<?php
session_start();

$_SESSION = array();
// Expira fisierele cookie
if(isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
    setcookie("user", '', strtotime( '-5 days' ), '/');
	setcookie("pass", '', strtotime( '-5 days' ), '/');
}
// Distruge variabilele sesiune
session_destroy();
// Verificare si redirectionare 
if(isset($_SESSION['username'])){
	header("location: login.php");
} else {
	header("location:signup.php");
	exit();
} 
?>