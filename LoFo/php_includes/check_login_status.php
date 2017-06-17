<?php
session_start();
include_once("db_con.php");
// Files that inculde this file at the very top would NOT require 
// connection to database or session_start(), be careful.
// Initialize some vars

function evalLoggedUser($conx, $username, $t){

	$sql = mysqli_prepare($conx, "SELECT 1 FROM users WHERE user_token=? AND username=? LIMIT 1");
	mysqli_stmt_bind_param($sql, "ss", $t, $username);
    mysqli_stmt_execute($sql);
    mysqli_stmt_store_result($sql);
    
    $numrows = mysqli_stmt_num_rows($sql);

	if($numrows > 0){
		$sql -> close();
		return true;
	}

	$sql -> close();
	return false;
}

$user_ok = false;
$log_username = "";
$user_role = "";
$log_user_id = "";

if(isset($_SESSION["user_token"]) && isset($_SESSION["username"])){
	// Verify the user
	$log_username = $_SESSION["username"];
	$user_ok = evalLoggedUser($db_con, $log_username, $_SESSION["user_token"]);
} else if(isset($_COOKIE["user_token"]) && isset($_COOKIE["username"])){
  	$log_username = $_COOKIE["username"];
	$user_ok = evalLoggedUser($db_con, $log_username, $_COOKIE["user_token"]);
	
}

if($user_ok == true){
	$sql = "SELECT user_id, role FROM users WHERE username='$log_username'";
    $query = mysqli_query($db_con, $sql);
    $row = mysqli_fetch_row($query);
	$log_user_id = $row[0];
	$user_role = $row[1];
}

    $result1 = mysqli_query($db_con,'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.user_id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$log_user_id.'" and m1.user1read="no" and users.user_id=m1.user2) or (m1.user2="'.$log_user_id.'" and m1.user2read="no" and users.user_id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
    $rowcount1=mysqli_num_rows($result1);

?>

