SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Table structure for table `wpsd_clients`
--

DROP TABLE IF EXISTS `wpsd_clients`;
CREATE TABLE IF NOT EXISTS `wpsd_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) DEFAULT NULL,
  `client_url` varchar(200) DEFAULT NULL,
  `client_order` int(11) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;