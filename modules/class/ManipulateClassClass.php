<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/9/15
 * Time: 23:26
 */

class ManipulateClassClass {

    var $class;

    function __construct($class){
        $this->class = $class;
    }

    /*
     *
     * Part I: Deal with a specific class
     * This part is used to process a specific class.
     *
     * loadClassMember() loads the basic info of the class members
     *
     * deleteClass() deletes the class, completely wiping it from database
     *
     * changeClassMembers($studentList) changes the students enrolled in a class
     * $studentList is a string of the form ';s20148123;s20148124;s20148125'
     *
     */
    function loadClassMembers(){
        global $conn;
        $sql = "SELECT * from student WHERE class LIKE '%;$this->class;%' OR class LIKE '%;$this->class' ORDER BY id ASC";
        $result = $conn->query($sql);

        $studentArr = array();
        $counter = 0;

        while($row = $result->fetch_assoc()) {
            $id = $row['id'];

            $sql1 = "SELECT * FROM userInfo WHERE uid = '$id'";

            $result1 = $conn->query($sql1);

            while($row1 = $result1->fetch_assoc()) {
                $userInfo = new UserInfo();
                $userInfo->constructByDBRow($row1);
                $studentArr[$counter] = $userInfo;
            }
            $counter++;
        }

        return $studentArr;
    }

    function deleteClass(){
        global $conn;

        $sql0 = "SELECT * FROM assignment WHERE class = '$this->class'";
        $result = $conn->query($sql0);

        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $sql4 = "DELETE FROM personalassignment WHERE assignment = '$id'";
            $conn->query($sql4);
        }

        $sql = "DELETE FROM assignment WHERE class = '$this->class'";
        $conn->query($sql);


        $sql = "SELECT * from student WHERE class LIKE '%;$this->class%'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $classIDs = explode(";", $row['class']);
            $newStr = "";

            for ($i = 1; $i < count($classIDs); $i++) {
                $classID = $classIDs[$i];
                if ($classID != $this->class){
                    $newStr = $newStr.";".$classID;
                }
            }

            $sql2 = "UPDATE student SET class = '$newStr' WHERE id = $id";
            $conn->query($sql2);

        }

        $sql3 = "DELETE FROM class WHERE id = '$this->class'";
        $conn->query($sql3);

        echo "The class is removed from the server.";
    }


    function addToClassFunction($student){
        global $conn;

        $sql0 = "SELECT * FROM class WHERE id = '$this->class'";
        $result = $conn->query($sql0);
        if ($result->num_rows == 0){
            return "There is no class which id == ".$this->class;
        }else{
            $sql1 = "SELECT * FROM student WHERE id = '$student'";
            $result1 = $conn->query($sql1);


            while($row = $result1->fetch_assoc()) {
                $classes = $row['class'];

                $classIDs = explode(";", $row['class']);

                if (count($classIDs) > 1) {
                    for ($i = 1; $i < count($classIDs); $i++) {
                        $classID = $classIDs[$i];
                        if ($classID == $this->class) {
                            return "$student is already in the class $this->class";
                        }
                    }
                }
                $newClass = $classes . ";" . $this->class;
                $sql2 = "UPDATE student SET class = '$newClass' WHERE id = $student";
                if ($conn->query($sql2) === TRUE) {
                    return "Success! $student is now in class $this->class";
                } else {
                    return "Unexpected error.";
                }
            }
        }

    }

    function quitClassFunction($student){
        global $conn;

        $sql1 = "SELECT * FROM student WHERE id = '$student'";
        $result1 = $conn->query($sql1);

        while($row = $result1->fetch_assoc()) {

            $classIDs = explode(";", $row['class']);

            $newClassList = "";

            if (count($classIDs) > 1) {
                for ($i = 1; $i < count($classIDs); $i++) {
                    $classID = $classIDs[$i];
                    if ($classID == $this->class) {
                        // Do nothing;
                    } else {
                        $newClassList .= ";" . $classID;
                    }
                }
            }
            $sql2 = "UPDATE student SET class = '$newClassList' WHERE id = '$student'";
            if ($conn->query($sql2) === TRUE) {
                return "Success! $student quits class $this->class";
            } else {
                return "Unexpected error.";
            }
        }
    }

    function isDisappearFromTheNewList($oldUsername, $studentList){
        $bool = true;

        for ($i = 0; $i < sizeof($studentList); $i++){
            $username = $studentList[$i];
            if ($oldUsername == $username){
                $bool = false;
            }
        }
        return $bool;
    }

    function changeClassMembers($studentList){
        $oldStudentList = $this->loadClassMembers();
        $studentList = explode(";",$studentList);


        for ($i = 1; $i < sizeof($studentList); $i++) {
            $student = $studentList[$i];
            $student = userVariableConversion($student, "username", "uid");

            $resultOfExec = $this->addToClassFunction($student)."\n";
            echo $resultOfExec;
        }

        for ($i = 0; $i < sizeof($oldStudentList); $i++){
            $oldUsername = $oldStudentList[$i]->username;
            if ($this->isDisappearFromTheNewList($oldUsername, $studentList)){
                $resultOfExec = $this->quitClassFunction( userVariableConversion($oldUsername, "username", "uid"))."\n";
                echo $resultOfExec;
            }
        }
    }
    // Part I ends



    /*
     *
     * Part II: Load Class
     * This part is used to load classes for students or teachers.
     *
     * loadClass() automatically determines the type of the user, and load the class according to the identity of the user.
     *
     */
    function loadClass(){
        global $conn;

        $result = checkForceQuit();

        $user = $result->uid;
        $userType = substr($_COOKIE['username'], 0, 1);

        $sql = "SELECT * from class WHERE teacher='$user'";
        if ($_COOKIE['username'] == "t001" && isset($_GET['inAdmin'])){
            $sql = "SELECT * from class";
        }
        if ($userType == "s"){
            $sql = "SELECT * from student WHERE id='$user'";
        }
        $result = $conn->query($sql);

        $arr = array();
        $counter = 0;

        while($row = $result->fetch_assoc()) {
            if ($userType == "t") {
                $id = $row['id'];
                $teacher = $row['teacher'];
                $name = $row['name'];

                $subject = "Unknown";

                $sql3 = "SELECT * FROM teacher WHERE id = '$teacher'";
                $result3 = $conn->query($sql3);
                if ($result3->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result3)) {
                        $subject = $row["subject"];
                    }
                }

                $unitClass = new UnitClass($id, $teacher, $name, $subject);
                $arr[$counter] = $unitClass;
                $counter++;
            }else{
                $classIDs = explode(";",$row['class']);
                if (count($classIDs) > 1){
                    $sql2 = "SELECT * from class WHERE id = '$classIDs[1]'";
                    for ($i = 2; $i < sizeof($classIDs); $i++){
                        $sql2 = $sql2." OR id = '$classIDs[$i]'";
                    }
                    $result2 = $conn->query($sql2);
                    while($row2 = $result2->fetch_assoc()) {
                        $id = $row2['id'];
                        $teacher = $row2['teacher'];
                        $name = $row2['name'];

                        $subject = "Unknown";

                        $sql3 = "SELECT * FROM teacher WHERE id = '$teacher'";
                        $result3 = $conn->query($sql3);
                        if ($result3->num_rows > 0) {
                            while($row = mysqli_fetch_assoc($result3)) {
                                $subject = $row["subject"];
                            }
                        }

                        $unitClass = new UnitClass($id, $teacher, $name, $subject);
                        $arr[$counter] = $unitClass;
                        $counter++;
                    }
                }
            }
        }

        echo json_encode($arr);
    }
    // Part II ends



    /*
     *
     * Part III: Create Class
     * This part is used to create a new class
     *
     * createClass($name, $teacher) creates a class of $teacher with name $name,
     * where $name is the name of the class, and $teacher is the uid of the teacher
     *
     */
    function createClass($name, $teacher){
        global $conn;

        $sql = "INSERT INTO class (teacher, name) VALUES ('$teacher', '$name')";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    // Part III ends
}