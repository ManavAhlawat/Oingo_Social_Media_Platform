-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2018 at 04:15 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oingo`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `FN_GET_DISTANCE`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `FN_GET_DISTANCE` (`lat1` DOUBLE, `lng1` DOUBLE, `lat2` DOUBLE, `lng2` DOUBLE) RETURNS DOUBLE BEGIN
    DECLARE radlat1 DOUBLE;
    DECLARE radlat2 DOUBLE;
    DECLARE theta DOUBLE;
    DECLARE radtheta DOUBLE;
    DECLARE dist DOUBLE;
    SET radlat1 = PI() * lat1 / 180;
    SET radlat2 = PI() * lat2 / 180;
    SET theta = lng1 - lng2;
    SET radtheta = PI() * theta / 180;
    SET dist = sin(radlat1) * sin(radlat2) + cos(radlat1) * cos(radlat2) * cos(radtheta);
    SET dist = acos(dist);
    SET dist = dist * 180 / PI();
    SET dist = dist * 60 * 1.1515;
    SET dist = dist * 1.609344;
RETURN dist;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_on_note`
--

DROP TABLE IF EXISTS `comment_on_note`;
CREATE TABLE IF NOT EXISTS `comment_on_note` (
  `NoteCommentID` int(11) NOT NULL,
  `NoteID` int(11) NOT NULL,
  KEY `NoteCommentID` (`NoteCommentID`),
  KEY `NoteID` (`NoteID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment_on_note`
--

INSERT INTO `comment_on_note` (`NoteCommentID`, `NoteID`) VALUES
(1, 3),
(2, 1),
(2, 4),
(3, 3),
(3, 5),
(4, 2),
(5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `filter`
--

DROP TABLE IF EXISTS `filter`;
CREATE TABLE IF NOT EXISTS `filter` (
  `filter_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tagid` int(11) DEFAULT NULL,
  `userstate` varchar(50) NOT NULL,
  `user_type` enum('Friends','Public') NOT NULL DEFAULT 'Public',
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `current_latitude` decimal(10,8) DEFAULT NULL,
  `current_longitude` decimal(11,8) DEFAULT NULL,
  `radius_of_interest` int(11) DEFAULT '1',
  PRIMARY KEY (`filter_id`),
  KEY `tagid` (`tagid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `filter`
--

INSERT INTO `filter` (`filter_id`, `uid`, `tagid`, `userstate`, `user_type`, `date`, `time`, `current_latitude`, `current_longitude`, `radius_of_interest`) VALUES
(1, 2, 4, 'at work', 'Public', '2018-10-15', '01:30:00', '0.70947638', '-1.29067093', 1),
(2, 3, 1, 'lunch break', 'Friends', '2018-10-15', '01:30:00', '0.70947638', '-1.29067093', 2),
(3, 4, 3, 'just chilling', 'Friends', '2018-09-17', '05:00:00', '0.71108299', '-1.28751921', 3),
(4, 1, 5, 'getting bored', 'Public', '2018-06-24', '04:00:00', '0.70947638', '-1.29067093', 5),
(5, 2, 2, 'at work', 'Public', '2018-08-06', '06:00:00', '0.69984212', '0.90970226', 4);

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

DROP TABLE IF EXISTS `friend_list`;
CREATE TABLE IF NOT EXISTS `friend_list` (
  `UID` int(11) NOT NULL,
  `Friend_Id` int(11) NOT NULL,
  `Action` enum('Accepted','Rejected','Request_Sent') NOT NULL DEFAULT 'Request_Sent',
  KEY `UID` (`UID`),
  KEY `Friend_Id` (`Friend_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`UID`, `Friend_Id`, `Action`) VALUES
(1, 2, 'Accepted'),
(1, 3, 'Rejected'),
(3, 2, 'Accepted'),
(4, 1, 'Request_Sent'),
(5, 3, 'Rejected'),
(6, 4, 'Accepted'),
(4, 5, 'Accepted'),
(1, 6, 'Request_Sent');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `LocID` int(11) NOT NULL AUTO_INCREMENT,
  `AreaName` varchar(50) DEFAULT NULL,
  `Latitude` decimal(10,8) NOT NULL,
  `Longitude` decimal(10,8) NOT NULL,
  `radius_of_interest` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`LocID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocID`, `AreaName`, `Latitude`, `Longitude`, `radius_of_interest`) VALUES
(1, 'Bayridge', '0.17624335', '0.38610348', 1),
(2, 'Dumbo', '0.52530920', '1.25876811', 3),
(3, 'Soho', '1.04890797', '0.21157056', 4),
(4, 'Chelsea', '0.69984212', '0.90970226', 2),
(5, 'Astoria', '0.59512237', '0.47336995', 5),
(6, 'NYU', '0.71025139', '-1.29130846', 2);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `NoteID` int(11) NOT NULL AUTO_INCREMENT,
  `SchID` int(11) NOT NULL,
  `NoteContent` varchar(255) DEFAULT NULL,
  `UID` int(11) NOT NULL,
  `locid` int(11) NOT NULL,
  `Shared_With` enum('Friends','Public') NOT NULL DEFAULT 'Public',
  `TimeStamp` time NOT NULL,
  `Are_comments_allowed` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`NoteID`),
  KEY `UID` (`UID`),
  KEY `locid` (`locid`),
  KEY `SchID` (`SchID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`NoteID`, `SchID`, `NoteContent`, `UID`, `locid`, `Shared_With`, `TimeStamp`, `Are_comments_allowed`) VALUES
(1, 2, 'Wonderful place', 4, 3, 'Friends', '12:03:12', 'No'),
(2, 1, 'Fun place', 1, 4, 'Friends', '10:23:12', 'Yes'),
(3, 5, 'Nice place to spend time', 2, 1, 'Public', '16:30:43', 'Yes'),
(4, 3, 'Amazing place', 3, 5, 'Public', '18:20:44', 'Yes'),
(5, 4, 'Do not miss visiting this place!', 2, 2, 'Public', '20:20:44', 'No'),
(6, 5, 'Check the restaurant', 2, 6, 'Public', '10:05:12', 'Yes'),
(14, 6, 'kk', 5, 6, 'Friends', '17:37:07', 'Yes'),
(13, 6, 'm', 5, 6, 'Friends', '17:36:35', 'Yes'),
(12, 6, 'kk', 5, 6, 'Friends', '17:21:15', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `note_comment`
--

DROP TABLE IF EXISTS `note_comment`;
CREATE TABLE IF NOT EXISTS `note_comment` (
  `NoteCommentID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL,
  `Comment` varchar(50) NOT NULL,
  PRIMARY KEY (`NoteCommentID`),
  KEY `UID` (`UID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `note_comment`
--

INSERT INTO `note_comment` (`NoteCommentID`, `UID`, `Comment`) VALUES
(1, 2, 'Thanks!'),
(2, 1, 'Helpful!'),
(3, 2, 'Thanks for sharing!'),
(4, 5, 'God Bless!'),
(5, 4, 'Thankyou'),
(6, 3, 'Great Help');

-- --------------------------------------------------------

--
-- Table structure for table `note_tag`
--

DROP TABLE IF EXISTS `note_tag`;
CREATE TABLE IF NOT EXISTS `note_tag` (
  `NoteID` int(11) NOT NULL,
  `TagID` int(11) NOT NULL,
  KEY `NoteID` (`NoteID`),
  KEY `TagID` (`TagID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `note_tag`
--

INSERT INTO `note_tag` (`NoteID`, `TagID`) VALUES
(1, 4),
(1, 2),
(1, 3),
(2, 2),
(2, 1),
(3, 1),
(4, 4),
(5, 2),
(5, 5),
(6, 7),
(12, 7),
(13, 7),
(14, 7);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `SchID` int(11) NOT NULL AUTO_INCREMENT,
  `Start_Date` date NOT NULL,
  `End_Date` date DEFAULT NULL,
  `Start_Time` time NOT NULL,
  `End_Time` time DEFAULT NULL,
  `Recurring` varchar(50) DEFAULT NULL,
  `Day_of_week` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`SchID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`SchID`, `Start_Date`, `End_Date`, `Start_Time`, `End_Time`, `Recurring`, `Day_of_week`) VALUES
(1, '2018-12-01', '2018-12-30', '11:17:26', '13:00:00', 'Weekly', 'Monday'),
(2, '2018-10-15', '2018-12-15', '01:45:22', '14:00:00', 'Daily', ''),
(3, '2018-09-18', '2018-12-18', '05:30:00', '19:00:00', 'Biweekly', 'Tuesday'),
(4, '2018-08-08', '2018-12-20', '06:10:00', '10:00:00', 'Monthly', 'Friday'),
(5, '2018-06-25', '2018-11-30', '04:50:32', '06:00:00', 'Weekly', 'Sunday'),
(6, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(7, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(8, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(9, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(10, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(11, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(12, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(13, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday'),
(14, '2018-12-11', '2018-12-11', '08:56:00', '18:30:00', 'Weekly', 'Monday');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `TagID` int(11) NOT NULL AUTO_INCREMENT,
  `TagName` varchar(50) NOT NULL,
  PRIMARY KEY (`TagID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`TagID`, `TagName`) VALUES
(1, '#food'),
(2, '#tourism'),
(3, '#shopping'),
(4, '#me'),
(5, '#transportation'),
(6, '#food'),
(7, '#fun'),
(8, '#fun'),
(9, '#fun'),
(10, '#fun'),
(11, '#food'),
(12, '#fun'),
(13, '#fun'),
(14, '#fun'),
(15, '#fun');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UID`, `UserName`, `Email`, `Password`) VALUES
(1, 'Adam', 'adam@gmail.com', 'password'),
(2, 'Andrew', 'andrew@gmail.com', 'password'),
(3, 'Bruce', 'bruce@gmail.com', 'password'),
(4, 'Colin', 'colin@gmail.com', 'password'),
(5, 'Dan', 'dan@gmail.com', 'password'),
(6, 'Elon', 'elonmusk@gmail.com', 'password'),
(7, 'Flanders', 'flanders@gmail.com', 'password'),
(8, 'Alex', 'alex@gmail.com', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user_state`
--

DROP TABLE IF EXISTS `user_state`;
CREATE TABLE IF NOT EXISTS `user_state` (
  `UID` int(11) NOT NULL,
  `UserState` varchar(50) NOT NULL,
  KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_state`
--

INSERT INTO `user_state` (`UID`, `UserState`) VALUES
(2, 'at work'),
(1, 'lunch break'),
(4, 'just chilling'),
(5, 'getting bored'),
(4, 'feeling enthusiastic'),
(5, 'mmm'),
(5, 'dsdd'),
(5, 'mmm');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
