<?php
	//ini_set('display_errors', '1');

	function connect_to_server() {
		$servername = "localhost";
		$username = "root";
		$password = "kbovtpass";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password);
		
		// Check connection
		if (!$conn) {
		    echo "Connection failed: " . mysqli_connect_error();
		    exit (1);
		}
		else {
			//echo "Connected successfully";
			return $conn;
		}
	}

	function create_db($conn, $db_name) {
		$query = "CREATE DATABASE IF NOT EXISTS " . $db_name;
		if (mysqli_query($conn, $query)) {
			//echo "Database created successfully";
		} 
		else {
			echo "Error creating database: " . mysqli_error($conn);
		}
	}

	function table_exist($conn, $tb_name, $db_name) {
		if (mysqli_num_rows(mysqli_query($conn, "SHOW TABLES from " . $db_name . " LIKE '" . $tb_name . "'")) == 1)
			return (1);
		else 
			return (0);
	}

	function create_table($conn, $query, $tb_name, $db_name) {
		if (table_exist($conn, $tb_name, $db_name)) {
		 	//echo "Table " . $tb_name . " already exist! ";
			return ;
		}
		if (mysqli_query($conn, $query)) {
		 	//echo "Table created successfully";
		} 
		else {
			echo "Error creating table: " . mysqli_error($conn);
		}
	}

	function user_pass_valid($username, $passwd) {
		$conn = connect_to_server();
		mysqli_select_db($conn, "main")or die("cannot select DB main");

		$username = mysqli_real_escape_string($conn, $username);
		$passwd = mysqli_real_escape_string($conn, $passwd);

		$result = mysqli_query($conn, "SELECT * FROM users WHERE login='$username' AND passwd='$passwd'");
		mysqli_close($conn);
		if (mysqli_num_rows($result))
			return (1);
		return (0);
	}

	function user_authorized() {
		//if (isset($_SESSION["logged_user"]) and $_SESSION["logged_user"])
		if (isset($_COOKIE['login']) && $_COOKIE['login'] &&
			isset($_COOKIE['passwd']) && $_COOKIE['passwd']) {
			if (user_pass_valid($_COOKIE['login'], $_COOKIE['passwd'])){
				$_SESSION["logged_user"] = $_COOKIE['login'];
				return (1);
			}
		}
		return (0);
	}

	function username_exist($username) {
		$conn = connect_to_server();
		mysqli_select_db($conn, "main")or die("cannot select DB main");

		$username = mysqli_real_escape_string($conn, $username);

		$result = mysqli_query($conn, "SELECT * FROM users WHERE login='$username'");
		mysqli_close($conn);
		if (mysqli_num_rows($result))
			return (1);
		return (0);
	}
	
?>