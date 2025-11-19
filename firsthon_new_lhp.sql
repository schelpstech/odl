-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2025 at 11:24 AM
-- Server version: 5.7.44
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `firsthon_new_lhp`
--

-- --------------------------------------------------------

--
-- Table structure for table `123admin`
--

CREATE TABLE `123admin` (
  `dname` varchar(64) NOT NULL,
  `dpwd` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `application_tbl`
--

CREATE TABLE `application_tbl` (
  `application_id` int(11) NOT NULL,
  `form_number` varchar(16) DEFAULT NULL,
  `surname` varchar(125) DEFAULT NULL,
  `firstname` varchar(125) DEFAULT NULL,
  `othername` varchar(125) DEFAULT NULL,
  `classid` int(11) DEFAULT NULL,
  `parent_ref` varchar(125) DEFAULT NULL,
  `passport` varchar(125) DEFAULT NULL,
  `gender` varchar(25) DEFAULT NULL,
  `dateofbirth` varchar(16) DEFAULT NULL,
  `state_of_origin` varchar(125) DEFAULT NULL,
  `last_school` varchar(255) DEFAULT NULL,
  `last_class` varchar(64) DEFAULT NULL,
  `last_year` year(4) DEFAULT NULL,
  `last_result` varchar(64) DEFAULT NULL,
  `health_surgery` varchar(225) DEFAULT NULL,
  `health_illness` varchar(225) DEFAULT NULL,
  `health_vaccine` varchar(225) DEFAULT NULL,
  `attestation` varchar(64) DEFAULT NULL,
  `amount_paid` varchar(16) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_mode` varchar(64) DEFAULT NULL,
  `payment_receipt` varchar(64) DEFAULT NULL,
  `payment_verified` varchar(64) DEFAULT NULL,
  `exam_date` datetime DEFAULT NULL,
  `exam_score` int(11) DEFAULT NULL,
  `admission_status` int(11) DEFAULT NULL,
  `rec_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `refid` varchar(16) NOT NULL,
  `term` varchar(64) NOT NULL,
  `classref` varchar(64) NOT NULL,
  `learn` varchar(254) NOT NULL,
  `learner` varchar(254) NOT NULL,
  `pinref` varchar(64) NOT NULL,
  `refdoc` varchar(254) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classact`
--

CREATE TABLE `classact` (
  `id` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `week` varchar(16) NOT NULL,
  `classid` varchar(64) NOT NULL,
  `classname` varchar(64) NOT NULL,
  `actdate` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `staffid` varchar(64) NOT NULL,
  `actlink` varchar(625) NOT NULL,
  `actphone` varchar(16) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpadmin`
--

CREATE TABLE `lhpadmin` (
  `adid` int(11) NOT NULL,
  `aduname` varchar(233) NOT NULL,
  `adpwd` varchar(233) NOT NULL,
  `admail` varchar(233) NOT NULL,
  `adfone` varchar(233) NOT NULL,
  `adfname` varchar(235) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpaffective`
--

CREATE TABLE `lhpaffective` (
  `affid` int(11) NOT NULL,
  `term` varchar(20) NOT NULL,
  `classid` int(11) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `total_present` int(11) DEFAULT NULL,
  `rating1` int(11) DEFAULT NULL,
  `rating2` int(11) DEFAULT NULL,
  `rating3` int(11) DEFAULT NULL,
  `rating4` int(11) DEFAULT NULL,
  `rating5` int(11) DEFAULT NULL,
  `comment` varchar(2255) DEFAULT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lhpalloc`
--

CREATE TABLE `lhpalloc` (
  `aid` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `classname` varchar(64) NOT NULL,
  `subject` varchar(254) NOT NULL,
  `staffid` varchar(64) NOT NULL,
  `supro` varchar(16) NOT NULL,
  `classid` int(11) NOT NULL,
  `sbjid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpassignedfee`
--

CREATE TABLE `lhpassignedfee` (
  `assid` int(11) NOT NULL,
  `feeid` varchar(16) NOT NULL,
  `classid` varchar(64) NOT NULL,
  `stdid` varchar(64) NOT NULL,
  `term` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `due` date NOT NULL,
  `amount` int(11) NOT NULL,
  `discount` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpclass`
--

CREATE TABLE `lhpclass` (
  `classid` int(11) NOT NULL,
  `classname` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpclassalloc`
--

CREATE TABLE `lhpclassalloc` (
  `classlocid` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `tutorid` varchar(18) NOT NULL,
  `term` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lhpfeedback`
--

CREATE TABLE `lhpfeedback` (
  `fid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `sbjid` int(11) NOT NULL,
  `stdid` varchar(64) NOT NULL,
  `type` varchar(254) NOT NULL,
  `content` longtext NOT NULL,
  `score` varchar(11) NOT NULL,
  `feedback` varchar(20000) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpfeelist`
--

CREATE TABLE `lhpfeelist` (
  `feeid` int(11) NOT NULL,
  `feename` varchar(254) NOT NULL,
  `term` varchar(254) DEFAULT NULL,
  `session` int(11) NOT NULL,
  `classid` varchar(64) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpnote`
--

CREATE TABLE `lhpnote` (
  `noteid` int(11) NOT NULL,
  `topicid` int(11) NOT NULL,
  `sbjid` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `content` longtext NOT NULL,
  `staffid` varchar(64) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `vet` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpnotice`
--

CREATE TABLE `lhpnotice` (
  `noticeid` int(11) NOT NULL,
  `term` varchar(24) NOT NULL,
  `refid` int(11) NOT NULL,
  `subject` varchar(64) NOT NULL,
  `message` varchar(254) NOT NULL,
  `rectime` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lhpquestion`
--

CREATE TABLE `lhpquestion` (
  `questid` int(11) NOT NULL,
  `topicid` int(11) NOT NULL,
  `sbjid` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `content` longtext NOT NULL,
  `grade` int(11) NOT NULL,
  `staffid` varchar(64) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `deadline` date NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpresultconfig`
--

CREATE TABLE `lhpresultconfig` (
  `id` int(11) NOT NULL,
  `term` varchar(24) NOT NULL,
  `ca_score` int(11) NOT NULL,
  `exam_score` int(11) NOT NULL,
  `sch_open` int(11) NOT NULL,
  `resumption` date NOT NULL,
  `signature` varchar(24) NOT NULL,
  `status` int(11) NOT NULL,
  `midterm` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpresultrecord`
--

CREATE TABLE `lhpresultrecord` (
  `id` int(11) NOT NULL,
  `term` varchar(24) DEFAULT NULL,
  `classid` varchar(12) DEFAULT NULL,
  `subjid` varchar(11) DEFAULT NULL,
  `lid` varchar(16) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `examscore` int(11) NOT NULL DEFAULT '0',
  `totalscore` int(11) NOT NULL DEFAULT '0',
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpscheme`
--

CREATE TABLE `lhpscheme` (
  `schmid` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `classname` varchar(64) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `week` varchar(64) NOT NULL,
  `topic` varchar(254) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `staffid` varchar(64) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpschool`
--

CREATE TABLE `lhpschool` (
  `schid` int(11) NOT NULL,
  `schname` varchar(254) NOT NULL,
  `address` varchar(626) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `email` varchar(88) NOT NULL,
  `website` varchar(88) NOT NULL,
  `proprietor` varchar(88) NOT NULL,
  `founded` year(4) NOT NULL,
  `motto` varchar(88) NOT NULL,
  `logo` varchar(88) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lhpsession`
--

CREATE TABLE `lhpsession` (
  `sessionid` int(11) NOT NULL,
  `session` varchar(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lhpstaff`
--

CREATE TABLE `lhpstaff` (
  `staffid` int(11) NOT NULL,
  `sname` varchar(64) DEFAULT NULL,
  `staffname` varchar(255) DEFAULT NULL,
  `spwd` varchar(64) DEFAULT NULL,
  `sfone` varchar(16) DEFAULT NULL,
  `semail` varchar(244) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `role` text,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpsubject`
--

CREATE TABLE `lhpsubject` (
  `sbjid` int(11) NOT NULL,
  `sbjname` varchar(64) NOT NULL,
  `classid` varchar(11) NOT NULL,
  `classname` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpsubmit`
--

CREATE TABLE `lhpsubmit` (
  `sid` int(11) NOT NULL,
  `sref` varchar(16) NOT NULL,
  `sbclass` varchar(254) NOT NULL,
  `sbwk` varchar(254) NOT NULL,
  `sbsbj` varchar(254) NOT NULL,
  `sbtopic` varchar(254) NOT NULL,
  `stdid` varchar(624) NOT NULL,
  `stdname` varchar(254) NOT NULL,
  `sbfile` varchar(254) NOT NULL,
  `sbteach` varchar(254) NOT NULL,
  `sbterm` varchar(244) NOT NULL,
  `sbgrade` varchar(24) NOT NULL DEFAULT 'Not Graded',
  `sbremarks` varchar(665) NOT NULL,
  `sbdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhptransaction`
--

CREATE TABLE `lhptransaction` (
  `transid` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `classid` varchar(64) NOT NULL,
  `stdid` varchar(64) NOT NULL,
  `reference` varchar(254) NOT NULL,
  `mode` varchar(64) NOT NULL,
  `paydate` date NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpuser`
--

CREATE TABLE `lhpuser` (
  `id` int(11) NOT NULL,
  `uname` varchar(64) NOT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `upwd` varchar(64) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `classid` varchar(64) DEFAULT NULL,
  `fname` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `picture` varchar(255) DEFAULT NULL,
  `numb` varchar(11) DEFAULT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lhpvet`
--

CREATE TABLE `lhpvet` (
  `vetid` int(11) NOT NULL,
  `noteid` int(11) NOT NULL,
  `userid` varchar(24) NOT NULL,
  `msg` varchar(626) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lhpweekrecord`
--

CREATE TABLE `lhpweekrecord` (
  `id` int(11) NOT NULL,
  `term` varchar(24) NOT NULL,
  `week` varchar(24) NOT NULL,
  `classid` varchar(12) NOT NULL,
  `subjid` varchar(11) NOT NULL,
  `lid` varchar(16) NOT NULL,
  `score` int(11) NOT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `lga` varchar(64) NOT NULL,
  `state` varchar(64) NOT NULL,
  `country` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `uname` varchar(65) DEFAULT NULL,
  `udate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `utype` varchar(16) DEFAULT NULL,
  `stat` int(11) DEFAULT NULL,
  `uip` varchar(16) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lpterm`
--

CREATE TABLE `lpterm` (
  `tid` int(11) NOT NULL,
  `term` varchar(64) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scidd` int(11) NOT NULL,
  `schdate` date NOT NULL,
  `schact` varchar(3000) NOT NULL,
  `start_time` time NOT NULL,
  `schdetails` varchar(3000) NOT NULL,
  `stop_time` time NOT NULL,
  `scterm` varchar(64) NOT NULL,
  `scclass` varchar(64) NOT NULL,
  `stp_date` date NOT NULL,
  `scposted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scfone` varchar(64) NOT NULL,
  `classname` varchar(64) NOT NULL,
  `scstaff` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_surname` varchar(255) NOT NULL,
  `user_firstname` varchar(225) NOT NULL,
  `user_phone` varchar(25) NOT NULL,
  `user_passphrase` varchar(225) NOT NULL,
  `phone2` varchar(16) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `busstop` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `lga` varchar(255) DEFAULT NULL,
  `state_of_res` varchar(255) DEFAULT NULL,
  `rectime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `123admin`
--
ALTER TABLE `123admin`
  ADD PRIMARY KEY (`dname`);

--
-- Indexes for table `application_tbl`
--
ALTER TABLE `application_tbl`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`refid`),
  ADD UNIQUE KEY `pinref` (`pinref`);

--
-- Indexes for table `classact`
--
ALTER TABLE `classact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lhpadmin`
--
ALTER TABLE `lhpadmin`
  ADD PRIMARY KEY (`adid`);

--
-- Indexes for table `lhpaffective`
--
ALTER TABLE `lhpaffective`
  ADD PRIMARY KEY (`affid`);

--
-- Indexes for table `lhpalloc`
--
ALTER TABLE `lhpalloc`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `lhpassignedfee`
--
ALTER TABLE `lhpassignedfee`
  ADD PRIMARY KEY (`assid`);

--
-- Indexes for table `lhpclass`
--
ALTER TABLE `lhpclass`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `lhpclassalloc`
--
ALTER TABLE `lhpclassalloc`
  ADD PRIMARY KEY (`classlocid`);

--
-- Indexes for table `lhpfeedback`
--
ALTER TABLE `lhpfeedback`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `lhpfeelist`
--
ALTER TABLE `lhpfeelist`
  ADD PRIMARY KEY (`feeid`);

--
-- Indexes for table `lhpnote`
--
ALTER TABLE `lhpnote`
  ADD PRIMARY KEY (`noteid`);

--
-- Indexes for table `lhpnotice`
--
ALTER TABLE `lhpnotice`
  ADD PRIMARY KEY (`noticeid`);

--
-- Indexes for table `lhpquestion`
--
ALTER TABLE `lhpquestion`
  ADD PRIMARY KEY (`questid`);

--
-- Indexes for table `lhpresultconfig`
--
ALTER TABLE `lhpresultconfig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lhpresultrecord`
--
ALTER TABLE `lhpresultrecord`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lhpscheme`
--
ALTER TABLE `lhpscheme`
  ADD PRIMARY KEY (`schmid`);

--
-- Indexes for table `lhpschool`
--
ALTER TABLE `lhpschool`
  ADD PRIMARY KEY (`schid`);

--
-- Indexes for table `lhpsession`
--
ALTER TABLE `lhpsession`
  ADD PRIMARY KEY (`sessionid`);

--
-- Indexes for table `lhpstaff`
--
ALTER TABLE `lhpstaff`
  ADD PRIMARY KEY (`staffid`),
  ADD UNIQUE KEY `sname` (`sname`);

--
-- Indexes for table `lhpsubject`
--
ALTER TABLE `lhpsubject`
  ADD PRIMARY KEY (`sbjid`);

--
-- Indexes for table `lhpsubmit`
--
ALTER TABLE `lhpsubmit`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `lhptransaction`
--
ALTER TABLE `lhptransaction`
  ADD PRIMARY KEY (`transid`);

--
-- Indexes for table `lhpuser`
--
ALTER TABLE `lhpuser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `lhpvet`
--
ALTER TABLE `lhpvet`
  ADD PRIMARY KEY (`vetid`);

--
-- Indexes for table `lhpweekrecord`
--
ALTER TABLE `lhpweekrecord`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lpterm`
--
ALTER TABLE `lpterm`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scidd`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application_tbl`
--
ALTER TABLE `application_tbl`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `classact`
--
ALTER TABLE `classact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lhpadmin`
--
ALTER TABLE `lhpadmin`
  MODIFY `adid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lhpaffective`
--
ALTER TABLE `lhpaffective`
  MODIFY `affid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3089;

--
-- AUTO_INCREMENT for table `lhpalloc`
--
ALTER TABLE `lhpalloc`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3813;

--
-- AUTO_INCREMENT for table `lhpassignedfee`
--
ALTER TABLE `lhpassignedfee`
  MODIFY `assid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24573;

--
-- AUTO_INCREMENT for table `lhpclass`
--
ALTER TABLE `lhpclass`
  MODIFY `classid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lhpclassalloc`
--
ALTER TABLE `lhpclassalloc`
  MODIFY `classlocid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `lhpfeedback`
--
ALTER TABLE `lhpfeedback`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `lhpfeelist`
--
ALTER TABLE `lhpfeelist`
  MODIFY `feeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=630;

--
-- AUTO_INCREMENT for table `lhpnote`
--
ALTER TABLE `lhpnote`
  MODIFY `noteid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1702;

--
-- AUTO_INCREMENT for table `lhpnotice`
--
ALTER TABLE `lhpnotice`
  MODIFY `noticeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1321;

--
-- AUTO_INCREMENT for table `lhpquestion`
--
ALTER TABLE `lhpquestion`
  MODIFY `questid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1201;

--
-- AUTO_INCREMENT for table `lhpresultconfig`
--
ALTER TABLE `lhpresultconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `lhpresultrecord`
--
ALTER TABLE `lhpresultrecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40551;

--
-- AUTO_INCREMENT for table `lhpscheme`
--
ALTER TABLE `lhpscheme`
  MODIFY `schmid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2836;

--
-- AUTO_INCREMENT for table `lhpschool`
--
ALTER TABLE `lhpschool`
  MODIFY `schid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lhpsession`
--
ALTER TABLE `lhpsession`
  MODIFY `sessionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lhpstaff`
--
ALTER TABLE `lhpstaff`
  MODIFY `staffid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `lhpsubject`
--
ALTER TABLE `lhpsubject`
  MODIFY `sbjid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `lhpsubmit`
--
ALTER TABLE `lhpsubmit`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lhptransaction`
--
ALTER TABLE `lhptransaction`
  MODIFY `transid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6144;

--
-- AUTO_INCREMENT for table `lhpuser`
--
ALTER TABLE `lhpuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;

--
-- AUTO_INCREMENT for table `lhpvet`
--
ALTER TABLE `lhpvet`
  MODIFY `vetid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `lhpweekrecord`
--
ALTER TABLE `lhpweekrecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387746;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=776;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56462;

--
-- AUTO_INCREMENT for table `lpterm`
--
ALTER TABLE `lpterm`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scidd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
