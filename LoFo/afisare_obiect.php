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
    </head>

    <body>
        <div class="header_menu">
            <div class="menu_content">
                <div class="menu_items">
                    <a href="index.php">HOME</a> |
                    <a href="signup.php">SIGN UP</a> |
                    <a href="report.php" class="activ">REPORT</a> |
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
                <h1>Results for your search: //INSERT_SEARCH_HERE// </h1>
                <?php
include_once("php_includes/db_con.php");

$name = $_GET['name'];
$category = $_GET['category']; 
$producer = $_GET['producer']; 
$model = $_GET['model'];
$color = $_GET['color'];
$location = $_GET['location'];
$date = $_GET['date'];
$username = $_SESSION["username"];
$source = $_GET['source'];

//Preluare informatii obiect
if($source == 'found'){
     $sql = mysqli_prepare($db_con, "SELECT username, category, obj_name, producer, model, color, picture, location, data FROM objects WHERE category = ? AND obj_name = ? AND color = ? AND location = ?");
     
     $sql1 = mysqli_prepare($db_con, "INSERT INTO found_objects (`username`, `category`, `obj_name`, `producer`, `model`, `color` , `location`, `data`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
     mysqli_stmt_bind_param($sql1, 'ssssssss', $username, $category, $numeOb, $producer, $model, $color, $location, $data);
     
     mysqli_stmt_execute($sql1);
}

if($source == 'lost'){
    $sql = mysqli_prepare($db_con, "SELECT username, category, obj_name, producer, model, color, picture, location, data FROM found_objects WHERE category = ? AND obj_name = ? AND color = ? AND location = ?");
}
	 mysqli_stmt_bind_param($sql, 'ssss', $category, $name, $color, $location);
     mysqli_stmt_execute($sql);

     $sql->store_result();
     $nr_rezultate = $sql->num_rows;

     $sql2 = mysqli_prepare($db_con,"SELECT last_name, first_name, email, phone_number FROM users WHERE username = ?");
     mysqli_stmt_bind_param($sql2,'s',$username);
     mysqli_stmt_execute($sql2);
     $sql2->bind_result($last_name, $first_ane, $email, $phone);
     $sql2->fetch();

     if($nr_rezultate > 0){
        $sql->bind_result($d_username, $d_category, $d_name, $d_producer, $d_model, $color, $d_pic, $d_loc, $d_date);
        
        while ($sql->fetch()) {
            echo"
            
            <div class=\"search_container\">
                        
                        <img src=\"https://i1.wp.com/blogdecasa.ro/wp-content/uploads/2016/04/Tigaie-Tefal-Character-30-cm.jpg\" class=\"search_img\">
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
                                    <div class=\"ob_contact_username\">Send: ".$d_username." a private message</div>
                        </div>
            ";
        } 
        }else 
            echo "Nu a fost gasit nici un obiect";
        $sql->close();
?>
                

                    </span>
                </div>
            </div>
        </div>
        </div>
    </body>

    </html>