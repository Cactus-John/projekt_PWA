-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 02:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwa_projekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(32) NOT NULL,
  `prezime` varchar(32) NOT NULL,
  `korisnicko_ime` varchar(32) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'Ivan', 'Bošnjak', 'ibosnjak', '$2y$10$GjbxiFq4BLb9MJOfmocy7eByKW8O4.cN1hbHfCZ8sfyWgQdxu/31K', 0),
(2, 'Alojz', 'Rubinić', 'rubi', '$2y$10$iFwysRXsnbB5yZErQOOO2e9y6tmBUpMaqlJrj13gra8RU/YZq5YMK', 1),
(3, 'Luka', 'Galunić', 'admin67', '$2y$10$2mwd1zntnPPkvSAiNdl0xe3xPzQ4cTfyIqBXLISYtAcPkwOeQJKe6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` varchar(32) NOT NULL,
  `naslov` varchar(64) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(64) NOT NULL,
  `kategorija` varchar(64) NOT NULL,
  `arhiva` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(11, '01.06.2026.', 'Politički rad', 'sad', 'izmjenjena arhiva', 'unos_politika.jpg', 'politika', 1),
(12, '01.06.2026.', 'vada', 'asdasdasd', 'asdasdasdasdasdasdasdas', 'unos_politika.jpg', 'politika', 1),
(13, '01.06.2026.', 'Prehrana ', 'Prehrana za mršavljenje', 'Kako se zdravo hraniti i izgubiti višak kilograma?', 'salata.jpeg', 'zdravlje', 0),
(14, '01.06.2026.', 'Trump', 'Putin i Ukraijna', 'ASDSADASDASDASDAS', 'trump.jpeg', 'politika', 1),
(15, '01.06.2026.', 'E-Roller', 'Rast e-romobila', 'Napredak i veći broj proizvodnje e-romobila', 'eroller.jpeg', 'politika', 0),
(16, '01.06.2026.', 'Sport i rekreacija', 'Kako se bolje osjećati?', 'Treniranje sporta čovjek se bolje osjeća, fizički i psihički.', 'imunitet.jpeg', 'zdravlje', 0),
(17, '01.06.2026.', 'EU Verstager', 'Liberalna pitanja u EU ', 'Priče i objašnjenja što raditi u EU.', 'vestager.jpeg', 'politika', 0),
(18, '01.06.2026.', 'Važnost pregleda i imuniteta', 'Kako izbjeći bolesti?', 'Imunitet se gradi kroz unos vitamina posebno vitamina C te se preporuča barem godišnji pregledi doktoru', 'pregled.jpeg', 'zdravlje', 0),
(20, '09.06.2026.', 'Plenković moli mlade Hrvate iz dijaspore', 'Premijer je zahvalio polaznicima na interesu za njihovom domovinom, ali i njihovim precima koji su u \"manje strukturiranim uvjetima\" uspjeli očuvati svoje korijene i poveznice s Hrvatskom.', 'Hrvata u Hrvatskoj svake je godine sve manje, rekao je u hrvatski premijer Andrej Plenković u utorak u Banskim dvorima, gdje je primio mlade članove hrvatske dijaspore koje je pozvao da se vrate u domovinu i daju svoj doprinos demografskoj obnovi zemlje.', 'unos_politika.jpg', 'politika', 0),
(21, '09.06.2026.', 'Počele su vrućine, ne ostavljajte djecu u vozilima!', 'Ostavljanjem djeteta bez nadzora u zatvorenom vozilu grubo se zanemaruje i zlostavlja dijete što predstavlja obilježje kaznenog djela Povrede djetetovih prava, objavila je policija', 'Dolaskom visokih temperatura povećava se opasnost od mogućnosti dehidracije i stradavanja djece ostavljenih u vozilima. Obzirom da su se takva stradavanja događala i ranije, potrebno je osvješćivati i upozoravati roditelje i sve koji se brinu o djeci da postoje rizici i opasnosti od izlaganja djece suncu i visokim temperaturama te da čak i kraći boravak u ugrijanom vozilu može prouzročiti tragične posljedice, objavila je policija.', 'pregled.jpeg', 'zdravlje', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`),
  ADD UNIQUE KEY `korisnicko_ime_2` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
