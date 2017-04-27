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
<meta charset="UTF-8">
<title>Adauga Obiect</title>
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
<body>
    <form name="objectform" id="objectform" onsubmit="return false;">
        
    <div>Nume obiect: </div>
    <input id="numeObiect" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Categorie: </div>
    <input id="categorie" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Producator: </div>
    <input id="producator" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Model: </div>
    <input id="model" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Culoare: </div>
    <input id="culoare" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Poza: </div>
    <input id="poza" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Locatia gasirii obiectului: </div>
    <input id="locatie" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Data gasirii </div>
    <input id="data" type="date" onblur="emptyElement('status')" maxlength="16">
    
    <br /><br />
    <button id="buton" onclick="adauga()">Adauga Obiect</button>
    <span id="status"></span>
    </form>
</body>
 </html>
 
 
 