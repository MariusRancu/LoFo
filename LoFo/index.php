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
                            response =  ajax.responseText;
                            if(response.indexOf('logged_in') > -1){
                                _("status").innerHTML = response;
                                location.reload();
                            }
                            else{
                                _("status").innerHTML = response;
                            }
                        }
                    }
                    ajax.send("&u=" + u + "&p=" + p + "&remember=" + remember);
                }
            }
        </script>
    </head>

    <body>
        <div class="header_menu">
            <div class="menu_content">
                    <div class="menu_items">
                        <a href="index.php" class="activ">HOME</a> |
                        <?php if($user_ok == true){
    echo '<a href="my_profile.php">MY PROFILE</a> |';
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
                        <span class="login_items">Welcome, <a href="./my_profile.php"><?php echo htmlspecialchars($log_username, ENT_QUOTES, 'UTF-8'); ?></a>!
                            <a href="logout.php" style="color: red; position: relative; float: right; right: 10px;top: 45px;">Logout</a></span>
<!--<a href="test.php">go to refer</a>-->
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