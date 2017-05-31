<?php
include_once("php_includes/check_login_status.php");
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
		$sql = "SELECT username, password FROM users WHERE username='$u'";
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
    function login(){
        var u = _("username").value;
        var p = _("password").value;
        var remember = _("remember").value;
        if(u == "" || p == ""){
            _("status").innerHTML = "Fill out all of the form data";
        } else {
            _("status").innerHTML = 'please wait ...';
            var ajax = ajaxObj("POST", "index.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText == "login_failed"){
                        _("status").innerHTML = "Combinație username parolă incorectă !";
                    } else {
                        window.location = "index.php";
                    }
                }
            }
            ajax.send("&u="+ u +"&p="+ p + "&remember=" + remember);
        }
    }
    </script>
</head>

<body>
    <div class="header_menu">
        <div class="menu_content">
            <div class="menu_items">
                <a href="index.php" class="activ">HOME</a> |
                <a href="signup.php">SIGN UP</a> |
                <a href="report.php">REPORT</a> |
                <a href="my_profile.php">MY PROFILE</a> |
                <?php if($user_role == true) : ?>
                <a href="admin_panel.php">ADMIN PANEL</a> |
                <?php endif; ?>
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
                    <p class="login_items">Welcome, <?php echo $log_username; ?></p>
                    <a href="logout.php">Logout</a>
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
    <div class="container_home">
        <div class="home_pierdut">
            <span><a href="obiect_pierdut.php">Am pierdut un obiect</a></span>
        </div>
        <div class="home_gasit">
            <span><a href="obiect_gasit.php">Am gasit un obiect</a></span>
        </div>
    </div>
</body>

</html>