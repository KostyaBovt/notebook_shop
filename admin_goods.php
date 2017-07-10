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
	<link rel="stylesheet" type="text/css" href="css/admin.css">
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
				<a href="admin_goods_add.php"><button class="butt">Add goods</button></a>
				<a href="admin_goods_modif.php"><button class="butt">Modify goods</button></a>
			</div>
	</div>		
</body>
</html>