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
  `akses` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0=tidak ada akses, 1=akses respon, 2=semua akses',
  `flg_active` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y=aktif, N=tidak aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`user`,`password`,`nama`,`akses`,`flg_active`) values (1,'reynaldi','4a52576581484410901682859fcf4dbc','REYNALDI','2','Y');

/*Table structure for table `wgm_detail` */

DROP TABLE IF EXISTS `wgm_detail`;

CREATE TABLE `wgm_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `bencana` int(11) DEFAULT NULL,
  `tgl_kejadian` date NOT NULL,
  `nama_lokasi` text,
  `kelurahan` varchar(30) DEFAULT NULL,
  `kecamatan` varchar(30) DEFAULT NULL,
  `kota` varchar(30) DEFAULT NULL,
  `provinsi` varchar(30) DEFAULT NULL,
  `dampak` text,
  `kebutuhan` text,
  `create_date` date NOT NULL,
  `flg_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bencana` (`bencana`),
  CONSTRAINT `wgm_detail_ibfk_1` FOREIGN KEY (`bencana`) REFERENCES `wgm_tipe_bencana` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_detail` */

insert  into `wgm_detail`(`id`,`lat`,`lng`,`bencana`,`tgl_kejadian`,`nama_lokasi`,`kelurahan`,`kecamatan`,`kota`,`provinsi`,`dampak`,`kebutuhan`,`create_date`,`flg_active`) values (1,'-4.8524316','105.2190786',1,'2019-11-28','JL. LINTAS SUMATRA','TERBANGGI BESAR','TERBANGGI BESAR','LAMPUNG','KABUPATEN LAMPUNG','TERJADI GEMPA BUMI PADA PUKUL 00.12 ','TERJADI GEMPA BUMI PADA PUKUL 00.12 ','2019-11-03','Y'),(3,'-5.939360342871429','107.0608294057563',3,'2019-10-29','PANTAI BAKTI','MUARA GEMBONG','MUARA GEMBONG','BEKASI','JAWA BARAT','TELAH TERJADI TSUNAMI DENGAN KETINGGIAN 10M','TELAH TERJADI TSUNAMI DENGAN KETINGGIAN 10M','2019-11-03','Y'),(4,'-6.159427023609115','105.44050971471904',2,'2019-09-03','PULAU KRAKATAU, PULAU ANAK KRAKATAU','LAMPUNG SELATAN','LAMPUNG SELATAN','LAMPUNG SELATAN','LAMPUNG','TERJADI LETUSAN PADA ANAK KRAKATAU','TERJADI LETUSAN PADA ANAK KRAKATAU','2019-11-03','Y'),(5,'-4.4213064620510645','137.3946969820497',1,'2019-10-27','HOYA','JILA','JILA','KABUPATEN MIMIKA','PAPUA','TERJADI GEMPA BUMI DENGAN GETARAN 5SL','TERJADI GEMPA BUMI DENGAN GETARAN 5SL','2019-11-03','Y'),(6,'-6.299281490182','106.670573076983',1,'2019-11-11','BSD','JAKARYA','FSAF','FF','FD','FDFD','FDFD','2019-11-04','Y'),(7,'-6.305626338536418','106.68641516648529',4,'2019-11-13','RW. MEKAR JAYA, 15310','RW. MEKAR JAYA','KEC. SERPONG','KOTA TANGERANG SELATAN','BANTEN ','- AJSDASJ OASDKL\r\n- JASHDKL KASDJ KJASD\r\n- JKADSHFL','-IOOUI UWERYU WEJLRKH\r\n-KJJSDNF SDJFB JDBF JDF','2019-11-17','Y');

/*Table structure for table `wgm_group_kegiatan` */

DROP TABLE IF EXISTS `wgm_group_kegiatan`;

CREATE TABLE `wgm_group_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_group_kegiatan` */

insert  into `wgm_group_kegiatan`(`id`,`nama`) values (1,'DAPUR UMUM'),(2,'POS HANGAT'),(3,'KESEHATAN'),(4,'KEBERSIHAN'),(5,'LOGISTIC FOOD'),(6,'LOGISTIC NON FOOD'),(7,'DUKUNGAN PSIKOSOSIAL'),(8,'SANITASI'),(9,'AIR'),(10,'RECOVERY AWAL'),(11,'PEMULIHAN');

/*Table structure for table `wgm_last_update_timeline_kegiatan` */

DROP TABLE IF EXISTS `wgm_last_update_timeline_kegiatan`;

CREATE TABLE `wgm_last_update_timeline_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timeline_kegiatan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timeline_kegiatan_deskripsi` text,
  `tgl_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `wgm_last_update_timeline_kegiatan_ibfk_1` (`timeline_kegiatan_id`),
  CONSTRAINT `wgm_last_update_timeline_kegiatan_ibfk_1` FOREIGN KEY (`timeline_kegiatan_id`) REFERENCES `wgm_timeline_kegiatan` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_last_update_timeline_kegiatan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_last_update_timeline_kegiatan` */

insert  into `wgm_last_update_timeline_kegiatan`(`id`,`timeline_kegiatan_id`,`user_id`,`timeline_kegiatan_deskripsi`,`tgl_insert`) values (61,58,1,'df','2019-12-06 09:58:28'),(62,58,1,'bg','2019-12-06 09:58:28'),(63,58,1,'vb','2019-12-06 09:59:47'),(64,58,1,'rt','2019-12-06 09:58:47'),(65,58,1,'vb','2019-12-06 15:31:37'),(66,58,1,'rt','2019-12-06 15:31:37'),(67,58,1,'vb','2019-12-06 15:32:03'),(68,58,1,'rt','2019-12-06 15:32:03'),(69,58,1,'vb','2019-12-06 15:33:25'),(70,58,1,'rt','2019-12-06 15:33:25'),(71,58,1,'vb','2019-12-06 16:01:43'),(72,58,1,'rt','2019-12-06 16:01:43'),(73,58,1,'vb','2019-12-06 16:26:58'),(74,58,1,'rt','2019-12-06 16:26:58'),(75,58,1,'dfg','2019-12-06 16:26:58'),(76,58,1,'qwe','2019-12-06 16:28:17'),(77,58,1,'asd','2019-12-06 16:28:17'),(78,58,1,'mke','2019-12-06 16:28:17'),(79,58,1,'qwe','2019-12-07 11:39:45'),(80,58,1,'asd','2019-12-07 11:39:45'),(81,58,1,'mke','2019-12-07 11:39:45');

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
  `detail_id` int(11) DEFAULT NULL,
  `group_kegiatan_id` int(11) DEFAULT NULL,
  `deskripsi` text,
  `gambar` varchar(100) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_kegiatan_id` (`group_kegiatan_id`),
  KEY `detail_id` (`detail_id`),
  CONSTRAINT `wgm_timeline_kegiatan_ibfk_2` FOREIGN KEY (`group_kegiatan_id`) REFERENCES `wgm_group_kegiatan` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_timeline_kegiatan_ibfk_3` FOREIGN KEY (`detail_id`) REFERENCES `wgm_detail` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_timeline_kegiatan` */

insert  into `wgm_timeline_kegiatan`(`id`,`detail_id`,`group_kegiatan_id`,`deskripsi`,`gambar`,`waktu`) values (58,7,1,'qwe|asd|mke','f8fb696633ee8a334a2d3ca72dcc53f0-1575693586.jpg',NULL);

/*Table structure for table `wgm_tipe_bencana` */

DROP TABLE IF EXISTS `wgm_tipe_bencana`;

CREATE TABLE `wgm_tipe_bencana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_tipe_bencana` */

insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (1,'GEMPA BUMI','gempa.png'),(2,'GUNUNG MELETUS','erupsi.png'),(3,'TSUNAMI','tsunami.png'),(4,'BANJIR','banjir.png'),(5,'LONGSOR','longsor.png'),(6,'KEBAKARAN HUTAN','karhutla.png'),(7,'KEBAKARAN PEMUKIMAN','kebakaran.png'),(8,'KEKERINGAN','kekeringan.png'),(9,'LAINNYA','lainnya.png');

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `yuyuy` */

/*!50106 DROP EVENT IF EXISTS `yuyuy`*/;

DELIMITER $$

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `yuyuy` ON SCHEDULE EVERY 1 DAY STARTS '2019-11-26 21:01:25' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	    select md5(123);
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
