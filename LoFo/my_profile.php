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
                <a href="my_profile.html" class="activ">MY PROFILE</a> |
                <a href="admin_panel.html">ADMIN PANEL</a> |
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
            <h1>My Profile</h1>
            <span>Hello, $username! </span>
            <br><br>
            <hr>
            <span>New Password: </span><input type="text" placeholder="Enter your new desired password" name="uname" size="55" required>
            <br><br>
            <span>Repeat Password: </span><input type="text" placeholder="Enter you new desired password, again" name="uname" size="55" required>
            <br><br>
            <input type="submit" value="Change Password">
            <br>
            <hr>
            <span>First Name: </span><input type="text" placeholder="Andrew" name="uname" size="55" disabled>
            <br><br>
            <span>Last Name: </span><input type="text" placeholder="Michael" name="uname" size="55" disabled>
            <br><br>
            <span>CNP: </span><input type="text" placeholder="1121294123536" name="uname" size="55" disabled>

            <br><br>
            <span>E-mail: </span><input type="text" placeholder="Enter your e-mail address" name="uname" size="55" required>
            <br><br>
            <span>Address: </span><input type="text" placeholder="Enter your home address" name="uname" size="55" required>
            <br><br>
            <span>Phone No: </span><input type="text" placeholder="Enter your phone no. -- it will not be made public" name="uname" size="55" required>
            <br><br>
            <input type="submit" value="Update my profile">
        </div>
    </div>
</body>

</html>