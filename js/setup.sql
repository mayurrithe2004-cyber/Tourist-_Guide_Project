CREATE DATABASE IF NOT EXISTS tourist_guide;
USE tourist_guide;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  mobile VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS destinations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  location VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  description TEXT,
  tags VARCHAR(255),
  image VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  destination_id INT NOT NULL,
  booking_date DATE NOT NULL,
  travel_date DATE NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  qty INT DEFAULT 1,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (destination_id) REFERENCES destinations(id)
);

CREATE TABLE IF NOT EXISTS wishlist (
  user_id INT NOT NULL,
  destination_id INT NOT NULL,
  PRIMARY KEY (user_id, destination_id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (destination_id) REFERENCES destinations(id)
);

-- Seed Data
INSERT INTO admins (name, email, password) VALUES 
('Administrator', 'admin@admin.com', 'admin123');

INSERT INTO destinations (name, location, price, description, tags, image) VALUES
('Goa', 'Goa, India', 18000, 'Sandy beaches, nightlife & seafood', 'Beach,Relax', 'assets/img4.jpeg'),
('Taj Mahal', 'Agra, India', 8500, 'Iconic Mughal monument', 'Historical', 'assets/img5.jpeg'),
('Manali', 'Himachal Pradesh', 15000, 'Himalayan adventure & skiing', 'Mountains,Adventure', 'assets/img6.jpeg'),
('Udaipur', 'Rajasthan', 12500, 'Palaces, lakes & royal heritage', 'Heritage,Romantic', 'assets/img7.jpeg'),
('Kerala Backwaters', 'Kerala', 22000, 'Houseboat cruises & spice tours', 'Cruise,Nature', 'assets/img8.jpeg');