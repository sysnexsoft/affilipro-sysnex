-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 05:42 AM
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
-- Database: `affilipro_sysnex`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_clicks`
--

CREATE TABLE `affiliate_clicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `is_image` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `slug`, `status`, `is_image`, `created_at`, `updated_at`) VALUES
(1, 'Size', 'size', NULL, 0, '2025-11-22 10:53:11', '2025-11-22 10:56:25'),
(2, 'Color', 'color', NULL, 1, '2025-11-22 10:56:44', '2025-11-22 10:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_items`
--

CREATE TABLE `attribute_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_items`
--

INSERT INTO `attribute_items` (`id`, `attribute_id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'M', 'm', NULL, '2025-11-22 10:53:44', '2025-11-22 10:53:44'),
(2, 1, 'L', 'l', NULL, '2025-11-22 10:53:50', '2025-11-22 10:53:50'),
(3, 1, 'XL', 'xl', NULL, '2025-11-22 10:56:03', '2025-11-22 10:56:03'),
(4, 2, 'Red', 'red', NULL, '2025-11-22 10:56:55', '2025-11-22 10:56:55'),
(5, 2, 'Green', 'green', NULL, '2025-11-22 10:57:03', '2025-11-22 10:57:03'),
(6, 2, 'White', 'white', NULL, '2025-11-22 10:57:13', '2025-11-22 10:57:13'),
(7, 2, 'Yellow', 'yellow', NULL, '2025-11-22 10:57:20', '2025-11-22 10:57:20'),
(10, 1, 's', NULL, NULL, '2025-11-24 11:56:27', '2025-11-24 11:56:27');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `description`, `thumbnail`, `category_id`, `views`, `featured`, `status`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `created_at`, `updated_at`) VALUES
(1, 'Test Test', 'test-test', '<p>TEsar sada Asd sad sad sad</p>', 'uploads/blogs/thumbnails/m3DOUDbAiP_1781871206.png', 2, 0, 1, 1, 'Plot Size: 5 Katha Plot Orientation: South Facing [Corner Plot] Buil', 'TEst Tst', 'TEst Tst', 'https://www.amazon.com/dp/B09XS7JWHH?tag=your-affiliate-id', '2026-06-19 06:13:27', '2026-06-19 06:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gadget', 'gadget', 'New Test Test', 1, '2026-06-19 05:51:11', '2026-06-19 06:11:17'),
(2, 'Electronics', 'electronics', 'test', 1, '2026-06-19 06:11:39', '2026-06-19 06:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `website`, `status`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Hayfa Clay', 'hayfa-clay', NULL, 'Tempor non magni vel', 'https://www.bawikysa.biz', 1, 'Est ab iure veniam', 'Nemo et culpa aut as', '2026-06-13 09:51:20', '2026-06-13 10:31:35');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `image`, `parent_id`, `position`, `featured`, `status`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', 'sad sad asdwa', NULL, 'uploads/category/EldgaX80Gj_1781880802.webp', NULL, 0, 0, 1, 'Ratna Enterprise | Premium Real Estate & Property Developer in Bangladesh', 'Ratna Enterprise | Premium Real Estate & Property Developer in Bangladesh', 'Ratna Enterprise | Premium Real Estate & Property Developer in Bangladesh', '2026-06-10 11:37:02', '2026-06-19 14:53:22'),
(2, 'Gadget', 'gadget', NULL, NULL, 'uploads/category/RbeiGTl1bO_1781880786.webp', NULL, 0, 1, 1, NULL, NULL, NULL, '2026-06-19 00:52:19', '2026-06-19 14:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `category_comparison_fields`
--

CREATE TABLE `category_comparison_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `comparison_field_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_comparison_fields`
--

INSERT INTO `category_comparison_fields` (`id`, `category_id`, `comparison_field_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 1, 1, NULL, NULL),
(4, 1, 3, NULL, NULL),
(5, 2, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `click_logs`
--

CREATE TABLE `click_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT 'Unknown',
  `device` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `click_logs`
--

INSERT INTO `click_logs` (`id`, `url`, `ip_address`, `country`, `device`, `browser`, `referrer`, `created_at`, `updated_at`) VALUES
(1, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', 'Direct Visit', '2026-06-19 06:46:10', '2026-06-19 06:46:10'),
(2, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 06:46:20', '2026-06-19 06:46:20'),
(3, 'http://127.0.0.1:8000/compare', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 06:46:22', '2026-06-19 06:46:22'),
(4, 'http://127.0.0.1:8000/categories', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 06:46:23', '2026-06-19 06:46:23'),
(5, 'http://127.0.0.1:8000/review', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 06:46:24', '2026-06-19 06:46:24'),
(6, 'http://127.0.0.1:8000/blogs', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 06:46:25', '2026-06-19 06:46:25'),
(7, 'http://127.0.0.1:8000/compare', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 06:46:30', '2026-06-19 06:46:30'),
(8, 'http://127.0.0.1:8000/contact-us', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 06:51:25', '2026-06-19 06:51:25'),
(9, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 12:56:47', '2026-06-19 12:56:47'),
(10, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 13:01:15', '2026-06-19 13:01:15'),
(11, 'http://127.0.0.1:8000', '127.0.0.1', 'Myanmar', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 13:59:54', '2026-06-19 13:59:54'),
(12, 'http://127.0.0.1:8000/compare', '127.0.0.1', NULL, 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:00:04', '2026-06-19 14:00:04'),
(13, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Myanmar', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:00:05', '2026-06-19 14:00:05'),
(14, 'http://127.0.0.1:8000/contact-us', '127.0.0.1', 'Myanmar', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:00:15', '2026-06-19 14:00:15'),
(15, 'http://127.0.0.1:8000', '127.0.0.1', 'Myanmar', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:00:32', '2026-06-19 14:00:32'),
(16, 'http://127.0.0.1:8000', '127.0.0.1', 'Myanmar', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:00:50', '2026-06-19 14:00:50'),
(17, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Myanmar', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:00:55', '2026-06-19 14:00:55'),
(18, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:02:24', '2026-06-19 14:02:24'),
(19, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:02:48', '2026-06-19 14:02:48'),
(20, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:06:11', '2026-06-19 14:06:11'),
(21, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:06:30', '2026-06-19 14:06:30'),
(22, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:07:02', '2026-06-19 14:07:02'),
(23, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:08:37', '2026-06-19 14:08:37'),
(24, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:09:41', '2026-06-19 14:09:41'),
(25, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:10:52', '2026-06-19 14:10:52'),
(26, 'http://127.0.0.1:8000/?search=nahid.prodevs%40gmail.com', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:11:55', '2026-06-19 14:11:55'),
(27, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:11:59', '2026-06-19 14:11:59'),
(28, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:12:45', '2026-06-19 14:12:45'),
(29, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:13:00', '2026-06-19 14:13:00'),
(30, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:13:18', '2026-06-19 14:13:18'),
(31, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:13:38', '2026-06-19 14:13:38'),
(32, 'http://127.0.0.1:8000/compare', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:13:44', '2026-06-19 14:13:44'),
(33, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:13:46', '2026-06-19 14:13:46'),
(34, 'http://127.0.0.1:8000/blogs', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:14:00', '2026-06-19 14:14:00'),
(35, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:14:05', '2026-06-19 14:14:05'),
(36, 'http://127.0.0.1:8000/blogs', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:14:26', '2026-06-19 14:14:26'),
(37, 'http://127.0.0.1:8000/blogs', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:14:48', '2026-06-19 14:14:48'),
(38, 'http://127.0.0.1:8000/blogs', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:22:04', '2026-06-19 14:22:04'),
(39, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:22:06', '2026-06-19 14:22:06'),
(40, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:22:27', '2026-06-19 14:22:27'),
(41, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:29:14', '2026-06-19 14:29:14'),
(42, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:29:19', '2026-06-19 14:29:19'),
(43, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:29:55', '2026-06-19 14:29:55'),
(44, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:30:28', '2026-06-19 14:30:28'),
(45, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:30:57', '2026-06-19 14:30:57'),
(46, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:31:06', '2026-06-19 14:31:06'),
(47, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:31:32', '2026-06-19 14:31:32'),
(48, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:32:09', '2026-06-19 14:32:09'),
(49, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:32:13', '2026-06-19 14:32:13'),
(50, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:32:26', '2026-06-19 14:32:26'),
(51, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:33:06', '2026-06-19 14:33:06'),
(52, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:33:22', '2026-06-19 14:33:22'),
(53, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:39:07', '2026-06-19 14:39:07'),
(54, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:39:12', '2026-06-19 14:39:12'),
(55, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:39:28', '2026-06-19 14:39:28'),
(56, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:39:44', '2026-06-19 14:39:44'),
(57, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:39:59', '2026-06-19 14:39:59'),
(58, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:40:36', '2026-06-19 14:40:36'),
(59, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:40:38', '2026-06-19 14:40:38'),
(60, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:40:51', '2026-06-19 14:40:51'),
(61, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:41:13', '2026-06-19 14:41:13'),
(62, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:41:20', '2026-06-19 14:41:20'),
(63, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:41:22', '2026-06-19 14:41:22'),
(64, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:41:56', '2026-06-19 14:41:56'),
(65, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:42:11', '2026-06-19 14:42:11'),
(66, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:42:19', '2026-06-19 14:42:19'),
(67, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:42:28', '2026-06-19 14:42:28'),
(68, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:42:42', '2026-06-19 14:42:42'),
(69, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:43:23', '2026-06-19 14:43:23'),
(70, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:43:26', '2026-06-19 14:43:26'),
(71, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:44:50', '2026-06-19 14:44:50'),
(72, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:44:55', '2026-06-19 14:44:55'),
(73, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:45:33', '2026-06-19 14:45:33'),
(74, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:45:45', '2026-06-19 14:45:45'),
(75, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:46:01', '2026-06-19 14:46:01'),
(76, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:46:43', '2026-06-19 14:46:43'),
(77, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:47:03', '2026-06-19 14:47:03'),
(78, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:47:28', '2026-06-19 14:47:28'),
(79, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:47:28', '2026-06-19 14:47:28'),
(80, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:47:59', '2026-06-19 14:47:59'),
(81, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:47:59', '2026-06-19 14:47:59'),
(82, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:48:00', '2026-06-19 14:48:00'),
(83, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:48:55', '2026-06-19 14:48:55'),
(84, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:49:13', '2026-06-19 14:49:13'),
(85, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 14:53:50', '2026-06-19 14:53:50'),
(86, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:54:18', '2026-06-19 14:54:18'),
(87, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:54:31', '2026-06-19 14:54:31'),
(88, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:54:37', '2026-06-19 14:54:37'),
(89, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:54:49', '2026-06-19 14:54:49'),
(90, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:55:01', '2026-06-19 14:55:01'),
(91, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:55:08', '2026-06-19 14:55:08'),
(92, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:55:22', '2026-06-19 14:55:22'),
(93, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:56:07', '2026-06-19 14:56:07'),
(94, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:56:36', '2026-06-19 14:56:36'),
(95, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:57:02', '2026-06-19 14:57:02'),
(96, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:57:54', '2026-06-19 14:57:54'),
(97, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:58:11', '2026-06-19 14:58:11'),
(98, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:59:14', '2026-06-19 14:59:14'),
(99, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:59:24', '2026-06-19 14:59:24'),
(100, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:59:33', '2026-06-19 14:59:33'),
(101, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 14:59:55', '2026-06-19 14:59:55'),
(102, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:00:20', '2026-06-19 15:00:20'),
(103, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:00:25', '2026-06-19 15:00:25'),
(104, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:01:37', '2026-06-19 15:01:37'),
(105, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:01:50', '2026-06-19 15:01:50'),
(106, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:02:13', '2026-06-19 15:02:13'),
(107, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:02:53', '2026-06-19 15:02:53'),
(108, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:03:31', '2026-06-19 15:03:31'),
(109, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:03:45', '2026-06-19 15:03:45'),
(110, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:04:19', '2026-06-19 15:04:19'),
(111, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:04:28', '2026-06-19 15:04:28'),
(112, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:07:36', '2026-06-19 15:07:36'),
(113, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:08:48', '2026-06-19 15:08:48'),
(114, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:09:04', '2026-06-19 15:09:04'),
(115, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:09:16', '2026-06-19 15:09:16'),
(116, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Mobile', 'Chrome', '127.0.0.1', '2026-06-19 15:09:50', '2026-06-19 15:09:50'),
(117, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:10:01', '2026-06-19 15:10:01'),
(118, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:10:27', '2026-06-19 15:10:27'),
(119, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:10:40', '2026-06-19 15:10:40'),
(120, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:11:01', '2026-06-19 15:11:01'),
(121, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:11:36', '2026-06-19 15:11:36'),
(122, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:12:52', '2026-06-19 15:12:52'),
(123, 'http://127.0.0.1:8000/product', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:12:54', '2026-06-19 15:12:54'),
(124, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:12:56', '2026-06-19 15:12:56'),
(125, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:12:58', '2026-06-19 15:12:58'),
(126, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:13:01', '2026-06-19 15:13:01'),
(127, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:15:59', '2026-06-19 15:15:59'),
(128, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:16:26', '2026-06-19 15:16:26'),
(129, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:16:32', '2026-06-19 15:16:32'),
(130, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:19:13', '2026-06-19 15:19:13'),
(131, 'http://127.0.0.1:8000/product/apple-2024-macbook-air-13-inch-laptop-with-m3-chip', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:19:16', '2026-06-19 15:19:16'),
(132, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', 'Direct Visit', '2026-06-19 15:20:49', '2026-06-19 15:20:49'),
(133, 'http://127.0.0.1:8000', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', 'Direct Visit', '2026-06-19 15:22:10', '2026-06-19 15:22:10'),
(134, 'http://127.0.0.1:8000/product/apple-2024-macbook-air-13-inch-laptop-with-m3-chip', '127.0.0.1', 'Bangladesh', 'Desktop', 'Chrome', '127.0.0.1', '2026-06-19 15:22:13', '2026-06-19 15:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `comparison_fields`
--

CREATE TABLE `comparison_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comparison_fields`
--

INSERT INTO `comparison_fields` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Ram', 'ram', '2026-06-19 02:30:21', '2026-06-19 02:30:21'),
(2, 'Rom', 'rom', '2026-06-19 02:34:43', '2026-06-19 02:34:43'),
(3, 'Type', 'type', '2026-06-19 02:53:13', '2026-06-19 02:53:13'),
(4, 'Battery Health', 'battery-health', '2026-06-19 02:53:30', '2026-06-19 02:53:30');

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
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT '1=800x800, 2=180x180, 3=1110x280',
  `file_original_name` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `type`, `file_original_name`, `file_url`, `user_id`, `created_at`, `updated_at`) VALUES
(29, '1', 'Girl Premium Frock - Merina', 'uploads/products/692496851533a_1000x1000.webp', 1, '2025-11-24 11:31:49', '2025-11-24 11:31:49'),
(30, '1', 'Girl Premium Frock - Anzarna', 'uploads/products/6924968579d73_1000x1000.webp', 1, '2025-11-24 11:31:49', '2025-11-24 11:31:49'),
(31, '1', 'Girl Premium Frock - Merina', 'uploads/products/69249685d7d3b_1000x1000.webp', 1, '2025-11-24 11:31:50', '2025-11-24 11:31:50'),
(32, '1', 'Kids Premium Jacket - Playard', 'uploads/products/692496864a7df_1000x1000.webp', 1, '2025-11-24 11:31:51', '2025-11-24 11:31:51'),
(33, '1', 'Girl Premium Frock - Merina', 'uploads/products/6924968736293_1000x1000.webp', 1, '2025-11-24 11:31:51', '2025-11-24 11:31:51'),
(34, '1', 'Kids Premium Jacket - Playard', 'uploads/products/6924968797d96_1000x1000.webp', 1, '2025-11-24 11:31:52', '2025-11-24 11:31:52'),
(35, '1', 'Girl Premium Frock - Merina', 'uploads/products/692496887c820_1000x1000.webp', 1, '2025-11-24 11:31:52', '2025-11-24 11:31:52'),
(36, '1', 'Kids Premium Jacket - Playard', 'uploads/products/69249688db8dd_1000x1000.webp', 1, '2025-11-24 11:31:53', '2025-11-24 11:31:53'),
(37, '1', 'Girl Premium Frock - Merina', 'uploads/products/69249689bc846_1000x1000.webp', 1, '2025-11-24 11:31:54', '2025-11-24 11:31:54');

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
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(15, '2019_08_19_000000_create_failed_jobs_table', 1),
(16, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(17, '2025_11_17_180450_create_permission_tables', 1),
(18, '2025_11_18_155218_create_web_settings_table', 1),
(20, '2025_11_22_074100_create_categories_table', 2),
(21, '2025_11_22_163245_create_attributes_table', 3),
(22, '2025_11_22_163341_create_attribute_items_table', 3),
(23, '2025_11_22_073157_create_products_table', 4),
(24, '2025_11_23_175823_create_media_table', 5),
(25, '2025_11_24_170750_create_product_variants_table', 6),
(26, '2025_11_24_170846_create_product_variant_items_table', 6),
(27, '2025_11_24_173056_create_category_products_table', 7),
(28, '2026_06_10_161053_create_categories_table', 8),
(29, '2026_06_10_161307_create_brands_table', 8),
(31, '2026_06_10_161436_create_product_images_table', 8),
(32, '2026_06_10_161539_create_product_specifications_table', 8),
(33, '2026_06_10_161619_create_product_reviews_table', 8),
(34, '2026_06_10_161655_create_product_faqs_table', 8),
(35, '2026_06_10_161740_create_affiliate_clicks_table', 8),
(36, '2026_06_10_161814_create_blogs_table', 8),
(37, '2026_06_10_161857_create_blog_categories_table', 8),
(38, '2026_06_10_161355_create_products_table', 9),
(41, '2026_06_19_082126_create_comparison_fields_table', 10),
(42, '2026_06_19_082218_create_category_comparison_fields_table', 10),
(43, '2026_06_19_123641_create_click_logs_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(2, 'role.permission', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(3, 'role.permission.create', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(4, 'role.permission.store', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(5, 'role.permission.edit', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(6, 'role.permission.update', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(7, 'role.permission.delete', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(8, 'profile', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(9, 'setting', 'web', '2025-11-19 11:29:58', '2025-11-19 11:29:58'),
(10, 'reset.password', 'web', '2025-11-19 11:29:58', '2025-11-19 11:29:58'),
(11, 'user.list', 'web', '2025-11-19 11:29:58', '2025-11-19 11:29:58'),
(12, 'user.store', 'web', '2025-11-19 11:29:58', '2025-11-19 11:29:58'),
(13, 'user.update', 'web', '2025-11-19 11:29:58', '2025-11-19 11:29:58'),
(14, 'user.delete', 'web', '2025-11-19 11:29:58', '2025-11-19 11:29:58'),
(15, 'category.index', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(16, 'category.store', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(17, 'category.update', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(18, 'category.delete', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(19, 'product.index', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(20, 'product.create', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(21, 'product.store', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(22, 'product.edit', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(23, 'product.update', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(24, 'product.delete', 'web', '2025-11-22 09:45:20', '2025-11-22 09:45:20'),
(25, 'attribute.index', 'web', '2025-11-22 10:50:31', '2025-11-22 10:50:31'),
(26, 'attribute.store', 'web', '2025-11-22 10:50:31', '2025-11-22 10:50:31'),
(27, 'attribute.update', 'web', '2025-11-22 10:50:31', '2025-11-22 10:50:31'),
(28, 'attribute.delete', 'web', '2025-11-22 10:50:31', '2025-11-22 10:50:31'),
(29, 'attribute.item.store', 'web', '2025-11-22 10:50:31', '2025-11-22 10:50:31'),
(30, 'attribute.item.update', 'web', '2025-11-22 10:50:31', '2025-11-22 10:50:31'),
(31, 'attribute.item.delete', 'web', '2025-11-22 10:50:31', '2025-11-22 10:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`category_ids`)),
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `short_description` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `pros` longtext DEFAULT NULL,
  `cons` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `gallery` varchar(255) DEFAULT NULL,
  `regular_price` decimal(12,2) DEFAULT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `review_count` int(11) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `click_count` int(11) NOT NULL DEFAULT 0,
  `affiliate_url` varchar(255) DEFAULT NULL,
  `affiliate_network` varchar(255) DEFAULT NULL,
  `commission_rate` decimal(8,2) DEFAULT NULL,
  `allow_compare` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `trending` tinyint(1) NOT NULL DEFAULT 0,
  `best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `editors_choice` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_ids`, `brand_id`, `title`, `slug`, `sku`, `short_description`, `description`, `pros`, `cons`, `featured_image`, `gallery`, `regular_price`, `sale_price`, `rating`, `review_count`, `view_count`, `click_count`, `affiliate_url`, `affiliate_network`, `commission_rate`, `allow_compare`, `featured`, `trending`, `best_seller`, `editors_choice`, `status`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `created_at`, `updated_at`) VALUES
(3, '[\"1\"]', NULL, 'Sony WH-1000XM5 Wireless Noise Canceling Headphones', 'sony-wh-1000xm5-wireless-noise-canceling-headphones', NULL, NULL, 'The Sony WH-1000XM5 headphones rewrite the rules for distraction-free listening. Two processors control 8 microphones for unprecedented noise cancellation and exceptional call quality. With a newly developed driver, featuring Hi-Res Audio wireless, these headphones deliver audiophile-grade performance.', 'Unmatched active noise cancellation (ANC).\r\nSuper comfortable lightweight design.\r\nExceptional 30-hour battery life with fast charging.', 'Does not fold into a compact size like older models.\r\nExpensive price tag.', 'uploads/products/thumbnails/WikxAaRrvp_1781856193.webp', NULL, 399.00, 348.00, 0.00, 0, 0, 0, 'https://www.amazon.com/dp/B09XS7JWHH?tag=your-affiliate-id', 'Amazon', NULL, 1, 1, 1, 0, 0, 1, NULL, NULL, NULL, NULL, '2026-06-19 01:01:31', '2026-06-19 02:03:14'),
(4, '[\"2\"]', 1, 'Apple 2024 MacBook Air 13-inch Laptop with M3 Chip', 'apple-2024-macbook-air-13-inch-laptop-with-m3-chip', NULL, 'The ultimate everyday laptop gets even better with the blazing-fast M3 chip, a liquid retina display, and up to 18 hours of battery life.', 'Strikingly thin and fast, the MacBook Air with the M3 chip is built for work and play. With a powerful 8-core CPU and up to 10-core GPU, multitasking is a breeze. It features a fanless design, meaning it runs completely silent even under heavy workloads.', 'Incredible performance from the M3 Apple Silicon.\r\n\r\nSilent, fanless thermal design.\r\n\r\nSupport for dual external displays (with laptop lid closed).', 'Base model still starts with only 8GB of RAM.\r\n\r\nStorage upgrades are very costly.', 'uploads/products/thumbnails/AJdO4uoVEi_1781856147.jpg', NULL, 1099.00, 999.00, 0.00, 0, 0, 0, 'https://www.amazon.com/dp/B0CX219Y39?tag=your-affiliate-id', 'Amazon', 3.00, 1, 1, 1, 1, 1, 1, '1', '1', '1', '1', '2026-06-19 01:22:25', '2026-06-19 02:02:27'),
(5, '[\"1\"]', 1, 'Anker Soundcore Motion X600 Portable Hi-Res Speaker', 'anker-soundcore-motion-x600-portable-hi-res-speaker', NULL, 'World\'s first portable high-fidelity spatial audio speaker with 50W output and IPX7 waterproof protection.', 'Inspired by theater acoustics, Motion X600 has 5 drivers and 3 amplifiers that are positioned to deliver sound all around you. Feel the music come alive with immersive spatial audio that fills any room or outdoor gathering.', 'Stunning spatial audio effect and crisp vocals.\r\n\r\nPremium aluminum design with a built-in handle.\r\n\r\nIPX7 fully waterproof rating.', 'Battery life drops significantly at high volume with Spatial Audio turned on.\r\n\r\nThe handle is fixed and cannot be removed.', 'uploads/products/thumbnails/YbtusZzfx4_1781854094.webp', NULL, 199.99, 169.99, 0.00, 0, 0, 0, 'https://www.aliexpress.com/item/100500552312.html', 'AliExpress', 7.00, 1, 1, 1, 1, 1, 1, '1', '1', '1', '1', '2026-06-19 01:28:14', '2026-06-19 01:28:14'),
(6, '[\"2\"]', 1, 'Logitech MX Master 3S Wireless Performance Mouse', 'logitech-mx-master-3s-wireless-performance-mouse', NULL, 'An iconic ergonomic mouse remastered with 8K DPI tracking, quiet clicks, and the ultra-fast MagSpeed scrolling wheel.', 'Meet MX Master 3S – an iconic mouse remastered. Feel every moment of your workflow with even more precision, tactility, and performance, thanks to Quiet Clicks and an 8,000 DPI track-on-glass sensor. It is the ultimate mouse for creators, coders, and office professionals.', 'Extremely comfortable ergonomic grip for long working hours.\r\n\r\nQuiet clicks reduce 90% of click noise.\r\n\r\nMagSpeed wheel can scroll 1,000 lines in a single second.', 'Designed strictly for right-handed users.\r\n\r\nLarge and heavy, not ideal for frequent travel or gaming.', 'uploads/products/thumbnails/xUi05ELq4E_1781854366.webp', NULL, 99.99, 89.99, 0.00, 0, 0, 0, 'https://www.amazon.com/dp/B09HM94V6G?tag=your-affiliate-id', 'Amazon', 4.00, 0, 0, 0, 0, 0, 1, 'Logitech MX Master 3S Wireless Performance Mouse', 'Logitech MX Master 3S Wireless Performance Mouse', 'Logitech MX Master 3S Wireless Performance Mouse', 'https://www.amazon.com/dp/B09XS7JWHH?tag=your-affiliate-id', '2026-06-19 01:32:46', '2026-06-19 02:48:25'),
(7, '[\"1\"]', 1, 'Test', 'test', '4585695', 'sad wa dad', '<p>a dsd wad a</p>', '<p>sa sad&nbsp;</p>', '<p>ad wa d</p>', 'uploads/products/thumbnails/2I2zakWmxX_1781859022.png', NULL, 600.00, 500.00, 0.00, 0, 0, 0, 'https://www.amazon.com/dp/B09HM94V6G?tag=your-affiliate-id', 'Amazon', 5.00, 1, 1, 1, 1, 1, 1, '1', '1', '1', '1', '2026-06-19 02:50:23', '2026-06-19 02:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `product_faqs`
--

CREATE TABLE `product_faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_faqs`
--

INSERT INTO `product_faqs` (`id`, `product_id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(5, 5, 'Is there an equalizer app available?', 'Yes, you can download the Soundcore App to fully customize the 9-band EQ settings.', '2026-06-19 01:28:14', '2026-06-19 01:28:14'),
(6, 5, 'Can I pair two X600 speakers together?', 'Yes, it supports True Wireless Stereo (TWS) pairing for full left and right channel separation.', '2026-06-19 01:28:14', '2026-06-19 01:28:14'),
(21, 4, 'Does this laptop have a cooling fan?', 'No, the MacBook Air M3 uses passive cooling and is 100% silent.', '2026-06-19 02:02:29', '2026-06-19 02:02:29'),
(22, 4, 'Can I play heavy games on it?', 'It handles casual and Apple Arcade games perfectly, but it is not a dedicated AAA gaming laptop.', '2026-06-19 02:02:29', '2026-06-19 02:02:29'),
(25, 3, 'Can it connect to two devices simultaneously?', 'Yes, it supports multipoint connection, allowing you to switch between phone and laptop smoothly.', '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(26, 3, 'Is it water-resistant?', 'No, the WH-1000XM5 does not have an official IPX rating, so keep it away from heavy rain or sweat.', '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(27, 6, 'How long does the battery last on a full charge?', 'It stays powered for up to 70 days on a full charge, and a 1-minute quick charge gives 3 hours of use.', '2026-06-19 02:48:25', '2026-06-19 02:48:25'),
(28, 6, 'Does it work with Mac and Windows together?', 'Yes, with Logitech Flow, you can move your cursor and even copy-paste files seamlessly across 3 computers.', '2026-06-19 02:48:25', '2026-06-19 02:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `position`, `created_at`, `updated_at`) VALUES
(1, 6, 'uploads/products/gallery/CWhMFksvpL_1781854366.webp', 0, '2026-06-19 01:32:46', '2026-06-19 01:32:46'),
(2, 6, 'uploads/products/gallery/Vzg7xLhKnK_1781854366.webp', 1, '2026-06-19 01:32:46', '2026-06-19 01:32:46'),
(3, 6, 'uploads/products/gallery/LKgQfTS1f7_1781854366.webp', 2, '2026-06-19 01:32:46', '2026-06-19 01:32:46'),
(5, 6, 'uploads/products/gallery/gzLQOEKHjN_1781855829.jpg', 3, '2026-06-19 01:57:09', '2026-06-19 01:57:09'),
(6, 6, 'uploads/products/gallery/oNAdcScncO_1781855829.jpg', 4, '2026-06-19 01:57:09', '2026-06-19 01:57:09'),
(7, 6, 'uploads/products/gallery/mTeZAUDPRf_1781855829.jpg', 5, '2026-06-19 01:57:09', '2026-06-19 01:57:09'),
(8, 4, 'uploads/products/gallery/t29j7J5Z13_1781856147.jpg', 0, '2026-06-19 02:02:27', '2026-06-19 02:02:27'),
(9, 4, 'uploads/products/gallery/r2wPKkTTZ7_1781856147.jpg', 1, '2026-06-19 02:02:27', '2026-06-19 02:02:27'),
(10, 4, 'uploads/products/gallery/eVu368qZDN_1781856147.jpg', 2, '2026-06-19 02:02:27', '2026-06-19 02:02:27'),
(11, 4, 'uploads/products/gallery/fXLgwgTTTy_1781856147.jpg', 3, '2026-06-19 02:02:27', '2026-06-19 02:02:27'),
(12, 4, 'uploads/products/gallery/pbL5J6gzf5_1781856147.jpg', 4, '2026-06-19 02:02:27', '2026-06-19 02:02:27'),
(13, 4, 'uploads/products/gallery/TiQ87m0rZ6_1781856147.jpg', 5, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(14, 4, 'uploads/products/gallery/djeSXT7Cpf_1781856148.jpg', 6, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(15, 4, 'uploads/products/gallery/vxjqsQvIGH_1781856148.jpg', 7, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(16, 4, 'uploads/products/gallery/sN324GSncO_1781856148.jpg', 8, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(17, 4, 'uploads/products/gallery/IQJQYq8XVz_1781856148.jpg', 9, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(18, 4, 'uploads/products/gallery/kdcaley8lo_1781856148.jpg', 10, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(19, 4, 'uploads/products/gallery/4lNQg5Kvd0_1781856148.jpeg', 11, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(20, 4, 'uploads/products/gallery/6x2zAgswez_1781856148.jpg', 12, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(21, 4, 'uploads/products/gallery/pA6T32Jaag_1781856148.jpg', 13, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(22, 4, 'uploads/products/gallery/8OpOyHHkuj_1781856148.jpg', 14, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(23, 4, 'uploads/products/gallery/EvzJHyrrDy_1781856148.jpg', 15, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(24, 4, 'uploads/products/gallery/tTmohlShOT_1781856148.jpg', 16, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(25, 4, 'uploads/products/gallery/6DrorhtTEb_1781856148.jpg', 17, '2026-06-19 02:02:28', '2026-06-19 02:02:28'),
(26, 4, 'uploads/products/gallery/kTAPqYt97y_1781856148.jpg', 18, '2026-06-19 02:02:29', '2026-06-19 02:02:29'),
(27, 3, 'uploads/products/gallery/XyNElCQvxU_1781856194.webp', 0, '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(28, 3, 'uploads/products/gallery/OvyFU8zcCO_1781856194.webp', 1, '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(29, 3, 'uploads/products/gallery/OIyC6zBluI_1781856194.webp', 2, '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(30, 3, 'uploads/products/gallery/3ge4fbKDYz_1781856194.webp', 3, '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(31, 3, 'uploads/products/gallery/GgQPqBdbiW_1781856194.webp', 4, '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(32, 3, 'uploads/products/gallery/0iRkD9Q0TT_1781856194.webp', 5, '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(33, 7, 'uploads/products/gallery/v98ovk4Yo1_1781859023.png', 0, '2026-06-19 02:50:24', '2026-06-19 02:50:24'),
(34, 7, 'uploads/products/gallery/cdBUVVFTwq_1781859024.png', 1, '2026-06-19 02:50:24', '2026-06-19 02:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `name`, `email`, `rating`, `review`, `approved`, `created_at`, `updated_at`) VALUES
(1, 4, 'Reliable Plumbing Services You Can Trust', 'nahid.prodevs@gmail.com', 5, 'Reliable Plumbing Services You Can Trust', 1, '2026-06-19 06:30:17', '2026-06-19 06:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_specifications`
--

CREATE TABLE `product_specifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `spec_name` varchar(255) NOT NULL,
  `spec_value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `spec_name`, `spec_value`, `created_at`, `updated_at`) VALUES
(9, 5, 'Audio Output', '50 Watts', '2026-06-19 01:28:14', '2026-06-19 01:28:14'),
(10, 5, 'Waterproof Rating', 'IPX7', '2026-06-19 01:28:14', '2026-06-19 01:28:14'),
(11, 5, 'Playtime', 'Up to 12 Hours', '2026-06-19 01:28:14', '2026-06-19 01:28:14'),
(12, 5, 'Audio Tech', 'Hi-Res Wireless, LDAC Support', '2026-06-19 01:28:14', '2026-06-19 01:28:14'),
(41, 4, 'Processor', 'Apple M3 Chip', '2026-06-19 02:02:29', '2026-06-19 02:02:29'),
(42, 4, 'RAM', '8GB Unified Memory', '2026-06-19 02:02:29', '2026-06-19 02:02:29'),
(43, 4, 'Storage', '256GB SSD', '2026-06-19 02:02:29', '2026-06-19 02:02:29'),
(44, 4, 'Display', '13.6-inch Liquid Retina', '2026-06-19 02:02:29', '2026-06-19 02:02:29'),
(49, 3, 'Type', 'Over-Ear, Wireless', '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(50, 3, 'Battery Life', 'Up to 30 Hours', '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(51, 3, 'Bluetooth Version', '5.2', '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(52, 3, 'Weight', '250 grams', '2026-06-19 02:03:14', '2026-06-19 02:03:14'),
(53, 6, 'Sensor Resolution', '8000 DPI (Works on glass)', '2026-06-19 02:48:25', '2026-06-19 02:48:25'),
(54, 6, 'Buttons', '7 Programmable Buttons', '2026-06-19 02:48:25', '2026-06-19 02:48:25'),
(55, 6, 'Connectivity', 'Bluetooth & Logi Bolt Receiver', '2026-06-19 02:48:25', '2026-06-19 02:48:25'),
(56, 6, 'Charging Port', 'USB-C Quick Charging', '2026-06-19 02:48:25', '2026-06-19 02:48:25'),
(57, 6, 'Ram', '10GB', '2026-06-19 02:48:25', '2026-06-19 02:48:25'),
(58, 6, 'Rom', '100GB', '2026-06-19 02:48:25', '2026-06-19 02:48:25'),
(61, 7, 'Ram', '10GB', '2026-06-19 02:51:37', '2026-06-19 02:51:37'),
(62, 7, 'Rom', '20GB', '2026-06-19 02:51:37', '2026-06-19 02:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(2, 'admin', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(3, 'manager', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39'),
(4, 'user', 'web', '2025-11-18 10:08:39', '2025-11-18 10:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', NULL, NULL, '$2y$10$pE8arh.OWm7wuqPGxZ.pze53Yebj7UWjrnVNzy/GesXIadH.8kD3S', 'uploads/profile/411218212.png', 'fXbW4bNN5a9Rvm23Z8ItBaDmLaPmrpcg8tgTbuwacpRQd1qIp5JUKFvMCrn9', '2025-11-18 10:08:39', '2025-11-19 10:09:55'),
(3, 'Admin', 'test@gmail.com', '01761070654', NULL, '$2y$10$A/fUao2WQt9P255pvfDptuosZ015lkMz.WSqxP0aOiHa5h6Q8/G7y', 'uploads/profile/1761476359.jpg', 'cqOpV2aHLFyJSV09tmamJr10vZHIIVdTaFEHx2q2tY5s2AbBMJwnPRjc1KXp', '2025-11-19 11:27:27', '2025-11-19 12:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_title` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_2` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone_2` varchar(255) DEFAULT NULL,
  `header_logo` varchar(255) DEFAULT NULL,
  `footer_logo` varchar(255) DEFAULT NULL,
  `favicon_logo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `company_name`, `company_title`, `email`, `email_2`, `phone`, `phone_2`, `header_logo`, `footer_logo`, `favicon_logo`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Sysnex', 'Ecommerce Home', 'test@gmail.com', 'ecommerce@gmail.com', '+8801310993183', '014124585474', 'uploads/settings/1935751212.jpg', 'uploads/settings/380789046.png', 'uploads/settings/1434990033.png', 'Dubarchar Dokkhin , Kamarer Char , Dubarchar - 2100 , Sherpur sadar Sherpur', '2025-11-18 10:08:39', '2026-04-16 12:03:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_clicks_product_id_foreign` (`product_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_items`
--
ALTER TABLE `attribute_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_comparison_fields`
--
ALTER TABLE `category_comparison_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_comparison_fields_category_id_foreign` (`category_id`),
  ADD KEY `category_comparison_fields_comparison_field_id_foreign` (`comparison_field_id`);

--
-- Indexes for table `click_logs`
--
ALTER TABLE `click_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comparison_fields`
--
ALTER TABLE `comparison_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comparison_fields_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_faqs`
--
ALTER TABLE `product_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_faqs_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_specifications_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `web_settings`
--
ALTER TABLE `web_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attribute_items`
--
ALTER TABLE `attribute_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_comparison_fields`
--
ALTER TABLE `category_comparison_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `click_logs`
--
ALTER TABLE `click_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `comparison_fields`
--
ALTER TABLE `comparison_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_faqs`
--
ALTER TABLE `product_faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `web_settings`
--
ALTER TABLE `web_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  ADD CONSTRAINT `affiliate_clicks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `category_comparison_fields`
--
ALTER TABLE `category_comparison_fields`
  ADD CONSTRAINT `category_comparison_fields_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_comparison_fields_comparison_field_id_foreign` FOREIGN KEY (`comparison_field_id`) REFERENCES `comparison_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_faqs`
--
ALTER TABLE `product_faqs`
  ADD CONSTRAINT `product_faqs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
