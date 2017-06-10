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
	include_once("php_includes/db_con_pm.php");
    
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
                <form class="form" onsubmit="return false;">
                    <h1>INBOX</h1>
                    <?php
include_once("php_includes/check_login_status.php");
include_once("php_includes/db_con.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Personal Messages</title>
    </head>
    <body>
        <div class="content">
<?php
//We check if the user is logged
if(isset($_SESSION['username']))
{
//We list his messages in a table
//Two queries are executes, one for the unread messages and another for read messages
    
    // Check connection

if (mysqli_connect_errno())
{
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
    
//$result1 = mysql_query($db_con,'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.user_id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$log_user_id.'" and m1.user1read="no" and users.user_id=m1.user2) or (m1.user2="'.$log_user_id.'" and m1.user2read="no" and users.user_id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
    
if (!$result1 = mysqli_query($db_con,'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.user_id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$log_user_id.'" and m1.user1read="no" and users.user_id=m1.user2) or (m1.user2="'.$log_user_id.'" and m1.user2read="no" and users.user_id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc'))
{
    die("Error" . mysqli_error($db_con));
}
    
    $rowcount1=mysqli_num_rows($result1);
    
$result1_count = mysqli_num_rows($result1);
    
//$req2 = mysql_query($db_con, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.user_id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="2" and m1.user1read="yes" and users.user_id=m1.user2) or (m1.user2="2" and m1.user2read="yes" and users.user_id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
    if (!$result2 = mysqli_query($db_con,'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.user_id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="2" and m1.user1read="yes" and users.user_id=m1.user2) or (m1.user2="2" and m1.user2read="yes" and users.user_id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc'))
{
    die("Error" . mysqli_error($db_con));
}
    
    $rowcount2=mysqli_num_rows($result2);
    
    
?>
This is the list of your messages:<br />
<a href="new_message.php" class="link_new_pm">New PM</a><br />
<h3>Unread Messages(<?php echo $rowcount1; ?>):</h3>
<table>
        <tr>
        <th class="title_cell">Title</th>
        <th>Nb. Replies</th>
        <th>Participant</th>
        <th>Date of creation</th>
    </tr>
<?php
//We display the list of unread messages
while($row = mysqli_fetch_array($result1))
{
?>
        <tr>
        <td class="left"><a href="discussion.php?id=<?php echo $row['id']; ?>"><?php echo htmlentities($row['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
        <td><?php echo $row['reps']-1; ?></td>
        <td><a href="profile.php?id=<?php echo $row['userid']; ?>"><?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
        <td><?php echo date('Y/m/d H:i:s' ,$row['timestamp']); ?></td>
    </tr>
<?php
}
//If there is no unread message we notice it
    echo $row;
if( $row == 0 )
{
?>
        <tr>
        <td colspan="4" class="center">You have no unread message.</td>
    </tr>
<?php
}
?>
</table>
<br />
<h3>Read Messages(<?php echo $rowcount2; ?>):</h3>
<table border="1">
        <tr>
        <th class="title_cell">Title</th>
        <th>Nb. Replies</th>
        <th>Participant</th>
        <th>Date or creation</th>
    </tr>
<?php
//We display the list of read messages
while($row = mysqli_fetch_array($result2))
{
?>
        <tr>
        <td class="left"><a href="discussion.php?id=<?php echo $row['id']; ?>"><?php echo htmlentities($row['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
        <td><?php echo $row['reps']-1; ?></td>
        <td><a href="profile.php?id=<?php echo $row['userid']; ?>"><?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
        <td><?php echo date('Y/m/d H:i:s' ,$row['timestamp']); ?></td>
    </tr>
<?php
}
//If there is no read message we notice it
if($rowcount2==0)
{
?>
        <tr>
        <td colspan="4" class="center">You have no read message.</td>
    </tr>
<?php
}
?>
</table>
<?php
}
else
{
        echo 'You must be logged to access this page.';
}
?>
                </div>
        </body>
</html>
                </form>
            </div>
        </body>

        </html>