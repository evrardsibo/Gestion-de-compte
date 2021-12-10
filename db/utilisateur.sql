-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 déc. 2021 à 09:06
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestioncompte`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `est_valide` tinyint(1) DEFAULT NULL,
  `clef` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `password`, `mail`, `role`, `image`, `est_valide`, `clef`) VALUES
('belyse', '$2y$10$sPWawPVJsbZg4xy5e4rtFOFRi7jLzaqIKn9HoQfh.n1UF30wZ6roO', 'sinda87@gmail.com', 'admin', '0', 0, 8099),
('evan', '$2y$10$daauuOF5jRaQJBguq5XmT.a6wmPHdO5CAanxrHsD7nDcVttxqtFmi', 'test@gmail.com', 'superuser', '', 0, 1855),
('evrard', '$2y$10$Y1ZZtokF8m1v7dTqJV.AnOb2dfnxidnBjtf5/MRTHBNxAuH8UxLg.', 'test1@hotmail.com', 'admin', 'profils/evrard/77543_evrard.jpg', 1, 4915),
('evrards', '$2y$10$s.s/jQxzZrw5/ZYR/yYRVO6L1r6B3oFKz4aL9PQz8Oz.LIz00EoTy', '82@gmail.com', 'utilisateur', '', 0, 8674),
('kendji', '$2y$10$B.kznPVeMeRT92z2i5kAfuAvvk/P3QNtFFNaZ2ulVAqy75d1bdEuK', 'hh@ken.bi', 'utilisateur', '', 0, 5197),
('mira', '$2y$10$.ozYJz5piy3IXS5AHq7QneuzGaG96wowyeKbpnspkSx7UqImB3Ia.', 'mira18@gmail.com', 'utilisateur', 'profils/mira/49318_mira1.jpg', 1, 574),
('rrr', '$2y$10$O0eP3KRZUD9Nn6BGcGnHNuvwhUBatALDE8DeLwoOVrryPHoiGYtMy', 'sibo10@hk.dk', 'utilisateur', 'profils/profil.jpg', 0, 7195),
('van', '$2y$10$TZA3gT81hPO88L/tnjFke.LqnOGGNPx9zSSodQvjLMcFUL5.yeM9G', 'yes@l.com', 'utilisateur', '', 0, 7514);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`login`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
