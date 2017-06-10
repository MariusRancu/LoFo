<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
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
            function sendMessage(objId){
                    var ajax = ajaxObj("POST", "new_message.php");
                    ajax.onreadystatechange = function() {
                        if(ajaxReturn(ajax) == true) {
                            window.location="new_message.php";
                        }
                    }
                    ajax.send("useridToSend=" + objId);
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
            <div class="search_form">
<?php
    include_once("php_includes/db_con.php");

    $name = $_POST['name'];
    $category = $_POST['category']; 
    $producer = $_POST['producer']; 
    $model = $_POST['model'];
    $color = $_POST['color'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $username = $_SESSION["username"];

    $filename = $_FILES["file"]["name"];
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file"]["size"];
	$allowed_file_types = array('.jpg', '.png');	


    //Prepare query depending on the page that sends the data
    if(isset($_POST['foundSubmit'])){
        $sql5 = mysqli_prepare($db_con, "SELECT id, username, category, obj_name, producer, model, color, picture, picture_location, location, data FROM objects WHERE category = ? AND obj_name = ? AND color = ? AND location = ? AND is_verified=1 AND status = 0");

        //Verify if object is already added
        $sql2 = mysqli_prepare($db_con, "SELECT * FROM found_objects WHERE category = ? AND obj_name = ? AND color = ? AND location = ? AND is_verified=1");
        mysqli_stmt_bind_param($sql2, 'ssss', $category, $name, $color, $location);
        mysqli_stmt_execute($sql2);
        $sql2->store_result();
        $nr_rezultate = $sql2->num_rows;
        mysqli_stmt_close($sql2);
        
        if($nr_rezultate == 0){
            if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000000))
	        {	
                // Rename file
                $newfilename = md5($file_basename) . $file_ext;
                if (file_exists("upload/" . $newfilename))
                {
                    // file already exists error
                    echo "You have already uploaded this file.";
                }
                else
                {		
                    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfilename);
                    echo "File uploaded successfully.";

                    //$null = NULL;
                    $picture_location = "upload/" . $newfilename;
                    $sql3 = mysqli_prepare($db_con, "INSERT INTO found_objects (`username`, `category`, `obj_name`, `producer`, `model`, `color`, `location`, `picture_location`, `data`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    mysqli_stmt_bind_param($sql3, 'sssssssss', $username, $category, $name, $producer, $model, $color, $location, $picture_location, $date);
                    
                    mysqli_stmt_execute($sql3);

                    //$objId = $sql3->insert_id;

                    mysqli_stmt_close($sql3);

                    /*$sql1 = mysqli_prepare($db_con, "UPDATE found_objects SET `picture`=? WHERE id=?");
                    mysqli_stmt_bind_param($sql1, 'bi', $null, $objId);
                    $sql1->send_long_data(0, file_get_contents("upload/" . $newfilename));

                    mysqli_stmt_execute($sql1);

                    mysqli_stmt_close($sql1); */


                }
            }
            elseif ($filesize > 2000000)
            {	
                // file size error
                echo "The file you are trying to upload is too large.";
            }
            else
            {
                // file type error
                echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
                unlink($_FILES["file"]["tmp_name"]);
            }  
        }
    }

     if(isset($_POST['lostSubmit'])){
        $sql5 = mysqli_prepare($db_con, "SELECT id, username, category, obj_name, producer, model, color, picture, picture_location, location, data FROM found_objects WHERE category = ? AND obj_name = ? AND color = ? AND location = ? AND is_verified=1 AND status=0");

        //Verify if object is already added
        $sql2 = mysqli_prepare($db_con, "SELECT * FROM objects WHERE category = ? AND obj_name = ? AND color = ? AND location = ?");
        mysqli_stmt_bind_param($sql2, 'ssss', $category, $name, $color, $location);
        mysqli_stmt_execute($sql2);
        $sql2->store_result();
        $nr_rezultate = $sql2->num_rows;
        mysqli_stmt_close($sql2);

        if($nr_rezultate == 0){
            if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000000))
	        {	
                // Rename file
                $newfilename = md5($file_basename) . $file_ext;
                if (file_exists("upload/" . $newfilename))
                {
                    // file already exists error
                    echo "You have already uploaded this file.";
                }
                else
                {		
                    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfilename);
                    echo "File uploaded successfully.";
                    //$null = NULL;
                    $picture_location = "upload/" . $newfilename;
                    $sql3 = mysqli_prepare($db_con, "INSERT INTO objects (`username`, `category`, `obj_name`, `producer`, `model`, `color`, `location`, `data`, `picture_location`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    mysqli_stmt_bind_param($sql3, 'sssssssss', $username, $category, $name, $producer, $model, $color, $location, $date, $picture_location);
                    
                    mysqli_stmt_execute($sql3);

                    //$objId = $sql3->insert_id;

                    mysqli_stmt_close($sql3);

                    /*$sql1 = mysqli_prepare($db_con, "UPDATE objects SET `picture`=? WHERE id=?");
                    mysqli_stmt_bind_param($sql1, 'bi', $null, $objId);
                    $sql1->send_long_data(0, file_get_contents("upload/" . $newfilename));

                    mysqli_stmt_execute($sql1);
                    mysqli_stmt_close($sql1);*/


                }
            }
            elseif ($filesize > 2000000)
            {	
                // file size error
                echo "The file you are trying to upload is too large.";
            }
            else
            {
                // file type error
                echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
                unlink($_FILES["file"]["tmp_name"]);
            }  
        }
    }

	 mysqli_stmt_bind_param($sql5, 'ssss', $category, $name, $color, $location);

     mysqli_stmt_execute($sql5);

     $sql5->store_result();
     $nr_rezultate = $sql5->num_rows;

     $sql2 = mysqli_prepare($db_con,"SELECT last_name, first_name, email, phone_number FROM users WHERE username = ?");
     mysqli_stmt_bind_param($sql2,'s',$username);
     mysqli_stmt_execute($sql2);
     $sql2->bind_result($last_name, $first_name, $email, $phone);
     $sql2->fetch();
     mysqli_stmt_close($sql2);

     if($nr_rezultate > 0){
        $sql5->bind_result($d_id, $d_username, $d_category, $d_name, $d_producer, $d_model, $color, $d_pic, $d_pic_location, $d_loc, $d_date);
        
        while ($sql5->fetch()) {
            echo"
            <div class=\"search_container\">
            <div class=\"search_left\">
                        <img src=". $d_pic_location ." height=\"150\" />   
                        </div>
                        <div class=\"search_right\">
                            <div class=\"search_ob_details\">
                                <br><span class=\"ob_field\">Object Name:</span><span class=\"ob_field\"> ". $d_name ."</span>
                                <br><span class=\"ob_field\">Category:</span><span class=\"ob_field\"> ". $d_category ."</span>
                                <br><span class=\"ob_field\">Producer:</span><span class=\"ob_field\"> ". $d_producer ."</span>
                                <br><span class=\"ob_field\">Model:</span><span class=\"ob_field\"> ". $d_model ."</span>
                                <br><span class=\"ob_field\">Color:</span><span class=\"ob_field\"> ". $color ."</span>
                                <br><span class=\"ob_field\">Found location:</span><span class=\"ob_field\"> ". $d_loc ."</span>
                                <br><span class=\"ob_field\">Found Date:</span><span class=\"ob_field\"> ". $d_date ."</span>
                            </div>
                            <span>
                            <div class=\"search_ob_contact\">
                                <br>
                                    <div class=\"ob_contact\">
                                    <span id=\"spoiler\" style=\"display:none\">".$phone."</span>
                                    <input type=\"submit\" title=\"Click to show/hide content\" type=\"button\" onclick=\"if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}\" value=\"Show phone number\"></input>
                                    </div>
                                <br>
                                    <button class=\"ob_contact_username\" onclick=\"sendMessage($d_id)\">Send: ".$d_username." a private message</button>
                        </div>
            ";
        } 
        }else 
            echo "Nu a fost gasit nici un obiect";
        $sql5->close();
?>
                

                    </span>
                </div>
            </div>
        </div>
        </div>
    </body>

    </html>