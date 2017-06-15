<?php
session_start();
// Set Session data to an empty array
$_SESSION = array();
// Expire their cookie files
if(isset($_COOKIE["username"]) && isset($_COOKIE["user_token"])) {
    setcookie("username", '', strtotime( '-5 days' ), '/');
	setcookie("user_token", '', strtotime( '-5 days' ), '/');
}
// Destroy the session variables
session_destroy();

header("location: http://localhost/LoFo/LoFo/");
	exit();
?>