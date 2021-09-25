-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2021 at 06:20 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dormitory_kesara`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `firstname` varchar(255) NOT NULL COMMENT 'ชื่อจริง',
  `lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `contact` text NOT NULL COMMENT 'ข้อมูลติดต่อ',
  `password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `firstname`, `lastname`, `contact`, `password`, `created`, `updated`) VALUES
('oshi', 'วงศ์วสันต์', 'ดวงเกตุ', '0972651700', '$2y$10$lgGxOoDeBRCzPBgcU8rQM.svzzD2x1cOIU3iXzFdqwOvynII0O7dK', '2021-09-23 05:58:18', '2021-09-23 07:22:40'),
('prakorn', 'Prakorn', 'Junthalungzevorakul', '', '$2y$10$VMvz/MN84nAtrBsEd9WJQeucmkOR11EgWAUzxUROMyUfulvZnSzJC', '2021-09-23 07:16:09', '2021-09-23 07:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL COMMENT 'รหัส',
  `name` varchar(255) NOT NULL COMMENT 'ชื่อธนาคาร',
  `account_number` varchar(255) NOT NULL COMMENT 'เลขบัญชี',
  `branch` varchar(255) NOT NULL COMMENT 'สาขา',
  `holder` varchar(255) NOT NULL COMMENT 'เจ้าของบัญชี',
  `img` text NOT NULL COMMENT 'ไฟล์ภาพธนาคาร',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `account_number`, `branch`, `holder`, `img`, `created`, `updated`) VALUES
(2, 'ไทยพาณิชย์', '4066171712', 'โรบินสัน', 'วงศ์วสันต์ ดวงเกตุ', '614e3e078be0a.jpg', '2021-09-24 21:07:19', '2021-09-24 21:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id_card` char(13) NOT NULL COMMENT 'เลขบัตรประชาชน',
  `firstname` varchar(255) NOT NULL COMMENT 'ชื่อจริง',
  `lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `gender` varchar(10) NOT NULL COMMENT 'เพศ',
  `phone_number` varchar(255) NOT NULL COMMENT 'เบอร์โทร',
  `address` text NOT NULL COMMENT 'ที่อยู่',
  `email` varchar(255) NOT NULL COMMENT 'อีเมล',
  `password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `current_book` varchar(255) NOT NULL COMMENT 'รายการปัจจุบัน',
  `status` varchar(255) NOT NULL COMMENT 'สถานะ',
  `active` varchar(10) NOT NULL DEFAULT 'Enable' COMMENT 'สถานะบัญชี',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เพิ่มข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id_card`, `firstname`, `lastname`, `gender`, `phone_number`, `address`, `email`, `password`, `current_book`, `status`, `active`, `created`, `updated`) VALUES
('1459900696781', 'วงศ์วสันต์', 'ดวงเกตุ', 'ชาย', '0972651700', '', 'thephenome1998@gmail.com', '$2y$10$J9FHiu.nhwt3xzQfk9QAGewv83Q2EZ.gi0Ok91MMIvAJqlimrS6Pa', 'MB20210925-591', 'ว่าง', 'Enable', '2021-09-22 18:11:13', '2021-09-25 03:53:37'),
('9999999999999', 'กฤตภาส', 'ฉัตรอุดมกุล', 'ชาย', '0972651700', '', 'test001@gmail.com', '$2y$10$XgbZ/ZiMUvTjJytOT5ZNCOV3fjiBo3.yvb0J8KiLPPOPbYfeJDuzy', 'DB20210925-826', 'ว่าง', 'Enable', '2021-09-23 08:36:02', '2021-09-25 04:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `daily_books`
--

CREATE TABLE `daily_books` (
  `id` varchar(255) NOT NULL COMMENT 'รหัส',
  `customer_id` char(13) NOT NULL COMMENT 'เลขบัตรลูกค้า',
  `daterange` varchar(255) NOT NULL COMMENT 'ช่วงวันที่',
  `duration` int(11) NOT NULL COMMENT 'ระยะเวลา',
  `check_in` date NOT NULL COMMENT 'วันที่เช็คอิน',
  `check_out` date NOT NULL COMMENT 'วันที่เช็คเอาท์',
  `time` time NOT NULL COMMENT 'เวลา',
  `cost` decimal(10,2) NOT NULL COMMENT 'ค่าที่พัก',
  `check_in_datetime` datetime DEFAULT NULL COMMENT 'วันที่เข้าเช็คอิน',
  `check_out_datetime` datetime DEFAULT NULL COMMENT 'วันที่ออกเช็คเอาท์',
  `daily_room_id` varchar(255) DEFAULT NULL COMMENT 'เลขห้อง',
  `status` varchar(255) NOT NULL COMMENT 'สถานะ',
  `note` text NOT NULL COMMENT 'หมายเหตุ',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily_books`
--

INSERT INTO `daily_books` (`id`, `customer_id`, `daterange`, `duration`, `check_in`, `check_out`, `time`, `cost`, `check_in_datetime`, `check_out_datetime`, `daily_room_id`, `status`, `note`, `created`, `updated`) VALUES
('DB20210924-795', '1459900696781', '2021-09-28 ถึง 2021-09-30', 2, '2021-09-28', '2021-09-30', '10:00:00', '600.00', NULL, NULL, 'A1', 'ยกเลิก', 'ชำระค่ามัดจำช้า', '2021-09-24 19:04:04', '2021-09-24 23:08:05'),
('DB20210925-684', '9999999999999', '2021-10-01 ถึง 2021-10-05', 4, '2021-10-01', '2021-10-05', '12:00:00', '1200.00', '2021-09-25 08:47:08', '2021-09-25 08:47:16', 'A2', 'เสร็จสิ้น', '', '2021-09-25 01:45:16', '2021-09-25 01:47:16'),
('DB20210925-744', '9999999999999', '2021-09-25 ถึง 2021-09-26', 1, '2021-09-25', '2021-09-26', '13:00:00', '300.00', NULL, NULL, 'A2', 'ยกเลิก', 'ห้องไม่พร้อมบริการ', '2021-09-24 22:55:33', '2021-09-24 23:02:59'),
('DB20210925-780', '1459900696781', '2021-09-27 ถึง 2021-09-28', 1, '2021-09-27', '2021-09-28', '14:00:00', '300.00', '2021-09-25 08:28:43', '2021-09-25 08:34:36', 'A1', 'เสร็จสิ้น', '', '2021-09-24 23:09:07', '2021-09-25 01:34:36'),
('DB20210925-826', '9999999999999', '2021-09-30 ถึง 2021-10-02', 2, '2021-09-30', '2021-10-02', '15:00:00', '600.00', NULL, NULL, 'A1', 'รออนุมัติ', '', '2021-09-25 04:13:34', '2021-09-25 04:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `daily_rooms`
--

CREATE TABLE `daily_rooms` (
  `id` varchar(255) NOT NULL COMMENT 'เลขห้อง',
  `type` int(11) NOT NULL COMMENT 'ประเภทห้อง',
  `floor` varchar(255) NOT NULL COMMENT 'ชั้น',
  `img_position` text NOT NULL COMMENT 'ไฟล์ภาพตำแหน่งห้อง',
  `active` varchar(255) NOT NULL DEFAULT 'พร้อมใช้งาน' COMMENT 'สถานะห้อง',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เพิ่มข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily_rooms`
--

INSERT INTO `daily_rooms` (`id`, `type`, `floor`, `img_position`, `active`, `created`, `updated`) VALUES
('A1', 3, '1', '614e0a26dafc2.jpg', 'พร้อมใช้งาน', '2021-09-24 14:10:05', '2021-09-24 17:25:58'),
('A2', 3, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:10:10', '2021-09-24 14:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` varchar(255) NOT NULL COMMENT 'รหัส',
  `customer_id` char(13) NOT NULL COMMENT 'ลูกค้า',
  `book_id` varchar(255) NOT NULL COMMENT 'เลขจอง',
  `amount` decimal(10,2) NOT NULL COMMENT 'ยอดเงิน',
  `slip` text NOT NULL COMMENT 'ไฟล์ภาพสลิป',
  `receive_bank` varchar(255) NOT NULL COMMENT 'ธนาคารรับเงิน',
  `receive_account_number` varchar(255) NOT NULL COMMENT 'เลขบัญชีผู้รับ',
  `receive_owner` varchar(255) NOT NULL COMMENT 'ชื่อผู้รับโอน',
  `transfer_bank` varchar(255) NOT NULL COMMENT 'ธนาคารผู้โอน',
  `transfer_account_number` varchar(255) NOT NULL COMMENT 'เลขบัญชีผู้โอน',
  `transfer_owner` varchar(255) NOT NULL COMMENT 'ชื่อบัญชีผู้โอน',
  `transfer_datetime` datetime NOT NULL COMMENT 'วันเวลาที่โอน',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `customer_id`, `book_id`, `amount`, `slip`, `receive_bank`, `receive_account_number`, `receive_owner`, `transfer_bank`, `transfer_account_number`, `transfer_owner`, `transfer_datetime`, `created`, `updated`) VALUES
('DP20210925-214', '9999999999999', 'DB20210925-684', '600.00', 'DP20210925-214.jpg', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4666666612', 'กฤตภาส ฉัตรอุดมกุล', '2021-09-25 08:46:00', '2021-09-25 01:46:15', '2021-09-25 01:46:15'),
('DP20210925-238', '1459900696781', 'DB20210925-780', '150.00', 'DP20210925-238.jpg', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', '2021-09-25 07:39:00', '2021-09-25 00:39:17', '2021-09-25 00:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `img` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `img`, `type_id`, `created`) VALUES
(5, '614cd5e83bee2.jpg', 5, '2021-09-23 19:30:48'),
(6, '614cd5e847963.jpg', 5, '2021-09-23 19:30:48'),
(7, '614cd5e853b1f.jpg', 5, '2021-09-23 19:30:48'),
(8, '614cd5e86cca4.jpg', 5, '2021-09-23 19:30:48'),
(9, '614cd5f32fed2.jpg', 4, '2021-09-23 19:30:59'),
(10, '614cd5f346690.jpg', 4, '2021-09-23 19:30:59'),
(11, '614cd5f35da68.jpg', 4, '2021-09-23 19:30:59'),
(12, '614cd5f36cb03.jpg', 4, '2021-09-23 19:30:59'),
(13, '614cd5f99f913.jpg', 3, '2021-09-23 19:31:05'),
(14, '614cd5f9b2e3f.jpg', 3, '2021-09-23 19:31:05'),
(15, '614cd5f9bf0df.jpg', 3, '2021-09-23 19:31:05');

-- --------------------------------------------------------

--
-- Table structure for table `monthly_books`
--

CREATE TABLE `monthly_books` (
  `id` varchar(255) NOT NULL COMMENT 'รหัส',
  `customer_id` char(13) NOT NULL COMMENT 'รหัสลูกค้า',
  `schedule_move_in` datetime DEFAULT NULL COMMENT 'กำหนดการจะย้ายเข้า',
  `move_in_date` date DEFAULT NULL COMMENT 'วันที่ย้ายเข้า',
  `move_out_date` date DEFAULT NULL COMMENT 'วันที่ย้ายออก',
  `cost` decimal(10,2) NOT NULL COMMENT 'ค่าที่พัก',
  `monthly_room_id` varchar(255) NOT NULL COMMENT 'เลขห้อง',
  `status` varchar(255) NOT NULL COMMENT 'สถานะ',
  `note` text NOT NULL COMMENT 'หมายเหตุ',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `monthly_books`
--

INSERT INTO `monthly_books` (`id`, `customer_id`, `schedule_move_in`, `move_in_date`, `move_out_date`, `cost`, `monthly_room_id`, `status`, `note`, `created`, `updated`) VALUES
('MB20210925-591', '1459900696781', '2021-10-01 13:00:00', NULL, NULL, '3000.00', 'B11', 'รออนุมัติ', '', '2021-09-25 03:53:37', '2021-09-25 03:53:37');

-- --------------------------------------------------------

--
-- Table structure for table `monthly_rooms`
--

CREATE TABLE `monthly_rooms` (
  `id` varchar(255) NOT NULL COMMENT 'เลขห้อง',
  `type` int(11) NOT NULL COMMENT 'ประเภทห้อง',
  `floor` varchar(255) NOT NULL COMMENT 'ชั้น',
  `img_position` text NOT NULL COMMENT 'ไฟล์ภาพตำแหน่งห้อง',
  `active` varchar(255) NOT NULL DEFAULT 'พร้อมใช้งาน' COMMENT 'สถานะห้อง',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เพิ่มข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `monthly_rooms`
--

INSERT INTO `monthly_rooms` (`id`, `type`, `floor`, `img_position`, `active`, `created`, `updated`) VALUES
('A10', 4, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:12:06', '2021-09-24 14:12:06'),
('A11', 4, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:12:16', '2021-09-24 14:12:16'),
('A12', 4, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:12:38', '2021-09-24 14:12:38'),
('A3', 5, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:07:30', '2021-09-24 14:07:30'),
('A4', 5, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:10:22', '2021-09-24 14:10:22'),
('A5', 5, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:11:17', '2021-09-24 14:11:17'),
('A6', 4, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:11:31', '2021-09-24 14:11:31'),
('A7', 4, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:11:38', '2021-09-24 14:11:38'),
('A8', 4, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:11:46', '2021-09-24 14:11:46'),
('A9', 4, '1', '', 'พร้อมใช้งาน', '2021-09-24 14:11:57', '2021-09-24 14:11:57'),
('B1', 5, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:12:44', '2021-09-24 14:12:44'),
('B10', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:14:13', '2021-09-24 14:14:13'),
('B11', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:14:26', '2021-09-24 14:14:26'),
('B13', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:14:54', '2021-09-24 14:14:54'),
('B14', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:15:05', '2021-09-24 14:15:05'),
('B15', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:15:12', '2021-09-24 14:15:12'),
('B2', 5, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:12:53', '2021-09-24 14:12:53'),
('B3', 5, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:13:12', '2021-09-24 14:13:12'),
('B4', 5, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:13:21', '2021-09-24 14:13:21'),
('B5', 5, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:13:33', '2021-09-24 14:13:33'),
('B6', 5, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:13:47', '2021-09-24 14:13:47'),
('B7', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:13:54', '2021-09-24 14:13:54'),
('B8', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:13:59', '2021-09-24 14:13:59'),
('B9', 4, '2', '', 'พร้อมใช้งาน', '2021-09-24 14:14:05', '2021-09-24 14:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `roomtypes`
--

CREATE TABLE `roomtypes` (
  `id` int(11) NOT NULL COMMENT 'รหัส',
  `name` varchar(255) NOT NULL COMMENT 'ชื่อประเภท',
  `type` varchar(255) NOT NULL COMMENT 'ชนิด',
  `description` text NOT NULL COMMENT 'รายละเอียด',
  `price` decimal(10,2) NOT NULL COMMENT 'ค่าห้อง',
  `img` text NOT NULL COMMENT 'ไฟล์ภาพ',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomtypes`
--

INSERT INTO `roomtypes` (`id`, `name`, `type`, `description`, `price`, `img`, `created`, `updated`) VALUES
(3, 'รายวัน (แอร์)', 'รายวัน', 'ห้องพักรายวัน แอร์\r\n300 บาท/คืน', '300.00', '614c7fa5b722a.jpg', '2021-09-23 13:22:45', '2021-09-24 12:27:39'),
(4, 'รายเดือน (แอร์)', 'รายเดือน', 'ห้องรายเดือน แอร์ \r\n3000 บาท ต่อเดือน', '3000.00', '614c801cdb165.jpg', '2021-09-23 13:24:44', '2021-09-24 12:27:43'),
(5, 'รายเดือน (พัดลม)', 'รายเดือน', 'ห้องพักรายเดือน พัดลม\r\n2500 บาท ต่อเดือน', '2500.00', '614c8034f2fef.jpg', '2021-09-23 13:25:08', '2021-09-24 12:54:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_card`);

--
-- Indexes for table `daily_books`
--
ALTER TABLE `daily_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `daily_room_id` (`daily_room_id`);

--
-- Indexes for table `daily_rooms`
--
ALTER TABLE `daily_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `monthly_books`
--
ALTER TABLE `monthly_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `monthly_room_id` (`monthly_room_id`);

--
-- Indexes for table `monthly_rooms`
--
ALTER TABLE `monthly_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `roomtypes`
--
ALTER TABLE `roomtypes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roomtypes`
--
ALTER TABLE `roomtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daily_books`
--
ALTER TABLE `daily_books`
  ADD CONSTRAINT `daily_books_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id_card`),
  ADD CONSTRAINT `daily_books_ibfk_3` FOREIGN KEY (`daily_room_id`) REFERENCES `daily_rooms` (`id`);

--
-- Constraints for table `daily_rooms`
--
ALTER TABLE `daily_rooms`
  ADD CONSTRAINT `daily_rooms_ibfk_1` FOREIGN KEY (`type`) REFERENCES `roomtypes` (`id`);

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id_card`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `roomtypes` (`id`);

--
-- Constraints for table `monthly_books`
--
ALTER TABLE `monthly_books`
  ADD CONSTRAINT `monthly_books_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id_card`),
  ADD CONSTRAINT `monthly_books_ibfk_2` FOREIGN KEY (`monthly_room_id`) REFERENCES `monthly_rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
