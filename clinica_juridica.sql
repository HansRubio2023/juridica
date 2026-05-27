CREATE DATABASE  IF NOT EXISTS `clinica_juridica` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `clinica_juridica`;
-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: clinica_juridica
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `__migrationhistory`
--

DROP TABLE IF EXISTS `__migrationhistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `__migrationhistory` (
  `MigrationId` varchar(150) NOT NULL,
  `ContextKey` varchar(300) NOT NULL,
  `Model` longblob NOT NULL,
  `ProductVersion` varchar(32) NOT NULL,
  PRIMARY KEY (`MigrationId`,`ContextKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `__migrationhistory`
--

LOCK TABLES `__migrationhistory` WRITE;
/*!40000 ALTER TABLE `__migrationhistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `__migrationhistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atenciones`
--

DROP TABLE IF EXISTS `atenciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atenciones` (
  `id_atencion` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_responsable` int DEFAULT NULL,
  `id_causa` int DEFAULT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  `fecha_atencion` date DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_atencion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_responsable` (`id_responsable`),
  KEY `id_causa` (`id_causa`),
  CONSTRAINT `atenciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `atenciones_ibfk_2` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`),
  CONSTRAINT `atenciones_ibfk_3` FOREIGN KEY (`id_causa`) REFERENCES `causas` (`id_causa`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atenciones`
--

LOCK TABLES `atenciones` WRITE;
/*!40000 ALTER TABLE `atenciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `atenciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Familia'),(7,'Corte Suprema'),(8,'Corte de Apelaciones'),(9,'Civil'),(10,'Laboral'),(11,'Cobranza'),(12,'Garantía');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `causas`
--

DROP TABLE IF EXISTS `causas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `causas` (
  `id_causa` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_tipo_causa` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `rit` varchar(20) DEFAULT NULL,
  `id_responsable` int DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `id_resultado` int DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_causa`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_tipo_causa` (`id_tipo_causa`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_responsable` (`id_responsable`),
  KEY `id_resultado` (`id_resultado`),
  CONSTRAINT `causas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `causas_ibfk_2` FOREIGN KEY (`id_tipo_causa`) REFERENCES `tipo_causa` (`id_tipo_causa`),
  CONSTRAINT `causas_ibfk_3` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  CONSTRAINT `causas_ibfk_4` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`),
  CONSTRAINT `causas_ibfk_5` FOREIGN KEY (`id_resultado`) REFERENCES `resultado_causa` (`id_resultado_causa`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `causas`
--

LOCK TABLES `causas` WRITE;
/*!40000 ALTER TABLE `causas` DISABLE KEYS */;
/*!40000 ALTER TABLE `causas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comunas`
--

DROP TABLE IF EXISTS `comunas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comunas` (
  `id_comuna` int NOT NULL AUTO_INCREMENT,
  `nombre_comuna` varchar(50) NOT NULL,
  PRIMARY KEY (`id_comuna`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comunas`
--

LOCK TABLES `comunas` WRITE;
/*!40000 ALTER TABLE `comunas` DISABLE KEYS */;
INSERT INTO `comunas` VALUES (1,'Victoria'),(2,'Traiguén'),(3,'Collipulli'),(4,'Temuco'),(5,'Lonquimay'),(6,'Carahue'),(7,'Chol Chol'),(8,'Cunco'),(9,'Curarrehue'),(10,'Freire'),(11,'Galvarino'),(12,'Gorbea'),(13,'Lautaro'),(14,'Loncoche'),(15,'Melipeuco'),(16,'Nueva Imperial'),(17,'Padre Las Casas'),(18,'Perquenco'),(19,'Pitrufquén'),(20,'Pucón'),(21,'Puerto Saavedra'),(22,'Teodoro Schmidt'),(23,'Toltén'),(24,'Vilcún'),(25,'Villarrica'),(26,'Angol'),(27,'Curacautín'),(28,'Ercilla'),(29,'Los Sauces'),(30,'Lumaco'),(31,'Purén'),(32,'Renaico'),(33,'Otro'),(34,'Las condes'),(35,'Talca'),(36,'Chillán');
/*!40000 ALTER TABLE `comunas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_causa`
--

DROP TABLE IF EXISTS `documentos_causa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_causa` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `id_causa` int NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_causa`
--

LOCK TABLES `documentos_causa` WRITE;
/*!40000 ALTER TABLE `documentos_causa` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_causa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_civil`
--

DROP TABLE IF EXISTS `estado_civil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_civil` (
  `id_estado_civil` int NOT NULL AUTO_INCREMENT,
  `nombre_estado_civil` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado_civil`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_civil`
--

LOCK TABLES `estado_civil` WRITE;
/*!40000 ALTER TABLE `estado_civil` DISABLE KEYS */;
INSERT INTO `estado_civil` VALUES (1,'Soltero'),(2,'Casado'),(3,'Viudo'),(4,'Divorciado'),(5,'Separado'),(6,'Conviviente');
/*!40000 ALTER TABLE `estado_civil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `usuario` varchar(60) DEFAULT NULL,
  `rol` varchar(50) DEFAULT 'usuario',
  `fecha_logueo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfiles`
--

LOCK TABLES `perfiles` WRITE;
/*!40000 ALTER TABLE `perfiles` DISABLE KEYS */;
INSERT INTO `perfiles` VALUES (1,'admin@unap.cl','$2y$10$uC884..wdEZ9QKWPEx/zK.4zep3EM7yghKozjY.7XNwcwGeyCKs7G','Admin','admin','2026-04-30 17:07:58'),(3,'estudiante@unap.cl','$2y$10$2aDkBrAiQuh27ygAWG8T/eIvgaRABSB2SsJ.l9L23koIXjE58gnuu','Patricio G','estudiante','2026-05-04 16:02:29'),(6,'tfiguero@unap.cl','$2y$10$qe2teoK9jkSFEX5QZgp.0.JabOmMrlwxvpaY05FCjrSbVX2zeAHKO','Tatiana Figueroa','usuario','2026-05-13 15:46:34'),(7,'gaaguilera@unap.cl','$2y$10$3p7fPr/ePkuUbny6FpPA4OCdoVKoPRfxynNu3rpcRuwYzneGRe3mC','Gabriela Aguilera','usuario','2026-05-18 14:23:44'),(8,'patricjara@unap.cl','$2y$10$o78pTWI5CEaGU/H91gQZsO73StYCcZ0vnpPtgKvPrUGInYv60YvnS','Patricia Jara','usuario','2026-05-18 14:24:20');
/*!40000 ALTER TABLE `perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsables`
--

DROP TABLE IF EXISTS `responsables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsables` (
  `id_responsable` int NOT NULL AUTO_INCREMENT,
  `nombre_responsable` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_responsable`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsables`
--

LOCK TABLES `responsables` WRITE;
/*!40000 ALTER TABLE `responsables` DISABLE KEYS */;
INSERT INTO `responsables` VALUES (2,'Tatiana F'),(3,'Manuel S');
/*!40000 ALTER TABLE `responsables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultado_causa`
--

DROP TABLE IF EXISTS `resultado_causa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resultado_causa` (
  `id_resultado_causa` int NOT NULL AUTO_INCREMENT,
  `nombre_resultado_causa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_resultado_causa`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultado_causa`
--

LOCK TABLES `resultado_causa` WRITE;
/*!40000 ALTER TABLE `resultado_causa` DISABLE KEYS */;
INSERT INTO `resultado_causa` VALUES (2,'Sentencia Favorable'),(3,'Conciliación/Transacción'),(5,'En tramitación'),(6,'Sentencia no favorable'),(7,'Suspendida'),(8,'Desistida');
/*!40000 ALTER TABLE `resultado_causa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_causa`
--

DROP TABLE IF EXISTS `tipo_causa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_causa` (
  `id_tipo_causa` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_causa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_causa`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_causa`
--

LOCK TABLES `tipo_causa` WRITE;
/*!40000 ALTER TABLE `tipo_causa` DISABLE KEYS */;
INSERT INTO `tipo_causa` VALUES (1,'Alimentos Rebaja'),(2,'Cuidado personal del niño'),(3,'Cuidado personal del niño, declaracion'),(4,'Cuidado personal del niño, modificacion'),(5,'Relacion directa y regular con el niño'),(6,'Relacion directa y regular modificacion'),(7,'Autorizacion salida del pais'),(8,'Matrimonio, Disenso Para Contraer'),(9,'Patria potestad (emancipacion judicial)'),(10,'Patria potestad solicitud'),(11,'Guardador Menores De Edad, Nombramiento'),(12,'Patria Potestad, Otros'),(13,'Alimentos'),(14,'Alimentos aumento'),(15,'Alimentos cesacion'),(16,'Alimentos, Cumplimientos'),(18,'Patria potestad renuncia'),(19,'Guardador Menores de Edad, Remocion'),(21,'Relacion directa y regular suspension'),(22,'Nulidad matrimonial'),(23,'Separacion judicial de bienes'),(24,'Cese de Convivencia'),(25,'Divorcio de común Acuerdo'),(26,'Relacion Directa y Regular, Otros'),(27,'Patria potestad suspension'),(28,'Demencia, interdicción por'),(29,'Disipacion, interdicción por'),(30,'Pagaré, acción cambiara ordinaria'),(31,'Indemnización de perjuicios transporte aéreo'),(32,'Indemnizacion de perjuicios transporte terrestre'),(33,'Ley indigena (Art. 56 de la Ley 19.253)'),(34,'Ley 20.609 contra la discriminación'),(35,'Simulación, acción de'),(36,'Desposeimiento, acción ordinaria de'),(37,'Hipotecaria, accion'),(38,'Revocatorias, acción pauliana'),(39,'Acción Ley 19585'),(40,'Pesos, cobro de'),(41,'Contrato, cumplimiento de'),(43,'Contrato, nulidad de'),(44,'Expropiación, nulidad de'),(45,'Testamento, nulidad de'),(47,'Herencia, petición de'),(48,'Herencia, proced. cuantía inferior art. 749 C.PC.'),(49,'Herencia, proced. cuantía superior art. 749 C.PC.'),(50,'Prescrip. extinción de acciones'),(51,'Testamento, reforma de'),(52,'Reivindicación'),(53,'Contrato, resolución de'),(54,'Acto Administrativo, nulidad de'),(55,'Cheque, acción ordinaria de cobro'),(56,'Letra, acción cambiaria ordinaria'),(57,'Lesión enorme, acción de rescisión por'),(59,'Mutuo de dinero, cobro de');
/*!40000 ALTER TABLE `tipo_causa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertokencaches`
--

DROP TABLE IF EXISTS `usertokencaches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertokencaches` (
  `UserTokenCacheId` int NOT NULL AUTO_INCREMENT,
  `webUserUniqueId` text,
  `cacheBits` longblob,
  `LastWrite` datetime NOT NULL,
  PRIMARY KEY (`UserTokenCacheId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertokencaches`
--

LOCK TABLES `usertokencaches` WRITE;
/*!40000 ALTER TABLE `usertokencaches` DISABLE KEYS */;
/*!40000 ALTER TABLE `usertokencaches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `rut` varchar(12) NOT NULL,
  `dv` varchar(1) DEFAULT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `domicilio` varchar(150) DEFAULT NULL,
  `sector` varchar(50) DEFAULT NULL,
  `telefono_fijo` varchar(20) DEFAULT NULL,
  `id_estado_civil` int DEFAULT NULL,
  `id_comuna` int DEFAULT NULL,
  `fecha_ingreso` date DEFAULT (curdate()),
  `comentarios` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `rut` (`rut`),
  KEY `id_estado_civil` (`id_estado_civil`),
  KEY `id_comuna` (`id_comuna`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_estado_civil`) REFERENCES `estado_civil` (`id_estado_civil`),
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_comuna`) REFERENCES `comunas` (`id_comuna`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vista_usuario`
--

DROP TABLE IF EXISTS `vista_usuario`;
/*!50001 DROP VIEW IF EXISTS `vista_usuario`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vista_usuario` AS SELECT 
 1 AS `id_usuario`,
 1 AS `rut`,
 1 AS `nombre_completo`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vista_usuario`
--

/*!50001 DROP VIEW IF EXISTS `vista_usuario`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_usuario` AS select `usuarios`.`id_usuario` AS `id_usuario`,`usuarios`.`rut` AS `rut`,concat(`usuarios`.`apellidos`,' ',`usuarios`.`nombres`) AS `nombre_completo` from `usuarios` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-27 16:54:08
