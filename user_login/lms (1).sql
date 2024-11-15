-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 04:36 AM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookorder`
--

CREATE TABLE `bookorder` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `isreturn` int(11) NOT NULL DEFAULT 0,
  `istaken` int(11) NOT NULL DEFAULT 0,
  `userid` int(11) DEFAULT NULL,
  `bookid` int(11) DEFAULT NULL,
  `date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookorder`
--

INSERT INTO `bookorder` (`id`, `username`, `isreturn`, `istaken`, `userid`, `bookid`, `date`) VALUES
(81, 'admin', 0, 1, 18, 52, '2023-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `bname` varchar(50) NOT NULL,
  `bauthor` varchar(100) NOT NULL,
  `bquantity` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `subcategoryid` int(11) NOT NULL,
  `bpublishdate` date NOT NULL,
  `categoryName` varchar(50) NOT NULL,
  `subcategoryName` varchar(50) NOT NULL,
  `bimage` text NOT NULL,
  `pubName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `bname`, `bauthor`, `bquantity`, `categoryid`, `subcategoryid`, `bpublishdate`, `categoryName`, `subcategoryName`, `bimage`, `pubName`) VALUES
(52, 'Operating System', 'Bhupendra Singh Saud', 43, 19, 49, '2023-06-29', 'BCA', '4th Semester', 'http://localhost/lms/admin/uploads/649d9eb21519b.jpg', 'ASMITA');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cname`) VALUES
(19, 'BCA'),
(20, 'BBA'),
(21, 'BBS'),
(22, 'BBM'),
(23, 'BHM'),
(24, 'BSW'),
(25, 'BIT'),
(26, '+2 Science'),
(27, '+2 Management'),
(28, '+2 Humanities'),
(29, '+2 Hotel Management'),
(30, 'Bsc.CSIT');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `cont_fname` varchar(50) NOT NULL,
  `cont_lname` varchar(50) NOT NULL,
  `cont_email` varchar(50) NOT NULL,
  `cont_phone` bigint(11) NOT NULL,
  `cont_message` varchar(255) NOT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `cont_fname`, `cont_lname`, `cont_email`, `cont_phone`, `cont_message`, `userid`) VALUES
(15, 'RajKumar', 'Rai', 'rrai86189@gmail.com', 9854532450, 'This is full of sit', 18),
(17, 'Raj', 'Rai', 'rrai86189@gmail.com', 985453245, ',afjhiu', 18),
(18, 'RajKumar Rau', 'mdbhf', 'admin@gmail.com', 985453245, 'mafyg', 18);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `subcatname` varchar(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `cId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `subcatname`, `cname`, `cId`) VALUES
(44, '1st Semester', 'BCA', 19),
(47, '2nd Semester', 'BCA', 19),
(48, '3rd Semester', 'BCA', 19),
(49, '4th Semester', 'BCA', 19),
(50, '5th Semester', 'BCA', 19),
(51, '6th Semester', 'BCA', 19),
(52, '7th Semester', 'BCA', 19),
(53, '8th Semester', 'BCA', 19),
(54, '1st year', 'BBS', 21),
(55, '2nd year', 'BBS', 21),
(56, '3rd year', 'BBS', 21),
(57, '4th year', 'BBS', 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phnumber` bigint(15) NOT NULL,
  `status` int(11) NOT NULL,
  `restriction` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phnumber`, `status`, `restriction`) VALUES
(18, 'admin', 'admin@gmail.com', '$2y$10$SYc7s2Zf27p5zYE.l0kqiO/Y77YCv6CvavvYUi0LEDjR/zoyBUztq', 9823551077, 1, 0),
(19, 'Raj Kumar Rai', 'rrai86189@gmail.com', '$2y$10$SKWRku6S1phkuzna0jRNsugqecgsWM3HGmIsxsoR.qJfncAJ30Nau', 9823551077, 2, 0),
(26, 'raj', 'raj@gmail.com', '$2y$10$/KyIv9KQ015HvBr6JUzNGejqT7Yk0xOAjfqhJxXljIzyY400nqOry', 9823551077, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookorder`
--
ALTER TABLE `bookorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bookorder_users` (`userid`),
  ADD KEY `fk_bookorder_books` (`bookid`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_category` (`categoryid`),
  ADD KEY `fk_books_subcategory` (`subcategoryid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contactus_users` (`userid`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subcategory_category` (`cId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookorder`
--
ALTER TABLE `bookorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookorder`
--
ALTER TABLE `bookorder`
  ADD CONSTRAINT `fk_bookorder_books` FOREIGN KEY (`bookid`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_bookorder_users` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`categoryid`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `fk_books_subcategory` FOREIGN KEY (`subcategoryid`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `contactus`
--
ALTER TABLE `contactus`
  ADD CONSTRAINT `fk_contactus_users` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `fk_subcategory_category` FOREIGN KEY (`cId`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
