<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 7/13/16
 * Time: 2:21 PM
 */

class ManipulatePresentationClass {

    /*
     *
     * Part I: Add a presentation
     * This part is used to add a new presentation into the database.
     *
     *
     *
     */
    function addPresentation(){
        global $conn;

        $result = checkForceQuit();

        $teacher = $result->username;

        if ($teacher != "t001"){
            die("Permission Denied!");
        }else{
            $name = $_POST["name"];
            $attachment = processAttachment();

            $sql = "INSERT INTO presentation (name, attachment) VALUES ('$name', '$attachment')";
            $conn->query($sql);

            echo "Success";
        }
    }

    var $presentation;

    function setPresentation($pID){
        $this->presentation = $pID;
    }

    function removePresentation(){
        global $conn;

        $result = checkForceQuit();

        $teacher = $result->username;

        if ($teacher != "t001"){
            die("Permission Denied!");
        }else{
            $sql = "DELETE FROM presentation WHERE id = '$this->presentation'";
            $conn->query($sql);

            echo "Success";
        }

    }

    function loadPresentations(){
        global $conn;

        $sql = "SELECT * FROM presentation";
        $result = $conn->query($sql);

        $arr = array();
        $counter = 0;

        while($row = $result->fetch_assoc()) {
            $presentationObj = new UnitPresentation($row);
            $arr[$counter] = $presentationObj;

            $counter++;
        }

        echo json_encode($arr);
    }
}

?>