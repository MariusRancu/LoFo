<?php
include_once("php_includes/db_con.php");

if(isset($_POST["u"])){
	
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$u = $_POST['u'];
	$p = $_POST['p'];
	$remember = $_POST['remember'];
	// FORM DATA ERROR HANDLING
	if($u == "" || $p == ""){
		echo "Complete all fields";
        exit();
		// END FORM DATA ERROR HANDLING
	} else {
		$sql = "SELECT user_id, pass FROM users WHERE username='$u'";
        $query = mysqli_query($db_con, $sql);
        $row = mysqli_fetch_row($query);
		$user_id = $row[0];
        $db_pass_str = $row[1];
		if(!password_verify($p, $db_pass_str)){
			echo 'Wrong username or password';
            exit();
		} else {
			// CREATE THEIR SESSIONS AND COOKIES
			$user_token = bin2hex(random_bytes(16));
			$sql = mysqli_prepare($db_con, "UPDATE users SET user_token = ? WHERE username=?");
        	mysqli_stmt_bind_param($sql, "ss", $user_token, $u);
			mysqli_stmt_execute($sql);
            $sql -> close();  

			$_SESSION['user_token'] = $user_token;
			$_SESSION['username'] = $u;
			if(isset($_post['remember'])){
				setcookie("user_token", $user_token, strtotime( '+5 days' ), "/", "", "", TRUE);
				setcookie("username", $u, strtotime( '+5 days' ), "/", "", "", TRUE);
			}
			echo "logged_in";
		    exit();
		}
	}
	exit();

}
?>