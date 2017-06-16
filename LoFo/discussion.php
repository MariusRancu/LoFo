<?php
include_once("php_includes/check_login_status.php");
include_once("php_includes/db_con.php");
?>
        <head>
            <title>Lost and Found - Marius Râncu şi Nedelcu Răzvan</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
    <body>
<?php
//We check if the user is logged
if(isset($_SESSION['username']))
{
//We check if the ID of the discussion is defined
if(isset($_GET['id']))
{
$id = intval($_GET['id']);
//We get the title and the narators of the discussion
$req1 = mysqli_query($db_con, 'select title, user1, user2 from pm where id="'.$id.'" and id2="1"');
$dn1 = mysqli_fetch_array($req1);
//We check if the discussion exists
if(mysqli_num_rows($req1)==1)
{
//We check if the user have the right to read this discussion
if($dn1['user1']==$log_user_id or $dn1['user2']==$log_user_id)
{
//The discussion will be placed in read messages
if($dn1['user1']==$log_user_id)
{
        mysqli_query($db_con, 'update pm set user1read="yes" where id="'.$id.'" and id2="1"');
        $user_partic = 2;
}
else
{
        mysqli_query($db_con, 'update pm set user2read="yes" where id="'.$id.'" and id2="1"');
        $user_partic = 1;
}
//We get the list of the messages
$req2 = mysqli_query($db_con, 'select pm.timestamp, pm.message, users.user_id as userid, users.username from pm, users where pm.id="'.$id.'" and users.user_id=pm.user1 order by pm.id2');
//We check if the form has been sent
if(isset($_POST['message']) and $_POST['message']!='')
{
        $message = $_POST['message'];
        //We remove slashes depending on the configuration
        if(get_magic_quotes_gpc())
        {
                $message = stripslashes($message);
        }
        //We protect the variables
        $message = $db_con->real_escape_string(nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
        //We send the message and we change the status of the discussion to unread for the recipient
        if(mysqli_query($db_con, 'insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "'.(intval(mysqli_num_rows($req2))+1).'", "", "'.$log_user_id.'", "", "'.$message.'", "'.time().'", "", "")') and mysqli_query($db_con, 'update pm set user'.$user_partic.'read="yes" where id="'.$id.'" and id2="1"'))
        {
?>
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
                            &#9830; <a href="messages.php">My messages</a>
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
                <div class="form">
                <h1>Your message has been sent.</h1>
                    <center>
                        <a href="#" onclick="goBack()">Go Back</a>
                    </center>

<script>
function goBack() {
    window.history.back();
}
</script>

</div>
<?php
        }
        else
        {
?>
<div class="message">An error occurred while sending the message.<br />
<a href="discussion.php?id=<?php echo $id; ?>">Go to the discussion</a></div>
<?php
        }
}
else
{
//We display the messages
?>
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
                            &#9830; <a href="messages.php">My messages</a>
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
                <div class="form">
                <h1><?php echo $dn1['title']; ?></h1>
                    <table class="messages_table">
            <tr>
                <th class="author">User</th>
                    <th>Message</th>
                </tr>
<?php
while($dn2 = mysqli_fetch_array($req2))
{
?>
        <tr>
        <td class="author center"><?php
?><br /><?php echo $dn2['username']; ?></td>
        <td class="left"><div class="date">Sent: <?php echo date('m/d/Y H:i:s' ,$dn2['timestamp']); ?></div>
        <?php echo $dn2['message']; ?></td>
    </tr>
<?php
}
//We display the reply form
?>
</table><br/>
</div>
                <div class="reply">
                    <form action="discussion.php?id=<?php echo $id; ?>" method="post">
        <textarea cols="40" rows="5" name="message" id="message" placeholder="Write a message"></textarea>
                        <br>
        <input type="submit" value="Send" onClick="window.location.reload()"/>
                        </div>
    </form>
<?php
}
}
else
{
        echo '<div class="message">You dont have the rights to access this page.</div>';
}
}
else
{
        echo '<div class="message">This discussion does not exists.</div>';
}
}
else
{
        echo '<div class="message">The discussion ID is not defined.</div>';
}
}
else
{
        echo '<div class="message">You must be logged to access this page.</div>';
}
?>
        </body>
</html>