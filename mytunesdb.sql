-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 18, 2025 at 06:07 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytunesdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `albumID` int NOT NULL,
  `title` varchar(865) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `releaseDate` datetime DEFAULT NULL,
  `artistID` int DEFAULT NULL,
  `genreID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumID`, `title`, `releaseDate`, `artistID`, `genreID`) VALUES
(1, 'FIRST ALBUM', '2025-05-05 18:42:26', 1, 1),
(2, 'Ghost Data', '2023-11-22 00:00:00', 2, 4),
(3, 'Bars & Breakpoints', '2025-01-09 00:00:00', 3, 3),
(5, 'Electric Pulse', '2023-05-25 00:00:00', 2, 4),
(6, 'Syntax Error', '2025-05-05 00:00:00', 3, 3),
(8, 'Stone Replay', '2022-12-01 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `albumbadge`
--

CREATE TABLE `albumbadge` (
  `albumBadgeID` int NOT NULL,
  `pressingID` int NOT NULL,
  `albumID` int DEFAULT NULL,
  `userID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albumbadge`
--

INSERT INTO `albumbadge` (`albumBadgeID`, `pressingID`, `albumID`, `userID`) VALUES
(1, 1, 1, 1),
(5, 2, 5, 1),
(6, 1, 3, 1),
(7, 2, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `albumgenre`
--

CREATE TABLE `albumgenre` (
  `albumGenreID` int NOT NULL,
  `albumID` int DEFAULT NULL,
  `genreID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albumgenre`
--

INSERT INTO `albumgenre` (`albumGenreID`, `albumID`, `genreID`) VALUES
(1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `artistID` int NOT NULL,
  `name` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`artistID`, `name`, `description`) VALUES
(1, 'Drake', 'Artist Drake'),
(2, 'Lewis Capaldi', 'Artist Lewis Capaldi'),
(3, 'Marshmallow', 'Artist Marshmallow'),
(4, 'Playboy Carti', 'Artist Playboy Carti');

-- --------------------------------------------------------

--
-- Table structure for table `cd`
--

CREATE TABLE `cd` (
  `cdID` int NOT NULL,
  `size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cd`
--

INSERT INTO `cd` (`cdID`, `size`, `edition`) VALUES
(1, 'Standard', 'Regular'),
(2, 'Slim', 'Deluxe'),
(3, 'Jewel Case', 'Collector');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `countryID` int NOT NULL,
  `regionID` int DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`countryID`, `regionID`, `name`) VALUES
(1, NULL, 'United Kingdom'),
(2, NULL, 'United States'),
(4, NULL, 'Afghanistan'),
(5, NULL, 'Albania'),
(6, NULL, 'Algeria'),
(7, NULL, 'Andorra'),
(8, NULL, 'Angola'),
(9, NULL, 'Antigua and Barbuda'),
(10, NULL, 'Argentina'),
(11, NULL, 'Armenia'),
(12, NULL, 'Australia'),
(13, NULL, 'Austria'),
(14, NULL, 'Azerbaijan'),
(15, NULL, 'Bahamas'),
(16, NULL, 'Bahrain'),
(17, NULL, 'Bangladesh'),
(18, NULL, 'Barbados'),
(19, NULL, 'Belarus'),
(20, NULL, 'Belgium'),
(21, NULL, 'Belize'),
(22, NULL, 'Benin'),
(23, NULL, 'Bhutan'),
(24, NULL, 'Bolivia'),
(25, NULL, 'Bosnia and Herzegovina'),
(26, NULL, 'Botswana'),
(27, NULL, 'Brazil'),
(28, NULL, 'Brunei'),
(29, NULL, 'Bulgaria'),
(30, NULL, 'Burkina Faso'),
(31, NULL, 'Burundi'),
(32, NULL, 'Cabo Verde'),
(33, NULL, 'Cambodia'),
(34, NULL, 'Cameroon'),
(35, NULL, 'Canada'),
(36, NULL, 'Central African Republic'),
(37, NULL, 'Chad'),
(38, NULL, 'Chile'),
(39, NULL, 'China'),
(40, NULL, 'Colombia'),
(41, NULL, 'Comoros'),
(42, NULL, 'Congo, Democratic Republic of the'),
(43, NULL, 'Congo, Republic of the'),
(44, NULL, 'Costa Rica'),
(45, NULL, 'Croatia'),
(46, NULL, 'Cuba'),
(47, NULL, 'Cyprus'),
(48, NULL, 'Czech Republic'),
(49, NULL, 'Denmark'),
(50, NULL, 'Djibouti'),
(51, NULL, 'Dominica'),
(52, NULL, 'Dominican Republic'),
(53, NULL, 'Ecuador'),
(54, NULL, 'Egypt'),
(55, NULL, 'El Salvador'),
(56, NULL, 'Equatorial Guinea'),
(57, NULL, 'Eritrea'),
(58, NULL, 'Estonia'),
(59, NULL, 'Eswatini'),
(60, NULL, 'Ethiopia'),
(61, NULL, 'Fiji'),
(62, NULL, 'Finland'),
(63, NULL, 'France'),
(64, NULL, 'Gabon'),
(65, NULL, 'Gambia'),
(66, NULL, 'Georgia'),
(67, NULL, 'Germany'),
(68, NULL, 'Ghana'),
(69, NULL, 'Greece'),
(70, NULL, 'Grenada'),
(71, NULL, 'Guatemala'),
(72, NULL, 'Guinea'),
(73, NULL, 'Guinea-Bissau'),
(74, NULL, 'Guyana'),
(75, NULL, 'Haiti'),
(76, NULL, 'Honduras'),
(77, NULL, 'Hungary'),
(78, NULL, 'Iceland'),
(79, NULL, 'India'),
(80, NULL, 'Indonesia'),
(81, NULL, 'Iran'),
(82, NULL, 'Iraq'),
(83, NULL, 'Ireland'),
(84, NULL, 'Israel'),
(85, NULL, 'Italy'),
(86, NULL, 'Ivory Coast'),
(87, NULL, 'Jamaica'),
(88, NULL, 'Japan'),
(89, NULL, 'Jordan'),
(90, NULL, 'Kazakhstan'),
(91, NULL, 'Kenya'),
(92, NULL, 'Kiribati'),
(93, NULL, 'Korea, North'),
(94, NULL, 'Korea, South'),
(95, NULL, 'Kosovo'),
(96, NULL, 'Kuwait'),
(97, NULL, 'Kyrgyzstan'),
(98, NULL, 'Laos'),
(99, NULL, 'Latvia'),
(100, NULL, 'Lebanon'),
(101, NULL, 'Lesotho'),
(102, NULL, 'Liberia'),
(103, NULL, 'Libya'),
(104, NULL, 'Liechtenstein'),
(105, NULL, 'Lithuania'),
(106, NULL, 'Luxembourg'),
(107, NULL, 'Madagascar'),
(108, NULL, 'Malawi'),
(109, NULL, 'Malaysia'),
(110, NULL, 'Maldives'),
(111, NULL, 'Mali'),
(112, NULL, 'Malta'),
(113, NULL, 'Marshall Islands'),
(114, NULL, 'Mauritania'),
(115, NULL, 'Mauritius'),
(116, NULL, 'Mexico'),
(117, NULL, 'Micronesia'),
(118, NULL, 'Moldova'),
(119, NULL, 'Monaco'),
(120, NULL, 'Mongolia'),
(121, NULL, 'Montenegro'),
(122, NULL, 'Morocco'),
(123, NULL, 'Mozambique'),
(124, NULL, 'Myanmar'),
(125, NULL, 'Namibia'),
(126, NULL, 'Nauru'),
(127, NULL, 'Nepal'),
(128, NULL, 'Netherlands'),
(129, NULL, 'New Zealand'),
(130, NULL, 'Nicaragua'),
(131, NULL, 'Niger'),
(132, NULL, 'Nigeria'),
(133, NULL, 'North Macedonia'),
(134, NULL, 'Norway'),
(135, NULL, 'Oman'),
(136, NULL, 'Pakistan'),
(137, NULL, 'Palau'),
(138, NULL, 'Panama'),
(139, NULL, 'Papua New Guinea'),
(140, NULL, 'Paraguay'),
(141, NULL, 'Peru'),
(142, NULL, 'Philippines'),
(143, NULL, 'Poland'),
(144, NULL, 'Portugal'),
(145, NULL, 'Qatar'),
(146, NULL, 'Romania'),
(147, NULL, 'Russia'),
(148, NULL, 'Rwanda'),
(149, NULL, 'Saint Kitts and Nevis'),
(150, NULL, 'Saint Lucia'),
(151, NULL, 'Saint Vincent and the Grenadines'),
(152, NULL, 'Samoa'),
(153, NULL, 'San Marino'),
(154, NULL, 'Sao Tome and Principe');

-- --------------------------------------------------------

--
-- Table structure for table `countrylanguage`
--

CREATE TABLE `countrylanguage` (
  `countryLanguageID` int NOT NULL,
  `countryID` int DEFAULT NULL,
  `languageID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countrylanguage`
--

INSERT INTO `countrylanguage` (`countryLanguageID`, `countryID`, `languageID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 2, 2),
(4, 13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currencyID` int NOT NULL,
  `code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entityimages`
--

CREATE TABLE `entityimages` (
  `entityImageID` int NOT NULL,
  `imageID` int DEFAULT NULL,
  `artistID` int DEFAULT NULL,
  `albumID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entityimages`
--

INSERT INTO `entityimages` (`entityImageID`, `imageID`, `artistID`, `albumID`) VALUES
(1, 7, NULL, 1),
(2, 9, NULL, 3),
(3, 10, NULL, 1),
(4, 11, NULL, 2),
(5, 12, NULL, 5),
(6, 13, NULL, 6),
(7, 14, NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `feature`
--

CREATE TABLE `feature` (
  `featureID` int NOT NULL,
  `trackID` int DEFAULT NULL,
  `artistID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feature`
--

INSERT INTO `feature` (`featureID`, `trackID`, `artistID`) VALUES
(3, 2, 3),
(4, 1, 4),
(5, 3, 2),
(6, 2, 2),
(7, 3, 4),
(8, 4, 2),
(9, 4, 3),
(10, 1, 2),
(11, 2, 3),
(12, 3, 4),
(13, 4, 1),
(14, 2, 1),
(15, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `fileID` int NOT NULL,
  `url` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trackID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genreID` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genreID`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Hip Hop'),
(4, 'Electronic'),
(5, 'Jazz'),
(6, 'Classical'),
(7, 'R&B'),
(8, 'Metal');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `imageID` int NOT NULL,
  `imageData` longblob,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`imageID`, `imageData`, `url`) VALUES
(1, NULL, 'images/drakeT.png'),
(2, NULL, 'images/drakeB.avif'),
(3, NULL, 'images/collector.jpg'),
(4, NULL, 'images/poster1.jpg'),
(5, NULL, 'images/ghostdhata.jpg'),
(6, NULL, 'images/ghostdhata.jpg'),
(9, NULL, 'images/bars.png'),
(10, NULL, 'images/first_album.png'),
(11, NULL, 'images/ghostdhata.jpg'),
(12, NULL, 'images/electric_pulse.png'),
(13, NULL, 'images/syntax_error.png'),
(14, NULL, 'images/stone_replay.png'),
(15, NULL, 'uploads/pfp_682738c453fac4.87888499.jpg'),
(16, NULL, 'images/shirt1.png');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `languageID` int NOT NULL,
  `languageName` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`languageID`, `languageName`) VALUES
(1, 'English'),
(2, 'Spanish'),
(3, 'French'),
(4, 'German'),
(5, 'Mandarin'),
(6, 'Arabic'),
(7, 'Portuguese'),
(8, 'Russian'),
(9, 'Hindi'),
(10, 'Bengali');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderID` int NOT NULL,
  `productID` int DEFAULT NULL,
  `paymentID` int DEFAULT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otherproduct`
--

CREATE TABLE `otherproduct` (
  `otherProductID` int NOT NULL,
  `size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `material` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otherproduct`
--

INSERT INTO `otherproduct` (`otherProductID`, `size`, `material`, `edition`) VALUES
(1, 'Small', 'Plastic', 'Basic'),
(2, 'Medium', 'Canvas', 'Limited'),
(3, 'Large', 'Metal', 'Collector');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `currencyID` int DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `paymentMethodID` int DEFAULT NULL,
  `paymentStatus` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `paymentMethodID` int NOT NULL,
  `methodName` varchar(204) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int NOT NULL,
  `userID` int NOT NULL,
  `subscriptionID` int NOT NULL,
  `amount` decimal(6,2) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `method` varchar(20) DEFAULT NULL,
  `paymentDate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentID`, `userID`, `subscriptionID`, `amount`, `currency`, `method`, `paymentDate`) VALUES
(1, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:27:40'),
(2, 6, 2, 0.00, '€', 'credit', '2025-05-14 15:27:47'),
(3, 6, 2, 0.00, '€', 'credit', '2025-05-14 15:30:08'),
(4, 6, 2, 0.00, '€', 'credit', '2025-05-14 15:30:37'),
(5, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:31:49'),
(6, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:34:15'),
(7, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:36:59'),
(8, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:37:36'),
(9, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:40:20'),
(10, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:41:59'),
(11, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:44:40'),
(12, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:44:49'),
(13, 6, 3, 4.99, '€', 'credit', '2025-05-14 15:45:16'),
(14, 4, 3, 4.99, '€', 'paypal', '2025-05-14 15:51:32'),
(15, 4, 2, 0.00, '€', 'credit', '2025-05-14 15:51:41'),
(16, 4, 2, 0.00, '€', 'credit', '2025-05-14 15:52:07'),
(17, 3, 3, 4.99, '€', 'paypal', '2025-05-15 10:11:40'),
(18, 6, 3, 4.99, '€', 'paypal', '2025-05-17 10:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `playlistID` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `dateAdded` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`playlistID`, `name`, `description`, `userID`, `dateAdded`) VALUES
(1, 'My First Playlist', NULL, NULL, NULL),
(2, 'play2', 'hvvseivne', 2, '2025-05-06 19:10:46'),
(3, 'Workout Mix', 'High energy tracks to boost your workout.', 1, '2025-05-06 20:00:00'),
(4, 'Chill Vibes', 'Relax and unwind.', 1, '2025-05-06 20:05:00'),
(5, 'Late Night Coding', 'Ambient tracks for deep work.', 2, '2025-05-06 20:10:00'),
(6, 'Throwbacks', 'Hits from the past.', 2, '2025-05-06 20:15:00'),
(7, 'Focus Mode', 'Instrumental productivity tracks.', 1, '2025-05-06 20:20:00'),
(8, 'Indie Discovery', 'Explore fresh indie sounds.', 2, '2025-05-06 20:25:00'),
(9, 'maytest', 'gggg', 3, '2025-05-06 19:10:46'),
(10, 'Morning Mix', 'Wake-up music .', 1, '2025-05-14 14:42:31'),
(11, 'Night Vibes', 'Evening chill tracks.', 1, '2025-05-14 14:42:31'),
(12, 'Party Mode', 'Dance beats selected.', 2, '2025-05-14 14:42:31'),
(13, 'Study Time', 'Ambient music for focus.', 2, '2025-05-14 14:42:31'),
(14, 'Roadtrip Tunes', 'For long drives.', 3, '2025-05-14 14:42:31'),
(15, 'User3 Relax Zone', 'Unwind with mellow tracks.', 3, '2025-05-14 14:42:31'),
(16, 'Chill Out', 'Lo-fi beats to relax/study to.', 4, '2025-05-14 14:49:14'),
(17, 'Party Hits', 'Upbeat tracks for the weekend.', 4, '2025-05-14 14:49:14');

-- --------------------------------------------------------

--
-- Table structure for table `playlisttrack`
--

CREATE TABLE `playlisttrack` (
  `trackPlaylistID` int NOT NULL,
  `playlistID` int DEFAULT NULL,
  `trackID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlisttrack`
--

INSERT INTO `playlisttrack` (`trackPlaylistID`, `playlistID`, `trackID`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int NOT NULL,
  `artistID` int DEFAULT NULL,
  `productTypeID` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantityStock` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `imageID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `artistID`, `productTypeID`, `price`, `quantityStock`, `name`, `description`, `date`, `imageID`) VALUES
(1, 2, 1, 30.00, 3, 'shirt', 'shirt of dragon', '2025-05-08', 16),
(3, 1, 1, 19.99, 3, 'T-Shirt', 'Official merch shirt.', '2025-05-16', 1),
(4, 1, 1, 5.99, 5, 'Badge Set', 'Custom plastic badge pack.', '2025-05-16', 2),
(5, 2, 2, 9.99, NULL, 'Poster', 'Canvas print tour poster.', NULL, 4),
(6, 3, 3, 199.00, 1, 'Collector Prop', 'Limited edition collector prop.', '2025-05-16', 3);

-- --------------------------------------------------------

--
-- Table structure for table `producttype`
--

CREATE TABLE `producttype` (
  `productTypeID` int NOT NULL,
  `wearableID` int DEFAULT NULL,
  `cdID` int DEFAULT NULL,
  `vinylID` int DEFAULT NULL,
  `otherProductID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producttype`
--

INSERT INTO `producttype` (`productTypeID`, `wearableID`, `cdID`, `vinylID`, `otherProductID`) VALUES
(1, 1, NULL, NULL, NULL),
(2, 1, NULL, NULL, NULL),
(3, NULL, NULL, 1, NULL),
(4, NULL, NULL, NULL, 1),
(5, NULL, NULL, NULL, 2),
(6, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `regionID` int NOT NULL,
  `regionName` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`regionID`, `regionName`) VALUES
(1, 'Africa'),
(2, 'Asia'),
(3, 'Europe'),
(4, 'North America'),
(5, 'South America'),
(6, 'Central America'),
(7, 'Middle East'),
(8, 'Oceania'),
(9, 'Caribbean'),
(10, 'Antarctica'),
(11, 'Southeast Asia'),
(12, 'Eastern Europe'),
(13, 'Western Europe'),
(14, 'Northern Europe'),
(15, 'Southern Europe'),
(16, 'East Asia'),
(17, 'South Asia'),
(18, 'Central Asia'),
(19, 'North Africa'),
(20, 'Sub-Saharan Africa');

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscriptionID` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(5,2) NOT NULL DEFAULT '0.00',
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subscriptionType` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`subscriptionID`, `name`, `price`, `description`, `subscriptionType`) VALUES
(2, 'Free', 0.00, 'Basic access with limited features and ads.', 'free'),
(3, 'Plus', 4.99, 'Ad-free streaming and offline playback.', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `trackID` int NOT NULL,
  `title` varchar(865) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `albumID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`trackID`, `title`, `albumID`) VALUES
(1, 'track1', 1),
(2, 'Waves and Static', 2),
(3, 'Ghost Data', 3),
(4, 'Velvet Midnight', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int NOT NULL,
  `username` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `googleID` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pressingID` int DEFAULT NULL,
  `imageID` int DEFAULT NULL,
  `countryID` int DEFAULT NULL,
  `subscriptionID` int DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `languageID` int DEFAULT NULL,
  `regionID` int DEFAULT NULL,
  `country` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'MT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `googleID`, `email`, `pressingID`, `imageID`, `countryID`, `subscriptionID`, `admin`, `languageID`, `regionID`, `country`) VALUES
(1, 'user1', 'password123', NULL, 'user1@example.com', 1, NULL, 2, NULL, 0, NULL, NULL, 'MT'),
(2, 'testuser', 'password123', NULL, 'test@example.com', 1, NULL, 1, NULL, 0, NULL, NULL, 'MT'),
(3, 'lyona', '$2y$10$GczrX6Y2lPy9FvX80XPDJOuYCKJd/yj90zEPD3bhncPV66yF0jqEe', NULL, 'lyonamanche@gmail.com', 1, 15, 112, 3, 0, 5, 3, 'MT'),
(4, 'myr', '$2y$10$qHHDZK4OUavHxuEtPaTnyOCIyqBXQoa/zPwQ9emtk8ycz2T7H5ZP6', NULL, 'myrah@gmail.com', NULL, NULL, NULL, 2, 1, NULL, NULL, 'MT'),
(5, 'test', '$2y$10$ztZqLEcHid1THhF1MsccW.IsQ.w53k.WMkyucmDJEU9AHMelnC7Ym', NULL, 'test@gmail.com', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'MT'),
(6, 'test4@gmail.com', '$2y$10$zqvsvI4wlXoCIBMYjf0T7u0TImER45IU8MRYpG7qXefEmhCle/pni', NULL, 'test4@gmail.com', NULL, NULL, 112, 3, 0, NULL, 3, 'MT');

-- --------------------------------------------------------

--
-- Table structure for table `vinyl`
--

CREATE TABLE `vinyl` (
  `vinylID` int NOT NULL,
  `size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vinyl`
--

INSERT INTO `vinyl` (`vinylID`, `size`, `edition`) VALUES
(1, '12 inch', 'Limited');

-- --------------------------------------------------------

--
-- Table structure for table `wearable`
--

CREATE TABLE `wearable` (
  `wearableID` int NOT NULL,
  `material` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `size` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wearable`
--

INSERT INTO `wearable` (`wearableID`, `material`, `size`) VALUES
(1, 'cotton', 'M'),
(2, 'cotton', 'L'),
(3, 'polyester', 'XL'),
(4, 'cotton', 'L'),
(5, 'cotton', 'M'),
(6, 'cotton', 'M');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumID`),
  ADD KEY `artistID` (`artistID`),
  ADD KEY `genreID` (`genreID`);

--
-- Indexes for table `albumbadge`
--
ALTER TABLE `albumbadge`
  ADD PRIMARY KEY (`albumBadgeID`),
  ADD KEY `albumID` (`albumID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `albumgenre`
--
ALTER TABLE `albumgenre`
  ADD PRIMARY KEY (`albumGenreID`),
  ADD KEY `albumID` (`albumID`),
  ADD KEY `genreID` (`genreID`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`artistID`);

--
-- Indexes for table `cd`
--
ALTER TABLE `cd`
  ADD PRIMARY KEY (`cdID`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`countryID`),
  ADD KEY `regionID` (`regionID`);

--
-- Indexes for table `countrylanguage`
--
ALTER TABLE `countrylanguage`
  ADD PRIMARY KEY (`countryLanguageID`),
  ADD KEY `countryID` (`countryID`),
  ADD KEY `languageID` (`languageID`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currencyID`);

--
-- Indexes for table `entityimages`
--
ALTER TABLE `entityimages`
  ADD PRIMARY KEY (`entityImageID`),
  ADD KEY `imageID` (`imageID`),
  ADD KEY `artistID` (`artistID`),
  ADD KEY `albumID` (`albumID`);

--
-- Indexes for table `feature`
--
ALTER TABLE `feature`
  ADD PRIMARY KEY (`featureID`),
  ADD KEY `trackID` (`trackID`),
  ADD KEY `artistID` (`artistID`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileID`),
  ADD KEY `trackID` (`trackID`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genreID`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`imageID`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`languageID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `paymentID` (`paymentID`);

--
-- Indexes for table `otherproduct`
--
ALTER TABLE `otherproduct`
  ADD PRIMARY KEY (`otherProductID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `currencyID` (`currencyID`),
  ADD KEY `paymentMethodID` (`paymentMethodID`);

--
-- Indexes for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`paymentMethodID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`playlistID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `playlisttrack`
--
ALTER TABLE `playlisttrack`
  ADD PRIMARY KEY (`trackPlaylistID`),
  ADD KEY `playlistID` (`playlistID`),
  ADD KEY `trackID` (`trackID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `artistID` (`artistID`),
  ADD KEY `productTypeID` (`productTypeID`);

--
-- Indexes for table `producttype`
--
ALTER TABLE `producttype`
  ADD PRIMARY KEY (`productTypeID`),
  ADD KEY `wearableID` (`wearableID`),
  ADD KEY `cdID` (`cdID`),
  ADD KEY `vinylID` (`vinylID`),
  ADD KEY `otherProductID` (`otherProductID`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`regionID`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscriptionID`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`trackID`),
  ADD KEY `albumID` (`albumID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `googleID` (`googleID`),
  ADD KEY `countryID` (`countryID`),
  ADD KEY `user_ibfk_image` (`imageID`),
  ADD KEY `fk_user_region` (`regionID`),
  ADD KEY `fk_user_language` (`languageID`);

--
-- Indexes for table `vinyl`
--
ALTER TABLE `vinyl`
  ADD PRIMARY KEY (`vinylID`);

--
-- Indexes for table `wearable`
--
ALTER TABLE `wearable`
  ADD PRIMARY KEY (`wearableID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albumbadge`
--
ALTER TABLE `albumbadge`
  MODIFY `albumBadgeID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `artistID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cd`
--
ALTER TABLE `cd`
  MODIFY `cdID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `countrylanguage`
--
ALTER TABLE `countrylanguage`
  MODIFY `countryLanguageID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `entityimages`
--
ALTER TABLE `entityimages`
  MODIFY `entityImageID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feature`
--
ALTER TABLE `feature`
  MODIFY `featureID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `imageID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `otherproduct`
--
ALTER TABLE `otherproduct`
  MODIFY `otherProductID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `playlistID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `producttype`
--
ALTER TABLE `producttype`
  MODIFY `productTypeID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `subscriptionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vinyl`
--
ALTER TABLE `vinyl`
  MODIFY `vinylID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wearable`
--
ALTER TABLE `wearable`
  MODIFY `wearableID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`genreID`) REFERENCES `genre` (`genreID`);

--
-- Constraints for table `albumbadge`
--
ALTER TABLE `albumbadge`
  ADD CONSTRAINT `albumbadge_ibfk_1` FOREIGN KEY (`albumID`) REFERENCES `album` (`albumID`),
  ADD CONSTRAINT `albumbadge_ibfk_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `albumgenre`
--
ALTER TABLE `albumgenre`
  ADD CONSTRAINT `albumgenre_ibfk_1` FOREIGN KEY (`albumID`) REFERENCES `album` (`albumID`),
  ADD CONSTRAINT `albumgenre_ibfk_2` FOREIGN KEY (`genreID`) REFERENCES `genre` (`genreID`);

--
-- Constraints for table `country`
--
ALTER TABLE `country`
  ADD CONSTRAINT `country_ibfk_1` FOREIGN KEY (`regionID`) REFERENCES `region` (`regionID`);

--
-- Constraints for table `countrylanguage`
--
ALTER TABLE `countrylanguage`
  ADD CONSTRAINT `countrylanguage_ibfk_1` FOREIGN KEY (`countryID`) REFERENCES `country` (`countryID`),
  ADD CONSTRAINT `countrylanguage_ibfk_2` FOREIGN KEY (`languageID`) REFERENCES `language` (`languageID`);

--
-- Constraints for table `entityimages`
--
ALTER TABLE `entityimages`
  ADD CONSTRAINT `entityimages_ibfk_3` FOREIGN KEY (`albumID`) REFERENCES `album` (`albumID`);

--
-- Constraints for table `feature`
--
ALTER TABLE `feature`
  ADD CONSTRAINT `feature_ibfk_1` FOREIGN KEY (`trackID`) REFERENCES `track` (`trackID`);

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_ibfk_1` FOREIGN KEY (`trackID`) REFERENCES `track` (`trackID`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`paymentID`) REFERENCES `payment` (`paymentID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`currencyID`) REFERENCES `currency` (`currencyID`),
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`paymentMethodID`) REFERENCES `paymentmethod` (`paymentMethodID`),
  ADD CONSTRAINT `payment_ibfk_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlisttrack`
--
ALTER TABLE `playlisttrack`
  ADD CONSTRAINT `playlisttrack_ibfk_1` FOREIGN KEY (`playlistID`) REFERENCES `playlist` (`playlistID`),
  ADD CONSTRAINT `playlisttrack_ibfk_2` FOREIGN KEY (`trackID`) REFERENCES `track` (`trackID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`productTypeID`) REFERENCES `producttype` (`productTypeID`);

--
-- Constraints for table `producttype`
--
ALTER TABLE `producttype`
  ADD CONSTRAINT `fk_producttype_cd` FOREIGN KEY (`cdID`) REFERENCES `cd` (`cdID`),
  ADD CONSTRAINT `fk_producttype_other` FOREIGN KEY (`otherProductID`) REFERENCES `otherproduct` (`otherProductID`),
  ADD CONSTRAINT `producttype_ibfk_1` FOREIGN KEY (`wearableID`) REFERENCES `wearable` (`wearableID`),
  ADD CONSTRAINT `producttype_ibfk_3` FOREIGN KEY (`vinylID`) REFERENCES `vinyl` (`vinylID`);

--
-- Constraints for table `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `track_ibfk_1` FOREIGN KEY (`albumID`) REFERENCES `album` (`albumID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_country` FOREIGN KEY (`countryID`) REFERENCES `country` (`countryID`),
  ADD CONSTRAINT `fk_user_language` FOREIGN KEY (`languageID`) REFERENCES `language` (`languageID`),
  ADD CONSTRAINT `fk_user_region` FOREIGN KEY (`regionID`) REFERENCES `region` (`regionID`),
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`countryID`) REFERENCES `country` (`countryID`),
  ADD CONSTRAINT `user_ibfk_image` FOREIGN KEY (`imageID`) REFERENCES `image` (`imageID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
