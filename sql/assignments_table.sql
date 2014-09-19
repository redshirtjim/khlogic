-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: db437696394.db.1and1.com
-- Generation Time: Jan 26, 2013 at 04:12 PM
-- Server version: 5.0.96
-- PHP Version: 5.3.3-7+squeeze14
-- 
-- Database: `db437696394`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `assignments`
-- 

CREATE TABLE `assignments` (
  `assign_id` int(10) unsigned NOT NULL auto_increment,
  `week_of` date NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `assign_type_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `meeting_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`assign_id`),
  KEY `user_id` (`user_id`),
  KEY `assign_type_id` (`assign_type_id`),
  KEY `page_id` (`page_id`),
  KEY `meeting_type_id` (`meeting_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `assignments`
-- 


-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `assignments`
-- 
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_4` FOREIGN KEY (`assign_type_id`) REFERENCES `assignment_type` (`assign_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `assignments_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
