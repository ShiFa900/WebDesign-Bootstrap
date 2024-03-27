-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: personsManagementApps
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.23.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `hobbies`
--

DROP TABLE IF EXISTS `hobbies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hobbies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hobbies_name` varchar(60) DEFAULT NULL,
  `person_id` int NOT NULL,
  `last_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hobbies2_persons_id_fk` (`person_id`),
  CONSTRAINT `hobbies2_persons_id_fk` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hobbies`
--

LOCK TABLES `hobbies` WRITE;
/*!40000 ALTER TABLE `hobbies` DISABLE KEYS */;
INSERT INTO `hobbies` VALUES (1,'Diving',6,'2024-02-26 06:49:44'),(5,'Merajut Amigurumi',6,'2024-02-26 06:49:44'),(8,'Merakit Gundam',18,'2024-02-26 06:49:44'),(9,'Main air',18,'2024-02-26 06:49:44'),(20,'Bermain badminton',16,'2024-02-26 06:49:44'),(27,'Bermain volly',16,'2024-02-26 06:49:44'),(29,'Main game',15,'2024-02-26 06:49:44'),(32,'Membuat ogoh-ogoh',33,'2024-02-26 06:49:44'),(42,'Merajut Amigurumi',5,'2024-02-26 06:49:44'),(43,'Motovlog',29,'2024-02-26 06:49:44'),(44,'SISPALA',29,'2024-02-26 06:49:44'),(45,'Makan siomay',18,'2024-02-26 06:49:44'),(46,'Main sepak bola',18,'2024-02-26 06:49:44'),(55,'Menulis novel',52,'2024-02-26 06:49:44'),(58,'Menulis puisi',52,'2024-02-26 06:49:44'),(59,'Camping',29,'2024-02-26 06:49:44'),(61,'Nonton anime',18,'2024-02-26 06:49:44'),(62,'Menulis blog',18,'2024-02-26 06:49:44'),(63,'Dancer',54,'2024-02-26 06:49:44'),(64,'Menjahit',51,'2024-02-26 06:49:44'),(66,'Memangang kue',5,'2024-03-05 05:56:34'),(67,'Menari tari bali',54,'2024-03-05 06:43:09'),(69,'Trail',60,'2024-03-22 05:24:34'),(70,'Berenang',61,'2024-03-22 10:18:22'),(71,'Bermain musik jazz',62,'2024-03-25 03:10:17'),(72,'Menulis syair',62,'2024-03-27 02:10:43'),(73,'Bermain musik',13,'2024-03-25 10:11:58'),(74,'Masak',15,'2024-03-26 06:07:33'),(75,'Surfing',61,'2024-03-26 07:21:37'),(79,'  lah',63,'2024-03-27 03:49:45');
/*!40000 ALTER TABLE `hobbies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jobs_name` varchar(60) DEFAULT NULL,
  `count` int DEFAULT NULL,
  `last_update` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'Entrepreneur',2,'2024-03-26 09:27:53'),(2,'Factory worker',1,'2024-03-25 09:31:18'),(3,'Chef',0,'2024-03-26 03:16:47'),(4,'Jurnalis',1,'2024-03-21 02:52:47'),(5,'Reporter',1,'2024-03-25 10:10:36'),(8,'Jobless',4,'2024-03-25 02:35:39'),(10,'Musician',1,'2024-03-25 10:08:44'),(11,'Student',4,'2024-03-26 09:31:52'),(14,'Mechanic',2,'2024-03-27 03:49:45'),(15,'Household assistant',0,'2024-03-25 03:56:17'),(16,'Novelis',1,'2024-03-22 06:48:46'),(17,'Gardener',1,'2024-03-22 10:21:10'),(18,'Tailor',1,'2024-03-25 09:27:44'),(20,'Designer',0,'2024-03-25 02:53:03'),(21,'Employee',0,'2024-03-25 10:08:29'),(22,'Enginer',0,'2024-03-25 02:12:27'),(23,'Painter',0,'2024-03-27 02:56:06'),(27,'Builder',0,'2024-03-27 03:37:16');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_job`
--

DROP TABLE IF EXISTS `person_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person_job` (
  `id` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL,
  `job_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `person_job_jobs_id_fk` (`job_id`),
  KEY `person_job_persons_id_fk` (`person_id`),
  CONSTRAINT `person_job_jobs_id_fk` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  CONSTRAINT `person_job_persons_id_fk` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_job`
--

LOCK TABLES `person_job` WRITE;
/*!40000 ALTER TABLE `person_job` DISABLE KEYS */;
INSERT INTO `person_job` VALUES (1,5,1),(2,6,1),(3,11,8),(7,12,8),(8,13,5),(9,15,4),(10,16,10),(11,18,11),(12,29,8),(13,33,11),(14,8,8),(19,44,8),(23,48,11),(26,51,18),(27,52,16),(29,54,11),(32,60,14),(33,61,17),(34,62,2),(35,63,14);
/*!40000 ALTER TABLE `person_job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) DEFAULT NULL,
  `nik` varchar(16) NOT NULL,
  `email` varchar(320) NOT NULL,
  `birthDate` date DEFAULT NULL,
  `sex` varchar(20) NOT NULL,
  `internalNote` varchar(320) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `lastLoggedIn` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persons`
--

LOCK TABLES `persons` WRITE;
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
INSERT INTO `persons` VALUES (5,'Sarah Kusuma','Etinaga','0012991234784624','kumalKelapa@gmail.com','1981-08-23','F','i&#039;m perfect All-American BITCH! :&lt;','A','$2y$10$cCOFFA7pjb8NzEYYfRvi8e6hDsxVVWanrj/vi/oblIEs.mpMLiS02',1,'2024-03-26 09:32:21'),(6,'Shouko San','Komi','1920182391237890','komi.san@gmail.com','1998-07-23','F','Komi adalah karakter yang ada di anime Komi Can&#039;t Communicate, dan berteman dekat dengan Tadano dan Najima. ','M','$2y$10$Dfz.1nsMJ65RNdujN6/gf.Ftxw9xDQi.17HfyQtz8MUAFZUUNVksG',1,'2024-01-31 07:09:58'),(8,'Mimin','Admin shopee','1293791273179173','milmil@gmail.com','1989-02-10','M',NULL,'M','$2y$10$AY8D.fPqfBsO11oXd.174eG90Mng/mSujRG/oZH3lVQS.DYEd0pw2',0,NULL),(11,'Jean Baptiste','Genoullio','0028103829183902','parfume@gmail.com','1947-02-10','M','Beliau pernah ikut Pemuda/Pemudi Berani','M','$2y$10$sS69eZDFRqGSf5u6lHba.e0jYxAxwQwT4BMxccmrmKQhcbrqH3Bj2',0,'2024-02-01 06:13:31'),(12,'Milalsa','Jewelry','2013801273017037','rubi@gmail.com','1888-12-23','M',NULL,'M','$2y$10$6CXvS0ggD21yyTcLzBFst.amw0a/LL488kMTjO85qvdSa.WgqMPoS',0,NULL),(13,'Shiku','Miyaki','0097912730102122','miyako@gmail.com','2007-08-21','M',NULL,'A','$2y$10$Fj73ipw7CX/.yXEwac0eQOSZj6AvdrA.v6RwZOLWZvfQ3rOptEC/q',1,'2024-03-21 10:32:19'),(15,'Rui','Ayaki','0127917391723712','Ayayaki@gmail.com','2004-08-31','M',NULL,'M','$2y$10$Y1ulraMAJl6vR3q2UVAjnOIHYy3gdEIgRhNh2do/XSECJlB3lpGmW',1,'2024-03-26 06:56:06'),(16,'Jenki','Zklasaki','0021830181292107','eki@gmail.com','2010-05-21','M','Sudah pindah kependudukan ke Gorontalo','M','$2y$10$r3U.F6AeJvO/nQkaOIUsp.d9uvCGCAGjFG/8DwZ5pOsAP0RbVspW6',1,NULL),(18,'Udin','Fazhra','0091828923792739','dinudin@gmail.com','2007-06-30','M',NULL,'M','$2y$10$7XsWcd1va11VRh/YrPu/cuTAPDdqa2kHaQ3FfUxNUYZGdBTj66T4y',1,NULL),(29,'Mackenzie','Wallberg','1212012810280183','enzy98@gmail.com','1999-07-10','F',NULL,'M','$2y$10$3WMU7X8eO0rUDZySp6CXF.7hBmBRHCWrtVObDi0oyYWvBRk7fieUO',1,'2024-02-16 08:58:42'),(33,'Aaron','Micheline','1100283173812378','arr@gmail.com','2019-09-19','M',NULL,'M','$2y$10$dlq.HREzdKoU/zjM6clcku5A.L2HVnbU0QImGp06XYMjinxnCJVaa',1,NULL),(44,'Masak Coba','Lagi','0021391829123127','cobalagiweh@gmail.com','1997-05-06','M',NULL,'M','$2y$10$drce5Zj5tTv2C42eYOgZMOJ6//3QNE.wHCYY3jUKTQKSIDvQLWujC',0,NULL),(48,'Cobba','bi','0092912381290830','try@gmail.com','2017-03-23','M',NULL,'M','$2y$10$brmWhFp82OXu2mSbG8yXl./vrkTL1D5HkkWNYqpUBYLa4Xj1FHqr.',1,'2024-02-26 03:31:57'),(51,'Maya','Kusuma','0091920910290192','kumalPelepah@gmail.com','2000-08-31','F',NULL,'A','$2y$10$LONfnKIn729h/upUyrdH8uLLzJWUVfH1RQIJFB5GepuoYzFJxymeK',1,'2024-02-26 03:47:58'),(52,'Cahyono','Putro','0121029109201921','yono@gmail.com','2006-06-12','M',NULL,'M','$2y$10$W0pwyvLKZBiA2t3sk2fH7e7nMR6G7AqXwM0UPL.OXlh5xFIwR2hFm',1,NULL),(54,'Pan','Red Panda','0091238912389128','redPanda@gmail.com','2011-08-31','F',NULL,'M','$2y$10$.dNP0PxA29KzA/CabSTfP.uO/qTesacx7KFivnWnBZ4f/svyqRUsW',1,NULL),(60,'Ini','Coba','0091212891829182','ini@gmail.com','2001-12-06','M','Sedang sakit','M','$2y$10$J48mAQQyblZCHjjt6YlOaOTOFWwBBZSRI9VJINhi/fjRG4GYAOnT.',1,'2024-03-22 07:17:52'),(61,'Dummy 1',NULL,'0012912901920192','dummy1@gmail.com','2012-12-31','B','ini adalah Dummy 1','M','$2y$10$K6ObLLMczqc/CdAYE0mkSuj20DOW7xwqMqM4IokUmMudF.P.YIXWO',1,NULL),(62,'Dump2','dummy','1102910290192019','dummy2@gmail.com','1967-02-23','M','dummy 2','M','$2y$10$RNu1l6l6ZtcVTPyPP68hHONZuUxO7z5rUjQ0OFw2wGASOkiLbR5Nq',1,NULL),(63,'Dummy 3',NULL,'10291282739217','dummy3@gmail.com','1980-05-26','F','ini dummy 3','M','$2y$10$UY.Jo65CFubgFT9tjPurt.NhoAAZzICmgy/sy9QAkLuMKy8Vu/piW',1,NULL);
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-27 13:52:52
