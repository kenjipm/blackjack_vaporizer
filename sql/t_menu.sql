-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2013 at 03:31 PM
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `t_menu`
--

INSERT INTO `t_menu` (`nama`, `harga`, `harga_min`) VALUES
('Espresso', 10000, 3000),
('Doppio', 16000, 6000),
('Americano', 18000, 7000),
('Classic Black', 14000, 7000),
('Latte Macchiato', 18000, 8000),
('Cappuccino', 20000, 9000),
('Mochaccino', 23000, 11000),
('Caffe Latte', 18000, 8000),
('Vanilla Latte', 20000, 9000),
('Mocha Latte', 22000, 10000),
('Hazelnut Latte', 22000, 10000),
('Caramel Latte', 22000, 10000),
('Caramel Nut Latte', 23000, 10000),
('Choco Vanilla Latte', 23000, 11000),
('Choco Hazelnut Latte', 25000, 12000),
('Choco Caramel Latte', 25000, 12000),
('Iced Americano', 18000, 5000),
('Iced Latte Macchiato', 21000, 10000),
('Iced Cappuccino', 22000, 10000),
('Iced Mochaccino', 26000, 12000),
('Iced Caffe Latte', 22000, 10000),
('Iced Vanilla Latte', 24000, 11000),
('Iced Mocha Latte', 25000, 12000),
('Iced Hazelnut Latte', 25000, 12000),
('Iced Caramel Latte', 25000, 12000),
('Iced Caramel Nut Latte', 26000, 12000),
('Iced Choco Vanilla Latte', 28000, 13000),
('Iced Choco Hazelnut Latte', 28000, 14000),
('Iced Choco Caramel Latte', 28000, 14000),
('Creamy Mocha Latte', 32000, 16000),
('Creamy Choco Vanilla Latte', 34000, 17000),
('Creamy Choco Hazelnut Latte', 35000, 18000),
('Creamy Choco Caramel Latte', 35000, 18000),
('Blacks Passion', 20000, 5000),
('Jacks Favorite', 36000, 19000),
('Caffe Affogato', 20000, 6000),
('Caffe Affogato Vanilla', 24000, 7000),
('Caffe Affogato Caramel', 24000, 8000),
('Caffe Affogato Hazelnut', 24000, 8000),
('Caffe Affogato Chocolate', 24000, 6000),
('Hot Chocolate', 22000, 10000),
('Hot Milk', 18000, 8000),
('Iced Chocolate', 24000, 12000),
('Iced Milk', 21000, 10000),
('Suspenso', 3000, 3000),
('(+) (C) Blacks', 0, 0),
('(+) (C) Jacks', 0, 0),
('(+) (C) Toraja Arabica', 3000, 2000),
('(+) (C) Curup Robusta', 0, 0),
('(+) (C) Strong', 3000, 2000),
('(+) (C) Balance', 3000, 2000),
('(+) (C) Soft', 3000, 2000),
('(+) (C) Romanian King', 4000, 2000),
('(+) (C) Vienna Queen', 4000, 2000),
('(+) (L) [+1] Lv. 2 - Doppio', 6000, 3000),
('(+) (L) [+2] Lv. 3 - Triple', 12000, 6000),
('(+) (L) [+4] Lv. 4 - Extreme', 24000, 12000),
('(+) (L) [+5] Lv. 5 - Hardcore', 30000, 15000),
('(+) (L) [+7] Lv. 6 - BlackJacks Heartbeat', 42000, 21000),
('(+) (L) [+1] Lv. 3 - Triple', 6000, 3000),
('(+) (L) [+3] Lv. 4 - Extreme', 18000, 9000),
('(+) (L) [+4] Lv. 5 - Hardcore', 24000, 12000),
('(+) (L) [+6] Lv. 6 - BlackJacks Heartbeat', 36000, 18000),
('Vanilla Americano', 19000, 8000),
('Hazelnut Americano', 20000, 9000),
('Caramel Americano', 20000, 9000),
('Caramel Nut Americano', 21000, 9000),
('Iced Vanilla Americano', 19000, 8000),
('Iced Hazelnut Americano', 20000, 9000),
('Iced Caramel Americano', 20000, 9000),
('Iced Caramel Nut Americano', 21000, 9000);