-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2023 at 10:14 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stms`
--

-- --------------------------------------------------------

--
-- Table structure for table `nots`
--

CREATE TABLE `nots` (
  `id` int(11) NOT NULL,
  `notification` varchar(300) NOT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nots`
--

INSERT INTO `nots` (`id`, `notification`, `time`) VALUES
(1, 'Lissa Lincoln updated her password successfully!', NULL),
(2, 'Brendah child has been added successfully', NULL),
(3, 'Godfrey child has been added successfully', NULL),
(4, 'Brendah Brighton\'s  details has been updated successfully', NULL),
(5, 'Brendah Brighton\'s  details has been updated successfully', NULL),
(6, 'Brenda Brighton\'s  details has been updated successfully', NULL),
(7, 'Bagamoyo Road\'s Route has been updated successfully', NULL),
(8, 'Bagamoyo Road\'s Route has been updated successfully', NULL),
(9, 'Britney has been added successfully', NULL),
(10, 'Britney Brown\'s  details has been updated successfully', NULL),
(11, 'Britney Brown\'s  details has been updated successfully', NULL),
(12, 'T101EQB has been added successfully', NULL),
(13, 'Brian has been added successfully', NULL),
(14, 'Jensen has been added successfully', NULL),
(15, 'Brandon has been added successfully', NULL),
(16, 'Lissa Lincoln\'s account has been updated successfully!', NULL),
(17, 'Bagamoyo Road\'s Route has been updated successfully', NULL),
(19, 'Brighton Brown\'s account has been updated successfully!', NULL),
(20, 'Veronica Samuel\'s account has been updated successfully!', NULL),
(21, 'Veronicah Samuel\'s account has been updated successfully!', NULL),
(22, 'Veronicah Samuel\'s account has been updated successfully!', NULL),
(23, 'Justina has been added successfully', NULL),
(24, 'Leila has been added successfully', NULL),
(25, 'Abdul has been added successfully', NULL),
(26, 'Lucian has been added successfully', NULL),
(27, 'Bill has been added successfully', NULL),
(28, 'Mark has been added successfully', NULL),
(29, 'John has been added successfully', NULL),
(30, 'Lissa has been added successfully', NULL),
(31, 'Brandon has been added successfully', NULL),
(32, 'Aliciah has been added successfully', NULL),
(33, 'Miriam has been added successfully', NULL),
(34, 'Sasha has been added successfully', NULL),
(35, 'David has been added successfully', NULL),
(36, 'Nina has been added successfully', NULL),
(37, 'Kheri has been added successfully', NULL),
(38, 'Lilian has been added successfully', NULL),
(39, 'Godfrey has been added successfully', NULL),
(40, 'Britney has been added successfully', NULL),
(41, 'Joyce has been added successfully', NULL),
(42, 'Dickson Damian\'s account has been registered successfully!', NULL),
(43, 'Haleed Adbul\'s account has been registered successfully!', NULL),
(44, 'Damian Soul\'s account has been registered successfully!', NULL),
(45, 'Stan David\'s account has been registered successfully!', NULL),
(46, 'T101EEE has been updated successfully', NULL),
(47, 'T101EQB has been updated successfully', NULL),
(48, 'T120DAX has been deleted successfully', NULL),
(49, 'T200DDD has been deleted successfully', NULL),
(50, 'T902ECB has been deleted successfully', NULL),
(51, 'T909DXD has been deleted successfully', NULL),
(52, 'T120DAX has been added successfully', NULL),
(53, 'T120ESX has been added successfully', NULL),
(54, 'Lucas Leins\'s account has been registered successfully!', NULL),
(55, 'T671EBB has been added successfully', NULL),
(56, 'Underson Luis\'s account has been registered successfully!', NULL),
(57, 'T200DDD has been added successfully', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `date` date NOT NULL,
  `studentID` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `date`, `studentID`, `amount`) VALUES
(1, '2023-03-30', 10, 75000),
(2, '2023-03-30', 19, 35000),
(3, '2023-03-30', 18, 35000),
(4, '2023-03-30', 9, 75000),
(5, '2023-03-30', 8, 75000),
(6, '2023-03-30', 17, 35000),
(7, '2023-03-30', 13, 75000),
(8, '2023-03-30', 16, 75000),
(9, '2023-03-30', 15, 75000),
(10, '2023-03-30', 3, 45000);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `routeID` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start` varchar(100) NOT NULL,
  `finish` varchar(100) NOT NULL,
  `fair` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`routeID`, `name`, `start`, `finish`, `fair`) VALUES
('BMR', 'Bagamoyo Road', 'Mbezi Beach', 'Dallas', '50000'),
('KND', 'Kinondoni Road', 'Morocco', 'Dallas', '45000'),
('MGR', 'Morogoro Road', 'Mbezi', 'Dallas', '75000'),
('MND', 'Madela Road', 'Nyerere Bridge', 'Dallas', '75000'),
('SHK', 'Shekilango Road', 'Bamaga', 'Dallas', '35000'),
('SNJ', 'Sam Nujoma Road', 'Mwenge', 'Dallas', '35000');

-- --------------------------------------------------------

--
-- Table structure for table `schoolbus`
--

CREATE TABLE `schoolbus` (
  `busID` varchar(100) NOT NULL,
  `bustype` varchar(200) NOT NULL,
  `driverID` int(11) DEFAULT NULL,
  `routeID` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schoolbus`
--

INSERT INTO `schoolbus` (`busID`, `bustype`, `driverID`, `routeID`) VALUES
('T101EEE', 'Hinno', 5, 'SHK'),
('T101EQB', 'Hinno', 3, 'SNJ'),
('T120DAX', 'Eicher', 2, 'BMR'),
('T120ESX', 'Mitsubushi', 4, 'MGR'),
('T200DDD', 'Eicher', 7, 'KND'),
('T671EBB', 'Eicher', 6, 'MND');

-- --------------------------------------------------------

--
-- Table structure for table `stop`
--

CREATE TABLE `stop` (
  `locationID` int(11) NOT NULL,
  `locationName` varchar(100) NOT NULL,
  `time` time NOT NULL,
  `time2` time NOT NULL,
  `routeID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stop`
--

INSERT INTO `stop` (`locationID`, `locationName`, `time`, `time2`, `routeID`) VALUES
(1, 'Mbezi', '05:45:00', '17:00:00', 'MGR'),
(2, 'Kimara', '06:15:00', '16:30:00', 'MGR'),
(3, 'Korogwe', '06:30:00', '16:15:00', 'MGR'),
(4, 'Ubungo Maji', '06:45:00', '16:00:00', 'MGR'),
(8, 'Nyerere Bridge', '05:30:00', '17:00:00', 'MND'),
(9, 'Uhasibu', '05:45:00', '16:30:00', 'MND'),
(10, 'Vetenary', '06:00:00', '16:00:00', 'MND'),
(11, 'Tazara', '06:15:00', '15:45:00', 'MND'),
(12, 'Tabata', '06:25:00', '15:30:00', 'MND'),
(13, 'External', '06:45:00', '15:15:00', 'MND'),
(19, 'Mwenge', '06:30:00', '00:00:00', 'SNJ'),
(20, 'Mlimani City', '06:45:00', '00:00:00', 'SNJ'),
(21, 'Bamaga', '06:20:00', '00:00:00', 'SHK'),
(22, 'Sinza Kijiweni', '06:45:00', '00:00:00', 'SHK'),
(30, 'Mbezi Beach', '06:00:00', '17:00:00', 'BMR'),
(31, 'Mbezi Tangi Bovu', '06:30:00', '16:30:00', 'BMR'),
(32, 'Morocco', '06:00:00', '17:00:00', 'KND'),
(33, 'Manyanya', '06:20:00', '16:40:00', 'KND'),
(34, 'Mwananyamala', '06:30:00', '16:30:00', 'KND'),
(35, 'Sinza Kijiweni', '06:50:00', '16:10:00', 'KND');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `parentName` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `phone2` varchar(255) NOT NULL,
  `locationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `firstname`, `lastname`, `parentName`, `phone`, `phone2`, `locationID`) VALUES
(1, 'Justina', 'James', 'James Emmanuel', '0620123456', '0710123456', 30),
(2, 'Leila', 'Hassan', 'Hassan Ibrahim', '0711223344', '0755662266', 31),
(3, 'Abdul', 'Lugege', 'Abrahman', '0622300300', '0713131313', 32),
(4, 'Lucian', 'Weston', 'Paul Weston', '0787882161', '0678123374', 33),
(5, 'Bill', 'Gates', 'Gates Joh', '0788112233', '0789898989', 34),
(6, 'Mark', 'Zuckerberg', 'Zuckerberg M', '0777117711', '0712121212', 35),
(7, 'John', 'Doe', 'Doe John', '0712112211', '0754321098', 1),
(8, 'Lissa', 'Lincoln', 'Lincoln', '0789717171', '0621212121', 2),
(9, 'Brandon', 'Sanderson', 'Sanderson B', '0777777777', '0788888888', 3),
(10, 'Aliciah', 'Keys', 'Keys Damian', '0626121212', '0771771771', 4),
(11, 'Miriam', 'Odemba', 'Odemba Paul', '0765123456', '0756123456', 8),
(12, 'Sasha', 'Khole', 'Khole Steven', '0766666666', '0712345678', 9),
(13, 'David', 'Beckham', 'Beckham D', '0787878787', '0798998986', 10),
(14, 'Nina', 'Blossom', 'Blossom Winner', '0711111111', '0712121111', 11),
(15, 'Kheri', 'Samir', 'Samir H', '0733213213', '0744112244', 12),
(16, 'Lilian', 'Brown', 'Brown Norman', '0678212121', '0782112211', 13),
(17, 'Godfrey', 'Yusuph', 'Yusuph Mbeju', '0766554433', '0788554411', 21),
(18, 'Britney', 'Brown', 'Mary Mwenda', '0777654332', '0786882162', 22),
(19, 'Joyce', 'Kileo', 'Kileo James', '0771121277', '0756321305', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(400) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `logintime` datetime DEFAULT NULL,
  `logouttime` datetime DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usertype` varchar(25) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstname`, `lastname`, `email`, `password`, `image`, `gender`, `phone`, `logintime`, `logouttime`, `createdAt`, `updated`, `usertype`, `status`) VALUES
(1, 'Veronicah', 'Samuel', 'veronica@gmail.com', '3578e06dfbf610f18786d8200fb2df257a32359f', 'palm_sunset_leaves_134503_1920x1080.jpg', 'female', '0711223344', '2023-03-30 11:14:03', '2023-03-30 11:12:45', '2023-03-15 06:17:09', '2023-03-30 08:14:03', 'School Manager', 'active'),
(2, 'Dickson', 'Damian', 'dick@gmail.com', 'd89d86da400aa7f02f9e07a7826f572c555f5763', '2023_01_26_17_45_IMG_0107.PNG', 'male', '0788221122', NULL, NULL, '2023-03-30 07:28:03', '2023-03-30 07:28:03', 'Driver', 'active'),
(3, 'Haleed', 'Adbul', 'dull@gmail.com', 'd89d86da400aa7f02f9e07a7826f572c555f5763', '-5954224247935186208_121.jpg', 'male', '0777888888', NULL, NULL, '2023-03-30 07:31:25', '2023-03-30 07:31:25', 'Driver', 'active'),
(4, 'Damian', 'Soul', 'damian@gmail.com', 'd89d86da400aa7f02f9e07a7826f572c555f5763', '334694011_1298781950983168_4332635264434975202_n.jpg', 'male', '0777889889', NULL, NULL, '2023-03-30 07:32:09', '2023-03-30 07:32:09', 'Driver', 'active'),
(5, 'Stan', 'David', 'stan@gmail.com', 'd89d86da400aa7f02f9e07a7826f572c555f5763', '335527418_860254108395623_5142291388760810679_n.jpg', 'male', '0788221122', NULL, NULL, '2023-03-30 07:32:41', '2023-03-30 07:32:41', 'Driver', 'active'),
(6, 'Lucas', 'Leins', 'lucas@gmail.com', 'd89d86da400aa7f02f9e07a7826f572c555f5763', '5aa0d62557ef7.jpg', 'male', '0788778822', '2023-03-30 11:12:53', '2023-03-30 11:13:10', '2023-03-30 07:47:03', '2023-03-30 08:13:10', 'Driver', 'active'),
(7, 'Underson', 'Luis', 'son@gmail.com', 'd89d86da400aa7f02f9e07a7826f572c555f5763', '5aa0d62557ef7.jpg', 'male', '0789898989', NULL, NULL, '2023-03-30 07:51:18', '2023-03-30 07:51:18', 'Driver', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nots`
--
ALTER TABLE `nots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`routeID`);

--
-- Indexes for table `schoolbus`
--
ALTER TABLE `schoolbus`
  ADD PRIMARY KEY (`busID`),
  ADD KEY `schoolbus_ibfk_1` (`driverID`),
  ADD KEY `schoolbus_ibfk_2` (`routeID`);

--
-- Indexes for table `stop`
--
ALTER TABLE `stop`
  ADD PRIMARY KEY (`locationID`),
  ADD KEY `routeID` (`routeID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `locationID` (`locationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nots`
--
ALTER TABLE `nots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stop`
--
ALTER TABLE `stop`
  MODIFY `locationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schoolbus`
--
ALTER TABLE `schoolbus`
  ADD CONSTRAINT `schoolbus_ibfk_1` FOREIGN KEY (`driverID`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `schoolbus_ibfk_2` FOREIGN KEY (`routeID`) REFERENCES `route` (`routeID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `stop`
--
ALTER TABLE `stop`
  ADD CONSTRAINT `stop_ibfk_1` FOREIGN KEY (`routeID`) REFERENCES `route` (`routeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`locationID`) REFERENCES `stop` (`locationID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
