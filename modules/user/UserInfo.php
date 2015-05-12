<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 5/12/15
 * Time: 20:50
 */

class UserInfo {
    var $uid;
    var $username;
    var $ChineseName;
    var $EnglishName;

    function __construct(){}

    function constructByDBRow($row){
        $this->uid = $row['uid'];
        $this->username = $row['username'];
        $this->ChineseName = $row['ChineseName'];
        $this->EnglishName = $row['EnglishName'];
    }
}

?>