CREATE DATABASE IF NOT EXISTS `tourist_guide_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `tourist_guide_db`;

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `admin` (`name`, `email`, `password`) VALUES ('Administrator', 'admin@admin.com', 'admin123');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(20),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `users` (`name`, `email`, `password`, `mobile`) VALUES ('Demo User', 'user@demo.com', '$2y$10$YourHashedPasswordHere', '9876543210');

CREATE TABLE IF NOT EXISTS `destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `location` varchar(150) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text,
  `image_url` varchar(255),
  `tags` json,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `destinations` (`name`, `location`, `price`, `description`, `image_url`, `tags`) VALUES
('Goa', 'Goa, India', 18000, 'Sandy beaches, nightlife & seafood', 'assets/img4.jpeg', '["Beach","Relax"]'),
('Taj Mahal', 'Agra, India', 8500, 'Iconic Mughal monument', 'assets/img5.jpeg', '["Historical"]'),
('Manali', 'Himachal Pradesh', 15000, 'Himalayan adventure & skiing', 'assets/img6.jpeg', '["Mountains","Adventure"]'),
('Udaipur', 'Rajasthan', 12500, 'Palaces, lakes & royal heritage', 'assets/img7.jpeg', '["Heritage","Romantic"]'),
('Kerala Backwaters', 'Kerala', 22000, 'Houseboat cruises & spice tours', 'assets/img8.jpeg', '["Cruise","Nature"]'),
('Goa - North', 'Goa', 17000, 'Beaches & water sports', 'assets/img9.jpeg', '["Beach","Adventure"]'),
('Shimla', 'Himachal Pradesh, India', 14000, 'Hill station, snow & trekking', 'assets/img10.jpeg', '["Mountains","Adventure"]'),
('Jaipur', 'Rajasthan, India', 13000, 'Pink city, forts & culture', 'assets/img14.avif', '["Heritage","Culture"]'),
('Darjeeling', 'West Bengal, India', 15000, 'Tea gardens & mountain views', 'assets/img14.avif', '["Nature","Relax"]'),
('Mysore', 'Karnataka, India', 9000, 'Palaces & historical spots', 'assets/img14.avif', '["Heritage","Culture"]'),
('Andaman Islands', 'Andaman & Nicobar', 25000, 'Beaches, scuba diving & nature', 'assets/img14.avif', '["Beach","Adventure"]'),
('Coorg', 'Karnataka, India', 12000, 'Coffee plantations & trekking', 'assets/img14.avif', '["Nature","Adventure"]'),
('Leh-Ladakh', 'Jammu & Kashmir, India', 30000, 'High mountains & biking', 'assets/img14.avif', '["Mountains","Adventure"]'),
('Rishikesh', 'Uttarakhand, India', 10000, 'River rafting & yoga', 'assets/img14.avif', '["Adventure","Relax"]'),
('Varanasi', 'Uttar Pradesh, India', 8000, 'Spiritual city & culture', 'assets/img14.avif', '["Culture","Heritage"]');

CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `travelers` int(11) DEFAULT 1,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `destination_id` (`destination_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_wishlist` (`user_id`, `destination_id`),
  KEY `user_id` (`user_id`),
  KEY `destination_id` (`destination_id`),
  CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
