<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || !isset($_SESSION['logged_user']) || $_SESSION['logged_user'] != "admin") {
		echo " only admin allowed here. good bye, young hacker";
		exit(1);
	}


	//echo "filter type: " . $_POST['filter_type'] . "<br/>";
	//echo "user id: " . $_POST['user_id'] . "<br/>";

	$order_id_post = $_POST['order_id'];

	$conn = connect_to_server();
	mysqli_select_db($conn, "main") or die ("Cannont select main db");

	$query1 = 	"SELECT orders.id as 'order_id', 
						orders.user_id as 'user_id', 
						users.login as 'user_login', 
						SUM(orders_goods.good_price * orders_goods.good_qty) as 't_amount'
				FROM orders
				INNER JOIN orders_goods 
					ON orders.id = orders_goods.order_id
				INNER JOIN goods 
					ON orders_goods.good_id = goods.id
				INNER JOIN users 
					ON users.id = orders.user_id
				WHERE orders.id=$order_id_post
				GROUP BY orders.id
				ORDER BY order_id DESC";

	$result1 = mysqli_query($conn, $query1);
	if (!$result1 || !mysqli_num_rows($result1))
	{
		echo "no items with order_id: " . $order_id_post;
		exit(1);
	}
	while ($row = mysqli_fetch_assoc($result1)) {
		$orders[$row["order_id"]] = $row;
	};


	$range = "";
	foreach ($orders as $order_id => $orderArray) {
		if (!$range)
			$range = "(";
		else
			$range .= ",";
		$range .= $order_id;
	}
	$range .= ")";

	$query2 = 	"SELECT	orders.id as 'order_id', 
					orders_goods.good_id as 'good_id', 
					goods.img as 'good_img', 
					goods.brand as 'good_brand', 
					goods.model as 'good_model', 
					orders_goods.good_price as 'good_price', 
					orders_goods.good_qty as 'good_qty'
				FROM orders
				INNER JOIN orders_goods 
					ON orders.id = orders_goods.order_id
				INNER JOIN goods 
					ON orders_goods.good_id = goods.id
				INNER JOIN users 
					ON users.id = orders.user_id
				WHERE orders.id in " . $range;

	$result2 = mysqli_query($conn, $query2);
	while ($row = mysqli_fetch_assoc($result2)) {
		$orders_items[$row["order_id"]][] = $row;
	};


	foreach ($orders as $order_id => $orderArray) {
		$t_amount = $orderArray['t_amount'];
		$user_id = $orderArray['user_id'];
		$user_login = $orderArray['user_login'];
	
		echo '<div class="order-item">
				<div class="order-header">
					<p class="left">Order #'. $order_id . ' User#'. $user_id . ' - '. $user_login . '</p><p class="right">' . $t_amount . '.00 UAH</p>
				</div>
				<div class="order-body">
					<table class="tb" cellspacing="0">
						<tr class="tb-header">
							<td class="tb-img"></td>
							<td class="tb-descr"><span class="td-name">Item</span></td>
							<td class="tb-price">Price in UAH</td>
							<td class="tb-qty">Q-ty</td>
							<td class="tb-amount">Amount in UAH</td>
						</tr>';

		foreach ($orders_items[$order_id] as $orderItemArray) {
			$img_path = "img/goods/" . $orderItemArray['good_img']; 
			$good_name = $orderItemArray['good_brand'] . " " . 	$orderItemArray['good_model'];
			$good_price = $orderItemArray['good_price'];
			$good_qty = $orderItemArray['good_qty'];
			$good_amount = $good_qty * $good_price;

			echo 	'<tr>
						<td class="tb-img"><img src="' . $img_path . '"></td>
						<td class="tb-descr"><span class="td-name">' . $good_name . '</span></td>
						<td class="tb-price">' . $good_price . '.00</td>
						<td class="tb-qty">' . $good_qty . '</td>
						<td class="tb-amount">' . $good_amount . '.00</td>
					</tr>';
		}

		echo 		'</table>
				</div>
			</div>';
	}

?>