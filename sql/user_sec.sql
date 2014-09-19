-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: db437696394.db.1and1.com
-- Generation Time: Dec 29, 2012 at 11:11 PM
-- Server version: 5.0.96
-- PHP Version: 5.3.3-7+squeeze14
-- 
-- user_sec table
-- 
-- 
-- Database: `db437696394`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `user_sec`
-- 

CREATE TABLE user_sec (
  user_id int(10) unsigned NOT NULL auto_increment,
  servant_type_id int(10) unsigned NOT NULL,
  first_name varchar(30) default NULL,
  last_name varchar(30) default NULL,
  email varchar(30) default NULL,
  passw varchar(100) default NULL,
  phone_1 varchar(15) default NULL,
  phone_2 varchar(15) default NULL,
  admin tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  public tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  cbs tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  tms tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  service_meet tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  attendants tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  sound_stage tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  cleaning tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  grounds tinyint(1) NOT NULL default '0' COMMENT 'Option: yes/NO',
  PRIMARY KEY  (user_id),
  KEY servant_type_id (servant_type_id)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- 
-- Dumping data for table `user_sec`
-- 

INSERT INTO user_sec VALUES (1, 0, 'Jim', 'Rush', 'jimrush72@gmail.com', '545cbcbd790043899a54bfb8ad9d3c3fc5c4f8ab', '816-806-7524', '212-867-5903', 1, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (4, 0, 'Richard', 'Jones', 'rick@mail.com', '6a1d413de1ec4ea4aa635f8aec8805f43b2f47d8', '816-816-8164', '816-816-6848', 0, 0, 0, 0, 0, 0, 0, 1, 0);
INSERT INTO user_sec VALUES (9, 0, 'Richard', 'Zentz', 'Richard@att.com', '209d5fae8b2ba427d30650dd0250942af944a0c9', '816-846-6547', '816-654-6548', 0, 1, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (10, 0, 'Mark', 'Strem', 'mark@mail.com', '5420c5f55023b72ce2786beee184c71e43fe6911', '654-654-6641', '312-654-1234', 1, 0, 1, 0, 1, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (11, 0, 'Claude', 'Wilson', 'wilson@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '816-654-9874', '816-549-6548', 0, 0, 0, 0, 0, 1, 0, 0, 0);
INSERT INTO user_sec VALUES (13, 0, 'Steve', 'Vigil', 'vigil@steve.com', '5241af651564ecc6c8949d8692e313664477a2f8', '816-654-9874', '816-584-6548', 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO user_sec VALUES (15, 0, 'Larry', 'Morris', 'morris@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '816-654-9874', '816-816-8165', 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (17, 0, 'Paul', 'Kenslow', 'kenslow@mail.com', '9c1c01dc3ac1445a500251fc34a15d3e75a849df', '816-816-8164', '816-816-6848', 0, 0, 0, 0, 0, 1, 0, 0, 0);
INSERT INTO user_sec VALUES (19, 0, 'Andrew', 'Anders', 'mail@mail.com', '3da541559918a808c2402bba5012f6c60b27661c', '456-789-9874', '654-654-9874', 1, 1, 0, 1, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (24, 0, 'Katy', 'Rush', 'katy_rush@hotmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '555-867-5309', '', 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (29, 0, 'Admin Jim', 'Rush', 'me@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '816-823-1682', '816-867-5309', 1, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (34, 0, 'Jim', 'Rush', 'jim@rush-family.info', '1cd02e31b43620d7c664e038ca42a060d61727b9', '816-806-7524', '', 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (35, 0, 'John', 'Smith', 'john@mail.com', 'a51dda7c7ff50b61eaea0444371f4a6a9301e501', '123-321-6541', '', 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO user_sec VALUES (36, 0, 'Johnny', 'Smith', 'Johnny@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '321-654-9874', '', 0, 0, 0, 0, 0, 0, 0, 0, 0);
