<?php
//Daca utilizatorul e deja logat, redirectioneaza
include_once("php_includes/check_login_status.php");
if($user_ok == true)
    {
        header("location: signup.php");
    exit();
    }
 ?> <?php
// Apel ajax
if(isset($_POST["u"])){
	
	include_once("php_includes/db_con.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$u = $_POST['u'];
	$p = md5($_POST['p']);
	$remember = $_POST['remember'];
	// FORM DATA ERROR HANDLING
	if($u == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT username, parola FROM utilizatori WHERE username='$u'";
        $query = mysqli_query($db_con, $sql);
        $row = mysqli_fetch_row($query);
		$db_username = $row[0];
        $db_pass_str = $row[1];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			
			if(isset($_post['remember'])){
				
			 setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		 setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			
			}
			
		    exit();
		}
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Log In</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
#body
{
	    background-color: gray;
		border: 2px solid black;
		text-align: center;
		border-radius: 10px;
}
#loginform > input {
	width: 100px;
	height: 10px;
	padding: 3px;
	background: #F3F9DD;

}
#loginbtn {
	font-size: 10px;

}
</style>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script>
function emptyElement(x){
	_(x).innerHTML = "";
}
function login(){
	var u = _("username").value;
	var p = _("password").value;
	var remember = _("remember").value;
	if(u == "" || p == ""){
		_("status").innerHTML = "Fill out all of the form data";
	} else {
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "login.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("status").innerHTML = "Combinație username parolă incorectă !";
				} else {
					window.location = "home.php";
				}
	        }
        }
        ajax.send("&u="+ u +"&p="+ p + "&remember=" + remember);
	}
}
</script>
</head>
<body>
<div id="body">
<div id="pageMiddle">
  <!-- LOGIN FORM -->
  <form id="loginform" onsubmit="return false;">
    LOGARE
    <hr color="brown">
    <b><i>Membru:</i></b> <input type="text" id="username" onfocus="emptyElement('status')" maxlength="88" align="left">
    <br>
    <b><i>Parola:&nbsp;&nbsp;&nbsp;</b></i> <input type="password" id="password" onfocus="emptyElement('status')" maxlength="100" align="left">
    <br>
    <button id="loginbtn" onclick="login()">Log in</button> 
    <hr>
    <font size="2"><b><i>Reţine-mi informaţiile:</i></b></font><input type="checkbox"  id="remember" align="left">
	<div></div>
	 
    <p id="status"></p>
  </form>
  <!-- LOGIN FORM -->
</div>
</div>
</body>
</html>