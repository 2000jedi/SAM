<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 4/12/16
 * Time: 6:45 PM
 */

class ManipulateSearchClass {

    var $keyword;

    function __construct($keyword){
        $this->keyword = $keyword;
    }

    function translateKeywordsStringWithSpaceIntoSQLSentence(){
        $resultSQL = "";

        $this->keyword = strtolower($this->keyword);

        $keyWordArray = explode(" ", $this->keyword);
        for ($i = 0; $i < count($keyWordArray); $i++){
            $singleKeyword = $keyWordArray[$i];

            $resultSQL .= " AND lower(content) LIKE '%$singleKeyword%'";
        }

        return $resultSQL;
    }

    function searchFromTeacherSide($teacher){
        global $conn;

        $sqlPartOfLIKE = $this->translateKeywordsStringWithSpaceIntoSQLSentence($this->keyword);
        $sql = "SELECT * FROM assignment WHERE teacher = '$teacher' $sqlPartOfLIKE";
        $result = $conn->query($sql);

        $arr = array();
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $unitAssignment = new UnitAssignment();
            $unitAssignment->constructFromDBRow($row, $row["class"], false);
            $arr[$counter] = $unitAssignment;
            $counter++;
        }

        return json_encode($arr);
    }

}