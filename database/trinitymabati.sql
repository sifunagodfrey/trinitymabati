-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2026 at 07:57 AM
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
(2, '2026_09_26_060639_add_default_uncategorized_product_category', 2);

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

--
-- Dumping data for table `su_abandoned_carts`
--

INSERT INTO `su_abandoned_carts` (`id`, `user_id`, `cart_data`, `last_updated`, `recovered`, `reminder_sent`, `created_at`) VALUES
(3, 2, '{\"total\":350,\"total_items\":1,\"items\":[{\"product_id\":109,\"product_name\":\"A4 Counter Book (4 Quire)\",\"quantity\":1,\"price\":350,\"subtotal\":350}]}', '2026-09-28 08:59:34', 0, 0, '2026-09-22 15:16:12'),
(5, 1, '{\"total\":1150,\"total_items\":8,\"items\":[{\"product_id\":98,\"product_name\":\"Blue Gel Pens\",\"quantity\":7,\"price\":100,\"subtotal\":700},{\"product_id\":95,\"product_name\":\"Desktop Calculator\",\"quantity\":1,\"price\":450,\"subtotal\":450}]}', '2026-09-26 09:03:49', 0, 0, '2026-09-25 16:27:36');

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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `su_contact_messages`
--

CREATE TABLE `su_contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `received_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `su_orders`
--

INSERT INTO `su_orders` (`id`, `user_id`, `order_code`, `status`, `payment_status`, `stock_deducted`, `subtotal`, `tax`, `shipping_cost`, `discount`, `total`, `currency`, `shipping_county_id`, `shipping_town_id`, `phone`, `shipping_status`, `expected_delivery`, `customer_confirmed`, `customer_confirmed_at`, `admin_confirmed`, `admin_confirmed_at`, `admin_confirmed_by`, `mpesa_checkout_request_id`, `pesapal_tracking_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 4, 'NAW00111000', 'cancelled', 'pending', 0, 0.00, 0.00, 150.00, 0.00, 8650.00, 'KES', 47, 48, '0758926969', 'pending', NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2026-09-18 14:19:53', '2026-09-18 14:43:20'),
(2, 4, 'NAW00111001', 'cancelled', 'pending', 1, 0.00, 0.00, 150.00, 0.00, 240.00, 'KES', 47, 48, '+254758926969', 'pending', NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2026-09-18 14:55:46', '2026-09-18 14:56:17'),
(3, 4, 'NAW00111002', 'cancelled', 'pending', 0, 0.00, 0.00, 150.00, 0.00, 200.00, 'KES', 47, 48, '+254758926969', 'pending', NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2026-09-18 15:00:43', '2026-09-18 12:01:09'),
(4, 4, 'NAW00111003', 'processing', 'pending', 1, 0.00, 0.00, 150.00, 0.00, 200.00, 'KES', 47, 48, '+254758926969', 'pending', NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2026-09-22 15:42:56', '2026-09-22 12:42:57');

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

--
-- Dumping data for table `su_order_items`
--

INSERT INTO `su_order_items` (`id`, `order_id`, `product_id`, `variant_id`, `product_name`, `variant_label`, `quantity`, `price`, `created_at`) VALUES
(1, 1, NULL, NULL, '12A Toner', NULL, 1, 8500.00, '2026-09-18 14:19:53'),
(2, 2, NULL, NULL, 'Push Pins Assorted Colors', NULL, 1, 90.00, '2026-09-18 14:55:46'),
(3, 3, NULL, NULL, 'Paper Clips Small', NULL, 1, 50.00, '2026-09-18 15:00:43'),
(4, 4, NULL, NULL, 'Paper Clips Small', NULL, 1, 50.00, '2026-09-22 15:42:56');

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

--
-- Dumping data for table `su_order_status_history`
--

INSERT INTO `su_order_status_history` (`id`, `order_id`, `status`, `note`, `changed_by`, `created_at`) VALUES
(1, 1, 'status:pending', 'Order placed', 4, '2026-09-18 14:19:53'),
(2, 1, 'status:cancelled', 'Order cancelled by the customer.', 4, '2026-09-18 14:43:20'),
(3, 2, 'status:pending', 'Order placed', 4, '2026-09-18 14:55:46'),
(4, 2, 'status:processing', 'Cash on delivery order confirmed', NULL, '2026-09-18 14:55:46'),
(5, 2, 'status:cancelled', 'Order cancelled by the customer.', 4, '2026-09-18 14:56:17'),
(6, 3, 'status:pending', 'Order placed', 4, '2026-09-18 15:00:43'),
(7, 3, 'status:processing', 'Cash on delivery order confirmed', NULL, '2026-09-18 15:00:43'),
(8, 3, 'status:cancelled', 'Order cancelled by the customer.', 4, '2026-09-18 15:01:09'),
(9, 4, 'status:pending', 'Order placed', 4, '2026-09-22 15:42:56'),
(10, 4, 'status:processing', 'Cash on delivery order confirmed', NULL, '2026-09-22 15:42:57');

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

--
-- Dumping data for table `su_payments`
--

INSERT INTO `su_payments` (`id`, `user_id`, `order_id`, `amount`, `method_id`, `status`, `reference`, `paid_at`, `created_at`) VALUES
(1, 4, 2, 240.00, 4, 'pending', 'COD-2', NULL, '2026-09-18 11:55:46'),
(2, 4, 3, 200.00, 4, 'pending', 'COD-3', NULL, '2026-09-18 12:00:43'),
(3, 4, 4, 200.00, 4, 'pending', 'COD-4', NULL, '2026-09-22 12:42:56');

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
  `category_id` int(10) UNSIGNED DEFAULT 17,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `su_products`
--
DELIMITER $$
CREATE TRIGGER `trg_su_products_default_category_insert` BEFORE INSERT ON `su_products` FOR EACH ROW BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (
                        SELECT id FROM su_product_categories WHERE slug = 'uncategorized' LIMIT 1
                    );
                END IF;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_su_products_default_category_update` BEFORE UPDATE ON `su_products` FOR EACH ROW BEGIN
                IF NEW.category_id IS NULL THEN
                    SET NEW.category_id = (
                        SELECT id FROM su_product_categories WHERE slug = 'uncategorized' LIMIT 1
                    );
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `su_product_categories`
--
DELIMITER $$
CREATE TRIGGER `trg_su_product_categories_protect_default` BEFORE DELETE ON `su_product_categories` FOR EACH ROW BEGIN
                IF OLD.slug = 'uncategorized' THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'The Uncategorized category cannot be deleted: it is the default fallback category for products.';
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

-- --------------------------------------------------------

--
-- Table structure for table `su_quotations`
--

CREATE TABLE `su_quotations` (
  `id` int(10) UNSIGNED NOT NULL,
  `quotation_code` varchar(50) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
(3, 'contact_email', 'support@finamax.co.ke', 'Public support email shown in the header, footer and contact page', '2026-09-18 03:10:33'),
(4, 'contact_phone', '0792829872', 'Public phone number shown in the header, footer and contact page', '2026-09-18 03:10:12'),
(5, 'contact_whatsapp', '254792829872', 'WhatsApp number in international format without a plus sign, used for wa.me links', '2026-09-18 03:10:12'),
(6, 'contact_address', 'Nairobi, Kenya', 'Physical location shown in the footer and contact page', '2026-09-17 05:42:36'),
(7, 'social_facebook', '', 'Facebook page URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(8, 'social_instagram', '', 'Instagram profile URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(9, 'social_twitter', '', 'X (Twitter) profile URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(10, 'social_tiktok', '', 'TikTok profile URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(11, 'social_youtube', '', 'YouTube channel URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(12, 'social_linkedin', '', 'LinkedIn page URL, leave blank to hide the icon', '2026-09-17 05:42:36'),
(13, 'whatsapp_default_message', 'Hello, I would like to know more about your products.', 'Pre-filled message for the floating WhatsApp button', '2026-09-17 05:42:36'),
(14, 'login_2fa_method', 'none', 'Customer login verification method: none, email or sms', '2026-09-17 05:42:36'),
(15, 'visitors_log_last_viewed_at', '2026-09-17 11:18:54', NULL, '2026-09-17 11:18:54'),
(16, 'primary_color', '#e71d06', NULL, '2026-10-13 05:23:37'),
(17, 'secondary_color', '#ff4938', NULL, '2026-10-13 05:23:37'),
(18, 'tertiary_color', '#2d3436', NULL, '2026-10-13 05:24:25'),
(19, 'logo_main', 'uploads/branding/logo_main-20261013082337-9afa0e.png', NULL, '2026-10-13 05:23:37'),
(20, 'site_icon', 'uploads/branding/site_icon-20261013082337-eb69e7.png', NULL, '2026-10-13 05:23:37'),
(21, 'apple_touch_icon', 'uploads/branding/apple_touch_icon-20261013082337-a8fb66.png', NULL, '2026-10-13 05:23:37'),
(22, 'logo_white', 'uploads/branding/logo_white-20261013084322-c937aa.png', NULL, '2026-10-13 05:43:22');

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
(610, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'http://localhost/trinitymabati', 'http://localhost/trinitymabati/blog', 'BTc7pCmngghVjJieHihn7T4t8ix1FRmwdXxZu8a1', 2, NULL, '2026-10-13 08:54:54');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `su_abandoned_carts`
--
ALTER TABLE `su_abandoned_carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `su_abandoned_cart_logs`
--
ALTER TABLE `su_abandoned_cart_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `su_contact_messages`
--
ALTER TABLE `su_contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `su_order_items`
--
ALTER TABLE `su_order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `su_pages`
--
ALTER TABLE `su_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `su_payments`
--
ALTER TABLE `su_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `su_product_attributes`
--
ALTER TABLE `su_product_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `su_product_attribute_values`
--
ALTER TABLE `su_product_attribute_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `su_product_categories`
--
ALTER TABLE `su_product_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `su_product_variant_attributes`
--
ALTER TABLE `su_product_variant_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `su_quotations`
--
ALTER TABLE `su_quotations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `su_quotation_items`
--
ALTER TABLE `su_quotation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=611;

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
