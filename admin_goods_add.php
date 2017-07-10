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
	<link rel="stylesheet" type="text/css" href="css/admin_goods_add.css">
	<script type="text/javascript" src="javascript/admin_goods_add_js.js"></script>
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
				<h3>Add good now:</h3>
				<table class="add-good">
					<tr>
						<td>Brand:</td>	
						<td><input type=text name="brand"></td>
					</tr>
					<tr>
						<td>Model:</td>	
						<td><input type=text name="model"></td>
					</tr>
					<tr>
						<td>Category:</td>	
						<td><input type=text name="category"></td>
					</tr>
					<tr>
						<td>Price:</td>	
						<td><input type=text name="price"></td>
					</tr>
					<tr>
						<td>Diagonal:</td>	
						<td><input type=text name="diagonal"></td>
					</tr>
					<tr>
						<td>Image:</td>	
						<td><input type=text name="imag"></td>
					</tr>
					<tr>
						<td>Description:</td>	
						<td><textarea type=text name="descr"></textarea></td>
					</tr>
					<tr>
						<td></td>	
						<td><input id="add_good" type=button name="submit" value="Add good"></td>
					</tr>
				</div>
			</div>
	</div>		
</body>
</html>