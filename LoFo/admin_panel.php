<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false || $user_role == 0)
    {
        header("location: contact_us.php");
    exit();
    }
// Check connection
include_once("php_includes/db_con.php");
if (mysqli_connect_errno())
{
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

if (!$reports = mysqli_query($db_con,"SELECT * FROM reported_by WHERE SOLVED IS NULL"))
{
    die("Error: " . mysqli_error($db_con));
}

$lost_objects = mysqli_query($db_con,"SELECT * FROM lost_objects WHERE is_verified = 0");
$found_objects = mysqli_query($db_con,"SELECT * FROM found_objects WHERE is_verified = 0");
$reg_users = mysqli_query($db_con,"SELECT * FROM users");

$rowcount=mysqli_num_rows($reports);
$lost_pending_count = mysqli_num_rows($lost_objects);
$found_pending_count = mysqli_num_rows($found_objects);
$reg_users_count = mysqli_num_rows($reg_users);


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
                        <?php if(isset($_SESSION['username'])){
    echo '<a href="my_profile.php">MY PROFILE</a> |';
    if($user_role == true) : 
                echo '<a href="admin_panel.php" class="activ">ADMIN PANEL</a> |';
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
            </div>
        </div>
        <div class="container">
            <div class="form">
                <h1>Hello,
                    <a href="./my_profile.php">
                        <?php echo $log_username; ?>
                    </a>!</h1>
            </div>
            <div class="admin_container">
                <a href="./pending_lost.php">
                    <div class="admin_button_one">
                        <div class="admin_upside">Pending lost objects</div>
                        <div class="admin_downside"><?php echo "$lost_pending_count"; ?></div>
                    </div>
                </a>

                <a href="./admin_reports.php">
                    <div class="admin_button_two">
                        <div class="admin_upside">Unsolved reports</div>
                        <div class="admin_downside"><?php echo "$rowcount"; ?></div>
                    </div>
                </a>

                <a href="./registered_users.php">
                    <div class="admin_button_three">
                        <div class="admin_upside">Registered members</div>
                        <div class="admin_downside"><?php echo "$reg_users_count"; ?></div>
                    </div>
                </a>

                <a href="./pending_found.php">
                    <div class="admin_button_four">
                        <div class="admin_upside">Pending found objects</div>
                        <div class="admin_downside"><?php echo "$found_pending_count"; ?></div>
                    </div>
                </a>
                <br><br>
                <a href="./json_raport.php">
                    <div class="admin_generate_one">
                        <div class="admin_upside">Lost objects raport</div>
                    </div>
                </a>
                <a href="./json_found_raport.php">
                    <div class="admin_generate_two">
                        <div class="admin_upside"> Found objects raport</div>
                    </div>
                </a>
            </div>
        </div>
    </body>

    </html>