<?php
ob_start();
//require_once('AWSSDKforPHP/rs-api-creds.php');
session_start();
$rs_api = array(
	'version' => '1.0',
	'account_id' => $_POST['account'],
	'username' => $_POST['email'],
	'password' => $_POST['password'],
	'cookie_file' => 'tmp/rs_api_cookie.txt'.$_POST['email'],
	//'cookie_file' => tempnam("/tmp", "rs_api"),
);

$_SESSION['email'] = $rs_api['username'];
$_SESSION['password'] = $rs_api['password'];
$_SESSION['cookie_file'] = $rs_api['cookie_file'];
$_SESSION['account'] = $rs_api['account_id'];
$_SESSION['version'] = $rs_api['version'];

$_SESSION['url'] = "https://my.rightscale.com/api/acct/".$_SESSION['account'];

$_SESSION['login_url'] = $_SESSION['url']."/login?api_version=".$_SESSION['version'];

$ch = curl_init($_SESSION['login_url']);

curl_setopt($ch, CURLOPT_COOKIEJAR, $_SESSION['cookie_file']);
curl_setopt($ch, CURLOPT_USERPWD,$_SESSION['email'].':'.$_SESSION['password']);

$output = curl_exec($ch);
//echo $output;
curl_close($ch);

if (!$output) {
	echo "User not authenticated.";
}else{
	header('location:schedule.php');
}
?>
