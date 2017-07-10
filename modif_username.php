<?php
	session_start();
	ini_set('display_errors', '1');
	
	include_once("connect_func.php");
	
	define("NEWUSERNAME", $_POST['username']);
	define("OLDUSERNAME", $_SESSION['logged_user']);

	define("DBASE", "main");
	define("TABLE", "users");
	
	function check_new_username() {
		if (!NEWUSERNAME) {
			echo "Empty new username. Please back and try again.";
			return (0);
		}

		if (username_exist(NEWUSERNAME)) {
			echo "user with username '" . NEWUSERNAME . "' olready exist. Please back and try another username.";
			return (0);
		}
		return(1);
	}

	if (check_new_username()) {
		$conn = connect_to_server();
		mysqli_select_db($conn, DBASE) or die("cannot select DB main");

		$new_username = mysqli_real_escape_string($conn, NEWUSERNAME);

		$query = "UPDATE " . TABLE . " SET login='" . $new_username . "' WHERE login='" . OLDUSERNAME . "'";
		mysqli_query($conn, $query);
		mysqli_close($conn);


		setcookie("login", $new_username, time() + 3600 * 24 * 356);
		$_SESSION['logged_user'] = $new_username;
		header("location: account.php");
	}

?>
<html>
<head>
	<title>Cannot modif username</title>
</head>
<body>
	<a href="account.php">My account>>></a>
</body>
</html>