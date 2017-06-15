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
  
  function emptyElement(x){
	_(x).innerHTML = "";
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
                    <p class="login_items">Welcome, <?php echo htmlspecialchars($log_username, ENT_QUOTES, 'UTF-8'); ?></p>
                    <a href="logout.php">Logout</a>
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
        <form action="afisare_obiect.php" enctype="multipart/form-data"  method="post">
         <div class="form" >
            <h1>Obiect Gasit</h1>
            <span>Object Name: </span> <input type="text" id="name" name="name" placeholder="Enter the name of the found object" size="55" required>
            <br><br>
            <span>Category: </span> <select name="category">
                <option value="">Please select the category of the object</option>
                <option value="Phone">Phone</option>
                <option value="Accesories">Accesories</option>
                <option value="Electronics">Electronics</option>
                <option value="Papers">Papers</option>
                <option value="Keys">Keys</option>
            </select>
            <br><br>
            <span>Producer: </span><input name="producer" type="text" placeholder="Enter the object's producer (if it has any)" size="55">
            <br><br>
            <span>Model: </span><input name="model" type="text" placeholder="Enter the object's model (if it has any)" size="55">
            <br><br>
            <span>Color: </span><input name="color" type="text" placeholder="Enter your object's color" size="55" required>
            <br><br>
<!--
            <span>Picture: </span><input type="text" placeholder="<HERE SHOULD BE AN UPLOAD FUNCTION>" name="uname" size="55" required>
            <br><br>
-->
            <input id="file" name="file" type="file" 
            <span>Lost Location: </span>
            <select name="location">
                <option value="">Please select the location where you lost the object</option>
                <option value="Copou">Copou</option>
                <option value="Tatarasi">Tatarasi</option>
                <option value="Alexandru">Alexandru</option>
                <option value="Baza III">Baza III</option>
                <option value="Nicolina">Nicolina</option>
            </select>
                <br><br>
                <span>Found Date: </span><input name="date" type="date" placeholder="Enter your phone no. -- it will not be made public" size="55" required>
                <br><br><br>
                <button name="foundSubmit" type="submit" value="foundSubmit">Send</button>
            </div>
        </form>
        <span id="status"></span>
    </div>
    </form>
    </div>
</body>

</html>