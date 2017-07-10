<?php
	session_start();
	include_once("connect_func.php");
	ini_set('display_errors', '1');
	
	define("USERNAME", $_SESSION['logged_user']);
	define("DBASE", "main");
	define("TABLE", "users");

	if (USERNAME == "admin") {
		exit(1);
	}

	$conn = connect_to_server();
	mysqli_select_db($conn, DBASE) or die("cannot select DB main");
	$query = "DELETE FROM " . TABLE . " WHERE login='" . USERNAME . "'";
	mysqli_query($conn, $query);
	mysqli_close($conn);

	$_SESSION["logged_user"] = "";
	setcookie('login', "nothing", time() - 1);
	setcookie('passwd', "nothing", time() - 1);
?>
<!DOCTYPE html>
<html>
<head>
	<title>User deleted</title>
</head>
<body>
	Profile of user "<?php echo USERNAME; ?>" was deleted. Return to <a href="index.php">Start page>>></a>
</body>
</html>