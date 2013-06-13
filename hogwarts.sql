-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 13, 2013 at 02:22 PM
-- Server version: 5.5.31
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hogwarts`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE IF NOT EXISTS `assessment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`id`, `student_id`, `teacher_id`, `subject_id`, `grade_id`, `date`) VALUES
(10, 2, 34, 5, 1, '0000-00-00'),
(14, 1, 36, 10, 1, '1992-06-08'),
(15, 1, 36, 10, 1, '1992-03-15'),
(24, 1, 33, 13, 1, '1992-06-08'),
(25, 4, 35, 1, 1, '1992-06-08'),
(40, 2, 34, 5, 1, '1992-06-09'),
(42, 1, 35, 1, 1, '1992-06-09'),
(43, 1, 35, 1, 1, '1992-06-09'),
(45, 2, 35, 1, 1, '1992-06-09'),
(46, 2, 35, 1, 1, '1992-06-09'),
(47, 2, 35, 1, 1, '1992-06-09'),
(48, 1, 35, 1, 1, '1992-06-09'),
(49, 1, 33, 13, 1, '1992-06-09'),
(50, 25, 33, 13, 1, '1992-06-09'),
(51, 21, 33, 13, 1, '1992-06-09'),
(52, 12, 35, 1, 1, '1992-06-09'),
(53, 14, 35, 1, 1, '1992-06-09'),
(54, 13, 35, 1, 1, '1992-06-09'),
(57, 4, 34, 5, 1, '1992-06-09'),
(58, 4, 34, 5, 1, '1992-06-09'),
(59, 3, 34, 5, 1, '1992-06-09'),
(60, 3, 34, 5, 1, '1992-06-09'),
(61, 17, 34, 5, 1, '1992-06-09'),
(62, 10, 34, 5, 1, '1992-06-09'),
(63, 1, 34, 5, 1, '1992-06-09'),
(64, 1, 36, 10, 1, '1992-06-09'),
(65, 8, 34, 5, 1, '1992-06-09'),
(66, 3, 34, 5, 1, '1992-06-09'),
(68, 6, 33, 13, 1, '1992-06-01'),
(69, 3, 33, 13, 1, '1992-06-09'),
(70, 2, 36, 10, 1, '1992-06-09'),
(71, 3, 36, 10, 1, '1992-06-09'),
(79, 6, 34, 5, 3, '1992-06-09'),
(81, 3, 35, 1, 2, '1992-06-07'),
(82, 6, 34, 5, 1, '1992-06-10'),
(83, 6, 34, 5, 2, '1992-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` varchar(32) DEFAULT NULL,
  `passing` tinyint(1) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `grade`, `passing`, `position`) VALUES
(1, 'Outstanding', 1, 1),
(2, 'Exceeds Expectations', 1, 2),
(3, 'Acceptable', 1, 3),
(4, 'Poor', 0, 4),
(5, 'Dreadful', 0, 5),
(6, 'Troll', 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `house`
--

CREATE TABLE IF NOT EXISTS `house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `house`
--

INSERT INTO `house` (`id`, `house`) VALUES
(1, 'Gryffindor'),
(2, 'Ravenclaw'),
(3, 'Hufflepuff'),
(4, 'Slytherin');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `first_name`, `last_name`, `image`) VALUES
(1, 'Lavender', 'Brown', NULL),
(2, 'Seamus', 'Finnigan', NULL),
(3, 'Hermione', 'Granger', '/client/school/resources/images/person/Hermione_Granger.jpg'),
(4, 'Neville', 'Longbottom', NULL),
(5, 'Parvati', 'Patil', NULL),
(6, 'Harry', 'Potter', '/client/school/resources/images/person/Harry_Potter.jpg'),
(7, 'Dean', 'Thomas', NULL),
(8, 'Ronald', 'Weasley', NULL),
(9, 'Terry', 'Boot', NULL),
(10, 'Mandy', 'Brocklehurst', NULL),
(11, 'Michael', 'Corner', NULL),
(12, 'Stephen', 'Cornfoot', NULL),
(13, 'Kevin', 'Entwhistle', NULL),
(14, 'Anthony', 'Goldstein', NULL),
(15, 'Su', 'Li', NULL),
(16, 'Morag', 'McDougal', NULL),
(17, 'Padma', 'Patil', NULL),
(18, 'Lisa', 'Turpin', NULL),
(19, 'Wayne', 'Hopkins', NULL),
(20, 'Megan', 'Jones', NULL),
(21, 'Ernie', 'Macmillan', NULL),
(22, 'Hannah', 'Abbott', NULL),
(23, 'Susan', 'Bones', NULL),
(24, 'Millicent', 'Bulstrode', NULL),
(25, 'Vincent', 'Crabbe', NULL),
(26, 'Tracey', 'Davis', NULL),
(27, 'Gregory', 'Goyle', NULL),
(28, 'Daphne', 'Greengrass', NULL),
(29, 'Draco', 'Malfoy', NULL),
(30, 'Theodore', 'Nott', NULL),
(31, 'Pansy', 'Parkinson', NULL),
(32, 'Blaise', 'Zabini', NULL),
(33, 'Silvanus', 'Kettleburn', NULL),
(34, 'Quirinus', 'Quirrell', NULL),
(35, 'Minerva', 'McGonagall', NULL),
(36, 'Charity', 'Burbage', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) DEFAULT NULL,
  `house_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `year`, `house_id`, `person_id`) VALUES
(1, 1991, 1, 1),
(2, 1991, 1, 2),
(3, 1991, 1, 3),
(4, 1991, 1, 4),
(5, 1991, 1, 5),
(6, 1991, 1, 6),
(7, 1991, 1, 7),
(8, 1991, 1, 8),
(9, 1991, 2, 9),
(10, 1991, 2, 10),
(11, 1991, 2, 11),
(12, 1991, 2, 12),
(13, 1991, 2, 13),
(14, 1991, 2, 14),
(15, 1991, 2, 15),
(16, 1991, 2, 16),
(17, 1991, 2, 17),
(18, 1991, 2, 18),
(19, 1991, 3, 19),
(20, 1991, 3, 20),
(21, 1991, 3, 21),
(22, 1991, 3, 22),
(23, 1991, 3, 23),
(24, 1991, 4, 24),
(25, 1991, 4, 25),
(26, 1991, 4, 26),
(27, 1991, 4, 27),
(28, 1991, 4, 28),
(29, 1991, 4, 29),
(30, 1991, 4, 30);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(32) DEFAULT NULL,
  `color` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subject`, `color`) VALUES
(1, 'Transfiguration', '#3366FF'),
(2, 'Charms', '#6633FF'),
(3, 'Potions', '#CC33FF'),
(4, 'History of Magic', '#FF33CC'),
(5, 'Defence Against the Dark Arts', '#33CCFF'),
(6, 'Astronomy', '#FF6633'),
(7, 'Herbology', '#33FF66'),
(8, 'Flying', '#B88A00'),
(9, 'Arithmancy', '#FF3366'),
(10, 'Muggle Studies', '#52A300'),
(11, 'Divination', '#E495CA'),
(12, 'Study of Ancient Runes', '#334D66'),
(13, 'Care of Magical Creatures', '#AD0000');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `person_id`, `year`, `subject_id`) VALUES
(1, 33, 1991, 13),
(2, 34, 1991, 5),
(3, 35, 1991, 1),
(4, 36, 1991, 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
