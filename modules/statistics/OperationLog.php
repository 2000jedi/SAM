<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 10/23/15
 * Time: 21:01
 */

class OperationLog {

    var $id;   // id of the log in database
    var $uid;  // user who performed the operation
    var $ip;
    var $time; // data type: long
    var $page;

    function __construct(){
        // DO nothing
    }

    function constructByInfo($id, $uid, $ip, $time, $page){
        $this->id = $id;
        $this->uid = $uid;
        $this->ip = $ip;
        $this->time = $time;
        $this->page = $page;
    }

    function constructByID($id){
        global $conn;
        $sql = "SELECT * FROM OperationLog WHERE id = '$id'";

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $this->uid = $row['uid'];
            $this->ip = $row['ip'];
            $this->time = $row['time'];
            $this->page = $row['page'];
        }
    }

    /*
     *
     * Called after initialize the class by constructByInfo, while $id is ignored in the method
     * It writes the info into the database
     *
     */
    function writeIntoDB(){
        global $conn;

        $sql = "INSERT INTO OperationLog (uid, ip, time, page) VALUES ('$this->uid', '$this->ip', now(), '$this->page')";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}