<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
        exit();
    }

$stmt = mysqli_prepare($db_con, 'SELECT id, username, category, description, is_verified FROM found_objects WHERE username=? AND status=0 ORDER BY data ASC');

mysqli_stmt_bind_param($stmt, "s", $log_username);

mysqli_stmt_execute($stmt);

mysqli_stmt_bind_result($stmt, $id, $user, $category, $description, $is_verified);

if(isset($_POST["acceptId"])){
    $accId =  $_POST["acceptId"];    
    $sql = mysqli_prepare($db_con, "UPDATE found_objects SET status=1 WHERE id=?");
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
                var ajax = ajaxObj("POST", "my_found_objects.php");
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
                <div class="menu_items">
                        <a href="index.php">HOME</a> |
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
<h2>My found objects </h2>            
<table border="3">
  <tr>
    <th>User</th>
    <th>Category</th>
    <th>Object Name</th>
    <th>Verification status</th>
    <th>Action</th>
  </tr>
<?php
while(mysqli_stmt_fetch($stmt))
{
?>
  <tr>
    <td><?php  echo $user ?></td>
    <td><?php  echo $category ?></td>
    <td><?php  echo $description ?></td>
    <td><?php  if($is_verified == 0) echo "Unverified"; if($is_verified == 1) echo "Accepted"; if($is_verified == 2) echo "Refused";?></td>
    <?php if($is_verified == 1) : ?>
    <td>
        <button onclick="accept(<?php echo $id?>)" alt="Fondat" style="color: green;margin: auto;">I've returned it</a>
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