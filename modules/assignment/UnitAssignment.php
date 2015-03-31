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
     *
     */
    var $content;
    var $attachment;
    var $dueday;
    var $duration;
    var $class;
    var $receiver;
    var $teacher;

    function __construct($id, $type, $content, $attachment, $dueday, $duration, $class, $receiver, $teacher){
        $this->id = $id;
        $this->type = $type;
        $this->content = $content;
        $this->attachment = $attachment;
        $this->dueday = $dueday;
        $this->duration = $duration;

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

        $this->receiver = $receiver;
        $this->teacher = $teacher;
    }
}

?>