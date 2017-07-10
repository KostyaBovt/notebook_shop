<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || $_SESSION['logged_user'] != "admin") {
		//echo " only admin allowed here. good bye, young hacker";
		exit(1);
	}

	$user_id = $_POST['user_id'];
	$conn = connect_to_server();
	mysqli_select_db($conn, "main") or die ("Cannont select main db");

	$query1 = 	"SELECT users.id as 'user_id', 
						users.login as 'user_login'
				FROM main.users
				WHERE users.id=$user_id
				";
	if (isset($_POST['all']) && $_POST['all'] == "1") {
		$query1 = 	"SELECT users.id as 'user_id', 
						users.login as 'user_login'
				FROM main.users
				ORDER BY user_id DESC
				LIMIT 30
				";
	}

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