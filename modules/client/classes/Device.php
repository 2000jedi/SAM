<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 9/14/15
 * Time: 21:19
 */

class Device {
    var $uid;

    function __construct( $uid ){
        $this->uid = $uid;
    }

    function push($msg){
        global $conn;
        $sql = "SELECT * from device WHERE uid = '$this->uid'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // The device is not created for the first time
            while($row = mysqli_fetch_assoc($result)) {
                $token = $row['token'];
                $platform = $row['platform'];
                if ($platform == "iOS"){
                    $this->pushIOS($token, $msg);
                }elseif ($platform == "Android"){
                    $this->pushAndroid($token, $msg);
                }
            }
        }
    }

    function updateToken($platform, $newToken){
        global $conn;
        $sql = "SELECT * from device WHERE uid = '$this->uid' AND platform = '$platform'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // The device is not created for the first time
            while($row = mysqli_fetch_assoc($result)) {
                $sql2 = "UPDATE device SET token = '$newToken' WHERE uid = '$this->uid' AND platform = '$platform'";
                $conn->query($sql2);
            }
        } else {
            $sql2 = "INSERT INTO device (uid, token, platform) VALUES ('$this->uid', '$newToken', '$platform')";
            $conn->query($sql2);
        }
        $this->token = $newToken;
    }

    function pushIOS($token, $msg){
        // echo "hahaha! Pushed to an iOS device.<br> msg = '$msg'";
    }

    function pushAndroid($token, $msg){
        global $mode;

        if ($mode == "SAE"){
            $appid = 22812;
            $title = '1';
            // title == version of client
            $acts = "[\"2,com.developersam.samclient,com.developersam.samclient.MainActivity\"]";
            // keep it constant for now
            $extra = array(
                'handle_by_app'=>'1'
            );

            $adpns = new SaeADPNS();
            $result = $adpns->push($appid, $token, $title, $msg, $acts, $extra);

            // echo "hahaha! Pushed to an Android device.<br> msg = '$msg'";
        }
    }
}