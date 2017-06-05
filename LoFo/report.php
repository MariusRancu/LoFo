<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
        exit();
    }
 ?>
    <?php

// Apel Ajax
if(isset($_POST["object_name"])){
    // Conecatere la BD
	include_once("php_includes/db_con.php");
    
    //Inserare obiect in tabel
$numeOb = $_POST['object_name'];
$categorie = $_POST['category'];
$producer =$_POST['producer'];
$model = $_POST['model'];
$color = $_POST['color'];
//$poza = $_POST['poza'];
$locatie = $_POST['location'];
$data = $_POST['date'];
$user = $_SESSION["username"];
        
    $sql = mysqli_prepare($db_con,"INSERT INTO objects (`username`, `category`, `obj_name`, `producer`, `model`, `color` , `location`, `data`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	mysqli_stmt_bind_param($sql,'ssssssss', $user, $categorie, $numeOb, $producer, $model, $color, $locatie, $data);
    
    mysqli_stmt_execute($sql);

    if(mysqli_stmt_affected_rows($sql) == 1){
        
		 echo 'Obiect adaugat'; 
         mysqli_stmt_close($sql);  
         exit(); 
	} else {
        
        echo 'Obiectul nu a putut fi adaugat';
        mysqli_stmt_close($sql);
        exit();
    }

    }
   
?>

        <html>

        <head>
            <title>Lost and Found - Marius Râncu şi Nedelcu Răzvan</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
            <script src="js/main.js"></script>
            <script src="js/ajax.js"></script>
            <script>
                function emptyElement(x) {
                    _(x).innerHTML = "";
                }

                function adauga() {
                    var nume = _("object_name").value;
                    var cat = _("category").value;
                    var prod = _("producer").value;
                    var mod = _("model").value;
                    var cul = _("color").value;
                    //var pz = _("poza").value;
                    var loc = _("location").value;
                    var dt = _("date").value;
                    var status = _("status");

                    if (nume == "" || cat == "" || loc == "") {
                        status.innerHTML = "Completati campurile obligatorii ! ";
                    } else {

                        var ajax = ajaxObj("POST", "obiect_pierdut.php");
                        ajax.onreadystatechange = function() {
                            if (ajaxReturn(ajax) == true) {

                                status.innerHTML = ajax.responseText;

                            }
                        }
                        ajax.send("object_name=" + nume + "&category=" + cat + "&producer=" + prod + "&location=" + loc + "&model=" + mod + "&color=" + cul + "&date=" + dt);
                    }
                }
            </script>
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
                <div class="form">
                    <h1>Report Member</h1>
                    <span>Username profile: </span> <input type="text" placeholder="Enter the member's profile/ID/Object that you want to report" name="uname" size="55" required>
                    <br><br>
                    <span>Reason: </span>
                    <select name="reasons">
                <option value="">Please pick a reason for which you report this member</option>
                <option value="scam">Scam</option>
                <option value="vulgar-language">Vulgar Language</option>
                <option value="not-return">Not willing to return lost object</option>
                <option value="no-answer">Doesn't answer</option>
                <option value="bot">Bot</option>
            </select>
                    <br><br>
                    <span>Describe report: </span><input type="text" placeholder="Use a few words to describe the report reason" name="uname" size="55" height="20" required>
                    <br><br>
                    <button id="signupbtn" onclick="signup()">Sign Up</button>
                </div>
            </div>
        </body>

        </html>