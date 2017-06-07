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

if (!$result = mysqli_query($db_con,"SELECT * FROM reported_by WHERE SOLVED IS NULL ORDER BY report_time ASC"))
{
    die("Error: " . mysqli_error($db_con));
}
$rowcount=mysqli_num_rows($result);
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
                    <a href="report.php">REPORT</a> |
                    <a href="my_profile.php">MY PROFILE</a> |
                    <a href="admin_panel.php" class="activ">ADMIN PANEL</a> |
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
            <div class="form">
                <h1>There are <?php echo "$rowcount"; ?> unsolved reports!</h1>
            </div>
            <div class="admin_container">
<table border="3">
  <tr>
    <th>Id</th>
    <th>Reported</th>
    <th>Reason</th>
    <th>Describe</th>
    <th>Reporter</th>
    <th>Date</th>
    <th>Do</th>
  </tr>
<?php
while($row = mysqli_fetch_array($result))
{
?>
  <tr>
    <td><?php  echo $row['report_id'] ?></td>
    <td><?php  echo $row['reported_username'] ?></td>
    <td><?php  echo $row['reason'] ?></td>
    <td><?php  echo $row['described_report'] ?></td>
    <td><?php  echo $row['reported_by'] ?></td>
    <td><?php  echo $row['report_time'] ?></td>
      <td><a href="update.php?id=<?php echo $row['report_id']; ?>" alt="Fondat" style="color: green;margin: auto;">&#10004;</a> <a href="delete.php?id=<?php echo $row['report_id']; ?>" alt="Nefondat" style="color: red;" onclick="return confirm('Esti sigur ca vrei sa-l stergi?')">&#10006;</a></font></td>
  </tr>
<?php
}
mysqli_close($db_con);
?>
</table>
            </div>
        </div>
    </body>

    </html>