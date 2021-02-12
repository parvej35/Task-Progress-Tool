/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.14-MariaDB : Database - todo_list_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`todo_list_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `todo_list_db`;

/*Table structure for table `app_user` */

DROP TABLE IF EXISTS `app_user`;

CREATE TABLE `app_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `oauth_provider` enum('Manual','Google','Facebook','Twitter','Linkedin') NOT NULL DEFAULT 'Manual',
  `oauth_uid` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `locale` varchar(1000) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `is_account_verified` tinyint(1) NOT NULL DEFAULT 0,
  `access_token` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `app_user` */

insert  into `app_user`(`id`,`first_name`,`last_name`,`email`,`gender`,`oauth_provider`,`oauth_uid`,`password`,`mobile`,`picture`,`locale`,`created`,`modified`,`is_account_verified`,`access_token`) values 
(1,'Parvej','Ahmed','parvej35@gmail.com','','Google','101305653540934907500',NULL,NULL,'https://lh3.googleusercontent.com/a-/AOh14GjyY8sEa2rcypPVU3yJH9HzQVteaLBISfggCuPxeQ=s96-c','en','2021-02-11 17:24:00','2021-02-12 16:27:59',1,'ya29.a0AfH6SMCkdY2bjyBAxFZqYMNXi2jfWDS3TlfwAOvtw9YHp2cJwH6bIhvtHIubP-JzG2UJYV-htbRTToAYgQRxvJTcoLVvn-YLsXeOy_t13L_s3_flVWckRW30Q5DoNjhOZTgDD_CY1YE0vO14xQowch60k1edmdn5op5zOV-LT3SPbw');

/*Table structure for table `tasks` */

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `topic_id` int(10) NOT NULL,
  `app_user_id` int(10) NOT NULL DEFAULT 0,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `position_id` int(10) NOT NULL DEFAULT 0,
  `status_id` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tasks` */

/*Table structure for table `topic` */

DROP TABLE IF EXISTS `topic`;

CREATE TABLE `topic` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `app_user_id` int(10) NOT NULL DEFAULT 0,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `topic` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
