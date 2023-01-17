-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Sty 2023, 17:04
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
-- Baza danych: `przychodnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typ`
--

CREATE TABLE `typ` (
                       `typ_id` int(11) NOT NULL,
                       `typ` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `typ`
--

INSERT INTO `typ` (`typ_id`, `typ`) VALUES
                                        (1, 'Admin'),
                                        (2, 'Lekarz'),
                                        (3, 'Pacjent');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
                              `uzytkownik_id` int(11) NOT NULL,
                              `typ_id` int(11) DEFAULT NULL,
                              `imie` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
                              `nazwisko` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
                              `login` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
                              `password` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownik`
--

INSERT INTO `uzytkownik` (`uzytkownik_id`, `typ_id`, `imie`, `nazwisko`, `login`, `password`) VALUES
                                                                                                  (1, 1, 'admin', 'admin', 'admin', 'admin'),
                                                                                                  (2, 2, 'Lekarz', 'Lekarski', 'lek', 'lek1'),
                                                                                                  (3, 3, 'Pacjent', 'Pacjentowy', 'pac', 'pac1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wizyta`
--

CREATE TABLE `wizyta` (
                          `id` int(11) NOT NULL,
                          `data_wizyty` date DEFAULT NULL,
                          `czas_wizyty` time DEFAULT NULL,
                          `lekarz_id` int(11) DEFAULT NULL,
                          `pacjent_id` int(11) DEFAULT NULL,
                          `opis` text COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wizyta`
--

INSERT INTO `wizyta` (`id`, `data_wizyty`, `czas_wizyty`, `lekarz_id`, `pacjent_id`, `opis`) VALUES
                                                                                                 (1, '2023-01-16', '17:29:16', 2, 3, 'lorem ipsum'),
                                                                                                 (2, '2023-01-16', '17:29:16', 2, 3, 'lorem ipsum');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `typ`
--
ALTER TABLE `typ`
    ADD PRIMARY KEY (`typ_id`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
    ADD PRIMARY KEY (`uzytkownik_id`),
    ADD KEY `typ_id` (`typ_id`);

--
-- Indeksy dla tabeli `wizyta`
--
ALTER TABLE `wizyta`
    ADD PRIMARY KEY (`id`),
    ADD KEY `lekarz_id` (`lekarz_id`),
    ADD KEY `pacjent_id` (`pacjent_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `typ`
--
ALTER TABLE `typ`
    MODIFY `typ_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
    MODIFY `uzytkownik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `wizyta`
--
ALTER TABLE `wizyta`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
    ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`typ_id`) REFERENCES `typ` (`typ_id`);

--
-- Ograniczenia dla tabeli `wizyta`
--
ALTER TABLE `wizyta`
    ADD CONSTRAINT `wizyta_ibfk_1` FOREIGN KEY (`lekarz_id`) REFERENCES `uzytkownik` (`uzytkownik_id`),
    ADD CONSTRAINT `wizyta_ibfk_2` FOREIGN KEY (`pacjent_id`) REFERENCES `uzytkownik` (`uzytkownik_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
