<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || !isset($_SESSION['logged_user']) || $_SESSION['logged_user'] != "admin") {
		echo " only admin allowed here. good bye, young hacker";
		exit(1);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin page</title>
	<link rel="stylesheet" type="text/css" href="css/admin_orders.css">
	<script type="text/javascript" src="javascript/admin_orders_js.js"></script>
</head>
<body>
	<div class="all">
			<div class="header">
				<div class="auth">
					<?php	
						echo '<p> Hello, ' . $_SESSION["logged_user"] . '!</p> <p><a href="account.php">My account</a></p>
						<p> | </p><p><a href="logout.php">Log out</a></p>';
						if ($_SESSION['logged_user'] == 'admin')
							echo '<p> | </p> <p><a href="admin.php">Admin</a></p>';
					?>
				</div>
				<div class="auth">
					<p>|</p> <p><a href="index.php">Main</a></p>				
				</div>

				<div class="basket">
					<a href="basket.php"><p>Basket</p></a>				
				</div>
			</div>

			<div class="panel">
				<h1>Here we manage orders</h1>
				<div class="filter">
					<button id="collapse">Collapse all</button>
					<button id="expande">Expande all</button><br><br><hr>
					
						<form name="filter_user_id" method="POST" action="" onsubmit="return false;">
							<div class="filter-head">Filter by user id:</div>
							<input type="text" name="user_id" value="">
							<input id="filter_user_id" type="submit" name="submit" value="Apply">
						</form><br><hr>
						<form name="filter_user_login" method="POST" action="" onsubmit="return false;">
							<div class="filter-head">Filter by user login:</div>
							<input type="text" name="user_id" value="">
							<input id="filter_user_login" type="submit" name="submit" value="Apply">
						</form><br><hr>
						<form name="filter_order_id" method="POST" action="" onsubmit="return false;">
							<div class="filter-head">Filter by order id:</div>
							<input type="text" name="user_id" value="">
							<input id="filter_order_id" type="submit" name="submit" value="Apply">
						</form><hr>

				</div>
				<div class="orders">
					<?php
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
									GROUP BY orders.id
									ORDER BY order_id DESC
									LIMIT 40";

						$result1 = mysqli_query($conn, $query1);

						if (!$result1 || !mysqli_num_rows($result1)) {
							exit(1);
						}

						while ($row = mysqli_fetch_assoc($result1)) {
							$orders[$row["order_id"]] = $row;
						};

						// foreach ($orders as  $value) {
						// 	print_r($value);
						// 	echo "<br/>";
						// };

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

						// foreach ($orders_items as  $value) {
						// 	print_r($value);
						// 	echo "<br/><br/>";
						// };

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

				</div>
			</div>
	</div>	
</body>
</html>