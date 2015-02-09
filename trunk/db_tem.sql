/*
SQLyog Ultimate - MySQL GUI v8.21 
MySQL - 5.6.17 : Database - db_cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_cms` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_cms`;

/*Table structure for table `cms_exchange` */

DROP TABLE IF EXISTS `cms_exchange`;

CREATE TABLE `cms_exchange` (
  `in` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` tinyint(4) DEFAULT NULL,
  `is_single` tinyblob COMMENT '1 = single,0 multi exchange',
  `receive_amount` tinyint(4) DEFAULT NULL,
  `return_amount` tinyint(4) DEFAULT NULL,
  `date` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `user_id` tinyint(4) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `invoice_code` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`in`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cms_exchange` */

/*Table structure for table `cms_exchange_detail` */

DROP TABLE IF EXISTS `cms_exchange_detail`;

CREATE TABLE `cms_exchange_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `exchange_id` int(11) DEFAULT NULL,
  `changed_amount` double DEFAULT NULL,
  `from_amount` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `recieved_amount` double DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `to_amount` double DEFAULT NULL,
  `to_currency_type` varchar(1) DEFAULT NULL,
  `from_currency_type` varchar(1) DEFAULT NULL,
  `from_to` varchar(20) DEFAULT NULL,
  `recieved_type` varchar(1) DEFAULT NULL,
  `specail_customer` tinyint(1) DEFAULT '0' COMMENT '0: normal, 1 : specail customer set new rate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `cms_exchange_detail` */

insert  into `cms_exchange_detail`(`id`,`exchange_id`,`changed_amount`,`from_amount`,`rate`,`recieved_amount`,`status`,`date`,`to_amount`,`to_currency_type`,`from_currency_type`,`from_to`,`recieved_type`,`specail_customer`) values (1,NULL,0,10,3990,10,'in','2014-10-10',39900,'R','$','ដុល្លា - រៀល','$',0),(2,NULL,0,1000,120.6,1000,'in','2014-10-10',120600,'R','B','បាត - រៀល','B',0),(3,NULL,0,100,3990,100,'in','2014-10-13',399000,'R','$','ដុល្លា - រៀល','$',0),(4,NULL,0,1000000,4000,1000000,'out','2014-10-13',250,'$','R','រៀល - ដុល្លា','R',0),(5,NULL,0,100,3990,100,'in','2014-10-14',399000,'R','$','ដុល្លា - រៀល','$',0),(6,NULL,0,200,3990,200,'in','2014-10-14',798000,'R','$','ដុល្លា - រៀល','$',0),(7,NULL,0,2000,120.6,2000,'in','2014-10-14',241200,'R','B','បាត - រៀល','B',0);

/*Table structure for table `cms_exchangerate` */

DROP TABLE IF EXISTS `cms_exchangerate`;

CREATE TABLE `cms_exchangerate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `in_cur_id` int(11) DEFAULT NULL COMMENT 'The Currency that we take from customer',
  `out_cur_id` int(11) DEFAULT NULL COMMENT 'The Currency that we give to customer',
  `rate_in` double DEFAULT NULL,
  `rate_out` double DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL COMMENT '1:active; 0:Disactive',
  `is_using` tinyint(4) DEFAULT NULL,
  `user_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cms_exchangerate` */

insert  into `cms_exchangerate`(`id`,`in_cur_id`,`out_cur_id`,`rate_in`,`rate_out`,`create_date`,`active`,`is_using`,`user_id`) values (1,1,2,32.9,33,'2014-02-03 12:07:58',1,NULL,NULL),(2,1,3,3990,4000,'2014-02-03 12:07:58',1,NULL,NULL),(3,2,3,120.6,121,'2014-02-03 12:07:58',1,NULL,NULL);

/*Table structure for table `cms_income_expense` */

DROP TABLE IF EXISTS `cms_income_expense`;

CREATE TABLE `cms_income_expense` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `decription` text,
  `total_amount` float(12,2) DEFAULT NULL,
  `fordate` int(11) DEFAULT NULL COMMENT '1to 12',
  `disc` text,
  `date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1use,1unuse',
  `user_id` int(11) DEFAULT NULL,
  `tran_type` tinyint(4) DEFAULT NULL COMMENT '1 expense,2 income',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cms_income_expense` */

/*Table structure for table `cms_keeping` */

DROP TABLE IF EXISTS `cms_keeping`;

CREATE TABLE `cms_keeping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_name` tinyint(4) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `date_keeping` date DEFAULT NULL,
  `amount_keeping` tinyint(4) DEFAULT NULL,
  `epx_date` date DEFAULT NULL,
  `invoice_numer` float DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `cms_keeping` */

insert  into `cms_keeping`(`id`,`client_name`,`payment_term`,`date_keeping`,`amount_keeping`,`epx_date`,`invoice_numer`,`status`) values (19,2,2,'2015-01-16',1,'2015-01-16',2,NULL),(20,3,3,'2015-01-16',3,'2015-01-31',3,NULL);

/*Table structure for table `cms_keepingdetail` */

DROP TABLE IF EXISTS `cms_keepingdetail`;

CREATE TABLE `cms_keepingdetail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keeping_id` int(11) DEFAULT NULL,
  `currency_type` tinyint(4) DEFAULT NULL,
  `money_inacc` float DEFAULT NULL,
  `cut_money` tinyint(4) DEFAULT NULL,
  `commission` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `recieve_amount` float DEFAULT NULL,
  `lbltotal_return` float DEFAULT NULL,
  `note` float DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

/*Data for the table `cms_keepingdetail` */

insert  into `cms_keepingdetail`(`id`,`keeping_id`,`currency_type`,`money_inacc`,`cut_money`,`commission`,`total_amount`,`recieve_amount`,`lbltotal_return`,`note`,`status`) values (27,19,1,1,1,1,1,1,1,1,NULL),(28,NULL,1,1,0,1,1,1,1,1,NULL),(29,NULL,2,2,1,2,2,2,2,2,NULL),(30,NULL,3,2,0,2,2,2,2,2,NULL),(31,20,1,3,1,3,3,3,3,3,NULL);

/*Table structure for table `cms_partner` */

DROP TABLE IF EXISTS `cms_partner`;

CREATE TABLE `cms_partner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `partner_brand` varchar(100) DEFAULT NULL,
  `partner_name` varbinary(50) DEFAULT NULL,
  `account_no` varchar(20) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `nation_id` varchar(20) DEFAULT NULL,
  `house_no` varchar(40) DEFAULT NULL,
  `group_no` varchar(40) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `commune` int(11) DEFAULT NULL,
  `district` int(11) DEFAULT NULL,
  `province` int(11) DEFAULT NULL,
  `tel` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `note` text,
  `is_cashoperation` tinyint(4) DEFAULT NULL COMMENT '1=use with cash in account',
  `cash_riel` float(12,2) DEFAULT NULL,
  `cash_dollar` float(12,2) DEFAULT NULL,
  `cash_bath` float(12,2) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `cms_partner` */

insert  into `cms_partner`(`id`,`parent`,`partner_brand`,`partner_name`,`account_no`,`photo`,`nation_id`,`house_no`,`group_no`,`street`,`commune`,`district`,`province`,`tel`,`mobile`,`status`,`note`,`is_cashoperation`,`cash_riel`,`cash_dollar`,`cash_bath`,`date`,`user_id`) values (2,2,'saa exchange','ហេង','098833333222',NULL,'9988833',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,'sara exchange','','',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,1,'narith exchange','','',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,1,'sok exchange','','',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,1,'vireak exchange','','',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `cms_partner_deposit` */

DROP TABLE IF EXISTS `cms_partner_deposit`;

CREATE TABLE `cms_partner_deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `cms_partner_deposit` */

insert  into `cms_partner_deposit`(`id`,`partner_id`,`date`,`user_id`,`status`,`note`) values (1,4,'2015-01-01',100,100,'4'),(2,5,'2015-01-06',NULL,NULL,'111'),(16,6,'2015-01-07',NULL,NULL,'7'),(17,5,'2015-01-14',NULL,NULL,'bbbb'),(18,4,'2015-01-14',NULL,1,'222'),(19,4,'2015-01-14',1,1,'22'),(20,2,'2015-01-14',1,1,'333'),(21,3,'2015-01-14',1,1,'333');

/*Table structure for table `cms_partnerdeposit_detail` */

DROP TABLE IF EXISTS `cms_partnerdeposit_detail`;

CREATE TABLE `cms_partnerdeposit_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `currency_type` int(11) DEFAULT NULL,
  `deposite_amount` float(12,2) DEFAULT NULL,
  `receive_amount` float(12,2) DEFAULT NULL,
  `return_amount` float(12,2) DEFAULT NULL,
  `note` text,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `cms_partnerdeposit_detail` */

insert  into `cms_partnerdeposit_detail`(`id`,`pd_id`,`date`,`currency_type`,`deposite_amount`,`receive_amount`,`return_amount`,`note`,`status`) values (7,14,2015,2,1.00,35.00,15.00,'222',NULL),(9,15,2015,2,1.00,222.00,222.00,'222',NULL),(10,16,2015,2,1.00,7000.00,7000.00,'7000',NULL),(11,17,2015,1,1.00,100.00,0.00,'',NULL),(12,18,2015,1,1.00,22.00,0.00,'',NULL),(13,19,2015,1,1.00,22.00,0.00,'',NULL),(14,20,2015,1,1.00,400.00,0.00,'333',NULL),(15,20,2015,1,1.00,400.00,0.00,'333',NULL),(16,21,2015,1,333.00,333.00,0.00,'ssss',NULL),(17,21,2015,2,100.00,100.00,0.00,'wqdQSDasdaSD',NULL);

/*Table structure for table `cms_withdraw` */

DROP TABLE IF EXISTS `cms_withdraw`;

CREATE TABLE `cms_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` text,
  `date_withdraw` date DEFAULT NULL,
  `riel_before` float(12,2) DEFAULT NULL,
  `dollar_before` float(12,2) DEFAULT NULL,
  `bath_before` float(12,2) DEFAULT NULL,
  `withdraw_riel` float(12,2) DEFAULT NULL,
  `withdraw_dollar` float(12,2) DEFAULT NULL,
  `withdraw_bat` float(12,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `cms_withdraw` */

insert  into `cms_withdraw`(`id`,`partner_id`,`date`,`note`,`date_withdraw`,`riel_before`,`dollar_before`,`bath_before`,`withdraw_riel`,`withdraw_dollar`,`withdraw_bat`,`status`) values (1,2,'2015-01-03','666',NULL,66.00,666.00,66.00,7.00,67.00,9.00,NULL),(12,6,'2015-01-04','tata',NULL,780.00,123.00,359.00,100.00,100.00,100.00,NULL);

/*Table structure for table `cs_agents` */

DROP TABLE IF EXISTS `cs_agents`;

CREATE TABLE `cs_agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `block` varchar(255) DEFAULT NULL,
  `house_no` varchar(10) DEFAULT NULL,
  `group_no` varchar(10) DEFAULT NULL,
  `street_no` varchar(255) DEFAULT NULL,
  `sangkat` varchar(255) DEFAULT NULL,
  `khan` varchar(255) DEFAULT NULL,
  `province` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

/*Data for the table `cs_agents` */

insert  into `cs_agents`(`id`,`name`,`code`,`tel`,`fax`,`hp`,`block`,`house_no`,`group_no`,`street_no`,`sangkat`,`khan`,`province`,`active`) values (1,'ឆេងលីម26','001','061657722','023215363','095617722','ខាងត្បូងផ្សារអូរឡាំពិច','26','','','','',1,1),(2,'ចេងវណ្ណា80','002','017831113','023218512','','ខាងត្បូងផ្សារអូរឡាំពិច','80','','','','',1,1),(3,'អៀហាវ52','003','012380093','023219461','','ខាងត្បូងផ្សារអូរឡាំពិច','52','','','','',1,1),(4,'ជាគាង40','004','012487853','023987462','','ខាងត្បូងផ្សារអូរឡាំពិច','40','','','','',1,1),(5,'ហ៊ាឃុង54.012266719','005','012266719','053953747','0535550031','','54','','','','',21,1),(6,'ចៅយីវថង87','006','012876502','053953440','','','87','','','','',21,1),(7,'វិញវ៉ា','007','012978097','063964326','','','','','','','',13,1),(8,'អ៊ឹងប៊ុនហ៊ី66','008','012838199','054710347','','','66','','','','',22,1),(9,'ឡៅពួយឃាង05','009','012837239','054958945','','','05','','','','',22,1),(10,'ជាងអូន48(1)','010','012690523','055210332','','','48','','','','',9,1),(11,'ហ៊ាងីន(1)','011','012826661','052951500','','','','','','','',14,1),(12,'លីឡេង77(1)','012','092554255','053211003','','','','','','','',21,1),(13,'ថៃពៅ(1)','013','092284023','042942039','','','','','','','',3,1),(14,'សួងM67(1)','014','012900767','','','','','','','','',3,1),(15,'រ៉ា26ស្ទោង(1)','015','092307167','','','','','','','','',5,1),(16,'ដារ៉ាអូររាំងឪ(1)','016','012903303','','','','','','','','',3,1),(17,'ឡាយប៊ុនភាព74(1)','017','011452045','053952287','','','74','','','','',21,1),(18,'ឈួនសុខហៀង','018','017432323','','','','','','','','',22,1),(27,'សំពៅលួន-ខ្លាស(1)','','012391161','','','','','','','','',21,1),(28,'ខេង-មង្គលបុរី(1)','','092624101','','','','','','','','',22,1),(23,'ហ៊ុយគាង(0.7)','19','017378787','','','','','','','','',28,1),(24,'ណាស់សំណាង15A','020','012912657','','','','','','','','',22,1),(25,'KBANK5042062784','021','017818114','','','','','','','','',27,1),(26,'SCB8602069644','022','017818114','','','','','','','','',27,1),(29,'ពោធិ៏រៀង-ពួក(1)','','012901499','','','','','','','','',13,1),(34,'ពូឌី','050','077431313','','','','','','','','',28,1),(30,'តុងយូ36','','085303303','023211250','','','','','','','',1,1),(31,'កុកឃាង60','','012910035','023212896','','','','','','','',1,1),(32,'ហេងផេង34','','012596979','023213921','','','','','','','',1,1),(33,'អ៊ីអូន','','012927323','','','','','','','','',28,1),(35,'Ving','','092515555','','','','','','','','',28,1),(36,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(37,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(38,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);

/*Table structure for table `cs_borrow` */

DROP TABLE IF EXISTS `cs_borrow`;

CREATE TABLE `cs_borrow` (
  `b_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) DEFAULT NULL,
  `invoice` varchar(20) DEFAULT NULL,
  `loan_date` date DEFAULT NULL,
  `user_id` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1:new borrow, 2:remain, 3:payouted',
  `is_allinterest` tinyint(4) DEFAULT NULL COMMENT '1=ការប្រាក់រួម,0ផ្សេងគ្នា',
  `delete_status` tinyint(4) DEFAULT '0' COMMENT '0:use, 1:stop use',
  `is_orgdebt` tinyint(4) DEFAULT '0' COMMENT '1=add,0 =remail from fund',
  PRIMARY KEY (`b_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `cs_borrow` */

insert  into `cs_borrow`(`b_id`,`sender_id`,`invoice`,`loan_date`,`user_id`,`status`,`is_allinterest`,`delete_status`,`is_orgdebt`) values (1,3,'LN-8F5242','2014-11-10',1,1,1,0,1),(2,3,'PO-377571','2014-11-10',1,2,1,0,0),(3,3,'PO-0CEDC8','2014-11-10',1,2,1,0,0),(4,3,'PO-0CEDC8','2014-11-10',1,2,1,0,0),(5,3,'LN-4CD9A7','2014-11-10',1,1,1,0,1),(6,3,'PO-5364C4','2014-11-10',1,2,1,0,0),(7,3,'PO-5364C4','2014-11-10',1,2,1,0,0);

/*Table structure for table `cs_borrow_detail` */

DROP TABLE IF EXISTS `cs_borrow_detail`;

CREATE TABLE `cs_borrow_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `br_id` int(11) DEFAULT NULL,
  `currency_type` tinyint(4) DEFAULT NULL,
  `laon_rate` float(5,2) DEFAULT NULL,
  `total_money` float(10,2) DEFAULT NULL COMMENT 'សំរាប់ប្រាក់ទើបជំពាក់ថ្មី',
  `loan_amount` float(15,2) DEFAULT NULL COMMENT 'ប្រាក់ជំពាក់សរុបទាំងអស់',
  `BD` float(10,2) DEFAULT NULL,
  `RD` float(10,2) DEFAULT NULL,
  `RB` float(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `delete_status` tinyint(4) DEFAULT '0' COMMENT '0:use, 1:stop use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `cs_borrow_detail` */

insert  into `cs_borrow_detail`(`id`,`br_id`,`currency_type`,`laon_rate`,`total_money`,`loan_amount`,`BD`,`RD`,`RB`,`status`,`delete_status`) values (1,1,1,2.00,1000.00,1000.00,33.00,4000.00,121.00,3,0),(2,1,2,2.00,4000.00,4000.00,33.00,4000.00,121.00,3,0),(3,2,1,2.00,900.00,900.00,33.00,4000.00,121.00,3,0),(4,3,1,2.00,800.00,800.00,33.00,4000.00,121.00,3,0),(5,4,2,2.00,3000.00,3000.00,33.00,4000.00,121.00,3,0),(6,5,1,2.00,10.00,810.00,33.00,4000.00,121.00,3,0),(7,5,2,2.00,10.00,3010.00,33.00,4000.00,121.00,3,0),(8,6,1,2.00,800.00,800.00,33.00,4000.00,121.00,2,0),(9,7,2,2.00,3000.00,3000.00,33.00,4000.00,121.00,2,0);

/*Table structure for table `cs_capital_detail` */

DROP TABLE IF EXISTS `cs_capital_detail`;

CREATE TABLE `cs_capital_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tran_id` int(11) DEFAULT NULL,
  `tran_type` tinyint(3) unsigned NOT NULL COMMENT '1=capital,2=transfer,3=exchange,4=kbank,5=loan,6=payment,7=withdraw,8= debt remain',
  `curr_type` tinyint(4) DEFAULT '1' COMMENT '1=dollar,2=bath,3=riel',
  `amount` float(15,2) DEFAULT NULL,
  `sign` tinyint(4) DEFAULT '1' COMMENT '1=increase,0 = decrease',
  `date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1=use,0= unused',
  `income` tinyint(4) DEFAULT '1' COMMENT '1= ប្រើប្រាស់លុយ,0 = មិនប្រើប្រាស់លុយ សំរាប់តែតត់ត្រាប៉ុន្នោះ',
  `user_id` tinyint(4) DEFAULT NULL COMMENT 'សំរាប់ Agent ណា',
  PRIMARY KEY (`id`,`tran_type`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `cs_capital_detail` */

insert  into `cs_capital_detail`(`id`,`tran_id`,`tran_type`,`curr_type`,`amount`,`sign`,`date`,`status`,`income`,`user_id`) values (1,1,5,1,1000.00,0,'2014-11-10',1,1,1),(2,2,5,2,2000.00,0,'2014-11-10',1,1,1),(3,1,8,1,100.00,1,'2014-11-10',1,1,1),(4,2,8,1,100.00,1,'2014-11-10',1,1,1),(5,3,8,2,100.00,1,'2014-11-10',1,1,1),(6,6,5,1,200.00,0,'2014-11-10',1,1,1),(7,7,5,2,100.00,0,'2014-11-10',1,1,1),(8,1,2,1,1000.00,1,'2014-11-10',1,0,1),(9,2,2,2,3000.00,1,'2014-11-10',1,0,1),(10,1,6,1,100.00,1,'2014-11-10',1,1,1),(11,2,6,2,100.00,1,'2014-11-10',1,1,1),(12,8,5,1,100.00,0,'2014-11-10',1,1,1),(13,9,5,2,100.00,0,'2014-11-10',1,1,1),(14,1,5,1,1000.00,0,'2014-11-10',1,1,1),(15,2,5,2,4000.00,0,'2014-11-10',1,1,1),(16,1,8,1,100.00,1,'2014-11-10',1,1,1),(17,2,8,1,100.00,1,'2014-11-10',1,1,1),(18,3,8,2,1000.00,1,'2014-11-10',1,1,1),(19,6,5,1,10.00,0,'2014-11-10',1,1,1),(20,7,5,2,10.00,0,'2014-11-10',1,1,1),(21,4,8,1,10.00,1,'2014-11-10',1,1,1),(22,5,8,2,10.00,1,'2014-11-10',1,1,1),(23,9,3,2,200.00,1,'2014-11-20',1,1,1),(24,9,3,3,24120.00,0,'2014-11-20',1,1,1),(25,10,3,1,300.00,1,'2014-11-20',1,1,1),(26,10,3,3,1197000.00,0,'2014-11-20',1,1,1),(27,27,1,1,1000.00,1,'2014-11-24',1,1,30),(28,28,1,2,1000000.00,1,'2014-11-24',1,1,30),(29,29,1,3,20000000.00,1,'2014-11-24',1,1,30),(30,30,1,1,1000.00,1,'2014-11-24',1,1,1),(31,31,1,2,200000.00,1,'2014-11-24',1,1,1),(32,32,1,3,3000000.00,1,'2014-11-24',1,1,1);

/*Table structure for table `cs_countries` */

DROP TABLE IF EXISTS `cs_countries`;

CREATE TABLE `cs_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cs_countries` */

insert  into `cs_countries`(`id`,`name`) values (1,'អាមេរិក'),(2,'ថៃ'),(3,'កម្ពុជា');

/*Table structure for table `cs_currencies` */

DROP TABLE IF EXISTS `cs_currencies`;

CREATE TABLE `cs_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `symbol` varchar(5) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cs_currencies` */

insert  into `cs_currencies`(`id`,`name`,`symbol`,`country_id`) values (1,'ដុល្លា','$',1),(2,'បាត','B',2),(3,'រៀល','R',3);

/*Table structure for table `cs_current_capital` */

DROP TABLE IF EXISTS `cs_current_capital`;

CREATE TABLE `cs_current_capital` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `currencyType` int(10) unsigned DEFAULT NULL,
  `statusDate` date DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `userid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cs_current_capital` */

/*Table structure for table `cs_current_capital_agent` */

DROP TABLE IF EXISTS `cs_current_capital_agent`;

CREATE TABLE `cs_current_capital_agent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `currencyType` int(10) unsigned DEFAULT NULL,
  `statusDate` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `agent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

/*Data for the table `cs_current_capital_agent` */

/*Table structure for table `cs_deposit` */

DROP TABLE IF EXISTS `cs_deposit`;

CREATE TABLE `cs_deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` varchar(30) DEFAULT NULL,
  `extend_from` int(11) DEFAULT NULL COMMENT 'extend from tran id',
  `sender_id` int(11) DEFAULT NULL,
  `pay_term` tinyint(4) DEFAULT NULL COMMENT '0=week,1=month',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount_month` float DEFAULT NULL,
  `money_type` tinyint(4) DEFAULT NULL,
  `money_inaccount_org` float(10,2) DEFAULT NULL,
  `money_inaccount` float(10,2) unsigned DEFAULT NULL COMMENT 'money after withdraw ,or extend',
  `commission` float(10,2) DEFAULT NULL,
  `total_amount` float(10,2) DEFAULT NULL COMMENT 'total money in acc+commission',
  `recieve_amount` float(10,2) DEFAULT NULL COMMENT 'recieve from customer',
  `total_return` float(10,2) DEFAULT '0.00',
  `recieve_province` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `sub_agent_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `is_expired` tinyint(4) DEFAULT '0' COMMENT '0 normal,1=extend or expired',
  `is_extend` tinyint(4) DEFAULT '0' COMMENT '0 normal,1= is extend from',
  `user_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cs_deposit` */

/*Table structure for table `cs_exchange` */

DROP TABLE IF EXISTS `cs_exchange`;

CREATE TABLE `cs_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `changedAmount` double DEFAULT NULL,
  `fromAmount` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `recieptNo` varchar(20) DEFAULT NULL,
  `recievedAmount` double DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `statusDate` datetime DEFAULT NULL,
  `toAmount` double DEFAULT NULL,
  `toAmountType` varchar(1) DEFAULT NULL,
  `fromAmountType` varchar(1) DEFAULT NULL,
  `from_to` varchar(20) DEFAULT NULL,
  `recievedType` varchar(1) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `specail_customer` tinyint(1) DEFAULT '0' COMMENT '0: normal, 1 : specail customer set new rate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `cs_exchange` */

insert  into `cs_exchange`(`id`,`changedAmount`,`fromAmount`,`rate`,`recieptNo`,`recievedAmount`,`status`,`statusDate`,`toAmount`,`toAmountType`,`fromAmountType`,`from_to`,`recievedType`,`userid`,`specail_customer`) values (1,0,10,3990,'5437A1116B4F6',10,'in','2014-10-10 16:04:31',39900,'R','$','ដុល្លា - រៀល','$',1,0),(2,0,1000,120.6,'5437A18BE868B',1000,'in','2014-10-10 16:06:39',120600,'R','B','បាត - រៀល','B',10,0),(3,0,100,3990,'543B7ED7C14AF',100,'in','2014-10-13 14:27:29',399000,'R','$','ដុល្លា - រៀល','$',1,0),(4,0,1000000,4000,'543B7EE3220B5',1000000,'out','2014-10-13 14:27:40',250,'$','R','រៀល - ដុល្លា','R',1,0),(5,0,100,3990,'543C9DF48FF08',100,'in','2014-10-14 10:52:31',399000,'R','$','ដុល្លា - រៀល','$',1,0),(6,0,200,3990,'543C9E3853FD5',200,'in','2014-10-14 10:53:35',798000,'R','$','ដុល្លា - រៀល','$',1,0),(7,0,2000,120.6,'543C9F66E4026',2000,'in','2014-10-14 10:58:39',241200,'R','B','បាត - រៀល','B',1,0),(8,0,40000,121,'5451DCD395C77',40000,'out','2014-10-30 13:38:33',330.58,'B','R','រៀល - បាត','R',1,0),(9,0,200,120.6,'546D5A0871FE2',200,'in','2014-11-20 10:04:10',24120,'R','B','បាត - រៀល','B',1,0),(10,0,300,3990,'546D5A2D39236',300,'in','2014-11-20 10:05:15',1197000,'R','$','ដុល្លា - រៀល','$',1,0);

/*Table structure for table `cs_keycode` */

DROP TABLE IF EXISTS `cs_keycode`;

CREATE TABLE `cs_keycode` (
  `code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyName` varchar(450) DEFAULT NULL,
  `keyValue` varchar(4500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `cs_keycode` */

insert  into `cs_keycode`(`code`,`keyName`,`keyValue`) values (1,'rpt-transfer-warnning-kh','សូមត្រូតពិនិត្យអោយបានត្រឹមត្រូវមុននឹងចាកចេញ'),(2,'rpt-transfer-title-kh','ខេ.អេស'),(3,'rpt-transfer-title-eng','ប្តូរប្រាក់ និង ផ្ទេរប្រាក់'),(4,'rpt-transfer-business-meaning-kh','មានប្តូរប្រាក់គ្រប់ប្រភេទ និងមានសេវាផ្ទេរប្រាក់'),(5,'rpt-transfer-business-meaning-eng','EXCHANGE CURRENCY AND TRANSFER SERIVCE'),(6,'rpt-transfer-location-adr-kh','ផ្ទះលេខ​189(ង) ជួរផ្ទះល្វែងខាងលិចទល់មុខផ្សារអត្តថ្មី'),(7,'rpt-transfer-tel-eng','Tel:017 777 613,011 288 258'),(8,'rpt-transfer-send-kh','បើកនៅ'),(9,'rpt-transfer-recieve-kh','ទទួលពី'),(10,'imgPath','images/resolvo.gif'),(11,'mainbranch','ខេ.អេស'),(12,'branch-add','ទីតាំង៖ ផ្ទះលេខ​189(ង) ជួរផ្ទះល្វែងខាងលិចទល់មុខផ្សារអត្តថ្មី'),(13,'bracnch-tel','017 777 613,011 288 258'),(14,'mainbranch-subtitle','សេវាប្តូរប្រាក់, សេវាផ្ទេរប្រាក់'),(15,'marquee-word','មានប្តូរប្រាក់គ្រប់ប្រភេទ និងមានសេវាផ្ទេរប្រាក់ រហ័សទាន់ចិត្ត, Exchnage and Transfer money'),(16,'services','សេវាប្តូរប្រាក់, សេវាផ្ទេរប្រាក់'),(17,'copyright','&copy 2013 MONOROM Exchange And Transfer Money Management All rights reserved.'),(18,'comment','សូមបញ្ចេញមតិចំពោះសេវាកម្មយើងខ្ញុំ Tel:012 288 258'),(19,'servername','localhost'),(20,'dbuser','root'),(21,'dbpassword',NULL),(22,'dbname','db_cs2_5');

/*Table structure for table `cs_loan` */

DROP TABLE IF EXISTS `cs_loan`;

CREATE TABLE `cs_loan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `currencyType` int(10) DEFAULT NULL,
  `loanDate` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `staus` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `cs_loan` */

/*Table structure for table `cs_loan_agent` */

DROP TABLE IF EXISTS `cs_loan_agent`;

CREATE TABLE `cs_loan_agent` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `currencyType` int(10) DEFAULT NULL,
  `loanDate` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `agent_id` int(10) DEFAULT NULL,
  `staus` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `cs_loan_agent` */

/*Table structure for table `cs_money_transactions` */

DROP TABLE IF EXISTS `cs_money_transactions`;

CREATE TABLE `cs_money_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(255) DEFAULT NULL,
  `reciever_name` varchar(255) DEFAULT NULL,
  `reciever_tel` varchar(15) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `amount_type` int(11) DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `commission_type` int(11) DEFAULT NULL,
  `commission_percent` float DEFAULT NULL,
  `commission_agent` double NOT NULL DEFAULT '0',
  `recieved` double DEFAULT NULL,
  `recieved_type` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0:send, 1:sent, 2:recieved, 3:paid, 4:cancel, 5:expired',
  `status_loan` tinyint(1) NOT NULL DEFAULT '0',
  `cut_service` tinyint(1) NOT NULL DEFAULT '0',
  `agent_id` int(11) DEFAULT NULL,
  `subagent_id` int(11) DEFAULT NULL,
  `send_date` datetime DEFAULT NULL COMMENT 'ថ្ងៃ​បង្កើត​ប្រតិបត្តិការណ៍',
  `recieved_date` datetime DEFAULT NULL COMMENT 'ថ្ងៃ​​ប្រតិបត្តិការណ៍',
  `expire_date` datetime DEFAULT NULL,
  `transfer_money` double DEFAULT NULL,
  `total_money` double DEFAULT NULL,
  `return_money` double DEFAULT NULL,
  `tran_type` tinyint(1) NOT NULL COMMENT '0: transfer; 1:recieved',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `is_kbank` tinyint(4) DEFAULT NULL COMMENT '0 normal,1=from kbank',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cs_money_transactions` */

insert  into `cs_money_transactions`(`id`,`sender_name`,`reciever_name`,`reciever_tel`,`invoice_no`,`amount`,`amount_type`,`commission`,`commission_type`,`commission_percent`,`commission_agent`,`recieved`,`recieved_type`,`status`,`status_loan`,`cut_service`,`agent_id`,`subagent_id`,`send_date`,`recieved_date`,`expire_date`,`transfer_money`,`total_money`,`return_money`,`tran_type`,`user_id`,`is_kbank`) values (1,'A','','012202020','TR-831546',1000,1,0,1,0,0,1000,1,0,1,0,1,2,'2014-11-08 09:44:13',NULL,'2014-12-25 09:44:13',1000,1000,0,0,1,0),(2,'A','','0302020200','TR-546026',3000,2,0,2,0,0,3000,2,0,1,0,1,1,'2014-11-08 09:44:47',NULL,'2014-12-25 09:44:47',3000,3000,0,0,1,0);

/*Table structure for table `cs_payout` */

DROP TABLE IF EXISTS `cs_payout`;

CREATE TABLE `cs_payout` (
  `po_id` int(11) NOT NULL AUTO_INCREMENT,
  `po_invoice_no` varchar(100) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `po_capital` float(15,2) DEFAULT NULL,
  `po_refund` float(15,2) DEFAULT NULL,
  `exrate_db` float(15,2) DEFAULT '0.00',
  `exrate_dr` float(15,2) DEFAULT '0.00',
  `exrate_rb` float(15,2) DEFAULT '0.00',
  `po_date` datetime DEFAULT NULL,
  `po_cur_type` tinyint(4) DEFAULT NULL,
  `po_status` tinyint(4) DEFAULT '0' COMMENT '0:use, 1:stop use',
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `cs_payout` */

insert  into `cs_payout`(`po_id`,`po_invoice_no`,`sender_id`,`po_capital`,`po_refund`,`exrate_db`,`exrate_dr`,`exrate_rb`,`po_date`,`po_cur_type`,`po_status`) values (1,'PO-377571',3,1000.00,100.00,33.00,4000.00,121.00,'2014-11-10 00:00:00',1,0),(2,'PO-0CEDC8',3,900.00,100.00,33.00,4000.00,121.00,'2014-11-10 00:00:00',1,0),(3,'PO-0CEDC8',3,4000.00,1000.00,33.00,4000.00,121.00,'2014-11-10 00:00:00',2,0),(4,'PO-5364C4',3,810.00,10.00,33.00,4000.00,121.00,'2014-11-10 00:00:00',1,0),(5,'PO-5364C4',3,3010.00,10.00,33.00,4000.00,121.00,'2014-11-10 00:00:00',2,0);

/*Table structure for table `cs_payout_detail` */

DROP TABLE IF EXISTS `cs_payout_detail`;

CREATE TABLE `cs_payout_detail` (
  `ps_id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL COMMENT 'payout id',
  `br_id` int(11) NOT NULL COMMENT 'borrow id',
  `cur_type` tinyint(4) DEFAULT '0',
  `ps_status` tinyint(4) DEFAULT '0' COMMENT '0:use, 1:stop use',
  `po_capital` float(10,2) DEFAULT NULL,
  `po_refund` float(10,2) DEFAULT NULL,
  PRIMARY KEY (`ps_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `cs_payout_detail` */

insert  into `cs_payout_detail`(`ps_id`,`po_id`,`br_id`,`cur_type`,`ps_status`,`po_capital`,`po_refund`) values (1,1,1,1,0,NULL,NULL),(2,2,2,1,0,NULL,NULL),(3,3,1,2,0,NULL,NULL),(4,4,5,1,0,NULL,NULL),(5,5,5,2,0,NULL,NULL);

/*Table structure for table `cs_pc` */

DROP TABLE IF EXISTS `cs_pc`;

CREATE TABLE `cs_pc` (
  `pc_name` varchar(255) NOT NULL,
  PRIMARY KEY (`pc_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `cs_pc` */

insert  into `cs_pc`(`pc_name`) values ('052c75a47b6aa770b53fca4d1d6f480a'),('3b94234bd8aa4058536b581bc3171d4c'),('48611c7eec5d0a0689fd8dd1789bdf40'),('4a31c37bfe67c8b60589261543865d22');

/*Table structure for table `cs_provinces` */

DROP TABLE IF EXISTS `cs_provinces`;

CREATE TABLE `cs_provinces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `cs_provinces` */

insert  into `cs_provinces`(`id`,`name`) values (1,'ភ្នំពេញ'),(2,'កំពង់ឆ្នាំង'),(3,'កំពង់ចាម'),(4,'កំពង់ស្ពី'),(5,'កំពង់ធំ'),(6,'កំពត'),(7,'កណ្តាល'),(8,'ស្វាយរៀង'),(9,'ប៉ៃលិន'),(10,'ព្រៃវែង'),(11,'កែប'),(12,'កោះកុង'),(13,'សៀមរាប'),(14,'ពោធ៌សាត់'),(15,'ព្រះវិហារ'),(16,'ព្រះសីហនុ'),(17,'ក្រចេះ'),(18,'តាកែវ'),(19,'រតនះគីរី'),(20,'មណ្ឌលគីរី'),(21,'បាត់ដំបង'),(22,'បន្ទាយមានជ័យ'),(23,'ឩត្តមានជ័យ'),(24,'ស្ទឹងត្រែង'),(28,'ប៉ោយប៉ែត'),(27,'ធនាគារថៃ'),(29,'ប្រទេសថៃ'),(30,'ប្រទេសវៀតណាម');

/*Table structure for table `cs_pscamount` */

DROP TABLE IF EXISTS `cs_pscamount`;

CREATE TABLE `cs_pscamount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `currency_type` tinyint(4) DEFAULT NULL,
  `volum` int(11) DEFAULT NULL,
  `psc_amount` int(11) DEFAULT NULL,
  `note` text,
  `date` date DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1=active,0=deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cs_pscamount` */

/*Table structure for table `cs_rate` */

DROP TABLE IF EXISTS `cs_rate`;

CREATE TABLE `cs_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `in_cur_id` int(11) DEFAULT NULL COMMENT 'The Currency that we take from customer',
  `out_cur_id` int(11) DEFAULT NULL COMMENT 'The Currency that we give to customer',
  `rate_in` double DEFAULT NULL,
  `rate_out` double DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL COMMENT '1:active; 0:Disactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cs_rate` */

insert  into `cs_rate`(`id`,`in_cur_id`,`out_cur_id`,`rate_in`,`rate_out`,`create_date`,`active`) values (1,1,2,32.9,33,'2014-02-03 12:07:58',1),(2,1,3,3990,4000,'2014-02-03 12:07:58',1),(3,2,3,120.6,121,'2014-02-03 12:07:58',1);

/*Table structure for table `cs_sender` */

DROP TABLE IF EXISTS `cs_sender`;

CREATE TABLE `cs_sender` (
  `sender_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acc_no` varchar(8) NOT NULL,
  `sender_name` varchar(150) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `sender_type` tinyint(4) DEFAULT '0' COMMENT '0=for transfer,1=all tran and kbank,2 loan tran',
  `status` tinyint(4) DEFAULT '1' COMMENT '1 active,0 deactive',
  PRIMARY KEY (`sender_id`,`acc_no`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `cs_sender` */

insert  into `cs_sender`(`sender_id`,`acc_no`,`sender_name`,`tel`,`email`,`address`,`sender_type`,`status`) values (1,'001','A','0122020200',NULL,NULL,0,1),(2,'002','B','020220000',NULL,NULL,1,1),(3,'003','C','020200000',NULL,NULL,2,1),(4,'0','D','012302010',NULL,'Phnom Penh',2,1),(5,'0','E','0212020100',NULL,'',0,1),(6,'0','pp','4255544879',NULL,'',2,1),(7,'0','Narith','0122010200',NULL,'narith',2,1),(8,'000003','ssss','',NULL,'',1,1);

/*Table structure for table `cs_stockmoney` */

DROP TABLE IF EXISTS `cs_stockmoney`;

CREATE TABLE `cs_stockmoney` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `currency_type` tinyint(4) DEFAULT NULL,
  `amount` float(18,2) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

/*Data for the table `cs_stockmoney` */

/*Table structure for table `cs_sub_agents` */

DROP TABLE IF EXISTS `cs_sub_agents`;

CREATE TABLE `cs_sub_agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `block` varchar(255) DEFAULT NULL,
  `house_no` varchar(10) DEFAULT NULL,
  `group_no` varchar(10) DEFAULT NULL,
  `street_no` varchar(255) DEFAULT NULL,
  `sangkat` varchar(255) DEFAULT NULL,
  `khan` varchar(255) DEFAULT NULL,
  `province` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `agent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;

/*Data for the table `cs_sub_agents` */

insert  into `cs_sub_agents`(`id`,`name`,`code`,`tel`,`fax`,`hp`,`block`,`house_no`,`group_no`,`street_no`,`sangkat`,`khan`,`province`,`active`,`agent_id`) values (1,'ជីវន្ត-ចំការលើ(2.5)','01','012363448','','','','','','','','',3,1,1),(2,'ហ៊ាខេង-ក្រែកជីមាន់(2.5)','02','0978341111','','','','','','','','',3,1,1),(3,'សេងប្រេស-ស្ពឺកំពង់ចាម(2.5)','03','012636360','','','','','','','','',3,1,1),(4,'អង្គរពួន-អូរស្មាច់(2.5)','04','017777724','','','','','','','','',22,1,1),(5,'ឡុងថន-ប្រមោយ(3.5)','05','012800048','','','','','','','','',14,1,1),(6,'ក្រវាញ-ពោធិ៍សាត់(2.5)','06','0979019168','','','','','','','','',14,1,1),(7,'តែលីហុង-កំពង់សោម(1)','07','012416341','','','','','','','','',16,1,1),(8,'តាងួន-វាលរេញ(2.5)','08','0376900527','','','','','','','','',16,1,1),(9,'ស៊ីង៉ា-តាំងក្រសាំង(3.5)','09','012719642','','','','','','','','',5,1,1),(10,'ចែពៅ-ទំរេញ(3.5)','010','011426142','','','','','','','','',5,1,1),(11,'ប្រាសាទសម្បូរ(3.5)','011','092233919','','','','','','','','',5,1,1),(12,'តាំងគោក(1.5)','012','012470596','','','','','','','','',5,1,1),(13,'ចែងីម-ព្រៃវែង(1.5)','013','011442444','','','','','','','','',10,1,1),(14,'ចែយ៉ា-ស្វាយរៀង(1.5)','014','011872673','','','','','','','','',8,1,1),(15,'ហ៊ាតុង-រមាសហែក(1.5)','015','0767618223','','','','','','','','',8,1,1),(16,'ចែចន្ថា-បាវិត(2.5)','16','011737456','','','','','','','','',8,1,1),(17,'ហ៊ាយី-កំពង់ត្របែក(1.5)','17','011823387','','','','','','','','',8,1,1),(18,'តិចវី-រតនះគីរី(1.5)','18','011500033','','','','','','','','',19,1,1),(19,'ហ៊ាសែ-ស្អាង(1.5)','19','061656562','','','','','','','','',7,1,1),(20,'ចិនកយ-កោះទាវ(1.5)','20','012292995','','','','','','','','',7,1,1),(21,'ចែមុំ-តាខ្មៅ(1.5)','21','0977377216','','','','','','','','',7,1,1),(22,'ហ៊ាជ្រន-កោះធំ(1.5)','22','017990095','','','','','','','','',7,1,1),(23,'គ្រូស្រ៊ី-កំពង់ឆ្នាំង(1.5)','23','012691998','','','','','','','','',2,1,1),(24,'ខ្មែររចនា-ផ្សារថ្មី(1.5)','24','085992058','','','','','','','','',1,1,1),(25,'វួចឡេង-ឬស្សីកែវ(1)','25','011666271','','','','','','','','',1,1,1),(26,'ជាងហុង-កំពង់ស្ពឺ(2.5)','26','099329333','','','','','','','','',4,1,1),(27,'ជាងពៅ-អន្លង់វែង(1.5)','27','012256526','','','','','','','','',1,1,3),(28,'ចែណេង-ឡែម(1.5)','28','017444496','','','','','','','','',21,1,3),(29,'អង្គរពូន-អូរស្មាច់(2)','29','017777724','','','','','','','','',22,1,1),(30,'លីលី-មោង(1.5)','30','092781505','','','','','','','','',21,1,1),(31,'99-ឡែម(1.5)','31','011289102','','','','','','','','',21,1,1),(32,'ចិកទី-បវិល(1.5)','32','092842770','','','','','','','','',21,1,1),(33,'អ៊ីណុប-សាលាក្រៅ(2)','32','092445436','','','','','','','','',9,1,10),(34,'ម្កត់ពេជ្រ-ព្រំ(2)','33','011333718','','','','','','','','',9,1,10),(35,'ពូឡុង-កោះស្តេច(3)','34','011726087','','','','','','','','',12,1,1),(36,'ចែបូ-ស្រែអំបិល(2.5)','35','012724707','','','','','','','','',12,1,1),(37,'ធីន-កោះកុង(1.5)','36','099680088','','','','','','','','',12,1,1),(38,'លីហេង-កំពត(1)','37','012439093','','','','','','','','',6,1,1),(39,'សុម៉ាលី-ឈូកកំពត(2)','39','0976246439','','','','','','','','',6,1,1),(40,'តាកៃ-ទូកមាស(2.5)','40','089790804','','','','','','','','',6,1,1),(41,'ពូឌី-កំពង់ត្រាច(1.5)','41','012900550','','','','','','','','',6,1,1),(42,'ហ៊ាផេង-ព្រែកចាក(1.5)','42','099320818','','','','','','','','',6,1,1),(43,'ធួន-ថ្នល់ទទឹង(2.5)','43','012692473','','','','','','','','',3,1,1),(44,'គន្ឋា-ស្ទឹង(2)','44','011665370','','','','','','','','',3,1,1),(45,'សៀងហៃ-មេមុត(1.5)','45','012905901','','','','','','','','',3,1,1),(46,'ស្គន់កំពង់ចាម(2.5)','46','012944261','','','','','','','','',3,1,1),(47,'ឆាយឆោមវី-ផ្អាវ(1.5)','47','012796479','','','','','','','','',3,1,1),(48,'គ្រួញ៉ូវ-ព្រៃទទឹង(2)','48','012801415','','','','','','','','',3,1,30),(49,'តាបាក់-កាប៊ីន(2.5)','49','012412472','','','','','','','','',21,1,1),(50,'ជាងហឿន-កំពង់ថ្ម(2.5)','50','012975349','','','','','','','','',5,1,1),(51,'ណាំគា-កំពង់ធំ(1.5)','51','012682866','','','','','','','','',5,1,1),(52,'ចែរ៉ា-ល្វាង(3.5)','52','099610494','','','','','','','','',15,1,1),(53,'ស្រអែមថ្មី-ព្រះវិហារ(3)','53','092700676','','','','','','','','',15,1,7),(54,'ម៉េងហ៊ី-ព្រះវិហារ(3.5)','54','012662575','','','','','','','','',15,1,7),(55,'ឆាយឡយ-គិរីវង្ស(2.5)','55','0977420884','','','','','','','','',18,1,1),(56,'ហ៊ាផេង-កោះទាវ(2)','56','012328558','','','','','','','','',7,1,1),(57,'ហ៊ាឡូវ-ដំដែក(1.5)','57','092927927','','','','','','','','',13,1,7),(58,'តាញ៉ុក-តាកែវ(1.5)','58','0972377712','','','','','','','','',18,1,1),(59,'ឆឹប-អង្គរបុរី(2.5)','59','017980270','','','','','','','','',18,1,1),(60,'លុបចោល','60','089900887','','','ចោល','','','','','',18,1,1),(61,'ស្រីអូន-ថ្មសរ(2)','61','011611681','','','','','','','','',18,1,1),(62,'ពូឃុំ-កោះអណ្តែត(2.5)','62','012720720','','','','','','','','',18,1,1),(63,'អ៊ីពៅ-ទន្លាប់','63','012342002','','','','','','','','',18,1,1),(64,'វណ្ណា-បាភ្នំ(2)','64','012788514','','','','','','','','',10,1,1),(65,'ជាងរ៉ា-ព្រែកសណ្តែក(3)','65','0977273300','','','','','','','','',10,1,1),(66,'ហ៊ាសុខ-អ្នកលឿងខាងកើត','66','011925434','','','','','','','','',10,1,1),(67,'ជាងអ័រ-ព្រៃភ្នៅ','67','012555768','','','','','','','','',10,1,1),(68,'កាជ្រាជ-ព្រៃវែង(2)','68','012928327','','','','','','','','',10,1,1),(69,'លីង៉ា-ពារាំង(2)','69','099222028','','','','','','','','',10,1,1),(70,'ពានភ្លើង-កំចាយមាស','70','012981081','','','','','','','','',10,1,1),(71,'ចែវួច-កអណ្តើក','71','011697786','','','','','','','','',10,1,1),(72,'ហ៊ាហួរ-ស្វាយអន្ទរ','72','012344222','','','','','','','','',10,1,1),(73,'តែហុកធាន-អ្នកលឿងខាងលិច','73','085585832','','','','','','','','',10,1,1),(74,'ធារី-ស្រែណយ(3.5)','74','012599494','','','','','','','','',13,1,1),(75,'ឡុងហាក់-ត្រពាំងប្រាសាទ(2.5)','75','099995656','','','','','','','','',13,1,1),(76,'ព្រាបស-សំរោង(2)','76','011662411','','','','','','','','',23,1,1),(77,'ពេទ្រម៉ាប់-ចុងកាល(4)','77','081244555','','','','','','','','',13,1,1),(78,'ផ្កាយបី-ក្រចេះ','78','011828455','','','','','','','','',17,1,1),(79,'23ស្នួល','79','099634634','','','','','','','','',17,1,1),(80,'ជាងជឺ-ឆ្លូង(3)','80','012525885','','','','','','','','',17,1,1),(81,'អ៊ីផល្លា-ស្ទឹងត្រែង(2)','81','011679523','','','','','','','','',24,1,1),(82,'ប៊ុនលី-សំឡូត(2.5)','82','012945232','','','','','','','','',21,1,1),(83,'ស្ពាននាគ-កំពង់ក្តី(2)','83','012570345','','','','','','','','',13,1,1),(84,'ខឹម-ភ្នំតូច(2)','86','012217045','','','','','','','','',22,1,1),(100,'សុខជា-ម៉ាឡៃ(2)','','012687099','','','','','','','','',22,1,8),(99,'ពូមឿយ-ភ្នំស្រុក(2)','','012665475','','','','','','','','',22,1,8),(87,'តាអាន-ស្វាយរៀង(1)','','011628712','','','','','','','','',8,1,1),(88,'អ៊ីហួយ-កាប៊ីន(2)','','012820857','','','','','','','','',21,1,5),(89,'អ៊ីគា-ស្តៅ(2)','','012565097','','','','','','','','',21,1,5),(90,'ហ៊ាផែ-បាវិល(2)','','012211212','','','','','','','','',21,1,5),(91,'ណូរ៉ា-កំពង់ថ្ម(2.5)','','012444178','','','','','','','','',1,1,1),(92,'វារេញ-គឹមសាន្ត(2)','','012997321','','','','','','','','',1,1,3),(93,'ឆាយអ៊ីម-ព្រៃវែង','','011442444','','','','','','','','',10,1,1),(94,'មង្គលបុរី(2)','','012833753','','','','','','','','',22,1,8),(95,'ឡោផេង-ក្រឡាញ់(1.5)','','077777796','','','','','','','','',22,1,8),(96,'ឃឹម-ភ្នំតូច(1.5)','','012217045','','','','','','','','',22,1,8),(97,'​​ស្ពាននាគ​-កំពង់ក្តី(1.5)','','012570345','','','','','','','','',13,1,7),(98,'ព្រាបស-សំរោង(1.5)','','011662411','','','','','','','','',23,1,7),(101,'វៀតណាម','','1664999941','','','','','','','','',30,1,3),(109,'លុប','','011442444','','','','','','','','',10,1,1),(102,'ផេង-ក្រចាប់(2)','','089633622','','','','','','','','',9,1,10),(103,'ហេងតុលា-ថៃ','','0818291951','','','','','','','','',29,1,2),(104,'ប៊ុនសុគុន្ធ-កំពង់ចាម(1.5)','','011770456','','','','','','','','',3,1,1),(105,'តាអាន-ស្វាយរៀង','','011628712','','','','','','','','',1,1,1),(106,'ហេងវី-អូស្មាច់(2)','','092600200','','','','','','','','',21,1,8),(107,'អ៊ីចាប់ឆាយ-រតនះគិរី','','012944227','','','','','','','','',19,1,1),(108,'ហេង-កំពង់ស្ពឺ(2)','','0888854464','','','','','','','','',4,1,3),(110,'ជាងលី-បន្ទាយស្រី(4)','','089767383','','','','','','','','',13,1,1),(111,'ជាងជឺ-ឆ្លូង(2)','','012525885','','','','','','','','',17,1,30),(112,'វួចឡេង-ស្ទាទចាស់','','011666271','','','','','','','','',1,1,1),(113,'ក្រវាញ-វណ្ណី(2)','','012504858','','','','','','','','',14,1,11),(114,'ធាង -ស្គន់','','012944261','','','','','','','','',3,1,13),(115,'ចែរី​-អន្លង់វែង(2.5)','','099343335','','','','','','','','',13,1,1),(116,'គ្រូញ៉ូវ-ព្រៃទទឹង(2.5)','','012801415','','','','','','','','',3,1,1),(117,'អង្គរ-អូស្មាច់','','011656528','','','','','','','','',1,1,30),(118,'ច្បារអំពៅ','','092908200','','','','','','','','',1,1,1),(119,'ចិន','','0977999271','','','','','','','','',1,1,31),(120,'តាងួន-វារេញ(2.5)','','0346900527','','','','','','','','',1,1,1),(121,'គឹមសាន្ត-វារេញ(2)','','016997321','','','','','','','','',1,1,3),(122,'ងូនលី-តាខ្មៅ(1.5)','','011777185','','','','','','','','',7,1,1),(123,'ផល្លា-ស្ទឹងត្រែង(1.5)','','011679523','','','','','','','','',24,1,4),(124,'គ្រូហម-ក្រលាញ់(1.5)','','012258573','','','','','','','','',13,1,7),(125,'ជាងធឿន-សំរោង(1.5)','','012586565','','','','','','','','',13,1,7),(126,'ចែមួយលក់មាស-បឹងខ្នាល(2)','','012383973','','','','','','','','',14,1,11),(127,'សុខា-ស្រអែមថ្មី(3.5)','','011983949','','','','','','','','',15,1,1),(128,'ជាងពៅ-អន្លងវែង(1.5)','','012256526','','','','','','','','',13,1,1),(129,'ក្រចាប់(2.5)','','089633622','','','','','','','','',9,1,1),(130,'វៀតណាម','','000000000','','','','','','','','',1,1,4),(131,'ហ៊ាតុង-រមាសហែក(1.5)','','0767618223','','','','','','','','',8,1,1),(132,'សួងM67(1.5)','','012900767','','','','','','','','',3,1,1),(133,'គង់មង្គល់បូរី','','017386168','','','','','','','','',22,1,1),(134,'ណារ័ត្ន​-ថ្មគោល(1.5)','','012666601','','','','','','','','',21,1,5),(135,'គីមី-ព្រំ(2)','','0979337666','','','','','','','','',9,1,5),(136,'មុំយី-បឹងខ្នារ(2)','005','000000000','','','','','','','','',1,1,11),(137,'ចែឡេង-កំពង់ត្រាច(1.5)','','012763982','','','','','','','','',6,1,1),(138,'ពូរិន-សំឡូត(2.5)','','089752197','','','','','','','','',21,1,1),(139,'គាង-ស្គន់2.5','','012944261','','','','','','','','',3,1,1),(140,'អង្គរពូន-អូស្មាច់(2.5)','','017777724','','','','','','','','',1,1,1),(141,'ម៉ាលី-ផ្សារថ្មី(1.5)','','085992058','','','','','','','','',1,1,1),(142,'ក្រចាប់(2.5)','','089633622','','','','','','','','',9,1,1),(143,'ម៉ាប់ម៉ុំ-ពានភ្លឺង(1.5)','','098981081','','','','','','','','',10,1,1),(144,'ចែឡេង-កំពង់ត្រាច(2)','','012763982','','','','','','','','',1,1,3),(145,'អេង-ប៉ៃលិន(2)','','012641075','','','','','','','','',9,1,3),(146,'ជាងពៅ-អន្លង់វែង','0122','012256526','','','','','','','','',23,1,7),(147,'ហ៊ាស្រេង-ដំដែក(2)','','012213199','','','','','','','','',13,1,1);

/*Table structure for table `cs_trancs_found_detail` */

DROP TABLE IF EXISTS `cs_trancs_found_detail`;

CREATE TABLE `cs_trancs_found_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `found_id` int(11) DEFAULT NULL COMMENT 're-rence wt cs_found',
  `owe_id` int(11) DEFAULT NULL COMMENT 're-rence wt cs_tran_owe',
  `money_found` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `cs_trancs_found_detail` */

/*Table structure for table `cs_trans_found` */

DROP TABLE IF EXISTS `cs_trans_found`;

CREATE TABLE `cs_trans_found` (
  `found_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_found` varchar(20) DEFAULT NULL COMMENT 'invoice_found',
  `sender_id` int(11) NOT NULL,
  `capital` double DEFAULT '0' COMMENT 'amount dollar before found',
  `refund` double DEFAULT '0' COMMENT 'amount bath before found',
  `exchange_rate_db` double DEFAULT '1' COMMENT 'dollar-bath',
  `exchange_rate_dr` double unsigned DEFAULT '1' COMMENT 'dollar-riel',
  `exchange_rate_rb` double unsigned DEFAULT '1' COMMENT 'riel-bath',
  `date_refund` datetime NOT NULL,
  `curency_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:dollar, 2:baht, 3:riel',
  `tran_id` varchar(11) NOT NULL DEFAULT '0' COMMENT 'transaction_owe_id',
  `status` tinyint(4) DEFAULT '0' COMMENT '0:use, 1:deleted',
  PRIMARY KEY (`found_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cs_trans_found` */

insert  into `cs_trans_found`(`found_id`,`invoice_found`,`sender_id`,`capital`,`refund`,`exchange_rate_db`,`exchange_rate_dr`,`exchange_rate_rb`,`date_refund`,`curency_type`,`tran_id`,`status`) values (1,'RF-105460',1,1001.33,100,33,4000,121,'2014-11-10 00:00:00',1,'1',0),(2,'RF-105460',1,3004,100,33,4000,121,'2014-11-10 00:00:00',2,'2',0);

/*Table structure for table `cs_transactions_owe` */

DROP TABLE IF EXISTS `cs_transactions_owe`;

CREATE TABLE `cs_transactions_owe` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `money_tran_id` int(11) unsigned NOT NULL,
  `sender_name` int(11) DEFAULT NULL,
  `reciever_name` varchar(255) DEFAULT NULL,
  `reciever_tel` varchar(15) DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `amount_type` int(11) unsigned DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `commission_type` int(11) DEFAULT NULL,
  `commission_percent` float DEFAULT NULL,
  `commission_agent` double NOT NULL DEFAULT '0',
  `recieved` double DEFAULT NULL,
  `recieved_type` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0:send, 1:sent, 2:recieved, 3:paid, 4:cancel, 5:expired',
  `status_loan` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:debt, 2:remain, 3:paid',
  `cut_service` tinyint(1) NOT NULL DEFAULT '0',
  `agent_id` int(11) DEFAULT NULL,
  `subagent_id` int(11) DEFAULT NULL,
  `send_date` date DEFAULT NULL COMMENT 'ថ្ងៃ​បង្កើត​ប្រតិបត្តិការណ៍',
  `recieved_date` date DEFAULT NULL COMMENT 'ថ្ងៃ​​ប្រតិបត្តិការណ៍',
  `expire_date` datetime DEFAULT NULL,
  `rate_perday` float DEFAULT NULL COMMENT 'rate pay day',
  `transfer_money` double DEFAULT NULL,
  `total_money` double DEFAULT NULL COMMENT 'លុយសល់ពីជំពាក់',
  `total_money_owe` double DEFAULT NULL COMMENT 'ជំពាក់សរុប',
  `tran_type` tinyint(1) DEFAULT NULL COMMENT '0: transfer; 1:recieved',
  `user_id` int(11) DEFAULT NULL,
  `exchange_rate_db` double DEFAULT '1' COMMENT 'dollar-bath',
  `exchange_rate_dr` double DEFAULT '1' COMMENT 'dollar-riel',
  `exchange_rate_rb` double DEFAULT '1' COMMENT 'exchange_rate_rb',
  `is_kbank` tinyint(4) DEFAULT '1' COMMENT '0 normal,1 remain debt from kbank',
  `is_orgdebt` tinyint(4) DEFAULT '0' COMMENT '1 = ជំពាក់ថ្មី,0 remain from fund',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `cs_transactions_owe` */

insert  into `cs_transactions_owe`(`id`,`money_tran_id`,`sender_name`,`reciever_name`,`reciever_tel`,`invoice_no`,`amount`,`amount_type`,`commission`,`commission_type`,`commission_percent`,`commission_agent`,`recieved`,`recieved_type`,`status`,`status_loan`,`cut_service`,`agent_id`,`subagent_id`,`send_date`,`recieved_date`,`expire_date`,`rate_perday`,`transfer_money`,`total_money`,`total_money_owe`,`tran_type`,`user_id`,`exchange_rate_db`,`exchange_rate_dr`,`exchange_rate_rb`,`is_kbank`,`is_orgdebt`) values (1,1,1,'','012202020','TR-831546',1000,1,0,1,0,0,1000,1,0,3,0,1,2,'2014-11-08',NULL,'2014-12-25 09:44:13',2,1000,1000,1000,0,1,33,4000,121,1,1),(2,2,1,'','0302020200','TR-546026',3000,2,0,2,0,0,3000,2,0,3,0,1,1,'2014-11-08',NULL,'2014-12-25 09:44:47',2,3000,3000,3000,0,1,33,4000,121,1,1),(3,0,1,NULL,NULL,'RF-105460',901.33,1,NULL,NULL,NULL,0,NULL,NULL,0,2,0,NULL,NULL,'2014-11-10',NULL,NULL,2,NULL,901.33,901.33,NULL,1,33,4000,121,1,0),(4,0,1,NULL,NULL,'RF-105460',2904,2,NULL,NULL,NULL,0,NULL,NULL,0,2,0,NULL,NULL,'2014-11-10',NULL,NULL,2,NULL,2904,2904,NULL,1,33,4000,121,1,0);

/*Table structure for table `cs_user_log` */

DROP TABLE IF EXISTS `cs_user_log`;

CREATE TABLE `cs_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `log_date` datetime NOT NULL,
  `log_type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2225 DEFAULT CHARSET=utf8;

/*Data for the table `cs_user_log` */

insert  into `cs_user_log`(`id`,`user_id`,`log_date`,`log_type`) values (462,22,'2013-06-09 00:54:03','in'),(461,23,'2013-06-09 00:19:39','in'),(460,23,'2013-06-08 08:23:18','in'),(459,23,'2013-06-08 05:45:10','in'),(458,23,'2013-06-08 04:50:41','in'),(457,23,'2013-06-08 04:44:12','in'),(456,22,'2013-06-08 04:05:58','in'),(455,23,'2013-06-08 02:54:39','in'),(454,21,'2013-06-08 02:54:24','out'),(453,1,'2013-06-08 02:29:05','in'),(452,21,'2013-06-08 01:24:37','in'),(451,22,'2013-06-08 01:23:19','in'),(13,2,'2011-09-14 12:47:46','in'),(14,2,'2011-09-14 13:42:55','in'),(15,1,'2011-09-14 15:20:43','in'),(16,1,'2011-09-14 15:26:34','out'),(17,1,'2011-09-14 15:26:42','in'),(18,1,'2011-09-14 15:26:44','out'),(19,1,'2011-09-14 15:27:38','in'),(20,1,'2011-09-14 15:38:24','in'),(21,1,'2011-09-14 15:46:16','out'),(22,1,'2011-09-14 15:47:24','in'),(23,1,'2011-09-14 15:50:18','out'),(24,1,'2011-09-14 15:50:25','in'),(25,1,'2011-09-14 15:50:26','in'),(26,1,'2011-09-14 15:50:34','in'),(27,1,'2011-09-14 15:50:36','in'),(28,1,'2011-09-14 15:50:36','in'),(29,1,'2011-09-14 15:50:36','in'),(30,1,'2011-09-14 15:50:36','in'),(31,1,'2011-09-14 15:50:36','in'),(32,1,'2011-09-14 15:50:41','in'),(33,1,'2011-09-14 15:50:45','out'),(34,1,'2011-09-14 15:50:58','in'),(35,1,'2011-09-14 15:51:00','in'),(36,1,'2011-09-14 15:51:01','in'),(37,1,'2011-09-14 15:51:02','in'),(38,1,'2011-09-14 15:51:03','in'),(39,1,'2011-09-14 15:51:04','in'),(40,1,'2011-09-14 15:55:12','in'),(41,1,'2011-09-14 15:55:15','in'),(42,1,'2011-09-14 15:57:01','out'),(43,1,'2011-09-14 15:57:11','in'),(44,1,'2011-09-14 15:57:13','in'),(45,1,'2011-09-14 15:57:13','in'),(46,1,'2011-09-14 15:57:13','in'),(47,1,'2011-09-14 15:57:13','in'),(48,1,'2011-09-14 15:57:26','in'),(49,1,'2011-09-14 15:58:06','out'),(50,1,'2011-09-14 15:58:12','in'),(51,1,'2011-09-14 16:06:10','in'),(52,2,'2011-09-14 16:44:16','in'),(53,2,'2011-09-14 17:06:22','out'),(54,2,'2011-09-14 17:06:36','in'),(55,2,'2011-09-14 17:13:55','out'),(56,1,'2011-09-14 17:24:33','out'),(57,1,'2011-09-15 09:01:10','in'),(58,1,'2011-09-15 09:43:33','in'),(59,1,'2011-09-15 10:01:21','in'),(60,1,'2011-09-15 14:02:33','in'),(61,1,'2011-09-16 08:17:25','in'),(62,1,'2011-09-16 08:49:11','in'),(63,1,'2011-09-16 08:56:48','out'),(64,1,'2011-09-16 11:57:05','out'),(65,1,'2011-09-16 11:57:15','in'),(66,1,'2011-09-16 13:01:00','in'),(67,1,'2011-09-16 14:30:22','in'),(68,1,'2011-09-16 17:22:33','in'),(69,1,'2011-09-19 08:36:48','in'),(70,1,'2011-09-19 09:55:23','in'),(71,1,'2011-09-19 11:13:01','in'),(72,1,'2011-09-19 13:25:17','in'),(73,1,'2011-09-19 15:24:07','in'),(74,1,'2011-09-19 16:06:09','in'),(75,1,'2011-09-19 16:45:22','in'),(76,1,'2011-09-20 08:23:12','out'),(77,2,'2011-09-20 08:23:28','in'),(78,2,'2011-09-20 08:24:06','out'),(79,1,'2011-09-20 08:24:14','in'),(80,1,'2011-09-20 09:26:00','in'),(81,1,'2011-09-20 10:12:48','in'),(82,1,'2011-09-20 10:12:59','in'),(83,1,'2011-09-20 10:48:54','in'),(84,1,'2011-09-20 11:14:46','out'),(85,2,'2011-09-20 11:15:00','in'),(86,2,'2011-09-20 11:16:56','out'),(87,2,'2011-09-20 11:19:33','in'),(88,1,'2011-09-20 13:08:09','in'),(89,1,'2011-09-20 13:22:00','in'),(90,1,'2011-09-20 13:45:28','in'),(91,1,'2011-09-20 13:50:45','out'),(92,1,'2011-09-20 13:51:20','in'),(93,1,'2011-09-20 13:55:27','out'),(94,1,'2011-09-20 17:02:39','in'),(95,1,'2011-09-20 17:26:08','out'),(96,1,'2011-09-20 17:26:16','out'),(97,1,'2011-09-21 08:50:35','in'),(98,1,'2011-09-21 13:49:23','in'),(99,1,'2011-09-21 13:49:23','in'),(100,4,'2011-09-21 14:18:01','in'),(101,2,'2011-09-21 14:25:12','in'),(102,4,'2011-09-21 14:33:31','out'),(103,2,'2011-09-21 14:33:39','out'),(104,1,'2011-09-21 17:32:19','in'),(105,1,'2011-09-21 17:34:00','in'),(106,2,'2011-09-21 17:34:32','in'),(107,2,'2011-09-21 17:35:16','in'),(108,2,'2011-09-21 18:04:49','out'),(109,1,'2011-09-22 09:33:28','in'),(110,1,'2011-09-22 11:13:46','in'),(111,1,'2011-09-22 11:18:12','in'),(112,1,'2011-09-22 11:55:00','in'),(113,1,'2011-09-22 11:55:09','out'),(114,1,'2011-09-22 11:55:47','in'),(115,2,'2011-09-22 11:59:58','in'),(116,2,'2011-09-22 12:02:47','out'),(117,1,'2011-09-22 12:05:33','out'),(118,1,'2011-09-22 12:07:13','in'),(119,1,'2011-09-22 12:08:07','out'),(120,10,'2011-09-22 12:08:16','in'),(121,11,'2011-09-22 14:06:07','in'),(122,11,'2011-09-22 14:06:15','out'),(123,1,'2011-09-22 14:15:27','out'),(124,1,'2011-09-22 14:19:11','in'),(125,1,'2011-09-22 14:24:50','out'),(126,1,'2011-09-22 14:34:48','in'),(127,11,'2011-09-22 14:46:27','in'),(128,11,'2011-09-22 14:46:30','out'),(129,4,'2011-09-22 15:10:06','in'),(130,4,'2011-09-22 15:10:51','out'),(131,1,'2011-09-22 15:58:19','out'),(132,1,'2011-09-22 16:05:16','in'),(133,1,'2011-09-29 10:04:52','in'),(134,1,'2011-09-30 16:21:19','in'),(135,1,'2011-09-30 16:22:51','out'),(136,2,'2011-09-30 16:23:07','in'),(137,2,'2011-09-30 16:23:38','out'),(138,1,'2011-09-30 16:23:48','in'),(139,1,'2011-10-03 09:31:36','in'),(140,1,'2011-10-03 13:28:56','out'),(141,1,'2011-10-03 13:29:04','in'),(142,1,'2011-10-03 13:29:10','out'),(143,1,'2011-10-03 13:29:35','in'),(144,14,'2011-10-03 13:35:49','in'),(145,1,'2011-10-03 13:46:26','out'),(146,1,'2011-10-03 13:46:44','in'),(147,1,'2011-10-03 14:48:06','out'),(148,1,'2011-10-03 14:48:16','in'),(149,1,'2011-10-03 14:49:28','out'),(150,1,'2011-10-03 14:49:46','in'),(151,1,'2011-10-03 16:03:33','out'),(152,1,'2011-10-03 16:03:46','in'),(153,1,'2011-10-03 16:05:16','out'),(154,1,'2011-10-03 16:05:22','in'),(155,1,'2011-10-04 11:47:00','out'),(156,1,'2011-10-04 11:47:16','in'),(157,1,'2011-10-04 12:03:18','out'),(158,1,'2011-10-04 12:04:52','in'),(159,1,'2011-10-04 12:05:00','out'),(160,1,'2011-10-04 12:05:27','in'),(161,1,'2011-10-04 12:05:30','out'),(162,1,'2011-10-04 12:06:39','in'),(163,1,'2011-10-04 12:07:39','out'),(164,1,'2011-10-04 12:07:45','in'),(165,1,'2011-10-05 13:49:35','in'),(166,1,'2011-10-05 14:09:20','out'),(167,2,'2011-10-05 14:09:34','in'),(168,1,'2011-10-05 14:16:50','in'),(169,2,'2011-10-05 16:12:44','in'),(170,2,'2011-10-05 16:14:47','out'),(171,2,'2011-10-05 16:22:37','in'),(172,1,'2011-10-05 16:47:56','in'),(173,2,'2011-10-06 09:39:27','in'),(174,18,'2011-10-06 11:07:27','in'),(175,1,'2011-10-06 11:09:33','in'),(176,1,'2011-10-06 11:11:15','in'),(177,1,'2011-10-06 11:13:42','out'),(178,2,'2011-10-06 11:20:10','out'),(179,1,'2011-10-06 11:20:16','in'),(180,1,'2011-10-06 11:31:50','out'),(181,1,'2011-10-06 11:36:31','out'),(182,1,'2011-10-06 11:36:33','out'),(183,18,'2011-10-06 11:37:15','out'),(184,1,'2011-10-06 11:47:16','in'),(185,1,'2011-10-06 11:48:59','in'),(186,1,'2011-10-06 11:49:09','in'),(187,18,'2011-10-06 11:49:48','in'),(188,1,'2011-10-06 11:50:11','out'),(189,18,'2011-10-06 11:50:21','in'),(190,1,'2011-10-06 11:53:10','out'),(191,1,'2011-10-07 13:22:44','out'),(192,1,'2011-10-07 15:38:09','in'),(193,1,'2011-10-07 15:43:41','out'),(194,1,'2011-10-10 08:53:10','in'),(195,1,'2011-10-10 08:54:45','in'),(196,1,'2011-10-10 08:56:46','out'),(197,1,'2011-10-10 09:01:31','in'),(198,1,'2011-10-10 09:01:45','out'),(199,1,'2011-10-10 09:25:10','in'),(200,1,'2011-10-10 09:25:54','in'),(201,1,'2011-10-10 09:27:00','in'),(202,1,'2011-10-10 09:38:08','in'),(203,1,'2011-10-10 09:42:00','out'),(204,1,'2011-10-10 09:43:04','out'),(205,1,'2011-10-10 10:51:02','in'),(206,1,'2011-10-10 10:51:10','out'),(207,1,'2011-10-10 11:07:41','in'),(208,1,'2011-10-10 13:30:13','in'),(209,1,'2011-10-10 13:32:09','out'),(210,1,'2011-10-10 13:35:17','in'),(211,18,'2011-10-10 13:43:38','in'),(212,1,'2011-10-10 17:17:58','in'),(213,1,'2011-10-10 17:43:57','in'),(214,1,'2011-10-10 18:01:46','out'),(215,1,'2011-10-12 10:52:00','in'),(216,1,'2011-10-12 15:23:15','out'),(217,1,'2011-10-12 15:27:40','in'),(218,1,'2011-10-12 17:43:47','out'),(219,1,'2011-10-13 08:21:08','in'),(220,1,'2011-10-13 09:51:26','out'),(221,2,'2011-10-13 09:51:35','in'),(222,2,'2011-10-13 10:27:36','out'),(223,1,'2011-10-13 10:27:43','in'),(224,1,'2011-10-13 10:27:54','out'),(225,1,'2011-10-13 10:28:57','in'),(226,1,'2011-10-13 10:31:47','out'),(227,2,'2011-10-13 10:32:40','in'),(228,2,'2011-10-13 10:34:19','out'),(229,1,'2011-10-13 10:34:27','in'),(230,2,'2011-10-13 11:48:22','in'),(231,2,'2011-10-13 11:49:29','out'),(232,1,'2011-10-14 08:53:28','in'),(233,9,'2011-10-14 14:10:54','in'),(234,9,'2011-10-14 14:33:25','in'),(235,1,'2011-10-14 14:40:21','in'),(236,9,'2011-10-14 14:45:18','in'),(237,1,'2011-10-14 14:50:44','in'),(238,9,'2011-10-14 14:52:12','out'),(239,9,'2011-10-14 14:54:55','out'),(240,1,'2011-10-14 14:56:57','out'),(241,1,'2011-10-14 14:57:59','in'),(242,18,'2011-10-14 14:58:44','in'),(243,9,'2011-10-14 15:01:33','out'),(244,1,'2011-10-14 15:54:18','in'),(245,1,'2011-10-14 15:55:29','in'),(246,1,'2011-10-17 08:12:40','in'),(247,1,'2011-10-17 11:58:57','in'),(248,1,'2011-10-17 13:06:37','out'),(249,1,'2011-10-17 13:27:23','in'),(250,1,'2011-10-17 17:29:09','out'),(251,1,'2011-10-18 08:46:34','in'),(252,1,'2011-10-19 10:50:17','in'),(253,2,'2011-10-19 16:35:58','in'),(254,18,'2011-10-19 16:41:22','in'),(255,9,'2011-10-20 09:10:59','in'),(256,9,'2011-10-20 09:11:18','out'),(257,2,'2011-10-21 16:42:16','in'),(258,1,'2011-10-21 16:50:54','out'),(259,2,'2011-10-21 16:50:56','out'),(260,9,'2011-10-24 16:06:33','in'),(261,9,'2011-10-24 16:43:31','out'),(262,1,'2011-10-26 09:33:48','in'),(263,1,'2011-10-26 09:33:54','in'),(264,1,'2011-10-26 09:59:03','in'),(265,1,'2011-10-26 10:04:15','in'),(266,1,'2011-10-26 10:17:29','in'),(267,1,'2011-10-26 10:22:02','in'),(268,1,'2011-10-26 10:27:47','in'),(269,1,'2011-10-26 10:40:19','in'),(270,1,'2011-10-26 10:40:36','in'),(271,1,'2011-10-26 10:43:47','in'),(272,1,'2011-10-26 10:44:01','in'),(273,1,'2011-10-26 10:45:51','out'),(274,1,'2011-10-26 10:47:16','in'),(275,1,'2011-10-26 11:01:15','out'),(276,1,'2011-10-26 11:01:22','in'),(277,1,'2011-10-26 11:02:21','out'),(278,1,'2011-10-26 11:02:28','in'),(279,1,'2011-10-26 11:02:34','in'),(280,1,'2011-10-26 11:57:55','out'),(281,1,'2011-10-26 12:02:12','in'),(282,1,'2011-10-26 12:03:16','out'),(283,1,'2011-10-26 12:03:57','in'),(284,9,'2011-10-26 12:12:14','in'),(285,1,'2011-10-26 13:09:28','out'),(286,1,'2011-10-26 13:14:15','out'),(287,9,'2011-10-26 13:31:16','out'),(288,1,'2011-10-26 14:33:45','in'),(289,1,'2011-10-26 16:24:49','out'),(290,1,'2011-10-26 16:26:06','in'),(291,1,'2011-10-27 11:31:38','in'),(292,1,'2011-10-27 11:32:10','out'),(293,1,'2011-10-28 16:53:03','in'),(294,1,'2011-10-28 16:54:58','out'),(295,4,'2011-10-28 16:55:08','in'),(296,1,'2011-10-28 17:04:04','in'),(297,1,'2011-10-28 17:47:50','out'),(298,9,'2011-10-31 14:44:40','in'),(299,9,'2011-10-31 15:57:38','out'),(300,9,'2011-10-31 16:47:28','in'),(301,9,'2011-10-31 17:00:16','out'),(302,1,'2011-11-01 08:26:12','in'),(303,1,'2011-11-01 09:11:12','out'),(304,1,'2011-11-01 14:09:11','in'),(305,1,'2011-11-14 13:03:45','in'),(306,1,'2011-11-14 15:49:29','out'),(307,9,'2011-11-16 09:28:12','in'),(308,9,'2011-11-16 09:33:32','out'),(309,1,'2011-11-16 16:37:03','in'),(310,9,'2011-11-16 17:02:49','in'),(311,1,'2011-11-21 14:06:56','in'),(312,1,'2011-11-21 17:11:50','in'),(313,1,'2011-11-22 09:44:51','in'),(314,1,'2011-11-22 11:40:20','out'),(315,1,'2011-11-22 11:41:48','in'),(316,9,'2011-11-22 16:15:05','in'),(317,1,'2011-11-23 08:51:25','out'),(318,1,'2011-11-23 10:59:16','in'),(319,1,'2011-11-23 10:59:20','out'),(320,1,'2011-11-23 11:53:02','in'),(321,1,'2011-11-23 11:53:10','out'),(322,1,'2011-11-23 11:53:55','in'),(323,1,'2011-11-23 11:54:02','out'),(324,1,'2011-11-23 13:09:56','in'),(325,1,'2011-11-23 13:10:21','out'),(326,1,'2011-11-23 13:10:32','in'),(327,9,'2011-11-23 13:22:21','out'),(328,1,'2011-11-23 13:23:32','out'),(329,9,'2011-11-23 13:25:30','in'),(330,9,'2011-11-23 13:25:38','out'),(331,1,'2011-11-23 13:59:45','in'),(332,1,'2011-11-23 00:07:48','in'),(333,20,'2011-11-23 00:44:01','in'),(334,1,'2011-11-23 01:01:52','in'),(335,20,'2011-11-23 01:04:26','in'),(336,1,'2011-11-23 01:11:16','in'),(337,1,'2011-11-23 01:20:38','out'),(338,1,'2011-11-23 01:21:24','out'),(339,1,'2011-11-23 01:25:04','in'),(340,1,'2011-11-23 01:28:27','out'),(341,1,'2011-11-23 02:48:32','in'),(342,1,'2011-11-23 02:54:03','out'),(343,20,'2011-11-23 02:57:12','in'),(344,1,'2011-11-24 02:57:33','in'),(345,1,'2011-11-24 02:57:58','in'),(346,20,'2011-11-24 06:14:03','in'),(347,1,'2011-11-24 08:13:43','in'),(348,1,'2011-11-25 00:26:47','in'),(349,1,'2011-12-01 02:15:42','in'),(350,1,'2011-12-01 02:16:59','out'),(351,20,'2011-12-07 02:01:29','in'),(352,20,'2011-12-11 04:41:00','in'),(353,1,'2011-12-12 00:36:25','in'),(354,1,'2011-12-12 00:37:41','out'),(355,1,'2011-12-12 00:38:10','in'),(356,1,'2011-12-12 00:41:53','in'),(357,1,'2011-12-12 00:45:53','out'),(358,1,'2011-12-12 00:46:36','out'),(359,1,'2011-12-12 05:47:09','in'),(360,1,'2011-12-12 05:49:04','out'),(361,1,'2011-12-18 20:09:32','in'),(362,1,'2011-12-20 19:18:21','in'),(363,1,'2011-12-20 19:27:28','out'),(364,1,'2011-12-20 19:34:10','in'),(365,1,'2011-12-20 20:04:31','out'),(366,4,'2011-12-20 21:56:54','in'),(367,4,'2011-12-20 21:57:06','out'),(368,4,'2011-12-20 21:57:45','in'),(369,1,'2011-12-23 22:09:30','in'),(370,1,'2011-12-28 02:29:43','in'),(371,1,'2011-12-28 02:31:02','out'),(372,1,'2011-12-29 01:38:02','in'),(373,1,'2012-01-09 01:30:31','in'),(374,1,'2012-03-12 20:42:31','in'),(375,1,'2012-04-26 01:21:06','in'),(376,1,'2012-05-01 06:43:19','in'),(377,1,'2012-05-24 20:44:33','in'),(378,1,'2013-05-24 03:51:41','in'),(379,1,'2013-05-27 01:57:39','in'),(380,1,'2013-05-27 02:12:23','in'),(381,1,'2013-05-27 02:14:04','in'),(382,1,'2013-05-27 02:16:20','in'),(383,1,'2013-05-27 02:31:48','out'),(384,1,'2013-05-27 05:04:40','in'),(385,2,'2013-05-27 05:51:17','in'),(386,2,'2013-05-27 05:52:13','out'),(387,1,'2013-05-27 07:47:50','in'),(388,1,'2013-05-27 16:48:38','in'),(389,1,'2013-05-27 17:13:43','out'),(390,1,'2013-05-28 01:52:35','in'),(391,1,'2013-05-28 04:49:20','in'),(392,1,'2013-05-30 09:46:42','out'),(393,1,'2013-05-30 09:48:04','in'),(394,1,'2013-05-30 09:48:24','in'),(395,1,'2013-05-30 09:49:42','in'),(396,1,'2013-05-30 09:51:54','in'),(397,1,'2013-05-30 09:53:47','out'),(398,1,'2013-05-30 09:54:09','in'),(399,18,'2013-05-30 10:17:25','in'),(400,18,'2013-05-30 10:18:01','in'),(401,18,'2013-05-30 10:18:25','out'),(402,1,'2013-05-30 10:18:29','out'),(403,18,'2013-05-30 10:18:37','in'),(404,18,'2013-05-30 10:18:54','out'),(405,18,'2013-05-30 10:28:10','in'),(406,18,'2013-05-30 10:29:02','out'),(407,9,'2013-05-30 10:29:16','in'),(408,9,'2013-05-30 10:29:25','out'),(409,1,'2013-05-30 10:29:34','in'),(410,1,'2013-06-03 02:07:25','in'),(411,1,'2013-06-03 02:20:34','out'),(412,18,'2013-06-03 02:21:06','in'),(413,1,'2013-06-03 04:52:11','in'),(414,1,'2013-06-03 04:52:33','out'),(415,1,'2013-06-03 04:52:48','in'),(416,1,'2013-06-03 04:54:08','out'),(417,21,'2013-06-03 04:54:26','in'),(418,21,'2013-06-03 04:54:39','out'),(419,21,'2013-06-03 05:05:22','in'),(420,18,'2013-06-03 05:13:06','in'),(421,18,'2013-06-03 05:18:11','out'),(422,21,'2013-06-03 05:18:19','in'),(423,1,'2013-06-03 08:57:43','in'),(424,1,'2013-06-03 09:00:49','out'),(425,1,'2013-06-03 09:17:12','in'),(426,21,'2013-06-03 10:55:19','in'),(427,21,'2013-06-03 11:11:09','in'),(428,1,'2013-06-03 11:12:32','in'),(429,21,'2013-06-03 11:23:31','in'),(430,21,'2013-06-04 00:56:34','in'),(431,21,'2013-06-04 00:58:16','in'),(432,21,'2013-06-04 01:19:03','out'),(433,21,'2013-06-04 01:19:56','in'),(434,22,'2013-06-04 06:02:45','in'),(435,21,'2013-06-04 09:19:37','in'),(436,21,'2013-06-04 09:38:15','in'),(437,21,'2013-06-05 00:25:43','in'),(438,21,'2013-06-05 00:54:50','in'),(439,21,'2013-06-05 01:20:35','in'),(440,22,'2013-06-05 04:31:32','in'),(441,21,'2013-06-05 11:17:07','in'),(442,21,'2013-06-06 00:56:42','in'),(443,21,'2013-06-06 00:57:32','in'),(444,21,'2013-06-06 02:37:53','in'),(445,21,'2013-06-06 04:14:38','in'),(446,21,'2013-06-06 06:53:56','in'),(447,22,'2013-06-06 07:26:35','in'),(448,21,'2013-06-06 10:03:49','in'),(449,21,'2013-06-07 00:07:55','in'),(450,21,'2013-06-07 01:26:09','in'),(463,22,'2013-06-09 02:18:51','out'),(464,22,'2013-06-09 02:19:05','in'),(465,23,'2013-06-09 03:52:18','in'),(466,22,'2013-06-09 04:13:05','out'),(467,1,'2013-06-09 04:13:12','in'),(468,1,'2013-06-09 04:14:23','out'),(469,1,'2013-06-09 04:14:37','in'),(470,1,'2013-06-09 04:15:17','out'),(471,22,'2013-06-09 04:16:00','in'),(472,22,'2013-06-09 04:17:32','out'),(473,22,'2013-06-09 04:17:39','in'),(474,22,'2013-06-09 04:17:50','out'),(475,22,'2013-06-09 04:17:56','in'),(476,23,'2013-06-09 04:28:54','out'),(477,23,'2013-06-09 04:29:04','in'),(478,23,'2013-06-09 04:47:45','in'),(479,23,'2013-06-09 04:50:36','in'),(480,21,'2013-06-09 07:26:14','in'),(481,21,'2013-06-09 08:59:56','out'),(482,22,'2013-06-09 09:00:05','in'),(483,22,'2013-06-10 00:10:00','in'),(484,21,'2013-06-10 00:12:27','in'),(485,23,'2013-06-10 00:59:06','in'),(486,22,'2013-06-10 05:01:02','in'),(487,23,'2013-06-10 06:01:58','in'),(488,23,'2013-06-11 07:07:31','in'),(489,22,'2013-06-11 07:22:02','in'),(490,22,'2013-06-11 08:21:58','in'),(491,22,'2013-06-11 09:37:49','in'),(492,22,'2013-06-11 10:37:14','in'),(493,22,'2013-06-11 10:41:12','in'),(494,23,'2013-06-11 12:31:36','in'),(495,23,'2013-06-11 15:42:47','in'),(496,22,'2013-06-11 19:38:43','in'),(497,23,'2013-06-12 07:25:19','in'),(498,21,'2013-06-12 07:25:58','in'),(499,21,'2013-06-12 09:33:22','in'),(500,22,'2013-06-12 11:22:47','in'),(501,23,'2013-06-12 16:22:39','in'),(502,23,'2013-06-12 16:33:41','in'),(503,23,'2013-06-12 16:38:26','in'),(504,23,'2013-06-12 16:46:29','in'),(505,23,'2013-06-12 16:56:16','in'),(506,21,'2013-06-13 07:13:55','in'),(507,23,'2013-06-13 07:19:20','in'),(508,23,'2013-06-13 09:07:49','in'),(509,23,'2013-06-13 10:52:19','in'),(510,23,'2013-06-13 11:47:27','in'),(511,24,'2013-06-13 12:34:34','in'),(512,24,'2013-06-13 13:00:59','in'),(513,24,'2013-06-13 13:33:46','in'),(514,24,'2013-06-13 14:21:57','in'),(515,22,'2013-06-13 14:54:21','in'),(516,22,'2013-06-13 15:44:27','in'),(517,22,'2013-06-14 07:25:04','in'),(518,23,'2013-06-14 07:29:33','in'),(519,24,'2013-06-14 10:16:23','in'),(520,24,'2013-06-14 11:13:55','in'),(521,21,'2013-06-14 11:28:21','in'),(522,21,'2013-06-14 11:29:01','in'),(523,24,'2013-06-14 13:48:42','in'),(524,21,'2013-06-14 18:03:23','in'),(525,21,'2013-06-14 18:07:39','in'),(526,21,'2013-06-14 18:09:16','in'),(527,24,'2013-06-14 18:16:54','in'),(528,23,'2013-06-14 19:03:33','in'),(529,22,'2013-06-15 07:33:34','in'),(530,22,'2013-06-15 07:39:36','in'),(531,22,'2013-06-15 07:49:42','in'),(532,22,'2013-06-15 08:12:16','in'),(533,22,'2013-06-15 09:13:33','in'),(534,22,'2013-06-15 09:16:14','in'),(535,22,'2013-06-15 09:16:24','out'),(536,22,'2013-06-15 09:16:32','in'),(537,22,'2013-06-15 09:19:04','in'),(538,22,'2013-06-15 09:48:00','in'),(539,22,'2013-06-15 09:58:00','in'),(540,22,'2013-06-15 13:05:15','in'),(541,22,'2013-06-15 13:33:37','in'),(542,22,'2013-06-15 19:35:56','in'),(543,21,'2013-06-15 20:48:37','in'),(544,22,'2013-06-15 20:51:39','in'),(545,22,'2013-06-15 20:55:53','in'),(546,21,'2013-06-15 21:05:04','in'),(547,21,'2013-06-15 21:06:00','out'),(548,22,'2013-06-15 21:07:06','in'),(549,22,'2013-06-15 21:08:44','in'),(550,21,'2013-06-15 21:11:01','in'),(551,21,'2013-06-15 21:11:35','out'),(552,21,'2013-06-15 21:23:43','in'),(553,21,'2013-06-15 21:23:52','out'),(554,21,'2013-06-16 07:25:05','in'),(555,21,'2013-06-16 07:25:37','in'),(556,21,'2013-06-16 08:25:54','in'),(557,22,'2013-06-16 08:52:00','in'),(558,24,'2013-06-16 09:40:42','in'),(559,23,'2013-06-16 09:55:36','in'),(560,21,'2013-06-16 09:56:52','in'),(561,23,'2013-06-16 10:12:21','in'),(562,24,'2013-06-16 10:13:28','in'),(563,21,'2013-06-16 10:35:58','in'),(564,23,'2013-06-16 10:57:54','in'),(565,23,'2013-06-16 10:58:23','in'),(566,24,'2013-06-16 12:24:49','in'),(567,22,'2013-06-16 13:07:04','in'),(568,23,'2013-06-16 13:07:41','in'),(569,24,'2013-06-16 13:08:38','in'),(570,21,'2013-06-16 13:29:38','in'),(571,23,'2013-06-16 17:09:24','in'),(572,22,'2013-06-16 17:18:21','in'),(573,21,'2013-06-16 20:27:27','in'),(574,21,'2013-06-17 06:50:29','in'),(575,21,'2013-06-17 06:53:21','in'),(576,22,'2013-06-17 06:55:52','in'),(577,21,'2013-06-17 07:12:54','in'),(578,23,'2013-06-17 07:27:43','in'),(579,23,'2013-06-17 07:57:50','in'),(580,24,'2013-06-17 07:58:27','in'),(581,23,'2013-06-17 08:18:55','out'),(582,23,'2013-06-17 08:19:43','in'),(583,23,'2013-06-17 09:57:06','in'),(584,24,'2013-06-17 09:57:33','in'),(585,22,'2013-06-17 10:16:46','in'),(586,23,'2013-06-17 13:49:51','in'),(587,22,'2013-06-17 13:57:29','in'),(588,24,'2013-06-17 17:11:44','in'),(589,24,'2013-06-17 17:14:11','in'),(590,24,'2013-06-17 18:32:51','in'),(591,22,'2013-06-17 18:36:55','in'),(592,22,'2013-06-18 06:37:04','in'),(593,22,'2013-06-18 06:47:32','in'),(594,22,'2013-06-18 07:02:27','in'),(595,23,'2013-06-18 07:13:40','in'),(596,24,'2013-06-18 08:13:59','in'),(597,24,'2013-06-18 08:19:27','in'),(598,22,'2013-06-18 10:01:41','in'),(599,21,'2013-06-18 11:32:09','in'),(600,24,'2013-06-18 13:13:53','in'),(601,23,'2013-06-18 13:17:52','in'),(602,21,'2013-06-18 14:19:22','out'),(603,26,'2013-06-18 14:20:19','in'),(604,26,'2013-06-18 14:20:34','out'),(605,26,'2013-06-18 14:25:55','in'),(606,23,'2013-06-18 14:40:02','in'),(607,23,'2013-06-18 15:26:49','in'),(608,23,'2013-06-18 15:30:39','in'),(609,22,'2013-06-18 15:36:09','in'),(610,23,'2013-06-18 16:18:07','in'),(611,23,'2013-06-18 16:33:04','in'),(612,25,'2013-06-18 17:13:37','in'),(613,26,'2013-06-18 17:42:23','in'),(614,25,'2013-06-18 18:33:34','in'),(615,23,'2013-06-18 19:00:37','in'),(616,21,'2013-06-19 07:13:45','in'),(617,21,'2013-06-19 07:20:33','in'),(618,23,'2013-06-19 07:21:20','in'),(619,26,'2013-06-19 07:34:10','in'),(620,23,'2013-06-19 07:34:57','in'),(621,24,'2013-06-19 08:31:14','in'),(622,22,'2013-06-19 15:52:25','in'),(623,23,'2013-06-19 17:55:59','in'),(624,22,'2013-06-20 06:54:33','in'),(625,26,'2013-06-20 07:09:59','in'),(626,21,'2013-06-20 07:13:17','in'),(627,23,'2013-06-20 07:22:45','in'),(628,23,'2013-06-20 07:38:21','in'),(629,25,'2013-06-20 08:38:52','in'),(630,23,'2013-06-20 09:05:25','in'),(631,23,'2013-06-20 11:11:13','in'),(632,23,'2013-06-20 12:08:59','in'),(633,26,'2013-06-20 12:09:03','in'),(634,22,'2013-06-20 12:32:24','in'),(635,23,'2013-06-20 12:33:27','in'),(636,23,'2013-06-20 13:20:22','in'),(637,22,'2013-06-20 13:37:49','in'),(638,24,'2013-06-20 13:42:08','in'),(639,23,'2013-06-20 14:04:34','in'),(640,23,'2013-06-20 14:34:43','in'),(641,22,'2013-06-20 16:49:21','in'),(642,22,'2013-06-20 17:28:37','in'),(643,26,'2013-06-20 17:29:24','in'),(644,26,'2013-06-20 17:30:47','in'),(645,26,'2013-06-20 17:32:34','in'),(646,26,'2013-06-20 17:34:42','in'),(647,26,'2013-06-20 17:35:29','in'),(648,22,'2013-06-20 18:44:09','in'),(649,22,'2013-06-20 18:44:31','in'),(650,24,'2013-06-20 18:46:33','in'),(651,22,'2013-06-20 18:47:59','in'),(652,22,'2013-06-21 07:07:56','in'),(653,24,'2013-06-21 07:24:00','in'),(654,23,'2013-06-21 07:32:33','in'),(655,22,'2013-06-21 08:10:32','in'),(656,24,'2013-06-21 09:09:27','in'),(657,22,'2013-06-21 09:20:54','in'),(658,25,'2013-06-21 09:25:11','in'),(659,25,'2013-06-21 09:50:28','in'),(660,22,'2013-06-21 10:12:49','in'),(661,25,'2013-06-21 10:51:46','in'),(662,22,'2013-06-21 11:00:38','in'),(663,24,'2013-06-21 11:19:41','in'),(664,22,'2013-06-21 11:53:32','in'),(665,25,'2013-06-21 12:28:25','in'),(666,1,'2013-06-21 16:04:36','in'),(667,23,'2013-06-21 16:05:02','in'),(668,1,'2013-06-21 16:12:17','out'),(669,1,'2013-06-21 16:13:11','in'),(670,23,'2013-06-21 16:23:29','in'),(671,23,'2013-06-21 16:27:49','out'),(672,27,'2013-06-21 16:27:54','in'),(673,27,'2013-06-21 16:33:35','out'),(674,25,'2013-06-21 16:33:43','in'),(675,25,'2013-06-21 17:14:12','out'),(676,25,'2013-06-21 17:18:38','in'),(677,23,'2013-06-21 17:28:25','in'),(678,25,'2013-06-21 17:31:07','in'),(679,22,'2013-06-22 07:08:43','in'),(680,23,'2013-06-22 07:20:41','in'),(681,22,'2013-06-22 07:22:12','in'),(682,24,'2013-06-22 09:17:34','in'),(683,22,'2013-06-22 14:44:36','in'),(684,22,'2013-06-22 14:58:22','in'),(685,22,'2013-06-22 19:06:18','in'),(686,22,'2013-06-23 08:03:02','in'),(687,22,'2013-06-23 08:38:43','in'),(688,22,'2013-06-23 09:00:14','in'),(689,22,'2013-06-23 10:02:52','in'),(690,22,'2013-06-23 13:29:45','in'),(691,22,'2013-06-23 13:46:24','in'),(692,22,'2013-06-23 13:50:17','in'),(693,23,'2013-06-23 13:53:27','in'),(694,25,'2013-06-23 14:07:47','in'),(695,24,'2013-06-23 14:14:44','in'),(696,25,'2013-06-23 17:22:23','in'),(697,23,'2013-06-23 17:37:03','in'),(698,25,'2013-06-23 18:54:29','in'),(699,22,'2013-06-24 06:48:53','in'),(700,24,'2013-06-24 07:37:35','in'),(701,21,'2013-06-24 07:43:48','in'),(702,23,'2013-06-24 08:06:02','in'),(703,24,'2013-06-24 10:03:20','in'),(704,24,'2013-06-24 17:12:22','in'),(705,24,'2013-06-24 20:25:03','in'),(706,22,'2013-06-25 06:57:15','in'),(707,21,'2013-06-25 07:05:02','in'),(708,24,'2013-06-25 07:19:34','in'),(709,23,'2013-06-25 08:11:38','in'),(710,25,'2013-06-25 10:04:57','in'),(711,22,'2013-06-26 07:29:59','in'),(712,23,'2013-06-26 07:31:57','in'),(713,24,'2013-06-26 08:03:13','in'),(714,22,'2013-06-26 08:55:24','in'),(715,24,'2013-06-26 10:47:37','in'),(716,24,'2013-06-26 12:13:11','in'),(717,26,'2013-06-26 16:42:37','in'),(718,26,'2013-06-26 16:52:43','in'),(719,26,'2013-06-26 16:53:35','in'),(720,23,'2013-06-26 17:04:52','in'),(721,25,'2013-06-26 18:20:11','in'),(722,22,'2013-06-27 07:00:53','in'),(723,21,'2013-06-27 07:01:31','in'),(724,23,'2013-06-27 07:15:03','in'),(725,24,'2013-06-27 09:59:22','in'),(726,24,'2013-06-27 13:40:39','in'),(727,22,'2013-06-28 06:47:46','in'),(728,23,'2013-06-28 07:24:35','in'),(729,24,'2013-06-28 07:36:29','in'),(730,1,'2013-06-28 16:10:29','in'),(731,1,'2013-06-28 16:14:26','out'),(732,22,'2013-06-28 17:32:06','in'),(733,25,'2013-06-28 18:50:01','in'),(734,23,'2013-06-29 06:53:21','in'),(735,22,'2013-06-29 07:26:34','in'),(736,25,'2013-06-29 08:35:21','in'),(737,24,'2013-06-29 10:14:56','in'),(738,22,'2013-06-29 13:17:03','in'),(739,22,'2013-06-29 13:25:33','in'),(740,25,'2013-06-29 13:28:25','in'),(741,24,'2013-06-29 20:30:42','in'),(742,22,'2013-06-30 07:10:31','in'),(743,23,'2013-06-30 07:18:20','in'),(744,24,'2013-06-30 08:06:00','in'),(745,24,'2013-06-30 10:00:07','in'),(746,25,'2013-06-30 10:44:08','in'),(747,21,'2013-07-01 07:17:23','in'),(748,24,'2013-07-01 07:27:22','in'),(749,23,'2013-07-01 07:31:14','in'),(750,22,'2013-07-01 07:40:27','in'),(751,24,'2013-07-01 07:44:54','in'),(752,22,'2013-07-02 06:55:16','in'),(753,21,'2013-07-02 07:06:17','in'),(754,23,'2013-07-02 07:46:23','in'),(755,24,'2013-07-02 08:55:45','in'),(756,24,'2013-07-02 12:40:32','in'),(757,22,'2013-07-02 17:12:05','in'),(758,25,'2013-07-02 18:50:39','in'),(759,23,'2013-07-03 07:10:32','in'),(760,22,'2013-07-03 07:32:28','in'),(761,24,'2013-07-03 07:43:41','in'),(762,24,'2013-07-03 08:50:46','in'),(763,24,'2013-07-03 12:54:20','in'),(764,22,'2013-07-03 14:41:49','in'),(765,24,'2013-07-03 14:55:36','in'),(766,24,'2013-07-03 16:35:03','in'),(767,22,'2013-07-04 06:56:44','in'),(768,23,'2013-07-04 07:09:35','in'),(769,24,'2013-07-04 07:13:36','in'),(770,25,'2013-07-04 10:38:49','in'),(771,22,'2013-07-04 12:08:04','in'),(772,23,'2013-07-04 14:37:24','out'),(773,23,'2013-07-04 14:38:59','in'),(774,23,'2013-07-04 15:56:11','out'),(775,23,'2013-07-04 15:56:33','in'),(776,24,'2013-07-04 17:05:59','in'),(777,24,'2013-07-04 17:45:13','in'),(778,24,'2013-07-04 18:20:38','in'),(779,23,'2013-07-05 07:27:27','in'),(780,22,'2013-07-05 07:34:44','in'),(781,24,'2013-07-05 08:04:25','in'),(782,25,'2013-07-05 09:52:18','in'),(783,24,'2013-07-05 10:29:17','in'),(784,23,'2013-07-05 13:26:31','out'),(785,23,'2013-07-05 13:27:18','in'),(786,24,'2013-07-05 15:31:15','in'),(787,23,'2013-07-05 16:14:56','out'),(788,23,'2013-07-05 16:15:36','in'),(789,23,'2013-07-05 16:35:17','in'),(790,25,'2013-07-05 17:53:16','in'),(791,21,'2013-07-06 06:55:52','in'),(792,23,'2013-07-06 07:15:32','in'),(793,24,'2013-07-06 08:03:17','in'),(794,23,'2013-07-06 09:33:02','out'),(795,23,'2013-07-06 09:33:37','in'),(796,24,'2013-07-06 16:24:33','in'),(797,24,'2013-07-07 06:54:19','in'),(798,23,'2013-07-07 07:21:18','in'),(799,22,'2013-07-07 07:33:45','in'),(800,24,'2013-07-07 08:26:08','in'),(801,24,'2013-07-07 10:37:33','in'),(802,24,'2013-07-07 12:08:17','in'),(803,24,'2013-07-07 15:18:33','in'),(804,25,'2013-07-07 18:30:47','in'),(805,24,'2013-07-08 06:58:13','in'),(806,21,'2013-07-08 07:11:16','in'),(807,23,'2013-07-08 07:21:59','in'),(808,22,'2013-07-08 08:23:05','in'),(809,22,'2013-07-08 13:50:29','in'),(810,24,'2013-07-08 13:56:12','in'),(811,24,'2013-07-08 17:00:26','in'),(812,24,'2013-07-08 20:31:56','in'),(813,23,'2013-07-09 07:10:31','in'),(814,24,'2013-07-09 07:37:00','in'),(815,22,'2013-07-09 08:07:13','in'),(816,25,'2013-07-09 09:48:06','in'),(817,24,'2013-07-09 15:00:57','in'),(818,24,'2013-07-09 15:39:21','in'),(819,22,'2013-07-09 17:52:08','in'),(820,22,'2013-07-10 07:28:39','in'),(821,23,'2013-07-10 07:32:41','in'),(822,24,'2013-07-10 07:49:40','in'),(823,24,'2013-07-10 14:42:41','in'),(824,23,'2013-07-10 14:57:45','in'),(825,24,'2013-07-10 17:28:11','in'),(826,22,'2013-07-11 07:11:08','in'),(827,23,'2013-07-11 07:22:31','in'),(828,24,'2013-07-11 08:08:01','in'),(829,25,'2013-07-11 12:10:36','in'),(830,22,'2013-07-12 06:57:17','in'),(831,23,'2013-07-12 07:12:22','in'),(832,23,'2013-07-12 07:28:23','in'),(833,24,'2013-07-12 08:18:48','in'),(834,25,'2013-07-12 10:48:24','in'),(835,23,'2013-07-12 11:16:34','out'),(836,23,'2013-07-12 11:17:30','in'),(837,23,'2013-07-13 07:26:38','in'),(838,22,'2013-07-13 08:09:05','in'),(839,24,'2013-07-13 08:51:14','in'),(840,24,'2013-07-13 08:59:47','in'),(841,22,'2013-07-13 13:34:33','in'),(842,24,'2013-07-13 14:21:51','in'),(843,22,'2013-07-13 15:08:48','in'),(844,22,'2013-07-14 07:17:28','in'),(845,23,'2013-07-14 07:23:48','in'),(846,24,'2013-07-14 07:43:40','in'),(847,23,'2013-07-14 10:44:20','in'),(848,24,'2013-07-14 11:35:50','in'),(849,22,'2013-07-14 12:16:34','in'),(850,23,'2013-07-14 12:19:58','in'),(851,23,'2013-07-14 12:47:32','in'),(852,23,'2013-07-14 14:49:57','in'),(853,23,'2013-07-14 15:36:37','in'),(854,23,'2013-07-14 16:27:11','in'),(855,23,'2013-07-14 16:49:14','in'),(856,23,'2013-07-15 07:34:56','in'),(857,24,'2013-07-15 07:41:56','in'),(858,22,'2013-07-15 13:49:01','in'),(859,24,'2013-07-15 18:09:11','in'),(860,25,'2013-07-15 18:34:36','in'),(861,25,'2013-07-15 18:36:25','out'),(862,28,'2013-07-15 18:36:41','in'),(863,21,'2013-07-16 07:13:44','in'),(864,22,'2013-07-16 07:14:40','in'),(865,24,'2013-07-16 07:33:35','in'),(866,24,'2013-07-17 06:38:01','in'),(867,22,'2013-07-17 07:21:45','in'),(868,26,'2013-07-17 07:24:49','in'),(869,22,'2013-07-17 11:45:30','in'),(870,22,'2013-07-17 11:49:30','in'),(871,22,'2013-07-17 18:17:36','in'),(872,22,'2013-07-18 06:59:44','in'),(873,26,'2013-07-18 07:01:20','in'),(874,24,'2013-07-18 07:29:25','in'),(875,26,'2013-07-18 09:14:01','in'),(876,23,'2013-07-18 10:21:20','in'),(877,24,'2013-07-18 12:24:22','in'),(878,25,'2013-07-18 12:46:13','in'),(879,25,'2013-07-18 13:08:46','in'),(880,25,'2013-07-18 16:44:35','in'),(881,25,'2013-07-18 17:10:40','in'),(882,25,'2013-07-18 18:30:49','in'),(883,25,'2013-07-18 18:31:41','out'),(884,28,'2013-07-18 18:32:54','in'),(885,28,'2013-07-18 18:39:56','in'),(886,24,'2013-07-19 07:10:11','in'),(887,22,'2013-07-19 07:10:35','in'),(888,21,'2013-07-19 07:12:46','in'),(889,28,'2013-07-19 07:21:16','in'),(890,23,'2013-07-19 07:22:40','in'),(891,28,'2013-07-19 17:30:40','in'),(892,22,'2013-07-20 07:10:55','in'),(893,21,'2013-07-20 07:13:25','in'),(894,23,'2013-07-20 07:29:59','in'),(895,28,'2013-07-20 07:47:25','in'),(896,28,'2013-07-20 08:42:48','in'),(897,22,'2013-07-20 09:27:32','in'),(898,26,'2013-07-20 15:09:29','in'),(899,25,'2013-07-20 16:42:41','in'),(900,22,'2013-07-22 07:09:11','in'),(901,21,'2013-07-22 07:18:20','in'),(902,23,'2013-07-22 07:20:50','in'),(903,28,'2013-07-22 08:00:53','in'),(904,24,'2013-07-22 08:14:36','in'),(905,25,'2013-07-22 10:38:36','in'),(906,28,'2013-07-22 10:46:03','in'),(907,28,'2013-07-22 17:56:25','in'),(908,23,'2013-07-23 07:14:44','in'),(909,28,'2013-07-23 07:36:23','in'),(910,24,'2013-07-23 07:36:53','in'),(911,22,'2013-07-23 07:45:40','in'),(912,28,'2013-07-23 15:33:37','in'),(913,28,'2013-07-23 17:25:36','in'),(914,22,'2013-07-24 06:53:58','in'),(915,23,'2013-07-24 07:01:51','in'),(916,24,'2013-07-24 07:19:23','in'),(917,28,'2013-07-24 07:33:05','in'),(918,22,'2013-07-24 07:51:31','in'),(919,22,'2013-07-24 11:41:55','in'),(920,24,'2013-07-24 12:08:11','in'),(921,24,'2013-07-24 15:24:40','in'),(922,28,'2013-07-24 17:36:33','in'),(923,22,'2013-07-25 07:25:55','in'),(924,24,'2013-07-25 07:29:52','in'),(925,28,'2013-07-25 08:07:07','in'),(926,23,'2013-07-25 08:27:30','in'),(927,28,'2013-07-25 08:28:45','in'),(928,28,'2013-07-25 08:29:46','in'),(929,28,'2013-07-25 08:31:07','in'),(930,22,'2013-07-25 08:47:08','in'),(931,23,'2013-07-25 08:47:19','in'),(932,25,'2013-07-25 09:42:53','in'),(933,23,'2013-07-25 11:08:34','in'),(934,28,'2013-07-25 11:18:17','in'),(935,22,'2013-07-25 11:18:59','in'),(936,22,'2013-07-25 15:43:48','in'),(937,28,'2013-07-25 16:56:29','in'),(938,24,'2013-07-26 07:01:16','in'),(939,23,'2013-07-26 07:24:33','in'),(940,22,'2013-07-26 07:27:31','in'),(941,28,'2013-07-26 10:22:05','in'),(942,24,'2013-07-26 10:38:35','in'),(943,22,'2013-07-26 11:03:07','in'),(944,22,'2013-07-26 15:44:39','in'),(945,28,'2013-07-26 16:40:33','in'),(946,28,'2013-07-26 17:05:53','in'),(947,24,'2013-07-27 07:07:10','in'),(948,22,'2013-07-27 07:12:52','in'),(949,23,'2013-07-27 07:13:28','in'),(950,28,'2013-07-27 08:03:59','in'),(951,28,'2013-07-27 08:25:17','in'),(952,26,'2013-07-27 11:22:13','in'),(953,28,'2013-07-27 15:01:17','in'),(954,22,'2013-07-27 15:02:54','in'),(955,22,'2013-07-27 18:09:28','in'),(956,22,'2013-07-28 09:49:10','in'),(957,22,'2013-07-29 09:23:41','in'),(958,26,'2013-07-29 09:29:00','in'),(959,24,'2013-07-29 09:31:55','in'),(960,28,'2013-07-29 10:05:13','in'),(961,26,'2013-07-29 11:10:01','in'),(962,28,'2013-07-29 14:34:03','in'),(963,26,'2013-07-29 17:53:41','in'),(964,26,'2013-07-30 07:26:46','in'),(965,22,'2013-07-30 07:35:52','in'),(966,28,'2013-07-30 07:42:14','in'),(967,24,'2013-07-30 07:50:55','in'),(968,28,'2013-07-30 10:29:07','in'),(969,22,'2013-07-30 10:31:27','in'),(970,22,'2013-07-31 06:53:29','in'),(971,28,'2013-07-31 07:05:31','in'),(972,24,'2013-07-31 07:07:56','in'),(973,26,'2013-07-31 07:35:03','in'),(974,26,'2013-07-31 07:51:01','in'),(975,26,'2013-07-31 08:35:49','in'),(976,28,'2013-07-31 11:39:21','in'),(977,24,'2013-08-01 07:16:47','in'),(978,28,'2013-08-01 07:24:12','in'),(979,22,'2013-08-01 07:33:26','in'),(980,26,'2013-08-01 08:01:06','in'),(981,22,'2013-08-01 18:55:59','in'),(982,22,'2013-08-02 07:11:38','in'),(983,24,'2013-08-02 07:34:35','in'),(984,26,'2013-08-02 07:34:45','in'),(985,28,'2013-08-02 07:34:55','in'),(986,26,'2013-08-02 07:50:45','in'),(987,22,'2013-08-02 09:24:32','in'),(988,28,'2013-08-02 09:27:14','in'),(989,1,'2013-08-02 11:39:11','in'),(990,1,'2013-08-02 12:09:58','out'),(991,1,'2013-08-02 12:10:17','in'),(992,1,'2013-08-02 12:10:43','out'),(993,1,'2013-08-02 12:10:59','in'),(994,1,'2013-08-02 12:14:29','in'),(995,1,'2013-08-02 12:16:03','out'),(996,22,'2013-08-02 12:35:33','in'),(997,28,'2013-08-02 16:33:27','in'),(998,22,'2013-08-02 17:36:41','out'),(999,10,'2013-08-02 17:36:51','in'),(1000,10,'2013-08-02 17:37:02','out'),(1001,1,'2013-08-02 17:37:17','in'),(1002,1,'2013-08-02 17:37:30','out'),(1003,22,'2013-08-03 06:57:57','in'),(1004,28,'2013-08-03 07:00:30','in'),(1005,24,'2013-08-03 07:35:53','in'),(1006,23,'2013-08-03 07:57:10','in'),(1007,28,'2013-08-03 08:10:29','in'),(1008,28,'2013-08-03 09:04:57','in'),(1009,28,'2013-08-03 09:08:53','out'),(1010,28,'2013-08-03 09:09:38','in'),(1011,22,'2013-08-03 10:09:44','in'),(1012,24,'2013-08-03 11:09:41','in'),(1013,22,'2013-08-03 19:09:38','in'),(1014,24,'2013-08-04 06:58:50','in'),(1015,23,'2013-08-04 07:38:07','in'),(1016,28,'2013-08-04 07:39:13','in'),(1017,28,'2013-08-04 07:51:14','in'),(1018,22,'2013-08-04 11:30:23','in'),(1019,24,'2013-08-04 13:21:00','in'),(1020,22,'2013-08-04 13:21:25','in'),(1021,22,'2013-08-04 13:24:15','in'),(1022,23,'2013-08-04 13:40:44','in'),(1023,22,'2013-08-05 06:47:55','in'),(1024,24,'2013-08-05 07:08:40','in'),(1025,23,'2013-08-05 07:22:39','in'),(1026,28,'2013-08-05 07:43:47','in'),(1027,24,'2013-08-05 07:56:11','in'),(1028,22,'2013-08-05 13:50:04','in'),(1029,28,'2013-08-06 07:17:20','in'),(1030,22,'2013-08-06 07:27:56','in'),(1031,23,'2013-08-06 07:39:50','in'),(1032,24,'2013-08-06 08:07:26','in'),(1033,23,'2013-08-07 07:02:11','in'),(1034,28,'2013-08-07 07:05:06','in'),(1035,24,'2013-08-07 07:21:45','in'),(1036,22,'2013-08-07 07:45:43','in'),(1037,23,'2013-08-07 09:15:50','out'),(1038,23,'2013-08-07 09:17:20','in'),(1039,22,'2013-08-07 09:25:06','in'),(1040,28,'2013-08-07 11:08:21','in'),(1041,25,'2013-08-07 11:48:05','in'),(1042,24,'2013-08-08 06:52:33','in'),(1043,28,'2013-08-08 07:01:03','in'),(1044,23,'2013-08-08 07:31:29','in'),(1045,22,'2013-08-08 07:51:06','in'),(1046,23,'2013-08-08 08:17:10','in'),(1047,25,'2013-08-08 10:54:24','in'),(1048,25,'2013-08-08 17:02:02','in'),(1049,28,'2013-08-08 17:23:29','in'),(1050,24,'2013-08-09 07:16:51','in'),(1051,23,'2013-08-09 07:18:10','in'),(1052,22,'2013-08-09 07:42:45','in'),(1053,28,'2013-08-09 07:44:17','in'),(1054,23,'2013-08-09 13:19:29','in'),(1055,23,'2013-08-09 16:12:46','in'),(1056,23,'2013-08-09 16:15:11','in'),(1057,22,'2013-08-10 06:43:22','in'),(1058,28,'2013-08-10 06:47:17','in'),(1059,23,'2013-08-10 07:22:26','in'),(1060,28,'2013-08-10 07:23:24','in'),(1061,24,'2013-08-10 07:27:50','in'),(1062,25,'2013-08-10 09:01:50','in'),(1063,25,'2013-08-10 09:29:36','in'),(1064,22,'2013-08-10 09:36:34','in'),(1065,22,'2013-08-10 14:07:35','in'),(1066,28,'2013-08-10 14:59:50','in'),(1067,28,'2013-08-11 06:40:22','in'),(1068,23,'2013-08-11 07:08:07','in'),(1069,24,'2013-08-11 07:14:58','in'),(1070,22,'2013-08-11 07:31:49','in'),(1071,28,'2013-08-11 08:06:05','in'),(1072,24,'2013-08-11 18:08:51','in'),(1073,22,'2013-08-11 18:36:23','in'),(1074,28,'2013-08-12 06:37:51','in'),(1075,22,'2013-08-12 06:45:35','in'),(1076,23,'2013-08-12 07:24:44','in'),(1077,24,'2013-08-12 07:25:15','in'),(1078,23,'2013-08-12 08:51:59','in'),(1079,25,'2013-08-12 11:47:48','in'),(1080,28,'2013-08-12 11:50:23','in'),(1081,22,'2013-08-12 18:16:19','in'),(1082,22,'2013-08-12 18:20:28','in'),(1083,24,'2013-08-13 05:45:27','in'),(1084,28,'2013-08-13 06:43:19','in'),(1085,22,'2013-08-13 07:24:48','in'),(1086,23,'2013-08-13 07:25:20','in'),(1087,23,'2013-08-14 07:06:35','in'),(1088,28,'2013-08-14 07:08:02','in'),(1089,22,'2013-08-14 07:34:35','in'),(1090,24,'2013-08-14 07:43:38','in'),(1091,23,'2013-08-14 10:01:14','out'),(1092,23,'2013-08-14 10:01:35','in'),(1093,22,'2013-08-14 13:13:07','in'),(1094,22,'2013-08-14 13:16:16','in'),(1095,28,'2013-08-15 07:26:53','in'),(1096,23,'2013-08-15 07:38:41','in'),(1097,22,'2013-08-15 07:51:00','in'),(1098,24,'2013-08-15 08:33:18','in'),(1099,28,'2013-08-15 10:18:16','in'),(1100,25,'2013-08-15 10:35:29','in'),(1101,24,'2013-08-15 17:31:53','in'),(1102,22,'2013-08-16 07:22:48','in'),(1103,24,'2013-08-16 07:22:59','in'),(1104,28,'2013-08-16 07:24:49','in'),(1105,23,'2013-08-16 07:25:13','in'),(1106,24,'2013-08-16 13:56:55','in'),(1107,23,'2013-08-17 07:20:58','in'),(1108,22,'2013-08-17 07:26:40','in'),(1109,24,'2013-08-17 07:34:29','in'),(1110,28,'2013-08-17 07:39:27','in'),(1111,22,'2013-08-18 07:16:40','in'),(1112,28,'2013-08-18 07:19:14','in'),(1113,23,'2013-08-18 07:33:27','in'),(1114,24,'2013-08-18 08:29:22','in'),(1115,23,'2013-08-18 08:30:53','in'),(1116,23,'2013-08-18 11:56:28','in'),(1117,24,'2013-08-19 06:39:09','in'),(1118,23,'2013-08-19 07:17:51','in'),(1119,22,'2013-08-19 07:27:35','in'),(1120,28,'2013-08-19 08:14:16','in'),(1121,28,'2013-08-20 07:11:28','in'),(1122,23,'2013-08-20 07:22:52','in'),(1123,24,'2013-08-20 07:26:54','in'),(1124,22,'2013-08-20 07:32:24','in'),(1125,24,'2013-08-20 10:20:13','in'),(1126,28,'2013-08-20 10:36:14','in'),(1127,24,'2013-08-20 13:48:27','in'),(1128,28,'2013-08-21 07:20:01','in'),(1129,23,'2013-08-21 07:20:15','in'),(1130,24,'2013-08-21 07:25:04','in'),(1131,22,'2013-08-21 07:57:18','in'),(1132,24,'2013-08-22 06:46:54','in'),(1133,23,'2013-08-22 07:23:47','in'),(1134,28,'2013-08-22 07:38:56','in'),(1135,23,'2013-08-22 09:35:26','in'),(1136,24,'2013-08-22 11:24:26','in'),(1137,24,'2013-08-23 06:54:16','in'),(1138,23,'2013-08-23 07:30:25','in'),(1139,28,'2013-08-23 07:32:37','in'),(1140,22,'2013-08-23 07:41:16','in'),(1141,24,'2013-08-23 14:07:06','in'),(1142,22,'2013-08-24 06:50:08','in'),(1143,23,'2013-08-24 07:23:36','in'),(1144,24,'2013-08-24 07:48:32','in'),(1145,28,'2013-08-24 08:00:08','in'),(1146,22,'2013-08-24 14:20:54','in'),(1147,24,'2013-08-25 07:25:41','in'),(1148,28,'2013-08-25 07:33:53','in'),(1149,22,'2013-08-25 07:37:06','in'),(1150,23,'2013-08-25 07:39:34','in'),(1151,22,'2013-08-25 08:02:38','in'),(1152,23,'2013-08-25 08:32:21','in'),(1153,24,'2013-08-25 20:46:17','in'),(1154,22,'2013-08-25 21:00:34','in'),(1155,28,'2013-08-26 06:51:28','in'),(1156,22,'2013-08-26 07:02:33','in'),(1157,26,'2013-08-26 07:11:20','in'),(1158,24,'2013-08-26 07:22:15','in'),(1159,23,'2013-08-26 07:29:18','in'),(1160,25,'2013-08-26 10:20:35','in'),(1161,23,'2013-08-26 12:19:15','in'),(1162,28,'2013-08-26 14:37:23','in'),(1163,25,'2013-08-26 17:09:04','in'),(1164,24,'2013-08-27 07:25:53','in'),(1165,28,'2013-08-27 07:28:02','in'),(1166,23,'2013-08-27 07:41:52','in'),(1167,22,'2013-08-27 07:46:41','in'),(1168,25,'2013-08-27 09:45:21','in'),(1169,25,'2013-08-27 13:45:41','in'),(1170,28,'2013-08-27 16:49:59','in'),(1171,23,'2013-08-28 07:32:59','in'),(1172,28,'2013-08-28 07:35:34','in'),(1173,24,'2013-08-28 08:25:43','in'),(1174,26,'2013-08-28 12:21:51','in'),(1175,22,'2013-08-28 12:23:26','in'),(1176,23,'2013-08-28 12:30:16','in'),(1177,23,'2013-08-28 12:40:29','in'),(1178,22,'2013-08-28 12:40:50','in'),(1179,28,'2013-08-28 12:55:13','in'),(1180,28,'2013-08-29 07:07:44','in'),(1181,22,'2013-08-29 07:09:32','in'),(1182,23,'2013-08-29 07:22:00','in'),(1183,23,'2013-08-29 07:33:51','in'),(1184,24,'2013-08-29 08:54:33','in'),(1185,28,'2013-08-29 11:00:22','in'),(1186,28,'2013-08-29 11:02:46','in'),(1187,24,'2013-08-30 07:24:00','in'),(1188,26,'2013-08-30 07:29:12','in'),(1189,22,'2013-08-30 07:32:26','in'),(1190,28,'2013-08-30 07:58:24','in'),(1191,23,'2013-08-30 08:31:48','in'),(1192,28,'2013-08-30 12:14:10','in'),(1193,23,'2013-08-30 12:33:18','in'),(1194,24,'2013-08-30 15:49:37','in'),(1195,24,'2013-08-30 15:54:03','in'),(1196,22,'2013-08-31 07:23:00','in'),(1197,28,'2013-08-31 07:36:53','in'),(1198,24,'2013-08-31 07:39:26','in'),(1199,23,'2013-08-31 08:04:13','in'),(1200,23,'2013-08-31 08:23:20','in'),(1201,23,'2013-08-31 16:12:01','in'),(1202,28,'2013-09-01 07:10:30','in'),(1203,23,'2013-09-01 07:26:06','in'),(1204,22,'2013-09-01 07:28:56','in'),(1205,24,'2013-09-01 08:46:15','in'),(1206,24,'2013-09-01 18:31:02','in'),(1207,22,'2013-09-01 18:31:27','in'),(1208,28,'2013-09-02 06:52:17','in'),(1209,22,'2013-09-02 06:53:10','in'),(1210,23,'2013-09-02 07:28:18','in'),(1211,24,'2013-09-02 07:35:31','in'),(1212,23,'2013-09-02 15:35:36','in'),(1213,23,'2013-09-02 15:37:54','in'),(1214,28,'2013-09-03 07:13:27','in'),(1215,28,'2013-09-03 07:14:19','in'),(1216,24,'2013-09-03 07:24:05','in'),(1217,23,'2013-09-03 07:26:41','in'),(1218,22,'2013-09-03 07:28:35','in'),(1219,22,'2013-09-04 07:11:04','in'),(1220,23,'2013-09-04 07:21:14','in'),(1221,24,'2013-09-04 07:28:22','in'),(1222,28,'2013-09-04 07:37:15','in'),(1223,22,'2013-09-04 12:06:59','in'),(1224,24,'2013-09-04 15:18:24','in'),(1225,28,'2013-09-04 18:06:58','in'),(1226,28,'2013-09-05 06:57:34','in'),(1227,23,'2013-09-05 07:25:32','in'),(1228,24,'2013-09-05 07:55:20','in'),(1229,22,'2013-09-05 08:19:23','in'),(1230,24,'2013-09-05 10:12:39','in'),(1231,28,'2013-09-06 06:54:08','in'),(1232,22,'2013-09-06 07:05:13','in'),(1233,23,'2013-09-06 07:17:37','in'),(1234,24,'2013-09-06 08:22:46','in'),(1235,28,'2013-09-06 09:22:12','in'),(1236,28,'2013-09-06 13:52:35','in'),(1237,24,'2013-09-06 13:53:06','in'),(1238,22,'2013-09-06 13:54:44','in'),(1239,28,'2013-09-06 15:09:24','in'),(1240,24,'2013-09-06 15:40:27','in'),(1241,22,'2013-09-07 07:19:14','in'),(1242,28,'2013-09-07 07:19:49','in'),(1243,23,'2013-09-07 07:20:49','in'),(1244,24,'2013-09-07 07:46:54','in'),(1245,23,'2013-09-07 10:34:07','in'),(1246,22,'2013-09-08 07:09:15','in'),(1247,23,'2013-09-08 07:21:35','in'),(1248,24,'2013-09-08 07:26:55','in'),(1249,28,'2013-09-08 07:27:07','in'),(1250,23,'2013-09-08 11:58:04','in'),(1251,22,'2013-09-09 07:04:59','in'),(1252,28,'2013-09-09 07:09:58','in'),(1253,23,'2013-09-09 07:28:28','in'),(1254,24,'2013-09-09 07:38:45','in'),(1255,28,'2013-09-09 11:58:45','in'),(1256,28,'2013-09-09 16:27:14','in'),(1257,22,'2013-09-10 07:24:17','in'),(1258,26,'2013-09-10 07:33:20','in'),(1259,23,'2013-09-10 07:38:02','in'),(1260,28,'2013-09-10 07:43:37','in'),(1261,24,'2013-09-10 08:11:47','in'),(1262,25,'2013-09-10 12:29:18','in'),(1263,25,'2013-09-10 12:29:50','out'),(1264,25,'2013-09-10 12:39:02','in'),(1265,25,'2013-09-10 12:45:36','in'),(1266,23,'2013-09-10 12:56:52','in'),(1267,28,'2013-09-10 15:50:53','in'),(1268,28,'2013-09-10 16:22:50','in'),(1269,22,'2013-09-10 18:52:34','in'),(1270,23,'2013-09-11 07:18:48','in'),(1271,28,'2013-09-11 07:20:16','in'),(1272,24,'2013-09-11 07:25:51','in'),(1273,22,'2013-09-11 07:30:57','in'),(1274,28,'2013-09-11 07:53:35','in'),(1275,23,'2013-09-11 10:56:22','in'),(1276,24,'2013-09-11 15:56:44','in'),(1277,28,'2013-09-11 16:10:48','in'),(1278,25,'2013-09-11 16:43:59','in'),(1279,28,'2013-09-12 07:01:42','in'),(1280,26,'2013-09-12 07:10:18','in'),(1281,23,'2013-09-12 07:40:18','in'),(1282,26,'2013-09-12 07:41:53','in'),(1283,22,'2013-09-12 07:45:16','in'),(1284,26,'2013-09-12 08:04:02','out'),(1285,24,'2013-09-12 08:04:17','in'),(1286,28,'2013-09-12 11:28:05','in'),(1287,23,'2013-09-12 13:49:44','in'),(1288,23,'2013-09-13 07:31:11','in'),(1289,24,'2013-09-13 08:03:40','in'),(1290,22,'2013-09-13 08:37:16','in'),(1291,25,'2013-09-13 10:17:52','in'),(1292,22,'2013-09-14 07:07:35','in'),(1293,23,'2013-09-14 07:32:45','in'),(1294,24,'2013-09-14 07:40:40','in'),(1295,24,'2013-09-14 12:49:51','in'),(1296,28,'2013-09-14 13:53:36','in'),(1297,24,'2013-09-14 14:36:34','in'),(1298,24,'2013-09-14 15:12:19','in'),(1299,24,'2013-09-14 15:19:02','in'),(1300,23,'2013-09-14 18:26:20','in'),(1301,24,'2013-09-15 06:39:50','in'),(1302,28,'2013-09-15 07:00:14','in'),(1303,24,'2013-09-15 07:19:01','in'),(1304,23,'2013-09-15 07:31:37','in'),(1305,28,'2013-09-15 07:42:19','in'),(1306,22,'2013-09-15 07:52:59','in'),(1307,24,'2013-09-15 12:09:16','in'),(1308,24,'2013-09-15 12:13:14','in'),(1309,24,'2013-09-15 13:26:23','in'),(1310,24,'2013-09-15 13:52:56','in'),(1311,28,'2013-09-16 06:38:21','in'),(1312,24,'2013-09-16 07:09:02','in'),(1313,23,'2013-09-16 07:27:26','in'),(1314,22,'2013-09-16 07:59:48','in'),(1315,28,'2013-09-16 15:45:14','in'),(1316,24,'2013-09-16 18:03:12','in'),(1317,28,'2013-09-17 07:05:28','in'),(1318,24,'2013-09-17 07:12:08','in'),(1319,23,'2013-09-17 07:35:50','in'),(1320,28,'2013-09-17 09:30:54','in'),(1321,22,'2013-09-17 14:17:43','in'),(1322,24,'2013-09-17 15:40:49','in'),(1323,28,'2013-09-17 16:42:18','in'),(1324,23,'2013-09-18 07:19:00','in'),(1325,24,'2013-09-18 07:28:53','in'),(1326,28,'2013-09-18 07:32:29','in'),(1327,22,'2013-09-18 08:10:49','in'),(1328,24,'2013-09-18 09:36:07','in'),(1329,22,'2013-09-18 10:00:14','in'),(1330,28,'2013-09-18 14:08:44','in'),(1331,22,'2013-09-18 15:42:57','in'),(1332,24,'2013-09-19 07:05:00','in'),(1333,28,'2013-09-19 07:21:06','in'),(1334,22,'2013-09-19 07:28:15','in'),(1335,23,'2013-09-19 08:08:14','in'),(1336,28,'2013-09-19 09:08:53','in'),(1337,22,'2013-09-19 10:54:46','in'),(1338,28,'2013-09-19 13:44:55','in'),(1339,28,'2013-09-20 07:02:37','in'),(1340,24,'2013-09-20 07:09:47','in'),(1341,23,'2013-09-20 07:37:14','in'),(1342,22,'2013-09-20 07:45:08','in'),(1343,28,'2013-09-21 07:38:23','in'),(1344,23,'2013-09-21 07:48:17','in'),(1345,24,'2013-09-21 09:54:19','in'),(1346,28,'2013-09-21 10:47:21','in'),(1347,23,'2013-09-21 10:48:48','in'),(1348,28,'2013-09-22 07:06:51','in'),(1349,23,'2013-09-22 07:22:38','in'),(1350,24,'2013-09-22 07:40:41','in'),(1351,22,'2013-09-22 08:04:43','in'),(1352,28,'2013-09-22 10:23:15','in'),(1353,24,'2013-09-22 13:17:01','in'),(1354,23,'2013-09-22 15:11:21','in'),(1355,24,'2013-09-23 06:56:46','in'),(1356,26,'2013-09-23 07:27:20','in'),(1357,28,'2013-09-23 07:33:00','in'),(1358,22,'2013-09-23 08:21:32','in'),(1359,23,'2013-09-23 08:25:27','in'),(1360,24,'2013-09-23 09:45:39','in'),(1361,22,'2013-09-23 12:17:51','in'),(1362,23,'2013-09-23 12:19:55','in'),(1363,28,'2013-09-23 12:37:56','in'),(1364,22,'2013-09-23 13:50:36','in'),(1365,25,'2013-09-23 19:16:12','in'),(1366,25,'2013-09-23 19:16:28','out'),(1367,25,'2013-09-23 19:16:42','in'),(1368,22,'2013-09-24 06:59:15','in'),(1369,28,'2013-09-24 07:02:40','in'),(1370,23,'2013-09-24 07:03:18','in'),(1371,24,'2013-09-24 07:26:46','in'),(1372,22,'2013-09-24 09:43:47','in'),(1373,26,'2013-09-24 17:10:14','in'),(1374,23,'2013-09-24 17:16:21','in'),(1375,22,'2013-09-24 18:50:38','in'),(1376,25,'2013-09-24 19:35:49','in'),(1377,22,'2013-09-25 07:03:33','in'),(1378,24,'2013-09-25 07:16:19','in'),(1379,26,'2013-09-25 07:16:32','in'),(1380,23,'2013-09-25 07:27:10','in'),(1381,28,'2013-09-25 13:30:42','in'),(1382,22,'2013-09-25 18:52:29','in'),(1383,22,'2013-09-25 21:15:37','in'),(1384,28,'2013-09-26 06:30:27','in'),(1385,28,'2013-09-26 06:36:13','in'),(1386,22,'2013-09-26 06:48:30','in'),(1387,23,'2013-09-26 07:00:18','in'),(1388,24,'2013-09-26 07:51:20','in'),(1389,28,'2013-09-26 10:45:28','in'),(1390,24,'2013-09-26 10:46:50','in'),(1391,23,'2013-09-26 10:46:54','in'),(1392,22,'2013-09-26 11:16:35','in'),(1393,23,'2013-09-26 17:44:36','in'),(1394,25,'2013-09-26 19:14:08','in'),(1395,28,'2013-09-27 06:17:43','in'),(1396,22,'2013-09-27 07:17:33','in'),(1397,23,'2013-09-27 07:24:50','in'),(1398,24,'2013-09-27 07:41:47','in'),(1399,24,'2013-09-27 18:33:17','in'),(1400,22,'2013-09-28 06:33:37','in'),(1401,28,'2013-09-28 06:35:47','in'),(1402,23,'2013-09-28 07:28:54','in'),(1403,24,'2013-09-28 07:59:07','in'),(1404,28,'2013-09-29 06:46:22','in'),(1405,23,'2013-09-29 07:03:14','in'),(1406,24,'2013-09-29 07:07:45','in'),(1407,22,'2013-09-29 08:05:21','in'),(1408,28,'2013-09-29 11:55:43','in'),(1409,22,'2013-09-29 13:33:10','in'),(1410,28,'2013-09-29 16:15:27','in'),(1411,28,'2013-09-30 06:15:02','in'),(1412,24,'2013-09-30 06:51:38','in'),(1413,22,'2013-09-30 07:04:25','in'),(1414,23,'2013-09-30 07:33:56','in'),(1415,24,'2013-09-30 12:40:21','in'),(1416,23,'2013-09-30 12:49:01','in'),(1417,28,'2013-09-30 12:57:16','in'),(1418,22,'2013-09-30 13:26:32','in'),(1419,23,'2013-09-30 20:06:55','in'),(1420,22,'2013-09-30 21:33:10','in'),(1421,22,'2013-10-01 06:36:45','in'),(1422,23,'2013-10-01 07:40:55','in'),(1423,28,'2013-10-01 07:51:32','in'),(1424,25,'2013-10-01 08:42:14','in'),(1425,25,'2013-10-01 09:02:44','in'),(1426,28,'2013-10-01 14:10:49','in'),(1427,22,'2013-10-01 15:20:15','in'),(1428,22,'2013-10-02 06:51:42','in'),(1429,23,'2013-10-02 07:10:09','in'),(1430,23,'2013-10-02 07:42:09','in'),(1431,28,'2013-10-02 09:13:03','in'),(1432,25,'2013-10-02 09:56:22','in'),(1433,22,'2013-10-02 12:01:55','in'),(1434,28,'2013-10-02 12:28:39','in'),(1435,23,'2013-10-02 18:46:27','in'),(1436,25,'2013-10-02 19:28:11','in'),(1437,22,'2013-10-03 07:18:23','in'),(1438,23,'2013-10-03 07:30:44','in'),(1439,22,'2013-10-03 12:08:27','in'),(1440,22,'2013-10-03 13:56:35','in'),(1441,22,'2013-10-03 14:39:58','in'),(1442,25,'2013-10-06 20:03:09','in'),(1443,23,'2013-10-06 20:03:21','in'),(1444,25,'2013-10-06 20:07:24','in'),(1445,23,'2013-10-06 20:07:40','in'),(1446,23,'2013-10-06 21:11:37','in'),(1447,25,'2013-10-06 21:33:01','in'),(1448,25,'2013-10-07 07:15:57','in'),(1449,23,'2013-10-07 07:34:44','in'),(1450,25,'2013-10-07 19:56:22','in'),(1451,23,'2013-10-08 07:28:21','in'),(1452,22,'2013-10-08 08:05:04','in'),(1453,22,'2013-10-08 09:46:01','in'),(1454,23,'2013-10-09 07:06:07','in'),(1455,22,'2013-10-09 07:43:16','in'),(1456,25,'2013-10-09 10:43:26','in'),(1457,25,'2013-10-09 17:36:23','in'),(1458,22,'2013-10-10 06:55:00','in'),(1459,23,'2013-10-10 07:16:39','in'),(1460,23,'2013-10-10 16:55:56','in'),(1461,22,'2013-10-11 07:08:10','in'),(1462,23,'2013-10-11 07:20:07','in'),(1463,28,'2013-10-11 13:49:37','in'),(1464,25,'2013-10-11 14:06:53','in'),(1465,22,'2013-10-11 15:06:46','in'),(1466,23,'2013-10-12 07:21:00','in'),(1467,22,'2013-10-12 07:22:23','in'),(1468,22,'2013-10-12 09:14:50','in'),(1469,22,'2013-10-12 09:36:34','in'),(1470,22,'2013-10-12 14:04:48','in'),(1471,22,'2013-10-13 06:51:08','in'),(1472,23,'2013-10-13 07:23:21','in'),(1473,23,'2013-10-13 16:25:24','in'),(1474,22,'2013-10-13 18:17:42','in'),(1475,22,'2013-10-13 19:41:02','in'),(1476,22,'2013-10-14 06:57:21','in'),(1477,23,'2013-10-14 07:24:31','in'),(1478,22,'2013-10-14 08:01:26','in'),(1479,22,'2013-10-14 10:19:39','in'),(1480,22,'2013-10-14 11:41:44','in'),(1481,24,'2013-10-14 12:53:13','in'),(1482,22,'2013-10-14 14:30:18','in'),(1483,23,'2013-10-14 15:43:56','in'),(1484,22,'2013-10-15 07:20:05','in'),(1485,23,'2013-10-15 07:23:35','in'),(1486,24,'2013-10-15 07:29:56','in'),(1487,22,'2013-10-15 13:17:10','in'),(1488,24,'2013-10-16 07:08:21','in'),(1489,22,'2013-10-16 07:26:11','in'),(1490,23,'2013-10-16 07:34:46','in'),(1491,23,'2013-10-16 15:16:30','in'),(1492,22,'2013-10-16 17:38:34','in'),(1493,23,'2013-10-17 07:28:16','in'),(1494,24,'2013-10-17 07:32:37','in'),(1495,23,'2013-10-17 10:57:29','in'),(1496,22,'2013-10-17 14:34:23','in'),(1497,25,'2013-10-17 15:05:35','in'),(1498,25,'2013-10-17 18:07:36','in'),(1499,23,'2013-10-18 07:37:01','in'),(1500,22,'2013-10-18 07:47:22','in'),(1501,24,'2013-10-18 11:47:01','in'),(1502,25,'2013-10-18 12:43:15','in'),(1503,23,'2013-10-18 13:56:20','in'),(1504,22,'2013-10-19 07:52:10','in'),(1505,23,'2013-10-19 07:57:07','in'),(1506,22,'2013-10-20 07:16:12','in'),(1507,23,'2013-10-20 07:26:03','in'),(1508,24,'2013-10-20 07:27:00','in'),(1509,22,'2013-10-21 07:14:11','in'),(1510,23,'2013-10-21 07:33:07','in'),(1511,24,'2013-10-21 07:50:36','in'),(1512,24,'2013-10-21 14:43:23','in'),(1513,22,'2013-10-22 07:24:31','in'),(1514,23,'2013-10-22 07:37:09','in'),(1515,24,'2013-10-22 07:46:13','in'),(1516,22,'2013-10-22 09:15:33','in'),(1517,21,'2013-10-22 10:44:02','in'),(1518,23,'2013-10-22 12:34:37','in'),(1519,24,'2013-10-22 13:51:49','in'),(1520,24,'2013-10-22 13:52:47','in'),(1521,24,'2013-10-22 13:55:00','in'),(1522,22,'2013-10-22 16:33:14','in'),(1523,24,'2013-10-22 18:40:20','in'),(1524,24,'2013-10-23 06:21:40','in'),(1525,22,'2013-10-23 07:17:16','in'),(1526,23,'2013-10-23 07:28:29','in'),(1527,23,'2013-10-24 07:30:13','in'),(1528,22,'2013-10-24 07:45:15','in'),(1529,22,'2013-10-24 07:48:46','in'),(1530,24,'2013-10-24 07:51:38','in'),(1531,22,'2013-10-24 09:41:02','in'),(1532,23,'2013-10-24 10:14:27','in'),(1533,23,'2013-10-24 17:54:35','in'),(1534,24,'2013-10-25 06:17:08','in'),(1535,23,'2013-10-25 07:25:12','in'),(1536,24,'2013-10-25 10:24:40','in'),(1537,22,'2013-10-25 20:03:32','in'),(1538,22,'2013-10-26 06:44:35','in'),(1539,24,'2013-10-26 07:31:10','in'),(1540,23,'2013-10-26 07:33:39','in'),(1541,22,'2013-10-26 09:53:21','in'),(1542,22,'2013-10-26 13:17:11','in'),(1543,25,'2013-10-26 15:19:11','in'),(1544,25,'2013-10-26 15:23:07','out'),(1545,23,'2013-10-26 15:31:22','in'),(1546,22,'2013-10-26 18:11:49','in'),(1547,23,'2013-10-27 07:38:15','in'),(1548,24,'2013-10-27 07:38:37','in'),(1549,22,'2013-10-27 08:02:14','in'),(1550,22,'2013-10-27 12:40:43','in'),(1551,22,'2013-10-27 20:10:09','in'),(1552,22,'2013-10-28 07:02:55','in'),(1553,24,'2013-10-28 07:09:48','in'),(1554,23,'2013-10-28 08:22:24','in'),(1555,22,'2013-10-28 16:36:30','in'),(1556,22,'2013-10-28 20:20:24','in'),(1557,22,'2013-10-28 21:05:14','in'),(1558,22,'2013-10-29 06:52:36','in'),(1559,24,'2013-10-29 07:30:20','in'),(1560,23,'2013-10-29 07:41:16','in'),(1561,25,'2013-10-29 11:01:27','in'),(1562,22,'2013-10-29 14:10:40','in'),(1563,23,'2013-10-29 18:37:52','in'),(1564,22,'2013-10-30 07:12:21','in'),(1565,23,'2013-10-30 07:22:45','in'),(1566,24,'2013-10-30 08:09:21','in'),(1567,22,'2013-10-30 18:01:46','in'),(1568,24,'2013-10-31 07:12:25','in'),(1569,22,'2013-10-31 07:23:31','in'),(1570,23,'2013-10-31 07:31:13','in'),(1571,22,'2013-10-31 10:29:41','in'),(1572,22,'2013-10-31 11:09:41','in'),(1573,22,'2013-11-01 07:38:42','in'),(1574,23,'2013-11-01 07:47:33','in'),(1575,24,'2013-11-01 08:29:55','in'),(1576,22,'2013-11-01 09:08:42','in'),(1577,25,'2013-11-02 00:01:56','in'),(1578,22,'2013-11-02 07:07:01','in'),(1579,24,'2013-11-02 07:22:04','in'),(1580,23,'2013-11-02 07:36:22','in'),(1581,24,'2013-11-02 09:38:00','in'),(1582,22,'2013-11-03 06:52:15','in'),(1583,24,'2013-11-03 07:07:03','in'),(1584,23,'2013-11-03 07:20:25','in'),(1585,22,'2013-11-03 12:11:24','in'),(1586,22,'2013-11-04 07:12:28','in'),(1587,23,'2013-11-04 07:25:04','in'),(1588,24,'2013-11-04 07:26:33','in'),(1589,22,'2013-11-05 07:24:48','in'),(1590,23,'2013-11-05 07:29:03','in'),(1591,24,'2013-11-05 07:43:08','in'),(1592,22,'2013-11-05 12:39:52','in'),(1593,22,'2013-11-05 13:06:33','in'),(1594,24,'2013-11-05 14:22:07','in'),(1595,22,'2013-11-05 19:29:30','in'),(1596,22,'2013-11-06 06:19:17','in'),(1597,23,'2013-11-06 09:16:42','in'),(1598,23,'2013-11-06 09:41:02','in'),(1599,24,'2013-11-06 09:46:37','in'),(1600,23,'2013-11-06 10:00:29','in'),(1601,22,'2013-11-06 10:01:15','in'),(1602,25,'2013-11-06 10:02:02','in'),(1603,23,'2013-11-06 10:26:16','in'),(1604,22,'2013-11-07 07:09:32','in'),(1605,24,'2013-11-07 08:17:43','in'),(1606,23,'2013-11-07 08:55:37','in'),(1607,22,'2013-11-07 18:25:15','in'),(1608,24,'2013-11-08 07:15:16','in'),(1609,22,'2013-11-08 07:41:42','in'),(1610,23,'2013-11-08 07:43:45','in'),(1611,22,'2013-11-08 16:46:05','in'),(1612,22,'2013-11-08 17:35:17','in'),(1613,22,'2013-11-08 18:56:13','in'),(1614,24,'2013-11-08 18:56:19','in'),(1615,22,'2013-11-08 19:50:30','in'),(1616,24,'2013-11-09 07:13:33','in'),(1617,23,'2013-11-09 07:21:34','in'),(1618,22,'2013-11-09 19:37:45','in'),(1619,25,'2013-11-10 00:41:14','in'),(1620,25,'2013-11-10 00:41:25','out'),(1621,25,'2013-11-10 00:41:46','in'),(1622,22,'2013-11-10 07:30:06','in'),(1623,23,'2013-11-10 07:50:07','in'),(1624,22,'2013-11-10 08:24:48','in'),(1625,22,'2013-11-10 13:06:23','in'),(1626,23,'2013-11-10 17:24:27','in'),(1627,22,'2013-11-11 07:13:33','in'),(1628,24,'2013-11-11 07:33:56','in'),(1629,23,'2013-11-11 08:19:50','in'),(1630,22,'2013-11-11 10:41:00','in'),(1631,25,'2013-11-11 13:19:51','in'),(1632,25,'2013-11-11 13:20:49','out'),(1633,29,'2013-11-11 13:20:57','in'),(1634,21,'2013-11-12 07:28:55','in'),(1635,23,'2013-11-12 07:30:33','in'),(1636,21,'2013-11-12 11:33:25','in'),(1637,22,'2013-11-12 13:23:09','in'),(1638,21,'2013-11-12 15:33:20','in'),(1639,22,'2013-11-12 15:50:11','in'),(1640,23,'2013-11-12 15:53:12','in'),(1641,21,'2013-11-12 15:56:28','in'),(1642,23,'2013-11-12 16:46:25','in'),(1643,21,'2013-11-12 17:17:05','in'),(1644,21,'2013-11-13 07:30:03','in'),(1645,23,'2013-11-13 07:39:02','in'),(1646,22,'2013-11-13 08:03:36','in'),(1647,22,'2013-11-13 08:58:36','in'),(1648,22,'2013-11-14 07:02:45','in'),(1649,23,'2013-11-14 09:02:34','in'),(1650,22,'2013-11-14 09:04:21','in'),(1651,22,'2013-11-14 11:48:16','in'),(1652,22,'2013-11-14 14:50:37','in'),(1653,22,'2013-11-15 07:16:40','in'),(1654,22,'2013-11-15 08:17:48','in'),(1655,22,'2013-11-15 08:27:31','in'),(1656,22,'2013-11-15 08:36:55','in'),(1657,29,'2013-11-15 10:45:14','in'),(1658,25,'2013-11-15 11:11:18','in'),(1659,22,'2013-11-15 11:36:42','in'),(1660,23,'2013-11-15 16:21:02','in'),(1661,22,'2013-11-15 17:16:35','in'),(1662,22,'2013-11-15 18:20:50','in'),(1663,25,'2013-11-15 18:51:32','in'),(1664,23,'2013-11-16 07:49:12','in'),(1665,22,'2013-11-16 07:58:26','in'),(1666,22,'2013-11-16 08:40:57','in'),(1667,22,'2013-11-16 10:31:02','in'),(1668,22,'2013-11-16 13:45:47','in'),(1669,22,'2013-11-17 07:30:44','in'),(1670,23,'2013-11-17 07:49:06','in'),(1671,23,'2013-11-17 10:04:17','in'),(1672,22,'2013-11-17 10:04:40','in'),(1673,22,'2013-11-18 07:14:17','in'),(1674,23,'2013-11-18 08:08:59','in'),(1675,23,'2013-11-18 08:18:23','in'),(1676,29,'2013-11-18 10:38:05','in'),(1677,22,'2013-11-18 15:40:29','in'),(1678,22,'2013-11-18 19:12:11','in'),(1679,22,'2013-11-19 07:37:13','in'),(1680,23,'2013-11-19 08:14:04','in'),(1681,23,'2013-11-19 11:20:26','in'),(1682,22,'2013-11-19 12:29:18','in'),(1683,22,'2013-11-20 07:35:16','in'),(1684,22,'2013-11-20 08:42:37','in'),(1685,25,'2013-11-20 11:09:54','in'),(1686,23,'2013-11-20 11:28:21','in'),(1687,22,'2013-11-20 14:54:21','in'),(1688,25,'2013-11-20 16:23:46','in'),(1689,23,'2013-11-21 07:19:47','in'),(1690,22,'2013-11-21 07:54:30','in'),(1691,22,'2013-11-21 09:42:29','in'),(1692,23,'2013-11-22 07:20:46','in'),(1693,22,'2013-11-22 07:42:11','in'),(1694,22,'2013-11-22 09:17:30','in'),(1695,22,'2013-11-22 09:59:51','in'),(1696,23,'2013-11-22 12:24:01','out'),(1697,23,'2013-11-22 12:24:45','in'),(1698,23,'2013-11-23 07:25:56','in'),(1699,22,'2013-11-23 07:30:36','in'),(1700,22,'2013-11-23 09:12:26','in'),(1701,22,'2013-11-23 10:48:55','in'),(1702,22,'2013-11-23 13:51:40','in'),(1703,29,'2013-11-23 14:22:19','in'),(1704,25,'2013-11-23 16:11:25','in'),(1705,22,'2013-11-24 07:18:35','in'),(1706,23,'2013-11-24 07:31:41','in'),(1707,29,'2013-11-24 09:09:29','in'),(1708,23,'2013-11-25 07:41:30','in'),(1709,22,'2013-11-25 07:43:30','in'),(1710,22,'2013-11-25 09:15:43','in'),(1711,22,'2013-11-25 10:41:34','in'),(1712,29,'2013-11-25 12:16:21','in'),(1713,23,'2013-11-26 07:41:25','in'),(1714,22,'2013-11-26 08:12:50','in'),(1715,29,'2013-11-26 09:02:44','in'),(1716,22,'2013-11-27 07:11:11','in'),(1717,29,'2013-11-27 07:24:29','in'),(1718,23,'2013-11-27 07:25:02','in'),(1719,23,'2013-11-27 09:59:33','in'),(1720,22,'2013-11-27 10:06:53','in'),(1721,22,'2013-11-27 16:27:25','in'),(1722,22,'2013-11-28 07:10:57','in'),(1723,23,'2013-11-28 08:04:35','in'),(1724,22,'2013-11-28 08:09:42','in'),(1725,29,'2013-11-28 11:01:12','in'),(1726,22,'2013-11-28 14:46:58','in'),(1727,23,'2013-11-28 15:00:59','in'),(1728,22,'2013-11-29 07:22:50','in'),(1729,23,'2013-11-29 07:24:57','in'),(1730,29,'2013-11-29 10:17:55','in'),(1731,25,'2013-11-29 11:50:53','in'),(1732,25,'2013-11-29 11:53:22','in'),(1733,25,'2013-11-29 11:57:32','in'),(1734,25,'2013-11-29 12:41:58','in'),(1735,22,'2013-11-29 12:48:30','in'),(1736,25,'2013-11-29 13:05:56','in'),(1737,25,'2013-11-29 13:26:23','in'),(1738,25,'2013-11-29 13:45:18','in'),(1739,22,'2013-11-29 20:04:19','in'),(1740,22,'2013-11-29 20:08:24','in'),(1741,22,'2013-11-30 07:16:39','in'),(1742,23,'2013-11-30 07:18:17','in'),(1743,22,'2013-11-30 08:10:48','in'),(1744,25,'2013-11-30 12:43:01','in'),(1745,25,'2013-11-30 12:43:09','out'),(1746,25,'2013-11-30 13:18:23','in'),(1747,23,'2013-11-30 15:19:36','in'),(1748,23,'2013-12-01 07:37:03','in'),(1749,22,'2013-12-01 07:57:00','in'),(1750,29,'2013-12-01 09:47:40','in'),(1751,29,'2013-12-01 13:27:21','in'),(1752,23,'2013-12-02 07:15:55','in'),(1753,22,'2013-12-02 07:27:18','in'),(1754,29,'2013-12-02 11:23:06','in'),(1755,22,'2013-12-03 07:32:26','in'),(1756,25,'2013-12-03 08:39:09','in'),(1757,29,'2013-12-03 10:35:26','in'),(1758,25,'2013-12-03 11:56:43','in'),(1759,22,'2013-12-03 16:49:41','in'),(1760,22,'2013-12-03 18:59:23','in'),(1761,22,'2013-12-04 07:09:58','in'),(1762,23,'2013-12-04 10:20:25','in'),(1763,22,'2013-12-04 14:33:57','in'),(1764,22,'2013-12-05 07:38:10','in'),(1765,23,'2013-12-05 07:42:45','in'),(1766,22,'2013-12-05 07:47:07','in'),(1767,22,'2013-12-05 07:49:40','in'),(1768,22,'2013-12-05 09:31:04','in'),(1769,22,'2013-12-05 10:35:02','in'),(1770,22,'2013-12-05 17:57:11','in'),(1771,22,'2013-12-05 18:42:02','in'),(1772,22,'2013-12-06 07:43:18','in'),(1773,23,'2013-12-06 07:56:35','in'),(1774,29,'2013-12-06 10:12:27','in'),(1775,22,'2013-12-06 19:27:40','in'),(1776,25,'2013-12-06 21:12:28','in'),(1777,25,'2013-12-06 22:53:37','in'),(1778,25,'2013-12-06 22:54:10','out'),(1779,25,'2013-12-06 23:05:01','in'),(1780,25,'2013-12-06 23:17:31','in'),(1781,23,'2013-12-07 08:09:21','in'),(1782,22,'2013-12-07 08:32:26','in'),(1783,29,'2013-12-07 09:31:12','in'),(1784,25,'2013-12-07 10:00:52','in'),(1785,25,'2013-12-07 10:34:46','in'),(1786,25,'2013-12-07 10:39:51','in'),(1787,22,'2013-12-07 10:41:55','in'),(1788,22,'2013-12-07 11:11:32','in'),(1789,23,'2013-12-07 11:23:33','in'),(1790,25,'2013-12-07 12:22:55','in'),(1791,23,'2013-12-07 12:41:36','in'),(1792,22,'2013-12-07 13:04:03','in'),(1793,22,'2013-12-08 07:31:34','in'),(1794,23,'2013-12-08 07:40:53','in'),(1795,29,'2013-12-08 09:54:18','in'),(1796,23,'2013-12-08 11:40:53','in'),(1797,23,'2013-12-08 12:04:41','in'),(1798,23,'2013-12-08 12:48:09','in'),(1799,22,'2013-12-08 17:21:38','in'),(1800,25,'2013-12-08 19:22:01','in'),(1801,22,'2013-12-09 07:36:14','in'),(1802,23,'2013-12-09 07:37:00','in'),(1803,25,'2013-12-09 09:54:04','in'),(1804,25,'2013-12-09 10:23:58','in'),(1805,22,'2013-12-09 10:44:07','in'),(1806,23,'2013-12-09 11:19:05','in'),(1807,25,'2013-12-09 12:20:07','in'),(1808,22,'2013-12-10 07:06:00','in'),(1809,22,'2013-12-10 08:37:37','in'),(1810,22,'2013-12-10 09:18:05','in'),(1811,22,'2013-12-10 16:24:34','in'),(1812,25,'2013-12-11 10:41:55','in'),(1813,25,'2013-12-11 12:46:51','in'),(1814,22,'2013-12-12 07:22:45','in'),(1815,22,'2013-12-12 08:15:22','in'),(1816,23,'2013-12-12 08:27:46','in'),(1817,23,'2013-12-12 11:44:12','in'),(1818,22,'2013-12-13 07:28:18','in'),(1819,23,'2013-12-13 07:54:10','in'),(1820,29,'2013-12-13 14:12:08','in'),(1821,22,'2013-12-14 07:47:05','in'),(1822,23,'2013-12-14 07:48:00','in'),(1823,29,'2013-12-14 07:50:29','in'),(1824,23,'2013-12-14 09:11:05','in'),(1825,25,'2013-12-14 19:03:29','in'),(1826,22,'2013-12-15 07:51:37','in'),(1827,23,'2013-12-15 08:07:58','in'),(1828,22,'2013-12-15 18:28:24','in'),(1829,22,'2013-12-16 07:10:05','in'),(1830,23,'2013-12-16 07:24:15','in'),(1831,29,'2013-12-16 08:57:34','in'),(1832,22,'2013-12-17 07:24:49','in'),(1833,29,'2013-12-17 07:32:47','in'),(1834,23,'2013-12-17 07:39:56','in'),(1835,22,'2013-12-17 12:42:58','in'),(1836,22,'2013-12-17 13:25:23','in'),(1837,22,'2013-12-17 15:31:44','in'),(1838,23,'2013-12-18 07:24:11','in'),(1839,29,'2013-12-18 07:28:02','in'),(1840,22,'2013-12-18 08:00:28','in'),(1841,23,'2013-12-18 08:35:33','in'),(1842,22,'2013-12-18 17:12:05','in'),(1843,22,'2013-12-19 07:27:08','in'),(1844,23,'2013-12-19 07:47:44','in'),(1845,29,'2013-12-19 07:52:50','in'),(1846,25,'2013-12-19 11:17:02','in'),(1847,23,'2013-12-19 11:57:20','in'),(1848,22,'2013-12-19 17:44:46','in'),(1849,29,'2013-12-20 07:30:19','in'),(1850,22,'2013-12-20 07:44:39','in'),(1851,22,'2013-12-20 10:34:24','in'),(1852,29,'2013-12-20 13:52:17','in'),(1853,29,'2013-12-20 16:01:04','in'),(1854,22,'2013-12-21 07:22:02','in'),(1855,23,'2013-12-21 07:39:26','in'),(1856,22,'2013-12-21 09:13:48','in'),(1857,22,'2013-12-22 07:29:19','in'),(1858,23,'2013-12-22 07:32:07','in'),(1859,22,'2013-12-22 07:40:51','in'),(1860,29,'2013-12-22 13:08:21','in'),(1861,22,'2013-12-22 13:15:48','in'),(1862,22,'2013-12-23 08:05:26','in'),(1863,29,'2013-12-23 08:38:26','in'),(1864,29,'2013-12-23 10:55:28','in'),(1865,23,'2013-12-24 07:24:27','in'),(1866,22,'2013-12-24 07:47:56','in'),(1867,29,'2013-12-24 11:10:05','in'),(1868,23,'2013-12-25 07:27:14','in'),(1869,22,'2013-12-25 08:10:41','in'),(1870,29,'2013-12-25 11:20:50','in'),(1871,23,'2013-12-26 07:43:16','in'),(1872,29,'2013-12-26 07:54:17','in'),(1873,29,'2013-12-26 10:44:35','in'),(1874,29,'2013-12-26 11:46:40','in'),(1875,23,'2013-12-27 07:40:01','in'),(1876,22,'2013-12-27 08:08:56','in'),(1877,22,'2013-12-27 11:25:46','in'),(1878,22,'2013-12-27 19:44:23','in'),(1879,23,'2013-12-28 07:40:55','in'),(1880,22,'2013-12-28 07:41:12','in'),(1881,29,'2013-12-28 10:25:29','in'),(1882,23,'2013-12-28 14:41:30','in'),(1883,23,'2013-12-29 07:40:16','in'),(1884,25,'2013-12-29 08:28:37','in'),(1885,22,'2013-12-29 09:42:58','in'),(1886,23,'2013-12-30 07:45:40','in'),(1887,22,'2013-12-30 07:46:57','in'),(1888,23,'2013-12-30 09:00:07','in'),(1889,29,'2013-12-30 10:51:14','in'),(1890,22,'2013-12-31 07:29:34','in'),(1891,23,'2013-12-31 07:35:02','in'),(1892,25,'2013-12-31 12:10:30','in'),(1893,23,'2013-12-31 13:59:04','in'),(1894,23,'2013-12-31 15:00:57','in'),(1895,23,'2014-01-01 07:30:51','in'),(1896,22,'2014-01-01 09:55:39','in'),(1897,22,'2014-01-01 15:20:10','in'),(1898,22,'2014-01-02 07:41:08','in'),(1899,23,'2014-01-02 07:47:08','in'),(1900,22,'2014-01-02 13:01:32','in'),(1901,22,'2014-01-03 07:34:36','in'),(1902,23,'2014-01-03 07:42:59','in'),(1903,22,'2014-01-04 07:30:42','in'),(1904,23,'2014-01-04 07:35:08','in'),(1905,25,'2014-01-04 10:12:14','in'),(1906,23,'2014-01-05 07:25:28','in'),(1907,22,'2014-01-05 07:47:48','in'),(1908,22,'2014-01-05 08:06:48','in'),(1909,22,'2014-01-06 07:24:22','in'),(1910,22,'2014-01-06 15:21:17','in'),(1911,22,'2014-01-07 07:04:03','in'),(1912,23,'2014-01-07 07:24:59','in'),(1913,22,'2014-01-07 11:25:32','in'),(1914,22,'2014-01-08 07:29:25','in'),(1915,23,'2014-01-08 07:42:57','in'),(1916,23,'2014-01-09 07:42:54','in'),(1917,22,'2014-01-09 07:52:19','in'),(1918,23,'2014-01-10 07:23:47','in'),(1919,22,'2014-01-10 07:27:20','in'),(1920,22,'2014-01-11 07:38:21','in'),(1921,23,'2014-01-11 07:56:21','in'),(1922,22,'2014-01-11 16:54:44','in'),(1923,22,'2014-01-12 07:22:57','in'),(1924,23,'2014-01-12 07:32:28','in'),(1925,22,'2014-01-13 07:41:10','in'),(1926,23,'2014-01-13 08:02:12','in'),(1927,23,'2014-01-14 07:33:44','in'),(1928,22,'2014-01-14 08:17:38','in'),(1929,22,'2014-01-14 08:18:12','in'),(1930,23,'2014-01-15 07:31:42','in'),(1931,22,'2014-01-15 08:18:46','in'),(1932,23,'2014-01-16 07:36:14','in'),(1933,22,'2014-01-16 08:12:42','in'),(1934,22,'2014-01-16 11:39:40','out'),(1935,22,'2014-01-16 11:40:03','in'),(1936,22,'2014-01-16 15:39:17','in'),(1937,23,'2014-01-17 07:35:14','in'),(1938,22,'2014-01-17 07:45:33','in'),(1939,23,'2014-01-18 07:36:55','in'),(1940,22,'2014-01-18 08:04:57','in'),(1941,23,'2014-01-18 09:42:58','in'),(1942,23,'2014-01-19 07:28:07','in'),(1943,22,'2014-01-19 07:31:43','in'),(1944,23,'2014-01-20 07:38:50','in'),(1945,22,'2014-01-20 07:42:15','in'),(1946,22,'2014-01-21 07:34:54','in'),(1947,23,'2014-01-21 07:37:24','in'),(1948,22,'2014-01-22 07:33:15','in'),(1949,23,'2014-01-22 07:50:36','in'),(1950,23,'2014-01-23 07:23:13','in'),(1951,22,'2014-01-23 07:54:59','in'),(1952,23,'2014-01-24 07:26:07','in'),(1953,22,'2014-01-24 07:48:58','in'),(1954,22,'2014-01-24 08:37:26','in'),(1955,22,'2014-01-24 08:53:40','in'),(1956,25,'2014-01-24 09:23:09','in'),(1957,25,'2014-01-24 09:35:43','in'),(1958,25,'2014-01-24 09:37:04','out'),(1959,27,'2014-01-24 09:37:14','in'),(1960,27,'2014-01-24 09:37:54','out'),(1961,25,'2014-01-24 09:40:04','in'),(1962,25,'2014-01-24 09:57:12','in'),(1963,25,'2014-01-24 09:59:02','in'),(1964,25,'2014-01-24 10:13:43','in'),(1965,23,'2014-01-24 10:51:17','in'),(1966,23,'2014-01-25 07:41:10','in'),(1967,22,'2014-01-25 08:07:01','in'),(1968,22,'2014-01-25 13:52:33','in'),(1969,23,'2014-01-26 07:23:22','in'),(1970,22,'2014-01-26 07:57:23','in'),(1971,23,'2014-01-27 07:41:54','in'),(1972,22,'2014-01-27 08:43:25','in'),(1973,22,'2014-01-28 07:28:12','in'),(1974,23,'2014-01-28 08:07:17','in'),(1975,23,'2014-01-28 09:06:50','in'),(1976,23,'2014-01-29 07:38:36','in'),(1977,22,'2014-01-29 07:42:00','in'),(1978,25,'2014-01-29 09:31:18','in'),(1979,23,'2014-01-29 17:27:03','out'),(1980,28,'2014-01-29 17:27:12','in'),(1981,28,'2014-01-29 17:28:42','out'),(1982,27,'2014-01-29 17:28:47','in'),(1983,27,'2014-01-29 17:39:57','out'),(1984,25,'2014-01-29 17:40:03','in'),(1985,22,'2014-01-30 08:38:00','in'),(1986,22,'2014-02-01 08:22:51','in'),(1987,22,'2014-02-02 14:19:14','in'),(1988,22,'2014-02-03 07:34:02','in'),(1989,23,'2014-02-03 07:38:00','in'),(1990,22,'2014-02-03 08:55:27','in'),(1991,22,'2014-02-04 07:44:08','in'),(1992,22,'2014-02-04 15:03:21','in'),(1993,22,'2014-02-05 07:39:32','in'),(1994,22,'2014-02-05 08:05:43','in'),(1995,1,'2014-02-05 10:51:32','in'),(1996,1,'2014-02-05 11:25:19','in'),(1997,1,'2014-02-05 14:05:47','out'),(1998,1,'2014-02-05 14:34:58','in'),(1999,1,'2014-02-06 12:06:08','in'),(2000,1,'2014-02-06 12:57:51','out'),(2001,1,'2014-02-06 14:50:22','in'),(2002,1,'2014-02-06 15:17:53','in'),(2003,1,'2014-02-07 08:51:16','in'),(2004,1,'2014-02-10 09:38:15','in'),(2005,1,'2014-02-11 08:33:23','in'),(2006,34,'2014-02-11 13:31:33','out'),(2007,1,'2014-02-11 13:31:46','in'),(2008,1,'2014-02-11 14:26:59','in'),(2009,1,'2014-02-12 09:16:07','in'),(2010,1,'2014-02-12 13:52:13','in'),(2011,1,'2014-02-13 08:31:42','in'),(2012,34,'2014-02-13 13:33:00','out'),(2013,1,'2014-02-13 17:01:24','in'),(2014,1,'2014-02-14 08:33:52','in'),(2015,1,'2014-02-17 08:29:44','in'),(2016,1,'2014-02-18 08:54:18','in'),(2017,1,'2014-02-19 09:27:31','in'),(2018,1,'2014-02-20 13:02:18','in'),(2019,1,'2014-02-21 08:41:04','in'),(2020,1,'2014-02-21 11:46:45','in'),(2021,34,'2014-02-21 13:11:15','out'),(2022,1,'2014-02-21 13:11:23','in'),(2023,1,'2014-02-21 13:52:51','out'),(2024,1,'2014-02-21 13:52:59','in'),(2025,1,'2014-02-21 14:07:30','out'),(2026,1,'2014-02-21 14:07:38','in'),(2027,1,'2014-02-21 14:08:19','out'),(2028,1,'2014-02-21 14:08:31','in'),(2029,1,'2014-02-21 14:08:39','out'),(2030,1,'2014-02-21 14:08:54','in'),(2031,1,'2014-02-24 08:37:19','in'),(2032,1,'2014-02-24 08:45:04','out'),(2033,1,'2014-02-24 08:45:18','in'),(2034,1,'2014-02-24 08:53:16','out'),(2035,1,'2014-02-24 08:53:40','in'),(2036,1,'2014-02-24 08:54:51','out'),(2037,1,'2014-02-24 08:55:32','in'),(2038,1,'2014-02-24 15:27:50','out'),(2039,1,'2014-02-24 15:28:01','in'),(2040,1,'2014-02-25 08:28:37','in'),(2041,1,'2014-02-25 12:07:26','in'),(2042,1,'2014-02-26 08:27:23','in'),(2043,2,'2014-03-04 15:00:17','out'),(2044,1,'2014-03-04 15:00:34','in'),(2045,1,'2014-03-04 15:02:07','out'),(2046,1,'2014-03-04 15:08:51','in'),(2047,1,'2014-03-04 15:25:27','out'),(2048,1,'2014-08-06 10:15:26','in'),(2049,1,'2014-08-06 11:16:45','in'),(2050,1,'2014-08-07 08:48:37','in'),(2051,1,'2014-08-07 09:19:34','in'),(2052,1,'2014-08-08 08:58:17','in'),(2053,1,'2014-08-08 13:12:46','in'),(2054,1,'2014-08-11 09:19:09','in'),(2055,1,'2014-08-12 08:35:45','in'),(2056,1,'2014-08-13 08:48:36','in'),(2057,1,'2014-08-13 15:16:53','in'),(2058,1,'2014-08-14 08:42:35','in'),(2059,1,'2014-08-14 10:26:49','out'),(2060,1,'2014-08-14 10:26:56','in'),(2061,1,'2014-08-14 10:29:06','in'),(2062,1,'2014-08-14 10:31:16','out'),(2063,1,'2014-08-14 10:31:23','in'),(2064,1,'2014-08-14 10:32:28','in'),(2065,1,'2014-08-14 10:33:25','out'),(2066,1,'2014-08-14 10:33:35','in'),(2067,1,'2014-08-15 08:51:17','in'),(2068,1,'2014-08-18 09:00:24','in'),(2069,1,'2014-08-19 08:48:16','in'),(2070,1,'2014-08-20 10:18:21','in'),(2071,1,'2014-08-20 11:22:39','in'),(2072,1,'2014-08-20 16:14:27','in'),(2073,1,'2014-08-20 16:18:24','out'),(2074,1,'2014-08-20 16:18:32','in'),(2075,1,'2014-08-21 08:35:07','in'),(2076,1,'2014-08-22 08:53:26','in'),(2077,1,'2014-08-22 14:21:21','in'),(2078,1,'2014-08-25 09:30:34','in'),(2079,1,'2014-08-25 10:51:00','in'),(2080,1,'2014-08-26 08:37:29','in'),(2081,1,'2014-08-27 08:40:56','in'),(2082,1,'2014-08-27 13:19:37','in'),(2083,1,'2014-08-28 08:52:35','in'),(2084,1,'2014-08-29 09:11:08','in'),(2085,1,'2014-08-29 10:45:47','in'),(2086,1,'2014-09-01 08:58:59','in'),(2087,1,'2014-09-01 09:08:03','out'),(2088,1,'2014-09-01 09:08:13','in'),(2089,1,'2014-09-01 09:09:09','in'),(2090,1,'2014-09-02 08:24:52','in'),(2091,1,'2014-09-02 16:47:59','out'),(2092,1,'2014-09-02 16:48:10','in'),(2093,1,'2014-09-02 16:48:20','out'),(2094,1,'2014-09-02 16:48:30','in'),(2095,1,'2014-09-03 08:38:13','in'),(2096,1,'2014-09-03 15:03:23','in'),(2097,1,'2014-09-04 08:43:08','in'),(2098,1,'2014-09-04 09:23:44','in'),(2099,1,'2014-09-05 09:11:41','in'),(2100,1,'2014-09-05 11:59:28','in'),(2101,1,'2014-09-08 09:18:47','in'),(2102,1,'2014-09-08 10:03:32','out'),(2103,1,'2014-09-08 10:03:40','in'),(2104,1,'2014-09-08 10:03:45','out'),(2105,1,'2014-09-08 10:03:54','in'),(2106,1,'2014-09-08 10:04:38','out'),(2107,1,'2014-09-08 10:04:45','in'),(2108,1,'2014-09-08 10:05:29','out'),(2109,1,'2014-09-08 10:05:36','in'),(2110,1,'2014-09-09 09:24:55','in'),(2111,1,'2014-09-09 11:16:13','in'),(2112,1,'2014-09-10 09:00:05','in'),(2113,1,'2014-09-11 08:55:14','in'),(2114,1,'2014-09-11 11:28:39','out'),(2115,1,'2014-09-11 11:28:47','in'),(2116,1,'2014-09-11 11:29:10','out'),(2117,1,'2014-09-11 11:30:49','in'),(2118,1,'2014-09-11 11:31:34','in'),(2119,1,'2014-09-11 11:32:16','out'),(2120,1,'2014-09-11 11:32:23','in'),(2121,1,'2014-09-12 09:04:36','in'),(2122,1,'2014-09-12 15:12:56','in'),(2123,1,'2014-09-15 09:07:20','in'),(2124,1,'2014-09-16 08:44:44','in'),(2125,1,'2014-09-17 09:08:33','in'),(2126,1,'2014-09-18 08:53:23','in'),(2127,1,'2014-09-19 08:48:00','in'),(2128,1,'2014-09-25 08:42:11','in'),(2129,1,'2014-09-26 10:40:50','in'),(2130,1,'2014-09-29 08:45:01','in'),(2131,1,'2014-09-30 08:52:57','in'),(2132,1,'2014-10-01 09:01:21','in'),(2133,1,'2014-10-02 09:15:42','in'),(2134,1,'2014-10-03 09:01:56','in'),(2135,1,'2014-10-06 09:01:04','in'),(2136,1,'2014-10-07 08:42:57','in'),(2137,1,'2014-10-08 08:27:33','in'),(2138,1,'2014-10-08 10:36:14','in'),(2139,1,'2014-10-08 11:39:04','out'),(2140,10,'2014-10-08 11:39:14','in'),(2141,10,'2014-10-08 11:39:38','out'),(2142,1,'2014-10-08 11:39:45','in'),(2143,1,'2014-10-08 14:03:27','out'),(2144,10,'2014-10-08 14:03:38','in'),(2145,10,'2014-10-08 14:23:54','out'),(2146,1,'2014-10-08 14:24:00','in'),(2147,1,'2014-10-09 08:35:40','in'),(2148,1,'2014-10-10 08:14:05','in'),(2149,1,'2014-10-10 15:50:34','out'),(2150,10,'2014-10-10 15:50:49','in'),(2151,10,'2014-10-10 15:51:43','out'),(2152,1,'2014-10-10 15:51:50','in'),(2153,1,'2014-10-10 16:06:01','out'),(2154,10,'2014-10-10 16:06:17','in'),(2155,10,'2014-10-10 16:06:47','out'),(2156,1,'2014-10-10 16:06:54','in'),(2157,1,'2014-10-10 16:26:11','in'),(2158,1,'2014-10-13 08:56:12','in'),(2159,1,'2014-10-13 13:32:45','in'),(2160,1,'2014-10-14 08:23:02','in'),(2161,34,'2014-10-14 10:50:13','out'),(2162,1,'2014-10-14 10:50:26','in'),(2163,1,'2014-10-15 09:30:24','in'),(2164,1,'2014-10-17 10:56:23','in'),(2165,1,'2014-10-17 13:38:24','in'),(2166,1,'2014-10-20 08:29:55','in'),(2167,1,'2014-10-20 08:41:02','in'),(2168,1,'2014-10-20 14:22:14','in'),(2169,1,'2014-10-20 16:46:22','in'),(2170,1,'2014-10-21 08:34:12','in'),(2171,1,'2014-10-22 08:55:03','in'),(2172,1,'2014-10-23 09:07:17','in'),(2173,1,'2014-10-23 11:55:01','in'),(2174,1,'2014-10-23 13:14:49','in'),(2175,1,'2014-10-24 08:55:41','in'),(2176,1,'2014-10-24 13:37:50','out'),(2177,10,'2014-10-24 13:38:08','in'),(2178,10,'2014-10-24 13:39:33','out'),(2179,1,'2014-10-24 13:39:41','in'),(2180,1,'2014-10-24 13:40:33','out'),(2181,1,'2014-10-24 13:40:41','in'),(2182,1,'2014-10-24 13:41:59','out'),(2183,1,'2014-10-24 13:42:09','in'),(2184,1,'2014-10-24 13:43:25','out'),(2185,10,'2014-10-24 13:43:34','in'),(2186,10,'2014-10-24 13:44:08','out'),(2187,1,'2014-10-24 13:44:16','in'),(2188,1,'2014-10-27 08:34:56','in'),(2189,1,'2014-10-28 08:34:18','in'),(2190,1,'2014-10-30 08:52:39','in'),(2191,1,'2014-10-30 12:05:33','in'),(2192,1,'2014-10-31 09:07:33','in'),(2193,1,'2014-11-18 09:21:07','in'),(2194,1,'2014-11-03 10:51:16','out'),(2195,1,'2014-11-03 10:52:43','in'),(2196,1,'2014-11-04 08:59:12','in'),(2197,1,'2014-11-10 08:48:01','in'),(2198,1,'2014-11-11 09:26:15','in'),(2199,1,'2014-11-11 15:56:35','in'),(2200,1,'2014-11-11 16:30:53','in'),(2201,1,'2014-11-12 09:09:21','in'),(2202,1,'2014-11-12 09:18:47','in'),(2203,1,'2014-11-12 11:17:19','out'),(2204,1,'2014-11-12 11:17:28','in'),(2205,1,'2014-11-12 13:12:43','out'),(2206,1,'2014-11-12 13:13:01','in'),(2207,1,'2014-11-13 08:42:10','in'),(2208,1,'2014-11-14 09:04:57','in'),(2209,1,'2014-11-14 09:49:47','out'),(2210,1,'2014-11-14 09:49:58','in'),(2211,1,'2014-11-14 10:41:24','out'),(2212,1,'2014-11-14 10:41:31','in'),(2213,1,'2014-11-18 08:49:53','in'),(2214,1,'2014-11-18 10:43:39','in'),(2215,1,'2014-11-18 11:00:29','in'),(2216,1,'2014-11-19 08:49:02','in'),(2217,1,'2014-11-20 08:55:55','in'),(2218,1,'2014-11-24 13:54:38','in'),(2219,1,'2014-11-24 14:02:00','out'),(2220,1,'2014-11-28 08:51:37','in'),(2221,1,'2014-11-30 01:28:32','in'),(2222,1,'2014-12-03 22:34:55','out'),(2223,1,'2014-12-03 22:35:07','in'),(2224,1,'2015-01-14 17:35:05','in');

/*Table structure for table `cs_users` */

DROP TABLE IF EXISTS `cs_users`;

CREATE TABLE `cs_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `user_name` varchar(128) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` tinyint(1) DEFAULT '0' COMMENT '0: transfer; 1:admin',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `cs_users` */

insert  into `cs_users`(`id`,`first_name`,`last_name`,`user_name`,`password`,`user_type`,`active`) values (1,'សុវណ្ណ','តុង','sovann','5f4dcc3b5aa765d61d8327deb882cf99',1,1),(9,'សៀក​លៀង','ប៊ុន','seakleang','5f4dcc3b5aa765d61d8327deb882cf99',3,1),(10,'sopheak','hem','sopheak','5f4dcc3b5aa765d61d8327deb882cf99',4,1),(18,'សាមឌី','ឡុញ','samdy','5f4dcc3b5aa765d61d8327deb882cf99',2,1),(21,'Monorom','Shop','monorom','e10adc3949ba59abbe56e057f20f883e',1,1),(22,'ចន្ឋូ','ឈួ','chanto','ba5d7a324172ff72dbcba5567453559c',1,1),(23,'ធាងស៊ិន','​ស៊ុយ','theangsen','3fb3b463c0833e7c96c8195f69941b9d',1,1),(24,'smey','rak','raksmey','52c69e3a57331081823331c4e69d3f2e',1,1),(25,'CHHENGHORN',' ','horn','7194f1a59fbb1c6e8f34cdf251dafa32',1,1),(26,'CHOM',' ','chom','b9e4d740a9a99e7203503a716b18c3ee',1,1),(27,'DARA',' ','dara','e10adc3949ba59abbe56e057f20f883e',3,1),(28,'mouytheang',' ','theang','9fe192aa1c016073174528cd7a2bdb18',4,1),(29,'មួយឡេង','​','leng','e10adc3949ba59abbe56e057f20f883e',1,1),(30,'GM','User','gm','e10adc3949ba59abbe56e057f20f883e',6,1);

/*Table structure for table `cs_withdraw` */

DROP TABLE IF EXISTS `cs_withdraw`;

CREATE TABLE `cs_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) DEFAULT NULL,
  `invoice` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `money_type` tinyint(4) DEFAULT NULL,
  `wd_amountdollar` float(10,2) DEFAULT NULL COMMENT 'withdraw in dollar',
  `wd_amountbath` float(10,2) DEFAULT NULL COMMENT 'withdraw in bath',
  `wd_amountriel` float(10,2) DEFAULT NULL COMMENT 'withdraw in riel',
  `dollar_before` float(10,2) DEFAULT NULL COMMENT 'amount_before draw',
  `bath_before` float(10,2) DEFAULT NULL,
  `riel_before` float(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cs_withdraw` */

insert  into `cs_withdraw`(`id`,`sender_id`,`invoice`,`create_date`,`money_type`,`wd_amountdollar`,`wd_amountbath`,`wd_amountriel`,`dollar_before`,`bath_before`,`riel_before`,`user_id`) values (1,94,'WD-2393CB','2014-09-25',NULL,100.00,0.00,0.00,100.00,0.00,0.00,1),(2,95,'WD-542396','2014-09-25',NULL,100.00,0.00,0.00,200.00,0.00,0.00,1),(3,95,'WD-2396EF','2014-09-25',NULL,100.00,0.00,0.00,100.00,0.00,0.00,1);

/*Table structure for table `rsv_acl_acl` */

DROP TABLE IF EXISTS `rsv_acl_acl`;

CREATE TABLE `rsv_acl_acl` (
  `acl_id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL,
  `controller` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1: display in menu; 0: disable from menu',
  `rank` int(11) DEFAULT NULL COMMENT 'rank to show in submenu',
  PRIMARY KEY (`acl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

/*Data for the table `rsv_acl_acl` */

insert  into `rsv_acl_acl`(`acl_id`,`module`,`controller`,`action`,`status`,`rank`) values (1,'rsvAcl','acl','add-acl',1,1),(2,'rsvAcl','acl','edit-acl',1,2),(3,'rsvAcl','acl','index',1,3),(4,'rsvAcl','user-access','index',1,4),(5,'rsvAcl','user-access','view-user-access',1,5),(6,'rsvAcl','user-access','update-status',1,6),(7,'rsvAcl','user-type','index',1,7),(8,'rsvAcl','user-type','add-user-type',1,8),(9,'rsvAcl','user-type','edit-user-type',1,9),(10,'subagent','index','index',1,10),(11,'subagent','index','add',1,11),(12,'subagent','index','edited',1,12),(13,'agent','index','index',1,13),(14,'agent','index','add',1,14),(15,'agent','index','edited',1,15),(16,'user','index','index',1,16),(17,'user','index','add',1,17),(18,'user','index','edited',1,18),(19,'transfer','index','index',1,19),(20,'transfer','index','add',1,20),(21,'transfer','index','edited',1,21),(22,'reports','index','index',1,22),(23,'reports','index','rpttotal',1,23),(24,'reports','index','rptautoprint',1,24),(25,'exchange','index','index',1,25),(26,'exchange','index','add',1,26),(27,'exchange','index','edited',1,27),(28,'exchange','index','rate',1,NULL),(29,'exchange','index','balance',1,NULL),(30,'reports','index','rptbalance',1,NULL),(31,'reports','index','rptincome',1,NULL),(32,'reports','index','rptsummary-exchange',1,NULL),(33,'reports','index','rptsummary-transfer',1,NULL),(34,'reports','index','rptsummary-transfer-alluser',1,NULL),(35,'payment','index','index',1,NULL),(36,'kbank','index','index',1,NULL),(37,'kbank','index','add',1,NULL),(38,'kbank','index','edited',1,NULL),(39,'kbank','index','extend-date',1,NULL),(40,'kbank','withdraw','index',1,NULL),(41,'kbank','withdraw','add',1,NULL),(42,'kbank','withdraw','edited',1,NULL),(43,'loan','index','index',1,NULL),(44,'capital','index','index',1,NULL),(45,'backup','index','index',1,NULL);

/*Table structure for table `rsv_acl_user` */

DROP TABLE IF EXISTS `rsv_acl_user`;

CREATE TABLE `rsv_acl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_type_id` (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `rsv_acl_user` */

/*Table structure for table `rsv_acl_user_access` */

DROP TABLE IF EXISTS `rsv_acl_user_access`;

CREATE TABLE `rsv_acl_user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acl_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_type_id` (`user_type_id`),
  KEY `acl_id` (`acl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

/*Data for the table `rsv_acl_user_access` */

insert  into `rsv_acl_user_access`(`id`,`acl_id`,`user_type_id`,`status`) values (1,1,1,1),(4,2,1,1),(5,3,1,1),(6,4,1,1),(7,5,1,1),(8,6,1,1),(9,7,1,1),(10,8,1,1),(11,9,1,1),(12,10,1,1),(13,11,1,1),(14,12,1,1),(15,13,1,1),(16,14,1,1),(17,15,1,1),(18,16,1,1),(19,17,1,1),(20,18,1,1),(21,19,1,1),(22,20,1,1),(23,21,1,1),(24,22,1,1),(25,23,1,1),(26,24,1,1),(27,10,2,1),(28,11,2,1),(29,12,2,1),(30,13,2,1),(31,14,2,1),(32,15,2,1),(33,19,2,1),(34,20,2,1),(35,21,2,1),(36,22,2,1),(37,23,2,1),(38,24,2,1),(39,19,3,1),(40,20,3,1),(41,21,3,1),(42,25,1,1),(43,26,1,1),(44,27,1,1),(45,28,1,1),(46,29,1,1),(47,25,2,1),(48,26,2,1),(49,27,2,1),(50,28,2,1),(51,29,2,1),(52,25,4,1),(53,26,4,1),(54,27,4,1),(55,28,5,1),(56,25,5,1),(57,29,4,1),(58,30,1,1),(59,31,1,1),(60,32,1,1),(61,33,1,1),(62,33,2,1),(63,32,2,1),(64,31,2,1),(65,30,2,1),(66,22,3,1),(67,23,3,1),(68,31,3,1),(69,24,3,1),(70,33,3,1),(71,32,4,1),(72,30,4,1),(73,34,1,1),(74,35,1,1),(75,36,1,1),(76,37,1,1),(77,38,1,1),(78,39,1,1),(79,41,1,1),(80,42,1,1),(81,40,1,1),(82,43,1,1),(83,44,1,1),(84,45,1,1),(85,25,6,1),(86,25,6,1),(87,25,6,1),(88,25,6,1),(89,26,6,1),(90,27,6,1),(91,28,6,1),(92,29,6,1),(93,36,6,1),(94,37,6,1),(95,38,6,1),(96,39,6,1),(97,40,6,1),(98,41,6,1),(99,42,6,1);

/*Table structure for table `rsv_acl_user_type` */

DROP TABLE IF EXISTS `rsv_acl_user_type`;

CREATE TABLE `rsv_acl_user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(50) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_type_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `rsv_acl_user_type` */

insert  into `rsv_acl_user_type`(`user_type_id`,`user_type`,`parent_id`,`status`) values (1,'Admin',0,1),(2,'អ្នក​គ្រប់គ្រង',1,1),(3,'អ្នក​វេ​ប្រាក់',2,1),(4,'អ្នក​ប្តូរ​ប្រាក់',2,1),(5,'អ្នក​កំណត់អត្រាការប្រាក់',2,1),(6,'GM',1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
