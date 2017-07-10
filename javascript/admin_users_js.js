function addDelButtons() {
	var delUserButtons = document.querySelectorAll(".del_user");
	for (var i = 0; i < delUserButtons.length; i++) {
		delUserButtons[i].addEventListener('click', function() {
			
			var id = this.parentElement.parentElement.id;
			var elem = this;
			//alert("delete user with id=" + id);

			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'admin_users_del_user.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("id=" + id);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					if (xhr.responseText == "0") {
						alert("cant delete this user");
					}
					else {
						alert("user deleted");
						elem.parentElement.parentElement.style.backgroundColor = '#ffb9af';
						elem.remove();					
					}		
				};
			};

		});
	};
};

function addChNameButtons() {
	var chNameButtons = document.querySelectorAll(".change_user_name");
	for (var i = 0; i < chNameButtons.length; i++) {
		chNameButtons[i].addEventListener('click', function() {
			var id = this.parentElement.parentElement.id;
			var elem = this;
			var newName = this.previousElementSibling.value;
			//alert("change user name with id =" + id);
			xhr = new XMLHttpRequest();
			xhr.open('POST', 'admin_users_ch_name.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send('user_id=' + id + "&new_name=" + newName);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					if (xhr.responseText == "0") {
						alert('cannot change user name');
					}
					else {
						elem.parentElement.previousElementSibling.innerHTML = newName;
						elem.previousElementSibling.value = "";
					}
				};
			};

		});
	};

};


window.onload = function() {
	addDelButtons();
	addChNameButtons();

	var filerIdButton = document.getElementById('filter_user_id');
	filerIdButton.addEventListener('click', function() {
		var userId = filerIdButton.previousElementSibling.value;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin_users_filter_user_id.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("filter_type=filter_user_id&user_id=" + userId);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementsByClassName('users')[0].innerHTML = xhr.responseText;	
				addDelButtons();
			};
		};
	});

	var filerLoginButton = document.getElementById('filter_user_login');
	filerLoginButton.addEventListener('click', function() {
		var userLogin = filerLoginButton.previousElementSibling.value;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin_users_filter_user_login.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("filter_type=filter_user_login&user_login=" + userLogin);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementsByClassName('users')[0].innerHTML = xhr.responseText;	
				addDelButtons();
			};
		};
	});

	var createUserButton = document.getElementById("create_user");	
	createUserButton.addEventListener('click', function() {
		var newLogin = document.querySelectorAll(".add-user input")[0].value;
		var newPass  = document.querySelectorAll(".add-user input")[1].value;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin_users_create_user.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("new_login=" + newLogin + "&new_pass=" + newPass);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				if (xhr.responseText =='0') {
					alert('cannot create user');
				}
				else {
					var xhr2 = new XMLHttpRequest();
					xhr2.open("POST", "admin_users_filter_user_id.php", true);
					xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhr2.send("user_id=1&all=1");
					xhr2.onreadystatechange = function() {
						if (xhr2.readyState == 4 && xhr2.status == 200) {
							document.querySelectorAll(".add-user input")[0].value = "";
							document.querySelectorAll(".add-user input")[1].value = "";
							document.getElementsByClassName('users')[0].innerHTML = xhr2.responseText;	
							addDelButtons();
							addChNameButtons();
						}
					}
				}
			};
		};


	});

};