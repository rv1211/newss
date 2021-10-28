-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2021 at 05:25 PM
-- Server version: 5.7.33
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paras_pack`
--

-- --------------------------------------------------------

--
-- Table structure for table `forward_order_master`
--

CREATE TABLE `forward_order_master` (
  `id` bigint(50) NOT NULL,
  `sender_id` bigint(30) NOT NULL,
  `pickup_address_id` bigint(30) NOT NULL,
  `order_product_detail_id` bigint(50) NOT NULL,
  `logistic_id` int(10) NOT NULL,
  `deliver_address_id` bigint(50) NOT NULL COMMENT 'receiver address id\r\n',
  `order_no` varchar(25) NOT NULL,
  `customer_order_no` varchar(50) DEFAULT NULL,
  `order_type` enum('0','1') DEFAULT NULL COMMENT '0-prepaid, 1-cod',
  `sgst_amount` decimal(10,2) DEFAULT NULL,
  `cgst_amount` decimal(10,2) DEFAULT NULL,
  `igst_amount` decimal(10,2) DEFAULT NULL,
  `total_shipping_amount` decimal(10,2) NOT NULL,
  `awb_number` varchar(25) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `remain_amount` decimal(10,2) DEFAULT NULL,
  `is_seller_info` enum('0','1') DEFAULT NULL COMMENT '0-no, 1-yes',
  `packing_slip_warehouse_name` varchar(25) DEFAULT NULL,
  `is_return_address_same_as_pickup` enum('0','1') DEFAULT NULL COMMENT '0-no, 1-yes',
  `return_address_id` bigint(50) DEFAULT NULL,
  `is_reverse` enum('0','1') DEFAULT '0' COMMENT '0-no, 1-yes',
  `is_cancelled` enum('0','1','2') DEFAULT '0' COMMENT '0-no, 1-yes, 2-cancelled but remain in api',
  `is_pre_awb` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-simple order, 1-pre awb order ',
  `is_delete` enum('0','1') NOT NULL COMMENT '0-not_delete,1-delete',
  `tracking_id` varchar(35) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forward_order_master`
--

INSERT INTO `forward_order_master` (`id`, `sender_id`, `pickup_address_id`, `order_product_detail_id`, `logistic_id`, `deliver_address_id`, `order_no`, `customer_order_no`, `order_type`, `sgst_amount`, `cgst_amount`, `igst_amount`, `total_shipping_amount`, `awb_number`, `paid_amount`, `remain_amount`, `is_seller_info`, `packing_slip_warehouse_name`, `is_return_address_same_as_pickup`, `return_address_id`, `is_reverse`, `is_cancelled`, `is_pre_awb`, `is_delete`, `tracking_id`, `created_date`, `created_by`, `updated_date`, `updated_by`) VALUES
(1, 10, 8, 3, 5, 19, '010401', '010401', '1', 0.00, 0.00, 0.00, 125.00, '14309320099683', 125.00, 0.00, NULL, NULL, '1', NULL, '0', '0', '0', '0', NULL, '2021-04-01 11:45:15', 10, '2021-04-01 11:45:15', NULL),
(2, 10, 8, 5, 5, 21, '020401', '020401', '1', 0.00, 0.00, 0.00, 150.00, '14309320099779', 150.00, 0.00, NULL, NULL, '1', NULL, '0', '0', '0', '0', NULL, '2021-04-02 11:48:02', 10, '2021-04-02 11:48:02', NULL),
(3, 4, 2, 6, 2, 22, '12778522d', '12778522d', '1', 0.00, 0.00, 0.00, 135.00, '6221711323862', 135.00, 0.00, '1', 'PARAS', '1', NULL, '0', '0', '0', '0', NULL, '2021-04-02 13:43:02', 4, '2021-04-02 13:43:02', NULL),
(5, 10, 8, 8, 5, 24, '030401', '030401', '1', 0.00, 0.00, 0.00, 125.00, '14309320099862', 125.00, 0.00, NULL, NULL, '1', NULL, '0', '0', '0', '1', NULL, '2021-04-03 12:29:58', 10, '2021-04-09 11:11:07', NULL),
(6, 3, 6, 9, 2, 25, 'RV1213', 'RV1213', '1', 0.00, 0.00, 0.00, 85.00, '6221711372431', 85.00, 0.00, NULL, NULL, '1', NULL, '0', '0', '0', '0', NULL, '2021-04-05 06:50:46', 3, '2021-04-05 06:50:46', NULL),
(7, 3, 5, 14, 10, 30, 'TH1211', 'TH1211', '1', 0.00, 0.00, 0.00, 100.00, 'BIZC2100010609', 100.00, 0.00, NULL, NULL, NULL, NULL, '0', '0', '0', '0', NULL, '2021-04-06 09:14:40', 3, '2021-04-06 09:14:40', NULL),
(8, 3, 5, 15, 10, 31, '123', '123', '1', 0.00, 0.00, 0.00, 100.00, 'BIZC2100010611', 100.00, 0.00, NULL, NULL, NULL, NULL, '0', '0', '0', '0', NULL, '2021-04-06 09:33:10', 3, '2021-04-06 09:33:10', NULL),
(9, 4, 2, 17, 5, 33, '12', '12', '0', 0.00, 0.00, 0.00, 75.00, '14309320123005', 75.00, 0.00, '1', 'pooja', NULL, NULL, '0', '0', '0', '0', NULL, '2021-04-06 18:15:49', 4, '2021-04-06 18:15:49', NULL),
(10, 11, 9, 33, 12, 49, '#1569', '#1569', '1', 0.00, 0.00, 0.00, 110.00, '', 110.00, 0.00, NULL, NULL, NULL, NULL, '0', '0', '0', '0', NULL, '2021-04-07 06:48:23', 11, '2021-04-07 06:48:23', NULL),
(11, 15, 14, 44, 5, 60, '956423', '956423', '1', 0.00, 0.00, 0.00, 72.00, '14309320067957', 72.00, 0.00, '1', 'kirtika patel', NULL, NULL, '0', '0', '0', '0', NULL, '2021-04-08 07:12:47', 15, '2021-04-08 07:12:47', NULL),
(12, 3, 5, 47, 10, 63, 'RRVV-1122', 'RRVV-1122', '1', 0.00, 0.00, 0.00, 100.00, 'BIZC2100010649', 100.00, 0.00, NULL, NULL, NULL, NULL, '0', '0', '0', '0', NULL, '2021-04-08 09:26:22', 3, '2021-04-08 09:26:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forward_order_master`
--
ALTER TABLE `forward_order_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forward_order_master`
--
ALTER TABLE `forward_order_master`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
