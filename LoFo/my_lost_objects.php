<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false)
    {
        header("location: signup.php");
    exit();
    }
?>
<h2>Lost objects </h2>            
<table border="3">
  <tr>
    <th>User</th>
    <th>Object Name</th>
    <th>Category</th>
    <th>Producer</th>
    <th>Model</th>
    <th>Color</th>
    <th>Location</th>
    <th>Date</th>
    <th>Verify</th>
  </tr>
<?php
while($row = mysqli_fetch_array($result))
{
?>
  <tr>
    <td><?php  echo $row['username'] ?></td>
    <td><?php  echo $row['category'] ?></td>
    <td><?php  echo $row['obj_name'] ?></td>
    <td><?php  echo $row['producer'] ?></td>
    <td><?php  echo $row['model'] ?></td>
    <td><?php  echo $row['color'] ?></td>
    <td><?php  echo $row['location'] ?></td>
    <td><?php  echo $row['data'] ?></td>
    <td>
        <button onclick="accept(<?php echo $row['id']?>)" alt="Fondat" style="color: green;margin: auto;">&#10004;</a>
        <button onclick="refuse(<?php echo $row['id']?>)" alt="Nefondat" style="color: green;margin: auto;">&#10006;</a>
    </td>
  </tr>