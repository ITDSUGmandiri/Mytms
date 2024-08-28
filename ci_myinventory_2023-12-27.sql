# ************************************************************
# Sequel Ace SQL dump
# Version 20062
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 11.1.2-MariaDB)
# Database: ci_myinventory
# Generation Time: 2023-12-27 09:09:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ci_sessions
# ------------------------------------------------------------

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`)
VALUES
	('1rs5desnip7rujtv4mti9meccs3mgbro','::1',1700840591,X'5F5F63695F6C6173745F726567656E65726174657C693A313730303834303537373B');

/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `description`)
VALUES
	(1,'admin','Administrator'),
	(2,'members','General User');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table inv_categories
# ------------------------------------------------------------

CREATE TABLE `inv_categories` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = deleted',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `inv_categories` WRITE;
/*!40000 ALTER TABLE `inv_categories` DISABLE KEYS */;

INSERT INTO `inv_categories` (`id`, `code`, `name`, `description`, `deleted`, `created_by`, `created_on`, `updated_by`, `updated_on`)
VALUES
	(1,'1','laptop','<p>-</p>',0,'administrator','2023-11-24 22:40:02','administrator','2023-11-24 22:40:02'),
	(2,'2','personal computer','',0,'administrator','2023-11-24 22:40:18','administrator','2023-11-24 22:40:18'),
	(3,'3','server','',0,'administrator','2023-11-24 22:40:30','administrator','2023-11-24 22:40:30');

/*!40000 ALTER TABLE `inv_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table inv_datas
# ------------------------------------------------------------

CREATE TABLE `inv_datas` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `category_id` int(12) NOT NULL COMMENT 'FK inv_category',
  `location_id` int(12) DEFAULT NULL COMMENT 'FK inv_location',
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `status` int(12) DEFAULT NULL COMMENT 'FK master_status',
  `length` int(12) DEFAULT NULL COMMENT 'Panjang',
  `width` int(12) DEFAULT NULL COMMENT 'Lebar',
  `height` int(12) DEFAULT NULL COMMENT 'Tinggi',
  `weight` int(12) DEFAULT NULL COMMENT 'Berat',
  `color` varchar(20) DEFAULT NULL COMMENT 'Warna',
  `price` int(12) DEFAULT NULL COMMENT 'Harga Beli',
  `date_of_purchase` date DEFAULT NULL COMMENT 'Tgl Beli',
  `photo` text DEFAULT NULL COMMENT 'Foto',
  `thumbnail` text DEFAULT NULL COMMENT 'Thumb',
  `description` text DEFAULT NULL COMMENT 'Keterangan',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `inv_datas` WRITE;
/*!40000 ALTER TABLE `inv_datas` DISABLE KEYS */;

INSERT INTO `inv_datas` (`id`, `code`, `category_id`, `location_id`, `brand`, `model`, `serial_number`, `status`, `length`, `width`, `height`, `weight`, `color`, `price`, `date_of_purchase`, `photo`, `thumbnail`, `description`, `deleted`, `created_by`, `created_on`, `updated_by`, `updated_on`)
VALUES
	(1,'1',1,1,'asus','g200','-',1,0,0,0,0,'Black',8500000,'2023-11-24','1asusg200.jpeg','1asusg200_thumb.jpeg','',0,'administrator','2023-11-24 22:42:40','administrator','2023-11-24 22:42:40');

/*!40000 ALTER TABLE `inv_datas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table inv_locations
# ------------------------------------------------------------

CREATE TABLE `inv_locations` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `detail` text DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `thumbnail` text DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `inv_locations` WRITE;
/*!40000 ALTER TABLE `inv_locations` DISABLE KEYS */;

INSERT INTO `inv_locations` (`id`, `code`, `name`, `detail`, `photo`, `thumbnail`, `deleted`, `created_by`, `created_on`, `updated_by`, `updated_on`)
VALUES
	(1,'1','lantai 1','','1lantai_1.jpeg','1lantai_1_thumb.jpeg',0,'administrator','2023-11-24 22:40:56','administrator','2023-11-24 22:40:56'),
	(2,'2','lantai 2','','2lantai_2.jpeg','2lantai_2_thumb.jpeg',0,'administrator','2023-11-24 22:41:19','administrator','2023-11-24 22:41:19');

/*!40000 ALTER TABLE `inv_locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table inv_log_data_location
# ------------------------------------------------------------

CREATE TABLE `inv_log_data_location` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL COMMENT 'FK inv_datas',
  `location_id` int(12) NOT NULL COMMENT 'FK inv_locations',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `inv_log_data_location` WRITE;
/*!40000 ALTER TABLE `inv_log_data_location` DISABLE KEYS */;

INSERT INTO `inv_log_data_location` (`id`, `code`, `location_id`, `created_by`, `created_on`, `updated_by`, `updated_on`)
VALUES
	(1,'1',1,'administrator','2023-11-24 22:42:40','administrator','2023-11-24 22:42:40');

/*!40000 ALTER TABLE `inv_log_data_location` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table inv_log_data_status
# ------------------------------------------------------------

CREATE TABLE `inv_log_data_status` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL COMMENT 'FK inv_datas',
  `status_id` int(12) NOT NULL COMMENT 'FK inv_status',
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `inv_log_data_status` WRITE;
/*!40000 ALTER TABLE `inv_log_data_status` DISABLE KEYS */;

INSERT INTO `inv_log_data_status` (`id`, `code`, `status_id`, `created_by`, `created_on`, `updated_by`, `updated_on`)
VALUES
	(1,'1',1,'administrator','2023-11-24 22:42:40','administrator','2023-11-24 22:42:40');

/*!40000 ALTER TABLE `inv_log_data_status` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table inv_status
# ------------------------------------------------------------

CREATE TABLE `inv_status` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `inv_status` WRITE;
/*!40000 ALTER TABLE `inv_status` DISABLE KEYS */;

INSERT INTO `inv_status` (`id`, `name`, `description`, `deleted`, `created_by`, `created_on`, `updated_by`, `updated_on`)
VALUES
	(1,'In Use','<p>Aktif digunakan</p>',0,'administrator','2018-04-13 11:16:07','administrator','2018-04-13 11:16:07'),
	(2,'Not Used','<p>Tidak digunakan</p>',0,'administrator','2018-04-13 11:17:25','administrator','2018-04-13 11:17:25'),
	(3,'In Repair','<p>Status barang masih dalam perbaikan</p>',0,'administrator','2018-04-18 16:34:43','administrator','2018-04-18 16:35:05');

/*!40000 ALTER TABLE `inv_status` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table login_attempts
# ------------------------------------------------------------

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`)
VALUES
	(2,'::1','admin',1703665048);

/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table master_color
# ------------------------------------------------------------

CREATE TABLE `master_color` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `master_color` WRITE;
/*!40000 ALTER TABLE `master_color` DISABLE KEYS */;

INSERT INTO `master_color` (`id`, `name`, `deleted`, `created_by`, `created_on`, `updated_by`, `updated_on`)
VALUES
	(1,'Black',0,'administrator','2018-04-03 16:30:13','administrator','2018-04-03 16:30:13'),
	(2,'White',0,'administrator','2018-04-13 10:48:13','administrator','2018-04-13 10:48:13'),
	(3,'Grey',0,'administrator','2018-04-13 11:32:37','administrator','2018-04-18 15:38:32'),
	(4,'Blue',0,'administrator','2018-04-13 11:32:44','administrator','2018-04-18 15:38:24'),
	(5,'Red',0,'administrator','2018-04-18 15:37:57','administrator','2018-04-18 15:37:57'),
	(6,'Brown',0,'administrator','2018-05-09 10:56:40','administrator','2018-05-09 10:56:40'),
	(7,'Yellow',0,'administrator','2018-05-09 11:02:17','administrator','2018-05-09 11:02:17'),
	(8,'Black White',0,'administrator','2018-05-11 09:43:40','administrator','2018-05-11 09:43:40'),
	(9,'Green',0,'administrator','2018-05-18 15:13:17','administrator','2018-05-18 15:13:17');

/*!40000 ALTER TABLE `master_color` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `phone`)
VALUES
	(1,'127.0.0.1','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,NULL,'gGSTNbCuCI/8jRvE.dfQZ.',1268889823,1703667320,1,'System','Administrator','01234567');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `after_users_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	INSERT INTO users_photo VALUES( NEW.username, "no_picture.png", "no_picture.png", now());
    END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table users_groups
# ------------------------------------------------------------

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`)
VALUES
	(5,1,1),
	(6,1,2);

/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_photo
# ------------------------------------------------------------

CREATE TABLE `users_photo` (
  `username` varchar(100) NOT NULL,
  `photo` text DEFAULT NULL,
  `thumbnail` text DEFAULT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `users_photo` WRITE;
/*!40000 ALTER TABLE `users_photo` DISABLE KEYS */;

INSERT INTO `users_photo` (`username`, `photo`, `thumbnail`, `updated_on`)
VALUES
	('administrator','ADMINISTRATOR.jpg','ADMINISTRATOR_thumb.jpg','2017-12-08 14:02:41');

/*!40000 ALTER TABLE `users_photo` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
