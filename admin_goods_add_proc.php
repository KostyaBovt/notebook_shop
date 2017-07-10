<?php

	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || !isset($_SESSION['logged_user']) || $_SESSION['logged_user'] != "admin") {
		echo "0";
		exit(1);
	}

	$input = json_decode($_POST["json_obj"], true);
	// echo $_POST["json_obj"];

	$brand = $input['brand'];
	$model = $input['model'];
	$descr = $input['descr'];
	$categ = $input['category'];
	$diago = $input['diagonal'];
	$price = $input['price'];
	$imag = $input['imag'];

	// echo "   ";
	// echo $brand . "  "; 
	// echo $model . "  "; 
	// echo $descr . "  "; 
	// echo $categ . "  "; 
	// echo $diago . "  "; 
	// echo $price . "  "; 
	// echo $img . " ";


	if ($brand == "" ||	$model == "" || $descr == "" || $categ == "" || $diago == "" || $price == "") {
		echo "0";
		exit (1);
	}

	$img = $conn = connect_to_server();
	mysqli_select_db($conn, "main") or die ("Cannont select main db");

	$query = "INSERT INTO `goods` (`id`, `brand`, `model`, `description`, `category`, `diagonal`, `price`, `img`) VALUES (NULL, '$brand', '$model', '$descr', '$categ', '$diago', $price, '$imag')";

	if (!mysqli_query($conn, $query)) {
		//echo mysqli_error($conn);
		echo "0";
		exit (1);
	}
	echo "1";
?>