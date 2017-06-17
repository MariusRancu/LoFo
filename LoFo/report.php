<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
        exit();
    }
 ?>
 <?php

// Apel Ajax
if(isset($_POST["reported_username"])){
    // Conecatere la BD
	include_once("php_includes/db_con.php");
    
    //Inserare obiect in tabel
$reported_username = $_POST['reported_username']; //$numeOb
$reason = $_POST['reason']; //$categorie
$described_report =$_POST['described_report']; //$producer
$reported_by = $_SESSION["username"];
$report_time = date("Y/m/d"); // date
    
    
        
    $sql = mysqli_prepare($db_con,"INSERT INTO reported_by (`reported_username`, `reason`, `described_report`, `reported_by`, `report_time`) VALUES(?, ?, ?, ?, ?)");
	mysqli_stmt_bind_param($sql,'sssss', $reported_username, $reason, $described_report, $reported_by, $report_time);
    
    mysqli_stmt_execute($sql);

    if(mysqli_stmt_affected_rows($sql) == 1){
        
		 echo 'Report trimis'; 
         mysqli_stmt_close($sql);  
         exit(); 
	} else {
        
        echo 'Reportul n-a putut fi trimis';
        mysqli_stmt_close($sql);
        exit();
    }

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

                function adauga() {
                    var reported_username = _("reported_username").value;
                    var reason = _("reason").value;
                    var described_report = _("described_report").value;
//                    var reported_by = _("reported_by").value;
//                    var reported_time = _("report_time").value;
                    var status = _("status");

                    if (reported_username == "" || reason == "" || described_report == "") {
                        status.innerHTML = "Completati campurile obligatorii ! ";
                    } else {

                        var ajax = ajaxObj("POST", "report.php");
                        ajax.onreadystatechange = function() {
                            if (ajaxReturn(ajax) == true) {

                                status.innerHTML = ajax.responseText;

                            }
                        }
                        ajax.send("reported_username=" + reported_username + "&reason=" + reason + "&described_report=" + described_report);
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
    echo '<a href="report.php" class="activ">REPORT</a> |';
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
                    <h1>Report Member</h1>
                    <span>Username profile: </span> <input type="text" id="reported_username" placeholder="Enter the member's profile/ID/Object that you want to report" name="uname" size="55" required>
                    <br><br>
                    <span>Reason: </span>
                    <select id="reason">
                <option value="">Please pick a reason for which you report this member</option>
                <option value="scam">Scam</option>
                <option value="vulgar-language">Vulgar Language</option>
                <option value="not-return">Not willing to return lost object</option>
                <option value="no-answer">Doesn't answer</option>
                <option value="bot">Bot</option>
            </select>
                    <br><br>
                    <span>Describe report: </span><input type="text" id="described_report" placeholder="Use a few words to describe the report reason" name="uname" size="55" height="20" required>
                    <br><br>
                    <button id="button" onclick="adauga()">Send</button>
                    <span id="status"></span>
                </form>
            </div>
        </body>

        </html>