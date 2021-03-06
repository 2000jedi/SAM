<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 2/12/16
 * Time: 6:31 PM
 */

class College {
    var $id;
    var $name;
    var $description;
    var $EDEAChoice;
    var $RDRAChoice;

    function __construct(){
        // Do nothing
    }

    function constructByID($id){
        global $conn;

        $sql = "SELECT * FROM college WHERE id = '$id'";
        $result = $conn->query($sql);

        $this->id = $id;

        while($row = $result->fetch_assoc()) {
            $this->constructByRow($row);
        }
    }

    function constructByRow($row){
        $this->id = $row["id"];
        $this->name = $row["name"];
        $this->description = $row["description"];
        $this->EDEAChoice = $row["EDEAChoice"];
        $this->RDRAChoice = $row["RDRAChoice"];
    }

    function inList($item, $listStr){
        $list = explode(";", $listStr);

        $bool = false;
        for ($i = 1; $i < count($list) ; $i++){
            if ($list[$i] == $item){
                $bool = true;
            }
        }

        return $bool;
    }

    function convertListNameToList($listName){
        $list = $this->RDRAChoice;
        if ($listName == "EDEAChoice"){
            $list = $this->EDEAChoice;
        }
        return $list;
    }

    function updateListFromNameAndValue($listName, $value){
        if ($listName == "EDEAChoice") {
            $this->EDEAChoice = $value;
        }else{
            $this->RDRAChoice = $value;
        }
    }

    function addToList($list, $student){
        global $conn;

        $listStr = $this->convertListNameToList($list);

        if ( $this->inList($student, $this->EDEAChoice) || $this->inList($student, $this->RDRAChoice) ) {
            return "the student is already in this college";
        }

        $listStr .= ";" . $student;

        $this->updateListFromNameAndValue($list, $listStr);

        $sql1 = "UPDATE college SET $list = '$listStr' WHERE id = '$this->id'";
        if ($conn->query($sql1) === TRUE){
            return "Success!";
        }else{
            return "Unexpected error.";
        }
    }

    function removeFromList($list, $student){
        global $conn;

        $listStr = $this->convertListNameToList($list);
        $listIDs = explode(";", $listStr);
        $listStr = "";

        if (count($listIDs) > 0){
            for ($i = 1; $i < count($listIDs); $i++){
                if ($listIDs[$i] != $student){
                    $listStr .= ";" . $listIDs[$i];
                }
            }
        }

        $this->updateListFromNameAndValue($list, $listStr);

        $sql1 = "UPDATE college SET $list = '$listStr' WHERE id = '$this->id'";
        if ($conn->query($sql1) === TRUE){
            return "Success!";
        }else{
            return "Unexpected error.";
        }
    }

    function findBetterCompetitorNumber($list, $student){
        $listStr = $this->convertListNameToList($list);
        $listIDs = explode(";", $listStr);

        $std = new Student($student);
        $stdScore = $std->calculateScore();

        $counter = 0;
        if (count($listIDs) > 0){
            for ($i = 1; $i < count($listIDs); $i++){
                $inListStudent = $listIDs[$i];
                if ($inListStudent == $student){
                    // Do nothing.
                }else{
                    $inListStd = new Student($inListStudent);
                    $inListStdScore = $inListStd->calculateScore();

                    if ($inListStdScore >= $stdScore){
                        $counter++;
                    }
                }
            }
        }

        return $counter;
    }

    // Ensure that the number is the number of competitors in the same grade.
    function filterChoiceList($choiceString, $student){
        global $conn;

        $explodedList = explode(";",$choiceString);

        $newString = "";

        $studentGrade = "";

        $sql = "SELECT * FROM user WHERE uid = '$student'";

        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $studentID = $row["username"];
            $studentGrade = substr($studentID, 0, 5);
        }

        for ($i = 1; $i < count($explodedList); $i++) {
            $uid = $explodedList[$i];
            $sql1 = "SELECT * FROM user WHERE uid = '$uid'";
            $result = $conn->query($sql1);

            while($row = $result->fetch_assoc()) {
                $usnm = $row["username"];
                $grade = substr($usnm, 0, 5);
                if ($grade == $studentGrade) {
                    $newString .= ";" . $uid;
                }
            }
        }
        return $newString;
    }

    function convertIntoUnitCollege($student){

        $this->EDEAChoice = $this->filterChoiceList($this->EDEAChoice, $student);
        $this->RDRAChoice = $this->filterChoiceList($this->RDRAChoice, $student);

        $numberOfEDEACompetitor = $this->findBetterCompetitorNumber("EDEAChoice", $student);
        $numberOfRDRACompetitor = $this->findBetterCompetitorNumber("RDRAChoice", $student);
        $totalNumberOfEDEAChoice = count(explode(";", $this->EDEAChoice)) - 1;
        $totalNumberOfRDRAChoice = count(explode(";", $this->RDRAChoice)) - 1;

        $studentStatus = "N/A";
        if ($this->inList($student, $this->EDEAChoice)){
            $studentStatus = "EDEA";
        }
        if ($this->inList($student, $this->RDRAChoice)){
            $studentStatus = "RDRA";
        }
        $uCollege = new UnitCollege($this->id, $this->name, $this->description, $studentStatus, $totalNumberOfEDEAChoice, $totalNumberOfRDRAChoice, $numberOfEDEACompetitor, $numberOfRDRACompetitor);

        return $uCollege;
    }
}