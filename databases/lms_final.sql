-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2021 at 12:27 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `announcement` varchar(255) NOT NULL,
  `uploaded` varchar(255) DEFAULT NULL,
  `filetype` varchar(255) DEFAULT NULL,
  `usr_id` varchar(255) NOT NULL,
  `audience` varchar(255) NOT NULL,
  `active` varchar(2) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_answer`
--

CREATE TABLE `tbl_answer` (
  `id` int(11) UNSIGNED NOT NULL,
  `ans_id` varchar(255) NOT NULL,
  `answer` varchar(100) NOT NULL DEFAULT 'null',
  `correct` varchar(10) NOT NULL,
  `usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `qstn_id` varchar(255) NOT NULL,
  `qstnnr_id` varchar(255) NOT NULL,
  `active` varchar(2) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_answer`
--

INSERT INTO `tbl_answer` (`id`, `ans_id`, `answer`, `correct`, `usr_id`, `crs_id`, `qstn_id`, `qstnnr_id`, `active`, `created_at`, `updated_at`) VALUES
(41, '5fe1b6b284353', 'a', '1', '5fdf84d50aa39', '5fdf84469bf2f', '5fe1b651e23aa', '5fe1b63c74289', '1', '2020-12-22 09:04:50', '2020-12-22 09:04:50'),
(42, '5fe1b6bb8f1f7', 'a', '1', '5fdf84d50aa39', '5fdf84469bf2f', '5fe1b658afd51', '5fe1b63c74289', '1', '2020-12-22 09:04:59', '2020-12-22 09:04:59'),
(43, '5fe1b6bcc14d9', 'a', '1', '5fdf84d50aa39', '5fdf84469bf2f', '5fe1b66060306', '5fe1b63c74289', '1', '2020-12-22 09:05:00', '2020-12-22 09:05:00'),
(44, '5fe1b6c2e466c', 'b', '0', '5fdf84d50aa39', '5fdf84469bf2f', '5fe1b66758023', '5fe1b63c74289', '1', '2020-12-22 09:05:06', '2020-12-22 09:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `id` int(6) UNSIGNED NOT NULL,
  `cmmnt_id` varchar(255) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `pst_id` varchar(255) NOT NULL,
  `active` varchar(2) DEFAULT '1',
  `repliedto_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `id` int(6) UNSIGNED NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `num` varchar(100) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `descriptitle` varchar(255) NOT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `schedule` varchar(10) DEFAULT NULL,
  `accesscode` varchar(150) DEFAULT NULL,
  `usr_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `crs_id`, `num`, `section`, `descriptitle`, `start_time`, `end_time`, `schedule`, `accesscode`, `usr_id`, `created_at`, `updated_at`) VALUES
(53, '5fdf81a83da5f', 'CS150', 'INF4A', 'Capstone Project', '10:00', '12:00', 'MWF', '5fdf81a83da64', '5fdf7ffe15fda', '2020-12-20 16:54:00', '2020-12-20 16:54:00'),
(54, '5fdf84469bf2f', 'CS120', 'INF4A', 'OOP Java 1', '10:00', '12:00', 'TTH', '5fdf85bdab66d', '5fdf83ebe49b2', '2020-12-20 17:05:10', '2020-12-20 17:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forum`
--

CREATE TABLE `tbl_forum` (
  `frm_id` int(11) UNSIGNED NOT NULL,
  `msg` text NOT NULL,
  `usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_forum`
--

INSERT INTO `tbl_forum` (`frm_id`, `msg`, `usr_id`, `crs_id`, `created_at`, `updated_at`) VALUES
(7, 'hi every one\n', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-20 17:07:11', '2020-12-20 17:07:11'),
(8, 'hello world', '5fdf84d50aa39', '5fdf84469bf2f', '2020-12-20 17:08:57', '2020-12-20 17:08:57'),
(9, 'hi\n', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-20 17:18:22', '2020-12-20 17:18:22'),
(10, 'hello\n', '5fdf84d50aa39', '5fdf84469bf2f', '2020-12-22 08:58:28', '2020-12-22 08:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_message`
--

CREATE TABLE `tbl_message` (
  `id` int(11) UNSIGNED NOT NULL,
  `msg` varchar(255) DEFAULT NULL,
  `attached_file` varchar(255) DEFAULT NULL,
  `name_file` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `active` varchar(2) DEFAULT '1',
  `std_id` varchar(255) DEFAULT NULL,
  `from_usr_id` varchar(255) NOT NULL,
  `to_usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_message`
--

INSERT INTO `tbl_message` (`id`, `msg`, `attached_file`, `name_file`, `file_type`, `active`, `std_id`, `from_usr_id`, `to_usr_id`, `crs_id`, `created_at`, `updated_at`) VALUES
(35, 'sample message', 'uploads/5fdf84469bf2f/messages/5fdf84d50aa39/images.png', 'images.png', 'image', '1', '5fdf84d50aa39', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-20 17:09:18', '2020-12-20 17:09:18'),
(36, 'hello ', '', '', '', '1', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84d50aa39', '5fdf84469bf2f', '2020-12-20 17:13:46', '2020-12-20 17:13:46'),
(37, 'hello 2', '', '', '', '1', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84d50aa39', '5fdf84469bf2f', '2020-12-20 17:14:05', '2020-12-20 17:14:05'),
(38, 'hehe', '', '', '', '1', '5fdf84d50aa39', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-21 14:23:57', '2020-12-21 14:23:57'),
(39, 'hi', '', '', '', '1', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84d50aa39', '5fdf84469bf2f', '2020-12-21 14:43:12', '2020-12-21 14:43:12'),
(40, 'hi2', '', '', '', '1', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84d50aa39', '5fdf84469bf2f', '2020-12-21 14:43:24', '2020-12-21 14:43:24'),
(41, 'hi', '', '', '', '1', '5fe0b4cc483b6', '5fe0b4cc483b6', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-21 14:45:21', '2020-12-21 14:45:21'),
(42, 'White hat', 'uploads/5fdf84469bf2f/messages/5fe0b4cc483b6/white-hat-seo.png', 'white-hat-seo.png', 'image', '1', '5fe0b4cc483b6', '5fe0b4cc483b6', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-21 14:45:31', '2020-12-21 14:45:31'),
(43, 'hello world\r\n', '', '', '', '1', '5fe0b5b18c1aa', '5fe0b5b18c1aa', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-21 14:49:30', '2020-12-21 14:49:30'),
(44, 'hello\r\n', '', '', '', '1', '5fdf84d50aa39', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-22 08:58:17', '2020-12-22 08:58:17'),
(45, 'hi\r\n', '', '', '', '1', '5fdf84d50aa39', '5fdf84d50aa39', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-22 09:04:41', '2020-12-22 09:04:41'),
(46, 'asdasdasdasdas', '', '', '', '1', '5fe0b4cc483b6', '5fdf83ebe49b2', '5fe0b4cc483b6', '5fdf84469bf2f', '2021-04-30 02:25:42', '2021-04-30 02:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE `tbl_post` (
  `id` int(11) UNSIGNED NOT NULL,
  `pst_id` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `descript` varchar(255) DEFAULT NULL,
  `locale` varchar(255) DEFAULT NULL,
  `types` varchar(100) DEFAULT NULL,
  `namefile` varchar(255) DEFAULT NULL,
  `active` varchar(2) DEFAULT '1',
  `usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `pst_id`, `title`, `descript`, `locale`, `types`, `namefile`, `active`, `usr_id`, `crs_id`, `created_at`, `updated_at`) VALUES
(84, '5fdf845acbbc3', 'titles', 'post description', 'uploads/5fdf84469bf2f/white-hat-seo.png', 'image', 'white-hat-seo.png', '0', '5fdf83ebe49b2', '5fdf84469bf2f', '2020-12-20 17:05:30', '2021-05-03 12:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE `tbl_question` (
  `id` int(11) UNSIGNED NOT NULL,
  `qstn_id` varchar(255) NOT NULL,
  `question` text DEFAULT NULL,
  `a` varchar(100) DEFAULT NULL,
  `b` varchar(100) DEFAULT NULL,
  `c` varchar(100) DEFAULT NULL,
  `d` varchar(100) DEFAULT NULL,
  `answer` varchar(100) DEFAULT NULL,
  `file_locale` varchar(255) NOT NULL,
  `file_names` varchar(255) NOT NULL,
  `file_types` varchar(255) NOT NULL,
  `usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `qstnnr_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`id`, `qstn_id`, `question`, `a`, `b`, `c`, `d`, `answer`, `file_locale`, `file_names`, `file_types`, `usr_id`, `crs_id`, `qstnnr_id`, `created_at`, `updated_at`) VALUES
(73, '5fdf849009bf3', '1+1', '1', '2', '4', '5', 'b', '', '', '', '5fdf83ebe49b2', '5fdf84469bf2f', '5fdf8481ebb79', '2020-12-20 17:06:24', '2020-12-20 17:06:24'),
(74, '5fdf8498b6982', '2+2', '4', '5', '6', '7', 'a', '', '', '', '5fdf83ebe49b2', '5fdf84469bf2f', '5fdf8481ebb79', '2020-12-20 17:06:32', '2020-12-20 17:06:32'),
(75, '5fdf84a186635', '3+3', '3', '4', '5', '6', 'd', '', '', '', '5fdf83ebe49b2', '5fdf84469bf2f', '5fdf8481ebb79', '2020-12-20 17:06:41', '2020-12-20 17:06:41'),
(76, '5fdf84a9276d2', '4+4', '9', '8', '7', '6', 'b', '', '', '', '5fdf83ebe49b2', '5fdf84469bf2f', '5fdf8481ebb79', '2020-12-20 17:06:49', '2020-12-20 17:06:49'),
(77, '5fdf84b1860a0', '5+5', '10', '11', '3', '1', 'a', '', '', '', '5fdf83ebe49b2', '5fdf84469bf2f', '5fdf8481ebb79', '2020-12-20 17:06:57', '2020-12-20 17:06:57'),
(78, '5fe1b651e23aa', 'jkjkjJK', 'JKJ', 'JK', 'j', 'jk', 'a', '', '', '', '5fdf83ebe49b2', '5fdf84469bf2f', '5fe1b63c74289', '2020-12-22 09:03:13', '2020-12-22 09:03:13'),
(123, '608d3c0ccc893', 'fsdfsdfsdfsdfsdfds', 'fsdf', 'sfsdfdssfs', 'sdffsdfdsfsd', 'fsdfsdfsdfsdfdsf', 'a', 'uploads/5fdf84469bf2f/DSCN0748.JPG', 'DSCN0748.JPG', 'image', '5fdf83ebe49b2', '5fdf84469bf2f', '5fe1b63c74289', '2021-05-01 11:31:24', '2021-05-01 11:33:37'),
(125, '608d3cd5ee013', 'dsfdsfds', 'fdsf', 'sdfsd', 'fsdfsd', 'fdsfdsfds', 'a', 'uploads/5fdf84469bf2f/60340847.jfif', '60340847.jfif', 'image', '5fdf83ebe49b2', '5fdf84469bf2f', '5fe1b63c74289', '2021-05-01 11:34:45', '2021-05-01 11:34:45'),
(126, '608d3cdd5a4ee', 'fdsfdsfds', 'sdfds', 'fsf', 'fdsfs', 'dfsdfsdfds', 'a', 'uploads/5fdf84469bf2f/422-4221647_download-slim-framework-logo-png.png', '422-4221647_download-slim-framework-logo-png.png', 'image', '5fdf83ebe49b2', '5fdf84469bf2f', '5fe1b63c74289', '2021-05-01 11:34:53', '2021-05-01 11:34:53'),
(127, '608d3ce30414b', 'dfsfds', 'fs', 'fdsf', 'dsfds', 'sfsdfdsfsd', 'a', 'uploads/5fdf84469bf2f/', '', '', '5fdf83ebe49b2', '5fdf84469bf2f', '5fe1b63c74289', '2021-05-01 11:34:59', '2021-05-01 11:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_questionnaire`
--

CREATE TABLE `tbl_questionnaire` (
  `id` int(11) UNSIGNED NOT NULL,
  `qstnnr_id` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `descript` varchar(255) DEFAULT NULL,
  `types` varchar(100) DEFAULT NULL,
  `items` int(11) DEFAULT NULL,
  `expiration` varchar(255) DEFAULT NULL,
  `timer` int(11) DEFAULT NULL,
  `answerkey` varchar(1) DEFAULT '0',
  `status` varchar(100) DEFAULT 'inactive',
  `usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `active` varchar(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_questionnaire`
--

INSERT INTO `tbl_questionnaire` (`id`, `qstnnr_id`, `title`, `descript`, `types`, `items`, `expiration`, `timer`, `answerkey`, `status`, `usr_id`, `crs_id`, `active`, `created_at`, `updated_at`) VALUES
(34, '5fdf8481ebb79', 'Quiz', 'Please Answer it.', 'Multiple Choice', 5, '2020-12-23T00:00', 1, '1', 'active', '5fdf83ebe49b2', '5fdf84469bf2f', '1', '2020-12-20 17:06:09', '2020-12-22 09:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_score`
--

CREATE TABLE `tbl_score` (
  `id` int(11) UNSIGNED NOT NULL,
  `scr_id` varchar(255) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `usr_id` varchar(255) NOT NULL,
  `qstnnr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `active` varchar(2) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_score`
--

INSERT INTO `tbl_score` (`id`, `scr_id`, `score`, `usr_id`, `qstnnr_id`, `crs_id`, `active`, `created_at`, `updated_at`) VALUES
(12, '5fe1b611c0784', 0, '5fdf84d50aa39', '5fdf8481ebb79', '5fdf84469bf2f', '1', '2020-12-22 09:02:09', '2020-12-22 09:02:09'),
(13, '5fe1b6ed473ae', 3, '5fdf84d50aa39', '5fe1b63c74289', '5fdf84469bf2f', '1', '2020-12-22 09:05:49', '2020-12-22 09:05:49'),
(14, '608d3ecd7a937', 0, '608d3e66e73d1', '5fe1b63c74289', '5fdf84469bf2f', '1', '2021-05-01 11:43:09', '2021-05-01 11:43:09'),
(15, '608d4037e22ec', 0, '608b720b79b54', '5fe1b63c74289', '5fdf84469bf2f', '1', '2021-05-01 11:49:11', '2021-05-01 11:49:11'),
(16, '608d40bc85169', 0, '608d4072a657e', '5fe1b63c74289', '5fdf84469bf2f', '1', '2021-05-01 11:51:24', '2021-05-01 11:51:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_studentcourse`
--

CREATE TABLE `tbl_studentcourse` (
  `id` int(11) UNSIGNED NOT NULL,
  `stdcrse_id` varchar(255) NOT NULL,
  `usr_id` varchar(255) NOT NULL,
  `crs_id` varchar(255) NOT NULL,
  `active` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_studentcourse`
--

INSERT INTO `tbl_studentcourse` (`id`, `stdcrse_id`, `usr_id`, `crs_id`, `active`, `created_at`, `updated_at`) VALUES
(20, '5fdf873e36926', '5fdf84d50aa39', '5fdf84469bf2f', '1', '2020-12-20 17:17:50', '2020-12-20 17:17:50'),
(21, '5fe0b4f1b4595', '5fe0b4cc483b6', '5fdf84469bf2f', '1', '2020-12-21 14:45:05', '2020-12-21 14:45:05'),
(22, '5fe0b5efe42f5', '5fe0b5b18c1aa', '5fdf84469bf2f', '1', '2020-12-21 14:49:19', '2020-12-21 14:49:19'),
(23, '608d3e7182a9b', '608d3e66e73d1', '5fdf84469bf2f', '1', '2021-05-01 11:41:37', '2021-05-01 11:41:37'),
(24, '608d3fb1155b1', '608b720b79b54', '5fdf84469bf2f', '1', '2021-05-01 11:46:57', '2021-05-01 11:46:57'),
(25, '608d407b39bee', '608d4072a657e', '5fdf84469bf2f', '1', '2021-05-01 11:50:19', '2021-05-01 11:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timer`
--

CREATE TABLE `tbl_timer` (
  `id` int(11) UNSIGNED NOT NULL,
  `timer_date` varchar(255) DEFAULT NULL,
  `stud_id` varchar(255) DEFAULT NULL,
  `qstnnr_id` varchar(255) DEFAULT NULL,
  `active` varchar(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_timer`
--

INSERT INTO `tbl_timer` (`id`, `timer_date`, `stud_id`, `qstnnr_id`, `active`, `created_at`, `updated_at`) VALUES
(15, '2020-12-20T17:10:26.267Z', '5fdf84d50aa39', '5fdf8481ebb79', '1', '2020-12-20 17:09:26', '2020-12-20 17:09:26'),
(16, '2020-12-21T14:50:41.625Z', '5fe0b5b18c1aa', '5fdf8481ebb79', '1', '2020-12-21 14:49:41', '2020-12-21 14:49:41'),
(17, '2020-12-22T09:05:47.116Z', '5fdf84d50aa39', '5fe1b63c74289', '1', '2020-12-22 09:04:47', '2020-12-22 09:04:47'),
(18, '2021-05-01T11:43:04.731Z', '608d3e66e73d1', '5fe1b63c74289', '1', '2021-05-01 11:42:04', '2021-05-01 11:42:04'),
(19, '2021-05-01T11:48:01.316Z', '608b720b79b54', '5fe1b63c74289', '1', '2021-05-01 11:47:01', '2021-05-01 11:47:01'),
(20, '2021-05-01T11:51:23.695Z', '608d4072a657e', '5fe1b63c74289', '1', '2021-05-01 11:50:23', '2021-05-01 11:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(6) UNSIGNED NOT NULL,
  `usr_id` varchar(255) NOT NULL,
  `std_id` varchar(255) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `profilepic` varchar(255) DEFAULT NULL,
  `department` varchar(255) NOT NULL,
  `types` varchar(50) NOT NULL,
  `active` varchar(2) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `usr_id`, `std_id`, `firstname`, `middlename`, `lastname`, `email`, `pass`, `profilepic`, `department`, `types`, `active`, `created_at`, `updated_at`) VALUES
(3, '5fb6cffff28ad', NULL, 'Tomas', 'Daano', 'Cadenas', 'stormking010@gmail.com', '$2y$10$gGa7vtNJivHINgOtR6nf6OxjMLzhBXFIU2ArwZ6i.vy81/SuhCfRi', 'uploads/profiles/5fb6cffff28ad/0.jpg', '', 'Admin', '1', '2020-11-19 20:05:20', '2020-12-21 14:42:48'),
(30, '5fdf83ebe49b2', '2019-00005', 'Joharah', '', 'Beloria', 'rarayatsu@gmail.com', '$2y$10$hJTNYxu/EsjK3v/xOMRkq.i8RbTaIEHoUJlDnDkFiCxPALhMmKnL6', 'uploads/profiles/5fdf83ebe49b2/pikachu.png', '', 'Faculty', '1', '2020-12-20 17:03:40', '2021-04-30 02:51:19'),
(31, '5fdf84d50aa39', NULL, 'Cory', NULL, 'Khong', 'corykhong@gmail.com', '$2y$10$pVVYg/BLljYWMaBoAoj52ePMW9W1oWdYgPor8O.VsEm5DbXs8wwm6', 'uploads/profiles/5fdf84d50aa39/unnamed.jpg', '', 'Student', '1', '2020-12-20 17:07:33', '2020-12-21 14:24:10'),
(32, '5fe0b4cc483b6', NULL, 'Bob', NULL, 'Uy', 'bobuy@gmail.com', '$2y$10$bO1MW6vvjHTbr7d/yb.Oy.Y8ARCwUGrkZahKHLqDYkiLJRDnAKzJy', 'uploads/profiles/5fe0b4cc483b6/white-hat-seo.png', '', 'Student', '1', '2020-12-21 14:44:28', '2021-05-03 12:40:13'),
(33, '5fe0b5b18c1aa', NULL, 'Madi', NULL, 'Lim', 'madilim@gmail.com', '$2y$10$rR2HJxHnVrG6EVKLS6toy.RY50WBTE9jwYPvG/BHFD0/MAoWo2dre', 'uploads/profiles/5fe0b5b18c1aa/Joharah.jpg', '', 'Student', '0', '2020-12-21 14:48:17', '2021-04-30 02:51:24'),
(34, '608b715041fe5', NULL, 'Joharah', NULL, 'Baboy', 'joharahbaboy@gmail.com', '$2y$10$uZE1qzM0bKvpP81FXxFkMOXOtpBeWf94M.m1K1bJUdLQezS2zF2vC', 'icons/user.svg', '', 'Student', '1', '2021-04-30 02:54:08', '2021-04-30 02:54:08'),
(35, '608b720b79b54', NULL, 'John', NULL, 'Doe', 'jd@gmail.com', '$2y$10$a7vGxgC6rBYRF3gkps0Qzu.y9Q3SPKL9/HzN8Pzw2EJ5Nu8XYG8my', 'icons/user.svg', '', 'Student', '1', '2021-04-30 02:57:15', '2021-04-30 02:57:15'),
(36, '608d3e66e73d1', NULL, 'Dina', NULL, 'Makita', 'dinamakita@gmail.com', '$2y$10$0Pcc9Ddzrx9VDOaEnN7p/ub01pp3kargQSeB9yCETGC5PonBDPoci', 'icons/user.svg', '', 'Student', '1', '2021-05-01 11:41:27', '2021-05-03 14:24:00'),
(37, '608d4072a657e', NULL, 'Sample', NULL, 'Lastname', 'sample@gmail.com', '$2y$10$1py8Tsrq0ZONLORrY8ibPOCPGGzI0bQU5Lfi73zSVfbt0gb4vHY92', 'icons/user.svg', '', 'Student', '1', '2021-05-01 11:50:10', '2021-05-01 11:50:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_answer`
--
ALTER TABLE `tbl_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cmmnt_id` (`cmmnt_id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crs_id` (`crs_id`);

--
-- Indexes for table `tbl_forum`
--
ALTER TABLE `tbl_forum`
  ADD PRIMARY KEY (`frm_id`);

--
-- Indexes for table `tbl_message`
--
ALTER TABLE `tbl_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pst_id` (`pst_id`);

--
-- Indexes for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qstn_id` (`qstn_id`);

--
-- Indexes for table `tbl_questionnaire`
--
ALTER TABLE `tbl_questionnaire`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_score`
--
ALTER TABLE `tbl_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_studentcourse`
--
ALTER TABLE `tbl_studentcourse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_timer`
--
ALTER TABLE `tbl_timer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usr_id` (`usr_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `std_id` (`std_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_answer`
--
ALTER TABLE `tbl_answer`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tbl_forum`
--
ALTER TABLE `tbl_forum`
  MODIFY `frm_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_message`
--
ALTER TABLE `tbl_message`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `tbl_questionnaire`
--
ALTER TABLE `tbl_questionnaire`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_score`
--
ALTER TABLE `tbl_score`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_studentcourse`
--
ALTER TABLE `tbl_studentcourse`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_timer`
--
ALTER TABLE `tbl_timer`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
