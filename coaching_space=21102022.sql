-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2022 at 10:47 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coaching_space`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 for Admin and 2 For Third Level User',
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 for active, 2 for inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_type`, `name`, `email`, `password`, `remember_token`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Admin Test', 'admin@coachingspace.com', '$2y$10$sYkQQjhEtTZPxAqlpx63vONXv5DUIcqIxbh.mmga6/0KT22ED5cCy', '9nn4xiG3PXNs46G8YO1IuFnbGO26thvztxqEcsdCuJPmj1dhBhtDluVLZp9n', '1', NULL, '2022-06-15 13:53:09', NULL),
(2, '2', 'Coach Admin', 'coachadmin@coachingspace.com', '$2y$10$Qlqp9kKxU7Ko5DtqhKr7Se2UaoykEl75FSMKj6fSvjoGZbBcntuQO', '', '1', '2022-06-08 13:06:17', '2022-06-15 13:52:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `availability_dates`
--

CREATE TABLE `availability_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coach_id` int(10) UNSIGNED NOT NULL,
  `day` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('available','blocked') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_slots` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagline` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coaching_level` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strengths` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avg_rating` double(8,2) DEFAULT 0.00,
  `rating_count` int(11) DEFAULT 0,
  `calendly_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not active, 1=active',
  `created_by` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`id`, `first_name`, `last_name`, `slug`, `name`, `email`, `phone_number`, `profile_image`, `tagline`, `short_description`, `about`, `coaching_level`, `strengths`, `avg_rating`, `rating_count`, `calendly_link`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Kamal', 'Test', 'kamal-test', 'Kamal Test', 'kamal.nyusoft@gmail.com', '0123456789', NULL, 'Tagline', 'Short Description Short Description Short Description Short Description Short Description Short Description', 'About Short Description Short Description Short Description Short Description Short Description Short Description', NULL, NULL, 1.00, 1, NULL, 1, 1, '2022-04-06 00:53:08', '2022-04-06 01:11:56', NULL),
(3, 'K', 'Taa', 'k-taa-3', 'K Taa', 'k@k.k', '0123456789', 'coach/slBIVb5slb.png', 'Tag', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 'da', NULL, NULL, 5.00, 0, NULL, 0, 1, '2022-04-06 01:06:16', '2022-04-06 01:09:36', NULL),
(4, 'AA', 'B', 'aa-b-4', 'AA B', 'a@a.a', '0123456789', NULL, 'Developer', 'Short Description Short Description Short Description Short Description Short Description Short Description', 'About Short Description Short Description Short Description Short Description Short Description Short Description', NULL, NULL, 2.00, 2, NULL, 1, 1, '2022-04-06 01:09:54', '2022-04-06 01:10:47', NULL),
(5, 'Kk', 'Tt', 'kk-tt-5', 'Kk Tt', 'kkk@kk.kk', '0123456789', 'coach/slBIVb5slb.png', 'dsf', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 'About Short Description Short Description Short Description Short Description Short Description Short Description', '[\"3\",\"2\"]', '[\"3\",\"2\"]', 3.00, 3, 'http://localhost/coaching-space/admin/coach/', 1, 1, '2022-04-06 07:09:34', '2022-04-06 07:33:11', NULL),
(6, 'jqpdsuln', 'organizations', 'jqpdsuln-organizations-6', 'jqpdsuln organizations', 'jqpdsuln@sharklasers.com', NULL, NULL, 'Wordpress Developer', 'Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer', 'Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer', NULL, NULL, 1.00, 1, NULL, 1, 1, '2022-04-14 01:56:21', '2022-04-14 02:01:45', NULL),
(7, 'Coach', 'One', 'coach-one-7', 'Coach One', 'coachone@gg.com', NULL, NULL, 'Laravel Developer', 'Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer', 'Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer', NULL, NULL, 4.00, 10, NULL, 1, 1, '2022-04-14 06:45:14', '2022-04-14 06:46:07', NULL),
(8, 'marit', 'marit', 'marit-marit-8', 'marit marit', 'marit@yopmail.com', '+15454645644', NULL, 'ss', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 'sSAsas', NULL, NULL, 2.00, 3, NULL, 1, 1, '2022-04-19 10:13:56', '2022-04-19 11:06:25', NULL),
(9, 'today', 'don', 'today-don-9', 'today don', 'don@yopmail.com', '+154546432555', NULL, '2rerwefwf', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 'wfwfwef', NULL, NULL, 3.00, 2, NULL, 1, 1, '2022-04-19 11:17:58', '2022-04-20 12:39:28', NULL),
(10, 'Test', 'CoachingCoach', 'test-coachingcoach-10', 'Test CoachingCoach', 'testcoachingcoach@sharklasers.com', '0123456789', NULL, 'Wordpress Developer', 'Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer', 'Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer Wordpress Developer', '[\"3\",\"2\"]', '[\"3\",\"2\"]', 0.00, 0, NULL, 1, 1, '2022-04-20 11:12:11', '2022-06-14 14:57:40', NULL),
(11, 'Coach', 'SpaceCoach', 'coach-spacecoach-11', 'Coach SpaceCoach', 'coachspace@yopmail.com', NULL, NULL, 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing a', 'testing purpose', '[\"4\"]', '[\"3\"]', 4.00, 1, NULL, 1, 1, '2022-04-20 12:57:17', '2022-06-14 14:57:07', NULL),
(12, 'Mikeee', 'Patel', 'mikeee-patel-12', 'Mikeee Patel', 'mikee@yopmail.com', '0123456789', NULL, 'What is Lorem Ipsum?s', 'Lorem Ipsum is simply dummy text of the printing a...', 'Lorem Ipsum is simply dummy text of the printing a...', '[\"4\"]', '[\"3\"]', 3.67, 3, NULL, 1, 1, '2022-04-21 05:18:19', '2022-06-14 14:55:49', NULL),
(15, 'CoachSpace', 'coach', 'coachspace-coach-15', 'CoachSpace coach', 'coachspacename@yopmail.com', '1234567895', NULL, 'Web Expert + Node Dev', 'testing purpose', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '[\"4\"]', '[\"3\"]', 4.00, 1, NULL, 1, 1, '2022-05-17 16:00:58', '2022-09-05 12:16:48', NULL),
(16, 'kushcoach', 'kuius', 'kushcoach-kuius-16', 'kushcoach kuius', 'kcoach@yopmail.com', '4454544554', NULL, 'f', 'fdsfsfsfsf', 'sfsfsf', NULL, NULL, 5.00, 2, NULL, 1, 1, '2022-05-18 12:39:40', '2022-05-24 14:33:16', NULL),
(17, 'TXT', 'Coach', 'txt-coach-17', 'TXT Coach', 'txtcoach@yopmail.com', '1234567896', NULL, 'Web Expert + Node Dev', 'testing purpose', 'test', '[\"4\",\"3\",\"2\"]', '[\"3\",\"2\"]', 4.00, 1, 'https://calendly.com/', 1, 1, '2022-05-24 10:54:43', '2022-05-24 12:33:40', NULL),
(18, 'TXT', 'Coach Name', 'txt-coach-18', 'TXT Coach Name', 'txtcoach1@yopmail.com', '1234567895', NULL, 'Web Expert + Node Dev', 'testing purpose', 'testing purpose', '[\"4\"]', '[\"4\"]', 0.00, 0, NULL, 1, 2, '2022-06-10 15:09:29', '2022-06-14 14:54:38', NULL),
(19, 'Andy', 'Coach', 'andy-coach-19', 'Andy Coach', 'andytesting@yopmail.com', '0123456789', NULL, 'Wordpress Developer', 'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum', 'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum', '[\"5\",\"4\"]', '[\"4\",\"3\"]', 3.00, 5, NULL, 1, 2, '2022-06-15 15:49:30', '2022-06-15 15:50:51', NULL),
(20, 'Andy', 'Two', 'andy-two-20', 'Andy Two', 'andytesting01@yopmail.com', NULL, NULL, 'IT Hub', 'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum', 'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum', '[\"3\",\"2\"]', '[\"3\",\"2\"]', 3.00, 5, NULL, 1, 1, '2022-06-17 09:34:02', '2022-06-17 09:34:02', NULL),
(21, 'Andy', 'Third', 'andy-third-21', 'Andy Third', 'andytesting03@yopmail.com', NULL, NULL, 'Laravel Developer Laravel Developer Laravel Developer', 'Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer', 'Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer Laravel Developer', '[\"2\"]', '[\"2\"]', 0.00, 0, NULL, 1, 2, '2022-06-17 09:40:31', '2022-06-17 09:42:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coaching_levels`
--

CREATE TABLE `coaching_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coaching_levels`
--

INSERT INTO `coaching_levels` (`id`, `title`, `created_at`, `updated_at`) VALUES
(2, 'Coaching Level1', '2022-04-06 06:49:21', '2022-04-20 12:13:41'),
(3, 'Coaching Level2', '2022-04-06 06:49:21', '2022-04-20 12:13:47'),
(4, 'Coaching Level3', '2022-04-15 13:30:18', '2022-04-20 12:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `id` int(10) UNSIGNED NOT NULL,
  `header_id` int(10) UNSIGNED NOT NULL,
  `footer_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 for active, 2 for inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `header_id`, `footer_id`, `title`, `subject`, `body`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Verify Email', 'Verify Email', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Please click the button below to verify your email address.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #00aee8;border-radius: 10px; border :thin solid #00aee8;\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">VERIFY EMAIL</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">If you did not create an account, no further action is required.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">If you&#39;re having trouble clicking the &quot;Verify Email Address&quot; button, copy and paste the URL below into your web browser: <a href=\"{LINK}\">{LINK}</a></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-07-28 04:06:49', NULL),
(2, 1, 1, 'New Request | Admin', 'New Request', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello Admin!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">You have new user request. Details are below.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 10px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">User Name : {NAME}.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Mail Id : {EMAIL}.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Phone number : {PHONE}.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Country : {COUNTRY}.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #00aee8;border-radius: 10px; border :thin solid #00aee8;\" width=\"210\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">VIEW USER</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-07-28 04:06:56', NULL),
(3, 1, 1, 'Invitation', 'Invitation', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><strong>You have an invitation from {FIRST_NAME} {LAST_NAME}.</strong></p>\r\n\r\n			<p>{MESSAGE}</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\" width=\"150\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">LOGIN</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-09-19 23:53:27', NULL),
(4, 1, 1, 'Reset password | User', 'Reset Password', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Reset Password</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Dear <b>{NAME}</b>, you are receiving this email because you requested to reset your password.</p>\r\n\r\n			<p style=\"margin-top: 30px;margin-bottom: 0px;\">Click the button below to reset your password.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #00aee8;border-radius: 10px; border :thin solid #00aee8;\" width=\"210\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">RESET PASSWORD</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">If you did not request this, please contact <a href=\"{LINK_1}\">support</a> for assistance.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-09-13 20:49:35', NULL),
(5, 1, 1, 'Approved New User Request | User', 'Congratulation!! Your profile is approved.', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Congratulation !!&nbsp;</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Your Profile on MD Elevated is approved.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Kindly click on below button to login to your account.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><b>{REMARK}</b></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\" width=\"210\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">LOGIN</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-08-17 13:37:48', '2021-09-05 13:00:00'),
(6, 1, 1, 'Declined New User Request | User', 'New User Request -Declined', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Sorry to say but your request is declined by Admin. Below is the reason.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><b>{REMARK}</b></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-07-28 04:04:45', '2021-09-05 13:00:00'),
(24, 1, 1, 'Contact Us | Admin', 'Contact us', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" data-module=\"hero-white-icon-outline0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" data-bgcolor=\"Bg White\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\"><!--[if mso]>\r\n<table width=\"584\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">\r\n<![endif]-->\r\n			<div data-color=\"Light\" data-max=\"23\" data-min=\"15\" data-size=\"Text MD\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 data-color=\"Dark\" data-max=\"40\" data-min=\"20\" data-size=\"Heading 2\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Contact us</h2>\r\n			<!-- <p style=\"margin-top: 0px;margin-bottom: 0px;\">That thus much less heron other hello</p> --></div>\r\n			<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><!--[if mso]>\r\n<table width=\"800\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<![endif]-->\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" style=\"max-width: 800px;margin: 0 auto;\" width=\"100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Full Name</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{NAME}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Email</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{EMAIL}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Country</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{COUNTRY}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Phone Number</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{PHONE}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 600px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Message</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"100\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 600px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{MESSAGE}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-02-08 21:32:12', '2021-09-14 19:11:57', NULL),
(23, 1, 1, 'Contact Us | User', 'Contact us', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" data-module=\"hero-white-icon-outline0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" data-bgcolor=\"Bg White\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\"><!--[if mso]>\r\n                <table width=\"584\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <td align=\"center\">\r\n                                <![endif]-->\r\n			<div data-color=\"Light\" data-max=\"23\" data-min=\"15\" data-size=\"Text MD\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 data-color=\"Dark\" data-max=\"40\" data-min=\"20\" data-size=\"Heading 2\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Thank you for getting in touch.</h2>\r\n			<!-- <p style=\"margin-top: 0px;margin-bottom: 0px;\">That thus much less heron other hello</p> --></div>\r\n			<!--[if mso]>\r\n                            </td>\r\n                        </tr>\r\n                </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<!-- ------------------------------------------------ -->\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" data-module=\"button-dark0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" data-bgcolor=\"Bg White\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\"><!-- -------------------------------------- -->\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\">\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">We will review your message and come back to you shortly. Thank you for reaching out to the MD Elevated. We look forward to connecting soon.</p>\r\n						</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			<!-- --------------------------------------- --></td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-02-08 21:31:41', '2021-09-14 19:12:04', NULL),
(32, 1, 1, 'User Approved | User', 'User Approved', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Congratulations! Admin has approved your profile.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #00aee8;border-radius: 10px; border :thin solid #00aee8;\" width=\"300\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">LOG IN</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-09-17 03:00:15', NULL),
(31, 1, 1, 'User On Hold | User', 'User On Hold', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Sorry to say but Admin has put you on hold. Below is the reason.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><b>{REMARK}</b></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 14:27:51', '2021-09-09 18:16:46', NULL),
(33, 1, 1, 'Account created!', 'Account created!', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">{MESSAGE}</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2022-04-16 17:05:34', '2022-04-16 19:12:46', NULL),
(34, 1, 1, 'User Status Change', 'User Status Change', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">{MESSAGE}</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', NULL, NULL, NULL),
(38, 1, 1, '1day or 3day before email | User | Coach', '1day or 3day before email | User | Coach', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\"><tbody><tr><td style=\"text-align: left;padding: 5px 15px;\"><p style=\"font-size:20px;\">{MESSAGE}</p><p>Please find below session details:</p><p><strong>Session ID : </strong>#{SESSION_ID}</p><p><strong>Date/Time : </strong>{DATE_TIME}</p><p><strong>Coach: </strong>{COACH_NAME}</p><p><strong>User: </strong>{USERNAME}</p></td></tr>\r\n<tr><td style=\"text-align: left;padding: 10px 15px;\"><div style=\"display: block; width: 100%; text-align: left;\"><a target=\"_blank\" style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \" href=\"{LINK_1}\"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">MS Teams Link </span></a></div></td></tr><tr><td style=\"text-align: left;padding: 10px 15px;\"><div style=\"display: block; width: 100%; text-align: left;\"><a target=\"_blank\" style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \" href=\"{LINK}\"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">View Session </span></a></div></td></tr><tr><td style=\"text-align: left;padding: 5px 15px;\"><div style=\"display: block; width: 100%; text-align: left;\">&nbsp;</div></td></tr><tr><td style=\"text-align: left;padding: 5px 15px; white-space: inherit; word-break: break-all; display: table;\"><p><strong>So be ready in time to meet and discuss with them.</strong></p></td></tr></tbody></table>', '1', '2022-05-03 04:55:51', '2022-05-11 07:47:51', NULL),
(39, 1, 1, 'Give a review for the session | User', 'Give a review for the session | User', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">\r\n<p style=\"font-size:20px;\">{MESSAGE}</p>\r\n<p>To make sure that we continue to provide the support you need, we would like to ask you to review your coach.</p>\r\n<p>Please find below session details:</strong></p>\r\n<p><strong>Session ID : </strong>#{SESSION_ID}</p>\r\n<p><strong>Date/Time : </strong>{DATE_TIME}</p>\r\n<p><strong>Coach: </strong>{COACH_NAME}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">          \r\n<div style=\"display: block; width: 100%; text-align: left;\">\r\n<a href=\"{LINK}\" target=\"_blank\"  style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">Give Review</span></a>\r\n</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px; white-space: inherit; word-break: break-all; display: table;\">\r\n</td>\r\n</tr>\r\n</table>', '1', '2022-05-03 04:55:51', NULL, NULL),
(40, 1, 1, 'User has reviewed your session | Coach', 'User has reviewed your session | Coach', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">\r\n<p style=\"font-size:20px;\">{MESSAGE}</p>\r\n<p>Please find below session details:</strong></p>\r\n<p><strong>Session ID : </strong>#{SESSION_ID}</p>\r\n<p><strong>Date/Time : </strong>{DATE_TIME}</p>\r\n<p><strong>User: </strong>{USERNAME}</p>\r\n<p>---------------------------------------------------------------</p>\r\n<p><strong>Overall Experience : </strong>{OVERALL_EXPERIENCE}</p>\r\n<p><strong>Attentiveness : </strong>{ATTENTIVENESS}</p>\r\n<p><strong>Communication : </strong>{COMMUNICATION}</p>\r\n<p><strong>Active Listening and Questioning : </strong>{ACTIVE_LISTING_QUESTIONING}</p>\r\n<p><strong>Review</strong>: {REVIEW}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">          \r\n<div style=\"display: block; width: 100%; text-align: left;\">\r\n\r\n</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px; white-space: inherit; word-break: break-all; display: table;\">\r\n</td>\r\n</tr>\r\n</table>', '1', '2022-05-03 04:55:51', NULL, NULL),
(41, 1, 1, 'User reviewed | Admin', 'User reviewed | Admin', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">\r\n<p style=\"font-size:20px;\">{MESSAGE}</p>\r\n<p><strong>Session ID : </strong>#{SESSION_ID}</p>\r\n<p><strong>Date/Time : </strong>{DATE_TIME}</p>\r\n<p><strong>User: </strong>{USERNAME}</p>\r\n<p><strong>Coach: </strong>{COACH_NAME}</p>\r\n<p>---------------------------------------------------------------</p>\r\n<p><strong>Overall Experience : </strong>{OVERALL_EXPERIENCE}</p>\r\n<p><strong>Attentiveness : </strong>{ATTENTIVENESS}</p>\r\n<p><strong>Communication : </strong>{COMMUNICATION}</p>\r\n<p><strong>Active Listening and Questioning : </strong>{ACTIVE_LISTING_QUESTIONING}</p>\r\n<p><strong>Review</strong>: {REVIEW}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">          \r\n<div style=\"display: block; width: 100%; text-align: left;\">\r\n<a href=\"{LINK}\" target=\"_blank\"  style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">View Session</span></a>\r\n</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px; white-space: inherit; word-break: break-all; display: table;\">\r\n</td>\r\n</tr>\r\n</table>', '1', '2022-05-03 04:55:51', NULL, NULL),
(42, 1, 1, 'Asking for a session report | Coach', 'Asking for a session report | Coach', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">\r\n<p>Thank you for your coaching session with <strong>{USERNAME}</strong>.</p>\r\n<p><strong>Session ID : </strong>#{SESSION_ID}</p>\r\n<p><strong>Date / Time : </strong>{DATE_TIME}</p>\r\n<p>For our records, we would like you to know what the theme of session was?</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px;\">          \r\n<div style=\"display: block; width: 100%; text-align: left;\">\r\n<a href=\"{LINK}\" target=\"_blank\"  style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">Add Session Report</span></a>\r\n</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: left;padding: 5px 15px; white-space: inherit; word-break: break-all; display: table;\">\r\n</td>\r\n</tr>\r\n</table>', '1', '2022-05-03 04:55:51', NULL, NULL),
(43, 1, 1, 'Coach has reported on session | Admin', 'Coach has reported on session | Admin', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n	<tr>\r\n		<td style=\"text-align: left;padding: 10px 15px;\">\r\n			<p style=\"font-size:20px;\">{MESSAGE}</p>\r\n			<p><strong>Session ID : </strong>#{SESSION_ID}</p>\r\n			<p><strong>Date / Time : </strong>{DATE_TIME}</p>\r\n			<p><strong>User: </strong>{USERNAME}</p>\r\n			<p><strong>Coach: </strong>{COACH_NAME}</p>\r\n			<p>---------------------------------------------------------------</p>\r\n			<p><strong>Session Report</strong>: {SESSION_REPORT}</p>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\"text-align: left;padding: 10px 15px;\">          \r\n			<div style=\"display: block; width: 100%; text-align: left;\">\r\n				<a href=\"{LINK}\" target=\"_blank\"  style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">View Session</span></a>\r\n			</div>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\"text-align: left;padding: 10px 15px; white-space: inherit; word-break: break-all; display: table;\">\r\n		</td>\r\n	</tr>\r\n</table>', '1', '2022-05-03 04:55:51', NULL, NULL),
(44, 1, 1, 'Account created | User', 'Account created | User', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n     <tr>\r\n          <td style=\"text-align: left;padding: 10px 15px;\">\r\n               <p style=\"font-size:20px;\">{MESSAGE}</p>\r\n               <p>Please check your login details:</strong></p>\r\n               <p><strong>Email : </strong>{EMAIL}</p>\r\n               <p><strong>Password : </strong>{PASSWORD}</p>\r\n          </td>\r\n     </tr>\r\n     <tr>\r\n          <td style=\"text-align: left;padding: 10px 15px;\">          \r\n               <div style=\"display: block; width: 100%; text-align: left;\">\r\n                    <a href=\"{LINK}\" target=\"_blank\"  style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">Login</span></a>\r\n               </div>\r\n          </td>\r\n     </tr>\r\n     <tr>\r\n          <td style=\"text-align: left;padding: 10px 15px; white-space: inherit; word-break: break-all; display: table;\">\r\n          </td>\r\n     </tr>\r\n</table>', '1', '2022-05-04 06:15:11', NULL, NULL);
INSERT INTO `email_template` (`id`, `header_id`, `footer_id`, `title`, `subject`, `body`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(45, 1, 1, 'Booking Confirmation with MS Team Link', 'Booking Confirmation with MS Team Link', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n	<tr>\r\n		<td style=\"text-align: left;padding: 5px 15px;\">\r\n<p style=\"font-size:20px;\">{MESSAGE}</p>\r\n			<p>Please find below session details:</strong></p>\r\n			<p><strong>Session ID : </strong>#{SESSION_ID}</p>\r\n			<p><strong>Date/Time : </strong>{DATE_TIME}</p>\r\n			<p><strong>Coach: </strong>{COACH_NAME}</p>\r\n			<p><strong>User: </strong>{USERNAME}</p>\r\n			<p><strong>Like to discuss: </strong>{DISCUSSION}</p>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\"text-align: left;padding: 10px 15px;\">          \r\n			<div style=\"display: block; width: 100%; text-align: left;\">\r\n				<a href=\"{LINK}\" target=\"_blank\"  style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">MS Teams Link </span></a>\r\n			</div>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\"text-align: left;padding: 5px 15px;\">          \r\n			<div style=\"display: block; width: 100%; text-align: left;\">\r\n				\r\n			</div>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\"text-align: left;padding: 5px 15px; white-space: inherit; word-break: break-all; display: table;\">\r\n			<p><strong>So be ready in time to meet and discuss with them.</strong></p>\r\n		</td>\r\n	</tr>\r\n</table>', '1', '2022-05-03 04:55:51', NULL, NULL),
(46, 1, 1, 'Cancel Session', 'Cancel Session', '<table class=\"btn btn-primary\" style=\"max-width: 600px; width: 100%; margin: 0 auto; table-layout: fixed; display: table;\">\r\n <tr>\r\n <td style=\"text-align: left;padding: 5px 15px;\">\r\n <p style=\"font-size:20px;\">{MESSAGE}</p>\r\n <p>Please find below session details:</strong></p>\r\n <p><strong>Session ID : </strong>#{SESSION_ID}</p>\r\n <p><strong>Date/Time : </strong>{DATE_TIME}</p>\r\n <p><strong>Coach: </strong>{COACH_NAME}</p>\r\n <p><strong>User: </strong>{USERNAME}</p>\r\n <p><strong>Cancel Reason: </strong>{DISCUSSION}</p>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td style=\"text-align: left;padding: 10px 15px;\"> \r\n <div style=\"display: block; width: 100%; text-align: left;\">\r\n <a href=\"{LINK}\" target=\"_blank\" style=\"display: inline-block;text-decoration: none; font-size: 14px; font-weight: bold; \"><span class=\"link\" style=\"display: table;text-align: center; padding: 10px 25px; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-transform: capitalize; border-color: #3498db;\">View Session Details</span></a>\r\n </div>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td style=\"text-align: left;padding: 5px 15px;\"> \r\n <div style=\"display: block; width: 100%; text-align: left;\">\r\n \r\n </div>\r\n </td>\r\n </tr>\r\n</table>', '1', '2022-05-03 04:55:51', NULL, NULL),
(47, 1, 1, '2 Months Before Reminder Email | User', '2 Months Before Reminder Email | User', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">We wanted to remind you that you did not book any sessions for the last 2 months.</p>\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">{MESSAGE}</p>\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">We look forward to seeing you. If you are unable to book your session, please contact us at hello@coachingspace.co.uk</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2022-09-12 12:12:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_template_footer`
--

CREATE TABLE `email_template_footer` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 for active, 2 for inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_template_footer`
--

INSERT INTO `email_template_footer` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Footer 1', '<!--footer-->\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"font-size: 48px;line-height: 20px;height: 20px;background-color: #ffffff;\">&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #f2f2f2;padding-left: 16px;padding-right: 16px;padding-bottom: 23px;\">\r\n			<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\">\r\n						<div style=\"font-size: 32px; line-height: 32px; height: 32px;\">&nbsp;</div>\r\n\r\n						<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 9px;margin-bottom: 14px;font-size: 14px;line-height: 21px;color:#333;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 8px;width: 100%;\">{COPYRIGHT}</p>\r\n						</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<!--footer-->\r\n</div>', '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_template_header`
--

CREATE TABLE `email_template_header` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 for active, 2 for inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_template_header`
--

INSERT INTO `email_template_header` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Header', '<title></title><link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" /><style media=\"screen\" type=\"text/css\">[style*=\'Open Sans\'] {\r\n            font-family: \'Open Sans\', Arial, sans-serif !important\r\n            }</style><div style=\"width: 700px;margin-left: auto;margin-right: auto;\"><div><!--header--><div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\'; margin-top: 0px; margin-bottom: 0px; font-size: 14px; line-height: 24px; background-color:#f2f2f2; padding: 24px;\"><p style=\"margin-top: 0px;margin-bottom: 0px;\"><a style=\"text-decoration: none;outline: none;color: #ffffff;\" href=\"{BASE_URL}\"><img alt=\"\" height=\"37\" style=\"max-width:100px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;\" width=\"240\" src=\"{LOGO}\" /></a></p></td></tr></tbody></table>', '1', NULL, '2022-05-02 13:07:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `slug`, `title`, `image`, `icon`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'facility-01', 'Facility 01', NULL, 'Facility 01', 1, '2022-04-01 09:02:41', '2022-04-01 09:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2022_03_24_095942_create_settings_table', 1),
(2, '2022_03_25_000000_create_admins_table', 1),
(3, '2022_03_26_000001_create_users_table', 1),
(4, '2022_03_27_100000_create_password_resets_table', 1),
(5, '2022_03_28_000000_create_failed_jobs_table', 1),
(6, '2022_03_28_095946_create_pages_table', 1),
(7, '2022_03_29_000000_create_facilities_table', 1),
(21, '2022_03_30_000000_create_reviews_table', 10),
(9, '2022_03_30_000000_create_organizations_table', 2),
(10, '2022_04_05_071233_create_coaches_table', 3),
(11, '2022_04_05_071234_create_coaching_levels_table', 4),
(12, '2022_04_05_071235_create_strengths_table', 5),
(13, '2022_04_10_000000_create_email_template_header_table', 6),
(14, '2022_04_10_000001_create_email_template_footer_table', 6),
(15, '2022_04_10_000002_create_email_template_table', 6),
(16, '2014_10_12_100000_create_password_resets_table', 7),
(22, '2022_04_21_063944_create_session_table', 11),
(20, '2022_04_26_123735_create_availability_dates_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessions_limit` int(10) DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=not active, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `first_name`, `last_name`, `company_name`, `email`, `phone_number`, `sessions_limit`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Nyusoft', 'Solutions', 'Nyusoft1 Solutions1', 'nyusoft11@gmailll.com', '0123456789', 2, 0, '2022-04-04 06:32:07', '2022-09-01 06:28:00', NULL),
(6, 'Nyusoft', 'Solutions', 'Nyusoft Solutions', 'nyusoft@gmailll.com', '0123456789', 2, 1, '2022-04-04 06:32:07', '2022-04-04 06:32:07', NULL),
(9, 'OM', 'Tech', 'OM Tech', 'jqpdsuln@sharklasers.com', NULL, 5, 1, '2022-04-14 00:58:39', '2022-04-20 13:18:25', NULL),
(10, 'Test', 'Organization', 'Test Organization', 'testorganization@sharklasers.com', '0123456789', 0, 1, '2022-04-20 10:22:28', '2022-04-20 12:22:57', NULL),
(11, 'kylance', 'node', 'nyusofft', 'nyusoft@yopmail.com', '12313123', 0, 1, '2022-04-20 11:26:37', '2022-04-20 12:16:39', '2022-04-20 12:16:39'),
(13, 'Microsoft', 'Inc', 'Microsoft Inc', 'coachspaceuser@yopmail.com', NULL, 0, 0, '2022-04-20 12:55:34', '2022-06-14 07:31:02', NULL),
(14, 'Organization', 'High', 'Wipro Co', 'xbtjcnbc@sharklasers.com', '0123456789', 0, 1, '2022-04-20 13:09:24', '2022-04-25 01:17:31', '2022-04-25 01:17:31');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_meta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=not active, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `review_by` int(10) UNSIGNED NOT NULL,
  `review_for` int(10) UNSIGNED NOT NULL,
  `overall_rating` int(11) NOT NULL,
  `attentiveness` int(11) NOT NULL,
  `communication` int(11) NOT NULL,
  `active_listening` int(11) NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=not active, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `session_id`, `review_by`, `review_for`, `overall_rating`, `attentiveness`, `communication`, `active_listening`, `review`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 3, 2, 2, 2, 3, 1, 'test2', 1, '2022-04-28 11:41:56', NULL),
(2, 6, 3, 2, 1, 2, 3, 1, 'test1', 1, '2022-04-28 11:41:56', '2022-04-28 13:41:06'),
(3, 6, 3, 2, 3, 2, 3, 1, 'test3', 1, '2022-04-28 11:41:56', '2022-04-28 13:59:57'),
(5, 7, 28, 12, 4, 3, 5, 3, 'ddd', 1, '2022-05-03 07:41:15', '2022-05-03 07:41:15'),
(6, 15, 6, 11, 4, 2, 3, 4, 'tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd tests    sdddd', 1, '2022-05-03 13:14:16', '2022-05-03 13:14:16'),
(7, 45, 6, 12, 5, 3, 2, 4, '', 1, '2022-06-14 11:11:42', '2022-06-14 11:11:42'),
(8, 2, 6, 15, 4, 4, 3, 4, 'dddd', 1, '2022-09-05 12:16:48', '2022-09-05 12:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coach_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `organization_id` int(10) DEFAULT NULL,
  `date` date NOT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_start_time` datetime NOT NULL,
  `session_end_time` datetime NOT NULL,
  `like_to_discuss` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `3days_before_email` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not sent, 1=sent',
  `1day_before_email` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not sent, 1=sent',
  `is_user_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=no, 1=yes',
  `session_report` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ms_join_web_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'MS Link Join Web URL',
  `ms_response_json` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'we store data into json',
  `status` enum('upcoming','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `coach_id`, `user_id`, `organization_id`, `date`, `time`, `session_start_time`, `session_end_time`, `like_to_discuss`, `user_notes`, `3days_before_email`, `1day_before_email`, `is_user_reviewed`, `session_report`, `ms_join_web_url`, `ms_response_json`, `status`, `cancel_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 15, 6, 7, '2022-09-12', '10:00 - 10:45', '2022-09-12 10:00:00', '2022-09-12 10:45:00', 'fsf', 'gdgdf', 0, 0, 0, NULL, 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_MmNiMjJiNmItZTEzYS00NzY5LWIyZjMtOTg1NjA1ZmI0ZTUy%40thread.v2/0?context=%7b%22Tid%22%3a%22a2f33be8-5e76-486e-8b72-d5ea619a9fda%22%2c%22Oid%22%3a%2207a06403-9693-4d53-ac59-878bfd24e7a5%22%7d', '{\"@odata.context\":\"https:\\/\\/graph.microsoft.com\\/v1.0\\/$metadata#users(\'07a06403-9693-4d53-ac59-878bfd24e7a5\')\\/onlineMeetings\\/$entity\",\"id\":\"MSowN2EwNjQwMy05NjkzLTRkNTMtYWM1OS04NzhiZmQyNGU3YTUqMCoqMTk6bWVldGluZ19NbU5pTWpKaU5tSXRaVEV6WVMwME56WTVMV0l5WmpNdE9UZzFOakExWm1JMFpUVXlAdGhyZWFkLnYy\",\"creationDateTime\":\"2022-09-01T11:54:22.7056681Z\",\"startDateTime\":\"2022-09-03T10:00:00.6491364Z\",\"endDateTime\":\"2022-09-03T10:45:00.6491364Z\",\"joinUrl\":\"https:\\/\\/teams.microsoft.com\\/l\\/meetup-join\\/19%3ameeting_MmNiMjJiNmItZTEzYS00NzY5LWIyZjMtOTg1NjA1ZmI0ZTUy%40thread.v2\\/0?context=%7b%22Tid%22%3a%22a2f33be8-5e76-486e-8b72-d5ea619a9fda%22%2c%22Oid%22%3a%2207a06403-9693-4d53-ac59-878bfd24e7a5%22%7d\",\"joinWebUrl\":\"https:\\/\\/teams.microsoft.com\\/l\\/meetup-join\\/19%3ameeting_MmNiMjJiNmItZTEzYS00NzY5LWIyZjMtOTg1NjA1ZmI0ZTUy%40thread.v2\\/0?context=%7b%22Tid%22%3a%22a2f33be8-5e76-486e-8b72-d5ea619a9fda%22%2c%22Oid%22%3a%2207a06403-9693-4d53-ac59-878bfd24e7a5%22%7d\",\"meetingCode\":\"368006932136\",\"subject\":\"Coach Spacing :: Online Meeting\",\"isBroadcast\":false,\"autoAdmittedUsers\":\"everyone\",\"outerMeetingAutoAdmittedUsers\":null,\"isEntryExitAnnounced\":true,\"allowedPresenters\":\"everyone\",\"allowMeetingChat\":\"enabled\",\"allowTeamworkReactions\":true,\"allowAttendeeToEnableMic\":true,\"allowAttendeeToEnableCamera\":true,\"recordAutomatically\":false,\"anonymizeIdentityForRoles\":[],\"capabilities\":[],\"videoTeleconferenceId\":null,\"externalId\":null,\"broadcastSettings\":null,\"joinMeetingIdSettings\":{\"isPasscodeRequired\":false,\"joinMeetingId\":\"368006932136\",\"passcode\":null},\"audioConferencing\":null,\"meetingInfo\":null,\"participants\":{\"organizer\":{\"upn\":\"hello@coachingspace.co.uk\",\"role\":\"presenter\",\"identity\":{\"application\":null,\"device\":null,\"user\":{\"id\":\"07a06403-9693-4d53-ac59-878bfd24e7a5\",\"displayName\":null,\"tenantId\":\"a2f33be8-5e76-486e-8b72-d5ea619a9fda\",\"identityProvider\":\"AAD\"}}},\"attendees\":[]},\"lobbyBypassSettings\":{\"scope\":\"everyone\",\"isDialInBypassEnabled\":true},\"chatInfo\":{\"threadId\":\"19:meeting_MmNiMjJiNmItZTEzYS00NzY5LWIyZjMtOTg1NjA1ZmI0ZTUy@thread.v2\",\"messageId\":\"0\",\"replyChainMessageId\":null},\"joinInformation\":{\"content\":\"data:text\\/html,%3cdiv+style%3d%22width%3a100%25%3bheight%3a+20px%3b%22%3e%0d%0a++++%3cspan+style%3d%22white-space%3anowrap%3bcolor%3a%235F5F5F%3bopacity%3a.36%3b%22%3e________________________________________________________________________________%3c%2fspan%3e%0d%0a%3c%2fdiv%3e%0d%0a+%0d%0a+%3cdiv+class%3d%22me-email-text%22+style%3d%22color%3a%23252424%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+lang%3d%22en-US%22%3e%0d%0a++++%3cdiv+style%3d%22margin-top%3a+24px%3b+margin-bottom%3a+20px%3b%22%3e%0d%0a++++++++%3cspan+style%3d%22font-size%3a+24px%3b+color%3a%23252424%22%3eMicrosoft+Teams+meeting%3c%2fspan%3e%0d%0a++++%3c%2fdiv%3e%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a+20px%3b%22%3e%0d%0a++++++++%3cdiv+style%3d%22margin-top%3a+0px%3b+margin-bottom%3a+0px%3b+font-weight%3a+bold%22%3e%0d%0a++++++++++%3cspan+style%3d%22font-size%3a+14px%3b+color%3a%23252424%22%3eJoin+on+your+computer%2c+mobile+app+or+room+device%3c%2fspan%3e%0d%0a++++++++%3c%2fdiv%3e%0d%0a++++++++%3ca+class%3d%22me-email-headline%22+style%3d%22font-size%3a+14px%3bfont-family%3a%27Segoe+UI+Semibold%27%2c%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3b%22+href%3d%22https%3a%2f%2fteams.microsoft.com%2fl%2fmeetup-join%2f19%253ameeting_MmNiMjJiNmItZTEzYS00NzY5LWIyZjMtOTg1NjA1ZmI0ZTUy%2540thread.v2%2f0%3fcontext%3d%257b%2522Tid%2522%253a%2522a2f33be8-5e76-486e-8b72-d5ea619a9fda%2522%252c%2522Oid%2522%253a%252207a06403-9693-4d53-ac59-878bfd24e7a5%2522%257d%22+target%3d%22_blank%22+rel%3d%22noreferrer+noopener%22%3eClick+here+to+join+the+meeting%3c%2fa%3e%0d%0a++++%3c%2fdiv%3e%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a20px%3b+margin-top%3a20px%22%3e%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a4px%22%3e%0d%0a++++++++%3cspan+data-tid%3d%22meeting-code%22+style%3d%22font-size%3a+14px%3b+color%3a%23252424%3b%22%3e%0d%0a++++++++++++Meeting+ID%3a+%3cspan+style%3d%22font-size%3a16px%3b+color%3a%23252424%3b%22%3e368+006+932+136%3c%2fspan%3e%0d%0a+++++++%3c%2fspan%3e%0d%0a++++++++%0d%0a++++++++%3cdiv+style%3d%22font-size%3a+14px%3b%22%3e%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2fwww.microsoft.com%2fen-us%2fmicrosoft-teams%2fdownload-app%22+rel%3d%22noreferrer+noopener%22%3e%0d%0a++++++++Download+Teams%3c%2fa%3e+%7c+%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2fwww.microsoft.com%2fmicrosoft-teams%2fjoin-a-meeting%22+rel%3d%22noreferrer+noopener%22%3eJoin+on+the+web%3c%2fa%3e%3c%2fdiv%3e%0d%0a++++%3c%2fdiv%3e%0d%0a+%3c%2fdiv%3e%0d%0a++++%0d%0a++++++%0d%0a++++%0d%0a++++%0d%0a++++%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a+24px%3bmargin-top%3a+20px%3b%22%3e%0d%0a++++++++%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2faka.ms%2fJoinTeamsMeeting%22+rel%3d%22noreferrer+noopener%22%3eLearn+More%3c%2fa%3e++%7c+%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2fteams.microsoft.com%2fmeetingOptions%2f%3forganizerId%3d07a06403-9693-4d53-ac59-878bfd24e7a5%26tenantId%3da2f33be8-5e76-486e-8b72-d5ea619a9fda%26threadId%3d19_meeting_MmNiMjJiNmItZTEzYS00NzY5LWIyZjMtOTg1NjA1ZmI0ZTUy%40thread.v2%26messageId%3d0%26language%3den-US%22+rel%3d%22noreferrer+noopener%22%3eMeeting+options%3c%2fa%3e+%0d%0a++++++%3c%2fdiv%3e%0d%0a%3c%2fdiv%3e%0d%0a%3cdiv+style%3d%22font-size%3a+14px%3b+margin-bottom%3a+4px%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22%3e%0d%0a%0d%0a%3c%2fdiv%3e%0d%0a%3cdiv+style%3d%22font-size%3a+12px%3b%22%3e%0d%0a%0d%0a%3c%2fdiv%3e%0d%0a%0d%0a%3c%2fdiv%3e%0d%0a%3cdiv+style%3d%22width%3a100%25%3bheight%3a+20px%3b%22%3e%0d%0a++++%3cspan+style%3d%22white-space%3anowrap%3bcolor%3a%235F5F5F%3bopacity%3a.36%3b%22%3e________________________________________________________________________________%3c%2fspan%3e%0d%0a%3c%2fdiv%3e\",\"contentType\":\"html\"}}', 'upcoming', NULL, '2022-09-01 11:54:24', '2022-09-01 11:54:24', NULL),
(3, 21, 6, 7, '2022-07-13', '12:00 - 12:45', '2022-09-09 12:00:00', '2022-09-09 12:45:00', 'ssss', NULL, 0, 0, 0, NULL, 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_NjU1Mjk0MWEtMDczNC00MjM1LWI2OGQtYWVhODNkNzdkMzkx%40thread.v2/0?context=%7b%22Tid%22%3a%22a2f33be8-5e76-486e-8b72-d5ea619a9fda%22%2c%22Oid%22%3a%2207a06403-9693-4d53-ac59-878bfd24e7a5%22%7d', '{\"@odata.context\":\"https:\\/\\/graph.microsoft.com\\/v1.0\\/$metadata#users(\'07a06403-9693-4d53-ac59-878bfd24e7a5\')\\/onlineMeetings\\/$entity\",\"id\":\"MSowN2EwNjQwMy05NjkzLTRkNTMtYWM1OS04NzhiZmQyNGU3YTUqMCoqMTk6bWVldGluZ19OalUxTWprME1XRXRNRGN6TkMwME1qTTFMV0kyT0dRdFlXVmhPRE5rTnpka016a3hAdGhyZWFkLnYy\",\"creationDateTime\":\"2022-09-07T06:43:11.4327981Z\",\"startDateTime\":\"2022-09-09T12:00:00.6491364Z\",\"endDateTime\":\"2022-09-09T12:45:00.6491364Z\",\"joinUrl\":\"https:\\/\\/teams.microsoft.com\\/l\\/meetup-join\\/19%3ameeting_NjU1Mjk0MWEtMDczNC00MjM1LWI2OGQtYWVhODNkNzdkMzkx%40thread.v2\\/0?context=%7b%22Tid%22%3a%22a2f33be8-5e76-486e-8b72-d5ea619a9fda%22%2c%22Oid%22%3a%2207a06403-9693-4d53-ac59-878bfd24e7a5%22%7d\",\"joinWebUrl\":\"https:\\/\\/teams.microsoft.com\\/l\\/meetup-join\\/19%3ameeting_NjU1Mjk0MWEtMDczNC00MjM1LWI2OGQtYWVhODNkNzdkMzkx%40thread.v2\\/0?context=%7b%22Tid%22%3a%22a2f33be8-5e76-486e-8b72-d5ea619a9fda%22%2c%22Oid%22%3a%2207a06403-9693-4d53-ac59-878bfd24e7a5%22%7d\",\"meetingCode\":\"394450654190\",\"subject\":\"Coach Spacing :: Online Meeting\",\"isBroadcast\":false,\"autoAdmittedUsers\":\"everyone\",\"outerMeetingAutoAdmittedUsers\":null,\"isEntryExitAnnounced\":true,\"allowedPresenters\":\"everyone\",\"allowMeetingChat\":\"enabled\",\"allowTeamworkReactions\":true,\"allowAttendeeToEnableMic\":true,\"allowAttendeeToEnableCamera\":true,\"recordAutomatically\":false,\"anonymizeIdentityForRoles\":[],\"capabilities\":[],\"videoTeleconferenceId\":null,\"externalId\":null,\"broadcastSettings\":null,\"joinMeetingIdSettings\":{\"isPasscodeRequired\":false,\"joinMeetingId\":\"394450654190\",\"passcode\":null},\"audioConferencing\":null,\"meetingInfo\":null,\"participants\":{\"organizer\":{\"upn\":\"hello@coachingspace.co.uk\",\"role\":\"presenter\",\"identity\":{\"application\":null,\"device\":null,\"user\":{\"id\":\"07a06403-9693-4d53-ac59-878bfd24e7a5\",\"displayName\":null,\"tenantId\":\"a2f33be8-5e76-486e-8b72-d5ea619a9fda\",\"identityProvider\":\"AAD\"}}},\"attendees\":[]},\"lobbyBypassSettings\":{\"scope\":\"everyone\",\"isDialInBypassEnabled\":true},\"chatInfo\":{\"threadId\":\"19:meeting_NjU1Mjk0MWEtMDczNC00MjM1LWI2OGQtYWVhODNkNzdkMzkx@thread.v2\",\"messageId\":\"0\",\"replyChainMessageId\":null},\"joinInformation\":{\"content\":\"data:text\\/html,%3cdiv+style%3d%22width%3a100%25%3bheight%3a+20px%3b%22%3e%0d%0a++++%3cspan+style%3d%22white-space%3anowrap%3bcolor%3a%235F5F5F%3bopacity%3a.36%3b%22%3e________________________________________________________________________________%3c%2fspan%3e%0d%0a%3c%2fdiv%3e%0d%0a+%0d%0a+%3cdiv+class%3d%22me-email-text%22+style%3d%22color%3a%23252424%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+lang%3d%22en-US%22%3e%0d%0a++++%3cdiv+style%3d%22margin-top%3a+24px%3b+margin-bottom%3a+20px%3b%22%3e%0d%0a++++++++%3cspan+style%3d%22font-size%3a+24px%3b+color%3a%23252424%22%3eMicrosoft+Teams+meeting%3c%2fspan%3e%0d%0a++++%3c%2fdiv%3e%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a+20px%3b%22%3e%0d%0a++++++++%3cdiv+style%3d%22margin-top%3a+0px%3b+margin-bottom%3a+0px%3b+font-weight%3a+bold%22%3e%0d%0a++++++++++%3cspan+style%3d%22font-size%3a+14px%3b+color%3a%23252424%22%3eJoin+on+your+computer%2c+mobile+app+or+room+device%3c%2fspan%3e%0d%0a++++++++%3c%2fdiv%3e%0d%0a++++++++%3ca+class%3d%22me-email-headline%22+style%3d%22font-size%3a+14px%3bfont-family%3a%27Segoe+UI+Semibold%27%2c%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3b%22+href%3d%22https%3a%2f%2fteams.microsoft.com%2fl%2fmeetup-join%2f19%253ameeting_NjU1Mjk0MWEtMDczNC00MjM1LWI2OGQtYWVhODNkNzdkMzkx%2540thread.v2%2f0%3fcontext%3d%257b%2522Tid%2522%253a%2522a2f33be8-5e76-486e-8b72-d5ea619a9fda%2522%252c%2522Oid%2522%253a%252207a06403-9693-4d53-ac59-878bfd24e7a5%2522%257d%22+target%3d%22_blank%22+rel%3d%22noreferrer+noopener%22%3eClick+here+to+join+the+meeting%3c%2fa%3e%0d%0a++++%3c%2fdiv%3e%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a20px%3b+margin-top%3a20px%22%3e%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a4px%22%3e%0d%0a++++++++%3cspan+data-tid%3d%22meeting-code%22+style%3d%22font-size%3a+14px%3b+color%3a%23252424%3b%22%3e%0d%0a++++++++++++Meeting+ID%3a+%3cspan+style%3d%22font-size%3a16px%3b+color%3a%23252424%3b%22%3e394+450+654+190%3c%2fspan%3e%0d%0a+++++++%3c%2fspan%3e%0d%0a++++++++%0d%0a++++++++%3cdiv+style%3d%22font-size%3a+14px%3b%22%3e%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2fwww.microsoft.com%2fen-us%2fmicrosoft-teams%2fdownload-app%22+rel%3d%22noreferrer+noopener%22%3e%0d%0a++++++++Download+Teams%3c%2fa%3e+%7c+%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2fwww.microsoft.com%2fmicrosoft-teams%2fjoin-a-meeting%22+rel%3d%22noreferrer+noopener%22%3eJoin+on+the+web%3c%2fa%3e%3c%2fdiv%3e%0d%0a++++%3c%2fdiv%3e%0d%0a+%3c%2fdiv%3e%0d%0a++++%0d%0a++++++%0d%0a++++%0d%0a++++%0d%0a++++%0d%0a++++%3cdiv+style%3d%22margin-bottom%3a+24px%3bmargin-top%3a+20px%3b%22%3e%0d%0a++++++++%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2faka.ms%2fJoinTeamsMeeting%22+rel%3d%22noreferrer+noopener%22%3eLearn+More%3c%2fa%3e++%7c+%3ca+class%3d%22me-email-link%22+style%3d%22font-size%3a+14px%3btext-decoration%3a+underline%3bcolor%3a+%236264a7%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22+target%3d%22_blank%22+href%3d%22https%3a%2f%2fteams.microsoft.com%2fmeetingOptions%2f%3forganizerId%3d07a06403-9693-4d53-ac59-878bfd24e7a5%26tenantId%3da2f33be8-5e76-486e-8b72-d5ea619a9fda%26threadId%3d19_meeting_NjU1Mjk0MWEtMDczNC00MjM1LWI2OGQtYWVhODNkNzdkMzkx%40thread.v2%26messageId%3d0%26language%3den-US%22+rel%3d%22noreferrer+noopener%22%3eMeeting+options%3c%2fa%3e+%0d%0a++++++%3c%2fdiv%3e%0d%0a%3c%2fdiv%3e%0d%0a%3cdiv+style%3d%22font-size%3a+14px%3b+margin-bottom%3a+4px%3bfont-family%3a%27Segoe+UI%27%2c%27Helvetica+Neue%27%2cHelvetica%2cArial%2csans-serif%3b%22%3e%0d%0a%0d%0a%3c%2fdiv%3e%0d%0a%3cdiv+style%3d%22font-size%3a+12px%3b%22%3e%0d%0a%0d%0a%3c%2fdiv%3e%0d%0a%0d%0a%3c%2fdiv%3e%0d%0a%3cdiv+style%3d%22width%3a100%25%3bheight%3a+20px%3b%22%3e%0d%0a++++%3cspan+style%3d%22white-space%3anowrap%3bcolor%3a%235F5F5F%3bopacity%3a.36%3b%22%3e________________________________________________________________________________%3c%2fspan%3e%0d%0a%3c%2fdiv%3e\",\"contentType\":\"html\"}}', 'canceled', NULL, '2022-09-07 06:43:10', '2022-09-07 06:43:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `field`, `value`, `created_at`, `updated_at`) VALUES
(7, 'address', 'India', '2021-08-19 20:41:10', '2022-04-01 09:02:04'),
(6, 'copyright_text', 'Copyright © 2022 Coaching Space. All rights reserved.', '2021-08-19 20:41:10', '2022-04-01 09:02:04'),
(5, 'site_mobile_no', '+1 342 345 5691', '2021-08-19 20:41:10', '2021-09-08 03:20:57'),
(4, 'site_email', 'info@coachingspace.com', '2021-08-19 20:41:10', '2022-04-01 09:02:04'),
(3, 'admin_mobile_no', '0123456789', '2021-08-19 20:41:10', '2021-08-19 20:41:10'),
(2, 'admin_email', 'kanu.nyusoft@gmail.com', '2021-08-19 20:41:10', '2022-04-01 09:02:04'),
(1, 'site_name', 'Coaching Space', '2021-08-19 20:41:10', '2022-04-01 09:02:04'),
(8, 'facebook_url', 'https://www.facebook.com/', '2021-08-19 20:41:10', '2021-08-19 20:41:10'),
(9, 'twitter_url', 'https://twitter.com/', '2021-08-19 20:41:10', '2021-08-19 20:41:10'),
(10, 'instagram_url', 'https://www.instagram.com/', '2021-08-19 20:41:10', '2021-08-19 20:41:10'),
(11, 'youtube_url', NULL, '2021-08-19 20:41:10', '2021-09-07 18:43:34'),
(12, 'pinterest_url', 'https://www.pinterest.com/', '2021-08-19 20:41:10', '2021-08-19 20:41:10'),
(13, 'meta_title', 'Coaching Space', '2021-08-19 20:41:10', '2022-04-01 09:02:04'),
(14, 'meta_description', 'Coaching Space', '2021-08-19 20:41:10', '2022-04-01 09:02:04'),
(15, 'logo', 'site_settings/36AVolgNdh.png', '2021-08-19 20:41:10', '2022-04-25 00:45:44'),
(19, 'publishable_key', 'pk_test_51JhqQ1HhKVkjNfmn7eN9vjNXYpy2RnqOmhOKWryPDcahPr3diM2ahqkKNk6GqKLlIFX4cJ1SG8KBluJ5T1H4ZBws00RjSJw3Eq', '2021-09-03 00:55:36', '2021-10-06 19:51:20'),
(20, 'secret_key', 'sk_test_51JhqQ1HhKVkjNfmnD6HZC49xLQEMTJO0gNUmtbRs2UBvu0HgElfmHr1lt9Q60pLocridSsvsQELa0m1ZtPjInMJw00DOBoRVnl', '2021-09-03 00:55:36', '2021-10-06 19:51:20'),
(21, 'google_map_key', 'AIzaSyCgPy8Y-unsQfRgWOlfP3gkIqvmobG4nTw', '2021-09-03 01:06:41', '2021-09-03 01:06:41'),
(22, 'google_captcha_key', '6LcTDWQaAAAAANO2ampjFYUzWVlSZ5KLlCr4GlIH', '2021-09-03 01:06:41', '2021-09-03 01:07:03'),
(23, 'google_captcha_secret', '6LcTDWQaAAAAAIx9-YarGz00F_wPO5UWsaCUUXzE', '2021-09-03 01:06:41', '2021-09-03 01:07:03'),
(24, 'favicon', 'site_settings/Q3KPlwSivy.png', '2021-09-03 01:16:01', '2022-04-25 00:34:22'),
(25, 'website_url', 'https://coachingspace.com', '2021-09-03 01:22:56', '2022-04-01 09:02:04'),
(26, 'meta_keywords', 'Coaching Space', '2021-09-06 21:36:44', '2022-04-01 09:02:04'),
(27, 'footer_logo', 'site_settings/jYEnY4dPbI.png', '2021-09-06 21:36:45', '2022-04-25 00:34:22'),
(28, 'linkedin_url', 'https://www.linkedin.com/', '2021-09-07 18:33:22', '2021-09-07 18:33:22'),
(30, 'enable_reviews', 'yes', '2021-09-20 20:24:01', '2021-10-28 23:45:49'),
(32, 'currency_icon', '€', '2021-09-27 22:17:19', '2021-09-27 22:17:19'),
(33, 'currency_name', 'EUR', '2021-09-27 22:17:19', '2021-09-27 22:17:19'),
(34, 'paypal_client', 'ATripBFBiiUarsYQa4wxIpuxJp5e0qVdQdL8N43CNK2d0Y-Q3QydpUkgbpNc8-sE23fPuPItoebKIKV4', '2021-10-10 23:56:24', '2021-10-10 23:56:24'),
(35, 'paypal_secret', 'EGDwKeyBqgLeFKNFXpFPFetqKA8llArWLiMF0LAYiPpHpUKlUn7lcJuST6x3lEVpygZSz64O9HU_0rcD', '2021-10-10 23:56:24', '2021-10-10 23:56:24'),
(36, 'paypal_mode', 'sandbox', '2021-10-11 00:20:04', '2021-10-11 00:22:03'),
(37, 'ms_link_token', 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IjgzX29tWW9DaHFVenBQc2VaeTRiX3Z1QmxfRTF0Y2FYSkgtVlAxY0Uyek0iLCJhbGciOiJSUzI1NiIsIng1dCI6IjJaUXBKM1VwYmpBWVhZR2FYRUpsOGxWMFRPSSIsImtpZCI6IjJaUXBKM1VwYmpBWVhZR2FYRUpsOGxWMFRPSSJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hMmYzM2JlOC01ZTc2LTQ4NmUtOGI3Mi1kNWVhNjE5YTlmZGEvIiwiaWF0IjoxNjU5NDMyNjc1LCJuYmYiOjE2NTk0MzI2NzUsImV4cCI6MTY1OTQzNjY3MiwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFTUUEyLzhUQUFBQTR0M1pXY0FaRitPdTZMeTlKbDFHOTQ4ZEpQeUhLVmIyNjZlK2V5bWllWFE9IiwiYW1yIjpbInB3ZCJdLCJhcHBfZGlzcGxheW5hbWUiOiJHcmFwaCBFeHBsb3JlciIsImFwcGlkIjoiZGU4YmM4YjUtZDlmOS00OGIxLWE4YWQtYjc0OGRhNzI1MDY0IiwiYXBwaWRhY3IiOiIwIiwiZmFtaWx5X25hbWUiOiJDb2FjaGluZyBTcGFjZSIsImdpdmVuX25hbWUiOiJUZWFtIiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiMTAzLjI0MC4xNjkuNTQiLCJuYW1lIjoiVGVhbSBDb2FjaGluZyBTcGFjZSIsIm9pZCI6IjA3YTA2NDAzLTk2OTMtNGQ1My1hYzU5LTg3OGJmZDI0ZTdhNSIsInBsYXRmIjoiMyIsInB1aWQiOiIxMDAzMjAwMUQ1RDIwMjBCIiwicHdkX2V4cCI6IjMxMzQzNDE0MCIsInB3ZF91cmwiOiJodHRwczovL3Byb2R1Y3Rpdml0eS5zZWN1cmVzZXJ2ZXIubmV0L21pY3Jvc29mdD9tYXJrZXRpZD1lbi1VU1x1MDAyNmVtYWlsPWhlbGxvJTQwY29hY2hpbmdzcGFjZS5jby51a1x1MDAyNnNvdXJjZT1WaWV3VXNlcnNcdTAwMjZhY3Rpb249UmVzZXRQYXNzd29yZCIsInJoIjoiMC5BVThBNkR2em9uWmVia2lMY3RYcVlacWYyZ01BQUFBQUFBQUF3QUFBQUFBQUFBQlBBT0EuIiwic2NwIjoiZURpc2NvdmVyeS5SZWFkLkFsbCBPbmxpbmVNZWV0aW5nQXJ0aWZhY3QuUmVhZC5BbGwgT25saW5lTWVldGluZ1JlY29yZGluZy5SZWFkLkFsbCBPbmxpbmVNZWV0aW5ncy5SZWFkIE9ubGluZU1lZXRpbmdzLlJlYWRXcml0ZSBPbmxpbmVNZWV0aW5nVHJhbnNjcmlwdC5SZWFkLkFsbCBvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJWWHp0MGtKMXBESThTNC1qQUs4X1pXUlZWb3Q3eGhUcUhtcTJsVUxkT3hvIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiYTJmMzNiZTgtNWU3Ni00ODZlLThiNzItZDVlYTYxOWE5ZmRhIiwidW5pcXVlX25hbWUiOiJoZWxsb0Bjb2FjaGluZ3NwYWNlLmNvLnVrIiwidXBuIjoiaGVsbG9AY29hY2hpbmdzcGFjZS5jby51ayIsInV0aSI6ImpHeXFzRFhZdVVPdmFvTE1EZmdTQVEiLCJ2ZXIiOiIxLjAiLCJ3aWRzIjpbIjYyZTkwMzk0LTY5ZjUtNDIzNy05MTkwLTAxMjE3NzE0NWUxMCIsImI3OWZiZjRkLTNlZjktNDY4OS04MTQzLTc2YjE5NGU4NTUwOSJdLCJ4bXNfc3QiOnsic3ViIjoieXVvTWd4eERmeUdqcEVoVWRrczBOWDFXdnpocTM5ekZHaVBSYWdSUWtETSJ9LCJ4bXNfdGNkdCI6MTY0MzYzODMzNn0.YB_5MTPqBirMbzFO5LNCnG7GNTPqLqGCEFgGYNGoBxqOmFip6QTsjLJIEg3dYU_f3qGC2i2a-82NW2vHaU4H2gyspLmQAyZ3wnpxeQA1NvzCWiwbG1H_u7fgHZy9AZsSri6N5s3V8lDxuU8qB-AYrZsW_ofe7Khxm0sb4U4TQBWFZTo0xG9tDU9li3rW65vbj1icDZ9Uzq6IWa8dUroHIb6AXqXMgMyjX8Di6XdHEPIdDL7ib61jRgIAr09iroTyI9-MpvN418GXOmiRIdgXWv8GMiv2h6ofzM6jBqZvi6mgBY7sVDyE7ZVuNWbDSHvtc_a1M3JM-sc9-ofSaKrfZQ', '2022-05-16 05:34:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `strengths`
--

CREATE TABLE `strengths` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strengths`
--

INSERT INTO `strengths` (`id`, `title`, `created_at`, `updated_at`) VALUES
(2, 'Strength Title01', '2022-04-06 07:01:21', '2022-04-06 07:01:31'),
(3, 'Strength Title02', '2022-04-06 07:01:21', '2022-04-06 07:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_template`
--

CREATE TABLE `tbl_email_template` (
  `id` int(10) UNSIGNED NOT NULL,
  `header_id` int(10) UNSIGNED NOT NULL,
  `footer_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 for active, 2 for inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_email_template`
--

INSERT INTO `tbl_email_template` (`id`, `header_id`, `footer_id`, `title`, `subject`, `body`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Verify Email', 'Verify Email', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Please click the button below to verify your email address.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">VERIFY EMAIL</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">If you did not create an account, no further action is required.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">If you&#39;re having trouble clicking the &quot;Verify Email Address&quot; button, copy and paste the URL below into your web browser: <a href=\"{LINK}\">{LINK}</a></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-07-28 09:36:49', NULL),
(2, 1, 1, 'New Request | Admin', 'New Request', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello Admin!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">You have new user request. Details are below.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 10px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">User Name : {NAME}.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Mail Id : {EMAIL}.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Phone number : {PHONE}.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Country : {COUNTRY}.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\" width=\"210\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">VIEW USER</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-07-28 09:36:56', NULL),
(3, 1, 1, 'Invitation', 'Invitation', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}!</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><strong>You have an invitation from {FIRST_NAME} {LAST_NAME}.</strong></p>\r\n\r\n			<p>{MESSAGE}</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\" width=\"150\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">LOGIN</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-09-20 05:23:27', NULL),
(4, 1, 1, 'Reset password | User', 'Reset Password', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Reset Password</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Dear <b>{NAME}</b>, you are receiving this email because you requested to reset your password at MD Elevated.</p>\r\n\r\n			<p style=\"margin-top: 30px;margin-bottom: 0px;\">Click the button below to reset your password.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\" width=\"210\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">RESET PASSWORD</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">If you did not request this, please contact <a href=\"{LINK_1}\">support</a> for assistance.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-09-14 02:19:35', NULL),
(5, 1, 1, 'Approved New User Request | User', 'Congratulation!! Your profile is approved.', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Congratulation !!&nbsp;</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Your Profile on MD Elevated is approved.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Kindly click on below button to login to your account.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><b>{REMARK}</b></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\" width=\"210\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">LOGIN</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-08-17 19:07:48', '2021-09-05 18:30:00'),
(6, 1, 1, 'Declined New User Request | User', 'New User Request -Declined', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Sorry to say but your request is declined by Admin. Below is the reason.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><b>{REMARK}</b></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-07-28 09:34:45', '2021-09-05 18:30:00'),
(24, 1, 1, 'Contact Us | Admin', 'Contact us', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" data-module=\"hero-white-icon-outline0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" data-bgcolor=\"Bg White\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\"><!--[if mso]>\r\n<table width=\"584\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">\r\n<![endif]-->\r\n			<div data-color=\"Light\" data-max=\"23\" data-min=\"15\" data-size=\"Text MD\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 data-color=\"Dark\" data-max=\"40\" data-min=\"20\" data-size=\"Heading 2\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Contact us</h2>\r\n			<!-- <p style=\"margin-top: 0px;margin-bottom: 0px;\">That thus much less heron other hello</p> --></div>\r\n			<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><!--[if mso]>\r\n<table width=\"800\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<![endif]-->\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" style=\"max-width: 800px;margin: 0 auto;\" width=\"100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Full Name</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{NAME}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Email</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{EMAIL}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Country</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{COUNTRY}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Phone Number</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n<td width=\"100\" align=\"right\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 300px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{PHONE}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"300\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 600px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Light\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<h4 data-color=\"Dark\" data-max=\"26\" data-min=\"10\" data-size=\"Heading 4\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;\">Message</h4>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\"><!--[if mso]>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n<tbody>\r\n<tr>\r\n<td width=\"100\" align=\"left\" valign=\"top\" style=\"padding: 0px 8px;\">\r\n<![endif]-->\r\n						<div style=\"display: inline-block;vertical-align: top;width: 100%;max-width: 600px;\">\r\n						<div style=\"font-size: 16px; line-height: 16px; height: 16px;\">&nbsp;</div>\r\n\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: left;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">{MESSAGE}</p>\r\n						</div>\r\n						</div>\r\n						<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			<!--[if mso]>\r\n</td>\r\n</tr>\r\n</table>\r\n<![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-02-09 03:02:12', '2021-09-15 00:41:57', NULL),
(23, 1, 1, 'Contact Us | User', 'Contact us', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" data-module=\"hero-white-icon-outline0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" data-bgcolor=\"Bg White\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\"><!--[if mso]>\r\n                <table width=\"584\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <td align=\"center\">\r\n                                <![endif]-->\r\n			<div data-color=\"Light\" data-max=\"23\" data-min=\"15\" data-size=\"Text MD\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 data-color=\"Dark\" data-max=\"40\" data-min=\"20\" data-size=\"Heading 2\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Thank you for getting in touch.</h2>\r\n			<!-- <p style=\"margin-top: 0px;margin-bottom: 0px;\">That thus much less heron other hello</p> --></div>\r\n			<!--[if mso]>\r\n                            </td>\r\n                        </tr>\r\n                </table>\r\n                <![endif]--></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<!-- ------------------------------------------------ -->\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" data-module=\"button-dark0\" role=\"presentation\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" data-bgcolor=\"Bg White\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\"><!-- -------------------------------------- -->\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" data-bgcolor=\"Bg White\" style=\"font-size: 0;vertical-align: top;background-color: #ffffff;\">\r\n						<div data-color=\"Secondary\" data-max=\"20\" data-min=\"12\" data-size=\"Text Default\" style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;text-align: right;padding-left: 8px;padding-right: 8px;\">\r\n						<p style=\"margin-top: 0px;margin-bottom: 4px;\">We will review your message and come back to you shortly. Thank you for reaching out to the MD Elevated. We look forward to connecting soon.</p>\r\n						</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			<!-- --------------------------------------- --></td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-02-09 03:01:41', '2021-09-15 00:42:04', NULL),
(32, 1, 1, 'User Approved | User', 'User Approved', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Congratulations! Admin has approved your profile.</p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:18px;padding-bottom: 8px;\">\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #F06C45;border-radius: 10px; border :thin solid #F06C45;\" width=\"300\"><a href=\"{LINK}\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;\">LOG IN</a></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-09-17 08:30:15', NULL),
(31, 1, 1, 'User On Hold | User', 'User On Hold', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top:20px;padding-bottom:0px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;\">\r\n			<h2 style=\"font-family: Arial, sans-serif, \'Open Sans\';font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;\">Hello {NAME}</h2>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\" style=\"background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;\">\r\n			<div style=\"font-family: Arial, sans-serif, \'Open Sans\';margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;\">\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\">Sorry to say but Admin has put you on hold. Below is the reason.</p>\r\n\r\n			<p style=\"margin-top: 0px;margin-bottom: 0px;\"><b>{REMARK}</b></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '1', '2021-01-31 19:57:51', '2021-09-09 23:46:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unavailability_dates`
--

CREATE TABLE `unavailability_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coach_id` int(10) UNSIGNED NOT NULL,
  `type` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0 for only date, 1 for date with time',
  `date` date DEFAULT NULL,
  `time_slots` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `organization_id` int(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avg_rating` double(8,2) DEFAULT 0.00,
  `rating_count` int(11) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not active, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `first_time_status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = first time login, 1 = password changed, 2 - Video Played',
  `last_seen` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twomonths_before_email` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not sent, 1=sent	'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `organization_id`, `first_name`, `last_name`, `slug`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `reset_password_token`, `about`, `phone_number`, `profile_image`, `location`, `latitude`, `longitude`, `city`, `state`, `country`, `postal_code`, `avg_rating`, `rating_count`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `first_time_status`, `last_seen`, `ip_address`, `twomonths_before_email`) VALUES
(6, 7, 'Test', 'Patel', 'leizdxmg-test', 'leizdxmg Test', 'leizdxmg@sharklasers.com', '2022-04-11 02:25:16', '$2y$10$14eF8HfOdv4tfyUEA99l0.FZIigzrKHvllx6DAnm9giqIlOAIDQNa', 'eKQNO8sJwxrvdIbQO077GJ2Xnt1oKedkIMHSya9Vi2pz0OfD0nGmPn0otGqa', '1679091c5a880faf6fb5e6087eb1b2dc', NULL, '1234567895', 'users/6-1650877441.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 1, '2022-04-11 00:48:45', '2022-10-17 07:59:27', NULL, '2', '2022-10-17 07:59:27', '::1', 0),
(20, 11, 'garry', 'cursten', 'garry-cursten', 'garry cursten', 'wedin@yopmail.com', '2022-04-19 11:27:41', '$2y$10$14eF8HfOdv4tfyUEA99l0.FZIigzrKHvllx6DAnm9giqIlOAIDQNa', NULL, '', NULL, '8884342342', 'users/1650448794.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 1, '2022-04-19 11:27:13', '2022-04-20 12:16:26', NULL, '2', '2022-06-07 13:05:58', NULL, 0),
(28, 7, 'Coaching', 'User', 'coaching-user', 'Coaching User', 'coachinguser@yopmail.com', '2022-04-29 05:43:02', '$2y$10$14eF8HfOdv4tfyUEA99l0.FZIigzrKHvllx6DAnm9giqIlOAIDQNa', NULL, '33e75ff09dd601bbe69f351039152189', NULL, '1234567895', 'users/1651210778.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, 1, '2022-04-29 05:39:38', '2022-09-02 07:29:48', NULL, '2', '2022-09-02 07:29:48', '::1', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availability_dates`
--
ALTER TABLE `availability_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coaches_email_unique` (`email`);

--
-- Indexes for table `coaching_levels`
--
ALTER TABLE `coaching_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template_footer`
--
ALTER TABLE `email_template_footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template_header`
--
ALTER TABLE `email_template_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organizations_email_unique` (`email`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strengths`
--
ALTER TABLE `strengths`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_template`
--
ALTER TABLE `tbl_email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unavailability_dates`
--
ALTER TABLE `unavailability_dates`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `availability_dates`
--
ALTER TABLE `availability_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `coaching_levels`
--
ALTER TABLE `coaching_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `email_template_footer`
--
ALTER TABLE `email_template_footer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `email_template_header`
--
ALTER TABLE `email_template_header`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `strengths`
--
ALTER TABLE `strengths`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_email_template`
--
ALTER TABLE `tbl_email_template`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `unavailability_dates`
--
ALTER TABLE `unavailability_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
