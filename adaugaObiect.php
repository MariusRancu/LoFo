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
if(isset($_POST["numeObiect"])){
    // Conecatere la BD
	include_once("php_includes/db_con.php");
    
    //Inserare obiect in tabel
$numeOb = $_POST['numeObiect'];
$categorie = $_POST['categorie'];
$producator =$_POST['producator'];
$model = $_POST['model'];
$culoare = $_POST['culoare'];
$poza = $_POST['poza'];
$locatie = $_POST['locatie'];
$data = $_POST['data'];
$user = $_SESSION["username"];

        $stmt = "SELECT MAX(id_obiect) from obiecte";
        $query = mysqli_query($db_con, $stmt); 
		$row = mysqli_fetch_row($query);
        $id_obiect = $row[0] + 1;
        
    $sql = mysqli_prepare($db_con,"INSERT INTO obiecte VALUES(?,?,?,?,?,?,?,?,?,?)");
	mysqli_stmt_bind_param($sql,'isssssssss', $id_obiect,$user, $categorie, $numeOb, $producator, $model, $culoare, $poza, $locatie, $data);
    
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
 
<!DOCTYPE html>
<html>
<head>
        <title>Lost and Found</title>
        <meta name="author" content="Râncu Marius & Nedelcu Răzvan">
        <meta charset="UTF-8">
        <meta name="description" content="Proiect: Lost and Found">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src = "js/main.js"> </script>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script>
  
  function emptyElement(x){
	_(x).innerHTML = "";
}
  
    function adauga(){
	var nume = _("numeObiect").value;
	var cat= _("categorie").value;
	var prod = _("producator").value;
	var mod = _("model").value;
	var cul = _("culoare").value;
	var pz = _("poza").value;
	var loc = _("locatie").value;
	var dt = _("data").value;
	var status = _("status");
	
	if(nume == "" || cat == "" || loc == ""){
		status.innerHTML = "Completati campurile obligatorii ! ";
	}  else {
		
		var ajax = ajaxObj("POST", "adaugaObiect.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	           
					status.innerHTML = ajax.responseText;
				 
	        }
        }
        ajax.send("numeObiect=" + nume + "&categorie=" + cat + "&producator=" + prod + "&locatie=" + loc + "&model=" + mod + "&culoare=" + cul + "&poza=" + pz + "&data=" + dt);
	}
}

    
</script>

</head>
<header>
    <?php 

    echo "<br><table align='center' cellspacing='0' cellpadding='0' width='800' class='outer-border center'>\n<tr>\n";
    echo "<td>\n";
    echo "<table class='full-header' align='center' cellpadding='0' cellspacing='0' width='900'>\n<tr>\n";
    echo "<td style='padding-bottom:10px; padding-right:10px; padding-left:600px;padding-top:150px;'>";
    include "already_login.php";
    echo "</td>";
    echo "</tr>\n</table>\n";
    echo "</td>\n</tr>\n</table>\n";

    ?>
    </header>
    <br><br>
<nav class="meniu"><center>
  <ul>
    <li><a href="index.php">Prima pagină</a></li>
    <li><a href="#">Am pierdut/găsit</a>
         <ul>
            <li><a href="adaugaObiect.php"> Adaugă obiect găsit</a></li>
            <li><a href="cautaObiect.php"> Caută obiect pierdut</a></li>
         </ul>
    </li>
    <li><a href="report.php">Raportează Abuz</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
</nav></center>
<div class="continut">
<section>
<body>
    <form name="objectform" id="objectform" onsubmit="return false;">
        
    Nume obiect: 
    <input id="numeObiect" type="text" onblur="emptyElement('status')" maxlength="16">
    <br>
    Categorie: 
    <input id="categorie" type="text" onblur="emptyElement('status')" maxlength="16">
    <br>
    Producator: 
    <input id="producator" type="text" onblur="emptyElement('status')" maxlength="16">
    <br>
    Model: 
    <input id="model" type="text" onblur="emptyElement('status')" maxlength="16">
    <br>
    Culo1are: 
    <input id="culoare" type="text" onblur="emptyElement('status')" maxlength="16">
    <br>
    Poza: 
    <input id="poza" type="text" onblur="emptyElement('status')" maxlength="16">
    <br>
    Locatia gasirii obiectului: 
    <input id="locatie" type="text" onblur="emptyElement('status')" maxlength="16">
    <br>
    Data gasirii 
    <input id="data" type="date" onblur="emptyElement('status')" maxlength="16">
    <br>
    <br /><br />
    <button id="buton" onclick="adauga()">Adauga Obiect</button>
    <span id="status"></span>
    </form>
</body>
 </html>
 
 
 