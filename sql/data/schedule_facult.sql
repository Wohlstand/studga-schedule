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
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `schedule_facult`
--

LOCK TABLES `schedule_facult` WRITE;
/*!40000 ALTER TABLE `schedule_facult` DISABLE KEYS */;
INSERT INTO `schedule_facult` VALUES (1,'Механический факультет','М',NULL,NULL,NULL,NULL,NULL,NULL,'\"АБ\" \"АБб\" \"М\" \"Мб\" \"БТП\" \"БТПб\" \"ГСМ\" \"МАГ\" \"МБ\" \"МБб\" \"МГ\" \"МГб\" \"МАГб\" \"ММаг\" \"ЭВС\" \"ЭВСм\"'),(2,'Факультет авиационных систем и комплексов','ФАСК',NULL,NULL,NULL,NULL,NULL,'','\"АК\" \"АКб\" \"РС\" \"РСб\" \"РТ\" \"РТб\" \"АКМаг\" \"ЭВСак\"'),(3,'Факультет прикладной математики и вычислительной техники','ФПМиВТ',18,NULL,2,NULL,NULL,NULL,'\"ЭВМ\" \"ЭВМб\" \"БИ\" \"БИб\" \"ПМ\" \"ПМб\" \"БИТ\" \"БИТб\"'),(4,'Факультет управления на воздушном транспорте','ФУВТ',NULL,NULL,NULL,NULL,NULL,NULL,'\"ОП\" \"ОПБ\" \"ОПб\" \"ОБП\" \"ОБПб\" \"ОПбЭС\" \"ОПЭСб\" \"СО\" \"СОб\" \"УВД\" \"УВДб\" \"УВДБ\" \"ЭК\" \"ЭКб\" \"ЭКБ\" \"ЭКБб\"'),(5,'Заочный факультет','ЗФ',NULL,NULL,NULL,NULL,NULL,NULL,'\"АКЗб\" \"МЗб\" \"РТз\"');
/*!40000 ALTER TABLE `schedule_facult` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-01 13:19:34
