/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.4.21-MariaDB : Database - spourt_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`spourt_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

/*Table structure for table `tbl_cart` */

DROP TABLE IF EXISTS `tbl_cart`;

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(16) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `grand_total` float DEFAULT NULL,
  `delivery_charges` decimal(4,2) DEFAULT 4.95,
  `cart_status` enum('In Progress','Close','Cancel') DEFAULT 'In Progress',
  `create_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_cart` */

insert  into `tbl_cart`(`cart_id`,`session_id`,`total`,`discount`,`grand_total`,`delivery_charges`,`cart_status`,`create_date`) values (3,'ks92isi6eyvpobvi',238.45,53.325,185.125,'0.00','Close','2022-10-24 17:21:25'),(4,'km5tcsvlk3ulkkt7',115.8,24.95,90.85,'0.00','Close','2022-10-24 17:21:25'),(5,'mq5c2m7v6ik3hu13',NULL,NULL,NULL,'4.95','In Progress','2022-10-24 17:21:25');

/*Table structure for table `tbl_cartitems` */

DROP TABLE IF EXISTS `tbl_cartitems`;

CREATE TABLE `tbl_cartitems` (
  `cart_id` int(11) NOT NULL,
  `product_code` varchar(4) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_id`,`product_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_cartitems` */

insert  into `tbl_cartitems`(`cart_id`,`product_code`,`quantity`) values (3,'B01',4),(3,'G01',3),(3,'R01',4),(4,'G01',2),(4,'R01',2);

/*Table structure for table `tbl_products` */

DROP TABLE IF EXISTS `tbl_products`;

CREATE TABLE `tbl_products` (
  `product_name` varchar(150) DEFAULT NULL,
  `product_code` varchar(5) NOT NULL,
  `product_price` float DEFAULT NULL,
  PRIMARY KEY (`product_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_products` */

insert  into `tbl_products`(`product_name`,`product_code`,`product_price`) values ('Blue Widget','B01',7.95),('Green Widget ','G01',24.95),('Red Widget','R01',32.95);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
