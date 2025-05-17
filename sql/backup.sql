-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: PROYECTO_VISITAHAL
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `ALOJAMIENTO`
--

USE PROYECTO_VISITAHAL;

DROP TABLE IF EXISTS `ALOJAMIENTO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ALOJAMIENTO` (
  `idAlojamiento` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idAlojamiento`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALOJAMIENTO`
--

LOCK TABLES `ALOJAMIENTO` WRITE;
/*!40000 ALTER TABLE `ALOJAMIENTO` DISABLE KEYS */;
INSERT INTO `ALOJAMIENTO` VALUES (4,'Bungalow 4'),(6,'Bungalow 6'),(21,'Bungalow 1'),(22,'Bungalow 2'),(24,'Bungalow 5');
/*!40000 ALTER TABLE `ALOJAMIENTO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CONTRATA`
--

DROP TABLE IF EXISTS `CONTRATA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CONTRATA` (
  `idContrata` int NOT NULL AUTO_INCREMENT,
  `idServicio` int NOT NULL,
  `idUsuario` int NOT NULL,
  `fechaContrata` date NOT NULL,
  PRIMARY KEY (`idContrata`),
  KEY `idUsuario` (`idUsuario`),
  KEY `CONTRATA_ibfk_1` (`idServicio`),
  CONSTRAINT `CONTRATA_ibfk_1` FOREIGN KEY (`idServicio`) REFERENCES `SERVICIO` (`idServicio`),
  CONSTRAINT `CONTRATA_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `USUARIO` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CONTRATA`
--

LOCK TABLES `CONTRATA` WRITE;
/*!40000 ALTER TABLE `CONTRATA` DISABLE KEYS */;
/*!40000 ALTER TABLE `CONTRATA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RESERVA`
--

DROP TABLE IF EXISTS `RESERVA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `RESERVA` (
  `idReserva` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `idAlojamiento` int NOT NULL,
  `fechaEntrada` date NOT NULL,
  `fechaSalida` date NOT NULL,
  PRIMARY KEY (`idReserva`),
  KEY `idAlojamiento` (`idAlojamiento`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `RESERVA_ibfk_1` FOREIGN KEY (`idAlojamiento`) REFERENCES `ALOJAMIENTO` (`idAlojamiento`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `RESERVA_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `USUARIO` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RESERVA`
--

LOCK TABLES `RESERVA` WRITE;
/*!40000 ALTER TABLE `RESERVA` DISABLE KEYS */;
INSERT INTO `RESERVA` VALUES (3,7,6,'2025-04-11','2025-04-13'),(5,9,21,'2025-04-12','2025-04-17'),(6,7,21,'2025-05-15','2025-05-18'),(7,7,22,'2025-05-16','2025-05-18'),(8,7,4,'2025-05-17','2025-05-18');
/*!40000 ALTER TABLE `RESERVA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ROL`
--

DROP TABLE IF EXISTS `ROL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ROL` (
  `idRol` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ROL`
--

LOCK TABLES `ROL` WRITE;
/*!40000 ALTER TABLE `ROL` DISABLE KEYS */;
INSERT INTO `ROL` VALUES (1,'administrador'),(2,'cliente'),(3,'superadministrador');
/*!40000 ALTER TABLE `ROL` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SERVICIO`
--

DROP TABLE IF EXISTS `SERVICIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SERVICIO` (
  `idServicio` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `aforo` int NOT NULL DEFAULT '20',
  `diasServicio` varchar(255) NOT NULL,
  `imagenRuta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idServicio`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SERVICIO`
--

LOCK TABLES `SERVICIO` WRITE;
/*!40000 ALTER TABLE `SERVICIO` DISABLE KEYS */;
INSERT INTO `SERVICIO` VALUES (10,'Visita al castillo','Visita guiada al castillo de Tahal y los alrededores para conocer su historia y legado.',20,'Sábado','img/servicios/681f23a0444c0.jpg'),(11,'Visita guiada por el pueblo','Visita guiada por los rincones más bonitos e históricos del pueblo.',20,'Domingo','img/servicios/681f32fb2815b.jpg'),(12,'Recogida de setas','Recogida de setas por los montes de Tahal.',50,'Sábado','img/servicios/681f33194f38d.webp'),(13,'Fiesta popular','Fiesta popular con arroz y charanga',100,'Sábado','img/servicios/681f33a256193.webp'),(14,'Ruta de los almendros','Ruta por los senderos del pueblo para ver los almendros en flor',30,'Domingo','img/servicios/681f33c01e09e.jpg'),(15,'Leyendas nocturnas','Paseo nocturno por los lugares más enigmáticos del pueblo.',20,'Sábado','img/servicios/681f33f1874db.jpg'),(16,'Carrera de montaña','Carrera por los bonitos parajes de la sierra de Tahal.',200,'Domingo','img/servicios/681f347b8d2ee.jpeg');
/*!40000 ALTER TABLE `SERVICIO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USUARIO`
--

DROP TABLE IF EXISTS `USUARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USUARIO` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `DNI` varchar(9) DEFAULT NULL,
  `correoElectronico` varchar(30) DEFAULT NULL,
  `contrasenna` varchar(400) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `CP` char(5) DEFAULT NULL,
  `idRol` int DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `DNI` (`DNI`),
  UNIQUE KEY `correoElectronico` (`correoElectronico`),
  KEY `idRol` (`idRol`),
  CONSTRAINT `USUARIO_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `ROL` (`idRol`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USUARIO`
--

LOCK TABLES `USUARIO` WRITE;
/*!40000 ALTER TABLE `USUARIO` DISABLE KEYS */;
INSERT INTO `USUARIO` VALUES (7,'56235623L','elloco@gmail.com','$2y$10$m0yAo7rvQ2dTVaI0xqZJT.DK8Wg/KEGPDGxG9AapMqI1NuSFpXzl2','Lexio','Georgin Marlos','23568',2),(9,'22222222A','patri@gmail.com','$2y$10$cOtgkPHoR7sDSyOIUCy0xeHpAKcbAaBsxCzdyQve3Deed.LyWGvzS','Patri','Abrantes Enriquez','04055',2),(15,'11111111A','admin@gmail.com','$2y$10$KD/iqlwWlML6MrEKcRfSs.1F5Wsfv57o2gzf/kydWv0BuMm6Wa8Qq','Admin','admin admin','11111',1),(17,'00000000A','superadministrador@gmail.com','$2y$10$tfBI/iI6M2zF2lX5SWkxBOc7r7wF0MTiKUAwNUS8UH0L1Gb2vjjiG','Admin','Admin Admin','00000',3);
/*!40000 ALTER TABLE `USUARIO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'PROYECTO_VISITAHAL'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-17 11:47:10
