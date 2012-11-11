<?php
session_start();
$date = time();
$myStartFile = 'sched/'.$_SESSION['email'].$date.".php";
$handle = fopen($myStartFile, 'w') or die('Cannont open file: '.$myStartFile);

	$data = "<?php\nrequire_once('../AWSSDKforPHP/rs-api-creds.php');\n\$ch = curl_init('".$_SESSION['login_url']."');\ncurl_setopt(\$ch, CURLOPT_COOKIEJAR, '../".$_SESSION['cookie_file']."');\n";
	$data.="curl_setopt(\$ch, CURLOPT_USERPWD, '".$_SESSION['email'].":".$_SESSION['password']."');\n";
	$data.="curl_exec(\$ch);\n";
	$data.="curl_close(\$ch);\n";
	fwrite($handle, $data);
	$handle = fopen($myStartFile, 'a');
	foreach($_GET['serverid'] as $server ){
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
$myStartCron = '/etc/cron.d/rsportal';
$handle = fopen($myStartCron, 'a') or die('Cannont open file: '.$myStartCron);
$data = "0 ".$_GET['startTime']." * * * 1-5 wget http://rsportal.dev.sifworks.com/".$myStartFile."\n";
fwrite($handle, $data);
//------THIS IS WHER THE STOP CODE GOES
sleep(1);
$date = time();
$myStopFile = 'sched/'.$_SESSION['email'].$date.".php";
$handle = fopen($myStopFile, 'w') or die('Cannont open file: '.$myStopFile);

	$data = "<?php\nrequire_once('../AWSSDKforPHP/rs-api-creds.php');\n\$ch = curl_init('".$_SESSION['login_url']."');\ncurl_setopt(\$ch, CURLOPT_COOKIEJAR, '../".$_SESSION['cookie_file']."');\n";
	$data.="curl_setopt(\$ch, CURLOPT_USERPWD, '".$_SESSION['email'].":".$_SESSION['password']."');\n";
	$data.="curl_exec(\$ch);\n";
	$data.="curl_close(\$ch);\n";
	fwrite($handle, $data);
	$handle = fopen($myStopFile, 'a');
	foreach($_GET['serverid'] as $server ){
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
$myStopCron = '/etc/cron.d/rsportal';
$handle = fopen($myStopCron, 'a') or die('Cannont open file: '.$myStopCron);
$data = "0 ".$_GET['stopTime']." * * * 1-5 wget http://rsportal.dev.sifworks.com/".$myStopFile."\n";
fwrite($handle, $data);
//--- Check for files
if(file_exists($myStopFile) && file_exists($myStartFile)){
	echo "Your server(s) were successfully Scheduled.";
	header('refresh: 5;url=schedule.php');
}else{
	echo "Something went wrong. Please contact <a href='eric.adams@pearson.com'>Eric Adams</a> with time and date of error.";
}

	
?>


