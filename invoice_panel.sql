-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(25) NOT NULL DEFAULT 'Unpaid',
  `datepaid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `invoices` (`id`, `status`, `datepaid`) VALUES
(1,	'Paid',	'2017-12-14 16:31:03'),
(2,	'Paid',	'2017-12-14 16:31:33'),
(3,	'Paid',	'2017-12-14 16:31:42'),
(4,	'Paid',	'2017-12-14 16:31:48'),
(5,	'Cancelled',	'2017-12-14 16:31:55'),
(6,	'Paid',	'2017-12-14 16:32:01'),
(7,	'Paid',	'2017-12-14 16:32:06'),
(8,	'Paid',	'2017-12-14 16:32:12'),
(9,	'Paid',	'2017-12-14 16:32:18'),
(10,	'Unpaid',	'2017-12-15 16:45:40');

DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) unsigned NOT NULL COMMENT 'id=>invoices',
  `type` varchar(250) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `invoice_items` (`id`, `invoice_id`, `type`, `amount`) VALUES
(1,	1,	'Domain Register',	27.99),
(2,	1,	'Hosting',	60.00),
(3,	1,	'Other',	7.00),
(4,	2,	'Domain Register',	27.99),
(5,	2,	'Hosting',	60.00),
(6,	2,	'Other',	7.00),
(7,	3,	'Domain Register',	159.20),
(8,	3,	'Hosting',	374.40),
(9,	3,	'Other',	50.00),
(10,	4,	'Domain Register',	36.00);

-- 2017-12-14 19:22:48
