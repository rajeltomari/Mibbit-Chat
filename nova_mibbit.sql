-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2010 at 01:34 PM
-- Server version: 5.0.77
-- PHP Version: 5.3.2-1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nova`
--

-- --------------------------------------------------------

--
-- Table structure for table `nova_mibbit`
--

CREATE TABLE IF NOT EXISTS `nova_mibbit` (
  `id` int(9) NOT NULL auto_increment,
  `server_address` varchar(200) default 'irc.kdfs.net',
  `channel` varchar(200) default '#Backroom',
  `widgetid` varchar(200) default '',
  `server_name` varchar(200) default 'KDFSnet',
  `guest_prefix` varchar(200) default 'Guest',
  `stats_page_url` varchar(200) default 'http://neo.us.kdfs.net',
  `height` int(3) default '600',
  `width` int(3) default '450',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `nova_mibbit`
--

INSERT INTO `nova_mibbit` (`id`, `server_address`, `channel`, `widgetid`, `server_name`, `guest_prefix`, `stats_page_url`, `height`, `width`) VALUES
(0, 'fresh.eu.kdfs.net', '#Backroom', '', 'KDFSnet', 'Guest', 'http://neo.us.kdfs.net', 600, 450);
