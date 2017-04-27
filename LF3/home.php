<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
    exit();
    }
 ?>   
  
<!DOCTYPE html>
<html>
    <head>
    </head>
  <body>
      <p>Welcome !</p>
      <a href = "logout.php">Logout</a>
      </br>
      <a href = "adaugaObiect.php">Adauga obiect pierdut</a>
      <a href = "cautaObiect.php">Cauta obiect gasit </a>
  </body>
</html>    
 