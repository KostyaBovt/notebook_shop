<?php
	include_once("connect_func.php");
	ini_set('display_errors', '1');
	//echo "hello";
	//echo "i received name: " . $_POST["name"] . " and surname: " .$_POST["surname"] . ". Bye!";
	$input = json_decode($_POST["json_main"], true);
	// print_r($input["brand"]);
	// echo "len brand : " . count($input["brand"]);
	// print_r($input["category"]);
	// echo "len category  " . count($input["category"]);
	// print_r($input["diagonal"]);
	// echo "len diagonal: " . count($input["diagonal"]);
	// echo "<br/>";
	//echo "->>" . $_POST["json_main"] . "<<-";

	$conn = connect_to_server();
	mysqli_select_db($conn, "main") or die ("Cannont select main db");
	
	$query = "SELECT * from goods";
	
	$whereFlag = 0;

	if (count($input["brand"])) {
		$whereFlag = 1;
		$query .= " WHERE (";
		for ($i = 0; $i < count($input["brand"]); $i++) {
			if ($i)
				$query .= " OR";
			$query .= " brand='" . $input["brand"][$i] . "'";
		};
		$query .= ")";	
	};

	if (count($input["category"])) {
		if (!$whereFlag++)
			$query .= " WHERE (";
		else
			$query .= " AND (";
		for ($i = 0; $i < count($input["category"]); $i++) {
			if ($i)
				$query .= " OR";
			$query .= " category='" . $input["category"][$i] . "'";
		};
		$query .= ")";
	};

	if (count($input["diagonal"])) {
		if (!$whereFlag++)
			$query .= " WHERE (";
		else
			$query .= " AND (";
		for ($i = 0; $i < count($input["diagonal"]); $i++) {
			if ($i)
				$query .= " OR";
			$query .= " diagonal='" . $input["diagonal"][$i] . "'";
		};
		$query .= ")";
	};


	$result = mysqli_query($conn, $query);
	while ($row  = mysqli_fetch_array($result)) {
				$name = $row['brand'] . " " . $row['model'];
				$img_path = "img/goods/" . $row['img'];
				$price = $row['price'] . " UAH";
				$descr = $row['description'];
				$id = $row['id'];
				echo '<div class="goods-item" id="' . $id .'">
						<div class="goods-img">
							<img src="' . $img_path . '">
						</div>
						<div class="goods-foot">
							<div class="goods-info"><span class="goods-info-name">' . $name . '</span><br/><small>' . $descr . '</small></div>
							<div class="goods-price">' . $price . '</div>
							<div class="goods-add-bskt">
								<img src="img/add.jpg">
							</div>
						</div>
					</div>';
	};
	
?>