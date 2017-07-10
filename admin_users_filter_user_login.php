<?php
	session_start();
	ini_set('display_errors', '1');
	include_once("connect_func.php");

	if (!user_authorized() || $_SESSION['logged_user'] != "admin") {
		//echo " only admin allowed here. good bye, young hacker";
		exit(1);
	}

	$user_login_post = $_POST['user_login'];
	$conn = connect_to_server();
	mysqli_select_db($conn, "main") or die ("Cannont select main db");

	$query1 = 	"SELECT users.id as 'user_id', 
						users.login as 'user_login'
				FROM main.users
				WHERE users.login='$user_login_post'
				";
	$result1 = mysqli_query($conn, $query1);
	if (!$result1 || !mysqli_num_rows($result1)) {
		echo "no users finded by login!";
		exit(1);
	}

	echo '<div class="user-item">
				<table class="user-header" >';
	while ($row = mysqli_fetch_assoc($result1)) {
		$user_id_i = $row['user_id'];
		$user_login_i = $row['user_login'];
		echo '		<tr id="' . $user_id_i . '">
						<td>user id ' . $user_id_i . '</td>
						<td>' . $user_login_i . '</td>
						<td>Change user name:
							<input type="text" name="user_login" value="">
							<input type="submit" name="submit" value="Change">
						</td>
						<td><button class="del_user">Delete user</button></td>
					</tr>';
	}
	echo '		</table>
			</div>';

?>