-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2026 at 12:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ihuriro_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(120) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` enum('Kg','g','L','ml','Piece','Box','Packet','Dozen','Meter','Roll','Bag') DEFAULT 'Piece',
  `discount` decimal(5,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `discount_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `product_name`, `unit_price`, `quantity`, `unit`, `discount`, `description`, `created_at`, `updated_at`, `discount_info`) VALUES
(1, 1, 'Umuceri Kigori', 1200.00, 100.00, 'Kg', 5.00, 'Umuceri mwiza cyane', '2026-07-01 06:15:28', '2026-07-01 06:15:28', NULL),
(3, 2, 'Umusingi (Kazo)', 700.00, 2.00, 'Dozen', 0.00, 'Hasigaye mike.', '2026-07-02 05:48:02', '2026-07-02 06:14:49', NULL),
(4, 2, 'Chamburaire (Hartex numero ya 1)', 2500.00, 4.00, 'Piece', 1.00, '', '2026-07-02 05:50:30', '2026-07-02 05:50:30', NULL),
(5, 2, 'Chamburaire (Hartex numero ya 2)', 2000.00, 4.00, 'Piece', 1.00, 'Ni izanyuma', '2026-07-02 05:54:25', '2026-07-02 05:54:25', NULL),
(6, 2, 'Umusingi (Magic)', 800.00, 1.00, 'Dozen', 5.00, 'Ntawundi uwufite', '2026-07-02 06:00:41', '2026-07-02 06:00:41', NULL),
(7, 2, 'Umusingi (Umukara)', 600.00, 3.00, 'Dozen', 2.00, 'Umusimari wo muri mwaye w\' umukara.', '2026-07-02 06:53:49', '2026-07-03 05:15:02', NULL),
(8, 3, 'Umuceri', 700.00, 350.00, 'Kg', 5.00, '', '2026-07-02 11:37:14', '2026-07-02 11:37:14', NULL),
(9, 3, 'Isukari', 1800.00, 120.00, 'Kg', 0.00, 'Isukari nyarwanda', '2026-07-02 11:37:58', '2026-07-02 11:37:58', NULL),
(10, 3, 'Ubuto', 2300.00, 90.00, '', 3.00, '', '2026-07-02 11:39:00', '2026-07-02 11:39:00', NULL),
(11, 4, 'Ibishyimbo', 950.00, 50.00, 'Kg', 0.00, '', '2026-07-02 11:41:28', '2026-07-02 11:41:28', NULL),
(12, 4, 'Akawunga', 850.00, 180.00, 'Kg', 0.00, '', '2026-07-02 11:42:08', '2026-07-02 11:42:08', NULL),
(13, 4, 'Ibirayi', 500.00, 400.00, 'Kg', 0.00, '', '2026-07-02 11:43:19', '2026-07-02 11:43:19', NULL),
(14, 5, 'Inyanya', 600.00, 220.00, 'Kg', 0.00, '', '2026-07-02 11:45:48', '2026-07-02 11:45:48', NULL),
(15, 5, 'Igitunguru', 700.00, 180.00, 'Kg', 0.00, '', '2026-07-02 11:46:31', '2026-07-02 11:46:31', NULL),
(16, 5, 'Karoti', 650.00, 170.00, 'Kg', 0.00, '', '2026-07-02 11:47:01', '2026-07-02 11:47:01', NULL),
(17, 6, 'Akandi', 1000.00, 600.00, 'Piece', 0.00, '', '2026-07-02 11:50:29', '2026-07-02 11:50:29', NULL),
(18, 6, 'Fanta', 800.00, 500.00, 'Piece', 0.00, 'Fanta Orange', '2026-07-02 11:50:55', '2026-07-02 17:47:33', NULL),
(19, 6, 'Jie/Juice/Umutobe', 1200.00, 250.00, 'Piece', 0.00, '', '2026-07-02 11:51:29', '2026-07-02 11:51:29', NULL),
(20, 7, 'Umuceri', 680.00, 500.00, 'Kg', 0.00, '', '2026-07-02 11:54:59', '2026-07-02 11:54:59', NULL),
(21, 7, 'Ibishyimbo', 930.00, 300.00, 'Kg', 0.00, '', '2026-07-02 11:55:23', '2026-07-02 11:55:23', NULL),
(22, 7, 'Amasaka', 720.00, 260.00, 'Kg', 0.00, '', '2026-07-02 11:55:53', '2026-07-02 11:55:53', NULL),
(23, 8, 'Ubugali', 750.00, 180.00, 'Kg', 5.00, 'ubugari/ifu y imyumbati', '2026-07-02 11:58:50', '2026-07-02 11:58:50', NULL),
(24, 8, 'Ibijumba', 450.00, 350.00, 'Kg', 0.00, '', '2026-07-02 11:59:15', '2026-07-02 11:59:15', NULL),
(25, 8, 'Ubunyobwa', 1800.00, 90.00, 'Kg', 0.00, '', '2026-07-02 11:59:41', '2026-07-02 11:59:41', NULL),
(26, 9, 'Amafi', 3500.00, 70.00, 'Kg', 0.00, 'Tomosoni', '2026-07-02 12:02:28', '2026-07-02 12:02:28', NULL),
(27, 9, 'Umunyu', 500.00, 220.00, 'Kg', 0.00, '', '2026-07-02 12:02:52', '2026-07-02 12:02:52', NULL),
(28, 9, 'Isabune', 900.00, 400.00, 'Piece', 0.00, '', '2026-07-02 12:03:21', '2026-07-02 12:03:21', NULL),
(29, 10, 'Insinga (Amashanyarazi)', 6500.00, 45.00, 'Piece', 0.00, 'Extension Cable', '2026-07-02 12:05:46', '2026-07-02 12:05:46', NULL),
(30, 10, 'LED Bulb', 2500.00, 120.00, 'Piece', 0.00, '', '2026-07-02 12:06:29', '2026-07-02 12:06:29', NULL),
(31, 10, 'Charger', 4000.00, 80.00, 'Piece', 0.00, 'imigozi yo gucomeka telephone(gatushe, smart, ...)', '2026-07-02 12:07:27', '2026-07-02 12:07:27', NULL),
(32, 2, 'Amata', 1000.00, 20.00, 'Kg', 0.00, 'inshyunshyu', '2026-07-02 17:34:08', '2026-07-03 06:25:20', NULL),
(33, 2, 'Inkweto', 16000.00, 10.00, 'Piece', 5.00, 'Inkweto ya nike, ibara ry umukara n umweru.', '2026-07-02 17:39:21', '2026-07-02 17:39:21', NULL),
(34, 6, 'Amavuta', 2000.00, 20.00, 'Packet', 0.00, 'amavuta yo kwisiga', '2026-07-02 17:48:37', '2026-07-02 17:48:37', NULL),
(36, 2, 'Jie/Juice', 450.00, 2.00, '', 0.00, '', '2026-07-03 06:24:52', '2026-07-03 06:24:52', NULL),
(37, 12, 'Umusingi (Kazo)', 300.00, 300.00, 'Kg', 0.00, '', '2026-07-03 07:25:35', '2026-07-03 07:25:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `district` varchar(100) NOT NULL,
  `sector` varchar(100) NOT NULL,
  `cell` varchar(100) NOT NULL,
  `address_description` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `phone`, `district`, `sector`, `cell`, `address_description`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Mugisha Store', 'mugisha', 'mugisha@gmail.com', '0783274800', 'Unknown', 'Unknown', 'Unknown', 'Huye', 'password_hash_here', '2026-07-01 06:15:12', '2026-07-01 06:40:02'),
(2, 'MMUGISHA Christian', 'Kwa MAMA Safi.', 'mugicyberchriss99@gmail.com', '0781234567', 'Gisagara', 'Kibirizi', 'Duwani', 'Duwani mu isantere aho bakorera amagare.', '$2y$10$44xr0yz5gXAqJdW2mt/CnO.ghEhVXRBNiboFwlnOeWARzgYTS92oK', '2026-07-01 12:08:16', '2026-07-01 18:28:19'),
(3, 'Jean Claude Niyonzima', 'Kigali Fresh Market', 'jean@gmail.com', '0788123456', 'Nyarugenge', 'Nyamirambo', 'Rugarama', 'Ku isoko rya Nyamirambo hafi ya gare.', '$2y$10$..NpW6WWLGnZekL2PwXqHunvrrbAQuODUi/e93alomeYyYg.UFmP6', '2026-07-02 11:34:34', '2026-07-02 11:34:34'),
(4, 'Diane Uwimana', 'Huye Foods', 'diane@gmail.com', '0788234567', 'Huye', 'Ngoma', 'Butare', 'Hafi ya gare ya Huye', '$2y$10$HtOX84ZwH.WcJd38kJnKx..OLvuXZZLtzvYI6wMfzxfPaFJFwPRVG', '2026-07-02 11:40:23', '2026-07-02 11:40:23'),
(5, 'Patrick Mugabo', 'Musanze Wholesale', 'patrick@gmail.com', '0788345678', 'Musanze', 'Muhoza', 'Cyabararika', 'Hafi ya Musanze Market', '$2y$10$ZIPvT1Aw494yndo8M27Nn.sqeevAoLmAfdBPWPwUhIR.yK9ce.g5a', '2026-07-02 11:44:40', '2026-07-02 11:44:40'),
(6, 'Alice Mukamana', 'Rubavu Super Store', 'alice@gmail.com', '0788456789', 'Rubavu', 'Gisenyi', 'Bugoyi', 'Hafi ya petite Barriere', '$2y$10$ZB0f5icHR8Y8fQWtcM60ZOyR5gGgi3pfPvLRSMm.amqGo5TCQGnDq', '2026-07-02 11:49:42', '2026-07-02 11:49:42'),
(7, 'Eric Habimana', 'East Grain Center', 'eric@gmail.com', '0788567890', 'Rwamagana', 'Kigabiro', 'Bwiza', 'Hafi ya Gare ya Rwamagana', '$2y$10$wXFF4.IipVCjPE4TYoESPukeYDNfVOmybiO5CknV1lRdJO3hmafwa', '2026-07-02 11:54:07', '2026-07-02 11:54:07'),
(8, 'Samuel Ndayisaba', 'Muhanga Agro Shop', 'samuel@gmail.com', '0788678901', 'Muhanga', 'Nyamabuye', 'Gahogo', 'Hafi ya Gare ya Muhanga', '$2y$10$RCkxTsor6.y4t9xpUHKc3.F9jolIJIrwvnb3NhZ8VzyLsABQeN6Ve', '2026-07-02 11:57:01', '2026-07-02 11:57:01'),
(9, 'Claudine Ingabire', 'Karongi Traders', 'claudine@gmail.com', '0788789012', 'Karongi', 'Rubengera', 'Kibirizi', 'Hafi y\'isoko rya Rubengera', '$2y$10$ODR4Eoy8R7wqIikwblY4FOFUoAJ8koMh5wuSmixJUWOuP6OvIgjlK', '2026-07-02 12:01:02', '2026-07-02 12:01:02'),
(10, 'Emmanuel Nsengimana', 'Kigali Electronics', 'emmanuel@gmail.com', '0788890123', 'Gasabo', 'Kimironko', 'Bibare', 'Kimironko Market', '$2y$10$Xafh3CoRz.T4mPcfk7HZmujYeP3xEAnm43lgDyCzKVdvZ7RqfwB96', '2026-07-02 12:04:24', '2026-07-02 12:04:24'),
(11, 'Bertin NIYIBIGENA', 'Bertin Store', 'bertin@gmail.com', '0788112233', 'Gasabo', 'Kinyinya', 'Kagugu', 'Hirwa gato y\' amshuri ya GS Kagugu.', '$2y$10$zoDHcIh3vEROk1PCqT/NreRjOSKiKpipJVPW1WqD5Myzt6QiHCnfa', '2026-07-02 19:07:20', '2026-07-02 19:07:20'),
(12, 'Test User', 'Test Shop', 'test@gmail.com', '0789000000', 'Gasabo', 'Remera', 'Rukiri', 'Near Remera Market', '$2y$10$POpCGF6UTxPQJPw9u0VtEOKqb4uFNqR6yoQUAb5LC6j8Vv5lHoSZG', '2026-07-03 05:32:47', '2026-07-03 05:42:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_name` (`product_name`),
  ADD KEY `idx_product_price` (`unit_price`),
  ADD KEY `idx_product_updated` (`updated_at`),
  ADD KEY `idx_user_product` (`user_id`,`product_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
