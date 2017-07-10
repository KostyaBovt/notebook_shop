<?php
		session_start();
		setcookie("login", $username, time() - 1);
		setcookie("passwd", $passwd, time() - 1);
		$_SESSION["logged_user"] = "";
		header("location: index.php");
?>