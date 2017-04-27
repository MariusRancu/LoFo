<?php

    // Conecatere la BD
	include_once("php_includes/db_con.php");
    
    //Inserare obiect in tabel
$numeOb = _("numeObiect").value;
$categorie = _("categorie").value;
$producator =_("producator").value;
$model =  _("model").value;
$culoare = _("culoare").value;
$poza =  _("poza").value;
$locatie = _("locatie").value;
$data = _("data").value;


        $stmt = "SELECT MAX(id_obiect) from obiecte";
        $query = mysqli_query($db_con, $stmt); 
		$row = mysqli_fetch_row($query);
        $id_obiect = $row[0];
        
        
    $sql = mysqli_prepare($db_con,"INSERT INTO obiecte(id_obiect, categorie, nume_obiect, producator, model, culoare, poza, loc_gasire, data_gasire) VALUES(?,?,?,?,?,?,?,?,?)");
	mysqli_stmt_bind_param($sql,'issssssss', $id_obiect,$categorie, $numeOb, $producator, $model, $culoare, $poza, $locatie, $data);
    
    mysqli_stmt_execute($sql);
    
	if(mysqli_stmt_affected_rows($sql) == 1){
        
		 echo 'obiect_adaugat'; 
         mysqli_stmt_close($sql);  
         
	} else {
        
        echo 'esuat';
        mysqli_stmt_close($sql);
        
    }
    exit();
   
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Adauga Obiect</title>
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
    <input id="Poza" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Locatia gasirii obiectului: </div>
    <input id="locatie" type="text" onblur="emptyElement('status')" maxlength="16">
    
    <div>Data gasirii </div>
    <input id="data" type="text" onblur="emptyElement('status')" maxlength="16">
<br /><br />
    <span id="eroare"></span>
    
    <button id="buton" onclick="adauga()">Adauga Obiect</button>
    <br />
    
    </form>
</body>
 </html>