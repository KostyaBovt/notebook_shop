<?php
	session_start();
	ini_set('display_errors', '1');
	
	include_once("connect_func.php");
	
	define("OLDPASSWD", hash("whirlpool", $_POST['old_passwd']));
	define("NEWPASSWD", hash("whirlpool", $_POST['new_passwd']));
	define("USERNAME", $_SESSION['logged_user']);

	define("DBASE", "main");
	define("TABLE", "users");
	
	function check_new_passwd() {
		if (!$_POST['old_passwd'] || !$_POST['new_passwd']) {
			echo "Empty password(s). Please back and try again.";
			return (0);
		}

		if (!user_pass_valid(USERNAME, OLDPASSWD)) {
			echo "You entered invalid current password. Please back and try another username.";
			return (0);
		}

		return(1);
	}

	if (check_new_passwd()) {
		$conn = connect_to_server();
		mysqli_select_db($conn, DBASE) or die("cannot select DB main");
		$query = "UPDATE " . TABLE . " SET passwd='" . NEWPASSWD . "' WHERE login='" . USERNAME . "'";
		mysqli_query($conn, $query);
		mysqli_close($conn);


		setcookie("passwd", NEWPASSWD, time() + 3600 * 24 * 356);
		echo "You password successfully modified. You can back to your account.";
	}

?>
<html>
<head>
	<title>Modif password</title>
</head>
<body>
	<a href="account.php">My account>>></a>
</body>
</html>