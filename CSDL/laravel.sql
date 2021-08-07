-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2021 at 09:17 AM
-- Server version: 5.7.20
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `adress`, `phone`, `fax`, `created_at`, `updated_at`) VALUES
(1, 'Nguyen Van A', '80 Ngõ 82 Yên Lãng, Láng Hạ, Đống Đa, Hà Nội, Việt Nam', '09871231234', '09871231234', NULL, NULL),
(2, 'Cong Ty TNHH ThaiVu', 'Trái Ninh, Hải Phong, Hải Hậu, Nam Định 420000, Việt Nam', '0968251593', '09873431234', NULL, NULL),
(3, 'Cong Ty TNHH ThanhCong', '59a Nguyễn Thái Học, Street, Hà Giang, 310000, Việt Nam', '09887231234', '09887231234', NULL, NULL),
(4, 'Cong Ty TNHH CamTu', 'Cao Bồ, Vị Xuyên, Hà Giang, Việt Nam', '09871128634', '09871128634', NULL, NULL),
(5, 'Cong Ty Nhua HoaBinh', 'Khu phố 6, Ninh Giang, Hải Dương, Việt Nam', '09823231234', '09823231234', NULL, NULL),
(6, 'Cong Ty Du Lich', 'Số 129 Hải Thượng Lãn Ông, P. An Tảo, Hưng Yên, Việt Nam', '09871121234', '09871121234', NULL, NULL),
(7, 'Cong Ty TNHH HaiDuong', 'Toà nhà HMTC TOWER, 22 Lý Tự Trọng, phường Bến Nghé', '09845231234', '09845231234', NULL, NULL),
(8, 'Cong Ty Moi Truong', 'Toà nhà 215-217 Trần Hưng Đạo, phường Cô Giang', '09871209234', '09871209234', NULL, NULL),
(9, 'Cong Ty VienThong', 'Cty 252 Cống Quỳnh, phường Phạm Ngũ Lão ', '09871231234', '09871231234', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estimate`
--

CREATE TABLE `estimate` (
  `id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estimate`
--

INSERT INTO `estimate` (`id`, `mota`, `created_at`, `updated_at`) VALUES
('126232328723838', 'mo ta', NULL, NULL),
('126232378723838', 'mo ta', NULL, NULL),
('126239371623838', 'mo ta', NULL, NULL),
('126239378723838', 'mo ta', NULL, NULL),
('126389371623838', 'mo ta', NULL, NULL),
('196232378723838', 'mo ta', NULL, NULL),
('196292378703838', 'mo ta', NULL, NULL),
('196292378723838', 'mo ta', NULL, NULL),
('196292378783838', 'mo ta', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `total` double(20,2) NOT NULL,
  `expire_date` datetime NOT NULL,
  `estimate_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `create_date`, `status`, `total`, `expire_date`, `estimate_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, '2021-08-05 15:16:51', 1, 230.00, '2021-08-19 15:16:51', '126389371623838', 3, NULL, NULL),
(2, '2021-08-05 15:16:51', 0, 2300.00, '2021-08-19 15:16:51', '126389371623838', 5, NULL, NULL),
(3, '2021-08-05 15:16:51', 1, 2300.00, '2021-08-09 15:30:16', '196292378703838', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `price` double(20,2) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`invoice_id`, `item_id`, `quantity`, `price`, `amount`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 300.00, 1500.00, NULL, NULL),
(2, 2, 5, 300.00, 1500.00, NULL, NULL),
(3, 2, 5, 300.00, 1500.00, NULL, NULL),
(3, 6, 1, 2300.00, 2300.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(20,2) NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `price`, `project_id`, `created_at`, `updated_at`) VALUES
(2, 'item name 2', 300.00, 2, NULL, NULL),
(5, 'item tesst', 56.00, 2, NULL, NULL),
(6, 'item 23', 2300.00, 2, NULL, NULL),
(7, 'item 34', 2399.00, 2, NULL, NULL),
(8, 'item 35', 1230.00, 2, NULL, NULL),
(9, 'item 36', 3499.00, 12, NULL, NULL),
(10, 'item 37', 3430.00, 11, NULL, NULL),
(11, 'Item 45', 400.00, 18, NULL, NULL),
(12, 'item 40', 2399.00, 3, NULL, NULL),
(13, 'item 41', 1230.00, 4, NULL, NULL),
(15, 'item 40', 2399.00, 3, NULL, NULL),
(16, 'item 41', 1230.00, 4, NULL, NULL),
(17, 'item 42', 2399.00, 3, NULL, NULL),
(18, 'item 43', 1230.00, 6, NULL, NULL),
(19, 'item 44', 2399.00, 7, NULL, NULL),
(20, 'item 45', 1230.00, 8, NULL, NULL),
(21, 'item 50', 2399.00, 3, NULL, NULL),
(22, 'item 51', 1230.00, 4, NULL, NULL),
(23, 'item 52', 2399.00, 12, NULL, NULL),
(24, 'item 53', 1230.00, 6, NULL, NULL),
(25, 'item 54', 2399.00, 7, NULL, NULL),
(26, 'item 55', 1230.00, 8, NULL, NULL),
(27, 'item 56', 2399.00, 3, NULL, NULL),
(28, 'item 57', 1230.00, 4, NULL, NULL),
(29, 'item 58', 2399.00, 12, NULL, NULL),
(30, 'item 59', 1230.00, 6, NULL, NULL),
(31, 'item 60', 2399.00, 7, NULL, NULL),
(32, 'item 61', 1230.00, 8, NULL, NULL),
(33, 'item 62', 2399.00, 3, NULL, NULL),
(34, 'item 63', 1230.00, 4, NULL, NULL),
(35, 'item 64', 2399.00, 11, NULL, NULL),
(36, 'item 50', 2399.00, 3, NULL, NULL),
(37, 'item 51', 1230.00, 4, NULL, NULL),
(38, 'item 52', 2399.00, 12, NULL, NULL),
(39, 'item 53', 1230.00, 6, NULL, NULL),
(40, 'item 54', 2399.00, 7, NULL, NULL),
(41, 'item 55', 1230.00, 8, NULL, NULL),
(42, 'item 56', 2399.00, 3, NULL, NULL),
(43, 'item 57', 1230.00, 4, NULL, NULL),
(44, 'item 58', 2399.00, 12, NULL, NULL),
(45, 'item 59', 1230.00, 6, NULL, NULL),
(46, 'item 60', 2399.00, 7, NULL, NULL),
(47, 'item 61', 1230.00, 8, NULL, NULL),
(48, 'item 62', 2399.00, 3, NULL, NULL),
(49, 'item 63', 1230.00, 4, NULL, NULL),
(50, 'item 64', 2399.00, 11, NULL, NULL),
(51, 'item 65', 1230.00, 6, NULL, NULL),
(52, 'item 66', 2399.00, 7, NULL, NULL),
(53, 'item 67', 1230.00, 8, NULL, NULL),
(54, 'item 54', 2399.00, 7, NULL, NULL),
(55, 'item 55', 1230.00, 8, NULL, NULL),
(56, 'item 56', 2399.00, 3, NULL, NULL),
(57, 'item 57', 1230.00, 4, NULL, NULL),
(58, 'item 58', 2399.00, 12, NULL, NULL),
(59, 'item 59', 1230.00, 6, NULL, NULL),
(60, 'item 60', 2399.00, 7, NULL, NULL),
(61, 'item 61', 1230.00, 8, NULL, NULL),
(62, 'item 62', 2399.00, 3, NULL, NULL),
(63, 'item 63', 1230.00, 4, NULL, NULL),
(64, 'item 64', 2399.00, 11, NULL, NULL),
(65, 'item 65', 1230.00, 6, NULL, NULL),
(66, 'item 66', 2399.00, 7, NULL, NULL),
(67, 'item 67', 1230.00, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2021_08_02_140512_create_projects_table', 1),
(5, '2014_10_12_000000_create_users_table', 2),
(6, '2014_10_12_100000_create_password_resets_table', 2),
(7, '2019_08_19_000000_create_failed_jobs_table', 2),
(8, '2021_08_02_143051_create_project_table', 2),
(9, '2021_08_03_013326_create_item_table', 3),
(10, '2021_08_03_153433_create_customer_table', 4),
(11, '2021_08_03_162130_create_estimate_table', 5),
(12, '2021_08_04_032141_create_invoice_table', 6),
(13, '2021_08_04_070702_create_invoice_detail_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Project 2', NULL, NULL),
(3, 'Project 3', NULL, NULL),
(4, 'Project 4', NULL, NULL),
(6, 'Project 6', NULL, NULL),
(7, 'Project 7', NULL, NULL),
(8, 'Project 8', NULL, NULL),
(9, 'Project 9', NULL, NULL),
(10, 'Project 10', NULL, NULL),
(11, 'Project 11', NULL, NULL),
(12, 'Project 12', NULL, NULL),
(13, 'Project 13', NULL, NULL),
(14, 'Project 14', NULL, NULL),
(15, 'Project 15', NULL, NULL),
(16, 'Project 16', NULL, NULL),
(17, 'Project 17', NULL, NULL),
(18, 'Project 18', NULL, NULL),
(19, 'Project 19', NULL, NULL),
(20, 'Project 21', NULL, NULL),
(21, 'Project 22', NULL, NULL),
(22, 'Project 23', NULL, NULL),
(23, 'Project 24', NULL, NULL),
(24, 'Project 25', NULL, NULL),
(25, 'Project 26', NULL, NULL),
(26, 'Project 27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimate`
--
ALTER TABLE `estimate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_estimate_id_foreign` (`estimate_id`),
  ADD KEY `invoice_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`invoice_id`,`item_id`),
  ADD KEY `invoice_detail_item_id_foreign` (`item_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_project_id_foreign` (`project_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
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
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimate` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `invoice_detail_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_detail_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
