-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 25 sep 2023 om 11:23
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `corbijns_webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `filenameimage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `filenameimage`) VALUES
(2, 'Smartphone', 'Introducing our premium smartphone, a perfect fusion of style and technology. With its large high-quality display and advanced camera features, it redefines mobile excellence. From stunning photography to seamless multitasking, this smartphone excels in every aspect. Its sleek design and long-lasting battery make it your ideal companion for work and play. Upgrade to mobile excellence today!', 299.99, 'smartphone.jpg'),
(3, 'Laptop', 'Introducing our powerful laptop with a high-resolution display and fast processor. Ideal for work and play, it offers seamless multitasking, immersive audio, and versatile connectivity. With a sleek design and long-lasting battery, it\'s your ultimate computing companion. Upgrade to excellence today!', 799.99, 'laptop.jpg'),
(4, 'Smartwatch', 'Introducing our sleek smartwatch, where style meets functionality. This cutting-edge device offers fitness tracking to keep you active and notifications to keep you connected. Whether you\'re tracking your workouts or staying updated on messages, this smartwatch is your ideal companion. Elevate your wristwear with our stylish smartwatch today!', 149.99, 'smartwatch.jpg'),
(5, 'Headphones', 'Presenting our premium over-ear headphones, designed to transport you into an immersive world of audio excellence. Crafted with precision, these headphones offer unparalleled sound quality. Whether you\'re enjoying music, movies, or gaming, they guarantee an exceptional listening experience. Elevate your audio journey with our high-quality over-ear headphones today!', 129.99, 'headphones.jpg'),
(6, 'Tablet', 'Introducing our versatile tablet, the epitome of convenience and innovation. With its expansive touchscreen and extended battery life, this tablet is designed to meet all your digital needs. Whether you\'re working, streaming, or browsing, it offers a seamless and enduring experience. Embrace versatility with our exceptional tablet today!', 249.99, 'tablet.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Sjakie van de', 'coach@man-kind.nl', 'halt!'),
(2, 'c c', 'corbijn.bulsink@hotmail.com', 'c'),
(3, 'c c', 'c@adang', 'cc'),
(4, 'caf sagdgdah', 'ag@sdagnka', 'cor'),
(5, 'caf sagdgdah', 'ag@sdagnkas', 'cor'),
(6, 'Hidde van Gastel', 'h.vgastel@hotmail.com', 'hoi12'),
(7, 'Hidde van Gastel', 'h.vgastel@hotmail.coms', 'hoi12'),
(8, 'saf daf', 'adf@fadf', 'cc'),
(9, 'saf daf', 'adf@fadfs', 'cc'),
(10, 'saf daf', 'adf@fadfsss', 'cc'),
(11, 'lol bol', 'cor@eagal', 'l'),
(12, 'c c', 'aglagkangkdalna@LOL', 'LOL'),
(13, 'c c', 'aglagkangkdalna@LOLssss', 'LOL');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
