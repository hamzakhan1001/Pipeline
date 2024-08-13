-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: appghost.cyabb6bvejrw.us-east-1.rds.amazonaws.com
-- Generation Time: Aug 13, 2024 at 07:24 PM
-- Server version: 10.6.16-MariaDB-log
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ghost_default_base`
--

-- --------------------------------------------------------

--
-- Table structure for table `ghost_access`
--

CREATE TABLE `ghost_access` (
  `idaccess` int(10) UNSIGNED NOT NULL,
  `login` varchar(100) NOT NULL,
  `idsite` int(10) UNSIGNED NOT NULL,
  `access` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_activity_log`
--

CREATE TABLE `ghost_activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(100) NOT NULL,
  `type` varchar(255) NOT NULL,
  `parameters` longtext NOT NULL,
  `ts_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `country` char(3) DEFAULT NULL,
  `ip` varbinary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_alert`
--

CREATE TABLE `ghost_alert` (
  `idalert` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `period` varchar(5) NOT NULL,
  `report` varchar(150) NOT NULL,
  `report_condition` varchar(50) DEFAULT NULL,
  `report_matched` varchar(255) DEFAULT NULL,
  `metric` varchar(150) NOT NULL,
  `metric_condition` varchar(50) NOT NULL,
  `metric_matched` float NOT NULL,
  `compared_to` smallint(4) UNSIGNED NOT NULL DEFAULT 1,
  `email_me` tinyint(1) NOT NULL DEFAULT 0,
  `additional_emails` text DEFAULT NULL,
  `phone_numbers` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_alert_site`
--

CREATE TABLE `ghost_alert_site` (
  `idalert` int(11) NOT NULL,
  `idsite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_alert_triggered`
--

CREATE TABLE `ghost_alert_triggered` (
  `idtriggered` bigint(20) UNSIGNED NOT NULL,
  `idalert` int(11) NOT NULL,
  `idsite` int(11) NOT NULL,
  `ts_triggered` timestamp NOT NULL DEFAULT current_timestamp(),
  `ts_last_sent` timestamp NULL DEFAULT NULL,
  `value_old` decimal(20,3) DEFAULT NULL,
  `value_new` decimal(20,3) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `period` varchar(5) NOT NULL,
  `report` varchar(150) NOT NULL,
  `report_condition` varchar(50) DEFAULT NULL,
  `report_matched` varchar(1000) DEFAULT NULL,
  `metric` varchar(150) NOT NULL,
  `metric_condition` varchar(50) NOT NULL,
  `metric_matched` float NOT NULL,
  `compared_to` smallint(6) NOT NULL DEFAULT 1,
  `email_me` tinyint(1) NOT NULL DEFAULT 0,
  `additional_emails` text DEFAULT NULL,
  `phone_numbers` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_archive_invalidations`
--

CREATE TABLE `ghost_archive_invalidations` (
  `idinvalidation` bigint(20) UNSIGNED NOT NULL,
  `idarchive` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `idsite` int(10) UNSIGNED NOT NULL,
  `date1` date NOT NULL,
  `date2` date NOT NULL,
  `period` tinyint(3) UNSIGNED NOT NULL,
  `ts_invalidated` datetime DEFAULT NULL,
  `ts_started` datetime DEFAULT NULL,
  `status` tinyint(1) UNSIGNED DEFAULT 0,
  `report` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_archive_numeric_2024_01`
--

CREATE TABLE `ghost_archive_numeric_2024_01` (
  `idarchive` int(10) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `idsite` int(10) UNSIGNED DEFAULT NULL,
  `date1` date DEFAULT NULL,
  `date2` date DEFAULT NULL,
  `period` tinyint(3) UNSIGNED DEFAULT NULL,
  `ts_archived` datetime DEFAULT NULL,
  `value` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_archive_numeric_2024_07`
--

CREATE TABLE `ghost_archive_numeric_2024_07` (
  `idarchive` int(10) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `idsite` int(10) UNSIGNED DEFAULT NULL,
  `date1` date DEFAULT NULL,
  `date2` date DEFAULT NULL,
  `period` tinyint(3) UNSIGNED DEFAULT NULL,
  `ts_archived` datetime DEFAULT NULL,
  `value` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_archive_numeric_2024_08`
--

CREATE TABLE `ghost_archive_numeric_2024_08` (
  `idarchive` int(10) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `idsite` int(10) UNSIGNED DEFAULT NULL,
  `date1` date DEFAULT NULL,
  `date2` date DEFAULT NULL,
  `period` tinyint(3) UNSIGNED DEFAULT NULL,
  `ts_archived` datetime DEFAULT NULL,
  `value` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_bot_db`
--

CREATE TABLE `ghost_bot_db` (
  `botId` int(10) UNSIGNED NOT NULL,
  `idsite` int(10) UNSIGNED NOT NULL,
  `botName` varchar(256) NOT NULL,
  `botActive` tinyint(1) NOT NULL,
  `botKeyword` varchar(256) NOT NULL,
  `botCount` int(10) UNSIGNED NOT NULL,
  `botLastVisit` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `extra_stats` tinyint(1) NOT NULL DEFAULT 0,
  `botType` tinyint(3) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ghost_bot_db`
--

INSERT INTO `ghost_bot_db` (`botId`, `idsite`, `botName`, `botActive`, `botKeyword`, `botCount`, `botLastVisit`, `extra_stats`, `botType`) VALUES
(1, 1, 'Amazonbot', 1, 'Amazonbot', 0, '2024-08-12 16:53:33', 0, 0),
(2, 1, 'Qualys', 1, 'Qualys', 0, '2024-08-12 16:53:33', 0, 0),
(3, 1, 'bingbot', 1, 'bingbot', 0, '2024-08-12 16:53:33', 0, 0),
(4, 1, 'YandexBot', 1, 'YandexBot', 0, '2024-08-12 16:53:33', 0, 0),
(5, 1, 'AhrefsBot', 1, 'AhrefsBot', 0, '2024-08-12 16:53:33', 0, 0),
(6, 1, 'Ahrefs', 1, 'Ahrefs', 0, '2024-08-12 16:53:33', 0, 0),
(7, 1, 'Scrapy', 1, 'Scrapy', 0, '2024-08-12 16:53:33', 0, 0),
(8, 1, 'Googlebot-Image', 1, 'Google-Image', 0, '2024-08-12 16:53:33', 0, 0),
(9, 1, 'Googlebot-News', 1, 'Googlebot-News', 0, '2024-08-12 16:53:33', 0, 0),
(10, 1, 'Googlebot-Video', 1, 'Googlebot-Video', 0, '2024-08-12 16:53:33', 0, 0),
(11, 1, 'Storebot-Google', 1, 'Storebot-Google', 0, '2024-08-12 16:53:33', 0, 0),
(12, 1, 'Google-InspectionTool', 1, 'Google-InspectionTool', 0, '2024-08-12 16:53:33', 0, 0),
(13, 1, 'Google-Extended', 1, 'Google-Extended', 0, '2024-08-12 16:53:33', 0, 0),
(14, 1, 'GoogleOther', 1, 'GoogleOther', 0, '2024-08-12 16:53:33', 0, 0),
(15, 1, 'APIs-Google', 1, 'APIs-Google', 0, '2024-08-12 16:53:33', 0, 0),
(16, 1, 'AdsBot-Google-Mobile', 1, 'AdsBot-Google-Mobile', 0, '2024-08-12 16:53:33', 0, 0),
(17, 1, 'AdsBot-Google', 1, 'AdsBot-Google', 0, '2024-08-12 16:53:33', 0, 0),
(18, 1, 'Mediapartners-Google', 1, 'Google AdSense', 0, '2024-08-12 16:53:33', 0, 0),
(19, 1, 'Google-Safety', 1, 'Google-Safety', 0, '2024-08-12 16:53:33', 0, 0),
(20, 1, 'Googlebot', 1, 'Googlebot', 0, '2024-08-12 16:53:33', 0, 0),
(21, 1, 'Google-Read-Aloud', 1, 'Google-Read-Aloud', 0, '2024-08-12 16:53:33', 0, 0),
(22, 1, 'Google-Site-Verification', 1, 'Google-Site-Verification', 0, '2024-08-12 16:53:33', 0, 0),
(23, 1, 'AdIdxBot', 1, 'AdIdxBot', 0, '2024-08-12 16:53:33', 0, 0),
(24, 1, 'NewRelic', 1, 'NewRelic', 0, '2024-08-12 16:53:33', 0, 0),
(25, 1, 'Detectify', 1, 'Detectify', 0, '2024-08-12 16:53:33', 0, 0),
(26, 1, 'UptimeRobot', 1, 'UptimeRobot', 0, '2024-08-12 16:53:33', 0, 0),
(27, 1, 'SendGrid', 1, 'SendGrid', 0, '2024-08-12 16:53:33', 0, 0),
(28, 1, 'Applebot', 1, 'Applebot', 0, '2024-08-12 16:53:33', 0, 0),
(29, 1, 'PinterestBot', 1, 'PinterestBot', 0, '2024-08-12 16:53:33', 0, 0),
(30, 1, 'Pingdom', 1, 'Pingdom', 0, '2024-08-12 16:53:33', 0, 0),
(31, 1, 'Barkrowler', 1, 'Barkrowler', 0, '2024-08-12 16:53:33', 0, 0),
(32, 1, 'SEMrush', 1, 'SEMrush', 0, '2024-08-12 16:53:33', 0, 0),
(33, 1, 'GPTBot', 1, 'GPTBot', 0, '2024-08-12 16:53:33', 0, 0),
(34, 1, 'ChatGPT-User', 1, 'ChatGPT-User', 0, '2024-08-12 16:53:33', 0, 0),
(35, 1, 'Bytespider', 1, 'Bytespider', 0, '2024-08-12 16:53:33', 0, 0),
(36, 1, 'CCBot', 1, 'CCBot', 0, '2024-08-12 16:53:33', 0, 0),
(37, 1, 'FacebookBot', 1, 'FacebookBot', 0, '2024-08-12 16:53:33', 0, 0),
(38, 1, 'Site24x7', 1, 'Site24x7', 0, '2024-08-12 16:53:33', 0, 0),
(39, 1, 'Stripe', 1, 'Stripe', 0, '2024-08-12 16:53:33', 0, 0),
(40, 1, 'Slackbot', 1, 'Slackbot', 0, '2024-08-12 16:53:33', 0, 0),
(41, 1, 'Proximic', 1, 'Proximic', 0, '2024-08-12 16:53:33', 0, 0),
(42, 1, 'okhttp', 1, 'okhttp', 0, '2024-08-12 16:53:33', 0, 0),
(43, 1, 'Python', 1, 'Python', 0, '2024-08-12 16:53:33', 0, 0),
(44, 1, 'SemrushBot', 1, 'SemrushBot', 0, '2024-08-12 16:53:33', 0, 0),
(45, 1, 'Chrome-Lighthouse', 1, 'Chrome-Lighthouse', 0, '2024-08-12 16:53:33', 0, 0),
(46, 1, 'Axios', 1, 'Axios', 0, '2024-08-12 16:53:33', 0, 0),
(47, 1, 'PetalBot', 1, 'PetalBot', 0, '2024-08-12 16:53:33', 0, 0),
(48, 1, 'CriteoBot', 1, 'CriteoBot', 0, '2024-08-12 16:53:33', 0, 0),
(49, 1, 'Baidu', 1, 'Baidu', 0, '2024-08-12 16:53:33', 0, 0),
(50, 1, 'ContentKing', 1, 'ContentKing', 0, '2024-08-12 16:53:33', 0, 0),
(51, 1, 'IAS crawler', 1, 'IAS crawler', 0, '2024-08-12 16:53:33', 0, 0),
(52, 1, 'Sucuri', 1, 'Sucuri', 0, '2024-08-12 16:53:33', 0, 0),
(53, 1, 'Seekport', 1, 'Seekport', 0, '2024-08-12 16:53:33', 0, 0),
(54, 1, 'Sogou', 1, 'Sogou', 0, '2024-08-12 16:53:33', 0, 0),
(55, 1, 'YahooMailProxy', 1, 'YahooMailProxy', 0, '2024-08-12 16:53:33', 0, 0),
(56, 1, 'ClaudeBot', 1, 'ClaudeBot', 0, '2024-08-12 16:53:33', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ghost_bot_db_stat`
--

CREATE TABLE `ghost_bot_db_stat` (
  `visitId` bigint(20) UNSIGNED NOT NULL,
  `botId` int(10) UNSIGNED NOT NULL,
  `idsite` int(10) UNSIGNED NOT NULL,
  `page` varchar(256) NOT NULL,
  `visit_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `useragent` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_bot_device_detector_bots`
--

CREATE TABLE `ghost_bot_device_detector_bots` (
  `id` int(11) NOT NULL,
  `idsite` int(10) UNSIGNED DEFAULT NULL,
  `useragent` varchar(256) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_bot_type`
--

CREATE TABLE `ghost_bot_type` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ghost_bot_type`
--

INSERT INTO `ghost_bot_type` (`id`, `name`, `date`) VALUES
(1, 'Monitoring & Analytics', '2024-08-12 16:53:34'),
(2, 'Search Engine Optimization', '2024-08-12 16:53:34'),
(3, 'Advertising & Marketing', '2024-08-12 16:53:34'),
(4, 'Page Preview', '2024-08-12 16:53:34'),
(5, 'Webhook', '2024-08-12 16:53:34'),
(6, 'Social network', '2024-08-12 16:53:34'),
(7, 'Scraper', '2024-08-12 16:53:34'),
(8, 'Copyright', '2024-08-12 16:53:34'),
(9, 'Search Engine Crawler', '2024-08-12 16:53:34'),
(10, 'AI Search Crawler', '2024-08-12 16:53:34'),
(11, 'AI Data Scraper', '2024-08-12 16:53:34'),
(12, 'AI Assistant', '2024-08-12 16:53:34'),
(13, 'Other', '2024-08-12 16:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `ghost_bot_visits`
--

CREATE TABLE `ghost_bot_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `botId` int(10) UNSIGNED DEFAULT NULL,
  `idsite` int(10) UNSIGNED DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_brute_force_log`
--

CREATE TABLE `ghost_brute_force_log` (
  `id_brute_force_log` bigint(11) NOT NULL,
  `ip_address` varchar(60) DEFAULT NULL,
  `attempted_at` datetime NOT NULL,
  `login` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_changes`
--

CREATE TABLE `ghost_changes` (
  `idchange` int(10) UNSIGNED NOT NULL,
  `created_time` datetime NOT NULL,
  `plugin_name` varchar(60) NOT NULL,
  `version` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `link_name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_custom_dimensions`
--

CREATE TABLE `ghost_custom_dimensions` (
  `idcustomdimension` bigint(20) UNSIGNED NOT NULL,
  `idsite` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `index` smallint(5) UNSIGNED NOT NULL,
  `scope` varchar(10) NOT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `extractions` text NOT NULL DEFAULT '',
  `case_sensitive` tinyint(3) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_goal`
--

CREATE TABLE `ghost_goal` (
  `idsite` int(11) NOT NULL,
  `idgoal` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  `match_attribute` varchar(20) NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `pattern_type` varchar(25) NOT NULL,
  `case_sensitive` tinyint(4) NOT NULL,
  `allow_multiple` tinyint(4) NOT NULL,
  `revenue` double NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `event_value_as_revenue` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_locks`
--

CREATE TABLE `ghost_locks` (
  `key` varchar(70) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `expiry_time` bigint(20) UNSIGNED DEFAULT 9999999999
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_logger_message`
--

CREATE TABLE `ghost_logger_message` (
  `idlogger_message` int(10) UNSIGNED NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `level` varchar(16) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_action`
--

CREATE TABLE `ghost_log_action` (
  `idaction` int(10) UNSIGNED NOT NULL,
  `name` varchar(4096) DEFAULT NULL,
  `hash` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED DEFAULT NULL,
  `url_prefix` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_clickid`
--

CREATE TABLE `ghost_log_clickid` (
  `idvisit` bigint(10) UNSIGNED NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `adclickid` varchar(255) DEFAULT NULL,
  `adprovider` varchar(50) DEFAULT NULL,
  `server_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_conversion`
--

CREATE TABLE `ghost_log_conversion` (
  `idvisit` bigint(10) UNSIGNED NOT NULL,
  `idsite` int(10) UNSIGNED NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `server_time` datetime NOT NULL,
  `idaction_url` int(10) UNSIGNED DEFAULT NULL,
  `idlink_va` bigint(10) UNSIGNED DEFAULT NULL,
  `idgoal` int(10) NOT NULL,
  `buster` int(10) UNSIGNED NOT NULL,
  `idorder` varchar(100) DEFAULT NULL,
  `items` smallint(5) UNSIGNED DEFAULT NULL,
  `url` varchar(4096) NOT NULL,
  `revenue` float DEFAULT NULL,
  `revenue_shipping` double DEFAULT NULL,
  `revenue_subtotal` double DEFAULT NULL,
  `revenue_tax` double DEFAULT NULL,
  `revenue_discount` double DEFAULT NULL,
  `pageviews_before` smallint(5) UNSIGNED DEFAULT NULL,
  `visitor_returning` tinyint(1) DEFAULT NULL,
  `visitor_seconds_since_first` int(11) UNSIGNED DEFAULT NULL,
  `visitor_seconds_since_order` int(11) UNSIGNED DEFAULT NULL,
  `visitor_count_visits` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `referer_keyword` varchar(255) DEFAULT NULL,
  `referer_name` varchar(255) DEFAULT NULL,
  `referer_type` tinyint(1) UNSIGNED DEFAULT NULL,
  `config_browser_name` varchar(40) DEFAULT NULL,
  `config_client_type` tinyint(1) DEFAULT NULL,
  `config_device_brand` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `config_device_model` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `config_device_type` tinyint(100) DEFAULT NULL,
  `location_city` varchar(255) DEFAULT NULL,
  `location_country` char(3) DEFAULT NULL,
  `location_latitude` decimal(9,6) DEFAULT NULL,
  `location_longitude` decimal(9,6) DEFAULT NULL,
  `location_region` char(3) DEFAULT NULL,
  `custom_dimension_1` varchar(255) DEFAULT NULL,
  `custom_dimension_2` varchar(255) DEFAULT NULL,
  `custom_dimension_3` varchar(255) DEFAULT NULL,
  `custom_dimension_4` varchar(255) DEFAULT NULL,
  `custom_dimension_5` varchar(255) DEFAULT NULL,
  `campaign_content` varchar(255) DEFAULT NULL,
  `campaign_group` varchar(255) DEFAULT NULL,
  `campaign_id` varchar(100) DEFAULT NULL,
  `campaign_keyword` varchar(255) DEFAULT NULL,
  `campaign_medium` varchar(255) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_placement` varchar(100) DEFAULT NULL,
  `campaign_source` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_conversion_item`
--

CREATE TABLE `ghost_log_conversion_item` (
  `idsite` int(10) UNSIGNED NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `server_time` datetime NOT NULL,
  `idvisit` bigint(10) UNSIGNED NOT NULL,
  `idorder` varchar(100) NOT NULL,
  `idaction_sku` int(10) UNSIGNED NOT NULL,
  `idaction_name` int(10) UNSIGNED NOT NULL,
  `idaction_category` int(10) UNSIGNED NOT NULL,
  `idaction_category2` int(10) UNSIGNED NOT NULL,
  `idaction_category3` int(10) UNSIGNED NOT NULL,
  `idaction_category4` int(10) UNSIGNED NOT NULL,
  `idaction_category5` int(10) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `deleted` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_link_visit_action`
--

CREATE TABLE `ghost_log_link_visit_action` (
  `idlink_va` bigint(10) UNSIGNED NOT NULL,
  `idsite` int(10) UNSIGNED NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `idvisit` bigint(10) UNSIGNED NOT NULL,
  `idaction_url_ref` int(10) UNSIGNED DEFAULT 0,
  `idaction_name_ref` int(10) UNSIGNED DEFAULT NULL,
  `custom_float` double DEFAULT NULL,
  `pageview_position` mediumint(8) UNSIGNED DEFAULT NULL,
  `server_time` datetime NOT NULL,
  `idpageview` char(6) DEFAULT NULL,
  `idaction_name` int(10) UNSIGNED DEFAULT NULL,
  `idaction_url` int(10) UNSIGNED DEFAULT NULL,
  `search_cat` varchar(200) DEFAULT NULL,
  `search_count` int(10) UNSIGNED DEFAULT NULL,
  `time_spent_ref_action` int(10) UNSIGNED DEFAULT NULL,
  `idaction_product_cat` int(10) UNSIGNED DEFAULT NULL,
  `idaction_product_cat2` int(10) UNSIGNED DEFAULT NULL,
  `idaction_product_cat3` int(10) UNSIGNED DEFAULT NULL,
  `idaction_product_cat4` int(10) UNSIGNED DEFAULT NULL,
  `idaction_product_cat5` int(10) UNSIGNED DEFAULT NULL,
  `idaction_product_name` int(10) UNSIGNED DEFAULT NULL,
  `product_price` double DEFAULT NULL,
  `idaction_product_sku` int(10) UNSIGNED DEFAULT NULL,
  `idaction_event_action` int(10) UNSIGNED DEFAULT NULL,
  `idaction_event_category` int(10) UNSIGNED DEFAULT NULL,
  `idaction_content_interaction` int(10) UNSIGNED DEFAULT NULL,
  `idaction_content_name` int(10) UNSIGNED DEFAULT NULL,
  `idaction_content_piece` int(10) UNSIGNED DEFAULT NULL,
  `idaction_content_target` int(10) UNSIGNED DEFAULT NULL,
  `time_dom_completion` mediumint(10) UNSIGNED DEFAULT NULL,
  `time_dom_processing` mediumint(10) UNSIGNED DEFAULT NULL,
  `time_network` mediumint(10) UNSIGNED DEFAULT NULL,
  `time_on_load` mediumint(10) UNSIGNED DEFAULT NULL,
  `time_server` mediumint(10) UNSIGNED DEFAULT NULL,
  `time_transfer` mediumint(10) UNSIGNED DEFAULT NULL,
  `time_spent` int(10) UNSIGNED DEFAULT NULL,
  `custom_dimension_1` varchar(255) DEFAULT NULL,
  `custom_dimension_2` varchar(255) DEFAULT NULL,
  `custom_dimension_3` varchar(255) DEFAULT NULL,
  `custom_dimension_4` varchar(255) DEFAULT NULL,
  `custom_dimension_5` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_media`
--

CREATE TABLE `ghost_log_media` (
  `idvisitor` binary(8) NOT NULL,
  `idvisit` bigint(20) UNSIGNED NOT NULL,
  `idsite` int(11) UNSIGNED NOT NULL,
  `idview` varchar(6) NOT NULL,
  `player_name` varchar(20) NOT NULL,
  `media_type` tinyint(1) NOT NULL,
  `resolution` varchar(20) DEFAULT '',
  `fullscreen` tinyint(1) UNSIGNED NOT NULL,
  `media_title` varchar(150) DEFAULT '',
  `resource` varchar(300) NOT NULL,
  `server_time` datetime NOT NULL,
  `time_to_initial_play` int(11) UNSIGNED DEFAULT NULL,
  `watched_time` bigint(20) UNSIGNED DEFAULT 0,
  `media_progress` int(11) UNSIGNED DEFAULT 0,
  `media_length` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_media_plays`
--

CREATE TABLE `ghost_log_media_plays` (
  `idview` varchar(6) NOT NULL,
  `idvisit` bigint(20) UNSIGNED NOT NULL,
  `segment_15` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_30` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_45` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_60` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_75` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_90` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_105` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_120` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_135` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_150` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_165` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_180` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_195` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_210` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_225` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_240` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_255` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_270` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_285` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_300` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_330` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_360` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_390` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_420` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_450` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_480` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_510` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_540` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_570` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_600` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_630` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_660` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_690` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_720` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_750` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_780` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_810` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_840` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_870` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_900` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_930` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_960` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_990` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1020` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1050` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1080` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1110` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1140` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1170` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1200` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1230` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1260` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1290` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1320` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1350` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1380` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1410` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1440` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1470` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1500` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1530` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1560` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1590` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1620` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1650` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1680` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1710` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1740` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1770` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1800` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1830` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1860` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1890` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1920` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1950` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_1980` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2010` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2040` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2070` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2100` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2130` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2160` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2190` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2220` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2250` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2280` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2310` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2340` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2370` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2400` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2430` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2460` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2490` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2520` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2550` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2580` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2610` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2640` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2670` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2700` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2730` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2760` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2790` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2820` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2850` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2880` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2910` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2940` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_2970` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3000` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3030` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3060` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3090` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3120` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3150` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3180` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3210` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3240` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3270` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3300` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3330` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3360` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3390` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3420` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3450` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3480` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3510` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3540` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3570` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3600` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3630` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3660` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3690` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3720` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3750` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3780` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3810` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3840` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3870` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3900` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3930` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3960` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_3990` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4020` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4050` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4080` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4110` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4140` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4170` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4200` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4230` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4260` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4290` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4320` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4350` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4380` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4410` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4440` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4470` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4500` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4530` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4560` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4590` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4620` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4650` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4680` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4710` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4740` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4770` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4800` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4830` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4860` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4890` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4920` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4950` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_4980` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5010` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5040` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5070` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5100` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5130` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5160` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5190` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5220` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5250` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5280` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5310` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5340` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5370` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5400` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5430` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5460` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5490` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5520` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5550` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5580` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5610` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5640` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5670` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5700` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5730` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5760` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5790` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5820` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5850` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5880` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5910` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5940` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_5970` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6000` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6030` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6060` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6090` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6120` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6150` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6180` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6210` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6240` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6270` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6300` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6330` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6360` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6390` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6420` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6450` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6480` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6510` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6540` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6570` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6600` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6630` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6660` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6690` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6720` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6750` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6780` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6810` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6840` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6870` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6900` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6930` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6960` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_6990` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_7020` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_7050` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_7080` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_7110` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_7140` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_7170` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `segment_7200` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_profiling`
--

CREATE TABLE `ghost_log_profiling` (
  `query` text NOT NULL,
  `count` int(10) UNSIGNED DEFAULT NULL,
  `sum_time_ms` float DEFAULT NULL,
  `idprofiling` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_log_visit`
--

CREATE TABLE `ghost_log_visit` (
  `idvisit` bigint(10) UNSIGNED NOT NULL,
  `idsite` int(10) UNSIGNED NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `visit_last_action_time` datetime NOT NULL,
  `config_id` binary(8) NOT NULL,
  `location_ip` varbinary(16) NOT NULL,
  `profilable` tinyint(1) DEFAULT NULL,
  `user_id` varchar(200) DEFAULT NULL,
  `visit_first_action_time` datetime NOT NULL,
  `visit_goal_buyer` tinyint(1) DEFAULT NULL,
  `visit_goal_converted` tinyint(1) DEFAULT NULL,
  `visitor_returning` tinyint(1) DEFAULT NULL,
  `visitor_seconds_since_first` int(11) UNSIGNED DEFAULT NULL,
  `visitor_seconds_since_order` int(11) UNSIGNED DEFAULT NULL,
  `visitor_count_visits` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `visit_entry_idaction_name` int(10) UNSIGNED DEFAULT NULL,
  `visit_entry_idaction_url` int(11) UNSIGNED DEFAULT NULL,
  `visit_exit_idaction_name` int(10) UNSIGNED DEFAULT NULL,
  `visit_exit_idaction_url` int(10) UNSIGNED DEFAULT 0,
  `visit_total_actions` int(11) UNSIGNED DEFAULT NULL,
  `visit_total_interactions` mediumint(8) UNSIGNED DEFAULT 0,
  `visit_total_searches` smallint(5) UNSIGNED DEFAULT NULL,
  `referer_keyword` varchar(255) DEFAULT NULL,
  `referer_name` varchar(255) DEFAULT NULL,
  `referer_type` tinyint(1) UNSIGNED DEFAULT NULL,
  `referer_url` varchar(1500) DEFAULT NULL,
  `location_browser_lang` varchar(20) DEFAULT NULL,
  `config_browser_engine` varchar(10) DEFAULT NULL,
  `config_browser_name` varchar(40) DEFAULT NULL,
  `config_browser_version` varchar(20) DEFAULT NULL,
  `config_client_type` tinyint(1) DEFAULT NULL,
  `config_device_brand` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `config_device_model` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `config_device_type` tinyint(100) DEFAULT NULL,
  `config_os` char(3) DEFAULT NULL,
  `config_os_version` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `visit_total_events` int(11) UNSIGNED DEFAULT NULL,
  `visitor_localtime` time DEFAULT NULL,
  `visitor_seconds_since_last` int(11) UNSIGNED DEFAULT NULL,
  `config_resolution` varchar(18) DEFAULT NULL,
  `config_cookie` tinyint(1) DEFAULT NULL,
  `config_flash` tinyint(1) DEFAULT NULL,
  `config_java` tinyint(1) DEFAULT NULL,
  `config_pdf` tinyint(1) DEFAULT NULL,
  `config_quicktime` tinyint(1) DEFAULT NULL,
  `config_realplayer` tinyint(1) DEFAULT NULL,
  `config_silverlight` tinyint(1) DEFAULT NULL,
  `config_windowsmedia` tinyint(1) DEFAULT NULL,
  `visit_total_time` int(11) UNSIGNED NOT NULL,
  `location_city` varchar(255) DEFAULT NULL,
  `location_country` char(3) DEFAULT NULL,
  `location_latitude` decimal(9,6) DEFAULT NULL,
  `location_longitude` decimal(9,6) DEFAULT NULL,
  `location_region` char(3) DEFAULT NULL,
  `last_idlink_va` bigint(20) UNSIGNED DEFAULT NULL,
  `custom_dimension_1` varchar(255) DEFAULT NULL,
  `custom_dimension_2` varchar(255) DEFAULT NULL,
  `custom_dimension_3` varchar(255) DEFAULT NULL,
  `custom_dimension_4` varchar(255) DEFAULT NULL,
  `custom_dimension_5` varchar(255) DEFAULT NULL,
  `config_webgl` tinyint(1) DEFAULT NULL,
  `campaign_content` varchar(255) DEFAULT NULL,
  `campaign_group` varchar(255) DEFAULT NULL,
  `campaign_id` varchar(100) DEFAULT NULL,
  `campaign_keyword` varchar(255) DEFAULT NULL,
  `campaign_medium` varchar(255) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `campaign_placement` varchar(100) DEFAULT NULL,
  `campaign_source` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_option`
--

CREATE TABLE `ghost_option` (
  `option_name` varchar(191) NOT NULL,
  `option_value` longtext NOT NULL,
  `autoload` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghost_option`
--

INSERT INTO `ghost_option` (`option_name`, `option_value`, `autoload`) VALUES
('CorePluginsAdmin.disableTagManagerTeaser', '1', 1),
('enableBrowserTriggerArchiving', '0', 1),
('fingerprint_salt_1_2024-08-10', '{\"value\":\"jkpfw966wnn17xsr542saznacciscn90\",\"time\":1723480122}', 0),
('fingerprint_salt_1_2024-08-11', '{\"value\":\"8f4h3ah2vp9fopc069kgwhd0t4hhvigx\",\"time\":1723480122}', 0),
('fingerprint_salt_1_2024-08-12', '{\"value\":\"bgkkmho3azb5br9i9r0a7ffm7fftipl3\",\"time\":1723480122}', 0),
('fingerprint_salt_1_2024-08-13', '{\"value\":\"jflii49afey8t72wk5i6u8bff5cvmhsm\",\"time\":1723480122}', 0),
('geoip2.loc_db_url', 'https://download.db-ip.com/free/dbip-city-lite-2024-08.mmdb.gz', 0),
('geoip2.updater_last_run_time', '1723420800', 0),
('geoip2.updater_period', 'month', 0),
('install_mail_sent', '1', 0),
('install_version', '5.1.0', 0),
('LastPluginActivation.ActivityLog', '1723520784', 0),
('LastPluginActivation.AdminNotification', '1723481613', 0),
('LastPluginActivation.AdvertisingConversionExport', '1723481613', 0),
('LastPluginActivation.BotTracker', '1723481614', 0),
('LastPluginActivation.CustomAlerts', '1723481614', 0),
('LastPluginActivation.DBStats', '1723481614', 0),
('LastPluginActivation.DeviceDetectorCache', '1723481614', 0),
('LastPluginActivation.DeviceFeatureWebGL', '1723481614', 0),
('LastPluginActivation.DiagnosticsExtended', '1723481614', 0),
('LastPluginActivation.ExtraTools', '1723481614', 0),
('LastPluginActivation.GhostBrand', '1723481614', 0),
('LastPluginActivation.GhostTheme', '1723481743', 0),
('LastPluginActivation.GoogleAnalyticsImporter', '1723481614', 0),
('LastPluginActivation.JsTrackerCustom', '1723481614', 0),
('LastPluginActivation.KPIWidgets', '1723481614', 0),
('LastPluginActivation.LoginTokenAuth', '1723481614', 0),
('LastPluginActivation.LogViewer', '1723481614', 0),
('LastPluginActivation.MarketingCampaignsReporting', '1723481618', 0),
('LastPluginActivation.MediaAnalytics', '1723481618', 0),
('LastPluginActivation.Migration', '1723481618', 0),
('LastPluginActivation.MobileAppMeasurable', '1723481618', 0),
('LastPluginActivation.QueuedTracking', '1723481618', 0),
('LastPluginActivation.ReferrersManager', '1723481618', 0),
('LastPluginActivation.SecurityInfo', '1723481618', 0),
('LastPluginActivation.TagManager', '1723481619', 0),
('LastPluginActivation.TagManagerExtended', '1723481619', 0),
('LastPluginActivation.TasksTimetable', '1723481619', 0),
('LastPluginActivation.TrackingSpamPrevention', '1723481619', 0),
('LastPluginActivation.TreemapVisualization', '1723481619', 0),
('LastPluginActivation.UserConsole', '1723481620', 0),
('LastPluginDeactivation.Marketplace', '1723520641', 0),
('MatomoUpdateHistory', '5.1.0,', 0),
('MobileMessaging_DelegatedManagement', 'false', 0),
('piwikUrl', 'https://tenant.ghostmetrics.cloud/', 1),
('PrivacyManager.anonymizeOrderId', '1', 0),
('PrivacyManager.anonymizeReferrer', '', 0),
('PrivacyManager.anonymizeUserId', '1', 0),
('PrivacyManager.doNotTrackEnabled', '1', 0),
('PrivacyManager.forceCookielessTracking', '0', 0),
('PrivacyManager.ipAddressMaskLength', '4', 0),
('PrivacyManager.ipAnonymizerEnabled', '1', 0),
('PrivacyManager.useAnonymizedIpForVisitEnrichment', '0', 0),
('SharedSiteIdsToArchive_AllWebsites_ResetQueueTime', '1723575903171', 0),
('SitesManager_DefaultTimezone', 'America/Chicago', 0),
('tagmanager_salt', '2e6309caf671fc873e13FWee{2!91vU5YGHNlpAx', 0),
('TaskScheduler.timetable', 'a:1:{s:45:\"Piwik\\Plugins\\GeoIp2\\GeoIP2AutoUpdater.update\";i:1725321658;}', 0),
('todayArchiveTimeToLive', '900', 1),
('TransactionLevel.testOption', '1', 0),
('UpdateCheck_LastCheckFailed', '', 0),
('UpdateCheck_LastTimeChecked', '1723520317', 1),
('UpdateCheck_LatestVersion', '5.1.0', 0),
('usercountry.location_provider', 'geoip2php', 0),
('usercountry.switchtoisoregions', '1723480138', 0),
('useridsalt', 'dkbeeYnVh284tFK6b0cGYLuBfHpnOC$0YFM09fKE', 1),
('UsersManager.lastSeen.ghost.superuser', '1723521326', 1),
('UsersManager.lastSeen.super user was set', '1723480136', 1),
('version_Actions', '5.1.0', 1),
('version_ActivityLog', '5.0.3', 1),
('version_AdminNotification', '5.0.0', 1),
('version_AdvertisingConversionExport', '5.1.2', 1),
('version_Annotations', '5.1.0', 1),
('version_API', '5.1.0', 1),
('version_BotTracker', '5.2.15', 1),
('version_BulkTracking', '5.1.0', 1),
('version_Contents', '5.1.0', 1),
('version_core', '5.1.0', 1),
('version_CoreAdminHome', '5.1.0', 1),
('version_CoreConsole', '5.1.0', 1),
('version_CoreHome', '5.1.0', 1),
('version_CorePluginsAdmin', '5.1.0', 1),
('version_CoreUpdater', '5.1.0', 1),
('version_CoreVisualizations', '5.1.0', 1),
('version_CoreVue', '5.1.0', 1),
('version_CustomAlerts', '5.0.5', 1),
('version_CustomDimensions', '5.1.0', 1),
('version_CustomJsTracker', '5.1.0', 1),
('version_Dashboard', '5.1.0', 1),
('version_DBStats', '5.1.0', 1),
('version_DeviceDetectorCache', '5.0.3', 1),
('version_DeviceFeatureWebGL', '5.0.0', 1),
('version_DevicePlugins', '5.1.0', 1),
('version_DevicesDetection', '5.1.0', 1),
('version_Diagnostics', '5.1.0', 1),
('version_DiagnosticsExtended', '0.2.0', 1),
('version_Ecommerce', '5.1.0', 1),
('version_Events', '5.1.0', 1),
('version_ExtraTools', '5.0.3', 1),
('version_Feedback', '5.1.0', 1),
('version_GeoIp2', '5.1.0', 1),
('version_GhostBrand', '1.0.0', 1),
('version_GhostTheme', '0.2.0', 1),
('version_Goals', '5.1.0', 1),
('version_GoogleAnalyticsImporter', '5.0.19', 1),
('version_Heartbeat', '5.1.0', 1),
('version_ImageGraph', '5.1.0', 1),
('version_Insights', '5.1.0', 1),
('version_Installation', '5.1.0', 1),
('version_Intl', '5.1.0', 1),
('version_IntranetMeasurable', '5.1.0', 1),
('version_JsTrackerCustom', '5.0.1', 1),
('version_JsTrackerInstallCheck', '5.1.0', 1),
('version_KPIWidgets', '5.0.4', 1),
('version_LanguagesManager', '5.1.0', 1),
('version_Live', '5.1.0', 1),
('version_Login', '5.1.0', 1),
('version_LoginTokenAuth', '5.0.0', 1),
('version_LogViewer', '5.0.2', 1),
('version_log_conversion.pageviews_before', 'SMALLINT UNSIGNED DEFAULT NULL', 1),
('version_log_conversion.revenue', 'float default NULL', 1),
('version_log_link_visit_action.idaction_content_interaction', 'INTEGER(10) UNSIGNED DEFAULT NULL', 1),
('version_log_link_visit_action.idaction_content_name', 'INTEGER(10) UNSIGNED DEFAULT NULL', 1),
('version_log_link_visit_action.idaction_content_piece', 'INTEGER(10) UNSIGNED DEFAULT NULL', 1),
('version_log_link_visit_action.idaction_content_target', 'INTEGER(10) UNSIGNED DEFAULT NULL', 1),
('version_log_link_visit_action.idaction_event_action', 'INTEGER(10) UNSIGNED DEFAULT NULL', 1),
('version_log_link_visit_action.idaction_event_category', 'INTEGER(10) UNSIGNED DEFAULT NULL', 1),
('version_log_link_visit_action.idaction_name', 'INTEGER(10) UNSIGNED', 1),
('version_log_link_visit_action.idaction_product_cat', 'INT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.idaction_product_cat2', 'INT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.idaction_product_cat3', 'INT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.idaction_product_cat4', 'INT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.idaction_product_cat5', 'INT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.idaction_product_name', 'INT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.idaction_product_sku', 'INT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.idaction_url', 'INTEGER(10) UNSIGNED DEFAULT NULL', 1),
('version_log_link_visit_action.idpageview', 'CHAR(6) NULL DEFAULT NULL', 1),
('version_log_link_visit_action.product_price', 'DOUBLE NULL', 1),
('version_log_link_visit_action.search_cat', 'VARCHAR(200) NULL', 1),
('version_log_link_visit_action.search_count', 'INTEGER(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.server_time', 'DATETIME NOT NULL', 1),
('version_log_link_visit_action.time_dom_completion', 'MEDIUMINT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.time_dom_processing', 'MEDIUMINT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.time_network', 'MEDIUMINT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.time_on_load', 'MEDIUMINT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.time_server', 'MEDIUMINT(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.time_spent_ref_action', 'INTEGER(10) UNSIGNED NULL', 1),
('version_log_link_visit_action.time_transfer', 'MEDIUMINT(10) UNSIGNED NULL', 1),
('version_log_visit.campaign_content', 'VARCHAR(255) NULL1', 1),
('version_log_visit.campaign_group', 'VARCHAR(255) NULL1', 1),
('version_log_visit.campaign_id', 'VARCHAR(100) NULL1', 1),
('version_log_visit.campaign_keyword', 'VARCHAR(255) NULL1', 1),
('version_log_visit.campaign_medium', 'VARCHAR(255) NULL1', 1),
('version_log_visit.campaign_name', 'VARCHAR(255) NULL1', 1),
('version_log_visit.campaign_placement', 'VARCHAR(100) NULL1', 1),
('version_log_visit.campaign_source', 'VARCHAR(255) NULL1', 1),
('version_log_visit.config_browser_engine', 'VARCHAR(10) NULL', 1),
('version_log_visit.config_browser_name', 'VARCHAR(40) NULL1', 1),
('version_log_visit.config_browser_version', 'VARCHAR(20) NULL', 1),
('version_log_visit.config_client_type', 'TINYINT( 1 ) NULL DEFAULT NULL1', 1),
('version_log_visit.config_cookie', 'TINYINT(1) NULL', 1),
('version_log_visit.config_device_brand', 'VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL1', 1),
('version_log_visit.config_device_model', 'VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL1', 1),
('version_log_visit.config_device_type', 'TINYINT( 100 ) NULL DEFAULT NULL1', 1),
('version_log_visit.config_flash', 'TINYINT(1) NULL', 1),
('version_log_visit.config_java', 'TINYINT(1) NULL', 1),
('version_log_visit.config_os', 'CHAR(3) NULL', 1),
('version_log_visit.config_os_version', 'VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL', 1),
('version_log_visit.config_pdf', 'TINYINT(1) NULL', 1),
('version_log_visit.config_quicktime', 'TINYINT(1) NULL', 1),
('version_log_visit.config_realplayer', 'TINYINT(1) NULL', 1),
('version_log_visit.config_resolution', 'VARCHAR(18) NULL', 1),
('version_log_visit.config_silverlight', 'TINYINT(1) NULL', 1),
('version_log_visit.config_webgl', 'TINYINT(1) NULL', 1),
('version_log_visit.config_windowsmedia', 'TINYINT(1) NULL', 1),
('version_log_visit.location_browser_lang', 'VARCHAR(20) NULL', 1),
('version_log_visit.location_city', 'varchar(255) DEFAULT NULL1', 1),
('version_log_visit.location_country', 'CHAR(3) NULL1', 1),
('version_log_visit.location_latitude', 'decimal(9, 6) DEFAULT NULL1', 1),
('version_log_visit.location_longitude', 'decimal(9, 6) DEFAULT NULL1', 1),
('version_log_visit.location_region', 'char(3) DEFAULT NULL1', 1),
('version_log_visit.profilable', 'TINYINT(1) NULL', 1),
('version_log_visit.referer_keyword', 'VARCHAR(255) NULL1', 1),
('version_log_visit.referer_name', 'VARCHAR(255) NULL1', 1),
('version_log_visit.referer_type', 'TINYINT(1) UNSIGNED NULL1', 1),
('version_log_visit.referer_url', 'VARCHAR(1500) NULL', 1),
('version_log_visit.user_id', 'VARCHAR(200) NULL', 1),
('version_log_visit.visitor_count_visits', 'INT(11) UNSIGNED NOT NULL DEFAULT 01', 1),
('version_log_visit.visitor_localtime', 'TIME NULL', 1),
('version_log_visit.visitor_returning', 'TINYINT(1) NULL1', 1),
('version_log_visit.visitor_seconds_since_first', 'INT(11) UNSIGNED NULL1', 1),
('version_log_visit.visitor_seconds_since_last', 'INT(11) UNSIGNED NULL', 1),
('version_log_visit.visitor_seconds_since_order', 'INT(11) UNSIGNED NULL1', 1),
('version_log_visit.visit_entry_idaction_name', 'INTEGER(10) UNSIGNED NULL', 1),
('version_log_visit.visit_entry_idaction_url', 'INTEGER(11) UNSIGNED NULL  DEFAULT NULL', 1),
('version_log_visit.visit_exit_idaction_name', 'INTEGER(10) UNSIGNED NULL', 1),
('version_log_visit.visit_exit_idaction_url', 'INTEGER(10) UNSIGNED NULL DEFAULT 0', 1),
('version_log_visit.visit_first_action_time', 'DATETIME NOT NULL', 1),
('version_log_visit.visit_goal_buyer', 'TINYINT(1) NULL', 1),
('version_log_visit.visit_goal_converted', 'TINYINT(1) NULL', 1),
('version_log_visit.visit_total_actions', 'INT(11) UNSIGNED NULL', 1),
('version_log_visit.visit_total_events', 'INT(11) UNSIGNED NULL', 1),
('version_log_visit.visit_total_interactions', 'MEDIUMINT UNSIGNED DEFAULT 0', 1),
('version_log_visit.visit_total_searches', 'SMALLINT(5) UNSIGNED NULL', 1),
('version_log_visit.visit_total_time', 'INT(11) UNSIGNED NOT NULL', 1),
('version_MarketingCampaignsReporting', '5.0.4', 1),
('version_Marketplace', '5.1.0', 1),
('version_MediaAnalytics', '5.0.8', 1),
('version_Migration', '5.0.3', 1),
('version_MobileAppMeasurable', '5.1.0', 1),
('version_MobileMessaging', '5.1.0', 1),
('version_Monolog', '5.1.0', 1),
('version_Morpheus', '5.1.0', 1),
('version_MultiSites', '5.1.0', 1),
('version_Overlay', '5.1.0', 1),
('version_PagePerformance', '5.1.0', 1),
('version_PrivacyManager', '5.1.0', 1),
('version_ProfessionalServices', '5.1.0', 1),
('version_Proxy', '5.1.0', 1),
('version_QueuedTracking', '5.0.6', 1),
('version_Referrers', '5.1.0', 1),
('version_ReferrersManager', '5.0.1', 1),
('version_Resolution', '5.1.0', 1),
('version_RssWidget', '1.0', 1),
('version_ScheduledReports', '5.1.0', 1),
('version_SecurityInfo', '5.0.3', 1),
('version_SegmentEditor', '5.1.0', 1),
('version_SEO', '5.1.0', 1),
('version_SitesManager', '5.1.0', 1),
('version_TagManager', '5.1.0', 1),
('version_TagManagerExtended', '5.0.10', 1),
('version_TasksTimetable', '5.0.1', 1),
('version_Tour', '5.1.0', 1),
('version_TrackingSpamPrevention', '5.0.3', 1),
('version_Transitions', '5.1.0', 1),
('version_TreemapVisualization', '5.0.1', 1),
('version_TwoFactorAuth', '5.1.0', 1),
('version_UserConsole', '5.0.1', 1),
('version_UserCountry', '5.1.0', 1),
('version_UserCountryMap', '5.1.0', 1),
('version_UserId', '5.1.0', 1),
('version_UserLanguage', '5.1.0', 1),
('version_UsersManager', '5.1.0', 1),
('version_VisitFrequency', '5.1.0', 1),
('version_VisitorInterest', '5.1.0', 1),
('version_VisitsSummary', '5.1.0', 1),
('version_VisitTime', '5.1.0', 1),
('version_WebsiteMeasurable', '5.1.0', 1),
('version_Widgetize', '5.1.0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ghost_plugin_setting`
--

CREATE TABLE `ghost_plugin_setting` (
  `plugin_name` varchar(60) NOT NULL,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` longtext NOT NULL,
  `json_encoded` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `user_login` varchar(100) NOT NULL DEFAULT '',
  `idplugin_setting` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghost_plugin_setting`
--

INSERT INTO `ghost_plugin_setting` (`plugin_name`, `setting_name`, `setting_value`, `json_encoded`, `user_login`, `idplugin_setting`) VALUES
('PrivacyManager', 'ImprintUrl', '', 0, '', 1),
('PrivacyManager', 'privacyPolicyUrl', 'http://ghostmetrics.io/privacy', 0, '', 2),
('PrivacyManager', 'termsAndConditionUrl', '', 0, '', 3),
('PrivacyManager', 'showInEmbeddedWidgets', '0', 0, '', 4),
('TrackingSpamPrevention', 'block_clouds', '0', 0, '', 5),
('TrackingSpamPrevention', 'block_headless', '1', 0, '', 6),
('TrackingSpamPrevention', 'blockServerSideLibraries', '0', 0, '', 7),
('TrackingSpamPrevention', 'max_actions_allowed', '0', 0, '', 8),
('TrackingSpamPrevention', 'notification_email', '', 0, '', 9),
('TrackingSpamPrevention', 'excluded_countries', '[]', 1, '', 10),
('TrackingSpamPrevention', 'included_countries', '[]', 1, '', 11);

-- --------------------------------------------------------

--
-- Table structure for table `ghost_privacy_logdata_anonymizations`
--

CREATE TABLE `ghost_privacy_logdata_anonymizations` (
  `idlogdata_anonymization` bigint(20) UNSIGNED NOT NULL,
  `idsites` text DEFAULT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `anonymize_ip` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `anonymize_location` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `anonymize_userid` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `unset_visit_columns` text NOT NULL DEFAULT '',
  `unset_link_visit_action_columns` text NOT NULL DEFAULT '',
  `output` mediumtext DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `job_start_date` datetime DEFAULT NULL,
  `job_finish_date` datetime DEFAULT NULL,
  `requester` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_queuedtracking_queue`
--

CREATE TABLE `ghost_queuedtracking_queue` (
  `queue_key` varchar(70) NOT NULL,
  `queue_value` varchar(255) DEFAULT NULL,
  `expiry_time` bigint(20) UNSIGNED DEFAULT 9999999999
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_report`
--

CREATE TABLE `ghost_report` (
  `idreport` int(11) NOT NULL,
  `idsite` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idsegment` int(11) DEFAULT NULL,
  `period` varchar(10) NOT NULL,
  `hour` tinyint(4) NOT NULL DEFAULT 0,
  `type` varchar(10) NOT NULL,
  `format` varchar(10) NOT NULL,
  `reports` text NOT NULL,
  `parameters` text DEFAULT NULL,
  `ts_created` timestamp NULL DEFAULT NULL,
  `ts_last_sent` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `evolution_graph_within_period` tinyint(4) NOT NULL DEFAULT 0,
  `evolution_graph_period_n` int(11) NOT NULL,
  `period_param` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_report_subscriptions`
--

CREATE TABLE `ghost_report_subscriptions` (
  `idreport` int(11) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `ts_subscribed` timestamp NOT NULL DEFAULT current_timestamp(),
  `ts_unsubscribed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_segment`
--

CREATE TABLE `ghost_segment` (
  `idsegment` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `definition` text NOT NULL,
  `hash` char(32) DEFAULT NULL,
  `login` varchar(100) NOT NULL,
  `enable_all_users` tinyint(4) NOT NULL DEFAULT 0,
  `enable_only_idsite` int(11) DEFAULT NULL,
  `auto_archive` tinyint(4) NOT NULL DEFAULT 0,
  `ts_created` timestamp NULL DEFAULT NULL,
  `ts_last_edit` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_sequence`
--

CREATE TABLE `ghost_sequence` (
  `name` varchar(120) NOT NULL,
  `value` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghost_sequence`
--

INSERT INTO `ghost_sequence` (`name`, `value`) VALUES
('ghost_archive_numeric_2024_01', 0),
('ghost_archive_numeric_2024_07', 0),
('ghost_archive_numeric_2024_08', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ghost_session`
--

CREATE TABLE `ghost_session` (
  `id` varchar(191) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghost_session`
--

INSERT INTO `ghost_session` (`id`, `modified`, `lifetime`, `data`) VALUES
('00c0c1320c632160b2e34d11c048a0eb143728a15a79b217085dd5fb30a4865aa3ee3ce2ca86fd80829ef33e9eb04c4bee9184f0194f810ee1af96d9a948d5fd', 1723493304, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiIzZmJiNDExYjMxZDU2ZjBlMWY4YTE0OGUyYTc5Mjc5OSI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDkzOTA0O319fX0=\";}'),
('07c0f8f5ae55b498f7759a84c00b59165504962465a728453160f5aea7e86990b8c2c81f94208d32481d0f77e28387afe26dbe96262fa9d62e4e87e8de3d5b15', 1723521967, 1209600, 'a:1:{s:4:\"data\";s:2428:\"YToyNDp7czo5OiJ1c2VyLm5hbWUiO3M6MTU6Imdob3N0LnN1cGVydXNlciI7czoyMjoidHdvZmFjdG9yYXV0aC52ZXJpZmllZCI7aTowO3M6MjA6InVzZXIudG9rZW5fYXV0aF90ZW1wIjtzOjMyOiJiYzg3MGE0M2FkNThhMjgwOWFlYjg1M2M1MDQzZTUzOCI7czoxMjoic2Vzc2lvbi5pbmZvIjthOjM6e3M6MjoidHMiO2k6MTcyMzQ4MTA4MTtzOjEwOiJyZW1lbWJlcmVkIjtiOjE7czoxMDoiZXhwaXJhdGlvbiI7aToxNzI0NzMxNTY3O31zOjEyOiJub3RpZmljYXRpb24iO2E6MTp7czoxMzoibm90aWZpY2F0aW9ucyI7YTowOnt9fXM6MjQ6Ik1hcmtldHBsYWNlLnVwZGF0ZVBsdWdpbiI7YTowOnt9czozMjoiQ29yZVBsdWdpbnNBZG1pbi51bmluc3RhbGxQbHVnaW4iO2E6MDp7fXM6MTE6IkFjdGl2aXR5TG9nIjthOjA6e31zOjIzOiJHb29nbGVBbmFseXRpY3NJbXBvcnRlciI7YTowOnt9czozMToiU2VhcmNoRW5naW5lS2V5d29yZHNQZXJmb3JtYW5jZSI7YTowOnt9czoyMjoiVHJhY2tpbmdTcGFtUHJldmVudGlvbiI7YTowOnt9czoyNToiTWFya2V0cGxhY2UuaW5zdGFsbFBsdWdpbiI7YTowOnt9czoyNjoiTGFuZ3VhZ2VzTWFuYWdlci5zZWxlY3Rpb24iO2E6MDp7fXM6NDI6Ikdvb2dsZUFuYWx5dGljc0ltcG9ydGVyLmdvb2dsZUNsaWVudENvbmZpZyI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiIzYTgwZmJkNjZmMjI5MzE0ODc4NjJjNDZkNjdiOTVjOCI7fXM6MTM6ImdhaW1wb3J0LmF1dGgiO2E6MTp7czo1OiJub25jZSI7czozMjoiOGZjNzk2YjU0Yzg4ZTY2NDRlOGNjYjVmYTIwZTE1YmEiO31zOjU6IkxvZ2luIjthOjI6e3M6MTQ6InJlZGlyZWN0UGFyYW1zIjthOjY6e3M6NjoibW9kdWxlIjtzOjE2OiJDb3JlUGx1Z2luc0FkbWluIjtzOjY6ImFjdGlvbiI7czoxMDoiZGVhY3RpdmF0ZSI7czoxMDoicGx1Z2luTmFtZSI7czoxMToiTWFya2V0cGxhY2UiO3M6NToibm9uY2UiO3M6MzI6IjNkM2U0NDZjMzFhYzZhM2RmODlkNjBiYzZiZjkwNDVhIjtzOjEwOiJyZWRpcmVjdFRvIjtzOjg6InJlZmVycmVyIjtzOjg6InJlZmVycmVyIjtzOjQyOiJodHRwcyUzQSUyRiUyRnRlc3QxMS5naG9zdG1ldHJpY3MuY2xvdWQlMkYiO31zOjE2OiJsYXN0UGFzc3dvcmRBdXRoIjtzOjE5OiIyMDI0LTA4LTEzIDAzOjQ0OjAwIjt9czoxNToiY29uZmlybVBhc3N3b3JkIjthOjA6e31zOjQ6Il9fWkYiO2E6NDp7czo0MjoiR29vZ2xlQW5hbHl0aWNzSW1wb3J0ZXIuZ29vZ2xlQ2xpZW50Q29uZmlnIjthOjE6e3M6NDoiRU5WVCI7YToxOntzOjU6Im5vbmNlIjtpOjE3MjM1MjI3NjI7fX1zOjEzOiJnYWltcG9ydC5hdXRoIjthOjE6e3M6NDoiRU5WVCI7YToxOntzOjU6Im5vbmNlIjtpOjE3MjM1MjI3NjI7fX1zOjU6IkxvZ2luIjthOjE6e3M6NDoiRU5WVCI7YToyOntzOjE0OiJyZWRpcmVjdFBhcmFtcyI7aToxNzIzNTIyNDQwO3M6MTY6Imxhc3RQYXNzd29yZEF1dGgiO2k6MTcyMzUyMjQ0MDt9fXM6MTI6IlBpd2lrX09wdE91dCI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNTI0NzE5O319fXM6MzE6IkNvcmVQbHVnaW5zQWRtaW4uYWN0aXZhdGVQbHVnaW4iO2E6MDp7fXM6MzM6IkNvcmVQbHVnaW5zQWRtaW4uZGVhY3RpdmF0ZVBsdWdpbiI7YTowOnt9czoyODoiUHJpdmFjeU1hbmFnZXIuZGVhY3RpdmF0ZURudCI7YTowOnt9czoyNjoiUHJpdmFjeU1hbmFnZXIuYWN0aXZhdGVEbnQiO2E6MDp7fXM6MTI6IlBpd2lrX09wdE91dCI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiI5MTY0NjJmOTVkNzczMDMyNjA1OGE1Yjg4NTY4MDlhMiI7fXM6MjA6IkpzVHJhY2tlckN1c3RvbS5zYXZlIjthOjA6e319\";}'),
('28d5ec8f0705dafcd72993201b814d76685a25a787488fe44f7ca13d3db8b5cdb2ee2c715a53b0ddf2be73e3cd85924f5cf6bf469db2ade73b0a75aa7e5e1ff7', 1723482571, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiJiZjk5ZGI3OWVlZTY4MzkwNmI3MjgxNDgzZTVmYjUxZiI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDgzMTcxO319fX0=\";}'),
('5ffcb04634d6f131c99c87cc9c333bf0421f1a8c2f4b947b19a9f71f53b478552a7e286a35362279384c07c45a2de67ed43dc11a00b31b1821dcc264b4c7fc79', 1723481895, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiIyNzk2NGU1YzRhZWMzZmQ5Y2VmOGEyYjA0M2U2MTAxNiI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDgyNDk1O319fX0=\";}'),
('6a201ff5a307bc88d9a44c766cd961c8e7286e48ae2d9b1eb65f2ec392cb06bdb27da0ebceebfbb958c0a4abe1015e0edf26517a9796a6992cb5e1f7d801eaad', 1723489340, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiI2ZDYyZjZkNjZkNzY5ZmYyMDEyOTUxYjNmMjBiYTllZSI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDg5OTQwO319fX0=\";}'),
('725b081ca1eaed09c925fe7bc8e04c0a7863095f7410f616f06d323802a341848c2434118904441470315e799c90d4375c62d4f68d971ac1870f7d70486f1ca9', 1723489342, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiJlNmNiYmE4MTk3ZTAwOWY2OGJiOGI1MTBiMTg4N2VmMSI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDg5OTQxO319fX0=\";}'),
('babc6fa78da8a2ae362c687a88691e2d864f6f931756c6fca42a657c0b46e17280d63b6d0f2a0c95604372edcc69710af3db12dc7f07fdea78f39e8c5827c806', 1723481896, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiJjMzEzMDNlZTdhNzgyMmU1MzBiOGNlNDIzMGY3MjlkMCI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDgyNDk2O319fX0=\";}'),
('c8ff7be396af046c9f5e5819b7f79bf77772d4a25664596444739d9585b6f2a9aad8e23b1005e057da6911cd7a4c92a542c9312b5a9f5979dc8c495ce3eca1a0', 1723520687, 1209600, 'a:1:{s:4:\"data\";s:8:\"YTowOnt9\";}'),
('c997a9625580a217878b1b040a24df2330fa16c3d3af5686508a0f57c045b550d5e668b4397db17f6a24c660dc4c07d54b8ffc6fd77c85184b81894ec1c0d362', 1723481099, 1209600, 'a:1:{s:4:\"data\";s:8:\"YTowOnt9\";}'),
('c9c10d127ebf35189cfcc669ce90635cf13e5baf33129b58683a6c23dc11976f00ed21d77f0c5386af7d2b677828f165608c3e66d4fdfbf158f251787cd98bd9', 1723481897, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiJhZmUzYTc2ODM5NzVlMTNiZjgxYzlhZGNhYTAxMjUyZCI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDgyNDk3O319fX0=\";}'),
('d6e7677ece72c92f409c3d704b03a5c68aa8736c9416d9b6a99d3705d7979a093604be3d0642d24c5c7536135ea2dc713aae293034dd11a2b542d16cd3d7a207', 1723481895, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiI5N2ZkMWQ3Y2IwZTg2NWIwN2VhZDI1NmY3YmUwMmJjYSI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDgyNDk1O319fX0=\";}'),
('fa8e8c558aab53e0aea699ae9ee60b073402b41c0a568dae452945a660cf5b98a2e34e863298f3c405302fb0a5eccf14609d71fb85f9e32ab6fbb86fa0cb3050', 1723482295, 1209600, 'a:1:{s:4:\"data\";s:224:\"YToyOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjU6Im5vbmNlIjtzOjMyOiIwMjYzYmE2MmIwZjNhZDcwMDg2OThlM2I4OGI1ZTEyZiI7fXM6NDoiX19aRiI7YToxOntzOjExOiJMb2dpbi5sb2dpbiI7YToxOntzOjQ6IkVOVlQiO2E6MTp7czo1OiJub25jZSI7aToxNzIzNDgyODk1O319fX0=\";}');

-- --------------------------------------------------------

--
-- Table structure for table `ghost_site`
--

CREATE TABLE `ghost_site` (
  `idsite` int(10) UNSIGNED NOT NULL,
  `name` varchar(90) NOT NULL,
  `main_url` varchar(255) NOT NULL,
  `ts_created` timestamp NULL DEFAULT NULL,
  `ecommerce` tinyint(4) DEFAULT 0,
  `sitesearch` tinyint(4) DEFAULT 1,
  `sitesearch_keyword_parameters` text NOT NULL,
  `sitesearch_category_parameters` text NOT NULL,
  `timezone` varchar(50) NOT NULL,
  `currency` char(3) NOT NULL,
  `exclude_unknown_urls` tinyint(1) DEFAULT 0,
  `excluded_ips` text NOT NULL,
  `excluded_parameters` text NOT NULL,
  `excluded_user_agents` text NOT NULL,
  `excluded_referrers` text NOT NULL,
  `group` varchar(250) NOT NULL,
  `type` varchar(255) NOT NULL,
  `keep_url_fragment` tinyint(4) NOT NULL DEFAULT 0,
  `creator_login` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghost_site`
--

INSERT INTO `ghost_site` (`idsite`, `name`, `main_url`, `ts_created`, `ecommerce`, `sitesearch`, `sitesearch_keyword_parameters`, `sitesearch_category_parameters`, `timezone`, `currency`, `exclude_unknown_urls`, `excluded_ips`, `excluded_parameters`, `excluded_user_agents`, `excluded_referrers`, `group`, `type`, `keep_url_fragment`, `creator_login`) VALUES
(1, 'Default', 'https://example.org', '2024-08-12 16:28:42', 0, 1, '', '', 'America/Chicago', 'USD', 0, '', '', '', '', '', 'website', 0, 'anonymous');

-- --------------------------------------------------------

--
-- Table structure for table `ghost_site_conversion_export`
--

CREATE TABLE `ghost_site_conversion_export` (
  `idexport` bigint(20) UNSIGNED NOT NULL,
  `idsite` int(11) NOT NULL,
  `access_token` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `parameters` longtext NOT NULL,
  `ts_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `ts_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ts_requested` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_site_setting`
--

CREATE TABLE `ghost_site_setting` (
  `idsite` int(10) UNSIGNED NOT NULL,
  `plugin_name` varchar(60) NOT NULL,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` longtext NOT NULL,
  `json_encoded` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `idsite_setting` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_site_url`
--

CREATE TABLE `ghost_site_url` (
  `idsite` int(10) UNSIGNED NOT NULL,
  `url` varchar(190) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_tagmanager_container`
--

CREATE TABLE `ghost_tagmanager_container` (
  `idcontainer` varchar(8) NOT NULL,
  `idsite` int(11) UNSIGNED NOT NULL,
  `context` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL DEFAULT '',
  `ignoreGtmDataLayer` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_tagmanager_container_release`
--

CREATE TABLE `ghost_tagmanager_container_release` (
  `idcontainerrelease` bigint(20) NOT NULL,
  `idcontainer` varchar(8) NOT NULL,
  `idcontainerversion` bigint(20) UNSIGNED NOT NULL,
  `idsite` int(11) UNSIGNED NOT NULL,
  `status` varchar(10) NOT NULL,
  `environment` varchar(40) NOT NULL,
  `release_login` varchar(100) NOT NULL,
  `release_date` datetime NOT NULL,
  `deleted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_tagmanager_container_version`
--

CREATE TABLE `ghost_tagmanager_container_version` (
  `idcontainerversion` bigint(20) UNSIGNED NOT NULL,
  `idcontainer` varchar(8) NOT NULL,
  `idsite` int(11) UNSIGNED NOT NULL,
  `status` varchar(10) NOT NULL,
  `revision` mediumint(8) UNSIGNED NOT NULL DEFAULT 1,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ghost_tagmanager_container_version`
--

-- --------------------------------------------------------

--
-- Table structure for table `ghost_tagmanager_tag`
--

CREATE TABLE `ghost_tagmanager_tag` (
  `idtag` bigint(20) UNSIGNED NOT NULL,
  `idcontainerversion` bigint(20) UNSIGNED NOT NULL,
  `idsite` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` varchar(10) NOT NULL,
  `parameters` mediumtext NOT NULL DEFAULT '',
  `fire_trigger_ids` text NOT NULL DEFAULT '',
  `block_trigger_ids` text NOT NULL DEFAULT '',
  `fire_limit` varchar(20) NOT NULL DEFAULT 'unlimited',
  `priority` smallint(5) UNSIGNED NOT NULL,
  `fire_delay` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_tagmanager_trigger`
--

CREATE TABLE `ghost_tagmanager_trigger` (
  `idtrigger` bigint(20) UNSIGNED NOT NULL,
  `idcontainerversion` bigint(20) UNSIGNED NOT NULL,
  `idsite` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` varchar(10) NOT NULL,
  `parameters` mediumtext NOT NULL DEFAULT '',
  `conditions` mediumtext NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_tagmanager_variable`
--

CREATE TABLE `ghost_tagmanager_variable` (
  `idvariable` bigint(20) UNSIGNED NOT NULL,
  `idcontainerversion` bigint(20) UNSIGNED NOT NULL,
  `idsite` int(11) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` varchar(10) NOT NULL,
  `parameters` mediumtext NOT NULL DEFAULT '',
  `lookup_table` mediumtext NOT NULL DEFAULT '',
  `default_value` text DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_tracking_failure`
--

CREATE TABLE `ghost_tracking_failure` (
  `idsite` bigint(20) UNSIGNED NOT NULL,
  `idfailure` smallint(5) UNSIGNED NOT NULL,
  `date_first_occurred` datetime NOT NULL,
  `request_url` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_twofactor_recovery_code`
--

CREATE TABLE `ghost_twofactor_recovery_code` (
  `idrecoverycode` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(100) NOT NULL,
  `recovery_code` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_user`
--

CREATE TABLE `ghost_user` (
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `twofactor_secret` varchar(40) NOT NULL DEFAULT '',
  `superuser_access` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `date_registered` timestamp NULL DEFAULT NULL,
  `ts_password_modified` timestamp NULL DEFAULT NULL,
  `idchange_last_viewed` int(10) UNSIGNED DEFAULT NULL,
  `invited_by` varchar(100) DEFAULT NULL,
  `invite_token` varchar(191) DEFAULT NULL,
  `invite_link_token` varchar(191) DEFAULT NULL,
  `invite_expired_at` timestamp NULL DEFAULT NULL,
  `invite_accept_at` timestamp NULL DEFAULT NULL,
  `ts_changes_shown` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghost_user`
--

INSERT INTO `ghost_user` (`login`, `password`, `email`, `twofactor_secret`, `superuser_access`, `date_registered`, `ts_password_modified`, `idchange_last_viewed`, `invited_by`, `invite_token`, `invite_link_token`, `invite_expired_at`, `invite_accept_at`, `ts_changes_shown`) VALUES
('anonymous', '', 'anonymous@example.org', '', 0, '2024-08-12 16:27:21', '2024-08-12 16:27:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ghost.superuser', '$2y$10$btwpaO.s3lY2SBEiH4H0Wevn48FZRuJ4qQA7hYvZjR16xlenakWRa', 'support@ghostmetrics.io', '', 1, '2024-08-12 16:27:47', '2024-08-12 16:27:47', 1, NULL, NULL, NULL, NULL, NULL, '2024-08-13 03:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `ghost_user_dashboard`
--

CREATE TABLE `ghost_user_dashboard` (
  `login` varchar(100) NOT NULL,
  `iddashboard` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `layout` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_user_language`
--

CREATE TABLE `ghost_user_language` (
  `login` varchar(100) NOT NULL,
  `language` varchar(10) NOT NULL,
  `use_12_hour_clock` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ghost_user_token_auth`
--

CREATE TABLE `ghost_user_token_auth` (
  `idusertokenauth` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `password` varchar(191) NOT NULL,
  `hash_algo` varchar(30) NOT NULL,
  `system_token` tinyint(1) NOT NULL DEFAULT 0,
  `last_used` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_expired` datetime DEFAULT NULL,
  `secure_only` tinyint(2) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghost_user_token_auth`
--

INSERT INTO `ghost_user_token_auth` (`idusertokenauth`, `login`, `description`, `password`, `hash_algo`, `system_token`, `last_used`, `date_created`, `date_expired`, `secure_only`) VALUES
(1, 'anonymous', 'anonymous default token', '36de6120825ec2c9d0f7b1e28d283d27232093f5f47ffc00de05d53d29dbbd0c8dafbc14ac2bb9e6273511c11b0837fcc39ae1735f280a7520fbc3168d8d5c11', 'sha512', 0, '2024-08-13 03:44:47', '2024-08-12 16:27:21', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ghost_access`
--
ALTER TABLE `ghost_access`
  ADD PRIMARY KEY (`idaccess`),
  ADD KEY `index_loginidsite` (`login`,`idsite`);

--
-- Indexes for table `ghost_activity_log`
--
ALTER TABLE `ghost_activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ghost_alert`
--
ALTER TABLE `ghost_alert`
  ADD PRIMARY KEY (`idalert`);

--
-- Indexes for table `ghost_alert_site`
--
ALTER TABLE `ghost_alert_site`
  ADD PRIMARY KEY (`idalert`,`idsite`);

--
-- Indexes for table `ghost_alert_triggered`
--
ALTER TABLE `ghost_alert_triggered`
  ADD PRIMARY KEY (`idtriggered`);

--
-- Indexes for table `ghost_archive_invalidations`
--
ALTER TABLE `ghost_archive_invalidations`
  ADD PRIMARY KEY (`idinvalidation`),
  ADD KEY `index_idsite_dates_period_name` (`idsite`,`date1`,`period`);

--
-- Indexes for table `ghost_archive_numeric_2024_01`
--
ALTER TABLE `ghost_archive_numeric_2024_01`
  ADD PRIMARY KEY (`idarchive`,`name`),
  ADD KEY `index_idsite_dates_period` (`idsite`,`date1`,`date2`,`period`,`name`(6)),
  ADD KEY `index_period_archived` (`period`,`ts_archived`);

--
-- Indexes for table `ghost_archive_numeric_2024_07`
--
ALTER TABLE `ghost_archive_numeric_2024_07`
  ADD PRIMARY KEY (`idarchive`,`name`),
  ADD KEY `index_idsite_dates_period` (`idsite`,`date1`,`date2`,`period`,`name`(6)),
  ADD KEY `index_period_archived` (`period`,`ts_archived`);

--
-- Indexes for table `ghost_archive_numeric_2024_08`
--
ALTER TABLE `ghost_archive_numeric_2024_08`
  ADD PRIMARY KEY (`idarchive`,`name`),
  ADD KEY `index_idsite_dates_period` (`idsite`,`date1`,`date2`,`period`,`name`(6)),
  ADD KEY `index_period_archived` (`period`,`ts_archived`);

--
-- Indexes for table `ghost_bot_db`
--
ALTER TABLE `ghost_bot_db`
  ADD PRIMARY KEY (`botId`);

--
-- Indexes for table `ghost_bot_db_stat`
--
ALTER TABLE `ghost_bot_db_stat`
  ADD PRIMARY KEY (`visitId`,`botId`,`idsite`);

--
-- Indexes for table `ghost_bot_device_detector_bots`
--
ALTER TABLE `ghost_bot_device_detector_bots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ghost_bot_type`
--
ALTER TABLE `ghost_bot_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `ghost_bot_visits`
--
ALTER TABLE `ghost_bot_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ghost_brute_force_log`
--
ALTER TABLE `ghost_brute_force_log`
  ADD PRIMARY KEY (`id_brute_force_log`),
  ADD KEY `index_ip_address` (`ip_address`);

--
-- Indexes for table `ghost_changes`
--
ALTER TABLE `ghost_changes`
  ADD PRIMARY KEY (`idchange`),
  ADD UNIQUE KEY `unique_plugin_version_title` (`plugin_name`,`version`,`title`(100));

--
-- Indexes for table `ghost_custom_dimensions`
--
ALTER TABLE `ghost_custom_dimensions`
  ADD PRIMARY KEY (`idcustomdimension`,`idsite`),
  ADD UNIQUE KEY `uniq_hash` (`idsite`,`scope`,`index`);

--
-- Indexes for table `ghost_goal`
--
ALTER TABLE `ghost_goal`
  ADD PRIMARY KEY (`idsite`,`idgoal`);

--
-- Indexes for table `ghost_locks`
--
ALTER TABLE `ghost_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ghost_logger_message`
--
ALTER TABLE `ghost_logger_message`
  ADD PRIMARY KEY (`idlogger_message`);

--
-- Indexes for table `ghost_log_action`
--
ALTER TABLE `ghost_log_action`
  ADD PRIMARY KEY (`idaction`),
  ADD KEY `index_type_hash` (`type`,`hash`);

--
-- Indexes for table `ghost_log_clickid`
--
ALTER TABLE `ghost_log_clickid`
  ADD PRIMARY KEY (`idvisit`),
  ADD KEY `idvisitor` (`idvisitor`);

--
-- Indexes for table `ghost_log_conversion`
--
ALTER TABLE `ghost_log_conversion`
  ADD PRIMARY KEY (`idvisit`,`idgoal`,`buster`),
  ADD UNIQUE KEY `unique_idsite_idorder` (`idsite`,`idorder`),
  ADD KEY `index_idsite_datetime` (`idsite`,`server_time`);

--
-- Indexes for table `ghost_log_conversion_item`
--
ALTER TABLE `ghost_log_conversion_item`
  ADD PRIMARY KEY (`idvisit`,`idorder`,`idaction_sku`),
  ADD KEY `index_idsite_servertime` (`idsite`,`server_time`);

--
-- Indexes for table `ghost_log_link_visit_action`
--
ALTER TABLE `ghost_log_link_visit_action`
  ADD PRIMARY KEY (`idlink_va`),
  ADD KEY `index_idvisit` (`idvisit`),
  ADD KEY `index_idsite_servertime` (`idsite`,`server_time`);

--
-- Indexes for table `ghost_log_media`
--
ALTER TABLE `ghost_log_media`
  ADD PRIMARY KEY (`idvisit`,`idview`),
  ADD KEY `idsite` (`idsite`,`media_type`,`server_time`);

--
-- Indexes for table `ghost_log_media_plays`
--
ALTER TABLE `ghost_log_media_plays`
  ADD PRIMARY KEY (`idvisit`,`idview`);

--
-- Indexes for table `ghost_log_profiling`
--
ALTER TABLE `ghost_log_profiling`
  ADD PRIMARY KEY (`idprofiling`),
  ADD UNIQUE KEY `query` (`query`(100));

--
-- Indexes for table `ghost_log_visit`
--
ALTER TABLE `ghost_log_visit`
  ADD PRIMARY KEY (`idvisit`),
  ADD KEY `index_idsite_config_datetime` (`idsite`,`config_id`,`visit_last_action_time`),
  ADD KEY `index_idsite_datetime` (`idsite`,`visit_last_action_time`),
  ADD KEY `index_idsite_idvisitor_time` (`idsite`,`idvisitor`,`visit_last_action_time`);

--
-- Indexes for table `ghost_option`
--
ALTER TABLE `ghost_option`
  ADD PRIMARY KEY (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Indexes for table `ghost_plugin_setting`
--
ALTER TABLE `ghost_plugin_setting`
  ADD PRIMARY KEY (`idplugin_setting`),
  ADD KEY `plugin_name` (`plugin_name`,`user_login`);

--
-- Indexes for table `ghost_privacy_logdata_anonymizations`
--
ALTER TABLE `ghost_privacy_logdata_anonymizations`
  ADD PRIMARY KEY (`idlogdata_anonymization`),
  ADD KEY `job_start_date` (`job_start_date`);

--
-- Indexes for table `ghost_queuedtracking_queue`
--
ALTER TABLE `ghost_queuedtracking_queue`
  ADD PRIMARY KEY (`queue_key`);

--
-- Indexes for table `ghost_report`
--
ALTER TABLE `ghost_report`
  ADD PRIMARY KEY (`idreport`);

--
-- Indexes for table `ghost_report_subscriptions`
--
ALTER TABLE `ghost_report_subscriptions`
  ADD PRIMARY KEY (`idreport`,`email`),
  ADD UNIQUE KEY `unique_token` (`token`);

--
-- Indexes for table `ghost_segment`
--
ALTER TABLE `ghost_segment`
  ADD PRIMARY KEY (`idsegment`);

--
-- Indexes for table `ghost_sequence`
--
ALTER TABLE `ghost_sequence`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `ghost_session`
--
ALTER TABLE `ghost_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ghost_site`
--
ALTER TABLE `ghost_site`
  ADD PRIMARY KEY (`idsite`);

--
-- Indexes for table `ghost_site_conversion_export`
--
ALTER TABLE `ghost_site_conversion_export`
  ADD PRIMARY KEY (`idexport`),
  ADD UNIQUE KEY `access_token` (`access_token`);

--
-- Indexes for table `ghost_site_setting`
--
ALTER TABLE `ghost_site_setting`
  ADD PRIMARY KEY (`idsite_setting`),
  ADD KEY `idsite` (`idsite`,`plugin_name`);

--
-- Indexes for table `ghost_site_url`
--
ALTER TABLE `ghost_site_url`
  ADD PRIMARY KEY (`idsite`,`url`);

--
-- Indexes for table `ghost_tagmanager_container`
--
ALTER TABLE `ghost_tagmanager_container`
  ADD PRIMARY KEY (`idcontainer`),
  ADD KEY `idsite` (`idsite`);

--
-- Indexes for table `ghost_tagmanager_container_release`
--
ALTER TABLE `ghost_tagmanager_container_release`
  ADD PRIMARY KEY (`idcontainerrelease`),
  ADD KEY `idsite` (`idsite`,`idcontainer`);

--
-- Indexes for table `ghost_tagmanager_container_version`
--
ALTER TABLE `ghost_tagmanager_container_version`
  ADD PRIMARY KEY (`idcontainerversion`),
  ADD KEY `idcontainer` (`idcontainer`),
  ADD KEY `idsite` (`idsite`,`idcontainer`);

--
-- Indexes for table `ghost_tagmanager_tag`
--
ALTER TABLE `ghost_tagmanager_tag`
  ADD PRIMARY KEY (`idtag`),
  ADD KEY `idsite` (`idsite`,`idcontainerversion`);

--
-- Indexes for table `ghost_tagmanager_trigger`
--
ALTER TABLE `ghost_tagmanager_trigger`
  ADD PRIMARY KEY (`idtrigger`),
  ADD KEY `idsite` (`idsite`,`idcontainerversion`);

--
-- Indexes for table `ghost_tagmanager_variable`
--
ALTER TABLE `ghost_tagmanager_variable`
  ADD PRIMARY KEY (`idvariable`),
  ADD KEY `idsite` (`idsite`,`idcontainerversion`);

--
-- Indexes for table `ghost_tracking_failure`
--
ALTER TABLE `ghost_tracking_failure`
  ADD PRIMARY KEY (`idsite`,`idfailure`);

--
-- Indexes for table `ghost_twofactor_recovery_code`
--
ALTER TABLE `ghost_twofactor_recovery_code`
  ADD PRIMARY KEY (`idrecoverycode`);

--
-- Indexes for table `ghost_user`
--
ALTER TABLE `ghost_user`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `uniq_email` (`email`);

--
-- Indexes for table `ghost_user_dashboard`
--
ALTER TABLE `ghost_user_dashboard`
  ADD PRIMARY KEY (`login`,`iddashboard`);

--
-- Indexes for table `ghost_user_language`
--
ALTER TABLE `ghost_user_language`
  ADD PRIMARY KEY (`login`);

--
-- Indexes for table `ghost_user_token_auth`
--
ALTER TABLE `ghost_user_token_auth`
  ADD PRIMARY KEY (`idusertokenauth`),
  ADD UNIQUE KEY `uniq_password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ghost_access`
--
ALTER TABLE `ghost_access`
  MODIFY `idaccess` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_activity_log`
--
ALTER TABLE `ghost_activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_alert_triggered`
--
ALTER TABLE `ghost_alert_triggered`
  MODIFY `idtriggered` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_archive_invalidations`
--
ALTER TABLE `ghost_archive_invalidations`
  MODIFY `idinvalidation` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_bot_db`
--
ALTER TABLE `ghost_bot_db`
  MODIFY `botId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `ghost_bot_db_stat`
--
ALTER TABLE `ghost_bot_db_stat`
  MODIFY `visitId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_bot_device_detector_bots`
--
ALTER TABLE `ghost_bot_device_detector_bots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_bot_type`
--
ALTER TABLE `ghost_bot_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ghost_bot_visits`
--
ALTER TABLE `ghost_bot_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_brute_force_log`
--
ALTER TABLE `ghost_brute_force_log`
  MODIFY `id_brute_force_log` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ghost_changes`
--
ALTER TABLE `ghost_changes`
  MODIFY `idchange` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_logger_message`
--
ALTER TABLE `ghost_logger_message`
  MODIFY `idlogger_message` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_log_action`
--
ALTER TABLE `ghost_log_action`
  MODIFY `idaction` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_log_link_visit_action`
--
ALTER TABLE `ghost_log_link_visit_action`
  MODIFY `idlink_va` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_log_profiling`
--
ALTER TABLE `ghost_log_profiling`
  MODIFY `idprofiling` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_log_visit`
--
ALTER TABLE `ghost_log_visit`
  MODIFY `idvisit` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_plugin_setting`
--
ALTER TABLE `ghost_plugin_setting`
  MODIFY `idplugin_setting` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ghost_privacy_logdata_anonymizations`
--
ALTER TABLE `ghost_privacy_logdata_anonymizations`
  MODIFY `idlogdata_anonymization` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_report`
--
ALTER TABLE `ghost_report`
  MODIFY `idreport` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_segment`
--
ALTER TABLE `ghost_segment`
  MODIFY `idsegment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_site`
--
ALTER TABLE `ghost_site`
  MODIFY `idsite` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ghost_site_conversion_export`
--
ALTER TABLE `ghost_site_conversion_export`
  MODIFY `idexport` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_site_setting`
--
ALTER TABLE `ghost_site_setting`
  MODIFY `idsite_setting` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_tagmanager_container_release`
--
ALTER TABLE `ghost_tagmanager_container_release`
  MODIFY `idcontainerrelease` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ghost_tagmanager_container_version`
--
ALTER TABLE `ghost_tagmanager_container_version`
  MODIFY `idcontainerversion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ghost_tagmanager_tag`
--
ALTER TABLE `ghost_tagmanager_tag`
  MODIFY `idtag` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ghost_tagmanager_trigger`
--
ALTER TABLE `ghost_tagmanager_trigger`
  MODIFY `idtrigger` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ghost_tagmanager_variable`
--
ALTER TABLE `ghost_tagmanager_variable`
  MODIFY `idvariable` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ghost_twofactor_recovery_code`
--
ALTER TABLE `ghost_twofactor_recovery_code`
  MODIFY `idrecoverycode` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ghost_user_token_auth`
--
ALTER TABLE `ghost_user_token_auth`
  MODIFY `idusertokenauth` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
