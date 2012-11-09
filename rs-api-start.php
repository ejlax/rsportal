<?php
session_start();
$date = time();
$myFile = '/sched/'.$_SESSION['email'].$date.".php";
$handle = fopen($myFile, 'w') or die('Cannont open file: '.$myFile);

/*$ch = curl_init($_SESSION['login_url']);
	curl_setopt($ch, CURLOPT_COOKIEJAR, '../'.$_SESSION['cookie_file']);
	curl_setopt($ch, CURLOPT_USERPWD,$_SESSION['email'].':'.$_SESSION['password']);

	curl_exec($ch);
	curl_close($ch);
	//var_dump($_SESSION);*/
	
	$serv = array(
		0 => '420241001',
		1 => '569036001'
		);
	//print_r($serv);	
	$data = "<?php\nrequire_once('../AWSSDKforPHP/rs-api-creds.php');\n\$ch = curl_init('".$_SESSION['login_url']."');\ncurl_setopt(\$ch, CURLOPT_COOKIEJAR, '../".$_SESSION['cookie_file']."');\n";
	$data.="curl_setopt(\$ch, CURLOPT_USERPWD, '".$_SESSION['email'].":".$_SESSION['password']."');\n";
	$data.="curl_exec(\$ch);\n";
	$data.="curl_close(\$ch);\n";
	fwrite($handle, $data);
	$handle = fopen($myFile, 'a');
	foreach($_GET['serverid'] as $server ){
		$data = "\$url = '".$_SESSION['url']."/servers/".$server."/".$_GET['type']."_ebs';\n";
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
$myCron = '/etc/cron.d/rsportal';
$handle = fopen($myCron, 'w') or die('Cannont open file: '.$myCron);
$data = "0 7 * * * 1-5 wget http://rsportal.dev.sifworks.com/".$myFile	
?>


