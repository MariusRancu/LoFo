<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
    exit();
    }

include_once("php_includes/db_con.php");
if (mysqli_connect_errno())
{
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

if (!$result = mysqli_query($db_con, 'SELECT * FROM lost_objects WHERE username="'.$log_username.'" AND status=0 ORDER BY data ASC'))
{
    die("Error: " . mysqli_error($db_con));
}

if(isset($_POST["acceptId"])){
    $accId =  $_POST["acceptId"];    
    $sql = mysqli_prepare($db_con, "UPDATE lost_objects SET status=1 WHERE id=?");
    mysqli_stmt_bind_param($sql,'i', $accId);
    mysqli_stmt_execute($sql);

    $sql->close();

    exit();
}

?>
<html>

    <head>
        <title>Lost and Found - Marius Râncu şi Nedelcu Răzvan</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/main.js"></script>
        <script src="js/ajax.js"></script>
        <script>
            function accept(id){
                var ajax = ajaxObj("POST", "my_lost_objects.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        location.reload();
                    }
                }
                ajax.send("acceptId=" + id);
                
        }
        </script>
        <body>
        <div class="header_menu">
            <div class="menu_content">
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
        </div>
        <div class="banner_bg">
            <div class="banner_itself">
                <div class="slogan">
                    <div class="big_text">L O F O</div>
                    <div class="little_text">Lost & Found V4.0.1 BETA</div>
                </div>
                <div class="login">
                    <div class="login_items">
                        <span class="login_items">Welcome, <a href="./my_profile.php"><?php echo htmlspecialchars($log_username, ENT_QUOTES, 'UTF-8'); ?></a>!
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
            <div class="admin_container">
<h2>My lost objects </h2>            
<table border="3">
  <tr>
    <th>User</th>
    <th>Category</th>
    <th>Description</th>
    <th>Verification status</th>
    <th>Action</th>
<?php
while($row = mysqli_fetch_array($result))
{
?>
  <tr>
    <td><?php  echo $row['username'] ?></td>
    <td><?php  echo $row['category'] ?></td>
    <td><?php  echo $row['description'] ?></td>
    <td><?php  if($row['is_verified'] == 0) echo "Unverified"; if($row['is_verified'] == 1) echo "Accepted"; if($row['is_verified'] == 2) echo "Refused";?></td>
    <?php if($row['is_verified'] == 1) : ?>
    <td>
        <button onclick="accept(<?php echo $row['id']?>)" alt="Fondat" style="color: green;margin: auto;">I've returned it</a>
    </td>
    <?php endif; ?>
  </tr>
  <?php } 
  mysqli_close($db_con);
?>
</table>
       </div>
        </div>
    </body>

    </html>