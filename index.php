<?php
	session_start();
	include_once("check_db_table_exist.php");
	include_once("connect_func.php");

	// function user_authorized() {
	// 	//if (isset($_SESSION["logged_user"]) and $_SESSION["logged_user"])
	// 	if (isset($_COOKIE['login']) && $_COOKIE['login'] &&
	// 		isset($_COOKIE['passwd']) && $_COOKIE['passwd']) {
	// 		if (user_pass_valid($_COOKIE['login'], $_COOKIE['passwd'])){
	// 			$_SESSION["logged_user"] = $_COOKIE['login'];
	// 			return (1);
	// 		}
	// 	}
	// 	return (0);
	// }

	// $conn = connect_to_server();
	// mysqli_select_db($conn, "main") or die ("Cannont select main db");
	// $query = "SELECT * from goods";
	// $result = mysqli_query($conn, $query);
	// while ($row  = mysqli_fetch_array($result)) {
	// 			$name = $row['brand'] . " " . $row['model'];
	// 			$img_path = "img/goods/" . $row['img'];
	// 			$price = $row['price'] . " UAH"; 
	// 			echo '<div class="goods-item">
					
	// 				<div class="goods-img">
	// 					<img src="' . $img_path . '">
	// 				</div>
	// 				<div class="goods-foot">
	// 					<div class="goods-info">' . $name . '<br/><small></small></div>
	// 					<div class="goods-price">' . $price . '</div>
	// 					<div class="goods-add-bskt">
	// 						<img src="img/add.jpg">
	// 					</div>
	// 				</div>
				
	// 			</div>';
	// }

?>
<html>
<head>
	<link rel="shortcut icon" href="img/icon2.png"/>
	<link rel="stylesheet" type="text/css" href="css/index_style.css">
	<script type="text/javascript" src="javascript/index_js.js"></script>
	<title>Notebook shop</title>
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

			<div class="basket">
				<a href="basket.php"><p>Basket</p></a>				
			</div>

			<div class="name">
				<h1>Notebook shop</h1>
			</div>
		
		</div>

		<div class="main">
			<div class="filter">
				<form name="filter2" method="POST" action="" onsubmit="return false;">
					<div class="filter-head">CHOOSE FILTERS:</div><hr>
					<div class="filter-item">Brand<br/>
						<label><input type="checkbox" name="brand" value="Lenovo">Lenovo</label><br/>
						<label><input type="checkbox" name="brand" value="Asus">Asus</label><br/>
						<label><input type="checkbox" name="brand" value="Acer">Acer</label><br/>
						<label><input type="checkbox" name="brand" value="MSI">MSI</label><br/>
						<label><input type="checkbox" name="brand" value="HP">HP</label>
					</div><hr>
					<div class="filter-item">Category<br/>
						<label><input type="checkbox" name="category" value="game">Game</label><br/>
						<label><input type="checkbox" name="category" value="office">Office</label><br/>
						<label><input type="checkbox" name="category" value="ultra">Ultrabook</label><br/>
						<label><input type="checkbox" name="category" value="trans">Transformer</label>
					</div><hr>
					<div class="filter-item">Screen size<br/>
						<label><input type="checkbox" name="diagonal" value="13-14">13"-14"</label><br/>
						<label><input type="checkbox" name="diagonal" value="15">15"</label><br/>
						<label><input type="checkbox" name="diagonal" value="16-20">16"-20"</label><br/>
					</div><hr>
						<input id="submitButton" type="submit" name="submit" value="Apply">
				</form>
			</div>
			<div class="goods">
				<?php
					$conn = connect_to_server();
					mysqli_select_db($conn, "main") or die ("Cannont select main db");
					$query = "SELECT * from goods";
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
					}	
				?>

			</div>
		</div>	

		<div class="footer">
			<h3>Our Contacts:</h3>
			<div class="map">
				<img src="img/map.png">
			</div>
			<div class="adress">
				02346<br/>
				Noname Street, 15<br/>
				Kyiv<br/>
				Ukraine<br/>
			</div>
		</div>
	</div>
</body>
</html>