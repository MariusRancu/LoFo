<?php 
include_once("php_includes/db_con.php");

$sql="select * from lost_objects"; 

$response = array();
$posts = array();
$result=mysqli_query($db_con, $sql);
while($row=mysqli_fetch_array($result)) 
{ 
$added_by=$row['username'];     
$description=$row['description'];
$s = "";
if($row['status'] == 0){
    $s = "waiting";
}else if($row['status'] == 1){
    $s = "accepted";
} else if($row['status'] == 2){
    $s = "refused";
}

$pending_status= $s;  

$posts[] = array('added_by'=> $added_by, 'description'=> $description, 'pending_status'=> $pending_status );

} 

$response['posts'] = $posts;

$fp = fopen('raports\\results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);

echo json_encode($response);

?> 