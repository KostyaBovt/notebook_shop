window.onload = function() {
	//deleting item form basket:
	var delButtonsArray = document.querySelectorAll(".tb-del img");
	for (var i = 0; i < delButtonsArray.length; i++) {
		delButtonsArray[i].addEventListener('click', function() {
			var id = this.parentElement.parentElement.id;
			var elem = this;
			//alert('Element with id=' + id + " to be deleted!");

			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'del_basket.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("id=" + id);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					var response = JSON.parse(xhr.responseText);
					//alert("we receive form server: " + xhr.responseText);
					//alert(" parsed: Q_ty: " + response["q_ty"] + ". Amount : " + response["amount"] + ". Total amount: " + response["t_amount"]);
					if (response["q_ty"] == 0) {
						elem.parentElement.parentElement.remove();
						document.querySelector("#tb-footer .tb-amount").innerText = response["t_amount"] + ".00";

					}
					else {
						elem.parentElement.parentElement.getElementsByClassName("tb-qty")[0].innerText = response["q_ty"];
						elem.parentElement.parentElement.getElementsByClassName("tb-amount")[0].innerText = response["amount"] + ".00";
						document.querySelector("#tb-footer .tb-amount").innerText = response["t_amount"] + ".00";
					};

					if (response["t_amount"] == 0) {
						document.querySelector(".basket").remove();
						document.querySelector("#empty").innerHTML = "<span id='empty'>Basket is empty</span>";
					}
				};
			};
		});
	};

	//confirm order:
	var orderButt = document.getElementById("order-butt");
	orderButt.addEventListener("click", function() {
		//alert("order!");
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'make_order.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("");
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				if (xhr.responseText == "0")
					alert("Please outhorize or register to confirm order");
				else {
					//alert("order success");
					document.getElementById("order-butt").outerHTML = '<button id="order-butt-res" type="button">The order successfully sent! See it your account! </button>';
					var delButtonsArray = document.querySelectorAll(".tb-del img");
					for (var i = 0; i < delButtonsArray.length; i++) {
						delButtonsArray[i].remove();
					};
				};

			};
		};

	});




};