<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
        exit();
    }
 ?>
 <?php

$form = true;
$otitle = '';
$orecip = '';
$omessage = '';

//We check if the form has been sent
if(isset($_POST['title'], $_POST['recip'], $_POST['message']))
{
        $otitle = $_POST['title'];
        $orecip = $_POST['recip'];
        $omessage = $_POST['message'];
        //We remove slashes depending on the configuration
        if(get_magic_quotes_gpc())
        {
                $otitle = stripslashes($otitle);
                $orecip = stripslashes($orecip);
                $omessage = stripslashes($omessage);
        }
        //We check if all the fields are filled
    
        if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='')
        {
                //We protect the variables
                $title = $db_con->real_escape_string($otitle);
                $recip =  $db_con->real_escape_string($orecip);
                $message =  $db_con->real_escape_string((nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8'))));
                //We check if the recipient exists
                if (!$result = mysqli_query($db_con,'select count(user_id) as recip, user_id as recipid, (select count(*) from pm) as npm from users where username="'.$recip.'"'))
{
    die("Error: " . mysqli_error($db_con));
}
            $rowcount=mysqli_num_rows($result);
            while($row = mysqli_fetch_array($result))
{
    $recip_q = $row['recip'];
    $recipid_q = $row['recipid'];
    $npm_q = $row['npm'];
}
                if($recip_q==1)
                {
                        //We check if the recipient is not the actual user
                        if($recipid_q != $log_user_id)
                        {
                                $id = $npm_q+1;
                                //We send the message
                            $insert = mysqli_query($db_con, 'INSERT INTO pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read) VALUES ("'.$id.'", "1", "'.$title.'", "'.$log_user_id.'", "'.$recipid_q.'", "'.$message.'", "'.time().'", "yes", "no")');
                                if($insert)
                                {
?>
        <head>
            <title>Lost and Found - Marius Râncu şi Nedelcu Răzvan</title>
            <link rel="stylesheet" type="text/css" href="./css/style.css">
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
                <form class="form" onsubmit="return false;">
                    <br>
                    <div class="message">The message has successfully been sent.<br />
                    <a href="messages.php">List of my Personal messages</a></div>
                </form>
                </body>
        <?php
                                        $form = false;
                                }
                                else
                                {
                                        $error = 'An error occurred while sending the message';
                                }
                        }
                        else
                        {
                                $error = 'You cannot send a message to yourself.';
                        }
                }
                else
                {
                        $error = 'The recipient does not exists.';
                }
        }
        else
        {
                $error = 'A field is empty. Please fill of the fields.';
        }
}
elseif(isset($_GET['recip']))
{

        $orecip = $_GET['recip'];
}
if($form)
{

?>

        <html>

        <head>
            <title>Lost and Found - Marius Râncu şi Nedelcu Răzvan</title>
            <link rel="stylesheet" type="text/css" href="./css/style.css">
        </head>

        <body>
            <div class="header_menu">
                <div class="menu_content">
                    <div class="menu_items">
                        <a href="index.php">HOME</a> |
                        <a href="signup.php">SIGN UP</a> |
                        <a href="report.php">REPORT</a> |
                        <a href="my_profile.php">MY PROFILE</a> |
                        <?php if($user_role == true) : ?>
                        <a href="admin_panel.php">ADMIN PANEL</a> |
                        <?php endif; ?>
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
                <form class="form" action="new_message.php" method="post">
                    <h1>Send a new PM</h1>
                    <?php 
 if(isset($error))
{
        echo '<div class="message_eroare">'.$error.'</div>';
}
 ?>
                    <span>Titlu </span><input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="title" size="55"  /><br><br>
                    <span>Username: </span><input type="text" value="<?php
                         if(isset($_POST['useridToSend'])){
                            echo $_POST['useridToSend'];
                        }else   
                            echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); 
                     ?>" id="recip" name="recip"  size="55"  /><br><br>
                   <span>Message: </span> <textarea cols="57" rows="5" id="message" name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <input type="submit" value="Send" />
                </form>
            </div>
        <<?php
}
?>
</body>

</html>