<?php
session_start();
include_once("db_con_pm.php");
// Files that inculde this file at the very top would NOT require 
// connection to database or session_start(), be careful.
// Initialize some vars

function evalLoggedUser($conx,$u,$p){
	$sql = "SELECT username FROM users WHERE username='$u' AND pass='$p'LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $numrows = mysqli_num_rows($query);

	if($numrows > 0){
		return true;
	}
}

$user_ok = false;
$log_username = "";
$user_role = "";
$log_user_id = "";

if(isset($_SESSION["username"]) && isset($_SESSION["password"])) {
	// Verify the user
	$log_username = $_SESSION["username"];
	$log_password = $_SESSION["password"];
	$user_ok = evalLoggedUser($db_con, $log_username, $log_password);
} else if(isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){
  	$log_username = $_COOKIE["user"];
	$log_password = $_COOKIE["pass"];
	$user_ok = evalLoggedUser($db_con, $log_username, $log_password);
	
}

if($user_ok == true){
	$sql = "SELECT user_id, role FROM users WHERE username='$log_username'";
    $query = mysqli_query($db_con, $sql);
    $row = mysqli_fetch_row($query);
	$log_user_id = $row[0];
	$user_role = $row[1];
}
?>