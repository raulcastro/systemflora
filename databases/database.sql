CREATE DATABASE db161140_fyf;

CREATE USER 'db161140_2go'@'localhost' IDENTIFIED BY 'where2GO';

GRANT ALL PRIVILEGES ON *.* TO 'db161140_2go'@'localhost' WITH GRANT OPTION;

CREATE TABLE `banner` (
  `banner_id` int(10) NOT NULL AUTO_INCREMENT,
  `banner` varchar(512) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;
 


CREATE TABLE `sliders` (
  `slider_id` int(10) NOT NULL AUTO_INCREMENT,
  `slider` varchar(256) NOT NULL,
  `title` varchar(256) DEFAULT '',
  `cover` int(1) DEFAULT '0',
  `link` varchar(512) DEFAULT NULL,
  `info` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;


CREATE TABLE `sections` (
  `section_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) NOT NULL,
  `index` int(1) DEFAULT 0,
  `segment` varchar(256) DEFAULT '',
  `description` TEXT DEFAULT NULL,
  `icon` varchar(512) DEFAULT NULL,
  `background` varchar(512) DEFAULT NULL,
  `belong` int(1) DEFAULT NULL,
  `kind` varchar(256) DEFAULT NULL,
  `content` text DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;




















