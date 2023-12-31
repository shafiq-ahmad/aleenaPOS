-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2019 at 11:29 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webapplics_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_code` varchar(20) NOT NULL,
  `ref_code` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT '',
  `title_urdu` varchar(100) DEFAULT '',
  `tags` text,
  `published` int(1) NOT NULL DEFAULT '1',
  `comments` varchar(100) DEFAULT '',
  `category` int(11) NOT NULL DEFAULT '0',
  `brand` int(11) DEFAULT '0',
  `art_size` double DEFAULT NULL,
  `unit` varchar(4) NOT NULL DEFAULT '',
  `packing` int(11) NOT NULL DEFAULT '1',
  `months` varchar(100) NOT NULL DEFAULT '["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]',
  `seasons` varchar(150) NOT NULL DEFAULT '["spring","winter","summer","autumn","monsoon"]',
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `article_brand_cats`
--

CREATE TABLE `article_brand_cats` (
  `brand_id` int(11) NOT NULL,
  `article_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_cats`
--

CREATE TABLE `article_cats` (
  `id` int(11) NOT NULL,
  `cat_code` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `title_urdu` varchar(50) DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `discount_per` varchar(50) DEFAULT '0',
  `gst_per` varchar(50) DEFAULT '0',
  `visibility` int(11) NOT NULL DEFAULT '2' COMMENT '0=hidden, 1=global,2=company',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `parent_cat` int(11) DEFAULT NULL,
  `business_type` int(11) NOT NULL DEFAULT '0' COMMENT 'Business or company type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article_cats`
--

INSERT INTO `article_cats` (`id`, `cat_code`, `title`, `title_urdu`, `published`, `discount_per`, `gst_per`, `visibility`, `branch_id`, `parent_cat`, `business_type`) VALUES
(1, NULL, NULL, NULL, 1, '0', '0', 2, 101, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `branch_accounts`
--

CREATE TABLE `branch_accounts` (
  `branch_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_value` double NOT NULL DEFAULT '0',
  `min_value` double NOT NULL DEFAULT '0',
  `max_value` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `branch_articles`
--

CREATE TABLE `branch_articles` (
  `branch_id` int(11) NOT NULL,
  `article_code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `cost_price` double NOT NULL DEFAULT '0',
  `sale_price` double NOT NULL DEFAULT '0',
  `sale_price_terms` text COLLATE utf8_bin,
  `qty` double NOT NULL DEFAULT '0',
  `scheme` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `discount_terms` text COLLATE utf8_bin,
  `seasonal` int(1) NOT NULL DEFAULT '0',
  `seasons` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `min_stock` double NOT NULL DEFAULT '0',
  `max_stock` double NOT NULL DEFAULT '0',
  `loc_store` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'main',
  `loc_section` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `loc_rack` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `loc` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `expiry_alert_days` int(11) NOT NULL DEFAULT '0',
  `stock_expiry_dates` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `branch_cash_accounts`
--

CREATE TABLE `branch_cash_accounts` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_bin NOT NULL,
  `account_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `cash` double NOT NULL DEFAULT '0',
  `current_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `branch_cash_accounts`
--

INSERT INTO `branch_cash_accounts` (`id`, `branch_id`, `title`, `account_type`, `cash`, `current_user_id`) VALUES
(1, 101, 'Owner', 'owner', -1120, 0),
(2, 101, 'Station 01', 'station', 533752.934070271, 0),
(3, 11, 'Owner', 'owner', 0, 1),
(4, 11, 'Station 01', 'station', -18090, 1),
(5, 103, 'Owner', 'owner', 0, 0),
(6, 103, 'Station 01', 'station', 0, 0),
(7, 104, 'Owner', 'owner', 0, 0),
(8, 104, 'Station 01', 'station', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `branch_customers`
--

CREATE TABLE `branch_customers` (
  `id` int(11) NOT NULL,
  `ledger_code` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `customer_type` int(11) NOT NULL DEFAULT '0',
  `contact_person` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `town_id` int(11) NOT NULL DEFAULT '0',
  `credit_value` double NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax_no` varchar(15) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `e_mail` varchar(30) NOT NULL,
  `ntn` varchar(30) NOT NULL,
  `gst_no` varchar(20) NOT NULL,
  `lng` double NOT NULL DEFAULT '0',
  `lat` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch_inventories`
--

CREATE TABLE `branch_inventories` (
  `id` int(11) NOT NULL,
  `inv_date` date NOT NULL,
  `inv_status` varchar(10) NOT NULL COMMENT 'Open, Done, Close',
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch_inventories`
--

INSERT INTO `branch_inventories` (`id`, `inv_date`, `inv_status`, `branch_id`, `user_id`, `remarks`) VALUES
(1, '2018-08-19', 'Open', 102, 10203, '');

-- --------------------------------------------------------

--
-- Table structure for table `branch_inv_articles`
--

CREATE TABLE `branch_inv_articles` (
  `id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL DEFAULT '0',
  `inv_date` date NOT NULL,
  `article_code` varchar(20) NOT NULL,
  `actual_stock` double NOT NULL,
  `inv_qty` double NOT NULL,
  `adjusted_qty` double NOT NULL DEFAULT '0',
  `closing_stock` double NOT NULL DEFAULT '0' COMMENT 'Closing stock when inv. done',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `action_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `branch_id` int(11) NOT NULL,
  `remarks` varchar(100) NOT NULL DEFAULT '',
  `inv_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `branch_purchases`
--

CREATE TABLE `branch_purchases` (
  `purchase_id` int(11) NOT NULL,
  `comments` varchar(200) NOT NULL,
  `purchase_date` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `branch_store` int(11) NOT NULL DEFAULT '0',
  `ref_inv_no` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `payment_date` date DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `cash` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `credit_terms` text CHARACTER SET utf8 COLLATE utf8_bin,
  `data_articles` text CHARACTER SET utf8 COLLATE utf8_bin,
  `data_payment` text,
  `data_supplier` text,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `branch_purchase_articles`
--

CREATE TABLE `branch_purchase_articles` (
  `purchase_id` int(11) NOT NULL,
  `article_code` varchar(20) NOT NULL,
  `qty_scheme` double NOT NULL,
  `scheme` double NOT NULL,
  `unit_price` double NOT NULL,
  `unit_net_price` double NOT NULL,
  `sale_price` double NOT NULL,
  `update_main_prices` tinyint(1) NOT NULL DEFAULT '0',
  `discount_per` float NOT NULL DEFAULT '0',
  `discount_total` float NOT NULL DEFAULT '0',
  `batch_no` varchar(10) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `old_sale_price` double NOT NULL DEFAULT '0',
  `old_unit_price` double NOT NULL DEFAULT '0',
  `packing` float NOT NULL DEFAULT '1',
  `in_hand` double NOT NULL DEFAULT '0',
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `branch_purchase_returns`
--

CREATE TABLE `branch_purchase_returns` (
  `id` int(11) NOT NULL,
  `comments` varchar(200) NOT NULL,
  `return_date` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `branch_store` int(11) NOT NULL,
  `ref_inv_no` int(11) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `cash` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `data_articles` text CHARACTER SET utf8 COLLATE utf8_bin,
  `data_supplier` text CHARACTER SET utf8 COLLATE utf8_bin,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch_purchase_return_articles`
--

CREATE TABLE `branch_purchase_return_articles` (
  `return_id` int(11) NOT NULL,
  `article_code` varchar(20) NOT NULL,
  `qty_scheme` double NOT NULL,
  `scheme` double NOT NULL,
  `unit_price` double NOT NULL,
  `unit_net_price` double NOT NULL,
  `whole_sale_price` double NOT NULL DEFAULT '0',
  `sale_price` double NOT NULL,
  `update_main_prices` tinyint(1) NOT NULL DEFAULT '0',
  `discount_per` float NOT NULL DEFAULT '0',
  `discount_total` float NOT NULL DEFAULT '0',
  `sale_tax_per` float NOT NULL DEFAULT '0',
  `sale_tax_total` float NOT NULL DEFAULT '0',
  `batch_no` varchar(10) DEFAULT NULL,
  `mfg_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `old_sale_price` double NOT NULL DEFAULT '0',
  `old_unit_price` double NOT NULL DEFAULT '0',
  `packing` float NOT NULL DEFAULT '1',
  `in_hand` double NOT NULL DEFAULT '0',
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch_sales`
--

CREATE TABLE `branch_sales` (
  `id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sale_type` varchar(15) NOT NULL DEFAULT 'Retail' COMMENT 'Distribution or Retail',
  `customer_id` int(11) DEFAULT NULL,
  `person` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `sale_status` tinyint(2) NOT NULL DEFAULT '0',
  `comments` varchar(100) DEFAULT NULL,
  `method_of_payment` tinyint(4) NOT NULL DEFAULT '0',
  `branch_store` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL,
  `sub_total` double NOT NULL DEFAULT '0',
  `cash` double NOT NULL DEFAULT '0',
  `bank_check` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `bank_card` double NOT NULL DEFAULT '0',
  `change_return` double NOT NULL DEFAULT '0',
  `discount_percent` double NOT NULL DEFAULT '0',
  `discount_amount` double NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `data_articles` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '{\\"articles\\":[]}',
  `data_customer` text CHARACTER SET utf8 COLLATE utf8_bin,
  `data_payment` text CHARACTER SET utf8 COLLATE utf8_bin,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `branch_sales_return`
--

CREATE TABLE `branch_sales_return` (
  `id` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `return_type` varchar(15) NOT NULL DEFAULT 'Rerail' COMMENT 'Distribution or Retail',
  `customer_id` int(11) DEFAULT NULL,
  `person` varchar(20) NOT NULL,
  `return_status` tinyint(2) NOT NULL DEFAULT '1',
  `comments` varchar(100) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `sub_total` double NOT NULL,
  `cash` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `change_return` double NOT NULL DEFAULT '0',
  `discount_amount` double NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `data_articles` text,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch_sale_articles`
--

CREATE TABLE `branch_sale_articles` (
  `sale_id` int(11) NOT NULL,
  `article_code` varchar(20) NOT NULL,
  `qty` double NOT NULL,
  `scheme` double NOT NULL DEFAULT '0',
  `in_hand` double NOT NULL DEFAULT '0',
  `cost_price` double NOT NULL DEFAULT '0',
  `price` double NOT NULL,
  `tp_price` double NOT NULL DEFAULT '0',
  `price_terms` text,
  `discount` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `station_id` int(11) NOT NULL DEFAULT '0',
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `branch_sale_return_articles`
--

CREATE TABLE `branch_sale_return_articles` (
  `return_id` int(11) NOT NULL,
  `article_code` varchar(20) NOT NULL,
  `qty` double NOT NULL,
  `scheme` double NOT NULL DEFAULT '0',
  `in_hand` double NOT NULL DEFAULT '0',
  `price` double NOT NULL,
  `discount` double NOT NULL,
  `status` tinyint(4) NOT NULL,
  `station_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch_stores`
--

CREATE TABLE `branch_stores` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `title` varchar(10) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `is_primary_store` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch_stores`
--

INSERT INTO `branch_stores` (`id`, `branch_id`, `title`, `published`, `is_primary_store`, `address`, `description`) VALUES
(1, 101, 'Main', 1, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cash_payment_logs`
--

CREATE TABLE `cash_payment_logs` (
  `file_name` varchar(30) COLLATE utf8_bin NOT NULL COMMENT 'table name (e.g. supplier or customer)',
  `file_id` int(11) NOT NULL DEFAULT '0',
  `ref_no` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `cash` double NOT NULL,
  `cash_source` int(11) NOT NULL COMMENT 'source account',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `old_account_value` double NOT NULL DEFAULT '0',
  `old_cash_value` double NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL,
  `details` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table `cash_receipt_logs`
--

CREATE TABLE `cash_receipt_logs` (
  `cash` double NOT NULL,
  `cash_source` int(11) NOT NULL COMMENT 'source account',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `file_name` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'table name (e.g. sales, purchases, returns)',
  `file_id` int(11) NOT NULL DEFAULT '0',
  `ref_no` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `old_account_value` double NOT NULL DEFAULT '0',
  `old_cash_value` double NOT NULL,
  `details` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `company_type` int(11) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `package_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `town_id` int(11) NOT NULL,
  `address` varchar(100) COLLATE utf8_bin NOT NULL,
  `lng` double NOT NULL,
  `lat` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `title`, `company_type`, `published`, `package_id`, `admin_id`, `town_id`, `address`, `lng`, `lat`) VALUES
(101, 'Citymart', 12, 1, 0, 10114, 0, 'Jallo Ghazi', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `company_branches`
--

CREATE TABLE `company_branches` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `branch_type` varchar(11) COLLATE utf8_bin NOT NULL,
  `town_id` int(11) NOT NULL,
  `address` varchar(100) COLLATE utf8_bin NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `lng` double NOT NULL,
  `lat` double NOT NULL,
  `billing_head` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_address` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_contacts` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `billing_notes` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=' Store, workshop, clinic etc';

--
-- Dumping data for table `company_branches`
--

INSERT INTO `company_branches` (`id`, `company_id`, `title`, `branch_type`, `town_id`, `address`, `published`, `lng`, `lat`, `billing_head`, `billing_address`, `billing_contacts`, `billing_notes`) VALUES
(101, 101, 'Citymart', '0', 0, 'Tarbela Road Jalu', 1, 0, 0, 'Sale Invoice', 'Tarbela Road Jalu', 'Usama 03095610604', 'sales item to be return and \r\nchang one days');

-- --------------------------------------------------------

--
-- Table structure for table `company_packages`
--

CREATE TABLE `company_packages` (
  `company_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `company_types`
--

CREATE TABLE `company_types` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_types`
--

INSERT INTO `company_types` (`id`, `title`, `published`) VALUES
(1, 'Softwares', 1),
(11, 'Departmental - Retail', 1),
(12, 'Departmental - Mix', 1),
(13, 'Departmental - Whole sale', 1),
(14, 'Departmental - Distribution', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `father_name` varchar(50) NOT NULL DEFAULT '',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '',
  `cnic` varchar(20) NOT NULL DEFAULT '',
  `town_id` int(11) NOT NULL DEFAULT '0',
  `account_no` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `fax_no` varchar(50) NOT NULL DEFAULT '',
  `mobile_no` varchar(50) NOT NULL DEFAULT '',
  `e_mail` varchar(100) NOT NULL DEFAULT '',
  `account_value` double NOT NULL DEFAULT '0',
  `lng` double NOT NULL DEFAULT '0',
  `lat` double NOT NULL DEFAULT '0',
  `register_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `consultant` int(11) NOT NULL DEFAULT '0',
  `reference` varchar(100) NOT NULL DEFAULT '',
  `diagnosis` varchar(255) NOT NULL DEFAULT '',
  `p_procedure` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `title`, `father_name`, `branch_id`, `address`, `cnic`, `town_id`, `account_no`, `phone`, `fax_no`, `mobile_no`, `e_mail`, `account_value`, `lng`, `lat`, `register_date`, `user_id`, `consultant`, `reference`, `diagnosis`, `p_procedure`) VALUES
(1, 'Iqtedar Khan', '', 101, 'Essha', '', 0, '17119', '', '', '', '', 150, 0, 0, '2018-12-17', 10113, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_credits`
--

CREATE TABLE `customer_credits` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ref_no` varchar(20) NOT NULL DEFAULT '',
  `amount` double NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `old_account_value` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_credits`
--

INSERT INTO `customer_credits` (`id`, `customer_id`, `ref_no`, `amount`, `date_time`, `user_id`, `transaction_date`, `old_account_value`) VALUES
(1, 6, 'sales.sale.306', 200, '2018-10-13 09:23:36', 12, '2018-10-13', 200),
(2, 1, 'sales.sale.2356', 150, '2018-12-23 09:00:18', 10114, '2018-12-23', 150);

-- --------------------------------------------------------

--
-- Table structure for table `debug_log`
--

CREATE TABLE `debug_log` (
  `id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_type` varchar(20) NOT NULL DEFAULT '',
  `log_data` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `err` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `debug_log`
--

INSERT INTO `debug_log` (`id`, `date_time`, `log_type`, `log_data`, `user_id`, `err`) VALUES
(0, '2018-12-13 04:43:24', 'DB_ERROR', 'Last SQL query: SELECT bp.* FROM branch_purchases AS bp LEFT JOIN branch_purchase_articles AS bpa ON (bp.purchase_id = bpa.purchase_id) WHERE bp.branch_id = 101 AND bp.purchase_id= <br/>Error#: 1064<br/>Desc: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '' at line 1<br/>', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `title`) VALUES
(5, 'Admin'),
(4, 'DERMATOLOGY'),
(3, 'Finance'),
(2, 'Purchases'),
(1, 'Sales');

-- --------------------------------------------------------

--
-- Table structure for table `devices_permit`
--

CREATE TABLE `devices_permit` (
  `company_id` int(11) NOT NULL,
  `device` varchar(100) COLLATE utf8_bin NOT NULL,
  `identification` varchar(20) COLLATE utf8_bin NOT NULL,
  `register_date` date NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `dept` int(11) DEFAULT '0',
  `designation` int(11) DEFAULT '0',
  `address` varchar(255) DEFAULT '',
  `mobile` varchar(25) DEFAULT '',
  `phone` varchar(25) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emp_designations`
--

CREATE TABLE `emp_designations` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `emp_designations`
--

INSERT INTO `emp_designations` (`id`, `title`) VALUES
(3, 'Chief Executive Officer (CEO)'),
(2, 'Directorz'),
(5, 'Doctor'),
(10, 'Labour'),
(4, 'Manager'),
(7, 'Operator'),
(1, 'Owner'),
(6, 'Receptionist');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expense_id` int(11) NOT NULL DEFAULT '0',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expense_date` date DEFAULT NULL,
  `amount` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `station_id` int(11) NOT NULL,
  `remarks` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_id`, `date_time`, `expense_date`, `amount`, `user_id`, `branch_id`, `station_id`, `remarks`) VALUES
(1, 1, '2018-10-04 16:31:09', '2018-10-04', 60, 10112, 101, 1, 'Milk');

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_bin NOT NULL,
  `category` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `expense_types`
--

INSERT INTO `expense_types` (`id`, `title`, `category`) VALUES
(1, 'Utility Bills', 'General'),
(2, 'Salary', 'Salary');

-- --------------------------------------------------------

--
-- Table structure for table `list_months`
--

CREATE TABLE `list_months` (
  `id` varchar(3) COLLATE utf8_bin NOT NULL,
  `title` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `list_months`
--

INSERT INTO `list_months` (`id`, `title`) VALUES
('Jan', 'January'),
('Feb', 'February'),
('Mar', 'March'),
('Apr', 'April'),
('May', 'May'),
('Jun', 'June'),
('Jul', 'July'),
('Aug', 'August'),
('Sep', 'September'),
('Oct', 'October'),
('Nov', 'November'),
('Dec', 'December');

-- --------------------------------------------------------

--
-- Table structure for table `list_seasons`
--

CREATE TABLE `list_seasons` (
  `id` varchar(15) COLLATE utf8_bin NOT NULL,
  `title` varchar(15) COLLATE utf8_bin NOT NULL,
  `months` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `list_seasons`
--

INSERT INTO `list_seasons` (`id`, `title`, `months`) VALUES
('autumn', 'Autumn', ''),
('summer', 'Summer', ''),
('spring', 'Spring', ''),
('winter', 'Winter', ''),
('monsoon', 'Monsoon', '');

-- --------------------------------------------------------

--
-- Table structure for table `list_tags`
--

CREATE TABLE `list_tags` (
  `tag` varchar(20) COLLATE utf8_bin NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `address` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `town_id` int(11) NOT NULL DEFAULT '0',
  `description` varchar(200) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu_type` varchar(24) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `menu_parms` varchar(200) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `req_access` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `home` tinyint(3) NOT NULL,
  `template` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msg_from` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg_cc` int(11) NOT NULL,
  `msg_status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '2 sent, 4 delivered, 8 read, 16 hide',
  `msg_subject` varchar(100) NOT NULL,
  `msg_body` text NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seasons`
--

CREATE TABLE `seasons` (
  `season` varchar(20) COLLATE utf8_bin NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `contact_person` varchar(50) NOT NULL DEFAULT '',
  `data_articles` text CHARACTER SET latin1,
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `city` varchar(15) NOT NULL DEFAULT '',
  `address` varchar(200) NOT NULL DEFAULT '',
  `terms_conditions` varchar(200) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `no_of_days` double NOT NULL DEFAULT '0',
  `fax_no` varchar(100) NOT NULL DEFAULT '',
  `mobile_no` varchar(100) NOT NULL DEFAULT '',
  `e_mail` varchar(100) NOT NULL DEFAULT '',
  `account_value` double NOT NULL DEFAULT '0' COMMENT 'Local credit account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_credits`
--

CREATE TABLE `supplier_credits` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `old_account_value` double NOT NULL DEFAULT '0',
  `ref_no` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `supplier_credits`
--

-- --------------------------------------------------------

--
-- Table structure for table `towns`
--

CREATE TABLE `towns` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `full_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_pass` varchar(255) COLLATE utf8_bin NOT NULL,
  `company` varchar(30) COLLATE utf8_bin NOT NULL,
  `e_mail` varchar(50) COLLATE utf8_bin NOT NULL,
  `phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `city` varchar(30) COLLATE utf8_bin NOT NULL,
  `zip_code` varchar(10) COLLATE utf8_bin NOT NULL,
  `address` varchar(255) COLLATE utf8_bin NOT NULL,
  `cnic` varchar(30) COLLATE utf8_bin NOT NULL,
  `group_id` int(11) NOT NULL,
  `register_date` date NOT NULL,
  `last_visit_date` date NOT NULL,
  `activation` varchar(100) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `published` int(1) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `acl` int(11) NOT NULL,
  `print_paper_size` varchar(10) COLLATE utf8_bin NOT NULL,
  `default_template` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'default',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `privileges` text COLLATE utf8_bin,
  `search_opt` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `data` text COLLATE utf8_bin,
  `options` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `full_name`, `user_pass`, `company`, `e_mail`, `phone`, `city`, `zip_code`, `address`, `cnic`, `group_id`, `register_date`, `last_visit_date`, `activation`, `notes`, `published`, `branch_id`, `dept_id`, `acl`, `print_paper_size`, `default_template`, `is_admin`, `privileges`, `search_opt`, `data`, `options`) VALUES
(10111, 'owner', 'Owner', 'e99a18c428cb38d5f260853678922e03', '101', 'owner@hotmail.com', '923005844433', 'Haripur', '0', 'b', '', 8, '2018-06-02', '2018-06-02', '', 'pass=abc123', 1, 101, 0, 12, 'pos', 'default', 1, '2,3,5,8,9,13,17,20,23,24,25,26,27,33,34', NULL, NULL, '[{"auto_multiQty":"false","fast_new_bill":"true"}]'),
(10113, 'admin', 'Admin', 'e88ebfe1ae982a6da01436e48af6eb74', '101', 'll', 'jj', 'Haripur', '0', 'b', '0', 8, '2018-10-23', '2018-10-23', '', '', 1, 101, 0, 12, 'pos', 'default', 0, '2,3,5,8,9,13,17,20,23,24,25,26,27,33,34,38,39', NULL, NULL, '[{"auto_multiQty":"false","fast_new_bill":"true"}]'),
(10114, 'user1', 'User 1', '172327706fc975aa0962791884609c37', '101', 'll', 'jj', 'Haripur', '0', 'b', '0', 8, '2018-10-23', '2018-10-23', '', '', 1, 101, 0, 12, 'pos', 'default', 0, '2,3,5,8,9,13,17,20,23,24,25,26,27,33,34', NULL, NULL, '[{"auto_multiQty":"false","fast_new_bill":"true"}]'),
(10401, 'user2', 'User 2', 'e99a18c428cb38d5f260853678922e03', '104', '', '', '', '', '', '', 128, '2018-10-21', '2018-10-21', '', '', 1, 104, 0, 128, 'A4', 'default', 1, '2,3,5,8,9,13,17,20,23,24,25,26,27,33,34,35', NULL, NULL, '[{"auto_multiQty":"false","fast_new_bill":"true"}]');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `published` int(1) NOT NULL,
  `power_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`group_id`, `group_name`, `published`, `power_level`) VALUES
(2, 'Public', 1, 2),
(4, 'Registered', 1, 4),
(8, 'End User', 1, 8),
(16, 'End User 2', 1, 16),
(32, 'Power User', 1, 32),
(64, 'Power User 2', 1, 64),
(128, 'Manager', 1, 128),
(256, 'Admin', 1, 256),
(512, 'Site Admin', 1, 512),
(1024, 'Super User', 1, 1024);

-- --------------------------------------------------------

--
-- Table structure for table `user_privileges`
--

CREATE TABLE `user_privileges` (
  `id` int(11) NOT NULL,
  `com` varchar(20) NOT NULL,
  `privilege_name` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_privileges`
--

INSERT INTO `user_privileges` (`id`, `com`, `privilege_name`, `title`) VALUES
(1, 'messages', 'delete', 'Delete'),
(2, 'messages', 'view', 'View'),
(3, 'articles', 'add', 'Add'),
(4, 'articles', 'add_stock', 'Add stock'),
(5, 'articles', 'discount', 'Discount'),
(6, 'articles', 'edit', 'Edit'),
(7, 'articles', 'stock_compare', 'Stock compare'),
(8, 'categories', 'add', 'Add'),
(9, 'categories', 'edit', 'Edit'),
(10, 'customers', 'add', 'Add'),
(11, 'customers', 'delete', 'Delete'),
(12, 'customers', 'edit', 'Edit'),
(13, 'customers', 'view', 'View'),
(14, 'inventories', 'add_entry', 'Add entry'),
(15, 'inventories', 'adjustments', 'Adjustments page'),
(16, 'inventories', 'delete_entry', 'Delete entry'),
(17, 'inventories', 'done', 'Finish Inventory'),
(18, 'purchases', 'add', 'Add'),
(19, 'purchases', 'add_return', 'Add return'),
(20, 'purchases', 'delete_item', 'Delete Items'),
(21, 'purchases', 'delete_itm_return', 'Delete Item Return'),
(22, 'purchases', 'edit', 'Edit'),
(23, 'sales', 'credit', 'Credit'),
(24, 'sales', 'discount', 'Discount'),
(25, 'sales', 'sale', 'Sale (POS)'),
(26, 'sales', 'sales_return', 'Sales return'),
(27, 'suppliers', 'add', 'Add'),
(28, 'suppliers', 'delete', 'Delete'),
(29, 'suppliers', 'edit', 'Edit'),
(30, 'suppliers', 'view', 'View'),
(31, 'users', 'change_password', 'Change password'),
(32, 'users', 'edit', 'Edit info'),
(33, 'cash', 'cash', 'Cash'),
(34, 'expenses', 'view', 'View Expenses'),
(35, 'lists', 'view', 'View Lists'),
(36, 'employees', 'view', 'Employees'),
(37, 'services', 'view', 'Services'),
(38, 'setup', 'backupdb', 'Backup DB'),
(39, 'setup', 'restoredb', 'Restore DB');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_branch_item_qty_compare`
--
CREATE TABLE `view_branch_item_qty_compare` (
`branch_id` int(11)
,`article_code` varchar(20)
,`item_sum` double
,`purchase_item_sum` double
,`item_return_purchase_sum` double
,`item_sale_sum` double
,`item_sale_return_sum` double
);

-- --------------------------------------------------------

--
-- Structure for view `view_branch_item_qty_compare`
--
DROP TABLE IF EXISTS `view_branch_item_qty_compare`;

CREATE ALGORITHM=UNDEFINED DEFINER=`qluo0xdpd5lu`@`localhost` SQL SECURITY DEFINER VIEW `view_branch_item_qty_compare`  AS  (select `ba`.`branch_id` AS `branch_id`,`a`.`article_code` AS `article_code`,sum((`ba`.`qty` + `ba`.`scheme`)) AS `item_sum`,0 AS `purchase_item_sum`,0 AS `item_return_purchase_sum`,0 AS `item_sale_sum`,0 AS `item_sale_return_sum` from (`branch_articles` `ba` join `articles` `a` on((`ba`.`article_code` = `a`.`article_code`))) group by `a`.`article_code`,`ba`.`branch_id`) union all (select `bp`.`branch_id` AS `branch_id`,`bpa`.`article_code` AS `article_code`,0 AS `item_sum`,sum((`bpa`.`qty_scheme` + `bpa`.`scheme`)) AS `purchase_item_sum`,0 AS `item_return_purchase_sum`,0 AS `item_sale_sum`,0 AS `item_sale_return_sum` from (`branch_purchase_articles` `bpa` join `branch_purchases` `bp` on((`bpa`.`purchase_id` = `bp`.`purchase_id`))) group by `bpa`.`article_code`,`bp`.`branch_id`) union all (select `bpr`.`branch_id` AS `branch_id`,`bpra`.`article_code` AS `article_code`,0 AS `item_sum`,0 AS `purchase_item_sum`,sum((`bpra`.`qty_scheme` + `bpra`.`scheme`)) AS `item_return_purchase_sum`,0 AS `item_sale_sum`,0 AS `item_sale_return_sum` from (`branch_purchase_return_articles` `bpra` join `branch_purchase_returns` `bpr` on((`bpra`.`return_id` = `bpr`.`id`))) group by `bpra`.`article_code`,`bpr`.`branch_id`) union all (select `bs`.`branch_id` AS `branch_id`,`bsa`.`article_code` AS `article_code`,0 AS `item_sum`,0 AS `purchase_item_sum`,0 AS `item_return_purchase_sum`,sum((`bsa`.`qty` + `bsa`.`scheme`)) AS `item_sale_sum`,0 AS `item_sale_return_sum` from (`branch_sale_articles` `bsa` join `branch_sales` `bs` on((`bsa`.`sale_id` = `bs`.`id`))) group by `bsa`.`article_code`,`bs`.`branch_id`) union all (select `bsr`.`branch_id` AS `branch_id`,`bsra`.`article_code` AS `article_code`,0 AS `item_sum`,0 AS `purchase_item_sum`,0 AS `item_return_purchase_sum`,0 AS `item_sale_sum`,sum((`bsra`.`qty` + `bsra`.`scheme`)) AS `item_sale_return_sum` from (`branch_sale_return_articles` `bsra` join `branch_sales_return` `bsr` on((`bsra`.`return_id` = `bsr`.`id`))) group by `bsra`.`article_code`,`bsr`.`branch_id`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_code`),
  ADD UNIQUE KEY `ref_code` (`ref_code`),
  ADD UNIQUE KEY `title` (`title`) USING BTREE,
  ADD KEY `ind_articles_category` (`article_code`),
  ADD KEY `fk_articles_category` (`category`);

--
-- Indexes for table `article_cats`
--
ALTER TABLE `article_cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_accounts`
--
ALTER TABLE `branch_accounts`
  ADD PRIMARY KEY (`branch_id`,`account_id`);

--
-- Indexes for table `branch_articles`
--
ALTER TABLE `branch_articles`
  ADD PRIMARY KEY (`branch_id`,`article_code`),
  ADD KEY `ind_branch_articles_art_code` (`branch_id`),
  ADD KEY `ind_branch_articles_branch_id` (`branch_id`),
  ADD KEY `fk_branch_articles_art_code` (`article_code`);

--
-- Indexes for table `branch_cash_accounts`
--
ALTER TABLE `branch_cash_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_customers`
--
ALTER TABLE `branch_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_inventories`
--
ALTER TABLE `branch_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_inv_articles`
--
ALTER TABLE `branch_inv_articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_purchases`
--
ALTER TABLE `branch_purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `branch_purchase_articles`
--
ALTER TABLE `branch_purchase_articles`
  ADD PRIMARY KEY (`purchase_id`,`article_code`);

--
-- Indexes for table `branch_purchase_returns`
--
ALTER TABLE `branch_purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_purchase_return_articles`
--
ALTER TABLE `branch_purchase_return_articles`
  ADD PRIMARY KEY (`return_id`,`article_code`);

--
-- Indexes for table `branch_sales`
--
ALTER TABLE `branch_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_sales_return`
--
ALTER TABLE `branch_sales_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_stores`
--
ALTER TABLE `branch_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_payment_logs`
--
ALTER TABLE `cash_payment_logs`
  ADD KEY `ind_cash_pm_dt` (`date_time`),
  ADD KEY `ind_cash_pm_refno` (`ref_no`);

--
-- Indexes for table `cash_receipt_logs`
--
ALTER TABLE `cash_receipt_logs`
  ADD KEY `ind_cash_receipt_dt` (`date_time`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_branches`
--
ALTER TABLE `company_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_packages`
--
ALTER TABLE `company_packages`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_credits`
--
ALTER TABLE `customer_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `debug_log`
--
ALTER TABLE `debug_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_designations`
--
ALTER TABLE `emp_designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_no` (`station_id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`season`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_credits`
--
ALTER TABLE `supplier_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `towns`
--
ALTER TABLE `towns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `ind_users_user_name` (`user_name`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article_cats`
--
ALTER TABLE `article_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2006;
--
-- AUTO_INCREMENT for table `branch_cash_accounts`
--
ALTER TABLE `branch_cash_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `branch_customers`
--
ALTER TABLE `branch_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `branch_inventories`
--
ALTER TABLE `branch_inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `branch_inv_articles`
--
ALTER TABLE `branch_inv_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;
--
-- AUTO_INCREMENT for table `branch_purchases`
--
ALTER TABLE `branch_purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;
--
-- AUTO_INCREMENT for table `branch_purchase_returns`
--
ALTER TABLE `branch_purchase_returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `branch_sales`
--
ALTER TABLE `branch_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6475;
--
-- AUTO_INCREMENT for table `branch_sales_return`
--
ALTER TABLE `branch_sales_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `branch_stores`
--
ALTER TABLE `branch_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_credits`
--
ALTER TABLE `customer_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_designations`
--
ALTER TABLE `emp_designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=658;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `supplier_credits`
--
ALTER TABLE `supplier_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
