<?php
include_once("php_includes/check_login_status.php");
include_once("php_includes/login.php");
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
} else { echo '<a href="signup.php">SIGN UP</a> |'; }; ?>
                        <a href="contact_us.php" class="activ">CONTACT US</a>
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
                        <p id="login_status"></p>
                    </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <div class="form">
            <h1>Contact US</h1>
            <span>Your e-mail: </span> <input type="text" placeholder="Enter your correct e-mail address, so we can contact you back" name="uname" size="55" required>
            <br><br>
            <span>Title: </span> <input type="text" placeholder="Enter the e-mail title" name="uname" size="55" required>
            <br><br>
            
            <span>Domain: </span>
            <select name="domains">
                <option value="">Why are you contacting us?</option>
                <option value="scam">Advertising</option>
                <option value="vulgar-language">Support</option>
                <option value="not-return">Partnership</option>
                <option value="no-answer">Bug Report</option>
            </select>
            <br><br>
            <span>Content: </span><textarea rows="10" cols="57" placeholder="Enter the content of the e-mail that you want to send."></textarea>
        <br><br><br>
            <input type="submit" value="Contact US">
        </div>
    </div>
</body>

</html>