-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Sty 2022, 12:13
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `faktury`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `administratorzy`
--

CREATE TABLE `administratorzy` (
  `id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `administratorzy`
--

INSERT INTO `administratorzy` (`id`, `user`, `pass`, `email`) VALUES
(1, 'admin1', '$2y$10$Sh86HCzYnSO1vP54stNGnu2K97Kr9w91/hWvqpr7cwcvASeNuFV7K', 'admin@admin.com'),
(2, 'admin2', '$2y$10$WWmsd2wA3SpoTNbdQZss8.Y2nKxcVZE16hOBTOpWGhQzJOrKMh9yS', 'admin2@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `faktury`
--

CREATE TABLE `faktury` (
  `id` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `nip` text COLLATE utf8_polish_ci NOT NULL,
  `pozycja` text COLLATE utf8_polish_ci NOT NULL,
  `kwota` double NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `faktury`
--

INSERT INTO `faktury` (`id`, `nazwa`, `nip`, `pozycja`, `kwota`, `data`) VALUES
(1, 'Testowa firma', '1234567890', 'Usługa', 0.99, '2022-01-28'),
(2, 'Testowa firma', '1234567890', 'Towar', 1000000.09, '2022-01-28');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `faktury`
--
ALTER TABLE `faktury`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `faktury`
--
ALTER TABLE `faktury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
