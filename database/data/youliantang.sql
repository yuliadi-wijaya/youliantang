-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2023 at 03:20 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youliantang`
--

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE `activations` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'SaZ8e4XUpCBuOu6YUVD8PQf12dMwFz63', 1, '2023-11-02 02:42:18', '2023-11-02 02:42:18', '2023-11-02 02:42:18'),
(2, 2, 'hly2aVx799bsfjGV04iFw4uExzLeNhof', 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(3, 3, '5O7lpq19Bqd5oMBXDQavF5iKmDxYThV4', 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(4, 4, 'dBbhifKrwyKD4jzF8qSx0yKNrfAzlzac', 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(5, 5, '6gBWZk6h39mHIYRYFLI6rBVCxHatHctl', 1, '2023-11-09 12:43:40', '2023-11-09 12:43:40', '2023-11-09 12:43:40'),
(6, 6, '1Wf6hxLENBe5d7csVGOcAsLd06ezqClD', 1, '2023-11-12 14:42:18', '2023-11-12 14:42:18', '2023-11-12 14:42:18'),
(7, 7, 'K1l2EyVChsH4p6ZqZ15W6PUxNMltJnv1', 1, '2023-11-17 13:37:33', '2023-11-17 13:37:33', '2023-11-17 13:37:33'),
(8, 8, 'YvU9pXMfSjcqoJigoLpFZlpRNs3sCiC3', 1, '2023-11-19 08:14:31', '2023-11-19 08:14:31', '2023-11-19 08:14:31'),
(9, 9, 'rdpQyd7ULclgSJ6UwE2TjxOjYpVtZWMn', 1, '2023-11-19 08:24:15', '2023-11-19 08:24:15', '2023-11-19 08:24:15'),
(10, 10, 'MIf1wSZoxfPtVRlo4EAZvrag1vcHkbxD', 1, '2023-11-19 08:28:52', '2023-11-19 08:28:52', '2023-11-19 08:28:52'),
(11, 11, '3TcKTE0OxXAkp5jd7wWSY9ycbcQf6HTU', 1, '2023-11-19 08:36:26', '2023-11-19 08:36:26', '2023-11-19 08:36:26'),
(12, 8, 'HIjmc3ItjqPBfD8Y6U5jagbvBQNblQD8', 1, '2023-12-09 12:43:44', '2023-12-09 12:43:44', '2023-12-09 12:43:44'),
(13, 9, 'UyCcTWd6QAN5GNKlBZD1SLxcrpxtoWHy', 1, '2023-12-09 12:50:55', '2023-12-09 12:50:55', '2023-12-09 12:50:55'),
(14, 10, 'JoW7uCEVrioWm6F7a54uJjcn3Jir7zFh', 1, '2023-12-09 14:09:24', '2023-12-09 14:09:24', '2023-12-09 14:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `appointment_for` bigint UNSIGNED NOT NULL,
  `appointment_with` bigint UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `available_time` bigint UNSIGNED NOT NULL,
  `available_slot` bigint UNSIGNED NOT NULL,
  `booked_by` bigint UNSIGNED NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=>pending,1=>complete,2=>cancel',
  `is_deleted` tinyint NOT NULL DEFAULT '0' COMMENT '0=>active,1=>inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_setting`
--

CREATE TABLE `app_setting` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_lg` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_sm` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_dark_sm` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_dark_lg` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `footer_left` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `footer_right` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_setting`
--

INSERT INTO `app_setting` (`id`, `title`, `logo_lg`, `logo_sm`, `logo_dark_sm`, `logo_dark_lg`, `favicon`, `footer_left`, `footer_right`, `created_at`, `updated_at`) VALUES
(1, 'You Lian tAng', 'logo-light1.png', 'logo-light.png', 'logo-dark.png', 'logo-dark1.png', 'favicon.ico', 'You Lian tAng', 'Reflexology & Massage Therapy', '2023-11-02 02:42:17', '2023-11-02 02:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `place_of_birth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `emergency_contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `place_of_birth`, `birth_date`, `gender`, `address`, `emergency_contact`, `emergency_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 3, 'Jakarta', '1996-06-20', 'Male', '7230 Lang Fords\nWilliamsonberg, CO 71807-6136', '085712061392', 'Liam', 1, 1, 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', 0),
(2, 6, 'Kuningan', '1994-03-17', 'Male', 'Kuningan', '087712123322', 'Dadan', 1, 1, 1, '2023-11-12 14:42:18', '2023-11-12 14:42:18', 0),
(3, 7, 'Kuningan', '1995-06-07', 'Male', 'Kuningan', '089713131311', 'Dodo', 1, 1, 1, '2023-11-17 13:37:33', '2023-11-17 13:37:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_members`
--

CREATE TABLE `customer_members` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `membership_id` bigint UNSIGNED NOT NULL,
  `expired_date` date NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_members`
--

INSERT INTO `customer_members` (`id`, `customer_id`, `membership_id`, `expired_date`, `status`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2023-12-11', 1, 1, 1, 0, '2023-11-11 10:08:27', '2023-11-12 04:12:04'),
(2, 6, 2, '2024-11-16', 0, 1, 1, 0, '2023-11-17 13:36:16', '2023-11-17 13:50:03');

-- --------------------------------------------------------

--
-- Stand-in structure for view `customer_regist_v`
-- (See below for the actual view)
--
CREATE TABLE `customer_regist_v` (
`customer_name` varchar(101)
,`phone_number` varchar(20)
,`email` varchar(100)
,`register_date` timestamp
,`place_of_birth` varchar(50)
,`birth_date` date
,`gender` enum('Male','Female')
,`address` text
,`emergency_name` varchar(100)
,`emergency_contact` varchar(20)
,`is_member` int
,`customer_status` varchar(10)
,`member_plan` varchar(191)
,`member_status` varchar(10)
,`start_member` timestamp
,`expired_date` date
);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `therapist_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_mode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `treatment_date` date NOT NULL,
  `treatment_time_from` time DEFAULT NULL,
  `treatment_time_to` time DEFAULT NULL,
  `note` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `old_data` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N' COMMENT 'Y=>Yes, N=>No',
  `is_member` tinyint DEFAULT NULL,
  `use_member` tinyint DEFAULT NULL,
  `member_plan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `grand_total` double DEFAULT NULL,
  `invoice_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_type` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_name`, `therapist_name`, `room`, `payment_mode`, `payment_status`, `treatment_date`, `treatment_time_from`, `treatment_time_to`, `note`, `created_by`, `updated_by`, `status`, `created_at`, `updated_at`, `is_deleted`, `customer_id`, `old_data`, `is_member`, `use_member`, `member_plan`, `voucher_code`, `total_price`, `discount`, `grand_total`, `invoice_code`, `invoice_type`) VALUES
(2, 'Liam Lubowitz', 'Aliyah Schultz', 'Room 306', 'OVO', 'Paid', '2023-11-02', '08:00:00', '09:00:00', 'Edit Old Data ke 2', 1, 1, 1, '2023-11-02 06:51:03', '2023-11-07 17:31:01', 0, NULL, 'Y', NULL, NULL, NULL, NULL, 615000, 0, 615000, 'INV/CK/23110004', 'CK'),
(6, NULL, NULL, NULL, 'QRIS', 'Paid', '2023-11-13', NULL, NULL, 'Tes Invoice edit', 1, 1, 1, '2023-11-12 18:41:46', '2023-11-21 17:49:59', 0, 6, 'N', 0, 0, NULL, 'GO2023110203481', 310000, 15000, 295000, 'INV/NC/23110001', 'NC'),
(7, NULL, NULL, NULL, 'GoPay', 'Paid', '2023-11-21', NULL, NULL, 'Testing invoice code invoice type', 1, NULL, 1, '2023-11-21 16:40:16', '2023-11-21 16:40:16', 0, 6, 'N', 0, 0, NULL, 'GO2023110261794', 135000, 15000, 120000, 'INV/CK/23110001', 'CK'),
(8, NULL, NULL, NULL, 'Debit/Credit Card', 'Unpaid', '2023-11-22', NULL, NULL, 'Tes', 1, 1, 1, '2023-11-22 16:00:24', '2023-11-22 17:08:25', 0, 7, 'N', 0, 0, NULL, 'GO2023110212657', 110000, 15000, 95000, 'INV/CK/23110002', 'CK'),
(9, NULL, NULL, NULL, 'Debit/Credit Card', 'Paid', '2023-11-22', NULL, NULL, 'Tes', 1, 1, 1, '2023-11-22 16:02:33', '2023-11-22 16:12:14', 0, 3, 'N', 1, 0, NULL, 'CB2023111275255', 110000, 5500, 104500, 'INV/NC/23110002', 'NC'),
(10, NULL, NULL, NULL, 'QRIS', 'Paid', '2023-11-24', NULL, NULL, 'Tes earning', 1, NULL, 1, '2023-11-24 05:59:25', '2023-11-24 05:59:25', 0, 7, 'N', 0, 0, NULL, 'CB2023111275255', 110000, 5500, 104500, 'INV/CK/23110003', 'CK'),
(11, NULL, NULL, NULL, 'QRIS', 'Paid', '2023-11-28', NULL, NULL, 'Tes create from settings edit 2', 1, 1, 1, '2023-11-28 08:45:08', '2023-11-28 08:58:02', 0, 7, 'N', NULL, 0, NULL, NULL, 135000, 0, 135000, 'INV/CK/23110005', 'CK'),
(12, NULL, NULL, NULL, 'Debit/Credit Card', 'Paid', '2023-12-09', NULL, NULL, 'Resepsionis tes', 9, NULL, 1, '2023-12-09 15:18:37', '2023-12-09 15:18:37', 0, 7, 'N', 0, 0, NULL, 'GO2023110252372', 140000, 15000, 125000, 'INV/CK/23120006', 'CK');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `treatment_time_from` time DEFAULT NULL,
  `treatment_time_to` time DEFAULT NULL,
  `room` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `therapist_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `title`, `amount`, `status`, `created_at`, `updated_at`, `is_deleted`, `product_id`, `treatment_time_from`, `treatment_time_to`, `room`, `therapist_id`) VALUES
(1, 2, 'Candle massage 90 menit', 285000, 1, '2023-11-02 06:51:03', '2023-11-07 17:31:01', 0, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Candle massage 120 menit', 330000, 1, '2023-11-02 06:51:03', '2023-11-07 17:31:01', 0, NULL, NULL, NULL, NULL, NULL),
(13, 7, NULL, 135000, 1, '2023-11-21 16:40:16', '2023-11-21 16:40:16', 0, 2, '07:00:00', '09:00:00', 'Room 303', 5),
(16, 6, NULL, 140000, 1, '2023-11-21 17:49:59', '2023-11-21 17:49:59', 0, 3, '07:00:00', '08:30:00', 'Room 301', 5),
(17, 6, NULL, 170000, 1, '2023-11-21 17:49:59', '2023-11-21 17:49:59', 0, 4, '09:00:00', '11:00:00', 'Room 302', 2),
(21, 9, NULL, 110000, 1, '2023-11-22 16:12:14', '2023-11-22 16:12:14', 0, 1, '11:00:00', '12:30:00', 'Room 305', 5),
(22, 8, NULL, 110000, 1, '2023-11-22 17:08:25', '2023-11-22 17:08:25', 0, 1, '07:10:00', '08:40:00', 'Room 306', 5),
(23, 10, NULL, 110000, 1, '2023-11-24 05:59:25', '2023-11-24 05:59:25', 0, 1, '10:00:00', '11:30:00', 'Room 303', 5),
(24, 11, NULL, 135000, 1, '2023-11-28 08:45:08', '2023-11-28 08:58:02', 1, 2, '07:00:00', '09:00:00', 'Room 302', 2),
(25, 11, NULL, 135000, 1, '2023-11-28 08:48:27', '2023-11-28 08:58:02', 1, 2, '07:00:00', '09:00:00', 'Room 302', 2),
(26, 11, NULL, 135000, 1, '2023-11-28 08:57:31', '2023-11-28 08:58:02', 1, 2, '07:00:00', '09:00:00', 'Room 302', 2),
(27, 11, NULL, 135000, 1, '2023-11-28 08:58:02', '2023-11-28 08:58:02', 0, 2, '07:00:00', '09:00:00', 'Room 302', 2),
(28, 12, NULL, 140000, 1, '2023-12-09 15:18:37', '2023-12-09 15:18:37', 0, 3, '08:00:00', '09:30:00', 'Room 303', 5);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_setting`
--

CREATE TABLE `invoice_setting` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_type` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_setting`
--

INSERT INTO `invoice_setting` (`id`, `invoice_type`, `created_at`, `updated_at`) VALUES
(1, 'CK', '2023-11-24 03:16:26', '2023-12-09 15:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `medical_infos`
--

CREATE TABLE `medical_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `height` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_group` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pulse` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `allergy` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_pressure` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `respiration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diet` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0' COMMENT '0=>active,1=>inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_infos`
--

INSERT INTO `medical_infos` (`id`, `user_id`, `height`, `b_group`, `pulse`, `allergy`, `weight`, `b_pressure`, `respiration`, `diet`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 3, '175', 'B+', '253 Gutkowski Square Suite 147\nLubowitzhaven, NM 52743-7325', '575 Mills Loaf\nMarcobury, AZ 62401', '50', 'no', 'no', 'Vegetarian', 0, '2023-11-02 02:42:19', '2023-11-02 02:42:19');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint UNSIGNED NOT NULL,
  `prescription_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0' COMMENT '0=>active,1=>inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` int NOT NULL DEFAULT '0' COMMENT '0=>fix,1=>percentage',
  `discount_value` double NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `total_active_period` int NOT NULL DEFAULT '0' COMMENT 'days',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `name`, `discount_type`, `discount_value`, `status`, `total_active_period`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Regular', 0, 1000, 1, 365, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(2, 'Gold', 1, 5, 1, 365, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(3, 'Platinum', 1, 10, 1, 365, NULL, NULL, 0, '2023-11-02 02:42:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_07_02_230147_migration_cartalyst_sentinel', 1),
(2, '2020_06_02_181105_create_customers_table', 1),
(3, '2020_06_02_190516_create_medical_infos_table', 1),
(4, '2020_06_15_193503_create_therapists_table', 1),
(5, '2020_08_12_192435_create_appointments_table', 1),
(6, '2020_08_23_204021_create_prescriptions_table', 1),
(7, '2020_08_23_204823_create_medicines_table', 1),
(8, '2020_08_23_204910_create_test_reports_table', 1),
(9, '2020_08_27_005231_create_invoices_table', 1),
(10, '2020_08_27_013259_create_invoice__details_table', 1),
(11, '2021_10_14_110108_create_receptionists_table', 1),
(12, '2021_10_25_105909_create_notification_types_table', 1),
(13, '2021_10_25_110054_create_notifications_table', 1),
(14, '2021_10_26_163942_create_therapist_available_days_table', 1),
(15, '2021_10_27_152952_create_therapist_available_times_table', 1),
(16, '2021_10_27_154530_create_therapist_available_slots_table', 1),
(17, '2021_11_01_152756_add_foreign_keys_to_appointments_table', 1),
(18, '2021_12_28_173014_create_transactions_table', 1),
(19, '2022_01_13_142321_create_payment_apis_table', 1),
(20, '2023_02_09_123305_app_setting', 1),
(21, '2023_10_27_180213_create_memberships_table', 1),
(22, '2023_10_29_120356_create_products_table', 1),
(23, '2023_10_29_152112_create_rooms_table', 1),
(24, '2023_10_29_160620_create_promos_table', 1),
(25, '2023_10_29_162051_create_promo_vouchers_table', 1),
(26, '2023_11_01_101016_create_transaction_new_table', 1),
(27, '2023_11_11_151343_create_customer_members_table', 2),
(28, '2023_11_24_123305_invoice_setting', 3),
(29, '2023_11_24_210301_create_reviews_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `notification_type_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_user` bigint UNSIGNED NOT NULL,
  `to_user` bigint UNSIGNED NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int NOT NULL DEFAULT '0' COMMENT '0=>Active, 1=>Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE `notification_types` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` int NOT NULL DEFAULT '0' COMMENT '0=>Active, 1=>Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `type`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Appointment Added', 0, '2023-11-02 02:42:19', NULL),
(2, 'Appointment Confirm', 0, '2023-11-02 02:42:19', NULL),
(3, 'Appointment Cancel', 0, '2023-11-02 02:42:19', NULL),
(4, 'Invoice Generated', 0, '2023-11-02 02:42:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_apis`
--

CREATE TABLE `payment_apis` (
  `id` bigint UNSIGNED NOT NULL,
  `gateway_type` tinyint NOT NULL COMMENT '1=>Razorpay',
  `key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` int NOT NULL DEFAULT '0' COMMENT '0=>Active, 1=>Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persistences`
--

CREATE TABLE `persistences` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(2, 2, '0wbyF4eiBDfG9rNsgORt4g6YBwkGGp61', '2023-11-02 03:24:14', '2023-11-02 03:24:14'),
(56, 9, 'GqlvQroFUjCDsZQYjZKvoPC7TrrRUPd1', '2023-12-09 14:39:27', '2023-12-09 14:39:27'),
(57, 9, 'pyBEWdi9Q1cylxrWoLWAmQvHOG8t4iYD', '2023-12-09 15:15:49', '2023-12-09 15:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `symptoms` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnosis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` double NOT NULL COMMENT 'minute',
  `price` double NOT NULL DEFAULT '0',
  `commission_fee` double NOT NULL DEFAULT '0' COMMENT 'therapist commission fee',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `duration`, `price`, `commission_fee`, `status`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Happy Hour Refleksi 90 menit', 90, 110000, 22000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(2, 'Happy Hour Refleksi 120 menit', 120, 135000, 27000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(3, 'Regular Refleksi 90 menit', 90, 140000, 28000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(4, 'Regular Refleksi 120 menit', 120, 170000, 34000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(5, 'Body Massage Tradisional 90 menit', 90, 230000, 46000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(6, 'Body Massage Tradisional 120 menit', 120, 285000, 57000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(7, 'Body Massage Combination 90 menit', 90, 230000, 46000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(8, 'Body Massage Combination 120 menit', 120, 285000, 57000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(9, 'Body Massage Thai 90 menit', 90, 230000, 46000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(10, 'Body Massage Thai 120 menit', 120, 285000, 57000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(11, 'Sport Massage 90 menit', 90, 350000, 70000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(12, 'Sport Massage 120 menit', 120, 400000, 80000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(13, 'Aromatheraphy 90 menit', 90, 285000, 57000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(14, 'Aromatheraphy 120 menit', 120, 330000, 66000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(15, 'Candle massage 90 menit', 90, 285000, 57000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(16, 'Candle massage 120 menit', 120, 330000, 66000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(17, 'Body Scrub 90 menit', 90, 285000, 57000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(18, 'Body Scrub 120 menit', 120, 330000, 66000, 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` int NOT NULL DEFAULT '0' COMMENT '0=>fix,1=>percentage',
  `discount_value` double NOT NULL DEFAULT '0',
  `discount_max_value` double DEFAULT '0' COMMENT 'fix rate',
  `active_period_start` date NOT NULL DEFAULT '2023-11-02',
  `active_period_end` date NOT NULL DEFAULT '2023-11-02',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `is_reuse_voucher` tinyint NOT NULL COMMENT '0=>no,1=>yes',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `name`, `description`, `discount_type`, `discount_value`, `discount_max_value`, `active_period_start`, `active_period_end`, `status`, `is_reuse_voucher`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Grand Opening Promo 10%', 'Grand Opening Promo 10%', 0, 15000, 0, '2023-11-02', '2024-02-02', 1, 0, NULL, NULL, 0, '2023-11-02 02:42:20', NULL),
(2, 'Percobaan 5%', 'Percobaan 5%', 1, 5, 10000, '2023-11-12', '2024-02-12', 1, 1, NULL, NULL, 0, '2023-11-12 06:32:05', NULL),
(3, 'Tes reuse yes', 'Tes aja', 0, 1000, NULL, '2023-11-23', '2023-11-30', 1, 1, 1, NULL, 0, '2023-11-23 09:32:10', '2023-11-23 09:32:10'),
(4, 'a', 'HAHAH', 0, 1, NULL, '2023-11-23', '2023-11-30', 1, 1, 1, 1, 0, '2023-11-23 10:09:11', '2023-11-23 10:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `promo_vouchers`
--

CREATE TABLE `promo_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `promo_id` bigint UNSIGNED NOT NULL,
  `voucher_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_used` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_vouchers`
--

INSERT INTO `promo_vouchers` (`id`, `promo_id`, `voucher_code`, `created_at`, `updated_at`, `is_used`) VALUES
(1, 1, 'GO2023110261794', NULL, '2023-11-22 17:08:25', 0),
(2, 1, 'GO2023110212657', NULL, '2023-11-22 17:08:25', 1),
(3, 1, 'GO2023110203481', NULL, NULL, 0),
(4, 1, 'GO2023110232261', NULL, NULL, 0),
(5, 1, 'GO2023110252372', NULL, '2023-12-09 15:18:37', 1),
(6, 2, 'CB2023111275255', NULL, NULL, 0),
(7, 2, 'CB2023111233686', NULL, NULL, 0),
(8, 2, 'CB2023111242665', NULL, NULL, 0),
(9, 4, 'REU20231023001', '2023-11-23 10:09:11', '2023-11-23 10:09:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `receptionists`
--

CREATE TABLE `receptionists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ktp` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `place_of_birth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `rekening_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receptionists`
--

INSERT INTO `receptionists` (`id`, `user_id`, `ktp`, `gender`, `address`, `place_of_birth`, `birth_date`, `rekening_number`, `emergency_contact`, `emergency_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 4, '3208081508700007', 'Female', '789 Gerhold Run Suite 694\nPablofort, TX 91561-2698', 'Jakarta', '1991-03-17', '1234567', '085719865733', 'Abdiel', 1, 1, 1, '2023-11-02 02:42:19', '2023-12-09 14:16:13', 0),
(3, 9, '3208081903951116', 'Male', 'Kuningan Jabar', 'Kuningan', '1994-03-31', '123456654321', '089713131311', 'Dodo', 1, 1, 1, '2023-12-09 12:50:55', '2023-12-09 15:12:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `therapist_id` bigint UNSIGNED DEFAULT NULL,
  `invoice_detail_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_id`, `customer_name`, `phone_number`, `invoice_id`, `rating`, `comment`, `created_at`, `updated_at`, `created_by`, `updated_by`, `therapist_id`, `invoice_detail_id`) VALUES
(3, 6, NULL, '087712123321', 6, 3, 'aa', '2023-11-30 11:50:19', '2023-11-30 11:50:19', 1, NULL, 5, 16),
(4, 6, NULL, '087712123321', 6, 2, 'vvv', '2023-11-30 11:50:19', '2023-11-30 11:50:19', 1, NULL, 2, 17),
(5, 6, NULL, '087712123321', 7, 4, 'Bagus enak', '2023-11-30 18:03:17', '2023-11-30 18:03:17', 1, NULL, 5, 13);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '{\"therapist.list\":true,\"therapist.create\":true,\"therapist.view\":true,\"therapist.update\":true,\"therapist.delete\":true,\"therapist.time_edit\":true,\"profile.update\":true,\"customer.list\":true,\"customer.create\":true,\"customer.update\":true,\"customer.delete\":true,\"customer.view\":true,\"receptionist.list\":true,\"receptionist.create\":true,\"receptionist.update\":true,\"receptionist.delete\":true,\"receptionist.view\":true,\"appointment.list\":true,\"appointment.status\":true,\"prescription.show\":true,\"invoice.show\":true,\"api.create\":true,\"api.list\":true,\"api.delete\":true,\"api.update\":true,\"setting.edit\":true,\"membership.list\":true,\"membership.create\":true,\"membership.update\":true,\"membership.delete\":true,\"product.list\":true,\"product.create\":true,\"product.update\":true,\"product.delete\":true,\"room.list\":true,\"room.create\":true,\"room.update\":true,\"room.delete\":true,\"promo.list\":true,\"promo.show\":true,\"promo.create\":true,\"promo.update\":true,\"promo.delete\":true,\"transaction.list\":true,\"transaction.show\":true,\"transaction.create\":true,\"transaction.update\":true,\"transaction.delete\":true,\"invoice.list\":true,\"invoice.create\":true,\"invoice.update\":true,\"invoice.delete\":true,\"invoice.edit\":true,\"invoice.invoice_pdf\":true,\"invoice.review\":true,\"customermember.list\":true,\"customermember.create\":true,\"customermember.update\":true,\"customermember.delete\":true,\"report.filter\":true,\"report.view\":true}', '2023-11-02 02:42:18', '2023-11-02 02:42:18'),
(2, 'therapist', 'Therapist', '{\"receptionist.list\":true,\"therapist.time_edit\":true,\"therapist.delete\":true,\"profile.update\":true,\"customer.list\":true,\"customer.create\":true,\"customer.update\":true,\"customer.delete\":true,\"customer.view\":true,\"appointment.list\":true,\"appointment.create\":true,\"appointment.status\":true,\"prescription.list\":true,\"prescription.create\":true,\"prescription.update\":true,\"prescription.delete\":true,\"prescription.show\":true,\"invoice.show\":true,\"invoice.list\":true,\"invoice.create\":true,\"invoice.update\":true,\"invoice.delete\":true,\"invoice.edit\":true}', '2023-11-02 02:42:18', '2023-11-02 02:42:18'),
(3, 'receptionist', 'Receptionist', '{\"therapist.list\":true,\"therapist.create\":true,\"therapist.view\":true,\"therapist.update\":true,\"therapist.delete\":true,\"therapist.time_edit\":true,\"profile.update\":true,\"customer.list\":true,\"customer.create\":true,\"customer.update\":true,\"customer.delete\":true,\"customer.view\":true,\"receptionist.list\":true,\"receptionist.create\":true,\"receptionist.update\":true,\"receptionist.delete\":true,\"receptionist.view\":true,\"appointment.list\":true,\"appointment.status\":true,\"prescription.show\":true,\"invoice.show\":true,\"api.create\":true,\"api.list\":true,\"api.delete\":true,\"api.update\":true,\"setting.edit\":true,\"membership.list\":true,\"membership.create\":true,\"membership.update\":true,\"membership.delete\":true,\"transaction.list\":true,\"transaction.show\":true,\"transaction.create\":true,\"transaction.update\":true,\"transaction.delete\":true,\"invoice.list\":true,\"invoice.create\":true,\"invoice.update\":true,\"invoice.delete\":true,\"invoice.edit\":true,\"invoice.invoice_pdf\":true,\"invoice.review\":true,\"customermember.list\":true,\"customermember.create\":true,\"customermember.update\":true,\"customermember.delete\":true}', '2023-11-02 02:42:18', '2023-11-02 02:42:18'),
(4, 'customer', 'Customer', '{\"therapist.list\":true,\"profile.update\":true,\"customer-appointment.list\":true,\"appointment.create\":true,\"appointment.status\":true}', '2023-11-02 02:42:18', '2023-11-02 02:42:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `user_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(2, 2, '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(3, 4, '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(4, 3, '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(5, 2, '2023-11-09 12:43:40', '2023-11-09 12:43:40'),
(6, 4, '2023-11-12 14:42:18', '2023-11-12 14:42:18'),
(7, 4, '2023-11-17 13:37:33', '2023-11-17 13:37:33'),
(9, 3, '2023-12-09 12:50:55', '2023-12-09 12:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`, `status`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Room 301', 'Room 301', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(2, 'Room 302', 'Room 302', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(3, 'Room 303', 'Room 303', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(4, 'Room 305', 'Room 305', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(5, 'Room 306', 'Room 306', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(6, 'Room 307', 'Room 307', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(7, 'Room 308', 'Room 308', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(8, 'Room 309', 'Room 309', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(9, 'Room 310', 'Room 310', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(10, 'Room 311', 'Room 311', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(11, 'Room 312', 'Room 312', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(12, 'Room 315', 'Room 315', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(13, 'VIP 1', 'VIP 1', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(14, 'VIP 2', 'VIP 2', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(15, 'VIP 3', 'VIP 3', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL),
(16, 'VIP 5', 'VIP 5', 1, NULL, NULL, 0, '2023-11-02 02:42:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_reports`
--

CREATE TABLE `test_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `prescription_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `therapists`
--

CREATE TABLE `therapists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ktp` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_of_birth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rekening_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slot_time` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapists`
--

INSERT INTO `therapists` (`id`, `user_id`, `ktp`, `gender`, `place_of_birth`, `birth_date`, `address`, `rekening_number`, `emergency_contact`, `emergency_name`, `slot_time`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 2, '3208081505900006', 'Male', 'Jakarta', '1998-01-18', 'Jakarta', '1234567', '085711142471', 'Schultz', 25, 1, 1, 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', 0),
(2, 5, '3208081903950006', 'Male', 'Kuningan', '1993-03-03', 'Kuningan', '123456654321', '089713131312', 'Dodo', NULL, 1, 1, 1, '2023-11-09 12:43:40', '2023-11-09 12:43:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `therapist_available_days`
--

CREATE TABLE `therapist_available_days` (
  `id` bigint UNSIGNED NOT NULL,
  `therapist_id` bigint UNSIGNED NOT NULL,
  `sun` tinyint NOT NULL DEFAULT '0' COMMENT '0=>not available,1=>available',
  `mon` tinyint NOT NULL DEFAULT '0' COMMENT '0=>not available,1=>available',
  `tue` tinyint NOT NULL DEFAULT '0' COMMENT '0=>not available,1=>available',
  `wen` tinyint NOT NULL DEFAULT '0' COMMENT '0=>not available,1=>available',
  `thu` tinyint NOT NULL DEFAULT '0' COMMENT '0=>not available,1=>available',
  `fri` tinyint NOT NULL DEFAULT '0' COMMENT '0=>not available,1=>available',
  `sat` tinyint NOT NULL DEFAULT '0' COMMENT '0=>not available,1=>available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapist_available_days`
--

INSERT INTO `therapist_available_days` (`id`, `therapist_id`, `sun`, `mon`, `tue`, `wen`, `thu`, `fri`, `sat`, `created_at`, `updated_at`) VALUES
(1, 2, 0, 0, 0, 0, 0, 0, 0, '2023-11-02 02:42:19', '2023-11-02 02:42:19'),
(2, 5, 0, 1, 1, 1, 0, 0, 0, '2023-11-09 12:43:40', '2023-11-09 12:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `therapist_available_slots`
--

CREATE TABLE `therapist_available_slots` (
  `id` bigint UNSIGNED NOT NULL,
  `therapist_id` bigint UNSIGNED NOT NULL,
  `therapist_available_time_id` bigint UNSIGNED NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapist_available_slots`
--

INSERT INTO `therapist_available_slots` (`id`, `therapist_id`, `therapist_available_time_id`, `from`, `to`, `status`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 2, 1, '10:00:00', '12:30:00', 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', 0),
(2, 2, 1, '16:00:00', '17:30:00', 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `therapist_available_times`
--

CREATE TABLE `therapist_available_times` (
  `id` bigint UNSIGNED NOT NULL,
  `therapist_id` bigint UNSIGNED NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>active,1=>inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapist_available_times`
--

INSERT INTO `therapist_available_times` (`id`, `therapist_id`, `from`, `to`, `status`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 2, '10:00:00', '17:30:00', 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `therapist_total_v`
-- (See below for the actual view)
--
CREATE TABLE `therapist_total_v` (
`therapist_name` varchar(101)
,`phone_number` varchar(20)
,`email` varchar(100)
,`ktp` varchar(16)
,`gender` enum('Male','Female')
,`place_of_birth` varchar(50)
,`birth_date` date
,`address` text
,`rekening_number` varchar(20)
,`emergency_name` varchar(100)
,`emergency_contact` varchar(20)
,`status` tinyint
,`register_date` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE `throttle` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2023-11-02 03:33:52', '2023-11-02 03:33:52'),
(2, NULL, 'ip', '127.0.0.1', '2023-11-02 03:33:52', '2023-11-02 03:33:52'),
(3, NULL, 'global', NULL, '2023-11-07 15:07:02', '2023-11-07 15:07:02'),
(4, NULL, 'ip', '127.0.0.1', '2023-11-07 15:07:02', '2023-11-07 15:07:02'),
(5, 1, 'user', NULL, '2023-11-07 15:07:02', '2023-11-07 15:07:02'),
(6, NULL, 'global', NULL, '2023-11-17 12:23:28', '2023-11-17 12:23:28'),
(7, NULL, 'ip', '127.0.0.1', '2023-11-17 12:23:28', '2023-11-17 12:23:28'),
(8, 1, 'user', NULL, '2023-11-17 12:23:28', '2023-11-17 12:23:28'),
(9, NULL, 'global', NULL, '2023-11-19 07:51:08', '2023-11-19 07:51:08'),
(10, NULL, 'ip', '127.0.0.1', '2023-11-19 07:51:08', '2023-11-19 07:51:08'),
(11, 1, 'user', NULL, '2023-11-19 07:51:08', '2023-11-19 07:51:08'),
(12, NULL, 'global', NULL, '2023-11-21 07:33:20', '2023-11-21 07:33:20'),
(13, NULL, 'ip', '127.0.0.1', '2023-11-21 07:33:20', '2023-11-21 07:33:20'),
(14, 1, 'user', NULL, '2023-11-21 07:33:20', '2023-11-21 07:33:20'),
(15, NULL, 'global', NULL, '2023-12-09 14:39:03', '2023-12-09 14:39:03'),
(16, NULL, 'ip', '127.0.0.1', '2023-12-09 14:39:03', '2023-12-09 14:39:03'),
(17, 9, 'user', NULL, '2023-12-09 14:39:03', '2023-12-09 14:39:03'),
(18, NULL, 'global', NULL, '2023-12-09 14:39:11', '2023-12-09 14:39:11'),
(19, NULL, 'ip', '127.0.0.1', '2023-12-09 14:39:11', '2023-12-09 14:39:11'),
(20, 1, 'user', NULL, '2023-12-09 14:39:11', '2023-12-09 14:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `billing_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `signature` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'card',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_new`
--

CREATE TABLE `transaction_new` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `therapist_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_cost` double NOT NULL DEFAULT '0',
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `trans_history_sum_v`
-- (See below for the actual view)
--
CREATE TABLE `trans_history_sum_v` (
`therapist_id` bigint unsigned
,`therapist_name` varchar(101)
,`phone_number` varchar(20)
,`treatment_month_year` varchar(7)
,`duration` double
,`commission_fee` double
,`invoice_type` char(2)
,`rating` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `trans_history_v`
-- (See below for the actual view)
--
CREATE TABLE `trans_history_v` (
`customer_id` bigint unsigned
,`customer_name` varchar(101)
,`customer_phone` varchar(20)
,`email` varchar(100)
,`invoice_id` bigint unsigned
,`invoice_code` varchar(20)
,`invoice_date` timestamp
,`treatment_date` date
,`payment_mode` varchar(191)
,`payment_status` varchar(191)
,`note` varchar(191)
,`is_member` varchar(3)
,`use_member` varchar(3)
,`member_plan` varchar(191)
,`voucher_code` varchar(191)
,`total_price` double
,`discount` double
,`grand_total` double
,`therapist_id` bigint unsigned
,`therapist_name` varchar(101)
,`therapist_phone` varchar(20)
,`room` varchar(191)
,`time_from` time
,`time_to` time
,`invoice_type` char(2)
,`old_data` char(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `profile_photo`, `email`, `password`, `created_by`, `updated_by`, `permissions`, `last_login`, `status`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'Super', 'Admin', '5142323114', 'avatar-5.jpg', 'admin@youliantang.com', '$2y$10$tGjMsXWRn3cyHNd0b9eulejup7p2DKzxzEJpULadyZV4foxvoEl2.', NULL, NULL, NULL, '2023-12-09 14:36:04', 1, '2023-11-02 02:42:18', '2023-12-09 14:36:04', 0),
(2, 'Aliyah', 'Schultz', '085713458326', 'Male_doctor.png', 'therapist@youliantang.com', '$2y$10$Bw.9dwojiIAgVrcogxqhzeft1wvnNJRLz/cPHctl4CWM2VIA7cbN2', NULL, NULL, NULL, '2023-11-02 03:24:14', 1, '2023-11-02 02:42:19', '2023-11-02 03:24:14', 0),
(3, 'Liam', 'Lubowitz', '085715710844', 'Male_patient.png', 'customer@example.com', '$2y$10$DPGYzWLVtl4S4nmJrJS.VeH2X2N3RLnY0Jz.AKmCv82SatQzFoJTC', NULL, NULL, NULL, NULL, 1, '2023-11-02 02:42:19', '2023-11-02 02:42:19', 0),
(4, 'Abdiel', 'Adams', '085718519933', 'Female_receptionist.png', 'receptionist@example.com', '$2y$10$/4wYfV5Zg7LflabEJimdXuKuXaLjmJGL8DnKvSke3XPgVfIchNtZe', NULL, NULL, NULL, NULL, 1, '2023-11-02 02:42:19', '2023-12-09 14:16:13', 0),
(5, 'Asep', 'Rosadin', '089713131313', NULL, 'asep@yahoo.com', '$2y$10$0YpujugdeJwGxtOXFRdLj.UdzF09p1uy3AcOzPe3iftbS7Ma1rdpO', 1, 1, NULL, NULL, 1, '2023-11-09 12:43:40', '2023-11-09 12:43:40', 0),
(6, 'Asep', 'Saepulloh', '087712123321', NULL, 'asep17@gmail.com', '$2y$10$INNF0QP4wGhh5.VEf00Mp.eVS07mTlbifxDR52JFHdXyLBDXV9aVG', 1, 1, NULL, NULL, 1, '2023-11-12 14:42:18', '2023-11-12 14:42:18', 0),
(7, 'Dadis', 'Kamal', '089713131321', NULL, 'dadi@example.com', '$2y$10$6nGm5EuBuzFnV8qgFEmd..p9Dz9qf2LgDk87VGlrZmlcdyLAOMlsO', 1, 1, NULL, NULL, 1, '2023-11-17 13:37:33', '2023-11-30 11:32:02', 0),
(9, 'Adi', 'Hidayat', '089713131333', NULL, 'adi.hidayat@gmail.com', '$2y$10$SWsQPfDCr2ConMJxJp0syeQaKsvgV.bkcSxfDCa/TaRYq1O/jbrIa', 1, 9, NULL, '2023-12-09 15:15:49', 1, '2023-12-09 12:50:55', '2023-12-09 15:15:49', 0);

-- --------------------------------------------------------

--
-- Structure for view `customer_regist_v`
--
DROP TABLE IF EXISTS `customer_regist_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customer_regist_v`  AS SELECT concat(coalesce(`u`.`first_name`,''),' ',coalesce(`u`.`last_name`,'')) AS `customer_name`, `u`.`phone_number` AS `phone_number`, `u`.`email` AS `email`, `u`.`created_at` AS `register_date`, `c`.`place_of_birth` AS `place_of_birth`, `c`.`birth_date` AS `birth_date`, `c`.`gender` AS `gender`, `c`.`address` AS `address`, `c`.`emergency_name` AS `emergency_name`, `c`.`emergency_contact` AS `emergency_contact`, (case when (coalesce(`cm`.`id`,0) = 0) then 0 else 1 end) AS `is_member`, (case when (`c`.`status` = 0) then 'Non Active' when (`c`.`status` = 1) then 'Active' else NULL end) AS `customer_status`, `m`.`name` AS `member_plan`, (case when (`cm`.`status` = 0) then 'Non Active' when (`cm`.`status` = 1) then 'Active' else NULL end) AS `member_status`, `cm`.`created_at` AS `start_member`, `cm`.`expired_date` AS `expired_date` FROM (((`customers` `c` join `users` `u` on((`u`.`id` = `c`.`user_id`))) left join `customer_members` `cm` on(((`cm`.`customer_id` = `u`.`id`) and (`cm`.`is_deleted` = 0)))) left join `memberships` `m` on((`m`.`id` = `cm`.`membership_id`))) WHERE (`c`.`is_deleted` = 0)  ;

-- --------------------------------------------------------

--
-- Structure for view `therapist_total_v`
--
DROP TABLE IF EXISTS `therapist_total_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `therapist_total_v`  AS SELECT concat(coalesce(`u`.`first_name`,''),' ',coalesce(`u`.`last_name`,'')) AS `therapist_name`, `u`.`phone_number` AS `phone_number`, `u`.`email` AS `email`, `t`.`ktp` AS `ktp`, `t`.`gender` AS `gender`, `t`.`place_of_birth` AS `place_of_birth`, `t`.`birth_date` AS `birth_date`, `t`.`address` AS `address`, `t`.`rekening_number` AS `rekening_number`, `t`.`emergency_name` AS `emergency_name`, `t`.`emergency_contact` AS `emergency_contact`, `t`.`status` AS `status`, `u`.`created_at` AS `register_date` FROM (`therapists` `t` join `users` `u` on((`u`.`id` = `t`.`user_id`))) WHERE (`u`.`is_deleted` = 0)  ;

-- --------------------------------------------------------

--
-- Structure for view `trans_history_sum_v`
--
DROP TABLE IF EXISTS `trans_history_sum_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `trans_history_sum_v`  AS SELECT `x`.`therapist_id` AS `therapist_id`, `x`.`therapist_name` AS `therapist_name`, `x`.`phone_number` AS `phone_number`, `x`.`treatment_month_year` AS `treatment_month_year`, `x`.`duration` AS `duration`, `x`.`commission_fee` AS `commission_fee`, `x`.`invoice_type` AS `invoice_type`, `x`.`rating` AS `rating` FROM (select `t`.`id` AS `therapist_id`,concat(coalesce(`t`.`first_name`,''),' ',coalesce(`t`.`last_name`,'')) AS `therapist_name`,`t`.`phone_number` AS `phone_number`,date_format(`i`.`treatment_date`,'%m-%Y') AS `treatment_month_year`,`p`.`duration` AS `duration`,`p`.`commission_fee` AS `commission_fee`,`i`.`invoice_type` AS `invoice_type`,coalesce(`r`.`rating`,0) AS `rating` from (((((`invoices` `i` join `invoice_details` `id` on(((`id`.`invoice_id` = `i`.`id`) and (`id`.`is_deleted` = 0) and (`id`.`status` = 1)))) join `users` `c` on((`c`.`id` = `i`.`customer_id`))) join `users` `t` on((`t`.`id` = `id`.`therapist_id`))) join `products` `p` on((`p`.`id` = `id`.`product_id`))) left join `reviews` `r` on(((`r`.`invoice_id` = `i`.`id`) and (`r`.`invoice_detail_id` = `id`.`id`) and (`r`.`therapist_id` = `id`.`therapist_id`)))) where ((`i`.`old_data` = 'N') and (`i`.`is_deleted` = 0) and (`i`.`status` = 1)) union select `t`.`id` AS `therapist_id`,concat(coalesce(`t`.`first_name`,''),' ',coalesce(`t`.`last_name`,'')) AS `therapist_name`,`t`.`phone_number` AS `phone_number`,date_format(`i`.`treatment_date`,'%m-%Y') AS `treatment_month_year`,`p`.`duration` AS `duration`,`p`.`commission_fee` AS `commission_fee`,`i`.`invoice_type` AS `invoice_type`,0 AS `rating` from ((((`invoices` `i` join `invoice_details` `id` on(((`id`.`invoice_id` = `i`.`id`) and (`id`.`is_deleted` = 0) and (`id`.`status` = 1)))) join `users` `c` on((lower(concat(coalesce(`c`.`first_name`,''),' ',coalesce(`c`.`last_name`,''))) = lower(`i`.`customer_name`)))) join `users` `t` on((lower(concat(coalesce(`t`.`first_name`,''),' ',coalesce(`t`.`last_name`,''))) = lower(`i`.`therapist_name`)))) join `products` `p` on((lower(`p`.`name`) = lower(`id`.`title`)))) where ((`i`.`old_data` = 'Y') and (`i`.`is_deleted` = 0) and (`i`.`status` = 1))) AS `x``x`  ;

-- --------------------------------------------------------

--
-- Structure for view `trans_history_v`
--
DROP TABLE IF EXISTS `trans_history_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `trans_history_v`  AS SELECT `x`.`customer_id` AS `customer_id`, `x`.`customer_name` AS `customer_name`, `x`.`customer_phone` AS `customer_phone`, `x`.`email` AS `email`, `x`.`invoice_id` AS `invoice_id`, `x`.`invoice_code` AS `invoice_code`, `x`.`invoice_date` AS `invoice_date`, `x`.`treatment_date` AS `treatment_date`, `x`.`payment_mode` AS `payment_mode`, `x`.`payment_status` AS `payment_status`, `x`.`note` AS `note`, `x`.`is_member` AS `is_member`, `x`.`use_member` AS `use_member`, `x`.`member_plan` AS `member_plan`, `x`.`voucher_code` AS `voucher_code`, `x`.`total_price` AS `total_price`, `x`.`discount` AS `discount`, `x`.`grand_total` AS `grand_total`, `x`.`therapist_id` AS `therapist_id`, `x`.`therapist_name` AS `therapist_name`, `x`.`therapist_phone` AS `therapist_phone`, `x`.`room` AS `room`, `x`.`time_from` AS `time_from`, `x`.`time_to` AS `time_to`, `x`.`invoice_type` AS `invoice_type`, `x`.`old_data` AS `old_data` FROM (select `c`.`id` AS `customer_id`,concat(coalesce(`c`.`first_name`,''),' ',coalesce(`c`.`last_name`,'')) AS `customer_name`,`c`.`phone_number` AS `customer_phone`,`c`.`email` AS `email`,`i`.`id` AS `invoice_id`,`i`.`invoice_code` AS `invoice_code`,`i`.`created_at` AS `invoice_date`,`i`.`treatment_date` AS `treatment_date`,`i`.`payment_mode` AS `payment_mode`,`i`.`payment_status` AS `payment_status`,`i`.`note` AS `note`,(case when (coalesce(`i`.`is_member`,0) = 0) then 'No' else 'Yes' end) AS `is_member`,(case when (coalesce(`i`.`use_member`,0) = 0) then 'No' else 'Yes' end) AS `use_member`,`i`.`member_plan` AS `member_plan`,`i`.`voucher_code` AS `voucher_code`,`i`.`total_price` AS `total_price`,`i`.`discount` AS `discount`,`i`.`grand_total` AS `grand_total`,NULL AS `therapist_id`,NULL AS `therapist_name`,NULL AS `therapist_phone`,NULL AS `room`,NULL AS `time_from`,NULL AS `time_to`,`i`.`invoice_type` AS `invoice_type`,`i`.`old_data` AS `old_data` from (`invoices` `i` join `users` `c` on((`c`.`id` = `i`.`customer_id`))) where ((`i`.`old_data` = 'N') and (`i`.`is_deleted` = 0) and (`i`.`status` = 1)) union select `c`.`id` AS `customer_id`,concat(coalesce(`c`.`first_name`,''),' ',coalesce(`c`.`last_name`,'')) AS `customer_name`,`c`.`phone_number` AS `customer_phone`,`c`.`email` AS `email`,`i`.`id` AS `invoice_id`,`i`.`invoice_code` AS `invoice_code`,`i`.`created_at` AS `invoice_date`,`i`.`treatment_date` AS `treatment_date`,`i`.`payment_mode` AS `payment_mode`,`i`.`payment_status` AS `payment_status`,`i`.`note` AS `note`,(case when (coalesce(`i`.`is_member`,0) = 0) then 'No' else 'Yes' end) AS `is_member`,(case when (coalesce(`i`.`use_member`,0) = 0) then 'No' else 'Yes' end) AS `use_member`,`i`.`member_plan` AS `member_plan`,`i`.`voucher_code` AS `voucher_code`,`i`.`total_price` AS `total_price`,`i`.`discount` AS `discount`,`i`.`grand_total` AS `grand_total`,`t`.`id` AS `therapist_id`,concat(coalesce(`t`.`first_name`,''),' ',coalesce(`t`.`last_name`,'')) AS `therapist_name`,`t`.`phone_number` AS `therapist_phone`,`i`.`room` AS `room`,`i`.`treatment_time_from` AS `time_from`,`i`.`treatment_time_to` AS `time_to`,`i`.`invoice_type` AS `invoice_type`,`i`.`old_data` AS `old_data` from (((`invoices` `i` join `invoice_details` `id` on(((`id`.`invoice_id` = `i`.`id`) and (`id`.`is_deleted` = 0) and (`id`.`status` = 1)))) join `users` `c` on((lower(concat(coalesce(`c`.`first_name`,''),' ',coalesce(`c`.`last_name`,''))) = lower(`i`.`customer_name`)))) join `users` `t` on((lower(concat(coalesce(`t`.`first_name`,''),' ',coalesce(`t`.`last_name`,''))) = lower(`i`.`therapist_name`)))) where ((`i`.`old_data` = 'Y') and (`i`.`is_deleted` = 0) and (`i`.`status` = 1))) AS `x` ORDER BY `x`.`invoice_date` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_booked_by_foreign` (`booked_by`),
  ADD KEY `appointments_appointment_for_foreign` (`appointment_for`),
  ADD KEY `appointments_appointment_with_foreign` (`appointment_with`),
  ADD KEY `appointments_available_time_foreign` (`available_time`),
  ADD KEY `appointments_available_slot_foreign` (`available_slot`);

--
-- Indexes for table `app_setting`
--
ALTER TABLE `app_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indexes for table `customer_members`
--
ALTER TABLE `customer_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_members_created_by_foreign` (`created_by`),
  ADD KEY `customer_members_updated_by_foreign` (`updated_by`),
  ADD KEY `customer_members_customer_id_foreign` (`customer_id`),
  ADD KEY `customer_members_membership_id_foreign` (`membership_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_created_by_foreign` (`created_by`),
  ADD KEY `invoices_updated_by_foreign` (`updated_by`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_details_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_details_product_id_foreign` (`product_id`),
  ADD KEY `invoice_details_therapist_id_foreign` (`therapist_id`);

--
-- Indexes for table `invoice_setting`
--
ALTER TABLE `invoice_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_infos`
--
ALTER TABLE `medical_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_infos_user_id_foreign` (`user_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicines_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memberships_created_by_foreign` (`created_by`),
  ADD KEY `memberships_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notification_type_id_foreign` (`notification_type_id`),
  ADD KEY `notifications_from_user_foreign` (`from_user`),
  ADD KEY `notifications_to_user_foreign` (`to_user`);

--
-- Indexes for table `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_apis`
--
ALTER TABLE `payment_apis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescriptions_customer_id_foreign` (`customer_id`),
  ADD KEY `prescriptions_appointment_id_foreign` (`appointment_id`),
  ADD KEY `prescriptions_created_by_foreign` (`created_by`),
  ADD KEY `prescriptions_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promos_created_by_foreign` (`created_by`),
  ADD KEY `promos_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `promo_vouchers`
--
ALTER TABLE `promo_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_vouchers_promo_id_foreign` (`promo_id`);

--
-- Indexes for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receptionists_user_id_foreign` (`user_id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_created_by_foreign` (`created_by`),
  ADD KEY `reviews_updated_by_foreign` (`updated_by`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`),
  ADD KEY `reviews_invoice_id_foreign` (`invoice_id`),
  ADD KEY `reviews_therapist_id_foreign` (`therapist_id`),
  ADD KEY `reviews_invoice_detail_id_foreign` (`invoice_detail_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_created_by_foreign` (`created_by`),
  ADD KEY `rooms_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `test_reports`
--
ALTER TABLE `test_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_reports_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `therapists`
--
ALTER TABLE `therapists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `therapists_user_id_foreign` (`user_id`);

--
-- Indexes for table `therapist_available_days`
--
ALTER TABLE `therapist_available_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `therapist_available_days_therapist_id_foreign` (`therapist_id`);

--
-- Indexes for table `therapist_available_slots`
--
ALTER TABLE `therapist_available_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `therapist_available_slots_therapist_id_foreign` (`therapist_id`),
  ADD KEY `therapist_available_slots_therapist_available_time_id_foreign` (`therapist_available_time_id`);

--
-- Indexes for table `therapist_available_times`
--
ALTER TABLE `therapist_available_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `therapist_available_times_therapist_id_foreign` (`therapist_id`);

--
-- Indexes for table `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_new`
--
ALTER TABLE `transaction_new`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activations`
--
ALTER TABLE `activations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_setting`
--
ALTER TABLE `app_setting`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_members`
--
ALTER TABLE `customer_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `invoice_setting`
--
ALTER TABLE `invoice_setting`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medical_infos`
--
ALTER TABLE `medical_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_apis`
--
ALTER TABLE `payment_apis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promo_vouchers`
--
ALTER TABLE `promo_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `receptionists`
--
ALTER TABLE `receptionists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `test_reports`
--
ALTER TABLE `test_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `therapists`
--
ALTER TABLE `therapists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `therapist_available_days`
--
ALTER TABLE `therapist_available_days`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `therapist_available_slots`
--
ALTER TABLE `therapist_available_slots`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `therapist_available_times`
--
ALTER TABLE `therapist_available_times`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_new`
--
ALTER TABLE `transaction_new`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_appointment_for_foreign` FOREIGN KEY (`appointment_for`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_appointment_with_foreign` FOREIGN KEY (`appointment_with`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_available_slot_foreign` FOREIGN KEY (`available_slot`) REFERENCES `therapist_available_slots` (`id`),
  ADD CONSTRAINT `appointments_available_time_foreign` FOREIGN KEY (`available_time`) REFERENCES `therapist_available_times` (`id`),
  ADD CONSTRAINT `appointments_booked_by_foreign` FOREIGN KEY (`booked_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `customer_members`
--
ALTER TABLE `customer_members`
  ADD CONSTRAINT `customer_members_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customer_members_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customer_members_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`),
  ADD CONSTRAINT `customer_members_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `invoice_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `invoice_details_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `medical_infos`
--
ALTER TABLE `medical_infos`
  ADD CONSTRAINT `medical_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `memberships_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `memberships_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_from_user_foreign` FOREIGN KEY (`from_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notifications_notification_type_id_foreign` FOREIGN KEY (`notification_type_id`) REFERENCES `notification_types` (`id`),
  ADD CONSTRAINT `notifications_to_user_foreign` FOREIGN KEY (`to_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `prescriptions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `prescriptions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `prescriptions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `promos`
--
ALTER TABLE `promos`
  ADD CONSTRAINT `promos_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `promos_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `promo_vouchers`
--
ALTER TABLE `promo_vouchers`
  ADD CONSTRAINT `promo_vouchers_promo_id_foreign` FOREIGN KEY (`promo_id`) REFERENCES `promos` (`id`);

--
-- Constraints for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD CONSTRAINT `receptionists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_invoice_detail_id_foreign` FOREIGN KEY (`invoice_detail_id`) REFERENCES `invoice_details` (`id`),
  ADD CONSTRAINT `reviews_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `reviews_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rooms_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `test_reports`
--
ALTER TABLE `test_reports`
  ADD CONSTRAINT `test_reports_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `therapists`
--
ALTER TABLE `therapists`
  ADD CONSTRAINT `therapists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `therapist_available_days`
--
ALTER TABLE `therapist_available_days`
  ADD CONSTRAINT `therapist_available_days_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `therapist_available_slots`
--
ALTER TABLE `therapist_available_slots`
  ADD CONSTRAINT `therapist_available_slots_therapist_available_time_id_foreign` FOREIGN KEY (`therapist_available_time_id`) REFERENCES `therapist_available_times` (`id`),
  ADD CONSTRAINT `therapist_available_slots_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `therapist_available_times`
--
ALTER TABLE `therapist_available_times`
  ADD CONSTRAINT `therapist_available_times_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_expired_status_daily` ON SCHEDULE EVERY 1 DAY STARTS '2023-11-12 00:01:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
  UPDATE customer_members
  SET status = 0
  WHERE expired_date <= NOW() AND status = 1;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
