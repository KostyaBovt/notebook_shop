<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");
	
	if (isset($_SESSION['logged_user']) && $_SESSION['logged_user'] != "")
		$user = $_SESSION['logged_user'];
	else
		$user = 'guest';
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/basket.css">
	<title>Current basket</title>
	<script type="text/javascript" src="javascript/basket_js.js"></script>
</head>
<body>
	<div class="all">

		<div class="topper">
			<?php
				if (!user_authorized()) {
					echo '<div class="auth">
						<p><a href="authorize.php">Log in</a></p> <p> | </p> <p><a href="register.php">Registration</a></p>
					</div>';
				}
				else {
					echo '<div class="auth">
						<p> Hello, ' . $_SESSION["logged_user"] . '!</p> <p><a href="account.php">My account</a></p>
						<p> | </p><p><a href="logout.php">Log out</a></p>
					</div>';
				}
			?>

			<div class="auth">
				<p>|</p> <p><a href="index.php">Main</a></p>				
			</div>
		</div>

		<div class="header">
			<h1>Hello, <?php echo $user;?>! This is your basket!</h1>
			<h2>Items currnetly in basket:
				<span id='empty'>
					<?php 
						if (!isset($_SESSION['basket']) || empty($_SESSION['basket']))
						echo "Basket is empty";
					?>
				</span>
			</h2>
		</div>

		<div class="basket">

			<?php
				if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
					echo 	'<table class="tb" cellspacing="0">
									<tr class="tb-header">
										<td class="tb-img"></td>
										<td class="tb-descr"><span class="td-name">Item</span></td>
										<td class="tb-price">Price in UAH</td>
										<td class="tb-qty">Q-ty</td>
										<td class="tb-amount">Amount in UAH</td>
										<td class="tb-del"></td>
									</tr>';


					$conn = connect_to_server();
					mysqli_select_db($conn, "main") or die ("Cannont select main db");
						
					$basket = $_SESSION['basket'];
					
					$query = "SELECT * from goods";
					$query .= " WHERE (";
					$count = 0;
					foreach ($basket as $key => $q_ty) {
						if ($count++)
							$query .= " OR ";
						$query .= "id='" . $key . "'"; 
					};
					$query .= ")";	
		
					$result = mysqli_query($conn, $query);
					//echo "result return rows num : " . mysqli_num_rows($result) . "<br/><br/>";

					while ($row = mysqli_fetch_assoc($result)) {
						$result_obj[$row['id']] = $row;
					}
					//print_r($result_obj);
					//echo "<br/><br/>";

					$totalAmount = 0;
					foreach ($basket as $id => $q_ty) {
						$name = $result_obj[$id]['brand'] . " " .$result_obj[$id]['model'];
						$img_path = "img/goods/" . $result_obj[$id]['img'];
						$price = $result_obj[$id]['price'];
						$descr = $result_obj[$id]['description'];
						$amount = $q_ty * $price;
						$totalAmount += $amount;
						$_SESSION['prices'][$id] = $price;
						$_SESSION['t_amount'] = $totalAmount;
						// echo	"id : " . $id . "<br/>" .
						// 		"name: " . $name . "<br/>" . 
						// 		"descr : " . $descr . "<br/>" .
						// 		"img_path : " . $img_path . "<br/>" .
						// 		"price : " . $price . "<br/>" .
						// 		"q_ty : " . $q_ty . "<br/>" .
						// 		"amount : " . $amount . ".00" . "<br/><br/><br/>";

						echo	'<tr id="' . $id . '">
										<td class="tb-img"><img src="' . $img_path . '"></td>
										<td class="tb-descr"><span class="td-name">' . $name . '</span><br/><small>' . $descr . '</small></td>
										<td class="tb-price">' . $price . '</td>
										<td class="tb-qty">' . $q_ty . '</td>
										<td class="tb-amount">' . $amount . '.00</td>
										<td class="tb-del"><img src="img/delete.png"></td>
									</tr>';
	

					}

					echo 	'<tr id="tb-footer">
										<td class="tb-img"></td>
										<td class="tb-descr"><span class="td-name"></span></td>
										<td class="tb-price"></td>
										<td class="tb-qty">Total Amount</td>
										<td class="tb-amount">' . $totalAmount .'.00</td>
										<td class="tb-del"></td>
									</tr>';
					echo "</table>";
					//print_r($_SESSION['basket']);
					echo '<button id="order-butt" type="button">Confirm order!</button>';
				}

				// echo $_SERVER['HTTP_REFERER'];
			?>
		</div>
	</div>
</body>
</html>