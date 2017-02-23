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
    var $publisher;
    var $pname;
    var $information;
    var $photo;
    var $attachment;
    var $publish;

    function construct($id, $cid, $publisher, $information, $photo, $attachment, $publish){
        global $conn;

        $this->id = $id;
        $this->cid = $cid;
        $this->publisher = $publisher;
        $this->information = $information;
        $this->photo = $photo;
        $this->attachment = $attachment;
        $this->publish = $publish;

        $sql = "SELECT * FROM club WHERE id = '$cid'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $this->cname = $row['name'];

        $sql = "SELECT * FROM userinfo WHERE uid = '$publisher'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $this->pname = $row['ChineseName'];
    }
}