<?php
	session_start();
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

		if (!user_pass_valid(USERNAME, PASSWD)) {
			echo "User and(or) password invalid. Please back and try again."; 
			return (0);
		}
		return (1);
	}

	function auth_user($username, $passwd) {
		setcookie("login", $username, time() + 3600 * 24 * 356);
		setcookie("passwd", $passwd, time() + 3600 * 24 * 356);
		$_SESSION["logged_user"] = $username;
	}

	if (check_input()) {
		auth_user(USERNAME, PASSWD);
		header("Location: index.php");
	}
?>

<html>
<head>
	<title>Invalid authorization</title>
</head>
<body>
	<a href="authorize.php">Authorization>>></a>
</body>
</html>