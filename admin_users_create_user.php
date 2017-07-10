<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || $_SESSION['logged_user'] != "admin") {
		echo "0";
		exit(1);
	}

	$new_login = $_POST['new_login'];
	$new_pass = hash("whirlpool",$_POST['new_pass']);

	if (!$_POST["new_login"] || !$_POST["new_pass"] || username_exist($new_login)) {
		echo "0";
		exit(1);
	}

	$conn = connect_to_server();
	mysqli_select_db($conn, "main")or die("cannot select main DB");
	$query = "INSERT INTO main.users VALUES (NULL, '$new_login', '$new_pass', '0')";
	mysqli_query($conn, $query);
?>