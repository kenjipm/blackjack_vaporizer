-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2014 at 11:02 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blackjack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
--

CREATE TABLE IF NOT EXISTS `t_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(64) NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_min` int(11) NOT NULL,
  `harga_base` int(11) NOT NULL DEFAULT '0',
  `harga_setor` int(11) NOT NULL,
  `nama_setor` varchar(32) NOT NULL,
  `default_discounted` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=415 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_order`
--

CREATE TABLE IF NOT EXISTS `t_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_pembeli` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nama_pembeli` varchar(32) NOT NULL,
  `keterangan` varchar(64) NOT NULL,
  `default_discount` int(11) NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL,
  `session_no` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1349 ;

--
-- Triggers `t_order`
--
DROP TRIGGER IF EXISTS `add_jumlah_pembeli`;
DELIMITER //
CREATE TRIGGER `add_jumlah_pembeli` AFTER INSERT ON `t_order`
 FOR EACH ROW BEGIN
UPDATE variabel 
SET jumlah_pembeli = jumlah_pembeli  + 1;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_order_menu`
--

CREATE TABLE IF NOT EXISTS `t_order_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `menu_sequence` int(11) NOT NULL,
  `keterangan` varchar(64) NOT NULL,
  `harga_awal` int(11) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `harga` int(11) NOT NULL,
  `harga_min` int(11) NOT NULL,
  `harga_base` int(11) NOT NULL DEFAULT '0',
  `harga_setor` int(11) NOT NULL,
  `nama_setor` varchar(32) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `waktu_done` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5814 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_order_paket`
--

CREATE TABLE IF NOT EXISTS `t_order_paket` (
  `id_order` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `keterangan` varchar(64) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_order_paket_menu`
--

CREATE TABLE IF NOT EXISTS `t_order_paket_menu` (
  `id_order_paket` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `keterangan` varchar(64) NOT NULL,
  `done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_paket`
--

CREATE TABLE IF NOT EXISTS `t_paket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(32) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_paket_menu`
--

CREATE TABLE IF NOT EXISTS `t_paket_menu` (
  `id_paket` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` varchar(32) NOT NULL,
  `alamat` varchar(64) NOT NULL,
  `kota` varchar(32) NOT NULL,
  `telepon` varchar(64) NOT NULL,
  `header` varchar(256) NOT NULL,
  `header2` varchar(256) NOT NULL,
  `footer` varchar(256) NOT NULL,
  `footer2` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `variabel`
--

CREATE TABLE IF NOT EXISTS `variabel` (
  `jumlah_pembeli` int(11) NOT NULL,
  `id_order_last_session` int(11) NOT NULL,
  `session_no` int(11) NOT NULL,
  `no_pembeli_multiplier` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
