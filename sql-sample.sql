/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` enum('ACTIVE','DELETE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `FK_candidates_jobs` (`job_id`),
  CONSTRAINT `FK_candidates_jobs` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `candidates_reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) unsigned NOT NULL,
  `author` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `craeted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_candidates_reviews_candidates` (`candidate_id`),
  CONSTRAINT `FK_candidates_reviews_candidates` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` smallint(5) unsigned NOT NULL,
  `description` text NOT NULL,
  `craeted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` enum('ACTIVE','DELETED') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `FK_jobs_jobs_positions` (`position_id`),
  CONSTRAINT `FK_jobs_jobs_positions` FOREIGN KEY (`position_id`) REFERENCES `jobs_positions` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jobs_positions` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `craeted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` enum('ACTIVE','DELETED') DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
