# netwatcher

Application for monitoring a LAN network

Installation instructions for DB in mysql:


CREATE DATABASE netwatch;

USE DATABASE netwatch;

CREATE TABLE `Machine` (
	`Name` VARCHAR(90) NULL DEFAULT NULL,
	`MAC` VARCHAR(90) NULL DEFAULT NULL
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
