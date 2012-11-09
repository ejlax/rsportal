<?php
ob_start();
/**
* The logout file
* destroys the session
* expires the cookie
* redirects to login.php
*/
session_start();
//$_SESSION = array();

session_destroy();
header("location:index.php");

?>