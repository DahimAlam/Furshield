-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2025 at 01:05 AM
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
-- Database: `furshield`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_requests`
--

CREATE TABLE `adoption_requests` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `adopter_user_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') DEFAULT 'pending',
  `message` text DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `appointment_time` datetime NOT NULL,
  `status` enum('pending','approved','completed','cancelled') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(180) NOT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `category` varchar(80) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `category`, `image`, `content`, `is_active`, `created_at`) VALUES
(1, '5 Tips for a Healthy Dog', 'healthy-dog-tips', 'Care', 'uploads/blogs/dogtips.jpg', 'From balanced diet to exercise, here are 5 simple tips to keep your dog healthy.', 1, '2025-09-09 19:38:17'),
(2, 'How to Prepare for Adopting a Cat', 'adopting-a-cat', 'Adoption', 'uploads/blogs/cattips.jpg', 'Adopting a cat is a big responsibility. Here’s what you need to prepare.', 1, '2025-09-09 19:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `logo`, `link`, `is_active`, `created_at`) VALUES
(1, 'uploads/brands/pedigree.png', 'https://www.pedigree.com', 1, '2025-09-09 19:38:17'),
(2, 'uploads/brands/whiskas.png', 'https://www.whiskas.com', 1, '2025-09-09 19:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(160) NOT NULL,
  `date` date NOT NULL,
  `city` varchar(80) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `date`, `city`, `image`, `link`, `is_active`, `created_at`) VALUES
(1, 'Free Vaccination Camp', '2025-09-20', 'Karachi', 'uploads/events/vaccine.jpg', 'https://furshield.com/events/vaccine-camp', 1, '2025-09-09 19:38:17'),
(2, 'Pet Adoption Fair', '2025-10-05', 'Lahore', 'uploads/events/adoptionfair.jpg', 'https://furshield.com/events/adoption-fair', 1, '2025-09-09 19:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(220) NOT NULL,
  `answer` text NOT NULL,
  `is_top` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_top`, `is_active`, `created_at`) VALUES
(1, 'How do I register as a vet?', 'Go to Register Vet page, fill details, wait for admin approval.', 1, 1, '2025-09-09 19:38:17'),
(2, 'Is online payment available?', 'Currently no, payments are simulated only.', 0, 1, '2025-09-09 19:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homepage_settings`
--

CREATE TABLE `homepage_settings` (
  `id` tinyint(4) NOT NULL DEFAULT 1,
  `hero_title` varchar(160) DEFAULT NULL,
  `hero_subtitle` varchar(220) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `cta_primary_text` varchar(60) DEFAULT NULL,
  `cta_primary_url` varchar(255) DEFAULT NULL,
  `cta_secondary_text` varchar(60) DEFAULT NULL,
  `cta_secondary_url` varchar(255) DEFAULT NULL,
  `show_adoption` tinyint(1) NOT NULL DEFAULT 1,
  `adoption_mode` enum('featured','latest') NOT NULL DEFAULT 'latest',
  `show_products` tinyint(1) NOT NULL DEFAULT 1,
  `products_mode` enum('featured','latest') NOT NULL DEFAULT 'latest',
  `show_testimonials` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_settings`
--

INSERT INTO `homepage_settings` (`id`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_primary_text`, `cta_primary_url`, `cta_secondary_text`, `cta_secondary_url`, `show_adoption`, `adoption_mode`, `show_products`, `products_mode`, `show_testimonials`, `updated_at`) VALUES
(1, 'Your pet’s health, organized & care made simple.', 'Owners, Vets & Shelters: appointments, records, adoption, and curated products.', NULL, NULL, NULL, NULL, NULL, 1, 'latest', 1, 'latest', 1, '2025-09-09 19:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `title` varchar(160) NOT NULL,
  `body` text DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('placed','packed','shipped','delivered','cancelled','refunded') DEFAULT 'placed',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) GENERATED ALWAYS AS (`subtotal` + `shipping` - `discount`) STORED,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `line_total` decimal(10,2) GENERATED ALWAYS AS (`qty` * `unit_price`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `adopt_interest` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`user_id`, `full_name`, `email`, `phone`, `address`, `city`, `country`, `adopt_interest`, `created_at`, `updated_at`) VALUES
(11, NULL, NULL, NULL, NULL, 'karachi', 'Pakistan', 1, '2025-09-10 16:03:31', NULL),
(12, NULL, NULL, NULL, NULL, 'Multan', 'Pakistan', 1, '2025-09-10 16:16:38', NULL),
(13, 'Ayesha Khan', 'ayesha123@gmail.com', '304 8204749235325', NULL, 'Delhi', 'India', 1, '2025-09-10 16:20:39', NULL),
(14, 'Farroq', 'frq123@gmail.com', '0481242376253257', NULL, 'Karachi', 'Pakistan', 0, '2025-09-10 16:25:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `species` varchar(40) DEFAULT NULL,
  `breed` varchar(80) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Unknown') DEFAULT 'Unknown',
  `avatar` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `urgent_until` datetime DEFAULT NULL,
  `spotlight` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('available','adopted','pending') DEFAULT 'available',
  `city` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_allergies`
--

CREATE TABLE `pet_allergies` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `allergen` varchar(120) NOT NULL,
  `severity` enum('low','medium','high') DEFAULT 'low',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_files`
--

CREATE TABLE `pet_files` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `file_type` enum('report','certificate','xray','prescription','other') DEFAULT 'other',
  `file_path` varchar(255) NOT NULL,
  `title` varchar(160) DEFAULT NULL,
  `issued_by` varchar(160) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_vaccinations`
--

CREATE TABLE `pet_vaccinations` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vaccine_name` varchar(120) NOT NULL,
  `due_date` date DEFAULT NULL,
  `given_date` date DEFAULT NULL,
  `vet_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_qty` int(11) DEFAULT 0,
  `image` varchar(120) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock_qty`, `image`, `image_alt`, `description`, `featured`) VALUES
(1, 'Premium Dog Food', 2500.00, 20, 'uploads/products/dogfood.jpg', NULL, 'High-protein chicken formula for active dogs.', 1),
(2, 'Cat Scratching Post', 1800.00, 15, 'uploads/products/scratchpost.jpg', NULL, 'Durable sisal rope scratching post for indoor cats.', 1),
(3, 'Bird Cage Deluxe', 5500.00, 5, 'uploads/products/birdcage.jpg', NULL, 'Spacious cage suitable for parrots & cockatiels.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shelters`
--

CREATE TABLE `shelters` (
  `user_id` int(11) NOT NULL,
  `shelter_name` varchar(150) DEFAULT NULL,
  `reg_no` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `logo_image` varchar(255) DEFAULT NULL,
  `reg_doc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shelters`
--

INSERT INTO `shelters` (`user_id`, `shelter_name`, `reg_no`, `capacity`, `address`, `city`, `country`, `logo_image`, `reg_doc`) VALUES
(20, 'Pets Health', '56385559444475594', 100, 'South Delhi', 'Delhi', 'India', 'uploads/shelters/logo_20.jpg', 'uploads/shelters/doc_20.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `title` varchar(160) NOT NULL,
  `summary` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `role` enum('owner','vet','shelter') NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `message` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `avatar`, `rating`, `message`, `is_active`, `created_at`) VALUES
(1, 'Ayesha', 'owner', 'uploads/avatars/user1.jpg', 5, 'FurShield made managing Buddy’s vaccinations so easy!', 1, '2025-09-09 19:38:17'),
(2, 'Dr. Imran', 'vet', 'uploads/avatars/vet1.jpg', 4, 'The system helps me track appointments & history quickly.', 1, '2025-09-09 19:38:17'),
(3, 'Happy Paws Shelter', 'shelter', 'uploads/avatars/shelter1.jpg', 5, 'Adoption requests are streamlined, less paperwork!', 1, '2025-09-09 19:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('owner','vet','shelter','admin') NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `pass_hash` varchar(255) NOT NULL,
  `status` enum('pending','active','inactive') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `phone`, `pass_hash`, `status`, `created_at`, `approved_at`) VALUES
(1, 'owner', 'Dahim ALam', 'dahimalam00@gmail.com', NULL, '$2y$10$KmzCYO9THzyofFwKw2wfaOTyqJI4HNcNv651GTCkFqvoB/v1sIX0q', 'pending', '2025-09-10 15:59:31', NULL),
(2, 'vet', 'Owais', 'owais123@gmail.com', NULL, '$2y$10$wdE4.BYEM0d0XMHHkhcMMusuw87G5PUaFXWm1sZSPk140yPLZwNIC', 'pending', '2025-09-10 15:59:31', NULL),
(3, 'shelter', 'Eidhi Center', 'eidhi@gmail.com', NULL, '$2y$10$8dd5M4i53W8sw/lFuSWrxO.bEX8RrKgiNu2gbw/sH9DIzCn1NHgni', 'pending', '2025-09-10 15:59:31', NULL),
(4, 'vet', 'Aliza Aleem', 'aliza234@gmail.com', NULL, '$2y$10$ZtAXr0Onp7.qC.wv1JYQle4StBAHSWMCSrAlsD78gfhgiYFvE2xUG', 'pending', '2025-09-10 15:59:31', NULL),
(5, 'vet', 'samia', 'sm123@gmail.com', NULL, '$2y$10$0SzNx3s0oQG9Dw/MKWPiredmFEwFidXvaJr3ZKfvPhgSS4x/6S/q6', 'pending', '2025-09-10 15:59:31', NULL),
(8, 'admin', 'Admin', 'admin@furshield.com', NULL, '$2y$10$dR14ppztN1x9tkzerOtOwuJd67UEQnDp4ThWwiVWdFmlNPcdHC4XO', 'pending', '2025-09-10 15:59:31', NULL),
(10, 'vet', 'Dr.Alam', 'dahim.alam145@gmail.com', NULL, '$2y$10$HyX.vGG.ZesYAR0npxDsFeoDcJLzEAWznz2EHcivoWdJ5ODn8kR1y', 'pending', '2025-09-10 15:59:31', NULL),
(11, 'owner', 'Fahad', 'fahad123@gmail.com', '03002472924', '$2y$10$eFLD5nS6HK7o6lA54eBswuXa2VMpAE8scl.cnu7B749.daONl5f96', 'active', '2025-09-10 15:59:49', NULL),
(12, 'owner', 'Ayesha Khan', 'ayesha@gmail.com', '30157924792', '$2y$10$hfI.nN3OJBFVarQAp8xat.0PLlFr5zvrDmaKXo0xh5lBSbVBAtygW', 'active', '2025-09-10 16:16:38', NULL),
(13, 'owner', 'Ayesha Khan', 'ayesha123@gmail.com', '304 8204749235325', '$2y$10$ESwyPnPwXzqThhF.qMQ0buCD8AFFjrNyA1.CcOhRrk6TMd8pD2BUe', 'active', '2025-09-10 16:20:39', NULL),
(14, 'owner', 'Farroq', 'frq123@gmail.com', '0481242376253257', '$2y$10$nDHmGkbaLrZ34BfhHafPtu2XeeO7g4s0W1X9c9Df35h/sBdMityUi', 'active', '2025-09-10 16:25:26', NULL),
(15, 'vet', 'Dr.Game', 'dr.game@gmail.com', '482048403', '$2y$10$bHyPK9RhWDVLvc1gGTSN5.qGCugvPgUOMfhfrseV3d7QzfNfWh.RC', 'pending', '2025-09-10 16:32:58', NULL),
(16, 'vet', 'Talha', 't123@gmail.com', '301474942795', '$2y$10$tA6.NL4TOFi3emqeOG3NJuI40Pnv3PRFcW0PCLhjIdmpKU2Z9uV62', 'pending', '2025-09-10 16:38:03', NULL),
(17, 'vet', 'Talha', 't234@gmail.com', '301474942795', '$2y$10$jiEIw1O.RU6Kit6mNVVJkO9lA5q/in.Teq6t.0PhcGRyzki7wrOKO', 'active', '2025-09-10 16:39:20', '2025-09-10 16:45:34'),
(18, 'vet', 'Kamran', 'kamran@gmail.com', '03017449373', '$2y$10$s1VmydAXJrHM7s5e1OY8CuHKhWtciPdHJtWyYqjxpcEexh2eVuYB.', 'active', '2025-09-10 16:47:26', '2025-09-10 16:47:56'),
(19, 'vet', 'Dr.Gulam', 'gulam123@gmail.com', '3457862345', '$2y$10$zQ5Y6jX.XnE/682ir/E7BeEDZ4cOZ3ZpJAlGNUop5SoFZz3zr5e76', 'active', '2025-09-10 17:56:21', '2025-09-10 18:06:36'),
(20, 'shelter', 'Iyer', 'pets123@gmail.com', '3849574947', '$2y$10$WVP2qrueYIsIhiAmr1w/LOTct22PRMrJyi3zAjWg6N6.QiyL9IRlS', 'active', '2025-09-10 17:59:59', '2025-09-10 18:03:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_prefs`
--

CREATE TABLE `user_prefs` (
  `user_id` int(11) NOT NULL,
  `email_notif` tinyint(1) NOT NULL DEFAULT 1,
  `sms_notif` tinyint(1) NOT NULL DEFAULT 0,
  `adoption_visibility_city` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vets`
--

CREATE TABLE `vets` (
  `user_id` int(11) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `license_no` varchar(100) DEFAULT NULL,
  `cnic_image` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `slots_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`slots_json`)),
  `clinic_address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vets`
--

INSERT INTO `vets` (`user_id`, `specialization`, `experience_years`, `license_no`, `cnic_image`, `profile_image`, `slots_json`, `clinic_address`, `city`, `country`) VALUES
(17, 'Surgery', 7, NULL, 'uploads/vets/cnic_17.jpg', 'uploads/vets/profile_17.jpg', NULL, 'golmarket', 'Karachi', 'Pakistan'),
(18, 'Surgery', 8, NULL, 'uploads/vets/cnic_18.jpg', 'uploads/vets/profile_18.jpg', NULL, 'golmarket', 'Los Angeles', 'United States'),
(19, 'Vaccine', 8, NULL, 'uploads/vets/cnic_19.jpg', 'uploads/vets/profile_19.jpg', NULL, 'no clinic', 'Los Angeles', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `vet_reviews`
--

CREATE TABLE `vet_reviews` (
  `id` int(11) NOT NULL,
  `owner_user_id` int(11) NOT NULL,
  `vet_user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 3, '2025-09-10 11:09:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `adopter_user_id` (`adopter_user_id`),
  ADD KEY `reviewed_by` (`reviewed_by`),
  ADD KEY `idx_adopt_status` (`status`,`pet_id`,`adopter_user_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_appt_pet` (`pet_id`),
  ADD KEY `fk_appt_owner` (`owner_id`),
  ADD KEY `fk_appt_vet` (`vet_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_blogs_active` (`is_active`,`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_events_date` (`date`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_faqs_active` (`is_active`,`is_top`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_settings`
--
ALTER TABLE `homepage_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_user` (`user_id`,`read_at`,`created_at`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_user` (`user_id`,`status`,`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pets_owner` (`user_id`),
  ADD KEY `idx_pets_filters` (`status`,`species`,`city`);

--
-- Indexes for table `pet_allergies`
--
ALTER TABLE `pet_allergies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `pet_files`
--
ALTER TABLE `pet_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `pet_vaccinations`
--
ALTER TABLE `pet_vaccinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `vet_id` (`vet_id`),
  ADD KEY `idx_vacc_due` (`due_date`,`given_date`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shelters`
--
ALTER TABLE `shelters`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stories_pet` (`pet_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_testi_active` (`is_active`,`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_role` (`role`);

--
-- Indexes for table `user_prefs`
--
ALTER TABLE `user_prefs`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vets`
--
ALTER TABLE `vets`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vet_reviews`
--
ALTER TABLE `vet_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_user_id` (`owner_user_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `idx_vet_reviews` (`vet_user_id`,`rating`,`created_at`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pet_allergies`
--
ALTER TABLE `pet_allergies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_files`
--
ALTER TABLE `pet_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_vaccinations`
--
ALTER TABLE `pet_vaccinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vet_reviews`
--
ALTER TABLE `vet_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD CONSTRAINT `adoption_requests_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adoption_requests_ibfk_2` FOREIGN KEY (`adopter_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adoption_requests_ibfk_3` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appt_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appt_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appt_vet` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `owners`
--
ALTER TABLE `owners`
  ADD CONSTRAINT `owners_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `fk_pets_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_allergies`
--
ALTER TABLE `pet_allergies`
  ADD CONSTRAINT `pet_allergies_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_files`
--
ALTER TABLE `pet_files`
  ADD CONSTRAINT `pet_files_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_vaccinations`
--
ALTER TABLE `pet_vaccinations`
  ADD CONSTRAINT `pet_vaccinations_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pet_vaccinations_ibfk_2` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `shelters`
--
ALTER TABLE `shelters`
  ADD CONSTRAINT `shelters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `fk_stories_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_prefs`
--
ALTER TABLE `user_prefs`
  ADD CONSTRAINT `user_prefs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vets`
--
ALTER TABLE `vets`
  ADD CONSTRAINT `vets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vet_reviews`
--
ALTER TABLE `vet_reviews`
  ADD CONSTRAINT `vet_reviews_ibfk_1` FOREIGN KEY (`owner_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vet_reviews_ibfk_2` FOREIGN KEY (`vet_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vet_reviews_ibfk_3` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
