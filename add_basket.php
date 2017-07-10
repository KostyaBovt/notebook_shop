<?php
	session_start();
	ini_set('display_errors', '1');
	echo ("start");

	$id = (string)$_POST['id'];
	$basket = "";
	if (isset($_SESSION['basket']))
		$basket = $_SESSION['basket'];
	$user = (isset($_SESSION['logged_user'])) ? $_SESSION['logged_user'] : "no_login_guest";

	if (!$basket || !isset($basket[$id])) {
		//$_SESSION['basket'] = "";
		$_SESSION['basket'][$id] = 1;
	}
	else {
		$_SESSION['basket'][$id] += 1;
	};

	echo "add_basket.php obtained id: " . $id . ". Loggued user: " . $user . ". ";
	echo "Currnet basket items count: " . count($_SESSION['basket']) . ". Basket items: ";
	foreach ($_SESSION['basket'] as $key => $elem) {
		echo "Id: " . $key . ", q-ty: " . $elem . ". ";
	}
?>