<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");
	
	if (!user_authorized() || !isset($_SESSION['logged_user']) || !$_SESSION['logged_user'])
		exit(0);
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/account.css">
	<script type="text/javascript" src="javascript/account_js.js"></script>
	<title>
		<?php
			echo $_SESSION['logged_user'] . " account";
		?>
	</title>
	<script type="text/javascript">
		function confirm_trigger() {
			$answer = confirm("Realy want to delete this account?");
			return ($answer);
		}
	</script>
</head>
<body>
	<div class="all">

		<div class="header">
			
		<?php
			if (!user_authorized()) {
				echo '<div class="auth">
					<p><a href="authorize.php">Log in</a></p> <p> | </p> <p><a href="register.php">Registration</a></p>';
				echo '</div>';
			}
			else {
				echo '<div class="auth">
					<p> Hello, ' . $_SESSION["logged_user"] . '!</p> <p><a href="account.php">My account</a></p>
					<p> | </p><p><a href="logout.php">Log out</a></p>';
					if ($_SESSION['logged_user'] == 'admin')
						echo '<p> | </p> <p><a href="admin.php">Admin</a></p>';
				echo '</div>';
			}
		?>
			<div class="auth">
				<p>|</p> <p><a href="index.php">Main</a></p>				
			</div>


			<div class="basket">
				<a href="basket.php"><p>Basket</p></a>				
			</div>
		
		</div>

		<h2>Your account:</h2>
		<div class="modif">
			<h2>Modify username:</h2>
			<?php
				if ($_SESSION['logged_user'] == "admin") {
					echo 'You can not change admin name';					
				}
				else {
					echo 	'<form method="POST" action="modif_username.php">
								New Username: <input type="text" name="username"/>
								<input type="submit" value="Change username"/>
							</form>';
				}
			?>
		</div>

		<div class="modif">
			<h2>Modify password:</h2>
			<form method="POST" action="modif_passwd.php">
				Old password: <input type="password" name="old_passwd"/>
				New password: <input type="password" name="new_passwd"/>
				<input type="submit" value="Change password"/>
			</form>
		</div>

		<div class="modif">
			<h2>Delete this account:</h2>
			<?php
				if ($_SESSION['logged_user'] == "admin") {
					echo 'You can not delete admin account';					
				}
				else {
					echo '<form method="POST" action="delete_account.php">
							<input type="submit" value="Delete account"  onClick="return confirm_trigger();"/>
						</form>';
				}
			?>
		</div>

		<div class="orders">
			
			<h2>You orders:</h2>
			
			<?php
				$conn = connect_to_server();
				mysqli_select_db($conn, "main") or die ("Cannont select main db");
				$user_login = $_SESSION['logged_user'];

				$query1 = 	"SELECT orders.id as 'order_id', 
									SUM(orders_goods.good_price * orders_goods.good_qty) as 't_amount'
							FROM orders
							INNER JOIN orders_goods 
								ON orders.id = orders_goods.order_id
							INNER JOIN goods 
								ON orders_goods.good_id = goods.id
							INNER JOIN users 
								ON users.id = orders.user_id
							WHERE users.login = '" . $user_login . "'
							GROUP BY orders.id
							ORDER BY order_id DESC";

				$query2 = "SELECT	orders.id as 'order_id', 
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
							WHERE users.login = '" . $user_login . "'";

				$result1 = mysqli_query($conn, $query1);

				if (!$result1 || !mysqli_num_rows($result1)) {
					echo "no orders yet";
					exit(1);
				}

				$result2 = mysqli_query($conn, $query2);

				while ($row = mysqli_fetch_assoc($result1)) {
					$orders[$row["order_id"]] = $row['t_amount']; 
				}

				while ($row = mysqli_fetch_assoc($result2)) {
					$orders_goods[$row['order_id']][] = $row;
				}

				foreach ($orders as $order_id => $t_amount) {
					echo '<div class="order-item">
									<div class="order-header">
										<p class="left">Order #'. $order_id . '</p><p class="right">' . $t_amount . '.00 UAH</p>
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

					foreach ($orders_goods[$order_id] as $order_elem) {
						$img_path = "img/goods/" . $order_elem['good_img'];
						$good_name = $order_elem['good_brand'] . " " . $order_elem['good_model'];
						$good_price = $order_elem['good_price'];
						$good_qty = $order_elem['good_qty'];
						$good_amount = $good_price * $good_qty;

						echo '<tr>
										<td class="tb-img"><img src="' . $img_path . '"></td>
										<td class="tb-descr"><span class="td-name">' . $good_name . '</span></td>
										<td class="tb-price">' . $good_price . '.00</td>
										<td class="tb-qty">' . $good_qty . '</td>
										<td class="tb-amount">' . $good_amount . '.00</td>
									</tr>';
					}				

					echo '		</table>
									</div>
								</div>';		
				}
			?>
		
		</div>
	</div>
</body>
</html>