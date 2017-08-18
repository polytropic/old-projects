-- phpMyAdmin SQL Dump
-- version 4.6.5
-- https://www.phpmyadmin.net/
--
-- Host: lastleaf.deb96project.com
-- Generation Time: May 23, 2017 at 11:48 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `secure_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(8) NOT NULL,
  `cat_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cat_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`) VALUES
(18, 'Introduction', '	Introduce yourself and welcome new members to the forum.'),
(19, 'Teas', '	Tea types and brands, brewing methods, teaware, etc.'),
(20, 'Off Topic', '	Anything goes here.  Keep it civil.');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`user_id`, `time`) VALUES
(4, '1488930577'),
(1, '1489093980'),
(4, '1489891328'),
(5, '1489892543'),
(12, '1493699328');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(8) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(128) COLLATE utf8_unicode_ci NOT NULL,
  `user_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_level` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `password`, `user_date`, `user_level`) VALUES
(11, 'elevPriv', 'elev@elev.com', '2ac9cb7dc02b3c0083eb70898e549b63', '2017-03-28 18:43:16', 1),
(12, 'test', 'test@test.com', '2ac9cb7dc02b3c0083eb70898e549b63', '2017-03-28 18:46:31', 0),
(13, 'teasnob', 'teasnob@tea.com', '2ac9cb7dc02b3c0083eb70898e549b63', '2017-03-28 18:59:25', 0),
(19, 'perks', 'perks54@gmail.com', '7f712e8354db045e34580900ce7d6bac', '2017-05-23 09:58:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(8) NOT NULL,
  `post_content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_content`, `post_date`, `post_topic`, `post_by`) VALUES
(18, 'Welcome to the inaugural LastLeaf forum thread!  ', '2017-03-28 19:07:46', 14, 11),
(19, 'Hello from Wyoming!', '2017-03-28 19:09:23', 14, 12),
(20, 'Hi, everyone!  It gets cold where I live, so I drink tea pretty much all winter long.  I finally decided to join after lurking for a few weeks.  Nice to meet you!', '2017-03-28 19:11:05', 15, 12),
(21, 'I\'m trying to find a nice Earl Grey that doesn\'t have too much bergamot, and is on the affordable side.  Can anyone suggest?', '2017-03-28 19:12:34', 16, 12),
(22, 'Welcome to the forum, test! :)', '2017-03-28 19:14:15', 15, 13),
(23, 'I\'m not having any luck with finding a green tea that is true to its name.  I tried LastLeaf\'s gunpowder green, but it was far from up to snuff.  Has anyone found something that was actually good AND green?', '2017-03-28 19:15:54', 17, 13),
(28, 'Are you looking for a creme Earl Grey?  Argo Teas has one that\'s pretty good.', '2017-03-28 19:25:43', 16, 13),
(32, 'Not sure if there is such a thing', '2017-05-23 10:01:30', 20, 19),
(33, 'What is red tea I think it is made up', '2017-05-23 10:01:49', 20, 19);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `review` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `review_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `username`, `review`, `review_date`, `image`) VALUES
(301, 1, 'test', 'This is a test review.  It is limited to 255 characters and strips out html tags and nulls.  An empty review cannot be submitted, and you must be logged in to submit.  ', '2017-03-28 22:55:05', 'images/blackteaimagesmall.jpg'),
(302, 1, 'test', 'You can submit a review with no photo attached.  If you do attach a file, it will be uploaded if it is an image type file that meets the size requirements.  Otherwise, your text alone will be uploaded.  Images display as a thumbnail linking to fullsize.', '2017-03-28 22:56:31', NULL),
(303, 2, 'test', 'This is one of my favorite green teas.  It&#39;s refreshing without becoming too bitter.', '2017-03-28 22:57:57', 'images/greenteaimage1.jpg'),
(304, 2, 'teasnob', 'This tea offended my sensibilities.  When you brew it, the color is not green at all!  More of a tan, really.  False advertising.', '2017-03-28 23:00:49', NULL),
(305, 3, 'teasnob', 'Read the fine print.  There&#39;s no tea in this; only herbal decaf ingredients.  This should be labeled as a tisane, not a tea!', '2017-03-28 23:02:35', NULL),
(315, 1, 'perks', 'I like Black tea and this is a good choice', '2017-05-23 16:59:32', NULL),
(316, 1, 'perks', 'This is a test with submitting an image', '2017-05-23 17:00:09', 'images/kitty.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(8) NOT NULL,
  `topic_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_cat` int(8) NOT NULL,
  `topic_by` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_subject`, `topic_date`, `topic_cat`, `topic_by`) VALUES
(14, 'Introductions Thread', '2017-03-28 19:07:46', 18, 11),
(15, 'Hello', '2017-03-28 19:11:05', 18, 12),
(16, 'Suggestions for Earl Grey?', '2017-03-28 19:12:34', 19, 12),
(17, 'Green tea that is actually green', '2017-03-28 19:15:54', 19, 13),
(20, 'Red Tea', '2017-05-23 10:01:30', 19, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name_unique` (`cat_name`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_topic` (`post_topic`),
  ADD KEY `post_by` (`post_by`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topic_cat` (`topic_cat`),
  ADD KEY `topic_by` (`topic_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_topic`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_by`) REFERENCES `members` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`topic_cat`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_by`) REFERENCES `members` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
