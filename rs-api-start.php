<?php
include_once('connect.php');
session_start();
if(isset($_GET['serverid'])){
//dprint_r($_GET);/*
//print_r($_GET['day']);

	//echo $_GET['startTime']." * *  ".$day;
$user = $_GET['user'];
$startTime = $_GET['startTime'];
$stopTime = $_GET['stopTime'];
//$server = $_GET['serverid'];
$date = time();
$myStartFile = "sched/".$user."-".$date.".php";
sleep(1);
$date = time();
$myStopFile = 'sched/'.$user."-".$date.".php";
//$sql = "INSERT INTO schedule(user,server,startTime,endTime,createFile) VALUES('$user','$server','$startTime','$stopTime','$myStartFile')";
//mysql_query($sql,$link);
foreach($_GET['serverid'] as $server ){
		$sql = "SELECT count(id) from schedule where server = '$server'";
		$result=mysql_query($sql,$link);
		list($count)=mysql_fetch_array($result);
		//echo $count;
		//echo $sql;
		if ($count>0){
			$sql = "SELECT distinct startTime,endTime from schedule where server = '$server'";
			//echo $sql."<br>";
			$result=mysql_query($sql,$link);
			$sched=mysql_fetch_array($result);
			//print_r($sched);
			//echo $sched['startTime']."<br>";
			//echo $sched['endTime']."<br>";
			echo "<h4>The server with the ID ".$server." has already been scheduled. Do you want to <a href='delete.php?serverid=".$server."'>delete</a> that server schedule?</44><br>";
			echo "<h4>The server is currently scheduled to start at ".$sched['startTime'].":00 and shutdown at ".$sched['endTime'].":00.</h4><br>";
		}else{
		$sql = "INSERT INTO schedule(user,server,startTime,endTime,createFile,stopFile) VALUES('$user','$server','$startTime','$stopTime','$myStartFile','$myStopFile')";
		mysql_query($sql,$link);
$handle = fopen($myStartFile, 'w') or die('Cannont open file: '.$myStartFile);
	$data = "<?php\nrequire_once('../AWSSDKforPHP/rs-api-creds.php');\n\$ch = curl_init('".$_SESSION['login_url']."');\ncurl_setopt(\$ch, CURLOPT_COOKIEJAR, '../".$_SESSION['cookie_file']."');\n";
	$data.="curl_setopt(\$ch, CURLOPT_USERPWD, '".$_SESSION['email'].":".$_SESSION['password']."');\n";
	$data.="curl_exec(\$ch);\n";
	$data.="curl_close(\$ch);\n";
	fwrite($handle, $data);
	$handle = fopen($myStartFile, 'a');
	foreach($_GET['serverid'] as $server ){
		//$sql = "SELECT user,server,startTime,endTime from schedule where server = '$server'";
		//$result=mysql_query($query,$link);
		//list($count)=mysql_fetch_array($result);
		//echo $count."<br>";
		//if ($count<1){
			//echo "That server already has a schedule. Do you want to <a href='reschedule.php'>reschedule</a> that server?";
		//}else{
		$data = "\$url = '".$_SESSION['url']."/servers/".$server."/start_ebs';\n";
		$data.="\$header = 'X-API-VERSION: 1.0';\n";
		$data.="\$ch = curl_init(\$url);\n";
		$data.="curl_setopt(\$ch, CURLOPT_COOKIEFILE, '../".$_SESSION['cookie_file']."');\n";
		$data.="curl_setopt(\$ch, CURLOPT_HTTPHEADER, \$header);\n";
		$data.="curl_setopt(\$ch, CURLOPT_POST, 1);\n";
		$data.="curl_setopt(\$ch, CURLOPT_POSTFIELDS,'api_version=1.0');\n";
		$data.="curl_exec(\$ch);\n";
		$data.="curl_close(\$ch);\n";

fwrite($handle, $data);
	}
	
//$myStartCron = 'sched/cron.txt';
//$handle = fopen($myStartCron, 'a') or die('Cannont open file: '.$myStartCron);
//$data = "echo -e '`crontab -l\n0 ".$_GET['startTime']." * * * '.$_GET['day[0]'].' wget http://rsportal.dev.sifworks.com/".$myStartFile." | crontab -'";
//foreach($_GET['day'] as $day){
exec('echo -e "`crontab -l`\n0 '.$_GET['startTime'].' * * 1-5 wget http://rsportal.dev.sifworks.com/'.$myStartFile.'" | crontab -'); 
//$query = 
//$sql="INSERT INTO sched(user,server,startTime,endTime,createFile) VALUES('$_GET['user']','$server','$_GET['startTime']','$_GET['stopTime']','$myStartFile')";
				//mysql_query($sql,$link);
//};            
//fwrite($handle, $data);

//------THIS IS WHER THE STOP CODE GOES
$handle = fopen($myStopFile, 'w') or die('Cannont open file: '.$myStopFile);

	$data = "<?php\nrequire_once('../AWSSDKforPHP/rs-api-creds.php');\n\$ch = curl_init('".$_SESSION['login_url']."');\ncurl_setopt(\$ch, CURLOPT_COOKIEJAR, '../".$_SESSION['cookie_file']."');\n";
	$data.="curl_setopt(\$ch, CURLOPT_USERPWD, '".$_SESSION['email'].":".$_SESSION['password']."');\n";
	$data.="curl_exec(\$ch);\n";
	$data.="curl_close(\$ch);\n";
	fwrite($handle, $data);
	$handle = fopen($myStopFile, 'a');
	foreach($_GET['serverid'] as $server ){
		//$sql = "INSERT INTO schedule(user,server,startTime,endTime,stopFile) VALUES('$user','$server','$startTime','$stopTime','$myStopFile')";
		//mysql_query($sql,$link);
		$data = "\$url = '".$_SESSION['url']."/servers/".$server."/stop_ebs';\n";
		$data.="\$header = 'X-API-VERSION: 1.0';\n";
		$data.="\$ch = curl_init(\$url);\n";
		$data.="curl_setopt(\$ch, CURLOPT_COOKIEFILE, '../".$_SESSION['cookie_file']."');\n";
		$data.="curl_setopt(\$ch, CURLOPT_HTTPHEADER, \$header);\n";
		$data.="curl_setopt(\$ch, CURLOPT_POST, 1);\n";
		$data.="curl_setopt(\$ch, CURLOPT_POSTFIELDS,'api_version=1.0');\n";
		$data.="curl_exec(\$ch);\n";
		$data.="curl_close(\$ch);\n";

fwrite($handle, $data);
	}
//$myStopCron = 'sched/cron.txt';
//$handle = fopen($myStopCron, 'a') or die('Cannont open file: '.$myStopCron);
//$data = "0 ".$_GET['stopTime']." * * * 1-5 wget http://rsportal.dev.sifworks.com/".$myStopFile."\n";
exec('echo -e "`crontab -l`\n0 '.$_GET['stopTime'].' * * 1-5 wget http://rsportal.dev.sifworks.com/'.$myStopFile.'" | crontab -');
//fwrite($handle, $data);
//exec('sudo crontab sched/cron.txt', $output, $return);
//--- Check for files
if(file_exists($myStopFile) && file_exists($myStartFile)){
	echo "<h4>Your server(s) were successfully Scheduled.<h4>";
	//header('refresh: 5;url=schedule.php');
}
}
}
}else{
	echo "<h4>No servers were chosen. Please choose a server.<h4>";
}

?>