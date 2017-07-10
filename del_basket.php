<?php
	session_start();
	ini_set('display_errors', '1');
	//echo "server sucsessfully received: " . $_POST["id"];

	$id = $_POST["id"];

	
	if ($_SESSION["basket"][$id] == 1) {
		
		unset($_SESSION["basket"][$id]);
		
		$retArray["q_ty"] = 0;
		$retArray["amount"] = 0;

		$_SESSION["t_amount"] -= $_SESSION["prices"][$id];	
		$retArray["t_amount"] = $_SESSION["t_amount"];

		$retArray = json_encode($retArray);
		echo $retArray;
	} 
	else {
		
		//decrease q_ty of item with id
		$_SESSION["basket"][$id] -= 1;
		
		//decrease total amount by price of deleted item
		$_SESSION["t_amount"] -= $_SESSION["prices"][$id];
		

		$retArray["q_ty"] = $_SESSION["basket"][$id];
		$retArray["amount"] = $_SESSION["basket"][$id] * $_SESSION["prices"][$id];
		$retArray["t_amount"] = $_SESSION["t_amount"];

		$retArray = json_encode($retArray);
		echo $retArray;		
	}

?>