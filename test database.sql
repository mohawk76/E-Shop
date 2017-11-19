-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Lis 2017, 18:01
-- Wersja serwera: 10.1.26-MariaDB
-- Wersja PHP: 7.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `test`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `images`
--

CREATE TABLE `images` (
  `ID_Image` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `images`
--

INSERT INTO `images` (`ID_Image`, `Name`, `Path`) VALUES
(1, 'Playstation 4', 'images/playstation4.jpeg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id_kategorii` int(11) NOT NULL,
  `Nazwa` varchar(255) DEFAULT NULL,
  `Opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id_kategorii`, `Nazwa`, `Opis`) VALUES
(1, 'Konsole i gry', 'Maszyny do grania w gry.'),
(2, 'RTV i Telewizory', NULL),
(3, 'Komputery i Tablety', NULL),
(4, 'Foto i Kamery', NULL),
(5, 'Telefony i Smartfony', NULL),
(7, 'Fast Food', 'Pyszne zarelko');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klient` int(11) NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Imie` varchar(255) NOT NULL,
  `Nazwisko` varchar(255) NOT NULL,
  `Telefon` varchar(255) NOT NULL,
  `Adres` varchar(255) NOT NULL,
  `Miasto` varchar(255) NOT NULL,
  `KodPocztowy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `producenci`
--

CREATE TABLE `producenci` (
  `id_producent` int(11) NOT NULL,
  `Nazwa` varchar(255) NOT NULL,
  `Kontakt` varchar(255) DEFAULT NULL,
  `Adres` varchar(255) DEFAULT NULL,
  `Miasto` varchar(255) DEFAULT NULL,
  `KodPocztowy` varchar(255) DEFAULT NULL,
  `Panstwo` varchar(255) DEFAULT NULL,
  `Telefon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `producenci`
--

INSERT INTO `producenci` (`id_producent`, `Nazwa`, `Kontakt`, `Adres`, `Miasto`, `KodPocztowy`, `Panstwo`, `Telefon`) VALUES
(1, 'Sony', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Asus', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Samsung', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'LG', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Panasonic', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Philips', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Lenovo', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Turek ', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produkt` int(11) NOT NULL,
  `Nazwa` varchar(255) DEFAULT NULL,
  `Opis` varchar(255) NOT NULL,
  `ID_Image` int(11) DEFAULT NULL,
  `id_producent` int(11) DEFAULT NULL,
  `id_kategorii` int(11) DEFAULT NULL,
  `Jednostka` varchar(255) DEFAULT NULL,
  `Cena` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id_produkt`, `Nazwa`, `Opis`, `ID_Image`, `id_producent`, `id_kategorii`, `Jednostka`, `Cena`) VALUES
(1, 'Playstation 4', 'Dobra konsolka', 1, 1, 1, 'szt.', 999),
(2, 'Playstation 3', 'Konsolka starszej generacji', NULL, 1, 1, 'szt.', 500),
(3, 'Telewizor SAMSUNG UE55MU6102K', 'Ladny obraz', NULL, 3, 2, 'szt.', 2999),
(4, 'Telewizor LG 55EG9A7V', 'Dobry telewizor w dobrej cenie!', NULL, 4, 2, 'szt.', 5999),
(5, 'Smartfon Samsung Galaxy Note 8 Czarny (SM-N950FZKDXEO)', 'Ladny ekran', NULL, 3, 5, 'szt.', 4298),
(6, 'Kebab XXL', 'samo mieso', NULL, 8, 7, 'kg', 21),
(7, 'Xbox360', 'Ma kinecta', NULL, 4, 1, 'szt.', 719);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Login` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `Login`, `Password`) VALUES
(1, 'mohawk76', 'wafel001');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_klient` int(11) DEFAULT NULL,
  `ZamData` date DEFAULT NULL,
  `id_producent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowieniaszczegoly`
--

CREATE TABLE `zamowieniaszczegoly` (
  `id_szczegol_zamowienia` int(11) NOT NULL,
  `id_zamowienia` int(11) NOT NULL,
  `id_produkt` int(11) NOT NULL,
  `Ilosc` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ID_Image`);

--
-- Indexes for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id_kategorii`);

--
-- Indexes for table `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klient`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- Indexes for table `producenci`
--
ALTER TABLE `producenci`
  ADD PRIMARY KEY (`id_producent`);

--
-- Indexes for table `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produkt`),
  ADD KEY `Produkty01` (`id_producent`),
  ADD KEY `Produkty02` (`id_kategorii`),
  ADD KEY `ProduktyImages` (`ID_Image`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `Zamowienia01` (`id_klient`),
  ADD KEY `Zamowienia02` (`id_producent`);

--
-- Indexes for table `zamowieniaszczegoly`
--
ALTER TABLE `zamowieniaszczegoly`
  ADD PRIMARY KEY (`id_szczegol_zamowienia`),
  ADD KEY `ZamowieniaSzczegoly01` (`id_zamowienia`),
  ADD KEY `ZamowieniaSzczegoly02` (`id_produkt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `images`
--
ALTER TABLE `images`
  MODIFY `ID_Image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klient` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `producenci`
--
ALTER TABLE `producenci`
  MODIFY `id_producent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produkt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `zamowieniaszczegoly`
--
ALTER TABLE `zamowieniaszczegoly`
  MODIFY `id_szczegol_zamowienia` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `ProduktyImages` FOREIGN KEY (`ID_Image`) REFERENCES `images` (`ID_Image`) ON DELETE SET NULL,
  ADD CONSTRAINT `ProduktyKategorie` FOREIGN KEY (`id_kategorii`) REFERENCES `kategorie` (`id_kategorii`) ON DELETE SET NULL,
  ADD CONSTRAINT `ProduktyProducenci` FOREIGN KEY (`id_producent`) REFERENCES `producenci` (`id_producent`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `CustomerOrder` FOREIGN KEY (`id_klient`) REFERENCES `klienci` (`id_klient`) ON DELETE CASCADE,
  ADD CONSTRAINT `producentFK` FOREIGN KEY (`id_producent`) REFERENCES `producenci` (`id_producent`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `zamowieniaszczegoly`
--
ALTER TABLE `zamowieniaszczegoly`
  ADD CONSTRAINT `ZamowieniaSzczegolyOrder` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`) ON DELETE CASCADE,
  ADD CONSTRAINT `produktFK` FOREIGN KEY (`id_produkt`) REFERENCES `zamowienia` (`id_zamowienia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
