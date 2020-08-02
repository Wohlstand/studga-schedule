-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for debian-linux-gnu (x86_64)
--
-- ------------------------------------------------------
-- Server version	10.0.38-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mail_list`
--

DROP TABLE IF EXISTS `mail_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_list` (
  `id_mail` int(100) NOT NULL AUTO_INCREMENT,
  `id_flow` int(100) unsigned DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `unsubscr_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Список рассылки об обновлении расписаний';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mstuca_groups`
--

DROP TABLE IF EXISTS `mstuca_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mstuca_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT '',
  `title_2` varchar(255) DEFAULT '',
  `title_3` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mstuca_sessions`
--

DROP TABLE IF EXISTS `mstuca_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mstuca_sessions` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Логин',
  `session_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'MD5-хэшики',
  `ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'IPv4 IPv6',
  `useragent` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Браузер',
  `session_timestart` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время начала сессии',
  `loghash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Хэш суммы логина и пароля',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AVG_ROW_LENGTH=204;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mstuca_users`
--

DROP TABLE IF EXISTS `mstuca_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mstuca_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Счётчик',
  `username` varchar(255) NOT NULL COMMENT 'Имя пользователя',
  `password` varchar(255) DEFAULT NULL COMMENT 'Хэш пароля 1',
  `password_c` varchar(255) DEFAULT NULL COMMENT 'Хэш пароля 2',
  `password_u` varchar(255) DEFAULT NULL COMMENT 'Пароль, зашифрованный функцией PASSWORD()',
  `password_n` varchar(255) DEFAULT NULL COMMENT 'Незашифрованный пароль, нужен для служб, проверяющих пароль напрямую',
  `crypto` varchar(255) NOT NULL DEFAULT 'SHA1' COMMENT 'Алгоритм шифрования (MD5 или SHA1)',
  `grp` int(11) NOT NULL DEFAULT '0' COMMENT 'Групповые привелегии',
  `email` varchar(255) DEFAULT NULL COMMENT 'Запасной e-mail',
  `firstname` varchar(255) DEFAULT NULL COMMENT 'Имя',
  `firstname_hide` int(1) unsigned zerofill DEFAULT '0',
  `lastname` varchar(255) DEFAULT NULL COMMENT 'Фамилия',
  `lastname_hide` int(10) unsigned zerofill DEFAULT '0000000000',
  `nickname` varchar(255) DEFAULT NULL COMMENT 'Ник пользователя',
  `birth` date DEFAULT NULL COMMENT 'Дата рождения',
  `birth_s` int(1) DEFAULT '0' COMMENT 'Параметр показа своей даты рождения',
  `city` varchar(255) DEFAULT NULL,
  `photo` varchar(1024) NOT NULL DEFAULT '' COMMENT 'Код фотографии y_xxxxxx.ext',
  `dateofreg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата регистрации',
  `checked` int(1) DEFAULT '0' COMMENT 'Проверен свежесозданный аккаунт?',
  `country` varchar(255) DEFAULT NULL,
  `lector` int(100) unsigned DEFAULT '0' COMMENT 'Привязка к преподавателю',
  `flow` int(100) unsigned DEFAULT '0' COMMENT 'Привязка к потоку',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1260;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news_feed`
--

DROP TABLE IF EXISTS `news_feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(1024) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(99) NOT NULL,
  `mass` int(4) unsigned zerofill DEFAULT '0000',
  `book` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '',
  `page_data` text COLLATE utf8_unicode_ci,
  `main` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AVG_ROW_LENGTH=12288;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages_books`
--

DROP TABLE IF EXISTS `pages_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_title` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AVG_ROW_LENGTH=16384;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_daycount`
--

DROP TABLE IF EXISTS `schedule_daycount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_daycount` (
  `id_day` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Семестры. Указывает начало отсчёта чёт/нечёт-а',
  `couples` int(1) unsigned DEFAULT '0' COMMENT 'Чёт-1/нечёт0 первой недели',
  `daystart` date DEFAULT NULL COMMENT 'День начала семестра',
  `dayend` date DEFAULT NULL COMMENT 'Дата окончания семестра',
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_day`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_disciplyne`
--

DROP TABLE IF EXISTS `schedule_disciplyne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_disciplyne` (
  `id_disciplyne` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dysc_name` varchar(255) DEFAULT NULL COMMENT 'Название предмета',
  PRIMARY KEY (`id_disciplyne`)
) ENGINE=InnoDB AUTO_INCREMENT=1560 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_facult`
--

DROP TABLE IF EXISTS `schedule_facult`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_facult` (
  `id_facult` int(99) NOT NULL AUTO_INCREMENT,
  `fac_name` varchar(255) DEFAULT NULL COMMENT 'Полное название факультета',
  `fac_name_s` varchar(255) DEFAULT NULL COMMENT 'Абравиатура',
  `fac_dean` int(11) DEFAULT NULL COMMENT 'Декан',
  `fac_dean_tel` varchar(255) DEFAULT NULL COMMENT 'телефон декана',
  `fac_depdean` int(11) DEFAULT NULL,
  `fac_meth_tel` varchar(255) DEFAULT NULL COMMENT 'телефон методистов',
  `fac_deanrooms` varchar(255) DEFAULT NULL COMMENT 'массив - комнаты деканата',
  `fac_desc` text COMMENT 'Описание факультета',
  `fac_gr_names` varchar(255) DEFAULT NULL COMMENT 'Список имён групп',
  PRIMARY KEY (`id_facult`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_facult_spec`
--

DROP TABLE IF EXISTS `schedule_facult_spec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_facult_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fac_id` int(11) NOT NULL,
  `spec_name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='Специальности по факультетам';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_files`
--

DROP TABLE IF EXISTS `schedule_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_files` (
  `filename` varchar(255) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `last_mod` varchar(255) DEFAULT '',
  `flow` int(99) DEFAULT '0',
  `group` int(11) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  `synonym` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_flows`
--

DROP TABLE IF EXISTS `schedule_flows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_flows` (
  `id_flow` int(11) NOT NULL AUTO_INCREMENT,
  `id_courator` varchar(255) DEFAULT NULL COMMENT 'Кураторы групп',
  `gr_name` varchar(10) DEFAULT NULL COMMENT 'Специальность',
  `gr_year-start` year(4) DEFAULT NULL COMMENT 'Год первого курса',
  `gr_year-end` year(4) DEFAULT NULL COMMENT 'Год выпуска',
  `id_facult` int(99) DEFAULT NULL COMMENT 'Факультет',
  `id_prof` int(99) DEFAULT NULL,
  `group_q` tinyint(4) DEFAULT '2' COMMENT 'Количество групп',
  `is_updating` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг процесса обновления расписания',
  `latest_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Последнее обновление базы данных',
  PRIMARY KEY (`id_flow`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_houses`
--

DROP TABLE IF EXISTS `schedule_houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_houses` (
  `id_house` int(29) NOT NULL AUTO_INCREMENT,
  `house_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_house`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_lectors`
--

DROP TABLE IF EXISTS `schedule_lectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_lectors` (
  `id_lector` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lcr_fullname` varchar(255) DEFAULT NULL COMMENT 'Полное имя преподавателя',
  `lcr_shtname` varchar(255) DEFAULT NULL COMMENT 'Фамилия и инициалы преподавателя',
  `lcr_rank-l` varchar(255) DEFAULT NULL COMMENT 'Учёная степень',
  `lcr_rank-sc` varchar(255) DEFAULT NULL COMMENT 'Учёное звание',
  `lcr_photo` varchar(255) DEFAULT NULL COMMENT 'Фотография преподавателя',
  `lcr_birthday` date DEFAULT NULL COMMENT 'Дата рождения преподавателя',
  `lcr_offsite` text COMMENT 'Официальный сайт преподавателя',
  PRIMARY KEY (`id_lector`),
  KEY `id_lector` (`id_lector`)
) ENGINE=InnoDB AUTO_INCREMENT=602 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_links`
--

DROP TABLE IF EXISTS `schedule_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_links` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `link` varchar(2048) DEFAULT NULL,
  `descr` text,
  `synonym` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=516 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_ltype`
--

DROP TABLE IF EXISTS `schedule_ltype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_ltype` (
  `id_ltype` int(11) NOT NULL AUTO_INCREMENT,
  `lt_name` varchar(255) DEFAULT NULL,
  `lt_name_sh` varchar(50) DEFAULT '',
  PRIMARY KEY (`id_ltype`),
  KEY `id_ltype` (`id_ltype`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_profs`
--

DROP TABLE IF EXISTS `schedule_profs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_profs` (
  `id_prof` int(99) NOT NULL AUTO_INCREMENT,
  `prof_name` varchar(255) DEFAULT NULL COMMENT 'Название специальности',
  `prof_shname` varchar(10) DEFAULT NULL COMMENT 'Абравиатура специальности',
  `prof_grmane` varchar(255) DEFAULT NULL,
  `prof_number` int(11) DEFAULT NULL COMMENT 'Код специальности',
  `id_facule` int(99) DEFAULT NULL,
  `prof_desc` text COMMENT 'Описание специальности',
  PRIMARY KEY (`id_prof`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Специальности';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_rooms`
--

DROP TABLE IF EXISTS `schedule_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_rooms` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Комнаты, аудитории, где проходят занятия',
  `room_number` varchar(255) DEFAULT NULL COMMENT 'Номер корпуса',
  `id_house` int(48) DEFAULT NULL COMMENT 'Корпус',
  `room_stage` int(11) DEFAULT NULL,
  `room_desc` varchar(255) DEFAULT NULL COMMENT 'Краткое описание аудитории',
  `room_220v` text COMMENT 'Наличие рабочих розеток 220v',
  `room_photo` varchar(255) DEFAULT NULL COMMENT 'Фотография из аудитории',
  PRIMARY KEY (`id_room`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=780;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_students`
--

DROP TABLE IF EXISTS `schedule_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_students` (
  `id_student` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) DEFAULT NULL,
  `id_subgrp_e` int(11) DEFAULT NULL,
  `id_sungrp_l` int(11) DEFAULT NULL,
  `st_fullname` varchar(255) DEFAULT NULL COMMENT 'ФИО студента',
  `st_birthday` date DEFAULT NULL COMMENT 'Дата рождения',
  `st_birthcity` varchar(255) DEFAULT NULL COMMENT 'Родной город',
  `st_hostel` int(1) DEFAULT '0' COMMENT 'Общежитие?',
  `st_photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_student`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_subgroups`
--

DROP TABLE IF EXISTS `schedule_subgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_subgroups` (
  `id_subgroup` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` varchar(255) DEFAULT NULL,
  `sgr_type` varchar(1) DEFAULT NULL COMMENT 'E или L (Английский или лабораторные)',
  `sgr_number` int(2) NOT NULL,
  PRIMARY KEY (`id_subgroup`),
  KEY `id_subgroup` (`id_subgroup`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2048;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedule_ver`
--

DROP TABLE IF EXISTS `schedule_ver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_ver` (
  `DateOfVer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `version` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'Alhpa, Beta, Unstable, Stable',
  `descr` text,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`DateOfVer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sent_info`
--

DROP TABLE IF EXISTS `sent_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sent_info` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `object_id` int(100) unsigned DEFAULT NULL,
  `info1` varchar(1024) DEFAULT NULL,
  `info2` varchar(1024) DEFAULT NULL,
  `info3` varchar(1024) DEFAULT NULL,
  `comment` text,
  `ip` varchar(255) DEFAULT NULL,
  `useragent` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statistic`
--

DROP TABLE IF EXISTS `statistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic` (
  `id_stat` int(100) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gr_name` varchar(50) NOT NULL,
  `IP` varchar(45) NOT NULL,
  `AGENT` varchar(2048) NOT NULL,
  `ver` varchar(255) DEFAULT NULL,
  `counts` int(99) DEFAULT '1',
  PRIMARY KEY (`id_stat`)
) ENGINE=MyISAM AUTO_INCREMENT=1017003 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database '????????'
--
/*!50003 DROP PROCEDURE IF EXISTS `Flows_ClearEmpties` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE PROCEDURE `Flows_ClearEmpties`()
    NO SQL
    COMMENT 'Удаляет пустые потоки, у которых нет расписаний'
DELETE FROM `schedule_flows` WHERE id_flow NOT IN (SELECT id_flow FROM `schedule__maindata` WHERE `schedule__maindata`.id_flow=`schedule_flows`.id_flow) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Flows_CountEmpties` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE PROCEDURE `Flows_CountEmpties`()
    NO SQL
    COMMENT 'Показывает количество потоков без расписаний'
SELECT count(*) FROM `schedule_flows` WHERE id_flow NOT IN (SELECT id_flow FROM `schedule__maindata` WHERE `schedule__maindata`.id_flow=`schedule_flows`.id_flow) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Flows_CountReal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE PROCEDURE `Flows_CountReal`()
    NO SQL
    COMMENT 'Показывает количетсво непустых потоков'
SELECT count(*) FROM `schedule_flows` WHERE id_flow IN (SELECT id_flow FROM `schedule__maindata` WHERE `schedule__maindata`.id_flow=`schedule_flows`.id_flow) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

--
-- Table structure for table `schedule__maindata`
--

DROP TABLE IF EXISTS `schedule__maindata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule__maindata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_disciplyne` int(11) unsigned DEFAULT NULL COMMENT 'Название предмета',
  `id_lector` int(11) unsigned DEFAULT NULL COMMENT 'Преподаватель',
  `id_flow` int(11) DEFAULT NULL COMMENT 'Поток',
  `id_group` varchar(255) DEFAULT NULL COMMENT 'Массив: делитель - пробел. Группа, для которой проводится занятие',
  `id_subgrp` varchar(255) DEFAULT '' COMMENT 'Массив: L000 - ID подгруппы лабораторных E000 - ID подгруппы английского',
  `id_day` int(11) unsigned DEFAULT NULL COMMENT 'Семестр',
  `id_ltype` int(11) unsigned DEFAULT NULL COMMENT 'Вид занятия',
  `issubgrp` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Это занятие одной из подгрупп или всей группы?',
  `id_room` int(11) unsigned DEFAULT NULL COMMENT 'Аудитория проведения занятия',
  `diration` int(1) NOT NULL DEFAULT '1' COMMENT 'Повтор занятия (число пар)',
  `lection` int(1) DEFAULT '0' COMMENT 'Номер пары (1,2,3,4,5,6,7)',
  `period-start` date DEFAULT NULL COMMENT 'Период проведения занятия',
  `period-end` date DEFAULT NULL,
  `exceptions` varchar(255) DEFAULT NULL COMMENT 'Массив дат, в которые занятие не проводится',
  `weekday` int(1) DEFAULT NULL COMMENT 'День недели записи занятия',
  `onlydays` varchar(255) DEFAULT NULL COMMENT 'Массив: Конкретные даты, в которые будет проводится занятие',
  `couples` int(1) DEFAULT '0' COMMENT '0 - любой день; 1 - только чётные; 2 - только нечётные',
  `exam_time` varchar(6) DEFAULT NULL,
  `change` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `change_time` timestamp NULL DEFAULT NULL,
  `change_user` int(99) DEFAULT NULL,
  `change_reason` text,
  PRIMARY KEY (`id`),
  KEY `id_disciplyne` (`id_disciplyne`),
  KEY `id_room` (`id_room`),
  KEY `id_day` (`id_day`),
  KEY `id_group` (`id_group`),
  KEY `id_subgrp` (`id_subgrp`),
  KEY `period` (`period-start`,`period-end`),
  KEY `weekday` (`weekday`),
  KEY `onlydays` (`onlydays`),
  KEY `couples` (`couples`),
  CONSTRAINT `id_disciplyne` FOREIGN KEY (`id_disciplyne`) REFERENCES `schedule_disciplyne` (`id_disciplyne`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1820;
/*!40101 SET character_set_client = @saved_cs_client */;


-- Dump completed on 2020-08-01 13:14:33
