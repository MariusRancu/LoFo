<?php
include_once("php_includes/check_login_status.php");
include_once("php_includes/functions.php");

if($user_ok == false)
    {
        header("location: signup.php");
        exit();
    }
 ?>

    <html>

    <head>
        <title>Results</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/main.js"></script>
        <script src="js/ajax.js"></script>
        <script>
            function sendMessage(userId){
                    var ajax = ajaxObj("POST", "new_message.php");
                    ajax.onreadystatechange = function() {
                        if(ajaxReturn(ajax) == true) {
                            window.location="new_message.php";
                        }
                    }
                    ajax.send("useridToSend=" + userId);
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
        <div class="search_form">
<?php

    $category = $_POST['category']; 
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    if(isset($_POST['location'])){
        $found_location = $_POST['location'];
    }else{
        $found_location = "";
    }

    if(isset($_POST['date'])){
        $found_date = $_POST['date'];
    }else{
        $found_date = "";
    }

    $tags = array_filter(explode(" ", $description), "filter_tags");
    $tags = array_map("sanitize_tag", $tags);
    $picture_location = "";

    if(!empty($_FILES)){
        $filename = $_FILES["file"]["name"];
        $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
        $file_ext = substr($filename, strripos($filename, '.')); // get file name
        $filesize = $_FILES["file"]["size"];
        $allowed_file_types = array('.jpg', '.png');	
        $newfilename = "";

        if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000000))
        {	
            // Rename file
            $newfilename = bin2hex(random_bytes(16)) . $file_ext;
           
           //upload file
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfilename);

            $picture_location = "upload/" . $newfilename;
                
        }
    }
    
    //Prepare query depending on the page that sends the data
    if(isset($_POST['foundSubmit'])){
        
        //insert description and category to lost objects
        $sql = mysqli_prepare($db_con, "INSERT INTO found_objects (username, category, description, picture_location, location, data) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($sql, 'ssssss', $log_username, $category, $description, $picture_location, $found_location, $found_date);

        mysqli_stmt_execute($sql);

        $obj_id = mysqli_insert_id($db_con);

        mysqli_stmt_close($sql); 

        foreach($tags as $tag){
            $sql1 = mysqli_prepare($db_con, "INSERT INTO found_ob_tags (obj_id, tag) VALUES(?, ?)");
            mysqli_stmt_bind_param($sql1, 'is', $obj_id, $tag);
            mysqli_stmt_execute($sql1);
        }

        mysqli_stmt_close($sql1);        

        //prepare query for results
        $regex_tags = implode('|', $tags);

        $query = "SELECT lo.username, users.phone_number, users.email, users.user_id, ltags.obj_id, lo.description,  lo.picture_location, COUNT(ltags.obj_id)
            FROM lost_objects lo JOIN lost_ob_tags ltags on lo.id = ltags.obj_id JOIN users ON lo.username = users.username
            WHERE ltags.tag REGEXP ? GROUP BY ltags.obj_id";

        $sql = mysqli_prepare($db_con, $query);
	    mysqli_stmt_bind_param($sql, 's', $regex_tags);     

        mysqli_stmt_execute($sql);
        mysqli_stmt_bind_result($sql, $d_username, $phone, $email, $d_id, $obj_id, $description, $d_pic_location, $matched_tags);

        $something_found = false;
            
        while (mysqli_stmt_fetch($sql)){
            if($matched_tags > 2){
                $something_found = true;
                ?>
            <div class="search_container">
            <div class="search_left">
                        <img src= "<?php echo $d_pic_location ?>"height="150" />   
                        </div>
                        <div class="search_right">
                            <div class="search_ob_details">
                                <br><span class="ob_field">Object description:</span><span class="ob_field"><?php echo $description ?></span>
                            </div>
                            <span>
                            <div class="search_ob_contact">
                                <br>
                                    <div class="ob_contact">
                                    <span id="spoiler" style="display:none"><?php echo $phone ?></span>
                                    <input type="submit" title="Click to show/hide content" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}" value="Show phone number"></input>
                                    </div>
                                <br>
                                    <button class="ob_contact_username" onclick="sendMessage(<?php echo $d_id ?>)">Send: <?php echo $d_username ?> a private message</button>
                        </div>
            <?php
            }
        }     
    }

     if(isset($_POST['lostSubmit'])){
        //insert description and category to lost objects
        $sql = mysqli_prepare($db_con, "INSERT INTO lost_objects (username, category, description, picture_location) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($sql, 'ssss', $log_username, $category, $description, $picture_location);

        mysqli_stmt_execute($sql);

        $obj_id = mysqli_insert_id($db_con);

        mysqli_stmt_close($sql); 

        foreach($tags as $tag){
            $sql1 = mysqli_prepare($db_con, "INSERT INTO lost_ob_tags (obj_id, tag) VALUES(?, ?)");
            mysqli_stmt_bind_param($sql1, 'is', $obj_id, $tag);
            mysqli_stmt_execute($sql1);
        }

        mysqli_stmt_close($sql1);        

        //prepare query for results
        $regex_tags = implode('|', $tags);

        $query = "SELECT lo.username, users.phone_number, users.email, users.user_id, ltags.obj_id, lo.description,  lo.picture_location, COUNT(ltags.obj_id), lo.location, lo.data 
            FROM found_objects lo JOIN found_ob_tags ltags on lo.id = ltags.obj_id JOIN users ON lo.username = users.username
            WHERE  ltags.tag REGEXP ? GROUP BY ltags.obj_id";

        $sql = mysqli_prepare($db_con, $query);
	    mysqli_stmt_bind_param($sql, 's', $regex_tags); 

        mysqli_stmt_execute($sql);
        mysqli_stmt_bind_result($sql, $d_username, $phone, $email, $d_id, $obj_id, $description, $d_pic_location, $matched_tags, $d_location, $d_date);

        $something_found = false;
            
        while (mysqli_stmt_fetch($sql)){
            if($matched_tags > 2){
                $something_found = true;
                ?>
            <div class="search_container">
            <div class="search_left">
                        <img src= "<?php echo $d_pic_location ?>"height="150" />   
                        </div>
                        <div class="search_right">
                            <div class="search_ob_details">
                                <br>
                                <span class="ob_field">Object description:</span><span class="ob_field"><?php echo $description ?></span>
                                <br>
                                <?php if($d_location != "") : ?>
                                    <span class="ob_field">Found location:</span><span class="ob_field"><?php echo $d_location ?></span>
                                <?php endif; ?>
                                <br>
                                <?php if($d_date != "") : ?>
                                    <span class="ob_field">Found date:</span><span class="ob_field"><?php echo $d_date ?></span>
                                <?php endif; ?>
                                <br>
                            </div>
                            <span>
                            <div class="search_ob_contact">
                                <br>
                                    <div class="ob_contact">
                                    <span id="spoiler" style="display:none"><?php echo $phone ?></span>
                                    <input type="submit" title="Click to show/hide content" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}" value="Show phone number"></input>
                                    </div>
                                <br>
                                    <button class="ob_contact_username" onclick="sendMessage(<?php echo $d_id ?>)">Send: <?php echo $d_username ?> a private message</button>
                        </div>
            <?php
            }
        } 
             
    }

        if($something_found = false){
            echo "No object found matching the description";
        }

        mysqli_stmt_close($sql);
?>
                

                    </span>
                </div>
            </div>
        </div>
        </div>
    </body>

    </html>