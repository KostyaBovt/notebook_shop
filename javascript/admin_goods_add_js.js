window.onload = function() {
	var addGoodButton = document.getElementById('add_good');
	addGoodButton.addEventListener("click", function() {
		var inputs = document.querySelectorAll(".add-good input");
		var inputs2 = document.querySelectorAll(".add-good textarea");
		var inputArray = {};
		for (var i = 0; i < inputs.length; i++) {
			if (inputs[i].type == "text") {
				inputArray[inputs[i].name] = inputs[i].value;
			}
		}
		inputArray[inputs2[0].name] = inputs2[0].value;
		inputArray = JSON.stringify(inputArray);
		//alert("inputArray before to be send: " + inputArray);

		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin_goods_add_proc.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("json_obj=" + inputArray);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				if (xhr.responseText == "0") {
					alert('cannot add good');
				}
				else {

					alert('good added');
					//alert(xhr.responseText);
					for (var i = 0; i < inputs.length; i++) {
						if (inputs[i].type == "text") {
							inputs[i].value = "";
						}
					}
					inputs2[0].value = "";
				}
			}
		};
	});
};