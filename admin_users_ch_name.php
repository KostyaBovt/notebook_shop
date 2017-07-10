<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || $_SESSION['logged_user'] != "admin") {
		echo "0";
		exit(1);
	}

	// echo "0";
	// exit(1);

	$user_id = $_POST['user_id'];
	$new_name = $_POST['new_name'];

	if ($user_id == "1" || !$new_name || username_exist($new_name)) {
		echo "0";
		exit(1);
	}

	$conn = connect_to_server();
	mysqli_select_db($conn, "main") or die ("Cannont select main db");
	$query1 = "UPDATE main.users SET users.login='$new_name' WHERE users.id=$user_id";
	mysqli_query($conn, $query1);

	echo "1";
?>