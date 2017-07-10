<?php
	include_once("connect_func.php");
	
	ini_set('display_errors', '1');
	define("USERNAME", $_POST['username']);
	define("PASSWD", hash("whirlpool", $_POST['passwd']));
	define("DBASE", "main");
	define("TABLE", "users");

	function check_input() {
		if (!$_POST["username"]) {
			echo "You have not entered the username. Please back and try again.";
			return (0);
		}
		elseif (!$_POST["passwd"]) {
			echo "You have not entered the password. Please back and try again.";
			return (0);
		}
		if (username_exist(USERNAME)) {
			echo "User with username '" . USERNAME . "' already exist. Please back and try again wth other username."; 
			return (0);
		}
		return (1);
	}

	function register_user($username, $passwd) {
		$conn = connect_to_server();
		mysqli_select_db($conn, DBASE)or die("cannot select DB " . DBASE);

		$username = mysqli_real_escape_string($conn, $username);
		$passwd = mysqli_real_escape_string($conn, $passwd);		


		$query = "INSERT INTO " . TABLE . " VALUES (NULL, '$username', '$passwd', '0')";
		mysqli_query($conn, $query);
	}


	if (check_input()) {
		register_user(USERNAME, PASSWD);
		header("Location: authorize.php");
	}
?>

<html>
<head>
	<title>Invalid registration</title>
</head>
<body>
	<a href="register.php">Registration>>></a>
</body>
</html>