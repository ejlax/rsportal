<?php
//include_once('verify.php');
require_once 'AWSSDKforPHP/sdk.class.php';
$ec2 = new AmazonEC2();
session_start();
if (!$_SESSION['cookie_file'] or !$_SESSION['email']){
	echo "User is not Authenticated.";
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>RightScale Scheduler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <!--<link rel="shortcut icon" href="../cd _portal/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../aws_portal/img/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../aws_portal/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../aws_portal/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../aws_portal/ico/apple-touch-icon-57-precomposed.png">  -->

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">RightScale Scheduler</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <!--  <li class="active"><a href="#"><i class="icon-home icon-black"></i>Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>  -->
            </ul>
            <ul class="nav pull-right">
            	<li class="dropdown">
            		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="icon-user"></b>Welcome,&nbsp;<?php echo $_SESSION['email'];?><b class="caret"></b></a>
              		<ul class="dropdown-menu">
						<li><a href='#'>Settings</a></li>  
		                <li><a href='#'>Profile</a></li>  
		                <li class='divider'></li>  
		                <li><a href='logout.php'>Logout</a></li>
              		</ul>
          		<li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      
        <div class='row-fluid span10'>
        <div class="span4 pull-left">
         	<div>
         	<h3>Start Server</h3>
			<?php
		
		$ch = curl_init($_SESSION['login_url']);
		
		curl_setopt($ch, CURLOPT_COOKIEJAR, $_SESSION['cookie_file']);
		curl_setopt($ch, CURLOPT_USERPWD,$_SESSION['email'].':'.$_SESSION['password']);
		
		curl_exec($ch);
		curl_close($ch);
		
		$url = $_SESSION['url']."/servers?api_version=".$_SESSION['version'];
		
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_COOKIEFILE, $_SESSION['cookie_file']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		
		
		$xml = new SimpleXMLElement( curl_exec($ch));
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
		echo "</select></br>
		<Label>Start Time</label>
		<select name='startTime'>
		<option value='2'>02:00</option>
		<option value='3'>03:00</option>
		<option value='4'>04:00</option>
		<option value='5'>05:00</option>
		<option value='6'>06:00</option>
		<option value='7'selected>07:00 --Default--</option>
		<option value='8'>08:00</option>
		<option value='9'>09:00</option>
		<option value='10'>10:00</option>
		<option value='11'>11:00</option>
		<option value='12'>12:00</option>
		<option value='13'>13:00</option>
		<option value='14'>14:00</option>
		<option value='15'>15:00</option>
		<option value='16'>16:00</option>
		<option value='17'>17:00</option>
		</select>
		<Label>Stop Time</label>
		<select name='stopTime'>
		<option value='9'>10:00</option>
		<option value='11'>11:00</option>
		<option value='12'>12:00</option>
		<option value='13'>13:00</option>
		<option value='14'>14:00</option>
		<option value='15'>15:00</option>
		<option value='16'>16:00</option>
		<option value='17'>17:00</option>
		<option value='18'>18:00</option>
		<option value='19' selected>19:00 --Default--</option>
		<option value='20'>20:00</option>
		<option value='21'>21:00</option>
		<option value='22'>22:00</option>
		<option value='23'>23:00</option>
		</select></br>
		<input class='btn btn-primary' type='submit' value='Submit' name='submit'><img id='loading' style='display: none;' src='img/ajax-loader.gif'></br>
		<h6> The default schedule is 7:00 am - 7:00 pm, Monday - Friday.";
		  ?>         
		<div id='response'><h6></h6></div>
         	</div>
        </div>  	
		<!-- <div class="table offset 3" id="instances">  -->
		<div class='span6'>
			<div id="rightScale">
				<h3>Event Roll</h3>
		      <p><script type='text/javascript' charset='utf-8' src='http://scripts.hashemian.com/jss/feed.js?print=yes&numlinks=10&summarylen=50&seedate=yes&popwin=no&url=http:%2F%2Fmy.rightscale.com%2Facct%2F19654%2Fuser_notifications%2Ffeed.atom%3Ffeed_token%3Dfada3a148e2f4effb8e2868a134448e13e466964'>
				</script>
				</p>
		    </div>
		</div>	
		</div>

		</div>
      </div><!--/row-->

      <hr>

      <footer align='center'>
        <p>&copy; Company 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="bootstrap.js"></script>
    <script>$('#schedule').bind('submit', function() {
  $('#loading').show()
});
</script>
<script>
	$("#schedule").submit(function(){
		$("#loading").submit(function(){
    $(this).show();
}).ajaxStop(function(){
   $(this).hide();
});
    // Intercept the form submission
    var formdata = $(this).serialize(); // Serialize all form data

    // Post data to your PHP processing script
    $.get( "rs-api-start.php", formdata, function( data ) {
        // Act upon the data returned, setting it to #success <div>
        $("#response").html ( data );
    });

    return false; // Prevent the form from actually submitting
});
</script>
  </body>
</html>
