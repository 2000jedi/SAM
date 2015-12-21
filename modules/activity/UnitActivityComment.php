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

    function construct($id, $username, $time, $comment, $attachment){
        $this->id = $id;
        $this->username = $username;
        $this->time = $time;
        $this->comment = $comment;
        $this->attachment = $attachment;
    }

    function constructFromDBRow($row){
        $uid = $row["uid"];
        $username = userVariableConversion($uid, "uid", "username");
        $this->construct($row["id"], $username, $row["time"], $row["comment"], $row["attachment"]);
    }
}