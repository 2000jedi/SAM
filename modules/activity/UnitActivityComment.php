<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/11/15
 * Time: 20:25
 */

class UnitActivityComment {

    var $id;
    var $username;
    var $time;
    var $comment;
    var $attachment;

    function __construct(){}

    function construct($id, $uid, $time, $comment, $attachment){
        $this->id = $id;
        $this->username = $this->nameOfPerson($uid);
        $this->time = $time;
        $this->comment = $comment;
        $this->attachment = $attachment;
    }

    function constructFromDBRow($row){
        $this->construct($row["id"], $row["uid"], $row["time"], $row["comment"], $row["attachment"]);
    }

    function nameOfPerson($uid){
        global $conn;
        $sql = "SELECT * FROM userInfo WHERE uid = '$uid'";
        $result = $conn->query($sql);

        $name = "";

        while($row = $result->fetch_assoc()) {
            $ChineseName = $row["ChineseName"];
            $EnglishName = $row["EnglishName"];
            $name = "$ChineseName ($EnglishName)";
        }

        return $name;
    }
}