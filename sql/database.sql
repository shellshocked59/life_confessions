-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2011 at 06:29 AM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `life_confessions`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto',
  `tumblr_id` int(11) NOT NULL COMMENT 'global',
  `url` text NOT NULL COMMENT 'global',
  `type` varchar(50) NOT NULL COMMENT 'global',
  `date` datetime NOT NULL COMMENT 'global',
  `unix_timestamp` datetime NOT NULL COMMENT 'global',
  `feed_item` varchar(255) NOT NULL COMMENT 'global',
  `reblog_key` varchar(50) NOT NULL COMMENT 'global',
  `slug` varchar(255) NOT NULL COMMENT 'global',
  `caption` text NOT NULL COMMENT 'global',
  `orgin` varchar(255) NOT NULL,
  `image_1280` varchar(255) NOT NULL COMMENT 'photo - local HQ image',
  `title` varchar(255) NOT NULL COMMENT 'reg & convo & link',
  `content` text NOT NULL,
  `video_player` text NOT NULL COMMENT 'video iframe',
  `audio_plays` int(11) NOT NULL COMMENT 'audio',
  `audio_artist` varchar(255) NOT NULL COMMENT 'audio',
  `audio_album` varchar(255) NOT NULL COMMENT 'audio',
  `audio_year` varchar(255) NOT NULL COMMENT 'audio',
  `audio_track` varchar(255) NOT NULL COMMENT 'audio',
  `audio_title` varchar(255) NOT NULL COMMENT 'audio',
  `created` datetime NOT NULL COMMENT 'auto',
  `modified` datetime NOT NULL COMMENT 'auto',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts_conversations`
--

CREATE TABLE IF NOT EXISTS `posts_conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `phrase` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts_conversations`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts_photos`
--

CREATE TABLE IF NOT EXISTS `posts_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `caption` int(11) NOT NULL,
  `offset` int(11) NOT NULL,
  `image_1280` varchar(255) NOT NULL,
  `image_500` varchar(255) NOT NULL,
  `image_400` varchar(255) NOT NULL,
  `image_250` varchar(255) NOT NULL,
  `image_100` varchar(255) NOT NULL,
  `image_75` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts_photos`
--


-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tags`
--


-- --------------------------------------------------------

--
-- Table structure for table `tags_posts`
--

CREATE TABLE IF NOT EXISTS `tags_posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

