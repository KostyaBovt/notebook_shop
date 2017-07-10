function addHeaderListners() {
	var ordersHeader = document.getElementsByClassName("order-header");
	for (var i = 0; i < ordersHeader.length; i++) {
		ordersHeader[i].addEventListener("click", function() {
			var currElem = this.nextElementSibling;
			var style = getComputedStyle(currElem);
			if (style.display == "block")
			 	currElem.style.display = "none";
			else if (style.display == "none")
			 	currElem.style.display = "block";
		});
	}
}


window.onload = function() {
	addHeaderListners();

	var expandeButton = document.getElementById("expande");
	expandeButton.addEventListener("click", function() {
		var ordersHeader = document.getElementsByClassName("order-header");
		for (var i = 0; i < ordersHeader.length; i++) {
			var currElem = ordersHeader[i].nextElementSibling;
			var style = getComputedStyle(currElem);
			currElem.style.display = "block";
		}		
	});

	var collapseButton = document.getElementById("collapse");
	collapseButton.addEventListener("click", function() {
		var ordersHeader = document.getElementsByClassName("order-header");
		for (var i = 0; i < ordersHeader.length; i++) {
			var currElem = ordersHeader[i].nextElementSibling;
			var style = getComputedStyle(currElem);
			currElem.style.display = "none";
		}		
	});

	var filterUserIdButt = document.getElementById('filter_user_id');
	filterUserIdButt.addEventListener("click", function() {
		var userId = document.forms['filter_user_id'].querySelectorAll('input')[0].value;
		//alert(userId);

		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin_orders_filter_user_id.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("filter_type=filter_user_id&user_id=" + userId);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				var elem = document.getElementsByClassName("orders")[0];
				elem.innerHTML = xhr.responseText;
				addHeaderListners();
			}
		};	
	});

	var filterUserLoginButt = document.getElementById('filter_user_login');
	filterUserLoginButt.addEventListener("click", function() {
		var userLogin = document.forms['filter_user_login'].querySelectorAll('input')[0].value;
		//alert(userLogin);

		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin_orders_filter_user_login.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("filter_type=filter_user_login&user_login=" + userLogin);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				var elem = document.getElementsByClassName("orders")[0];
				elem.innerHTML = xhr.responseText;
				addHeaderListners();
			}
		};	
	});

	var filterOrderIdButt = document.getElementById('filter_order_id');
	filterOrderIdButt.addEventListener("click", function() {
		var orderId = document.forms['filter_order_id'].querySelectorAll('input')[0].value;
		//alert(orderId);

		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin_orders_filter_order_id.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("filter_type=filter_order_id&order_id=" + orderId);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				var elem = document.getElementsByClassName("orders")[0];
				elem.innerHTML = xhr.responseText;
				addHeaderListners();
			}
		};	
	});



}