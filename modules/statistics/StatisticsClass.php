<?php
/**
 * Author: Pelinium
 * Date: 2015/10/25
 */

class StatisticsClass {

	function __construct(){
		// Do nothing
	}

	function loadActiveUsers(){
		global $conn;

		$sql = "SELECT * FROM IPDB";
		$ips = $conn->query($sql);
		$sql = "SELECT * FROM user ORDER BY username ASC";
		$users = $conn->query($sql);
		//read from DB using uid,username and ip

		$ip = array();
		while ($i = $ips->fetch_assoc()){
			$ip[$i['uid']] = $i['ip'];
		}
		//enumerate ip and save to a list
		//$user = array();
		while ($i = $users->fetch_assoc()){
			//$user[$i['username']] = $ip[$i['uid']];
			if (array_key_exists($i['uid'],$ip) !== false){
				$userName = $i['username'];
				echo $userName."<br />";
			}
		}
		//enumerate username then print to the screen, find the ip according to the previous uid
	}

	function getIPs(){
		$tableHTML = "<table border = '1'><tr><td>Username</td><td>IP</td></tr>";
		global $conn;
		$sql = "SELECT * FROM IPDB";
		$ips = $conn->query($sql);
		$sql = "SELECT * FROM user ORDER BY user.username ASC";
		$users = $conn->query($sql);
		//read from DB using uid,username and ip

		$ip = array();
		while ($i = $ips->fetch_assoc()){
			$ip[$i['uid']] = $i['ip'];
		}
		//enumerate ip and save to a list
		//$user = array();
		while ($i = $users->fetch_assoc()){
			//$user[$i['username']] = $ip[$i['uid']];
			if (array_key_exists($i['uid'],$ip) !== false){
				$userName = $i['username'];
				$userIP = $ip[$i['uid']];
				$tableHTML = $tableHTML."<tr><td>$userName</td><td>$userIP</td></tr>";
			}
		}
		echo $tableHTML.'</table>';
		//enumerate username then print to the screen, find the ip according to the previous uid
    }
}
?>
