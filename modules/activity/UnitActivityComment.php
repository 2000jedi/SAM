<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/11/15
 * Time: 20:25
 */

class UnitActivityComment {

    var $id;
    var $aid;
    var $uid;
    var $time;
    var $comment;

    function __construct(){}

    function construct($id, $aid, $uid, $time, $comment){
        $this->id = $id;
        $this->aid = $aid;
        $this->uid = $uid;
        $this->time = $time;
        $this->comment = $comment;
    }

    function constructFromDBRow($row){
        $this->construct($row["id"], $row["aid"], $row["uid"], $row["time"], $row["comment"]);
    }
}