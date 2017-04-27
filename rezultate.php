<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
    exit();
    }
 ?>
 <?php
include_once("php_includes/db_con.php");

$categorie = $_GET['categorie']; 
$numeOb = $_GET['numeObiect'];
$producator = $_GET['producator']; 
$model = $_GET['model'];
$culoare = $_GET['culoare'];
$locatie = $_GET['locatie'];
$username = $_SESSION["username"];

//Preluare informatii obiect
$sql = mysqli_prepare($db_con,"SELECT username,nume_obiect,categorie,producator,model,culoare,loc_gasire,data_gasire FROM obiecte WHERE categorie = ? AND nume_obiect = ? AND producator = ? AND model = ? AND culoare = ? AND loc_gasire = ?");
	 mysqli_stmt_bind_param($sql,'ssssss', $categorie, $numeOb, $producator, $model, $culoare, $locatie);
     mysqli_stmt_execute($sql);

     $sql->store_result();
     $nr_rezultate = $sql->num_rows;

//Preluare informatii utilizator
     $sql2 = mysqli_prepare($db_con,"SELECT nume,prenume,email,nr_tel FROM utilizatori WHERE username = ?");
     mysqli_stmt_bind_param($sql2,'s',$username);
     mysqli_stmt_execute($sql2);
     $sql2->bind_result($numeU, $prenumeU, $email, $nr_tel);
     $sql2->fetch();

     if($nr_rezultate > 0){
   

    $sql->bind_result($username, $nume, $prod, $mod, $cul, $pz, $loc, $data);
    

     echo "
                                                <th>Utilizatorul</th>
                                                <th>Nume obiect</th>
                                                <th>Producator</th>
                                                <th>Model</th>
                                                <th>Culoare</th>
                                                <th>Locatie gasire</th>
                                                <th>Data gasire</th>
                                                ";
    
    while ($sql->fetch()) {
    	 echo "<tr><td>";  
    	 echo $username;
    	 echo "</td>";
    	 echo "<td>";
    	 echo $nume;
    	 echo "</td>";
    	 echo "<td>";
    	 echo $prod;
    	 echo "</td><td>";
    	 echo $mod;
    	 echo "</td><td>";
    	 echo $cul;
    	 echo "</td><td>";
    	 echo $loc;
    	 echo "</td><td>";
    	 echo $data;
    	 echo "</tr></td>";
         
    } 
    echo "<br>";
         echo $numeU." ".$prenumeU." ".$nr_tel." ".$email; 
    }else 
    echo "Nu a fost gasit nici un obiect";
    $sql->close();
?>