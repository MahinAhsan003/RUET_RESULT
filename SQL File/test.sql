
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', 'f925916e2754e5e03f75dd58a5733251', '2024-03-10 10:30:57');


CREATE TABLE `tbldept` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Department` varchar(100) NOT NULL,  -- Updated length to match other tables
  `deptCode` varchar(2) NOT NULL,
  UNIQUE KEY (`Department`)  -- Added unique constraint for foreign key reference
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tblclasses` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Department` varchar(100) DEFAULT NULL,  -- Updated length to match tbldept
  `Series` int(4) DEFAULT NULL,
  `Section` varchar(5) DEFAULT NULL,
  `Semester` int(5) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`Department`) REFERENCES `tbldept`(`Department`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tblteachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `TeacherId` varchar(80) NOT NULL,
  `TeacherName` varchar(100) DEFAULT NULL,
  `TeacherEmail` varchar(100) DEFAULT NULL,
  `TeacherPhone` varchar(15) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,  -- Updated length to match tbldept
  `JoiningDate` varchar(100) DEFAULT NULL,
  `Designation` varchar(100) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  FOREIGN KEY (`Department`) REFERENCES `tbldept`(`Department`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tblnotice` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `noticeTitle` varchar(255) DEFAULT NULL,
  `noticeDetails` mediumtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `tblstudents` (
  `StudentId` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `StudentName` VARCHAR(100) DEFAULT NULL,
  `RollId` INT(11) NOT NULL UNIQUE,
  `RegistrationId` VARCHAR(100) NOT NULL,
  `StudentEmail` VARCHAR(100) DEFAULT NULL,
  `Gender` VARCHAR(10) DEFAULT NULL,
  `Department` VARCHAR(10) NOT NULL,
  `Section` VARCHAR(10) NOT NULL,
  `Series` INT(10) NOT NULL,
  `DOB` VARCHAR(100) DEFAULT NULL,
  `FatherName` VARCHAR(100) DEFAULT NULL,
  `MotherName` VARCHAR(100) DEFAULT NULL,
  `Contact` VARCHAR(15) DEFAULT NULL,
  `RegDate` TIMESTAMP NULL DEFAULT current_timestamp(),
  `UpdationDate` TIMESTAMP NULL DEFAULT NULL,
  `Status` INT(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tblsubjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(100) DEFAULT NULL,
  `CourseCredit` decimal(3,2) DEFAULT NULL,
  `Department` varchar(100) NOT NULL,  -- Updated length to match tbldept
  `Semester` int(1) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`Department`) REFERENCES `tbldept`(`Department`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tblresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `StudentId` int(11) DEFAULT NULL,
  `ClassId` int(11) DEFAULT NULL,
  `SubjectId` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`StudentId`) REFERENCES `tblstudents`(`StudentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`ClassId`) REFERENCES `tblclasses`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`SubjectId`) REFERENCES `tblsubjects`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tblregistration` (
  `RollId` INT(11) NOT NULL,
  `Semester` VARCHAR(20) NOT NULL,
  `RegisteredCourses` TEXT NOT NULL,
  `RegistrationStatus` INT DEFAULT 0,
  PRIMARY KEY (`RollId`, `Semester`),
  FOREIGN KEY (`RollId`) REFERENCES `tblstudents`(`RollId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE tblregistrationqueue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    RollId INT(11) NOT NULL,  -- Updated to INT to match tblstudents
    Semester VARCHAR(20) NOT NULL,
    RegisteredCourses TEXT NOT NULL,
    RegistrationStatus INT DEFAULT 0,  -- Default to 0 (pending)
    RegistrationTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RollId) REFERENCES tblstudents(RollId) ON DELETE CASCADE ON UPDATE CASCADE  -- Added foreign key constraint
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



ALTER TABLE `tblclasses`
ADD CONSTRAINT `fk_tblclasses_department`
FOREIGN KEY (`Department`) REFERENCES `tbldept`(`Department`)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tblteachers`
ADD CONSTRAINT `fk_tblteachers_department`
FOREIGN KEY (`Department`) REFERENCES `tbldept`(`Department`)
ON DELETE CASCADE ON UPDATE CASCADE;


COMMIT;
