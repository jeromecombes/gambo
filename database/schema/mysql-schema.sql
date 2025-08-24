/*M!999999\- enable the sandbox mode */ 
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `professor` mediumtext DEFAULT NULL,
  `title` mediumtext DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `nom` mediumtext DEFAULT NULL,
  `code` mediumtext DEFAULT NULL,
  `day` mediumtext DEFAULT NULL,
  `debut` mediumtext DEFAULT NULL,
  `fin` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_attrib_rh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_attrib_rh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `writing1` int(11) DEFAULT NULL,
  `writing2` int(11) DEFAULT NULL,
  `writing3` int(11) DEFAULT NULL,
  `seminar1` int(11) DEFAULT NULL,
  `seminar2` int(11) DEFAULT NULL,
  `seminar3` int(11) DEFAULT NULL,
  `workshop1` int(11) DEFAULT NULL,
  `workshop2` int(11) DEFAULT NULL,
  `workshop3` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `a1` int(11) DEFAULT NULL,
  `a2` int(11) DEFAULT NULL,
  `a3` int(11) DEFAULT NULL,
  `b1` int(11) DEFAULT NULL,
  `b2` int(11) DEFAULT NULL,
  `b3` int(11) DEFAULT NULL,
  `c1` int(11) DEFAULT NULL,
  `d1` int(11) DEFAULT NULL,
  `c2` int(11) DEFAULT NULL,
  `c3` int(11) DEFAULT NULL,
  `d2` int(11) DEFAULT NULL,
  `d3` int(11) DEFAULT NULL,
  `e2` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_ciph`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_ciph` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `institution` mediumtext DEFAULT NULL,
  `domaine` mediumtext DEFAULT NULL,
  `titre` mediumtext DEFAULT NULL,
  `instructeur` mediumtext DEFAULT NULL,
  `debut` mediumtext DEFAULT NULL,
  `fin` mediumtext DEFAULT NULL,
  `duree` mediumtext DEFAULT NULL,
  `day1` mediumtext NOT NULL,
  `start1` mediumtext NOT NULL,
  `end1` mediumtext NOT NULL,
  `day2` mediumtext NOT NULL,
  `start2` mediumtext NOT NULL,
  `end2` mediumtext NOT NULL,
  `day3` mediumtext NOT NULL,
  `start3` mediumtext NOT NULL,
  `end3` mediumtext NOT NULL,
  `titre2` mediumtext NOT NULL,
  `instructeur2` mediumtext NOT NULL,
  `debut2` mediumtext NOT NULL,
  `fin2` mediumtext NOT NULL,
  `duree2` mediumtext NOT NULL,
  `day4` mediumtext NOT NULL,
  `start4` mediumtext NOT NULL,
  `end4` mediumtext NOT NULL,
  `day5` mediumtext NOT NULL,
  `start5` mediumtext NOT NULL,
  `end5` mediumtext NOT NULL,
  `day6` mediumtext NOT NULL,
  `start6` mediumtext NOT NULL,
  `end6` mediumtext NOT NULL,
  `lock` enum('0','1') NOT NULL DEFAULT '0',
  `notes` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_cm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_cm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university` varchar(20) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `ufr` mediumtext DEFAULT NULL,
  `parcours` mediumtext DEFAULT NULL,
  `discipline` mediumtext DEFAULT NULL,
  `departement` mediumtext DEFAULT NULL,
  `licence` mediumtext DEFAULT NULL,
  `niveau` mediumtext DEFAULT NULL,
  `nom` mediumtext DEFAULT NULL,
  `jour1` mediumtext DEFAULT NULL,
  `debut1` mediumtext DEFAULT NULL,
  `fin1` mediumtext DEFAULT NULL,
  `jour2` mediumtext DEFAULT NULL,
  `debut2` mediumtext DEFAULT NULL,
  `fin2` mediumtext DEFAULT NULL,
  `prof` mediumtext DEFAULT NULL,
  `ufr_en` mediumtext DEFAULT NULL,
  `parcours_en` mediumtext DEFAULT NULL,
  `discipline_en` mediumtext DEFAULT NULL,
  `departement_en` mediumtext DEFAULT NULL,
  `licence_en` mediumtext DEFAULT NULL,
  `nom_en` mediumtext DEFAULT NULL,
  `email` mediumtext DEFAULT NULL,
  `credits` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_rh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_rh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_rh2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_rh2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_td`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_td` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university` varchar(20) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `jour1` mediumtext DEFAULT NULL,
  `debut1` mediumtext DEFAULT NULL,
  `fin1` mediumtext DEFAULT NULL,
  `jour2` mediumtext DEFAULT NULL,
  `debut2` mediumtext DEFAULT NULL,
  `fin2` mediumtext DEFAULT NULL,
  `prof` mediumtext DEFAULT NULL,
  `nom` mediumtext DEFAULT NULL,
  `nom_en` mediumtext DEFAULT NULL,
  `email` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_univ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_univ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) NOT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `university` varchar(200) DEFAULT NULL,
  `ufr` varchar(200) DEFAULT NULL,
  `parcours` varchar(200) DEFAULT NULL,
  `discipline` mediumtext DEFAULT NULL,
  `departement` mediumtext DEFAULT NULL,
  `licence` mediumtext DEFAULT NULL,
  `niveau` mediumtext NOT NULL,
  `cm_name` mediumtext DEFAULT NULL,
  `cm_code` mediumtext DEFAULT NULL,
  `cm_day1` mediumtext NOT NULL,
  `cm_start1` mediumtext NOT NULL,
  `cm_end1` mediumtext NOT NULL,
  `cm_day2` mediumtext NOT NULL,
  `cm_start2` mediumtext NOT NULL,
  `cm_end2` mediumtext NOT NULL,
  `cm_prof` mediumtext DEFAULT NULL,
  `td_name` mediumtext DEFAULT NULL,
  `td_code` mediumtext DEFAULT NULL,
  `td_day1` mediumtext NOT NULL,
  `td_start1` mediumtext NOT NULL,
  `td_end1` mediumtext NOT NULL,
  `td_day2` mediumtext NOT NULL,
  `td_start2` mediumtext NOT NULL,
  `td_end2` mediumtext NOT NULL,
  `td_prof` mediumtext DEFAULT NULL,
  `lock` enum('0','1') NOT NULL DEFAULT '0',
  `university_en` mediumtext DEFAULT NULL,
  `ufr_en` mediumtext DEFAULT NULL,
  `parcours_en` mediumtext DEFAULT NULL,
  `discipline_en` mediumtext DEFAULT NULL,
  `departement_en` mediumtext DEFAULT NULL,
  `licence_en` mediumtext DEFAULT NULL,
  `niveau_en` mediumtext DEFAULT NULL,
  `cm_name_en` mediumtext DEFAULT NULL,
  `cm_code_en` mediumtext DEFAULT NULL,
  `cm_prof_en` mediumtext DEFAULT NULL,
  `td_name_en` mediumtext DEFAULT NULL,
  `td_code_en` mediumtext DEFAULT NULL,
  `td_prof_en` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_univ3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_univ3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `cm` int(11) DEFAULT NULL,
  `td` int(11) DEFAULT NULL,
  `tmp` int(11) DEFAULT NULL,
  `lockCM` int(1) DEFAULT NULL,
  `lockTD` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `courses_univ4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_univ4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` mediumtext DEFAULT NULL,
  `nom` mediumtext DEFAULT NULL,
  `type` mediumtext DEFAULT NULL,
  `lien` mediumtext DEFAULT NULL,
  `institution` mediumtext DEFAULT NULL,
  `institutionAutre` mediumtext DEFAULT NULL,
  `discipline` mediumtext DEFAULT NULL,
  `niveau` mediumtext DEFAULT NULL,
  `prof` mediumtext DEFAULT NULL,
  `email` mediumtext DEFAULT NULL,
  `day` mediumtext DEFAULT NULL,
  `debut` mediumtext DEFAULT NULL,
  `fin` mediumtext DEFAULT NULL,
  `note` int(1) DEFAULT 0,
  `modalites` mediumtext DEFAULT NULL,
  `modalites1` mediumtext DEFAULT NULL,
  `modalites2` mediumtext DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `lock` int(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `date1` mediumtext DEFAULT NULL,
  `date2` mediumtext DEFAULT NULL,
  `date3` mediumtext DEFAULT NULL,
  `date4` mediumtext DEFAULT NULL,
  `date5` mediumtext DEFAULT NULL,
  `date6` mediumtext DEFAULT NULL,
  `date7` mediumtext DEFAULT NULL,
  `date8` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realname` mediumtext DEFAULT NULL,
  `name` mediumtext DEFAULT NULL,
  `type` mediumtext DEFAULT NULL,
  `rel` mediumtext DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `size` mediumtext DEFAULT NULL,
  `type2` mediumtext DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `adminOnly` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eval_enabled`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `eval_enabled` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `form` varchar(20) DEFAULT NULL,
  `courseId` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `question` int(11) DEFAULT NULL,
  `response` mediumtext DEFAULT NULL,
  `closed` int(11) DEFAULT 0,
  `semester` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `course` varchar(5) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `note` mediumtext DEFAULT NULL,
  `grade1` mediumtext DEFAULT NULL,
  `grade2` mediumtext DEFAULT NULL,
  `grade` mediumtext DEFAULT NULL,
  `date1` mediumtext DEFAULT NULL,
  `date2` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `housing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `housing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `question` int(11) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `std_id` (`student`),
  KEY `housing_semester_index` (`semester`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `housing_accept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `housing_accept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `housing_affect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `housing_affect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `logement` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `housing_closed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `housing_closed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `logements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `logements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` mediumtext DEFAULT NULL,
  `firstname` mediumtext DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `zipcode` mediumtext DEFAULT NULL,
  `city` mediumtext DEFAULT NULL,
  `phonenumber` mediumtext DEFAULT NULL,
  `cellphone` mediumtext DEFAULT NULL,
  `email` mediumtext DEFAULT NULL,
  `lastname2` mediumtext DEFAULT NULL,
  `firstname2` mediumtext DEFAULT NULL,
  `cellphone2` mediumtext DEFAULT NULL,
  `email2` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `logements_dispo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `logements_dispo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logement_id` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `partners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `date` int(11) DEFAULT NULL,
  `univreg` int(11) DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` int(11) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `responses` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `stage` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `internship` varchar(100) NOT NULL,
  `stage` mediumtext DEFAULT NULL,
  `lock` int(11) DEFAULT 0,
  `notes` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lastname` mediumtext DEFAULT NULL,
  `firstname` mediumtext DEFAULT NULL,
  `email` mediumtext DEFAULT NULL,
  `password` mediumtext DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `gender` mediumtext DEFAULT NULL,
  `dob` mediumtext DEFAULT NULL,
  `citizenship1` mediumtext DEFAULT NULL,
  `citizenship2` mediumtext DEFAULT NULL,
  `town` mediumtext DEFAULT NULL,
  `university2` mediumtext DEFAULT NULL,
  `graduation` mediumtext DEFAULT NULL,
  `city` mediumtext DEFAULT NULL,
  `street` mediumtext DEFAULT NULL,
  `zip` mediumtext DEFAULT NULL,
  `state` mediumtext DEFAULT NULL,
  `contactlast` mediumtext DEFAULT NULL,
  `contactfirst` mediumtext DEFAULT NULL,
  `contactphone` mediumtext DEFAULT NULL,
  `contactmobile` mediumtext DEFAULT NULL,
  `contactemail` mediumtext DEFAULT NULL,
  `university` varchar(25) DEFAULT NULL,
  `guest` int(1) DEFAULT 0,
  `semesters` mediumtext DEFAULT NULL,
  `country` mediumtext DEFAULT NULL,
  `cellphone` mediumtext DEFAULT NULL,
  `home_institution` mediumtext DEFAULT NULL,
  `placeOB` mediumtext DEFAULT NULL,
  `countryOB` mediumtext DEFAULT NULL,
  `frenchNumber` mediumtext DEFAULT NULL,
  `resultatTCF` mediumtext DEFAULT NULL,
  `tin` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tutorat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutorat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `tuteur` mediumtext DEFAULT NULL,
  `day` mediumtext DEFAULT NULL,
  `start` mediumtext DEFAULT NULL,
  `end` mediumtext DEFAULT NULL,
  `lock` int(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `univ_reg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `univ_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) NOT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `question` int(11) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `univ_reg2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `univ_reg2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `question` int(11) DEFAULT NULL,
  `response` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `univ_reg3s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `univ_reg3s` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `university` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `univ_reg_lock1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `univ_reg_lock1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `univ_reg_show`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `univ_reg_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_agents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `lastname` mediumtext DEFAULT NULL,
  `firstname` mediumtext DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `access` mediumtext DEFAULT NULL,
  `university` varchar(25) DEFAULT NULL,
  `language` varchar(2) DEFAULT NULL,
  `alerts` int(1) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`) COMMENT 'email'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*M!999999\- enable the sandbox mode */ 
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2019_05_18_154804_alter_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2019_05_18_185113_add_field_admin_to_users',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2019_06_21_000449_change_students_homeinstitution',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2019_06_21_065936_rename_univ_reg3',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2021_02_28_184602_users_email_length',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2021_03_11_223253_add_students_timestamps',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2021_03_11_224505_students_columns_nullable',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2021_03_13_195216_add_housing_timestamps',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2021_03_13_195706_add_housing_defaults',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2021_03_14_140750_add_housing_assignment_timestamps',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2021_03_15_213417_add_final_reg_timestamps',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2021_03_15_220015_add_univ_reg_timestamps',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2021_03_15_220235_Univ_Reg_Columns_Nullable',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2021_03_16_214057_add_users_email_verified',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2019_08_19_000000_create_failed_jobs_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2021_03_18_003932_r_h_course_choice_rename_semesters',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2021_03_18_165828_standardize_semester_field',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2021_03_18_214955_add_timestamps_to_courses_rh_assignment',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2021_03_18_215504_add_nullable_columns_to_rh_courses_assignment',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2021_03_20_143432_users_login_nullable',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2021_03_22_150328_add_timestamps_to_univ_courses',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2021_03_27_201035_add_timestamp_to_courses_choices',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2021_03_29_161319_add_timestamps_to_tutoring',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2021_03_30_205219_add_timestamps_to_internship',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2021_03_30_205914_add_intership_attribute',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2021_03_30_224336_change_lock_field_on_internship',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2021_03_31_162326_add_timestamp_to_grades_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2021_03_31_213000_change_courses_valudes_on_grades_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2021_04_06_173042_add_timestamp_to_evaluations',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2021_04_07_122341_drop_table_forms',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2021_04_10_160743_add_nullable_columns_to_evaluations',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2021_04_11_172555_update_form_into_evaluations_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2021_04_11_230937_add_timestamps_to_dates_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2021_04_13_164657_update_access_on_table_users',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2021_04_14_074025_add_timestamps_to_housing_accept',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2021_04_14_161832_drop_login_and_token_from_users_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2014_10_12_200000_add_two_factor_columns_to_users_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2021_04_19_082727_add_timestamps_to_hosts_available',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2021_04_19_084011_add_timestamps_to_hosts',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2021_04_20_224717_add_timestamps_to_courses',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2021_04_27_135517_rename_internship_in_evaluations_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2021_04_28_082627_add_timestamps_to_eval_enabled',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2021_05_11_162940_change_note_value_on_course_univ4',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2021_07_19_165727_add_timestamps_to_rh_courses',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2021_07_26_171055_encrypt_users_lastname_firstname',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2021_07_26_190353_add_user_id_to_students_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2021_07_31_003551_delete_students_token',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2021_08_17_071833_change_nature_for_type_on_courses_univ4',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2021_08_17_073853_remove_html_entities_from_courses_univ4',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2021_08_17_085008_remove_html_entities_from_courses',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2021_08_17_090119_remove_html_entities_from_students',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2021_08_17_092542_remove_html_entities_from_response_fields',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2021_08_17_170716_change_day_attribute_on_courses',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2021_08_17_183015_change_day_attribute_on_tutorings',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2021_08_17_184557_change_day_attribute_on_univcourses',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2021_08_17_225442_translate_disability_answers_on_univ_reg',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2021_08_23_165525_remove_html_entities_from_students_firstname',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2022_06_15_005358_add_workshop_courses',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2022_06_15_011156_add_workshop_course_assignment',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2022_09_20_211114_create_partners_table',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2022_10_17_212839_update_partner_list',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2022_10_27_223500_update_partner_for_univ_reg',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2022_10_27_230302_add_univ_reg_field_to_partners_table',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2019_12_14_000001_create_personal_access_tokens_table',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2022_08_28_230145_create_user_codes',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2022_10_30_141625_create_user_agents',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2024_01_27_124544_add_expires_at_column_to_personal_access_tokens',24);
