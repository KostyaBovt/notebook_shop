CREATE TABLE main.goods 
(
	id int(11) NOT NULL AUTO_INCREMENT,
	`brand` VARCHAR(64) NOT NULL,
	`model` VARCHAR(128) NOT NULL,
	`description` VARCHAR(512) NOT NULL,
	`category` VARCHAR(128) NOT NULL,
	`diagonal` VARCHAR(128) NOT NULL,
	`price` FLOAT(11,2) NOT NULL,
	`img` varchar(32) NOT NULL,
	PRIMARY KEY (id)
);