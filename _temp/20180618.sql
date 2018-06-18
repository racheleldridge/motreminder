/*
SQLyog Community v12.01 (64 bit)
MySQL - 5.0.51b-community-nt : Database - motreminder_re
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`motreminder_re` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `motreminder_re`;

/*Table structure for table `car` */

DROP TABLE IF EXISTS `car`;

CREATE TABLE `car` (
  `car_reg` varchar(10) NOT NULL,
  `colour` varchar(30) NOT NULL,
  `make` varchar(30) NOT NULL,
  `reminder_days` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `people_no` int(11) NOT NULL,
  PRIMARY KEY  (`car_reg`,`reminder_days`,`people_no`),
  KEY `people` (`people_no`),
  CONSTRAINT `people` FOREIGN KEY (`people_no`) REFERENCES `people` (`people_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `car` */

/*Table structure for table `people` */

DROP TABLE IF EXISTS `people`;

CREATE TABLE `people` (
  `people_no` int(11) NOT NULL auto_increment,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `activated` bit(1) NOT NULL default '\0',
  `pwd` varchar(50) NOT NULL,
  `activation_code` char(50) NOT NULL,
  `date_signed_up` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `date_activated` datetime default NULL,
  `last_sign_in` datetime default NULL,
  `last_update` datetime default NULL,
  `ip_address` varchar(20) default NULL,
  PRIMARY KEY  (`people_no`),
  UNIQUE KEY `EMAIL` (`email`),
  UNIQUE KEY `ACTIVATION` (`activation_code`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `people` */

insert  into `people`(`people_no`,`first_name`,`last_name`,`email`,`activated`,`pwd`,`activation_code`,`date_signed_up`,`date_activated`,`last_sign_in`,`last_update`,`ip_address`) values (25,'R','Eldridge','racheleldridge99@gmail.com','','5f4dcc3b5aa765d61d8327deb882cf99','cVINA1TIqiriq5PDPf2kk7ws9xfD1RHVaUPXh37NB7w3QtwOeV','2018-06-14 14:51:38',NULL,NULL,NULL,NULL),(26,'First','Last','nativebreed@hotmail.com','','03a31e4e429cbfc6cc6470bb9bfdf6fe','fUaPGKnmu5AOhE7G9GPVFS30WsETz9X3EaOtKezCZy4qXREpJm','2018-06-18 09:18:30',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
