-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.37 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных queue_db
DROP DATABASE IF EXISTS `queue_db`;
CREATE DATABASE IF NOT EXISTS `queue_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `queue_db`;

-- Дамп структуры для таблица queue_db.queue
DROP TABLE IF EXISTS `queue`;
CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL DEFAULT '0',
  `num` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `QueueStatus` (`status_id`),
  CONSTRAINT `QueueStatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы queue_db.queue: ~5 rows (приблизительно)
DELETE FROM `queue`;
/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
INSERT INTO `queue` (`id`, `doctor_id`, `num`, `date`, `status_id`) VALUES
	(210, 11, 1, '2019-01-13 16:44:37', 1),
	(211, 11, 2, '2019-01-13 16:44:38', 1),
	(212, 11, 3, '2019-01-13 16:44:38', 1),
	(213, 11, 4, '2019-01-13 16:44:39', 1),
	(214, 11, 5, '2019-01-13 16:44:40', 1);
/*!40000 ALTER TABLE `queue` ENABLE KEYS */;

-- Дамп структуры для таблица queue_db.role
DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы queue_db.role: ~2 rows (приблизительно)
DELETE FROM `role`;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `name`) VALUES
	(1, 'Администратор'),
	(2, 'Доктор');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Дамп структуры для таблица queue_db.status
DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы queue_db.status: ~4 rows (приблизительно)
DELETE FROM `status`;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`, `name`) VALUES
	(1, 'В очереди'),
	(2, 'В ожидании'),
	(3, 'В процессе'),
	(4, 'Завершен');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Дамп структуры для таблица queue_db.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '0',
  `specialization` varchar(255) NOT NULL DEFAULT '0',
  `cabinet` int(3) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы queue_db.user: ~2 rows (приблизительно)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `login`, `password`, `name`, `specialization`, `cabinet`, `active`, `role_id`) VALUES
	(3, 'admin', '202cb962ac59075b964b07152d234b70', 'Даниил Сидоров', 'Администратор', 223, 1, 1),
	(6, '1', '1', '1', '1', 1, 1, 1),
	(10, 'kek', '', 'Анна Стародуб3', 'пваыпывап', 322, 0, 2),
	(11, 'kek', '', 'Анна Стародуб3', 'нкуекуенкенк', 222, 1, 2),
	(12, 'kek', '', 'Анна Стародуб3', 'Стоматолог', 322, 1, 2);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
