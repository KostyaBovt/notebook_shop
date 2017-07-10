<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || $_SESSION['logged_user'] != "admin") {
		echo " only admin allowed here. good bye, young hacker";
		exit(1);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin page</title>
	<link rel="stylesheet" type="text/css" href="css/admin_users.css">
	<script type="text/javascript" src="javascript/admin_users_js.js"></script>
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
				<h1>Here we manage users</h1>
				<div class="filter">
					<form name="filter_user_id" method="POST" action="" onsubmit="return false;">
						<div class="filter-head">Filter by user id:</div>
						<input type="text" name="user_id" value="">
						<input id="filter_user_id" type="submit" name="submit" value="Apply">
					</form><br><hr>
					<form name="filter_user_login" method="POST" action="" onsubmit="return false;">
						<div class="filter-head">Filter by user login:</div>
						<input type="text" name="user_id" value="">
						<input id="filter_user_login" type="submit" name="submit" value="Apply">
					</form><br>
				</div>
				<h3>Add new user:</h3>
				<div class="add-user">
					Login: <input type="text" name="user_id" value="">
					Password: <input type="password" name="user_id" value="">
					<input id="create_user" type="submit" name="submit" value="Create">

				</div>
				<h3>Current users:</h3>
				<div class="users">
					<?php
						$conn = connect_to_server();
						mysqli_select_db($conn, "main") or die ("Cannont select main db");

						$query1 = 	"SELECT users.id as 'user_id', 
											users.login as 'user_login'
									FROM main.users
									ORDER BY user_id DESC
									LIMIT 30
									";
						$result1 = mysqli_query($conn, $query1);
						if (!$result1 || !mysqli_num_rows($result1)) {
							echo "no users finded!";
							exit(1);
						}
						echo '<div class="user-item">
									<table class="user-header" >';
						while ($row = mysqli_fetch_assoc($result1)) {
							$user_id = $row['user_id'];
							$user_login = $row['user_login'];
							echo '		<tr id="' . $user_id . '">
											<td>user id ' . $user_id . '</td>
											<td>' . $user_login . '</td>
											<td>Change user name:
												<input type="text" name="user_login" value="">
												<input class="change_user_name" type="submit" name="submit" value="Change">
											</td>
											<td><button class="del_user">Delete user</button></td>
										</tr>';
						}
						echo '		</table>
								</div>';

					?>


				</div>
			</div>
	</div>		
</body>
</html>