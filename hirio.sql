-- phpMyAdmin SQL Dump
-- version 3.2.2
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 15-11-23 19:58 
-- 서버 버전: 5.1.73
-- PHP 버전: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `hirio`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr AUTO_INCREMENT=21 ;

--
-- 테이블의 덤프 데이터 `admins`
--

INSERT INTO `admins` (`id`, `username`, `hashed_password`) VALUES
(1, 'hirio', 'cnsdud'),
(19, 'ezelay', 'cnsdud'),
(20, '1', '1');

-- --------------------------------------------------------

--
-- 테이블 구조 `boards`
--

CREATE TABLE IF NOT EXISTS `boards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `party_id` int(11) NOT NULL,
  `writer` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` text,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `party_id` (`party_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr AUTO_INCREMENT=7 ;

--
-- 테이블의 덤프 데이터 `boards`
--

INSERT INTO `boards` (`id`, `party_id`, `writer`, `time`, `title`, `content`, `visible`) VALUES
(1, 43, '박성욱', '07:30', '연습용파티', '컨텐트는 길어도됨', 1),
(2, 43, '박성욱', '08:30', '연습용파티2', '내용내용내용내용내용내용내용', 1),
(3, 43, '박성욱', '08:30', '연습용파티2', '내용내용내용내용내용내용내용', 1),
(4, 43, '박성욱', '08:30', '연습용파티2', '내용내용내용내용내용내용내용', 1),
(5, 40, '박성욱', '08:30', '연습용파티2', '내용내용내용내용내용내용내용', 1),
(6, 40, '박성욱', '08:30', '연습용파티2', '내용내용내용내용내용내용내용', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `party`
--

CREATE TABLE IF NOT EXISTS `party` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interests` varchar(30) NOT NULL,
  `loc_exp` varchar(255) NOT NULL,
  `loc` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `exp` varchar(255) NOT NULL,
  `date` varchar(30) NOT NULL,
  `mem_limit` int(11) NOT NULL,
  `master` varchar(30) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `members` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr AUTO_INCREMENT=131 ;

--
-- 테이블의 덤프 데이터 `party`
--

INSERT INTO `party` (`id`, `interests`, `loc_exp`, `loc`, `name`, `exp`, `date`, `mem_limit`, `master`, `visible`, `members`) VALUES