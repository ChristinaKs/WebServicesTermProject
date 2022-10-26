-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2022 at 06:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
  `GameProductCode` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Boxart` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `GameDescription` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MAPRating` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Version` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GameStudioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `GameId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamestudio`
--
ALTER TABLE `gamestudio`
  MODIFY `gamestudio` int(11) NOT NULL AUTO_INCREMENT;

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
