<?php
session_start();
// Daca utilizatorul e logat,redirectioneaza
if(isset($_SESSION["username"])){
	header("location:home.php");
    exit();
}
?><?php
// Ajax apeleaza usernamecheck
if(isset($_POST["usernamecheck"])){
	include_once("php_includes/db_con.php");
	
	$sql = mysqli_prepare($db_con,"SELECT username FROM utilizatori WHERE username=? LIMIT 1");
	mysqli_stmt_bind_param($sql,'s',$username);
	
	$username = $_POST['usernamecheck'];
	
	mysqli_stmt_execute($sql);
	mysqli_stmt_store_result($sql);
    $uname_check = mysqli_stmt_num_rows($sql);
	$sql -> close();
	
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<strong style="color:#F00;">Nume utilizator: 3 - 16 charactere </strong>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<strong style="color:#F00;">Nume utilizator trebuie sa înceapă cu literă</strong>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<strong style="color:#009900;">' . $username . ' acceptat !</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . $username . ' există deja !</strong>';
	    exit();
    }
}
?><?php

	if(isset($_POST["pass_check1"]) && $_POST["pass_check2"]){
		$pass1 = $_POST["pass_check1"];
		$pass2 = $_POST["pass_check2"];
		if($pass1 != $pass2){
			 echo '<strong style="color:#F00;">Parolele nu coincid !</strong>';
		}else if (strlen($_POST["pass_check1"]) < 5){
			echo '<strong style="color:#F00;">Parola prea ușoară !</strong>';
		}else {
			echo '<strong style="color:#009900;"> Parolă acceptată </strong>';
		}
	exit();
}
?>

<?php

// Ajax calls this REGISTRATION code to execute
if(isset($_POST["username"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_con.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$username =  $_POST['username'];
	$nume =$_POST['nume'];
	$prenume =$_POST['prenume'];
	$email = $_POST['email'];
	$parola = $_POST['parola'];
	$adresa = $_POST['adresa'];
	$telefon = $_POST['telefon'];
	$cnp = $_POST['cnp'];

	// Verificare username

	$sql = mysqli_prepare($db_con,"SELECT username FROM utilizatori WHERE username=? LIMIT 1");
	mysqli_stmt_bind_param($sql,'s',$username);
	
	
	mysqli_stmt_execute($sql);
	mysqli_stmt_store_result($sql);
    $u_check = mysqli_stmt_num_rows($sql);
	$sql -> close();
	
	// Verificare email
	
	$sql = mysqli_prepare($db_con,"SELECT email FROM utilizatori WHERE email=? LIMIT 1");
	mysqli_stmt_bind_param($sql,'s',$email);
	mysqli_stmt_execute($sql);
	mysqli_stmt_store_result($sql);
    $email_check = mysqli_stmt_num_rows($sql);
	$sql -> close();
	
	// Verificare existenta CNP
	
	$sql = mysqli_prepare($db_con, "SELECT CNP FROM utilizatori WHERE CNP=? LIMIT 1");
	mysqli_stmt_bind_param($sql,'s',$cnp);
	mysqli_stmt_execute($sql);
	mysqli_stmt_store_result($sql);
    $cnp_check = mysqli_stmt_num_rows($sql);
	$sql -> close();
		 
	// Verificare daca CNP este alcatuit doar din cifre
	$cnp_number_check = true;
	for($i=0 ; $i<13 ; $i++) {
        if(!is_numeric($cnp[$i])) {
            $cnp_number_check = false;
        }
	}
	// Inceput formular erori
	if($username == ""){
		echo "The form submission is missing values.";
        exit();
	} else if ($u_check > 0){ 
        echo "The username you entered is alreay taken";
        exit();
	} else if ($email_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($username) < 3 || strlen($username) > 16) {
        echo "Username must be between 3 and 16 characters " . $username . ".";
        exit(); 
    } else if (is_numeric($username[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else if(strlen($cnp) != 13 ){
		 echo "Lungime cnp incorecta.";
		 exit();
		 
	}else if ($cnp_number_check == false){
		echo "Format CNP incorect.";
		exit();
	} else if($cnp_check > 0) {
		 echo "CNP asociat deja unui cont.";
		 exit();
	} else {
	// Sfarsit formular erori
	    // Criptare parola si inserare cont in tabel
		$pass_hash = md5($parola);
		
		$sql = mysqli_prepare($db_con, "INSERT INTO utilizatori (username, nume, prenume, email, parola, adresa, nr_tel, CNP)       
		        VALUES(?,?,?,?,?,?,?,?)");
	mysqli_stmt_bind_param($sql,'ssssssss', $username, $nume, $prenume, $email, $parola, $adresa, $telefon, $cnp);
	mysqli_stmt_execute($sql);
	$sql -> close(); 
		
		}
	
	
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
        <title>Lost and Found</title>
        <meta name="author" content="Râncu Marius & Nedelcu Răzvan">
        <meta charset="UTF-8">
        <meta name="description" content="Proiect: Lost and Found">
        <link rel="stylesheet" type="text/css" href="css/style.css">
<style type="text/css">


</style>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script>


function emptyElement(x){
	_(x).innerHTML = "";
}

function checkusername(){
	var username = _("username").value;
	if(username != ""){
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("unamestatus").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("usernamecheck=" + username);
	}
}

function checkpassword(){
	var password1 = _("p1").value;
	var password2 = _("p2").value;
	var ajax = ajaxObj("POST", "signup.php");
	
	if(password1 != "" && password2 != ""){
	ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("password_status").innerHTML = ajax.responseText;
	        }
        }
		ajax.send("pass_check1=" + password1 + "&pass_check2=" + password2);
}
}

function signup(){
	var username = _("username").value;
	var nume = _("nume").value;
	var prenume = _("prenume").value;
	var email = _("email").value;
	var p1 = _("p1").value;
	var p2 = _("p2").value;
	var adresa = _("adresa").value;
	var telefon = _("telefon").value;
	var cnp = _("cnp").value;
	var status = _("status");
	
	if(username == "" || nume == "" ||  prenume == "" ||  email == "" ||  adresa == "" || p1 == "" || p2 == "" || telefon == "" || cnp == ""){
		status.innerHTML = "Completati toate campurile !";
	} else if(p1 != p2){
		status.innerHTML = "Parolele nu se potrivesc ";
	} else {
		
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            
					status.innerHTML = ajax.responseText;
				 
	        }
        }
        ajax.send("username=" + username + "&nume=" + nume + "&prenume=" + prenume + "&email=" + email + "&adresa=" + adresa + "&parola=" + p1 + "&telefon=" + telefon + "&cnp=" + cnp);
	}
}


</script>
</head>
<body>
<header>
    </header>
    <br><br>
<nav class="meniu"><center>
  <ul>
    <li><a href="index.php">Prima pagină</a></li>

    <li><a href="signup.php">Înregistrează-te</a></li>
    <li><a href="report.php">Raportează Abuz</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
</nav></center>
<div class="continut">
<section>
<div id="pageMiddle" align="left">
  <h3>Inregistreaza-te: </h3><hr>
  <form name="signupform" id="signupform" onsubmit="return false;">
    Username: <input id="username" type="text" onblur="checkusername()" maxlength="16" size="50">
    <span id="unamestatus"></span><hr>
	Nume:
    <input id="nume" type="text" onfocus="emptyElement('status')" maxlength="88" size="50"><hr>
	Prenume:
    <input id="prenume" type="text" onfocus="emptyElement('status')" maxlength="88" size="50"><hr>
	CNP:
    <input id="cnp" type="text" onfocus="emptyElement('status')" maxlength="13" size="50"><hr>
	Numar-telefon:
    <input id="telefon" type="text" onfocus="emptyElement('status')" maxlength="88" size="50"><hr>
    Email Address:
    <input id="email" type="text" onfocus="emptyElement('status')" maxlength="88" size="50"><hr>
	Adresa:
    <input id="adresa" type="text" onfocus="emptyElement('status')" maxlength="88" size="50"><hr>
    Create Password:
    <input id="p1" type="password" onfocus="emptyElement('status')" maxlength="50" size="50"><hr>
	
    Confirm Password:
    <input id="p2" type="password"  onblur="checkpassword()" maxlength="50" size="50">
	<span id="password_status"></span>
    
   
    <br /><br />
    <button id="signupbtn" onclick="signup()">Create Account</button>
	</br>
    <span id="status"></span>
    </form>
    </div>
  </form>
</section>
</div>
</nav>
</body>
</html>