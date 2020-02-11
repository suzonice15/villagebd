-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 11, 2020 at 12:12 PM
-- Server version: 10.3.22-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `villageb_cinew`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `action_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `action_name` varchar(64) NOT NULL,
  `display_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `adds`
--

CREATE TABLE `adds` (
  `adds_id` int(11) NOT NULL,
  `adds_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `adds_link` varchar(555) CHARACTER SET utf8 DEFAULT '#',
  `media_id` int(11) NOT NULL,
  `adds_type` varchar(55) DEFAULT 'sidebar',
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `blog_title` varchar(512) CHARACTER SET utf8 NOT NULL,
  `blog_name` varchar(512) CHARACTER SET utf8 NOT NULL,
  `blog_summary` longtext CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `brand_name` varchar(255) DEFAULT NULL,
  `brand_description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_time` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `career_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(155) NOT NULL,
  `cv` varchar(555) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` bigint(50) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT 100,
  `category_title` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `rank_order` int(11) DEFAULT 0,
  `category_banner` int(11) DEFAULT NULL,
  `banner_target_url` text DEFAULT NULL,
  `category_banner2` int(11) DEFAULT NULL,
  `banner_target_url2` text NOT NULL,
  `category_gallery1` int(11) DEFAULT NULL,
  `category_gallery2` int(11) DEFAULT NULL,
  `category_gallery3` int(11) DEFAULT NULL,
  `target_url1` text DEFAULT NULL,
  `target_url2` text DEFAULT NULL,
  `target_url3` text DEFAULT NULL,
  `seo_title` text CHARACTER SET utf16 DEFAULT NULL,
  `seo_meta_title` text NOT NULL,
  `seo_keywords` text CHARACTER SET utf16 DEFAULT NULL,
  `seo_content` text CHARACTER SET utf16 DEFAULT NULL,
  `seo_meta_content` text NOT NULL,
  `pcbuilder_category` varchar(3) DEFAULT 'no',
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_time` datetime DEFAULT '0000-00-00 00:00:00',
  `category_price` int(50) NOT NULL,
  `category_icon` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL,
  `coupon_name` varchar(250) NOT NULL,
  `coupon_code` varchar(250) NOT NULL,
  `coupon_start` date NOT NULL,
  `coupon_end` date NOT NULL,
  `coupon_status` tinyint(1) NOT NULL,
  `coupon_note` varchar(250) NOT NULL,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `content_rating` varchar(15) NOT NULL,
  `design_rating` varchar(15) NOT NULL,
  `easy_use_rating` varchar(15) NOT NULL,
  `overall_rating` varchar(15) NOT NULL,
  `page` varchar(255) NOT NULL,
  `email_or_phone` varchar(55) NOT NULL,
  `purpose_of_visit` varchar(255) DEFAULT NULL,
  `where_of_visit` varchar(255) DEFAULT NULL,
  `how_of_visit` varchar(255) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `created_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hitcounter`
--

CREATE TABLE `hitcounter` (
  `hitcounter_id` int(11) NOT NULL,
  `client_ip` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homeslider`
--

CREATE TABLE `homeslider` (
  `homeslider_id` int(11) NOT NULL,
  `homeslider_title` varchar(555) CHARACTER SET utf8 NOT NULL DEFAULT '#',
  `homeslider_text` text DEFAULT NULL,
  `target_url` varchar(555) CHARACTER SET utf8 NOT NULL DEFAULT '#',
  `homeslider_banner` varchar(555) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL,
  `slider_position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `inquiry_id` int(11) NOT NULL,
  `name` varchar(155) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(15) NOT NULL,
  `subject` varchar(555) CHARACTER SET utf8 NOT NULL,
  `status` varchar(6) NOT NULL DEFAULT 'unread',
  `message` text CHARACTER SET utf8 NOT NULL,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `media_id` int(11) NOT NULL,
  `relation_id` int(11) DEFAULT 0,
  `media_title` varchar(555) CHARACTER SET utf8 DEFAULT '#',
  `media_path` varchar(555) CHARACTER SET utf8 NOT NULL,
  `media_type` varchar(256) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(64) NOT NULL,
  `display_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `news_title` varchar(512) CHARACTER SET utf8 NOT NULL,
  `news_name` varchar(512) CHARACTER SET utf8 NOT NULL,
  `news_summary` longtext CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offer_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `offer_title` varchar(512) CHARACTER SET utf8 NOT NULL,
  `offer_name` varchar(512) CHARACTER SET utf8 NOT NULL,
  `offer_summary` longtext CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `option_name` varchar(155) DEFAULT NULL,
  `option_value` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `order_total` varchar(155) NOT NULL,
  `emi` int(1) DEFAULT 0,
  `order_status` varchar(15) CHARACTER SET utf8 NOT NULL DEFAULT 'new',
  `payment_type` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `products` text CHARACTER SET utf8 NOT NULL,
  `billing_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `billing_phone` varchar(15) CHARACTER SET utf8 NOT NULL,
  `billing_email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `billing_address` text CHARACTER SET utf8 DEFAULT NULL,
  `billing_city` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `billing_state` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `billing_country` varchar(55) CHARACTER SET utf8 DEFAULT 'Bangladesh',
  `shipping_charge` varchar(155) DEFAULT NULL,
  `order_note` text DEFAULT NULL,
  `view_status` varchar(6) CHARACTER SET utf8 DEFAULT 'unread',
  `status` tinyint(1) DEFAULT 1,
  `sslcommerz` text CHARACTER SET utf8 DEFAULT NULL,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL,
  `coupon_code` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orginal_hitcounter`
--

CREATE TABLE `orginal_hitcounter` (
  `hitcounter_id` bigint(250) NOT NULL,
  `client_ip` varchar(250) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `role` varchar(128) DEFAULT 'super-admin',
  `module` varchar(32) NOT NULL,
  `action` varchar(64) NOT NULL,
  `have_access` enum('yes','no') DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_author` int(11) NOT NULL,
  `post_title` text CHARACTER SET utf8 DEFAULT NULL,
  `post_name` text CHARACTER SET utf8 NOT NULL,
  `post_excerpt` text CHARACTER SET utf8 NOT NULL,
  `post_content` longtext CHARACTER SET utf8 NOT NULL,
  `post_status` varchar(20) CHARACTER SET utf8 DEFAULT 'publish',
  `comment_status` varchar(20) CHARACTER SET utf8 NOT NULL,
  `post_type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `postmeta`
--

CREATE TABLE `postmeta` (
  `meta_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_price` double DEFAULT 0,
  `discount_price` double DEFAULT 0,
  `discount_date_from` datetime DEFAULT '0000-00-00 00:00:00',
  `discount_date_to` datetime DEFAULT '0000-00-00 00:00:00',
  `product_summary` longtext CHARACTER SET utf8 DEFAULT NULL,
  `product_description` longtext DEFAULT NULL,
  `product_specification` longtext DEFAULT NULL,
  `product_type` varchar(15) CHARACTER SET utf8 DEFAULT 'general',
  `product_video` varchar(555) CHARACTER SET utf8 DEFAULT NULL,
  `product_availability` varchar(256) DEFAULT 'NULL',
  `is_live_promo` tinyint(1) DEFAULT 0,
  `seo_title` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `seo_content` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_time` datetime DEFAULT '0000-00-00 00:00:00',
  `coupon_code` int(50) NOT NULL,
  `coupon_price` varchar(250) NOT NULL,
  `coupon_status` varchar(50) NOT NULL,
  `product_order` int(11) NOT NULL,
  `product_discount` float NOT NULL,
  `coupon_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_manager_access_terms`
--

CREATE TABLE `product_manager_access_terms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `term_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `quote_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `components` text NOT NULL,
  `email_send` varchar(3) DEFAULT 'no',
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `recyclebin`
--

CREATE TABLE `recyclebin` (
  `recyclebin_id` int(11) NOT NULL,
  `table_name` varchar(128) DEFAULT NULL,
  `table_id` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT 0,
  `recyclebin_status` tinyint(1) DEFAULT 0 COMMENT '0 for delete 1 for update',
  `created_time` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `rating` varchar(5) DEFAULT '1',
  `created_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saved_pc`
--

CREATE TABLE `saved_pc` (
  `pc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `components` text NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `service_title` varchar(512) NOT NULL,
  `service_name` varchar(512) NOT NULL,
  `service_summary` longtext NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `term_relation`
--

CREATE TABLE `term_relation` (
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `top_view_product`
--

CREATE TABLE `top_view_product` (
  `view_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `term_id` text DEFAULT NULL,
  `client_ip` varchar(55) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usermeta`
--

CREATE TABLE `usermeta` (
  `user_meta_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_phone` varchar(55) DEFAULT NULL,
  `user_email` varchar(155) NOT NULL,
  `user_login` varchar(55) DEFAULT NULL,
  `user_pass` varchar(64) NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `user_status` varchar(9) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `registered_date` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_date` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`action_id`);

--
-- Indexes for table `adds`
--
ALTER TABLE `adds`
  ADD PRIMARY KEY (`adds_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`career_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `hitcounter`
--
ALTER TABLE `hitcounter`
  ADD PRIMARY KEY (`hitcounter_id`);

--
-- Indexes for table `homeslider`
--
ALTER TABLE `homeslider`
  ADD PRIMARY KEY (`homeslider_id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`inquiry_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_manager_access_terms`
--
ALTER TABLE `product_manager_access_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`quote_id`);

--
-- Indexes for table `recyclebin`
--
ALTER TABLE `recyclebin`
  ADD PRIMARY KEY (`recyclebin_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `saved_pc`
--
ALTER TABLE `saved_pc`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `term_relation`
--
ALTER TABLE `term_relation`
  ADD PRIMARY KEY (`product_id`,`term_id`),
  ADD KEY `term_taxonomy_id` (`term_id`);

--
-- Indexes for table `top_view_product`
--
ALTER TABLE `top_view_product`
  ADD PRIMARY KEY (`view_id`);

--
-- Indexes for table `usermeta`
--
ALTER TABLE `usermeta`
  ADD PRIMARY KEY (`user_meta_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `action_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adds`
--
ALTER TABLE `adds`
  MODIFY `adds_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hitcounter`
--
ALTER TABLE `hitcounter`
  MODIFY `hitcounter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homeslider`
--
ALTER TABLE `homeslider`
  MODIFY `homeslider_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postmeta`
--
ALTER TABLE `postmeta`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_manager_access_terms`
--
ALTER TABLE `product_manager_access_terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recyclebin`
--
ALTER TABLE `recyclebin`
  MODIFY `recyclebin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_pc`
--
ALTER TABLE `saved_pc`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `top_view_product`
--
ALTER TABLE `top_view_product`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usermeta`
--
ALTER TABLE `usermeta`
  MODIFY `user_meta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
