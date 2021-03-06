<?php
include_once("php_includes/check_login_status.php");
include_once("php_includes/login.php");

if($user_ok){
	header("location:index.php");
    exit();
}

if(isset($_POST["usernamecheck"])){
	$sql = mysqli_prepare($db_con,"SELECT * FROM users WHERE username=? LIMIT 1");
	mysqli_stmt_bind_param($sql, 's' ,$username);
	
	$username = $_POST['usernamecheck'];
	
	mysqli_stmt_execute($sql);
	mysqli_stmt_store_result($sql);
    $uname_check = mysqli_stmt_num_rows($sql);
	$sql -> close();
	
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<strong style="color:#F00;">Username: 3 - 16 charactere </strong>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<strong style="color:#F00;">Nume utilizator trebuie sa înceapă cu literă</strong>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<strong style="color:#009900;">' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . ' accepted !</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . ' already exists !</strong>';
	    exit();
    }
}

    if(isset($_POST["email_check"])){
        $email_check = $_POST["email_check"];

        $sql = mysqli_prepare($db_con, "SELECT 1 FROM users WHERE email=? LIMIT 1");
       
        mysqli_stmt_bind_param($sql, 's', $email_check);
        mysqli_stmt_execute($sql);
        mysqli_stmt_store_result($sql);
       
        $email_count = mysqli_stmt_num_rows($sql);
       
        mysqli_stmt_close($sql);

        if($email_count != 0){
            echo '<strong style="color:#F00;">The email is already in use by another user</strong>';
        }else{
            if(filter_var($email_check, FILTER_VALIDATE_EMAIL)){
                echo '<strong style="color:#009900;">Email adress accepted</strong>';;
            }
            else{
                echo '<strong style="color:#F00;">Wrong email format</strong>';
            }
        }
        exit();
    }

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


// Ajax calls this REGISTRATION code to execute
if(isset($_POST["username"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$username =  $_POST['username'];
	$nume = $_POST['nume'];
	$prenume = $_POST['prenume'];
	$email = $_POST['email'];
	$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$adresa = $_POST['adresa'];
	$telefon = $_POST['telefon'];
    $role = 0;
	// Verificare username

	$sql = mysqli_prepare($db_con,"SELECT username FROM users WHERE username=? LIMIT 1");
	mysqli_stmt_bind_param($sql,'s',$username);
	
	
	mysqli_stmt_execute($sql);
	mysqli_stmt_store_result($sql);
    $u_check = mysqli_stmt_num_rows($sql);
	$sql -> close();
	
	// Verificare email
	
	$sql = mysqli_prepare($db_con,"SELECT email FROM users WHERE email=? LIMIT 1");
	mysqli_stmt_bind_param($sql, 's', $email);
	mysqli_stmt_execute($sql);
	mysqli_stmt_store_result($sql);
    $email_check = mysqli_stmt_num_rows($sql);
	$sql -> close();
	
	
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
        echo "Username must be between 3 and 16 characters " . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . ".";
        exit(); 
    } else if (is_numeric($username[0])) {
        echo 'Username cannot begin with a number';
        exit();
        // End error check
    } else {
        //Insert account to database
            
            $sql = mysqli_prepare($db_con, "INSERT INTO users (username, last_name, first_name, email, pass, address, phone_number, role)       
                    VALUES(?,?,?,?,?,?,?,?)");
            mysqli_stmt_bind_param($sql, 'sssssssi', $username, $nume, $prenume, $email, $pass_hash, $adresa, $telefon, $role);
            mysqli_stmt_execute($sql);
            $sql -> close();    
		}
	exit();
}
?>

<html>
<head>
    <title>Lost and Found - Marius Râncu şi Nedelcu Răzvan</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

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

    function emptyElement(x){
        _(x).innerHTML = "";
    }

    function login(){
        var u = _("l_username").value;
        var p = _("password").value;
        var remember = _("remember").value;
        if(u == "" || p == ""){
            _("login_status").innerHTML = "Fill out all of the form data";
        } else {
            _("login_status").innerHTML = 'please wait ...';
            var ajax = ajaxObj("POST", "signup.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    var response = ajax.responseText;
                        if(response.indexOf('logged_in') > -1){
                            location.reload();
                        }
                        else{
                            _("login_status").innerHTML = response;
                        }
                }
            }
            ajax.send("&u="+ u +"&p="+ p + "&remember=" + remember);
        }
    }

    function checkpassword(){
        var password1 = _("p1").value;
        var password2 = _("p2").value;
        
        if(password1 != "" && password2 != ""){
            var ajax = ajaxObj("POST", "signup.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    _("password_status").innerHTML = ajax.responseText;
                }
            }
            ajax.send("pass_check1=" + password1 + "&pass_check2=" + password2);
        }
    }

    function emailCheck(){
        var email = _("email").value;
        var ajax = ajaxObj("POST", "signup.php");

        if(email != ""){
            ajax.onreadystatechange = function(){
                if(ajaxReturn(ajax) == true){
                    _("email_status").innerHTML = ajax.responseText;
                }
            }
            ajax.send("email_check=" + email);
        }
    }

    function signup(){
        var username = _("username").value;
        var nume = _("lastname").value;
        var prenume = _("firstname").value;
        var email = _("email").value;
        var p1 = _("p1").value;
        var p2 = _("p2").value;
        var adresa = _("address").value;
        var telefon = _("phone").value;
        var status = _("status");
        
        if(username == "" || nume == "" ||  prenume == "" ||  email == "" ||  adresa == "" || p1 == "" || p2 == "" || telefon == ""){
            status.innerHTML = "Completati toate campurile !";
        } else if(p1 != p2){
            status.innerHTML = "Parolele nu se potrivesc ";
        } else {
            var ajax = ajaxObj("POST", "signup.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                        status.innerHTML = ajax.responseText;
                        alert("Your account has been created. You may login now!");
                        window.location = "index.php";
                }
            }
            ajax.send("username=" + username + "&nume=" + nume + "&prenume=" + prenume + "&email=" + email + "&adresa=" + adresa + "&password=" + p1 + "&telefon=" + telefon);
        }
    }

    </script>
</head>

<body>
    <div class="header_menu">
        <div class="menu_content">
                    <div class="menu_items">
                        <a href="index.php">HOME</a> |
                        <?php if(isset($_SESSION['username'])){
    echo '<a href="my_profile.php">MY PROFILE</a> |';
    if($user_role == true) : 
                echo '<a href="admin_panel.php">ADMIN PANEL</a> |';
    endif;
    echo '<a href="report.php">REPORT</a> |';
} else { echo '<a href="signup.php" class="activ">SIGN UP</a> |'; }; ?>
                        <a href="contact_us.php">CONTACT US</a>
                    </div>

        </div>
    </div>
    <div class="banner_bg">
        <div class="banner_itself">
            <div class="slogan">
                <div class="big_text">L O F O</div>
                <div class="little_text">Lost & Found V4.0.1 BETA</div>
            </div>
             <?php if($user_ok == true) : ?>
                <div class="login">
                        <div class="login_items">
                            <span class="login_items">Welcome, <a href="./my_profile.php"><?php echo $log_username; ?></a>!
                            <span class="mini_menu">
                            <br>
                            &#9830; <a href="messages.php">My messages ( <?php echo $rowcount1; ?> )</a>
                            <br>
                            &#9830; <a href="my_lost_objects.php">My lost objects</a>
                            <br>
                            &#9830; <a href="my_found_objects.php">My found objects</a>
                            </span>
                            <a href="logout.php" style="color: red; position: relative; float: right; right: 10px;top: 0x;">Logout</a></span>
                        </div>
                </div>
            <?php else : ?>
                <div class="login">
                    <div class="login_items">
                        <input type="text" placeholder="Enter Username" id="l_username" size="18" required/>
                        <input type="checkbox" checked="checked" id="remember"><span>Remember me?</span>
                        <input type="password" placeholder="Enter Password" id="password" size="18" required/>
                        <input type="submit" id="loginbtn" onclick="login()"></submit> 
                        <p id="login_status"></p>
                    </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <div class="form">
            <h1>Sign UP</h1>
            <form name="signupform" id="signupform" onsubmit="return false;">
                <span>Username: </span> 
                <input type="text" id="username" maxlength="16" onblur="checkusername()" placeholder="Enter your desired username" size="55" required/>
                <span id="unamestatus" style="float: right;top: 0px;bottom: 0px;"></span>
                <br><br><br>
                <span>Password: </span>
                <input id="p1" type="password" onfocus="emptyElement('status')" placeholder="Enter your desired password" name="uname" size="55" required/>
                <br><br>
                <span>Repeat Password: </span>
                <input id="p2" type="password" onblur="checkpassword()" placeholder="Enter you desired password, again" name="uname" size="55" required/>
                <span id="password_status" style="float: right;top: 0px;bottom: 0px;"></span>
                <br><br><br>
                <span>First Name: </span>
                <input id="firstname" type="text" onfocus="emptyElement('status')" placeholder="Enter your first name" name="uname" size="55" required/>
                <br><br>
                <span>Last Name: </span>
                <input id="lastname" type="text" onfocus="emptyElement('status')" placeholder="Enter your last name" name="uname" size="55" required/>
                <br><br>
                <span>E-mail: </span>
                <input id="email" onblur="emailCheck()" type="text" placeholder="Enter your e-mail address" size="55" required/>
                <span id="email_status"></span>
                <br><br>
                <span>Address: </span>
                <input id="address" type="text" onfocus="emptyElement('status')" placeholder="Enter your home address" name="uname" size="55" required/>
                <br><br>
                <span>Phone No: </span>
                <input id="phone" type="text" onfocus="emptyElement('status')" placeholder="Enter your phone no. -- it will not be made public" name="uname" size="55" required/>
                <br/><br/><br/>
                <button id="signupbtn" onclick="signup()">Sign Up</button>
                <br/>
                <span id="status"></span>
            </form>
    </div></div>
</body>

</html>