-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2017 at 08:37 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eschooling`
--

-- --------------------------------------------------------

--
-- Table structure for table `admintable`
--

CREATE TABLE `admintable` (
  `prefix` varchar(3) CHARACTER SET utf8 NOT NULL DEFAULT 'AD0',
  `adminID` int(11) NOT NULL,
  `a_fname` varchar(70) CHARACTER SET utf8 NOT NULL,
  `a_lname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `a_middlename` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `a_phone` varchar(15) CHARACTER SET utf8 NOT NULL,
  `a_dateOfBirth` date NOT NULL DEFAULT '0000-00-00',
  `a_streetName` varchar(70) CHARACTER SET utf8 NOT NULL,
  `a_apart_no` varchar(15) CHARACTER SET utf8 NOT NULL,
  `a_city` varchar(50) CHARACTER SET utf8 NOT NULL,
  `a_states` char(4) CHARACTER SET utf8 NOT NULL,
  `a_zipCode` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admintable`
--

INSERT INTO `admintable` (`prefix`, `adminID`, `a_fname`, `a_lname`, `a_middlename`, `a_phone`, `a_dateOfBirth`, `a_streetName`, `a_apart_no`, `a_city`, `a_states`, `a_zipCode`) VALUES
('AD0', 1, 'Natasha', 'Hanley', 'F', '5968898765', '2017-12-27', '1234 Main St.', 'N9', 'Austin', 'TX', '78741');

-- --------------------------------------------------------

--
-- Table structure for table `coursetable`
--

CREATE TABLE `coursetable` (
  `courseID` int(11) NOT NULL,
  `courseCode` char(6) NOT NULL,
  `courseName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coursetable`
--

INSERT INTO `coursetable` (`courseID`, `courseCode`, `courseName`) VALUES
(1, 'ESL100', 'ENGLISH LANGAUGE'),
(2, 'SPA012', 'SPEECH EDUCATION'),
(3, 'MTH022', 'SCIENCES  SOCIAL'),
(4, 'MTH100', 'MATHEMATICS');

-- --------------------------------------------------------

--
-- Table structure for table `gradetable`
--

CREATE TABLE `gradetable` (
  `gradeID` int(11) NOT NULL,
  `grade` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gradetable`
--

INSERT INTO `gradetable` (`gradeID`, `grade`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `privilagetable`
--

CREATE TABLE `privilagetable` (
  `privilegeID` int(11) NOT NULL,
  `privilegeName` varchar(20) NOT NULL,
  `privilegeType` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilagetable`
--

INSERT INTO `privilagetable` (`privilegeID`, `privilegeName`, `privilegeType`) VALUES
(1, 'Administrator', 'superuser'),
(2, 'Teacher', 'staffs'),
(3, 'Student', 'users');

-- --------------------------------------------------------

--
-- Table structure for table `schoolstudent`
--

CREATE TABLE `schoolstudent` (
  `schoolStudentID` int(11) NOT NULL,
  `schoolID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `admissionDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schoolstudent`
--

INSERT INTO `schoolstudent` (`schoolStudentID`, `schoolID`, `studentID`, `admissionDate`) VALUES
(1, 1, 1, '2017-12-21 07:03:09'),
(2, 1, 2, '2017-12-20 03:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `schooltable`
--

CREATE TABLE `schooltable` (
  `schoolID` int(11) NOT NULL,
  `schoolName` varchar(100) NOT NULL,
  `schoolPhone` varchar(15) NOT NULL,
  `streetName` varchar(70) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(45) NOT NULL,
  `zipCode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schooltable`
--

INSERT INTO `schooltable` (`schoolID`, `schoolName`, `schoolPhone`, `streetName`, `city`, `state`, `zipCode`) VALUES
(1, 'High Point High School', '5126736804', '1234 Main St.', 'Houston', 'Texas', '78741');

-- --------------------------------------------------------

--
-- Table structure for table `sessiontable`
--

CREATE TABLE `sessiontable` (
  `sessionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `sessionHash` varchar(64) NOT NULL,
  `lastLoginDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `studentcoursetable`
--

CREATE TABLE `studentcoursetable` (
  `studentCourseID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `teachID` int(11) NOT NULL,
  `enrollDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studentcoursetable`
--

INSERT INTO `studentcoursetable` (`studentCourseID`, `courseID`, `studentID`, `teachID`, `enrollDate`) VALUES
(1, 1, 1, 1, '2017-12-20 02:15:11'),
(2, 2, 1, 1, '2017-12-28 06:07:00'),
(3, 1, 2, 2, '2017-12-28 00:00:00'),
(4, 2, 2, 2, '2017-12-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `studentgradetable`
--

CREATE TABLE `studentgradetable` (
  `studentgradeID` int(11) NOT NULL,
  `gradeID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `gradedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentgradetable`
--

INSERT INTO `studentgradetable` (`studentgradeID`, `gradeID`, `studentID`, `courseID`, `gradedDate`) VALUES
(1, 1, 1, 1, '2017-12-08 03:15:05'),
(2, 2, 2, 4, '2017-12-20 03:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `studenttable`
--

CREATE TABLE `studenttable` (
  `prefix` varchar(3) NOT NULL DEFAULT 'ST0',
  `studentID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `middleName` char(1) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `race` varchar(45) NOT NULL,
  `dateOfBirth` date NOT NULL DEFAULT '0000-00-00',
  `streetName` varchar(70) NOT NULL,
  `apart_no` varchar(15) NOT NULL,
  `city` varchar(50) NOT NULL,
  `states` char(4) NOT NULL,
  `zipCode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studenttable`
--

INSERT INTO `studenttable` (`prefix`, `studentID`, `firstName`, `lastName`, `middleName`, `phone`, `gender`, `race`, `dateOfBirth`, `streetName`, `apart_no`, `city`, `states`, `zipCode`) VALUES
('ST0', 1, 'Shakira', 'Ebikam', 'M', '(333) 333-3333', 'F', 'Black/African American', '2017-12-01', '1234 Mian Ts', 'U', 'Huston', 'GA', '99999-9999');

-- --------------------------------------------------------

--
-- Table structure for table `teachercoursetable`
--

CREATE TABLE `teachercoursetable` (
  `teachCourseID` int(11) NOT NULL,
  `teachID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `startDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teacherschool`
--

CREATE TABLE `teacherschool` (
  `teachSchoolID` int(11) NOT NULL,
  `teachID` int(11) NOT NULL,
  `schoolID` int(11) NOT NULL,
  `hireDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacherschool`
--

INSERT INTO `teacherschool` (`teachSchoolID`, `teachID`, `schoolID`, `hireDate`) VALUES
(1, 1, 1, '2017-12-14 03:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `teachertable`
--

CREATE TABLE `teachertable` (
  `prefix` varchar(3) NOT NULL DEFAULT 'TC0',
  `teachID` int(11) NOT NULL,
  `t_fname` varchar(70) NOT NULL,
  `t_lname` varchar(50) NOT NULL,
  `t_middlename` char(1) DEFAULT NULL,
  `t_phone` varchar(20) NOT NULL,
  `t_dateOfBirth` date NOT NULL DEFAULT '0000-00-00',
  `t_streetName` varchar(70) NOT NULL,
  `t_apart_no` varchar(15) NOT NULL,
  `t_city` varchar(50) NOT NULL,
  `t_states` char(4) NOT NULL,
  `t_zipCode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachertable`
--

INSERT INTO `teachertable` (`prefix`, `teachID`, `t_fname`, `t_lname`, `t_middlename`, `t_phone`, `t_dateOfBirth`, `t_streetName`, `t_apart_no`, `t_city`, `t_states`, `t_zipCode`) VALUES
('TC0', 1, 'Obi', 'Ebikam', 'C', '(222) 222-2222', '2017-12-07', '1234 Mian Ts', 'Y9', 'Auston', '', '55555-5555'),
('TC0', 2, 'Franklyn', 'Ebikam', 'C', '(222) 222-2222', '2017-12-13', '1234 Mian St', 'C80', 'Austin', '', '55555');

-- --------------------------------------------------------

--
-- Table structure for table `userstable`
--

CREATE TABLE `userstable` (
  `userID` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `teachID` int(11) DEFAULT NULL,
  `privilegeID` int(11) NOT NULL,
  `userName` varchar(25) NOT NULL,
  `password` varchar(72) NOT NULL,
  `email` varchar(100) NOT NULL,
  `createDate` datetime NOT NULL,
  `privilegeName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userstable`
--

INSERT INTO `userstable` (`userID`, `studentID`, `teachID`, `privilegeID`, `userName`, `password`, `email`, `createDate`, `privilegeName`) VALUES
(1, NULL, NULL, 1, 'febikam', '$2y$11$u3qVDaaBXAKyDU9xPHUQ8u66rjdTfya07yvb4XZbEAuE7vJ090jX6', 'febikam@aol.com', '2017-11-15 00:00:00', 'Administrator'),
(2, NULL, 3, 2, 'oebikam', '$2y$11$Fx729HVnOq9nzycmvsUnX.pQ77sjvPBhYg/k1Ctds9U3RappZgZgi', 'oebikam@aol.com', '2017-12-10 01:21:03', 'Teacher'),
(3, NULL, 2, 2, 'fcebikam', '$2y$11$kqG6rdmVTkl1hSYtRkl9uelEiqeasuOIy62xOjaqMEq6Nrbq4/QSS', 'febikam2@aol.com', '2017-12-10 01:25:45', 'Teacher'),
(4, 1, NULL, 3, 'sebikam', '$2y$11$N3.Syv/OHh7QlFiZlXHXhe6h913d60IPSX3ox40gMRkjx.HdjDNYS', 'sebikam@aol.com', '2017-12-10 01:27:57', 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admintable`
--
ALTER TABLE `admintable`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `coursetable`
--
ALTER TABLE `coursetable`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `gradetable`
--
ALTER TABLE `gradetable`
  ADD PRIMARY KEY (`gradeID`);

--
-- Indexes for table `privilagetable`
--
ALTER TABLE `privilagetable`
  ADD PRIMARY KEY (`privilegeID`);

--
-- Indexes for table `schoolstudent`
--
ALTER TABLE `schoolstudent`
  ADD PRIMARY KEY (`schoolStudentID`);

--
-- Indexes for table `schooltable`
--
ALTER TABLE `schooltable`
  ADD PRIMARY KEY (`schoolID`);

--
-- Indexes for table `sessiontable`
--
ALTER TABLE `sessiontable`
  ADD PRIMARY KEY (`sessionID`);

--
-- Indexes for table `studentcoursetable`
--
ALTER TABLE `studentcoursetable`
  ADD PRIMARY KEY (`studentCourseID`);

--
-- Indexes for table `studentgradetable`
--
ALTER TABLE `studentgradetable`
  ADD PRIMARY KEY (`studentgradeID`);

--
-- Indexes for table `studenttable`
--
ALTER TABLE `studenttable`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexes for table `teachercoursetable`
--
ALTER TABLE `teachercoursetable`
  ADD PRIMARY KEY (`teachCourseID`);

--
-- Indexes for table `teacherschool`
--
ALTER TABLE `teacherschool`
  ADD PRIMARY KEY (`teachSchoolID`);

--
-- Indexes for table `teachertable`
--
ALTER TABLE `teachertable`
  ADD PRIMARY KEY (`teachID`);

--
-- Indexes for table `userstable`
--
ALTER TABLE `userstable`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admintable`
--
ALTER TABLE `admintable`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coursetable`
--
ALTER TABLE `coursetable`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gradetable`
--
ALTER TABLE `gradetable`
  MODIFY `gradeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `privilagetable`
--
ALTER TABLE `privilagetable`
  MODIFY `privilegeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schoolstudent`
--
ALTER TABLE `schoolstudent`
  MODIFY `schoolStudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schooltable`
--
ALTER TABLE `schooltable`
  MODIFY `schoolID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessiontable`
--
ALTER TABLE `sessiontable`
  MODIFY `sessionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentcoursetable`
--
ALTER TABLE `studentcoursetable`
  MODIFY `studentCourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `studentgradetable`
--
ALTER TABLE `studentgradetable`
  MODIFY `studentgradeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studenttable`
--
ALTER TABLE `studenttable`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachercoursetable`
--
ALTER TABLE `teachercoursetable`
  MODIFY `teachCourseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacherschool`
--
ALTER TABLE `teacherschool`
  MODIFY `teachSchoolID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachertable`
--
ALTER TABLE `teachertable`
  MODIFY `teachID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userstable`
--
ALTER TABLE `userstable`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
