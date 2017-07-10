<?php
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	$db_name = "main";
	$admin_pass = "admin";

	$conn = connect_to_server();
	create_db($conn, $db_name);
	mysqli_select_db($conn, $db_name) or die("cannot select DB main");
	
	if (!table_exist($conn, "users", $db_name)) {	
		create_table($conn, file_get_contents("./queries/create_table_users.sql"), "users", $db_name);
		mysqli_query($conn, "INSERT INTO users VALUES (NULL, 'admin', '" . hash('whirlpool', $admin_pass) . "', '1')");
	}
	
	if (!table_exist($conn, "goods", $db_name)) {
		create_table($conn, file_get_contents("./queries/create_table_goods.sql"), "goods", $db_name);
		mysqli_query($conn, file_get_contents("./queries/fill_table_goods.sql"));
	}

	create_table($conn, file_get_contents("./queries/create_table_orders.sql"), "orders", $db_name);
	create_table($conn, file_get_contents("./queries/create_table_orders_goods.sql"), "orders_goods", $db_name);
	
	mysqli_close($conn);
?>