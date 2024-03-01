-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 29, 2024 at 01:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lm_ent-bv5`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(250) NOT NULL,
  `brand_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `category_id`, `brand_name`, `brand_status`) VALUES
(25, 15, 'EPSON', 'active'),
(26, 16, 'monggol', 'active'),
(27, 15, 'HBV', 'active'),
(28, 18, 'sample brand', 'active'),
(29, 18, 'Ej brand', 'active'),
(30, 17, 'brand 1', 'active'),
(31, 17, 'brand 2', 'active'),
(32, 19, 'VENUM', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `category_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`) VALUES
(15, 'Office Supplies', 'active'),
(16, 'School Suppplies', 'active'),
(17, 'Janitor Supplies', 'active'),
(18, 'Furniture', 'active'),
(19, 'SPORTS EQUIPMENT', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_order`
--

CREATE TABLE `inventory_order` (
  `inventory_order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inventory_order_total` double(10,2) NOT NULL,
  `inventory_order_date` date NOT NULL,
  `inventory_order_name` varchar(255) NOT NULL,
  `inventory_order_address` text NOT NULL,
  `payment_status` enum('cash','credit') NOT NULL,
  `inventory_order_status` varchar(100) NOT NULL,
  `inventory_order_created_date` date NOT NULL,
  `vat_percentage` double(10,2) NOT NULL,
  `discount` double(10,2) NOT NULL,
  `overall_total` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory_order`
--

INSERT INTO `inventory_order` (`inventory_order_id`, `user_id`, `inventory_order_total`, `inventory_order_date`, `inventory_order_name`, `inventory_order_address`, `payment_status`, `inventory_order_status`, `inventory_order_created_date`, `vat_percentage`, `discount`, `overall_total`) VALUES
(1, 1, 12.00, '2024-02-20', 'matthew', 'NONE', 'cash', 'active', '2024-02-28', 0.00, 0.00, 12.00),
(2, 1, 90.00, '2024-02-28', 'Morty', 'NONE', 'cash', 'active', '2024-02-28', 0.00, 0.00, 90.00),
(3, 1, 60.00, '2024-02-27', 'Customer 2', 'NONE', 'cash', 'active', '2024-02-28', 0.00, 0.00, 60.00),
(4, 1, 13.44, '2024-02-27', 'dave m', 'NONE', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(5, 1, 13.44, '2024-02-20', 'dave', 'NONE', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(6, 1, 33.60, '2024-02-20', 'EJ ', 'NONE', 'cash', 'active', '2024-02-28', 0.00, 0.00, 33.60),
(7, 1, 64.20, '2024-02-20', 'Customer 12', 'NONE', 'cash', 'active', '2024-02-28', 0.00, 0.00, 64.20),
(8, 1, 0.00, '2024-02-13', 'matthew', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 0.00),
(9, 1, 13.44, '2024-01-30', 'dave', 'none', 'cash', 'active', '2024-02-28', 12.00, 0.00, 15.05),
(10, 1, 13.44, '2024-02-20', 'Customer 2', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(11, 1, 13.44, '2024-02-27', 'EJ ', 'n', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(12, 1, 13.44, '2024-02-27', 'cust 6', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(13, 1, 13.44, '2024-02-27', 'Customer 12', 'none', 'cash', 'active', '2024-02-28', 0.22, 0.00, 13.47),
(14, 1, 13.44, '2024-02-20', 'dave', 'none', 'cash', 'active', '2024-02-28', 0.15, 0.00, 13.46),
(15, 1, 13.44, '2024-02-27', 'Customer 1', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(16, 1, 13.44, '2024-02-19', 'Customer 2', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(17, 1, 13.44, '2024-02-20', 'EJ ', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(18, 1, 0.00, '2024-02-27', 'dave', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 0.00),
(19, 1, 13.44, '2024-02-20', 'dave m', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(20, 1, 13.44, '2024-02-27', 'matthew', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(21, 1, 13.44, '2024-02-20', 'Morty', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(22, 1, 12.00, '2024-02-27', 'Rick Sanchez', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 12.00),
(23, 1, 13.44, '2024-02-27', 'Customer 1010', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(24, 1, 13.44, '2024-02-20', 'EJ ', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(25, 1, 12.84, '2024-02-27', 'dave', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 12.84),
(26, 1, 13.44, '2024-02-27', 'dave', 'n', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(27, 1, 13.44, '2024-02-27', 'Customer 1', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(28, 1, 13.44, '2024-02-20', 'dave 4', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 25.44),
(29, 1, 13.44, '2024-02-27', 'dave', 'n', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(30, 1, 13.44, '2024-02-27', 'Customer 1', 'n', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(31, 1, 13.44, '2024-02-27', 'dave 5', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(32, 1, 12.84, '2024-02-20', 'Customer 12', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 12.84),
(33, 1, 13.44, '2024-02-27', 'EJ ', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(34, 1, 13.44, '2024-02-19', 'dave', 'm', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(35, 1, 13.44, '2024-02-27', 'dave m', 'none', 'cash', 'active', '2024-02-28', 0.00, 0.00, 0.00),
(36, 1, 13.44, '2024-02-27', 'Customer 1', 'g', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(37, 1, 13.44, '2024-03-05', 'dave m', 'm', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(38, 1, 13.44, '2024-02-27', 'dave', 'm', 'cash', 'active', '2024-02-28', 0.00, 0.00, 13.44),
(39, 1, 13.44, '2024-02-27', 'EJ ', 'n', 'cash', 'active', '2024-02-29', 0.00, 0.00, 13.44),
(40, 1, 13.44, '2024-02-27', 'dave m', 'none', 'cash', 'active', '2024-02-29', 0.00, 0.00, 25.44),
(41, 1, 12.84, '2024-02-27', 'dave mtthw', 'none', 'cash', 'active', '2024-02-29', 0.00, 5.00, 12.84),
(42, 1, 12.84, '2024-02-28', 'Customer 2', 'none', 'cash', 'active', '2024-02-29', 12.00, 5.00, 12.84),
(43, 1, 12.00, '2024-02-28', 'Customer 1', 'nuay', 'cash', 'active', '2024-02-29', 0.00, 0.00, 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_order_product`
--

CREATE TABLE `inventory_order_product` (
  `inventory_order_product_id` int(11) NOT NULL,
  `inventory_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `tax` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory_order_product`
--

INSERT INTO `inventory_order_product` (`inventory_order_product_id`, `inventory_order_id`, `product_id`, `quantity`, `price`, `tax`) VALUES
(1, 1, 50, 1, 12.00, 0.00),
(2, 2, 51, 1, 90.00, 0.00),
(3, 3, 49, 1, 60.00, 0.00),
(4, 4, 50, 1, 12.00, 0.00),
(5, 5, 50, 1, 12.00, 0.00),
(6, 6, 48, 1, 30.00, 0.00),
(7, 7, 49, 1, 60.00, 0.00),
(8, 8, 50, 1, 12.00, 0.00),
(9, 9, 50, 1, 12.00, 0.00),
(10, 10, 50, 1, 12.00, 0.00),
(11, 11, 50, 1, 12.00, 0.00),
(12, 12, 50, 1, 12.00, 0.00),
(13, 13, 50, 1, 12.00, 0.00),
(14, 14, 50, 1, 12.00, 0.00),
(15, 15, 50, 1, 12.00, 0.00),
(16, 16, 50, 1, 12.00, 0.00),
(17, 17, 50, 1, 12.00, 0.00),
(18, 19, 50, 1, 12.00, 0.00),
(19, 20, 50, 1, 12.00, 0.00),
(20, 21, 50, 1, 12.00, 0.00),
(21, 22, 50, 1, 12.00, 0.00),
(22, 23, 50, 1, 12.00, 0.00),
(23, 24, 50, 1, 12.00, 0.00),
(24, 25, 50, 1, 12.00, 0.00),
(25, 26, 50, 1, 12.00, 0.00),
(26, 27, 50, 1, 12.00, 0.00),
(27, 28, 50, 1, 12.00, 0.00),
(28, 29, 50, 1, 12.00, 0.00),
(29, 30, 50, 1, 12.00, 0.00),
(30, 31, 50, 1, 12.00, 0.00),
(31, 32, 50, 1, 12.00, 0.00),
(32, 33, 50, 1, 12.00, 0.00),
(33, 34, 50, 1, 12.00, 0.00),
(34, 35, 50, 1, 12.00, 0.00),
(35, 36, 50, 1, 12.00, 0.00),
(36, 37, 50, 1, 12.00, 0.00),
(37, 38, 50, 1, 12.00, 0.00),
(38, 39, 50, 1, 12.00, 0.00),
(39, 40, 50, 1, 12.00, 0.00),
(40, 41, 50, 1, 12.00, 0.00),
(41, 42, 50, 1, 12.00, 0.00),
(42, 43, 50, 1, 12.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `product_description` text NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_unit` varchar(150) NOT NULL,
  `product_base_price` double(10,2) NOT NULL,
  `product_tax` decimal(4,2) NOT NULL,
  `product_minimum_order` double(10,2) NOT NULL,
  `product_enter_by` int(11) NOT NULL,
  `product_status` enum('active','inactive') NOT NULL,
  `product_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `brand_id`, `product_name`, `product_description`, `product_quantity`, `product_unit`, `product_base_price`, `product_tax`, `product_minimum_order`, `product_enter_by`, `product_status`, `product_date`) VALUES
(27, 15, 27, 'Ballpen (BLUE)', 'none', 1, 'Box', 60.00, '10.00', 0.00, 1, 'active', '2024-02-06'),
(30, 15, 25, 'Pencil', 'none', 1, 'Box', 60.00, '10.00', 0.00, 1, 'inactive', '2024-02-06'),
(31, 15, 25, 'printer (box)', 'none', 5, 'Box', 4000.00, '10.00', 0.00, 1, 'active', '2024-02-06'),
(33, 16, 26, 'Pencil 4h (Graphite)', 'none basta lapis lang', 5, 'Box', 100.00, '10.00', 0.00, 1, 'active', '2024-02-08'),
(34, 15, 27, 'Ballpen BLACK', 'NONE', 5, 'Box', 60.00, '10.00', 0.00, 1, 'active', '2024-02-08'),
(35, 15, 25, 'EPSON INK', 'none', 1, 'Box', 100.00, '10.00', 0.00, 1, 'active', '2024-02-09'),
(36, 15, 25, 'EPSON INK (BLACK)', 'Printer ink (black)', 5, 'Box', 100.00, '10.00', 0.00, 1, 'active', '2024-02-09'),
(41, 16, 26, 'pencil charcoal', 'none', 5, 'Box', 300.00, '10.00', 0.00, 1, 'inactive', '2024-02-15'),
(42, 17, 30, 'map', 'none', 300, 'Pcs', 200.00, '0.00', 0.00, 1, 'active', '2024-02-15'),
(43, 17, 31, 'rubber gloves', 'none', 300, 'Pcs', 30.00, '5.00', 0.00, 1, 'active', '2024-02-15'),
(44, 17, 30, 'Cleaning towels', 'none', 100, 'Pcs', 25.00, '0.00', 0.00, 1, 'active', '2024-02-15'),
(45, 15, 25, 'Printer INK (small)', 'NONE', 5, 'Box', 1200.00, '5.00', 0.00, 1, 'active', '2024-02-16'),
(48, 17, 31, 'Dish washing liquid (no tax)', 'none', 300, 'Box', 30.00, '0.00', 0.00, 1, 'active', '2024-02-17'),
(49, 17, 31, 'Spray Container bottle (no tax)', 'none', 150, 'Pcs', 60.00, '0.00', 0.00, 1, 'active', '2024-02-17'),
(50, 17, 31, 'rags (no tax)', 'none', 300, 'Pcs', 12.00, '0.00', 0.00, 1, 'active', '2024-02-17'),
(51, 19, 32, 'MOUTH GUARD (NO TAX)', 'NONE', 300, 'Pcs', 90.00, '0.00', 0.00, 1, 'active', '2024-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_type` enum('admin','user') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_type`, `user_status`) VALUES
(1, 'admin123@gmail.com', '$2y$10$.JEm7ciQEsOyQYG6nX.dkeIGFkSh9kUkMVm4Q7hdwDK2yBNgI6IVq', 'Admin', 'admin', 'Active'),
(11, 'mattd@gmail.com', '$2y$10$tYnXpSaYJDxlkgVZ5Hr86OnMhAbI2Z0jjjA.tyI4lOBsfScH3gXES', 'matthewD', 'user', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `inventory_order`
--
ALTER TABLE `inventory_order`
  ADD PRIMARY KEY (`inventory_order_id`);

--
-- Indexes for table `inventory_order_product`
--
ALTER TABLE `inventory_order_product`
  ADD PRIMARY KEY (`inventory_order_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `inventory_order`
--
ALTER TABLE `inventory_order`
  MODIFY `inventory_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `inventory_order_product`
--
ALTER TABLE `inventory_order_product`
  MODIFY `inventory_order_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
