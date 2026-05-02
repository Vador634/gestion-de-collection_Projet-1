-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 23 sep. 2025 à 14:13
-- Version du serveur : 10.3.39-MariaDB-0+deb10u1
-- Version de PHP : 7.3.31-1~deb10u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `GestionDeCollection`
--

-- --------------------------------------------------------

--
-- Structure de la table `Appartient`
--

CREATE TABLE `Appartient` (
  `idCollection` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL,
  `dateAjout` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Collection`
--

CREATE TABLE `Collection` (
  `idCollection` int(11) NOT NULL,
  `nomCollection` varchar(100) NOT NULL,
  `dateCreation` date NOT NULL,
  `notePerso` text DEFAULT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ConditionJeu`
--

CREATE TABLE `ConditionJeu` (
  `idCondition` int(11) NOT NULL,
  `libelleCondition` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Console`
--

CREATE TABLE `Console` (
  `idConsole` int(11) NOT NULL,
  `nomConsole` varchar(100) NOT NULL,
  `fabricant` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Developpeur`
--

CREATE TABLE `Developpeur` (
  `idDeveloppeur` int(11) NOT NULL,
  `libelleDeveloppeur` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Disponible`
--

CREATE TABLE `Disponible` (
  `idConsole` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Edite`
--

CREATE TABLE `Edite` (
  `idEditeur` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Editeur`
--

CREATE TABLE `Editeur` (
  `idEditeur` int(11) NOT NULL,
  `libelleEditeur` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Genre`
--

CREATE TABLE `Genre` (
  `idGenre` int(11) NOT NULL,
  `libelleGenre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GenreJeu`
--

CREATE TABLE `GenreJeu` (
  `idGenre` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Jeu`
--

CREATE TABLE `Jeu` (
  `idJeu` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `anneeSortie` year(4) DEFAULT NULL,
  `prixEstime` decimal(10,2) DEFAULT NULL,
  `idCondition` int(11) DEFAULT NULL,
  `idRarete` int(11) DEFAULT NULL,
  `idDeveloppeur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `JeuLangue`
--

CREATE TABLE `JeuLangue` (
  `idLangue` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `JeuModeDeJeu`
--

CREATE TABLE `JeuModeDeJeu` (
  `idModeDeJeu` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Langue`
--

CREATE TABLE `Langue` (
  `idLangue` int(11) NOT NULL,
  `libelleLangue` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ModeDeJeu`
--

CREATE TABLE `ModeDeJeu` (
  `idModeDeJeu` int(11) NOT NULL,
  `libelleModeDeJeu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Rarete`
--

CREATE TABLE `Rarete` (
  `idRarete` int(11) NOT NULL,
  `libelleRarete` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `mailUtilisateur` varchar(100) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Appartient`
--
ALTER TABLE `Appartient`
  ADD PRIMARY KEY (`idCollection`,`idJeu`),
  ADD KEY `idJeu` (`idJeu`);

--
-- Index pour la table `Collection`
--
ALTER TABLE `Collection`
  ADD PRIMARY KEY (`idCollection`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `ConditionJeu`
--
ALTER TABLE `ConditionJeu`
  ADD PRIMARY KEY (`idCondition`);

--
-- Index pour la table `Console`
--
ALTER TABLE `Console`
  ADD PRIMARY KEY (`idConsole`);

--
-- Index pour la table `Developpeur`
--
ALTER TABLE `Developpeur`
  ADD PRIMARY KEY (`idDeveloppeur`);

--
-- Index pour la table `Disponible`
--
ALTER TABLE `Disponible`
  ADD PRIMARY KEY (`idConsole`,`idJeu`),
  ADD KEY `idJeu` (`idJeu`);

--
-- Index pour la table `Edite`
--
ALTER TABLE `Edite`
  ADD PRIMARY KEY (`idEditeur`,`idJeu`),
  ADD KEY `idJeu` (`idJeu`);

--
-- Index pour la table `Editeur`
--
ALTER TABLE `Editeur`
  ADD PRIMARY KEY (`idEditeur`);

--
-- Index pour la table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`idGenre`);

--
-- Index pour la table `GenreJeu`
--
ALTER TABLE `GenreJeu`
  ADD PRIMARY KEY (`idGenre`,`idJeu`),
  ADD KEY `idJeu` (`idJeu`);

--
-- Index pour la table `Jeu`
--
ALTER TABLE `Jeu`
  ADD PRIMARY KEY (`idJeu`),
  ADD KEY `idCondition` (`idCondition`),
  ADD KEY `idRarete` (`idRarete`),
  ADD KEY `idDeveloppeur` (`idDeveloppeur`);

--
-- Index pour la table `JeuLangue`
--
ALTER TABLE `JeuLangue`
  ADD PRIMARY KEY (`idLangue`,`idJeu`),
  ADD KEY `idJeu` (`idJeu`);

--
-- Index pour la table `JeuModeDeJeu`
--
ALTER TABLE `JeuModeDeJeu`
  ADD PRIMARY KEY (`idModeDeJeu`,`idJeu`),
  ADD KEY `idJeu` (`idJeu`);

--
-- Index pour la table `Langue`
--
ALTER TABLE `Langue`
  ADD PRIMARY KEY (`idLangue`);

--
-- Index pour la table `ModeDeJeu`
--
ALTER TABLE `ModeDeJeu`
  ADD PRIMARY KEY (`idModeDeJeu`);

--
-- Index pour la table `Rarete`
--
ALTER TABLE `Rarete`
  ADD PRIMARY KEY (`idRarete`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `mailUtilisateur` (`mailUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Collection`
--
ALTER TABLE `Collection`
  MODIFY `idCollection` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ConditionJeu`
--
ALTER TABLE `ConditionJeu`
  MODIFY `idCondition` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Console`
--
ALTER TABLE `Console`
  MODIFY `idConsole` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Developpeur`
--
ALTER TABLE `Developpeur`
  MODIFY `idDeveloppeur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Editeur`
--
ALTER TABLE `Editeur`
  MODIFY `idEditeur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Genre`
--
ALTER TABLE `Genre`
  MODIFY `idGenre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Jeu`
--
ALTER TABLE `Jeu`
  MODIFY `idJeu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Langue`
--
ALTER TABLE `Langue`
  MODIFY `idLangue` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ModeDeJeu`
--
ALTER TABLE `ModeDeJeu`
  MODIFY `idModeDeJeu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Rarete`
--
ALTER TABLE `Rarete`
  MODIFY `idRarete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Appartient`
--
ALTER TABLE `Appartient`
  ADD CONSTRAINT `Appartient_ibfk_1` FOREIGN KEY (`idCollection`) REFERENCES `Collection` (`idCollection`),
  ADD CONSTRAINT `Appartient_ibfk_2` FOREIGN KEY (`idJeu`) REFERENCES `Jeu` (`idJeu`);

--
-- Contraintes pour la table `Collection`
--
ALTER TABLE `Collection`
  ADD CONSTRAINT `Collection_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `Disponible`
--
ALTER TABLE `Disponible`
  ADD CONSTRAINT `Disponible_ibfk_1` FOREIGN KEY (`idConsole`) REFERENCES `Console` (`idConsole`),
  ADD CONSTRAINT `Disponible_ibfk_2` FOREIGN KEY (`idJeu`) REFERENCES `Jeu` (`idJeu`);

--
-- Contraintes pour la table `Edite`
--
ALTER TABLE `Edite`
  ADD CONSTRAINT `Edite_ibfk_1` FOREIGN KEY (`idEditeur`) REFERENCES `Editeur` (`idEditeur`),
  ADD CONSTRAINT `Edite_ibfk_2` FOREIGN KEY (`idJeu`) REFERENCES `Jeu` (`idJeu`);

--
-- Contraintes pour la table `GenreJeu`
--
ALTER TABLE `GenreJeu`
  ADD CONSTRAINT `GenreJeu_ibfk_1` FOREIGN KEY (`idGenre`) REFERENCES `Genre` (`idGenre`),
  ADD CONSTRAINT `GenreJeu_ibfk_2` FOREIGN KEY (`idJeu`) REFERENCES `Jeu` (`idJeu`);

--
-- Contraintes pour la table `Jeu`
--
ALTER TABLE `Jeu`
  ADD CONSTRAINT `Jeu_ibfk_1` FOREIGN KEY (`idCondition`) REFERENCES `ConditionJeu` (`idCondition`),
  ADD CONSTRAINT `Jeu_ibfk_2` FOREIGN KEY (`idRarete`) REFERENCES `Rarete` (`idRarete`),
  ADD CONSTRAINT `Jeu_ibfk_3` FOREIGN KEY (`idDeveloppeur`) REFERENCES `Developpeur` (`idDeveloppeur`);

--
-- Contraintes pour la table `JeuLangue`
--
ALTER TABLE `JeuLangue`
  ADD CONSTRAINT `JeuLangue_ibfk_1` FOREIGN KEY (`idLangue`) REFERENCES `Langue` (`idLangue`),
  ADD CONSTRAINT `JeuLangue_ibfk_2` FOREIGN KEY (`idJeu`) REFERENCES `Jeu` (`idJeu`);

--
-- Contraintes pour la table `JeuModeDeJeu`
--
ALTER TABLE `JeuModeDeJeu`
  ADD CONSTRAINT `JeuModeDeJeu_ibfk_1` FOREIGN KEY (`idModeDeJeu`) REFERENCES `ModeDeJeu` (`idModeDeJeu`),
  ADD CONSTRAINT `JeuModeDeJeu_ibfk_2` FOREIGN KEY (`idJeu`) REFERENCES `Jeu` (`idJeu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
