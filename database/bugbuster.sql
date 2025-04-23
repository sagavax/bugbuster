-- --------------------------------------------------------
-- Hostiteľ:                     127.0.0.1
-- Verze serveru:                8.3.0 - MySQL Community Server - GPL
-- OS serveru:                   Win64
-- HeidiSQL Verzia:              12.10.0.7033
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportování struktury pro tabulka bugbuster.apps
CREATE TABLE IF NOT EXISTS `apps` (
  `app_id` int NOT NULL AUTO_INCREMENT,
  `app_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `app_descr` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `app_link` varchar(255) DEFAULT NULL,
  `github_repo` varchar(255) DEFAULT NULL,
  `is_active_dev` tinyint(1) DEFAULT '1',
  `Sloupec 6` tinyint(1) DEFAULT '1',
  `is_app_active` tinyint(1) DEFAULT '1',
  `added_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.app_log
CREATE TABLE IF NOT EXISTS `app_log` (
  `id` int NOT NULL DEFAULT '0',
  `diary_text` text CHARACTER SET utf8mb3 NOT NULL,
  `date_added` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.bugs
CREATE TABLE IF NOT EXISTS `bugs` (
  `bug_id` int NOT NULL AUTO_INCREMENT,
  `bug_title` varchar(50) DEFAULT NULL,
  `bug_text` text,
  `bug_priority` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bug_status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bug_application` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `is_fixed` tinyint(1) DEFAULT NULL,
  `comments` int DEFAULT '0',
  `github_issue` int DEFAULT '0',
  `added_date` datetime DEFAULT NULL,
  `fixed_date` datetime DEFAULT NULL,
  PRIMARY KEY (`bug_id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb3;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.bugs_comments
CREATE TABLE IF NOT EXISTS `bugs_comments` (
  `comm_id` int NOT NULL AUTO_INCREMENT,
  `bug_id` int DEFAULT NULL,
  `bug_comm_header` varchar(100) DEFAULT NULL,
  `bug_comment` text,
  `application` varchar(50) DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL,
  PRIMARY KEY (`comm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb3;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.bugs_labels
CREATE TABLE IF NOT EXISTS `bugs_labels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bug_id` int DEFAULT NULL,
  `bug_label` varchar(50) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.bugs_timeline
CREATE TABLE IF NOT EXISTS `bugs_timeline` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_id` int DEFAULT NULL,
  `object_type` enum('bug','bug_comment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'bug alebo bug_comment',
  `parent_object_id` int DEFAULT NULL,
  `timeline_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.diary
CREATE TABLE IF NOT EXISTS `diary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_date` datetime DEFAULT NULL,
  `diary_text` text,
  `project_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb3;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.diary_bck
CREATE TABLE IF NOT EXISTS `diary_bck` (
  `id` int NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `diary_text` text CHARACTER SET utf8mb3,
  `project_id` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.diary_timeline
CREATE TABLE IF NOT EXISTS `diary_timeline` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_id` int DEFAULT NULL,
  `parent_object_id` int DEFAULT NULL,
  `object_type` enum('idea','idea_comment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timeline_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.ideas
CREATE TABLE IF NOT EXISTS `ideas` (
  `idea_id` int NOT NULL AUTO_INCREMENT,
  `idea_title` varchar(50) DEFAULT NULL,
  `idea_text` text,
  `is_implemented` tinyint(1) DEFAULT '0',
  `is_postponed` tinyint(1) DEFAULT '0',
  `idea_priority` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `idea_status` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `idea_application` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `comments` int DEFAULT '0',
  `added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`idea_id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb3;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.ideas_comments
CREATE TABLE IF NOT EXISTS `ideas_comments` (
  `comm_id` int NOT NULL AUTO_INCREMENT,
  `idea_id` int DEFAULT NULL,
  `idea_comm_header` varchar(100) DEFAULT NULL,
  `idea_comment` text,
  `application` varchar(100) DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL,
  PRIMARY KEY (`comm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb3;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.ideas_timeline
CREATE TABLE IF NOT EXISTS `ideas_timeline` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_id` int DEFAULT NULL,
  `parent_object_id` int DEFAULT NULL,
  `object_type` enum('idea','idea_comment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timeline_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `implemented_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.notes
CREATE TABLE IF NOT EXISTS `notes` (
  `note_id` int NOT NULL AUTO_INCREMENT,
  `note_title` varchar(100) DEFAULT NULL,
  `note_application` varchar(100) DEFAULT NULL,
  `note_text` text,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.notes_timeline
CREATE TABLE IF NOT EXISTS `notes_timeline` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_id` int DEFAULT NULL,
  `parent_object_id` int DEFAULT NULL,
  `object_type` enum('idea','idea_comment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timeline_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka bugbuster.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Export dat nebyl vybrán.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
