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
	// Salveaza datele din POST in variabile
	$u = $_POST['u'];
	$p = md5($_POST['p']);
	$remember = $_POST['remember'];
	// Veridicare login
	if($u == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
			
		$sql = mysqli_prepare($db_con,"SELECT username, parola FROM utilizatori WHERE username=?");
		mysqli_stmt_bind_param($sql,'s',$u);
	
	
		mysqli_stmt_execute($sql);
		$sql->bind_result($db_username, $db_pass_str);
		mysqli_stmt_fetch($sql);
		$sql -> close();
		
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
#loginform{
	margin-top:24px;	
}
#loginform > div {
	margin-top: 12px;	
}
#loginform > input {
	width: 200px;
	padding: 3px;
	background: #F3F9DD;
}
#loginbtn {
	font-size:15px;
	padding: 10px;
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

<div id="pageMiddle">
  <h3>Log In Here</h3>
  <!-- LOGIN FORM -->
  <form id="loginform" onsubmit="return false;">
    <div>Username:</div>
    <input type="text" id="username" onfocus="emptyElement('status')" maxlength="88">
    <div>Parolă:</div>
    <input type="password" id="password" onfocus="emptyElement('status')" maxlength="100">
    <br /><br />
    <button id="loginbtn" onclick="login()">Log In</button> 
	<div>Păstrează autentificarea </div>
	 <input type="checkbox"  id="remember">
    <p id="status"></p>
  </form>
  <!-- LOGIN FORM -->
</div>
</body>
</html>