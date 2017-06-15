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

if (!$result = mysqli_query($db_con, 'SELECT * FROM found_objects WHERE username="'.$log_username.'" AND status=0 ORDER BY data ASC'))
{
    die("Error: " . mysqli_error($db_con));
}

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
                <div class="login">
                    <div class="login_items">
                        <span class="login_items">Welcome, <a href="./my_profile.php"><?php echo htmlspecialchars($log_username, ENT_QUOTES, 'UTF-8'); ?></a>!
                            <a href="logout.php" style="color: red; position: relative; float: right; right: 10px;top: 45px;">Logout</a></span>
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
    <th>Object Name</th>
    <th>Category</th>
    <th>Producer</th>
    <th>Model</th>
    <th>Color</th>
    <th>Location</th>
    <th>Date</th>
    <th>Verify</th>
  </tr>
<?php
while($row = mysqli_fetch_array($result))
{
?>
  <tr>
    <td><?php  echo $row['username'] ?></td>
    <td><?php  echo $row['category'] ?></td>
    <td><?php  echo $row['obj_name'] ?></td>
    <td><?php  echo $row['producer'] ?></td>
    <td><?php  echo $row['model'] ?></td>
    <td><?php  echo $row['color'] ?></td>
    <td><?php  echo $row['location'] ?></td>
    <td><?php  echo $row['data'] ?></td>
    <td>
        <button onclick="accept(<?php echo $row['id']?>)" alt="Fondat" style="color: green;margin: auto;">I've returned it</a>
    </td>
  </tr>
  <?php } 
  mysqli_close($db_con);
?>
</table>
       </div>
        </div>
    </body>

    </html>