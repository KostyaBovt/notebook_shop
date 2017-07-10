window.onload = function() {
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