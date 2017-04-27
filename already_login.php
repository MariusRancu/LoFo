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
    <link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
    <style type="text/css">
#body
{
      background-color: gray;
    border: 2px solid black;
    text-align: center;
    border-radius: 10px;
    padding-bottom: 10px;
    font-weight: bold;
}
#loginform > input {
  width: 100px;
  height: 10px;
  padding: 3px;
  background: #F3F9DD;

}
#loginbtn {
  font-size: 10px;

}
</style>
    </head>
  <body>
  <div id="body">
      BUN VENIT!
      <hr color="brown">
      <a href = "logout.php">Deloghează-te</a>
      <br>
      <a href = "adaugaObiect.php">Adaugă obiect găsit</a>
      <br>
      <a href = "cautaObiect.php">Caută obiect pierdut</a>
  </body></div>
</html>    
 