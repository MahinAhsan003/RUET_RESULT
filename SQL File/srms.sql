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

CREATE TABLE tblstudents (
  StudentId INT(11) NOT NULL AUTO_INCREMENT,
  StudentName VARCHAR(100) DEFAULT NULL,
  RollId INT(11) NOT NULL,
  RegistrationId VARCHAR(100) NOT NULL,
  StudentEmail VARCHAR(100) DEFAULT NULL,
  Gender VARCHAR(10) DEFAULT NULL,
  Department VARCHAR(10) NOT NULL,
  Section VARCHAR(10) NOT NULL,
  Series INT(10) NOT NULL,
  DOB VARCHAR(100) DEFAULT NULL,
  FatherName VARCHAR(100) DEFAULT NULL,
  MotherName VARCHAR(100) DEFAULT NULL,
  Contact VARCHAR(110) DEFAULT NULL,
  RegDate TIMESTAMP NULL DEFAULT current_timestamp(),
  UpdationDate TIMESTAMP NULL DEFAULT NULL,
  Status INT(1) DEFAULT NULL,
  PRIMARY KEY (StudentId),
  UNIQUE KEY (RollId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`StudentName`, `RollId`, `RegistrationId`, `StudentEmail`, `Gender`, `Department`, `Section`, `Series`, `DOB`, `FatherName`, `MotherName`,`Contact`, `Status`) VALUES
('Rahul Debnath', 2010001, '1055', '2010001@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-03-03','Test', 'Test', '01912153465', 1),
('Humayra Tasnim Adiba', 2010002, '1056', '2010002@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1994-02-02', 'Test', 'Test', '01912153465', 1),
('Mahin Ahsan', 2010003, '1057', '2010003@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-08-06', 'Test', 'Test', '01912153465', 1),
('Kamrul Islam', 2010004, '1058', '2010004@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1992-02-03', 'Test', 'Test', '01912153465', 1),
('Maysha Iyasmin', 2010005, '1059', '2010005@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1991-02-03', 'Test', 'Test', '01912153465', 1),
('Md. Jonayed Dewan', 2010006, '1060', '2010006@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1990-01-12', 'Test', 'Test', '01912153465', 1),
('Md. Tanjim Jahan Joy', 2010007, '1061', '2010007@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-04-01', 'Test', 'Test', '01912153465', 1),
('Sahriar Abdur Rahman Shaon', 2010008, '1062', '2010008@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-07-15', 'Test', 'Test', '01912153465', 1),
('Mst. Tahmina Akter', 2010009, '1063', '2010009@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-10-30', 'Test', 'Test', '01912153465', 1),
('Samira Khan', 2010010, '1064', '2010010@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-01-22', 'Test', 'Test', '01912153465', 1),
('Durjoy Saha', 2010011, '1065', '2010011@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-03-14', 'Test', 'Test', '01912153465', 1),
('Sajid Rahman', 2010012, '1066', '2010012@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-05-27', 'Test', 'Test', '01912153465', 1),
('Sirajum Munir', 2010013, '1067', '2010013@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-08-10', 'Test', 'Test', '01912153465', 1),
('Ziharul Islam Rifath', 2010014, '1068', '2010014@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-11-23', 'Test', 'Test', '01912153465', 1),
('Iyasin Arafat', 2010015, '1069', '2010015@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-02-14', 'Test', 'Test', '01912153465', 1),
('Md. Tawhidul Islam', 2010016, '1070', '2010016@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-06-05', 'Test', 'Test', '01912153465', 1),
('Md. Mohtasim Fuad', 2010017, '1071', '2010017@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-09-18', 'Test', 'Test', '01912153465', 1),
('Anika Tabassum Tuba', 2010018, '1072', '2010018@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-12-29', 'Test', 'Test', '01912153465', 1),
('Md. Ashikul Islam', 2010019, '1073', '2010019@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-03-12', 'Test', 'Test', '01912153465', 1),
('Khondokar Radwanur Rahman', 2010020, '1074', '2010020@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-07-03', 'Test', 'Test', '01912153465', 1),
('Joshua Adams', 2010021, '1075', '2010021@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-10-16', 'Test', 'Test', '01912153465', 1),
('Olivia Baker', 2010022, '1076', '2010022@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-01-07', 'Test', 'Test', '01912153465', 1),
('Ethan Nelson', 2010023, '1077', '2010023@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-04-19', 'Test', 'Test', '01912153465', 1),
('Samantha Green', 2010024, '1078', '2010024@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-07-31', 'Test', 'Test', '01912153465', 1),
('Matthew Perez', 2010025, '1079', '2010025@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-09-02', 'Test', 'Test', '01912153465', 1),
('Ashley Hill', 2010026, '1080', '2010026@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-12-15', 'Test', 'Test', '01912153465', 1),
('Ryan Wright', 2010027, '1081', '2010027@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-03-28', 'Test', 'Test', '01912153465', 1),
('Emma Martinez', 2010028, '1082', '2010028@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-06-10', 'Test', 'Test', '01912153465', 1),
('Benjamin Hernandez', 2010029, '1083', '2010029@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-09-23', 'Test', 'Test', '01912153465', 1),
('Madison Carter', 2010030, '1084', '2010030@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-12-04', 'Test', 'Test', '01912153465', 1),
('Andrew Phillips', 2010031, '1085', '2010031@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-03-17', 'Test', 'Test', '01912153465', 1),
('Alyssa Campbell', 2010032, '1086', '2010032@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-06-08', 'Test', 'Test', '01912153465', 1),
('Jacob Parker', 2010033, '1087', '2010033@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-09-21', 'Test', 'Test', '01912153465', 1),
('Sophia Evans', 2010034, '1088', '2010034@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-12-02', 'Test', 'Test', '01912153465', 1),
('Alexander Roberts', 2010035, '1089', '2010035@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-03-05', 'Test', 'Test', '01912153465', 1),
('Chloe Ramirez', 2010036, '1090', '2010036@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-06-27', 'Test', 'Test', '01912153465', 1),
('Mason Rivera', 2010037, '1091', '2010037@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-09-09', 'Test', 'Test', '01912153465', 1),
('Isabella Campbell', 2010038, '1092', '2010038@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-12-20', 'Test', 'Test', '01912153465', 1),
('Liam Kelly', 2010039, '1093', '2010039@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-03-03', 'Test', 'Test', '01912153465', 1),
('Abigail Flores', 2010040, '1094', '2010040@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-06-12', 'Test', 'Test', '01912153465', 1),
('Evan Sanders', 2010041, '1095', '2010041@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-09-25', 'Test', 'Test', '01912153465', 1),
('Mia Price', 2010042, '1096', '2010042@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-12-06', 'Test', 'Test', '01912153465', 1),
('Aiden Bennett', 2010043, '1097', '2010043@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-04-08', 'Test', 'Test', '01912153465', 1),
('Ella Lee', 2010044, '1098', '2010044@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-07-11', 'Test', 'Test', '01912153465', 1),
('Lucas Jenkins', 2010045, '1099', '2010045@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-10-24', 'Test', 'Test', '01912153465', 1),
('Grace Richardson', 2010046, '1100', '2010046@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-01-15', 'Test', 'Test', '01912153465', 1),
('Noah Barnes', 2010047, '1101', '2010047@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-04-28', 'Test', 'Test', '01912153465', 1),
('Ava Ross', 2010048, '1102', '2010048@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-08-10', 'Test', 'Test', '01912153465', 1),
('Logan Peterson', 2010049, '1103', '2010049@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-11-23', 'Test', 'Test', '01912153465', 1),
('Emily Morgan', 2010050, '1104', '2010050@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-02-05', 'Test', 'Test', '01912153465', 1),
('Dylan Scott', 2010051, '1105', '2010051@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-05-18', 'Test', 'Test', '01912153465', 1),
('Madison White', 2010052, '1106', '2010052@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-08-30', 'Test', 'Test', '01912153465', 1),
('Jackson Nelson', 2010053, '1107', '2010053@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-11-12', 'Test', 'Test', '01912153465', 1),
('Lily Thomas', 2010054, '1108', '2010054@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-03-25', 'Test', 'Test', '01912153465', 1),
('Ryan Allen', 2010055, '1109', '2010055@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-06-07', 'Test', 'Test', '01912153465', 1),
('Natalie King', 2010056, '1110', '2010056@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1994-09-19', 'Test', 'Test', '01912153465', 1),
('Brayden Wright', 2010057, '1111', '2010057@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1993-12-02', 'Test', 'Test', '01912153465', 1),
('Sofia Lopez', 2010058, '1112', '2010058@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1992-03-16', 'Test', 'Test', '01912153465', 1),
('Zachary Harris', 2010059, '1113', '2010059@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1991-06-29', 'Test', 'Test', '01912153465', 1),
('Avery Martinez', 2010060, '1114', '2010060@student.ruet.ac.bd', 'Female', 'ECE', 'A', 2020, '1990-09-01', 'Test', 'Test', '01912153465', 1),
('Isaac Thompson', 2010061, '1115', '2010061@student.ruet.ac.bd', 'Male', 'ECE', 'A', 2020, '1995-12-15', 'Test', 'Test', '01912153465', 1);


-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(100) DEFAULT NULL,
  `CourseCredit` decimal(3,2) DEFAULT NULL,
  `Department` varchar(100) NOT NULL, 
  `Semester` int(1) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`id`, `CourseName`, `CourseCode`, `CourseCredit`, `Department`, `Semester`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Circuit and Systems-I', 'ECE-1101', '3.00', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(2, 'Circuit and Systems-I Sessional', 'ECE-1102', '1.5', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(3, 'Computer Programming', 'ECE-1103', '3.00', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(4, 'Computer Programming Sessional', 'ECE-1104', '1.5', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(5, 'Calculus and Ordinary Differential Equation', 'MATH-1117', '3.00', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(6, 'Optics and Modern Physics', 'PHY-1117', '3.00', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(7, 'Optics and Modern', 'PHY-1118', '0.75', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(8, 'Technical English', 'HUM-117', '3.00', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(9, 'Technical English Sessional', 'HUM-1118', '0.75', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(10, 'Introduction to Computer System', 'ECE-1100', '0.75', 'ECE', 1, '2024-07-03 17:49:58', NULL),
(11, 'Circuits and Systems-II', 'ECE-1201', '3.00', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(12, 'Circuit and Systems-II Sessional', 'ECE-1202', '0.75', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(13, 'Object Oriented Programming', 'ECE-1203', '3.00', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(14, 'Object Oriented Programming Sessional', 'ECE-1104', '1.5', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(15, 'Analog Electronic Circuits-I', 'ECE-1205', '3.00', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(16, 'Analog Electronic Circuits-I Sessional', 'ECE-1206', '0.75', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(17, 'Transform Methods, Statistics & Complex Variable', 'MATH-1217', '3.00', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(18, 'Government, Sociology, Environment Protection & History of Independence', 'HUM-1217', '3.00', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(19, 'Engineering Ethics', 'ECE-1200', '0.75', 'ECE', 2, '2024-07-03 17:49:58', NULL),
(20, 'Data Structure & Algorithms', 'ECE-2101', '3.00', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(21, 'Data Structure & Algorithms Sessional', 'ECE-2102', '1.5', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(22, 'Analog Electronic Circuits-II', 'ECE-2105', '3.00', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(23, 'Analog Electronic Circuits-II Sessional', 'ECE-2106', '0.75', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(24, 'Digital Techniques', 'ECE-2111', '3.00', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(25, 'Digital Techniques Sessional', 'ECE-2112', '0.75', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(26, 'Vector Analysis & Linear Algebra', 'MATH-2117', '3.00', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(27, 'Inorganic and Physical Chemistry', 'CHEM-2117', '3.00', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(28, 'Inorganic and Physical Chemistry Sessional', 'CHEM-2118', '0.75', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(29, 'Software Development Project- I', 'ECE-2100', '0.75', 'ECE', 3, '2024-07-03 17:49:58', NULL),
(30, 'Electrical Machine-I', 'ECE-2207', '3.00', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(31, 'Electrical Machine-I Sessional', 'ECE-2208', '0.75', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(32, 'Numerical Methods & Discrete Mathematics', 'ECE-2213', '3.00', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(33, 'Numerical Methods & Discrete Mathematics Sessional', 'ECE-2214', '1.50', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(34, 'Data Base Systems', 'ECE-2215', '3.00', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(35, 'Data Base Systems Sessional', 'ECE-2216', '1.50', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(36, 'Co-ordinate Geometry & Partial Differential Equations', 'MATH-2217', '3.00', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(37, 'Legal Issues, Industrial & Operational Management', 'ECE-2217', '3.00', 'ECE', 4, '2024-07-03 17:49:58', NULL),
(38, 'Electronic Shop Practice', 'ECE-2200', '1.50', 'ECE', 4, '2024-07-03 17:49:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE tblregistration (
    RollId INT NOT NULL,
    Semester VARCHAR(20) NOT NULL,
    RegisteredCourses TEXT NOT NULL,
    RegistrationStatus INT DEFAULT 0,
    PRIMARY KEY (RollId, Semester),
    FOREIGN KEY (RollId) REFERENCES tblstudents(RollId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Dumping data for table `tblsubjects`
--


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
  ADD PRIMARY KEY AUTO_INCREMENT (`id`);

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
