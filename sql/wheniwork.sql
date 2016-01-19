CREATE DATABASE `wheniwork` CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `wheniwork`.`users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` enum('manager','employee') NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `token` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wheniwork`.`shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) unsigned DEFAULT NULL,
  `employee_id` int(11) unsigned DEFAULT NULL,
  `break` float NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `manager_id` (`manager_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `shifts_ibfk_3` FOREIGN KEY (`manager_id`) REFERENCES `wheniwork`.`users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `shifts_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `wheniwork`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
