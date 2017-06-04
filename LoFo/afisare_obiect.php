<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
    exit();
    }
 ?>

    <html>

    <head>
        <title>Lost and Found - Marius Râncu şi Nedelcu Răzvan</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
        <div class="header_menu">
            <div class="menu_content">
                <div class="menu_items">
                    <a href="index.php">HOME</a> |
                    <a href="signup.php">SIGN UP</a> |
                    <a href="report.php" class="activ">REPORT</a> |
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
                        <span class="login_items">Welcome, <a href="./my_profile.php"><?php echo $log_username; ?></a>!
                            <a href="logout.php" style="color: red; position: relative; float: right; right: 10px;top: 45px;">Logout</a></span>

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
            <div class="search_form">
                <h1>Results for your search: //INSERT_SEARCH_HERE// </h1>
                <div class="search_container">
                    <img src="https://i1.wp.com/blogdecasa.ro/wp-content/uploads/2016/04/Tigaie-Tefal-Character-30-cm.jpg" class="search_img">
                    <div class="search_right">
                        <div class="search_ob_details">
                            <br><span class="ob_field">Object Name:</span>
                            <br><span class="ob_field">Category:</span>
                            <br><span class="ob_field">Producer:</span>
                            <br><span class="ob_field">Model:</span>
                            <br><span class="ob_field">Color:</span>
                            <br><span class="ob_field">Found location:</span>
                            <br><span class="ob_field">Found Date:</span>
                        </div>
                        <span>
                <div class="search_ob_contact">
                    <br>
                        <div class="ob_contact">
                        <span id="spoiler" style="display:none"> +4074xxxxxxx</span>
                        <input type="submit" title="Click to show/hide content" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}" value="Show phone number"></input>
                        </div>
                    <br>
                        <div class="ob_contact_username">Send: Andrei Matei a private message</div>
                    </div>

                    </span>
                </div>
            </div>
        </div>
        </div>
    </body>

    </html>