-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Mar 2023, 19:59
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `group-management`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `birth_date`) VALUES
(19, 'rycuke', '$2y$10$/X8dAGsvvHJT6rR7gjB69uCGXZRvElQsmgbdQLZJ2kdzjOLfxAi12', 'Autumn', 'Branch', '1973-07-01'),
(20, 'wezozi', '$2y$10$9jc6lmWAJQAJ7zfNv/7uY.juZMAYIpQzA41/umzn.Rc8P1p4TLpOC', 'Hamish', 'Bird', '1995-06-29'),
(21, 'zykarum', '$2y$10$n68nghZc/pDV.OK3n9eOSO1TPEF9yYM/9yGPO1dPdfltEUtWr9Izm', 'Iola', 'Camacho', '2005-08-02'),
(22, 'ferufug', '$2y$10$EIIjUX4G.tG3MHXuFqeYuu.ams4X3wD3hPJwLPCUULdTNuVrAn5Ta', 'Fay', 'Ortega', '1975-07-30'),
(23, 'cukukojave', '$2y$10$sAzM4VH0s0KGtb.p19KKwOAOt8XST0c1yWdVznh/3F8W2iGGfcGr2', 'Minerva', 'Rowe', '1971-09-08'),
(25, 'admin', '$2y$10$s62FfYDhcJ7cOThY.2mFtu2RXWk4oVae0Rsx1wxZsFvABlHIfc.4m', 'Admin', 'Admin', '2023-03-06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`) VALUES
(33, 'LoTR Fans'),
(34, 'Harry Potter Fans'),
(35, 'Star Wars Fans'),
(36, 'Star Trek Fans');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_group_map`
--

CREATE TABLE `user_group_map` (
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user_group_map`
--

INSERT INTO `user_group_map` (`user_id`, `group_id`) VALUES
(19, 33),
(20, 33),
(21, 34),
(22, 34),
(19, 35),
(20, 35),
(23, 36),
(21, 36),
(20, 36),
(19, 36),
(19, 34);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeksy dla tabeli `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT dla tabeli `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
