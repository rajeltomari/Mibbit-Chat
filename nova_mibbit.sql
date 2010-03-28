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
  `mibbit_id` int(5) NOT NULL auto_increment,
  `mibbit_key` varchar(100) default '',
  `mibbit_value` text,
  PRIMARY KEY  (`mibbit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `nova_mibbit`
--

INSERT INTO `nova_mibbit` (`mibbit_id`, `mibbit_key`, `mibbit_value`, `mibbit_label`) VALUES
(1, 'server_address', 'fresh.eu.kdfs.net'),
(2, 'channel', '#Backroom'),
(3, 'widgetid', ''),
(4, 'server_name', 'KDFSnet'),
(5, 'guest_prefix', 'Guest'),
(6, 'stats_page_url', 'http://neo.us.kdfs.net'),
(7, 'height', 600),
(8, 'width', 450);
