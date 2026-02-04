-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 04 fév. 2026 à 18:36
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gameshop_db`
--
CREATE DATABASE IF NOT EXISTS `gameshop_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gameshop_db`;

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `date_transaction` datetime DEFAULT current_timestamp(),
  `montant` decimal(10,2) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `invoice`
--

INSERT INTO `invoice` (`id`, `id_user`, `date_transaction`, `montant`, `adresse`, `ville`, `code_postal`) VALUES
(3, 1, '2026-01-12 14:48:35', 19.99, '123 Rue du Jeu', 'Paris', '75000'),
(4, 1, '2026-01-12 14:48:45', 29.99, '123 Rue du Jeu', 'Paris', '75000'),
(5, 1, '2026-01-12 14:50:01', 19.99, 'Adresse par defaut', 'Ville', '00000'),
(6, 1, '2026-01-12 14:50:10', 49.99, 'Adresse par defaut', 'Ville', '00000'),
(7, 1, '2026-01-12 14:52:07', 29.99, 'Adresse par defaut', 'Ville', '00000'),
(8, 1, '2026-01-12 15:00:13', 249.95, 'Adresse par defaut', 'Ville', '00000'),
(9, 1, '2026-01-13 11:54:54', 29.99, 'Adresse par defaut', 'Ville', '00000'),
(10, 1, '2026-01-13 11:57:48', 29.99, 'Adresse par defaut', 'Ville', '00000'),
(11, 1, '2026-02-04 12:35:37', 69.99, 'Adresse par defaut', 'Ville', '00000');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_publication` datetime DEFAULT current_timestamp(),
  `plateforme` varchar(50) NOT NULL DEFAULT 'PC',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `nom`, `description`, `prix`, `image`, `date_publication`, `plateforme`) VALUES
(9, 'Clair Obscur: Expedition 33', 'Clair Obscur: Expedition 33 est un RPG français au tour par tour qui se distingue par son univers sombre inspiré de la Belle Époque et ses graphismes sous Unreal Engine 5. Le scénario suit Gustave et ses compagnons dans une mission désespérée pour détruire la « Peintresse », une entité qui efface chaque année les personnes ayant atteint un certain âge (le nombre 33 étant le prochain sur la liste). Le gameplay innove en intégrant des actions en temps réel (esquives, parades, contres) au sein des combats tactiques, offrant une expérience dynamique saluée pour sa direction artistique et sa narration poignante.', 49.99, 'game_6964f651ef6b1.jpg', '2026-01-12 14:25:37', 'PC, Playstation, Xbox'),
(10, 'Légendes Pokémon : Z-A', 'Légendes Pokémon : Z-A est un RPG d\'action-aventure qui se déroule intégralement au sein d\'une Illumis en pleine reconstruction urbaine, visant à instaurer une cohabitation pacifique entre humains et Pokémon. Second volet de la lignée Légendes, il introduit un système de combat dynamique en temps réel et marque le grand retour de la Méga-Évolution pour faire face aux Pokémon \"Méga-Féroces\" qui sèment le chaos en ville. Le joueur y rejoint la Team MZ pour enquêter sur les mystères entourant le Pokémon légendaire Zygarde, tout en progressant dans les échelons du Club de Combat Z-A.', 69.99, 'game_6964f67a60b73.jpg', '2026-01-12 14:26:18', 'Nintendo'),
(11, 'INAZUMA ELEVEN: Victory Road', 'Inazuma Eleven: Victory Road est un RPG de football développé par Level-5 qui marque le renouveau de la franchise en se déroulant 25 ans après l\'ère de Mark Evans. Le jeu suit l\'histoire de Destin Billows, un nouveau protagoniste qui tente de reconstruire un club de football à Nagasaki pour défier le fils de Mark, tout en proposant un immense \"Mode Chronique\" permettant de recruter plus de 4 500 personnages issus de toute la saga. Alliant stratégie et action avec des animations signées par le studio MAPPA, cet opus propose un gameplay modernisé (système de Focus, Zone de tir) disponible sur consoles et PC.', 69.99, 'game_6964f6a704d77.jpg', '2026-01-12 14:27:03', 'PC, Playstation, Xbox, Nintendo'),
(12, 'Minecraft', 'Minecraft est un jeu de type « bac à sable » emblématique qui plonge le joueur dans un monde infini généré de manière procédurale, entièrement composé de blocs destructibles. Fondé sur la survie et la créativité, il permet d\'extraire des ressources, de fabriquer des outils et de bâtir des structures monumentales tout en se protégeant de créatures nocturnes. Devenu le jeu le plus vendu de l\'histoire, il se décline aujourd\'hui en deux versions principales (Java et Bedrock) et propose une liberté totale, que ce soit à travers l\'exploration de dimensions parallèles comme l\'Ender ou via des serveurs multijoueurs communautaires aux modes de jeux variés.', 29.99, 'game_6964f7831a6f5.jpg', '2026-01-12 14:30:43', 'PC, Playstation, Xbox, Nintendo'),
(13, 'Hollow Knight: Silksong', 'Hollow Knight: Silksong est la suite très attendue du célèbre Metroidvania de Team Cherry, où l\'on incarne Hornet, la princesse protectrice de Hallownest, capturée et emmenée dans le royaume inconnu de Pharloom. Contrairement au premier opus axé sur la descente, ce jeu propose une ascension vers le sommet d\'une citadelle étincelante à travers un monde régi par la soie et le chant, peuplé de plus de 150 nouveaux ennemis. Le gameplay gagne en verticalité et en vitesse grâce à l\'agilité d\'Hornet, qui utilise des outils artisanaux et des capacités acrobatiques pour explorer des biomes détaillés comme des forêts de corail ou des cités dorées, le tout porté par une bande-son orchestrale mélancolique.', 19.99, 'game_6964f868e009c.jpg', '2026-01-12 14:34:32', 'PC, Playstation, Xbox, Nintendo'),
(14, 'Just Dance 2026', 'Just Dance 2026 Edition est le dernier volet de la célèbre franchise de rythme d\'Ubisoft, proposant une playlist de 40 nouveaux titres allant des tubes actuels (comme Lady Gaga ou Dua Lipa) aux classiques intemporels. Cette édition introduit un nouveau \"Mode Party\" avec des défis imprévisibles et un mode \"Contrôleur Caméra\" sur smartphone pour suivre les mouvements sans accessoire supplémentaire. Intégré à une plateforme unique regroupant les contenus des années précédentes, le jeu propose également le retour du mode Entraînement pour le fitness et un accès au service par abonnement Just Dance+ pour étendre son catalogue à des centaines de morceaux.', 49.99, 'game_6964f952b1e68.jpg', '2026-01-12 14:38:26', 'PC, Playstation, Xbox, Nintendo'),
(15, 'The Legend of Zelda : Tears of the Kingdom', 'The Legend of Zelda: Tears of the Kingdom est la suite directe de Breath of the Wild, reprenant le vaste monde d\'Hyrule tout en l\'étendant verticalement avec des îles célestes et des profondeurs souterraines mystérieuses. Le jeu révolutionne l\'exploration grâce aux nouveaux pouvoirs de Link, notamment l\'Emprise, qui permet de construire des véhicules et des machines complexes, et l\'Amalgame, servant à fusionner des objets pour créer des armes uniques. Cette aventure épique centrée sur la reconstruction du royaume et la recherche de la princesse Zelda est saluée pour sa liberté créative sans précédent, offrant aux joueurs des outils quasi infinis pour résoudre des énigmes et parcourir un monde riche en secrets.', 69.99, 'game_69650058512ab.jpg', '2026-01-12 15:08:24', 'Nintendo'),
(16, 'Grand Theft Auto V', 'Grand Theft Auto V est un monument du jeu en monde ouvert qui suit les destins croisés de trois criminels — Michael, Franklin et Trevor — dans la métropole tentaculaire de Los Santos. Le titre mêle habilement braquages spectaculaires, narration satirique de la société américaine et une liberté d\'action quasi absolue, permettant de passer d\'un personnage à l\'autre à tout moment. En plus de sa campagne solo culte, il intègre GTA Online, un univers multijoueur persistant en constante évolution où les joueurs peuvent bâtir leur propre empire criminel à travers une multitude d\'activités, de courses et de missions en coopération.', 19.99, 'game_6965fa7091e25.jpg', '2026-01-13 08:55:28', 'PC, Playstation, Xbox'),
(17, 'Mario Kart World', 'Mario Kart World est le dernier épisode majeur de la série, sorti le 5 juin 2025 comme titre de lancement de la Nintendo Switch 2. Pour la première fois dans la franchise, le jeu propose une structure en monde ouvert où les circuits sont physiquement interconnectés par des routes explorables en \"Mode Balade\". Le gameplay s\'enrichit de nouvelles mécaniques comme le saut chargé et le \"grind\" sur rails, tout en doublant le nombre de participants avec des courses en ligne allant jusqu\'à 24 joueurs. Il propose également un mode \"Survie\" (Knockout) où les pilotes les plus lents sont éliminés à chaque point de passage dans un flux continu de carapaces et d\'action.', 79.99, 'game_6965fade5c18e.jpg', '2026-01-13 08:57:18', 'Nintendo'),
(18, 'Balatro', 'Balatro est un roguelike de deckbuilding hypnotique qui réinvente les règles du poker en y ajoutant des mécaniques de triche stratégiques. Le but est d\'accumuler des points en jouant des mains classiques, tout en les boostant grâce à plus de 150 Jokers aux pouvoirs uniques, des cartes de Tarot et des planètes qui créent des combos dévastateurs. Salué pour son aspect extrêmement addictif et sa direction artistique rétro \"CRT\", le jeu propose une rejouabilité infinie où chaque tentative permet de débloquer de nouveaux secrets et de perfectionner ses synergies pour vaincre des mises (blinds) toujours plus élevées.', 19.99, 'game_6965fb7a7a29a.jpg', '2026-01-13 08:59:54', 'PC, Playstation, Xbox, Nintendo'),
(20, 'Fortnite : Sauver le monde', 'Fortnite : Sauver le monde est le mode de jeu originel de type action-building et défense de base en coopération, où les joueurs s\'unissent pour repousser des hordes de monstres appelés \"Carapateurs\". Après qu\'une mystérieuse tempête a fait disparaître 98 % de la population, vous devez récolter des ressources, explorer des cartes générées aléatoirement et construire des fortifications truffées de pièges pour protéger des objectifs stratégiques. Le jeu propose une progression riche basée sur la collection de héros, l\'amélioration d\'un arbre de talents complexe et la fabrication d\'armes artisanales, offrant une expérience plus tactique et narrative que son pendant Battle Royale.', 19.99, 'game_6965ffcb8fd27.jpg', '2026-01-13 09:18:19', 'PC, Playstation, Xbox'),
(21, 'Hogwarts Legacy : L\'Héritage de Poudlard', 'Hogwarts Legacy : L\'Héritage de Poudlard est un RPG d\'action-aventure en monde ouvert qui vous plonge dans l\'univers d\'Harry Potter à la fin des années 1800. Vous y incarnez un étudiant de cinquième année possédant le don rare de maîtriser une magie ancienne, vous permettant d\'explorer librement le château de Poudlard, le village de Pré-au-Lard et les contrées environnantes tout en suivant des cours et en affrontant une rébellion de gobelins. Le système de jeu repose sur des combats dynamiques à la baguette, la personnalisation de votre sorcier (maison, talents, potions) et l\'interaction avec des créatures fantastiques, offrant une immersion totale dans le monde des sorciers bien avant les événements des livres originaux.', 29.99, 'game_696600a835e2c.jpg', '2026-01-13 09:22:00', 'PC, Playstation, Xbox, Nintendo'),
(22, 'The Legend of Zelda: Breath of the Wild', 'The Legend of Zelda: Breath of the Wild a révolutionné le jeu d\'aventure en monde ouvert en offrant une liberté totale d\'exploration au sein d\'un royaume d\'Hyrule dévasté. Dans la peau de Link, qui s\'éveille après un sommeil de cent ans, vous devez parcourir des paysages variés et sauvages pour affronter le Fléau Ganon, avec pour seule limite votre curiosité. Le gameplay repose sur une physique réaliste, une gestion de la température et l\'interaction avec l\'environnement (escalade de toutes les surfaces, cuisine, utilisation des pouvoirs de la tablette Sheikah), faisant de chaque énigme et combat une expérience unique et organique.', 69.99, 'game_696603afd6cc1.jpg', '2026-01-13 09:34:55', 'Nintendo'),
(23, 'Split Fiction', 'Split Fiction est le dernier jeu d\'aventure exclusivement coopératif de Hazelight Studios (It Takes Two), où deux joueurs incarnent Mio et Zoé, des écrivaines rivales piégées dans leurs propres récits. Le gameplay se renouvelle constamment en alternant entre des univers de science-fiction et de fantasy, chaque niveau introduisant des mécaniques uniques allant du vol à dos de dragon au pilotage de robots, tout en utilisant le système de \"Pass Ami\" pour jouer gratuitement avec un proche. Salué pour sa narration poignante sur l\'amitié et sa créativité visuelle sous Unreal Engine 5, le titre impose une collaboration totale pour résoudre des énigmes et surmonter des séquences d\'action variées.', 39.99, 'game_696627abaf2d8.jpg', '2026-01-13 12:08:27', 'PC, Playstation, Xbox, Nintendo'),
(24, 'Monster Hunter Wilds', 'Monster Hunter Wilds est l\'évolution majeure de la série d\'action-RPG de Capcom, plongeant les chasseurs dans les Terres Interdites, un monde ouvert organique aux écosystèmes dynamiques qui changent radicalement selon la météo. Le gameplay se fluidifie grâce à la monture \"Seikret\", qui permet de combattre et de changer d\'arme en plein mouvement, tout en introduisant le mode \"Focus\" pour cibler précisément les points faibles des monstres gigantesques. Avec ses troupeaux de créatures massives et ses transitions sans chargement entre le village et la chasse, cet opus mise sur une immersion totale et une coopération en ligne cross-play pour traquer des prédateurs toujours plus redoutables.', 59.99, 'game_696f3ae24284e.jpg', '2026-01-20 09:20:50', 'PC, Playstation, Xbox'),
(25, 'Astro Bot', 'Astro Bot est un jeu de plateforme 3D exclusif à la PlayStation 5 qui célèbre les 30 ans d\'histoire de la marque à travers une aventure colorée et inventive. Vous y incarnez le petit robot Astro qui doit explorer plus de 50 mondes variés pour secourir son équipage dispersé et réparer son vaisseau-mère (une PS5 géante) après une attaque galactique. Le jeu est particulièrement reconnu pour son utilisation magistrale de la manette DualSense, offrant des sensations tactiles uniques, ainsi que pour ses nombreux caméos de personnages cultes de l\'univers PlayStation transformés en robots.', 44.99, 'game_696f3c948e4fd.jpeg', '2026-01-20 09:28:04', 'Playstation'),
(26, 'Cyberpunk 2077', 'Cyberpunk 2077 est un RPG d\'action en monde ouvert situé à Night City, une mégalopole futuriste obsédée par le pouvoir et les modifications corporelles. Vous incarnez V, un mercenaire cherchant un implant unique qui détient la clé de l\'immortalité, tout en cohabitant avec le fantôme numérique du rockeur rebelle Johnny Silverhand (joué par Keanu Reeves). Depuis sa refonte complète et l\'extension Phantom Liberty, le jeu propose des combats intenses, une narration profonde à choix multiples et un système de compétences (Cyberwares) ultra-poussé, offrant une expérience immersive au sommet de la science-fiction moderne.', 69.99, 'game_696f46042080f.jpeg', '2026-01-20 10:08:20', 'PC, Playstation, Xbox, Nintendo'),
(27, 'Marvel\'s Spider Man 2', 'Marvel\'s Spider-Man 2 est un jeu d\'action-aventure spectaculaire qui permet d\'incarner alternativement Peter Parker et Miles Morales pour protéger un New York étendu (incluant Brooklyn et le Queens). L\'histoire est centrée sur la menace brutale de Kraven le Chasseur et l\'arrivée du symbiote Venom, qui vient tester le lien entre les deux héros et corrompre les pouvoirs de Peter. Le gameplay sublime la navigation urbaine avec les \"Ailes de toile\" et propose des combats dynamiques utilisant les bras mécaniques, les pouvoirs bio-électriques et les capacités dévastatrices du costume noir, le tout sans aucun temps de chargement.', 69.99, 'game_696f4704a3e04.jpeg', '2026-01-20 10:12:36', 'PC, Playstation');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `date_commande` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `id_item`, `date_commande`) VALUES
(3, 1, 13, '2026-01-12 14:48:35'),
(4, 1, 12, '2026-01-12 14:48:45'),
(5, 1, 13, '2026-01-12 14:50:01'),
(6, 1, 14, '2026-01-12 14:50:10'),
(7, 1, 12, '2026-01-12 14:52:07'),
(8, 1, 9, '2026-01-12 15:00:13'),
(9, 1, 21, '2026-01-13 11:54:54'),
(10, 1, 21, '2026-01-13 11:57:48'),
(11, 1, 11, '2026-02-04 12:35:37');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `id_item`, `quantite`) VALUES
(9, 9, 5),
(10, 10, 100),
(11, 11, 99),
(12, 12, 98),
(13, 13, 98),
(14, 14, 99),
(15, 15, 100),
(16, 16, 100),
(17, 17, 50),
(18, 18, 15),
(20, 20, 5),
(21, 21, 28),
(22, 22, 0),
(23, 23, 200),
(24, 24, 70),
(25, 25, 20),
(26, 26, 50),
(27, 27, 30);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `email`, `password`, `role`) VALUES
(1, 'maxime_loprin', 'maximeloprin@gmail.com', '$2y$10$jSaRutBWl.IAkAM2mx/Yf.3hz26lnfvKIZNcrbfAbFLIhVB6UIfz2', 'admin'),
(3, 'MaximeLoprin', 'maximeloprin@icloud.com', '$2y$10$p1rRbtbjBzJ8wkQdZvcMMuH/7YMfdlmsCx94BmGlMyFDSL4bMzA6m', 'user');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `items` (`id`);

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
