<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 21:39
 */

class UnitAssignment {
    var $id;
    var $type;
    /*
     *
     * Type 1 = Assignment
     * Type 2 = Notification
     * Type 3 = Club Post (Exist in UnitPost)
     *
     */
    var $content;
    var $attachment;
    var $publish;
    var $dueday;
    var $duration;
    var $class;
    var $subject;
    var $teacher;
    var $finished;

    function __construct(){}

    function construct($id, $type, $content, $attachment, $publish, $dueday, $duration, $class, $teacher, $finished){
        $this->id = $id;
        $this->type = $type;
        $this->content = $content;
        $this->attachment = $attachment;
        $this->publish = $publish;
        $this->dueday = $dueday;
        $this->duration = $duration;
        $this->teacher = $teacher;
        $this->finished = $finished;

        $sql = "SELECT * FROM class WHERE id = '$class'";
        global $conn;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $this->class = $row["name"];
            }
        } else {
            $this->class = "Unknown";
        }

        $sql2 = "SELECT * FROM teacher WHERE id = '$teacher'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result2)) {
                $this->subject = $row["subject"];
            }
        } else {
            $this->subject = "Unknown";
        }

    }

    function constructFromDBRow($rowFromDB, $class, $finished){

        $this->id = $rowFromDB['id'];
        $this->type = $rowFromDB['type'];
        $this->content = $rowFromDB['content'];
        $this->attachment = $rowFromDB['attachment'];
        $this->publish = $rowFromDB['publish'];
        $this->dueday = $rowFromDB['dueday'];
        $this->duration = $rowFromDB['duration'];
        $this->teacher = $rowFromDB['teacher'];


        $this->class = $class;
        $this->finished = $finished;

        $sql = "SELECT * FROM class WHERE id = '$class'";
        global $conn;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $this->class = $row["name"];
            }
        } else {
            $this->class = "Unknown";
        }

        $sql2 = "SELECT * FROM teacher WHERE id = '$this->teacher'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result2)) {
                $this->subject = $row["subject"];
            }
        } else {
            $this->class = "Unknown";
        }
    }
}

?>