<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/9/15
 * Time: 22:46
 */

class ManipulateAssignmentClass {

    var $assignment;

    function __construct(){
        // Do nothing
    }

    /*
     *
     * Part I: Load Assignment
     * This part is used to load assignment for stream view or for class
     *
     * studentLoadAssignment($student) loads assignments for stream view,
     * where $student is the uid of the student
     *
     * classLoadAssignment($class) loads assignments for a class.
     * It can be both called while loading for students and for teachers
     * $class is the class id of the class requiring to load assignment
     *
     */
    function studentLoadAssignment($student){
        global $conn;

        $sql = "SELECT * from student WHERE id='$student'";
        $result = $conn->query($sql);

        $sqlForClass = "";

        while($row = $result->fetch_assoc()) {
            $classIDs = explode(";",$row['class']);

            if (count($classIDs)>1){
                $sqlForClass = "class = ".$classIDs[1]." ";
                for ($i = 2; $i < count($classIDs) ; $i++){
                    $classID = $classIDs[$i];
                    $sqlForClass = $sqlForClass."OR class = ".$classID." ";
                }
            }
        }

        $sqlForClass = "(".$sqlForClass.")";

        if ($sqlForClass == "()"){
            $sqlForClass = "1 = 0";
        }

        $sql = "SELECT * from assignment WHERE dueday > curdate() AND ( $sqlForClass OR class = '39' ) ORDER BY type ASC, dueday ASC";
        $result = $conn->query($sql);

        $arr = array();
        $counter = 0;

        // Exclude the finished assignments
        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $class = $row['class'];

            $finished = false;

            $sql2 = "SELECT * FROM personalassignment WHERE assignment = '$id' AND uid = '$student' AND actual >= 0";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                $finished = true;
            }

            if ($finished == true && $row['type'] == "2"){
                // Do nothing
            }else{
                $unitAssignment = new UnitAssignment();
                $unitAssignment->constructFromDBRow($row, $class, $finished);
                $arr[$counter] = $unitAssignment;
                $counter++;
            }

        }

        return json_encode($arr);
    }

    function classLoadAssignment($class){
        global $conn;

        $sql = "SELECT * FROM assignment WHERE class = '$class' AND dueday > (curdate() - 180) ORDER BY type ASC, dueday DESC";
        $result = $conn->query($sql);

        $arr = array();
        $counter = 0;

        while($row = $result->fetch_assoc()) {

            $unitAssignment = new UnitAssignment();
            $unitAssignment->constructFromDBRow($row, $class, false);
            $arr[$counter] = $unitAssignment;
            $counter++;
        }

        return json_encode($arr);
    }
    // Part I ends



    /*
     *
     * Part II: Deal with a specific assignment
     * This part is used to process a specific assignment
     *
     * setAssignment($assignment) sets up the common variable $assignment for in-class calling
     * All part II operation must be preceded by this function
     *
     * updateAssignment($content, $teacher) updates an assignment based on its new content already assigned by a teacher,
     * where $content is the new content, ans $teacher is the uid of the teacher
     *
     * deleteAssignment($teacher) deletes an assignment assigned by a teacher,
     * where $teacher is the uid of the teacher
     *
     * markCompletion($actual, $student) marks an assignment as completed,
     * where $actual is the time used (can be anything, which would be automatically processed by the function),
     * and $student is the uid of a student
     *
     * markUnCompletion($student) marks an assignment as uncompleted,
     * where $student is the uid of a student
     * (The function is NOT called by the client side, but do not delete!)
     *
     * loadPersonalScore($student) loads the score of an assignment of the student,
     * where $student is the uid of a student
     *
     * loadPersonalScores() lists all the personal scores of an assignment
     *
     * updatePersonalScore($student, $score) updates score of an assignment of a specific person
     * where $student is the uid of a student, and $score is the numerical value of score (in 100)
     *
     */
    function setAssignment($assignment){
        $this->assignment = $assignment;
    }

    function updateAssignment($content, $teacher){
        global $conn;

        $sql = "UPDATE assignment SET content = '$content' WHERE id = '$this->assignment' AND teacher = '$teacher'";

        if ($conn->query($sql) === TRUE) {
            echo "Success!";
        } else {
            echo "Unexpected error.";
        }
    }

    function deleteAssignment($teacher){
        global $conn;

        $sql = "DELETE FROM assignment WHERE id = '$this->assignment' AND teacher = '$teacher'";
        $sql2 = "DELETE FROM personalassignment WHERE assignment = '$this->assignment'";

        if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE ) {
            echo "Successfully deleted one assignment.";
        } else {
            echo "Unexpected Error";
        }
    }

    function personalAssignmentExist($student){
        global $conn;

        $sqlSearchExist = "SELECT * FROM personalassignment WHERE assignment = '$this->assignment' AND uid = '$student'";
        $result = $conn->query($sqlSearchExist);

        if ($result->num_rows > 0) {
            return true;
        }else{
            return false;
        }
    }

    function markCompletion($actual, $student){
        global $conn;

        if (is_numeric($actual)){
            $actual = floatval($actual);
            if ($actual > 0){
                // DO nothing.
            }else{
                $actual = 0;
            }
        }else{
            $actual = 0;
        }

        $exist = $this->personalAssignmentExist($student);

        $sql = "";
        if ($exist) {
            $sql = "UPDATE personalassignment SET actual = '$actual' WHERE assignment = '$this->assignment' AND uid = '$student'";
        }else{
            $sql = "INSERT INTO personalassignment (assignment, uid, actual) VALUES ($this->assignment, $student, $actual)";
        }


        if ($conn->query($sql) === TRUE) {
            echo "Thank you for cooperation!";
        } else {
            echo "Unexpected error.";
        }
    }

    function markUnCompletion($student){
        global $conn;

        $sql = "DELETE FROM personalassignment WHERE assignment = '$this->assignment' AND uid = $student";

        if ($conn->query($sql) === TRUE) {
            echo "Success!";
        } else {
            echo "Unexpected error.";
        }
    }

    function loadPersonalScore($student){
        global $conn;

        $sql = "SELECT * FROM personalassignment WHERE assignment = '$this->assignment' AND uid = '$student'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $score = $row['score'];
                return $score;
            }
            return "0";
        }else{
            return "0";
        }
    }

    function loadPersonalScores(){
        global $conn;

        $sqlFindClass = "SELECT * FROM assignment WHERE id = '$this->assignment'";
        $result = $conn->query($sqlFindClass);

        $class = '0';
        while($row = $result->fetch_assoc()) {
            $class = $row['class'];
        }

        $maniClass = new ManipulateClassClass($class);
        $members = $maniClass->loadClassMembers();

        $scoreArr = array();

        for ($i = 0; $i < sizeof($members); $i++){
            $studentUserInfo = $members[$i];
            $student = $studentUserInfo->uid;
            $username = $studentUserInfo->username;
            $chineseName = $studentUserInfo->ChineseName;
            $englishName = $studentUserInfo->EnglishName;

            $score = $this->loadPersonalScore($student);
            $scoreArr[$i*5] = $student;
            $scoreArr[$i*5+1] = $username;
            $scoreArr[$i*5+2] = $chineseName;
            $scoreArr[$i*5+3] = $englishName;
            $scoreArr[$i*5+4] = $score;
        }

        return $scoreArr;
    }

    function updatePersonalScore($student, $score){
        global $conn;

        $exist = $this->personalAssignmentExist($student);

        if ($exist) {
            $sqlAddRecord = "UPDATE personalassignment SET score = '$score' WHERE assignment = '$this->assignment' AND uid = '$student'";
        }else{
            $sqlAddRecord = "INSERT INTO personalassignment (assignment, uid, actual, score) VALUES ('$this->assignment', '$student', -1, '$score')";
        }
        if ($conn->query($sqlAddRecord) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    // Part II ends


    /*
     *
     * Part III: Add Assignment
     * This part is used to add a new assignment
     *
     */
    function addAssignment(){
        global $conn;

        $result = checkForceQuit();

        $teacher = $result->uid;


        $type = $_POST['type'];
        $dueday = "null";
        $duration = 0.0;
        $attachment = "null";
        if ($type == "1"){
            $duration = $_POST['duration'];
        }
        $dueday = $_POST['dueday'];
        if ($dueday == ""){
            $dueday = "2038-1-1";
        }
        $dueday = date("Y-m-d", strtotime($dueday));

        if ($_POST['hasAttachment'] == "true"){
            /*
            $target_dir = "/files/attachments/";

            $attachment = "";

            for ($i = 0; $i < count($_FILES["attachment"]['name']); $i++ ){
                $originalName = $_FILES["attachment"]['name'][$i];
                $realNameArr = explode(".",$originalName);
                $realName = "";
                for ($ii = 0; $ii < count($realNameArr)-1; $ii++){
                    $realName .= $realNameArr[$ii];
                }
                $fileType = pathinfo($originalName, PATHINFO_EXTENSION);
                $final_filename = $realName."_".time().".".$fileType;
                if ($mode == "local"){
                    $target_file = $_SERVER['DOCUMENT_ROOT'].$target_dir .$final_filename;

                    $attachment .= ";".$target_dir.$final_filename.";".$originalName;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"][$i], $target_file);
                }else if ($mode == "SAE"){
                    $fileContent=file_get_contents($_FILES["attachment"]["tmp_name"][$i]);
                    $temp=new SaeStorage();
                    $temp->write("wflmssam",$final_filename,$fileContent);
                    $url=$temp->getUrl($domain,$final_filename);

                    $attachment .= ";".$url.";".$originalName;
                }
            }
            */
            $attachment = processAttachment();

        }
        $content = $_POST['content'];
        $class = $_POST['class'];

        $sql2 = "INSERT INTO assignment (type, content, attachment, publish, dueday, duration, class, teacher) VALUES ($type, '$content', '$attachment', now(), '$dueday', $duration, '$class', '$teacher')";
        $conn->query($sql2);


        $sql3 = "SELECT * from student WHERE class LIKE '%;$class;%' OR class LIKE '%;$class' ORDER BY id ASC";
        $result = $conn->query($sql3);


        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $device = new Device($id);
            $device->push('[{"version": "1","title": "NEW!", "msg": "Your teacher assigned new homework."}]');
        }

        echo "Success";
    }
    // Part III ends


}