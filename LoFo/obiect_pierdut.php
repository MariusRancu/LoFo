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
    
        function adauga(){
            var name = _("object_name").value;
            var cat= _("category").value;
            var prod = _("producer").value;
            var mod = _("model").value;
            var col = _("color").value;
            //var pz = _("poza").value;
            var loc = _("location").value;
            var dt = _("date").value;
            var status = _("status");
            
            if(cat == "" || loc == ""){
                status.innerHTML = "Completati campurile obligatorii ! ";
            }  else {
                document.location = "afisare_obiect.php?name=" + name + "&category=" + cat + "&producer=" + prod + "&model=" + mod + "&color=" + col + "&location=" + loc + "&date=" + date + "&source=lost";
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
        <form onsubmit="return false;">
         <div class="form" >
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
                <br><br><br>
                <button onclick="adauga()">Send</button>
            </div>
        </form>
        <span id="status"></span>
    </div>
</body>

</html>