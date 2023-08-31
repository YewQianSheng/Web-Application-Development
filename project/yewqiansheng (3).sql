-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2023-08-31 03:00:11
-- 服务器版本： 8.0.31
-- PHP 版本： 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `yewqiansheng`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `category_name`, `description`) VALUES
(1, 'coffee', 'powder, 3in1'),
(2, 'dish washer', 'do the washing up.'),
(3, 'Snacks ', 'Snacks for adults and children'),
(4, 'bodywash', 'antibacterial bodywash'),
(5, 'Rice', 'Rice is a staple food and one of the most widely consumed grains in the world.'),
(6, 'biscuit', 'hunger food'),
(7, 'noodle', 'instant noodles'),
(8, 'ice cream ', 'relieve heat'),
(9, 'toothpaste', 'Daily Toiletries'),
(10, 'ball', 'game '),
(11, 'Tissue', 'delicate paper product that is often used for various purposes due to its softness, absorbency, and thin nature.'),
(12, 'seasoning', 'for cooking');

-- --------------------------------------------------------

--
-- 表的结构 `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gender` enum('Male','Female','Other','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `birth` date NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('Active','Inactive','Other','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Active',
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `birth`, `registration_date`, `status`, `email`, `image`) VALUES
(1, 'patrickyew', '$2y$10$VH2KCVqptUY90vFc86hHL.8WMC2xjtIEzGGdGTAmbpy5nJI5g/bqW', 'patrick', 'yew', 'Male', '2023-08-16', '2023-08-28 05:58:29', 'Active', 'patrick@gmail.com', 'uploads/e08ecfac390ead3fa78c2a32df852da1f54f2fd8-black (1).jpg'),
(2, 'chrisyew', '$2y$10$ixpwtPo/dwoQCD4UsSsgFO.G2xhlVLzVL8XYk0VfX3ZxhYdsLTIDe', 'chris', 'yew', 'Male', '2023-01-29', '2023-08-28 05:58:24', 'Active', 'chris@gmail.com', 'uploads/d50bfebc45bb3ca1aaedabf4620fa06d40d448ae-chris.jpeg'),
(3, 'crystaltan', '$2y$10$OGTJtD4tV4oTqv8E/..kW.HtwgxX9T6fM8mk23.ERpV/hN9IwtNqW', 'crystal', 'tan', 'Female', '2023-08-16', '2023-08-28 05:58:20', 'Active', 'crystal@gmail.com', 'uploads/7c9e6d6c1389b7f6f41cbb3ac09e2b3f4cb0a7f8-girl.jpg'),
(4, 'angellim', '$2y$10$X15UADtm2Zy051Yxbb..EewMI2PFb1P8EsR6bgi6DaIrBDkyis7Ii', 'angel', 'lim', 'Female', '2023-07-31', '2023-08-30 17:18:28', 'Active', 'angel@gmail.com', ''),
(5, 'Francischow', '$2y$10$u4IJdtv9oUqeyqu/CvOe8u5lhPxUQoTKcO8QGXrDdcoEcO03txNTO', 'francis', 'chow', 'Male', '2023-08-28', '2023-08-30 10:52:22', 'Active', 'francis@gmail.com', 'uploads/25c8410cc0f87fc734e8e2fe39578a233264e38d-bm.jpg'),
(6, 'lindacheong', '$2y$10$tAFEgGXsyPRFp4JKMgA5xuDXDsqc3PUKOkvBd5P8LCGm2qKihrCjS', 'lindas', 'cheong', 'Female', '2023-01-03', '2023-08-30 17:18:31', 'Active', 'linda@gmail.com', ''),
(7, 'ali123', '$2y$10$hNb5IRyMftlrmYm4mqRQC.vm/lIVU19Eeu0uXnsgzeq3GPcTCRdzu', 'ali', 'tan', 'Male', '2023-08-15', '2023-08-30 17:18:18', 'Active', 'ali@gmail.com', ''),
(8, 'zeejia', '$2y$10$YKlQYEBMpbeQ82EwO0RuTeBVSnK1HlhuYZ17wUM/Apc.Ni3lWPTpa', 'zee', 'jia', 'Male', '2023-08-15', '2023-08-30 17:18:32', 'Active', 'zj@gmail.com', ''),
(9, 'alexyew', '$2y$10$UwmJvIuipU.A7zQnNEiBuu97176hCrIqFNlI8tN5bMoY0n.pm6vsW', 'alex', 'yew', 'Female', '2023-08-23', '2023-08-30 17:18:34', 'Inactive', 'alex@gmail.com', ''),
(10, 'jacky', '$2y$10$UDDzxNhZo2jy/RaeWZrHaecl9qUTreqvly/bIOdxKE1dWnJqaOufy', 'jacky', 'chow', 'Male', '2023-08-22', '2023-08-30 13:37:42', 'Active', 'chow@gmail.com', 'uploads/2e2e61da74788060d511898bc3015916e206280b-face.jpeg'),
(11, 'kevin', '$2y$10$VabyUnghqdgePpd/JW9wCORRtdiZKI0EOPeFBgBQ.tK.1NrUD2o0u', 'kevin', 'lim', 'Male', '2023-08-08', '2023-08-31 01:49:20', 'Active', 'kevin@gmail.com', 'uploads/e83d827b6000aa0fbd3c5d72463b3e7d15c2a626-hwm.jpg'),
(26, 'Halipoter', '$2y$10$AxmGvOcTQQDovrDew0s7quDS2yK2Mc5.FkaHJzhmRg2e/yqOf2ks2', 'hali', 'poter', 'Male', '2023-08-22', '2023-08-31 02:15:25', 'Active', 'halipoter@gmail.com', 'uploads/bc123c4fdefb504985d54ee04f0ceec2b0b343a4-sb.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `order_details_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`order_details_id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 2),
(18, 2, 3, 5),
(16, 3, 17, 7),
(48, 5, 29, 3),
(47, 4, 1, 10),
(46, 4, 6, 10000),
(15, 3, 2, 4),
(17, 3, 16, 7),
(19, 2, 17, 7),
(45, 4, 11, 10000000),
(44, 4, 14, 10000000),
(49, 5, 16, 5);

-- --------------------------------------------------------

--
-- 表的结构 `order_summary`
--

DROP TABLE IF EXISTS `order_summary`;
CREATE TABLE IF NOT EXISTS `order_summary` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` double DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_summary`
--

INSERT INTO `order_summary` (`order_id`, `customer_id`, `order_date`, `total_amount`) VALUES
(1, 1, '2023-08-28 02:11:46', 22),
(2, 2, '2023-08-28 11:52:39', 15),
(3, 1, '2023-08-28 14:39:08', 60),
(4, 1, '2023-08-31 02:16:20', 220030110),
(5, 8, '2023-08-31 10:28:59', 68);

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `promotion_price` double NOT NULL,
  `manufacture_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `category_name` varchar(25) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`, `modified`, `promotion_price`, `manufacture_date`, `expired_date`, `category_name`, `image`) VALUES
(1, 'Super coffee', 'net weight: 420G\r\nStrawberry &amp; Banana bits, Blueberry &amp; Apple bits', 12, '2023-08-28 01:16:22', '2023-08-28 06:09:08', 11, '2023-02-26', '2024-02-26', 'coffee', 'uploads/87f81b6d166107a41dcf24565d4f9bfe2ce951d4-super.jpeg'),
(2, 'Sunlight', '4X900 ml, Lime dishwash ', 15, '2023-08-28 01:23:52', '2023-08-28 06:09:04', 0, '2023-08-13', '2024-08-13', 'dish washer', 'uploads/96fca6418f8a9f9a78bb13396da4ef93024338b6-sunlight.jpeg'),
(3, 'Twisties', '24x13G, Twisties Cheddar Cheese', 5, '2023-08-28 01:27:12', '2023-08-28 06:09:02', 3, '2022-01-01', '2024-01-01', 'Snacks ', 'uploads/250c8204825069f81546ca61c6a7b5844e2a867b-snack.jpeg'),
(4, 'Lifebuoy', '950ml, fight 99.9% germs', 20, '2023-08-28 01:30:30', '2023-08-28 06:08:59', 18, '2022-02-22', '2025-02-22', 'bodywash', 'uploads/12e5ea6cfbb711f3268803b317e16c20b951e187-shower.jpeg'),
(5, 'JasmineSuper', '10KG, import for Thailand', 30, '2023-08-28 01:35:40', '2023-08-28 06:08:56', 28, '2021-05-23', '2024-05-23', 'coffee', 'uploads/05374f281401a07a0c10093422d9061d707c296c-rice.jpeg'),
(6, 'Oreo', '119.6G X 3, chocolate ', 3, '2023-08-28 01:40:12', '2023-08-28 06:08:40', 0, '2022-03-12', '2024-03-12', 'biscuit', 'uploads/b7fda237c8d830588ea06553b3041e609679be23-oreo.jpeg'),
(7, 'Jacods', '229g baked crisps original ', 7, '2023-08-28 01:42:03', '2023-08-28 06:08:36', 0, '2023-04-04', '2024-04-03', 'biscuit', 'uploads/6b3b76e5f7025a1ce3ccd98cbafa82e191d9ecd5-jacod.jpeg'),
(8, 'Oldtown ', 'Net Weight 240G 20x12g ,600G 20x30g', 11, '2023-08-28 01:44:36', '2023-08-28 06:08:33', 0, '2023-08-07', '2024-08-07', 'coffee', 'uploads/54d0714613bd244eb96f65b2a7899e5d30ba825d-coffe.jpeg'),
(9, 'Maggi', '5s X 79g, curry', 6, '2023-08-28 01:48:36', '2023-08-28 06:08:30', 5, '2023-07-30', '2024-07-30', 'noodle', 'uploads/bde6536ce0e3c585746ee794c38461f7c83ef40c-Maggi.jpeg'),
(10, 'WALLs', 'creamy vanilla ', 3, '2023-08-28 01:50:46', '2023-08-28 06:28:18', 0, '2023-08-06', '2023-10-06', 'ice cream ', 'uploads/472570230ff9ede3ef8ab2d78033d4da9a58b6dc-ice_cream.jpeg'),
(11, 'darlie', '225g X2, + 75g X1, fresh and clean', 7, '2023-08-28 01:56:10', '2023-08-28 06:44:04', 0, '2023-08-13', '2024-09-13', 'toothpaste', 'uploads/166eeaed4ea5eb0a479c4266d258134bbfb54f11-darlie.jpg'),
(14, 'FreshWhite', '75gx2', 15, '2023-08-30 21:09:44', '2023-08-30 13:30:58', 0, '2023-08-06', '2024-08-30', 'toothpaste', 'uploads/c81427c24146eedd31ecc60c6808b92bd659f2fc-fw.jpeg'),
(15, 'Premier Tissue', '200pulls x4 ', 16, '2023-08-30 21:14:21', '2023-08-31 02:57:25', 0, '2023-08-01', '2025-12-30', 'Tissue', 'uploads/41a2376350f21e265eeb143eac019c6cb139dc94-tissue.jpeg'),
(16, 'KCA Bathroom Tissue', 'bathroom tissue roll', 15, '2023-08-30 21:20:11', '2023-08-30 13:20:11', 10, '2023-07-30', '2026-12-29', 'Tissue', 'uploads/84f8d75d5e0e3e39a006ff27b8da0300783ee940-kca.jpeg'),
(17, 'Nescafe', 'Premix Coffee Original 25s x18g', 13, '2023-08-30 21:34:08', '2023-08-30 13:34:08', 11, '2023-07-30', '2024-10-30', 'coffee', 'uploads/1f99fdabe603b40b43b868a326ed55b3792ca381-nc.jpeg'),
(18, 'Magnolia Vanilla', '1.5L, 2 tubs', 18, '2023-08-30 21:47:12', '2023-08-30 18:16:57', 0, '2023-08-02', '2024-10-30', 'ice cream ', 'uploads/ea289571e5eb1c5ca22e811a30c10c696b72597a-ic.jpeg'),
(29, 'Vit Plain Noodles', '(Halus/Kasar/Panmee) 650/700gm', 6, '2023-08-31 10:19:38', '2023-08-31 02:19:38', 0, '2023-01-01', '2024-11-30', 'noodle', 'uploads/762b132beee9979c3e5b976d07e75a336cb13ef8-vit.jpeg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
