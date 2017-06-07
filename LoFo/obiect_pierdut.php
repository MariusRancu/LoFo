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

    $sql1 = mysqli_prepare($db_con, "SELECT username, category, obj_name, producer, model, color, picture, location, data FROM found_objects WHERE category = ? AND obj_name = ? AND color = ? AND location = ?");
     mysqli_stmt_execute($sql1);

     $sql1->store_result();
     $nr_rezultate = $sql1->num_rows;

     if($nr_rezultate > 0){
         echo 'Object found';
     }
        
    $sql = mysqli_prepare($db_con, "INSERT INTO objects (`username`, `category`, `obj_name`, `producer`, `model`, `color`, `location`, `data`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	mysqli_stmt_bind_param($sql,'ssssssss', $user, $categorie, $numeOb, $producer, $model, $color, $locatie, $data);
    
    mysqli_stmt_execute($sql);

    if(mysqli_stmt_affected_rows($sql) == 1){
        
		 echo 'Object added'; 
         mysqli_stmt_close($sql);  
         exit(); 
	} else {
        
        echo 'Object could not be added';
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
        function emptyElement(x){
            _(x).innerHTML = "";
    }
    
        function adauga(){
            var nume = _("object_name").value;
            var cat= _("category").value;
            var prod = _("producer").value;
            var mod = _("model").value;
            var cul = _("color").value;
            //var pz = _("poza").value;
            var loc = _("location").value;
            var dt = _("date").value;
            var status = _("status");
            
            if(nume == "" || cat == "" || loc == ""){
                status.innerHTML = "Completati campurile obligatorii ! ";
            }  else {
                
                var ajax = ajaxObj("POST", "obiect_pierdut.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        if(ajax.responseText == "Object found"){
                            document.location = "afisare_obiect.php?name=" + name + "&category=" + cat + "&producer=" + prod + "&model=" + mod + "&color=" + col + "&location=" + loc + "&date=" + date + "&source=lost";
                        }
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
                <a href="report.php">REPORT</a> |
                <a href="my_profile.php" >MY PROFILE</a> |
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
        <form class="form" onsubmit="return false;">
            <h1>Obiect Pierdut</h1>
            <span>Object Name: </span> <input type="text" id="object_name" placeholder="Enter the name of the found object" size="55" required>
            <br><br>
            <span>Category: </span> <select id="category">
                <option value="">Please select the category of the object</option>
                <option value="Phone">Phone</option>
                <option value="Accesories">Accesories</option>
                <option value="Electronics">Electronics</option>
                <option value="Papers">Papers</option>
                <option value="Keys">Keys</option>
            </select>
            <br><br>
            <span>Producer: </span><input id="producer" type="text" placeholder="Enter the object's producer (if it has any)" size="55">
            <br><br>
            <span>Model: </span><input id="model" type="text" placeholder="Enter the object's model (if it has any)" size="55">
            <br><br>
            <span>Color: </span><input id="color" type="text" placeholder="Enter your object's color" size="55" required>
            <br><br>
<!--
            <span>Picture: </span><input type="text" placeholder="<HERE SHOULD BE AN UPLOAD FUNCTION>" name="uname" size="55" required>
            <br><br>
-->
            <span>Found Location: </span>
            <select id="location">
                <option value="">Please select the location where you lost the object</option>
                <option value="Copou">Copou</option>
                <option value="Tatarasi">Tatarasi</option>
                <option value="Alexandru">Alexandru</option>
                <option value="Baza III">Baza III</option>
                <option value="Nicolina">Nicolina</option>
            </select>
            <br><br>
            <span>Found Date: </span><input id="date" type="date" placeholder="Enter your phone no. -- it will not be made public" size="55" required>
            <!--
            <br><br>
                    <span>CNP: </span><input type="text" placeholder="Enter your CNP -- it will not be made public" name="uname" size="55" required>
-->
            <br><br><br>
            <button id="button" onclick="adauga()">Send</button>
            <span id="status"></span>
        </form>
    </div>
</body>

</html>