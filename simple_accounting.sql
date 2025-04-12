-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 09:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) NOT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `shaba` varchar(255) DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashboxes`
--

CREATE TABLE `cashboxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `responsible_person_id` bigint(20) UNSIGNED DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `min_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `max_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(49, '0001_01_01_000000_create_users_table', 1),
(50, '0001_01_01_000001_create_cache_table', 1),
(51, '0001_01_01_000002_create_jobs_table', 1),
(52, '2024_01_01_000000_create_people_table', 1),
(53, '2024_01_01_create_person_categories_table', 1),
(54, '2024_01_01_create_shareholders_table', 1),
(55, '2024_01_01_create_vendors_table', 1),
(56, '2024_04_05_create_transactions_table', 1),
(57, '2025_04_04_182728_create_accounts_table', 1),
(58, '2025_04_04_192322_create_products_table', 1),
(59, '2025_04_04_192323_create_banks_table', 1),
(60, '2025_04_04_192323_create_cashboxes_table', 1),
(61, '2025_04_04_192323_create_services_table', 1),
(62, '2025_04_04_192324_create_sales_table', 1),
(63, '2025_04_04_192329_create_purchases_table', 1),
(64, '2025_04_05_105420_add_status_to_people_table', 1),
(65, '2025_04_05_111601_update_people_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(6) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `national_code` varchar(10) DEFAULT NULL,
  `economic_code` varchar(12) DEFAULT NULL,
  `registration_number` varchar(20) DEFAULT NULL,
  `type` enum('individual','company') NOT NULL DEFAULT 'individual',
  `company_name` varchar(255) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'ایران',
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) NOT NULL DEFAULT 'general',
  `is_customer` tinyint(1) NOT NULL DEFAULT 0,
  `is_supplier` tinyint(1) NOT NULL DEFAULT 0,
  `is_employee` tinyint(1) NOT NULL DEFAULT 0,
  `is_shareholder` tinyint(1) NOT NULL DEFAULT 0,
  `credit_limit` decimal(20,2) NOT NULL DEFAULT 0.00,
  `opening_balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `code`, `title`, `first_name`, `last_name`, `display_name`, `national_code`, `economic_code`, `registration_number`, `type`, `company_name`, `mobile`, `phone`, `status`, `email`, `website`, `address`, `postal_code`, `country`, `state`, `city`, `category_id`, `is_customer`, `is_supplier`, `is_employee`, `is_shareholder`, `credit_limit`, `opening_balance`, `image`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '000001', NULL, 'علی', 'محمدی', NULL, NULL, NULL, NULL, 'individual', NULL, '09121234567', '02144556677', 1, 'ali.mohammadi@example.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 1, 0, 0, 0, 5000000.00, 1500000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(2, '000002', NULL, NULL, NULL, NULL, NULL, '411111111111', '12345', 'company', 'شرکت فناوری پیشرو', '09121111111', '02188776655', 1, 'info@pishro.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 0, 1, 0, 0, 10000000.00, -2000000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(3, '000003', NULL, 'مریم', 'حسینی', NULL, NULL, NULL, NULL, 'individual', NULL, '09129876543', '02166554433', 1, 'maryam.hosseini@example.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 1, 0, 0, 0, 3000000.00, 0.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(4, '000004', NULL, NULL, NULL, NULL, NULL, '422222222222', '54321', 'company', 'فروشگاه زنجیره‌ای ستاره', '09122222222', '02177889900', 1, 'info@setareh.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 1, 1, 0, 0, 15000000.00, 3000000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(5, '000005', NULL, 'رضا', 'کریمی', NULL, NULL, NULL, NULL, 'individual', NULL, '09123334444', '02133445566', 1, 'reza.karimi@example.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 0, 0, 1, 0, 2000000.00, -500000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(6, '000006', NULL, NULL, NULL, NULL, NULL, '433333333333', '98765', 'company', 'تولیدی صنعت گستر', '09123333333', '02155667788', 1, 'info@sanatgostar.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 0, 1, 0, 0, 20000000.00, 7000000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(7, '000007', NULL, 'زهرا', 'رضایی', NULL, NULL, NULL, NULL, 'individual', NULL, '09124445555', '02122334455', 1, 'zahra.rezaei@example.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 1, 0, 0, 0, 4000000.00, 1000000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(8, '000008', NULL, 'محمد', 'صادقی', NULL, NULL, NULL, NULL, 'individual', NULL, '09125556666', '02166778899', 1, 'mohammad.sadeghi@example.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 0, 0, 0, 1, 5000000.00, -1500000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(9, '000009', NULL, NULL, NULL, NULL, NULL, '444444444444', '24680', 'company', 'پخش دارو سلامت', '09124444444', '02144332211', 1, 'info@salamatpakhsh.com', NULL, NULL, NULL, 'ایران', NULL, NULL, '1', 0, 1, 0, 0, 25000000.00, -4000000.00, NULL, NULL, 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(10, '000010', NULL, 'فاطمه', 'احمدی', NULL, '0012345678', NULL, NULL, 'individual', NULL, '09126667777', '02188990011', 1, 'fateme.ahmadi@example.com', 'www.example.com', 'تهران، خیابان شریعتی، کوچه گلستان، پلاک 45', '1234567890', 'ایران', 'تهران', 'تهران', '1', 1, 0, 0, 0, 6000000.00, 2500000.00, NULL, 'مشتری دائمی فروشگاه', 1, '2025-04-05 08:10:01', '2025-04-05 08:10:01', NULL),
(41, '000011', NULL, 'سعید', 'رضایی', NULL, '0078901234', NULL, NULL, 'individual', NULL, '09127778888', '02177889900', 1, 'saeed.rezaei@example.com', NULL, 'خیابان شریعتی، کوچه گلستان، پلاک 45', '1234567810', 'ایران', 'تهران', 'تهران', '1', 1, 0, 0, 0, 7000000.00, 2000000.00, NULL, NULL, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(42, '000012', NULL, NULL, NULL, NULL, NULL, '455555555555', '13579', 'company', 'صنایع غذایی بهار', '09125555555', '02133445566', 1, 'info@bahar.com', 'www.bahar.com', 'شهرک صنعتی شمس‌آباد', '1234567811', 'ایران', 'تهران', 'تهران', '3', 0, 1, 0, 0, 30000000.00, 8000000.00, NULL, NULL, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(43, '000013', NULL, 'نرگس', 'کاظمی', NULL, '0089012345', NULL, NULL, 'individual', NULL, '09128889999', '02166778899', 1, 'narges.kazemi@example.com', NULL, 'جنت‌آباد، خیابان لاله، پلاک 67', '1234567812', 'ایران', 'تهران', 'تهران', '2', 1, 0, 0, 0, 4000000.00, -1000000.00, NULL, NULL, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(44, '000014', NULL, NULL, NULL, NULL, NULL, '466666666666', '97531', 'company', 'پخش دارویی سلامت', '09126666666', '02144556677', 1, 'info@salamatpakhsh.com', 'www.salamatpakhsh.com', 'خیابان آزادی، پلاک 89', '1234567813', 'ایران', 'تهران', 'تهران', '3', 0, 1, 0, 0, 50000000.00, 12000000.00, NULL, NULL, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(45, '000015', NULL, 'حسین', 'محمودی', NULL, '0090123456', NULL, NULL, 'individual', NULL, '09129990000', '02155667788', 1, 'hossein.mahmoudi@example.com', NULL, 'نارمک، خیابان گلبرگ، پلاک 12', '1234567814', 'ایران', 'تهران', 'تهران', '2', 1, 0, 0, 0, 9000000.00, 3500000.00, NULL, NULL, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(46, '000016', 'آقای', 'مهدی', 'شمس ابادی', NULL, NULL, NULL, NULL, 'individual', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'ایران', NULL, NULL, '9', 0, 0, 0, 0, 0.00, 0.00, NULL, NULL, 1, '2025-04-05 14:40:35', '2025-04-05 14:40:35', NULL),
(47, '000017', NULL, 'مصطفی', 'اکرادی', NULL, NULL, NULL, NULL, 'individual', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'ایران', NULL, NULL, '9', 0, 0, 0, 0, 0.00, 0.00, NULL, NULL, 1, '2025-04-05 15:14:23', '2025-04-05 15:14:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person_categories`
--

CREATE TABLE `person_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#000000',
  `icon` varchar(50) NOT NULL DEFAULT 'users',
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `person_categories`
--

INSERT INTO `person_categories` (`id`, `name`, `color`, `icon`, `order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'عمومی', '#4f46e5', 'users', 1, 1, '2025-04-05 12:58:19', '2025-04-05 12:58:19', NULL),
(9, 'مشتریان ویژه', '#059669', 'star', 2, 1, '2025-04-05 12:58:19', '2025-04-05 12:58:19', NULL),
(10, 'تامین‌کنندگان', '#dc2626', 'truck', 3, 1, '2025-04-05 12:58:19', '2025-04-05 12:58:19', NULL),
(11, 'عمومی', '#4f46e5', 'users', 1, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(12, 'مشتریان ویژه', '#059669', 'star', 2, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(13, 'تامین‌کنندگان', '#dc2626', 'truck', 3, 1, '2025-04-05 13:09:05', '2025-04-05 13:09:05', NULL),
(14, 'مشتری خودم', '#ff007b', 'users', 1, 1, '2025-04-05 09:43:59', '2025-04-05 09:43:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `min_quantity` int(11) NOT NULL DEFAULT 0,
  `current_quantity` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `itemable_type` varchar(255) NOT NULL,
  `itemable_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `itemable_type` varchar(255) NOT NULL,
  `itemable_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('peFm7LTiIfkr46GwjiBNfem5dxxotXWRXy3pGO99', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRXRJeDdpYkJTYTFQSXZ0bjF2Vk1qV0JnNVM4WktJM0VyUXRtUGdHTSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BlcnNvbnMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BlcnNvbnMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1743879533);

-- --------------------------------------------------------

--
-- Table structure for table `shareholders`
--

CREATE TABLE `shareholders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `person_id` bigint(20) UNSIGNED NOT NULL,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `share_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `investment_amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `person_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `date` datetime NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'مصطفی اکرادی', 'akradim@hotmail.com', NULL, '$2y$12$4bJ5CjV3oZxaBzT71mRHpuvK4ZOUSwWcQVz9lUCNpTb.0Cl0W7vkC', NULL, '2025-04-05 07:52:14', '2025-04-05 07:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `person_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_code` varchar(255) NOT NULL,
  `credit_limit` decimal(20,2) NOT NULL DEFAULT 0.00,
  `payment_terms` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_code_unique` (`code`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cashboxes`
--
ALTER TABLE `cashboxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cashboxes_responsible_person_id_foreign` (`responsible_person_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `people_code_unique` (`code`),
  ADD UNIQUE KEY `people_national_code_unique` (`national_code`);

--
-- Indexes for table `person_categories`
--
ALTER TABLE `person_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_invoice_number_unique` (`invoice_number`),
  ADD KEY `purchases_vendor_id_foreign` (`vendor_id`),
  ADD KEY `purchases_created_by_foreign` (`created_by`),
  ADD KEY `purchases_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_created_by_foreign` (`created_by`),
  ADD KEY `sales_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_code_unique` (`code`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shareholders`
--
ALTER TABLE `shareholders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shareholders_person_id_foreign` (`person_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_person_id_foreign` (`person_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_vendor_code_unique` (`vendor_code`),
  ADD KEY `vendors_person_id_foreign` (`person_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashboxes`
--
ALTER TABLE `cashboxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `person_categories`
--
ALTER TABLE `person_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shareholders`
--
ALTER TABLE `shareholders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cashboxes`
--
ALTER TABLE `cashboxes`
  ADD CONSTRAINT `cashboxes_responsible_person_id_foreign` FOREIGN KEY (`responsible_person_id`) REFERENCES `people` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `people` (`id`);

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `sales_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shareholders`
--
ALTER TABLE `shareholders`
  ADD CONSTRAINT `shareholders_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
