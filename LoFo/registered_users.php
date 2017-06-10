 <?php
 include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
    exit();
    }
    
    if (!$result = mysqli_query($db_con,"SELECT user_id, username, last_name, first_name, email, address, phone_number, role FROM users"))
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
                <div class="login">
                    <div class="login_items">
                        <span class="login_items">Welcome, <a href="./my_profile.php"><?php echo $log_username; ?></a>!
                            <a href="logout.php" style="color: red; position: relative; float: right; right: 10px;top: 45px;">Logout</a></span>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="container">
            <div class="form">
                <h1>There are <?php echo "$rowcount"; ?> Registered users!</h1>
            </div>
            <div class="admin_container">
<h2>Lost objects </h2>            
<table border="3">
  <tr>
    <th>Id</th>
    <th>Username</th>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Email</th>
    <th>Address</th>
    <th>Phone Number</th>
    <th>Role</th>
  </tr>
<?php
while($row = mysqli_fetch_array($result))
{
?>
  <tr>
    <td><?php  echo $row['user_id'] ?></td>
    <td><?php  echo $row['username'] ?></td>
    <td><?php  echo $row['last_name'] ?></td>
    <td><?php  echo $row['first_name'] ?></td>
    <td><?php  echo $row['email'] ?></td>
    <td><?php  echo $row['address'] ?></td>
    <td><?php  echo $row['phone_number'] ?></td>
    <td><?php if($row['role'] == 0) echo "User"; else echo "Admin"; ?></td>
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