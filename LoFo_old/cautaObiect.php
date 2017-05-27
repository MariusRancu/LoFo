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
     <meta charset="UTF-8">
<title>Cauta obiect</title>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>

<script>
  
  function emptyElement(x){
	_(x).innerHTML = "";
}
  
    function cauta(){
	var nume = _("numeObiect").value;
	var cat= _("categorie").value;
	var prod = _("producator").value;
	var mod = _("model").value;
	var cul = _("culoare").value;
	var pz = _("poza").value;
	var loc = _("locatie").value;
	var status = _("status");
	
	if(nume == "" || cat == ""|| loc == ""){
		status.innerHTML = "Completati campurile obligatorii ! ";
	}  else {
		    document.location = "rezultate.php?numeObiect=" + nume + "&categorie=" + cat + "&producator=" + prod + "&model=" + mod + "&culoare=" + cul + "&locatie=" + loc;
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
    
    <div>Locatia pierderii obiectului: </div>
    <input id="locatie" type="text" onblur="emptyElement('status')" maxlength="16">
    
    
    <br /><br />
    <button id="buton" onclick="cauta()">Cauta obiect</button>
    <span id="status"></span>
    </form>
</body>
 </html>