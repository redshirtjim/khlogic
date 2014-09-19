-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: db437696394.db.1and1.com
-- Generation Time: Dec 30, 2012 at 09:29 PM
-- Server version: 5.0.96
-- PHP Version: 5.3.3-7+squeeze14
-- 
-- users table
-- 
-- 
-- Database: `db437696394`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE users (
  user_id int(10) unsigned NOT NULL auto_increment,
  gender varchar(3) default NULL,
  first_name varchar(30) NOT NULL,
  last_name varchar(30) NOT NULL,
  email varchar(80) NOT NULL,
  passw char(40) NOT NULL,
  active char(32) default NULL,
  registration_date datetime NOT NULL,
  phone_1 varchar(15) default NULL,
  phone_2 varchar(15) default NULL,
  pub_type_id int(10) unsigned NOT NULL,
  servant_type_id int(10) unsigned NOT NULL,
  service_group_id int(10) unsigned NOT NULL,
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
  UNIQUE KEY email (email),
  KEY pub_type_id (pub_type_id),
  KEY servant_type_id (servant_type_id),
  KEY service_group_id (service_group_id),
  KEY login (email,passw)
) TYPE=InnoDB AUTO_INCREMENT=30 AUTO_INCREMENT=30 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO users VALUES (1, 'Br.', 'Jim', 'Rush', 'jimrush72@gmail.com', '545cbcbd790043899a54bfb8ad9d3c3fc5c4f8ab', '', '0000-00-00 00:00:00', '816-806-7524', '212-867-5903', 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (2, 'Br.', 'Richard', 'Jones', 'rick@mail.com', '6a1d413de1ec4ea4aa635f8aec8805f43b2f47d8', '', '0000-00-00 00:00:00', '816-816-8164', '816-816-6848', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0);
INSERT INTO users VALUES (3, 'Br.', 'Richard', 'Zentz', 'Richard@att.com', '209d5fae8b2ba427d30650dd0250942af944a0c9', '', '0000-00-00 00:00:00', '816-846-6547', '816-654-6548', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (4, 'Br.', 'Mark', 'Strem', 'mark@mail.com', '5420c5f55023b72ce2786beee184c71e43fe6911', '', '0000-00-00 00:00:00', '654-654-6641', '312-654-1234', 1, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0);
INSERT INTO users VALUES (5, 'Br.', 'Claude', 'Wilson', 'wilson@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', '0000-00-00 00:00:00', '816-654-9874', '816-549-6548', 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0);
INSERT INTO users VALUES (6, 'Br.', 'Steve', 'Vigil', 'vigil@steve.com', '5241af651564ecc6c8949d8692e313664477a2f8', '', '0000-00-00 00:00:00', '816-654-9874', '816-584-6548', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO users VALUES (7, 'Br.', 'Larry', 'Morris', 'morris@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', '0000-00-00 00:00:00', '816-654-9874', '816-816-8165', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (8, 'Br.', 'Paul', 'Kenslow', 'kenslow@mail.com', '9c1c01dc3ac1445a500251fc34a15d3e75a849df', '', '0000-00-00 00:00:00', '816-816-8164', '816-816-6848', 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0);
INSERT INTO users VALUES (9, 'Br.', 'Andrew', 'Anders', 'mail@mail.com', '3da541559918a808c2402bba5012f6c60b27661c', '', '0000-00-00 00:00:00', '456-789-9874', '654-654-9874', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (10, 'Sr.', 'Katy', 'Rush', 'katy_rush@hotmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '0000-00-00 00:00:00', '555-867-5309', '655-654-9874', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (12, 'Br.', 'Jim', 'Rush', 'jim@rush-family.info', '1cd02e31b43620d7c664e038ca42a060d61727b9', '', '0000-00-00 00:00:00', '816-806-7524', '656-654-9874', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (13, 'Br.', 'John', 'Smith', 'john@mail.com', 'a51dda7c7ff50b61eaea0444371f4a6a9301e501', '', '0000-00-00 00:00:00', '123-321-6541', '657-654-9874', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (14, 'Br.', 'Peter', 'Free', 'pete@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-8164', '659-654-9874', 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (15, 'Br.', 'Will', 'Adam', 'will.betty@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-1234', '660-654-9874', 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (16, 'Br.', 'Vincent', 'Barber', 'vincent.barber@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-3456', '661-654-9874', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (17, 'Br.', 'Tom', 'Callahan', 'tom.c@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-5678', '662-654-9874', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (18, 'Br.', 'Stephen', 'Davis', 'steve.davis@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-9874', '663-654-9874', 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (19, 'Br.', 'Robert', 'Eagleton', 'bob.eagle@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-6541', '664-654-9874', 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (20, 'Br.', 'Oscar', 'Green', 'o.green@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-3698', '665-654-9874', 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (21, 'Sr.', 'Marge', 'Hall', 'maggie@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-6845', '666-654-9874', 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (23, 'Sr.', 'Betty', 'Adam', 'betty.adam@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '816-555-1234', '668-654-9874', 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (24, 'Br.', 'Mike', 'Klin', 'mike@kline.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '654-654-1234', '669-654-9874', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (25, 'Sr.', 'Very', 'Old', 'veryold@sadf.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '987-654-1234', '670-654-9874', 4, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (26, 'Br.', 'Nick', 'Limburgh', 'nick@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '987-654-3215', '671-654-9874', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (27, 'Br.', 'Jonah', 'Jameson', 'jjameson@gizzette.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '456-987-8521', '672-654-9874', 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (28, 'Sr.', 'Amanda', 'Zero', '0@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '987-654-6547', '673-654-9874', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO users VALUES (29, 'Br.', 'Johnny', 'Smith', 'Johnny@mail.com', 'c7b376c573a0255d9023cc99d2a315cacf21d812', '', '0000-00-00 00:00:00', '321-654-9874', '658-654-9874', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `users`
-- 
ALTER TABLE `users`
  ADD CONSTRAINT users_ibfk_2 FOREIGN KEY (servant_type_id) REFERENCES servant_type (servant_type_id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT users_ibfk_1 FOREIGN KEY (pub_type_id) REFERENCES pub_type (pub_type_id) ON DELETE CASCADE ON UPDATE CASCADE;
