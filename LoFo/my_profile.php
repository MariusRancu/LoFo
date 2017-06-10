<?php
include_once("php_includes/check_login_status.php");
include_once("php_includes/db_con.php");
include_once("php_includes/login.php");

if($user_ok == false){
	header("location:index.php");
    exit();
}

$sql2 = mysqli_prepare($db_con, "SELECT last_name, first_name, email, address, phone_number FROM users WHERE username = ?");

mysqli_stmt_bind_param($sql2, 's', $log_username);
mysqli_stmt_execute($sql2);

$sql2->bind_result($last_name, $first_name, $f_email, $f_address, $f_phone);
$sql2->fetch();
mysqli_stmt_close($sql2);
// Apel ajax
?>

    <?php
    if(isset($_POST["pass_check1"]) && $_POST["pass_check2"]){
		$pass1 = $_POST["pass_check1"];
		$pass2 = $_POST["pass_check2"];
		if($pass1 != $pass2){
			 echo '<strong style="color:#F00;">Parolele nu coincid !</strong>';
		}else if (strlen($_POST["pass_check1"]) < 5){
			echo '<strong style="color:#F00;">Parola prea ușoară !</strong>';
		}else {
            $pass_hash = md5($pass1);
            $sql4 = mysqli_prepare($db_con, "UPDATE users SET pass=? WHERE username = ?");
            mysqli_stmt_bind_param($sql4, 'ss', $pass_hash, $log_username);

            mysqli_stmt_execute($sql4);

            if(mysqli_stmt_affected_rows($sql4) == 1){
        
            echo 'Password changed';
            mysqli_stmt_close($sql4);
            }
            else{
                echo 'Paswword not changed';
                mysqli_stmt_close($sql4);  
            }
            }
            exit();
}
?>

        <?php 
    if(isset($_POST["email"]) && isset($_POST["addr"]) && isset($_POST["phone"])){
        $email = $_POST["email"];
        $addr = $_POST["addr"];
        $phone = $_POST["phone"];

        if($email == ""){
            $email == $f_email;
        }

        if($addr == ""){
            $addr = $f_addr;
        }

        if($phone == ""){
            $phone = $f_phone;
        }

        $sql1 = mysqli_prepare($db_con, "UPDATE users SET email=?, address=?, phone_number=? WHERE username = ?");
            mysqli_stmt_bind_param($sql1, 'ssss', $email, $addr, $phone, $log_username);
            mysqli_stmt_execute($sql1);

            if(mysqli_stmt_affected_rows($sql1) == 1){
                echo 'Values updated';
                mysqli_stmt_close($sql1);
                exit();
            }
            else{
                echo 'Values could not be changed';
                mysqli_stmt_close($sql1);
                exit();
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
                function emptyElement(x) {
                    _(x).innerHTML = "";
                }

                function login() {
                    var u = _("username").value;
                    var p = _("password").value;
                    var remember = _("remember").value;
                    if (u == "" || p == "") {
                        _("status").innerHTML = "Fill out all of the form data";
                    } else {
                        _("status").innerHTML = 'please wait ...';
                        var ajax = ajaxObj("POST", "index.php");
                        ajax.onreadystatechange = function() {
                            if (ajaxReturn(ajax) == true) {
                                if (ajax.responseText == "login_failed") {
                                    _("status").innerHTML = "Combinație username parolă incorectă !";
                                } else {
                                    window.location = "index.php";
                                }
                            }
                        }
                        ajax.send("&u=" + u + "&p=" + p + "&remember=" + remember);
                    }
                }

                function changePass() {
                    var p1 = _("p1").value;
                    var p2 = _("p2").value;
                    var ajax = ajaxObj("POST", "my_profile.php");

                    if (p1 != "" && p2 != "") {
                        ajax.onreadystatechange = function() {
                            if (ajaxReturn(ajax) == true) {
                                _("pass_status").innerHTML = ajax.responseText;
                            }
                        }
                        ajax.send("pass_check1=" + p1 + "&pass_check2=" + p2);
                    }
                }

                function updateInfo() {
                    var email = _("email").value;
                    var addr = _("address").value;
                    var phone = _("phone").value;

                    var ajax = ajaxObj("POST", "my_profile.php");

                    if (email != "" || address != "" || phone != "") {
                        ajax.onreadystatechange = function() {
                            if (ajaxReturn(ajax) == true) {
                                _("info_status").innerHTML = ajax.responseText;
                            }
                        }
                        ajax.send("email=" + email + "&addr=" + addr + "&phone=" + phone);
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
    echo '<a href="my_profile.php" class="activ">MY PROFILE</a> |';
    if($user_role == true) : 
                echo '<a href="admin_panel.php">ADMIN PANEL</a> |';
    endif;
    echo '<a href="report.php">REPORT</a> |';
} else { echo '<a href="signup.php">SIGN UP</a> |'; }; ?>
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
                            &#9830; <a href="messages.php">My messages</a>
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
                            <input type="text" placeholder="Enter Username" id="username" size="18" required/>
                            <input type="checkbox" checked="checked" id="remember"><span>Remember me?</span>
                            <input type="password" placeholder="Enter Password" id="password" size="18" required/>
                            <input type="submit" id="loginbtn" onclick="login()"></submit>
                            <p id="status"></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="container">
                <form class="form" onsubmit="return false;">
                    <h1>My Profile</h1>
                    <span>Hello, <?php echo $log_username ?></span>
                    <br><br>
                    <hr>
                    <span>New Password: </span><input id="p1" type="password" placeholder="Enter your new desired password" name="uname" size="55">
                    <br><br>
                    <span>Repeat Password: </span><input id="p2" type="password" placeholder="Enter you new desired password, again" name="uname" size="55">
                    <span id="pass_status"></span>
                    <br><br>
                    <input type="submit" onclick="changePass()" value="Change Password">
                </form>
                <form class="form" onsubmit="return false;">
                    <br>
                    <hr>
                    <span>First Name: </span><input type="text" placeholder=<?php echo $first_name ?> name="uname" size="55" disabled>
                    <br><br>
                    <span>Last Name: </span><input type="text" placeholder=<?php echo $last_name ?> name="uname" size="55" disabled>
                    <br><br>

                    <br><br>
                    <span>E-mail: </span><input id="email" type="text" placeholder=<?php echo $f_email ?> name="uname" size="55">
                    <br><br>
                    <span>Address: </span><input id="address" type="text" placeholder=<?php echo $f_address ?> name="uname" size="55">
                    <br><br>
                    <span>Phone No: </span><input id="phone" type="text" placeholder=<?php echo $f_phone ?> name="uname" size="55">
                    <span id="info_status"></span>
                    <br><br>
                    <input type="submit" onclick="updateInfo()" value="Update my profile">
                </form>
            </div>
        </body>

        </html>