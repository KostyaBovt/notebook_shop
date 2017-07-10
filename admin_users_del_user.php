<?php
	session_start();
	include_once("connect_func.php");
	ini_set('display_errors', '1');

	if (!user_authorized() || !isset($_SESSION['logged_user']) || $_SESSION['logged_user'] != "admin") {
		echo"0";
		exit(1);
	}

	$user_id = $_POST['id'];
	if ($user_id == 1) {
		echo "0";
		exit(1);
	}
	
	$conn = connect_to_server();
	mysqli_select_db($conn, 'main') or die("cannot select DB main");
	
	$query = 'DELETE FROM users WHERE users.id="' . $user_id . '"';
	if (!mysqli_query($conn, $query)) {
		echo "0";
		exit(1);
	}
	mysqli_close($conn);
?>