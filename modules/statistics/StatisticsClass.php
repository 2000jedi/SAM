<?php
/**
 * Author: Pelinium
 * Date: 2015/10/25
 */
require $_SERVER['DOCUMENT_ROOT']."/config.php";
require $_SERVER['DOCUMENT_ROOT']."/modules/statistics/OperationLog.php";

$conn = mysql_connect("localhost","root","");//please change them
if (!$conn){
	die('Could not connect: ' . mysql_error());
	}
	else{echo "Connected<br/>";
	}

	mysql_select_db("missile", $conn);
	$result = mysql_query("SELECT * FROM OperationLog WHERE time>='2015-10-24' and time<='2015-10-26'
	and uid='28'");//By changing the time period and uid, we can know the operations of a certain user at a certain day.
	while ($row = mysql_fetch_array($result))
  	{
  	echo $row['uid'] . " " .  $row['ip']. " ".$row['time'] . " ". $row['page'];
  	echo "<br />";
  	}
?>
