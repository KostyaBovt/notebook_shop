CREATE TABLE main.orders 
(
	id int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (`user_id`) REFERENCES main.users(`id`) ON DELETE CASCADE
);