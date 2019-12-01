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

/*Table structure for table `test` */

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `test` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `test` */

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_group_kegiatan` */

insert  into `wgm_group_kegiatan`(`id`,`nama`) values (1,'ASSESMENT'),(2,'KESEHATAN'),(3,'EVAKUASI'),(4,'AIR & SANITASI'),(5,'PERMAKANAN'),(6,'DUKUNGAN PSIKOSOSIAL'),(7,'LOGISTIK'),(8,'RECOVERY AWAL');

/*Table structure for table `wgm_last_update_timeline_kegiatan` */

DROP TABLE IF EXISTS `wgm_last_update_timeline_kegiatan`;

CREATE TABLE `wgm_last_update_timeline_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timeline_kegiatan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timeline_kegiatan_deskripsi` text,
  `tgl_insert` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `wgm_last_update_timeline_kegiatan_ibfk_1` (`timeline_kegiatan_id`),
  CONSTRAINT `wgm_last_update_timeline_kegiatan_ibfk_1` FOREIGN KEY (`timeline_kegiatan_id`) REFERENCES `wgm_timeline_kegiatan` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_last_update_timeline_kegiatan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_last_update_timeline_kegiatan` */

insert  into `wgm_last_update_timeline_kegiatan`(`id`,`timeline_kegiatan_id`,`user_id`,`timeline_kegiatan_deskripsi`,`tgl_insert`) values (1,1,1,'KFNJ DSJNF DJNF','2019-11-29 14:48:13'),(2,1,1,'KJFIEF ENFIE IEI','2019-11-29 14:48:57'),(3,2,1,'AWRV SDSDFSVRV NYJMUK','2019-11-29 14:49:10'),(4,2,1,'SDFWV4TGH HRRHTHRTHR G','2019-11-29 14:55:27'),(5,3,1,'KDFVFNJ DSJDVDFVNF SFGBG','2019-11-29 14:55:29'),(6,3,1,'DFGF DGRTHGRGBT NTYHNGF R DF','2019-11-29 14:55:32');

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
  `gambar` varchar(30) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_kegiatan_id` (`group_kegiatan_id`),
  KEY `detail_id` (`detail_id`),
  CONSTRAINT `wgm_timeline_kegiatan_ibfk_2` FOREIGN KEY (`group_kegiatan_id`) REFERENCES `wgm_group_kegiatan` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wgm_timeline_kegiatan_ibfk_3` FOREIGN KEY (`detail_id`) REFERENCES `wgm_detail` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_timeline_kegiatan` */

insert  into `wgm_timeline_kegiatan`(`id`,`detail_id`,`group_kegiatan_id`,`deskripsi`,`gambar`,`waktu`) values (1,5,1,'KFNJ DSJNF DJNF|KJFIEF ENFIE IEI','file/gambar.jpg','2019-11-25 18:59:55'),(2,5,2,'AWRV SDSDFSVRV NYJMUK|SDFWV4TGH HRRHTHRTHR G','file/gambar.jpg','2019-11-26 19:38:17'),(3,5,3,'KDFVFNJ DSJDVDFVNF SFGBG|DFGF DGRTHGRGBT|NTYHNGF R DF','file/gambar.jpg','2019-11-26 19:38:17');

/*Table structure for table `wgm_tipe_bencana` */

DROP TABLE IF EXISTS `wgm_tipe_bencana`;

CREATE TABLE `wgm_tipe_bencana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_tipe_bencana` */

insert  into `wgm_tipe_bencana`(`id`,`nama`) values (1,'GEMPA BUMI'),(2,'GUNUNG MELETUS'),(3,'TSUNAMI'),(4,'BANJIR');

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
