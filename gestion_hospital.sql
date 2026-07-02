-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 02 juil. 2026 à 02:46
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_hospital`
--

-- --------------------------------------------------------

--
-- Structure de la table `consultations`
--

CREATE TABLE `consultations` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `medecin_id` int(11) NOT NULL,
  `rendez_vous_id` int(11) DEFAULT NULL,
  `date_consultation` datetime NOT NULL,
  `motif` varchar(255) DEFAULT NULL,
  `diagnostic` text DEFAULT NULL,
  `traitement` text DEFAULT NULL,
  `observation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consultations`
--

INSERT INTO `consultations` (`id`, `patient_id`, `medecin_id`, `rendez_vous_id`, `date_consultation`, `motif`, `diagnostic`, `traitement`, `observation`) VALUES
(1, 1, 1, NULL, '2026-07-01 22:10:00', 'malade', 'sida', 'paracetamol', 'danger de mort');

-- --------------------------------------------------------

--
-- Structure de la table `medecins`
--

CREATE TABLE `medecins` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medecins`
--

INSERT INTO `medecins` (`id`, `nom`, `prenom`, `specialite`, `telephone`, `email`) VALUES
(1, 'MANSIATIMA', 'SENDO', 'gynecologue', '0854792143', 'horemiezola@gmail.com'),
(2, 'NGOMA', 'NSIKU', 'chirurgien', '0854792143', 'horemiezola@gmail.com'),
(3, 'SUESO', 'VIMBI', 'ophtamologue', '0854792143', 'horemiezola@gmail.com'),
(4, 'ZOLA', 'METHO', 'pediatre', '0854792143', 'horemiezola@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `numero_patient` varchar(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `sexe` enum('Masculin','Feminin') NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `date_enregistrement` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id`, `numero_patient`, `nom`, `prenom`, `sexe`, `date_naissance`, `adresse`, `telephone`, `date_enregistrement`) VALUES
(1, 'PAT-1782919283', 'zola', 'metho', 'Masculin', '2026-07-23', 'matadi', '0854792143', '2026-07-01 15:21:23');

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

CREATE TABLE `rendez_vous` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `medecin_id` int(11) NOT NULL,
  `date_rdv` date NOT NULL,
  `heure` time NOT NULL,
  `motif` varchar(255) DEFAULT NULL,
  `statut` enum('En attente','Confirmé','Annulé','Effectué') DEFAULT 'En attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`id`, `patient_id`, `medecin_id`, `date_rdv`, `heure`, `motif`, `statut`) VALUES
(1, 1, 4, '2026-07-24', '23:12:00', 'malade', 'Confirmé');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_consultation` (`patient_id`),
  ADD KEY `fk_medecin_consultation` (`medecin_id`),
  ADD KEY `fk_rdv_consultation` (`rendez_vous_id`);

--
-- Index pour la table `medecins`
--
ALTER TABLE `medecins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_patient` (`numero_patient`);

--
-- Index pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_rdv` (`patient_id`),
  ADD KEY `fk_medecin_rdv` (`medecin_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `medecins`
--
ALTER TABLE `medecins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `fk_medecin_consultation` FOREIGN KEY (`medecin_id`) REFERENCES `medecins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_consultation` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rdv_consultation` FOREIGN KEY (`rendez_vous_id`) REFERENCES `rendez_vous` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD CONSTRAINT `fk_medecin_rdv` FOREIGN KEY (`medecin_id`) REFERENCES `medecins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_rdv` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
