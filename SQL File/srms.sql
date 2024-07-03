-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 07:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', 'f925916e2754e5e03f75dd58a5733251', '2024-03-10 10:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `tblclasses`
--

CREATE TABLE `tblclasses` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `Department` varchar(80) DEFAULT NULL,
  `Series` int(4) DEFAULT NULL,
  `Section` varchar(5) DEFAULT NULL,
  `Semester` int(5) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclasses`
--

INSERT INTO `tblclasses` (`id`, `Department`, `Series`, `Section`, `Semester`, `CreationDate`, `UpdationDate`) VALUES
(1, 'ECE', 2020, 'A', 1, '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(2, 'ME', 2020, 'A', 1, '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(3, 'CSE', 2020, 'A', 1, '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(4, 'ETE', 2020, 'A', 1, '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(5, 'CE', 2020, 'A', 1, '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(6, 'MTE', 2020, 'A', 1, '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(7, 'MSE', 2020, 'A', 1, '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(8, 'EEE', 2020, 'A', 1, '2024-04-25 10:30:57', NULL);


-- --------------------------------------------------------

--
-- Table structure for table `tbldept`
--

CREATE TABLE `tbldept` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `Department` varchar(32) NOT NULL,
  `deptCode` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Dumping data for table `tbldept`
--

INSERT INTO `tbldept` (`id`, `Department`, `deptCode`) VALUES
(1, 'ECE', '10' ),
(2, 'CSE', '03' ),
(3, 'CE', '00' ),
(4, 'ME', '02' ),
(5, 'ETE', '01' ),
(6, 'EEE', '04' ),
(7, 'MTE', '05' ),
(8, 'MSE', '06' );


-- --------------------------------------------------------

CREATE TABLE `tblteachers` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `TeacherId` varchar(80) NOT NULL,
  `TeacherName` varchar(100) DEFAULT NULL,
  `TeacherEmail` varchar(100) DEFAULT NULL,
  `TeacherPhone` int(11) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `JoiningDate` varchar(100) DEFAULT NULL,
  `Designation` varchar(100) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
--
-- Table structure for table `tblnotice`
--

CREATE TABLE `tblnotice` (
  `id` int(11) NOT NULL,
  `noticeTitle` varchar(255) DEFAULT NULL,
  `noticeDetails` mediumtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblnotice`
--

INSERT INTO `tblnotice` (`id`, `noticeTitle`, `noticeDetails`, `postingDate`) VALUES
(2, 'Notice regarding result Delearation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Adipiscing elit ut aliquam purus. Vel risus commodo viverra maecenas. Et netus et malesuada fames ac turpis egestas sed. Cursus eget nunc scelerisque viverra mauris in aliquam sem fringilla. Ornare arcu odio ut sem nulla pharetra diam. Vel pharetra vel turpis nunc eget lorem dolor sed. Velit ut tortor pretium viverra suspendisse. In ornare quam viverra orci sagittis eu. Viverra tellus in hac habitasse. Donec massa sapien faucibus et molestie. Libero justo laoreet sit amet cursus sit amet dictum. Dignissim diam quis enim lobortis scelerisque fermentum dui.\r\n\r\nEget nulla facilisi etiam dignissim. Quisque non tellus orci ac. Amet cursus sit amet dictum sit amet justo donec. Interdum velit euismod in pellentesque massa. Condimentum lacinia quis vel eros donec ac odio. Magna eget est lorem ipsum dolor. Bibendum at varius vel pharetra vel turpis nunc eget lorem. Pellentesque adipiscing commodo elit at imperdiet dui accumsan sit amet. Maecenas accumsan lacus vel facilisis volutpat est velit egestas dui. Massa tincidunt dui ut ornare lectus sit amet est placerat. Nisi quis eleifend quam adipiscing vitae.', '2024-05-01 14:34:58'),
(3, 'Test Notice', 'This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  ', '2024-05-02 14:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `tblresult`
--

CREATE TABLE `tblresult` (
  `id` int(11) NOT NULL,
  `StudentId` int(11) DEFAULT NULL,
  `ClassId` int(11) DEFAULT NULL,
  `SubjectId` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblresult`
--

INSERT INTO `tblresult` (`id`, `StudentId`, `ClassId`, `SubjectId`, `marks`, `PostingDate`, `UpdationDate`) VALUES
(2, 1, 1, 2, 100, '2024-05-10 10:30:57', NULL),
(3, 1, 1, 1, 80, '2024-05-10 10:30:57', NULL),
(4, 1, 1, 5, 78, '2024-05-10 10:30:57', NULL),
(5, 1, 1, 4, 60, '2024-05-10 10:30:57', NULL),
(6, 2, 4, 2, 90, '2024-05-10 10:30:57', NULL),
(7, 2, 4, 1, 75, '2024-05-10 10:30:57', NULL),
(8, 2, 4, 5, 56, '2024-05-10 10:30:57', NULL),
(9, 2, 4, 4, 80, '2024-05-10 10:30:57', NULL),
(10, 4, 7, 2, 54, '2024-05-10 10:30:57', NULL),
(11, 4, 7, 1, 85, '2024-05-10 10:30:57', NULL),
(12, 4, 7, 5, 55, '2024-05-10 10:30:57', NULL),
(13, 4, 7, 7, 65, '2024-05-10 10:30:57', NULL),
(14, 5, 8, 2, 75, '2024-05-10 10:30:57', NULL),
(15, 5, 8, 1, 56, '2024-05-10 10:30:57', NULL),
(16, 5, 8, 5, 52, '2024-05-10 10:30:57', NULL),
(17, 5, 8, 4, 80, '2024-05-10 10:30:57', NULL),
(18, 6, 9, 8, 80, '2024-05-20 15:20:18', NULL),
(19, 6, 9, 8, 70, '2024-05-20 15:20:18', NULL),
(20, 6, 9, 2, 90, '2024-05-20 15:20:18', NULL),
(21, 6, 9, 1, 60, '2024-05-20 15:20:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `StudentId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentName` varchar(100) DEFAULT NULL,
  `RollId` int(11) NOT NULL,
  `RegistrationId` varchar(100) NOT NULL,
  `StudentEmail` varchar(100) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Department` varchar(10) NOT NULL,
  `Section` varchar(10) NOT NULL,
  `Series` int(10) NOT NULL,
  `DOB` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  PRIMARY KEY (`StudentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`StudentName`, `RollId`, `RegistrationId`, `StudentEmail`, `Gender`, `Department`, `Section`, `Series`, `DOB`, `Status`) VALUES
('Sarita', 2303006, 'REG12345', 'sarita@university.com', 'Female', 'CSE', 'A', 2023, '1995-03-03', 1),
('Anuj Kumar', 2301006, 'REG67890', 'anuj@university.com', 'Male', 'EEE', 'B', 2023, '1994-02-02', 1),
('Amit Kumar', 2205006, 'REG11223', 'amit@university.com', 'Male', 'ME', 'A', 2022, '1993-08-06', 1),
('Rahul Kumar', 2110006, 'REG44556', 'rahul@university.com', 'Male', 'ECE', 'A', 2021, '1992-02-03', 1),
('Sanjeev Singh',2000006, 'REG77889', 'sanjeev@university.com', 'Male', 'CE', 'B', 2020, '1991-02-03', 1),
('Shiv Gupta', 1903006, 'REG99000', 'shiv@university.com', 'Male', 'CSE', 'A', 2019, '1990-01-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjectcombination`
--

CREATE TABLE `tblsubjectcombination` (
  `id` int(11) NOT NULL,
  `ClassId` int(11) DEFAULT NULL,
  `SubjectId` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `Updationdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubjectcombination`
--

INSERT INTO `tblsubjectcombination` (`id`, `ClassId`, `SubjectId`, `status`, `CreationDate`, `Updationdate`) VALUES
(3, 2, 5, 0, '2024-05-01 10:30:57', '2024-06-07 05:25:49'),
(4, 1, 2, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(5, 1, 4, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(6, 1, 5, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(8, 4, 4, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(10, 4, 1, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(12, 4, 2, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(13, 4, 5, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(14, 6, 1, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(15, 6, 2, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(16, 6, 4, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(17, 6, 6, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(18, 7, 1, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(19, 7, 7, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(20, 7, 2, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(21, 7, 6, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(22, 7, 5, 0, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(23, 8, 1, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(24, 8, 2, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(25, 8, 4, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(26, 8, 6, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(27, 8, 5, 0, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(28, 9, 1, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(29, 9, 2, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(30, 9, 8, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00'),
(31, 9, 8, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `id` int(11) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(100) DEFAULT NULL,
  `CourseCredit` decimal(3,2) DEFAULT NULL,
  `deptName` varchar(100) NOT NULL,
  `Semester` int(1) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`id`, `CourseName`, `CourseCode`, `CourseCredit`, `deptName`, `Semester`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Circuit and Systems-1', 'ECE-1101', '3.00', 'ECE', 1, '2024-07-03 17:49:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclasses`
--
ALTER TABLE `tblclasses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnotice`
--
ALTER TABLE `tblnotice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblresult`
--
ALTER TABLE `tblresult`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`StudentId`);

--
-- Indexes for table `tblsubjectcombination`
--
ALTER TABLE `tblsubjectcombination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY AUTOINCREMENT (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblclasses`
--
ALTER TABLE `tblclasses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblnotice`
--
ALTER TABLE `tblnotice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblresult`
--
ALTER TABLE `tblresult`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `StudentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblsubjectcombination`
--
ALTER TABLE `tblsubjectcombination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
