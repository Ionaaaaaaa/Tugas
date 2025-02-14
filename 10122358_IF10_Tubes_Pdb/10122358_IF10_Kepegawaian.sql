-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_pegawai
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin@gmail.com','1234');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal_shift`
--

DROP TABLE IF EXISTS `jadwal_shift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jadwal_shift` (
  `id_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) DEFAULT NULL,
  `id_shift` int(11) DEFAULT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `id_pegawai` (`id_pegawai`),
  KEY `id_shift` (`id_shift`),
  CONSTRAINT `jadwal_shift_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE,
  CONSTRAINT `jadwal_shift_ibfk_2` FOREIGN KEY (`id_shift`) REFERENCES `shift` (`id_shift`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal_shift`
--

LOCK TABLES `jadwal_shift` WRITE;
/*!40000 ALTER TABLE `jadwal_shift` DISABLE KEYS */;
INSERT INTO `jadwal_shift` VALUES (1,1,1,'Senin'),(2,2,2,'Senin'),(3,3,3,'Senin'),(4,4,1,'Selasa'),(5,5,2,'Selasa'),(6,6,3,'Selasa'),(7,7,1,'Rabu'),(8,8,2,'Rabu'),(9,9,3,'Rabu'),(10,10,1,'Kamis'),(11,11,2,'Kamis'),(12,12,3,'Kamis'),(13,13,1,'Jumat'),(14,14,2,'Jumat'),(15,1,3,'Jumat'),(16,2,1,'Sabtu'),(17,3,2,'Sabtu'),(18,4,3,'Sabtu'),(19,5,1,'Minggu'),(20,6,2,'Minggu'),(21,7,3,'Minggu'),(30,27,1,'Senin'),(31,27,2,'Selasa'),(32,27,3,'Selasa');
/*!40000 ALTER TABLE `jadwal_shift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES (1,'Agus Pratama','agus@gmail.com','1234','Staff','2025-02-12 17:31:19'),(2,'Budi Santoso','budi@gmail.com','1234','Staff','2025-02-12 17:31:19'),(3,'Citra Lestari','citra@gmail.com','1234','Staff','2025-02-12 17:31:19'),(4,'Dewi Kurnia','dewi@gmail.com','1234','Supervisor','2025-02-12 17:31:19'),(5,'Eko Saputra','eko@gmail.com','1234','Staff','2025-02-12 17:31:19'),(6,'Fajar Hidayat','fajar@gmail.com','1234','Staff','2025-02-12 17:31:19'),(7,'Gita Maharani','gita@gmail.com','1234','Manager','2025-02-12 17:31:19'),(8,'Hadi Wijaya','hadi@gmail.com','1234','Staff','2025-02-12 17:31:19'),(9,'Indra Lesmana','indra@gmail.com','1234','Staff','2025-02-12 17:31:19'),(10,'Joko Widodo','joko@gmail.com','1234','Supervisor','2025-02-12 17:31:19'),(11,'Kurniawan Putra','kurniawan@gmail.com','1234','Staff','2025-02-12 17:31:19'),(12,'Lina Sari','lina@gmail.com','1234','Staff','2025-02-12 17:31:19'),(13,'Mulyadi Syah','mulyadi@gmail.com','1234','Staff','2025-02-12 17:31:19'),(14,'Nurul Fadilah','nurul@gmail.com','1234','Staff','2025-02-12 17:31:19'),(27,'koko','1@gmail.com','1234','apa aja','2025-02-14 18:16:44');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shift`
--

DROP TABLE IF EXISTS `shift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL AUTO_INCREMENT,
  `nama_shift` varchar(50) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  PRIMARY KEY (`id_shift`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shift`
--

LOCK TABLES `shift` WRITE;
/*!40000 ALTER TABLE `shift` DISABLE KEYS */;
INSERT INTO `shift` VALUES (1,'Pagi','08:00:00','16:00:00'),(2,'Siang','16:00:00','00:00:00'),(3,'Malam','00:00:00','08:00:00');
/*!40000 ALTER TABLE `shift` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-15  1:48:12
