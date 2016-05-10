<?php
/**
 * Author: Pelinium
 * Date: 2015/10/25
 */

class StatisticsClass {

	function __construct(){
		// Do nothing
	}

	function printActiveUsers($title, $minusDay){
		global $conn;

		echo "<div>$title</div>";

		$tableHTML = "<table border = '1' style='margin: 0 auto'><tr><td>Name</td><td>Occurrence</td></tr>";

		$sql = "SELECT uid, COUNT(*) AS count FROM OperationLog WHERE time > DATE_ADD(CURDATE(), INTERVAL -$minusDay DAY)  GROUP BY uid ORDER BY count DESC";
		$users = $conn->query($sql);

		while ($i = $users->fetch_assoc()){
			$userName = $this->getUserNameInChineseAndEnglishByUID($i['uid']);
			$occurrence = $i['count'];
			$tableHTML = $tableHTML."<tr><td>$userName</td><td>$occurrence</td></tr>";
		}

		echo $tableHTML.'</table>';
	}

	function loadActiveUsers(){
		global $conn;

		echo "<meta charset='utf-8'>";

		echo "<div style='text-align: center'>";

		$this->printActiveUsers("All active users", 10000);
		$this->printActiveUsers("Active User in a month", 30);
		$this->printActiveUsers("Active User in a week", 7);
		$this->printActiveUsers("Active User in a day", 1);
		echo "</div>";
	}

	function getUserNameInChineseAndEnglishByUID($uid){
		global $conn;

		$sql = "SELECT * FROM userInfo WHERE uid = '$uid'";
		$users = $conn->query($sql);
		while ($row = $users->fetch_assoc()){
			$info = new UserInfo();
			$info->constructByDBRow($row);
			$cName = $info->ChineseName;
			$eName = $info->EnglishName;
			$name = "$cName($eName)";
			return $name;
		}
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
