-- MySQL dump 10.16  Distrib 10.1.30-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: new_project
-- ------------------------------------------------------
-- Server version	10.1.30-MariaDB

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
-- Table structure for table `constants`
--

DROP TABLE IF EXISTS `constants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `constants` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  `domainname` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `reviews_on_page` int(3) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `constants`
--

LOCK TABLES `constants` WRITE;
/*!40000 ALTER TABLE `constants` DISABLE KEYS */;
INSERT INTO `constants` VALUES (1,'ru','http://localhost/new_project','Название сайта','Не является публичной офертой',3,'lyubomyr83@mail.ru'),(2,'en','http://localhost/new_project','Site name','Not a public offer',3,'lyubomyr83@mail.ru');
/*!40000 ALTER TABLE `constants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `default_lng` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'ru','русский','1','1'),(2,'en','english','1','0');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `position` int(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `created` int(255) NOT NULL,
  `lastmod` int(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `header_visible` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Мы предлагаем',1,'ru',1525698194,0,'1','1'),(2,'We offer',2,'en',1525698194,0,'1','1');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(3) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `menu_icon` varchar(255) NOT NULL,
  `icon_size` varchar(255) NOT NULL,
  `menu_number` int(4) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `language` varchar(255) NOT NULL,
  `created` int(255) NOT NULL,
  `lastmod` int(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `visible_in_main_menu` enum('0','1') NOT NULL,
  `visible_in_sidebar` enum('0','1') NOT NULL,
  `active_link_in_sidebar` enum('0','1') NOT NULL,
  `reviews_visible` enum('0','1') NOT NULL,
  `reviews_add` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,'','','адрес сайта | Ключевое слово | Главная','icon-home','icon-large',1,'Главная',1,'Главная','ru',1525698194,0,'1','1','1','1','1','1'),(2,0,'','','site address | Keyword | Main','icon-home','icon-large',2,'Main',3,'Main','en',1525698194,0,'1','1','1','1','0','0'),(3,1,'','','адрес сайта | Ключевое слово | Пример страницы','','',1,'Пример страницы',2,'Пример страницы','ru',1525698194,0,'1','0','1','1','1','0'),(4,2,'','','site address | Keyword | Example page','','',2,'Example page',4,'Example page','en',1525698194,0,'1','0','1','1','1','0');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `page_id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `autor` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `state` varchar(255) NOT NULL,
  `created` int(255) NOT NULL,
  `lastmod` int(255) NOT NULL,
  `rating` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,3,'Первый отзыв','Очень хороший отзыв на странице \"Пример страницы\"','Администратор сайта','clubintellect@mail.ru','1','new',1525698194,0,5),(2,4,'Second review','Very good review on page \"Example page\"','Site administrator','clubintellect@mail.ru','0','good',1525698194,0,5),(3,1,'Отзыв на главной','Пример отзыва на странице \"Главная\"','Администратор сайта','clubintellect@mail.ru','1','good',1525698194,0,4);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','42f3d4cf9443bb1cbf053f7933f37d98');
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

-- Dump completed on 2018-05-07 16:05:33
