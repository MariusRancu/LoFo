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
                <a href="my_profile.php" >MY PROFILE</a> |
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
    <div class="container">
        <div class="form">
            <h1>Report Member</h1>
            <span>Username profile: </span> <input type="text" placeholder="Enter the member's profile/ID/Object that you want to report" name="uname" size="55" required>
            <br><br>
            <span>Reason: </span>
            <select name="reasons">
                <option value="">Please pick a reason for which you report this member</option>
                <option value="scam">Scam</option>
                <option value="vulgar-language">Vulgar Language</option>
                <option value="not-return">Not willing to return lost object</option>
                <option value="no-answer">Doesn't answer</option>
                <option value="bot">Bot</option>
            </select>
            <br><br>
            <span>Describe report: </span><input type="text" placeholder="Use a few words to describe the report reason" name="uname" size="55" height="20" required>
        <br><br>
            <button id="signupbtn" onclick="signup()">Sign Up</button>
        </div>
    </div>
</body>

</html>