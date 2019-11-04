/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.40-MariaDB : Database - db_gis
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_gis` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_gis`;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `flg_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user` */

/*Table structure for table `wgm_detail` */

DROP TABLE IF EXISTS `wgm_detail`;

CREATE TABLE `wgm_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `bencana` int(11) DEFAULT NULL,
  `nama_lokasi` text,
  `kelurahan` varchar(30) DEFAULT NULL,
  `kecamatan` varchar(30) DEFAULT NULL,
  `kota` varchar(30) DEFAULT NULL,
  `provinsi` varchar(30) DEFAULT NULL,
  `deskripsi` text,
  `group_kegiatan` int(11) DEFAULT NULL,
  `create_date` date NOT NULL,
  `flg_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bencana` (`bencana`),
  KEY `group_kegiatan` (`group_kegiatan`),
  CONSTRAINT `wgm_detail_ibfk_1` FOREIGN KEY (`bencana`) REFERENCES `wgm_tipe_bencana` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_detail_ibfk_2` FOREIGN KEY (`group_kegiatan`) REFERENCES `wgm_group_kegiatan` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_detail` */

insert  into `wgm_detail`(`id`,`lat`,`lng`,`bencana`,`nama_lokasi`,`kelurahan`,`kecamatan`,`kota`,`provinsi`,`deskripsi`,`group_kegiatan`,`create_date`,`flg_active`) values (1,'-4.8524316','105.2190786',1,'JL. LINTAS SUMATRA','TERBANGGI BESAR','TERBANGGI BESAR','LAMPUNG','KABUPATEN LAMPUNG','TERJADI GEMPA BUMI PADA PUKUL 00.12 ',NULL,'2019-11-03','Y'),(3,'-5.939360342871429','107.0608294057563',3,'PANTAI BAKTI','MUARA GEMBONG','MUARA GEMBONG','BEKASI','JAWA BARAT','TELAH TERJADI TSUNAMI DENGAN KETINGGIAN 10M',NULL,'2019-11-03','Y'),(4,'-6.159427023609115','105.44050971471904',2,'PULAU KRAKATAU, PULAU ANAK KRAKATAU','LAMPUNG SELATAN','LAMPUNG SELATAN','LAMPUNG SELATAN','LAMPUNG','TERJADI LETUSAN PADA ANAK KRAKATAU',NULL,'2019-11-03','Y'),(5,'-4.4213064620510645','137.3946969820497',1,'HOYA','JILA','JILA','KABUPATEN MIMIKA','PAPUA','TERJADI GEMPA BUMI DENGAN GETARAN 5SL',NULL,'2019-11-03','Y'),(6,'-6.299281490182','106.670573076983',1,'BSD','JAKARYA','FSAF','FF','FD','FDFD',NULL,'2019-11-04','Y');

/*Table structure for table `wgm_group_kegiatan` */

DROP TABLE IF EXISTS `wgm_group_kegiatan`;

CREATE TABLE `wgm_group_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_group_kegiatan` */

insert  into `wgm_group_kegiatan`(`id`,`nama`,`deskripsi`) values (1,'a','vcv'),(2,'b','vvvvvvvvvvvvv');

/*Table structure for table `wgm_request_support` */

DROP TABLE IF EXISTS `wgm_request_support`;

CREATE TABLE `wgm_request_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `tipe_bencana_id` int(11) DEFAULT NULL,
  `group_kegiatan_id` int(11) DEFAULT NULL,
  `detail` text,
  `gambar` varchar(30) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `status` enum('MENUNGGU','DITERIMA') DEFAULT 'MENUNGGU',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `tipe_bencana_id` (`tipe_bencana_id`),
  KEY `group_kegiatan_id` (`group_kegiatan_id`),
  CONSTRAINT `wgm_request_support_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_request_support_ibfk_2` FOREIGN KEY (`tipe_bencana_id`) REFERENCES `wgm_tipe_bencana` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_request_support_ibfk_3` FOREIGN KEY (`group_kegiatan_id`) REFERENCES `wgm_group_kegiatan` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `wgm_request_support` */

/*Table structure for table `wgm_timeline_kegiatan` */

DROP TABLE IF EXISTS `wgm_timeline_kegiatan`;

CREATE TABLE `wgm_timeline_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_kegiatan_id` int(11) DEFAULT NULL,
  `detail` text,
  `gambar` varchar(30) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_kegiatan_id` (`group_kegiatan_id`),
  CONSTRAINT `wgm_timeline_kegiatan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_timeline_kegiatan_ibfk_2` FOREIGN KEY (`group_kegiatan_id`) REFERENCES `wgm_group_kegiatan` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `wgm_timeline_kegiatan` */

/*Table structure for table `wgm_tipe_bencana` */

DROP TABLE IF EXISTS `wgm_tipe_bencana`;

CREATE TABLE `wgm_tipe_bencana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_tipe_bencana` */

insert  into `wgm_tipe_bencana`(`id`,`nama`) values (1,'GEMPA BUMI'),(2,'GUNUNG MELETUS'),(3,'TSUNAMI'),(4,'BANJIR');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
