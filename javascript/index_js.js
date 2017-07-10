function addBasketClick() {
	var goodsItems = document.querySelectorAll(".goods-item .goods-foot .goods-add-bskt");
	//var count = 0;
	for (var i = 0; i < goodsItems.length; i++) {
		goodsItems[i].addEventListener('click', function() {
		 	var id = this.parentElement.parentElement.id * 1;
		 	var name = this.parentElement.parentElement.querySelector(".goods-foot .goods-info .goods-info-name").innerText;
		 	var price = this.parentElement.parentElement.querySelector(".goods-foot .goods-price").innerText;
		 	if (confirm("Add to basket item " + name + " for " + price + "?  id(" + id + ")")) {
		 		var xhr = new XMLHttpRequest();
		 		xhr.open('POST', 'add_basket.php', true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send("id=" + id);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status == 200) {
						// alert("we obtained after add basket: " + xhr.responseText);
					}
				};
		 	};
		});
		//alert(goodsItems[i].innerHTML);
		//count++;
	}

	//alert(count);
};

window.onload = function() {
	//alert("14");
	
	var submitButton = document.getElementById("submitButton");
	submitButton.addEventListener("click", function() {
		//alert("6");
		var inputArray = document.forms[0].getElementsByTagName("input");
		var len = inputArray["length"];
		var filterFlags = {"brand" : [], "category" : [], "diagonal" : []};
		
		//var keysFilterFlags = Object.keys(filterFlags);
		
		for (var i = 0; i < len; i++) {
			if (inputArray[i]["type"] == "checkbox") {
				if (inputArray[i]["checked"]) {
					filterFlags[inputArray[i]["name"]].push(inputArray[i]["value"]);
					//alert("name: " + inputArray[i]["name"] + ", value: " + inputArray[i]["value"] + ", checked: " + inputArray[i]["checked"] + ".");	
				}
			}
		};
	
		var str = JSON.stringify(filterFlags);
		// alert("we have such filters: " + str);

		var xhr = new XMLHttpRequest();
		xhr.open("POST", "get_filter_apply.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("json_main=" + str);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				var elem = document.getElementsByClassName("goods")[0];
				elem.innerHTML = xhr.responseText;
				//console.log(xhr.responseText);
				addBasketClick();
			}
		};
	});

	addBasketClick();

};