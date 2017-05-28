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
                <a href="report.html">REPORT</a> |
                <a href="my_profile.php" >MY PROFILE</a> |
                <a href="admin_panel.php" class="activ">ADMIN PANEL</a> |
                <a href="contact_us.html">CONTACT US</a>
            </div>

        </div>
    </div>
    <div class="banner_bg">
        <div class="banner_itself">
            <div class="slogan">
                <div class="big_text">L O F O</div>
                <div class="little_text">Lost & Found V4.0.1 BETA</div>
            </div>
            <div class="login">
                <div class="login_items">
                    <input type="text" placeholder="Enter Username" name="uname" size="18" required>
                    <input type="checkbox" checked="checked"><span>Remember me?</span>
                    <input type="text" placeholder="Enter Password" name="uname" size="18" required>
                    <input type="submit" value="Submit">

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="form">
            <h1>Admin Panel</h1>
            <span>Hello, Admin! </span>
        </div>
    </div>
</body>

</html>