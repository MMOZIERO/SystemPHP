-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 16 Lut 2015, 15:29
-- Wersja serwera: 5.5.32-cll
-- Wersja PHP: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `moziero_si`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE IF NOT EXISTS `pracownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nazwisko` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `plec` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nazpan` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kodpocztowy` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `imie`, `nazwisko`, `plec`, `nazpan`, `email`, `kodpocztowy`) VALUES
(21, 'Jan', 'Kozak', 'Mezczyzna', 'Koza', 'fgsdf@wp.pl', '78-500'),
(20, 'Emil', 'Wasacz', 'Mezczyzna', 'Wanczyk', 'fgsdf@wp.pl', '78-500'),
(19, 'Micha³', 'Oziero', 'Mezczyzna', 'Oziero', 'fgsdf@wp.pl', '78-500'),
(18, 'Micha³', 'Oziero', 'Mezczyzna', 'Oziero', 'fgsdf@wp.pl', '78-500'),
(17, 'Micha³', 'Oziero', 'Mezczyzna', 'Oziero', 'fgsdf@wp.pl', '78-500'),
(16, 'Micha³', 'Oziero', 'Mezczyzna', 'Oziero', 'fgsdf@wp.pl', '89-600'),
(15, 'Micha³', 'Oziero', 'Mezczyzna', 'Oziero', 'fgsdf@wp.pl', '78-700'),
(31, 'Jan', 'Kozaczek', 'Mezczyzna', 'Keserr', 'sdfrsfre@wp.pl', '78-500'),
(35, 'Jan', 'Borsuk', 'Mezczyzna', 'Nowak', 'sdfrsfre@wp.pl', '78-500'),
(36, 'Jan', 'Ozieross', 'Mezczyzna', 'Sfrfrdsf', 'sdfrsfre@wp.pl', '78-500'),
(37, 'Jan', 'Nowak', 'Mezczyzna', 'Nowak', 'jgfed3rty@wp.pl', '89-600'),
(38, 'gdsgffds', 'gdf', 'Mezczyzna', 'gfd', 'tt@ttt.ggg', '55-555'),
(39, 'Adam', 'Jacek', 'Mezczyzna', 'Jacekk', 'fsgasf@wp.pl', '78-500'),
(40, 'Adam', 'Jacek', 'Mezczyzna', 'Jacekk', 'test12345@wp.pl', '78-500'),
(41, 'Test69', 'Test69', 'Kobieta', 'Test69', 'test12345@wp.pl', '78-500'),
(42, 'Jan UNION SELECT *  FROM  `uzy', 'GGGGGGGGGGG', 'Mezczyzna', 'Ogórek', 'jgfed3rty@wp.pl', '89-600');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE IF NOT EXISTS `uzytkownicy` (
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `haslo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uprawnienia` int(16) NOT NULL,
  `imie` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nazwisko` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`login`, `haslo`, `uprawnienia`, `imie`, `nazwisko`) VALUES
('admin123456', '7488e331b8b64e5794da3fa4eb10ad5d', 4, 'Michal', 'Oziero'),
('gggggg', '9cafeef08db2dd477098a0293e71f90a', 4, 'Adam', 'Nowak'),
('test69', '47ec2dd791e31e2ef2076caf64ed9b3d', 4, 'Jan', 'Nowak');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
         