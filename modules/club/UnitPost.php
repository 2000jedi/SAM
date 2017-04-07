<?php

/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/23
 * Time: 23:21
 */
class UnitPost{
    var $id;
    var $cid;
    var $cname;
    var $title;
    var $publisher;
    var $pname;
    var $information;
    var $photo;
    var $attachment;
    var $publish;
    var $type = 3; // Information Type: Unit Post

    function construct($id, $cid, $publisher, $title, $information, $attachment, $publish){
        global $conn;

        $this->id = $id;
        $this->cid = $cid;
        $this->publisher = $publisher;
        $this->title = $title;
        $this->information = $information;
        $this->attachment = $attachment;
        $this->publish = $publish;

        $sql = "SELECT * FROM club WHERE id = '$cid'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $this->cname = $row['name'];

        $sql = "SELECT * FROM userInfo WHERE uid = '$publisher'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $ChineseName = $row["ChineseName"];
        $EnglishName = $row["EnglishName"];
        $this->pname = "$ChineseName ($EnglishName)";
    }
}