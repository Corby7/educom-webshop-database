-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 27 sep 2023 om 13:32
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
-- Tabelstructuur voor tabel `orderlines`
--

CREATE TABLE `orderlines` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orderlines`
--

INSERT INTO `orderlines` (`id`, `order_id`, `product_id`, `amount`) VALUES
(4, 29, 1, 2),
(5, 29, 3, 4),
(6, 29, 2, 1),
(7, 30, 3, 8),
(8, 31, 3, 5),
(9, 31, 2, 1),
(10, 32, 5, 1),
(11, 33, 5, 1),
(12, 33, 1, 1),
(13, 34, 5, 1),
(14, 34, 1, 1),
(15, 34, 2, 1),
(16, 35, 5, 1),
(17, 35, 1, 1),
(18, 35, 2, 1),
(19, 36, 5, 1),
(20, 36, 1, 1),
(21, 36, 2, 1),
(22, 37, 5, 1),
(23, 37, 1, 1),
(24, 37, 2, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`) VALUES
(28, 2, '2023-09-27 11:43:02'),
(29, 2, '2023-09-27 11:51:22'),
(30, 2, '2023-09-27 12:01:24'),
(31, 2, '2023-09-27 12:02:18'),
(32, 1, '2023-09-27 12:09:52'),
(33, 1, '2023-09-27 12:18:40'),
(34, 1, '2023-09-27 12:24:36'),
(35, 1, '2023-09-27 12:27:05'),
(36, 1, '2023-09-27 12:27:23'),
(37, 1, '2023-09-27 12:27:40');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `filenameimage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `filenameimage`) VALUES
(1, 'Smartphone', 'Introducing our premium smartphone, a perfect fusion of style and technology. With its large high-quality display and advanced camera features, it redefines mobile excellence. From stunning photography to seamless multitasking, this smartphone excels in every aspect. Its sleek design and long-lasting battery make it your ideal companion for work and play. Upgrade to mobile excellence today!', 299.99, 'smartphone.jpg'),
(2, 'Laptop', 'Introducing our powerful laptop with a high-resolution display and fast processor. Ideal for work and play, it offers seamless multitasking, immersive audio, and versatile connectivity. With a sleek design and long-lasting battery, it\'s your ultimate computing companion. Upgrade to excellence today!', 799.99, 'laptop.jpg'),
(3, 'Smartwatch', 'Introducing our sleek smartwatch, where style meets functionality. This cutting-edge device offers fitness tracking to keep you active and notifications to keep you connected. Whether you\'re tracking your workouts or staying updated on messages, this smartwatch is your ideal companion. Elevate your wristwear with our stylish smartwatch today!', 149.99, 'smartwatch.jpg'),
(4, 'Headphones', 'Presenting our premium over-ear headphones, designed to transport you into an immersive world of audio excellence. Crafted with precision, these headphones offer unparalleled sound quality. Whether you\'re enjoying music, movies, or gaming, they guarantee an exceptional listening experience. Elevate your audio journey with our high-quality over-ear headphones today!', 129.99, 'headphones.jpg'),
(5, 'Tablet', 'Introducing our versatile tablet, the epitome of convenience and innovation. With its expansive touchscreen and extended battery life, this tablet is designed to meet all your digital needs. Whether you\'re working, streaming, or browsing, it offers a seamless and enduring experience. Embrace versatility with our exceptional tablet today!', 249.99, 'tablet.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
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
(6, 'Hidde van Gastel', 'h.vgastel@hotmail.com', 'hoi12');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `orderlines`
--
ALTER TABLE `orderlines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT voor een tabel `orderlines`
--
ALTER TABLE `orderlines`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `orderlines`
--
ALTER TABLE `orderlines`
  ADD CONSTRAINT `orderlines_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orderlines_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
