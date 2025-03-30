-- MySQL dump 10.13  Distrib 9.2.0, for Linux (x86_64)
--
-- Host: localhost    Database: PROYECTO_VISITAHAL
-- ------------------------------------------------------
-- Server version	9.2.0

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

DROP TABLE IF EXISTS `ALOJAMIENTO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ALOJAMIENTO` (
  `idAlojamiento` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idAlojamiento`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALOJAMIENTO`
--

LOCK TABLES `ALOJAMIENTO` WRITE;
/*!40000 ALTER TABLE `ALOJAMIENTO` DISABLE KEYS */;
INSERT INTO `ALOJAMIENTO` VALUES (1,'Bungalow 1'),(2,'Bungalow 2'),(3,'Bungalow 3'),(4,'Bungalow 4'),(5,'Bungalow 5'),(6,'Bungalow 6');
/*!40000 ALTER TABLE `ALOJAMIENTO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CONTRATA`
--

DROP TABLE IF EXISTS `CONTRATA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CONTRATA` (
  `idServicio` int NOT NULL,
  `idUsuario` int NOT NULL,
  `fechaContrata` date NOT NULL,
  PRIMARY KEY (`idServicio`,`idUsuario`,`fechaContrata`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `CONTRATA_ibfk_1` FOREIGN KEY (`idServicio`) REFERENCES `SERVICIO` (`idServicio`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `CONTRATA_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `USUARIO` (`idUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RESERVA`
--

LOCK TABLES `RESERVA` WRITE;
/*!40000 ALTER TABLE `RESERVA` DISABLE KEYS */;
INSERT INTO `RESERVA` VALUES (3,7,6,'2025-04-11','2025-04-13'),(4,7,4,'2025-04-03','2025-04-06');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ROL`
--

LOCK TABLES `ROL` WRITE;
/*!40000 ALTER TABLE `ROL` DISABLE KEYS */;
INSERT INTO `ROL` VALUES (1,'administrador'),(2,'cliente');
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
  PRIMARY KEY (`idServicio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SERVICIO`
--

LOCK TABLES `SERVICIO` WRITE;
/*!40000 ALTER TABLE `SERVICIO` DISABLE KEYS */;
INSERT INTO `SERVICIO` VALUES (1,'castillo','Visita al castillo de Tahal'),(2,'sendero','Ruta por los parajes rurales del pueblo'),(3,'pueblo','Visita guiada por el pueblo y sus rincones más bonitos'),(4,'setas','Recogida de setas por los montes del pueblo'),(5,'fiesta','Fiesta popular con arroz y charanga'),(6,'almendros','Ruta de los almendros en flor'),(7,'leyendas','Visita guiada nocturna donde se narran las leyendas del pueblo');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USUARIO`
--

LOCK TABLES `USUARIO` WRITE;
/*!40000 ALTER TABLE `USUARIO` DISABLE KEYS */;
INSERT INTO `USUARIO` VALUES (1,'85878545C','llll@gmail.com','loco','Lex','Luthor','28001',2),(6,'85178545C','llgfdsll@gmail.com','loco','Lex','Luthor','28001',2),(7,'56235623L','elloco@gmail.com','$2y$10$m0yAo7rvQ2dTVaI0xqZJT.DK8Wg/KEGPDGxG9AapMqI1NuSFpXzl2','Lexio','Georgin Marlos','23568',2);
/*!40000 ALTER TABLE `USUARIO` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-30 11:30:46
