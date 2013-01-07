<?php
ob_start();
include_once('connect.php');
//echo $_GET['serverid'];
$server = $_GET['serverid'];
$sql = "SELECT createFile,stopFile from schedule where server = '$server'";
			//echo $sql."<br>";
			$result=mysql_query($sql,$link);
			$sched=mysql_fetch_array($result);
			//echo $sched['createFile']."<br>";
			//echo $sched['stopFile']."<br>";
			unlink($sched['createFile']);
			unlink($sched['stopFile']);
$sql = "SELECT count(id) from schedule where server = '$server'";
$result = mysql_query($sql,$link);
list($count_old) = mysql_fetch_array($result);
//echo $count_old;
$sql = "DELETE from schedule where server = '$server'";
//echo $sql;
mysql_query($sql,$link);

$sql = "SELECT count(id) from schedule where server = '$server'";
$result = mysql_query($sql,$link);
list($count_new) = mysql_fetch_array($result);
if($count_new<1){
	echo "Server was successfully deleted. This page will refresh in 5 seconds.";
	header('refresh: 5;url=schedule.php');
}else{
	echo "Server was not removed successfully. Please email Eric.Adams@pearson.com to have remove the server manually.";
}
ob_flush();
?>