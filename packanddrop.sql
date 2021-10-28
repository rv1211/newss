-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 10, 2021 at 08:47 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `packanddrop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

DROP TABLE IF EXISTS `customer_master`;
CREATE TABLE IF NOT EXISTS `customer_master` (
  `customer_id` bigint(30) NOT NULL AUTO_INCREMENT,
  `customer_email` varchar(35) DEFAULT NULL,
  `customer_password` varchar(50) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_mobile_no` varchar(15) DEFAULT NULL,
  `customer_website` varchar(35) DEFAULT NULL,
  `customer_wallet_balance` decimal(10,2) DEFAULT NULL,
  `customer_status` tinyint(1) DEFAULT NULL COMMENT '0-pending, 1-approve',
  `customer_rejection_reason` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL COMMENT '0-inactive, 1-active',
  `api_is_web_access` tinyint(1) DEFAULT NULL COMMENT '0-no, 1-yes',
  `api_pickup_address_id` int(10) DEFAULT NULL,
  `api_key` varchar(100) DEFAULT NULL,
  `api_user_id` varchar(100) DEFAULT NULL,
  `allow_credit` tinyint(1) DEFAULT NULL COMMENT '0-no, 1-yes',
  `allow_credit_limit` decimal(10,2) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`customer_id`, `customer_email`, `customer_password`, `customer_name`, `customer_mobile_no`, `customer_website`, `customer_wallet_balance`, `customer_status`, `customer_rejection_reason`, `is_active`, `api_is_web_access`, `api_pickup_address_id`, `api_key`, `api_user_id`, `allow_credit`, `allow_credit_limit`, `created_date`, `created_by`, `updated_date`, `updated_by`) VALUES
(1, 'testoffice9@gmail.com', '123456', 'Abc makwana', '852369888888', 'asdsad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-10 00:15:12', NULL, '2021-02-10 00:15:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logistic_master`
--

DROP TABLE IF EXISTS `logistic_master`;
CREATE TABLE IF NOT EXISTS `logistic_master` (
  `logistic_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `logistic_name` varchar(20) DEFAULT NULL,
  `cod_price` decimal(10,2) DEFAULT NULL,
  `cod_percentage` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0-inactive,1-active',
  PRIMARY KEY (`logistic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logistic_master`
--

INSERT INTO `logistic_master` (`logistic_id`, `logistic_name`, `cod_price`, `cod_percentage`, `is_active`) VALUES
(1, 'Shadowfax', '25.00', '1.50', 1),
(2, 'Xpressbees Lite', '25.00', '5.00', 1),
(3, 'Xpressbees Express', '40.00', '2.00', 1),
(4, 'Delhivery', '40.00', '1.50', 1),
(5, 'DTDC', NULL, NULL, 1),
(6, 'Delhivery Express', '50.00', '2.10', 1),
(7, 'test', '10.00', '5.00', 1),
(8, 'test1', '14.00', '5.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manage_price`
--

DROP TABLE IF EXISTS `manage_price`;
CREATE TABLE IF NOT EXISTS `manage_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_for` varchar(50) DEFAULT NULL,
  `shipment_type` varchar(20) DEFAULT NULL,
  `rule` varchar(50) DEFAULT NULL,
  `within_city` float DEFAULT NULL,
  `within_state` float DEFAULT NULL,
  `within_zone` float DEFAULT NULL,
  `metro` float DEFAULT NULL,
  `metro_2` float DEFAULT NULL,
  `rest_of_india` float DEFAULT NULL,
  `rest_of_india_2` float DEFAULT NULL,
  `special_zone` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_price`
--

INSERT INTO `manage_price` (`id`, `price_for`, `shipment_type`, `rule`, `within_city`, `within_state`, `within_zone`, `metro`, `metro_2`, `rest_of_india`, `rest_of_india_2`, `special_zone`) VALUES
(1, '1', 'Forward', 'First 500 grams', 31, NULL, 35, 47, 47, 51, 51, 64),
(2, '1', 'Forward', 'Additional 500 grams', 24, NULL, 30, 35, NULL, 39, NULL, 53),
(3, '1', 'Reverse', 'First 500 grams', 34, NULL, 40, 53, NULL, 61, NULL, 69),
(4, '1', 'Reverse', 'Additional 500 grams', 29, NULL, 39, 46, NULL, 51, NULL, 61),
(5, '2', 'Forward', 'First 500 grams', 37, NULL, 41, 46, 46, 52, 52, 57),
(6, '2', 'Forward', 'Additional 500 grams', 35, NULL, 37, 42, NULL, 46, NULL, 52),
(7, '2', 'Forward', 'First 1 kg', 73, NULL, 78, 88, NULL, 98, NULL, 109),
(8, '2', 'Forward', 'First 1.5 kg', 110, NULL, 119, 134, NULL, 150, NULL, 166),
(9, '3', 'Forward', 'First 1 kg', 47, NULL, 51, 53, NULL, 57, NULL, 76),
(10, '3', 'Forward', 'Additional 1 kg', 39, NULL, 39, 47, NULL, 50, NULL, 57),
(11, '3', 'Forward', 'First 1.5 kg', 82, NULL, 89, 98, NULL, 108, NULL, 134),
(12, '3', 'Forward', 'First 2 kg', 86, NULL, 89, 100, NULL, 107, NULL, 133),
(13, '5', 'Forward', 'First 500 grams', 27, 27, 34, 45, NULL, 45, NULL, 66),
(14, '5', 'Forward', 'Additional 500 grams', 19, 19, 26, 39, NULL, 37, NULL, 62),
(17, '5', 'Forward', 'Per 1Kg > 5Kgs', 28, 28, 46, 73, NULL, 73, NULL, 129),
(19, '5', 'Reverse', 'Reverse Fix Price', 85, 85, 85, 85, NULL, 85, NULL, 85),
(21, '6', 'Forward', 'First 5 kg', 110, NULL, 145, 160, 185, 200, 210, 225),
(22, '6', 'Forward', 'Every additional 5 kg Upto 10kg', 25, NULL, 32, 37, 41, 44, 50, 60),
(23, '6', 'Forward', 'Every additional 1 kg above 10kg', 16, NULL, 21, 24, 27, 29, 33, 40),
(24, '6', 'Reverse', 'Every 1 kg', 23, NULL, 30, 35, 39, 42, 48, 58),
(25, '4', 'Forward', 'First 500 grams', 38, NULL, 43, 46, 48, 49, 51, 55),
(26, '4', 'Forward', 'Every additional 500 gms Upto 3kg', 26, NULL, 31, 35, 37, 38, 40, 44),
(27, '4', 'Forward', 'Every additional 1 kg above 3kg', 26, NULL, 31, 35, 37, 38, 40, 44),
(28, '4', 'Reverse', 'Every 1 kg', 26, NULL, 31, 35, 37, 38, 40, 44),
(29, '2', 'Forward', 'First 2 kg', 145, NULL, 156, 176, NULL, 196, NULL, 218),
(30, '2', 'Forward', 'First 2.5 kg', 180, NULL, 194, 218, NULL, 242, NULL, 270),
(31, '2', 'Forward', 'First 3 kg', 216, NULL, 231, 260, NULL, 288, NULL, 321),
(32, '2', 'Forward', 'First 3.5 kg', 251, NULL, 268, 301, NULL, 334, NULL, 373),
(33, '2', 'Forward', 'First 4 kg', 286, NULL, 306, 343, NULL, 381, NULL, 425),
(34, '2', 'Forward', 'First 4.5 kg', 321, NULL, 343, 385, NULL, 427, NULL, 476),
(35, '2', 'Forward', 'First 5 kg', 356, NULL, 381, 427, NULL, 473, NULL, 528),
(36, '3', 'Forward', 'First 2.5 kg', 120, NULL, 128, 145, NULL, 158, NULL, 191),
(37, '3', 'Forward', 'First 3 kg', 133, NULL, 140, 153, NULL, 164, NULL, 209),
(38, '3', 'Forward', 'First 3.5 kg', 168, NULL, 178, 198, NULL, 215, NULL, 267),
(39, '3', 'Forward', 'First 4 kg', 172, NULL, 178, 200, NULL, 213, NULL, 266),
(40, '3', 'Forward', 'First 4.5 kg', 206, NULL, 217, 245, NULL, 265, NULL, 324),
(41, '3', 'Forward', 'First 5 kg', 219, NULL, 229, 253, NULL, 271, NULL, 342),
(42, '3', 'Forward', 'First 5.5 kg', 253, NULL, 267, 298, NULL, 322, NULL, 400),
(43, '3', 'Forward', 'First 6 kg', 257, NULL, 267, 300, NULL, 320, NULL, 399),
(44, '3', 'Forward', 'First 6.5 kg', 292, NULL, 306, 345, NULL, 371, NULL, 457),
(45, '3', 'Forward', 'First 7 kg', 296, NULL, 306, 348, NULL, 370, NULL, 457),
(46, '3', 'Forward', 'First 7.5 kg', 330, NULL, 344, 392, NULL, 421, NULL, 514),
(47, '3', 'Forward', 'First 8 kg', 343, NULL, 356, 400, NULL, 427, NULL, 532),
(48, '3', 'Forward', 'First 8.5 kg', 378, NULL, 395, 445, NULL, 478, NULL, 590),
(49, '3', 'Forward', 'First 9 kg', 382, NULL, 395, 448, NULL, 476, NULL, 590),
(50, '3', 'Forward', 'First 9.5 kg', 416, NULL, 433, 493, NULL, 528, NULL, 647),
(51, '3', 'Forward', 'First 10 kg', 420, NULL, 433, 495, NULL, 526, NULL, 647),
(52, '3', 'Forward', 'First 10.5 kg', 455, NULL, 472, 540, NULL, 577, NULL, 704),
(53, '3', 'Forward', 'First 11 kg', 459, NULL, 472, 542, NULL, 575, NULL, 704),
(54, '3', 'Forward', 'First 12 kg', 497, NULL, 510, 590, NULL, 625, NULL, 761);

-- --------------------------------------------------------

--
-- Table structure for table `rule_master`
--

DROP TABLE IF EXISTS `rule_master`;
CREATE TABLE IF NOT EXISTS `rule_master` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

DROP TABLE IF EXISTS `user_master`;
CREATE TABLE IF NOT EXISTS `user_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(35) NOT NULL,
  `user_password` int(50) NOT NULL,
  `user_type` tinyint(2) NOT NULL COMMENT '1-admin,2-member,3-accountant',
  `name` varchar(50) NOT NULL,
  `user_mobile_no` varchar(15) NOT NULL,
  `is_active` tinyint(1) NOT NULL COMMENT '0-inactive,1-active',
  `created_date` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `update_date` datetime NOT NULL,
  `updated_by` int(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
