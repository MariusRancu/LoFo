<?php
//conexiune generala

$db_con = mysqli_connect("localhost","root","","twbd");
// Your database info
//
//$db_host = 'localhost';
//$db_user = 'root';
//$db_pass = '';
//$db_name = 'twbd';

mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("twbd") or die(mysql_error());

if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
} 
?>
