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

function tagsDisplay(e){
         var tags = _("tagsInput").value.split(" ");
         var tagsCount = 0;
         var selectedCategory = _("categ").value;
         filteredTags = tags.filter(tag=>tag.length > 1 &&(tag !="sau" || tag != "cum" || tag != "pai" || tag != "sunt"));
         tagsCount = filteredTags.length
        _("tags_status").textContent = tagsCount;

        if(tagsCount > 2 && selectedCategory != "" )
            _("foundSubmit").disabled=false;
        else
            _("foundSubmit").disabled=true;    


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
                            &#9830; <a href="messages.php">My messages ( <?php echo $rowcount1; ?> )</a>
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
        <form action="afisare_obiect.php" enctype="multipart/form-data"  method="post">
         <div class="form" >
            <h1>Found object</h1>
             <span>Category: </span> <select id="categ"name="category" onblur="tagsDisplay()">
                <option value="">Please select the category of the object</option>
                <option value="Phone">Phone</option>
                <option value="Accesories">Accesories</option>
                <option value="Electronics">Electronics</option>
                <option value="Papers">Papers</option>
                <option value="Keys">Keys</option>
                <option value="Animals">Animals</option>
                <option value="Others">Others</option>
            </select>
            <br/><br/>
            <span>Object Description: </span> <input id="tagsInput" type="text" onblur="tagsDisplay()" onkeypress="tagsDisplay()" name="description" placeholder="Enter some keywords that best describes the object" size="55" required>
            <span>Valid tags(min 3):</span><span id="tags_status"></span>
            <br/><br/>
            <span>Found location: </span> <input id="locationInput" type="text" name="location" placeholder="Enter where you found the object" size="55">            
            <br/><br/>
            <span>Found date</span> <input id="dateInput" type="date" name="date" />
            <br/><br/>
            <input id="file" name="file" type="file" />
                <br/><br/><br/>
                <button id="foundSubmit" name="foundSubmit" disabled type="submit" value="foundSubmit">Send</button>
            </div>
        </form>
        <span id="status"></span>
    </div>
    </div>
</body>

</html>