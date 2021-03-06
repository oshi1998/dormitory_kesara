-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2021 at 09:21 PM
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
('admin', 'admin', 'admin', '', '$2y$10$ySh4QUVOd5GTgGb9hvqD4.lkF/6c24N6cUIxqEIx3YJuUngYLvibu', '2021-09-25 09:55:19', '2021-09-25 09:55:19'),
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
  `username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
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

INSERT INTO `customers` (`username`, `id_card`, `firstname`, `lastname`, `gender`, `phone_number`, `address`, `email`, `password`, `current_book`, `status`, `active`, `created`, `updated`) VALUES
('oshi', '', 'วงศ์วสันต์', 'ดวงเกตุ', 'ชาย', '0972651700', '', 'thephenome1998@gmail.com', '$2y$10$fDseGoL5BZRPXQeJPapRy.tIlqOXGXyC5Us8JzHO9vceL9pVwATCm', 'MB20211003-46', 'ว่าง', 'Enable', '2021-10-03 16:32:48', '2021-10-03 19:53:25'),
('test', '', 'วงศ์วสันต์', 'ดวงเกตุ', 'ชาย', '0972651700', '', 'test001@gmail.com', '$2y$10$rUdB.dSKMTYVSGQ2BdJoiuZn7OR6cChfSJkg2iKMG21SxkbxgYqpe', '', 'ว่าง', 'Enable', '2021-10-03 17:41:17', '2021-10-03 17:41:17'),
('ufax36z102222', '', 'เกริกพล', 'สัมฤทธิ์', 'ชาย', '0972651700', '', 'el_fenomenos1998@hotmail.com', '$2y$10$sNqZUARdU4.Qz47yGppi4u13qBQSMtdYhdiirHxWFRrNrax26lJvC', 'DB20211028-349', 'ว่าง', 'Enable', '2021-10-03 19:32:32', '2021-10-28 16:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `daily_books`
--

CREATE TABLE `daily_books` (
  `id` varchar(255) NOT NULL COMMENT 'รหัส',
  `customer_username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งานลูกค้า',
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

INSERT INTO `daily_books` (`id`, `customer_username`, `daterange`, `duration`, `check_in`, `check_out`, `time`, `cost`, `check_in_datetime`, `check_out_datetime`, `daily_room_id`, `status`, `note`, `created`, `updated`) VALUES
('DB20211003-655', 'oshi', '2021-10-03 ถึง 2021-10-04', 1, '2021-10-03', '2021-10-04', '00:00:00', '300.00', '2021-10-04 00:55:54', '2021-10-04 00:56:04', 'A1', 'เสร็จสิ้น', '', '2021-10-03 16:54:38', '2021-10-03 17:56:04'),
('DB20211028-349', 'ufax36z102222', '2021-10-28 ถึง 2021-10-30', 2, '2021-10-28', '2021-10-30', '00:00:00', '600.00', '2021-10-28 23:36:51', NULL, 'A2', 'อยู่ระหว่างการเช็คอิน', '', '2021-10-28 16:36:18', '2021-10-28 16:36:51'),
('DB20211028-360', 'ufax36z102222', '2021-10-30 ถึง 2021-11-02', 3, '2021-10-30', '2021-11-02', '00:00:00', '900.00', '2021-10-28 22:17:01', '2021-10-28 23:35:50', 'A2', 'เสร็จสิ้น', '', '2021-10-28 15:16:10', '2021-10-28 16:35:50');

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
  `customer_username` varchar(255) NOT NULL COMMENT 'ลูกค้า',
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

INSERT INTO `deposits` (`id`, `customer_username`, `book_id`, `amount`, `slip`, `receive_bank`, `receive_account_number`, `receive_owner`, `transfer_bank`, `transfer_account_number`, `transfer_owner`, `transfer_datetime`, `created`, `updated`) VALUES
('DP20211004-214', 'oshi', 'MB20211003-487', '1500.00', 'DP20211004-214.jpg', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', '2021-10-04 01:12:00', '2021-10-03 18:13:01', '2021-10-03 18:13:01'),
('DP20211004-627', 'oshi', 'DB20211003-655', '150.00', 'DP20211004-627.jpg', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', '2021-10-04 00:55:00', '2021-10-03 17:55:27', '2021-10-03 17:55:27'),
('DP20211021-205', 'oshi', 'MB20211003-46', '1500.00', 'DP20211021-205.jpg', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', '2021-10-21 01:50:00', '2021-10-20 18:50:47', '2021-10-20 18:50:47'),
('DP20211028-103', 'ufax36z102222', 'DB20211028-349', '300.00', 'DP20211028-103.jpg', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4666666612', 'กฤตภาส ฉัตรอุดมกุล', '2021-10-28 23:36:00', '2021-10-28 16:36:42', '2021-10-28 16:36:42'),
('DP20211028-415', 'ufax36z102222', 'DB20211028-360', '450.00', 'DP20211028-415.jpg', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4066171712', 'กฤตภาส ฉัตรอุดมกุล', '2021-10-28 22:16:00', '2021-10-28 15:16:50', '2021-10-28 15:16:50');

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
  `customer_username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งานลูกค้า',
  `schedule_move_in` date DEFAULT NULL COMMENT 'กำหนดการจะย้ายเข้า',
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

INSERT INTO `monthly_books` (`id`, `customer_username`, `schedule_move_in`, `move_in_date`, `move_out_date`, `cost`, `monthly_room_id`, `status`, `note`, `created`, `updated`) VALUES
('MB20211003-46', 'oshi', '2021-10-04', '2021-10-21', NULL, '3000.00', 'A11', 'อยู่ระหว่างการเช่าห้อง', '', '2021-10-03 19:53:25', '2021-10-20 18:51:04'),
('MB20211003-487', 'oshi', '2021-10-09', '2021-10-04', '2021-10-04', '3000.00', 'B7', 'เสร็จสิ้น', '', '2021-10-03 18:06:54', '2021-10-03 18:15:45');

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
-- Table structure for table `notice_payments`
--

CREATE TABLE `notice_payments` (
  `np_id` varchar(255) NOT NULL COMMENT 'รหัสใบเสร็จ',
  `np_customer_username` varchar(255) NOT NULL COMMENT 'ลูกค้า',
  `np_manager_name` varchar(255) NOT NULL COMMENT 'ชื่อผู้จัดการ',
  `np_room_id` varchar(255) NOT NULL COMMENT 'รหัสห้อง',
  `np_month` varchar(255) NOT NULL COMMENT 'เดือน',
  `np_year` varchar(255) NOT NULL COMMENT 'ปี',
  `np_cost` decimal(10,2) NOT NULL COMMENT 'ราคาทั้งหมด',
  `np_fine` decimal(10,2) NOT NULL COMMENT 'ค่าปรับ',
  `np_expired_date` varchar(255) NOT NULL COMMENT 'วันที่หมดเขต',
  `np_status` varchar(255) NOT NULL COMMENT 'สถานะ',
  `np_pay` varchar(255) NOT NULL COMMENT 'รูปแบบการจ่ายเงิน',
  `np_receive_bank` varchar(255) NOT NULL COMMENT 'ธนาคารรับเงิน',
  `np_receive_acc` varchar(255) NOT NULL COMMENT 'เลขบัญชีรับเงิน',
  `np_receive_owner` varchar(255) NOT NULL COMMENT 'ชื่อบัญชีรับเงิน',
  `np_transfer_bank` varchar(255) NOT NULL COMMENT 'ธนาคารผู้โอน',
  `np_transfer_acc` varchar(255) NOT NULL COMMENT 'เลขบัญชีผู้โอน',
  `np_transfer_owner` varchar(255) NOT NULL COMMENT 'ชื่อบัญชีผู้โอน',
  `np_transfer_datetime` varchar(255) NOT NULL COMMENT 'เวลาที่โอน',
  `np_slip` text NOT NULL COMMENT 'ไฟล์ภาพสลิป',
  `np_created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notice_payments`
--

INSERT INTO `notice_payments` (`np_id`, `np_customer_username`, `np_manager_name`, `np_room_id`, `np_month`, `np_year`, `np_cost`, `np_fine`, `np_expired_date`, `np_status`, `np_pay`, `np_receive_bank`, `np_receive_acc`, `np_receive_owner`, `np_transfer_bank`, `np_transfer_acc`, `np_transfer_owner`, `np_transfer_datetime`, `np_slip`, `np_created`) VALUES
('NP20211022-904', 'oshi', 'Prakorn Junthalungzevorakul', 'A11', 'ตุลาคม', '2564', '3400.00', '100.00', '1', 'สำเร็จ', 'ชำระออนไลน์', 'ไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', 'ธนาคารไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', '2021-10-23T02:37', 'NP20211022-904.jpg', '2021-10-22 16:39:57');

-- --------------------------------------------------------

--
-- Table structure for table `notice_payment_details`
--

CREATE TABLE `notice_payment_details` (
  `npd_id` int(11) NOT NULL COMMENT 'รหัสรายการ',
  `npd_np_id` varchar(255) NOT NULL COMMENT 'รหัสใบเสร็จ',
  `npd_name` varchar(255) NOT NULL COMMENT 'ชื่อรายการ',
  `npd_cost` decimal(10,2) NOT NULL COMMENT 'ราคา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notice_payment_details`
--

INSERT INTO `notice_payment_details` (`npd_id`, `npd_np_id`, `npd_name`, `npd_cost`) VALUES
(12, 'NP20211022-904', 'ค่าเช่าห้อง', '3000.00'),
(13, 'NP20211022-904', 'ค่าน้ำ', '100.00'),
(14, 'NP20211022-904', 'ค่าไฟ', '300.00');

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` varchar(255) NOT NULL COMMENT 'รหัส',
  `topic` varchar(255) NOT NULL COMMENT 'หัวข้อ',
  `description` text NOT NULL COMMENT 'รายละเอียด',
  `room_id` varchar(255) NOT NULL COMMENT 'เลขห้อง',
  `customer_username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งานลูกค้า',
  `img` text NOT NULL COMMENT 'ไฟล์ภาพ',
  `status` varchar(255) NOT NULL COMMENT 'สถานะ',
  `note` text NOT NULL COMMENT 'หมายเหตุ',
  `created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `repairs`
--

INSERT INTO `repairs` (`id`, `topic`, `description`, `room_id`, `customer_username`, `img`, `status`, `note`, `created`, `updated`) VALUES
('RP20211004-112', 'ไฟห้องน้ำไม่ติด', 'ไฟห้องน้ำไม่ติด', 'B7', 'oshi', 'RP20211004-112.jpg', 'รับเรื่องแล้ว', '', '2021-10-03 18:13:41', '2021-10-03 18:15:16');

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
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `daily_books`
--
ALTER TABLE `daily_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_room_id` (`daily_room_id`),
  ADD KEY `customer_username` (`customer_username`);

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
  ADD KEY `customer_username` (`customer_username`);

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
  ADD KEY `monthly_room_id` (`monthly_room_id`),
  ADD KEY `customer_username` (`customer_username`);

--
-- Indexes for table `monthly_rooms`
--
ALTER TABLE `monthly_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `notice_payments`
--
ALTER TABLE `notice_payments`
  ADD PRIMARY KEY (`np_id`),
  ADD KEY `np_customer_username` (`np_customer_username`);

--
-- Indexes for table `notice_payment_details`
--
ALTER TABLE `notice_payment_details`
  ADD PRIMARY KEY (`npd_id`),
  ADD KEY `npd_np_id` (`npd_np_id`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_username` (`customer_username`);

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
-- AUTO_INCREMENT for table `notice_payment_details`
--
ALTER TABLE `notice_payment_details`
  MODIFY `npd_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการ', AUTO_INCREMENT=15;

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
  ADD CONSTRAINT `daily_books_ibfk_3` FOREIGN KEY (`daily_room_id`) REFERENCES `daily_rooms` (`id`),
  ADD CONSTRAINT `daily_books_ibfk_4` FOREIGN KEY (`customer_username`) REFERENCES `customers` (`username`);

--
-- Constraints for table `daily_rooms`
--
ALTER TABLE `daily_rooms`
  ADD CONSTRAINT `daily_rooms_ibfk_1` FOREIGN KEY (`type`) REFERENCES `roomtypes` (`id`);

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_ibfk_1` FOREIGN KEY (`customer_username`) REFERENCES `customers` (`username`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `roomtypes` (`id`);

--
-- Constraints for table `monthly_books`
--
ALTER TABLE `monthly_books`
  ADD CONSTRAINT `monthly_books_ibfk_2` FOREIGN KEY (`monthly_room_id`) REFERENCES `monthly_rooms` (`id`),
  ADD CONSTRAINT `monthly_books_ibfk_3` FOREIGN KEY (`customer_username`) REFERENCES `customers` (`username`);

--
-- Constraints for table `monthly_rooms`
--
ALTER TABLE `monthly_rooms`
  ADD CONSTRAINT `monthly_rooms_ibfk_1` FOREIGN KEY (`type`) REFERENCES `roomtypes` (`id`);

--
-- Constraints for table `notice_payments`
--
ALTER TABLE `notice_payments`
  ADD CONSTRAINT `notice_payments_ibfk_1` FOREIGN KEY (`np_customer_username`) REFERENCES `customers` (`username`);

--
-- Constraints for table `notice_payment_details`
--
ALTER TABLE `notice_payment_details`
  ADD CONSTRAINT `notice_payment_details_ibfk_1` FOREIGN KEY (`npd_np_id`) REFERENCES `notice_payments` (`np_id`);

--
-- Constraints for table `repairs`
--
ALTER TABLE `repairs`
  ADD CONSTRAINT `repairs_ibfk_1` FOREIGN KEY (`customer_username`) REFERENCES `customers` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
