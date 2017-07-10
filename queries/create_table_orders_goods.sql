CREATE TABLE main.orders_goods
(
	id int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`good_id` int(11) NOT NULL,
	`good_qty` int(11) NOT NULL,
	`good_price` int(11) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (`order_id`) REFERENCES main.orders(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`good_id`) REFERENCES main.goods(`id`) ON DELETE CASCADE
);