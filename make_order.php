<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized()) {
		echo "0";
	}
	else {
		$conn = connect_to_server();
		mysqli_select_db($conn, "main") or die ("Cannot select main db");

		$query = "SELECT id FROM users WHERE login='" .$_SESSION['logged_user'] . "'";
		$result = mysqli_query($conn, $query);
		$result = mysqli_fetch_assoc($result);

		//echo "1" . ". We have user id: " . $result['id'];
		
		$user_id = $result['id'];

		$query = "INSERT INTO orders (`id`, `user_id`) VALUES (NULL, $user_id)";
		mysqli_query($conn, $query);

		$order_id = mysqli_insert_id($conn);

		$basket = $_SESSION["basket"];
		$prices = $_SESSION["prices"];
		foreach ($basket as $good_id => $good_qty) {
			$good_price = $prices[$good_id];
			$query = "INSERT INTO orders_goods (`id`, `order_id`, `good_id`, `good_qty`, `good_price`) VALUES (NULL, $order_id, $good_id, $good_qty, $good_price)";
			mysqli_query($conn, $query);
		}

		unset($_SESSION["basket"]);
		unset($_SESSION["prices"]);
		unset($_SESSION["t_amount"]);
		echo "1";
	}
?>