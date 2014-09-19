-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: db437696394.db.1and1.com
-- Generation Time: Dec 29, 2012 at 11:13 PM
-- Server version: 5.0.96
-- PHP Version: 5.3.3-7+squeeze14
-- 
-- pubs table
-- 
-- 
-- Database: `db437696394`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `pubs`
-- 

CREATE TABLE pubs (
  pubs_id int(10) unsigned NOT NULL auto_increment,
  gender varchar(3) default NULL,
  first_name varchar(30) default NULL,
  last_name varchar(30) default NULL,
  email varchar(30) default NULL,
  phone_1 varchar(15) default NULL,
  phone_2 varchar(15) default NULL,
  pub_type_id int(10) unsigned NOT NULL,
  servant_type_id int(10) unsigned NOT NULL,
  service_group_id int(10) unsigned NOT NULL,
  PRIMARY KEY  (pubs_id),
  KEY pub_type_id (pub_type_id),
  KEY servant_type_id (servant_type_id),
  KEY service_group_id (service_group_id)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- 
-- Dumping data for table `pubs`
-- 

INSERT INTO pubs VALUES (1, 'Br.', 'Peter', 'Free', 'pete@mail.com', '816-555-8164', '816-555-8165', 2, 1, 0);
INSERT INTO pubs VALUES (2, 'Br.', 'Will', 'Adam', 'will.betty@mail.com', '816-555-1234', '816-555-2345', 3, 3, 0);
INSERT INTO pubs VALUES (3, 'Br.', 'Vincent', 'Barber', 'vincent.barber@mail.com', '816-555-3456', '816-555-4567', 1, 1, 0);
INSERT INTO pubs VALUES (4, 'Br.', 'Tom', 'Callahan', 'tom.c@mail.com', '816-555-5678', '816-555-6789', 1, 2, 0);
INSERT INTO pubs VALUES (5, 'Br.', 'Stephen', 'Davis', 'steve.davis@mail.com', '816-555-9874', '816-555-8745', 2, 1, 0);
INSERT INTO pubs VALUES (6, 'Br.', 'Robert', 'Eagleton', 'bob.eagle@mail.com', '816-555-6541', '816-555-6549', 2, 2, 0);
INSERT INTO pubs VALUES (7, 'Br.', 'Oscar', 'Green', 'o.green@mail.com', '816-555-3698', '816-555-1475', 3, 3, 0);
INSERT INTO pubs VALUES (8, 'Sr.', 'Marge', 'Hall', 'maggie@mail.com', '816-555-6845', '816-555-4123', 1, 3, 0);
INSERT INTO pubs VALUES (9, 'Br.', 'Mark', 'Hall', 'mark@mail.com', '816-555-6845', '816-555-4123', 1, 1, 0);
INSERT INTO pubs VALUES (10, 'Sr.', 'Betty', 'Adam', 'betty.adam@mail.com', '816-555-1234', '816-555-2345', 1, 3, 0);
INSERT INTO pubs VALUES (11, 'Br.', 'Mike', 'Klin', 'mike@kline.com', '654-654-1234', '321-654-4321', 1, 2, 0);
INSERT INTO pubs VALUES (13, 'Sr.', 'Very', 'Old', 'veryold@sadf.com', '987-654-1234', '654-987-3214', 4, 3, 0);
INSERT INTO pubs VALUES (30, 'Br.', 'Nick', 'Limburgh', 'nick@mail.com', '987-654-3215', '654-321-6589', 2, 3, 0);
INSERT INTO pubs VALUES (31, 'Br.', 'Jonah', 'Jameson', 'jjameson@gizzette.com', '456-987-8521', '654-654-7414', 3, 3, 0);
INSERT INTO pubs VALUES (32, 'Sr.', 'Amanda', 'Zero', '0@mail.com', '987-654-6547', '654-321-6541', 2, 3, 0);

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `pubs`
-- 
ALTER TABLE `pubs`
  ADD CONSTRAINT pubs_ibfk_1 FOREIGN KEY (pub_type_id) REFERENCES pub_type (pub_type_id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT pubs_ibfk_2 FOREIGN KEY (servant_type_id) REFERENCES servant_type (servant_type_id) ON DELETE CASCADE ON UPDATE CASCADE;
