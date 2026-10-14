-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 14, 2026 at 04:13 PM
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
-- Database: `trinitymabati`
--

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
(1, '2026_09_22_162053_add_foreign_keys_to_su_product_label_table', 1),
(2, '2026_09_26_060639_add_default_uncategorized_product_category', 2),
(3, '2026_09_28_115518_add_is_default_to_su_product_categories_table', 3),
(4, '2026_10_13_110000_add_product_default_variant_options', 3),
(5, '2026_10_13_103000_seed_stone_coated_shingle_roofing_tiles', 4),
(6, '2026_10_13_113000_seed_stone_coated_classic_roofing_tiles', 5),
(7, '2026_10_13_120000_seed_stone_coated_roman_roofing_tiles', 6),
(8, '2026_10_13_123000_seed_box_profile_four_products', 7),
(9, '2026_10_13_130000_add_box_profile_tile_red_28g_glossy_variant', 8),
(10, '2026_10_13_130000_seed_corrugated_roofing_sheets', 9),
(11, '2026_10_13_160000_create_client_testimonials_and_projects', 10),
(12, '2026_10_13_150000_allow_guest_quotation_requests', 11),
(13, '2026_10_14_160000_fix_su_contact_messages_columns', 12),
(14, '2026_10_14_170000_wipe_products_quotations_and_orders', 13),
(15, '2026_10_14_171000_rebuild_product_categories (1)', 13),
(16, '2026_10_14_172000_seed_trinity_catalogue_2026', 13);

-- --------------------------------------------------------

--
-- Table structure for table `su_abandoned_carts`
--

CREATE TABLE `su_abandoned_carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cart_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cart_data`)),
  `last_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `recovered` tinyint(1) NOT NULL DEFAULT 0,
  `reminder_sent` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_abandoned_cart_logs`
--

CREATE TABLE `su_abandoned_cart_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `sent_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_banners`
--

CREATE TABLE `su_banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `placement` enum('slider','homepage','category','promo') NOT NULL DEFAULT 'homepage',
  `title` varchar(150) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_blog_categories`
--

CREATE TABLE `su_blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_blog_posts`
--

CREATE TABLE `su_blog_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_blog_tags`
--

CREATE TABLE `su_blog_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_brands`
--

CREATE TABLE `su_brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_brands`
--

INSERT INTO `su_brands` (`id`, `name`, `slug`, `logo`, `banner_image`, `description`, `created_at`) VALUES
(1, 'KARATASI', 'karatasi', 'uploads/brands/logos/1790140218-karatas-logo.png', NULL, NULL, '2026-09-23 05:10:18'),
(2, 'HP', 'hp', 'uploads/brands/logos/1790140274-hp-logo.png', NULL, NULL, '2026-09-23 05:11:14'),
(3, 'Epson', 'epson', 'uploads/brands/logos/1790140345-epson-logo.png', NULL, NULL, '2026-09-23 05:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `su_carts`
--

CREATE TABLE `su_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_carts`
--

INSERT INTO `su_carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-09-18 11:40:11', '2026-09-18 11:40:11'),
(2, 2, '2026-09-22 15:16:04', '2026-09-22 15:16:04'),
(3, 1, '2026-09-25 13:04:01', '2026-09-25 13:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `su_cart_items`
--

CREATE TABLE `su_cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price_at_time` decimal(10,2) NOT NULL DEFAULT 0.00,
  `length` float DEFAULT 0,
  `width` float DEFAULT 0,
  `height` float DEFAULT 0,
  `weight` float DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sheet_length_m` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_client_projects`
--

CREATE TABLE `su_client_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `location` varchar(160) DEFAULT NULL,
  `roofing_profile` varchar(160) DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_client_testimonials`
--

CREATE TABLE `su_client_testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(160) NOT NULL,
  `location` varchar(160) DEFAULT NULL,
  `role` varchar(160) DEFAULT NULL,
  `testimonial` text NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `photo` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_contact_messages`
--

CREATE TABLE `su_contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `first_name` varchar(100) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `received_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_contact_messages`
--

INSERT INTO `su_contact_messages` (`id`, `name`, `first_name`, `last_name`, `email`, `phone`, `subject`, `message`, `is_read`, `received_at`) VALUES
(1, 'Dana Katisya', '', '', 'katisyadana@gmail.com', NULL, 'Website Contact Form', 'Testing testing 123', 0, '2026-10-14 16:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `su_counties`
--

CREATE TABLE `su_counties` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_counties`
--

INSERT INTO `su_counties` (`id`, `country_id`, `name`) VALUES
(1, 1, 'Mombasa'),
(2, 1, 'Kwale'),
(3, 1, 'Kilifi'),
(4, 1, 'Tana River'),
(5, 1, 'Lamu'),
(6, 1, 'Taita Taveta'),
(7, 1, 'Garissa'),
(8, 1, 'Wajir'),
(9, 1, 'Mandera'),
(10, 1, 'Marsabit'),
(11, 1, 'Isiolo'),
(12, 1, 'Meru'),
(13, 1, 'Tharaka Nithi'),
(14, 1, 'Embu'),
(15, 1, 'Kitui'),
(16, 1, 'Machakos'),
(17, 1, 'Makueni'),
(18, 1, 'Nyandarua'),
(19, 1, 'Nyeri'),
(20, 1, 'Kirinyaga'),
(21, 1, 'Murang\'a'),
(22, 1, 'Kiambu'),
(23, 1, 'Turkana'),
(24, 1, 'West Pokot'),
(25, 1, 'Samburu'),
(26, 1, 'Trans Nzoia'),
(27, 1, 'Uasin Gishu'),
(28, 1, 'Elgeyo Marakwet'),
(29, 1, 'Nandi'),
(30, 1, 'Baringo'),
(31, 1, 'Laikipia'),
(32, 1, 'Nakuru'),
(33, 1, 'Narok'),
(34, 1, 'Kajiado'),
(35, 1, 'Kericho'),
(36, 1, 'Bomet'),
(37, 1, 'Kakamega'),
(38, 1, 'Vihiga'),
(39, 1, 'Bungoma'),
(40, 1, 'Busia'),
(41, 1, 'Siaya'),
(42, 1, 'Kisumu'),
(43, 1, 'Homa Bay'),
(44, 1, 'Migori'),
(45, 1, 'Kisii'),
(46, 1, 'Nyamira'),
(47, 1, 'Nairobi');

-- --------------------------------------------------------

--
-- Table structure for table `su_countries`
--

CREATE TABLE `su_countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_countries`
--

INSERT INTO `su_countries` (`id`, `name`) VALUES
(1, 'Kenya');

-- --------------------------------------------------------

--
-- Table structure for table `su_customers`
--

CREATE TABLE `su_customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `shipping_address` text DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `customer_type` enum('regular','premium') NOT NULL DEFAULT 'regular',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_customers`
--

INSERT INTO `su_customers` (`id`, `user_id`, `shipping_address`, `billing_address`, `customer_type`, `created_at`) VALUES
(1, 1, NULL, NULL, 'regular', '2026-09-17 07:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `su_customer_payment_preferences`
--

CREATE TABLE `su_customer_payment_preferences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_discounts`
--

CREATE TABLE `su_discounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('fixed','percent') NOT NULL DEFAULT 'percent',
  `value` decimal(10,2) NOT NULL,
  `usage_limit` int(11) DEFAULT 1,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_email_settings`
--

CREATE TABLE `su_email_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail_driver` varchar(50) DEFAULT 'smtp',
  `mail_host` varchar(150) DEFAULT NULL,
  `mail_port` int(11) DEFAULT NULL,
  `mail_username` varchar(150) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_encryption` varchar(10) DEFAULT NULL,
  `mail_from_address` varchar(150) DEFAULT NULL,
  `mail_from_name` varchar(150) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_email_settings`
--

INSERT INTO `su_email_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `updated_at`) VALUES
(1, 'smtp', 'smtp.gmail.com', 587, NULL, 'usdu pint awue kbcl', 'tls', 'info@trinitymabati.com', 'Trinity Mabati', '2026-10-14 17:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `su_faqs`
--

CREATE TABLE `su_faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_faqs`
--

INSERT INTO `su_faqs` (`id`, `question`, `answer`, `position`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'How do I place an order?', 'Browse our catalog, add items to your cart and complete checkout with your preferred payment method.', 1, 1, '2026-09-17 05:42:36', NULL),
(2, 'Which payment methods are supported?', 'We support M-Pesa, Pesapal, bank transfer and cash on delivery. Available options are shown at checkout.', 2, 1, '2026-09-17 05:42:36', NULL),
(3, 'How do I track my order?', 'Log in to your account and open Order History to see live status updates for every order.', 3, 1, '2026-09-17 05:42:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `su_flash_sales`
--

CREATE TABLE `su_flash_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('active','expired') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_income_expenses`
--

CREATE TABLE `su_income_expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_type` varchar(50) NOT NULL,
  `reference_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_invoices`
--

CREATE TABLE `su_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `issued_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date DEFAULT NULL,
  `status` enum('unpaid','paid','overdue') NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_location_pricing`
--

CREATE TABLE `su_location_pricing` (
  `id` int(10) UNSIGNED NOT NULL,
  `town_id` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `distance_km` decimal(10,2) DEFAULT NULL,
  `estimated_delivery_days` decimal(4,2) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_location_pricing`
--

INSERT INTO `su_location_pricing` (`id`, `town_id`, `price`, `distance_km`, `estimated_delivery_days`, `updated_at`) VALUES
(1, 48, 0.00, NULL, NULL, '2026-09-18 11:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `su_low_stock_alerts`
--

CREATE TABLE `su_low_stock_alerts` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `threshold` int(11) NOT NULL,
  `notified_email` tinyint(1) NOT NULL DEFAULT 0,
  `notified_sms` tinyint(1) NOT NULL DEFAULT 0,
  `resolved_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_loyalty_points`
--

CREATE TABLE `su_loyalty_points` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `tier_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `points_balance` int(11) NOT NULL DEFAULT 0,
  `lifetime_points` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_loyalty_settings`
--

CREATE TABLE `su_loyalty_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `loyalty_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `kes_per_point` decimal(10,2) NOT NULL DEFAULT 10.00,
  `redemption_rate` decimal(10,2) NOT NULL DEFAULT 10.00,
  `min_redeem_points` int(11) NOT NULL DEFAULT 100,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_loyalty_settings`
--

INSERT INTO `su_loyalty_settings` (`id`, `loyalty_enabled`, `kes_per_point`, `redemption_rate`, `min_redeem_points`, `created_at`, `updated_at`) VALUES
(1, 1, 10.00, 10.00, 100, '2026-09-17 05:42:36', '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_loyalty_tiers`
--

CREATE TABLE `su_loyalty_tiers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `min_points` int(11) NOT NULL DEFAULT 0,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `points_multiplier` decimal(5,2) NOT NULL DEFAULT 1.00,
  `badge_icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_loyalty_tiers`
--

INSERT INTO `su_loyalty_tiers` (`id`, `name`, `min_points`, `discount_percent`, `points_multiplier`, `badge_icon`, `is_active`, `created_at`) VALUES
(1, 'Bronze', 0, 0.00, 1.00, NULL, 1, '2026-09-17 05:42:36'),
(2, 'Silver', 500, 2.00, 1.10, NULL, 1, '2026-09-17 05:42:36'),
(3, 'Gold', 2000, 5.00, 1.25, NULL, 1, '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_loyalty_transactions`
--

CREATE TABLE `su_loyalty_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('earn','redeem') NOT NULL DEFAULT 'earn',
  `points` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_media`
--

CREATE TABLE `su_media` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('image','video','pdf','other') NOT NULL DEFAULT 'image',
  `file_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_newsletters`
--

CREATE TABLE `su_newsletters` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `audience` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `status` enum('scheduled','sent') NOT NULL DEFAULT 'scheduled',
  `scheduled_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_newsletter_subscribers`
--

CREATE TABLE `su_newsletter_subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `receive_promotions` tinyint(1) NOT NULL DEFAULT 0,
  `receive_suggestions` tinyint(1) NOT NULL DEFAULT 0,
  `receive_order_updates` tinyint(1) NOT NULL DEFAULT 0,
  `receive_news_updates` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_notifications`
--

CREATE TABLE `su_notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('order','support','promotion','system') NOT NULL DEFAULT 'order',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_orders`
--

CREATE TABLE `su_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `status` enum('pending','processing','in_transit','delivered','completed','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','processing','failed','refunded') NOT NULL DEFAULT 'pending',
  `stock_deducted` tinyint(1) NOT NULL DEFAULT 0,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'KES',
  `shipping_county_id` int(10) UNSIGNED DEFAULT NULL,
  `shipping_town_id` int(10) UNSIGNED DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `shipping_status` enum('pending','shipped','in_transit','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `expected_delivery` datetime DEFAULT NULL,
  `customer_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `customer_confirmed_at` timestamp NULL DEFAULT NULL,
  `admin_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `admin_confirmed_at` timestamp NULL DEFAULT NULL,
  `admin_confirmed_by` int(10) UNSIGNED DEFAULT NULL,
  `mpesa_checkout_request_id` varchar(255) DEFAULT NULL,
  `pesapal_tracking_id` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_order_items`
--

CREATE TABLE `su_order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `variant_label` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_order_loyalty`
--

CREATE TABLE `su_order_loyalty` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `points_earned` int(11) NOT NULL DEFAULT 0,
  `points_redeemed` int(11) NOT NULL DEFAULT 0,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_order_returns`
--

CREATE TABLE `su_order_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `status` enum('requested','approved','rejected','refunded') NOT NULL DEFAULT 'requested',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_order_status_history`
--

CREATE TABLE `su_order_status_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(50) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `changed_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_pages`
--

CREATE TABLE `su_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `content` longtext DEFAULT NULL,
  `meta_title` varchar(160) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_pages`
--

INSERT INTO `su_pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Refund Policy', 'refund-policy', '<h2>1. Overview</h2><p>This Refund Policy outlines the terms under which Finamax (\"Finamax,\" \"we,\" \"us,\" or \"our\") will consider and process refunds for payments made through our digital platform (the \"Platform\") in connection with product applications, deposits, and ownership plan payments. This Policy should be read together with our Terms and Conditions.</p><p>Because Finamax operates as a marketplace connecting customers to manufacturers, sellers, and dealer partners, refund eligibility may also depend on the specific terms of the ownership agreement and the policies of the relevant manufacturer or seller.</p><h2>2. Application and Processing Fees</h2><ul><li>Certain non-refundable administrative or processing fees may apply when submitting an application (e.g., credit checks, verification, or documentation fees). These will be clearly disclosed to you before payment.</li><li>Non-refundable fees will not be reimbursed even if your application is subsequently declined, unless the decline was due to an error on Finamax\'s part.</li></ul><h2>3. Deposits and Down Payments</h2><ul><li>Deposits or down payments made toward an ownership plan are generally refundable <strong>only</strong> under the following circumstances:</li></ul><ol><li class=\"ql-indent-1\">Your application is declined after payment of the deposit;</li><li class=\"ql-indent-1\">The seller/manufacturer is unable to fulfil the order (e.g., product unavailability); or</li><li class=\"ql-indent-1\">You cancel your application within [Insert Cooling-Off Period, e.g., 48 hours] of submission, provided the asset has not yet been allocated, ordered, or delivered.</li></ol><ul><li>Deposits are <strong>not refundable</strong> once the asset has been allocated, delivered, or handed over to you, except where the product is found to be defective and cannot be remedied through repair or replacement (see Section 5).</li><li>Approved refunds under this section will be processed within [Insert Number] business days to the original payment method, unless otherwise agreed.</li></ul><h2>4. Installment and Ownership Plan Payments</h2><ul><li>Payments made toward an active ownership plan (i.e., after asset handover) are generally non-refundable, as they represent progress toward ownership of the asset.</li><li>If you wish to exit an ownership plan early, please refer to the early termination/settlement terms in your specific ownership agreement, which may involve a settlement amount rather than a refund.</li><li>If your ownership plan is terminated due to default, applicable terms in your agreement regarding repossession and settlement of outstanding balances will apply, and no refund will typically be due unless a payment surplus exists after settlement.</li></ul><h2>5. Defective or Faulty Products</h2><ul><li>If a product delivered to you is found to be defective, damaged, or not as described at the point of delivery, you must report this to Finamax customer support within [Insert Number, e.g., 7] days of receipt.</li><li>Finamax will coordinate with the relevant manufacturer/seller to arrange:</li><li class=\"ql-indent-1\">Repair of the product;</li><li class=\"ql-indent-1\">Replacement of the product; or</li><li class=\"ql-indent-1\">A refund of amounts paid, where repair or replacement is not possible or reasonable.</li><li>Refunds for defective products will be assessed on a case-by-case basis in line with the applicable manufacturer\'s warranty terms and consumer protection laws.</li></ul><h2>6. Order Cancellations by Finamax or Sellers</h2><p>If Finamax or a seller/manufacturer cancels your order or application (e.g., due to stock unavailability, pricing errors, or inability to verify information), you will be entitled to a full refund of any amounts paid specifically for that order, processed within [Insert Number] business days.</p><h2>7. Non-Refundable Circumstances</h2><p>Refunds will generally <strong>not</strong> be granted where:</p><ul><li>You simply change your mind after the asset has been delivered and accepted;</li><li>The asset has been used, damaged through misuse, or altered from its delivered condition;</li><li>The request falls outside the applicable reporting or cooling-off period stated in this Policy; or</li><li>The payment relates to a fee explicitly disclosed as non-refundable at the time of payment.</li></ul><h2>8. How to Request a Refund</h2><p>To request a refund, please:</p><ol><li>Contact Finamax customer support through [Insert Channel — email/phone/app];</li><li>Provide your account details, transaction reference, and reason for the request; and</li><li>Submit any supporting documentation (e.g., photos of a defective product, communication records).</li></ol><p>Our team will review your request and respond within [Insert Number] business days.</p><h2>9. Refund Method</h2><p>Approved refunds will be issued to the original payment method used (e.g., bank account, mobile money) unless an alternative method is agreed in writing. Processing times may vary depending on your payment provider.</p><h2>10. Changes to This Policy</h2><p>Finamax may update this Refund Policy from time to time to reflect changes in our business practices or legal requirements. The updated Policy will be posted on the Platform with a revised \"Last Updated\" date.</p><h2>11. Contact Us</h2><p>For refund inquiries, don\'t hesitate to get in touch with us.</p>', 'Refund Policy', 'Read our refund policy.', 1, '2026-09-17 05:42:36', '2026-09-18 06:26:57'),
(2, 'Terms and Conditions', 'terms-and-conditions', '<h1>1. Introduction</h1><p>These Terms and Conditions (\"Terms\") govern your access to and use of the Finamax digital platform, website, and mobile application (collectively, the \"Platform\"), operated by Finamax (\"Finamax,\" \"we,\" \"us,\" or \"our\"). By creating an account, browsing, or using any part of the Platform, you (\"User,\" \"Customer,\" or \"you\") agree to be bound by these Terms. If you do not agree, please do not use the Platform.</p><h2>2. About Finamax</h2><p>Finamax is a digital marketplace that connects customers with trusted manufacturers and sellers of productive assets — including transportation assets such as motorcycles — through flexible, transparent ownership solutions. Finamax facilitates the discovery, application, financing/ownership arrangement, and support process, but does not itself manufacture the products listed on the Platform unless expressly stated.</p><h2>3. Eligibility</h2><p>To use the Platform and apply for any ownership plan, you must:</p><ul><li>Be at least 18 years of age;</li><li>Have the legal capacity to enter into binding agreements;</li><li>Provide accurate, current, and complete information during registration and application; and</li><li>Comply with all applicable laws in your jurisdiction.</li></ul><p>Finamax reserves the right to verify your eligibility and to refuse or suspend service where information provided is false, incomplete, or cannot be verified.</p><h2>4. Account Registration</h2><ul><li>You must create an account to access certain features of the Platform.</li><li>You are responsible for maintaining the confidentiality of your login credentials and for all activities conducted under your account.</li><li>You must notify us immediately of any unauthorized use of your account.</li><li>Finamax is not liable for any loss arising from your failure to safeguard your account credentials.</li></ul><h2>5. Products and Ownership Plans</h2><h3>5.1 Marketplace Role</h3><p>Finamax connects you with manufacturers, sellers, and dealer partners offering products on the Platform. Product descriptions, specifications, images, and pricing are provided by sellers/manufacturers and are believed to be accurate, but Finamax does not guarantee their completeness or accuracy.</p><h3>5.2 Applications</h3><p>When you apply for a product through an ownership plan, you authorize Finamax to:</p><ul><li>Assess your eligibility and affordability, including through credit checks and verification with credit reference bureaus;</li><li>Share necessary information with relevant manufacturers, sellers, financing partners, and guarantors; and</li><li>Process your application in accordance with our internal approval criteria.</li></ul><p>Submission of an application does not guarantee approval. Finamax reserves the right to approve, decline, or request additional information for any application at its sole discretion.</p><h3>5.3 Ownership Plans</h3><ul><li>Approved customers will receive an agreement outlining the payment schedule, total cost, applicable fees, and terms specific to their ownership plan.</li><li>Ownership of the asset transfers to the customer only upon full satisfaction of the payment obligations set out in the applicable agreement, unless otherwise stated.</li><li>Until full ownership transfer, the asset may remain subject to security interests, tracking devices, or usage conditions as specified in your agreement.</li></ul><h2>6. Payments</h2><ul><li>You agree to make payments in accordance with the schedule specified in your ownership plan agreement.</li><li>Accepted payment methods will be communicated during the application and onboarding process.</li><li>Late or missed payments may result in penalty fees, suspension of asset usage, repossession, or other remedies as set out in your specific ownership agreement.</li><li>All fees, charges, and interest (where applicable) will be disclosed transparently before you commit to a plan.</li></ul><h2>7. Customer Responsibilities</h2><p>As a Customer, you agree to:</p><ul><li>Use the Platform and any acquired assets lawfully and responsibly;</li><li>Provide accurate information throughout the application and ownership period;</li><li>Maintain and care for any financed asset in accordance with the manufacturer\'s guidelines and your ownership agreement;</li><li>Promptly report any loss, theft, damage, or malfunction of a financed asset; and</li><li>Make payments on time and in full as agreed.</li></ul><h2>8. Prohibited Conduct</h2><p>You may not:</p><ul><li>Use the Platform for any unlawful, fraudulent, or deceptive purpose;</li><li>Provide false, misleading, or stolen identity information;</li><li>Attempt to interfere with, disrupt, or gain unauthorized access to the Platform or its systems;</li><li>Resell, transfer, or encumber a financed asset without Finamax\'s written consent prior to full ownership transfer; or</li><li>Use the Platform to harass, abuse, or harm any other user, seller, or Finamax representative.</li></ul><h2>9. Intellectual Property</h2><p>All content on the Platform, including logos, trademarks, text, graphics, software, and design, is the property of Finamax or its licensors and is protected by applicable intellectual property laws. You may not copy, reproduce, distribute, or create derivative works from Platform content without our prior written consent.</p><h2>10. Third-Party Sellers and Manufacturers</h2><p>Finamax facilitates transactions between customers and third-party sellers/manufacturers. While we take reasonable steps to work with trusted partners:</p><ul><li>Finamax is not the manufacturer of third-party products unless expressly stated;</li><li>Product warranties are provided by the manufacturer/seller in accordance with their own warranty terms; and</li><li>Any disputes regarding product quality or defects should first be raised through the applicable warranty process, with Finamax providing reasonable support to facilitate resolution.</li></ul><h2>11. Limitation of Liability</h2><p>To the maximum extent permitted by law:</p><ul><li>Finamax provides the Platform on an \"as is\" and \"as available\" basis, without warranties of any kind, express or implied.</li><li>Finamax shall not be liable for indirect, incidental, special, or consequential damages arising from your use of the Platform or any product acquired through it.</li><li>Finamax\'s total liability for any claim arising from these Terms or your use of the Platform shall not exceed the amount you have paid to Finamax in the twelve (12) months preceding the claim.</li></ul><p>Nothing in these Terms limits liability that cannot be excluded under applicable law.</p><h2>12. Suspension and Termination</h2><p>Finamax reserves the right to suspend or terminate your account and access to the Platform, with or without notice, if:</p><ul><li>You breach these Terms;</li><li>We suspect fraudulent, unlawful, or abusive activity;</li><li>Required to do so by law or regulatory directive; or</li><li>You request account closure, subject to settlement of any outstanding obligations.</li></ul><h2>13. Dispute Resolution</h2><ul><li>We encourage users to first contact our customer support team to resolve any issue.</li><li>If a dispute cannot be resolved informally, it shall be referred to mediation or arbitration in accordance with the laws of [Insert Jurisdiction], before resorting to litigation, unless otherwise required by law.</li><li>These Terms are governed by the laws of [Insert Jurisdiction/Country].</li></ul><h2>14. Changes to These Terms</h2><p>Finamax may update these Terms from time to time to reflect changes in our services, business practices, or legal requirements. Continued use of the Platform after changes take effect constitutes acceptance of the revised Terms. Material changes will be communicated through the Platform.</p><h2>15. Contact Us</h2><p>For questions about these Terms, don\'t hesitate to get in touch with us.</p>', 'Terms and Conditions', 'Read our terms and conditions.', 1, '2026-09-17 05:42:36', '2026-09-18 06:26:12'),
(3, 'Privacy Policy', 'privacy-policy', '<h1>1. Introduction</h1><p>Finamax (\"Finamax,\" \"we,\" \"us,\" or \"our\") operates a digital platform that connects customers with trusted manufacturers and sellers of productive assets — including transportation assets such as motorcycles — through innovative, flexible ownership solutions. This Privacy Policy explains how we collect, use, share, and protect your personal information when you use our website, mobile application, or any related services (collectively, the \"Platform\").</p><p>By accessing or using the Platform, you agree to the collection and use of information in accordance with this Privacy Policy. If you do not agree with the terms of this policy, please do not use the Platform.</p><h2>2. Information We Collect</h2><h3>2.1 Information You Provide to Us</h3><ul><li><strong>Identity Information</strong>: Full name, national ID/passport number, date of birth, photograph, and signature.</li><li><strong>Contact Information</strong>: Phone number, email address, physical/postal address.</li><li><strong>Financial Information</strong>: Bank account details, mobile money details, income information, employment or business details, and payment history.</li><li><strong>Application &amp; Onboarding Information</strong>: Details submitted during product applications, including guarantor information, references, and supporting documents (e.g., ID copies, proof of income, driving license).</li><li><strong>Communications</strong>: Records of correspondence when you contact customer support, including calls, emails, chats, or messages.</li></ul><h3>2.2 Information Collected Automatically</h3><ul><li><strong>Device Information</strong>: Device type, operating system, unique device identifiers, IP address, mobile network information.</li><li><strong>Usage Data</strong>: Pages visited, features used, time spent on the Platform, click patterns, and referral sources.</li><li><strong>Location Data</strong>: Approximate or precise location, where enabled, to support service delivery, fraud prevention, and asset tracking (where applicable to financed assets).</li><li><strong>Cookies and Similar Technologies</strong>: See Section 8 below.</li></ul><h3>2.3 Information From Third Parties</h3><ul><li>Credit reference bureaus and credit scoring agencies.</li><li>Manufacturers, sellers, and dealer partners involved in fulfilling your order.</li><li>Identity verification and KYC (Know Your Customer) service providers.</li><li>Payment processors and financial institutions.</li><li>Publicly available sources, where lawful.</li></ul><h2>3. How We Use Your Information</h2><p>We use your personal information to:</p><ol><li>Create and manage your Finamax account.</li><li>Process applications for products and ownership plans, including eligibility and affordability assessments.</li><li>Facilitate transactions between you and sellers/manufacturers on the Platform.</li><li>Process payments, track ownership progress, and manage installment schedules.</li><li>Verify your identity and prevent fraud, money laundering, or other illegal activity.</li><li>Provide customer support and respond to inquiries.</li><li>Send you service-related communications (e.g., payment reminders, order updates, policy changes).</li><li>Send marketing communications, where you have consented, and which you may opt out of at any time.</li><li>Improve, personalize, and develop the Platform and our services.</li><li>Comply with legal, regulatory, and tax obligations.</li><li>Enforce our Terms and Conditions and protect our rights, property, and safety, and that of our users.</li></ol><h2>4. Legal Basis for Processing</h2><p>We process your personal information on the following bases:</p><ul><li><strong>Consent</strong>: Where you have given clear consent (e.g., marketing communications).</li><li><strong>Contractual necessity</strong>: To perform our obligations under an ownership plan or purchase agreement with you.</li><li><strong>Legal obligation</strong>: To comply with applicable laws, including data protection, anti-money laundering, and consumer protection laws.</li><li><strong>Legitimate interest</strong>: For fraud prevention, credit risk assessment, Platform security, and service improvement, balanced against your rights and interests.</li></ul><h2>5. How We Share Your Information</h2><p>We may share your information with:</p><ul><li><strong>Manufacturers, sellers, and dealer partners</strong> — to fulfil orders and deliver products.</li><li><strong>Financing and payment partners</strong> — to process transactions and manage ownership plans.</li><li><strong>Credit reference bureaus</strong> — to assess creditworthiness and report payment behavior, in accordance with applicable law.</li><li><strong>Service providers</strong> — including IT hosting, data analytics, customer support, and identity verification vendors, under confidentiality obligations.</li><li><strong>Regulators and law enforcement</strong> — where required by law, court order, or to protect our legal rights.</li><li><strong>Business transfers</strong> — in connection with a merger, acquisition, restructuring, or sale of assets, subject to confidentiality safeguards.</li></ul><p>We do not sell your personal information to third parties for their own independent marketing purposes.</p><h2>6. Data Retention</h2><p>We retain your personal information for as long as necessary to:</p><ul><li>Fulfil the purposes described in this Policy;</li><li>Maintain records of your ownership plan and payment history;</li><li>Comply with legal, regulatory, accounting, or reporting obligations; and</li><li>Resolve disputes and enforce our agreements.</li></ul><p>When information is no longer needed, we securely delete or anonymize it, unless retention is required by law.</p><h2>7. Data Security</h2><p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction, including encryption, access controls, and secure storage practices. However, no method of transmission or storage is completely secure, and we cannot guarantee absolute security.</p><h2>8. Cookies and Tracking Technologies</h2><p>We use cookies and similar technologies to:</p><ul><li>Keep you logged in and remember your preferences;</li><li>Analyze Platform traffic and usage patterns; and</li><li>Improve functionality and user experience.</li></ul><p>You can control cookies through your browser or device settings. Disabling cookies may affect certain features of the Platform.</p><h2>9. Your Rights</h2><p>Subject to applicable data protection law, you have the right to:</p><ul><li><strong>Access</strong> the personal information we hold about you;</li><li><strong>Correct</strong> inaccurate or incomplete information;</li><li><strong>Request deletion</strong> of your information, subject to legal and contractual retention requirements;</li><li><strong>Object to or restrict</strong> certain processing activities;</li><li><strong>Withdraw consent</strong> at any time, where processing is based on consent;</li><li><strong>Data portability</strong>, where technically feasible; and</li><li><strong>Lodge a complaint</strong> with the relevant data protection authority.</li></ul><p>To exercise these rights, contact us using the details in Section 13.</p><h2>10. Children\'s Privacy</h2><p>The Platform is not intended for individuals under the age of 18. We do not knowingly collect personal information from minors. If we become aware that we have inadvertently collected such information, we will take steps to delete it.</p><h2>11. International Data Transfers</h2><p>Where your information is transferred to or processed in a country other than your own (e.g., for cloud hosting or service providers), we take steps to ensure it receives an adequate level of protection consistent with applicable data protection laws.</p><h2>12. Changes to This Privacy Policy</h2><p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. We will notify you of material changes through the Platform or other appropriate means. The \"Last Updated\" date at the top reflects the most recent revision.</p><h2>13. Contact Us</h2><p>If you have questions, concerns, or requests regarding this Privacy Policy or your personal information, please <a href=\"https://finamax.co.ke/contact-us/\" rel=\"noopener noreferrer\" target=\"_blank\">contact us</a>.</p>', 'Privacy Policy', 'Read our privacy policy.', 1, '2026-09-17 05:42:36', '2026-09-18 06:25:30'),
(4, 'Cookie Policy', 'cookie-policy', '<p>Our cookie policy. Replace this content from the admin panel.</p>', 'Cookie Policy', 'Read our cookie policy.', 1, '2026-09-17 05:42:36', '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_payments`
--

CREATE TABLE `su_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','successful','failed','refunded') NOT NULL DEFAULT 'pending',
  `reference` varchar(100) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_payment_logs`
--

CREATE TABLE `su_payment_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(10) UNSIGNED NOT NULL,
  `gateway_response` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_payment_methods`
--

CREATE TABLE `su_payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `user_input_label` varchar(255) DEFAULT NULL,
  `user_input_description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_payment_methods`
--

INSERT INTO `su_payment_methods` (`id`, `name`, `slug`, `description`, `is_active`, `is_default`, `config`, `user_input_label`, `user_input_description`, `thumbnail`, `created_at`) VALUES
(1, 'Pay via M-Pesa', 'mpesa', 'Safaricom M-Pesa STK push payments', 1, 1, '{\"consumer_key\": \"REPLACE_ME\", \"consumer_secret\": \"REPLACE_ME\", \"shortcode\": \"REPLACE_ME\", \"passkey\": \"REPLACE_ME\", \"env\": \"sandbox\", \"callback_url\": \"https://yourdomain.com/payments/mpesa/callback\"}', 'Enter your Safaricom number', 'We will send an STK push request to this number to complete the payment.', NULL, '2026-09-17 05:42:36'),
(2, 'Pesapal', 'pesapal', 'Pesapal gateway for cards and mobile money', 1, 0, '{\"consumer_key\": \"REPLACE_ME\", \"consumer_secret\": \"REPLACE_ME\", \"environment\": \"sandbox\", \"callback_url\": \"https://yourdomain.com/payments/pesapal/callback\", \"ipn_url\": \"https://yourdomain.com/payments/pesapal/ipn\"}', 'Enter your email address', 'You will be redirected to Pesapal to securely complete your payment.', NULL, '2026-09-17 05:42:36'),
(3, 'Bank Transfer', 'bank_transfer', 'Direct bank transfer with proof of payment upload', 1, 0, '{\"bank_name\": \"REPLACE_ME\", \"account_name\": \"REPLACE_ME\", \"account_number\": \"REPLACE_ME\", \"branch\": \"REPLACE_ME\"}', 'Upload proof of payment', 'Transfer the order total to the account shown, then upload your payment slip or screenshot.', NULL, '2026-09-17 05:42:36'),
(4, 'Pay on Delivery', 'cash_on_delivery', 'Customer pays in cash when the order is delivered', 1, 0, '[]', NULL, 'You will pay in cash when your order is delivered to you.', NULL, '2026-09-17 05:42:36'),
(5, 'Card Payment', 'card', 'Card payments through a gateway of your choice, inactive until configured', 0, 0, '{\"provider\": \"REPLACE_ME\", \"public_key\": \"REPLACE_ME\", \"secret_key\": \"REPLACE_ME\"}', 'Enter your card details', 'You will be redirected to complete your card payment securely.', NULL, '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_pending_mpesa`
--

CREATE TABLE `su_pending_mpesa` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `checkout_request_id` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','successful','failed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_pending_pesapal`
--

CREATE TABLE `su_pending_pesapal` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `tracking_id` varchar(100) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','successful','failed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_pending_users`
--

CREATE TABLE `su_pending_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `resend_available_at` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_permissions`
--

CREATE TABLE `su_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_permissions`
--

INSERT INTO `su_permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'View Users', 'view_users', 'Allows viewing the user list and details', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(2, 'Create Users', 'create_users', 'Allows creation of new user accounts', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(3, 'Edit Users', 'edit_users', 'Allows editing existing user accounts', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(4, 'Delete Users', 'delete_users', 'Allows deleting user accounts', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(5, 'View Roles', 'view_roles', 'Allows viewing roles and their assigned permissions', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(6, 'Edit Roles', 'edit_roles', 'Allows editing roles and assigning permissions', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(7, 'View Products', 'view_products', 'Allows viewing all product listings', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(8, 'Create Products', 'create_products', 'Allows creating new products', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(9, 'Edit Products', 'edit_products', 'Allows editing product details', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(10, 'Delete Products', 'delete_products', 'Allows deleting products', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(11, 'Manage Categories', 'manage_categories', 'Allows creating, editing and deleting product categories', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(12, 'View Orders', 'view_orders', 'Allows viewing customer orders', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(13, 'Update Orders', 'update_orders', 'Allows updating order status and fulfillment info', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(14, 'View Payments', 'view_payments', 'Allows access to payment records', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(15, 'Moderate Reviews', 'moderate_reviews', 'Allows approving, editing or removing customer reviews', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(16, 'Manage Settings', 'manage_settings', 'Allows changing store settings like name, logo and contact details', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(17, 'View System Logs', 'view_system_logs', 'Allows access to backend activity logs', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(18, 'Send Notifications', 'send_notifications', 'Allows sending announcements or emails to users', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(19, 'Manage Coupons', 'manage_coupons', 'Allows creating and managing discount codes', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(20, 'View Reports', 'view_reports', 'Allows access to analytics and sales reports', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(21, 'View Invoices', 'view_invoices', 'Allows viewing invoices', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(22, 'Manage Shipping', 'manage_shipping', 'Allows configuring shipping settings', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(23, 'Manage Location Pricing', 'manage_location_pricing', 'Allows configuring delivery pricing per town', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(24, 'Manage Newsletters', 'manage_newsletters', 'Allows creating and sending newsletters', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(25, 'Manage Media', 'manage_media', 'Allows access to all media, images and files', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(26, 'View Contact Messages', 'view_contact_messages', 'Allows access to messages submitted through the contact form', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(27, 'Manage User Permissions', 'manage_user_permissions', 'Allows managing user roles and permissions', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(28, 'Manage Blog', 'manage_blog', 'Allows creating and editing blog posts and categories', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(29, 'Manage Pages', 'manage_pages', 'Allows editing static pages like Terms and Privacy Policy', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(30, 'Manage Support Tickets', 'manage_support_tickets', 'Allows viewing and replying to support tickets', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(31, 'Manage Loyalty Program', 'manage_loyalty_program', 'Allows configuring loyalty points rules and adjusting balances', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(32, 'Manage Referral Program', 'manage_referral_program', 'Allows configuring referral rewards and viewing referral activity', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(33, 'View Quotations', 'view_quotations', 'Allows viewing customer quotations', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(34, 'Manage Quotations', 'manage_quotations', 'Allows creating, editing and sending quotations to customers', '2026-09-17 05:42:36', '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_post_tag`
--

CREATE TABLE `su_post_tag` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_products`
--

CREATE TABLE `su_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `label_id` int(10) UNSIGNED DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `original_price` decimal(12,2) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'KES',
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `low_stock_threshold` int(11) NOT NULL DEFAULT 5,
  `is_variant` tinyint(1) NOT NULL DEFAULT 0,
  `weight` decimal(10,2) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `condition` enum('new','used','refurbished') NOT NULL DEFAULT 'new',
  `condition_notes` text DEFAULT NULL,
  `is_vat_exempt` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `thumbnail` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `detailed_description` text DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `allow_custom_length` tinyint(1) NOT NULL DEFAULT 0,
  `default_length_m` decimal(6,2) NOT NULL DEFAULT 3.00,
  `min_length_m` decimal(6,2) NOT NULL DEFAULT 0.10,
  `max_length_m` decimal(6,2) NOT NULL DEFAULT 30.00,
  `default_gauge` varchar(100) DEFAULT NULL,
  `default_finish` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_products`
--

INSERT INTO `su_products` (`id`, `name`, `slug`, `brand_id`, `category_id`, `label_id`, `sku`, `price`, `sale_price`, `cost_price`, `original_price`, `currency`, `stock_quantity`, `low_stock_threshold`, `is_variant`, `weight`, `length`, `width`, `height`, `condition`, `condition_notes`, `is_vat_exempt`, `is_active`, `thumbnail`, `short_description`, `detailed_description`, `views`, `created_at`, `updated_at`, `allow_custom_length`, `default_length_m`, `min_length_m`, `max_length_m`, `default_gauge`, `default_finish`) VALUES
(256, 'Box Profile IT4 IT5 Glossy Charcoal Grey', 'box-profile-it4-it5-glossy-charcoal-grey', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-GLOSSY-CHARCOAL-GREY', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Glossy Charcoal Grey, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:22', '2026-10-14 16:52:22', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(257, 'Box Profile IT4 IT5 Glossy Brick Red', 'box-profile-it4-it5-glossy-brick-red', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-GLOSSY-BRICK-RED', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Glossy Brick Red, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(258, 'Box Profile IT4 IT5 Glossy Tile Red', 'box-profile-it4-it5-glossy-tile-red', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-GLOSSY-TILE-RED', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Glossy Tile Red, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(259, 'Box Profile IT4 IT5 Glossy Maroon', 'box-profile-it4-it5-glossy-maroon', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-GLOSSY-MAROON', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Glossy Maroon, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(260, 'Box Profile IT4 IT5 Glossy Jungle Green', 'box-profile-it4-it5-glossy-jungle-green', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-GLOSSY-JUNGLE-GREEN', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Glossy Jungle Green, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(261, 'Box Profile IT4 IT5 Glossy Ocean Blue', 'box-profile-it4-it5-glossy-ocean-blue', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-GLOSSY-OCEAN-BLUE', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Glossy Ocean Blue, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(262, 'Box Profile IT4 IT5 Matte Charcoal Grey', 'box-profile-it4-it5-matte-charcoal-grey', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-MATTE-CHARCOAL-GREY', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Matte Charcoal Grey, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(263, 'Box Profile IT4 IT5 Matte Chocolate Brown', 'box-profile-it4-it5-matte-chocolate-brown', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-MATTE-CHOCOLATE-BROWN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Matte Chocolate Brown, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(264, 'Box Profile IT4 IT5 Matte Tile Red', 'box-profile-it4-it5-matte-tile-red', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-MATTE-TILE-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Matte Tile Red, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(265, 'Box Profile IT4 IT5 Matte Maroon', 'box-profile-it4-it5-matte-maroon', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-MATTE-MAROON', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Matte Maroon, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:23', '2026-10-14 16:52:23', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(266, 'Box Profile IT4 IT5 Matte Jungle Green', 'box-profile-it4-it5-matte-jungle-green', NULL, 20, NULL, 'BOX-PROFILE-IT4-IT5-MATTE-JUNGLE-GREEN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', 'Order your Mabati from Trinity Mabati Factory\n\nInvest in Longevity\nOur roofing sheets feature an Aluminum-Zinc base that provides exceptional protection against corrosion, doubling the lifespan compared to ordinary roofing.\n\nWorry-Free Color\nEnjoy peace of mind with our superior paint quality, which comes with a comprehensive fade-free warranty of up to 15 years.\n\nAchieve Your Vision\nCustomize the look of your building with our extensive range of available colors to perfectly suit your design.\n\nSmarter Installation, Better Protection\nBy providing lengths tailored to your project, we reduce the number of seams. This drastically lowers the risk of leaks and saves you money by cutting down on material waste.\n\nA Flawless Finish\nComplete your project with our matching accessories, ensuring a perfectly integrated and aesthetically pleasing total roofing system.', 0, 1, NULL, 'Box Profile IT4 IT5 Matte Jungle Green, per metre.', '<h3>Box Profile Roofing Sheets</h3><p>Box Profile roofing sheets, often chosen for their contemporary and clean aesthetic, represent a superior structural option in the Kenyan market. Characterized by their distinct rectangular ribs, they offer enhanced load-bearing capacity and rigidity compared to standard corrugated sheets, making them ideal for large-span structures, industrial buildings, and high-end residential projects.</p><p>While typically commanding a slightly higher price point than mabati, the box profile design provides exceptional strength, better runoff during intense rain, and a modern, premium finish, appealing to customers seeking both maximum durability and visual impact.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(267, 'Versatile Profile Matte Charcoal Grey', 'versatile-profile-matte-charcoal-grey', NULL, 28, NULL, 'VERSATILE-PROFILE-MATTE-CHARCOAL-GREY', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Versatile Profile Matte Charcoal Grey, per metre.', 'Versatile Profile Matte Charcoal Grey, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(268, 'Versatile Profile Matte Chocolate Brown', 'versatile-profile-matte-chocolate-brown', NULL, 28, NULL, 'VERSATILE-PROFILE-MATTE-CHOCOLATE-BROWN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Versatile Profile Matte Chocolate Brown, per metre.', 'Versatile Profile Matte Chocolate Brown, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(269, 'Versatile Profile Matte Maroon', 'versatile-profile-matte-maroon', NULL, 28, NULL, 'VERSATILE-PROFILE-MATTE-MAROON', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Versatile Profile Matte Maroon, per metre.', 'Versatile Profile Matte Maroon, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(270, 'Versatile Profile Matte Tile Red', 'versatile-profile-matte-tile-red', NULL, 28, NULL, 'VERSATILE-PROFILE-MATTE-TILE-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Versatile Profile Matte Tile Red, per metre.', 'Versatile Profile Matte Tile Red, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(271, 'Versatile Profile Matte Brick Red', 'versatile-profile-matte-brick-red', NULL, 28, NULL, 'VERSATILE-PROFILE-MATTE-BRICK-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Versatile Profile Matte Brick Red, per metre.', 'Versatile Profile Matte Brick Red, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(272, 'Versatile Profile Matte Ocean Blue', 'versatile-profile-matte-ocean-blue', NULL, 28, NULL, 'VERSATILE-PROFILE-MATTE-OCEAN-BLUE', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Versatile Profile Matte Ocean Blue, per metre.', 'Versatile Profile Matte Ocean Blue, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(273, 'Eurotile Profile Matte Charcoal Grey', 'eurotile-profile-matte-charcoal-grey', NULL, 29, NULL, 'EUROTILE-PROFILE-MATTE-CHARCOAL-GREY', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Eurotile Profile Matte Charcoal Grey, per metre.', 'Eurotile Profile Matte Charcoal Grey, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(274, 'Eurotile Profile Matte Chocolate Brown', 'eurotile-profile-matte-chocolate-brown', NULL, 29, NULL, 'EUROTILE-PROFILE-MATTE-CHOCOLATE-BROWN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Eurotile Profile Matte Chocolate Brown, per metre.', 'Eurotile Profile Matte Chocolate Brown, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(275, 'Eurotile Profile Matte Maroon', 'eurotile-profile-matte-maroon', NULL, 29, NULL, 'EUROTILE-PROFILE-MATTE-MAROON', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Eurotile Profile Matte Maroon, per metre.', 'Eurotile Profile Matte Maroon, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(276, 'Eurotile Profile Matte Dark Green', 'eurotile-profile-matte-dark-green', NULL, 29, NULL, 'EUROTILE-PROFILE-MATTE-DARK-GREEN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Eurotile Profile Matte Dark Green, per metre.', 'Eurotile Profile Matte Dark Green, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(277, 'Eurotile Profile Matte Tile Red', 'eurotile-profile-matte-tile-red', NULL, 29, NULL, 'EUROTILE-PROFILE-MATTE-TILE-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Eurotile Profile Matte Tile Red, per metre.', 'Eurotile Profile Matte Tile Red, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(278, 'Eurotile Profile Matte Brick Red', 'eurotile-profile-matte-brick-red', NULL, 29, NULL, 'EUROTILE-PROFILE-MATTE-BRICK-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Eurotile Profile Matte Brick Red, per metre.', 'Eurotile Profile Matte Brick Red, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(279, 'Romantile Matte Charcoal Grey', 'romantile-matte-charcoal-grey', NULL, 30, NULL, 'ROMANTILE-MATTE-CHARCOAL-GREY', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Romantile Matte Charcoal Grey, per metre.', 'Romantile Matte Charcoal Grey, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(280, 'Romantile Matte Maroon', 'romantile-matte-maroon', NULL, 30, NULL, 'ROMANTILE-MATTE-MAROON', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Romantile Matte Maroon, per metre.', 'Romantile Matte Maroon, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(281, 'Romantile Matte Brick Red', 'romantile-matte-brick-red', NULL, 30, NULL, 'ROMANTILE-MATTE-BRICK-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Romantile Matte Brick Red, per metre.', 'Romantile Matte Brick Red, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(282, 'Romantile Matte Chocolate Brown', 'romantile-matte-chocolate-brown', NULL, 30, NULL, 'ROMANTILE-MATTE-CHOCOLATE-BROWN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Romantile Matte Chocolate Brown, per metre.', 'Romantile Matte Chocolate Brown, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(283, 'Corrugated Wave Glossy Charcoal Grey', 'corrugated-wave-glossy-charcoal-grey', NULL, 21, NULL, 'CORRUGATED-WAVE-GLOSSY-CHARCOAL-GREY', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Glossy Charcoal Grey, per metre.', 'Corrugated Wave Glossy Charcoal Grey, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(284, 'Corrugated Wave Glossy Brick Red', 'corrugated-wave-glossy-brick-red', NULL, 21, NULL, 'CORRUGATED-WAVE-GLOSSY-BRICK-RED', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Glossy Brick Red, per metre.', 'Corrugated Wave Glossy Brick Red, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(285, 'Corrugated Wave Glossy Tile Red', 'corrugated-wave-glossy-tile-red', NULL, 21, NULL, 'CORRUGATED-WAVE-GLOSSY-TILE-RED', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Glossy Tile Red, per metre.', 'Corrugated Wave Glossy Tile Red, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(286, 'Corrugated Wave Glossy Ocean Blue', 'corrugated-wave-glossy-ocean-blue', NULL, 21, NULL, 'CORRUGATED-WAVE-GLOSSY-OCEAN-BLUE', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Glossy Ocean Blue, per metre.', 'Corrugated Wave Glossy Ocean Blue, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(287, 'Corrugated Wave Glossy Jungle Green', 'corrugated-wave-glossy-jungle-green', NULL, 21, NULL, 'CORRUGATED-WAVE-GLOSSY-JUNGLE-GREEN', 500.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Glossy Jungle Green, per metre.', 'Corrugated Wave Glossy Jungle Green, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(288, 'Corrugated Wave Matte Charcoal Grey', 'corrugated-wave-matte-charcoal-grey', NULL, 21, NULL, 'CORRUGATED-WAVE-MATTE-CHARCOAL-GREY', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Matte Charcoal Grey, per metre.', 'Corrugated Wave Matte Charcoal Grey, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(289, 'Corrugated Wave Matte Chocolate Brown', 'corrugated-wave-matte-chocolate-brown', NULL, 21, NULL, 'CORRUGATED-WAVE-MATTE-CHOCOLATE-BROWN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Matte Chocolate Brown, per metre.', 'Corrugated Wave Matte Chocolate Brown, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(290, 'Corrugated Wave Matte Maroon', 'corrugated-wave-matte-maroon', NULL, 21, NULL, 'CORRUGATED-WAVE-MATTE-MAROON', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Corrugated Wave Matte Maroon, per metre.', 'Corrugated Wave Matte Maroon, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(291, 'Non Colored Corrugated Sheet Uncolored Galvanized Metallic Silver', 'non-colored-corrugated-sheet-uncolored-galvanized-metallic-silver', NULL, 21, NULL, 'NON-COLORED-CORRUGATED-SHEET-UNCOLORED-GALVANIZED-METALLIC-SILVER', 280.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Non Colored Corrugated Sheet Uncolored Galvanized Metallic Silver, per metre.', 'Non Colored Corrugated Sheet Uncolored Galvanized Metallic Silver, per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '32G', 'Uncolored Galvanized'),
(292, 'Translucent Clear Sheet Fiberglass Clear Transparent', 'translucent-clear-sheet-fiberglass-clear-transparent', NULL, 31, NULL, 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-CLEAR-TRANSPARENT', 950.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Translucent fiberglass sheet in Clear Transparent, priced per metre. The custom length option is priced at 1500 per metre.', 'Translucent fiberglass sheet in Clear Transparent, priced per metre. The custom length option is priced at 1500 per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, 'Standard Thickness', 'Fiberglass'),
(293, 'Translucent Clear Sheet Fiberglass Opal White', 'translucent-clear-sheet-fiberglass-opal-white', NULL, 31, NULL, 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-OPAL-WHITE', 950.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Translucent fiberglass sheet in Opal White, priced per metre. The custom length option is priced at 1500 per metre.', 'Translucent fiberglass sheet in Opal White, priced per metre. The custom length option is priced at 1500 per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, 'Standard Thickness', 'Fiberglass'),
(294, 'Polycarbonate Sheet', 'polycarbonate-sheet', NULL, 31, NULL, 'POLYCARBONATE-SHEET', 17000.00, NULL, NULL, NULL, 'KES', 200, 5, 0, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Polycarbonate sheet, priced per sheet.', 'Polycarbonate sheet, priced per sheet.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, NULL, NULL),
(295, 'Crimped Roofing Sheet Glossy', 'crimped-roofing-sheet-glossy', NULL, 31, NULL, 'CRIMPED-ROOFING-SHEET-GLOSSY', 1000.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Crimped roofing sheet, glossy finish, priced per metre.', 'Crimped roofing sheet, glossy finish, priced per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(296, 'Crimped Roofing Sheet Matte', 'crimped-roofing-sheet-matte', NULL, 31, NULL, 'CRIMPED-ROOFING-SHEET-MATTE', 1000.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Crimped roofing sheet, matte finish, priced per metre.', 'Crimped roofing sheet, matte finish, priced per metre.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 1, 1.00, 0.10, 30.00, '30G', 'Matte'),
(297, 'Classic Tile Alu Zinc Volcanic Stone Charcoal Grey', 'classic-tile-alu-zinc-volcanic-stone-charcoal-grey', NULL, 26, NULL, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Classic Tile Alu Zinc Volcanic Stone Charcoal Grey, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(298, 'Classic Tile Alu Zinc Volcanic Stone Dark Brown', 'classic-tile-alu-zinc-volcanic-stone-dark-brown', NULL, 26, NULL, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-BROWN', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Classic Tile Alu Zinc Volcanic Stone Dark Brown, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(299, 'Classic Tile Alu Zinc Volcanic Stone Brick Red', 'classic-tile-alu-zinc-volcanic-stone-brick-red', NULL, 26, NULL, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BRICK-RED', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Classic Tile Alu Zinc Volcanic Stone Brick Red, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(300, 'Classic Tile Alu Zinc Volcanic Stone Maroon', 'classic-tile-alu-zinc-volcanic-stone-maroon', NULL, 26, NULL, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Classic Tile Alu Zinc Volcanic Stone Maroon, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(301, 'Classic Tile Alu Zinc Volcanic Stone Black', 'classic-tile-alu-zinc-volcanic-stone-black', NULL, 26, NULL, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Classic Tile Alu Zinc Volcanic Stone Black, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(302, 'Shingles Tile Alu Zinc Volcanic Stone Charcoal Grey', 'shingles-tile-alu-zinc-volcanic-stone-charcoal-grey', NULL, 25, NULL, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Shingles Tile Alu Zinc Volcanic Stone Charcoal Grey, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(303, 'Shingles Tile Alu Zinc Volcanic Stone Bark Wood Brown', 'shingles-tile-alu-zinc-volcanic-stone-bark-wood-brown', NULL, 25, NULL, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BARK-WOOD-BROWN', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Shingles Tile Alu Zinc Volcanic Stone Bark Wood Brown, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(304, 'Shingles Tile Alu Zinc Volcanic Stone Dark Green', 'shingles-tile-alu-zinc-volcanic-stone-dark-green', NULL, 25, NULL, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-GREEN', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Shingles Tile Alu Zinc Volcanic Stone Dark Green, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(305, 'Shingles Tile Alu Zinc Volcanic Stone Black', 'shingles-tile-alu-zinc-volcanic-stone-black', NULL, 25, NULL, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Shingles Tile Alu Zinc Volcanic Stone Black, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(306, 'Milano Tile Alu Zinc Volcanic Stone Charcoal Grey', 'milano-tile-alu-zinc-volcanic-stone-charcoal-grey', NULL, 27, NULL, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Milano Tile Alu Zinc Volcanic Stone Charcoal Grey, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(307, 'Milano Tile Alu Zinc Volcanic Stone Terracotta', 'milano-tile-alu-zinc-volcanic-stone-terracotta', NULL, 27, NULL, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-TERRACOTTA', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Milano Tile Alu Zinc Volcanic Stone Terracotta, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(308, 'Milano Tile Alu Zinc Volcanic Stone Chocolate Brown', 'milano-tile-alu-zinc-volcanic-stone-chocolate-brown', NULL, 27, NULL, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHOCOLATE-BROWN', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Milano Tile Alu Zinc Volcanic Stone Chocolate Brown, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(309, 'Milano Tile Alu Zinc Volcanic Stone Maroon', 'milano-tile-alu-zinc-volcanic-stone-maroon', NULL, 27, NULL, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON', 650.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Milano Tile Alu Zinc Volcanic Stone Maroon, per panel.', '<h3>Stone Coated Roofing Tiles</h3><p>Stone Coated Roofing Tiles represent the pinnacle of roofing excellence, blending the timeless, sophisticated appearance of traditional Mediterranean tiles or asphalt shingles with the modern durability of zinc-aluminium coated steel.</p><p>Popular in Kenya for luxury residential homes and high-profile developments, these sheets feature a tough stone granule finish that effectively dampens rain noise and offers outstanding resistance to UV rays, hail, and extreme weather.</p>', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '28G', 'Alu Zinc Volcanic Stone'),
(310, 'Ridge Cap Glossy Charcoal Grey', 'ridge-cap-glossy-charcoal-grey', NULL, 34, NULL, 'RIDGE-CAP-GLOSSY-CHARCOAL-GREY', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Glossy Charcoal Grey, per 2.0 metre piece.', 'Ridge Cap Glossy Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(311, 'Ridge Cap Glossy Brick Red', 'ridge-cap-glossy-brick-red', NULL, 34, NULL, 'RIDGE-CAP-GLOSSY-BRICK-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Glossy Brick Red, per 2.0 metre piece.', 'Ridge Cap Glossy Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:24', '2026-10-14 16:52:24', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(312, 'Ridge Cap Glossy Tile Red', 'ridge-cap-glossy-tile-red', NULL, 34, NULL, 'RIDGE-CAP-GLOSSY-TILE-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Glossy Tile Red, per 2.0 metre piece.', 'Ridge Cap Glossy Tile Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(313, 'Ridge Cap Glossy Maroon', 'ridge-cap-glossy-maroon', NULL, 34, NULL, 'RIDGE-CAP-GLOSSY-MAROON', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Glossy Maroon, per 2.0 metre piece.', 'Ridge Cap Glossy Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(314, 'Ridge Cap Glossy Jungle Green', 'ridge-cap-glossy-jungle-green', NULL, 34, NULL, 'RIDGE-CAP-GLOSSY-JUNGLE-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Glossy Jungle Green, per 2.0 metre piece.', 'Ridge Cap Glossy Jungle Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(315, 'Ridge Cap Glossy Ocean Blue', 'ridge-cap-glossy-ocean-blue', NULL, 34, NULL, 'RIDGE-CAP-GLOSSY-OCEAN-BLUE', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Glossy Ocean Blue, per 2.0 metre piece.', 'Ridge Cap Glossy Ocean Blue, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy');
INSERT INTO `su_products` (`id`, `name`, `slug`, `brand_id`, `category_id`, `label_id`, `sku`, `price`, `sale_price`, `cost_price`, `original_price`, `currency`, `stock_quantity`, `low_stock_threshold`, `is_variant`, `weight`, `length`, `width`, `height`, `condition`, `condition_notes`, `is_vat_exempt`, `is_active`, `thumbnail`, `short_description`, `detailed_description`, `views`, `created_at`, `updated_at`, `allow_custom_length`, `default_length_m`, `min_length_m`, `max_length_m`, `default_gauge`, `default_finish`) VALUES
(316, 'Ridge Cap Matte Charcoal Grey', 'ridge-cap-matte-charcoal-grey', NULL, 34, NULL, 'RIDGE-CAP-MATTE-CHARCOAL-GREY', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Charcoal Grey, per 2.0 metre piece.', 'Ridge Cap Matte Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(317, 'Ridge Cap Matte Chocolate Brown', 'ridge-cap-matte-chocolate-brown', NULL, 34, NULL, 'RIDGE-CAP-MATTE-CHOCOLATE-BROWN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Chocolate Brown, per 2.0 metre piece.', 'Ridge Cap Matte Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(318, 'Ridge Cap Matte Maroon', 'ridge-cap-matte-maroon', NULL, 34, NULL, 'RIDGE-CAP-MATTE-MAROON', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Maroon, per 2.0 metre piece.', 'Ridge Cap Matte Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(319, 'Ridge Cap Matte Tile Red', 'ridge-cap-matte-tile-red', NULL, 34, NULL, 'RIDGE-CAP-MATTE-TILE-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Tile Red, per 2.0 metre piece.', 'Ridge Cap Matte Tile Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(320, 'Ridge Cap Matte Brick Red', 'ridge-cap-matte-brick-red', NULL, 34, NULL, 'RIDGE-CAP-MATTE-BRICK-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Brick Red, per 2.0 metre piece.', 'Ridge Cap Matte Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(321, 'Ridge Cap Matte Ocean Blue', 'ridge-cap-matte-ocean-blue', NULL, 34, NULL, 'RIDGE-CAP-MATTE-OCEAN-BLUE', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Ocean Blue, per 2.0 metre piece.', 'Ridge Cap Matte Ocean Blue, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(322, 'Ridge Cap Matte Jungle Green', 'ridge-cap-matte-jungle-green', NULL, 34, NULL, 'RIDGE-CAP-MATTE-JUNGLE-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Jungle Green, per 2.0 metre piece.', 'Ridge Cap Matte Jungle Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(323, 'Ridge Cap Matte Dark Green', 'ridge-cap-matte-dark-green', NULL, 34, NULL, 'RIDGE-CAP-MATTE-DARK-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Matte Dark Green, per 2.0 metre piece.', 'Ridge Cap Matte Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(324, 'Roll Top Ridge Cap Glossy Charcoal Grey', 'roll-top-ridge-cap-glossy-charcoal-grey', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-GLOSSY-CHARCOAL-GREY', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Glossy Charcoal Grey, per 2.0 metre piece.', 'Roll Top Ridge Cap Glossy Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(325, 'Roll Top Ridge Cap Glossy Brick Red', 'roll-top-ridge-cap-glossy-brick-red', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-GLOSSY-BRICK-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Glossy Brick Red, per 2.0 metre piece.', 'Roll Top Ridge Cap Glossy Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(326, 'Roll Top Ridge Cap Glossy Tile Red', 'roll-top-ridge-cap-glossy-tile-red', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-GLOSSY-TILE-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Glossy Tile Red, per 2.0 metre piece.', 'Roll Top Ridge Cap Glossy Tile Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(327, 'Roll Top Ridge Cap Glossy Maroon', 'roll-top-ridge-cap-glossy-maroon', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-GLOSSY-MAROON', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Glossy Maroon, per 2.0 metre piece.', 'Roll Top Ridge Cap Glossy Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(328, 'Roll Top Ridge Cap Glossy Jungle Green', 'roll-top-ridge-cap-glossy-jungle-green', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-GLOSSY-JUNGLE-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Glossy Jungle Green, per 2.0 metre piece.', 'Roll Top Ridge Cap Glossy Jungle Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(329, 'Roll Top Ridge Cap Glossy Ocean Blue', 'roll-top-ridge-cap-glossy-ocean-blue', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-GLOSSY-OCEAN-BLUE', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Glossy Ocean Blue, per 2.0 metre piece.', 'Roll Top Ridge Cap Glossy Ocean Blue, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(330, 'Roll Top Ridge Cap Matte Charcoal Grey', 'roll-top-ridge-cap-matte-charcoal-grey', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-CHARCOAL-GREY', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Charcoal Grey, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(331, 'Roll Top Ridge Cap Matte Chocolate Brown', 'roll-top-ridge-cap-matte-chocolate-brown', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-CHOCOLATE-BROWN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Chocolate Brown, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(332, 'Roll Top Ridge Cap Matte Maroon', 'roll-top-ridge-cap-matte-maroon', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-MAROON', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Maroon, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(333, 'Roll Top Ridge Cap Matte Tile Red', 'roll-top-ridge-cap-matte-tile-red', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-TILE-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Tile Red, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Tile Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(334, 'Roll Top Ridge Cap Matte Brick Red', 'roll-top-ridge-cap-matte-brick-red', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-BRICK-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Brick Red, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(335, 'Roll Top Ridge Cap Matte Ocean Blue', 'roll-top-ridge-cap-matte-ocean-blue', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-OCEAN-BLUE', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Ocean Blue, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Ocean Blue, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(336, 'Roll Top Ridge Cap Matte Jungle Green', 'roll-top-ridge-cap-matte-jungle-green', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-JUNGLE-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Jungle Green, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Jungle Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(337, 'Roll Top Ridge Cap Matte Dark Green', 'roll-top-ridge-cap-matte-dark-green', NULL, 34, NULL, 'ROLL-TOP-RIDGE-CAP-MATTE-DARK-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Roll Top Ridge Cap Matte Dark Green, per 2.0 metre piece.', 'Roll Top Ridge Cap Matte Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(338, 'Side Flashing Glossy Charcoal Grey', 'side-flashing-glossy-charcoal-grey', NULL, 36, NULL, 'SIDE-FLASHING-GLOSSY-CHARCOAL-GREY', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Glossy Charcoal Grey, per 2.0 metre piece.', 'Side Flashing Glossy Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(339, 'Side Flashing Glossy Brick Red', 'side-flashing-glossy-brick-red', NULL, 36, NULL, 'SIDE-FLASHING-GLOSSY-BRICK-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Glossy Brick Red, per 2.0 metre piece.', 'Side Flashing Glossy Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(340, 'Side Flashing Glossy Tile Red', 'side-flashing-glossy-tile-red', NULL, 36, NULL, 'SIDE-FLASHING-GLOSSY-TILE-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Glossy Tile Red, per 2.0 metre piece.', 'Side Flashing Glossy Tile Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(341, 'Side Flashing Glossy Maroon', 'side-flashing-glossy-maroon', NULL, 36, NULL, 'SIDE-FLASHING-GLOSSY-MAROON', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Glossy Maroon, per 2.0 metre piece.', 'Side Flashing Glossy Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(342, 'Side Flashing Glossy Jungle Green', 'side-flashing-glossy-jungle-green', NULL, 36, NULL, 'SIDE-FLASHING-GLOSSY-JUNGLE-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Glossy Jungle Green, per 2.0 metre piece.', 'Side Flashing Glossy Jungle Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(343, 'Side Flashing Glossy Ocean Blue', 'side-flashing-glossy-ocean-blue', NULL, 36, NULL, 'SIDE-FLASHING-GLOSSY-OCEAN-BLUE', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Glossy Ocean Blue, per 2.0 metre piece.', 'Side Flashing Glossy Ocean Blue, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Glossy'),
(344, 'Side Flashing Matte Charcoal Grey', 'side-flashing-matte-charcoal-grey', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-CHARCOAL-GREY', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Charcoal Grey, per 2.0 metre piece.', 'Side Flashing Matte Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(345, 'Side Flashing Matte Chocolate Brown', 'side-flashing-matte-chocolate-brown', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-CHOCOLATE-BROWN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Chocolate Brown, per 2.0 metre piece.', 'Side Flashing Matte Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(346, 'Side Flashing Matte Maroon', 'side-flashing-matte-maroon', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-MAROON', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Maroon, per 2.0 metre piece.', 'Side Flashing Matte Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(347, 'Side Flashing Matte Tile Red', 'side-flashing-matte-tile-red', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-TILE-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Tile Red, per 2.0 metre piece.', 'Side Flashing Matte Tile Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(348, 'Side Flashing Matte Brick Red', 'side-flashing-matte-brick-red', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-BRICK-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Brick Red, per 2.0 metre piece.', 'Side Flashing Matte Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(349, 'Side Flashing Matte Ocean Blue', 'side-flashing-matte-ocean-blue', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-OCEAN-BLUE', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Ocean Blue, per 2.0 metre piece.', 'Side Flashing Matte Ocean Blue, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(350, 'Side Flashing Matte Jungle Green', 'side-flashing-matte-jungle-green', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-JUNGLE-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Jungle Green, per 2.0 metre piece.', 'Side Flashing Matte Jungle Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(351, 'Side Flashing Matte Dark Green', 'side-flashing-matte-dark-green', NULL, 36, NULL, 'SIDE-FLASHING-MATTE-DARK-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Matte Dark Green, per 2.0 metre piece.', 'Side Flashing Matte Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Matte'),
(352, 'Valley Tray Galvanized Metallic Silver', 'valley-tray-galvanized-metallic-silver', NULL, 35, NULL, 'VALLEY-TRAY-GALVANIZED-METALLIC-SILVER', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Galvanized Metallic Silver, per 2.0 metre piece.', 'Valley Tray Galvanized Metallic Silver, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Galvanized'),
(353, 'Valley Tray Color Coated Charcoal Grey', 'valley-tray-color-coated-charcoal-grey', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-CHARCOAL-GREY', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Charcoal Grey, per 2.0 metre piece.', 'Valley Tray Color Coated Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(354, 'Valley Tray Color Coated Brick Red', 'valley-tray-color-coated-brick-red', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-BRICK-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Brick Red, per 2.0 metre piece.', 'Valley Tray Color Coated Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(355, 'Valley Tray Color Coated Tile Red', 'valley-tray-color-coated-tile-red', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-TILE-RED', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Tile Red, per 2.0 metre piece.', 'Valley Tray Color Coated Tile Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(356, 'Valley Tray Color Coated Maroon', 'valley-tray-color-coated-maroon', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-MAROON', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Maroon, per 2.0 metre piece.', 'Valley Tray Color Coated Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(357, 'Valley Tray Color Coated Jungle Green', 'valley-tray-color-coated-jungle-green', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-JUNGLE-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Jungle Green, per 2.0 metre piece.', 'Valley Tray Color Coated Jungle Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(358, 'Valley Tray Color Coated Ocean Blue', 'valley-tray-color-coated-ocean-blue', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-OCEAN-BLUE', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Ocean Blue, per 2.0 metre piece.', 'Valley Tray Color Coated Ocean Blue, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(359, 'Valley Tray Color Coated Chocolate Brown', 'valley-tray-color-coated-chocolate-brown', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-CHOCOLATE-BROWN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Chocolate Brown, per 2.0 metre piece.', 'Valley Tray Color Coated Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(360, 'Valley Tray Color Coated Dark Green', 'valley-tray-color-coated-dark-green', NULL, 35, NULL, 'VALLEY-TRAY-COLOR-COATED-DARK-GREEN', 300.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Color Coated Dark Green, per 2.0 metre piece.', 'Valley Tray Color Coated Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 0, 3.00, 0.10, 30.00, '30G', 'Color Coated'),
(361, 'Plain Sheet Glossy Charcoal Grey', 'plain-sheet-glossy-charcoal-grey', NULL, 37, NULL, 'PLAIN-SHEET-GLOSSY-CHARCOAL-GREY', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Glossy Charcoal Grey, per metre.', 'Plain Sheet Glossy Charcoal Grey, per metre.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(362, 'Plain Sheet Glossy Brick Red', 'plain-sheet-glossy-brick-red', NULL, 37, NULL, 'PLAIN-SHEET-GLOSSY-BRICK-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Glossy Brick Red, per metre.', 'Plain Sheet Glossy Brick Red, per metre.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(363, 'Plain Sheet Glossy Tile Red', 'plain-sheet-glossy-tile-red', NULL, 37, NULL, 'PLAIN-SHEET-GLOSSY-TILE-RED', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Glossy Tile Red, per metre.', 'Plain Sheet Glossy Tile Red, per metre.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(364, 'Plain Sheet Glossy Maroon', 'plain-sheet-glossy-maroon', NULL, 37, NULL, 'PLAIN-SHEET-GLOSSY-MAROON', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Glossy Maroon, per metre.', 'Plain Sheet Glossy Maroon, per metre.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(365, 'Plain Sheet Glossy Jungle Green', 'plain-sheet-glossy-jungle-green', NULL, 37, NULL, 'PLAIN-SHEET-GLOSSY-JUNGLE-GREEN', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Glossy Jungle Green, per metre.', 'Plain Sheet Glossy Jungle Green, per metre.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(366, 'Plain Sheet Glossy Ocean Blue', 'plain-sheet-glossy-ocean-blue', NULL, 37, NULL, 'PLAIN-SHEET-GLOSSY-OCEAN-BLUE', 600.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Glossy Ocean Blue, per metre.', 'Plain Sheet Glossy Ocean Blue, per metre.', 0, '2026-10-14 16:52:25', '2026-10-14 16:52:25', 1, 1.00, 0.10, 30.00, '30G', 'Glossy'),
(367, 'Normal Roofing Nails Non Coloured', 'normal-roofing-nails-non-coloured', NULL, 38, NULL, 'NORMAL-ROOFING-NAILS-NON-COLOURED', 250.00, NULL, NULL, NULL, 'KES', 200, 5, 0, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Normal roofing nails, non coloured, priced per kg.', 'Normal roofing nails, non coloured, priced per kg.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, NULL, NULL),
(368, 'Rubber Washers Coloured', 'rubber-washers-coloured', NULL, 39, NULL, 'RUBBER-WASHERS-COLOURED', 100.00, NULL, NULL, NULL, 'KES', 200, 5, 0, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Coloured rubber washers, priced per packet.', 'Coloured rubber washers, priced per packet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, NULL, NULL),
(369, 'PVC Gutters', 'pvc-gutters', NULL, 40, NULL, 'PVC-GUTTERS', 1500.00, NULL, NULL, NULL, 'KES', 200, 5, 0, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'PVC gutters.\nGutter 1500 per piece\nClips 150\nConnectors 450 per piece\nDown pipe 1500 per piece\nThe rest 450 per piece', 'PVC gutters.\nGutter 1500 per piece\nClips 150\nConnectors 450 per piece\nDown pipe 1500 per piece\nThe rest 450 per piece', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, NULL, NULL),
(370, 'Valley Tray Stone Coated Charcoal Grey', 'valley-tray-stone-coated-charcoal-grey', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-CHARCOAL-GREY', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Charcoal Grey, per 2.0 metre piece.', 'Valley Tray Stone Coated Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(371, 'Valley Tray Stone Coated Dark Brown', 'valley-tray-stone-coated-dark-brown', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-DARK-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Dark Brown, per 2.0 metre piece.', 'Valley Tray Stone Coated Dark Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(372, 'Valley Tray Stone Coated Brick Red', 'valley-tray-stone-coated-brick-red', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-BRICK-RED', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Brick Red, per 2.0 metre piece.', 'Valley Tray Stone Coated Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(373, 'Valley Tray Stone Coated Maroon', 'valley-tray-stone-coated-maroon', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-MAROON', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Maroon, per 2.0 metre piece.', 'Valley Tray Stone Coated Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(374, 'Valley Tray Stone Coated Black', 'valley-tray-stone-coated-black', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-BLACK', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Black, per 2.0 metre piece.', 'Valley Tray Stone Coated Black, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(375, 'Valley Tray Stone Coated Bark Wood Brown', 'valley-tray-stone-coated-bark-wood-brown', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-BARK-WOOD-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Bark Wood Brown, per 2.0 metre piece.', 'Valley Tray Stone Coated Bark Wood Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(376, 'Valley Tray Stone Coated Dark Green', 'valley-tray-stone-coated-dark-green', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-DARK-GREEN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Dark Green, per 2.0 metre piece.', 'Valley Tray Stone Coated Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(377, 'Valley Tray Stone Coated Terracotta', 'valley-tray-stone-coated-terracotta', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-TERRACOTTA', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Terracotta, per 2.0 metre piece.', 'Valley Tray Stone Coated Terracotta, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(378, 'Valley Tray Stone Coated Chocolate Brown', 'valley-tray-stone-coated-chocolate-brown', NULL, 33, NULL, 'VALLEY-TRAY-STONE-COATED-CHOCOLATE-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Valley Tray Stone Coated Chocolate Brown, per 2.0 metre piece.', 'Valley Tray Stone Coated Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(379, 'Ridge Cap Stone Coated Charcoal Grey', 'ridge-cap-stone-coated-charcoal-grey', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-CHARCOAL-GREY', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Charcoal Grey, per 2.0 metre piece.', 'Ridge Cap Stone Coated Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(380, 'Ridge Cap Stone Coated Dark Brown', 'ridge-cap-stone-coated-dark-brown', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-DARK-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Dark Brown, per 2.0 metre piece.', 'Ridge Cap Stone Coated Dark Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(381, 'Ridge Cap Stone Coated Brick Red', 'ridge-cap-stone-coated-brick-red', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-BRICK-RED', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Brick Red, per 2.0 metre piece.', 'Ridge Cap Stone Coated Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(382, 'Ridge Cap Stone Coated Maroon', 'ridge-cap-stone-coated-maroon', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-MAROON', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Maroon, per 2.0 metre piece.', 'Ridge Cap Stone Coated Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(383, 'Ridge Cap Stone Coated Black', 'ridge-cap-stone-coated-black', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-BLACK', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Black, per 2.0 metre piece.', 'Ridge Cap Stone Coated Black, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(384, 'Ridge Cap Stone Coated Bark Wood Brown', 'ridge-cap-stone-coated-bark-wood-brown', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-BARK-WOOD-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Bark Wood Brown, per 2.0 metre piece.', 'Ridge Cap Stone Coated Bark Wood Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(385, 'Ridge Cap Stone Coated Dark Green', 'ridge-cap-stone-coated-dark-green', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-DARK-GREEN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Dark Green, per 2.0 metre piece.', 'Ridge Cap Stone Coated Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(386, 'Ridge Cap Stone Coated Terracotta', 'ridge-cap-stone-coated-terracotta', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-TERRACOTTA', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Terracotta, per 2.0 metre piece.', 'Ridge Cap Stone Coated Terracotta, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(387, 'Ridge Cap Stone Coated Chocolate Brown', 'ridge-cap-stone-coated-chocolate-brown', NULL, 33, NULL, 'RIDGE-CAP-STONE-COATED-CHOCOLATE-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Ridge Cap Stone Coated Chocolate Brown, per 2.0 metre piece.', 'Ridge Cap Stone Coated Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(388, 'Side Flashing Stone Coated Charcoal Grey', 'side-flashing-stone-coated-charcoal-grey', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-CHARCOAL-GREY', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Charcoal Grey, per 2.0 metre piece.', 'Side Flashing Stone Coated Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(389, 'Side Flashing Stone Coated Dark Brown', 'side-flashing-stone-coated-dark-brown', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-DARK-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Dark Brown, per 2.0 metre piece.', 'Side Flashing Stone Coated Dark Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(390, 'Side Flashing Stone Coated Brick Red', 'side-flashing-stone-coated-brick-red', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-BRICK-RED', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Brick Red, per 2.0 metre piece.', 'Side Flashing Stone Coated Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(391, 'Side Flashing Stone Coated Maroon', 'side-flashing-stone-coated-maroon', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-MAROON', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Maroon, per 2.0 metre piece.', 'Side Flashing Stone Coated Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(392, 'Side Flashing Stone Coated Black', 'side-flashing-stone-coated-black', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-BLACK', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Black, per 2.0 metre piece.', 'Side Flashing Stone Coated Black, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(393, 'Side Flashing Stone Coated Bark Wood Brown', 'side-flashing-stone-coated-bark-wood-brown', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-BARK-WOOD-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Bark Wood Brown, per 2.0 metre piece.', 'Side Flashing Stone Coated Bark Wood Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(394, 'Side Flashing Stone Coated Dark Green', 'side-flashing-stone-coated-dark-green', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-DARK-GREEN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Dark Green, per 2.0 metre piece.', 'Side Flashing Stone Coated Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(395, 'Side Flashing Stone Coated Terracotta', 'side-flashing-stone-coated-terracotta', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-TERRACOTTA', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Terracotta, per 2.0 metre piece.', 'Side Flashing Stone Coated Terracotta, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(396, 'Side Flashing Stone Coated Chocolate Brown', 'side-flashing-stone-coated-chocolate-brown', NULL, 33, NULL, 'SIDE-FLASHING-STONE-COATED-CHOCOLATE-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Side Flashing Stone Coated Chocolate Brown, per 2.0 metre piece.', 'Side Flashing Stone Coated Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(397, 'Plain Sheet Stone Coated Charcoal Grey', 'plain-sheet-stone-coated-charcoal-grey', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-CHARCOAL-GREY', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Charcoal Grey, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Charcoal Grey, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(398, 'Plain Sheet Stone Coated Dark Brown', 'plain-sheet-stone-coated-dark-brown', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-DARK-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Dark Brown, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Dark Brown, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(399, 'Plain Sheet Stone Coated Brick Red', 'plain-sheet-stone-coated-brick-red', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-BRICK-RED', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Brick Red, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Brick Red, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(400, 'Plain Sheet Stone Coated Maroon', 'plain-sheet-stone-coated-maroon', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-MAROON', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Maroon, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Maroon, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(401, 'Plain Sheet Stone Coated Black', 'plain-sheet-stone-coated-black', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-BLACK', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Black, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Black, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(402, 'Plain Sheet Stone Coated Bark Wood Brown', 'plain-sheet-stone-coated-bark-wood-brown', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-BARK-WOOD-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Bark Wood Brown, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Bark Wood Brown, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(403, 'Plain Sheet Stone Coated Dark Green', 'plain-sheet-stone-coated-dark-green', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-DARK-GREEN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Dark Green, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Dark Green, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(404, 'Plain Sheet Stone Coated Terracotta', 'plain-sheet-stone-coated-terracotta', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-TERRACOTTA', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Terracotta, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Terracotta, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(405, 'Plain Sheet Stone Coated Chocolate Brown', 'plain-sheet-stone-coated-chocolate-brown', NULL, 33, NULL, 'PLAIN-SHEET-STONE-COATED-CHOCOLATE-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Plain Sheet Stone Coated Chocolate Brown, per 2.0M x 0.45M sheet.', 'Plain Sheet Stone Coated Chocolate Brown, per 2.0M x 0.45M sheet.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(406, 'Barge Box Stone Coated Charcoal Grey', 'barge-box-stone-coated-charcoal-grey', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-CHARCOAL-GREY', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Charcoal Grey, per 2.0 metre piece.', 'Barge Box Stone Coated Charcoal Grey, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(407, 'Barge Box Stone Coated Dark Brown', 'barge-box-stone-coated-dark-brown', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-DARK-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Dark Brown, per 2.0 metre piece.', 'Barge Box Stone Coated Dark Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(408, 'Barge Box Stone Coated Brick Red', 'barge-box-stone-coated-brick-red', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-BRICK-RED', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Brick Red, per 2.0 metre piece.', 'Barge Box Stone Coated Brick Red, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(409, 'Barge Box Stone Coated Maroon', 'barge-box-stone-coated-maroon', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-MAROON', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Maroon, per 2.0 metre piece.', 'Barge Box Stone Coated Maroon, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(410, 'Barge Box Stone Coated Black', 'barge-box-stone-coated-black', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-BLACK', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Black, per 2.0 metre piece.', 'Barge Box Stone Coated Black, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(411, 'Barge Box Stone Coated Bark Wood Brown', 'barge-box-stone-coated-bark-wood-brown', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-BARK-WOOD-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Bark Wood Brown, per 2.0 metre piece.', 'Barge Box Stone Coated Bark Wood Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(412, 'Barge Box Stone Coated Dark Green', 'barge-box-stone-coated-dark-green', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-DARK-GREEN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Dark Green, per 2.0 metre piece.', 'Barge Box Stone Coated Dark Green, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(413, 'Barge Box Stone Coated Terracotta', 'barge-box-stone-coated-terracotta', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-TERRACOTTA', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Terracotta, per 2.0 metre piece.', 'Barge Box Stone Coated Terracotta, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(414, 'Barge Box Stone Coated Chocolate Brown', 'barge-box-stone-coated-chocolate-brown', NULL, 32, NULL, 'BARGE-BOX-STONE-COATED-CHOCOLATE-BROWN', 750.00, NULL, NULL, NULL, 'KES', 200, 5, 1, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Barge Box Stone Coated Chocolate Brown, per 2.0 metre piece.', 'Barge Box Stone Coated Chocolate Brown, per 2.0 metre piece.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, '28G', 'Stone Coated'),
(415, 'Touch Up Kit Glue Chips', 'touch-up-kit-glue-chips', NULL, 32, NULL, 'TOUCH-UP-KIT-GLUE-CHIPS', 800.00, NULL, NULL, NULL, 'KES', 200, 5, 0, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Natural chips and adhesive for repairs and cuts. Covers about 100 sq.m of roof.', 'Natural chips and adhesive for repairs and cuts. Covers about 100 sq.m of roof.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, NULL, NULL),
(416, 'Serrated Ring Shank Nails Galvanized', 'serrated-ring-shank-nails-galvanized', NULL, 32, NULL, 'SERRATED-RING-SHANK-NAILS-GALVANIZED', 800.00, NULL, NULL, NULL, 'KES', 200, 5, 0, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Heavy duty galvanized side fixing nails. 1 kg pack, about 250 pieces.', 'Heavy duty galvanized side fixing nails. 1 kg pack, about 250 pieces.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, NULL, NULL),
(417, 'Roofing Nails and Rubber Washers', 'roofing-nails-and-rubber-washers', NULL, 33, NULL, 'ROOFING-NAILS-AND-RUBBER-WASHERS', 800.00, NULL, NULL, NULL, 'KES', 200, 5, 0, NULL, NULL, NULL, NULL, 'new', NULL, 0, 1, NULL, 'Standard galvanized spiral roofing nails with rubber washers. 1 kg pack.', 'Standard galvanized spiral roofing nails with rubber washers. 1 kg pack.', 0, '2026-10-14 16:52:26', '2026-10-14 16:52:26', 0, 3.00, 0.10, 30.00, NULL, NULL);

--
-- Triggers `su_products`
--
DELIMITER $$
CREATE TRIGGER `trg_su_products_default_category_insert` BEFORE INSERT ON `su_products` FOR EACH ROW BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (SELECT id FROM su_product_categories WHERE is_default = 1 LIMIT 1);
                END IF;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_su_products_default_category_update` BEFORE UPDATE ON `su_products` FOR EACH ROW BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (SELECT id FROM su_product_categories WHERE is_default = 1 LIMIT 1);
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `su_product_attributes`
--

CREATE TABLE `su_product_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_product_attributes`
--

INSERT INTO `su_product_attributes` (`id`, `product_id`, `name`, `slug`, `created_at`) VALUES
(93, 256, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(94, 256, 'Finish', 'finish', '2026-10-14 16:52:23'),
(95, 257, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(96, 257, 'Finish', 'finish', '2026-10-14 16:52:23'),
(97, 258, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(98, 258, 'Finish', 'finish', '2026-10-14 16:52:23'),
(99, 259, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(100, 259, 'Finish', 'finish', '2026-10-14 16:52:23'),
(101, 260, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(102, 260, 'Finish', 'finish', '2026-10-14 16:52:23'),
(103, 261, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(104, 261, 'Finish', 'finish', '2026-10-14 16:52:23'),
(105, 262, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(106, 262, 'Finish', 'finish', '2026-10-14 16:52:23'),
(107, 263, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(108, 263, 'Finish', 'finish', '2026-10-14 16:52:23'),
(109, 264, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(110, 264, 'Finish', 'finish', '2026-10-14 16:52:23'),
(111, 265, 'Gauge', 'gauge', '2026-10-14 16:52:23'),
(112, 265, 'Finish', 'finish', '2026-10-14 16:52:23'),
(113, 266, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(114, 266, 'Finish', 'finish', '2026-10-14 16:52:24'),
(115, 267, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(116, 267, 'Finish', 'finish', '2026-10-14 16:52:24'),
(117, 268, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(118, 268, 'Finish', 'finish', '2026-10-14 16:52:24'),
(119, 269, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(120, 269, 'Finish', 'finish', '2026-10-14 16:52:24'),
(121, 270, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(122, 270, 'Finish', 'finish', '2026-10-14 16:52:24'),
(123, 271, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(124, 271, 'Finish', 'finish', '2026-10-14 16:52:24'),
(125, 272, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(126, 272, 'Finish', 'finish', '2026-10-14 16:52:24'),
(127, 273, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(128, 273, 'Finish', 'finish', '2026-10-14 16:52:24'),
(129, 274, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(130, 274, 'Finish', 'finish', '2026-10-14 16:52:24'),
(131, 275, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(132, 275, 'Finish', 'finish', '2026-10-14 16:52:24'),
(133, 276, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(134, 276, 'Finish', 'finish', '2026-10-14 16:52:24'),
(135, 277, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(136, 277, 'Finish', 'finish', '2026-10-14 16:52:24'),
(137, 278, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(138, 278, 'Finish', 'finish', '2026-10-14 16:52:24'),
(139, 279, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(140, 279, 'Finish', 'finish', '2026-10-14 16:52:24'),
(141, 280, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(142, 280, 'Finish', 'finish', '2026-10-14 16:52:24'),
(143, 281, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(144, 281, 'Finish', 'finish', '2026-10-14 16:52:24'),
(145, 282, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(146, 282, 'Finish', 'finish', '2026-10-14 16:52:24'),
(147, 283, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(148, 283, 'Finish', 'finish', '2026-10-14 16:52:24'),
(149, 284, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(150, 284, 'Finish', 'finish', '2026-10-14 16:52:24'),
(151, 285, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(152, 285, 'Finish', 'finish', '2026-10-14 16:52:24'),
(153, 286, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(154, 286, 'Finish', 'finish', '2026-10-14 16:52:24'),
(155, 287, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(156, 287, 'Finish', 'finish', '2026-10-14 16:52:24'),
(157, 288, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(158, 288, 'Finish', 'finish', '2026-10-14 16:52:24'),
(159, 289, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(160, 289, 'Finish', 'finish', '2026-10-14 16:52:24'),
(161, 290, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(162, 290, 'Finish', 'finish', '2026-10-14 16:52:24'),
(163, 291, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(164, 291, 'Finish', 'finish', '2026-10-14 16:52:24'),
(165, 292, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(166, 292, 'Finish', 'finish', '2026-10-14 16:52:24'),
(167, 293, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(168, 293, 'Finish', 'finish', '2026-10-14 16:52:24'),
(169, 295, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(170, 295, 'Finish', 'finish', '2026-10-14 16:52:24'),
(171, 296, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(172, 296, 'Finish', 'finish', '2026-10-14 16:52:24'),
(173, 297, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(174, 297, 'Finish', 'finish', '2026-10-14 16:52:24'),
(175, 298, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(176, 298, 'Finish', 'finish', '2026-10-14 16:52:24'),
(177, 299, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(178, 299, 'Finish', 'finish', '2026-10-14 16:52:24'),
(179, 300, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(180, 300, 'Finish', 'finish', '2026-10-14 16:52:24'),
(181, 301, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(182, 301, 'Finish', 'finish', '2026-10-14 16:52:24'),
(183, 302, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(184, 302, 'Finish', 'finish', '2026-10-14 16:52:24'),
(185, 303, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(186, 303, 'Finish', 'finish', '2026-10-14 16:52:24'),
(187, 304, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(188, 304, 'Finish', 'finish', '2026-10-14 16:52:24'),
(189, 305, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(190, 305, 'Finish', 'finish', '2026-10-14 16:52:24'),
(191, 306, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(192, 306, 'Finish', 'finish', '2026-10-14 16:52:24'),
(193, 307, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(194, 307, 'Finish', 'finish', '2026-10-14 16:52:24'),
(195, 308, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(196, 308, 'Finish', 'finish', '2026-10-14 16:52:24'),
(197, 309, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(198, 309, 'Finish', 'finish', '2026-10-14 16:52:24'),
(199, 310, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(200, 310, 'Finish', 'finish', '2026-10-14 16:52:24'),
(201, 311, 'Gauge', 'gauge', '2026-10-14 16:52:24'),
(202, 311, 'Finish', 'finish', '2026-10-14 16:52:24'),
(203, 312, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(204, 312, 'Finish', 'finish', '2026-10-14 16:52:25'),
(205, 313, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(206, 313, 'Finish', 'finish', '2026-10-14 16:52:25'),
(207, 314, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(208, 314, 'Finish', 'finish', '2026-10-14 16:52:25'),
(209, 315, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(210, 315, 'Finish', 'finish', '2026-10-14 16:52:25'),
(211, 316, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(212, 316, 'Finish', 'finish', '2026-10-14 16:52:25'),
(213, 317, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(214, 317, 'Finish', 'finish', '2026-10-14 16:52:25'),
(215, 318, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(216, 318, 'Finish', 'finish', '2026-10-14 16:52:25'),
(217, 319, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(218, 319, 'Finish', 'finish', '2026-10-14 16:52:25'),
(219, 320, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(220, 320, 'Finish', 'finish', '2026-10-14 16:52:25'),
(221, 321, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(222, 321, 'Finish', 'finish', '2026-10-14 16:52:25'),
(223, 322, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(224, 322, 'Finish', 'finish', '2026-10-14 16:52:25'),
(225, 323, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(226, 323, 'Finish', 'finish', '2026-10-14 16:52:25'),
(227, 324, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(228, 324, 'Finish', 'finish', '2026-10-14 16:52:25'),
(229, 325, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(230, 325, 'Finish', 'finish', '2026-10-14 16:52:25'),
(231, 326, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(232, 326, 'Finish', 'finish', '2026-10-14 16:52:25'),
(233, 327, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(234, 327, 'Finish', 'finish', '2026-10-14 16:52:25'),
(235, 328, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(236, 328, 'Finish', 'finish', '2026-10-14 16:52:25'),
(237, 329, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(238, 329, 'Finish', 'finish', '2026-10-14 16:52:25'),
(239, 330, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(240, 330, 'Finish', 'finish', '2026-10-14 16:52:25'),
(241, 331, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(242, 331, 'Finish', 'finish', '2026-10-14 16:52:25'),
(243, 332, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(244, 332, 'Finish', 'finish', '2026-10-14 16:52:25'),
(245, 333, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(246, 333, 'Finish', 'finish', '2026-10-14 16:52:25'),
(247, 334, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(248, 334, 'Finish', 'finish', '2026-10-14 16:52:25'),
(249, 335, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(250, 335, 'Finish', 'finish', '2026-10-14 16:52:25'),
(251, 336, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(252, 336, 'Finish', 'finish', '2026-10-14 16:52:25'),
(253, 337, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(254, 337, 'Finish', 'finish', '2026-10-14 16:52:25'),
(255, 338, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(256, 338, 'Finish', 'finish', '2026-10-14 16:52:25'),
(257, 339, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(258, 339, 'Finish', 'finish', '2026-10-14 16:52:25'),
(259, 340, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(260, 340, 'Finish', 'finish', '2026-10-14 16:52:25'),
(261, 341, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(262, 341, 'Finish', 'finish', '2026-10-14 16:52:25'),
(263, 342, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(264, 342, 'Finish', 'finish', '2026-10-14 16:52:25'),
(265, 343, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(266, 343, 'Finish', 'finish', '2026-10-14 16:52:25'),
(267, 344, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(268, 344, 'Finish', 'finish', '2026-10-14 16:52:25'),
(269, 345, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(270, 345, 'Finish', 'finish', '2026-10-14 16:52:25'),
(271, 346, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(272, 346, 'Finish', 'finish', '2026-10-14 16:52:25'),
(273, 347, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(274, 347, 'Finish', 'finish', '2026-10-14 16:52:25'),
(275, 348, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(276, 348, 'Finish', 'finish', '2026-10-14 16:52:25'),
(277, 349, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(278, 349, 'Finish', 'finish', '2026-10-14 16:52:25'),
(279, 350, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(280, 350, 'Finish', 'finish', '2026-10-14 16:52:25'),
(281, 351, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(282, 351, 'Finish', 'finish', '2026-10-14 16:52:25'),
(283, 352, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(284, 352, 'Finish', 'finish', '2026-10-14 16:52:25'),
(285, 353, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(286, 353, 'Finish', 'finish', '2026-10-14 16:52:25'),
(287, 354, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(288, 354, 'Finish', 'finish', '2026-10-14 16:52:25'),
(289, 355, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(290, 355, 'Finish', 'finish', '2026-10-14 16:52:25'),
(291, 356, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(292, 356, 'Finish', 'finish', '2026-10-14 16:52:25'),
(293, 357, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(294, 357, 'Finish', 'finish', '2026-10-14 16:52:25'),
(295, 358, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(296, 358, 'Finish', 'finish', '2026-10-14 16:52:25'),
(297, 359, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(298, 359, 'Finish', 'finish', '2026-10-14 16:52:25'),
(299, 360, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(300, 360, 'Finish', 'finish', '2026-10-14 16:52:25'),
(301, 361, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(302, 361, 'Finish', 'finish', '2026-10-14 16:52:25'),
(303, 362, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(304, 362, 'Finish', 'finish', '2026-10-14 16:52:25'),
(305, 363, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(306, 363, 'Finish', 'finish', '2026-10-14 16:52:25'),
(307, 364, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(308, 364, 'Finish', 'finish', '2026-10-14 16:52:25'),
(309, 365, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(310, 365, 'Finish', 'finish', '2026-10-14 16:52:25'),
(311, 366, 'Gauge', 'gauge', '2026-10-14 16:52:25'),
(312, 366, 'Finish', 'finish', '2026-10-14 16:52:26'),
(313, 370, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(314, 370, 'Finish', 'finish', '2026-10-14 16:52:26'),
(315, 371, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(316, 371, 'Finish', 'finish', '2026-10-14 16:52:26'),
(317, 372, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(318, 372, 'Finish', 'finish', '2026-10-14 16:52:26'),
(319, 373, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(320, 373, 'Finish', 'finish', '2026-10-14 16:52:26'),
(321, 374, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(322, 374, 'Finish', 'finish', '2026-10-14 16:52:26'),
(323, 375, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(324, 375, 'Finish', 'finish', '2026-10-14 16:52:26'),
(325, 376, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(326, 376, 'Finish', 'finish', '2026-10-14 16:52:26'),
(327, 377, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(328, 377, 'Finish', 'finish', '2026-10-14 16:52:26'),
(329, 378, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(330, 378, 'Finish', 'finish', '2026-10-14 16:52:26'),
(331, 379, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(332, 379, 'Finish', 'finish', '2026-10-14 16:52:26'),
(333, 380, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(334, 380, 'Finish', 'finish', '2026-10-14 16:52:26'),
(335, 381, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(336, 381, 'Finish', 'finish', '2026-10-14 16:52:26'),
(337, 382, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(338, 382, 'Finish', 'finish', '2026-10-14 16:52:26'),
(339, 383, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(340, 383, 'Finish', 'finish', '2026-10-14 16:52:26'),
(341, 384, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(342, 384, 'Finish', 'finish', '2026-10-14 16:52:26'),
(343, 385, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(344, 385, 'Finish', 'finish', '2026-10-14 16:52:26'),
(345, 386, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(346, 386, 'Finish', 'finish', '2026-10-14 16:52:26'),
(347, 387, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(348, 387, 'Finish', 'finish', '2026-10-14 16:52:26'),
(349, 388, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(350, 388, 'Finish', 'finish', '2026-10-14 16:52:26'),
(351, 389, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(352, 389, 'Finish', 'finish', '2026-10-14 16:52:26'),
(353, 390, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(354, 390, 'Finish', 'finish', '2026-10-14 16:52:26'),
(355, 391, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(356, 391, 'Finish', 'finish', '2026-10-14 16:52:26'),
(357, 392, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(358, 392, 'Finish', 'finish', '2026-10-14 16:52:26'),
(359, 393, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(360, 393, 'Finish', 'finish', '2026-10-14 16:52:26'),
(361, 394, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(362, 394, 'Finish', 'finish', '2026-10-14 16:52:26'),
(363, 395, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(364, 395, 'Finish', 'finish', '2026-10-14 16:52:26'),
(365, 396, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(366, 396, 'Finish', 'finish', '2026-10-14 16:52:26'),
(367, 397, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(368, 397, 'Finish', 'finish', '2026-10-14 16:52:26'),
(369, 398, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(370, 398, 'Finish', 'finish', '2026-10-14 16:52:26'),
(371, 399, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(372, 399, 'Finish', 'finish', '2026-10-14 16:52:26'),
(373, 400, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(374, 400, 'Finish', 'finish', '2026-10-14 16:52:26'),
(375, 401, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(376, 401, 'Finish', 'finish', '2026-10-14 16:52:26'),
(377, 402, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(378, 402, 'Finish', 'finish', '2026-10-14 16:52:26'),
(379, 403, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(380, 403, 'Finish', 'finish', '2026-10-14 16:52:26'),
(381, 404, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(382, 404, 'Finish', 'finish', '2026-10-14 16:52:26'),
(383, 405, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(384, 405, 'Finish', 'finish', '2026-10-14 16:52:26'),
(385, 406, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(386, 406, 'Finish', 'finish', '2026-10-14 16:52:26'),
(387, 407, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(388, 407, 'Finish', 'finish', '2026-10-14 16:52:26'),
(389, 408, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(390, 408, 'Finish', 'finish', '2026-10-14 16:52:26'),
(391, 409, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(392, 409, 'Finish', 'finish', '2026-10-14 16:52:26'),
(393, 410, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(394, 410, 'Finish', 'finish', '2026-10-14 16:52:26'),
(395, 411, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(396, 411, 'Finish', 'finish', '2026-10-14 16:52:26'),
(397, 412, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(398, 412, 'Finish', 'finish', '2026-10-14 16:52:26'),
(399, 413, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(400, 413, 'Finish', 'finish', '2026-10-14 16:52:26'),
(401, 414, 'Gauge', 'gauge', '2026-10-14 16:52:26'),
(402, 414, 'Finish', 'finish', '2026-10-14 16:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `su_product_attribute_values`
--

CREATE TABLE `su_product_attribute_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `attribute_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_product_attribute_values`
--

INSERT INTO `su_product_attribute_values` (`id`, `attribute_id`, `value`, `slug`, `created_at`) VALUES
(178, 93, '30G', '30g', '2026-10-14 16:52:23'),
(179, 93, '28G', '28g', '2026-10-14 16:52:23'),
(180, 94, 'Glossy', 'glossy', '2026-10-14 16:52:23'),
(181, 95, '30G', '30g', '2026-10-14 16:52:23'),
(182, 95, '28G', '28g', '2026-10-14 16:52:23'),
(183, 96, 'Glossy', 'glossy', '2026-10-14 16:52:23'),
(184, 97, '30G', '30g', '2026-10-14 16:52:23'),
(185, 97, '28G', '28g', '2026-10-14 16:52:23'),
(186, 98, 'Glossy', 'glossy', '2026-10-14 16:52:23'),
(187, 99, '30G', '30g', '2026-10-14 16:52:23'),
(188, 99, '28G', '28g', '2026-10-14 16:52:23'),
(189, 100, 'Glossy', 'glossy', '2026-10-14 16:52:23'),
(190, 101, '30G', '30g', '2026-10-14 16:52:23'),
(191, 101, '28G', '28g', '2026-10-14 16:52:23'),
(192, 102, 'Glossy', 'glossy', '2026-10-14 16:52:23'),
(193, 103, '30G', '30g', '2026-10-14 16:52:23'),
(194, 103, '28G', '28g', '2026-10-14 16:52:23'),
(195, 104, 'Glossy', 'glossy', '2026-10-14 16:52:23'),
(196, 105, '30G', '30g', '2026-10-14 16:52:23'),
(197, 105, '28G', '28g', '2026-10-14 16:52:23'),
(198, 106, 'Matte', 'matte', '2026-10-14 16:52:23'),
(199, 107, '30G', '30g', '2026-10-14 16:52:23'),
(200, 107, '28G', '28g', '2026-10-14 16:52:23'),
(201, 108, 'Matte', 'matte', '2026-10-14 16:52:23'),
(202, 109, '30G', '30g', '2026-10-14 16:52:23'),
(203, 109, '28G', '28g', '2026-10-14 16:52:23'),
(204, 110, 'Matte', 'matte', '2026-10-14 16:52:23'),
(205, 111, '30G', '30g', '2026-10-14 16:52:23'),
(206, 111, '28G', '28g', '2026-10-14 16:52:23'),
(207, 112, 'Matte', 'matte', '2026-10-14 16:52:23'),
(208, 113, '30G', '30g', '2026-10-14 16:52:24'),
(209, 113, '28G', '28g', '2026-10-14 16:52:24'),
(210, 114, 'Matte', 'matte', '2026-10-14 16:52:24'),
(211, 115, '30G', '30g', '2026-10-14 16:52:24'),
(212, 115, '28G', '28g', '2026-10-14 16:52:24'),
(213, 116, 'Matte', 'matte', '2026-10-14 16:52:24'),
(214, 117, '30G', '30g', '2026-10-14 16:52:24'),
(215, 117, '28G', '28g', '2026-10-14 16:52:24'),
(216, 118, 'Matte', 'matte', '2026-10-14 16:52:24'),
(217, 119, '30G', '30g', '2026-10-14 16:52:24'),
(218, 119, '28G', '28g', '2026-10-14 16:52:24'),
(219, 120, 'Matte', 'matte', '2026-10-14 16:52:24'),
(220, 121, '30G', '30g', '2026-10-14 16:52:24'),
(221, 121, '28G', '28g', '2026-10-14 16:52:24'),
(222, 122, 'Matte', 'matte', '2026-10-14 16:52:24'),
(223, 123, '30G', '30g', '2026-10-14 16:52:24'),
(224, 123, '28G', '28g', '2026-10-14 16:52:24'),
(225, 124, 'Matte', 'matte', '2026-10-14 16:52:24'),
(226, 125, '30G', '30g', '2026-10-14 16:52:24'),
(227, 125, '28G', '28g', '2026-10-14 16:52:24'),
(228, 126, 'Matte', 'matte', '2026-10-14 16:52:24'),
(229, 127, '30G', '30g', '2026-10-14 16:52:24'),
(230, 127, '28G', '28g', '2026-10-14 16:52:24'),
(231, 128, 'Matte', 'matte', '2026-10-14 16:52:24'),
(232, 129, '30G', '30g', '2026-10-14 16:52:24'),
(233, 129, '28G', '28g', '2026-10-14 16:52:24'),
(234, 130, 'Matte', 'matte', '2026-10-14 16:52:24'),
(235, 131, '30G', '30g', '2026-10-14 16:52:24'),
(236, 131, '28G', '28g', '2026-10-14 16:52:24'),
(237, 132, 'Matte', 'matte', '2026-10-14 16:52:24'),
(238, 133, '30G', '30g', '2026-10-14 16:52:24'),
(239, 133, '28G', '28g', '2026-10-14 16:52:24'),
(240, 134, 'Matte', 'matte', '2026-10-14 16:52:24'),
(241, 135, '30G', '30g', '2026-10-14 16:52:24'),
(242, 135, '28G', '28g', '2026-10-14 16:52:24'),
(243, 136, 'Matte', 'matte', '2026-10-14 16:52:24'),
(244, 137, '30G', '30g', '2026-10-14 16:52:24'),
(245, 137, '28G', '28g', '2026-10-14 16:52:24'),
(246, 138, 'Matte', 'matte', '2026-10-14 16:52:24'),
(247, 139, '30G', '30g', '2026-10-14 16:52:24'),
(248, 139, '28G', '28g', '2026-10-14 16:52:24'),
(249, 140, 'Matte', 'matte', '2026-10-14 16:52:24'),
(250, 141, '30G', '30g', '2026-10-14 16:52:24'),
(251, 141, '28G', '28g', '2026-10-14 16:52:24'),
(252, 142, 'Matte', 'matte', '2026-10-14 16:52:24'),
(253, 143, '30G', '30g', '2026-10-14 16:52:24'),
(254, 143, '28G', '28g', '2026-10-14 16:52:24'),
(255, 144, 'Matte', 'matte', '2026-10-14 16:52:24'),
(256, 145, '30G', '30g', '2026-10-14 16:52:24'),
(257, 145, '28G', '28g', '2026-10-14 16:52:24'),
(258, 146, 'Matte', 'matte', '2026-10-14 16:52:24'),
(259, 147, '30G', '30g', '2026-10-14 16:52:24'),
(260, 147, '28G', '28g', '2026-10-14 16:52:24'),
(261, 148, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(262, 149, '30G', '30g', '2026-10-14 16:52:24'),
(263, 149, '28G', '28g', '2026-10-14 16:52:24'),
(264, 150, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(265, 151, '30G', '30g', '2026-10-14 16:52:24'),
(266, 151, '28G', '28g', '2026-10-14 16:52:24'),
(267, 152, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(268, 153, '30G', '30g', '2026-10-14 16:52:24'),
(269, 153, '28G', '28g', '2026-10-14 16:52:24'),
(270, 154, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(271, 155, '30G', '30g', '2026-10-14 16:52:24'),
(272, 155, '28G', '28g', '2026-10-14 16:52:24'),
(273, 156, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(274, 157, '30G', '30g', '2026-10-14 16:52:24'),
(275, 157, '28G', '28g', '2026-10-14 16:52:24'),
(276, 158, 'Matte', 'matte', '2026-10-14 16:52:24'),
(277, 159, '30G', '30g', '2026-10-14 16:52:24'),
(278, 159, '28G', '28g', '2026-10-14 16:52:24'),
(279, 160, 'Matte', 'matte', '2026-10-14 16:52:24'),
(280, 161, '30G', '30g', '2026-10-14 16:52:24'),
(281, 161, '28G', '28g', '2026-10-14 16:52:24'),
(282, 162, 'Matte', 'matte', '2026-10-14 16:52:24'),
(283, 163, '32G', '32g', '2026-10-14 16:52:24'),
(284, 163, '30G', '30g', '2026-10-14 16:52:24'),
(285, 164, 'Uncolored Galvanized', 'uncolored-galvanized', '2026-10-14 16:52:24'),
(286, 165, 'Standard Thickness', 'standard-thickness', '2026-10-14 16:52:24'),
(287, 165, 'Standard Thickness Custom Length', 'standard-thickness-custom-length', '2026-10-14 16:52:24'),
(288, 166, 'Fiberglass', 'fiberglass', '2026-10-14 16:52:24'),
(289, 167, 'Standard Thickness', 'standard-thickness', '2026-10-14 16:52:24'),
(290, 167, 'Standard Thickness Custom Length', 'standard-thickness-custom-length', '2026-10-14 16:52:24'),
(291, 168, 'Fiberglass', 'fiberglass', '2026-10-14 16:52:24'),
(292, 169, '30G', '30g', '2026-10-14 16:52:24'),
(293, 169, '28G', '28g', '2026-10-14 16:52:24'),
(294, 170, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(295, 171, '30G', '30g', '2026-10-14 16:52:24'),
(296, 171, '28G', '28g', '2026-10-14 16:52:24'),
(297, 172, 'Matte', 'matte', '2026-10-14 16:52:24'),
(298, 173, '28G', '28g', '2026-10-14 16:52:24'),
(299, 173, '26G', '26g', '2026-10-14 16:52:24'),
(300, 174, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(301, 175, '28G', '28g', '2026-10-14 16:52:24'),
(302, 175, '26G', '26g', '2026-10-14 16:52:24'),
(303, 176, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(304, 177, '28G', '28g', '2026-10-14 16:52:24'),
(305, 177, '26G', '26g', '2026-10-14 16:52:24'),
(306, 178, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(307, 179, '28G', '28g', '2026-10-14 16:52:24'),
(308, 179, '26G', '26g', '2026-10-14 16:52:24'),
(309, 180, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(310, 181, '28G', '28g', '2026-10-14 16:52:24'),
(311, 181, '26G', '26g', '2026-10-14 16:52:24'),
(312, 182, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(313, 183, '28G', '28g', '2026-10-14 16:52:24'),
(314, 183, '26G', '26g', '2026-10-14 16:52:24'),
(315, 184, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(316, 185, '28G', '28g', '2026-10-14 16:52:24'),
(317, 185, '26G', '26g', '2026-10-14 16:52:24'),
(318, 186, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(319, 187, '28G', '28g', '2026-10-14 16:52:24'),
(320, 187, '26G', '26g', '2026-10-14 16:52:24'),
(321, 188, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(322, 189, '28G', '28g', '2026-10-14 16:52:24'),
(323, 189, '26G', '26g', '2026-10-14 16:52:24'),
(324, 190, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(325, 191, '28G', '28g', '2026-10-14 16:52:24'),
(326, 191, '26G', '26g', '2026-10-14 16:52:24'),
(327, 192, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(328, 193, '28G', '28g', '2026-10-14 16:52:24'),
(329, 193, '26G', '26g', '2026-10-14 16:52:24'),
(330, 194, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(331, 195, '28G', '28g', '2026-10-14 16:52:24'),
(332, 195, '26G', '26g', '2026-10-14 16:52:24'),
(333, 196, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(334, 197, '28G', '28g', '2026-10-14 16:52:24'),
(335, 197, '26G', '26g', '2026-10-14 16:52:24'),
(336, 198, 'Alu Zinc Volcanic Stone', 'alu-zinc-volcanic-stone', '2026-10-14 16:52:24'),
(337, 199, '30G', '30g', '2026-10-14 16:52:24'),
(338, 199, '28G', '28g', '2026-10-14 16:52:24'),
(339, 200, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(340, 201, '30G', '30g', '2026-10-14 16:52:24'),
(341, 201, '28G', '28g', '2026-10-14 16:52:24'),
(342, 202, 'Glossy', 'glossy', '2026-10-14 16:52:24'),
(343, 203, '30G', '30g', '2026-10-14 16:52:25'),
(344, 203, '28G', '28g', '2026-10-14 16:52:25'),
(345, 204, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(346, 205, '30G', '30g', '2026-10-14 16:52:25'),
(347, 205, '28G', '28g', '2026-10-14 16:52:25'),
(348, 206, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(349, 207, '30G', '30g', '2026-10-14 16:52:25'),
(350, 207, '28G', '28g', '2026-10-14 16:52:25'),
(351, 208, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(352, 209, '30G', '30g', '2026-10-14 16:52:25'),
(353, 209, '28G', '28g', '2026-10-14 16:52:25'),
(354, 210, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(355, 211, '30G', '30g', '2026-10-14 16:52:25'),
(356, 211, '28G', '28g', '2026-10-14 16:52:25'),
(357, 212, 'Matte', 'matte', '2026-10-14 16:52:25'),
(358, 213, '30G', '30g', '2026-10-14 16:52:25'),
(359, 213, '28G', '28g', '2026-10-14 16:52:25'),
(360, 214, 'Matte', 'matte', '2026-10-14 16:52:25'),
(361, 215, '30G', '30g', '2026-10-14 16:52:25'),
(362, 215, '28G', '28g', '2026-10-14 16:52:25'),
(363, 216, 'Matte', 'matte', '2026-10-14 16:52:25'),
(364, 217, '30G', '30g', '2026-10-14 16:52:25'),
(365, 217, '28G', '28g', '2026-10-14 16:52:25'),
(366, 218, 'Matte', 'matte', '2026-10-14 16:52:25'),
(367, 219, '30G', '30g', '2026-10-14 16:52:25'),
(368, 219, '28G', '28g', '2026-10-14 16:52:25'),
(369, 220, 'Matte', 'matte', '2026-10-14 16:52:25'),
(370, 221, '30G', '30g', '2026-10-14 16:52:25'),
(371, 221, '28G', '28g', '2026-10-14 16:52:25'),
(372, 222, 'Matte', 'matte', '2026-10-14 16:52:25'),
(373, 223, '30G', '30g', '2026-10-14 16:52:25'),
(374, 223, '28G', '28g', '2026-10-14 16:52:25'),
(375, 224, 'Matte', 'matte', '2026-10-14 16:52:25'),
(376, 225, '30G', '30g', '2026-10-14 16:52:25'),
(377, 225, '28G', '28g', '2026-10-14 16:52:25'),
(378, 226, 'Matte', 'matte', '2026-10-14 16:52:25'),
(379, 227, '30G', '30g', '2026-10-14 16:52:25'),
(380, 227, '28G', '28g', '2026-10-14 16:52:25'),
(381, 228, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(382, 229, '30G', '30g', '2026-10-14 16:52:25'),
(383, 229, '28G', '28g', '2026-10-14 16:52:25'),
(384, 230, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(385, 231, '30G', '30g', '2026-10-14 16:52:25'),
(386, 231, '28G', '28g', '2026-10-14 16:52:25'),
(387, 232, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(388, 233, '30G', '30g', '2026-10-14 16:52:25'),
(389, 233, '28G', '28g', '2026-10-14 16:52:25'),
(390, 234, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(391, 235, '30G', '30g', '2026-10-14 16:52:25'),
(392, 235, '28G', '28g', '2026-10-14 16:52:25'),
(393, 236, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(394, 237, '30G', '30g', '2026-10-14 16:52:25'),
(395, 237, '28G', '28g', '2026-10-14 16:52:25'),
(396, 238, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(397, 239, '30G', '30g', '2026-10-14 16:52:25'),
(398, 239, '28G', '28g', '2026-10-14 16:52:25'),
(399, 240, 'Matte', 'matte', '2026-10-14 16:52:25'),
(400, 241, '30G', '30g', '2026-10-14 16:52:25'),
(401, 241, '28G', '28g', '2026-10-14 16:52:25'),
(402, 242, 'Matte', 'matte', '2026-10-14 16:52:25'),
(403, 243, '30G', '30g', '2026-10-14 16:52:25'),
(404, 243, '28G', '28g', '2026-10-14 16:52:25'),
(405, 244, 'Matte', 'matte', '2026-10-14 16:52:25'),
(406, 245, '30G', '30g', '2026-10-14 16:52:25'),
(407, 245, '28G', '28g', '2026-10-14 16:52:25'),
(408, 246, 'Matte', 'matte', '2026-10-14 16:52:25'),
(409, 247, '30G', '30g', '2026-10-14 16:52:25'),
(410, 247, '28G', '28g', '2026-10-14 16:52:25'),
(411, 248, 'Matte', 'matte', '2026-10-14 16:52:25'),
(412, 249, '30G', '30g', '2026-10-14 16:52:25'),
(413, 249, '28G', '28g', '2026-10-14 16:52:25'),
(414, 250, 'Matte', 'matte', '2026-10-14 16:52:25'),
(415, 251, '30G', '30g', '2026-10-14 16:52:25'),
(416, 251, '28G', '28g', '2026-10-14 16:52:25'),
(417, 252, 'Matte', 'matte', '2026-10-14 16:52:25'),
(418, 253, '30G', '30g', '2026-10-14 16:52:25'),
(419, 253, '28G', '28g', '2026-10-14 16:52:25'),
(420, 254, 'Matte', 'matte', '2026-10-14 16:52:25'),
(421, 255, '30G', '30g', '2026-10-14 16:52:25'),
(422, 255, '28G', '28g', '2026-10-14 16:52:25'),
(423, 256, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(424, 257, '30G', '30g', '2026-10-14 16:52:25'),
(425, 257, '28G', '28g', '2026-10-14 16:52:25'),
(426, 258, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(427, 259, '30G', '30g', '2026-10-14 16:52:25'),
(428, 259, '28G', '28g', '2026-10-14 16:52:25'),
(429, 260, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(430, 261, '30G', '30g', '2026-10-14 16:52:25'),
(431, 261, '28G', '28g', '2026-10-14 16:52:25'),
(432, 262, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(433, 263, '30G', '30g', '2026-10-14 16:52:25'),
(434, 263, '28G', '28g', '2026-10-14 16:52:25'),
(435, 264, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(436, 265, '30G', '30g', '2026-10-14 16:52:25'),
(437, 265, '28G', '28g', '2026-10-14 16:52:25'),
(438, 266, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(439, 267, '30G', '30g', '2026-10-14 16:52:25'),
(440, 267, '28G', '28g', '2026-10-14 16:52:25'),
(441, 268, 'Matte', 'matte', '2026-10-14 16:52:25'),
(442, 269, '30G', '30g', '2026-10-14 16:52:25'),
(443, 269, '28G', '28g', '2026-10-14 16:52:25'),
(444, 270, 'Matte', 'matte', '2026-10-14 16:52:25'),
(445, 271, '30G', '30g', '2026-10-14 16:52:25'),
(446, 271, '28G', '28g', '2026-10-14 16:52:25'),
(447, 272, 'Matte', 'matte', '2026-10-14 16:52:25'),
(448, 273, '30G', '30g', '2026-10-14 16:52:25'),
(449, 273, '28G', '28g', '2026-10-14 16:52:25'),
(450, 274, 'Matte', 'matte', '2026-10-14 16:52:25'),
(451, 275, '30G', '30g', '2026-10-14 16:52:25'),
(452, 275, '28G', '28g', '2026-10-14 16:52:25'),
(453, 276, 'Matte', 'matte', '2026-10-14 16:52:25'),
(454, 277, '30G', '30g', '2026-10-14 16:52:25'),
(455, 277, '28G', '28g', '2026-10-14 16:52:25'),
(456, 278, 'Matte', 'matte', '2026-10-14 16:52:25'),
(457, 279, '30G', '30g', '2026-10-14 16:52:25'),
(458, 279, '28G', '28g', '2026-10-14 16:52:25'),
(459, 280, 'Matte', 'matte', '2026-10-14 16:52:25'),
(460, 281, '30G', '30g', '2026-10-14 16:52:25'),
(461, 281, '28G', '28g', '2026-10-14 16:52:25'),
(462, 282, 'Matte', 'matte', '2026-10-14 16:52:25'),
(463, 283, '30G', '30g', '2026-10-14 16:52:25'),
(464, 283, '28G', '28g', '2026-10-14 16:52:25'),
(465, 284, 'Galvanized', 'galvanized', '2026-10-14 16:52:25'),
(466, 285, '30G', '30g', '2026-10-14 16:52:25'),
(467, 285, '28G', '28g', '2026-10-14 16:52:25'),
(468, 286, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(469, 287, '30G', '30g', '2026-10-14 16:52:25'),
(470, 287, '28G', '28g', '2026-10-14 16:52:25'),
(471, 288, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(472, 289, '30G', '30g', '2026-10-14 16:52:25'),
(473, 289, '28G', '28g', '2026-10-14 16:52:25'),
(474, 290, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(475, 291, '30G', '30g', '2026-10-14 16:52:25'),
(476, 291, '28G', '28g', '2026-10-14 16:52:25'),
(477, 292, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(478, 293, '30G', '30g', '2026-10-14 16:52:25'),
(479, 293, '28G', '28g', '2026-10-14 16:52:25'),
(480, 294, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(481, 295, '30G', '30g', '2026-10-14 16:52:25'),
(482, 295, '28G', '28g', '2026-10-14 16:52:25'),
(483, 296, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(484, 297, '30G', '30g', '2026-10-14 16:52:25'),
(485, 297, '28G', '28g', '2026-10-14 16:52:25'),
(486, 298, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(487, 299, '30G', '30g', '2026-10-14 16:52:25'),
(488, 299, '28G', '28g', '2026-10-14 16:52:25'),
(489, 300, 'Color Coated', 'color-coated', '2026-10-14 16:52:25'),
(490, 301, '30G', '30g', '2026-10-14 16:52:25'),
(491, 301, '28G', '28g', '2026-10-14 16:52:25'),
(492, 302, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(493, 303, '30G', '30g', '2026-10-14 16:52:25'),
(494, 303, '28G', '28g', '2026-10-14 16:52:25'),
(495, 304, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(496, 305, '30G', '30g', '2026-10-14 16:52:25'),
(497, 305, '28G', '28g', '2026-10-14 16:52:25'),
(498, 306, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(499, 307, '30G', '30g', '2026-10-14 16:52:25'),
(500, 307, '28G', '28g', '2026-10-14 16:52:25'),
(501, 308, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(502, 309, '30G', '30g', '2026-10-14 16:52:25'),
(503, 309, '28G', '28g', '2026-10-14 16:52:25'),
(504, 310, 'Glossy', 'glossy', '2026-10-14 16:52:25'),
(505, 311, '30G', '30g', '2026-10-14 16:52:26'),
(506, 311, '28G', '28g', '2026-10-14 16:52:26'),
(507, 312, 'Glossy', 'glossy', '2026-10-14 16:52:26'),
(508, 313, '28G', '28g', '2026-10-14 16:52:26'),
(509, 313, '26G', '26g', '2026-10-14 16:52:26'),
(510, 314, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(511, 315, '28G', '28g', '2026-10-14 16:52:26'),
(512, 315, '26G', '26g', '2026-10-14 16:52:26'),
(513, 316, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(514, 317, '28G', '28g', '2026-10-14 16:52:26'),
(515, 317, '26G', '26g', '2026-10-14 16:52:26'),
(516, 318, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(517, 319, '28G', '28g', '2026-10-14 16:52:26'),
(518, 319, '26G', '26g', '2026-10-14 16:52:26'),
(519, 320, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(520, 321, '28G', '28g', '2026-10-14 16:52:26'),
(521, 321, '26G', '26g', '2026-10-14 16:52:26'),
(522, 322, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(523, 323, '28G', '28g', '2026-10-14 16:52:26'),
(524, 323, '26G', '26g', '2026-10-14 16:52:26'),
(525, 324, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(526, 325, '28G', '28g', '2026-10-14 16:52:26'),
(527, 325, '26G', '26g', '2026-10-14 16:52:26'),
(528, 326, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(529, 327, '28G', '28g', '2026-10-14 16:52:26'),
(530, 327, '26G', '26g', '2026-10-14 16:52:26'),
(531, 328, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(532, 329, '28G', '28g', '2026-10-14 16:52:26'),
(533, 329, '26G', '26g', '2026-10-14 16:52:26'),
(534, 330, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(535, 331, '28G', '28g', '2026-10-14 16:52:26'),
(536, 331, '26G', '26g', '2026-10-14 16:52:26'),
(537, 332, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(538, 333, '28G', '28g', '2026-10-14 16:52:26'),
(539, 333, '26G', '26g', '2026-10-14 16:52:26'),
(540, 334, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(541, 335, '28G', '28g', '2026-10-14 16:52:26'),
(542, 335, '26G', '26g', '2026-10-14 16:52:26'),
(543, 336, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(544, 337, '28G', '28g', '2026-10-14 16:52:26'),
(545, 337, '26G', '26g', '2026-10-14 16:52:26'),
(546, 338, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(547, 339, '28G', '28g', '2026-10-14 16:52:26'),
(548, 339, '26G', '26g', '2026-10-14 16:52:26'),
(549, 340, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(550, 341, '28G', '28g', '2026-10-14 16:52:26'),
(551, 341, '26G', '26g', '2026-10-14 16:52:26'),
(552, 342, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(553, 343, '28G', '28g', '2026-10-14 16:52:26'),
(554, 343, '26G', '26g', '2026-10-14 16:52:26'),
(555, 344, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(556, 345, '28G', '28g', '2026-10-14 16:52:26'),
(557, 345, '26G', '26g', '2026-10-14 16:52:26'),
(558, 346, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(559, 347, '28G', '28g', '2026-10-14 16:52:26'),
(560, 347, '26G', '26g', '2026-10-14 16:52:26'),
(561, 348, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(562, 349, '28G', '28g', '2026-10-14 16:52:26'),
(563, 349, '26G', '26g', '2026-10-14 16:52:26'),
(564, 350, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(565, 351, '28G', '28g', '2026-10-14 16:52:26'),
(566, 351, '26G', '26g', '2026-10-14 16:52:26'),
(567, 352, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(568, 353, '28G', '28g', '2026-10-14 16:52:26'),
(569, 353, '26G', '26g', '2026-10-14 16:52:26'),
(570, 354, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(571, 355, '28G', '28g', '2026-10-14 16:52:26'),
(572, 355, '26G', '26g', '2026-10-14 16:52:26'),
(573, 356, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(574, 357, '28G', '28g', '2026-10-14 16:52:26'),
(575, 357, '26G', '26g', '2026-10-14 16:52:26'),
(576, 358, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(577, 359, '28G', '28g', '2026-10-14 16:52:26'),
(578, 359, '26G', '26g', '2026-10-14 16:52:26'),
(579, 360, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(580, 361, '28G', '28g', '2026-10-14 16:52:26'),
(581, 361, '26G', '26g', '2026-10-14 16:52:26'),
(582, 362, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(583, 363, '28G', '28g', '2026-10-14 16:52:26'),
(584, 363, '26G', '26g', '2026-10-14 16:52:26'),
(585, 364, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(586, 365, '28G', '28g', '2026-10-14 16:52:26'),
(587, 365, '26G', '26g', '2026-10-14 16:52:26'),
(588, 366, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(589, 367, '28G', '28g', '2026-10-14 16:52:26'),
(590, 367, '26G', '26g', '2026-10-14 16:52:26'),
(591, 368, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(592, 369, '28G', '28g', '2026-10-14 16:52:26'),
(593, 369, '26G', '26g', '2026-10-14 16:52:26'),
(594, 370, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(595, 371, '28G', '28g', '2026-10-14 16:52:26'),
(596, 371, '26G', '26g', '2026-10-14 16:52:26'),
(597, 372, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(598, 373, '28G', '28g', '2026-10-14 16:52:26'),
(599, 373, '26G', '26g', '2026-10-14 16:52:26'),
(600, 374, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(601, 375, '28G', '28g', '2026-10-14 16:52:26'),
(602, 375, '26G', '26g', '2026-10-14 16:52:26'),
(603, 376, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(604, 377, '28G', '28g', '2026-10-14 16:52:26'),
(605, 377, '26G', '26g', '2026-10-14 16:52:26'),
(606, 378, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(607, 379, '28G', '28g', '2026-10-14 16:52:26'),
(608, 379, '26G', '26g', '2026-10-14 16:52:26'),
(609, 380, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(610, 381, '28G', '28g', '2026-10-14 16:52:26'),
(611, 381, '26G', '26g', '2026-10-14 16:52:26'),
(612, 382, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(613, 383, '28G', '28g', '2026-10-14 16:52:26'),
(614, 383, '26G', '26g', '2026-10-14 16:52:26'),
(615, 384, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(616, 385, '28G', '28g', '2026-10-14 16:52:26'),
(617, 385, '26G', '26g', '2026-10-14 16:52:26'),
(618, 386, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(619, 387, '28G', '28g', '2026-10-14 16:52:26'),
(620, 387, '26G', '26g', '2026-10-14 16:52:26'),
(621, 388, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(622, 389, '28G', '28g', '2026-10-14 16:52:26'),
(623, 389, '26G', '26g', '2026-10-14 16:52:26'),
(624, 390, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(625, 391, '28G', '28g', '2026-10-14 16:52:26'),
(626, 391, '26G', '26g', '2026-10-14 16:52:26'),
(627, 392, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(628, 393, '28G', '28g', '2026-10-14 16:52:26'),
(629, 393, '26G', '26g', '2026-10-14 16:52:26'),
(630, 394, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(631, 395, '28G', '28g', '2026-10-14 16:52:26'),
(632, 395, '26G', '26g', '2026-10-14 16:52:26'),
(633, 396, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(634, 397, '28G', '28g', '2026-10-14 16:52:26'),
(635, 397, '26G', '26g', '2026-10-14 16:52:26'),
(636, 398, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(637, 399, '28G', '28g', '2026-10-14 16:52:26'),
(638, 399, '26G', '26g', '2026-10-14 16:52:26'),
(639, 400, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26'),
(640, 401, '28G', '28g', '2026-10-14 16:52:26'),
(641, 401, '26G', '26g', '2026-10-14 16:52:26'),
(642, 402, 'Stone Coated', 'stone-coated', '2026-10-14 16:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `su_product_categories`
--

CREATE TABLE `su_product_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_product_categories`
--

INSERT INTO `su_product_categories` (`id`, `name`, `slug`, `parent_id`, `icon`, `featured_image`, `banner_image`, `description`, `is_default`, `created_at`) VALUES
(18, 'Tile Profiles', 'tile-profiles', NULL, NULL, '1791898633-3fe34b00b13474cc284bd33dcdc97c50e8702124.webp', NULL, 'Quality tile-profile roofing sheets from Trinity Mabati Factory', 0, '2026-10-13 06:20:32'),
(19, 'Stone Coated Profiles', 'stone-coated-profiles', NULL, NULL, '1791898562-maroon-stone-coated-metallic-roof-tiles.jpg', NULL, 'Durable stone-coated roofing tiles for residential and commercial buildings', 0, '2026-10-13 06:20:32'),
(20, 'Box Profiles', 'box-profiles', NULL, NULL, '1791898440-6a9eea46cb193082a8150d2ba6009e9d38dc3edd.webp', NULL, 'Box-profile metal roofing sheets for residential and commercial projects', 0, '2026-10-13 06:20:32'),
(21, 'Corrugated Sheets', 'corrugated-sheets', NULL, NULL, '1791896988-7e7793ba136f1fa9f950ca39b91f46878bf8d08b.jpg', NULL, 'Corrugated metal roofing sheets for a wide range of building applications', 0, '2026-10-13 06:20:32'),
(25, 'Shingle roofing tiles', 'shingle-roofing-tiles', 19, NULL, NULL, NULL, 'Stone-coated shingle roofing tiles', 0, '2026-10-13 06:20:32'),
(26, 'Classic roofing tiles', 'classic-roofing-tiles', 19, NULL, '1791898522-maroon-stone-coated-metallic-roof-tiles.jpg', NULL, 'Classic stone-coated roofing tiles', 0, '2026-10-13 06:20:32'),
(27, 'Milano roofing tiles', 'milano-roofing-tiles', 19, NULL, NULL, NULL, 'Roman-style stone-coated roofing tiles', 0, '2026-10-13 06:20:32'),
(28, 'Versatile profiles', 'versatile-profiles', 18, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(29, 'Eurotile profiles', 'eurotile-profiles', 18, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(30, 'Romantile profiles', 'romantile-profiles', 18, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(31, 'Industrial Sheets', 'industrial-sheets', NULL, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(32, 'Roofing Accessories', 'roofing-accessories', NULL, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(33, 'Stoney coated accessories', 'stoney-coated-accessories', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(34, 'Ridge cap', 'ridge-cap', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(35, 'Valley tray', 'valley-tray', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(36, 'Side flashing', 'side-flashing', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(37, 'Plainsheet', 'plainsheet', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(38, 'Roofing nails', 'roofing-nails', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(39, 'Washers', 'washers', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22'),
(40, 'PVC Gutters', 'pvc-gutters', 32, NULL, NULL, NULL, NULL, 0, '2026-10-14 16:52:22');

--
-- Triggers `su_product_categories`
--
DELIMITER $$
CREATE TRIGGER `trg_su_product_categories_protect_default` BEFORE DELETE ON `su_product_categories` FOR EACH ROW BEGIN
                IF OLD.is_default = 1 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'The default category cannot be deleted. Set another category as default first.';
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `su_product_category`
--

CREATE TABLE `su_product_category` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_product_category`
--

INSERT INTO `su_product_category` (`product_id`, `category_id`) VALUES
(256, 20),
(257, 20),
(258, 20),
(259, 20),
(260, 20),
(261, 20),
(262, 20),
(263, 20),
(264, 20),
(265, 20),
(266, 20),
(267, 28),
(268, 28),
(269, 28),
(270, 28),
(271, 28),
(272, 28),
(273, 29),
(274, 29),
(275, 29),
(276, 29),
(277, 29),
(278, 29),
(279, 30),
(280, 30),
(281, 30),
(282, 30),
(283, 21),
(284, 21),
(285, 21),
(286, 21),
(287, 21),
(288, 21),
(289, 21),
(290, 21),
(291, 21),
(292, 31),
(293, 31),
(294, 31),
(295, 31),
(296, 31),
(297, 26),
(298, 26),
(299, 26),
(300, 26),
(301, 26),
(302, 25),
(303, 25),
(304, 25),
(305, 25),
(306, 27),
(307, 27),
(308, 27),
(309, 27),
(310, 34),
(311, 34),
(312, 34),
(313, 34),
(314, 34),
(315, 34),
(316, 34),
(317, 34),
(318, 34),
(319, 34),
(320, 34),
(321, 34),
(322, 34),
(323, 34),
(324, 34),
(325, 34),
(326, 34),
(327, 34),
(328, 34),
(329, 34),
(330, 34),
(331, 34),
(332, 34),
(333, 34),
(334, 34),
(335, 34),
(336, 34),
(337, 34),
(338, 36),
(339, 36),
(340, 36),
(341, 36),
(342, 36),
(343, 36),
(344, 36),
(345, 36),
(346, 36),
(347, 36),
(348, 36),
(349, 36),
(350, 36),
(351, 36),
(352, 35),
(353, 35),
(354, 35),
(355, 35),
(356, 35),
(357, 35),
(358, 35),
(359, 35),
(360, 35),
(361, 37),
(362, 37),
(363, 37),
(364, 37),
(365, 37),
(366, 37),
(367, 38),
(368, 39),
(369, 40),
(370, 33),
(371, 33),
(372, 33),
(373, 33),
(374, 33),
(375, 33),
(376, 33),
(377, 33),
(378, 33),
(379, 33),
(380, 33),
(381, 33),
(382, 33),
(383, 33),
(384, 33),
(385, 33),
(386, 33),
(387, 33),
(388, 33),
(389, 33),
(390, 33),
(391, 33),
(392, 33),
(393, 33),
(394, 33),
(395, 33),
(396, 33),
(397, 33),
(398, 33),
(399, 33),
(400, 33),
(401, 33),
(402, 33),
(403, 33),
(404, 33),
(405, 33),
(406, 32),
(407, 32),
(408, 32),
(409, 32),
(410, 32),
(411, 32),
(412, 32),
(413, 32),
(414, 32),
(415, 32),
(416, 32),
(417, 33);

-- --------------------------------------------------------

--
-- Table structure for table `su_product_label`
--

CREATE TABLE `su_product_label` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `label_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_product_labels`
--

CREATE TABLE `su_product_labels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `color_code` varchar(7) DEFAULT '#000000',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_product_reviews`
--

CREATE TABLE `su_product_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_product_variants`
--

CREATE TABLE `su_product_variants` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_code` varchar(150) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `variant_signature` char(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_product_variants`
--

INSERT INTO `su_product_variants` (`id`, `product_id`, `variant_code`, `sku`, `price`, `sale_price`, `cost_price`, `stock_quantity`, `image`, `variant_signature`, `created_at`, `updated_at`) VALUES
(131, 256, 'BOX-PROFILE-IT4-IT5-GLOSSY-CHARCOAL-GREY-30G', 'BOX-PROFILE-IT4-IT5-GLOSSY-CHARCOAL-GREY-30G', 500.00, NULL, NULL, 200, NULL, '68ac5c9c76973d5874c3fcff871cab48b4e62df9a5bbdca42697d96f8b38844d', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(132, 256, 'BOX-PROFILE-IT4-IT5-GLOSSY-CHARCOAL-GREY-28G', 'BOX-PROFILE-IT4-IT5-GLOSSY-CHARCOAL-GREY-28G', 650.00, NULL, NULL, 200, NULL, '2bc2aad6de938e3a96b0f2d8c4e11b22b5aa66760e17f9e78db1d89c9ca07cfd', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(133, 257, 'BOX-PROFILE-IT4-IT5-GLOSSY-BRICK-RED-30G', 'BOX-PROFILE-IT4-IT5-GLOSSY-BRICK-RED-30G', 500.00, NULL, NULL, 200, NULL, 'd6ef54ffa4ed4062c4cce2ec86050f137de9e2b75fdeea0b6e2cf6a9de0ae307', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(134, 257, 'BOX-PROFILE-IT4-IT5-GLOSSY-BRICK-RED-28G', 'BOX-PROFILE-IT4-IT5-GLOSSY-BRICK-RED-28G', 650.00, NULL, NULL, 200, NULL, '50e4bba5ee829063266c1154f844de50ccd1d470d6dfb084c45f97a6d0606bdc', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(135, 258, 'BOX-PROFILE-IT4-IT5-GLOSSY-TILE-RED-30G', 'BOX-PROFILE-IT4-IT5-GLOSSY-TILE-RED-30G', 500.00, NULL, NULL, 200, NULL, '68f13b9edfada6ef0e443ad3b5bc9877c64867c529c470d3b742cfbe05bab90e', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(136, 258, 'BOX-PROFILE-IT4-IT5-GLOSSY-TILE-RED-28G', 'BOX-PROFILE-IT4-IT5-GLOSSY-TILE-RED-28G', 650.00, NULL, NULL, 200, NULL, 'e3485488332ec9320a66332c536ecdc070d14f31b2e7d2c287c390cae7b529d4', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(137, 259, 'BOX-PROFILE-IT4-IT5-GLOSSY-MAROON-30G', 'BOX-PROFILE-IT4-IT5-GLOSSY-MAROON-30G', 500.00, NULL, NULL, 200, NULL, '4157762c04235582e3c17423f8876417be65594e484e0e5f66c8d0c744e0872b', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(138, 259, 'BOX-PROFILE-IT4-IT5-GLOSSY-MAROON-28G', 'BOX-PROFILE-IT4-IT5-GLOSSY-MAROON-28G', 650.00, NULL, NULL, 200, NULL, '648ddba375a00540660854c5210fd149ff93938982f4fe4155a50b17b399fd08', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(139, 260, 'BOX-PROFILE-IT4-IT5-GLOSSY-JUNGLE-GREEN-30G', 'BOX-PROFILE-IT4-IT5-GLOSSY-JUNGLE-GREEN-30G', 500.00, NULL, NULL, 200, NULL, 'd099bae8729aadc846df1e3f6832566ccd8153adf009b2b762c8713f11d2d08d', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(140, 260, 'BOX-PROFILE-IT4-IT5-GLOSSY-JUNGLE-GREEN-28G', 'BOX-PROFILE-IT4-IT5-GLOSSY-JUNGLE-GREEN-28G', 650.00, NULL, NULL, 200, NULL, '1a28c631e91c20c0f1830af4f5163f4553af3a58054b9f21a821af9f9b90bd3a', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(141, 261, 'BOX-PROFILE-IT4-IT5-GLOSSY-OCEAN-BLUE-30G', 'BOX-PROFILE-IT4-IT5-GLOSSY-OCEAN-BLUE-30G', 500.00, NULL, NULL, 200, NULL, 'dd39606da577b951d544e3e059f492e5932d034f4cd462fcb22e29b1a77f93ed', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(142, 261, 'BOX-PROFILE-IT4-IT5-GLOSSY-OCEAN-BLUE-28G', 'BOX-PROFILE-IT4-IT5-GLOSSY-OCEAN-BLUE-28G', 650.00, NULL, NULL, 200, NULL, '61faf9c5a3a22539664e5125f3c87d553393c1628edd8ba714a943a6bc1e949d', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(143, 262, 'BOX-PROFILE-IT4-IT5-MATTE-CHARCOAL-GREY-30G', 'BOX-PROFILE-IT4-IT5-MATTE-CHARCOAL-GREY-30G', 600.00, NULL, NULL, 200, NULL, 'c906311b43c4273730bcd0af247f65d61661f47dcb03cd4dcfeb26c0bf85f50b', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(144, 262, 'BOX-PROFILE-IT4-IT5-MATTE-CHARCOAL-GREY-28G', 'BOX-PROFILE-IT4-IT5-MATTE-CHARCOAL-GREY-28G', 700.00, NULL, NULL, 200, NULL, 'ea02ccc6a4fc408752efdaed911820a7a97650c5491c243fb7f24713d8000922', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(145, 263, 'BOX-PROFILE-IT4-IT5-MATTE-CHOCOLATE-BROWN-30G', 'BOX-PROFILE-IT4-IT5-MATTE-CHOCOLATE-BROWN-30G', 600.00, NULL, NULL, 200, NULL, 'a1291d3657cc67c6178deab3ac322862d5f464577c62ee16a445c5b49bc8d214', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(146, 263, 'BOX-PROFILE-IT4-IT5-MATTE-CHOCOLATE-BROWN-28G', 'BOX-PROFILE-IT4-IT5-MATTE-CHOCOLATE-BROWN-28G', 700.00, NULL, NULL, 200, NULL, '01cc798ea105b278a749dadd9b80fc14631d4a616fd6fbdb7a39d028ae7bd71c', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(147, 264, 'BOX-PROFILE-IT4-IT5-MATTE-TILE-RED-30G', 'BOX-PROFILE-IT4-IT5-MATTE-TILE-RED-30G', 600.00, NULL, NULL, 200, NULL, '5ee88ce44d67eab979f5fe8d62a3fa6cbcb2f9c3aa6340e085a24216f963b082', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(148, 264, 'BOX-PROFILE-IT4-IT5-MATTE-TILE-RED-28G', 'BOX-PROFILE-IT4-IT5-MATTE-TILE-RED-28G', 700.00, NULL, NULL, 200, NULL, '8b32110956569553790d9928ace67c83b20f9819a3b55f1e13aa01325f0e4018', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(149, 265, 'BOX-PROFILE-IT4-IT5-MATTE-MAROON-30G', 'BOX-PROFILE-IT4-IT5-MATTE-MAROON-30G', 600.00, NULL, NULL, 200, NULL, '1bf600451e8ad07973b15049d61650a1a8711efde47719737aceeb534e2018f4', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(150, 265, 'BOX-PROFILE-IT4-IT5-MATTE-MAROON-28G', 'BOX-PROFILE-IT4-IT5-MATTE-MAROON-28G', 700.00, NULL, NULL, 200, NULL, '8a400c41f147c5f8d72405a664f29ea5790282ed854c1f72eba1479cc82e52bc', '2026-10-14 16:52:23', '2026-10-14 16:52:23'),
(151, 266, 'BOX-PROFILE-IT4-IT5-MATTE-JUNGLE-GREEN-30G', 'BOX-PROFILE-IT4-IT5-MATTE-JUNGLE-GREEN-30G', 600.00, NULL, NULL, 200, NULL, '2babc3034791d162af2859cb5f77d9b4ab4e6bc57d758c6093aa9befc27b6c75', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(152, 266, 'BOX-PROFILE-IT4-IT5-MATTE-JUNGLE-GREEN-28G', 'BOX-PROFILE-IT4-IT5-MATTE-JUNGLE-GREEN-28G', 700.00, NULL, NULL, 200, NULL, '134500e63e5a74f1bd4c5b4083fe54331e9d325b1989da25f4f40e1fbe534be0', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(153, 267, 'VERSATILE-PROFILE-MATTE-CHARCOAL-GREY-30G', 'VERSATILE-PROFILE-MATTE-CHARCOAL-GREY-30G', 600.00, NULL, NULL, 200, NULL, '607eb50501956d3269c7caa1cc79d0b1ddf4473b87b38c81e039fad8371f0dcc', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(154, 267, 'VERSATILE-PROFILE-MATTE-CHARCOAL-GREY-28G', 'VERSATILE-PROFILE-MATTE-CHARCOAL-GREY-28G', 700.00, NULL, NULL, 200, NULL, '8461a19707447cc62e6f4683cc1b3f30984528d52bdfa2ad1615f464b697c887', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(155, 268, 'VERSATILE-PROFILE-MATTE-CHOCOLATE-BROWN-30G', 'VERSATILE-PROFILE-MATTE-CHOCOLATE-BROWN-30G', 600.00, NULL, NULL, 200, NULL, '41a687b6bdf1b9ec99d3287c847c982e20c2c1d6a64f09e8f5474cd5e01f16a1', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(156, 268, 'VERSATILE-PROFILE-MATTE-CHOCOLATE-BROWN-28G', 'VERSATILE-PROFILE-MATTE-CHOCOLATE-BROWN-28G', 700.00, NULL, NULL, 200, NULL, '5c10da2f57c3f996bc42790af04e4a8b14f64835da6ac2aad12a1729df49c78d', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(157, 269, 'VERSATILE-PROFILE-MATTE-MAROON-30G', 'VERSATILE-PROFILE-MATTE-MAROON-30G', 600.00, NULL, NULL, 200, NULL, '2cdb6b75b541c063bf549f37c2899f452534b3af46dfa85afe43149d393cc0b0', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(158, 269, 'VERSATILE-PROFILE-MATTE-MAROON-28G', 'VERSATILE-PROFILE-MATTE-MAROON-28G', 700.00, NULL, NULL, 200, NULL, '59467ad6e50372039cf430209ef22489209b10728247049fabb6cd155f60f8b9', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(159, 270, 'VERSATILE-PROFILE-MATTE-TILE-RED-30G', 'VERSATILE-PROFILE-MATTE-TILE-RED-30G', 600.00, NULL, NULL, 200, NULL, '68cc40b18f97a578ce75164c0a354c202231176a4a7834a57558d024e77d1854', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(160, 270, 'VERSATILE-PROFILE-MATTE-TILE-RED-28G', 'VERSATILE-PROFILE-MATTE-TILE-RED-28G', 700.00, NULL, NULL, 200, NULL, 'ebf0373cedd526fc3a1ad9337b99e4bc8e862d08b739dfbe70cf3b38ef11f8cb', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(161, 271, 'VERSATILE-PROFILE-MATTE-BRICK-RED-30G', 'VERSATILE-PROFILE-MATTE-BRICK-RED-30G', 600.00, NULL, NULL, 200, NULL, '80ebe584808b51c21013a69354d7259b24a00681acc329f3a735b1627f11e3cf', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(162, 271, 'VERSATILE-PROFILE-MATTE-BRICK-RED-28G', 'VERSATILE-PROFILE-MATTE-BRICK-RED-28G', 700.00, NULL, NULL, 200, NULL, '79c473003bd7839797ae7cb00bcbe851c3611ca6c2958383b4ef7e2736241f98', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(163, 272, 'VERSATILE-PROFILE-MATTE-OCEAN-BLUE-30G', 'VERSATILE-PROFILE-MATTE-OCEAN-BLUE-30G', 600.00, NULL, NULL, 200, NULL, '537464f90aa4b99b3dcf98e2948d6545132de0912584086197e8286293c198d0', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(164, 272, 'VERSATILE-PROFILE-MATTE-OCEAN-BLUE-28G', 'VERSATILE-PROFILE-MATTE-OCEAN-BLUE-28G', 700.00, NULL, NULL, 200, NULL, '7c12ce1b19d5f95f097d19db3065e0178ff83f1ea23a062efe96a69159d1fdf0', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(165, 273, 'EUROTILE-PROFILE-MATTE-CHARCOAL-GREY-30G', 'EUROTILE-PROFILE-MATTE-CHARCOAL-GREY-30G', 600.00, NULL, NULL, 200, NULL, '52af6cfde018b599fa588a2bdf2351ae841ada2bb051ee01b0d52c1410194b3a', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(166, 273, 'EUROTILE-PROFILE-MATTE-CHARCOAL-GREY-28G', 'EUROTILE-PROFILE-MATTE-CHARCOAL-GREY-28G', 700.00, NULL, NULL, 200, NULL, '7e2d258b7756927a314fbc28b744897b2bd5b051a6aa97b230f63d4ee39e854d', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(167, 274, 'EUROTILE-PROFILE-MATTE-CHOCOLATE-BROWN-30G', 'EUROTILE-PROFILE-MATTE-CHOCOLATE-BROWN-30G', 600.00, NULL, NULL, 200, NULL, '788785ba730fbe555d3b3090b2a6f8696a118eb0d1c350c04cd8477acd4e359a', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(168, 274, 'EUROTILE-PROFILE-MATTE-CHOCOLATE-BROWN-28G', 'EUROTILE-PROFILE-MATTE-CHOCOLATE-BROWN-28G', 700.00, NULL, NULL, 200, NULL, '6d61ee9a3e5b83fadb326d762812be8f7572261b321aa52a6461b49d60d80592', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(169, 275, 'EUROTILE-PROFILE-MATTE-MAROON-30G', 'EUROTILE-PROFILE-MATTE-MAROON-30G', 600.00, NULL, NULL, 200, NULL, '22c0c7dc59c2be0334274ee09dbb19cbf105b682a5ead5def83ac2710ac029fd', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(170, 275, 'EUROTILE-PROFILE-MATTE-MAROON-28G', 'EUROTILE-PROFILE-MATTE-MAROON-28G', 700.00, NULL, NULL, 200, NULL, 'ce2f25ddc14296283e34cb52beb559cff6b387652280fce97de14a2d19915fe4', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(171, 276, 'EUROTILE-PROFILE-MATTE-DARK-GREEN-30G', 'EUROTILE-PROFILE-MATTE-DARK-GREEN-30G', 600.00, NULL, NULL, 200, NULL, 'a34e07159064ec4eb2c5d117289aeb3a38020b6a2a2cb79fdb03b7489f5ffbf3', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(172, 276, 'EUROTILE-PROFILE-MATTE-DARK-GREEN-28G', 'EUROTILE-PROFILE-MATTE-DARK-GREEN-28G', 700.00, NULL, NULL, 200, NULL, '792ac09b0d21f1bada520f363d76761a752922af1d869396577bb4d874183f35', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(173, 277, 'EUROTILE-PROFILE-MATTE-TILE-RED-30G', 'EUROTILE-PROFILE-MATTE-TILE-RED-30G', 600.00, NULL, NULL, 200, NULL, '45aae662f39d49c402df391ee80bb7feaf4d298f3e348f8474547c3dc3d3525b', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(174, 277, 'EUROTILE-PROFILE-MATTE-TILE-RED-28G', 'EUROTILE-PROFILE-MATTE-TILE-RED-28G', 700.00, NULL, NULL, 200, NULL, 'd13b5f175b99b7202ffe830f756448090d77e230a298491adaf3667268675445', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(175, 278, 'EUROTILE-PROFILE-MATTE-BRICK-RED-30G', 'EUROTILE-PROFILE-MATTE-BRICK-RED-30G', 600.00, NULL, NULL, 200, NULL, '84068eee77fea4620b62b81fd860bc5faf3c769151163fbc4d21671902134231', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(176, 278, 'EUROTILE-PROFILE-MATTE-BRICK-RED-28G', 'EUROTILE-PROFILE-MATTE-BRICK-RED-28G', 700.00, NULL, NULL, 200, NULL, 'd27a0793d1277ae5ac16be2e2080e88771b5c375fe98e50258b4637b573701d1', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(177, 279, 'ROMANTILE-MATTE-CHARCOAL-GREY-30G', 'ROMANTILE-MATTE-CHARCOAL-GREY-30G', 600.00, NULL, NULL, 200, NULL, '151613cc6602ee8c21f28e8dd6ef0900b6caa9f1797249e954b20b9e1a34b9ce', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(178, 279, 'ROMANTILE-MATTE-CHARCOAL-GREY-28G', 'ROMANTILE-MATTE-CHARCOAL-GREY-28G', 700.00, NULL, NULL, 200, NULL, 'c8c5e13f0220f4e822fb98c950a167cdd9ccb2d1461be84519e10b6840d110ba', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(179, 280, 'ROMANTILE-MATTE-MAROON-30G', 'ROMANTILE-MATTE-MAROON-30G', 600.00, NULL, NULL, 200, NULL, 'e87bd8f1ce9bed6671948a9ae9a62f2f9b193cbaeb1b7efacb64e5b63b47f689', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(180, 280, 'ROMANTILE-MATTE-MAROON-28G', 'ROMANTILE-MATTE-MAROON-28G', 700.00, NULL, NULL, 200, NULL, 'adf52c1a62c9cbfdb6acfedcdb51db484ccf07145ea6aa2cc9fadf90567ceadb', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(181, 281, 'ROMANTILE-MATTE-BRICK-RED-30G', 'ROMANTILE-MATTE-BRICK-RED-30G', 600.00, NULL, NULL, 200, NULL, '54401d699b5bc7c6d528276a85b27c800f14f0a99e72069f5fecdc15b8d8c062', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(182, 281, 'ROMANTILE-MATTE-BRICK-RED-28G', 'ROMANTILE-MATTE-BRICK-RED-28G', 700.00, NULL, NULL, 200, NULL, '262717cbefbc2a710033ffe4fa4e2f20d862aac1d0176b7dbcd9dc8aa7e54360', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(183, 282, 'ROMANTILE-MATTE-CHOCOLATE-BROWN-30G', 'ROMANTILE-MATTE-CHOCOLATE-BROWN-30G', 600.00, NULL, NULL, 200, NULL, '53a1ef3ba5c4edfb8159f8aadf785fe1177d3fbb1563c7a21f01c002877410b6', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(184, 282, 'ROMANTILE-MATTE-CHOCOLATE-BROWN-28G', 'ROMANTILE-MATTE-CHOCOLATE-BROWN-28G', 700.00, NULL, NULL, 200, NULL, 'fa38bf0a1953cb2228c140f1b21e4a8641dd4dae8aa5274b6861bec4cf8ff871', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(185, 283, 'CORRUGATED-WAVE-GLOSSY-CHARCOAL-GREY-30G', 'CORRUGATED-WAVE-GLOSSY-CHARCOAL-GREY-30G', 500.00, NULL, NULL, 200, NULL, '245ff80fb5272cefe2ba073f2ed7d72517da39e8884f976d0c9cb53fd7da12d6', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(186, 283, 'CORRUGATED-WAVE-GLOSSY-CHARCOAL-GREY-28G', 'CORRUGATED-WAVE-GLOSSY-CHARCOAL-GREY-28G', 650.00, NULL, NULL, 200, NULL, 'b146e46518dde93c86d6e13c36b26c60669713bc9b2d90d99e4edfd467f8866d', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(187, 284, 'CORRUGATED-WAVE-GLOSSY-BRICK-RED-30G', 'CORRUGATED-WAVE-GLOSSY-BRICK-RED-30G', 500.00, NULL, NULL, 200, NULL, '3df91c40da7fcecfbeee6c533344a2296d432a409a1f35cc1107ed43d5365d7a', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(188, 284, 'CORRUGATED-WAVE-GLOSSY-BRICK-RED-28G', 'CORRUGATED-WAVE-GLOSSY-BRICK-RED-28G', 650.00, NULL, NULL, 200, NULL, '7f0fe09ef669e3f5cb3f49ff493efebf9f4e075229edf88e8dabafb8c8d2441a', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(189, 285, 'CORRUGATED-WAVE-GLOSSY-TILE-RED-30G', 'CORRUGATED-WAVE-GLOSSY-TILE-RED-30G', 500.00, NULL, NULL, 200, NULL, '35e3ccee0cbc123187ed330214a3922e7e671b35213cae07c4029e6b4625abb9', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(190, 285, 'CORRUGATED-WAVE-GLOSSY-TILE-RED-28G', 'CORRUGATED-WAVE-GLOSSY-TILE-RED-28G', 650.00, NULL, NULL, 200, NULL, '12443c5543062958afe600c2153f35fe918b8efc0ddeec05cd35c5b6b68492fd', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(191, 286, 'CORRUGATED-WAVE-GLOSSY-OCEAN-BLUE-30G', 'CORRUGATED-WAVE-GLOSSY-OCEAN-BLUE-30G', 500.00, NULL, NULL, 200, NULL, '7a17df4cff92ca5a365c616d6d4b1c80a3a7538162e474245c153330fdc8317c', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(192, 286, 'CORRUGATED-WAVE-GLOSSY-OCEAN-BLUE-28G', 'CORRUGATED-WAVE-GLOSSY-OCEAN-BLUE-28G', 650.00, NULL, NULL, 200, NULL, '6810f2202a661664bb04d951b30b3020dc26a67fbe12bce081024306beaf223c', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(193, 287, 'CORRUGATED-WAVE-GLOSSY-JUNGLE-GREEN-30G', 'CORRUGATED-WAVE-GLOSSY-JUNGLE-GREEN-30G', 500.00, NULL, NULL, 200, NULL, '9a8e3ea9b2b2db25a35dc491783b79f4690ab3490465ad98c78e84cfdca008be', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(194, 287, 'CORRUGATED-WAVE-GLOSSY-JUNGLE-GREEN-28G', 'CORRUGATED-WAVE-GLOSSY-JUNGLE-GREEN-28G', 650.00, NULL, NULL, 200, NULL, '1f0982239d94eb315c3368f3385fc6331b43a6e343b4290e43c144bde6c5a2b1', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(195, 288, 'CORRUGATED-WAVE-MATTE-CHARCOAL-GREY-30G', 'CORRUGATED-WAVE-MATTE-CHARCOAL-GREY-30G', 600.00, NULL, NULL, 200, NULL, 'd903e4b8ae9bae5e7ef482e6f01811ef9bf20ec4372626993d33b68afecc6c95', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(196, 288, 'CORRUGATED-WAVE-MATTE-CHARCOAL-GREY-28G', 'CORRUGATED-WAVE-MATTE-CHARCOAL-GREY-28G', 650.00, NULL, NULL, 200, NULL, '137a8f12e674afc7285056217581715f9d3ca132c3e119522dde3c25cd29ebc0', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(197, 289, 'CORRUGATED-WAVE-MATTE-CHOCOLATE-BROWN-30G', 'CORRUGATED-WAVE-MATTE-CHOCOLATE-BROWN-30G', 600.00, NULL, NULL, 200, NULL, '957ac15499164819516ed59cad7982043f1b65f17305119d1e7c8cc283890b04', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(198, 289, 'CORRUGATED-WAVE-MATTE-CHOCOLATE-BROWN-28G', 'CORRUGATED-WAVE-MATTE-CHOCOLATE-BROWN-28G', 650.00, NULL, NULL, 200, NULL, '251d7bc5c3933afa7b82f65ab17b480f6073844be283346006349a97fa481e40', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(199, 290, 'CORRUGATED-WAVE-MATTE-MAROON-30G', 'CORRUGATED-WAVE-MATTE-MAROON-30G', 600.00, NULL, NULL, 200, NULL, '68c0efe98c108e0d9a96682a0006566af5b2eb02a74e03460b5e9e884fbd574c', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(200, 290, 'CORRUGATED-WAVE-MATTE-MAROON-28G', 'CORRUGATED-WAVE-MATTE-MAROON-28G', 650.00, NULL, NULL, 200, NULL, 'd5cd10c40e031d81197a1bf6b6f1170589b0e27ed0896a7c46750d470e8c3d2f', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(201, 291, 'NON-COLORED-CORRUGATED-SHEET-UNCOLORED-GALVANIZED-METALLIC-SILVER-32G', 'NON-COLORED-CORRUGATED-SHEET-UNCOLORED-GALVANIZED-METALLIC-SILVER-32G', 280.00, NULL, NULL, 200, NULL, 'e31cd1cef50f5e88ebc3d6d3cf2fcd00e8d43915d60f9814c38625d489dbb19d', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(202, 291, 'NON-COLORED-CORRUGATED-SHEET-UNCOLORED-GALVANIZED-METALLIC-SILVER-30G', 'NON-COLORED-CORRUGATED-SHEET-UNCOLORED-GALVANIZED-METALLIC-SILVER-30G', 380.00, NULL, NULL, 200, NULL, 'be29a1492e97c4293a1ef9022a59cee573b72ba5581805fd92125a427b830a37', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(203, 292, 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-CLEAR-TRANSPARENT-V1', 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-CLEAR-TRANSPARENT-V1', 950.00, NULL, NULL, 200, NULL, '8d9b8d75a96253cd1b3e881c4a6591b4ed6e8bcb8646905f9f29e5812a47e067', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(204, 292, 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-CLEAR-TRANSPARENT-V2', 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-CLEAR-TRANSPARENT-V2', 1500.00, NULL, NULL, 200, NULL, '9935b768ddecf563bd36cdedb3f76148633702226fa26898770792c73e08a3e1', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(205, 293, 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-OPAL-WHITE-V1', 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-OPAL-WHITE-V1', 950.00, NULL, NULL, 200, NULL, 'ffa743bdcce745faa75c8ba7c1e04f37b5dd3d69a1071747d632c7f6b5e8aeb3', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(206, 293, 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-OPAL-WHITE-V2', 'TRANSLUCENT-CLEAR-SHEET-FIBERGLASS-OPAL-WHITE-V2', 1500.00, NULL, NULL, 200, NULL, '6f8c50d934a9d886ddac5c99d1c28db05242e75d27e5fa5974172d421a84f0d7', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(207, 295, 'CRIMPED-ROOFING-SHEET-GLOSSY-30G', 'CRIMPED-ROOFING-SHEET-GLOSSY-30G', 1000.00, NULL, NULL, 200, NULL, '6bfe20389a8f7cb7828a69969e757d03d62d1ecc9000823679da0ec9a2eab1b8', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(208, 295, 'CRIMPED-ROOFING-SHEET-GLOSSY-28G', 'CRIMPED-ROOFING-SHEET-GLOSSY-28G', 1000.00, NULL, NULL, 200, NULL, 'a87d2e7950d8830e3d4912825ce8ba43dd8f4d73a806a129134355374c28dfa4', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(209, 296, 'CRIMPED-ROOFING-SHEET-MATTE-30G', 'CRIMPED-ROOFING-SHEET-MATTE-30G', 1000.00, NULL, NULL, 200, NULL, '0293a4238e7795d48b567de7fba57c0dc84d9935eebc6d32ebe6235ca6c05de2', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(210, 296, 'CRIMPED-ROOFING-SHEET-MATTE-28G', 'CRIMPED-ROOFING-SHEET-MATTE-28G', 1000.00, NULL, NULL, 200, NULL, 'dd7a2f6eed78c529557dfe89cd3362a6798a270bbee3c7e7dee8448d209da9cb', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(211, 297, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-28G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-28G', 650.00, NULL, NULL, 200, NULL, '90caa851b7a9a86067defa11dd3950b43cdcacc8732a7930b35d7942490d63f6', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(212, 297, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-26G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-26G', 700.00, NULL, NULL, 200, NULL, '91c1b4e55c0cc99b6bd6eabccfaeb17d3bdad54553125224c0679b1eefd9503c', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(213, 298, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-BROWN-28G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-BROWN-28G', 650.00, NULL, NULL, 200, NULL, '10686925810f938b00d95da8667bf1661d98035455e2957d5df195d13cb63b9e', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(214, 298, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-BROWN-26G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-BROWN-26G', 700.00, NULL, NULL, 200, NULL, '016a29d3646cc4f9c849cf2902ba1017fa3f93fae437f79884b07f0f3364d221', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(215, 299, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BRICK-RED-28G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BRICK-RED-28G', 650.00, NULL, NULL, 200, NULL, 'd9b88a10bc81ce85582a08554e1afa85f5b5f958a06cae13b4f7345c33d02312', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(216, 299, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BRICK-RED-26G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BRICK-RED-26G', 700.00, NULL, NULL, 200, NULL, 'f71260f10bd636ed8b63e1045d5b669b00966df9539ce3ac0c5fcb552590e832', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(217, 300, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-28G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-28G', 650.00, NULL, NULL, 200, NULL, '36707ffdbbfc56391c33134a89b214a71de347566783445e4608b8150494f8c8', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(218, 300, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-26G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-26G', 700.00, NULL, NULL, 200, NULL, '048b2c6a660c2c7a85153c594f57b0b2c7a45266dd36db2ce1dc8b0a7c4f0dc7', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(219, 301, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-28G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-28G', 650.00, NULL, NULL, 200, NULL, 'ec67556ac0f22fd71449cb0fa812d5d3b26ae93919b1c3bb9d4927d48d02d2d2', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(220, 301, 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-26G', 'CLASSIC-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-26G', 700.00, NULL, NULL, 200, NULL, '442d3ca5db27bfc8d353fdffd7c3f6a8efccbd9a2d328a7c3d249b1c45d59faa', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(221, 302, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-28G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-28G', 650.00, NULL, NULL, 200, NULL, 'c5d3b22e17c3825d5371f4cce763f59a3a09e54f518a44c1168946c8558fedd1', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(222, 302, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-26G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-26G', 700.00, NULL, NULL, 200, NULL, '5ded29424cdaab71c17335daeadf1331df51bb7bdd90e6d81133050a9ba83090', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(223, 303, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BARK-WOOD-BROWN-28G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BARK-WOOD-BROWN-28G', 650.00, NULL, NULL, 200, NULL, 'c807304eafb6655c366993b944d50a757d2cf69fdce640fc85d8689f30165ca0', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(224, 303, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BARK-WOOD-BROWN-26G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BARK-WOOD-BROWN-26G', 700.00, NULL, NULL, 200, NULL, '89a51140822c7e8ea0b00dc59455730e2e0ad76f951dcc956c1e8d94ac01e6d6', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(225, 304, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-GREEN-28G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-GREEN-28G', 650.00, NULL, NULL, 200, NULL, '2499ba7825641163dc20d5c3375116df3eae2f6bb61d7d5dd42002f093e3ae77', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(226, 304, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-GREEN-26G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-DARK-GREEN-26G', 700.00, NULL, NULL, 200, NULL, 'ab3e411adbc3bbf418d204ba906d0036d3583e3f1e22c4c4b6f3a6689de43787', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(227, 305, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-28G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-28G', 650.00, NULL, NULL, 200, NULL, '280de3de5265d31691f11e788c4306853ecbe68528c7fe75e0f8f50e3c449f06', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(228, 305, 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-26G', 'SHINGLES-TILE-ALU-ZINC-VOLCANIC-STONE-BLACK-26G', 700.00, NULL, NULL, 200, NULL, 'c509413b3199f4a54f462bae287e2453c2f150084edd9ac41867f46c8b72014d', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(229, 306, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-28G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-28G', 650.00, NULL, NULL, 200, NULL, '23246f96927f31ac4b4c4dbe950a5228f3fbb4c1481ec335a9429425a2d2f855', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(230, 306, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-26G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHARCOAL-GREY-26G', 700.00, NULL, NULL, 200, NULL, '10c5c333e8f4e9e70cc90fbbdd496943a07ccc28a194c3360404b08c85b80df8', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(231, 307, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-TERRACOTTA-28G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-TERRACOTTA-28G', 650.00, NULL, NULL, 200, NULL, '9eb9719e090e8b6f68358d4d0b629ebf48feb0237a5e3be899e672f44ee6483f', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(232, 307, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-TERRACOTTA-26G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-TERRACOTTA-26G', 700.00, NULL, NULL, 200, NULL, '1908501093229543c261c3aba7f81c0c540d877e4b099150f1d6aeda38087c01', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(233, 308, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHOCOLATE-BROWN-28G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHOCOLATE-BROWN-28G', 650.00, NULL, NULL, 200, NULL, '275a06fb5c77c646789dd329d0078384154c58a7ea1c78c81da921f440583484', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(234, 308, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHOCOLATE-BROWN-26G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-CHOCOLATE-BROWN-26G', 700.00, NULL, NULL, 200, NULL, '9135694f2d797d947ea0fb76732df98107aa1b05df16726efc2f9570438cd928', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(235, 309, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-28G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-28G', 650.00, NULL, NULL, 200, NULL, '63854e9a635dfdf733f2c6531e263fc90414726f2bf81425a182266f637c6362', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(236, 309, 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-26G', 'MILANO-TILE-ALU-ZINC-VOLCANIC-STONE-MAROON-26G', 700.00, NULL, NULL, 200, NULL, 'db96739b35de8f242f0a0b7f356d99744e1072fcbe76264501ae104a80ec6d58', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(237, 310, 'RIDGE-CAP-GLOSSY-CHARCOAL-GREY-30G', 'RIDGE-CAP-GLOSSY-CHARCOAL-GREY-30G', 300.00, NULL, NULL, 200, NULL, '63c52f2e8cdf43cb08200530e5d8690046691c0ecfa66d106eff84972d6fc2cc', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(238, 310, 'RIDGE-CAP-GLOSSY-CHARCOAL-GREY-28G', 'RIDGE-CAP-GLOSSY-CHARCOAL-GREY-28G', 350.00, NULL, NULL, 200, NULL, '9236b2d56c07da538e353d7a7f74aa8e7bf0d9815c27ac02f10a0fbd8614f9ba', '2026-10-14 16:52:24', '2026-10-14 16:52:24'),
(239, 311, 'RIDGE-CAP-GLOSSY-BRICK-RED-30G', 'RIDGE-CAP-GLOSSY-BRICK-RED-30G', 300.00, NULL, NULL, 200, NULL, '4b9f313093174e0cb8d1b8ce8fb75934e3981e2390bbcc31d9d884f5c004519c', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(240, 311, 'RIDGE-CAP-GLOSSY-BRICK-RED-28G', 'RIDGE-CAP-GLOSSY-BRICK-RED-28G', 350.00, NULL, NULL, 200, NULL, '6947ec9aa1f8106efa229a1d6aa852e1518232b89989418a42ac047b5c652e33', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(241, 312, 'RIDGE-CAP-GLOSSY-TILE-RED-30G', 'RIDGE-CAP-GLOSSY-TILE-RED-30G', 300.00, NULL, NULL, 200, NULL, 'd46e74f848095a848a966d5bf7187d8fe0af037ac4f45c1bef56a7dca23a1310', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(242, 312, 'RIDGE-CAP-GLOSSY-TILE-RED-28G', 'RIDGE-CAP-GLOSSY-TILE-RED-28G', 350.00, NULL, NULL, 200, NULL, '5debcdf3ffe4b87acd0340e1533a78ece51ebead0ebd8e4f4ca22600d705274b', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(243, 313, 'RIDGE-CAP-GLOSSY-MAROON-30G', 'RIDGE-CAP-GLOSSY-MAROON-30G', 300.00, NULL, NULL, 200, NULL, '858c311df2ff83dac52c0e9301903e251c836a75e44885e09ea62333620c912c', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(244, 313, 'RIDGE-CAP-GLOSSY-MAROON-28G', 'RIDGE-CAP-GLOSSY-MAROON-28G', 350.00, NULL, NULL, 200, NULL, '432a89fc935f4614a43b4e877453dc0bd6627fe4a41f64d4ae110256cdba241b', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(245, 314, 'RIDGE-CAP-GLOSSY-JUNGLE-GREEN-30G', 'RIDGE-CAP-GLOSSY-JUNGLE-GREEN-30G', 300.00, NULL, NULL, 200, NULL, '61c08e16449a8fd95768edbab1fe674cda028a20de690fb5c6b1248baa7e0f10', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(246, 314, 'RIDGE-CAP-GLOSSY-JUNGLE-GREEN-28G', 'RIDGE-CAP-GLOSSY-JUNGLE-GREEN-28G', 350.00, NULL, NULL, 200, NULL, 'da0989c4e6587a3b8adc4de13e5dc1320c93d11900691c195a11d9a0d40ecb6f', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(247, 315, 'RIDGE-CAP-GLOSSY-OCEAN-BLUE-30G', 'RIDGE-CAP-GLOSSY-OCEAN-BLUE-30G', 300.00, NULL, NULL, 200, NULL, '05df9a18fe2f590c888cf6170c3cdba5ffcede9155ec59841356688bec70058c', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(248, 315, 'RIDGE-CAP-GLOSSY-OCEAN-BLUE-28G', 'RIDGE-CAP-GLOSSY-OCEAN-BLUE-28G', 350.00, NULL, NULL, 200, NULL, '74caa46e4f5b025cd281932a005d81e8d794fe9fce2cfb5d4256dd431f40f744', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(249, 316, 'RIDGE-CAP-MATTE-CHARCOAL-GREY-30G', 'RIDGE-CAP-MATTE-CHARCOAL-GREY-30G', 300.00, NULL, NULL, 200, NULL, '01a888290b2367b8ab6dbc870930393f3cf7d03fcab7308ce4f4b995bb880b47', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(250, 316, 'RIDGE-CAP-MATTE-CHARCOAL-GREY-28G', 'RIDGE-CAP-MATTE-CHARCOAL-GREY-28G', 350.00, NULL, NULL, 200, NULL, 'f06284c9e3ca758f16e4b3c53ad43841cdad1a3efa85a48fe7471eccf71941de', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(251, 317, 'RIDGE-CAP-MATTE-CHOCOLATE-BROWN-30G', 'RIDGE-CAP-MATTE-CHOCOLATE-BROWN-30G', 300.00, NULL, NULL, 200, NULL, 'd9932e00ea7f4a5dbf784b4eb2ce60528893c547393224c358e07d452b941fd2', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(252, 317, 'RIDGE-CAP-MATTE-CHOCOLATE-BROWN-28G', 'RIDGE-CAP-MATTE-CHOCOLATE-BROWN-28G', 350.00, NULL, NULL, 200, NULL, '96917721164d6c39fc734ad3721711641fd5e11d632614d133859b7ae3672ede', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(253, 318, 'RIDGE-CAP-MATTE-MAROON-30G', 'RIDGE-CAP-MATTE-MAROON-30G', 300.00, NULL, NULL, 200, NULL, '5fbe99687550d5577dd3f63bf6cb2f1ea15fc02e0996319cecee7fb5e3f98e2d', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(254, 318, 'RIDGE-CAP-MATTE-MAROON-28G', 'RIDGE-CAP-MATTE-MAROON-28G', 350.00, NULL, NULL, 200, NULL, 'e840201e1f2dc411740c1f3d56c157035c70fee0165cb2b26a3878f734de01b8', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(255, 319, 'RIDGE-CAP-MATTE-TILE-RED-30G', 'RIDGE-CAP-MATTE-TILE-RED-30G', 300.00, NULL, NULL, 200, NULL, '09d65912126931994805aa7ec4b2ec89ad2f42d768af77fed012fd2e6a088642', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(256, 319, 'RIDGE-CAP-MATTE-TILE-RED-28G', 'RIDGE-CAP-MATTE-TILE-RED-28G', 350.00, NULL, NULL, 200, NULL, '4c0c4c2541bd98918ebf54107a4f4ed46511e9a1c3c5ca14af6ac7fc5e4ab571', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(257, 320, 'RIDGE-CAP-MATTE-BRICK-RED-30G', 'RIDGE-CAP-MATTE-BRICK-RED-30G', 300.00, NULL, NULL, 200, NULL, 'be5568411b1834d64befafdd7741c5460b7b8f5e099edd615af6265ef7d5c3a5', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(258, 320, 'RIDGE-CAP-MATTE-BRICK-RED-28G', 'RIDGE-CAP-MATTE-BRICK-RED-28G', 350.00, NULL, NULL, 200, NULL, 'b2312c00172cb6dedd7eed7d5df4609d2f09eb175e692df2b3196c52811689e3', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(259, 321, 'RIDGE-CAP-MATTE-OCEAN-BLUE-30G', 'RIDGE-CAP-MATTE-OCEAN-BLUE-30G', 300.00, NULL, NULL, 200, NULL, 'af805acbfae12651f24c1a0e1aaeeda3bc1da7a62c74918555a501d4fa03f2c9', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(260, 321, 'RIDGE-CAP-MATTE-OCEAN-BLUE-28G', 'RIDGE-CAP-MATTE-OCEAN-BLUE-28G', 350.00, NULL, NULL, 200, NULL, '6abb9edaf6265c205d4a28791b5d992a98f48be2833bf6e503bc1f9dad8573f2', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(261, 322, 'RIDGE-CAP-MATTE-JUNGLE-GREEN-30G', 'RIDGE-CAP-MATTE-JUNGLE-GREEN-30G', 300.00, NULL, NULL, 200, NULL, '2bb702d34ed181eaef011a9248ee71f44e1029d99bcacdd24591be37e50c22ba', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(262, 322, 'RIDGE-CAP-MATTE-JUNGLE-GREEN-28G', 'RIDGE-CAP-MATTE-JUNGLE-GREEN-28G', 350.00, NULL, NULL, 200, NULL, '077ba2ef6cb8b7e45df071e04a850adbfc7ab355e68686aa3cec9267f74bfb9a', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(263, 323, 'RIDGE-CAP-MATTE-DARK-GREEN-30G', 'RIDGE-CAP-MATTE-DARK-GREEN-30G', 300.00, NULL, NULL, 200, NULL, 'c7f7877bfc1fdaf252646e2de71c0f0b50977576383b290ed990a0012b54ed4f', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(264, 323, 'RIDGE-CAP-MATTE-DARK-GREEN-28G', 'RIDGE-CAP-MATTE-DARK-GREEN-28G', 350.00, NULL, NULL, 200, NULL, 'c8abd70c8355e3d62206a91fdbf122087ff808b619cbb1e97b2982366a2503a3', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(265, 324, 'ROLL-TOP-RIDGE-CAP-GLOSSY-CHARCOAL-GREY-30G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-CHARCOAL-GREY-30G', 300.00, NULL, NULL, 200, NULL, 'f77ba4bc45384bf9aed80b0d2d404979a507c17a2c66c8faa0c530bf573db716', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(266, 324, 'ROLL-TOP-RIDGE-CAP-GLOSSY-CHARCOAL-GREY-28G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-CHARCOAL-GREY-28G', 350.00, NULL, NULL, 200, NULL, 'a05e3e1b8360027754b3d6298754025fa6e5b0ff36e8bfeb0d17103bf75064de', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(267, 325, 'ROLL-TOP-RIDGE-CAP-GLOSSY-BRICK-RED-30G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-BRICK-RED-30G', 300.00, NULL, NULL, 200, NULL, 'ed694dca1d6007c895715c882b6361ba8a919cbbe5dbcbe4707a921ab5e5f2d0', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(268, 325, 'ROLL-TOP-RIDGE-CAP-GLOSSY-BRICK-RED-28G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-BRICK-RED-28G', 350.00, NULL, NULL, 200, NULL, 'a41503068765211b9b035d92bbd7960a4fa3a60944c4d7e6b3f1957d7211bfb8', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(269, 326, 'ROLL-TOP-RIDGE-CAP-GLOSSY-TILE-RED-30G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-TILE-RED-30G', 300.00, NULL, NULL, 200, NULL, '83f5a3c19492ef13b6bcde8b4f489bc032eb0e6636cb8023547b3de4069fba93', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(270, 326, 'ROLL-TOP-RIDGE-CAP-GLOSSY-TILE-RED-28G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-TILE-RED-28G', 350.00, NULL, NULL, 200, NULL, 'db8e456d6a81547f2ef5dad90d0533e0bb8bf9a9f1378bb25345e889232f5381', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(271, 327, 'ROLL-TOP-RIDGE-CAP-GLOSSY-MAROON-30G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-MAROON-30G', 300.00, NULL, NULL, 200, NULL, '0f0410c67959513cc83a7a587d1671a9ca5c0b5314a124f92e0ed0db1ab51388', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(272, 327, 'ROLL-TOP-RIDGE-CAP-GLOSSY-MAROON-28G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-MAROON-28G', 350.00, NULL, NULL, 200, NULL, '5cd1898c96c0ac19cad4850d9ed27b67a696f178cbc2b13ec813af78218813c9', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(273, 328, 'ROLL-TOP-RIDGE-CAP-GLOSSY-JUNGLE-GREEN-30G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-JUNGLE-GREEN-30G', 300.00, NULL, NULL, 200, NULL, '3f3d40369d1bda875f7f490fdbc5d5b4682cd85f8bee411e6e964d9493b69b43', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(274, 328, 'ROLL-TOP-RIDGE-CAP-GLOSSY-JUNGLE-GREEN-28G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-JUNGLE-GREEN-28G', 350.00, NULL, NULL, 200, NULL, 'f0492492f89e3d235b6e65d1fc588b6629884f701d712190630b71f91c6876ec', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(275, 329, 'ROLL-TOP-RIDGE-CAP-GLOSSY-OCEAN-BLUE-30G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-OCEAN-BLUE-30G', 300.00, NULL, NULL, 200, NULL, '76c9b589062461ebbe94021b6b4c172c01e852a2cecbda11b73b0bcbd8a95b63', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(276, 329, 'ROLL-TOP-RIDGE-CAP-GLOSSY-OCEAN-BLUE-28G', 'ROLL-TOP-RIDGE-CAP-GLOSSY-OCEAN-BLUE-28G', 350.00, NULL, NULL, 200, NULL, 'acf2df818ba0debe63871c3f09d7e0cbe1b0d8c52ee1e2f9c40fd67bf66cf004', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(277, 330, 'ROLL-TOP-RIDGE-CAP-MATTE-CHARCOAL-GREY-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-CHARCOAL-GREY-30G', 300.00, NULL, NULL, 200, NULL, 'c1a19289c6802478cda8100f54d294ff059a140fde6b0a43e148e2b10923a8ee', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(278, 330, 'ROLL-TOP-RIDGE-CAP-MATTE-CHARCOAL-GREY-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-CHARCOAL-GREY-28G', 350.00, NULL, NULL, 200, NULL, '984e2c165e2140da922e8030658c64c55508b8d31c104f55377fe67e95c16d19', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(279, 331, 'ROLL-TOP-RIDGE-CAP-MATTE-CHOCOLATE-BROWN-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-CHOCOLATE-BROWN-30G', 300.00, NULL, NULL, 200, NULL, '47d8c302f44140d32dc718a064bac6a828985dd4fd87010076b35c9d6736c5bc', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(280, 331, 'ROLL-TOP-RIDGE-CAP-MATTE-CHOCOLATE-BROWN-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-CHOCOLATE-BROWN-28G', 350.00, NULL, NULL, 200, NULL, '971ca5fc570900fccd965344422310f25c72e52becd4e0f96f01a006b14ce16b', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(281, 332, 'ROLL-TOP-RIDGE-CAP-MATTE-MAROON-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-MAROON-30G', 300.00, NULL, NULL, 200, NULL, '2f01dc99c71b130e00d6f20ad77f6fd0503e16d66fe0eb2b02df53abbd221738', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(282, 332, 'ROLL-TOP-RIDGE-CAP-MATTE-MAROON-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-MAROON-28G', 350.00, NULL, NULL, 200, NULL, '46c2e43c683f33fd8a8410f846e187df708978d36b5923e9559ef6a47cd1e4a3', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(283, 333, 'ROLL-TOP-RIDGE-CAP-MATTE-TILE-RED-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-TILE-RED-30G', 300.00, NULL, NULL, 200, NULL, '042c1f49887a4229c7713b97f2208e2806753c45f40ae96138f044e69295fafd', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(284, 333, 'ROLL-TOP-RIDGE-CAP-MATTE-TILE-RED-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-TILE-RED-28G', 350.00, NULL, NULL, 200, NULL, '96ad00c497a8faabfbe882f77ad58a248aab6bdc79213f6e1e8131c7844586ba', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(285, 334, 'ROLL-TOP-RIDGE-CAP-MATTE-BRICK-RED-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-BRICK-RED-30G', 300.00, NULL, NULL, 200, NULL, 'd78be5cf7eedb6c52c943a466b5a2663d6816d69cb836792d7db938056a66d98', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(286, 334, 'ROLL-TOP-RIDGE-CAP-MATTE-BRICK-RED-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-BRICK-RED-28G', 350.00, NULL, NULL, 200, NULL, '93ae92ef6916723cec801aa83c5b7d42e09fc0817e08f7e6401e85d7c82bb17b', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(287, 335, 'ROLL-TOP-RIDGE-CAP-MATTE-OCEAN-BLUE-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-OCEAN-BLUE-30G', 300.00, NULL, NULL, 200, NULL, 'd234524ab4cef0ea27c243dd3078e6c7c1aed0835e6a79f1851151b0cab65aa6', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(288, 335, 'ROLL-TOP-RIDGE-CAP-MATTE-OCEAN-BLUE-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-OCEAN-BLUE-28G', 350.00, NULL, NULL, 200, NULL, '2a8a2b2b6f7360b67c3397ddb35e6846813ee0703d6977d9accfdf74a59fe87a', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(289, 336, 'ROLL-TOP-RIDGE-CAP-MATTE-JUNGLE-GREEN-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-JUNGLE-GREEN-30G', 300.00, NULL, NULL, 200, NULL, '403fec10b66c3c18ba678cdd83609c31651ebdcdc6f1a3bd25cef507dd432346', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(290, 336, 'ROLL-TOP-RIDGE-CAP-MATTE-JUNGLE-GREEN-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-JUNGLE-GREEN-28G', 350.00, NULL, NULL, 200, NULL, '1a1aa5cbcc2f67d851049f3e4ae04f8375a69c7f8b02ccce3bfdbba021b69338', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(291, 337, 'ROLL-TOP-RIDGE-CAP-MATTE-DARK-GREEN-30G', 'ROLL-TOP-RIDGE-CAP-MATTE-DARK-GREEN-30G', 300.00, NULL, NULL, 200, NULL, 'a2b9707caad7221336c9d294750f3f17bb1a89004fb59982012e7f5d5c60482b', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(292, 337, 'ROLL-TOP-RIDGE-CAP-MATTE-DARK-GREEN-28G', 'ROLL-TOP-RIDGE-CAP-MATTE-DARK-GREEN-28G', 350.00, NULL, NULL, 200, NULL, 'ca192204341ddb6a0103130e4621f829d663975864e3b0d57c52987ff92a2737', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(293, 338, 'SIDE-FLASHING-GLOSSY-CHARCOAL-GREY-30G', 'SIDE-FLASHING-GLOSSY-CHARCOAL-GREY-30G', 300.00, NULL, NULL, 200, NULL, 'c3812cbd4fe61412995b4bc999f229b7e51cd82d4b1be3afd48e857bd1e23c40', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(294, 338, 'SIDE-FLASHING-GLOSSY-CHARCOAL-GREY-28G', 'SIDE-FLASHING-GLOSSY-CHARCOAL-GREY-28G', 350.00, NULL, NULL, 200, NULL, '00c6a76bd1b182141174ff9b079ae0805e4caf5bc31e7ba3f17f3f80973cf3d8', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(295, 339, 'SIDE-FLASHING-GLOSSY-BRICK-RED-30G', 'SIDE-FLASHING-GLOSSY-BRICK-RED-30G', 300.00, NULL, NULL, 200, NULL, '5fe3fc80f840138018abf432e85cb8f7a4bf6d8a620deccd617c0575d5bbcfdc', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(296, 339, 'SIDE-FLASHING-GLOSSY-BRICK-RED-28G', 'SIDE-FLASHING-GLOSSY-BRICK-RED-28G', 350.00, NULL, NULL, 200, NULL, 'b1e50acda67d09eb3ea2e647927b441d1966ba5b4f842a40bc18021a6c2d1a5d', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(297, 340, 'SIDE-FLASHING-GLOSSY-TILE-RED-30G', 'SIDE-FLASHING-GLOSSY-TILE-RED-30G', 300.00, NULL, NULL, 200, NULL, '382cc49925c4522e93bdcf794fe74df1830e2f832f3b30fccc4efc1040d5c8b3', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(298, 340, 'SIDE-FLASHING-GLOSSY-TILE-RED-28G', 'SIDE-FLASHING-GLOSSY-TILE-RED-28G', 350.00, NULL, NULL, 200, NULL, '697ed391ea67febcb21878a3b509c3038bdd337f7cde3ad87c01efc3d25b0311', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(299, 341, 'SIDE-FLASHING-GLOSSY-MAROON-30G', 'SIDE-FLASHING-GLOSSY-MAROON-30G', 300.00, NULL, NULL, 200, NULL, '2d6bbc7269e8b2954877aee219152f126d034a6ac0c28bd79e819cad7b1d1530', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(300, 341, 'SIDE-FLASHING-GLOSSY-MAROON-28G', 'SIDE-FLASHING-GLOSSY-MAROON-28G', 350.00, NULL, NULL, 200, NULL, '8144ea27ab064dc75c0ec4cc1f1be7c7c436def4ef21d8c6ff4b0047f3deb782', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(301, 342, 'SIDE-FLASHING-GLOSSY-JUNGLE-GREEN-30G', 'SIDE-FLASHING-GLOSSY-JUNGLE-GREEN-30G', 300.00, NULL, NULL, 200, NULL, 'de583cb07dc5a77dd5889d6144110e3c2dff8aed4db222ffa360aff48b7651c0', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(302, 342, 'SIDE-FLASHING-GLOSSY-JUNGLE-GREEN-28G', 'SIDE-FLASHING-GLOSSY-JUNGLE-GREEN-28G', 350.00, NULL, NULL, 200, NULL, '9fd4092c154b2b1344a41aff2d4ec4d57193ae860370ddd70a9dfe148aa59d53', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(303, 343, 'SIDE-FLASHING-GLOSSY-OCEAN-BLUE-30G', 'SIDE-FLASHING-GLOSSY-OCEAN-BLUE-30G', 300.00, NULL, NULL, 200, NULL, '0e596422687d9881b8f0c6ba47846b9df33401b79c4f3896ae6f5b9ad75c6490', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(304, 343, 'SIDE-FLASHING-GLOSSY-OCEAN-BLUE-28G', 'SIDE-FLASHING-GLOSSY-OCEAN-BLUE-28G', 350.00, NULL, NULL, 200, NULL, 'ef8473d95e436f814609aabc440b9af361cf03a1c619ce28cc59624b71136e4d', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(305, 344, 'SIDE-FLASHING-MATTE-CHARCOAL-GREY-30G', 'SIDE-FLASHING-MATTE-CHARCOAL-GREY-30G', 300.00, NULL, NULL, 200, NULL, '887434a1facc6a28b5006129ddb97ef1b5c8f10844b938e8e7f122ee9e041472', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(306, 344, 'SIDE-FLASHING-MATTE-CHARCOAL-GREY-28G', 'SIDE-FLASHING-MATTE-CHARCOAL-GREY-28G', 350.00, NULL, NULL, 200, NULL, '46e9ac79617e5b9c9c63811882f9ea531ddc82b2ac9c9c713224d217bc3b6d5b', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(307, 345, 'SIDE-FLASHING-MATTE-CHOCOLATE-BROWN-30G', 'SIDE-FLASHING-MATTE-CHOCOLATE-BROWN-30G', 300.00, NULL, NULL, 200, NULL, 'a760eb309a6d1876f2581ff9862d4cc9a3b884cf73506dc1c899ccf0d24408b8', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(308, 345, 'SIDE-FLASHING-MATTE-CHOCOLATE-BROWN-28G', 'SIDE-FLASHING-MATTE-CHOCOLATE-BROWN-28G', 350.00, NULL, NULL, 200, NULL, 'a573dd81771fad28953739d6c3261e682eeea2b189154547c0ce71a27c836d4e', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(309, 346, 'SIDE-FLASHING-MATTE-MAROON-30G', 'SIDE-FLASHING-MATTE-MAROON-30G', 300.00, NULL, NULL, 200, NULL, '1651d65f07075cb9acc69d7de852d50fca4504c7b3ef1b5a60834a96a7d2c831', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(310, 346, 'SIDE-FLASHING-MATTE-MAROON-28G', 'SIDE-FLASHING-MATTE-MAROON-28G', 350.00, NULL, NULL, 200, NULL, '56523d27f9d1bbecfff5ca65a2db549cc929e96f13eb8fc20f6caa3b901220da', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(311, 347, 'SIDE-FLASHING-MATTE-TILE-RED-30G', 'SIDE-FLASHING-MATTE-TILE-RED-30G', 300.00, NULL, NULL, 200, NULL, '3d1cf4646eb50122e294da989d454eea41f98335c22359d7ffdc8e0d292c95bb', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(312, 347, 'SIDE-FLASHING-MATTE-TILE-RED-28G', 'SIDE-FLASHING-MATTE-TILE-RED-28G', 350.00, NULL, NULL, 200, NULL, 'a649aefa42cfa866e1fa9ecf9ab8d9b8d4c9c91db9c78cc93778dbcf448e2fde', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(313, 348, 'SIDE-FLASHING-MATTE-BRICK-RED-30G', 'SIDE-FLASHING-MATTE-BRICK-RED-30G', 300.00, NULL, NULL, 200, NULL, '39226f3e536f687c879ac23f208fc9420789ddde49701efa3027a509ec028c4e', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(314, 348, 'SIDE-FLASHING-MATTE-BRICK-RED-28G', 'SIDE-FLASHING-MATTE-BRICK-RED-28G', 350.00, NULL, NULL, 200, NULL, '175e06cb468913f9970418dd9e6cd97b377e0510eb77af9f0dfe443af43f0e94', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(315, 349, 'SIDE-FLASHING-MATTE-OCEAN-BLUE-30G', 'SIDE-FLASHING-MATTE-OCEAN-BLUE-30G', 300.00, NULL, NULL, 200, NULL, '3429f0960d03c82cd941b6d3797802b6e9ac18788d9ff9c676d4ca1013f52fbd', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(316, 349, 'SIDE-FLASHING-MATTE-OCEAN-BLUE-28G', 'SIDE-FLASHING-MATTE-OCEAN-BLUE-28G', 350.00, NULL, NULL, 200, NULL, '7f5267da9c59cda6a24e372c52bfb4c363cd8aa86a2c8729214213e0bd3ca1cd', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(317, 350, 'SIDE-FLASHING-MATTE-JUNGLE-GREEN-30G', 'SIDE-FLASHING-MATTE-JUNGLE-GREEN-30G', 300.00, NULL, NULL, 200, NULL, '746a596296e7dbb5e1727c719fca3f0b6ad7f98c3b2bf893fae6090479098538', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(318, 350, 'SIDE-FLASHING-MATTE-JUNGLE-GREEN-28G', 'SIDE-FLASHING-MATTE-JUNGLE-GREEN-28G', 350.00, NULL, NULL, 200, NULL, '0edcd1b342a774e1f1a8ce512101fc2e23eb57fb5d3b82c2d41d2c3eb9999766', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(319, 351, 'SIDE-FLASHING-MATTE-DARK-GREEN-30G', 'SIDE-FLASHING-MATTE-DARK-GREEN-30G', 300.00, NULL, NULL, 200, NULL, 'b10b734abba58fd844c1ba2bb63d155d438059efd36663fc66d1789461868886', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(320, 351, 'SIDE-FLASHING-MATTE-DARK-GREEN-28G', 'SIDE-FLASHING-MATTE-DARK-GREEN-28G', 350.00, NULL, NULL, 200, NULL, '2be5a7906cb797e48ad0e4e5ca423a7460f5d23dc1bc3d04a02bf004fe11416c', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(321, 352, 'VALLEY-TRAY-GALVANIZED-METALLIC-SILVER-30G', 'VALLEY-TRAY-GALVANIZED-METALLIC-SILVER-30G', 300.00, NULL, NULL, 200, NULL, '72f6b44af9dd036d7429974b589ced1c1a2140a5b53d5d237cbe317a2aac335e', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(322, 352, 'VALLEY-TRAY-GALVANIZED-METALLIC-SILVER-28G', 'VALLEY-TRAY-GALVANIZED-METALLIC-SILVER-28G', 350.00, NULL, NULL, 200, NULL, '9e658125860388f322eb1e52dfe7db60e81f5bcd349f0c596bbb3f3bea6d0fdf', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(323, 353, 'VALLEY-TRAY-COLOR-COATED-CHARCOAL-GREY-30G', 'VALLEY-TRAY-COLOR-COATED-CHARCOAL-GREY-30G', 300.00, NULL, NULL, 200, NULL, '0a4ea7e5397f18af4d900fa13485f5fb10d69fe52868b7dc7e54d8dfeb43c121', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(324, 353, 'VALLEY-TRAY-COLOR-COATED-CHARCOAL-GREY-28G', 'VALLEY-TRAY-COLOR-COATED-CHARCOAL-GREY-28G', 350.00, NULL, NULL, 200, NULL, '4119d5134279e9a98edaacb12e640f7108e75dd7c5ce076ac88b43cc702968a5', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(325, 354, 'VALLEY-TRAY-COLOR-COATED-BRICK-RED-30G', 'VALLEY-TRAY-COLOR-COATED-BRICK-RED-30G', 300.00, NULL, NULL, 200, NULL, '2cb7d31bfeb7f5fa4274b76c1b19e941f4c16cb4f54cec3c36384102af7f69d4', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(326, 354, 'VALLEY-TRAY-COLOR-COATED-BRICK-RED-28G', 'VALLEY-TRAY-COLOR-COATED-BRICK-RED-28G', 350.00, NULL, NULL, 200, NULL, 'a3e142aff252cb3ddba2465a693652af265c50bba1a56b918244cd745d5fd385', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(327, 355, 'VALLEY-TRAY-COLOR-COATED-TILE-RED-30G', 'VALLEY-TRAY-COLOR-COATED-TILE-RED-30G', 300.00, NULL, NULL, 200, NULL, '76281ce9cf81cce37df52782653278ac986bece0fc3d1504c46f42f0a49b86a4', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(328, 355, 'VALLEY-TRAY-COLOR-COATED-TILE-RED-28G', 'VALLEY-TRAY-COLOR-COATED-TILE-RED-28G', 350.00, NULL, NULL, 200, NULL, 'f0d2d3183f2a025f14ab9cc8b004b08665931139d85e13015e072859d41ed0e5', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(329, 356, 'VALLEY-TRAY-COLOR-COATED-MAROON-30G', 'VALLEY-TRAY-COLOR-COATED-MAROON-30G', 300.00, NULL, NULL, 200, NULL, '0d97a854a473ba1ebce9d4295628d2c3ad2f51a7077a6b50d983e3cb1651fd55', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(330, 356, 'VALLEY-TRAY-COLOR-COATED-MAROON-28G', 'VALLEY-TRAY-COLOR-COATED-MAROON-28G', 350.00, NULL, NULL, 200, NULL, 'bb65fe9cd339a64f3881e3edf37ad804dcd77cd5bdc5e06dd84e62c0b58b21e6', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(331, 357, 'VALLEY-TRAY-COLOR-COATED-JUNGLE-GREEN-30G', 'VALLEY-TRAY-COLOR-COATED-JUNGLE-GREEN-30G', 300.00, NULL, NULL, 200, NULL, '86a65e5563e31845d5fb8bbd6a7f4c09dc00b1dae8f2fce43d3540c1e08e03f8', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(332, 357, 'VALLEY-TRAY-COLOR-COATED-JUNGLE-GREEN-28G', 'VALLEY-TRAY-COLOR-COATED-JUNGLE-GREEN-28G', 350.00, NULL, NULL, 200, NULL, '84e1755c6e2727010ce3ae45c710ed7eda5bb79388b9a8a89f1cda2f5fa66828', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(333, 358, 'VALLEY-TRAY-COLOR-COATED-OCEAN-BLUE-30G', 'VALLEY-TRAY-COLOR-COATED-OCEAN-BLUE-30G', 300.00, NULL, NULL, 200, NULL, '0e03251f1560b590f0c625e0be43a4ce57ceedbb45572a60bf1efdc83402d9f7', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(334, 358, 'VALLEY-TRAY-COLOR-COATED-OCEAN-BLUE-28G', 'VALLEY-TRAY-COLOR-COATED-OCEAN-BLUE-28G', 350.00, NULL, NULL, 200, NULL, '99fc2cc76dfec06eb0eaed630fd9a863ab8212da2c4fb233e877743740ed46fa', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(335, 359, 'VALLEY-TRAY-COLOR-COATED-CHOCOLATE-BROWN-30G', 'VALLEY-TRAY-COLOR-COATED-CHOCOLATE-BROWN-30G', 300.00, NULL, NULL, 200, NULL, 'e53a35fe1bf732664236d850d0e0da0cc7e808fc3821cb98dcee462196d39267', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(336, 359, 'VALLEY-TRAY-COLOR-COATED-CHOCOLATE-BROWN-28G', 'VALLEY-TRAY-COLOR-COATED-CHOCOLATE-BROWN-28G', 350.00, NULL, NULL, 200, NULL, 'b48aaa9ef7b79dee62b762162922d382ee8070a60e5cb867f8e1fc5c189a8fd4', '2026-10-14 16:52:25', '2026-10-14 16:52:25');
INSERT INTO `su_product_variants` (`id`, `product_id`, `variant_code`, `sku`, `price`, `sale_price`, `cost_price`, `stock_quantity`, `image`, `variant_signature`, `created_at`, `updated_at`) VALUES
(337, 360, 'VALLEY-TRAY-COLOR-COATED-DARK-GREEN-30G', 'VALLEY-TRAY-COLOR-COATED-DARK-GREEN-30G', 300.00, NULL, NULL, 200, NULL, '6b1dd233803414e5305cbef9eb0ca411b486e6d156b14dc2afafba2ebf42986e', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(338, 360, 'VALLEY-TRAY-COLOR-COATED-DARK-GREEN-28G', 'VALLEY-TRAY-COLOR-COATED-DARK-GREEN-28G', 350.00, NULL, NULL, 200, NULL, 'ef6eb0d9f732893e33c066e8f3bd7412e78231ffd7bc06b6dce95d896281374d', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(339, 361, 'PLAIN-SHEET-GLOSSY-CHARCOAL-GREY-30G', 'PLAIN-SHEET-GLOSSY-CHARCOAL-GREY-30G', 600.00, NULL, NULL, 200, NULL, '6ee86a9002d0e633e8c4aa5569a48528ba147bf3a6339d94532e9e05d0697045', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(340, 361, 'PLAIN-SHEET-GLOSSY-CHARCOAL-GREY-28G', 'PLAIN-SHEET-GLOSSY-CHARCOAL-GREY-28G', 700.00, NULL, NULL, 200, NULL, '0063f05c8c157da5a083c187a199103eb442ff988b198d18f8a5b2815530859a', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(341, 362, 'PLAIN-SHEET-GLOSSY-BRICK-RED-30G', 'PLAIN-SHEET-GLOSSY-BRICK-RED-30G', 600.00, NULL, NULL, 200, NULL, '3ae9ee209c0bb52c1a7789a0e62265bdf7a8dab24cd4e5aa54953c72d72ec6b6', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(342, 362, 'PLAIN-SHEET-GLOSSY-BRICK-RED-28G', 'PLAIN-SHEET-GLOSSY-BRICK-RED-28G', 700.00, NULL, NULL, 200, NULL, 'c374430d323c59c78e3f404184db3605ac893574f5f8a28020bf3fdb5bd61aa4', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(343, 363, 'PLAIN-SHEET-GLOSSY-TILE-RED-30G', 'PLAIN-SHEET-GLOSSY-TILE-RED-30G', 600.00, NULL, NULL, 200, NULL, 'bc8dcaa5a46100d4618088917c04857467f434395fd355200c60a82a7bbf0e58', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(344, 363, 'PLAIN-SHEET-GLOSSY-TILE-RED-28G', 'PLAIN-SHEET-GLOSSY-TILE-RED-28G', 700.00, NULL, NULL, 200, NULL, '4dfa80821dacf15789c1e091cda69a06811fd0cc55c65644627e81555a234168', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(345, 364, 'PLAIN-SHEET-GLOSSY-MAROON-30G', 'PLAIN-SHEET-GLOSSY-MAROON-30G', 600.00, NULL, NULL, 200, NULL, 'edd96ff3562dce19961640650ba1dd466acb450d7ded6354fddabf58b1e41fc6', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(346, 364, 'PLAIN-SHEET-GLOSSY-MAROON-28G', 'PLAIN-SHEET-GLOSSY-MAROON-28G', 700.00, NULL, NULL, 200, NULL, '067ac70b1b150b1b4eb3b9f5cc9172f8f07e1079979af0fc766aba50a85bad6d', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(347, 365, 'PLAIN-SHEET-GLOSSY-JUNGLE-GREEN-30G', 'PLAIN-SHEET-GLOSSY-JUNGLE-GREEN-30G', 600.00, NULL, NULL, 200, NULL, '3625c3d59210536a85df6dcee3edc5392f3c507f97c5faa1b48baab514eba51c', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(348, 365, 'PLAIN-SHEET-GLOSSY-JUNGLE-GREEN-28G', 'PLAIN-SHEET-GLOSSY-JUNGLE-GREEN-28G', 700.00, NULL, NULL, 200, NULL, '4d7f1e8a26c0fd241056618a34408a8e3b3ad5d601513842787811035fe15cda', '2026-10-14 16:52:25', '2026-10-14 16:52:25'),
(349, 366, 'PLAIN-SHEET-GLOSSY-OCEAN-BLUE-30G', 'PLAIN-SHEET-GLOSSY-OCEAN-BLUE-30G', 600.00, NULL, NULL, 200, NULL, 'fb7f2ef38526497ad1b7f07f4b934303a9ffe4095b042032458de539bf7fec20', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(350, 366, 'PLAIN-SHEET-GLOSSY-OCEAN-BLUE-28G', 'PLAIN-SHEET-GLOSSY-OCEAN-BLUE-28G', 700.00, NULL, NULL, 200, NULL, '3d66bd6e7b14064caed78de2d9efc3634ecbb1f5860599a75354392bdeb6ee6f', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(351, 370, 'VALLEY-TRAY-STONE-COATED-CHARCOAL-GREY-28G', 'VALLEY-TRAY-STONE-COATED-CHARCOAL-GREY-28G', 750.00, NULL, NULL, 200, NULL, '4d1b36af7ae0b79f500dd3d36d5a76c84b638e47d46cdafb6106cb5daf94de3a', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(352, 370, 'VALLEY-TRAY-STONE-COATED-CHARCOAL-GREY-26G', 'VALLEY-TRAY-STONE-COATED-CHARCOAL-GREY-26G', 800.00, NULL, NULL, 200, NULL, '1b1b1d19136277092f3ae2e69f86a56253274dadc75f80498efe8a08b0151444', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(353, 371, 'VALLEY-TRAY-STONE-COATED-DARK-BROWN-28G', 'VALLEY-TRAY-STONE-COATED-DARK-BROWN-28G', 750.00, NULL, NULL, 200, NULL, '9f1088b13d77f8c075fe246e7fb69e78ba5db11a4a299c283860f239e0ecdf04', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(354, 371, 'VALLEY-TRAY-STONE-COATED-DARK-BROWN-26G', 'VALLEY-TRAY-STONE-COATED-DARK-BROWN-26G', 800.00, NULL, NULL, 200, NULL, 'a7534888873fd21d6433783c8110096aae40e3108e399f44cc435c84a2cce380', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(355, 372, 'VALLEY-TRAY-STONE-COATED-BRICK-RED-28G', 'VALLEY-TRAY-STONE-COATED-BRICK-RED-28G', 750.00, NULL, NULL, 200, NULL, '10e800f0785b84dd1c9ae4a8f51f82147e8daaf0f5f4907bbc0f86449b4d1ede', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(356, 372, 'VALLEY-TRAY-STONE-COATED-BRICK-RED-26G', 'VALLEY-TRAY-STONE-COATED-BRICK-RED-26G', 800.00, NULL, NULL, 200, NULL, 'ec22337173c2371781c3b239169357a9e7c06cbfbd54933fbdeb9a682a51752d', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(357, 373, 'VALLEY-TRAY-STONE-COATED-MAROON-28G', 'VALLEY-TRAY-STONE-COATED-MAROON-28G', 750.00, NULL, NULL, 200, NULL, '69f870aa78a0c11786424fd1cbc579213207a87b714aeb5d6fffd574e33921ef', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(358, 373, 'VALLEY-TRAY-STONE-COATED-MAROON-26G', 'VALLEY-TRAY-STONE-COATED-MAROON-26G', 800.00, NULL, NULL, 200, NULL, 'b1be3fb65367efbafb44a8889346b6c2e0c094d8cb1f0aac744d8fc1bfe25430', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(359, 374, 'VALLEY-TRAY-STONE-COATED-BLACK-28G', 'VALLEY-TRAY-STONE-COATED-BLACK-28G', 750.00, NULL, NULL, 200, NULL, '719f6e9096daee6cde4d6a4f6698868edf9868313726e499066c17dfd66c41e2', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(360, 374, 'VALLEY-TRAY-STONE-COATED-BLACK-26G', 'VALLEY-TRAY-STONE-COATED-BLACK-26G', 800.00, NULL, NULL, 200, NULL, '16ad74c6565336351ebc6a2a9da277f858a3ffa291b8436bb4aea73d4710d143', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(361, 375, 'VALLEY-TRAY-STONE-COATED-BARK-WOOD-BROWN-28G', 'VALLEY-TRAY-STONE-COATED-BARK-WOOD-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'fddf68bd669b575e163e0fb82207327745c4f10f9d4c76c54efc045919d1f931', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(362, 375, 'VALLEY-TRAY-STONE-COATED-BARK-WOOD-BROWN-26G', 'VALLEY-TRAY-STONE-COATED-BARK-WOOD-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '795ecec3152fe46e05659103b3bb6cd22e1d775948ae8e74d78a3893bf9b8f5e', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(363, 376, 'VALLEY-TRAY-STONE-COATED-DARK-GREEN-28G', 'VALLEY-TRAY-STONE-COATED-DARK-GREEN-28G', 750.00, NULL, NULL, 200, NULL, 'e2084499570ea61c926c5af0e2f281f96eec58e4bf74110dc25ab98bc7a91015', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(364, 376, 'VALLEY-TRAY-STONE-COATED-DARK-GREEN-26G', 'VALLEY-TRAY-STONE-COATED-DARK-GREEN-26G', 800.00, NULL, NULL, 200, NULL, 'd099a1243f3bb7797112083ec200ab38c54d737a703745e19dc06defdec2f95a', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(365, 377, 'VALLEY-TRAY-STONE-COATED-TERRACOTTA-28G', 'VALLEY-TRAY-STONE-COATED-TERRACOTTA-28G', 750.00, NULL, NULL, 200, NULL, '1f64ff3bfa7f1d107954ddf6e36c3dda861f2dbb8d2d7982073125da4803dd74', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(366, 377, 'VALLEY-TRAY-STONE-COATED-TERRACOTTA-26G', 'VALLEY-TRAY-STONE-COATED-TERRACOTTA-26G', 800.00, NULL, NULL, 200, NULL, '778fbe642506f240be1c0ad1ae7cd635d0715a70742ab3a03df9a17719f52bf9', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(367, 378, 'VALLEY-TRAY-STONE-COATED-CHOCOLATE-BROWN-28G', 'VALLEY-TRAY-STONE-COATED-CHOCOLATE-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'e1883fe6886b96de9430249112c4197920c84879a47b51a585599818296386f2', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(368, 378, 'VALLEY-TRAY-STONE-COATED-CHOCOLATE-BROWN-26G', 'VALLEY-TRAY-STONE-COATED-CHOCOLATE-BROWN-26G', 800.00, NULL, NULL, 200, NULL, 'eb2a70309680d42c19dea615e55c8f77b328c5bda407f28b5576c2b75eb6716f', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(369, 379, 'RIDGE-CAP-STONE-COATED-CHARCOAL-GREY-28G', 'RIDGE-CAP-STONE-COATED-CHARCOAL-GREY-28G', 750.00, NULL, NULL, 200, NULL, '0d117086b5231d6c9851401093be8e3f5c7f5edd6f14255a94cc955931b1c569', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(370, 379, 'RIDGE-CAP-STONE-COATED-CHARCOAL-GREY-26G', 'RIDGE-CAP-STONE-COATED-CHARCOAL-GREY-26G', 800.00, NULL, NULL, 200, NULL, '057f0ba1b85971bc05240272536fcf06f570c66bfde698b4aa66c41424a13475', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(371, 380, 'RIDGE-CAP-STONE-COATED-DARK-BROWN-28G', 'RIDGE-CAP-STONE-COATED-DARK-BROWN-28G', 750.00, NULL, NULL, 200, NULL, '2a7f5e8335877cdebc0b2fa2588ccb62e5f8993795d1132fb5688847e083ad5f', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(372, 380, 'RIDGE-CAP-STONE-COATED-DARK-BROWN-26G', 'RIDGE-CAP-STONE-COATED-DARK-BROWN-26G', 800.00, NULL, NULL, 200, NULL, 'ed6219b7c0e936ace58143223d2aa2f3cf219e9c2256f9d152a63c71648dab77', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(373, 381, 'RIDGE-CAP-STONE-COATED-BRICK-RED-28G', 'RIDGE-CAP-STONE-COATED-BRICK-RED-28G', 750.00, NULL, NULL, 200, NULL, '1f392dfd9d1d00bc04fbd284b752f5d738bf0bf13bd8699c766c6c0c50575bc6', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(374, 381, 'RIDGE-CAP-STONE-COATED-BRICK-RED-26G', 'RIDGE-CAP-STONE-COATED-BRICK-RED-26G', 800.00, NULL, NULL, 200, NULL, '946587bc7759db43c5972acf58360ad1b108734dd842015e030bc70d6e5eda93', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(375, 382, 'RIDGE-CAP-STONE-COATED-MAROON-28G', 'RIDGE-CAP-STONE-COATED-MAROON-28G', 750.00, NULL, NULL, 200, NULL, '97b906560ed328417f55e2f9299f92231d81e9d99c16c1b81da2d99d110de193', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(376, 382, 'RIDGE-CAP-STONE-COATED-MAROON-26G', 'RIDGE-CAP-STONE-COATED-MAROON-26G', 800.00, NULL, NULL, 200, NULL, '1db9d5d89d29dd2fd556e4357c5f06bdf782022074583895d579b8d809b7c1fd', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(377, 383, 'RIDGE-CAP-STONE-COATED-BLACK-28G', 'RIDGE-CAP-STONE-COATED-BLACK-28G', 750.00, NULL, NULL, 200, NULL, 'aa98f95ca964a73211e75fd708a1884f4527a35f795f3871fd54d781243aaa7d', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(378, 383, 'RIDGE-CAP-STONE-COATED-BLACK-26G', 'RIDGE-CAP-STONE-COATED-BLACK-26G', 800.00, NULL, NULL, 200, NULL, 'e5422fe8d864dd99e7037d0bbde98f569682ed49c1b0e2b083f559e6055aefa6', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(379, 384, 'RIDGE-CAP-STONE-COATED-BARK-WOOD-BROWN-28G', 'RIDGE-CAP-STONE-COATED-BARK-WOOD-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'edba68f409a00701b2b03a5d6df12586c85645d0eb427243699e6cc9a38e57e2', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(380, 384, 'RIDGE-CAP-STONE-COATED-BARK-WOOD-BROWN-26G', 'RIDGE-CAP-STONE-COATED-BARK-WOOD-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '8caab1a573390412d4caa4d8138e58a6de49a5a700fe4a064b52b9b02c456041', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(381, 385, 'RIDGE-CAP-STONE-COATED-DARK-GREEN-28G', 'RIDGE-CAP-STONE-COATED-DARK-GREEN-28G', 750.00, NULL, NULL, 200, NULL, '5042d02665fd2a847a5182ee16bea735a5f35573ffa32e6eeb8d103014dd5c25', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(382, 385, 'RIDGE-CAP-STONE-COATED-DARK-GREEN-26G', 'RIDGE-CAP-STONE-COATED-DARK-GREEN-26G', 800.00, NULL, NULL, 200, NULL, 'dd3346219107e125651453106c58d175ce3aac014f5223ef8d9a325a5859edbf', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(383, 386, 'RIDGE-CAP-STONE-COATED-TERRACOTTA-28G', 'RIDGE-CAP-STONE-COATED-TERRACOTTA-28G', 750.00, NULL, NULL, 200, NULL, '76bd5bded12c52fbf5eb9eb9559e8e5f1163ca23913b07ba4293d6968643d17f', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(384, 386, 'RIDGE-CAP-STONE-COATED-TERRACOTTA-26G', 'RIDGE-CAP-STONE-COATED-TERRACOTTA-26G', 800.00, NULL, NULL, 200, NULL, 'be02604c2810401063bbd511a2c0ab15d28bf467fdfa7362a8c0258662af48f7', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(385, 387, 'RIDGE-CAP-STONE-COATED-CHOCOLATE-BROWN-28G', 'RIDGE-CAP-STONE-COATED-CHOCOLATE-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'f23b14b86b0399293ffd062db1a891b1721c86d7f6172574b7591265120f369d', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(386, 387, 'RIDGE-CAP-STONE-COATED-CHOCOLATE-BROWN-26G', 'RIDGE-CAP-STONE-COATED-CHOCOLATE-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '665478607ba70eb47f8bf626e2b0abea1b23fc3a24d4cb9bdde89574ab28b7f4', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(387, 388, 'SIDE-FLASHING-STONE-COATED-CHARCOAL-GREY-28G', 'SIDE-FLASHING-STONE-COATED-CHARCOAL-GREY-28G', 750.00, NULL, NULL, 200, NULL, 'e75013c972761036c2dae3715765da12f6a1296d20bd656f25b8041ba3ac7b33', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(388, 388, 'SIDE-FLASHING-STONE-COATED-CHARCOAL-GREY-26G', 'SIDE-FLASHING-STONE-COATED-CHARCOAL-GREY-26G', 800.00, NULL, NULL, 200, NULL, '39083d60425c2403a72f209538413d2e6a02ba5183bd93de17edd9807b00b57f', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(389, 389, 'SIDE-FLASHING-STONE-COATED-DARK-BROWN-28G', 'SIDE-FLASHING-STONE-COATED-DARK-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'c0550a8cafca04c76139f1da9ba717db63920a6e474da2b963a61e05e7525415', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(390, 389, 'SIDE-FLASHING-STONE-COATED-DARK-BROWN-26G', 'SIDE-FLASHING-STONE-COATED-DARK-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '349fbc539c482020bb031d3a8d63cde09d1bbe77c64950579f8a33537389581a', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(391, 390, 'SIDE-FLASHING-STONE-COATED-BRICK-RED-28G', 'SIDE-FLASHING-STONE-COATED-BRICK-RED-28G', 750.00, NULL, NULL, 200, NULL, '38970c21cb090770137c5e10f1028f23a5764efed073dfbcc1e2fd081d972b41', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(392, 390, 'SIDE-FLASHING-STONE-COATED-BRICK-RED-26G', 'SIDE-FLASHING-STONE-COATED-BRICK-RED-26G', 800.00, NULL, NULL, 200, NULL, '55ff2434787ef018a19abf2c193e55a7d3a95ccfe58878aec535ee8bfa26ec0e', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(393, 391, 'SIDE-FLASHING-STONE-COATED-MAROON-28G', 'SIDE-FLASHING-STONE-COATED-MAROON-28G', 750.00, NULL, NULL, 200, NULL, '9574e7331fd829ca9f057965288837db392c50ed771de7c45268b07ce8c5ad75', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(394, 391, 'SIDE-FLASHING-STONE-COATED-MAROON-26G', 'SIDE-FLASHING-STONE-COATED-MAROON-26G', 800.00, NULL, NULL, 200, NULL, '03fcb65d132527916f161f31d0ea38b2ad1e1bc3ec42f567313077518a7e9976', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(395, 392, 'SIDE-FLASHING-STONE-COATED-BLACK-28G', 'SIDE-FLASHING-STONE-COATED-BLACK-28G', 750.00, NULL, NULL, 200, NULL, '34905a5c518a0c4fd1bbe7f4ef34c8de0ef6893998436dedf3612844e4904100', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(396, 392, 'SIDE-FLASHING-STONE-COATED-BLACK-26G', 'SIDE-FLASHING-STONE-COATED-BLACK-26G', 800.00, NULL, NULL, 200, NULL, '33a9e5e61c71c2973bed2025a4dffffedcde4e7d2e4f5efe859b8e6206337eb0', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(397, 393, 'SIDE-FLASHING-STONE-COATED-BARK-WOOD-BROWN-28G', 'SIDE-FLASHING-STONE-COATED-BARK-WOOD-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'e824ccd9e418c46b1833457f742c12afc44a0088e6e4cf132274c3e833298fb4', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(398, 393, 'SIDE-FLASHING-STONE-COATED-BARK-WOOD-BROWN-26G', 'SIDE-FLASHING-STONE-COATED-BARK-WOOD-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '79cf48e4c7c3367cef79d9727c814392b98b369b308f3108f44c494bb19ee512', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(399, 394, 'SIDE-FLASHING-STONE-COATED-DARK-GREEN-28G', 'SIDE-FLASHING-STONE-COATED-DARK-GREEN-28G', 750.00, NULL, NULL, 200, NULL, '7317de7b6c5ce900883a42634b86b50ce81d6f8db815e6d5895a90a8041689bf', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(400, 394, 'SIDE-FLASHING-STONE-COATED-DARK-GREEN-26G', 'SIDE-FLASHING-STONE-COATED-DARK-GREEN-26G', 800.00, NULL, NULL, 200, NULL, '9065408f43cd85cc6e033ef97695bd18c0c4e14f4457b94022b44ca0c5201462', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(401, 395, 'SIDE-FLASHING-STONE-COATED-TERRACOTTA-28G', 'SIDE-FLASHING-STONE-COATED-TERRACOTTA-28G', 750.00, NULL, NULL, 200, NULL, '703bf4a46ddbf83b10ef6f5bdf87cfe1c5095a331484609d55dcc212bb33bd26', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(402, 395, 'SIDE-FLASHING-STONE-COATED-TERRACOTTA-26G', 'SIDE-FLASHING-STONE-COATED-TERRACOTTA-26G', 800.00, NULL, NULL, 200, NULL, '722f7166b5e48cd7dca9cacf491b2360f8a3baf38996d70661af084a59eb1f0a', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(403, 396, 'SIDE-FLASHING-STONE-COATED-CHOCOLATE-BROWN-28G', 'SIDE-FLASHING-STONE-COATED-CHOCOLATE-BROWN-28G', 750.00, NULL, NULL, 200, NULL, '3acab13c6eefc5fcf29e0d5f5923d34f9cf31c6b1ef4bb5b6af4a16449c9b569', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(404, 396, 'SIDE-FLASHING-STONE-COATED-CHOCOLATE-BROWN-26G', 'SIDE-FLASHING-STONE-COATED-CHOCOLATE-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '9f1679c204899de56ec811e0785a81c0928eb579bb6979a075665e353066a121', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(405, 397, 'PLAIN-SHEET-STONE-COATED-CHARCOAL-GREY-28G', 'PLAIN-SHEET-STONE-COATED-CHARCOAL-GREY-28G', 750.00, NULL, NULL, 200, NULL, '8da3661d899b523121871afc6601901e0e42933acdbd477f98c9641bc1f91786', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(406, 397, 'PLAIN-SHEET-STONE-COATED-CHARCOAL-GREY-26G', 'PLAIN-SHEET-STONE-COATED-CHARCOAL-GREY-26G', 800.00, NULL, NULL, 200, NULL, 'e9a137f738a57c4bcf951c73138562e0f79a284ac7b605210cf27c0e12537909', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(407, 398, 'PLAIN-SHEET-STONE-COATED-DARK-BROWN-28G', 'PLAIN-SHEET-STONE-COATED-DARK-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'eef49f6a8f2d64cb2a1b92e10c57f321a2f2c407a655def160909cd3ba3966b5', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(408, 398, 'PLAIN-SHEET-STONE-COATED-DARK-BROWN-26G', 'PLAIN-SHEET-STONE-COATED-DARK-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '388244bb31c7dda29410358f6248112cddb245e2e6d8dd2f321b80c6c182748a', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(409, 399, 'PLAIN-SHEET-STONE-COATED-BRICK-RED-28G', 'PLAIN-SHEET-STONE-COATED-BRICK-RED-28G', 750.00, NULL, NULL, 200, NULL, '3e14fb344e6a2d275a78da534a5815137c9219bee4a97066a2dede43ccb3ddb8', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(410, 399, 'PLAIN-SHEET-STONE-COATED-BRICK-RED-26G', 'PLAIN-SHEET-STONE-COATED-BRICK-RED-26G', 800.00, NULL, NULL, 200, NULL, '94cd7bfffd0c8cd46863ce2fcc727fa0b2c1cfee9cc3e350ae6723787ffc45fe', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(411, 400, 'PLAIN-SHEET-STONE-COATED-MAROON-28G', 'PLAIN-SHEET-STONE-COATED-MAROON-28G', 750.00, NULL, NULL, 200, NULL, 'bb61a327bfa6538b40c36597dc427e5e28b6155e8f8144406c3fdfd081562fd1', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(412, 400, 'PLAIN-SHEET-STONE-COATED-MAROON-26G', 'PLAIN-SHEET-STONE-COATED-MAROON-26G', 800.00, NULL, NULL, 200, NULL, '45785b1a76e1a767e6031dab31f027c07d9254ec58c74d737f1e480a09f869db', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(413, 401, 'PLAIN-SHEET-STONE-COATED-BLACK-28G', 'PLAIN-SHEET-STONE-COATED-BLACK-28G', 750.00, NULL, NULL, 200, NULL, 'e5e10bdd1ee44625559e242b14734c0ab4688afefff3b7ac22a2cd0c2801abd1', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(414, 401, 'PLAIN-SHEET-STONE-COATED-BLACK-26G', 'PLAIN-SHEET-STONE-COATED-BLACK-26G', 800.00, NULL, NULL, 200, NULL, '048bcd0ecf57b324ed1f58bd71fd22ea0099b298abecd74f3faf2c651865fe6d', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(415, 402, 'PLAIN-SHEET-STONE-COATED-BARK-WOOD-BROWN-28G', 'PLAIN-SHEET-STONE-COATED-BARK-WOOD-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'c69e95f2de3716693012f0df7a898d4726d84531d170a29c87abb65e90aaf1db', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(416, 402, 'PLAIN-SHEET-STONE-COATED-BARK-WOOD-BROWN-26G', 'PLAIN-SHEET-STONE-COATED-BARK-WOOD-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '89eaacba28342f92d1b493f4345d50e3f1ccc5c52aa9075a5db6d656ae587186', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(417, 403, 'PLAIN-SHEET-STONE-COATED-DARK-GREEN-28G', 'PLAIN-SHEET-STONE-COATED-DARK-GREEN-28G', 750.00, NULL, NULL, 200, NULL, 'a7cbd01f45eab4e24400452ce75ef25f532d05d3759be8b09fc028aa7bbca5d1', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(418, 403, 'PLAIN-SHEET-STONE-COATED-DARK-GREEN-26G', 'PLAIN-SHEET-STONE-COATED-DARK-GREEN-26G', 800.00, NULL, NULL, 200, NULL, 'e7189b3a6974bff55e610fec033b96ada05dc913296646cac4cc8736a850a9ea', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(419, 404, 'PLAIN-SHEET-STONE-COATED-TERRACOTTA-28G', 'PLAIN-SHEET-STONE-COATED-TERRACOTTA-28G', 750.00, NULL, NULL, 200, NULL, 'b9cddb6dbf4e3f40d6f514b6d0743a1396c2ca4e328b0bc34dd204aa41c99224', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(420, 404, 'PLAIN-SHEET-STONE-COATED-TERRACOTTA-26G', 'PLAIN-SHEET-STONE-COATED-TERRACOTTA-26G', 800.00, NULL, NULL, 200, NULL, 'a74be23d83e4eb768b96c4940d652ab93ec469b72d9d648f28c813acb39cf341', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(421, 405, 'PLAIN-SHEET-STONE-COATED-CHOCOLATE-BROWN-28G', 'PLAIN-SHEET-STONE-COATED-CHOCOLATE-BROWN-28G', 750.00, NULL, NULL, 200, NULL, '722bd00fb27c9b5258ac2155854c8d763c59d9545ef4fa93f2b0e22cc1bd372a', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(422, 405, 'PLAIN-SHEET-STONE-COATED-CHOCOLATE-BROWN-26G', 'PLAIN-SHEET-STONE-COATED-CHOCOLATE-BROWN-26G', 800.00, NULL, NULL, 200, NULL, 'bb579b3eafcb006af94be12733cf9dd38f8f92ce441e002741ea7d0f340f9c76', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(423, 406, 'BARGE-BOX-STONE-COATED-CHARCOAL-GREY-28G', 'BARGE-BOX-STONE-COATED-CHARCOAL-GREY-28G', 750.00, NULL, NULL, 200, NULL, '003eb8fcd4b9dc2874ee66b2935dfb188f775b7d5ef79190195ecc877f9c5352', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(424, 406, 'BARGE-BOX-STONE-COATED-CHARCOAL-GREY-26G', 'BARGE-BOX-STONE-COATED-CHARCOAL-GREY-26G', 800.00, NULL, NULL, 200, NULL, '0bdcbb37085a8306b99a1b2240fa42b9bfb59c8c1c174609c27e927dd718a3a8', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(425, 407, 'BARGE-BOX-STONE-COATED-DARK-BROWN-28G', 'BARGE-BOX-STONE-COATED-DARK-BROWN-28G', 750.00, NULL, NULL, 200, NULL, 'a5ba53bd7941789d5641f714d6af8830047ac2df2c056eef824bfb6c2c4d195c', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(426, 407, 'BARGE-BOX-STONE-COATED-DARK-BROWN-26G', 'BARGE-BOX-STONE-COATED-DARK-BROWN-26G', 800.00, NULL, NULL, 200, NULL, 'b582e83e374cce8714364b37af312db808c46f664267c2de4d2601a182f53d05', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(427, 408, 'BARGE-BOX-STONE-COATED-BRICK-RED-28G', 'BARGE-BOX-STONE-COATED-BRICK-RED-28G', 750.00, NULL, NULL, 200, NULL, 'f7a5b2577e603ae4e32ec6f0637c320e8ab2d4ae140790f6acac22b17b31a523', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(428, 408, 'BARGE-BOX-STONE-COATED-BRICK-RED-26G', 'BARGE-BOX-STONE-COATED-BRICK-RED-26G', 800.00, NULL, NULL, 200, NULL, '7247401b22e8ec6a0d11750572e494629edae0311b124606a4990134aa4895ea', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(429, 409, 'BARGE-BOX-STONE-COATED-MAROON-28G', 'BARGE-BOX-STONE-COATED-MAROON-28G', 750.00, NULL, NULL, 200, NULL, '2e179b72b88fc4df520547eb0d5e9f56ea3c8104bf96dce5f19905f630ee2ad9', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(430, 409, 'BARGE-BOX-STONE-COATED-MAROON-26G', 'BARGE-BOX-STONE-COATED-MAROON-26G', 800.00, NULL, NULL, 200, NULL, '5c7668415e03d7c16fd03428fe6a2c6791d598166549b40ebb2e3fb92545d3a8', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(431, 410, 'BARGE-BOX-STONE-COATED-BLACK-28G', 'BARGE-BOX-STONE-COATED-BLACK-28G', 750.00, NULL, NULL, 200, NULL, '7c0d097295e1b0c68de9527902c3fd193cf8e09f82bf4c24e138803065e85439', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(432, 410, 'BARGE-BOX-STONE-COATED-BLACK-26G', 'BARGE-BOX-STONE-COATED-BLACK-26G', 800.00, NULL, NULL, 200, NULL, '8c83c6bc04bb5697eac8aae7bf7cc7b885f74dca840bcf2057de43acdd74e26e', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(433, 411, 'BARGE-BOX-STONE-COATED-BARK-WOOD-BROWN-28G', 'BARGE-BOX-STONE-COATED-BARK-WOOD-BROWN-28G', 750.00, NULL, NULL, 200, NULL, '25bec69b7e0a8b3f503bdacdaded9173845eafb29728417e935b96b8413a8626', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(434, 411, 'BARGE-BOX-STONE-COATED-BARK-WOOD-BROWN-26G', 'BARGE-BOX-STONE-COATED-BARK-WOOD-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '69a7a4c63f81d32538fc4712ed0b8d9ca571ee7dfce2d20fabacef92ba2cde11', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(435, 412, 'BARGE-BOX-STONE-COATED-DARK-GREEN-28G', 'BARGE-BOX-STONE-COATED-DARK-GREEN-28G', 750.00, NULL, NULL, 200, NULL, 'ee35b05c7317814ca036f3ba3e3122d9e5c300fe2c9f12fcbf2e0fbb61e23010', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(436, 412, 'BARGE-BOX-STONE-COATED-DARK-GREEN-26G', 'BARGE-BOX-STONE-COATED-DARK-GREEN-26G', 800.00, NULL, NULL, 200, NULL, '61d11af6fddf6504b1e0bdd6d08625d06cdb7ee729576a5a1ffef61c51054dea', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(437, 413, 'BARGE-BOX-STONE-COATED-TERRACOTTA-28G', 'BARGE-BOX-STONE-COATED-TERRACOTTA-28G', 750.00, NULL, NULL, 200, NULL, 'd70277e8e4006f65f89fcb6c7471a8606e4f9967d252d71b5ad6bd61dfabaabe', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(438, 413, 'BARGE-BOX-STONE-COATED-TERRACOTTA-26G', 'BARGE-BOX-STONE-COATED-TERRACOTTA-26G', 800.00, NULL, NULL, 200, NULL, 'd13d42186ad24b7f238ed624a03a4e8e2a7604584eecaf1890cc7ce84aff7a6f', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(439, 414, 'BARGE-BOX-STONE-COATED-CHOCOLATE-BROWN-28G', 'BARGE-BOX-STONE-COATED-CHOCOLATE-BROWN-28G', 750.00, NULL, NULL, 200, NULL, '7bce37f47e9474deb253045fe31e5d72ad79bff57024dfdd1ddc4af1c7350fc2', '2026-10-14 16:52:26', '2026-10-14 16:52:26'),
(440, 414, 'BARGE-BOX-STONE-COATED-CHOCOLATE-BROWN-26G', 'BARGE-BOX-STONE-COATED-CHOCOLATE-BROWN-26G', 800.00, NULL, NULL, 200, NULL, '698b14f0d3ada8038487ea35e8df7e4877a1d1ef6837b1716883455a8bd943be', '2026-10-14 16:52:26', '2026-10-14 16:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `su_product_variant_attributes`
--

CREATE TABLE `su_product_variant_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED NOT NULL,
  `attribute_id` int(10) UNSIGNED NOT NULL,
  `attribute_value_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_product_variant_attributes`
--

INSERT INTO `su_product_variant_attributes` (`id`, `variant_id`, `attribute_id`, `attribute_value_id`) VALUES
(205, 131, 93, 178),
(206, 131, 94, 180),
(207, 132, 93, 179),
(208, 132, 94, 180),
(209, 133, 95, 181),
(210, 133, 96, 183),
(211, 134, 95, 182),
(212, 134, 96, 183),
(213, 135, 97, 184),
(214, 135, 98, 186),
(215, 136, 97, 185),
(216, 136, 98, 186),
(217, 137, 99, 187),
(218, 137, 100, 189),
(219, 138, 99, 188),
(220, 138, 100, 189),
(221, 139, 101, 190),
(222, 139, 102, 192),
(223, 140, 101, 191),
(224, 140, 102, 192),
(225, 141, 103, 193),
(226, 141, 104, 195),
(227, 142, 103, 194),
(228, 142, 104, 195),
(229, 143, 105, 196),
(230, 143, 106, 198),
(231, 144, 105, 197),
(232, 144, 106, 198),
(233, 145, 107, 199),
(234, 145, 108, 201),
(235, 146, 107, 200),
(236, 146, 108, 201),
(237, 147, 109, 202),
(238, 147, 110, 204),
(239, 148, 109, 203),
(240, 148, 110, 204),
(241, 149, 111, 205),
(242, 149, 112, 207),
(243, 150, 111, 206),
(244, 150, 112, 207),
(245, 151, 113, 208),
(246, 151, 114, 210),
(247, 152, 113, 209),
(248, 152, 114, 210),
(249, 153, 115, 211),
(250, 153, 116, 213),
(251, 154, 115, 212),
(252, 154, 116, 213),
(253, 155, 117, 214),
(254, 155, 118, 216),
(255, 156, 117, 215),
(256, 156, 118, 216),
(257, 157, 119, 217),
(258, 157, 120, 219),
(259, 158, 119, 218),
(260, 158, 120, 219),
(261, 159, 121, 220),
(262, 159, 122, 222),
(263, 160, 121, 221),
(264, 160, 122, 222),
(265, 161, 123, 223),
(266, 161, 124, 225),
(267, 162, 123, 224),
(268, 162, 124, 225),
(269, 163, 125, 226),
(270, 163, 126, 228),
(271, 164, 125, 227),
(272, 164, 126, 228),
(273, 165, 127, 229),
(274, 165, 128, 231),
(275, 166, 127, 230),
(276, 166, 128, 231),
(277, 167, 129, 232),
(278, 167, 130, 234),
(279, 168, 129, 233),
(280, 168, 130, 234),
(281, 169, 131, 235),
(282, 169, 132, 237),
(283, 170, 131, 236),
(284, 170, 132, 237),
(285, 171, 133, 238),
(286, 171, 134, 240),
(287, 172, 133, 239),
(288, 172, 134, 240),
(289, 173, 135, 241),
(290, 173, 136, 243),
(291, 174, 135, 242),
(292, 174, 136, 243),
(293, 175, 137, 244),
(294, 175, 138, 246),
(295, 176, 137, 245),
(296, 176, 138, 246),
(297, 177, 139, 247),
(298, 177, 140, 249),
(299, 178, 139, 248),
(300, 178, 140, 249),
(301, 179, 141, 250),
(302, 179, 142, 252),
(303, 180, 141, 251),
(304, 180, 142, 252),
(305, 181, 143, 253),
(306, 181, 144, 255),
(307, 182, 143, 254),
(308, 182, 144, 255),
(309, 183, 145, 256),
(310, 183, 146, 258),
(311, 184, 145, 257),
(312, 184, 146, 258),
(313, 185, 147, 259),
(314, 185, 148, 261),
(315, 186, 147, 260),
(316, 186, 148, 261),
(317, 187, 149, 262),
(318, 187, 150, 264),
(319, 188, 149, 263),
(320, 188, 150, 264),
(321, 189, 151, 265),
(322, 189, 152, 267),
(323, 190, 151, 266),
(324, 190, 152, 267),
(325, 191, 153, 268),
(326, 191, 154, 270),
(327, 192, 153, 269),
(328, 192, 154, 270),
(329, 193, 155, 271),
(330, 193, 156, 273),
(331, 194, 155, 272),
(332, 194, 156, 273),
(333, 195, 157, 274),
(334, 195, 158, 276),
(335, 196, 157, 275),
(336, 196, 158, 276),
(337, 197, 159, 277),
(338, 197, 160, 279),
(339, 198, 159, 278),
(340, 198, 160, 279),
(341, 199, 161, 280),
(342, 199, 162, 282),
(343, 200, 161, 281),
(344, 200, 162, 282),
(345, 201, 163, 283),
(346, 201, 164, 285),
(347, 202, 163, 284),
(348, 202, 164, 285),
(349, 203, 165, 286),
(350, 203, 166, 288),
(351, 204, 165, 287),
(352, 204, 166, 288),
(353, 205, 167, 289),
(354, 205, 168, 291),
(355, 206, 167, 290),
(356, 206, 168, 291),
(357, 207, 169, 292),
(358, 207, 170, 294),
(359, 208, 169, 293),
(360, 208, 170, 294),
(361, 209, 171, 295),
(362, 209, 172, 297),
(363, 210, 171, 296),
(364, 210, 172, 297),
(365, 211, 173, 298),
(366, 211, 174, 300),
(367, 212, 173, 299),
(368, 212, 174, 300),
(369, 213, 175, 301),
(370, 213, 176, 303),
(371, 214, 175, 302),
(372, 214, 176, 303),
(373, 215, 177, 304),
(374, 215, 178, 306),
(375, 216, 177, 305),
(376, 216, 178, 306),
(377, 217, 179, 307),
(378, 217, 180, 309),
(379, 218, 179, 308),
(380, 218, 180, 309),
(381, 219, 181, 310),
(382, 219, 182, 312),
(383, 220, 181, 311),
(384, 220, 182, 312),
(385, 221, 183, 313),
(386, 221, 184, 315),
(387, 222, 183, 314),
(388, 222, 184, 315),
(389, 223, 185, 316),
(390, 223, 186, 318),
(391, 224, 185, 317),
(392, 224, 186, 318),
(393, 225, 187, 319),
(394, 225, 188, 321),
(395, 226, 187, 320),
(396, 226, 188, 321),
(397, 227, 189, 322),
(398, 227, 190, 324),
(399, 228, 189, 323),
(400, 228, 190, 324),
(401, 229, 191, 325),
(402, 229, 192, 327),
(403, 230, 191, 326),
(404, 230, 192, 327),
(405, 231, 193, 328),
(406, 231, 194, 330),
(407, 232, 193, 329),
(408, 232, 194, 330),
(409, 233, 195, 331),
(410, 233, 196, 333),
(411, 234, 195, 332),
(412, 234, 196, 333),
(413, 235, 197, 334),
(414, 235, 198, 336),
(415, 236, 197, 335),
(416, 236, 198, 336),
(417, 237, 199, 337),
(418, 237, 200, 339),
(419, 238, 199, 338),
(420, 238, 200, 339),
(421, 239, 201, 340),
(422, 239, 202, 342),
(423, 240, 201, 341),
(424, 240, 202, 342),
(425, 241, 203, 343),
(426, 241, 204, 345),
(427, 242, 203, 344),
(428, 242, 204, 345),
(429, 243, 205, 346),
(430, 243, 206, 348),
(431, 244, 205, 347),
(432, 244, 206, 348),
(433, 245, 207, 349),
(434, 245, 208, 351),
(435, 246, 207, 350),
(436, 246, 208, 351),
(437, 247, 209, 352),
(438, 247, 210, 354),
(439, 248, 209, 353),
(440, 248, 210, 354),
(441, 249, 211, 355),
(442, 249, 212, 357),
(443, 250, 211, 356),
(444, 250, 212, 357),
(445, 251, 213, 358),
(446, 251, 214, 360),
(447, 252, 213, 359),
(448, 252, 214, 360),
(449, 253, 215, 361),
(450, 253, 216, 363),
(451, 254, 215, 362),
(452, 254, 216, 363),
(453, 255, 217, 364),
(454, 255, 218, 366),
(455, 256, 217, 365),
(456, 256, 218, 366),
(457, 257, 219, 367),
(458, 257, 220, 369),
(459, 258, 219, 368),
(460, 258, 220, 369),
(461, 259, 221, 370),
(462, 259, 222, 372),
(463, 260, 221, 371),
(464, 260, 222, 372),
(465, 261, 223, 373),
(466, 261, 224, 375),
(467, 262, 223, 374),
(468, 262, 224, 375),
(469, 263, 225, 376),
(470, 263, 226, 378),
(471, 264, 225, 377),
(472, 264, 226, 378),
(473, 265, 227, 379),
(474, 265, 228, 381),
(475, 266, 227, 380),
(476, 266, 228, 381),
(477, 267, 229, 382),
(478, 267, 230, 384),
(479, 268, 229, 383),
(480, 268, 230, 384),
(481, 269, 231, 385),
(482, 269, 232, 387),
(483, 270, 231, 386),
(484, 270, 232, 387),
(485, 271, 233, 388),
(486, 271, 234, 390),
(487, 272, 233, 389),
(488, 272, 234, 390),
(489, 273, 235, 391),
(490, 273, 236, 393),
(491, 274, 235, 392),
(492, 274, 236, 393),
(493, 275, 237, 394),
(494, 275, 238, 396),
(495, 276, 237, 395),
(496, 276, 238, 396),
(497, 277, 239, 397),
(498, 277, 240, 399),
(499, 278, 239, 398),
(500, 278, 240, 399),
(501, 279, 241, 400),
(502, 279, 242, 402),
(503, 280, 241, 401),
(504, 280, 242, 402),
(505, 281, 243, 403),
(506, 281, 244, 405),
(507, 282, 243, 404),
(508, 282, 244, 405),
(509, 283, 245, 406),
(510, 283, 246, 408),
(511, 284, 245, 407),
(512, 284, 246, 408),
(513, 285, 247, 409),
(514, 285, 248, 411),
(515, 286, 247, 410),
(516, 286, 248, 411),
(517, 287, 249, 412),
(518, 287, 250, 414),
(519, 288, 249, 413),
(520, 288, 250, 414),
(521, 289, 251, 415),
(522, 289, 252, 417),
(523, 290, 251, 416),
(524, 290, 252, 417),
(525, 291, 253, 418),
(526, 291, 254, 420),
(527, 292, 253, 419),
(528, 292, 254, 420),
(529, 293, 255, 421),
(530, 293, 256, 423),
(531, 294, 255, 422),
(532, 294, 256, 423),
(533, 295, 257, 424),
(534, 295, 258, 426),
(535, 296, 257, 425),
(536, 296, 258, 426),
(537, 297, 259, 427),
(538, 297, 260, 429),
(539, 298, 259, 428),
(540, 298, 260, 429),
(541, 299, 261, 430),
(542, 299, 262, 432),
(543, 300, 261, 431),
(544, 300, 262, 432),
(545, 301, 263, 433),
(546, 301, 264, 435),
(547, 302, 263, 434),
(548, 302, 264, 435),
(549, 303, 265, 436),
(550, 303, 266, 438),
(551, 304, 265, 437),
(552, 304, 266, 438),
(553, 305, 267, 439),
(554, 305, 268, 441),
(555, 306, 267, 440),
(556, 306, 268, 441),
(557, 307, 269, 442),
(558, 307, 270, 444),
(559, 308, 269, 443),
(560, 308, 270, 444),
(561, 309, 271, 445),
(562, 309, 272, 447),
(563, 310, 271, 446),
(564, 310, 272, 447),
(565, 311, 273, 448),
(566, 311, 274, 450),
(567, 312, 273, 449),
(568, 312, 274, 450),
(569, 313, 275, 451),
(570, 313, 276, 453),
(571, 314, 275, 452),
(572, 314, 276, 453),
(573, 315, 277, 454),
(574, 315, 278, 456),
(575, 316, 277, 455),
(576, 316, 278, 456),
(577, 317, 279, 457),
(578, 317, 280, 459),
(579, 318, 279, 458),
(580, 318, 280, 459),
(581, 319, 281, 460),
(582, 319, 282, 462),
(583, 320, 281, 461),
(584, 320, 282, 462),
(585, 321, 283, 463),
(586, 321, 284, 465),
(587, 322, 283, 464),
(588, 322, 284, 465),
(589, 323, 285, 466),
(590, 323, 286, 468),
(591, 324, 285, 467),
(592, 324, 286, 468),
(593, 325, 287, 469),
(594, 325, 288, 471),
(595, 326, 287, 470),
(596, 326, 288, 471),
(597, 327, 289, 472),
(598, 327, 290, 474),
(599, 328, 289, 473),
(600, 328, 290, 474),
(601, 329, 291, 475),
(602, 329, 292, 477),
(603, 330, 291, 476),
(604, 330, 292, 477),
(605, 331, 293, 478),
(606, 331, 294, 480),
(607, 332, 293, 479),
(608, 332, 294, 480),
(609, 333, 295, 481),
(610, 333, 296, 483),
(611, 334, 295, 482),
(612, 334, 296, 483),
(613, 335, 297, 484),
(614, 335, 298, 486),
(615, 336, 297, 485),
(616, 336, 298, 486),
(617, 337, 299, 487),
(618, 337, 300, 489),
(619, 338, 299, 488),
(620, 338, 300, 489),
(621, 339, 301, 490),
(622, 339, 302, 492),
(623, 340, 301, 491),
(624, 340, 302, 492),
(625, 341, 303, 493),
(626, 341, 304, 495),
(627, 342, 303, 494),
(628, 342, 304, 495),
(629, 343, 305, 496),
(630, 343, 306, 498),
(631, 344, 305, 497),
(632, 344, 306, 498),
(633, 345, 307, 499),
(634, 345, 308, 501),
(635, 346, 307, 500),
(636, 346, 308, 501),
(637, 347, 309, 502),
(638, 347, 310, 504),
(639, 348, 309, 503),
(640, 348, 310, 504),
(641, 349, 311, 505),
(642, 349, 312, 507),
(643, 350, 311, 506),
(644, 350, 312, 507),
(645, 351, 313, 508),
(646, 351, 314, 510),
(647, 352, 313, 509),
(648, 352, 314, 510),
(649, 353, 315, 511),
(650, 353, 316, 513),
(651, 354, 315, 512),
(652, 354, 316, 513),
(653, 355, 317, 514),
(654, 355, 318, 516),
(655, 356, 317, 515),
(656, 356, 318, 516),
(657, 357, 319, 517),
(658, 357, 320, 519),
(659, 358, 319, 518),
(660, 358, 320, 519),
(661, 359, 321, 520),
(662, 359, 322, 522),
(663, 360, 321, 521),
(664, 360, 322, 522),
(665, 361, 323, 523),
(666, 361, 324, 525),
(667, 362, 323, 524),
(668, 362, 324, 525),
(669, 363, 325, 526),
(670, 363, 326, 528),
(671, 364, 325, 527),
(672, 364, 326, 528),
(673, 365, 327, 529),
(674, 365, 328, 531),
(675, 366, 327, 530),
(676, 366, 328, 531),
(677, 367, 329, 532),
(678, 367, 330, 534),
(679, 368, 329, 533),
(680, 368, 330, 534),
(681, 369, 331, 535),
(682, 369, 332, 537),
(683, 370, 331, 536),
(684, 370, 332, 537),
(685, 371, 333, 538),
(686, 371, 334, 540),
(687, 372, 333, 539),
(688, 372, 334, 540),
(689, 373, 335, 541),
(690, 373, 336, 543),
(691, 374, 335, 542),
(692, 374, 336, 543),
(693, 375, 337, 544),
(694, 375, 338, 546),
(695, 376, 337, 545),
(696, 376, 338, 546),
(697, 377, 339, 547),
(698, 377, 340, 549),
(699, 378, 339, 548),
(700, 378, 340, 549),
(701, 379, 341, 550),
(702, 379, 342, 552),
(703, 380, 341, 551),
(704, 380, 342, 552),
(705, 381, 343, 553),
(706, 381, 344, 555),
(707, 382, 343, 554),
(708, 382, 344, 555),
(709, 383, 345, 556),
(710, 383, 346, 558),
(711, 384, 345, 557),
(712, 384, 346, 558),
(713, 385, 347, 559),
(714, 385, 348, 561),
(715, 386, 347, 560),
(716, 386, 348, 561),
(717, 387, 349, 562),
(718, 387, 350, 564),
(719, 388, 349, 563),
(720, 388, 350, 564),
(721, 389, 351, 565),
(722, 389, 352, 567),
(723, 390, 351, 566),
(724, 390, 352, 567),
(725, 391, 353, 568),
(726, 391, 354, 570),
(727, 392, 353, 569),
(728, 392, 354, 570),
(729, 393, 355, 571),
(730, 393, 356, 573),
(731, 394, 355, 572),
(732, 394, 356, 573),
(733, 395, 357, 574),
(734, 395, 358, 576),
(735, 396, 357, 575),
(736, 396, 358, 576),
(737, 397, 359, 577),
(738, 397, 360, 579),
(739, 398, 359, 578),
(740, 398, 360, 579),
(741, 399, 361, 580),
(742, 399, 362, 582),
(743, 400, 361, 581),
(744, 400, 362, 582),
(745, 401, 363, 583),
(746, 401, 364, 585),
(747, 402, 363, 584),
(748, 402, 364, 585),
(749, 403, 365, 586),
(750, 403, 366, 588),
(751, 404, 365, 587),
(752, 404, 366, 588),
(753, 405, 367, 589),
(754, 405, 368, 591),
(755, 406, 367, 590),
(756, 406, 368, 591),
(757, 407, 369, 592),
(758, 407, 370, 594),
(759, 408, 369, 593),
(760, 408, 370, 594),
(761, 409, 371, 595),
(762, 409, 372, 597),
(763, 410, 371, 596),
(764, 410, 372, 597),
(765, 411, 373, 598),
(766, 411, 374, 600),
(767, 412, 373, 599),
(768, 412, 374, 600),
(769, 413, 375, 601),
(770, 413, 376, 603),
(771, 414, 375, 602),
(772, 414, 376, 603),
(773, 415, 377, 604),
(774, 415, 378, 606),
(775, 416, 377, 605),
(776, 416, 378, 606),
(777, 417, 379, 607),
(778, 417, 380, 609),
(779, 418, 379, 608),
(780, 418, 380, 609),
(781, 419, 381, 610),
(782, 419, 382, 612),
(783, 420, 381, 611),
(784, 420, 382, 612),
(785, 421, 383, 613),
(786, 421, 384, 615),
(787, 422, 383, 614),
(788, 422, 384, 615),
(789, 423, 385, 616),
(790, 423, 386, 618),
(791, 424, 385, 617),
(792, 424, 386, 618),
(793, 425, 387, 619),
(794, 425, 388, 621),
(795, 426, 387, 620),
(796, 426, 388, 621),
(797, 427, 389, 622),
(798, 427, 390, 624),
(799, 428, 389, 623),
(800, 428, 390, 624),
(801, 429, 391, 625),
(802, 429, 392, 627),
(803, 430, 391, 626),
(804, 430, 392, 627),
(805, 431, 393, 628),
(806, 431, 394, 630),
(807, 432, 393, 629),
(808, 432, 394, 630),
(809, 433, 395, 631),
(810, 433, 396, 633),
(811, 434, 395, 632),
(812, 434, 396, 633),
(813, 435, 397, 634),
(814, 435, 398, 636),
(815, 436, 397, 635),
(816, 436, 398, 636),
(817, 437, 399, 637),
(818, 437, 400, 639),
(819, 438, 399, 638),
(820, 438, 400, 639),
(821, 439, 401, 640),
(822, 439, 402, 642),
(823, 440, 401, 641),
(824, 440, 402, 642);

-- --------------------------------------------------------

--
-- Table structure for table `su_quotations`
--

CREATE TABLE `su_quotations` (
  `id` int(10) UNSIGNED NOT NULL,
  `quotation_code` varchar(50) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `prepared_by` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('draft','sent','accepted','rejected','expired','converted') NOT NULL DEFAULT 'draft',
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) NOT NULL DEFAULT 'KES',
  `valid_until` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `converted_order_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_first_name` varchar(100) DEFAULT NULL,
  `customer_last_name` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(30) DEFAULT NULL,
  `customer_email` varchar(190) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_quotation_items`
--

CREATE TABLE `su_quotation_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `quotation_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `total` decimal(12,2) GENERATED ALWAYS AS (`unit_price` * `quantity`) STORED,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_referral_codes`
--

CREATE TABLE `su_referral_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(32) NOT NULL,
  `reward_type` enum('wallet','loyalty_points') NOT NULL DEFAULT 'loyalty_points',
  `reward_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `referred_reward_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `clicks` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_referral_events`
--

CREATE TABLE `su_referral_events` (
  `id` int(10) UNSIGNED NOT NULL,
  `referral_code_id` int(10) UNSIGNED NOT NULL,
  `referrer_user_id` int(10) UNSIGNED NOT NULL,
  `referred_user_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','qualified','rewarded','cancelled') NOT NULL DEFAULT 'pending',
  `reward_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `rewarded_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_roles`
--

CREATE TABLE `su_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_roles`
--

INSERT INTO `su_roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', 'super_admin', 'System level administrator with full access to all modules, settings and logs', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(2, 'Administrator', 'admin', 'Day to day admin responsible for managing products, orders, payments and content', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(3, 'Customer', 'customer', 'Buyer who can browse, order products, submit reviews and earn loyalty points', '2026-09-17 05:42:36', '2026-09-17 05:42:36'),
(4, 'Manager', 'manager', 'Staff member who handles quotations, orders and day to day customer facing tasks', '2026-09-17 05:42:36', '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_role_permissions`
--

CREATE TABLE `su_role_permissions` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_role_permissions`
--

INSERT INTO `su_role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(2, 2),
(2, 3),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(4, 1),
(4, 7),
(4, 12),
(4, 13),
(4, 14),
(4, 21),
(4, 33),
(4, 34);

-- --------------------------------------------------------

--
-- Table structure for table `su_sessions`
--

CREATE TABLE `su_sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','expired','terminated') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_settings`
--

CREATE TABLE `su_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_settings`
--

INSERT INTO `su_settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES
(1, 'company_name', 'Your Company Name', 'Registered company name', '2026-09-17 05:42:36'),
(2, 'site_name', 'Trinity Mabati', 'Display name shown across the site', '2026-10-13 05:23:37'),
(3, 'contact_email', 'info@trinitymabati.com', 'Public support email shown in the header, footer and contact page', '2026-10-13 12:39:41'),
(4, 'contact_phone', '0740 550 105', 'Public phone number shown in the header, footer and contact page', '2026-10-13 12:39:41'),
(5, 'contact_whatsapp', '0740 550 105', 'WhatsApp number in international format without a plus sign, used for wa.me links', '2026-10-13 12:39:41'),
(6, 'contact_address', 'Nairobi, Kenya', 'Physical location shown in the footer and contact page', '2026-09-17 05:42:36'),
(7, 'social_facebook', 'https://facebook.com', 'Facebook page URL, leave blank to hide the icon', '2026-10-13 12:39:41'),
(8, 'social_instagram', 'https://instagramcom', 'Instagram profile URL, leave blank to hide the icon', '2026-10-13 12:42:37'),
(9, 'social_twitter', 'https://x.com', 'X (Twitter) profile URL, leave blank to hide the icon', '2026-10-13 12:42:37'),
(10, 'social_tiktok', '', 'TikTok profile URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(11, 'social_youtube', 'https://youtube.com', 'YouTube channel URL, leave blank to hide the icon', '2026-10-13 12:42:37'),
(12, 'social_linkedin', '', 'LinkedIn page URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(13, 'whatsapp_default_message', 'Hello, I would like to know more about your products.', 'Pre-filled message for the floating WhatsApp button', '2026-09-17 05:42:36'),
(14, 'login_2fa_method', 'none', 'Customer login verification method: none, email or sms', '2026-09-17 05:42:36'),
(15, 'visitors_log_last_viewed_at', '2026-09-17 11:18:54', NULL, '2026-09-17 11:18:54'),
(16, 'primary_color', '#aa1f25', NULL, '2026-10-14 08:49:56'),
(17, 'secondary_color', '#211e1f', NULL, '2026-10-14 08:49:56'),
(18, 'tertiary_color', '#2d3436', NULL, '2026-10-14 08:51:49'),
(19, 'logo_main', 'uploads/branding/logo_main-20261014115840-169909.png', NULL, '2026-10-14 08:58:40'),
(20, 'site_icon', 'uploads/branding/site_icon-20261014114841-05b109.png', NULL, '2026-10-14 08:48:41'),
(21, 'apple_touch_icon', 'uploads/branding/apple_touch_icon-20261014115840-5901d1.png', NULL, '2026-10-14 08:58:40'),
(22, 'logo_white', 'uploads/branding/logo_white-20261014165307-a25c35.png', NULL, '2026-10-14 13:53:07'),
(23, 'branch_nairobi_name', 'Nairobi Outlet', 'Trinity Mabati Factory outlet contact details', '2026-10-13 12:56:11'),
(24, 'branch_nairobi_address', 'Enterprise Road, B. Binico Enterprises, Nairobi, Kenya.', 'Trinity Mabati Factory outlet contact details', '2026-10-13 12:56:11'),
(25, 'branch_nairobi_phone', '0740 550 105', 'Trinity Mabati Factory outlet contact details', '2026-10-13 15:18:06'),
(26, 'branch_migori_name', 'Migori Outlet', 'Trinity Mabati Factory outlet contact details', '2026-10-13 12:56:11'),
(27, 'branch_migori_address', 'Kimaiga, next to Dolion Hotel', 'Trinity Mabati Factory outlet contact details', '2026-10-13 12:56:11'),
(28, 'branch_migori_phone', '0796 593 842', 'Trinity Mabati Factory outlet contact details', '2026-10-13 15:18:06'),
(29, 'logo_dark', 'uploads/branding/logo_dark-20261014115840-c28613.png', NULL, '2026-10-14 08:58:40');

-- --------------------------------------------------------

--
-- Table structure for table `su_shipping_expenses`
--

CREATE TABLE `su_shipping_expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_shipping_settings`
--

CREATE TABLE `su_shipping_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `base_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `weight_threshold` decimal(10,2) NOT NULL DEFAULT 5.00,
  `weight_rate` decimal(10,2) NOT NULL DEFAULT 10.00,
  `volume_divisor` int(11) NOT NULL DEFAULT 5000,
  `volume_multiplier` decimal(10,2) NOT NULL DEFAULT 0.50,
  `distance_rate` decimal(10,2) NOT NULL DEFAULT 10.00,
  `distance_unit` varchar(20) DEFAULT 'km',
  `distance_note` text DEFAULT NULL,
  `free_shipping_threshold` decimal(10,2) DEFAULT NULL,
  `tracking_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_shipping_settings`
--

INSERT INTO `su_shipping_settings` (`id`, `base_rate`, `weight_threshold`, `weight_rate`, `volume_divisor`, `volume_multiplier`, `distance_rate`, `distance_unit`, `distance_note`, `free_shipping_threshold`, `tracking_enabled`, `created_at`) VALUES
(1, 150.00, 5.00, 10.00, 5000, 0.50, 10.00, 'km', NULL, NULL, 1, '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_support_tickets`
--

CREATE TABLE `su_support_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `department` enum('support','billing','marketing','technical','logistics') NOT NULL DEFAULT 'support',
  `urgency` enum('low','medium','high','critical') NOT NULL DEFAULT 'low',
  `status` enum('open','in_progress','on_hold','resolved','closed') NOT NULL DEFAULT 'open',
  `assigned_admin_id` int(10) UNSIGNED DEFAULT NULL,
  `last_reply_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_support_ticket_replies`
--

CREATE TABLE `su_support_ticket_replies` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `is_read_by_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_read_by_user` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_system_logs`
--

CREATE TABLE `su_system_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_system_messages`
--

CREATE TABLE `su_system_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED DEFAULT NULL,
  `recipient_id` int(10) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `related_url` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_system_messages`
--

INSERT INTO `su_system_messages` (`id`, `sender_id`, `recipient_id`, `subject`, `message`, `related_url`, `is_read`, `created_at`) VALUES
(1, NULL, NULL, 'Contact Form: Dana Katisya', 'Name:  Dana Katisya\nEmail: katisyadana@gmail.com\n\nTesting testing 123\n\nView full message: http://localhost/trinitymabati/manage/contact/1', NULL, 0, '2026-10-14 13:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `su_tax_settings`
--

CREATE TABLE `su_tax_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `tax_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 16.00,
  `tax_label` varchar(100) NOT NULL DEFAULT 'VAT',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_tax_settings`
--

INSERT INTO `su_tax_settings` (`id`, `tax_enabled`, `tax_rate`, `tax_label`, `updated_at`) VALUES
(1, 1, 16.00, 'VAT', '2026-09-17 05:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `su_towns`
--

CREATE TABLE `su_towns` (
  `id` int(10) UNSIGNED NOT NULL,
  `county_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_towns`
--

INSERT INTO `su_towns` (`id`, `county_id`, `name`, `created_at`) VALUES
(1, 1, 'Mombasa Town', '2026-09-17 05:42:36'),
(2, 2, 'Kwale Town', '2026-09-17 05:42:36'),
(3, 3, 'Kilifi Town', '2026-09-17 05:42:36'),
(4, 4, 'Hola', '2026-09-17 05:42:36'),
(5, 5, 'Lamu Town', '2026-09-17 05:42:36'),
(6, 6, 'Voi', '2026-09-17 05:42:36'),
(7, 7, 'Garissa Town', '2026-09-17 05:42:36'),
(8, 8, 'Wajir Town', '2026-09-17 05:42:36'),
(9, 9, 'Mandera Town', '2026-09-17 05:42:36'),
(10, 10, 'Marsabit Town', '2026-09-17 05:42:36'),
(11, 11, 'Isiolo Town', '2026-09-17 05:42:36'),
(12, 12, 'Meru Town', '2026-09-17 05:42:36'),
(13, 13, 'Chuka', '2026-09-17 05:42:36'),
(14, 14, 'Embu Town', '2026-09-17 05:42:36'),
(15, 15, 'Kitui Town', '2026-09-17 05:42:36'),
(16, 16, 'Machakos Town', '2026-09-17 05:42:36'),
(17, 17, 'Wote', '2026-09-17 05:42:36'),
(18, 18, 'Ol Kalou', '2026-09-17 05:42:36'),
(19, 19, 'Nyeri Town', '2026-09-17 05:42:36'),
(20, 20, 'Kerugoya', '2026-09-17 05:42:36'),
(21, 21, 'Murang\'a Town', '2026-09-17 05:42:36'),
(22, 22, 'Kiambu Town', '2026-09-17 05:42:36'),
(23, 23, 'Lodwar', '2026-09-17 05:42:36'),
(24, 24, 'Kapenguria', '2026-09-17 05:42:36'),
(25, 25, 'Maralal', '2026-09-17 05:42:36'),
(26, 26, 'Kitale', '2026-09-17 05:42:36'),
(27, 27, 'Eldoret', '2026-09-17 05:42:36'),
(28, 28, 'Iten', '2026-09-17 05:42:36'),
(29, 29, 'Kapsabet', '2026-09-17 05:42:36'),
(30, 30, 'Kabarnet', '2026-09-17 05:42:36'),
(31, 31, 'Nanyuki', '2026-09-17 05:42:36'),
(32, 32, 'Nakuru Town', '2026-09-17 05:42:36'),
(33, 33, 'Narok Town', '2026-09-17 05:42:36'),
(34, 34, 'Kajiado Town', '2026-09-17 05:42:36'),
(35, 35, 'Kericho Town', '2026-09-17 05:42:36'),
(36, 36, 'Bomet Town', '2026-09-17 05:42:36'),
(37, 37, 'Kakamega Town', '2026-09-17 05:42:36'),
(38, 38, 'Mbale', '2026-09-17 05:42:36'),
(39, 39, 'Bungoma Town', '2026-09-17 05:42:36'),
(40, 40, 'Busia Town', '2026-09-17 05:42:36'),
(41, 41, 'Siaya Town', '2026-09-17 05:42:36'),
(42, 42, 'Kisumu Town', '2026-09-17 05:42:36'),
(43, 43, 'Homa Bay Town', '2026-09-17 05:42:36'),
(44, 44, 'Migori Town', '2026-09-17 05:42:36'),
(45, 45, 'Kisii Town', '2026-09-17 05:42:36'),
(46, 46, 'Nyamira Town', '2026-09-17 05:42:36'),
(47, 47, 'Nairobi CBD', '2026-09-17 05:42:36'),
(48, 47, 'CBD', '2026-09-18 08:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `su_two_factor_authentications`
--

CREATE TABLE `su_two_factor_authentications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `method` enum('email','sms','app') NOT NULL DEFAULT 'email',
  `secret_key` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_users`
--

CREATE TABLE `su_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','suspended','pending') NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `login_ip` varchar(45) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `password_reset_code` varchar(6) DEFAULT NULL,
  `password_reset_expires_at` datetime DEFAULT NULL,
  `twofa_code` varchar(6) DEFAULT NULL,
  `twofa_expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_users`
--

INSERT INTO `su_users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `email_verified_at`, `status`, `last_login_at`, `last_activity_at`, `login_ip`, `remember_token`, `password_reset_code`, `password_reset_expires_at`, `twofa_code`, `twofa_expires_at`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Hope', 'Sifuna', 'hopesifuna@gmail.com', NULL, '$2y$12$PfCEFuaggxmX0hTYaw3EO.WbIQezKIoqbToSrClHDzxft.qBcVKzO', '2026-09-17 07:13:16', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-09-17 07:13:16', '2026-09-17 07:13:16', NULL),
(2, 'Sifuna', 'Godfrey', 'sifuna.godfreyw@gmail.com', NULL, '$2y$12$eN264V6PbgOKjMsdiLzSu.BIblabGfKMKrR6c/nPRr1RRMvbtWnp6', '2026-09-17 07:13:16', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-09-17 07:13:16', '2026-09-17 07:13:16', NULL),
(3, 'Finamax', 'Ltd', 'info@finamax.co.ke', NULL, '$2y$12$C2AyyxLrhBAzI6/Coms.pOzJoMmzFOE8j2E4vxWSV49elwWHaRSjK', NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-09-18 02:56:34', '2026-09-18 02:56:34', NULL),
(4, 'Dana', 'Katisya', 'katisyadana@gmail.com', '+254758926969', '$2y$12$G4YKKkjb80xEfdg2ELdZfei2hHjC3H9sO.r9cJLj.w.E93tUORJlu', NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-09-18 11:40:10', '2026-09-18 11:40:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `su_user_devices`
--

CREATE TABLE `su_user_devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `platform` enum('android','ios','web') NOT NULL DEFAULT 'web',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_user_messages`
--

CREATE TABLE `su_user_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED DEFAULT NULL,
  `receiver_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `related_type` varchar(100) DEFAULT NULL,
  `related_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('sent','delivered','read','archived') NOT NULL DEFAULT 'sent',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_user_profiles`
--

CREATE TABLE `su_user_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `county_id` int(10) UNSIGNED DEFAULT NULL,
  `town_id` int(10) UNSIGNED DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_user_profiles`
--

INSERT INTO `su_user_profiles` (`id`, `user_id`, `gender`, `date_of_birth`, `address`, `country_id`, `county_id`, `town_id`, `profile_photo`, `bio`, `social_links`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, '2026-09-18 14:42:33', '2026-09-18 14:42:33');

-- --------------------------------------------------------

--
-- Table structure for table `su_user_roles`
--

CREATE TABLE `su_user_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_user_roles`
--

INSERT INTO `su_user_roles` (`id`, `user_id`, `role_id`, `created_at`) VALUES
(1, 1, 3, '2026-09-17 07:13:16'),
(2, 2, 1, '2026-09-17 07:13:16'),
(3, 4, 3, '2026-09-18 11:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `su_visitors_logs`
--

CREATE TABLE `su_visitors_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `visited_url` text NOT NULL,
  `referrer_url` text DEFAULT NULL,
  `session_id` varchar(128) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `visit_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `su_visitors_logs`
--

INSERT INTO `su_visitors_logs` (`id`, `ip_address`, `user_agent`, `visited_url`, `referrer_url`, `session_id`, `user_id`, `country`, `visit_time`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 09:37:14'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 09:38:42'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 09:39:01'),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/brands', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 09:46:03'),
(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/categories', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 09:46:07'),
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/brands', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 09:46:10'),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/about', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 09:46:14'),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/about', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:04:45'),
(9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/swap-to-own', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:05:03'),
(10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:05:16'),
(11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/track-order', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:05:23'),
(12, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:06:42'),
(13, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:06:55'),
(14, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/privacy-policy', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:07:02'),
(15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/contact', 'http://localhost/finamax/privacy-policy', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:07:06'),
(16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/contact', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:07:18'),
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/swap-to-own', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:07:42'),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/swap-to-own', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:08:04'),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:08:06'),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:08:17'),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/login', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:08:20'),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/swap-to-own', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:08:26'),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/swap-to-own', 'http://localhost/finamax/', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:13:30'),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/swap-to-own', 'FTH5lYHeoH0ZrbKkkAn91Yz4baBaW54aBr6wvw6V', NULL, NULL, '2026-09-17 10:13:32'),
(25, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/login', 'LHOjYKEsoFZMNYBav1fCgG1gaIJ4wRH9muGVZSko', 1, NULL, '2026-09-17 10:13:40'),
(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/account/dashboard', 'LHOjYKEsoFZMNYBav1fCgG1gaIJ4wRH9muGVZSko', 1, NULL, '2026-09-17 10:15:05'),
(27, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/account/orders', 'LHOjYKEsoFZMNYBav1fCgG1gaIJ4wRH9muGVZSko', 1, NULL, '2026-09-17 10:15:10'),
(28, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/wishlist', 'LHOjYKEsoFZMNYBav1fCgG1gaIJ4wRH9muGVZSko', 1, NULL, '2026-09-17 10:15:12'),
(29, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', NULL, 'LHOjYKEsoFZMNYBav1fCgG1gaIJ4wRH9muGVZSko', 1, NULL, '2026-09-17 10:17:04'),
(30, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/dashboard', 'hUVueqH6wxDYluXdDinuOCuZpiSB4rWzkE9Z5PV9', NULL, NULL, '2026-09-17 10:17:09'),
(31, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/manage/tickets', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:34:09'),
(32, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:34:18'),
(33, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:34:22'),
(34, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:34:23'),
(35, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/contact', 'http://localhost/finamax/about', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:34:25'),
(36, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/contact', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:34:34'),
(37, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:34:45'),
(38, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/buy-on-cash', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:35:20'),
(39, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/buy-on-cash', 'http://localhost/finamax/buy-on-cash', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:35:37'),
(40, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/buy-on-cash', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:36:03'),
(41, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/buy-on-cash', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:56:21'),
(42, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/buy-on-cash', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:56:42'),
(43, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/buy-on-cash', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:57:26'),
(44, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:57:45'),
(45, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/wishlist', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:57:49'),
(46, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:57:50'),
(47, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:57:51'),
(48, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:57:58'),
(49, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/search?q=hope', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 10:58:06'),
(50, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/search?q=hope', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:00:36'),
(51, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:02:57'),
(52, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/products', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:03:03'),
(53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:03:06'),
(54, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:03:08'),
(55, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/contact', 'http://localhost/finamax/about', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:03:10'),
(56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/contact', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:03:16'),
(57, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:05:38'),
(58, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/account/orders', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:05:42'),
(59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:05:44'),
(60, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:05:47'),
(61, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:05:49'),
(62, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:09:51'),
(63, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:09:55'),
(64, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/account/orders', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:10:01'),
(65, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:10:45'),
(66, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:10:47'),
(67, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:10:52'),
(68, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:10:54'),
(69, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:11:32'),
(70, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:11:33'),
(71, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:11:39'),
(72, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:15'),
(73, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/orders', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:17'),
(74, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:19'),
(75, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/search?q=School%20bags', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:26'),
(76, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/search?q=School%20bags', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:29'),
(77, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:30'),
(78, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/products', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:32'),
(79, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:34'),
(80, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/about', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:13:45'),
(81, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:20:01'),
(82, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:20:16'),
(83, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/orders', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:20:19'),
(84, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:20:25'),
(85, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories', 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 11:20:27'),
(86, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'IfRy71YfaUa4zKu0xaNh7I7KbxY044Nyc2KAkOpQ', 2, NULL, '2026-09-17 12:12:31'),
(87, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'xMkjBr4VglVL1NnHDYFvbrXDD71iOjNSKpFzcLDL', NULL, NULL, '2026-09-17 12:12:52'),
(88, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:25:38'),
(89, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:25:44'),
(90, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:25:46'),
(91, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:26:54'),
(92, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:27:45'),
(93, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:28:43'),
(94, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:28:53'),
(95, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/products', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:28:57'),
(96, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:28:59'),
(97, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:29:16'),
(98, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/categories', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:29:18'),
(99, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products', 'JZX6jti9SGO9DeAzE1BdTRbU8oTc78BxbS2MY4a9', 2, NULL, '2026-09-17 12:29:19'),
(100, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'Ctb4E7sbNUIMXxeT8S4Gwn5u684YGdc0irPx8TO6', NULL, NULL, '2026-09-17 13:06:57'),
(101, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', 'Ctb4E7sbNUIMXxeT8S4Gwn5u684YGdc0irPx8TO6', NULL, NULL, '2026-09-17 13:07:08'),
(102, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products', 'Ctb4E7sbNUIMXxeT8S4Gwn5u684YGdc0irPx8TO6', NULL, NULL, '2026-09-17 13:07:28'),
(103, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/', 'Ctb4E7sbNUIMXxeT8S4Gwn5u684YGdc0irPx8TO6', NULL, NULL, '2026-09-17 13:07:46'),
(104, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/categories', 'Ctb4E7sbNUIMXxeT8S4Gwn5u684YGdc0irPx8TO6', NULL, NULL, '2026-09-17 13:07:50'),
(105, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/products', 'Ctb4E7sbNUIMXxeT8S4Gwn5u684YGdc0irPx8TO6', NULL, NULL, '2026-09-17 13:07:54'),
(106, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/contact', 'http://localhost/finamax/about', 'Ctb4E7sbNUIMXxeT8S4Gwn5u684YGdc0irPx8TO6', NULL, NULL, '2026-09-17 13:08:16'),
(107, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/contact', 'http://localhost/finamax/contact', 'FZ6vSWaXspj04ZEDnqO3BHp61YBUBWggmSZXD08F', NULL, NULL, '2026-09-17 21:43:19'),
(108, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/contact', 'http://localhost/finamax/contact', '249MQiwYdTtT68S6qyTXQzX7vXbFBDt3tQQie8ai', NULL, NULL, '2026-09-18 05:24:58'),
(109, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 05:59:20'),
(110, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:02:02'),
(111, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:04:17'),
(112, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:11:00'),
(113, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/terms-conditions', 'http://localhost/finamax/', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:11:38'),
(114, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/terms-conditions', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:11:42'),
(115, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/about', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:14:52'),
(116, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/products', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:14:55'),
(117, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories', 'http://localhost/finamax/products/paper-clips-small', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:15:59'),
(118, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/search?q=4%20Tips%20to%20Reduce%20Printing%20%26%20Other%20Stationery%20Expenses', 'http://localhost/finamax/categories', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:16:54'),
(119, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/blog', NULL, '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:17:11'),
(120, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/privacy-policy', 'http://localhost/finamax/blog', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:22:11'),
(121, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/contact', 'http://localhost/finamax/privacy-policy', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:24:48'),
(122, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/contact', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:29:22'),
(123, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/products', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 06:34:21'),
(124, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 08:28:35'),
(125, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/hp-desktop-brand-new-pro-400-performance-meets-affordability', 'http://localhost/finamax/', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 08:28:53'),
(126, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products/hp-desktop-brand-new-pro-400-performance-meets-affordability', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 08:32:46'),
(127, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 08:33:08'),
(128, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 08:34:24'),
(129, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 08:37:13'),
(130, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/', '3TkThMP0X14d0SY1Al9bGRzmfEBblktCPutMolgs', 2, NULL, '2026-09-18 08:37:21'),
(131, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'G2jyX9WMS4jexsbnjVBn575zAQ6Qhse9ENbvnccT', NULL, NULL, '2026-09-18 09:23:53'),
(132, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/blog', 'http://localhost/finamax/', 'G2jyX9WMS4jexsbnjVBn575zAQ6Qhse9ENbvnccT', NULL, NULL, '2026-09-18 09:24:15'),
(133, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'nwnK8liNhhCBAgrgQkU1F78VFo3rrzER4MtSRbyK', NULL, NULL, '2026-09-18 11:38:28'),
(134, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/', 'nwnK8liNhhCBAgrgQkU1F78VFo3rrzER4MtSRbyK', NULL, NULL, '2026-09-18 11:39:01'),
(135, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/12a-toner', 'http://localhost/finamax/categories/toners-cartridges', 'nwnK8liNhhCBAgrgQkU1F78VFo3rrzER4MtSRbyK', NULL, NULL, '2026-09-18 11:39:23'),
(136, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/12a-toner', 'nwnK8liNhhCBAgrgQkU1F78VFo3rrzER4MtSRbyK', NULL, NULL, '2026-09-18 11:39:32'),
(137, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/cart', 'nwnK8liNhhCBAgrgQkU1F78VFo3rrzER4MtSRbyK', NULL, NULL, '2026-09-18 11:39:44'),
(138, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/register', 'http://localhost/finamax/login', 'nwnK8liNhhCBAgrgQkU1F78VFo3rrzER4MtSRbyK', NULL, NULL, '2026-09-18 11:39:51'),
(139, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/register', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:40:12'),
(140, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/account/dashboard', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:40:44'),
(141, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:40:48'),
(142, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/checkout', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:41:34'),
(143, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/checkout', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:47:37'),
(144, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:50:17'),
(145, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=34', 'http://localhost/finamax/checkout', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:50:33'),
(146, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'YZDPByRxA1qAew0I0KfEj9gAOdMpfhUvNmBjOxTY', NULL, NULL, '2026-09-18 11:51:53'),
(147, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'g8Vn17B08ARoVt7iNzna1MecZR1ThWMuJcFhX3rr', 4, NULL, '2026-09-18 11:54:41'),
(148, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/login', 'http://localhost/finamax/manage/payments/transactions', 'ApTL7uAleVb7yghgTxBBrRMQbleA5EhScFCza9fj', NULL, NULL, '2026-09-18 14:08:54'),
(149, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/login', 'http://localhost/finamax/login', 'ApTL7uAleVb7yghgTxBBrRMQbleA5EhScFCza9fj', NULL, NULL, '2026-09-18 14:09:08'),
(150, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/login', 'http://localhost/finamax/login', 'ApTL7uAleVb7yghgTxBBrRMQbleA5EhScFCza9fj', NULL, NULL, '2026-09-18 14:09:49'),
(151, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/manage/payments/transactions', 'ApTL7uAleVb7yghgTxBBrRMQbleA5EhScFCza9fj', NULL, NULL, '2026-09-18 14:09:51'),
(152, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', NULL, 'ApTL7uAleVb7yghgTxBBrRMQbleA5EhScFCza9fj', NULL, NULL, '2026-09-18 14:09:51'),
(153, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/checkout', '46RKG77Peh4T7PZrge8eTpJDhnGTJe475UXhi28Y', NULL, NULL, '2026-09-18 14:15:30'),
(154, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/login', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:15:41'),
(155, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:15:47'),
(156, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/payment', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:15:56'),
(157, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/payment', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:17:50'),
(158, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/checkout/payment', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:26:54'),
(159, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/cart', 'http://localhost/finamax/checkout/payment', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:27:22'),
(160, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:27:24'),
(161, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax', 'http://localhost/finamax/cart', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:27:55'),
(162, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:28:37'),
(163, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:29:01'),
(164, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/address', 'http://localhost/finamax/account/address', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:42:11'),
(165, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/address/set', 'http://localhost/finamax/account/address', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:42:14'),
(166, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/address', 'http://localhost/finamax/account/address/set', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:42:33'),
(167, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/products', 'http://localhost/finamax/account/address', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:42:39'),
(168, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/products', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:42:41'),
(169, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/products/push-pins-assorted-colors', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:42:57'),
(170, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/account/wishlist', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:43:00'),
(171, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/account/dashboard', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:43:04'),
(172, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders/1', 'http://localhost/finamax/account/orders', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:43:09'),
(173, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/account/orders/1/cancel', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:43:34'),
(174, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/account/wishlist', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:43:36'),
(175, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/account/orders/1/cancel', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:26'),
(176, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders/1', 'http://localhost/finamax/account/orders', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:29'),
(177, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/account/dashboard', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:32'),
(178, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/account/wishlist', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:34'),
(179, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/products/push-pins-assorted-colors', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:39'),
(180, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/products', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:41');
INSERT INTO `su_visitors_logs` (`id`, `ip_address`, `user_agent`, `visited_url`, `referrer_url`, `session_id`, `user_id`, `country`, `visit_time`) VALUES
(181, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/push-pins-assorted-colors', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:45'),
(182, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:44:48'),
(183, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/checkout/payment', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:51:52'),
(184, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:51:55'),
(185, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:52:02'),
(186, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:52:08'),
(187, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/cart', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:53:44'),
(188, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:53:46'),
(189, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:55:19'),
(190, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/locations?county_id=34', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:55:21'),
(191, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:55:30'),
(192, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/payment', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:55:41'),
(193, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/payment?order=NAW00111001', 'http://localhost/finamax/checkout/payment', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:55:46'),
(194, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/checkout/payment?order=NAW00111001', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:56:00'),
(195, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/account/wishlist', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:56:11'),
(196, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders/2', 'http://localhost/finamax/account/orders', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 14:56:14'),
(197, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/products', 'http://localhost/finamax/account/orders/2/cancel', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:18'),
(198, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/products', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:20'),
(199, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/products', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:21'),
(200, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout', 'http://localhost/finamax/products/paper-clips-small', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:25'),
(201, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/locations?county_id=34', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:26'),
(202, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:33'),
(203, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/payment', 'http://localhost/finamax/checkout', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:40'),
(204, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/checkout/payment?order=NAW00111002', 'http://localhost/finamax/checkout/payment', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:43'),
(205, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/checkout/payment?order=NAW00111002', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:00:58'),
(206, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/account/wishlist', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:01:03'),
(207, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders/3', 'http://localhost/finamax/account/orders', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:01:05'),
(208, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/account/orders/3', 'http://localhost/finamax/account/orders/3', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:01:09'),
(209, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders/3/invoice', 'http://localhost/finamax/account/orders/3', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:01:15'),
(210, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders/3/invoice', 'http://localhost/finamax/account/orders/3', 'XaxeZdakDWqxaxyDGOV8mbTfLLPaLw9bZGrcO5fy', 4, NULL, '2026-09-18 15:03:02'),
(211, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/account/orders/3', 'OuSFEbwpbabpp3vGoHwuGDCYUIjdDkFvPvpfiCXE', NULL, NULL, '2026-09-18 15:03:46'),
(212, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/checkout/payment', 'OuSFEbwpbabpp3vGoHwuGDCYUIjdDkFvPvpfiCXE', NULL, NULL, '2026-09-18 15:03:59'),
(213, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'OuSFEbwpbabpp3vGoHwuGDCYUIjdDkFvPvpfiCXE', NULL, NULL, '2026-09-18 15:04:01'),
(214, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', '172nTq9aQM8aZ1XKYDTX5C2zTEhtfRgppVM6fwOT', NULL, NULL, '2026-09-19 08:35:16'),
(215, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Safari/605.1.15', 'http://localhost/finamax/login', 'http://localhost/finamax/manage/messages', 'Db3M7F29Uc1XI6TgOwUIhGGdFzidxwSpYAM3dh4t', NULL, NULL, '2026-09-19 08:35:16'),
(216, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 13:49:47'),
(217, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:02:58'),
(218, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:13:38'),
(219, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1', 'http://localhost/finamax', NULL, 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:18:29'),
(220, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:18:31'),
(221, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:18:41'),
(222, '::1', 'Mozilla/5.0 (Linux; Android 17; SM-G980F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.8010.52 Mobile Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:18:56'),
(223, '::1', 'Mozilla/5.0 (Linux; Android 17; SM-A125M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.8010.52 Mobile Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:18:57'),
(224, '::1', 'Mozilla/5.0 (Linux; Android 17; SM-A125M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.8010.52 Mobile Safari/537.36', 'http://localhost/finamax', NULL, 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:21:22'),
(225, '::1', 'Mozilla/5.0 (Linux; Android 17; SM-A125M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.8010.52 Mobile Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:21:25'),
(226, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:21:49'),
(227, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', NULL, 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:30:58'),
(228, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:31:00'),
(229, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:31:49'),
(230, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', NULL, 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:34:39'),
(231, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:34:41'),
(232, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'fmLivPZCN6kv50wtxWMMA9QMf73zC48YMkbw4OjC', NULL, NULL, '2026-09-22 14:35:07'),
(233, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:41:54'),
(234, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:43:47'),
(235, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax', 'http://localhost/finamax/', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:46:32'),
(236, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax/products', 'http://localhost/finamax/', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:46:52'),
(237, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax/products', 'http://localhost/finamax/products', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:49:59'),
(238, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax/products', 'http://localhost/finamax/products', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:51:05'),
(239, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax/products', 'http://localhost/finamax/products', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:51:53'),
(240, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/products', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:55:08'),
(241, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax/products/paper-clips-small', NULL, 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:58:50'),
(242, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 27_0) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0 Safari/605.1.15', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/products/paper-clips-small', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:58:53'),
(243, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', NULL, 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:59:19'),
(244, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', NULL, 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 14:59:19'),
(245, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', NULL, 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:03:34'),
(246, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', NULL, 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:07:58'),
(247, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/products/paper-clips-small', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:10:20'),
(248, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/hp-desktop-brand-new-pro-400-performance-meets-affordability', 'http://localhost/finamax/categories/computers-laptops', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:10:25'),
(249, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/hp-desktop-brand-new-pro-400-performance-meets-affordability', 'http://localhost/finamax/categories/computers-laptops', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:13:07'),
(250, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/hp-desktop-brand-new-pro-400-performance-meets-affordability', 'http://localhost/finamax/categories/computers-laptops', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:14:24'),
(251, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/a4-counter-book-4-quire', 'http://localhost/finamax/products/hp-desktop-brand-new-pro-400-performance-meets-affordability', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:14:58'),
(252, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/a4-counter-book-4-quire', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:16:07'),
(253, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/a4-counter-book-4-quire', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:16:12'),
(254, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'CHj7Ydq5h5gwpCokv18KgrCjImVUJuvPTMd7Wuzd', 2, NULL, '2026-09-22 15:16:13'),
(255, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'y9vn4YPOSyvCWv59y03pY0DHIq7TDuLaTII43OSe', NULL, NULL, '2026-09-22 15:19:49'),
(256, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'y9vn4YPOSyvCWv59y03pY0DHIq7TDuLaTII43OSe', NULL, NULL, '2026-09-22 15:21:55'),
(257, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/', 'y9vn4YPOSyvCWv59y03pY0DHIq7TDuLaTII43OSe', NULL, NULL, '2026-09-22 15:22:02'),
(258, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/paper-clips-small', 'y9vn4YPOSyvCWv59y03pY0DHIq7TDuLaTII43OSe', NULL, NULL, '2026-09-22 15:22:12'),
(259, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/cart', 'y9vn4YPOSyvCWv59y03pY0DHIq7TDuLaTII43OSe', NULL, NULL, '2026-09-22 15:22:23'),
(260, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', 'y9vn4YPOSyvCWv59y03pY0DHIq7TDuLaTII43OSe', NULL, NULL, '2026-09-22 15:22:41'),
(261, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/login', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:23:00'),
(262, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=34', 'http://localhost/finamax/checkout', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:23:00'),
(263, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/login', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:25:50'),
(264, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:25:53'),
(265, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/login', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:35:20'),
(266, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/login', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:35:26'),
(267, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/login', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:37:14'),
(268, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:37:24'),
(269, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/payment', 'http://localhost/finamax/checkout', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:37:29'),
(270, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/payment', 'http://localhost/finamax/checkout', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:39:13'),
(271, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/notepads', 'http://localhost/finamax/checkout/payment', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:39:28'),
(272, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/desktop-calculator', 'http://localhost/finamax/categories/other-supplies', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:39:34'),
(273, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/desktop-calculator', 'http://localhost/finamax/categories/other-supplies', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:42:28'),
(274, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/desktop-calculator', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:42:35'),
(275, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:42:38'),
(276, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:42:45'),
(277, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/payment', 'http://localhost/finamax/checkout', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:42:51'),
(278, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/payment?order=NAW00111003', 'http://localhost/finamax/checkout/payment', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:42:57'),
(279, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/notepads', 'http://localhost/finamax/checkout/payment?order=NAW00111003', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:43:03'),
(280, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/notepads', 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 15:43:08'),
(281, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 16:12:00'),
(282, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 16:12:09'),
(283, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'oTpYa3l7XFykBHJ8sze6av56evDrB8QQWL8MSqDg', 4, NULL, '2026-09-22 16:12:20'),
(284, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'X0Tm4kymYpSLo37zSuNw4qnTbOwFwrup0X91g33b', NULL, NULL, '2026-09-22 16:12:24'),
(285, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/manage/products/all/80/edit', '38f2g7tgPD5kcxcsRObhie1juYuqF2mo3NOis014', NULL, NULL, '2026-09-23 06:35:06'),
(286, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', '38f2g7tgPD5kcxcsRObhie1juYuqF2mo3NOis014', NULL, NULL, '2026-09-23 06:51:01'),
(287, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', '38f2g7tgPD5kcxcsRObhie1juYuqF2mo3NOis014', NULL, NULL, '2026-09-23 06:51:07'),
(288, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', '38f2g7tgPD5kcxcsRObhie1juYuqF2mo3NOis014', NULL, NULL, '2026-09-23 06:51:14'),
(289, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:05:32'),
(290, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/thumbtacks-metal', 'http://localhost/finamax/', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:06:27'),
(291, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/products/thumbtacks-metal', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:07:04'),
(292, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/brands', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:18:01'),
(293, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/terms-conditions', 'http://localhost/finamax/products', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:18:09'),
(294, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/privacy-policy', 'http://localhost/finamax/terms-conditions', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:18:17'),
(295, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/refund-policy', 'http://localhost/finamax/privacy-policy', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:18:20'),
(296, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/blog', 'http://localhost/finamax/refund-policy', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:18:25'),
(297, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/track-order', 'http://localhost/finamax/blog', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:18:28'),
(298, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/track-order', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 07:18:32'),
(299, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/about', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:10:25'),
(300, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/brands', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:10:37'),
(301, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/printer-inks', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:10:38'),
(302, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/categories/printers-scanners', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:12:31'),
(303, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:33:46'),
(304, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:35:19'),
(305, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax', 'http://localhost/finamax/', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:35:23'),
(306, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:36:26'),
(307, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:36:43'),
(308, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/products', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:36:55'),
(309, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/products/paper-clips-small', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:37:04'),
(310, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/laser-printer-toner-color', 'http://localhost/finamax/products', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:37:14'),
(311, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/hp-quality-compatible-83a-laserjet-toner-catridge', 'http://localhost/finamax/products/laser-printer-toner-color', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:37:18'),
(312, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/products/hp-quality-compatible-83a-laserjet-toner-catridge', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:37:29'),
(313, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/rechargeable-mouse', 'http://localhost/finamax/categories/computers-laptops', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:37:34'),
(314, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/products/rechargeable-mouse', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:37:49'),
(315, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/hp-elitebook-x360-1030-g3-intel-core-i5-8th-gen-8gb-ram-256gb-ssd', 'http://localhost/finamax/categories/computers-laptops', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:37:54'),
(316, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/hp-elitebook-x360-1030-g3-intel-core-i5-8th-gen-8gb-ram-256gb-ssd', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:09'),
(317, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/hp-elitebook-x360-1030-g3-intel-core-i5-8th-gen-8gb-ram-256gb-ssd', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:16'),
(318, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27 Mobile/15E148 Safari/604.1', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:17'),
(319, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/hp-elitebook-x360-1030-g3-intel-core-i5-8th-gen-8gb-ram-256gb-ssd', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:25'),
(320, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:28'),
(321, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:36'),
(322, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/checkout', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:55'),
(323, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/computers-laptops', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:38:59'),
(324, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/products/test-1', 'http://localhost/finamax/', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:39:03'),
(325, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:39:20'),
(326, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:40:17'),
(327, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/', 'i7QlR7Clqzd0FPqOyrV0SyUs2PXj6qNIhiyFhUeH', 2, NULL, '2026-09-23 08:40:22'),
(328, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:44:12'),
(329, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:44:26'),
(330, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:44:30'),
(331, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/notepads', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:45:46'),
(332, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/brands/epson', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:46:42'),
(333, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/brands/hp', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:46:48'),
(334, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:48:10'),
(335, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:48:24'),
(336, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printer-inks', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:48:57'),
(337, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printer-inks', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:50:58'),
(338, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:51:22'),
(339, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printers-scanners', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:51:30'),
(340, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:52:05'),
(341, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/categories/printers-scanners', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:53:15'),
(342, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/wireless-bluetooth-keyboard-7-colors-backlit-rechargeable-keyboard', 'http://localhost/finamax/categories/other-supplies', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:53:18'),
(343, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/bic-crystal-pens', 'http://localhost/finamax/categories/other-supplies', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:53:24'),
(344, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/red-gel-pens', 'http://localhost/finamax/categories/other-supplies', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:53:34'),
(345, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/products/red-gel-pens', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:54:10'),
(346, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/office-stationery', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:55:36'),
(347, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:57:27'),
(348, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:58:28'),
(349, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/categories/office-stationery', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:58:30'),
(350, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/spiral-pocket-notebooks', 'http://localhost/finamax/products/push-pins-assorted-colors', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:58:47'),
(351, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/a4-white-envelopes-peel-amp-seal', 'http://localhost/finamax/products/push-pins-assorted-colors', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:58:50'),
(352, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/ink-pot', 'http://localhost/finamax/products/push-pins-assorted-colors', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:59:00'),
(353, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/terms-conditions', 'http://localhost/finamax/products/ink-pot', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 08:59:58');
INSERT INTO `su_visitors_logs` (`id`, `ip_address`, `user_agent`, `visited_url`, `referrer_url`, `session_id`, `user_id`, `country`, `visit_time`) VALUES
(354, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/terms-conditions', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 09:00:25'),
(355, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/categories/office-stationery', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 09:00:28'),
(356, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printer-inks', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 09:50:56'),
(357, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 09:51:08'),
(358, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printers-scanners', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 09:51:23'),
(359, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/notepads', 'http://localhost/finamax/', '5HxHe370uAPaItjIeiVpGNeR0RTP80cP990Bn9h1', NULL, NULL, '2026-09-25 09:51:28'),
(360, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:53:19'),
(361, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:56:04'),
(362, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/other-supplies', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:56:12'),
(363, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/categories/printer-inks', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:56:24'),
(364, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/categories/office-stationery', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:57:05'),
(365, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/products/push-pins-assorted-colors', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:57:08'),
(366, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/categories/office-stationery', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:57:09'),
(367, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/other-supplies', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:57:19'),
(368, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/categories/printers-scanners', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:57:24'),
(369, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/83a-toner-iprint', 'http://localhost/finamax/categories/toners-cartridges', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:57:45'),
(370, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products/83a-toner-iprint', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 12:57:57'),
(371, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 13:03:11'),
(372, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/blue-gel-pens', 'http://localhost/finamax/categories/other-supplies', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 13:03:13'),
(373, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/blue-gel-pens', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 13:03:27'),
(374, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/cart', 'UK7JhLsIA7hihgWC6mObv45LJjyffVnKgW1ehN6l', NULL, NULL, '2026-09-25 13:03:53'),
(375, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/login', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:04:01'),
(376, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:04:05'),
(377, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/checkout', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:11:49'),
(378, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/wishlist', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:04'),
(379, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/account/wishlist', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:10'),
(380, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:14'),
(381, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:39'),
(382, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:43'),
(383, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:47'),
(384, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:50'),
(385, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/categories/printing-accessories', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:12:57'),
(386, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/computers-laptops', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:13:00'),
(387, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/about', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:19:16'),
(388, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/track-order', 'http://localhost/finamax/about', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:19:19'),
(389, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/track-order', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 13:30:44'),
(390, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 14:01:16'),
(391, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products/push-pins-assorted-colors', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 14:01:28'),
(392, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 14:04:52'),
(393, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/toners-cartridges', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 14:09:47'),
(394, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 14:55:19'),
(395, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/black-gel-pens', 'http://localhost/finamax/categories/office-stationery', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:02:57'),
(396, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/products/black-gel-pens', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:03:26'),
(397, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/categories/toners-cartridges', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:03:35'),
(398, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/categories/printing-accessories', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:04:12'),
(399, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/printing-accessories', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:04:14'),
(400, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:07:07'),
(401, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:07:19'),
(402, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:07:22'),
(403, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:07:31'),
(404, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/categories/printer-inks', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:07:57'),
(405, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/account/orders', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:08:01'),
(406, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/notepads', 'http://localhost/finamax/categories/computers-laptops', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:09:19'),
(407, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/categories/notepads', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:09:22'),
(408, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/categories/office-stationery', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:10:03'),
(409, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/other-supplies', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:10:19'),
(410, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/categories/toners-cartridges?sort=price_asc', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:14:00'),
(411, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/categories/computers-laptops', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 15:14:25'),
(412, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/categories/office-stationery', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:07:12'),
(413, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/desktop-calculator', 'http://localhost/finamax/categories/other-supplies', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:08:21'),
(414, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/correction-tape-white', 'http://localhost/finamax/products/desktop-calculator', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:19:38'),
(415, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/products/desktop-calculator', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:19:50'),
(416, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/categories/other-supplies', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:19:53'),
(417, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/notepads', 'http://localhost/finamax/categories/notepads', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:20:02'),
(418, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/categories/notepads', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:20:04'),
(419, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/categories/printer-inks', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:27:04'),
(420, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:27:37'),
(421, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:27:40'),
(422, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:27:44'),
(423, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:27:47'),
(424, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/checkout', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:27:53'),
(425, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/tape-dispenser', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:54:31'),
(426, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/tape-dispenser', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:54:34'),
(427, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/tape-dispenser', 'http://localhost/finamax/', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:54:37'),
(428, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/tape-dispenser', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:01'),
(429, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:10'),
(430, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:12'),
(431, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout/locations?county_id=47', 'http://localhost/finamax/checkout', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:15'),
(432, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/work-books', 'http://localhost/finamax/checkout', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:26'),
(433, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/printer-cleaning-kit', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:35'),
(434, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:40'),
(435, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/categories/printers-scanners', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:42'),
(436, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/work-books', 'http://localhost/finamax/categories/printing-accessories', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:43'),
(437, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/work-books', 'http://localhost/finamax/categories/work-books', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:45'),
(438, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/categories/work-books', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:46'),
(439, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/toners-cartridges', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:47'),
(440, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/hp-wireless-mouse-black', 'http://localhost/finamax/categories/other-supplies', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:57:56'),
(441, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/products/hp-wireless-mouse-black', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:58:21'),
(442, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/blue-gel-pens', 'http://localhost/finamax/categories/other-supplies', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:58:26'),
(443, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/bic-crystal-pens', 'http://localhost/finamax/products/blue-gel-pens', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:58:36'),
(444, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/bic-crystal-pens', 'http://localhost/finamax/products/blue-gel-pens', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:58:39'),
(445, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/desktop-calculator', 'http://localhost/finamax/products/blue-gel-pens', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:58:44'),
(446, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/products/desktop-calculator', 'l4HDFKevzjGnp7exX1gvKhDsZdJyzEYreGQCNphP', 1, NULL, '2026-09-25 16:58:47'),
(447, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'UjE3hhVBPiiV8Fkk6mPvwnNuBg3hCzieEE1rc6Ih', NULL, NULL, '2026-09-26 08:37:26'),
(448, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'UjE3hhVBPiiV8Fkk6mPvwnNuBg3hCzieEE1rc6Ih', NULL, NULL, '2026-09-26 08:39:33'),
(449, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'UjE3hhVBPiiV8Fkk6mPvwnNuBg3hCzieEE1rc6Ih', NULL, NULL, '2026-09-26 08:39:51'),
(450, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/', 'UjE3hhVBPiiV8Fkk6mPvwnNuBg3hCzieEE1rc6Ih', NULL, NULL, '2026-09-26 08:39:55'),
(451, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/login', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:40:03'),
(452, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/dashboard', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:40:14'),
(453, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/dashboard', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:40:37'),
(454, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:40:45'),
(455, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:40:53'),
(456, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/cart', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:40:58'),
(457, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:42:51'),
(458, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/brands', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:42:55'),
(459, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:44:29'),
(460, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/account/dashboard', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:44:34'),
(461, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/products', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:44:37'),
(462, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/products', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:44:41'),
(463, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/test-1', 'http://localhost/finamax/products', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:44:50'),
(464, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/products/test-1', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:45:28'),
(465, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', NULL, 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:46:09'),
(466, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/notepads', 'http://localhost/finamax/account/dashboard', 'mwrGJZtR6A9DPGnU6JSsfmibkrfsiCDcVZ75mkUi', 1, NULL, '2026-09-26 08:46:13'),
(467, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/notepads', 'MgVvw2PMQSWRoH2OOm4HMWJ6f3qYl6MxLmIwYqc3', NULL, NULL, '2026-09-26 08:46:35'),
(468, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/manage/dashboard', 'B5db4As2abqgO6ni9XHPylKJBK5vyXTpEpY9WpRe', NULL, NULL, '2026-09-26 08:54:24'),
(469, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/', 'B5db4As2abqgO6ni9XHPylKJBK5vyXTpEpY9WpRe', NULL, NULL, '2026-09-26 08:54:28'),
(470, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', 'B5db4As2abqgO6ni9XHPylKJBK5vyXTpEpY9WpRe', NULL, NULL, '2026-09-26 08:54:30'),
(471, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/login', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 08:54:39'),
(472, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/dashboard', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 08:57:43'),
(473, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 08:57:45'),
(474, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/office-stationery', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:02:51'),
(475, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:03:47'),
(476, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/cart', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:03:49'),
(477, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:03:56'),
(478, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/dashboard', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:04:00'),
(479, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:04:03'),
(480, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/dashboard', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:05:50'),
(481, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:05:53'),
(482, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:06:07'),
(483, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/orders', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:06:11'),
(484, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:06:33'),
(485, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:07:11'),
(486, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:07:18'),
(487, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/other-supplies', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:07:25'),
(488, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/categories/printers-scanners', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:07:43'),
(489, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/computers-laptops', '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:07:45'),
(490, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/dashboard', NULL, '3b04xi7BBrsJ0Kb9m2eFGSmNp6QtjwjEEFKaIPI6', 1, NULL, '2026-09-26 09:09:39'),
(491, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/account/dashboard', 'RKfKTCyRnpywq5gu4mkm0UG0gn9oBoL1dVg219UD', NULL, NULL, '2026-09-26 09:09:42'),
(492, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 10:10:06'),
(493, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 10:11:11'),
(494, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/83a-toner-iprint', 'http://localhost/finamax/categories/toners-cartridges', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 10:11:20'),
(495, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/products/83a-toner-iprint', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 10:15:48'),
(496, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printers-scanners', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 10:15:59'),
(497, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/thumbtacks-metal', 'http://localhost/finamax/', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 10:24:12'),
(498, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/products/thumbtacks-metal', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 10:24:22'),
(499, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/wireless-keyboard', 'http://localhost/finamax/categories/computers-laptops', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 11:31:05'),
(500, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/products/wireless-keyboard', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 11:31:13'),
(501, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/push-pins-assorted-colors', 'http://localhost/finamax/categories/office-stationery', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 11:34:06'),
(502, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/staples-standard-size', 'http://localhost/finamax/products/push-pins-assorted-colors', 'VpUGMbjp9RMvjTHJJFw5KTpJ6aB05z9RB4a783Dy', 2, NULL, '2026-09-26 11:46:11'),
(503, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:34:39'),
(504, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:37:05'),
(505, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/05a-toner-reliable-performance-crisp-prints', 'http://localhost/finamax/categories/printers-scanners', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:37:12'),
(506, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products/05a-toner-reliable-performance-crisp-prints', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:37:15'),
(507, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/paper-clips-small', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:37:19'),
(508, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/products/paper-clips-small', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:37:21'),
(509, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/other-supplies', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:37:50'),
(510, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/05a-toner-reliable-performance-crisp-prints', 'http://localhost/finamax/categories/printers-scanners', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:37:52'),
(511, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/products/05a-toner-reliable-performance-crisp-prints', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:12'),
(512, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/office-stationery?sort=newest', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:37'),
(513, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:45'),
(514, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/login', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:48'),
(515, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/login', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:50'),
(516, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:52'),
(517, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/categories/office-stationery', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:54'),
(518, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/other-supplies', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:38:56'),
(519, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/categories/printers-scanners', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:39:02'),
(520, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/categories/printing-accessories', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:39:04'),
(521, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/work-books', 'http://localhost/finamax/categories/toners-cartridges', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:39:07'),
(522, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/categories/work-books', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:39:09');
INSERT INTO `su_visitors_logs` (`id`, `ip_address`, `user_agent`, `visited_url`, `referrer_url`, `session_id`, `user_id`, `country`, `visit_time`) VALUES
(523, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/laser-printer-toner-color', 'http://localhost/finamax/categories/toners-cartridges', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:39:10'),
(524, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/products/laser-printer-toner-color', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:39:28'),
(525, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/office-stationery', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:39:34'),
(526, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:41:11'),
(527, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:41:12'),
(528, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/categories/other-supplies', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:41:38'),
(529, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/laser-printer-toner-color', 'http://localhost/finamax/categories/toners-cartridges', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:41:53'),
(530, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/laser-printer-toner-color', 'http://localhost/finamax/categories/toners-cartridges', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:42:14'),
(531, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products/laser-printer-toner-color', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:42:30'),
(532, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:42:39'),
(533, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/office-stationery', 'http://localhost/finamax/categories/toners-cartridges', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:46:11'),
(534, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/office-stationery', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:46:22'),
(535, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/brands', 'http://localhost/finamax/', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:46:32'),
(536, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/computers-laptops', 'http://localhost/finamax/brands', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:47:45'),
(537, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/computers-laptops', '4WJMwCuDvCkekiBU5n4i0ADBQEqkp5QWHzvQ2y87', NULL, NULL, '2026-09-28 08:47:47'),
(538, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'I7K7nfB2x4kWKzAtWh8ypTFTxInpIS3TvWQuJMEG', 2, NULL, '2026-09-28 08:58:55'),
(539, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/', 'I7K7nfB2x4kWKzAtWh8ypTFTxInpIS3TvWQuJMEG', 2, NULL, '2026-09-28 08:59:03'),
(540, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/categories/printer-inks', 'I7K7nfB2x4kWKzAtWh8ypTFTxInpIS3TvWQuJMEG', 2, NULL, '2026-09-28 08:59:32'),
(541, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/checkout', 'http://localhost/finamax/cart', 'I7K7nfB2x4kWKzAtWh8ypTFTxInpIS3TvWQuJMEG', 2, NULL, '2026-09-28 08:59:34'),
(542, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/manage/dashboard', 'TF5iETO86SJ8skqtqWWlh3kDMiuCdxeamel1ll2l', NULL, NULL, '2026-09-28 09:01:17'),
(543, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:38:55'),
(544, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/', 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:38:59'),
(545, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/account/orders', 'http://localhost/finamax/categories/printers-scanners', 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:39:07'),
(546, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/account/orders', 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:39:13'),
(547, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/whiteboard-markers', 'http://localhost/finamax/products', 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:39:19'),
(548, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/products/whiteboard-markers', 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:39:32'),
(549, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/toners-cartridges', 'http://localhost/finamax/', 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:40:50'),
(550, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/uncategorized', 'http://localhost/finamax/categories/toners-cartridges', 'fo8o8xceZ2UEocddbRyP1XO5OjQIKfAoeSIf6jOR', 2, NULL, '2026-09-28 09:40:58'),
(551, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'WmBVR8bl2EH0rQ61hRetdGc8PkuH9Yl2Io7caADw', NULL, NULL, '2026-09-29 10:18:33'),
(552, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'qgiAhLFHHBChKrxS8nysDGSMIMFyo8cFH1Uki4vD', NULL, NULL, '2026-09-29 14:24:41'),
(553, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'UvTM9lYmWf4jhU47r3ZFplYEbjdoe9WNW1GFjlHT', NULL, NULL, '2026-09-30 09:00:20'),
(554, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'XG9lU695ujaXqBgn5pntFX8opVFClefE9q9jtb9E', NULL, NULL, '2026-10-01 15:31:24'),
(555, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'bkz8OWAjgq7a1uY1SNyPtIK3FdcEnfHCFEcygluF', NULL, NULL, '2026-10-02 07:09:41'),
(556, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'Xyr833INzzgezrtfMWgFbrxyhAnGTwmIHInT7vJf', NULL, NULL, '2026-10-02 08:31:04'),
(557, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'wu4qMlBCUBeTko0zDphRxpSzXMbHNYQRhbxCQCHl', NULL, NULL, '2026-10-05 09:24:38'),
(558, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'FbiadQXquPUUtcdiSS5DhhRO98fCZG47v4Bhfl30', NULL, NULL, '2026-10-07 12:14:01'),
(559, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'UnsqajXoZ0uyTluC6zOBM470R6fMitOkP3reWerr', NULL, NULL, '2026-10-08 08:32:27'),
(560, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:28:51'),
(561, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:29:57'),
(562, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/blue-gel-pens', 'http://localhost/finamax/categories/other-supplies', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:30:20'),
(563, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/blue-gel-pens', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:30:50'),
(564, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/cart', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:30:53'),
(565, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:31:06'),
(566, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/cart', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:37:29'),
(567, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/embossed-binding-covers-red-ream', 'http://localhost/finamax/', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:38:24'),
(568, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:52:29'),
(569, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printing-accessories', 'http://localhost/finamax/', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:52:44'),
(570, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/work-books', 'http://localhost/finamax/categories/printing-accessories', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:52:50'),
(571, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printers-scanners', 'http://localhost/finamax/categories/work-books', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:52:58'),
(572, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/printer-cleaning-kit', 'http://localhost/finamax/categories/printers-scanners', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:53:08'),
(573, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products', 'http://localhost/finamax/products/printer-cleaning-kit', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:53:33'),
(574, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/products/test-1', 'http://localhost/finamax/products', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:54:29'),
(575, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/products/test-1', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:54:49'),
(576, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax/cart', 'http://localhost/finamax/cart', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:54:52'),
(577, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/cart', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:54:56'),
(578, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'B4YbbkKsAVqZa8ujvJNreiMp7DLQKVoabm6fzntU', NULL, NULL, '2026-10-08 20:56:48'),
(579, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, '8OUxlbCnnY5sJcTUj02bZbg9QHLhYpdj1TYEqiyq', NULL, NULL, '2026-10-12 11:08:02'),
(580, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'QY8HXTZl8veitXucOYID9GITGNgYr5LFCW6E6SM8', NULL, NULL, '2026-10-12 13:35:59'),
(581, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 15:41:09'),
(582, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 15:41:21'),
(583, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/', 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 15:50:57'),
(584, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/printer-inks', 'http://localhost/finamax/', 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 15:50:59'),
(585, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/categories/printer-inks', 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 15:51:23'),
(586, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 15:51:35'),
(587, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', NULL, 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 16:44:06'),
(588, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax/login', 'http://localhost/finamax/', 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 16:44:13'),
(589, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax', 'http://localhost/finamax/login', 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 16:44:24'),
(590, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/finamax/categories/other-supplies', 'http://localhost/finamax/', 'vER5e7ANWIsF6CatH1Op0nYPtHpjvkFMBwzBl39J', NULL, NULL, '2026-10-12 16:49:23'),
(591, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'wIMnJDlYXpDUqBhJdr8epfqDVSoiDZUtTLTarwZI', NULL, NULL, '2026-10-12 17:00:35'),
(592, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', NULL, 'L2KfNylUJ7NUAp8pGS2W2C5Gku4orlpzsdQjmC86', NULL, NULL, '2026-10-12 17:58:16'),
(593, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/login', 'L2KfNylUJ7NUAp8pGS2W2C5Gku4orlpzsdQjmC86', NULL, NULL, '2026-10-12 17:58:23'),
(594, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/login', 'L2KfNylUJ7NUAp8pGS2W2C5Gku4orlpzsdQjmC86', NULL, NULL, '2026-10-12 17:58:33'),
(595, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/login', 'L2KfNylUJ7NUAp8pGS2W2C5Gku4orlpzsdQjmC86', NULL, NULL, '2026-10-12 17:58:39'),
(596, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/login', 'L2KfNylUJ7NUAp8pGS2W2C5Gku4orlpzsdQjmC86', NULL, NULL, '2026-10-12 17:58:51'),
(597, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'i61PsNoMgqyvbcPav1yFyBg5N1LWVLToELDm8wsL', NULL, NULL, '2026-10-13 07:57:42'),
(598, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:11:06'),
(599, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:12:11'),
(600, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:23:48'),
(601, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:36:02'),
(602, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:43:39'),
(603, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:44:44'),
(604, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:45:18'),
(605, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/blog', 'http://localhost/trinitymabati/', 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:45:23'),
(606, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/blog', 'http://localhost/trinitymabati/', 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:47:09'),
(607, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/blog', 'http://localhost/trinitymabati/', 'Wp8S94r1YkhgR3a4e6SVLVEVstW8tFEnBSNucrdE', 2, NULL, '2026-10-13 08:52:13'),
(608, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/manage/dashboard', 'wsKnrHhlkyn19UWbtbhdL0DYProhngSJmtLbVwkq', NULL, NULL, '2026-10-13 08:54:16'),
(609, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/login', 'wsKnrHhlkyn19UWbtbhdL0DYProhngSJmtLbVwkq', NULL, NULL, '2026-10-13 08:54:21'),
(610, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/blog', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 08:54:54'),
(611, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/blog', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:00:12'),
(612, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/blog', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:20:39'),
(613, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:20:57'),
(614, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:34:23'),
(615, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:34:25'),
(616, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:34:27'),
(617, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:34:33'),
(618, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/products', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:34:45'),
(619, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:34:47'),
(620, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:43:07'),
(621, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:43:09'),
(622, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:43:14'),
(623, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/products', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:43:44'),
(624, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:43:45'),
(625, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:43:46'),
(626, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:43:48'),
(627, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:44:29'),
(628, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:44:32'),
(629, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:44:37'),
(630, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:46:50'),
(631, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-tile-red', 'http://localhost/trinitymabati/products', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:46:56'),
(632, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:47:49'),
(633, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:48:22'),
(634, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:51:39'),
(635, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:51:42'),
(636, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:51:44'),
(637, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:51:45'),
(638, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-versatile', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:55:39'),
(639, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/trinity-versatile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:55:53'),
(640, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-maroon', 'http://localhost/trinitymabati/categories/trinity-versatile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:56:14'),
(641, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-maroon', 'http://localhost/trinitymabati/categories/trinity-versatile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:58:37'),
(642, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products?category_id=22', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:58:41'),
(643, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/products?category_id=22', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:58:44'),
(644, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 09:58:48'),
(645, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:02:39'),
(646, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:03:19'),
(647, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:04:26'),
(648, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-tile-red', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:04:29'),
(649, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:05:09'),
(650, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:05:24'),
(651, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:06:53'),
(652, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-versatile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:07:05'),
(653, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/trinity-versatile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:07:59'),
(654, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:08:10'),
(655, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:08:26'),
(656, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:08:38'),
(657, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:08:51'),
(658, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:09:25'),
(659, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:09:47'),
(660, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:10:31'),
(661, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:10:37'),
(662, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:10:41'),
(663, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:11:03'),
(664, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:11:32'),
(665, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:12:22'),
(666, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-chocolate-brown', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:15:32'),
(667, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:15:34'),
(668, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:16:23'),
(669, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:16:29'),
(670, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:17:25'),
(671, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:19:39'),
(672, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:19:42'),
(673, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:19:54'),
(674, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:23:13'),
(675, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:23:21'),
(676, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:23:30'),
(677, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/trinity-versatile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:23:45'),
(678, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/trinity-versatile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:26:37'),
(679, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/products/trinity-versatile-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:26:58'),
(680, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:27:02'),
(681, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:27:41'),
(682, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-tile-red', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:27:54'),
(683, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-tile-red', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:29:54'),
(684, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-tile-red', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:30:25'),
(685, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maroon', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:30:34'),
(686, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:30:40'),
(687, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:30:43'),
(688, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:30:46');
INSERT INTO `su_visitors_logs` (`id`, `ip_address`, `user_agent`, `visited_url`, `referrer_url`, `session_id`, `user_id`, `country`, `visit_time`) VALUES
(689, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:33:58'),
(690, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:34:37'),
(691, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:44:34'),
(692, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:44:38'),
(693, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:44:43'),
(694, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:44:52'),
(695, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-maroon', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:45:00'),
(696, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:48:31'),
(697, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:48:35'),
(698, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:48:38'),
(699, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:50:16'),
(700, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:50:19'),
(701, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:53:31'),
(702, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:53:44'),
(703, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:53:53'),
(704, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:54:11'),
(705, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:59:09'),
(706, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 10:59:46'),
(707, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:00:13'),
(708, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:00:48'),
(709, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:04:41'),
(710, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-forest-green', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:05:44'),
(711, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-forest-green', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:10:40'),
(712, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:10:54'),
(713, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:11:26'),
(714, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:11:36'),
(715, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-tile-red', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:11:58'),
(716, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:13:19'),
(717, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:13:40'),
(718, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:13:46'),
(719, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-orientile-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:13:57'),
(720, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:15:07'),
(721, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:16:35'),
(722, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:16:38'),
(723, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:16:40'),
(724, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:21:17'),
(725, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-maroon', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:21:24'),
(726, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-maroon', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:25:23'),
(727, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:25:25'),
(728, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-chocolate-brown', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:25:35'),
(729, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:26:29'),
(730, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:26:32'),
(731, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-forest-green', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:26:37'),
(732, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:31:55'),
(733, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-charcoal-grey', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:32:03'),
(734, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-forest-green', 'http://localhost/trinitymabati/products/box-profile-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:33:15'),
(735, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:33:44'),
(736, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:33:50'),
(737, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-forest-green', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:34:25'),
(738, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/products/stone-coated-shingle-roofing-tiles-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:34:52'),
(739, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:35:08'),
(740, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:35:10'),
(741, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:35:11'),
(742, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:35:13'),
(743, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:36:22'),
(744, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:36:25'),
(745, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-maroon', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:36:34'),
(746, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/products/box-profile-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:36:39'),
(747, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-maroon', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:36:45'),
(748, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/products/box-profile-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:48:55'),
(749, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-tile-red', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:49:07'),
(750, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:52:03'),
(751, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:52:54'),
(752, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:52:57'),
(753, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:53:08'),
(754, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 11:53:49'),
(755, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 12:47:51'),
(756, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 13:40:53'),
(757, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 13:40:56'),
(758, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 13:43:21'),
(759, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:14:04'),
(760, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:14:07'),
(761, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:17:06'),
(762, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:17:09'),
(763, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:29:02'),
(764, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:29:06'),
(765, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:29:28'),
(766, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:31:03'),
(767, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:33:09'),
(768, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:34:52'),
(769, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:34:55'),
(770, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:35:09'),
(771, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:40:04'),
(772, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:40:18'),
(773, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:40:34'),
(774, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:41:39'),
(775, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:54:00'),
(776, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:54:27'),
(777, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:54:35'),
(778, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:54:51'),
(779, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:55:31'),
(780, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:55:40'),
(781, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:55:48'),
(782, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:55:50'),
(783, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:56:01'),
(784, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:56:05'),
(785, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:56:37'),
(786, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:56:59'),
(787, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:57:20'),
(788, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:57:37'),
(789, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:57:47'),
(790, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:58:30'),
(791, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:58:56'),
(792, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 14:58:58'),
(793, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:02:52'),
(794, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:07'),
(795, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:11'),
(796, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:32'),
(797, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:35'),
(798, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:37'),
(799, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:42'),
(800, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:45'),
(801, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:47'),
(802, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:52'),
(803, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:03:58'),
(804, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:04:00'),
(805, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:04:04'),
(806, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:04:19'),
(807, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:04:21'),
(808, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:04:25'),
(809, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:04:34'),
(810, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:04:35'),
(811, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:05:35'),
(812, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:05:53'),
(813, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:05:58'),
(814, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:01'),
(815, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-charcoal-grey', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:04'),
(816, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:05'),
(817, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:07'),
(818, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:15'),
(819, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:18'),
(820, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:25'),
(821, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:51'),
(822, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:06:54'),
(823, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:07:12'),
(824, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:07:14'),
(825, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:07:18'),
(826, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/roman-roofing-tiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:07:36'),
(827, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/roman-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:10:24'),
(828, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:11:01'),
(829, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:11:13'),
(830, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:13:21'),
(831, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:13:33'),
(832, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:13:35'),
(833, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:13:47'),
(834, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:16:02'),
(835, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:16:04'),
(836, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:16:41'),
(837, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:16:44'),
(838, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:16:53'),
(839, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:17:05'),
(840, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:20:07'),
(841, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:20:20'),
(842, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:20:29'),
(843, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:20:34'),
(844, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:20:47'),
(845, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:20:49');
INSERT INTO `su_visitors_logs` (`id`, `ip_address`, `user_agent`, `visited_url`, `referrer_url`, `session_id`, `user_id`, `country`, `visit_time`) VALUES
(846, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:20:51'),
(847, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:24:21'),
(848, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:24:23'),
(849, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:24:44'),
(850, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:25:30'),
(851, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:25:33'),
(852, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:25:39'),
(853, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:25:47'),
(854, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:29:00'),
(855, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:29:06'),
(856, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:29:07'),
(857, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:29:57'),
(858, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/blog', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:31:48'),
(859, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/blog', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:34:24'),
(860, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:35:39'),
(861, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:35:43'),
(862, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:35:46'),
(863, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:36:33'),
(864, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:36:37'),
(865, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:37:10'),
(866, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:37:26'),
(867, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:37:31'),
(868, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:38:21'),
(869, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:39:46'),
(870, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:41:52'),
(871, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:42:41'),
(872, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:42:49'),
(873, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:43:05'),
(874, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:43:44'),
(875, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:51:52'),
(876, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:51:57'),
(877, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:53:19'),
(878, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:56:20'),
(879, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:56:24'),
(880, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:57:00'),
(881, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:57:54'),
(882, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:58:12'),
(883, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:58:50'),
(884, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:59:10'),
(885, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:59:11'),
(886, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'http://localhost/trinitymabati/categories/box-profile?sort=price_asc', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:59:18'),
(887, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 15:59:22'),
(888, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:02:27'),
(889, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:02:50'),
(890, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:09:51'),
(891, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:09:55'),
(892, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:09:58'),
(893, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:10:00'),
(894, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:10:35'),
(895, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:10:46'),
(896, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:11:22'),
(897, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:22:15'),
(898, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-classic-roofing-tiles-forest-green', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:22:19'),
(899, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/stone-coated-classic-roofing-tiles-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:22:29'),
(900, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:22:36'),
(901, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:22:39'),
(902, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:22:46'),
(903, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:22:53'),
(904, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:23:00'),
(905, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:25:26'),
(906, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:26:28'),
(907, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:26:54'),
(908, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:32:40'),
(909, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:33:19'),
(910, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:34:04'),
(911, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:34:08'),
(912, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:34:12'),
(913, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:35:25'),
(914, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:35:31'),
(915, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:35:33'),
(916, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:36:07'),
(917, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:36:13'),
(918, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:38:33'),
(919, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:39:20'),
(920, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:39:25'),
(921, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:41:04'),
(922, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:43:01'),
(923, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:49:33'),
(924, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:49:56'),
(925, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:50:06'),
(926, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:50:25'),
(927, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'zLmFKNONxbIJYU1EQGlAv1uOPPrxzLUHYyx95ZRe', NULL, NULL, '2026-10-13 16:50:36'),
(928, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:52:20'),
(929, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:52:23'),
(930, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:52:26'),
(931, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:54:05'),
(932, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-maroon', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:55:42'),
(933, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-maroon', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:55:52'),
(934, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:56:06'),
(935, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:56:10'),
(936, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:56:12'),
(937, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:57:13'),
(938, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 16:58:59'),
(939, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:01:06'),
(940, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:01:46'),
(941, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:04:00'),
(942, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:04:28'),
(943, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:05:48'),
(944, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:06:14'),
(945, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:08:53'),
(946, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:09:05'),
(947, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:12:17'),
(948, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:13:03'),
(949, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:15:28'),
(950, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:19:37'),
(951, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:19:44'),
(952, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:19:59'),
(953, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:20:08'),
(954, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:20:17'),
(955, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:20:18'),
(956, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:20:50'),
(957, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:21:20'),
(958, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:21:22'),
(959, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:22:09'),
(960, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:22:11'),
(961, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:22:17'),
(962, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:23:28'),
(963, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:23:42'),
(964, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:23:45'),
(965, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:24:16'),
(966, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories?category=corrugated-sheets', 'http://localhost/trinitymabati/categories', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:24:26'),
(967, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories?category=stone-coated-profiles', 'http://localhost/trinitymabati/categories?category=corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:24:33'),
(968, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories?category=classic-roofing-tiles', 'http://localhost/trinitymabati/categories?category=stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:24:50'),
(969, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories?category=roman-roofing-tiles', 'http://localhost/trinitymabati/categories?category=classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:26:02'),
(970, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories?category=roman-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:26:51'),
(971, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:26:53'),
(972, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:27:00'),
(973, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:27:06'),
(974, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:28:12'),
(975, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:28:14'),
(976, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:28:28'),
(977, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:28:30'),
(978, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:28:42'),
(979, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:30:58'),
(980, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/blog', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:31:05'),
(981, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/blog', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:31:09'),
(982, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:31:41'),
(983, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:31:48'),
(984, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-forest-green', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:33:10'),
(985, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:33:20'),
(986, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:33:28'),
(987, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:34:35'),
(988, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:34:37'),
(989, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:35:04'),
(990, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:36:10'),
(991, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/trinity-eurotile-roofing-sheet-chocolate-brown', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:36:12'),
(992, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-roman-roofing-tiles-tile-red', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:36:24'),
(993, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-roman-roofing-tiles-tile-red', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:38:05'),
(994, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/stone-coated-roman-roofing-tiles-tile-red', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:38:08'),
(995, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-forest-green', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:38:15'),
(996, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/box-profile-forest-green', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:39:42'),
(997, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/box-profile-forest-green', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:39:44'),
(998, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:41:21'),
(999, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:41:52'),
(1000, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:44:54'),
(1001, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:45:32'),
(1002, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:45:34'),
(1003, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:45:40'),
(1004, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:45:43'),
(1005, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:46:31'),
(1006, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:47:01'),
(1007, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/roman-roofing-tiles', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:47:07'),
(1008, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'http://localhost/trinitymabati/categories/roman-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:47:12'),
(1009, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/categories/shingle-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:47:18'),
(1010, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:47:23'),
(1011, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/categories/trinity-orientile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:47:24');
INSERT INTO `su_visitors_logs` (`id`, `ip_address`, `user_agent`, `visited_url`, `referrer_url`, `session_id`, `user_id`, `country`, `visit_time`) VALUES
(1012, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/tile-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:48:07'),
(1013, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:48:09'),
(1014, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:48:38'),
(1015, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:48:46'),
(1016, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:15'),
(1017, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-alluzinc-roofing-sheet-non-colored', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:16'),
(1018, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:39'),
(1019, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:46'),
(1020, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:48'),
(1021, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:49'),
(1022, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:53'),
(1023, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:49:54'),
(1024, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:51:01'),
(1025, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 17:51:03'),
(1026, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:02:07'),
(1027, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:02:17'),
(1028, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:02:35'),
(1029, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:02:39'),
(1030, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:03:46'),
(1031, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:04:49'),
(1032, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:05:13'),
(1033, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:05:16'),
(1034, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:11:36'),
(1035, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:15:28'),
(1036, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:15:47'),
(1037, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:17:00'),
(1038, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:17:30'),
(1039, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:09'),
(1040, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:16'),
(1041, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:18'),
(1042, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:22'),
(1043, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:23'),
(1044, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:25'),
(1045, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:27'),
(1046, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:29'),
(1047, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:31'),
(1048, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:36'),
(1049, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:38'),
(1050, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:41'),
(1051, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:18:49'),
(1052, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:19:00'),
(1053, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:20:07'),
(1054, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:20:09'),
(1055, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:20:11'),
(1056, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:25:18'),
(1057, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:28:43'),
(1058, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:29:31'),
(1059, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:29:33'),
(1060, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:30:19'),
(1061, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:30:32'),
(1062, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:30:34'),
(1063, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:30:40'),
(1064, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:31:02'),
(1065, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:32:34'),
(1066, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:32:36'),
(1067, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:32:38'),
(1068, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:32:40'),
(1069, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:32:42'),
(1070, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:32:54'),
(1071, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:32:56'),
(1072, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:33:46'),
(1073, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:33:50'),
(1074, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:33:53'),
(1075, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:34:20'),
(1076, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:34:44'),
(1077, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:34:47'),
(1078, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:34:48'),
(1079, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:34:50'),
(1080, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:35:00'),
(1081, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:35:06'),
(1082, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:35:27'),
(1083, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:38:02'),
(1084, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:38:04'),
(1085, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:38:06'),
(1086, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:39:13'),
(1087, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:39:15'),
(1088, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:39:18'),
(1089, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:39:28'),
(1090, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:40:05'),
(1091, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:41:23'),
(1092, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:46:38'),
(1093, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:48:18'),
(1094, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:48:24'),
(1095, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:48:25'),
(1096, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:48:27'),
(1097, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:48:29'),
(1098, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:48:34'),
(1099, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:49:43'),
(1100, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:52:00'),
(1101, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/cart', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:52:23'),
(1102, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:53:37'),
(1103, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:53:42'),
(1104, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:54:02'),
(1105, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:54:28'),
(1106, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:55:44'),
(1107, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:56:30'),
(1108, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:56:58'),
(1109, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:57:04'),
(1110, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:57:07'),
(1111, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:57:10'),
(1112, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:57:14'),
(1113, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:57:17'),
(1114, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 18:59:39'),
(1115, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:01:26'),
(1116, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:03:18'),
(1117, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/quotation', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:03:22'),
(1118, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/quotation', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:05:16'),
(1119, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:06:16'),
(1120, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:06:19'),
(1121, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:06:22'),
(1122, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:06:31'),
(1123, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:07:01'),
(1124, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:10:27'),
(1125, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:10:30'),
(1126, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:10:39'),
(1127, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:10:42'),
(1128, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/trinity-eurotile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:11:18'),
(1129, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:11:39'),
(1130, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:11:42'),
(1131, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:11:47'),
(1132, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/contact', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:12:37'),
(1133, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:12:39'),
(1134, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:15:22'),
(1135, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/box-profile', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:15:24'),
(1136, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/categories/box-profile', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:15:26'),
(1137, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:17:29'),
(1138, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'http://localhost/trinitymabati/', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:17:32'),
(1139, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/about', 'http://localhost/trinitymabati/categories/stone-coated-profiles', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:17:40'),
(1140, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/about', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 19:17:42'),
(1141, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'emkH1w9P9g0ymSseWtbFJpOQXBB2MbkgVSHhM3CQ', NULL, NULL, '2026-10-14 11:16:17'),
(1142, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', NULL, 'AuJpoXuiECrnA1FZDMwar9bnvGaozIDXHb9uIMRe', 2, NULL, '2026-10-14 11:52:07'),
(1143, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/manage/quotations/1', 'Nh3fWsieoUjHgiDnnH2DsSB9RAxBkCOve2LBK4Fj', NULL, NULL, '2026-10-14 14:29:11'),
(1144, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/login', 'Nh3fWsieoUjHgiDnnH2DsSB9RAxBkCOve2LBK4Fj', NULL, NULL, '2026-10-14 14:29:42'),
(1145, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/login', 'http://localhost/trinitymabati/login', 'Nh3fWsieoUjHgiDnnH2DsSB9RAxBkCOve2LBK4Fj', NULL, NULL, '2026-10-14 15:06:36'),
(1146, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'Nh3fWsieoUjHgiDnnH2DsSB9RAxBkCOve2LBK4Fj', NULL, NULL, '2026-10-14 15:27:15'),
(1147, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/tile-profiles', 'http://localhost/trinitymabati/', 'Nh3fWsieoUjHgiDnnH2DsSB9RAxBkCOve2LBK4Fj', NULL, NULL, '2026-10-14 15:27:16'),
(1148, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/trinity-orientile', 'http://localhost/trinitymabati/categories/tile-profiles', 'Nh3fWsieoUjHgiDnnH2DsSB9RAxBkCOve2LBK4Fj', NULL, NULL, '2026-10-14 15:27:24'),
(1149, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/categories/trinity-orientile', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 15:51:48'),
(1150, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:09:26'),
(1151, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:20:00'),
(1152, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/contact', 'http://localhost/trinitymabati/', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:20:20'),
(1153, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'http://localhost/trinitymabati/contact', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:20:54'),
(1154, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/stone-coated-classic-roofing-tiles-tile-red', 'http://localhost/trinitymabati/categories/classic-roofing-tiles', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:20:58'),
(1155, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/products/stone-coated-classic-roofing-tiles-tile-red', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:21:02'),
(1156, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout', 'http://localhost/trinitymabati/cart', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:21:04'),
(1157, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout/locations?county_id=47', 'http://localhost/trinitymabati/checkout', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:21:13'),
(1158, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout/payment', 'http://localhost/trinitymabati/checkout', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:21:19'),
(1159, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/checkout/payment', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:21:46'),
(1160, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/cart', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:22:03'),
(1161, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:22:06'),
(1162, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/cart', 'http://localhost/trinitymabati/products/corrugated-roofing-sheet-maasai-red', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:22:10'),
(1163, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout', 'http://localhost/trinitymabati/cart', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:22:12'),
(1164, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout/locations?county_id=47', 'http://localhost/trinitymabati/checkout', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:22:16'),
(1165, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout/payment', 'http://localhost/trinitymabati/checkout', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:22:20'),
(1166, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/checkout/payment?order=NAW00111005', 'http://localhost/trinitymabati/checkout/payment', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:22:36'),
(1167, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'http://localhost/trinitymabati/checkout/payment?order=NAW00111005', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:53:43'),
(1168, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-wave-glossy-tile-red', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 16:54:00'),
(1169, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-wave-glossy-tile-red', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 17:03:29'),
(1170, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati/products/corrugated-wave-glossy-tile-red', 'http://localhost/trinitymabati/categories/corrugated-sheets', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 17:05:44'),
(1171, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-wave-glossy-tile-red', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 17:11:33'),
(1172, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-wave-glossy-tile-red', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 17:11:47'),
(1173, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 17:11:51'),
(1174, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/products/corrugated-wave-glossy-tile-red', 'qyoX8z1Am2lU2NScEjlRdArKqTdCNWv8YLMpfSAC', 2, NULL, '2026-10-14 17:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `su_wishlists`
--

CREATE TABLE `su_wishlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_abandoned_carts`
--
ALTER TABLE `su_abandoned_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_abandoned_cart_logs`
--
ALTER TABLE `su_abandoned_cart_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `su_banners`
--
ALTER TABLE `su_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_blog_categories`
--
ALTER TABLE `su_blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `su_blog_posts`
--
ALTER TABLE `su_blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `su_blog_tags`
--
ALTER TABLE `su_blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `su_brands`
--
ALTER TABLE `su_brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `su_carts`
--
ALTER TABLE `su_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_cart_items`
--
ALTER TABLE `su_cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `su_client_projects`
--
ALTER TABLE `su_client_projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `su_client_projects_slug_unique` (`slug`),
  ADD KEY `su_client_projects_is_published_index` (`is_published`);

--
-- Indexes for table `su_client_testimonials`
--
ALTER TABLE `su_client_testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `su_client_testimonials_is_published_index` (`is_published`);

--
-- Indexes for table `su_contact_messages`
--
ALTER TABLE `su_contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_counties`
--
ALTER TABLE `su_counties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `su_countries`
--
ALTER TABLE `su_countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `su_customers`
--
ALTER TABLE `su_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `su_customer_payment_preferences`
--
ALTER TABLE `su_customer_payment_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `su_discounts`
--
ALTER TABLE `su_discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `su_email_settings`
--
ALTER TABLE `su_email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_faqs`
--
ALTER TABLE `su_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_flash_sales`
--
ALTER TABLE `su_flash_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `su_income_expenses`
--
ALTER TABLE `su_income_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_invoices`
--
ALTER TABLE `su_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_location_pricing`
--
ALTER TABLE `su_location_pricing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `town_id` (`town_id`);

--
-- Indexes for table `su_low_stock_alerts`
--
ALTER TABLE `su_low_stock_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `su_loyalty_points`
--
ALTER TABLE `su_loyalty_points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `tier_id` (`tier_id`);

--
-- Indexes for table `su_loyalty_settings`
--
ALTER TABLE `su_loyalty_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_loyalty_tiers`
--
ALTER TABLE `su_loyalty_tiers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_loyalty_transactions`
--
ALTER TABLE `su_loyalty_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `su_media`
--
ALTER TABLE `su_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `su_newsletters`
--
ALTER TABLE `su_newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_newsletter_subscribers`
--
ALTER TABLE `su_newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `su_notifications`
--
ALTER TABLE `su_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_orders`
--
ALTER TABLE `su_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_county_id` (`shipping_county_id`),
  ADD KEY `shipping_town_id` (`shipping_town_id`),
  ADD KEY `admin_confirmed_by` (`admin_confirmed_by`);

--
-- Indexes for table `su_order_items`
--
ALTER TABLE `su_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `su_order_loyalty`
--
ALTER TABLE `su_order_loyalty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_order_returns`
--
ALTER TABLE `su_order_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `su_order_status_history`
--
ALTER TABLE `su_order_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Indexes for table `su_pages`
--
ALTER TABLE `su_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `su_payments`
--
ALTER TABLE `su_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `method_id` (`method_id`);

--
-- Indexes for table `su_payment_logs`
--
ALTER TABLE `su_payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `su_payment_methods`
--
ALTER TABLE `su_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `su_pending_mpesa`
--
ALTER TABLE `su_pending_mpesa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_pending_pesapal`
--
ALTER TABLE `su_pending_pesapal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_pending_users`
--
ALTER TABLE `su_pending_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_permissions`
--
ALTER TABLE `su_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `su_post_tag`
--
ALTER TABLE `su_post_tag`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `su_products`
--
ALTER TABLE `su_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `label_id` (`label_id`);

--
-- Indexes for table `su_product_attributes`
--
ALTER TABLE `su_product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `su_product_attribute_values`
--
ALTER TABLE `su_product_attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `su_product_categories`
--
ALTER TABLE `su_product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `su_product_category`
--
ALTER TABLE `su_product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `su_product_label`
--
ALTER TABLE `su_product_label`
  ADD PRIMARY KEY (`product_id`,`label_id`),
  ADD KEY `label_id` (`label_id`);

--
-- Indexes for table `su_product_labels`
--
ALTER TABLE `su_product_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_product_reviews`
--
ALTER TABLE `su_product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_product_variants`
--
ALTER TABLE `su_product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `su_product_variant_attributes`
--
ALTER TABLE `su_product_variant_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD KEY `attribute_value_id` (`attribute_value_id`);

--
-- Indexes for table `su_quotations`
--
ALTER TABLE `su_quotations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotation_code` (`quotation_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `prepared_by` (`prepared_by`),
  ADD KEY `converted_order_id` (`converted_order_id`);

--
-- Indexes for table `su_quotation_items`
--
ALTER TABLE `su_quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `su_referral_codes`
--
ALTER TABLE `su_referral_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_referral_events`
--
ALTER TABLE `su_referral_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referral_code_id` (`referral_code_id`),
  ADD KEY `referrer_user_id` (`referrer_user_id`),
  ADD KEY `referred_user_id` (`referred_user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `su_roles`
--
ALTER TABLE `su_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `su_role_permissions`
--
ALTER TABLE `su_role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `su_sessions`
--
ALTER TABLE `su_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_settings`
--
ALTER TABLE `su_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `su_shipping_expenses`
--
ALTER TABLE `su_shipping_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `su_shipping_settings`
--
ALTER TABLE `su_shipping_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_support_tickets`
--
ALTER TABLE `su_support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_admin_id` (`assigned_admin_id`);

--
-- Indexes for table `su_support_ticket_replies`
--
ALTER TABLE `su_support_ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `su_system_logs`
--
ALTER TABLE `su_system_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_system_messages`
--
ALTER TABLE `su_system_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `su_tax_settings`
--
ALTER TABLE `su_tax_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_towns`
--
ALTER TABLE `su_towns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `county_id` (`county_id`);

--
-- Indexes for table `su_two_factor_authentications`
--
ALTER TABLE `su_two_factor_authentications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_users`
--
ALTER TABLE `su_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `su_user_devices`
--
ALTER TABLE `su_user_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_user_messages`
--
ALTER TABLE `su_user_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_user_profiles`
--
ALTER TABLE `su_user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `county_id` (`county_id`),
  ADD KEY `town_id` (`town_id`);

--
-- Indexes for table `su_user_roles`
--
ALTER TABLE `su_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_role` (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `su_visitors_logs`
--
ALTER TABLE `su_visitors_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `su_wishlists`
--
ALTER TABLE `su_wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product_variant` (`user_id`,`product_id`,`variant_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `su_abandoned_carts`
--
ALTER TABLE `su_abandoned_carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `su_abandoned_cart_logs`
--
ALTER TABLE `su_abandoned_cart_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `su_banners`
--
ALTER TABLE `su_banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_blog_categories`
--
ALTER TABLE `su_blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `su_blog_posts`
--
ALTER TABLE `su_blog_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `su_blog_tags`
--
ALTER TABLE `su_blog_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_brands`
--
ALTER TABLE `su_brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `su_carts`
--
ALTER TABLE `su_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `su_cart_items`
--
ALTER TABLE `su_cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `su_client_projects`
--
ALTER TABLE `su_client_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_client_testimonials`
--
ALTER TABLE `su_client_testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_contact_messages`
--
ALTER TABLE `su_contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_counties`
--
ALTER TABLE `su_counties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `su_countries`
--
ALTER TABLE `su_countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_customers`
--
ALTER TABLE `su_customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_customer_payment_preferences`
--
ALTER TABLE `su_customer_payment_preferences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_discounts`
--
ALTER TABLE `su_discounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_email_settings`
--
ALTER TABLE `su_email_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_faqs`
--
ALTER TABLE `su_faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `su_flash_sales`
--
ALTER TABLE `su_flash_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_income_expenses`
--
ALTER TABLE `su_income_expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_invoices`
--
ALTER TABLE `su_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_location_pricing`
--
ALTER TABLE `su_location_pricing`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_low_stock_alerts`
--
ALTER TABLE `su_low_stock_alerts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `su_loyalty_points`
--
ALTER TABLE `su_loyalty_points`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_loyalty_settings`
--
ALTER TABLE `su_loyalty_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_loyalty_tiers`
--
ALTER TABLE `su_loyalty_tiers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `su_loyalty_transactions`
--
ALTER TABLE `su_loyalty_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_media`
--
ALTER TABLE `su_media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=648;

--
-- AUTO_INCREMENT for table `su_newsletters`
--
ALTER TABLE `su_newsletters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_newsletter_subscribers`
--
ALTER TABLE `su_newsletter_subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_notifications`
--
ALTER TABLE `su_notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_orders`
--
ALTER TABLE `su_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `su_order_items`
--
ALTER TABLE `su_order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `su_order_loyalty`
--
ALTER TABLE `su_order_loyalty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_order_returns`
--
ALTER TABLE `su_order_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_order_status_history`
--
ALTER TABLE `su_order_status_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `su_pages`
--
ALTER TABLE `su_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `su_payments`
--
ALTER TABLE `su_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `su_payment_logs`
--
ALTER TABLE `su_payment_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_payment_methods`
--
ALTER TABLE `su_payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `su_pending_mpesa`
--
ALTER TABLE `su_pending_mpesa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_pending_pesapal`
--
ALTER TABLE `su_pending_pesapal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_pending_users`
--
ALTER TABLE `su_pending_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_permissions`
--
ALTER TABLE `su_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `su_products`
--
ALTER TABLE `su_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;

--
-- AUTO_INCREMENT for table `su_product_attributes`
--
ALTER TABLE `su_product_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=403;

--
-- AUTO_INCREMENT for table `su_product_attribute_values`
--
ALTER TABLE `su_product_attribute_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=643;

--
-- AUTO_INCREMENT for table `su_product_categories`
--
ALTER TABLE `su_product_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `su_product_labels`
--
ALTER TABLE `su_product_labels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `su_product_reviews`
--
ALTER TABLE `su_product_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_product_variants`
--
ALTER TABLE `su_product_variants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=441;

--
-- AUTO_INCREMENT for table `su_product_variant_attributes`
--
ALTER TABLE `su_product_variant_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=825;

--
-- AUTO_INCREMENT for table `su_quotations`
--
ALTER TABLE `su_quotations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `su_quotation_items`
--
ALTER TABLE `su_quotation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `su_referral_codes`
--
ALTER TABLE `su_referral_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_referral_events`
--
ALTER TABLE `su_referral_events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_roles`
--
ALTER TABLE `su_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `su_sessions`
--
ALTER TABLE `su_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_settings`
--
ALTER TABLE `su_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `su_shipping_expenses`
--
ALTER TABLE `su_shipping_expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_shipping_settings`
--
ALTER TABLE `su_shipping_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_support_tickets`
--
ALTER TABLE `su_support_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_support_ticket_replies`
--
ALTER TABLE `su_support_ticket_replies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_system_logs`
--
ALTER TABLE `su_system_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_system_messages`
--
ALTER TABLE `su_system_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_tax_settings`
--
ALTER TABLE `su_tax_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_towns`
--
ALTER TABLE `su_towns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `su_two_factor_authentications`
--
ALTER TABLE `su_two_factor_authentications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_users`
--
ALTER TABLE `su_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `su_user_devices`
--
ALTER TABLE `su_user_devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_user_messages`
--
ALTER TABLE `su_user_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_user_profiles`
--
ALTER TABLE `su_user_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `su_user_roles`
--
ALTER TABLE `su_user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `su_visitors_logs`
--
ALTER TABLE `su_visitors_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1175;

--
-- AUTO_INCREMENT for table `su_wishlists`
--
ALTER TABLE `su_wishlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `su_abandoned_carts`
--
ALTER TABLE `su_abandoned_carts`
  ADD CONSTRAINT `fk_abandoned_carts_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_abandoned_cart_logs`
--
ALTER TABLE `su_abandoned_cart_logs`
  ADD CONSTRAINT `fk_abandoned_logs_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_abandoned_logs_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_blog_posts`
--
ALTER TABLE `su_blog_posts`
  ADD CONSTRAINT `fk_blog_posts_author` FOREIGN KEY (`author_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_blog_posts_category` FOREIGN KEY (`category_id`) REFERENCES `su_blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_carts`
--
ALTER TABLE `su_carts`
  ADD CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_cart_items`
--
ALTER TABLE `su_cart_items`
  ADD CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `su_carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_items_variant` FOREIGN KEY (`variant_id`) REFERENCES `su_product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_counties`
--
ALTER TABLE `su_counties`
  ADD CONSTRAINT `fk_counties_country` FOREIGN KEY (`country_id`) REFERENCES `su_countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_customers`
--
ALTER TABLE `su_customers`
  ADD CONSTRAINT `fk_customers_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_customer_payment_preferences`
--
ALTER TABLE `su_customer_payment_preferences`
  ADD CONSTRAINT `fk_payment_prefs_method` FOREIGN KEY (`payment_method_id`) REFERENCES `su_payment_methods` (`id`),
  ADD CONSTRAINT `fk_payment_prefs_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_flash_sales`
--
ALTER TABLE `su_flash_sales`
  ADD CONSTRAINT `fk_flash_sales_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_invoices`
--
ALTER TABLE `su_invoices`
  ADD CONSTRAINT `fk_invoices_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`),
  ADD CONSTRAINT `fk_invoices_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`);

--
-- Constraints for table `su_location_pricing`
--
ALTER TABLE `su_location_pricing`
  ADD CONSTRAINT `fk_location_pricing_town` FOREIGN KEY (`town_id`) REFERENCES `su_towns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_low_stock_alerts`
--
ALTER TABLE `su_low_stock_alerts`
  ADD CONSTRAINT `fk_low_stock_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_low_stock_variant` FOREIGN KEY (`variant_id`) REFERENCES `su_product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_loyalty_points`
--
ALTER TABLE `su_loyalty_points`
  ADD CONSTRAINT `fk_loyalty_points_tier` FOREIGN KEY (`tier_id`) REFERENCES `su_loyalty_tiers` (`id`),
  ADD CONSTRAINT `fk_loyalty_points_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_loyalty_transactions`
--
ALTER TABLE `su_loyalty_transactions`
  ADD CONSTRAINT `fk_loyalty_transactions_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_loyalty_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_media`
--
ALTER TABLE `su_media`
  ADD CONSTRAINT `fk_media_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_media_variant` FOREIGN KEY (`variant_id`) REFERENCES `su_product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_notifications`
--
ALTER TABLE `su_notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_orders`
--
ALTER TABLE `su_orders`
  ADD CONSTRAINT `fk_orders_admin` FOREIGN KEY (`admin_confirmed_by`) REFERENCES `su_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_county` FOREIGN KEY (`shipping_county_id`) REFERENCES `su_counties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_town` FOREIGN KEY (`shipping_town_id`) REFERENCES `su_towns` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_order_items`
--
ALTER TABLE `su_order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`),
  ADD CONSTRAINT `fk_order_items_variant` FOREIGN KEY (`variant_id`) REFERENCES `su_product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_order_loyalty`
--
ALTER TABLE `su_order_loyalty`
  ADD CONSTRAINT `fk_order_loyalty_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_loyalty_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_order_returns`
--
ALTER TABLE `su_order_returns`
  ADD CONSTRAINT `fk_returns_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_returns_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`),
  ADD CONSTRAINT `fk_returns_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_order_status_history`
--
ALTER TABLE `su_order_status_history`
  ADD CONSTRAINT `fk_status_history_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_status_history_user` FOREIGN KEY (`changed_by`) REFERENCES `su_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_payments`
--
ALTER TABLE `su_payments`
  ADD CONSTRAINT `fk_payments_method` FOREIGN KEY (`method_id`) REFERENCES `su_payment_methods` (`id`),
  ADD CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`),
  ADD CONSTRAINT `fk_payments_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`);

--
-- Constraints for table `su_payment_logs`
--
ALTER TABLE `su_payment_logs`
  ADD CONSTRAINT `fk_payment_logs_payment` FOREIGN KEY (`payment_id`) REFERENCES `su_payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_post_tag`
--
ALTER TABLE `su_post_tag`
  ADD CONSTRAINT `fk_post_tag_post` FOREIGN KEY (`post_id`) REFERENCES `su_blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_tag_tag` FOREIGN KEY (`tag_id`) REFERENCES `su_blog_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_products`
--
ALTER TABLE `su_products`
  ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brand_id`) REFERENCES `su_brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `su_product_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_products_label` FOREIGN KEY (`label_id`) REFERENCES `su_product_labels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_product_attributes`
--
ALTER TABLE `su_product_attributes`
  ADD CONSTRAINT `fk_attributes_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_product_attribute_values`
--
ALTER TABLE `su_product_attribute_values`
  ADD CONSTRAINT `fk_attribute_values_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `su_product_attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_product_categories`
--
ALTER TABLE `su_product_categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `su_product_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_product_category`
--
ALTER TABLE `su_product_category`
  ADD CONSTRAINT `fk_product_category_category` FOREIGN KEY (`category_id`) REFERENCES `su_product_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_category_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_product_label`
--
ALTER TABLE `su_product_label`
  ADD CONSTRAINT `fk_product_label_label` FOREIGN KEY (`label_id`) REFERENCES `su_product_labels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_label_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_product_reviews`
--
ALTER TABLE `su_product_reviews`
  ADD CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_product_variants`
--
ALTER TABLE `su_product_variants`
  ADD CONSTRAINT `fk_variants_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_product_variant_attributes`
--
ALTER TABLE `su_product_variant_attributes`
  ADD CONSTRAINT `fk_variant_attributes_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `su_product_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_variant_attributes_value` FOREIGN KEY (`attribute_value_id`) REFERENCES `su_product_attribute_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_variant_attributes_variant` FOREIGN KEY (`variant_id`) REFERENCES `su_product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_quotations`
--
ALTER TABLE `su_quotations`
  ADD CONSTRAINT `fk_quotations_order` FOREIGN KEY (`converted_order_id`) REFERENCES `su_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_quotations_preparer` FOREIGN KEY (`prepared_by`) REFERENCES `su_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_quotations_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_quotation_items`
--
ALTER TABLE `su_quotation_items`
  ADD CONSTRAINT `fk_quotation_items_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_quotation_items_quotation` FOREIGN KEY (`quotation_id`) REFERENCES `su_quotations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quotation_items_variant` FOREIGN KEY (`variant_id`) REFERENCES `su_product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_referral_codes`
--
ALTER TABLE `su_referral_codes`
  ADD CONSTRAINT `fk_referral_codes_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_referral_events`
--
ALTER TABLE `su_referral_events`
  ADD CONSTRAINT `fk_referral_events_code` FOREIGN KEY (`referral_code_id`) REFERENCES `su_referral_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_referral_events_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_referral_events_referred` FOREIGN KEY (`referred_user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_referral_events_referrer` FOREIGN KEY (`referrer_user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_role_permissions`
--
ALTER TABLE `su_role_permissions`
  ADD CONSTRAINT `fk_role_permissions_permission` FOREIGN KEY (`permission_id`) REFERENCES `su_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_role_permissions_role` FOREIGN KEY (`role_id`) REFERENCES `su_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_sessions`
--
ALTER TABLE `su_sessions`
  ADD CONSTRAINT `fk_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_shipping_expenses`
--
ALTER TABLE `su_shipping_expenses`
  ADD CONSTRAINT `fk_shipping_expenses_order` FOREIGN KEY (`order_id`) REFERENCES `su_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_support_tickets`
--
ALTER TABLE `su_support_tickets`
  ADD CONSTRAINT `fk_tickets_admin` FOREIGN KEY (`assigned_admin_id`) REFERENCES `su_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_tickets_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_support_ticket_replies`
--
ALTER TABLE `su_support_ticket_replies`
  ADD CONSTRAINT `fk_ticket_replies_sender` FOREIGN KEY (`sender_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ticket_replies_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `su_support_tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_system_messages`
--
ALTER TABLE `su_system_messages`
  ADD CONSTRAINT `fk_system_messages_recipient` FOREIGN KEY (`recipient_id`) REFERENCES `su_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_system_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `su_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `su_towns`
--
ALTER TABLE `su_towns`
  ADD CONSTRAINT `fk_towns_county` FOREIGN KEY (`county_id`) REFERENCES `su_counties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_two_factor_authentications`
--
ALTER TABLE `su_two_factor_authentications`
  ADD CONSTRAINT `fk_two_factor_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_user_devices`
--
ALTER TABLE `su_user_devices`
  ADD CONSTRAINT `fk_user_devices_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_user_profiles`
--
ALTER TABLE `su_user_profiles`
  ADD CONSTRAINT `fk_user_profiles_country` FOREIGN KEY (`country_id`) REFERENCES `su_countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_profiles_county` FOREIGN KEY (`county_id`) REFERENCES `su_counties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_profiles_town` FOREIGN KEY (`town_id`) REFERENCES `su_towns` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_user_roles`
--
ALTER TABLE `su_user_roles`
  ADD CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `su_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `su_wishlists`
--
ALTER TABLE `su_wishlists`
  ADD CONSTRAINT `fk_wishlists_product` FOREIGN KEY (`product_id`) REFERENCES `su_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlists_user` FOREIGN KEY (`user_id`) REFERENCES `su_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlists_variant` FOREIGN KEY (`variant_id`) REFERENCES `su_product_variants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
