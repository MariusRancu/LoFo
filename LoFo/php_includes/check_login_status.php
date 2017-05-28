<?php
session_start();
include_once("db_con.php");
// Files that inculde this file at the very top would NOT require 
// connection to database or session_start(), be careful.
// Initialize some vars
$user_ok = false;
$log_username = "";

if(isset($_SESSION["username"]) && isset($_SESSION["password"])) {
	// Verify the user
	$user_ok = true;
	$log_username = $_SESSION["username"];
} else if(isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){
   
	// Verify the user
	$user_ok = true;
	
}
?>