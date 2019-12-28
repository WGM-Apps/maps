/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.40-MariaDB : Database - db_gis
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `user` */

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `akses` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0=tidak ada akses, 1=akses respon, 2=semua akses',
  `flg_active` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y=aktif, N=tidak aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`user`,`password`,`nama`,`akses`,`flg_active`) values (1,'demo','81dc9bdb52d04dc20036dbd8313ed055','DEMO','2','Y');

/*Table structure for table `wgm_detail` */

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
  `sumber_daya` text,
  `pic` text NOT NULL,
  `posko` text NOT NULL,
  `anggaran` decimal(18,2) DEFAULT '0.00',
  `create_date` date NOT NULL,
  `flg_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bencana` (`bencana`),
  CONSTRAINT `wgm_detail_ibfk_1` FOREIGN KEY (`bencana`) REFERENCES `wgm_tipe_bencana` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_detail` */

/*Table structure for table `wgm_group_kegiatan` */

CREATE TABLE `wgm_group_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_group_kegiatan` */

insert  into `wgm_group_kegiatan`(`id`,`nama`) values (1,'DAPUR UMUM');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (2,'POS HANGAT');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (3,'KESEHATAN');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (4,'KEBERSIHAN');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (5,'LOGISTIC FOOD');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (6,'LOGISTIC NON FOOD');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (7,'DUKUNGAN PSIKOSOSIAL');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (8,'SANITASI');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (9,'AIR');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (10,'RECOVERY AWAL');
insert  into `wgm_group_kegiatan`(`id`,`nama`) values (11,'PEMULIHAN');

/*Table structure for table `wgm_group_kegiatan_detail` */

CREATE TABLE `wgm_group_kegiatan_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_wgm_group_kegiatan` int(11) DEFAULT NULL,
  `nama` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `wgm_group_kegiatan_detail` */

/*Table structure for table `wgm_last_update_timeline_kegiatan` */

CREATE TABLE `wgm_last_update_timeline_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timeline_kegiatan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timeline_kegiatan_deskripsi` text,
  `tgl_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `wgm_last_update_timeline_kegiatan_ibfk_1` (`timeline_kegiatan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_last_update_timeline_kegiatan` */

/*Table structure for table `wgm_request_support` */

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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_timeline_kegiatan` */

/*Table structure for table `wgm_tipe_bencana` */

CREATE TABLE `wgm_tipe_bencana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  `icon` varchar(100) NOT NULL DEFAULT 'lainnya.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `wgm_tipe_bencana` */

insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (1,'GEMPA BUMI','gempa.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (2,'GUNUNG MELETUS','erupsi.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (3,'TSUNAMI','tsunami.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (4,'BANJIR','banjir.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (5,'LONGSOR','longsor.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (6,'KEBAKARAN HUTAN','karhutla.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (7,'KEBAKARAN PEMUKIMAN','kebakaran.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (8,'KEKERINGAN','kekeringan.png');
insert  into `wgm_tipe_bencana`(`id`,`nama`,`icon`) values (9,'LAINNYA','lainnya.png');

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `yuyuy` */

DELIMITER $$

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `yuyuy` ON SCHEDULE EVERY 1 DAY STARTS '2019-11-26 21:01:25' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	    select md5(123);
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
