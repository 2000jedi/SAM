<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/21/15
 * Time: 19:59
 */

class Security {
    var $uid;
    var $ip;

    function __construct( $uid ){
        $this->uid = $uid;
    }

    function updateIP($ip){
        global $conn;
        $sql = "SELECT * from IPDB WHERE uid = '$this->uid' AND ip = '$ip'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // IP already in the DB, do nothing.
        } else {
            $sql2 = "INSERT INTO IPDB (uid, ip) VALUES ('$this->uid', '$ip')";
            $conn->query($sql2);
        }
        $this->ip = $ip;
    }

    function getIPs(){
        global $conn;
        $sql = "SELECT * from IPDB WHERE uid = '$this->uid'";

        $arr = array();

        $result = $conn->query($sql);
        $counter = 0;
        if ($result->num_rows > 0) {
            // The device is not created for the first time
            while($row = mysqli_fetch_assoc($result)) {
                $ip = $row['ip'];
                $arr[$counter] = $ip;
                $counter++;
            }
        }

        return $arr;
    }

    function getIPsString(){
        $str = "";
        $arr = $this->getIps();
        for ($i = 0; $i < sizeof($arr); $i++){
            $str = $str.";".$arr[$i];
        }
        return $str;
    }
}