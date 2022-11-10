-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2022 at 03:36 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamingapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `GameId` int(11) NOT NULL,
  `GameName` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GameProductCode` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Boxart` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `GameDescription` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MPAARating` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Version` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GameStudioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`GameId`, `GameName`, `GameProductCode`, `Boxart`, `GameDescription`, `MPAARating`, `Platform`, `Version`, `GameStudioId`) VALUES
(1, 'League of Legends', NULL, '', 'League of Legends is a team-based strategy game where two teams of five powerful champions face off to destroy the other\'s base. Choose from over 140 champions to make epic plays, secure kills, and take down towers as you battle your way to victory.', 'T', 'GeForce Now, Microsoft Windows, macOS, Mac operating systems', '12.21', 1),
(2, 'Valorant', NULL, '', 'Valorant is a free-to-play first-person hero shooter developed and published by Riot Games, for Microsoft Windows. Teased under the codename Project A in October 2019, the game began a closed beta period with limited access on April 7, 2020, followed by a release on June 2, 2020. The development of the game started in 2014. Valorant takes inspiration from the Counter-Strike series of tactical shooters, borrowing several mechanics such as the buy menu, spray patterns, and inaccuracy while moving.', 'T', 'Microsoft Windows', '5.09', 1),
(3, 'FIFA 22', NULL, '', 'FIFA 22 is a football simulation video game published by Electronic Arts. It is the 29th installment in the FIFA series, and was released worldwide on 1 October 2021 for Microsoft Windows, Nintendo Switch, PlayStation 4, PlayStation 5, Xbox One and Xbox Series X/S.[1] Players who pre-ordered the ultimate edition, however, received four days of early access and were able to play the game from 27 September.', 'E', 'Microsoft Windows, Nintendo Switch, PlayStation 4, PlayStation 5, Stadia. Xbox One, Xbox Series X/S', 'Standard', 2),
(4, 'Just Dance', 'SDNP41', '', 'Just Dance is a motion-based dance video game for multiple players, with each game including a collection of classic and modern songs each with its own dance choreographies.', 'E10+', 'Wii, Wii U, PlayStation 3, PlayStation 4, PlayStation 5, Xbox 360, Xbox One, Xbox Series X/S, iOS, Android, Nintendo Switch, Microsoft Windows, macOS, Stadia', NULL, 3),
(5, 'Just Dance 2', 'SD2E41', '', 'Just Dance 2 is a 2010 dance rhythm game developed by Ubisoft Paris and Ubisoft Milan and published by Ubisoft. The game was released exclusively for the Wii on October 12, 2010, in North America and in Australia and Europe on October 14, 2010, as a sequel to Just Dance and the second main installment of the series.', 'E10+', 'Wii', '2', 3),
(6, 'Just Dance 3', 'SJDK41', '', 'Just Dance 3 is a 2011 dance rhythm game released on the Wii, Xbox 360, and PlayStation 3 with Kinect and Move support respectively for the latter two. It is part of the Just Dance video game series published by Ubisoft originally on the Wii and the third main installment of the series.', 'E10+', 'Wii, Xbox 360, PlayStation 3', '3', 3),
(7, 'Just Dance 4', 'SJXE41', '', 'Just Dance 4 is a 2012 music rhythm game developed and published by Ubisoft as the fourth main installment of the Just Dance series. Announced at E3 2012 by Flo Rida and Aisha Tyler, it was released on the Wii, the Wii U, the PlayStation 3 (with PlayStation Move), and the Xbox 360 (with Kinect). The Wii, PlayStation Move and Kinect versions were released on October 2, 2012 in Europe and Australia and on October 9, 2012 in North America, The Wii U version was released on November 18, 2012 in North America and on November 30, 2012 in Europe and Australia, as a launch title for the console.', 'E10+', 'Wii, Xbox 360, PlayStation 3, Wii U', '4', 3),
(8, 'Just Dance 2014', 'SJ7E41', '', 'Just Dance 2014 is a 2013 dance rhythm game developed by Ubisoft Paris, Ubisoft Milan, Ubisoft Reflections, Ubisoft Bucharest, Ubisoft Pune, Ubisoft Montpellier and Ubisoft Barcelona and published by Ubisoft. The fifth main installment of the Just Dance series, it was announced at Ubisoft\'s E3 2013 press event, and released for PlayStation 3, Xbox 360, Wii, and Wii U on 9 October 2013, and for PlayStation 4 and Xbox One as a launch title on 15 November and 22 November 2013 respectively.', 'E10+', 'PlayStation 3, Wii, Wii U, Xbox 360, PlayStation 4, Xbox One', '2014', 3),
(9, 'Super Mario Galaxy', 'RMGE01', '', 'Become Mario as he traverses gravity-bending galaxies, traveling in and out of gravitational fields by blasting from planet to planet.', 'E', 'Wii, Switch', '1', 5),
(10, 'Splatoon 3', 'AV5JA', '', 'Enter the Splatlands, a sun-scorched desert inhabited by battle-hardened Inklings and Octolings.', 'E10+', 'Switch', '1.2', 4),
(11, 'Counter-Strike: Global Offensive', '730', '', 'Counter-Strike: Global Offensive (CS: GO) expands upon the team-based action gameplay that it pioneered when it was launched 19 years ago.', 'T', 'PC (Steam), SteamDeck', '1.38.4.6', 6),
(12, 'Puyo Puyo Tsū', 'SHVCAXPJ', '', 'Stack and chain your Puyo combos to negate the Garbage puyos sent by your opponent.', '-', 'Super Famicom, Sega Saturn, PlayStation, PlayStation 2, Mega Drive, Game Gear, Game Boy, PC (CD-ROM), PC-98, PC Engine CD, Neo-Geo Pocket, WonderSwan, Wii, 3DS, PSOne Classics, Switch, Mega Drive Mini', '1', 7);

-- --------------------------------------------------------

--
-- Table structure for table `gamestudio`
--

CREATE TABLE `gamestudio` (
  `gamestudio` int(11) NOT NULL,
  `Developer` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Publisher` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StudioDescription` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Location` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gamestudio`
--

INSERT INTO `gamestudio` (`gamestudio`, `Developer`, `Publisher`, `StudioDescription`, `Location`) VALUES
(1, 'Riot Games', 'Riot Forge', 'Riot Games, Inc. is an American video game developer, publisher and esports tournament organizer based in Los Angeles, California. It was founded in September 2006 by Brandon Beck and Marc Merrill to develop League of Legends and went on to develop several spin-off games and the unrelated first-person shooter game Valorant. In 2011, Riot Games was acquired by Chinese conglomerate Tencent. Riot Games\' publishing arm, Riot Forge, oversees the production of League of Legends spin-offs by other developers. The company worked with Fortiche to release Arcane, a television series based on the League of Legends universe.', 'Los Angeles, United States'),
(2, 'Electronics Arts Inc.', 'EA Sports', 'Electronic Arts Inc. (EA) is an American video game company headquartered in Redwood City, California. Founded in May 1982 by Apple employee Trip Hawkins, the company was a pioneer of the early home computer game industry and promoted the designers and programmers responsible for its games as \"software artists.\" EA published numerous games and some productivity software for personal computers, all of which were developed by external individuals or groups until 1987\'s Skate or Die!. The company shifted toward internal game studios, often through acquisitions, such as Distinctive Software becoming EA Canada in 1991.', 'California, United States'),
(3, 'Ubisoft Paris', 'Ubisoft', 'Ubisoft Entertainment SA is a French video game company headquartered in Saint-Mandé with development studios across the world. Its video game franchises include Assassin\'s Creed, Far Cry, For Honor, Just Dance, Prince of Persia, Rabbids, Rayman, Tom Clancy\'s, and Watch Dogs.', 'Paris'),
(4, 'Nintendo', 'Nintendo EDP', 'Nintendo Entertainment Planning & Development Division, commonly abbreviated as Nintendo EPD, is the largest division within the Japanese video game company Nintendo. ', 'Kyoto, Japan'),
(5, 'Nintendo', 'Nintendo EAD', 'Nintendo Entertainment Analysis & Development Division, commonly abbreviated as Nintendo EAD and formerly known as Nintendo Research & Development No.4 Department.', 'Kyoto, Japan'),
(6, 'Valve', 'Hidden Path Entertainment', 'Valve Corporation is an American video game developer, publisher, and digital distribution company headquartered in Bellevue, Washington.', 'Washington, United States'),
(7, 'Compile', 'Compile', 'Compile Co., Ltd. (株式会社コンパイル Kabushiki-gaisha Konpairu) was a video game software developer founded on April 7, 1982. The company, originally known as Programmers-3', 'Japan');

-- --------------------------------------------------------

--
-- Table structure for table `gtsitem`
--

CREATE TABLE `gtsitem` (
  `GtsId` int(11) NOT NULL,
  `OwnedId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owneditem`
--

CREATE TABLE `owneditem` (
  `OwnedId` int(11) NOT NULL,
  `isForTrade` tinyint(4) NOT NULL,
  `TradeLink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReviewId` int(11) NOT NULL,
  `GameId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `RatingId` int(11) NOT NULL,
  `Rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewId` int(11) NOT NULL,
  `RatingId` int(11) NOT NULL,
  `PosOrNeg` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Review` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `traderequest`
--

CREATE TABLE `traderequest` (
  `RequestId` int(11) NOT NULL,
  `GtsId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AcceptedOrDenied` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserId` int(11) NOT NULL,
  `Email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ContactInfo` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlistitem`
--

CREATE TABLE `wishlistitem` (
  `WishlistId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `GameId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`GameId`),
  ADD KEY `FKgamestudio` (`GameStudioId`);

--
-- Indexes for table `gamestudio`
--
ALTER TABLE `gamestudio`
  ADD PRIMARY KEY (`gamestudio`);

--
-- Indexes for table `gtsitem`
--
ALTER TABLE `gtsitem`
  ADD PRIMARY KEY (`GtsId`),
  ADD KEY `FKownedid` (`OwnedId`),
  ADD KEY `FKuserid` (`UserId`);

--
-- Indexes for table `owneditem`
--
ALTER TABLE `owneditem`
  ADD PRIMARY KEY (`OwnedId`),
  ADD KEY `FKreviewid` (`ReviewId`),
  ADD KEY `FKuserid2` (`UserId`),
  ADD KEY `Fkgameid2` (`GameId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`RatingId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewId`),
  ADD KEY `FKratingid` (`RatingId`);

--
-- Indexes for table `traderequest`
--
ALTER TABLE `traderequest`
  ADD PRIMARY KEY (`RequestId`),
  ADD KEY `FKgtsid` (`GtsId`),
  ADD KEY `FKuserid3` (`UserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `wishlistitem`
--
ALTER TABLE `wishlistitem`
  ADD PRIMARY KEY (`WishlistId`),
  ADD KEY `FKgameid3` (`GameId`),
  ADD KEY `FKuserId4` (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `GameId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gamestudio`
--
ALTER TABLE `gamestudio`
  MODIFY `gamestudio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gtsitem`
--
ALTER TABLE `gtsitem`
  MODIFY `GtsId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owneditem`
--
ALTER TABLE `owneditem`
  MODIFY `OwnedId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `RatingId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `traderequest`
--
ALTER TABLE `traderequest`
  MODIFY `RequestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlistitem`
--
ALTER TABLE `wishlistitem`
  MODIFY `WishlistId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `FKgamestudio` FOREIGN KEY (`GameStudioId`) REFERENCES `gamestudio` (`gamestudio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gtsitem`
--
ALTER TABLE `gtsitem`
  ADD CONSTRAINT `FKownedid` FOREIGN KEY (`OwnedId`) REFERENCES `owneditem` (`OwnedId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKuserid` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `owneditem`
--
ALTER TABLE `owneditem`
  ADD CONSTRAINT `FKreviewid` FOREIGN KEY (`ReviewId`) REFERENCES `review` (`ReviewId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKuserid2` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fkgameid2` FOREIGN KEY (`GameId`) REFERENCES `game` (`GameId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `FKratingid` FOREIGN KEY (`RatingId`) REFERENCES `rating` (`RatingId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `traderequest`
--
ALTER TABLE `traderequest`
  ADD CONSTRAINT `FKgtsid` FOREIGN KEY (`GtsId`) REFERENCES `gtsitem` (`GtsId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKuserid3` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlistitem`
--
ALTER TABLE `wishlistitem`
  ADD CONSTRAINT `FKgameid3` FOREIGN KEY (`GameId`) REFERENCES `game` (`GameId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKuserId4` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
