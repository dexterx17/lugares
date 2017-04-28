-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: lugares
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

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
-- Table structure for table `categoria_lugar`
--

DROP TABLE IF EXISTS `categoria_lugar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_lugar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoria_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lugar_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoria_lugar_categoria_id_lugar_id_unique` (`categoria_id`,`lugar_id`),
  KEY `categoria_lugar_lugar_id_foreign` (`lugar_id`),
  CONSTRAINT `categoria_lugar_lugar_id_foreign` FOREIGN KEY (`lugar_id`) REFERENCES `lugares` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categoria_lugar_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_lugar`
--

LOCK TABLES `categoria_lugar` WRITE;
/*!40000 ALTER TABLE `categoria_lugar` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria_lugar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `categoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_unicode_ci,
  `objetivo` text COLLATE utf8_unicode_ci,
  `icono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT '0',
  `icono_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES ('amusement_park','Parque de atracciones','schoen.breanne@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?72072','2017-04-28 09:04:10','2017-04-28 09:04:10'),('aquarium','Acuario','ryan.wisozk@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?33583','2017-04-28 09:04:10','2017-04-28 09:04:10'),('art_gallery','Galería de arte','hallie.goyette@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?44256','2017-04-28 09:04:10','2017-04-28 09:04:10'),('atm','Cajero automático','marietta03@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?70733','2017-04-28 09:04:10','2017-04-28 09:04:10'),('bakery','Panadería','sunny.schultz@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?85127','2017-04-28 09:04:10','2017-04-28 09:04:10'),('bar','Bares','lura24@example.net','Vive nuevas experiencias, puedes visitar un bar diferente cada vez que salgas con tus amigos y cuando los hayas visto todos sabrás cual es el mejor.',NULL,1,'http://lorempixel.com/640/480/?75374','2017-04-28 09:04:10','2017-04-28 09:28:02'),('book_store','Librería','farrell.ethan@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?20438','2017-04-28 09:04:10','2017-04-28 09:04:10'),('bowling_alley','Bolera','esmeralda.littel@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?11951','2017-04-28 09:04:10','2017-04-28 09:04:10'),('bus_station','Estación de autobuses','effertz.hudson@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?26915','2017-04-28 09:04:10','2017-04-28 09:04:10'),('cafe','Cafetería','osvaldo20@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?18708','2017-04-28 09:04:10','2017-04-28 09:04:10'),('campground','Terreno de camping','candelario20@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?31075','2017-04-28 09:04:10','2017-04-28 09:04:10'),('casino','Casino','hagenes.jordy@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?89343','2017-04-28 09:04:10','2017-04-28 09:04:10'),('cemetery','Cementerio','hermiston.aryanna@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?59451','2017-04-28 09:04:10','2017-04-28 09:04:10'),('church','Iglesia','judson.crooks@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?70252','2017-04-28 09:04:11','2017-04-28 09:04:11'),('city_hall','Palacio Municipal','sydnie33@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?62591','2017-04-28 09:04:11','2017-04-28 09:04:11'),('clothing_store','Tienda de ropa','ofriesen@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?54912','2017-04-28 09:04:11','2017-04-28 09:04:11'),('convenience_store','Tienda de conveniencia','alex69@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?68532','2017-04-28 09:04:11','2017-04-28 09:04:11'),('courthouse','Palacio de justicia','samson.veum@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?29084','2017-04-28 09:04:11','2017-04-28 09:04:11'),('department_store','Grandes almacenes','imani.mcdermott@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?63771','2017-04-28 09:04:11','2017-04-28 09:04:11'),('embassy','Embajada','ischuster@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?51658','2017-04-28 09:04:11','2017-04-28 09:04:11'),('gas_station','Gasolinera','stokes.esperanza@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?35994','2017-04-28 09:04:11','2017-04-28 09:04:11'),('gym','Gimnasio','gcarroll@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?52697','2017-04-28 09:04:11','2017-04-28 09:04:11'),('hindu_temple','Templo hindú','layla39@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?53099','2017-04-28 09:04:12','2017-04-28 09:04:12'),('home_goods_store','Home_goods_store','casimir.rowe@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?75918','2017-04-28 09:04:12','2017-04-28 09:04:12'),('library','Biblioteca','ebert.frank@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?67277','2017-04-28 09:04:12','2017-04-28 09:04:12'),('liquor_store','Tienda de licores','margret.braun@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?45323','2017-04-28 09:04:12','2017-04-28 09:04:12'),('lodging','Alojamiento','graham.sarah@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?80556','2017-04-28 09:04:12','2017-04-28 09:04:12'),('meal_delivery','Entrega de comida','ikshlerin@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?92249','2017-04-28 09:04:12','2017-04-28 09:04:12'),('meal_takeaway','Comida para llevar','greenholt.dagmar@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?53011','2017-04-28 09:04:12','2017-04-28 09:04:12'),('mosque','Mezquita','mayra.kling@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?57029','2017-04-28 09:04:12','2017-04-28 09:04:12'),('movie_theater','Cine','rosie.white@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?36231','2017-04-28 09:04:12','2017-04-28 09:04:12'),('museum','Museo','micheal.friesen@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?86240','2017-04-28 09:04:12','2017-04-28 09:04:12'),('night_club','Club nocturno','barton.princess@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?59463','2017-04-28 09:04:13','2017-04-28 09:04:13'),('park','Parque','odavis@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?28884','2017-04-28 09:04:13','2017-04-28 09:04:13'),('pet_store','Tienda de mascotas','rice.jared@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?54239','2017-04-28 09:04:13','2017-04-28 09:04:13'),('real_estate_agency','Real_estate_agency','meaghan40@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?24363','2017-04-28 09:04:14','2017-04-28 09:04:14'),('restaurant','Restaurante','jonatan.kovacek@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?37573','2017-04-28 09:04:14','2017-04-28 09:04:14'),('rv_park','Rv_park','tkoss@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?98590','2017-04-28 09:04:14','2017-04-28 09:04:14'),('shoe_store','Tienda de zapatos','carter.annie@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?33780','2017-04-28 09:04:14','2017-04-28 09:04:14'),('shopping_mall','Centro comercial','koss.estevan@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?88181','2017-04-28 09:04:14','2017-04-28 09:04:14'),('spa','Spa','xluettgen@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?84371','2017-04-28 09:04:14','2017-04-28 09:04:14'),('stadium','Estadio','kayla63@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?85281','2017-04-28 09:04:14','2017-04-28 09:04:14'),('subway_station','Estación de metro','eugene06@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?34857','2017-04-28 09:04:14','2017-04-28 09:04:14'),('synagogue','Sinagoga','rosalinda24@example.com',NULL,NULL,0,'http://lorempixel.com/640/480/?87845','2017-04-28 09:04:14','2017-04-28 09:04:14'),('taxi_stand','Parada de taxi','justina.bergstrom@example.net',NULL,NULL,0,'http://lorempixel.com/640/480/?37054','2017-04-28 09:04:14','2017-04-28 09:04:14'),('train_station','Estación de tren','virginia09@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?84168','2017-04-28 09:04:14','2017-04-28 09:04:14'),('zoo','Zoo','jimmy.kuphal@example.org',NULL,NULL,0,'http://lorempixel.com/640/480/?45491','2017-04-28 09:04:15','2017-04-28 09:04:15');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lugar_user`
--

DROP TABLE IF EXISTS `lugar_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lugar_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `lugar_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lugar_user_user_id_lugar_id_unique` (`user_id`,`lugar_id`),
  KEY `lugar_user_lugar_id_foreign` (`lugar_id`),
  CONSTRAINT `lugar_user_lugar_id_foreign` FOREIGN KEY (`lugar_id`) REFERENCES `lugares` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lugar_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lugar_user`
--

LOCK TABLES `lugar_user` WRITE;
/*!40000 ALTER TABLE `lugar_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `lugar_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lugares`
--

DROP TABLE IF EXISTS `lugares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lugares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vecinity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `id_0` int(11) DEFAULT NULL,
  `id_1` int(11) DEFAULT NULL,
  `id_2` int(11) DEFAULT NULL,
  `id_3` int(11) DEFAULT NULL,
  `loaded` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lugares_google_id_unique` (`google_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lugares`
--

LOCK TABLES `lugares` WRITE;
/*!40000 ALTER TABLE `lugares` DISABLE KEYS */;
/*!40000 ALTER TABLE `lugares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2017_04_24_032331_create_categorias_table',1),('2017_04_24_032349_create_lugars_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pais` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_provider_id_unique` (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test','test@test.com','$2y$10$ppkd3LsQpYwpiueSNVyZIOwvW7W4yEG3bnHib5hxKBSoGtAnq2nhG',NULL,NULL,'','',NULL,NULL,'ztuKvccdZX','2017-04-28 09:04:09','2017-04-28 09:04:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-27 23:59:53
