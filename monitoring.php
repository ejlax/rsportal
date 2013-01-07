<?php
session_start();
$ch = curl_init($_SESSION['login_url']);
		
curl_setopt($ch, CURLOPT_COOKIEJAR, $_SESSION['cookie_file']);
curl_setopt($ch, CURLOPT_USERPWD,$_SESSION['email'].':'.$_SESSION['password']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
if ($output == 'Permission denied') {
	echo "<br>Please <a href='index.php'>login</a> again.";
}

/*$url = $_SESSION['url']."/servers?api_version=".$_SESSION['version'];

$ch = curl_init($url);
$postfields = "size=large&period=now&tz=America%2FDenver&myOrig=&myDest=&imageField.x=5&imageField.y=5";
curl_setopt($ch, CURLOPT_COOKIEFILE, $_SESSION['cookie_file']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,'api_version=1.0');
//curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_exec($ch);
curl_close($ch);

//print_r($xml);
$i=0;
//$servers = $xml->server->children();

//print_r($xml['server']);
echo "
	<form class='form' method='get' action='rs-api-start.php' id='schedule'>
	<select size=10 multiple='meultiple' name='serverid[]'>";
foreach($xml->server as $server){
	$i++;
	$nickname = (string) $server->nickname;
	$url = (string) $server->href;
	$depl = (string) $server->deployment-href;
	$servers = explode('servers/', $url);
	$serverid = $servers[1];
	echo "<option value='" .$serverid ."'>" .$nickname ."</option>";
		
}
echo "</select></br><input class='btn btn-primary' type='submit' value='Submit' name='submit'><img id='loading' style='display: none;' src='img/ajax-loader.gif'></br>";
*/
$url = $_SESSION['url']."/servers/575884001/monitoring?api_version=1.0";
//echo $url;
$ch = curl_init($url);
//$postfields = "size=large&period=now&tz=America%2FDenver&title=cpu-idle";
curl_setopt($ch, CURLOPT_COOKIEFILE, $_SESSION['cookie_file']);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,$postfields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$xml = curl_exec($ch);
curl_close($ch);
print_r($xml);
/*foreach($xml{'monitors'} as $monitor){
			
			$graphname = (string) $monitor->graph-name;
			$url = (string) $monitor->href;
			//$depl = (string) $server->deployment-href;
			//$servers = explode('servers/', $url);
			//$serverid = $servers[1];
			//echo "<option value='" .$serverid ."'>" .$nickname ."</option>";
			echo $url;
}*/


