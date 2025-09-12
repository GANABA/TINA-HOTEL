-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 15 mars 2025 à 04:01
-- Version du serveur : 8.0.30
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hb_website`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'Melki', '12345');

-- --------------------------------------------------------

--
-- Structure de la table `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int NOT NULL,
  `booking_id` int NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `total_pay` int NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `motif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`, `nationality`, `profession`, `motif`) VALUES
(1, 1, 'Chambre standard', 50, 700, NULL, 'Melki GANABA', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(2, 2, 'Chambre standard', 50, 500, NULL, 'Melki GANABA', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(3, 3, 'Chambre standard', 70, 150, 'A5', 'Melki Ganaba', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(4, 4, 'Chambre standard', 50, 300, 'B54', 'Melki Ganaba', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(5, 5, 'Suite supérieur', 150, 600, 'C30', 'Melki Ganaba', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(6, 6, 'Suite supérieur', 150, 1200, NULL, 'Melki Ganaba', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(7, 7, 'Chambre Deluxe', 200, 600, 'Q4', 'Melki Ganaba', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(8, 8, 'Chambre standard', 50, 150, NULL, 'Melki Ganaba', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(9, 9, 'Chambre standard', 50, 50, NULL, 'Melki Ganaba', '58002314', 'XYZ, Boukombé, TINA Hotel', '', '', ''),
(10, 10, 'Chambre Deluxe', 200, 400, NULL, 'Melki Ganaba', '90123407', 'XYZ, Boukombé', '', '', ''),
(11, 11, 'Chambre standard', 50, 150, 'D4', 'Melki Ganaba', '90123407', 'XYZ, Boukombé', '', '', ''),
(12, 12, 'Chambre standard', 50, 150, 'T13', 'Melki Ganaba', '90123407', 'XYZ, Boukombé', '', '', ''),
(13, 13, 'Chambre standard', 50, 50, 'V6', 'Melki Ganaba', '90123407', 'XYZ, Boukombé', '', '', ''),
(14, 14, 'Suite supérieur', 150, 300, NULL, 'sedek', '334455189', 'Arafat', '', '', ''),
(15, 15, 'Chambre Standard - Ventilation', 3000, 18000, NULL, 'Melki Ganaba', '90123407', 'XYZ, Boukombé', '', '', ''),
(16, 16, 'Suite supérieur', 150, 300, NULL, 'Melki Ganaba', '90123407', 'XYZ, Boukombé', '', '', ''),
(17, 17, 'Salle de Conférence Atacora', 10000, 10000, NULL, 'Melki Ganaba', '90123407', 'XYZ, Boukombé', '', '', ''),
(18, 18, 'Salle de Conférence Tata', 7000, 21000, NULL, 'Melki Ganaba', '90123407', 'Porto', 'Beninois', 'Maitre', 'Tourisme'),
(19, 19, 'Chambre standard', 50, 50, NULL, 'Melki Ganaba', '90123407', 'titirou', 'Beninois', 'Maitr', 'Mission'),
(20, 20, 'Salle de Conférence Tata', 7000, 7000, 'QE', 'Melki Ganaba', '90123407', 'cotonou', 'Beninois', 'Maitre', 'Repos'),
(21, 21, 'Chambre Standard - Ventilation', 3000, 9000, 'KLM3', 'Melki Ganaba', '90123407', 'nati', 'Beninois', 'Maitre', 'Atelier');

-- --------------------------------------------------------

--
-- Structure de la table `booking_offline`
--

CREATE TABLE `booking_offline` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `motif` varchar(100) NOT NULL,
  `room_id` int NOT NULL,
  `room_no` varchar(100) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `trans_amount` int NOT NULL,
  `datentime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `booking_offline`
--

INSERT INTO `booking_offline` (`id`, `name`, `nationality`, `profession`, `phonenum`, `address`, `motif`, `room_id`, `room_no`, `check_in`, `check_out`, `trans_amount`, `datentime`) VALUES
(1, 'gnb', '', '', '478584754893', 'bkbe', '', 7, 'A356', '2025-03-05', '2025-03-07', 12560, '2025-03-05 10:33:13'),
(2, 'gnb gmkr', '', '', '478584754893', 'bkbe city', '', 9, 'CE79', '2025-03-10', '2025-03-15', 7000, '2025-03-05 10:43:09'),
(3, 'gnb gmkr', '', '', '478584754893', 'bkbe city', '', 8, 'CE79', '2025-03-05', '2025-03-06', 7000, '2025-03-05 11:02:23'),
(4, 'Melki', '', '', '0147890924', 'Parakou', '', 9, 'C34', '2025-03-05', '2025-03-12', 500, '2025-03-05 22:55:38'),
(5, 'Rod', '', '', '0178909200', 'NATI', '', 8, 'C34', '2025-03-06', '2025-03-08', 500, '2025-03-05 22:59:32'),
(6, 'sedek', '', '', '0178909200', 'Natitingou', '', 7, 'C37', '2025-03-05', '2025-03-09', 450, '2025-03-05 23:11:26'),
(7, 'Kiki Leko', 'Beninoise', 'Enseignant', '01347585990', 'Parakou', 'Visite', 12, 'Salle conférence', '2025-03-13', '2025-03-14', 12560, '2025-03-13 00:43:57'),
(8, 'Sedek GNB', 'Togolais', 'Ingénieur', '98457689', 'Lomé', 'Mission', 11, '115', '2025-03-14', '2025-03-16', 15000, '2025-03-13 10:30:15');

-- --------------------------------------------------------

--
-- Structure de la table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int NOT NULL,
  `user_id` int NOT NULL,
  `room_id` int NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int NOT NULL DEFAULT '0',
  `refund` int DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'pending',
  `order_id` varchar(150) NOT NULL,
  `trans_id` varchar(200) DEFAULT NULL,
  `trans_amount` int NOT NULL,
  `trans_status` varchar(100) NOT NULL DEFAULT 'pending',
  `trans_res_msg` varchar(200) DEFAULT NULL,
  `rate_review` int DEFAULT NULL,
  `datentime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_id`, `trans_amount`, `trans_status`, `trans_res_msg`, `rate_review`, `datentime`) VALUES
(1, 5, 7, '2025-01-23', '2025-01-25', 0, 1, 'cancelled', 'ORD_12323534335', '122434455656576096564', 700, 'TXN_SUCCESS', 'Txn Success', NULL, '2025-01-28 09:53:54'),
(2, 5, 7, '2025-01-26', '2025-01-30', 0, 0, 'cancelled', 'ORD_1232353433', '12243445565676096564', 500, 'TXN_SUCCESS', 'Txn Success', NULL, '2025-01-22 09:53:54'),
(3, 5, 7, '2025-02-03', '2025-02-05', 1, NULL, 'booked', 'ORD_2243243455', '112345096800', 150, 'TXN_SUCCESS', 'Txn Success', 1, '2025-02-03 11:15:48'),
(4, 5, 7, '2025-02-05', '2025-02-07', 1, NULL, 'booked', 'ORD_232300003994', '34584645064059', 300, 'TXN_SUCCESS', 'Txn Success', 1, '2025-02-03 11:19:21'),
(5, 5, 8, '2025-02-24', '2025-02-28', 1, NULL, 'booked', 'ORD_57216506', NULL, 600, 'TXN_SUCCESS', NULL, 1, '2025-02-24 11:23:01'),
(6, 5, 8, '2025-02-25', '2025-03-05', 0, 0, 'cancelled', 'ORD_58247748', NULL, 1200, 'TXN_SUCCESS', NULL, NULL, '2025-02-24 12:01:17'),
(7, 5, 9, '2025-02-24', '2025-02-27', 1, NULL, 'booked', 'ORD_58000903', NULL, 600, 'TXN_SUCCESS', NULL, 1, '2025-02-24 13:04:09'),
(8, 5, 7, '2025-02-24', '2025-02-27', 0, NULL, 'cancelled', 'ORD_59129976', NULL, 150, 'TXN_SUCCESS', NULL, NULL, '2025-02-24 13:38:40'),
(9, 5, 7, '2025-02-25', '2025-02-26', 0, NULL, 'cancelled', 'ORD_52703393', NULL, 50, 'TXN_SUCCESS', NULL, NULL, '2025-02-24 13:42:59'),
(10, 5, 9, '2025-02-26', '2025-02-28', 0, NULL, 'cancelled', 'ORD_55727104', NULL, 400, 'TXN_SUCCESS', NULL, NULL, '2025-02-24 13:59:24'),
(11, 5, 7, '2025-02-25', '2025-02-28', 1, NULL, 'booked', 'ORD_55561162', NULL, 150, 'TXN_SUCCESS', NULL, 1, '2025-02-25 07:57:52'),
(12, 5, 7, '2025-03-02', '2025-03-05', 1, NULL, 'booked', 'ORD_58480340', NULL, 150, 'TXN_SUCCESS', NULL, 1, '2025-03-01 16:00:39'),
(13, 5, 7, '2025-03-20', '2025-03-21', 1, NULL, 'booked', 'ORD_55764314', NULL, 50, 'TXN_SUCCESS', NULL, 0, '2025-03-01 17:26:12'),
(14, 10, 8, '2025-03-07', '2025-03-09', 0, NULL, 'booked', 'ORD_108969490', NULL, 300, 'TXN_SUCCESS', NULL, NULL, '2025-03-06 09:58:56'),
(15, 5, 10, '2025-03-09', '2025-03-15', 0, NULL, 'booked', 'ORD_59203999', NULL, 18000, 'TXN_SUCCESS', NULL, NULL, '2025-03-09 20:51:42'),
(16, 5, 8, '2025-03-10', '2025-03-12', 0, NULL, 'cancelled', 'ORD_54073594', NULL, 300, 'TXN_SUCCESS', NULL, NULL, '2025-03-10 07:21:27'),
(17, 5, 12, '2025-03-12', '2025-03-13', 0, NULL, 'booked', 'ORD_56763097', NULL, 10000, 'TXN_SUCCESS', NULL, NULL, '2025-03-12 15:08:15'),
(18, 5, 13, '2025-03-14', '2025-03-17', 0, NULL, 'booked', 'ORD_58906850', NULL, 21000, 'TXN_SUCCESS', NULL, NULL, '2025-03-12 17:17:27'),
(19, 5, 7, '2025-03-12', '2025-03-13', 0, NULL, 'cancelled', 'ORD_56376416', NULL, 50, 'TXN_SUCCESS', NULL, NULL, '2025-03-12 23:44:54'),
(20, 5, 13, '2025-03-13', '2025-03-14', 1, NULL, 'booked', 'ORD_51763258', NULL, 7000, 'TXN_SUCCESS', NULL, 1, '2025-03-13 04:15:53'),
(21, 5, 10, '2025-03-14', '2025-03-17', 1, NULL, 'booked', 'ORD_56423022', NULL, 9000, 'TXN_SUCCESS', NULL, 0, '2025-03-13 04:18:56');

-- --------------------------------------------------------

--
-- Structure de la table `carousel`
--

CREATE TABLE `carousel` (
  `sr_no` int NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `carousel`
--

INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(16, 'IMG_3220.jpg'),
(17, 'IMG_5895.jpg'),
(20, 'IMG_4664.jpg'),
(21, 'IMG_9016.jpg'),
(22, 'IMG_8990.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` bigint NOT NULL,
  `pn2` bigint NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'XYZ, Boukombé, TINA Hotel', 'https://maps.app.goo.gl/P9xnKJVBqszymSVz9', 2290197350863, 2290196436341, 'tinahotel@gmail.com', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://x.com/X.', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3927.079090500213!2d1.1074750000000002!3d10.174226700000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102b670f2db74a4b:0xfcc8e99eea63f4ef!2sTINA Hôtel!5e0!3m2!1sfr!2sbj!4v1741390602751!5m2!1sfr!2sbj');

-- --------------------------------------------------------

--
-- Structure de la table `facilities`
--

CREATE TABLE `facilities` (
  `id` int NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(17, 'IMG_8898.svg', 'Télévision', 'Profitez d&#039;une télévision à écran plat pour vous détendre après une longue journée. Accédez à une variété de chaînes locales et internationales pour votre divertissement.'),
(18, 'IMG_9503.svg', 'Climatisation', 'Nos chambres sont dotées d&#039;un système de climatisation performant, vous assurant un environnement frais et agréable, quelle que soit la température extérieure.'),
(21, 'IMG_3129.svg', 'Wi-Fi', 'Restez connecté à vos activités sur internet avec un accès Wi-Fi rapide et sécurisé dans toutes les chambres et espaces communs de l&#039;hôtel, idéal pour le travail ou le divertissement.');

-- --------------------------------------------------------

--
-- Structure de la table `features`
--

CREATE TABLE `features` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(9, 'Lit double'),
(10, 'Salle de bain'),
(12, 'Douche à effet pluie'),
(20, 'Salle de bain privative'),
(21, 'Brasseur d&#039;air'),
(22, 'Bureau et chaise'),
(23, 'Armoire'),
(24, 'Service de ménage'),
(25, 'Moustiquaire'),
(26, 'Sonorisation'),
(27, 'Vidéo projecteur'),
(28, 'Tableau projecteur'),
(29, 'Tableau de conférence'),
(30, 'Disposition flexible'),
(31, 'Eclairage ajustable');

-- --------------------------------------------------------

--
-- Structure de la table `rating_review`
--

CREATE TABLE `rating_review` (
  `sr_no` int NOT NULL,
  `booking_id` int NOT NULL,
  `room_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `review` varchar(200) NOT NULL,
  `seen` int NOT NULL DEFAULT '0',
  `datentime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rating_review`
--

INSERT INTO `rating_review` (`sr_no`, `booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`) VALUES
(5, 3, 7, 5, 4, 'Un cadre exceptionnel et un accueil chaleureux ! L\'hôtel est propre, bien situé et idéal pour découvrir Boukombé. Je recommande vivement.', 1, '2025-02-18 14:51:39'),
(6, 4, 7, 5, 5, 'Nous avons passé un séjour incroyable. L’équipe est accueillante et le cadre est reposant. C’est l’endroit parfait pour se ressourcer en pleine nature.', 1, '2025-02-18 15:09:48'),
(7, 5, 8, 5, 3, 'pas mal', 0, '2025-02-24 11:29:26'),
(10, 11, 7, 5, 2, 'faible', 0, '2025-02-25 08:03:03'),
(12, 20, 13, 5, 5, 'cetais smpa l&#039;accueil', 0, '2025-03-13 05:16:31');

-- --------------------------------------------------------

--
-- Structure de la table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(100) NOT NULL,
  `area` int NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `adult` int NOT NULL,
  `children` int NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `removed` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `type`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(7, 'Chambre standard', '', 20, 50, 2, 2, 1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt adipisci quae fugit quisquam corrupti ducimus aspernatur at voluptas consequuntur quod. Non accusantium earum a corporis quisquam veniam consectetur consequuntur ratione!', 1, 1),
(8, 'Suite supérieur', '', 40, 150, 5, 2, 1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt adipisci quae fugit quisquam corrupti ducimus aspernatur at voluptas consequuntur quod. Non accusantium earum a corporis quisquam veniam consectetur consequuntur ratione!', 1, 1),
(9, 'Chambre Deluxe', '', 60, 200, 2, 4, 1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt adipisci quae fugit quisquam corrupti ducimus aspernatur at voluptas consequuntur quod. Non accusantium earum a corporis quisquam veniam consectetur consequuntur ratione!', 1, 1),
(10, 'Chambre Standard - Ventilation', 'Chambre', 12, 7500, 12, 2, 1, 'Élégante et fonctionnelle, notre Chambre Standard avec ventilation vous assure un séjour agréable dans un cadre apaisant. Équipée d&amp;#039;un lit double confortable, d&amp;#039;un brasseur d&amp;#039;air et d&amp;#039;un décor soigné, elle offre tout le nécessaire pour un moment de détente à Boukombé.', 1, 0),
(11, 'Chambre Standard - Climatisée', 'Chambre', 12, 13500, 8, 2, 1, 'Profitez d&amp;#039;un confort optimal avec notre Chambre Standard climatisée. Dotée d&amp;#039;un lit double spacieux, d&amp;#039;une climatisation performante et d&amp;#039;une atmosphère chaleureuse, elle est idéale pour un séjour relaxant après une journée d&amp;#039;exploration ou de travail.', 1, 0),
(12, 'Salle de Conférence Atacora', 'Salle', 150, 90000, 1, 100, 1, 'Spacieuse et équipée, la Salle Atacora est idéale pour les grandes réunions, séminaires et événements. Avec une capacité généreuse, elle offre un cadre professionnel et confortable, favorisant des échanges productifs.', 1, 0),
(13, 'Salle de Conférence Tata', 'Salle', 100, 75000, 1, 70, 1, 'Intimiste et fonctionnelle, la Salle Tata est parfaite pour les réunions de taille moyenne, les formations ou les comités restreints. Son atmosphère propice à la concentration et son équipement moderne en font un choix privilégié pour vos rencontres professionnelles.', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `sr_no` int NOT NULL,
  `room_id` int NOT NULL,
  `facilities_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `room_facilities`
--

INSERT INTO `room_facilities` (`sr_no`, `room_id`, `facilities_id`) VALUES
(103, 10, 17),
(104, 10, 21),
(105, 11, 17),
(106, 11, 18),
(107, 11, 21),
(114, 13, 18),
(115, 13, 21),
(120, 12, 18),
(121, 12, 21);

-- --------------------------------------------------------

--
-- Structure de la table `room_features`
--

CREATE TABLE `room_features` (
  `sr_no` int NOT NULL,
  `room_id` int NOT NULL,
  `features_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `room_features`
--

INSERT INTO `room_features` (`sr_no`, `room_id`, `features_id`) VALUES
(172, 10, 9),
(173, 10, 20),
(174, 10, 21),
(175, 10, 22),
(176, 10, 24),
(177, 11, 9),
(178, 11, 20),
(179, 11, 21),
(180, 11, 22),
(181, 11, 24),
(203, 13, 21),
(204, 13, 26),
(205, 13, 27),
(206, 13, 28),
(207, 13, 29),
(208, 13, 30),
(209, 13, 31),
(224, 12, 21),
(225, 12, 26),
(226, 12, 27),
(227, 12, 28),
(228, 12, 29),
(229, 12, 30),
(230, 12, 31);

-- --------------------------------------------------------

--
-- Structure de la table `room_images`
--

CREATE TABLE `room_images` (
  `sr_no` int NOT NULL,
  `room_id` int NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `room_images`
--

INSERT INTO `room_images` (`sr_no`, `room_id`, `image`, `thumb`) VALUES
(27, 10, 'IMG_8452.jpg', 1),
(28, 10, 'IMG_7215.jpg', 0),
(30, 10, 'IMG_2828.jpg', 0),
(32, 11, 'IMG_8750.jpg', 1),
(33, 11, 'IMG_2539.jpg', 0),
(34, 11, 'IMG_2441.jpg', 0),
(35, 11, 'IMG_8184.jpg', 0),
(36, 12, 'IMG_5648.jpg', 0),
(37, 12, 'IMG_5594.jpg', 1),
(38, 12, 'IMG_4219.jpg', 0),
(39, 12, 'IMG_3365.jpg', 0),
(40, 13, 'IMG_9201.jpg', 1),
(41, 13, 'IMG_6587.jpg', 0),
(42, 13, 'IMG_6000.jpg', 0),
(43, 13, 'IMG_2849.jpg', 0),
(44, 7, 'IMG_3275.webp', 0);

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'TINA HOTEL', 'Un havre de paix au cœur de l’Atacora. Profitez d’un séjour alliant confort, hospitalité et découverte, avec des services pensés pour votre bien-être. Une expérience unique entre tradition et modernité, idéale pour voyageurs et aventuriers.', 0);

-- --------------------------------------------------------

--
-- Structure de la table `team_details`
--

CREATE TABLE `team_details` (
  `sr_no` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `nationality` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `is_verified` int NOT NULL DEFAULT '0',
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `datentime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `nationality`, `phonenum`, `profession`, `profile`, `password`, `is_verified`, `token`, `t_expire`, `status`, `datentime`) VALUES
(5, 'Melki Ganaba', 'melchisedech@gmail.com', 'Beninois', '90123407', 'Maitre', 'IMG_9858.jpeg', '$2y$10$UwlTl7PwL93Ul5rxDHHGo.hmL3ef6hjZrDaF6dGmL48bWej57R3Pm', 1, NULL, NULL, 1, '2024-12-22 09:59:53'),
(6, 'walid', 'elwalid2008@gmail.com', 'Calavi', '66493008', '2222-02-22', 'default.jpg', '$2y$10$mKM2z78dLiJ/AqQmDy41N.MLmDyKMywzZfdv8lw/kDhGzXHqL0xOu', 1, NULL, NULL, 1, '2025-01-24 10:46:23'),
(9, 'Rodanim', 'kiki@gmail.com', 'nati', '33445512', '2025-03-14', 'IMG_6724.jpeg', '$2y$10$hKSwDhOlGSj7wW.7FYZp6.BqxjAN7it5E8LSj8Ja9juCUIIn5oFhy', 1, '0fb75a6d81a3ce227a8601262f543f0b', NULL, 1, '2025-03-06 09:31:22'),
(10, 'sedek', 'sedek@gmail.com', 'Arafat', '334455189', '2025-03-06', 'IMG_5934.jpeg', '$2y$10$MkBheFTyYeLwujxi1/uKv.2nUI5AX4sCDyf/C42vFexO4KJvh7nZa', 1, '17852fb80c6d2d27516e4f9a4619e3b4', NULL, 1, '2025-03-06 09:51:42'),
(11, 'Joseph AYA', 'jojo@gmail.com', 'cotonou', '90123468', '2025-03-13', 'IMG_9885.jpeg', '$2y$10$PH0.kRLTQuFVkkfDFH.Wze.eCkLNMkxD7I/NqHXk/Z3RaNO4ETpQS', 1, '53eff1e7e62db1b1df521bb2cd49ab50', NULL, 1, '2025-03-06 10:11:52'),
(13, 'kouKou', 'kouKou@gmail.com', 'koutchata', '26364808', '2022-02-02', 'default.jpg', '$2y$10$XYRgITaqfZwjcCyCIFG1mu9aq6bDKkon4DxjRS2ycejdwbFeWW9vW', 1, '3bcf1540a1c80845e97d6d4437e17340', NULL, 1, '2025-03-09 03:20:27'),
(15, 'john', 'jonhdoe@gmail.com', 'Ctn', '012346789', '2025-03-02', 'IMG_5777.jpeg', '$2y$10$OFTU7Y7ahUYryIYRZ1Nkd.kc08u.zKR/fG0.RBXbWrbcZ4pIo9KRe', 1, 'bfc56010c01aeee3514175b2cd043eb2', '2025-03-10', 1, '2025-03-09 21:06:32'),
(17, 'luc', 'luc@gmail.com', 'Lome', '4758509409', '2025-03-09', 'user_67ce989704c3e.jpg', '$2y$10$AxbME4ZsCSlaNgHdy13uSO9G98tv5YBNJ4rLmFDniIIQzgs3lJUUC', 0, 'e3a404586f475afe9e191150567672be', NULL, 1, '2025-03-10 08:45:33'),
(18, 'Claude', 'claude@gmail.com', 'CLAUDE', '2374010', '2025-03-10', 'IMG_3141.jpeg', '$2y$10$9utgbj8SY1c3iybkKRGxOet4fFMNuxGiXpBtC9pdfu0yilyzFmEqC', 1, '856dde2dba4ec5b3930163129436c79f', NULL, 1, '2025-03-10 08:47:41'),
(19, 'lili', 'lili@gmail.com', 'llolo', '01234685', '2025-03-11', 'user_67d04415752a2.jpg', '$2y$10$aIaMklbX1GFrAP7YVVBYS.ks8MagtZTnLhmVUeK6..xTbq/M3H5Xi', 0, '0adccdd6634434c95636934063dea0ff', NULL, 1, '2025-03-11 15:09:36'),
(20, 'ganabarodanimkm', 'ganabarodanimkm@gmail.com', 'Dubai', '012365798', '2025-02-27', 'IMG_1733.jpeg', '$2y$10$lP8dn6srkJamxcdRVMrb6OSTlrBDE1qpsWkPKgUZRFZDGV44toxHq', 0, '760ef592796dba0a27233f81998512bb', NULL, 1, '2025-03-11 15:13:17'),
(21, 'Loa', 'test-qi6j3adb4@srv1.mail-tester.com', 'SDFTR', '23456', '2025-03-11', 'user_67d0b8e013414.jpg', '$2y$10$hPf.dld8xG0vKqsIQV7mX.ubx8/kla3m4C4CxWtFlP5yz4e009aVi', 0, 'd22e9237cf14b914fb70d61eee48aa63', NULL, 1, '2025-03-11 23:27:49'),
(22, 'Gan', 'gan@gmail.com', 'Béninoise', '99123455234', '2025-03-12', 'user_67d19c7e02fcb.jpg', '$2y$10$przlfeZxxoE863LhVJrdJ.yxeqLSN9.1PBiUPbc9U5HQAFshINWSS', 0, '55bcaf736687b479b7c5ef627c401ae4', NULL, 1, '2025-03-12 15:38:58'),
(23, 'ndaoo', 'ndaoo@gmail.com', 'Béninoise', '991234552', 'Etudiant', 'user_67d1a27a67fb4.jpg', '$2y$10$J7qxLNrsOmza3ZidC6rkXOj/IMCFc6cgk21VPK3fYQlOLsda3vspy', 0, '95affaa8fe011a9f38cad04134d7d215', NULL, 1, '2025-03-12 16:04:31'),
(24, 'jojo', 'jana@gmail.com', 'Togolais', '38858649', 'Ingénieur', 'IMG_9455.jpeg', '$2y$10$vGFW1uFuJnHkddZO9WpYKOH9sGUeXrFPLkQXSdNvI6DHuG3NSGNBm', 0, '60bbaf26c93ba1cd290708810201ab46', NULL, 1, '2025-03-13 21:59:53');

-- --------------------------------------------------------

--
-- Structure de la table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `datentime` datetime NOT NULL,
  `seen` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_queries`
--

INSERT INTO `user_queries` (`sr_no`, `name`, `email`, `subject`, `message`, `datentime`, `seen`) VALUES
(34, 'Rodanim GANABA', 'ganabamelchisedech@gmail.com', 'cc', 'Nouvelle demande', '2025-03-01 17:47:31', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Index pour la table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Index pour la table `booking_offline`
--
ALTER TABLE `booking_offline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Index pour la table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Index pour la table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`sr_no`);

--
-- Index pour la table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Index pour la table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `facilities id` (`facilities_id`),
  ADD KEY `room id` (`room_id`);

--
-- Index pour la table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `features id` (`features_id`),
  ADD KEY `rm id` (`room_id`);

--
-- Index pour la table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `room_id` (`room_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Index pour la table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `booking_offline`
--
ALTER TABLE `booking_offline`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `features`
--
ALTER TABLE `features`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT pour la table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT pour la table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `booking_offline`
--
ALTER TABLE `booking_offline`
  ADD CONSTRAINT `booking_offline_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT;

--
-- Contraintes pour la table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `rm id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT;

--
-- Contraintes pour la table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
