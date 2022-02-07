-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2022 at 05:36 AM
-- Server version: 10.6.5-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agendagub_20db21db`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_nama_opd`(`p_id_opd` INT) RETURNS varchar(255) CHARSET latin1
BEGIN
	DECLARE nama varchar(255);
	IF(p_id_opd != 0)THEN
        SELECT nm_opd INTO nama
        FROM ms_opd
        WHERE id_opd = p_id_opd;
	ELSE
		SET nama = 'LOKASI TIDAK DIKETAHUI';
	END IF;
    RETURN nama;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `data_agenda`
--

CREATE TABLE IF NOT EXISTS `data_agenda` (
  `id_agenda` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `nama_agenda` varchar(500) NOT NULL,
  `tanggal` date NOT NULL,
  `id_opd` int(11) NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `jenis_agenda` enum('P','S') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kegiatan` text NOT NULL,
  `lokasi_kegiatan` text NOT NULL,
  `penyelenggara` varchar(255) DEFAULT NULL,
  `cp` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `dokumen` text NOT NULL,
  `status_verifikasi` varchar(2) NOT NULL,
  `pesan_verifikasi` text NOT NULL,
  `status_disposisi` enum('SD','BD') NOT NULL COMMENT 'SD=Sudah Disposisi, BD=Belum Disposisi',
  `id_status` varchar(11) NOT NULL,
  `keterangan_hadir` text DEFAULT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_agenda`
--

INSERT INTO `data_agenda` (`id_agenda`, `token`, `nama_agenda`, `tanggal`, `id_opd`, `penerima`, `jenis_agenda`, `jam_mulai`, `jam_selesai`, `kegiatan`, `lokasi_kegiatan`, `penyelenggara`, `cp`, `keterangan`, `dokumen`, `status_verifikasi`, `pesan_verifikasi`, `status_disposisi`, `id_status`, `keterangan_hadir`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`) VALUES
(4, '63D4870143285B199064A8315BD2CF6B', 'kunjungan ke jateng', '2022-01-26', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '02:00:00', '04:00:00', 'mou dg gub jateng', 'kantor gub jateng', NULL, NULL, 'pastikan opd pendamping', 'agendagub_10-01-2022_10-53-19.pdf', 'CC', '', 'BD', 'SH', '', 'ajudan_gub', '2022-01-10 10:53:18', '182.1.9.96', 'ntahlah', '2022-01-10 10:54:32', '182.1.2.86'),
(45, '3D0709843FDEEDB42B379FDD81157EB9', 'TESTING 3 20 JANUARI 2022', '2022-01-27', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '17:00:00', '17:25:00', 'Kegiatan ketiga yang diinputkan oleh admin', 'Auditorium Gubernur', 'Wartawan Testing', '', 'dokumennya kosong', 'agendagub_20-01-2022_14-31-48.pdf', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-20 14:31:44', '103.160.118.2', 'ajudan_gub', '2022-01-20 15:33:26', '103.160.118.2'),
(44, '28047D5CB2E06243CE71863E1799C2F9', 'TESTING 2 20 JANUARI 2021', '2022-01-31', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '08:00:00', '09:30:00', 'Kegiatan ini merupakan testing kedua Kali diinputkan tanggal yang sama', 'Aula Kementrian PPA', 'Kementrian PPA', 'Nartoks - 0812927160901', 'menggunakan baju batik', 'agendagub_20-01-2022_13-53-52.pdf', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-20 13:53:48', '103.160.118.2', 'ajudan_gub', '2022-01-20 14:55:04', '103.160.118.2'),
(7, '6F14EEE674D51275C9A8EBB391BB548C', 'RAPAT FLY OVER', '2022-01-13', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '09:00:00', '12:00:00', 'RAPAT FLY OVER SITINJAU LAWIK', 'HOTEL BALAIRUNG JKT', NULL, NULL, 'BAPPEDA', 'agendagub_11-01-2022_09-11-07.pdf', 'CC', '', 'BD', 'SM', NULL, 'ajudan_gub', '2022-01-11 09:11:07', '114.122.68.10', '', '0000-00-00 00:00:00', ''),
(64, '0D2D81EFCE6C1392F1E8F6490477A817', 'oke1111', '2022-01-21', 14, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '17:00:00', '18:00:00', 'OPKEEE', ',MNKJK', 'OKE12323', 'Q1N1KJH2KH', 'BATIK', 'agendagub_20-01-2022_16-33-23.pdf', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-21 09:14:46', '103.160.118.2', 'ajudan_gub', '2022-01-21 09:15:01', '103.160.118.2'),
(65, '698EF2D8D572E6C17A0BE0D41721AE48', 'JHJHKH', '2022-01-22', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '05:00:00', '05:30:00', 'JKHHJHKJ', '4545', '455', '54545', '', 'agendagub_20-01-2022_16-34-25.pdf', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-20 16:34:11', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-21 09:08:08', '103.160.118.2'),
(42, 'C37F084BAD09C4C9B15BC60E3073BDFB', 'testing 1', '2022-01-01', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '13:00:00', '15:00:00', 'testing 1', 'bbbb', 'aaa', '', '', 'agendagub_20-01-2022_10-46-02.pdf', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-20 10:46:01', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:46:15', '103.160.118.2'),
(40, '017EBC77ECE261863B3BD17802A52200', 'testing 3', '2022-01-20', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '09:30:00', '09:45:00', 'testing 3', 'khatib sulaiman', 'dispora', '', '', 'agendagub_20-01-2022_10-38-01.pdf', 'CC', '', 'BD', 'SH', 'siap', 'ajudan_gub', '2022-01-20 10:38:00', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:38:15', '103.160.118.2'),
(41, '0E4BC5DED81B98BB68E0A16C6ADF5308', 'testing 1', '2022-01-21', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '13:00:00', '15:00:00', 'testing 1', 'bbbb', 'aaa', '', '', 'agendagub_20-01-2022_10-45-01.pdf', 'CC', '', 'BD', 'SH', 'okeee', 'ajudan_gub', '2022-01-20 10:45:00', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:45:15', '103.160.118.2'),
(39, 'C9A385ED64899D79F939A43590007FEE', 'testing 2', '2022-02-03', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '02:10:00', '03:30:00', 'testing 2', 'bukittingi', 'disdik', '', '', '', 'CC', '', 'BD', 'SH', 'oke ', 'ajudan_gub', '2022-01-20 10:31:55', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:32:26', '103.160.118.2'),
(38, 'CBC0BAC5C08BC4A5AEC3C9C185C4700F', 'agenda pelatihan', '2022-01-31', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '09:00:00', '16:00:00', 'pelatihan bimtek', 'padang', 'disbud', '', '', 'agendagub_20-01-2022_10-18-24.pdf', 'CC', '', 'BD', 'SW', 'mohon hadiri bapak', 'ajudan_gub', '2022-01-20 10:18:23', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:23:43', '103.160.118.2'),
(36, '4AD67DFB121C0D4540EED4C02D72ECCB', 'TESTING 2 19 JANUARI - Agenda ujicoba aplikasi', '2022-01-20', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '10:00:00', '11:30:00', 'Leviathan ujicoba aplikasi dengan mengupload documents Surat undangan Agenda pimpinan', 'Kantor Kenangagagagaga', 'Dinas OPD terkait', '', '', 'agendagub_19-01-2022_15-23-05.pdf', 'CC', '', 'BD', 'SW', 'wakilkan Leviathan ujicoba ini', 'ajudan_gub', '2022-01-19 15:23:02', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-19 15:23:59', '103.160.118.2'),
(37, 'F1B7D72921120917D5AC0A73229C0451', 'contoh', '2022-01-20', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '06:00:00', '09:00:00', 'contoh kegiatan', 'Padang', 'diskominfo', '08125689789654', '', '', 'CC', '', 'BD', 'SH', 'hadiri oleh bapak', 'ajudan_gub', '2022-01-20 10:06:29', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:06:53', '103.160.118.2'),
(35, 'B04C54184906C6D52453C5C2A1D0680B', 'TESTING 19 JANUARI - Kegiatan uji coba aplikasi', '2022-01-20', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '09:30:00', '09:55:00', 'Aplikasi EAgenda Gubernur sedang diuji coba testing aplikasi', 'Kantor Kenanga', 'Dinas OPD terkait yang membuat aplikasi ini DISKOMINFOTIK', 'TUTUTUT - 082930192001', '', '', 'CC', '', 'BD', 'SH', 'uji coba hadiri', 'ajudan_gub', '2022-01-19 15:20:19', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-19 15:20:45', '103.160.118.2'),
(50, 'FB597EC67C9B61C7B1CFFBE7161BC427', 'dddddddd', '2022-01-06', 14, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '14:35:00', '15:35:00', 'dddddd', 'dddd', 'dddd', 'dddddd', '', '', 'SM', '', 'BD', 'SW', 'okeeeee', 'ajudan_gub', '2022-01-20 15:06:48', '103.160.118.2', 'ajudan_gub', '2022-01-20 15:35:11', '103.160.118.2'),
(69, 'D619FD83625C2B4DBC31C1D36F7DA7D9', 'testing agenda', '2022-01-25', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '12:00:00', '18:00:00', 'testing agenda', 'solok', 'dinas', '', '', '', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-24 12:02:24', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-24 12:02:45', '103.160.118.2'),
(68, '44E89A6303481B18C9F4A32D2F69A5AE', 'agenda contoh lagi 1', '2022-01-31', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '13:00:00', '16:00:00', 'agenda lagi1', 'd bukik 1', 'dinassssss 1', '081256895', '', '', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-21 08:41:03', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-21 09:03:38', '103.160.118.2'),
(70, '7B55C301C1708FEB6F646824F9E911FD', 'erid', '2022-01-22', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '14:00:00', '18:00:00', 'erid lagi', 'solsel', 'erid', 'erid', '', '', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-24 12:25:39', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-24 12:26:00', '103.160.118.2'),
(71, '4901475545FCF91F9A925A211752DA1D', 'contoh 1', '2022-01-25', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '13:00:00', '17:00:00', 'contoh agenda', 'padang', 'tes', 'tes', 'oke', '', 'CC', '', 'BD', 'SH', 'oke', 'ajudan_gub', '2022-01-24 12:30:00', '103.160.118.2', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-24 12:30:30', '103.160.118.2'),
(72, 'E07E34EE6C42FC4FCC9CBE9EF189986F', 'testing 24 januari', '2022-01-25', 1, 'B6A6F83CC282E4FD98345162757D9CE3', 'P', '21:00:00', '21:29:00', 'kegiatannya testinghari senin', 'Lapangan Imam Bonjol', 'Dinas terkait testing', '', 'menggunakan pakaian santai', 'agendagub_24-01-2022_12-35-56.pdf', 'CC', '', 'BD', 'SM', NULL, 'ajudan_gub', '2022-01-24 12:34:15', '36.69.8.120', 'ajudan_gub', '2022-01-24 12:35:55', '36.69.8.120');

-- --------------------------------------------------------

--
-- Table structure for table `data_disposisi`
--

CREATE TABLE IF NOT EXISTS `data_disposisi` (
  `id_disposisi` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `id_agenda` int(11) NOT NULL,
  `tgl_disposisi` datetime NOT NULL,
  `isi_disposisi` text NOT NULL,
  `id_pengirim` varchar(50) NOT NULL,
  `id_opd` int(11) NOT NULL,
  `jenis_disposisi` enum('D','P') NOT NULL COMMENT 'D=Disposisi Dari Ketua DPRD utk Anggota DPRD, P=Disposisi Sekretaris/Pejabat ke Bawahan',
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_disposisi`
--

INSERT INTO `data_disposisi` (`id_disposisi`, `token`, `id_agenda`, `tgl_disposisi`, `isi_disposisi`, `id_pengirim`, `id_opd`, `jenis_disposisi`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`) VALUES
(1, '7DA7C71C4237B89B4BAAE5E8394EFD1F', 36, '2022-01-19 15:23:59', 'wakilkan Leviathan ujicoba ini', '6E68174FDB2AA961DA7FC2664F7EA6D5', 1, 'D', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-19 15:23:59', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(2, '8045AA538438C5D8F7CCFFC77A044796', 38, '2022-01-20 10:23:43', 'mohon hadiri bapak', '6E68174FDB2AA961DA7FC2664F7EA6D5', 1, 'D', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:23:43', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(3, '02F64A71537909B8149CE12097598EBA', 50, '2022-01-20 15:35:11', 'okeeeee', '6E68174FDB2AA961DA7FC2664F7EA6D5', 1, 'D', 'ajudan_gub', '2022-01-20 15:35:11', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(4, '027189CB338D5C6F035FE2D4C9530DC9', 66, '2022-01-21 09:07:05', 'siip', '6E68174FDB2AA961DA7FC2664F7EA6D5', 1, 'D', '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-21 09:07:05', '103.160.118.2', '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_disposisi_masuk`
--

CREATE TABLE IF NOT EXISTS `data_disposisi_masuk` (
  `id_disposisi_masuk` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `id_disposisi` int(11) NOT NULL,
  `id_penerima` varchar(255) NOT NULL,
  `id_opd` int(11) NOT NULL,
  `tgl_terima` datetime NOT NULL,
  `status_penerima` enum('SD','BD') NOT NULL,
  `pesan_penerima` text NOT NULL,
  `status_disposisi` varchar(2) DEFAULT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_disposisi_masuk`
--

INSERT INTO `data_disposisi_masuk` (`id_disposisi_masuk`, `token`, `id_disposisi`, `id_penerima`, `id_opd`, `tgl_terima`, `status_penerima`, `pesan_penerima`, `status_disposisi`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`) VALUES
(1, '7DA7C71C4237B89B4BAAE5E8394EFD1F', 1, 'CBBB594293314410F1FCCF763DB21B0D', 0, '0000-00-00 00:00:00', 'BD', '', NULL, '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-19 15:23:59', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(2, '8045AA538438C5D8F7CCFFC77A044796', 2, 'CBBB594293314410F1FCCF763DB21B0D', 0, '0000-00-00 00:00:00', 'BD', '', NULL, '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-20 10:23:43', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(3, '02F64A71537909B8149CE12097598EBA', 3, 'CBBB594293314410F1FCCF763DB21B0D', 2, '0000-00-00 00:00:00', 'BD', '', 'SH', 'ajudan_gub', '2022-01-20 15:35:11', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(4, '027189CB338D5C6F035FE2D4C9530DC9', 4, 'CBBB594293314410F1FCCF763DB21B0D', 0, '0000-00-00 00:00:00', 'BD', '', NULL, '6E68174FDB2AA961DA7FC2664F7EA6D5', '2022-01-21 09:07:05', '103.160.118.2', '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_notifikasi`
--

CREATE TABLE IF NOT EXISTS `data_notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `token_notifikasi` varchar(50) NOT NULL,
  `token_agenda` varchar(50) DEFAULT NULL,
  `token_disposisi` varchar(50) DEFAULT NULL,
  `id_pengirim` varchar(255) NOT NULL,
  `id_penerima` varchar(255) NOT NULL,
  `tipe_notifikasi` enum('SM','SR','SV','DM') NOT NULL COMMENT 'SM = Draft Masuk, SR =Draft yang direview oleh sekretaris, SV=Surat yang akan diahdiri atau diwakilkan, dm=disposisi masuk',
  `pesan_notifikasi` text NOT NULL,
  `id_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=Belum Baca, 1=Sudah Baca',
  `create_by` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_notifikasi`
--

INSERT INTO `data_notifikasi` (`id_notifikasi`, `token_notifikasi`, `token_agenda`, `token_disposisi`, `id_pengirim`, `id_penerima`, `tipe_notifikasi`, `pesan_notifikasi`, `id_status`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`) VALUES
(1, '68903EA26BFD819B87C72C417071A394', 'FA471492BA3F5D1D9D7F67BD7E53A82F', '', '231E696E9C21810535E08FFFE70F0868', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ntahlah', '2022-01-19 13:40:57', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(2, 'ED5C6C8CEF1793FB9321685F4721B562', 'B2A1C645C8E9AD7C7ED6660F129A8B12', '', '231E696E9C21810535E08FFFE70F0868', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ntahlah', '2022-01-19 13:42:11', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(3, '97A362CAD408861EF9AD12E83A3530FB', '57987FA2356FA930BA7D05EF9978F5CE', '', '231E696E9C21810535E08FFFE70F0868', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ntahlah', '2022-01-19 13:45:20', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(4, 'BC4C05E75100DD5B1E2C22683A099037', '27AF217079A05035E7081CE4B112039E', '', '231E696E9C21810535E08FFFE70F0868', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ntahlah', '2022-01-19 13:48:32', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(5, 'FD3DE3B346986452315500EB622DE8E9', '02B420A22740B003FC42A459C239A7BA', '', '231E696E9C21810535E08FFFE70F0868', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ntahlah', '2022-01-19 14:20:18', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(6, '79CCB74BE0AA3E7DE2A8DC017043F07A', 'B04C54184906C6D52453C5C2A1D0680B', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '1', '', '2022-01-19 15:20:19', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(7, 'AE2F7B18189961E0BB7601DECE861276', '4AD67DFB121C0D4540EED4C02D72ECCB', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '1', '', '2022-01-19 15:23:06', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(8, 'C822B2AE73AD7234D8531E574A712A58', '4AD67DFB121C0D4540EED4C02D72ECCB', '7DA7C71C4237B89B4BAAE5E8394EFD1F', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'CBBB594293314410F1FCCF763DB21B0D', 'DM', 'Ada disposisi masuk', '0', 'ajudan_gub', '2022-01-19 15:23:59', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(9, 'CD51FB3FE2AAEC9007A36E35295BC049', 'F1B7D72921120917D5AC0A73229C0451', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 10:06:29', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(10, '4014BF5255709960EF48D4AC6CF9EFE3', 'CBC0BAC5C08BC4A5AEC3C9C185C4700F', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 10:18:24', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(11, '5A7A25E011CDE552B5FBDDB4B36C3251', 'CBC0BAC5C08BC4A5AEC3C9C185C4700F', '8045AA538438C5D8F7CCFFC77A044796', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'CBBB594293314410F1FCCF763DB21B0D', 'DM', 'Ada disposisi masuk', '0', 'ajudan_gub', '2022-01-20 10:23:43', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(12, '631F5E2139AB60E162E121CA39E3BB2C', 'C9A385ED64899D79F939A43590007FEE', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 10:31:55', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(13, 'F6DCCC93750F04642A6139ABF22714E0', '017EBC77ECE261863B3BD17802A52200', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 10:38:01', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(14, '35F4B7F6EC00ADC15DE3EDD0E92486ED', '0E4BC5DED81B98BB68E0A16C6ADF5308', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 10:45:01', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(15, 'F4DE5EE2C25BA3D94BA6949E73332E8A', 'C37F084BAD09C4C9B15BC60E3073BDFB', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 10:46:02', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(16, 'B1ABFA30B1A40B46346E6EAB190A499B', '1F54C974F92B64931A7E2653F6A7A813', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 13:42:45', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(17, '9C1C73C95525EAA3DA097EB49F9C2109', '28047D5CB2E06243CE71863E1799C2F9', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 13:53:52', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(18, 'C2233EE2BDFF6D8205E7336829C1D8B7', '3D0709843FDEEDB42B379FDD81157EB9', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 14:31:48', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(19, '6BE3E5DC972D999145A724F54B2DE277', 'A377CE68BD4CD9CBF6B5FC223463BE55', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ajudan_gub', '2022-01-20 14:32:00', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(20, '7527A90AD00608FC5EC5038EB6104144', '43A5D1FCD79C14A0273BBBDC96E9C1D0', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ajudan_gub', '2022-01-20 14:37:36', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(21, '7DA4F3AA46C9D43969460939547E40A8', 'E19888B92E634BD344AFE045E8C83889', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ajudan_gub', '2022-01-20 14:58:52', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(22, '2B450A96108167F4B693A39F5791504E', '5F3D03F1C503A1AD19193ED247DB4804', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ajudan_gub', '2022-01-20 15:02:22', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(23, 'C0C654631A86E584F1E1DCA00512954F', 'FB597EC67C9B61C7B1CFFBE7161BC427', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', '231E696E9C21810535E08FFFE70F0868', 'SM', 'Ada draft baru', '0', 'ajudan_gub', '2022-01-20 15:03:07', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(24, 'D49E04D8C5BD2CCC16A0E3B17E885B43', 'FB597EC67C9B61C7B1CFFBE7161BC427', '02F64A71537909B8149CE12097598EBA', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'CBBB594293314410F1FCCF763DB21B0D', 'DM', 'Ada disposisi masuk', '0', 'ajudan_gub', '2022-01-20 15:35:11', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(25, '29E83A806DB0CECD9ED6E8B7D648B9B5', '9EFEDC6E3FB25259008BD97C3CC21F34', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 15:44:00', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(26, '6F12854D00923A6595597E8A495FE8D8', '8A900A74E6BA73A96759FC5D94A34729', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 15:46:57', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(27, '286373FE084B849D9FD23691C60EB5C2', 'B67ED0ED6598F771726BC77D6409AA8C', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 15:50:24', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(28, '3701F3A939ACE1A2C4ED51004F709D4F', '3E42579D485D1491F13700AF2BBB7065', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 15:51:41', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(29, '2FD792DCA507BA48D45B2AAEEFD0B3DA', 'AE758BDFB832529310192542A54DB2FD', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 15:54:26', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(30, '22FD28C39C0F14444C5AF313A186C4AA', 'A208AF1C06C2017269DCACF02F55C3B7', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 15:58:11', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(31, '64F98D64ABFD025642B0C39516C92535', 'FFCE98542D48E22351D4F64FB6D91B67', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 15:59:50', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(32, 'B350AFD3B2CB3B5BDE6391229B960DBD', '099D2D6ED111EF6412509C33682DA716', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:00:11', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(33, '3910D0ADF9960AC8D1CBF2DB9A293C4E', '4B09656EA0A40CEA0BBBC9A92F8BAD47', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:01:22', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(34, '3B87B57C0CEE66B62D12909FFB6B7CE9', 'A9C3C169A882E253DADE4F47B83BB0C2', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:02:51', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(35, '8C31189B2CFC253755995C110EB6D0A1', 'A3D02BF15D9BB242A83E7485E53C64CC', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:03:55', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(36, '7542A0835D6BAEEC41B7F324F8F523BB', 'E889E978979B667E3B5A03E5DDF1653C', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:04:27', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(37, 'D591FF16757645AFD9583B8FD138A96D', '61E6A6D85463EAA06D996C89CF628B72', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:17:31', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(38, 'A01D0783854021D07794C16CDCE347CA', '0D2D81EFCE6C1392F1E8F6490477A817', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:33:05', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(39, 'EF00FE32235DDC87CC0BBD9509F07470', '698EF2D8D572E6C17A0BE0D41721AE48', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:34:12', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(40, 'C37A02DDB12E2C616348DBA3C353B3DA', '40A94A8D370ECBC6629F2825624D632A', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:35:21', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(41, '9915144B91AFDB92A638FA15E2EDA8F3', 'DA3CFED73480795D0791CBC4D2A88B61', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-20 16:37:02', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(42, '346574DC4DD24DB9EF4FA7FAE08915AA', '44E89A6303481B18C9F4A32D2F69A5AE', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-21 08:41:04', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(43, '8A1CB422F1AC1FB854770A8A01FEC8E8', '40A94A8D370ECBC6629F2825624D632A', '027189CB338D5C6F035FE2D4C9530DC9', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'CBBB594293314410F1FCCF763DB21B0D', 'DM', 'Ada disposisi masuk', '0', 'ajudan_gub', '2022-01-21 09:07:05', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(44, 'CC1891C9B1FC2F737235E4C02C932958', 'D619FD83625C2B4DBC31C1D36F7DA7D9', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-24 12:02:24', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(45, '56A9DC740891AAF285785AA084195C90', '7B55C301C1708FEB6F646824F9E911FD', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-24 12:25:39', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(46, 'F97BF9F921894CD8DA366FAFF6CA2EC6', '4901475545FCF91F9A925A211752DA1D', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-24 12:30:01', '103.160.118.2', '', '0000-00-00 00:00:00', ''),
(47, '917C04AF16B58DEF88B838A00204711D', 'E07E34EE6C42FC4FCC9CBE9EF189986F', '', '6E68174FDB2AA961DA7FC2664F7EA6D5', 'B6A6F83CC282E4FD98345162757D9CE3', 'SM', 'Ada draft agenda baru', '0', '', '2022-01-24 12:34:16', '36.69.8.120', '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_penerima`
--

CREATE TABLE IF NOT EXISTS `data_penerima` (
  `id_penerima` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `nama_penerima` varchar(500) NOT NULL,
  `id_status` enum('0','1') NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_penerima`
--

INSERT INTO `data_penerima` (`id_penerima`, `token`, `nama_penerima`, `id_status`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`) VALUES
(1, 'F6008B37FCAC399A1C7A11530B04C7B0', 'Wakil Gubernur', '', 'ntahlah', '2022-01-12 10:54:33', '::1', 'ntahlah', '2022-01-12 14:09:35', '::1'),
(2, '9E4079DAAB5DFCAFB33E60A3FF58E45D', 'Sekretaris Daerah', '', 'ntahlah', '2022-01-12 10:59:22', '::1', 'ntahlah', '2022-01-12 14:09:40', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 1, '6595E94DFE54F61849C5CA2983A77AC4P6HAGDK', 1, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text DEFAULT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT 0
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(1, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953625, 0.0136569, '1', 200),
(2, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953625, 0.010268, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(3, 'draft/insert_draft', 'post', 'a:21:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:6:"181152";s:9:"jam_mulai";s:3:"9:0";s:10:"keterangan";s:7:"TESTING";s:6:"id_opd";s:1:"1";s:8:"penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:11:"jam_selesai";s:4:"9:30";s:12:"jenis_agenda";s:1:"P";s:9:"create_by";s:10:"ajudan_gub";s:7:"dokumen";s:170564:"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\nEyPw5tl3Uoj/d3dHEGPK3RFKV4lDA26WeOsp+kV7cL1IxgtHCyEzIXXBoV4h36kYOUXn4BJEpgsY\ntV324v4rWVIi4GE3v094F6zX9xwq1xxr0/hI7K4lo1zAgtKCl+X5qt9BdaLn0ZGZEAAK7hWfOxED\ni6hBltPDb/4E/8sPf/rNH7A4+zLFgs/Bq/JDwpRkxIurXF1F+ea3L3/Xe/yhFG/w8ym03/Py22ez\n9G77tfpUMfVTNtabqMxDjgbpYXQY1z/wi5f/C/SvSQNlbmRzdHJlYW0KZW5kb2JqCjc2IDAgb2Jq\nCjg3ODAKZW5kb2JqCjUgMCBvYmoKPDwvVHlwZS9QYWdlL01lZGlhQm94IFswIDAgNzc4IDEwMDdd\nCi9Sb3RhdGUgMC9QYXJlbnQgMyAwIFIKL0dyb3VwIDQgMCBSCi9SZXNvdXJjZXM8PC9Qcm9jU2V0\nWy9QREYgL1RleHRdCi9Db2xvclNwYWNlIDQwIDAgUgovRXh0R1N0YXRlIDQxIDAgUgovUGF0dGVy\nbiA0MiAwIFIKL1hPYmplY3QgNDMgMCBSCi9Gb250IDQ0IDAgUgo+PgovQ29udGVudHMgNiAwIFIK\nPj4KZW5kb2JqCjQ1IDAgb2JqCjw8L1R5cGUvUGFnZS9NZWRpYUJveCBbMCAwIDc3OCAxMDA3XQov\nUm90YXRlIDAvUGFyZW50IDMgMCBSCi9Hcm91cCA0IDAgUgovUmVzb3VyY2VzPDwvUHJvY1NldFsv\nUERGIC9UZXh0XQovQ29sb3JTcGFjZSA2OSAwIFIKL0V4dEdTdGF0ZSA3MCAwIFIKL1BhdHRlcm4g\nNzEgMCBSCi9YT2JqZWN0IDcyIDAgUgovRm9udCA3MyAwIFIKPj4KL0NvbnRlbnRzIDQ2IDAgUgo+\nPgplbmRvYmoKNzQgMCBvYmoKPDwvVHlwZS9QYWdlL01lZGlhQm94IFswIDAgNzc4IDEwMDddCi9S\nb3RhdGUgMC9QYXJlbnQgMyAwIFIKL0dyb3VwIDQgMCBSCi9SZXNvdXJjZXM8PC9Qcm9jU2V0Wy9Q\nREYgL1RleHRdCi9Db2xvclNwYWNlIDkxIDAgUgovRXh0R1N0YXRlIDkyIDAgUgovUGF0dGVybiA5\nMyAwIFIKL1hPYmplY3QgOTQgMCBSCi9Gb250IDk1IDAgUgo+PgovQ29udGVudHMgNzUgMCBSCj4+\nCmVuZG9iagozIDAgb2JqCjw8IC9UeXBlIC9QYWdlcyAvS2lkcyBbCjUgMCBSCjQ1IDAgUgo3NCAw\nIFIKXSAvQ291bnQgMwo+PgplbmRvYmoKMSAwIG9iago8PC9UeXBlIC9DYXRhbG9nIC9QYWdlcyAz\nIDAgUgovTWV0YWRhdGEgMTIzIDAgUgo+PgplbmRvYmoKOCAwIG9iago8PC9UeXBlL0V4dEdTdGF0\nZQovQk0vTm9ybWFsCi9PUE0gMQovVEsgdHJ1ZT4+ZW5kb2JqCjkgMCBvYmoKPDwKL1JlZ2lzdHJ5\nKEFkb2JlKQovT3JkZXJpbmcoSWRlbnRpdHkpCi9TdXBwbGVtZW50IDAKPj4KZW5kb2JqCjEzIDAg\nb2JqCjw8Ci9SZWdpc3RyeShBZG9iZSkKL09yZGVyaW5nKElkZW50aXR5KQovU3VwcGxlbWVudCAw\nCj4+CmVuZG9iagoxNyAwIG9iago8PAovUmVnaXN0cnkoQWRvYmUpCi9PcmRlcmluZyhJZGVudGl0\neSkKL1N1cHBsZW1lbnQgMAo+PgplbmRvYmoKMjEgMCBvYmoKPDwKL1JlZ2lzdHJ5KEFkb2JlKQov\nT3JkZXJpbmcoSWRlbnRpdHkpCi9TdXBwbGVtZW50IDAKPj4KZW5kb2JqCjI2IDAgb2JqCjw8L1R5\ncGUvRXh0R1N0YXRlCi9CTS9Ob3JtYWw+PmVuZG9iagozMCAwIG9iagpbL1BhdHRlcm5dCmVuZG9i\nago0MCAwIG9iago8PC9SMzAKMzAgMCBSPj4KZW5kb2JqCjQxIDAgb2JqCjw8L1IyNgoyNiAwIFIv\nUjgKOCAwIFI+PgplbmRvYmoKNDIgMCBvYmoKPDwvUjM5CjM5IDAgUi9SMjkKMjkgMCBSL1IzMwoz\nMyAwIFIvUjM2CjM2IDAgUj4+CmVuZG9iagozOSAwIG9iago8PC9GaWx0ZXIvRmxhdGVEZWNvZGUK\nL1R5cGUvUGF0dGVybgovUGF0dGVyblR5cGUgMQovUGFpbnRUeXBlIDEKL1RpbGluZ1R5cGUgMQov\nQkJveFswCjAKMTAwMAoxMjc2XQovTWF0cml4WzAuNzUKMAowCjAuNzUKMTQuNwozNi40XQovWFN0\nZXAgNDY1NgovWVN0ZXAgNDY1NgovUmVzb3VyY2VzPDwvRXh0R1N0YXRlPDwvUjI2IDI2IDAgUgo+\nPgovWE9iamVjdDw8L1IzNyAzNyAwIFIKCi9SMzggMzggMCBSCj4+Ci9Qcm9jU2V0IFsvUERGL0lt\nYWdlQ10+Pi9MZW5ndGggNTg+PnN0cmVhbQp4nDPQM1QwAEEonZzLpR9kZKaQXsxVqGBoAARgYUMj\nczOIMqCIsYGZgYEpRKmxhYJLPlcgFwAAtw5SCmVuZHN0cmVhbQplbmRvYmoKMjkgMCBvYmoKPDwv\nRmlsdGVyL0ZsYXRlRGVjb2RlCi9UeXBlL1BhdHRlcm4KL1BhdHRlcm5UeXBlIDEKL1BhaW50VHlw\nZSAxCi9UaWxpbmdUeXBlIDEKL0JCb3hbMAowCjgxNgoyNTJdCi9NYXRyaXhbMC44MzE0ODYKMAow\nCjAuODMxNDg2CjUxLjYKNjgxLjJdCi9YU3RlcCAzMjE1Ci9ZU3RlcCAzMjE1Ci9SZXNvdXJjZXM8\nPC9FeHRHU3RhdGU8PC9SMjYgMjYgMCBSCj4+Ci9YT2JqZWN0PDwvUjI3IDI3IDAgUgoKL1IyOCAy\nOCAwIFIKPj4KL1Byb2NTZXQgWy9QREYvSW1hZ2VDXT4+L0xlbmd0aCA5Nz4+c3RyZWFtCnicM9Az\nVDAAQSidnMtVyAViWBiaGSgYmRoZKBSlKoQr5HEFcukHGZkppBdDFeRyQeVzuBBqoWwQI4MLpKtQ\nASoAVWCgoGugZ2BgYGhiamoIsg1oqIWCSz7Q+EAuAMa5HCsKZW5kc3RyZWFtCmVuZG9iagozMyAw\nIG9iago8PC9GaWx0ZXIvRmxhdGVEZWNvZGUKL1R5cGUvUGF0dGVybgovUGF0dGVyblR5cGUgMQov\nUGFpbnRUeXBlIDEKL1RpbGluZ1R5cGUgMQovQkJveFswCjAKODE2CjI1Ml0KL01hdHJpeFswLjgz\nMTQ4NgowCjAKMC44MzE0ODYKNTEuNgo0MzcuNl0KL1hTdGVwIDMyMTUKL1lTdGVwIDMyMTUKL1Jl\nc291cmNlczw8L0V4dEdTdGF0ZTw8L1IyNiAyNiAwIFIKPj4KL1hPYmplY3Q8PC9SMzEgMzEgMCBS\nCgovUjMyIDMyIDAgUgo+PgovUHJvY1NldCBbL1BERi9JbWFnZUNdPj4vTGVuZ3RoIDk4Pj5zdHJl\nYW0KeJwz0DNUMABBKJ2cy1XIBWJYGJoZKBiZGhkoFKUqhCvkcQVy6QcZmSmkF0MV5HJB5XO4EGqh\nbBAjgwukq1ABKgBVYKCga6BnYGBgaGJqagiyTT/I2EjBJR9ofCAXAMaNHCYKZW5kc3RyZWFtCmVu\nZG9iagozNiAwIG9iago8PC9GaWx0ZXIvRmxhdGVEZWNvZGUKL1R5cGUvUGF0dGVybgovUGF0dGVy\nblR5cGUgMQovUGFpbnRUeXBlIDEKL1RpbGluZ1R5cGUgMQovQkJveFswCjAKODE2CjQ0Ml0KL01h\ndHJpeFswLjgzMTQ4NgowCjAKMC44MzE0ODYKNTEuNgozNi44XQovWFN0ZXAgMzQwNQovWVN0ZXAg\nMzQwNQovUmVzb3VyY2VzPDwvRXh0R1N0YXRlPDwvUjI2IDI2IDAgUgo+PgovWE9iamVjdDw8L1Iz\nNCAzNCAwIFIKCi9SMzUgMzUgMCBSCj4+Ci9Qcm9jU2V0IFsvUERGL0ltYWdlQ10+Pi9MZW5ndGgg\nOTk+PnN0cmVhbQp4nDPQM1QwAEEonZzLVcgFYlgYmhkomJgYGSgUpSqEK+RxBXLpBxmZKaQXQxXk\nckHlc7gQaqFsECODC6SrUAEqAFVgoKBroGdgYGBoaWhiaAqyTj/I2FTBJR9ofiAXAOQRHGIKZW5k\nc3RyZWFtCmVuZG9iago0MyAwIG9iago8PC9SMzgKMzggMCBSL1IzNwozNyAwIFIvUjM1CjM1IDAg\nUi9SMzQKMzQgMCBSL1IzMgozMiAwIFIvUjMxCjMxIDAgUi9SMjgKMjggMCBSL1IyNwoyNyAwIFI+\nPgplbmRvYmoKMzggMCBvYmoKPDwvU3VidHlwZS9JbWFnZQovQ29sb3JTcGFjZS9EZXZpY2VSR0IK\nL1dpZHRoIDEwMDAKL0hlaWdodCAxMjc2Ci9CaXRzUGVyQ29tcG9uZW50IDgKL0ludGVycG9sYXRl\nIHRydWUKL0ZpbHRlci9GbGF0ZURlY29kZQovRGVjb2RlUGFybXM8PC9QcmVkaWN0b3IgMTUKL0Nv\nbHVtbnMgMTAwMAovQ29sb3JzIDM+PgovU01hc2sgMzcgMCBSL0xlbmd0aCA2NTY4Pj5zdHJlYW0K\neJzt1jENADAMwLCVP+lB6LlFshHkzBwAAOB78zoAAADYGXcAAAgw7gAAEGDcAQAgwLgDAECAcQcA\ngADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAA\nBBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAg\nwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAAB\nxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw\n7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBx\nBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7\nAAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwB\nACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4A\nAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAA\nCDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBA\ngHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAAC\njDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg\n3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADj\nDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3\nAAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgD\nAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0A\nAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAA\nEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCA\nAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAE\nGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDA\nuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHG\nHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDu\nAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEH\nAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsA\nAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEA\nIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAA\nAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAI\nMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECA\ncQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKM\nOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDc\nAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMO\nAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcA\nAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMA\nQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAA\nAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQ\nYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA\n4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQY\ndwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4\nAwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYd\nAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4A\nABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcA\ngADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAA\nBBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAg\nwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAAB\nxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw\n7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBx\nBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7\nAAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwB\nACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4A\nAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAA\nCDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBA\ngHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAAC\njDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg\n3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADj\nDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3\nAAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgD\nAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0A\nAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAA\nEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCA\nAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAE\nGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDA\nuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHG\nHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDu\nAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEH\nAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsA\nAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEA\nIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAA\nAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAI\nMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECA\ncQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKM\nOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDc\nAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMO\nAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcA\nAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMA\nQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAA\nAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQ\nYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA\n4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQY\ndwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4\nAwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYd\nAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4A\nABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcA\ngADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAA\nBBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAg\nwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAAB\nxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw\n7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBx\nBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7\nAAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwB\nACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4A\nAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAA\nCDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBA\ngHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAAC\njDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg\n3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADj\nDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3\nAAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgD\nAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0A\nAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAA\nEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCA\nAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAE\nGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDA\nuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHG\nHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDu\nAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEH\nAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsA\nAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEA\nIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAA\nAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAI\nMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECA\ncQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKM\nOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDc\nAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMO\nAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcA\nAAgw7gAAEHABnNQE/QplbmRzdHJlYW0KZW5kb2JqCjM3IDAgb2JqCjw8L1N1YnR5cGUvSW1hZ2UK\nL0NvbG9yU3BhY2UvRGV2aWNlR3JheQovV2lkdGggMTAwMAovSGVpZ2h0IDEyNzYKL0JpdHNQZXJD\nb21wb25lbnQgOAovRmlsdGVyL0ZsYXRlRGVjb2RlCi9EZWNvZGVQYXJtczw8L1ByZWRpY3RvciAx\nNQovQ29sdW1ucyAxMDAwPj4vTGVuZ3RoIDM2OTc+PnN0cmVhbQp4nO3TQQ0AIAzAQObfNCoWEnqn\noJ/OAb43rwOAfUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFG\nhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBg\ndAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4B\nRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQ\nYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowO\nAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDo\nEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKM\nDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA\n6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0C\njA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEh\nwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgd\nAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DR\nIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQY\nHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA\n0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoE\nGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKND\ngNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6\nBBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCj\nQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgw\nOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocA\no0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQI\nMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaH\nAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0\nCDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFG\nhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBg\ndAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4B\nRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQ\nYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowO\nAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDo\nEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKM\nDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA\n6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0C\njA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEh\nwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgd\nAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DR\nIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQY\nHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA\n0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoE\nGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKND\ngNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6\nBBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCj\nQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgw\nOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocA\no0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQI\nMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaH\nAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0\nCDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFG\nhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBg\ndAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4B\nRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQ\nYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowO\nAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDo\nEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKM\nDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA\n6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0C\njA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEh\nwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgd\nAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DR\nIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQY\nHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA\n0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoE\nGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKND\ngNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6\nBBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCj\nQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDwAWBwAT9CmVuZHN0cmVhbQplbmRvYmoKMzUgMCBvYmoK\nPDwvU3VidHlwZS9JbWFnZQovQ29sb3JTcGFjZS9EZXZpY2VSR0IKL1dpZHRoIDgxNgovSGVpZ2h0\nIDQ0MgovQml0c1BlckNvbXBvbmVudCA4Ci9JbnRlcnBvbGF0ZSB0cnVlCi9GaWx0ZXIvRmxhdGVE\nZWNvZGUKL0RlY29kZVBhcm1zPDwvUHJlZGljdG9yIDE1Ci9Db2x1bW5zIDgxNgovQ29sb3JzIDM+\nPgovU01hc2sgMzQgMCBSL0xlbmd0aCAyMDE0Pj5zdHJlYW0KeJzt1jEBAAAIgDDtX9oYHG4JONkB\nACC1dQAAwHeGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGIH344Buwpl\nbmRzdHJlYW0KZW5kb2JqCjM0IDAgb2JqCjw8L1N1YnR5cGUvSW1hZ2UKL0NvbG9yU3BhY2UvRGV2\naWNlR3JheQovV2lkdGggODE2Ci9IZWlnaHQgNDQyCi9CaXRzUGVyQ29tcG9uZW50IDgKL0ZpbHRl\nci9GbGF0ZURlY29kZQovRGVjb2RlUGFybXM8PC9QcmVkaWN0b3IgMTUKL0NvbHVtbnMgODE2Pj4v\nTGVuZ3RoIDEyMjY+PnN0cmVhbQp4nO3XsQ3DMBAEQan/ommDgaHMvxEhYKYBJVzc675+1nXIferD\nUD0eq2DgH8FA4LFCIBgIBAPBfezPBV7oG8zBkVkGjjdZgoE5wUAgGAgEA4FgIBAMBIKBQDAQCAYC\nwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKB\nQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBYAcDTFkYGHOSQSAYCAQD\ngWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLB\nQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFA\nMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAg\nEAwEgoFAMBDsYIApCwNjTjIIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFA\nIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAw\nEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQ\nDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgI\nBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgG\nAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASC\ngUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAPB\nDgaYsjAw5iSDQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYC\nwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKB\nQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4Fg\nIBAMBIKBQDAQCAYCwUAgGAgEA4FgINjBAFMWBsacZBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLB\nQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFA\nMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEOxhgysLAmJMMAsFAIBgIBAOB\nYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFA\nIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAsK4PHOUTUgplbmRzdHJl\nYW0KZW5kb2JqCjMyIDAgb2JqCjw8L1N1YnR5cGUvSW1hZ2UKL0NvbG9yU3BhY2UvRGV2aWNlUkdC\nCi9XaWR0aCA4MTYKL0hlaWdodCAyNTIKL0JpdHNQZXJDb21wb25lbnQgOAovSW50ZXJwb2xhdGUg\ndHJ1ZQovRmlsdGVyL0ZsYXRlRGVjb2RlCi9EZWNvZGVQYXJtczw8L1ByZWRpY3RvciAxNQovQ29s\ndW1ucyA4MTYKL0NvbG9ycyAzPj4KL1NNYXNrIDMxIDAgUi9MZW5ndGgg', '', '103.160.118.2', 1641953642, 0.17126, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(4, 'notifikasi/insert', 'post', 'a:14:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:3:"211";s:11:"id_pengirim";s:32:"6E68174FDB2AA961DA7FC2664F7EA6D5";s:15:"token_disposisi";s:0:"";s:16:"pesan_notifikasi";s:21:"Ada draft agenda baru";s:12:"token_agenda";s:32:"3FD951F39A4264D8443C98FA1F4D59ED";s:11:"id_penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:15:"tipe_notifikasi";s:2:"SM";}', '', '103.160.118.2', 1641953642, 0.00853086, '1', 200),
(5, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953643, 0.0134411, '1', 200),
(6, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953643, 0.012624, '1', 200),
(7, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953643, 0.0106199, '1', 200),
(8, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953643, 0.010654, '1', 200),
(9, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953670, 0.00649309, '1', 200),
(10, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953701, 0.012224, '1', 200),
(11, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953701, 0.013242, '1', 200),
(12, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"11176132";}', '', '103.160.118.2', 1641953714, 0.00607109, '1', 200),
(13, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"11176132";}', '', '103.160.118.2', 1641953761, 0.00617599, '1', 200),
(14, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953790, 0.013741, '1', 200),
(15, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953793, 0.00899601, '1', 200),
(16, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953808, 0.0125539, '1', 200),
(17, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953808, 0.0105021, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(18, 'draft/insert_draft', 'post', 'a:21:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:6:"181109";s:9:"jam_mulai";s:3:"9:0";s:10:"keterangan";s:3:"SAA";s:6:"id_opd";s:1:"1";s:8:"penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:11:"jam_selesai";s:4:"10:0";s:12:"jenis_agenda";s:1:"P";s:9:"create_by";s:10:"ajudan_gub";s:7:"dokumen";s:170564:"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\nEyPw5tl3Uoj/d3dHEGPK3RFKV4lDA26WeOsp+kV7cL1IxgtHCyEzIXXBoV4h36kYOUXn4BJEpgsY\ntV324v4rWVIi4GE3v094F6zX9xwq1xxr0/hI7K4lo1zAgtKCl+X5qt9BdaLn0ZGZEAAK7hWfOxED\ni6hBltPDb/4E/8sPf/rNH7A4+zLFgs/Bq/JDwpRkxIurXF1F+ea3L3/Xe/yhFG/w8ym03/Py22ez\n9G77tfpUMfVTNtabqMxDjgbpYXQY1z/wi5f/C/SvSQNlbmRzdHJlYW0KZW5kb2JqCjc2IDAgb2Jq\nCjg3ODAKZW5kb2JqCjUgMCBvYmoKPDwvVHlwZS9QYWdlL01lZGlhQm94IFswIDAgNzc4IDEwMDdd\nCi9Sb3RhdGUgMC9QYXJlbnQgMyAwIFIKL0dyb3VwIDQgMCBSCi9SZXNvdXJjZXM8PC9Qcm9jU2V0\nWy9QREYgL1RleHRdCi9Db2xvclNwYWNlIDQwIDAgUgovRXh0R1N0YXRlIDQxIDAgUgovUGF0dGVy\nbiA0MiAwIFIKL1hPYmplY3QgNDMgMCBSCi9Gb250IDQ0IDAgUgo+PgovQ29udGVudHMgNiAwIFIK\nPj4KZW5kb2JqCjQ1IDAgb2JqCjw8L1R5cGUvUGFnZS9NZWRpYUJveCBbMCAwIDc3OCAxMDA3XQov\nUm90YXRlIDAvUGFyZW50IDMgMCBSCi9Hcm91cCA0IDAgUgovUmVzb3VyY2VzPDwvUHJvY1NldFsv\nUERGIC9UZXh0XQovQ29sb3JTcGFjZSA2OSAwIFIKL0V4dEdTdGF0ZSA3MCAwIFIKL1BhdHRlcm4g\nNzEgMCBSCi9YT2JqZWN0IDcyIDAgUgovRm9udCA3MyAwIFIKPj4KL0NvbnRlbnRzIDQ2IDAgUgo+\nPgplbmRvYmoKNzQgMCBvYmoKPDwvVHlwZS9QYWdlL01lZGlhQm94IFswIDAgNzc4IDEwMDddCi9S\nb3RhdGUgMC9QYXJlbnQgMyAwIFIKL0dyb3VwIDQgMCBSCi9SZXNvdXJjZXM8PC9Qcm9jU2V0Wy9Q\nREYgL1RleHRdCi9Db2xvclNwYWNlIDkxIDAgUgovRXh0R1N0YXRlIDkyIDAgUgovUGF0dGVybiA5\nMyAwIFIKL1hPYmplY3QgOTQgMCBSCi9Gb250IDk1IDAgUgo+PgovQ29udGVudHMgNzUgMCBSCj4+\nCmVuZG9iagozIDAgb2JqCjw8IC9UeXBlIC9QYWdlcyAvS2lkcyBbCjUgMCBSCjQ1IDAgUgo3NCAw\nIFIKXSAvQ291bnQgMwo+PgplbmRvYmoKMSAwIG9iago8PC9UeXBlIC9DYXRhbG9nIC9QYWdlcyAz\nIDAgUgovTWV0YWRhdGEgMTIzIDAgUgo+PgplbmRvYmoKOCAwIG9iago8PC9UeXBlL0V4dEdTdGF0\nZQovQk0vTm9ybWFsCi9PUE0gMQovVEsgdHJ1ZT4+ZW5kb2JqCjkgMCBvYmoKPDwKL1JlZ2lzdHJ5\nKEFkb2JlKQovT3JkZXJpbmcoSWRlbnRpdHkpCi9TdXBwbGVtZW50IDAKPj4KZW5kb2JqCjEzIDAg\nb2JqCjw8Ci9SZWdpc3RyeShBZG9iZSkKL09yZGVyaW5nKElkZW50aXR5KQovU3VwcGxlbWVudCAw\nCj4+CmVuZG9iagoxNyAwIG9iago8PAovUmVnaXN0cnkoQWRvYmUpCi9PcmRlcmluZyhJZGVudGl0\neSkKL1N1cHBsZW1lbnQgMAo+PgplbmRvYmoKMjEgMCBvYmoKPDwKL1JlZ2lzdHJ5KEFkb2JlKQov\nT3JkZXJpbmcoSWRlbnRpdHkpCi9TdXBwbGVtZW50IDAKPj4KZW5kb2JqCjI2IDAgb2JqCjw8L1R5\ncGUvRXh0R1N0YXRlCi9CTS9Ob3JtYWw+PmVuZG9iagozMCAwIG9iagpbL1BhdHRlcm5dCmVuZG9i\nago0MCAwIG9iago8PC9SMzAKMzAgMCBSPj4KZW5kb2JqCjQxIDAgb2JqCjw8L1IyNgoyNiAwIFIv\nUjgKOCAwIFI+PgplbmRvYmoKNDIgMCBvYmoKPDwvUjM5CjM5IDAgUi9SMjkKMjkgMCBSL1IzMwoz\nMyAwIFIvUjM2CjM2IDAgUj4+CmVuZG9iagozOSAwIG9iago8PC9GaWx0ZXIvRmxhdGVEZWNvZGUK\nL1R5cGUvUGF0dGVybgovUGF0dGVyblR5cGUgMQovUGFpbnRUeXBlIDEKL1RpbGluZ1R5cGUgMQov\nQkJveFswCjAKMTAwMAoxMjc2XQovTWF0cml4WzAuNzUKMAowCjAuNzUKMTQuNwozNi40XQovWFN0\nZXAgNDY1NgovWVN0ZXAgNDY1NgovUmVzb3VyY2VzPDwvRXh0R1N0YXRlPDwvUjI2IDI2IDAgUgo+\nPgovWE9iamVjdDw8L1IzNyAzNyAwIFIKCi9SMzggMzggMCBSCj4+Ci9Qcm9jU2V0IFsvUERGL0lt\nYWdlQ10+Pi9MZW5ndGggNTg+PnN0cmVhbQp4nDPQM1QwAEEonZzLpR9kZKaQXsxVqGBoAARgYUMj\nczOIMqCIsYGZgYEpRKmxhYJLPlcgFwAAtw5SCmVuZHN0cmVhbQplbmRvYmoKMjkgMCBvYmoKPDwv\nRmlsdGVyL0ZsYXRlRGVjb2RlCi9UeXBlL1BhdHRlcm4KL1BhdHRlcm5UeXBlIDEKL1BhaW50VHlw\nZSAxCi9UaWxpbmdUeXBlIDEKL0JCb3hbMAowCjgxNgoyNTJdCi9NYXRyaXhbMC44MzE0ODYKMAow\nCjAuODMxNDg2CjUxLjYKNjgxLjJdCi9YU3RlcCAzMjE1Ci9ZU3RlcCAzMjE1Ci9SZXNvdXJjZXM8\nPC9FeHRHU3RhdGU8PC9SMjYgMjYgMCBSCj4+Ci9YT2JqZWN0PDwvUjI3IDI3IDAgUgoKL1IyOCAy\nOCAwIFIKPj4KL1Byb2NTZXQgWy9QREYvSW1hZ2VDXT4+L0xlbmd0aCA5Nz4+c3RyZWFtCnicM9Az\nVDAAQSidnMtVyAViWBiaGSgYmRoZKBSlKoQr5HEFcukHGZkppBdDFeRyQeVzuBBqoWwQI4MLpKtQ\nASoAVWCgoGugZ2BgYGhiamoIsg1oqIWCSz7Q+EAuAMa5HCsKZW5kc3RyZWFtCmVuZG9iagozMyAw\nIG9iago8PC9GaWx0ZXIvRmxhdGVEZWNvZGUKL1R5cGUvUGF0dGVybgovUGF0dGVyblR5cGUgMQov\nUGFpbnRUeXBlIDEKL1RpbGluZ1R5cGUgMQovQkJveFswCjAKODE2CjI1Ml0KL01hdHJpeFswLjgz\nMTQ4NgowCjAKMC44MzE0ODYKNTEuNgo0MzcuNl0KL1hTdGVwIDMyMTUKL1lTdGVwIDMyMTUKL1Jl\nc291cmNlczw8L0V4dEdTdGF0ZTw8L1IyNiAyNiAwIFIKPj4KL1hPYmplY3Q8PC9SMzEgMzEgMCBS\nCgovUjMyIDMyIDAgUgo+PgovUHJvY1NldCBbL1BERi9JbWFnZUNdPj4vTGVuZ3RoIDk4Pj5zdHJl\nYW0KeJwz0DNUMABBKJ2cy1XIBWJYGJoZKBiZGhkoFKUqhCvkcQVy6QcZmSmkF0MV5HJB5XO4EGqh\nbBAjgwukq1ABKgBVYKCga6BnYGBgaGJqagiyTT/I2EjBJR9ofCAXAMaNHCYKZW5kc3RyZWFtCmVu\nZG9iagozNiAwIG9iago8PC9GaWx0ZXIvRmxhdGVEZWNvZGUKL1R5cGUvUGF0dGVybgovUGF0dGVy\nblR5cGUgMQovUGFpbnRUeXBlIDEKL1RpbGluZ1R5cGUgMQovQkJveFswCjAKODE2CjQ0Ml0KL01h\ndHJpeFswLjgzMTQ4NgowCjAKMC44MzE0ODYKNTEuNgozNi44XQovWFN0ZXAgMzQwNQovWVN0ZXAg\nMzQwNQovUmVzb3VyY2VzPDwvRXh0R1N0YXRlPDwvUjI2IDI2IDAgUgo+PgovWE9iamVjdDw8L1Iz\nNCAzNCAwIFIKCi9SMzUgMzUgMCBSCj4+Ci9Qcm9jU2V0IFsvUERGL0ltYWdlQ10+Pi9MZW5ndGgg\nOTk+PnN0cmVhbQp4nDPQM1QwAEEonZzLVcgFYlgYmhkomJgYGSgUpSqEK+RxBXLpBxmZKaQXQxXk\nckHlc7gQaqFsECODC6SrUAEqAFVgoKBroGdgYGBoaWhiaAqyTj/I2FTBJR9ofiAXAOQRHGIKZW5k\nc3RyZWFtCmVuZG9iago0MyAwIG9iago8PC9SMzgKMzggMCBSL1IzNwozNyAwIFIvUjM1CjM1IDAg\nUi9SMzQKMzQgMCBSL1IzMgozMiAwIFIvUjMxCjMxIDAgUi9SMjgKMjggMCBSL1IyNwoyNyAwIFI+\nPgplbmRvYmoKMzggMCBvYmoKPDwvU3VidHlwZS9JbWFnZQovQ29sb3JTcGFjZS9EZXZpY2VSR0IK\nL1dpZHRoIDEwMDAKL0hlaWdodCAxMjc2Ci9CaXRzUGVyQ29tcG9uZW50IDgKL0ludGVycG9sYXRl\nIHRydWUKL0ZpbHRlci9GbGF0ZURlY29kZQovRGVjb2RlUGFybXM8PC9QcmVkaWN0b3IgMTUKL0Nv\nbHVtbnMgMTAwMAovQ29sb3JzIDM+PgovU01hc2sgMzcgMCBSL0xlbmd0aCA2NTY4Pj5zdHJlYW0K\neJzt1jENADAMwLCVP+lB6LlFshHkzBwAAOB78zoAAADYGXcAAAgw7gAAEGDcAQAgwLgDAECAcQcA\ngADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAA\nBBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAg\nwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAAB\nxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw\n7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBx\nBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7\nAAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwB\nACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4A\nAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAA\nCDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBA\ngHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAAC\njDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg\n3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADj\nDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3\nAAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgD\nAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0A\nAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAA\nEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCA\nAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAE\nGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDA\nuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHG\nHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDu\nAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEH\nAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsA\nAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEA\nIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAA\nAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAI\nMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECA\ncQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKM\nOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDc\nAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMO\nAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcA\nAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMA\nQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAA\nAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQ\nYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA\n4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQY\ndwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4\nAwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYd\nAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4A\nABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcA\ngADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAA\nBBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAg\nwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAAB\nxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw\n7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBx\nBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7\nAAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwB\nACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4A\nAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAA\nCDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBA\ngHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAAC\njDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg\n3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADj\nDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3\nAAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgD\nAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0A\nAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAA\nEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCA\nAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAE\nGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDA\nuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHG\nHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDu\nAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEH\nAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsA\nAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEA\nIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAA\nAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAI\nMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECA\ncQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKM\nOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDc\nAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMO\nAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcA\nAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMA\nQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAA\nAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQ\nYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA\n4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQY\ndwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4\nAwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYd\nAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4A\nABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcA\ngADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAA\nBBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAg\nwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAAB\nxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw\n7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBx\nBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7\nAAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwB\nACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4A\nAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAA\nCDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBA\ngHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAAC\njDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg\n3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADj\nDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3\nAAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgD\nAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0A\nAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAA\nEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCA\nAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAE\nGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDA\nuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHG\nHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDu\nAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEH\nAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsA\nAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEA\nIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECAcQcAgADjDgAA\nAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKMOwAABBh3AAAI\nMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDcAQAgwLgDAECA\ncQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMOAAABxh0AAAKM\nOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcAAAgw7gAAEGDc\nAQAgwLgDAECAcQcAgADjDgAAAcYdAAACjDsAAAQYdwAACDDuAAAQYNwBACDAuAMAQIBxBwCAAOMO\nAAABxh0AAAKMOwAABBh3AAAIMO4AABBg3AEAIMC4AwBAgHEHAIAA4w4AAAHGHQAAAow7AAAEGHcA\nAAgw7gAAEHABnNQE/QplbmRzdHJlYW0KZW5kb2JqCjM3IDAgb2JqCjw8L1N1YnR5cGUvSW1hZ2UK\nL0NvbG9yU3BhY2UvRGV2aWNlR3JheQovV2lkdGggMTAwMAovSGVpZ2h0IDEyNzYKL0JpdHNQZXJD\nb21wb25lbnQgOAovRmlsdGVyL0ZsYXRlRGVjb2RlCi9EZWNvZGVQYXJtczw8L1ByZWRpY3RvciAx\nNQovQ29sdW1ucyAxMDAwPj4vTGVuZ3RoIDM2OTc+PnN0cmVhbQp4nO3TQQ0AIAzAQObfNCoWEnqn\noJ/OAb43rwOAfUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFG\nhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBg\ndAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4B\nRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQ\nYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowO\nAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDo\nEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKM\nDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA\n6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0C\njA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEh\nwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgd\nAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DR\nIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQY\nHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA\n0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoE\nGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKND\ngNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6\nBBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCj\nQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgw\nOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocA\no0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQI\nMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaH\nAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0\nCDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFG\nhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBg\ndAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4B\nRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQ\nYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowO\nAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDo\nEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKM\nDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA\n6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0C\njA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEh\nwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgd\nAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DR\nIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQY\nHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA\n0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoE\nGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKND\ngNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6\nBBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCj\nQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgw\nOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocA\no0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQI\nMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaH\nAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0\nCDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFG\nhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBg\ndAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4B\nRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQ\nYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowO\nAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDo\nEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKM\nDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA\n6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0C\njA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEh\nwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgd\nAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DR\nIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQY\nHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA\n0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDgNEhwOgQYHQIMDoE\nGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKND\ngNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCjQ4DRIcDoEGB0CDA6\nBBgdAowOAUaHAKNDgNEhwOgQYHQIMDoEGB0CjA4BRocAo0OA0SHA6BBgdAgwOgQYHQKMDgFGhwCj\nQ4DRIcDoEGB0CDA6BBgdAowOAUaHAKNDwAWBwAT9CmVuZHN0cmVhbQplbmRvYmoKMzUgMCBvYmoK\nPDwvU3VidHlwZS9JbWFnZQovQ29sb3JTcGFjZS9EZXZpY2VSR0IKL1dpZHRoIDgxNgovSGVpZ2h0\nIDQ0MgovQml0c1BlckNvbXBvbmVudCA4Ci9JbnRlcnBvbGF0ZSB0cnVlCi9GaWx0ZXIvRmxhdGVE\nZWNvZGUKL0RlY29kZVBhcm1zPDwvUHJlZGljdG9yIDE1Ci9Db2x1bW5zIDgxNgovQ29sb3JzIDM+\nPgovU01hc2sgMzQgMCBSL0xlbmd0aCAyMDE0Pj5zdHJlYW0KeJzt1jEBAAAIgDDtX9oYHG4JONkB\nACC1dQAAwHeGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgA\nAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKG\nDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAg\nZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGKGDAAgZsgAAGIH344Buwpl\nbmRzdHJlYW0KZW5kb2JqCjM0IDAgb2JqCjw8L1N1YnR5cGUvSW1hZ2UKL0NvbG9yU3BhY2UvRGV2\naWNlR3JheQovV2lkdGggODE2Ci9IZWlnaHQgNDQyCi9CaXRzUGVyQ29tcG9uZW50IDgKL0ZpbHRl\nci9GbGF0ZURlY29kZQovRGVjb2RlUGFybXM8PC9QcmVkaWN0b3IgMTUKL0NvbHVtbnMgODE2Pj4v\nTGVuZ3RoIDEyMjY+PnN0cmVhbQp4nO3XsQ3DMBAEQan/ommDgaHMvxEhYKYBJVzc675+1nXIferD\nUD0eq2DgH8FA4LFCIBgIBAPBfezPBV7oG8zBkVkGjjdZgoE5wUAgGAgEA4FgIBAMBIKBQDAQCAYC\nwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKB\nQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBYAcDTFkYGHOSQSAYCAQD\ngWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLB\nQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFA\nMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAg\nEAwEgoFAMBDsYIApCwNjTjIIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFA\nIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAw\nEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQ\nDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgI\nBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgG\nAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASC\ngUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAPB\nDgaYsjAw5iSDQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYC\nwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKB\nQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4FgIBAMBIKBQDAQCAYCwUAgGAgEA4Fg\nIBAMBIKBQDAQCAYCwUAgGAgEA4FgINjBAFMWBsacZBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLB\nQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEgoFA\nMBAIBgLBQCAYCAQDgWAgEAwEgoFAMBAIBgLBQCAYCAQDgWAgEAwEOxhgysLAmJMMAsFAIBgIBAOB\nYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFA\nIBgIBAOBYCAQDASCgUAwEAgGAsFAIBgIBAOBYCAQDASCgUAwEAgGAsFAsK4PHOUTUgplbmRzdHJl\nYW0KZW5kb2JqCjMyIDAgb2JqCjw8L1N1YnR5cGUvSW1hZ2UKL0NvbG9yU3BhY2UvRGV2aWNlUkdC\nCi9XaWR0aCA4MTYKL0hlaWdodCAyNTIKL0JpdHNQZXJDb21wb25lbnQgOAovSW50ZXJwb2xhdGUg\ndHJ1ZQovRmlsdGVyL0ZsYXRlRGVjb2RlCi9EZWNvZGVQYXJtczw8L1ByZWRpY3RvciAxNQovQ29s\ndW1ucyA4MTYKL0NvbG9ycyAzPj4KL1NNYXNrIDMxIDAgUi9MZW5ndGggMTE1', '', '103.160.118.2', 1641953809, 0.169779, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(19, 'notifikasi/insert', 'post', 'a:14:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:3:"211";s:11:"id_pengirim";s:32:"6E68174FDB2AA961DA7FC2664F7EA6D5";s:15:"token_disposisi";s:0:"";s:16:"pesan_notifikasi";s:21:"Ada draft agenda baru";s:12:"token_agenda";s:32:"9C29D5A480558DAE2010BADE89F4C81D";s:11:"id_penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:15:"tipe_notifikasi";s:2:"SM";}', '', '103.160.118.2', 1641953810, 0.00838304, '1', 200),
(20, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953810, 0.0108402, '1', 200),
(21, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953810, 0.013381, '1', 200),
(22, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953810, 0.010509, '1', 200),
(23, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953810, 0.0110781, '1', 200),
(24, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953923, 0.00703597, '1', 200),
(25, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953939, 0.011301, '1', 200),
(26, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953939, 0.0105498, '1', 200),
(27, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953964, 0.0128078, '1', 200),
(28, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953964, 0.010241, '1', 200),
(29, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953984, 0.0149, '1', 200),
(30, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953984, 0.0103521, '1', 200),
(31, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953988, 0.00799489, '1', 200),
(32, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641953988, 0.0122221, '1', 200),
(33, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954014, 0.0147939, '1', 200),
(34, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954014, 0.00933003, '1', 200),
(35, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954020, 0.011986, '1', 200),
(36, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954020, 0.0105841, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(37, 'draft/insert_draft', 'post', 'a:21:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:6:"849524";s:9:"jam_mulai";s:4:"12:0";s:10:"keterangan";s:6:"REREWR";s:6:"id_opd";s:1:"1";s:8:"penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:11:"jam_selesai";s:5:"12:25";s:12:"jenis_agenda";s:1:"P";s:9:"create_by";s:10:"ajudan_gub";s:7:"dokumen";s:777603:"JVBERi0xLjMKJeLjz9MKMSAwIG9iago8PCAKL0NyZWF0b3IgKENhbm9uIFNDMTAxMSkKL0NyZWF0\naW9uRGF0ZSAoRDoyMDIwMDEwNjA5MTc1NCswNycwMCcpCi9Qcm9kdWNlciAoTVAgTmF2aWdhdG9y\nIEVYKQo+PiAKZW5kb2JqCjIgMCBvYmoKPDwgCi9QYWdlcyAzIDAgUiAKL1R5cGUgL0NhdGFsb2cg\nCj4+IAplbmRvYmoKNCAwIG9iago8PCAvV2lkdGggNzkgL0hlaWdodCAxMDYgCi9CaXRzUGVyQ29t\ncG9uZW50IDggL0NvbG9yU3BhY2UgL0RldmljZVJHQgovRmlsdGVyIC9EQ1REZWNvZGUgL0xlbmd0\naCA0MzgxID4+IApzdHJlYW0K/9j/4AAQSkZJRgABAAEAZgBnAAD//gAfTEVBRCBUZWNobm9sb2dp\nZXMgSW5jLiBWMS4wMQD/2wCEAAICAgQDBAcEBAcHBQUFBwcGBgYGBwcHBwcHBwcHBwcHBwcHBwcH\nBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcBAwQEBQQFBgQEBgcGBQYHBwcHBwcHBwcHBwcHBwcH\nBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHB//EAaIAAAEFAQEBAQEBAAAAAAAAAAAB\nAgMEBQYHCAkKCwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoLEAACAQMDAgQDBQUEBAAAAX0B\nAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpD\nREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmq\nsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+foRAAIBAgQEAwQH\nBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJico\nKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZ\nmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/A\n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\n/GmBG+o3ABxJJ0/vt6fWgRj3OsXagYmlHXpI4/rTQHOz67fJIxWeZTtUZErg4BbA+92ycfU+tAGd\nL4m1JelzcD/ttJ/8VSQFIeKtUz/x9XP/AH/l/wDiqBntnwgvp7uO6kuHeVw8ShpGZ22hCQMsScAk\nkDpkk9zSegH/2QplbmRzdHJlYW0KZW5kb2JqCjUgMCBvYmoKPDwgL1R5cGUgL1hPYmplY3QgL1N1\nYnR5cGUgL0ltYWdlIC9XaWR0aCAyMDE2IC9IZWlnaHQgMjcyMCAKL0JpdHNQZXJDb21wb25lbnQg\nOCAvQ29sb3JTcGFjZSAvRGV2aWNlUkdCCi9GaWx0ZXIgWyAvRmxhdGVEZWNvZGUgL0RDVERlY29k\nZSBdIC9MZW5ndGggMjY1Nzk3ID4+IApzdHJlYW0KeAHsvHVQnE30Jjq4BAnBYZAgmQR3HQYIwYMn\nuEtwd3cJwQkSZHALFoI7BJfgwXUGd89gw+Xb3dq6W/eP+7u3dqt+u/V1vdVVb/XUW2e6uk8/5znP\n6cf5x3XAcwUZeRkAylNjQ2EDAB6XAGEAfBzcZ7jY+M9wnxEQ4BMS05MSv3hBDALSktNzvOHm4njD\nzsYrogDhFZARZGOX0JKUea+srqHOA9E10VU1VlBTV0EhICAgJiJ+RUr6SoWfnV/l/3N77EXJBwBQ\nMJ6senoA/62hoKKhY2BiYT9ZhwJAexr4r89/Hf2/DT4HoKKgoaGio2FgoKM/fcb/aQyAToTx4iW3\nJCaxmgkWgzMJT3BiHjbj25puUvXJUyZeU5cQHFwycgpKKuZXoNdvWPj4BQSFhEWk3knLyMrJK2h8\n+Kippa2ja2Zu8cnSytrG1c3dw9PL2yc0LDwiMupzdFLy15TUtPRvGfkFhUXFJaVl33/W1tU3NDY1\nt/zq6e3rHxgcGp6anvkzOze/sLgBg29ube/s7u2fnV9cXl3/RdzcEj2ZjIqOjoaO9Y/JKKiegCeb\nidAxXnJjvpBUwzJxJmbgCcYmeZuYV9ONw8irfkpq6jKJS8bEt8F89o/V/8Xo/5jNIf+/jP7vNv93\nkx+7AETYuLlY62goLwGoRChoRCiPiwA8NBQAKhEaEUAccLn/GpAfhPtv959oDgrpkwq5KYTpzaAi\ndBeLQWTRgNe5qP92/87Bv+vg323wryv41xP+6wn/R0+YSMLAErMhgykPuhCzQrH6d3r+x+n5d8P8\n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', '', '103.160.118.2', 1641954021, 0.711923, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(38, 'notifikasi/insert', 'post', 'a:14:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:3:"211";s:11:"id_pengirim";s:32:"6E68174FDB2AA961DA7FC2664F7EA6D5";s:15:"token_disposisi";s:0:"";s:16:"pesan_notifikasi";s:21:"Ada draft agenda baru";s:12:"token_agenda";s:32:"718258DC666409DA9F0137AEF33DDCFF";s:11:"id_penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:15:"tipe_notifikasi";s:2:"SM";}', '', '103.160.118.2', 1641954022, 0.00834608, '1', 200),
(39, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954022, 0.0112441, '1', 200),
(40, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954022, 0.0127871, '1', 200),
(41, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954024, 0.011199, '1', 200),
(42, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954024, 0.00924301, '1', 200),
(43, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954117, 0.00679493, '1', 200),
(44, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954128, 0.0198309, '1', 200),
(45, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954128, 0.00613999, '1', 200),
(46, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954128, 0.00945115, '1', 200),
(47, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954128, 0.00579, '1', 200),
(48, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641954128, 0.00497913, '1', 200),
(49, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955464, 0.00899792, '1', 200),
(50, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955464, 0.0112588, '1', 200),
(51, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955464, 0.0097301, '1', 200),
(52, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955464, 0.00674415, '1', 200),
(53, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955495, 0.0134032, '1', 200),
(54, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955495, 0.013581, '1', 200),
(55, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955495, 0.00636792, '1', 200),
(56, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955495, 0.010577, '1', 200),
(57, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"11176123";}', '', '103.160.118.2', 1641955509, 0.00620604, '1', 200),
(58, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955519, 0.012233, '1', 200),
(59, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955519, 0.00800991, '1', 200),
(60, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955519, 0.0116429, '1', 200),
(61, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955519, 0.00697994, '1', 200),
(62, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:7:"6995176";}', '', '103.160.118.2', 1641955523, 0.00578213, '1', 200),
(63, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955534, 0.0153821, '1', 200),
(64, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955534, 0.011337, '1', 200),
(65, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955534, 0.00856495, '1', 200),
(66, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955534, 0.00623798, '1', 200),
(67, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955546, 0.0121019, '1', 200),
(68, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955546, 0.0133798, '1', 200),
(69, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955546, 0.010705, '1', 200),
(70, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955546, 0.00760102, '1', 200),
(71, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955624, 0.0125968, '1', 200),
(72, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955629, 0.010057, '1', 200),
(73, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955629, 0.00925088, '1', 200),
(74, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955629, 0.00834012, '1', 200),
(75, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955652, 0.0122011, '1', 200),
(76, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955652, 0.010016, '1', 200),
(77, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955652, 0.0111129, '1', 200),
(78, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955652, 0.00866199, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(79, 'draft/insert_draft', 'post', 'a:21:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:7:"1054862";s:9:"jam_mulai";s:4:"8:25";s:10:"keterangan";s:3:"trt";s:6:"id_opd";s:1:"1";s:8:"penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:11:"jam_selesai";s:4:"8:50";s:12:"jenis_agenda";s:1:"P";s:9:"create_by";s:10:"ajudan_gub";s:7:"dokumen";s:959716:"JVBERi0xLjUNCiW1tbW1DQoxIDAgb2JqDQo8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFIvTGFu\nZyhlbi1VUykgL1N0cnVjdFRyZWVSb290IDU0IDAgUi9NYXJrSW5mbzw8L01hcmtlZCB0cnVlPj4+\nPg0KZW5kb2JqDQoyIDAgb2JqDQo8PC9UeXBlL1BhZ2VzL0NvdW50IDExL0tpZHNbIDMgMCBSIDEw\nIDAgUiAxOSAwIFIgMjMgMCBSIDI1IDAgUiAyOSAwIFIgMzEgMCBSIDM4IDAgUiA0MCAwIFIgNDMg\nMCBSIDQ2IDAgUl0gPj4NCmVuZG9iag0KMyAwIG9iag0KPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAg\nUi9SZXNvdXJjZXM8PC9Gb250PDwvRjEgNSAwIFIvRjIgOCAwIFI+Pi9FeHRHU3RhdGU8PC9HUzcg\nNyAwIFI+Pi9Qcm9jU2V0Wy9QREYvVGV4dC9JbWFnZUIvSW1hZ2VDL0ltYWdlSV0gPj4vTWVkaWFC\nb3hbIDAgMCA1OTQuOTYgODQxLjkyXSAvQ29udGVudHMgNCAwIFIvR3JvdXA8PC9UeXBlL0dyb3Vw\nL1MvVHJhbnNwYXJlbmN5L0NTL0RldmljZVJHQj4+L1RhYnMvUy9TdHJ1Y3RQYXJlbnRzIDA+Pg0K\nZW5kb2JqDQo0IDAgb2JqDQo8PC9GaWx0ZXIvRmxhdGVEZWNvZGUvTGVuZ3RoIDkyNz4+DQpzdHJl\nYW0NCnicjVfbbhMxEH2PlH/w4xppXXt8l6pKSVuglF5EAw+kPBSaFgSliBYk/p4ZZzfZTbuOVTXa\nnbXPXDxzZsx2ztnu7s7J/tEBk3t7bHqwz6az8WjnpWIK2OxmPFJM4p9iAE44x7wNQgc2uxuPJLvF\nla8uPLt9oLdX49G8est1NeGuOue1r854rat3jeSUcbsUkyR9esPrUB3yUO3zWM14bSqGC1fbCeuI\n++qY1wqS+ILXDkWf2OzNeHSIhi6NBaakkKFnr3ZB+NC1d47o653s8GSfsY7/quc/PPE/euGBee1F\nLMKDDt4miIqFIDoDIpWItgTEDIO4AAJ8CYjNp0eIGG3DnJNCxQZv86DatRFEhNBf+5PXUN1QUtwP\n7FISVej+rmPMjveUE5RSlDuXFSUOiX9TOi1QfE3I3/DbI0ppTdrwcEW/X+kbPtn0gUDSy/d/9Jse\nadMlJ1BaccDrmLB+rjY+UFqTwvtfrcak+oorUz1840vo69X6tJMN+KgNiOD6PiZzScFJa2cqjqTk\n/i9V0MqglbpUJ39IdMeVXnvSsa7Bml7R61r2OGCZiUrARvSHvACjhEQvdBSyza3pIZY4BXg6QTua\nOm4e2qI/xfAquaYHWnBQVuyoKm5ozGazKyp2p7TQRXh+uMRstIUgIQPifSFIzIDYWAiiZAYFT7cQ\nRT2HEpxAkC4Dnv3gyO+Lr2VHjTQApg+QtwKKztpEDI4pAtRbOqUFgQXjgwBo8D5OuKleU6223ZBy\nPhX0pGWkttsljjmdPAmGei4YxlIUerq6tqcW3drjqCijFiEEJsnl34vx6ObFcx6aLSFTjurMOBAO\n1rPAPHm1/q+VzkrWbwM8YpVQpqtmjjEbWOuUMK6/9h6j+Rm1GGRI5JUf9LNgeBJIoABIejEtuaVz\noZeru7vFkg3LYh9FgL7GfN7YskQk3LLMdsNVarQqRclwl1G6FCVDXhoZsBAlw14aKbAMBTLspZED\nscOWoDzLXg0KcmAhSmYM1KBLUTJzoJa2FCUzCBItm6I0hi2TIChFIyU4I7RqABOnEbkhr9l106ep\nJnX6xISJBU+PGnln3O/MXquLRAJ7eUb7iFJXVJpuEd1LQ0lPMQon0g2T8zFw2y5LltgIjBS2HdH7\nV58PRDrJiQuSt04mj1Mg+h7RJanbOtIU1QpmZY3TS2oSPZvyTvotTgabMgebgV+OhKwmrdhEv8wr\nkCoWN3Sc3bowMiE8Me4/f/3lWA0KZW5kc3RyZWFtDQplbmRvYmoNCjUgMCBvYmoNCjw8L1R5cGUv\nRm9udC9TdWJ0eXBlL1RydWVUeXBlL05hbWUvRjEvQmFzZUZvbnQvQUJDREVFK0NhbGlicmksQm9s\nZC9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcvRm9udERlc2NyaXB0b3IgNiAwIFIvRmlyc3RDaGFy\nIDMyL0xhc3RDaGFyIDEyMS9XaWR0aHMgMjgxIDAgUj4+DQplbmRvYmoNCjYgMCBvYmoNCjw8L1R5\ncGUvRm9udERlc2NyaXB0b3IvRm9udE5hbWUvQUJDREVFK0NhbGlicmksQm9sZC9GbGFncyAzMi9J\ndGFsaWNBbmdsZSAwL0FzY2VudCA3NTAvRGVzY2VudCAtMjUwL0NhcEhlaWdodCA3NTAvQXZnV2lk\ndGggNTM2L01heFdpZHRoIDE3ODEvRm9udFdlaWdodCA3MDAvWEhlaWdodCAyNTAvU3RlbVYgNTMv\nRm9udEJCb3hbIC01MTkgLTI1MCAxMjYzIDc1MF0gL0ZvbnRGaWxlMiAyODIgMCBSPj4NCmVuZG9i\nag0KNyAwIG9iag0KPDwvVHlwZS9FeHRHU3RhdGUvQk0vTm9ybWFsL0NBIDE+Pg0KZW5kb2JqDQo4\nIDAgb2JqDQo8PC9UeXBlL0ZvbnQvU3VidHlwZS9UcnVlVHlwZS9OYW1lL0YyL0Jhc2VGb250L0FC\nQ0RFRStDYWxpYnJpL0VuY29kaW5nL1dpbkFuc2lFbmNvZGluZy9Gb250RGVzY3JpcHRvciA5IDAg\nUi9GaXJzdENoYXIgMzIvTGFzdENoYXIgMTIxL1dpZHRocyAyODMgMCBSPj4NCmVuZG9iag0KOSAw\nIG9iag0KPDwvVHlwZS9Gb250RGVzY3JpcHRvci9Gb250TmFtZS9BQkNERUUrQ2FsaWJyaS9GbGFn\ncyAzMi9JdGFsaWNBbmdsZSAwL0FzY2VudCA3NTAvRGVzY2VudCAtMjUwL0NhcEhlaWdodCA3NTAv\nQXZnV2lkdGggNTIxL01heFdpZHRoIDE3NDMvRm9udFdlaWdodCA0MDAvWEhlaWdodCAyNTAvU3Rl\nbVYgNTIvRm9udEJCb3hbIC01MDMgLTI1MCAxMjQwIDc1MF0gL0ZvbnRGaWxlMiAyODQgMCBSPj4N\nCmVuZG9iag0KMTAgMCBvYmoNCjw8L1R5cGUvUGFnZS9QYXJlbnQgMiAwIFIvUmVzb3VyY2VzPDwv\nRm9udDw8L0YyIDggMCBSL0YzIDEzIDAgUi9GNCAxNSAwIFIvRjUgMTcgMCBSPj4vRXh0R1N0YXRl\nPDwvR1MxMiAxMiAwIFIvR1M3IDcgMCBSPj4vUHJvY1NldFsvUERGL1RleHQvSW1hZ2VCL0ltYWdl\nQy9JbWFnZUldID4+L01lZGlhQm94WyAwIDAgNTk1LjQ0IDg0MS45Ml0gL0NvbnRlbnRzIDExIDAg\nUi9Hcm91cDw8L1R5cGUvR3JvdXAvUy9UcmFuc3BhcmVuY3kvQ1MvRGV2aWNlUkdCPj4vVGFicy9T\nL1N0cnVjdFBhcmVudHMgMT4+DQplbmRvYmoNCjExIDAgb2JqDQo8PC9GaWx0ZXIvRmxhdGVEZWNv\n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\n4CQPT6McZ9Ga/n1tVxFUYvOtvWZd0kmWFyh3mCKFOxgRFj/q6cF+s5IVkW2skCvd8mAyB70G57Cw\nC0qzaBsto97p3vuYlVTHWEdrM2duS2OZDH192Gk55pyZEDu9rRVoo6VtYteV0fguJKLZoV0VMtto\nJWScVCKWwilVjG7ijAnVfdf7iUIdNHRo7jXiJe4bZIxQ8pNEQSPlQdvQtiFSHuhs4m3BD6fnOaYw\nsb88RNspGIFDU22Pn5KsFDK3iwC7UpgEXzSg3sJbNBse8wYbMtSu2uL2WFpl+XhGWwjLrp8RHXea\nqst/esT2yPYaFpM9julflDAnogxmfr8B31FSbnvvwTzuUzSvSzRohfYp1q9gpziMd2iGfy9KdhSx\nyILbEX9kKQeo9hdUzwja2V1jOU1dFSNNg1PJkzb23C1CN+EXLTeeQD8dOhbtgUk7By8GMzBcaHE3\nUbMBxyfHYJgQ0K9z9mSu0Q4F1QiHqVlii7BkHnK/fZ20/6VlTWgzsP/d+MW/ibyHMTwNhf9aEOEJ\nvzc62GTpFWcZXB69HcMuNFnLDCXS4XxlPuvhCSv2cEUVFQwUkTh7fd+/o1hA1g0KZW5kc3RyZWFt\nDQplbmRvYmoNCjEyIDAgb2JqDQo8PC9UeXBlL0V4dEdTdGF0ZS9CTS9Ob3JtYWwvY2EgMT4+DQpl\nbmRvYmoNCjEzIDAgb2JqDQo8PC9UeXBlL0ZvbnQvU3VidHlwZS9UcnVlVHlwZS9OYW1lL0YzL0Jh\nc2VGb250L1RpbWVzIzIwTmV3IzIwUm9tYW4sQm9sZC9FbmNvZGluZy9XaW5BbnNpRW5jb2Rpbmcv\nRm9udERlc2NyaXB0b3IgMTQgMCBSL0ZpcnN0Q2hhciAzMi9MYXN0Q2hhciAxMjEvV2lkdGhzIDI4\nNSAwIFI+Pg0KZW5kb2JqDQoxNCAwIG9iag0KPDwvVHlwZS9Gb250RGVzY3JpcHRvci9Gb250TmFt\nZS9UaW1lcyMyME5ldyMyMFJvbWFuLEJvbGQvRmxhZ3MgMzIvSXRhbGljQW5nbGUgMC9Bc2NlbnQg\nODkxL0Rlc2NlbnQgLTIxNi9DYXBIZWlnaHQgNjc3L0F2Z1dpZHRoIDQyNy9NYXhXaWR0aCAyNTU4\nL0ZvbnRXZWlnaHQgNzAwL1hIZWlnaHQgMjUwL0xlYWRpbmcgNDIvU3RlbVYgNDIvRm9udEJCb3hb\nIC01NTggLTIxNiAyMDAwIDY3N10gPj4NCmVuZG9iag0KMTUgMCBvYmoNCjw8L1R5cGUvRm9udC9T\ndWJ0eXBlL1RydWVUeXBlL05hbWUvRjQvQmFzZUZvbnQvQXJpYWwsQm9sZC9FbmNvZGluZy9XaW5B\nbnNpRW5jb2RpbmcvRm9udERlc2NyaXB0b3IgMTYgMCBSL0ZpcnN0Q2hhciAzMi9MYXN0Q2hhciAz\nMi9XaWR0aHMgMjg2IDAgUj4+DQplbmRvYmoNCjE2IDAgb2JqDQo8PC9UeXBlL0ZvbnREZXNjcmlw\ndG9yL0ZvbnROYW1lL0FyaWFsLEJvbGQvRmxhZ3MgMzIvSXRhbGljQW5nbGUgMC9Bc2NlbnQgOTA1\nL0Rlc2NlbnQgLTIxMC9DYXBIZWlnaHQgNzI4L0F2Z1dpZHRoIDQ3OS9NYXhXaWR0aCAyNjI4L0Zv\nbnRXZWlnaHQgNzAwL1hIZWlnaHQgMjUwL0xlYWRpbmcgMzMvU3RlbVYgNDcvRm9udEJCb3hbIC02\nMjggLTIxMCAyMDAwIDcyOF0gPj4NCmVuZG9iag0KMTcgMCBvYmoNCjw8L1R5cGUvRm9udC9TdWJ0\neXBlL1RydWVUeXBlL05hbWUvRjUvQmFzZUZvbnQvVGltZXMjMjBOZXcjMjBSb21hbi9FbmNvZGlu\nZy9XaW5BbnNpRW5jb2RpbmcvRm9udERlc2NyaXB0b3IgMTggMCBSL0ZpcnN0Q2hhciAzMi9MYXN0\nQ2hhciAxODQvV2lkdGhzIDI5MCAwIFI+Pg0KZW5kb2JqDQoxOCAwIG9iag0KPDwvVHlwZS9Gb250\nRGVzY3JpcHRvci9Gb250TmFtZS9UaW1lcyMyME5ldyMyMFJvbWFuL0ZsYWdzIDMyL0l0YWxpY0Fu\nZ2xlIDAvQXNjZW50IDg5MS9EZXNjZW50IC0yMTYvQ2FwSGVpZ2h0IDY5My9BdmdXaWR0aCA0MDEv\nTWF4V2lkdGggMjYxNC9Gb250V2VpZ2h0IDQwMC9YSGVpZ2h0IDI1MC9MZWFkaW5nIDQyL1N0ZW1W\nIDQwL0ZvbnRCQm94WyAtNTY4IC0yMTYgMjA0NiA2OTNdID4+DQplbmRvYmoNCjE5IDAgb2JqDQo8\nPC9UeXBlL1BhZ2UvUGFyZW50IDIgMCBSL1Jlc291cmNlczw8L0ZvbnQ8PC9GMiA4IDAgUi9GNSAx\nNyAwIFIvRjYgMjEgMCBSPj4vRXh0R1N0YXRlPDwvR1MxMiAxMiAwIFIvR1M3IDcgMCBSPj4vUHJv\nY1NldFsvUERGL1RleHQvSW1hZ2VCL0ltYWdlQy9JbWFnZUldID4+L01lZGlhQm94WyAwIDAgNTk1\nLjQ0IDg0MS45Ml0gL0NvbnRlbnRzIDIwIDAgUi9Hcm91cDw8L1R5cGUvR3JvdXAvUy9UcmFuc3Bh\ncmVuY3kvQ1MvRGV2aWNlUkdCPj4vVGFicy9TL1N0cnVjdFBhcmVudHMgMj4+DQplbmRvYmoNCjIw\nIDAgb2JqDQo8PC9GaWx0ZXIvRmxhdGVEZWNvZGUvTGVuZ3RoIDI1MjI+Pg0Kc3RyZWFtDQp4nJ1a\nW2/bOBZ+D5D/oEcLaGjxIkoEBgNM2ml3dzZAF81gHop5cGrHThVfNrVm0H+2P2955yFFSU5RBJVl\n8vBcv3Ohl7+8nJ8eV1/OxU8/LX85n1dfdpt18Xl5fzz9ubz/ftosP662T4fV+el4WH7qH87q1T82\nq/Xm5eefi9t3b4vb++ur5XtSYIwqVtw/Xl/hopL/cFFXDAlcNIKjihf3e7nuwydMiu2366uq2OqP\njf304frq84KWfxb3/7q++lWSVGQ9IVwhRiGhz4sCrP3v9dV/4h0YU0TljpYgTkZ3FL/evS2WIxq4\nPZ7Px/24Et4fj+dICe5sKjXRtgVtEW7Z9NnF8qM69e7tP98VVaTPupCKgsrEdY1aKRFuUOsk+lje\n0MWmZIuX8oYvuk15g+vFvsTt4qEk1WKlPx/U4xY8F/KxqsTiXN4QrLd3+v1RUhOL55K26hGLxfZJ\nPbvlnfl+r971+vvDkzqqW0kK39Sihf5cJEZcvuepLLSR1mGxLPvjw9Oz5SglMFAGqzgiJCaQnuvX\nEow4jtd+1UJsFedaPGLl2gCNaRGN2p6VXOZx/6R0PnYWpgxxUXBRISzsWacfMRDlYvE9XaLeM2F1\nbdlRXJ8Aq85kisC3Ur1l+s8Y21MQxu4rx5p6CIfIvdqUB03YWlW/Xts38pCtdQLDpSYWSeA5NVI/\nuHVbx6ilygKjlhVPxjzOKZsTVEfK1nvXfQcYlGJJTrS2AH2zAPiucQgqdzvD+w17o1i58iEY1MRJ\nLiTUFkdYb5REnZjGFr05SDO89frXJ2QsL98CZox1jHm+O8Wi8kaYg96tSu7IyY/mPM3HWltK75tT\n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\nZKN3Mb4L7yyve5X/kttAJZ/JiOrWjvt8AEZ8TMT3CWlPORQ0B8vqJrxuUlNMUclhIpPqSg06tOX4\n6HTA9/8BhcIEpQ0KZW5kc3RyZWFtDQplbmRvYmoNCjIxIDAgb2JqDQo8PC9UeXBlL0ZvbnQvU3Vi\ndHlwZS9UcnVlVHlwZS9OYW1lL0Y2L0Jhc2VGb250L1RpbWVzIzIwTmV3IzIwUm9tYW4sSXRhbGlj\nL0VuY29kaW5nL1dpbkFuc2lFbmNvZGluZy9Gb250RGVzY3JpcHRvciAyMiAwIFIvRmlyc3RDaGFy\nIDMyL0xhc3RDaGFyIDEyMS9XaWR0aHMgMjkxIDAgUj4+DQplbmRvYmoNCjIyIDAgb2JqDQo8PC9U\neXBlL0ZvbnREZXNjcmlwdG9yL0ZvbnROYW1lL1RpbWVzIzIwTmV3IzIwUm9tYW4sSXRhbGljL0Zs\nYWdzIDMyL0l0YWxpY0FuZ2xlIC0xNi40L0FzY2VudCA4OTEvRGVzY2VudCAtMjE2L0NhcEhlaWdo\ndCA2OTQvQXZnV2lkdGggNDAyL01heFdpZHRoIDE4MzEvRm9udFdlaWdodCA0MDAvWEhlaWdodCAy\nNTAvTGVhZGluZyA0Mi9TdGVtViA0MC9Gb250QkJveFsgLTQ5OCAtMjE2IDEzMzMgNjk0XSA+Pg0K\nZW5kb2JqDQoyMyAwIG9iag0KPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9SZXNvdXJjZXM8PC9G\nb250PDwvRjIgOCAwIFIvRjUgMTcgMCBSL0Y2IDIxIDAgUi9GMyAxMyAwIFIvRjQgMTUgMCBSPj4v\nUHJvY1NldFsvUERGL1RleHQvSW1hZ2VCL0ltYWdlQy9JbWFnZUldID4+L01lZGlhQm94WyAwIDAg\nNTk1LjQ0IDg0MS45Ml0gL0NvbnRlbnRzIDI0IDAgUi9Hcm91cDw8L1R5cGUvR3JvdXAvUy9UcmFu\nc3BhcmVuY3kvQ1MvRGV2aWNlUkdCPj4vVGFicy9TL1N0cnVjdFBhcmVudHMgMz4+DQplbmRvYmoN\nCjI0IDAgb2JqDQo8PC9GaWx0ZXIvRmxhdGVEZWNvZGUvTGVuZ3RoIDIyMTc+Pg0Kc3RyZWFtDQp4\nnLVaW4/bxg5+X2D/gx4toB5rLhppiqBFNml6cnoWyEk3T2kfvLHjdbzW7tlaBfLvDzkXiSNp5E2L\n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\nauCouS5jt71EPPQE1aF7T/8RT6WGmQUTVSz1bXKtwq9G0doOnWW6cAsB5zWOJcmXGorky+c3mOn2\n8nxzmcCOimM9FFmYLEMr4Nd4qZ3hkKL+T1TryCuqjhKEzaEzigU+m4hT5Z1mfCDy+WwtTcn4wBmU\nJf8eSdqfPyZbcsOETMdhBOL1s8iQ14IZz2ZLaPqFspT26ll0WOKQgEr4Vj4kezEMUDst1icbBcqI\n4MWY61KfTgu8fJHMNCUKiX99IFo8607jO6b9Zvn29fO+yCNPltVfIshAVz7PkbPGdCXIFUgz1PzX\n42KqFKwV/lWNyHwCNj6Rx1w7p2fqM7WEXAbPRXrmrZ2aHEvBmRhY2/UQ/XBBEPKLDZ9wqjxP/J0X\n0oQ7IrRAvLIcM8/4sHKqLfeZBf2+mQKg8Ln30Lozfj+rYaoP4ID3hscaRnb+H4WQldINCmVuZHN0\ncmVhbQ0KZW5kb2JqDQoyNSAwIG9iag0KPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9SZXNvdXJj\nZXM8PC9Gb250PDwvRjIgOCAwIFIvRjUgMTcgMCBSL0Y3IDI3IDAgUi9GNiAyMSAwIFI+Pi9Qcm9j\nU2V0Wy9QREYvVGV4dC9JbWFnZUIvSW1hZ2VDL0ltYWdlSV0gPj4vTWVkaWFCb3hbIDAgMCA1OTUu\nNDQgODQxLjkyXSAvQ29udGVudHMgMjYgMCBSL0dyb3VwPDwvVHlwZS9Hcm91cC9TL1RyYW5zcGFy\nZW5jeS9DUy9EZXZpY2VSR0I+Pi9UYWJzL1MvU3RydWN0UGFyZW50cyA0Pj4NCmVuZG9iag0KMjYg\nMCBvYmoNCjw8L0ZpbHRlci9GbGF0ZURlY29kZS9MZW5ndGggMTQ2Mj4+DQpzdHJlYW0NCnicpVjZ\nbts4FH034H/QowTUNPcFKApkaWcybYo09cxL0Ae5chzX9TKpPUD+frhoISVRdlAEUCzp3sO7Hl5q\nevF8WD3m3w/J27fTi8Mh//60KJKH6Wy3/zadvewX07t8udrmh9VuO/16nB/Moz8XebF4fvcuuby+\nSi5n49H0A04QApAms8fxCCVQ/6GEQQoUSoTiAPJkthmPYLI0lz/Go4eUZd+S2V/j0XutbzBqLQQB\nJb7WQ5p4sv+OR19CDYQIIFpDYsBxVCN5f3uVTCPuXu4Oh90m7vGH3e4QeFytTbTbUiZEAiTp8NrJ\n9M6sent1c53AIHgsQTiIHCIUcJUIJICsPEKgFbDpB9HRowRIFOolHbXucowBSUK1iwzjdJ9NkEp/\nrjLE03Wub1j6S19husqI7CDXcEoBLEK4m4gshjp3LJTdPmaEpLtsQlT60Zjxt15TpPcxCKqDxYed\nbmQlgDiU1d7JdFt6NFFpkWe09Nz8OmQTjMo3Vmh5tO+2GYZWoAyMvbdiR/vT6R3X+hFW6cZoLqzg\nT7Pe6slcffx+gynSzrG2wTFZAYSIxFJb/KxX4tqScuEgk85GVNloPVharfKBdpIwF6to3l0ZcQUB\nUuX664VeKQiIg/Zi9sbELMkIdMJOzPzS9nJraUfFSv/KlBXbH51KXqnYt65w7rVMg+88fskobIT9\nFGiRwiDObVD0U6rtbSCL2pYADcfR1vahgSxKyEjmpAC8FbnGbH/d4chzDFil/8PLpk2biZdLdBMb\nd1/60CTelrFZ1S5t7/bh7dwTXzuBqrqJK6+1rR6zqCeaRxwgjALJQwfafNfISoBxKOsHpkO2qIe3\nS4bl+p+qQPD5DBvonc+wgdplJtJWFBEcjmOE1DACRIbgNTsZ1EiKzWqtbqt6qrCLriobKtP8GjAP\nGqZ0pGYuffuEFY5tAUTIrvkebQVbgKgcClkbhfTldixLDLqFfSO8oLvAnmopKAARpVWf84wbHqIl\nlVrgsk8nqi+h7qEx+8aE15eN5JJxoMJV6+5vAD9rNOqh+QzRa0iskzCgPFztNmxYrxAqn3WUo62p\nqG1NH3CwNXG8NZlQZjdzIOT81gz0zm/NQO03hh8MMUAshLuxkYvWdGxUEYDRYXeaqiFAyFC2ahDk\ntneu0iePA148fsC0GnqCecc8nhsxQwjrRV31PxpWiDW0AqxljaOOeqjq5oW380KhBLSVTkNPm/w5\nQyg97J9228UZ+aUCdvI7rwlv3sSkTK75h0/RAtOdgzoNWlhIN7jaIilcdy7qGaYMgDfInIwDJgQg\nGq74bJp0u1yc9h5zCJQMtaNVxClAoahthDvtkOMv6w6KqSvNJi1DeVRWdmSj5QQRYDyU/a+qy3LX\nOtmWBAtAW3GgMVkd8bZsFJdw0LJtEhOlEPBzYQ2XnU4FjnYg7tSMHNh+27JRsyQC+PxUaAtV9KxC\nAG4VW2xXoYgDJuIWdnYVMv2kuyNJV8Xk5job2GIwNRRbVsMrthhf7xVbjK/W7NFPFRW7Ga+at90k\nY4eailY0dyzrY8bG0bB/9IyO8tUujn7/9LqZG5Rj62QcGQSbQ2br2NhJGe3JEtXcJVphuxkCYb0g\ntJOy7geG+yFY3gPLIAdooBI6ICL44tNheQYVoOIVePLEF6Sy5CAx30aafarI/dNFXX7lCH2xNdEo\nvHqrtzEzPH817FNWhjvQ7soZ2r4eYgLzXg9xulSgvaI3GYLDHqq+z21YAU5Dtywx/nM9eAKEfVg6\nRKSFNXyO7DtIEqaMeoBSnaLmVZP5+/5qcIm+gZgoBpB8jaGkF0UPQC13K47ROTo23dv0dvXdCJG0\nzJdNZHDcMA9umw8rtka+2Mn2UzY50fWor+3L0qWSmE91fkSNsU1MzwlnHyMghcwnxwB/2Mo+AkD6\nqKMbNkDZ+x/MLBOvNvYg2h772pxbNCHP25b8D9rH2zkNCmVuZHN0cmVhbQ0KZW5kb2JqDQoyNyAw\nIG9iag0KPDwvVHlwZS9Gb250L1N1YnR5cGUvVHJ1ZVR5cGUvTmFtZS9GNy9CYXNlRm9udC9Bcmlh\nbC9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcvRm9udERlc2NyaXB0b3IgMjggMCBSL0ZpcnN0Q2hh\nciAzMi9MYXN0Q2hhciAzMi9XaWR0aHMgMjkyIDAgUj4+DQplbmRvYmoNCjI4IDAgb2JqDQo8PC9U\neXBlL0ZvbnREZXNjcmlwdG9yL0ZvbnROYW1lL0FyaWFsL0ZsYWdzIDMyL0l0YWxpY0FuZ2xlIDAv\nQXNjZW50IDkwNS9EZXNjZW50IC0yMTAvQ2FwSGVpZ2h0IDcyOC9BdmdXaWR0aCA0NDEvTWF4V2lk\ndGggMjY2NS9Gb250V2VpZ2h0IDQwMC9YSGVpZ2h0IDI1MC9MZWFkaW5nIDMzL1N0ZW1WIDQ0L0Zv\nbnRCQm94WyAtNjY1IC0yMTAgMjAwMCA3MjhdID4+DQplbmRvYmoNCjI5IDAgb2JqDQo8PC9UeXBl\nL1BhZ2UvUGFyZW50IDIgMCBSL1Jlc291cmNlczw8L0ZvbnQ8PC9GMiA4IDAgUi9GMyAxMyAwIFIv\nRjQgMTUgMCBSL0Y1IDE3IDAgUi9GNiAyMSAwIFIvRjcgMjcgMCBSPj4vRXh0R1N0YXRlPDwvR1Mx\nMiAxMiAwIFIvR1M3IDcgMCBSPj4vUHJvY1NldFsvUERGL1RleHQvSW1hZ2VCL0ltYWdlQy9JbWFn\nZUldID4+L01lZGlhQm94WyAwIDAgNTk1LjQ0IDg0MS45Ml0gL0NvbnRlbnRzIDMwIDAgUi9Hcm91\ncDw8L1R5cGUvR3JvdXAvUy9UcmFuc3BhcmVuY3kvQ1MvRGV2aWNlUkdCPj4vVGFicy9TL1N0cnVj\ndFBhcmVudHMgNT4+DQplbmRvYmoNCjMwIDAgb2JqDQo8PC9GaWx0ZXIvRmxhdGVEZWNvZGUvTGVu\nZ3RoIDIzOTY+Pg0Kc3RyZWFtDQp4nJVaW2/bOBZ+D5D/oEcJGNPiRRfuDgZI0jbbnemgm6ZPxTwo\nieu6TpxsYs8i/37POaQsUiJpB0VSWzo85Ll958LMz563q+/d7Tb79df52Xbb3f5Y3GXf5tePT3/N\nr1+fFvPP3XK16barx838y+5mi4/+tejuFs+//Zadv7vIzq9PT+YfRMY5K1V2/f30hGcl/OPwRDIp\ns0bXrKyz6wegu/zCRbZ8OT0psyV9bey3y9OTb3lW/JVd//v05D2w/O/pyX9OT5D5mF0rWC2IXWhF\n9v7TRTaPSHX+uN0+PsQF+/D4uPUE6/eWpc4qDvsqu3HtbOwRcsUq4dOmxZKguLbNZMt4G19BYmXz\nzyjQp4uP77LSU7/MQK+u7oWWTGVNWbGqskzPixkX+dl5oYH/TOcfC/yJiCFLJmt/vXuoyXF4QGkc\nDC91VreKKWmZnP1ZqPzsj8Js/6WYyeEDnerdGRD8CR+b/HPBef6+aPIrOHljll7Q60v6TPQ+i2ug\nxhWfInIp0TDZ+EdKyiVCchlHrJVm3Cgnm5WsRHvfgoRstPf8gxpbh4uKgUe5HEpanE3WTizLJR/t\n/s1oagFaqvLnQqi826Aybov+09L8Rwo7e7oveJ2v1gWH17BG5y+gvtV4670nKVCZv13MawS4fVv7\ntLTx94LL/PH3YiZ4/vUqtlpXTAp/ddI2cv5Ht1lm+WIzuzwvvHioJlqrKtaCGIKzptlrDY7WgZLu\nOuNNQuc3hSjp2ZI0syp4S0qqQBB4Y4ieFkDwXMxq9xVpe/hq1ntLI2K3FP/eyWjbDf2OLtMNU6Nl\nd+bMP9G+xhvuzfkVmXg9PRJKsyWzoEj00Hzt+q9LQ7TEBw/I7aYLCG+IdrQBUfUfZWvf4aoneni/\nwvOtYbWs4FwzWYK8YSErXmKcekImXUKFwlUqVgN8a8V4s/dgOP/meyHBLelQvxdC5F9TrKsQ64Yz\n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\nb2NTZXRbL1BERi9UZXh0L0ltYWdlQi9JbWFnZUMvSW1hZ2VJXSA+Pi9NZWRpYUJveFsgMCAwIDU5\nNS40NCA4NDEuOTJdIC9Db250ZW50cyAzMiAwIFIvR3JvdXA8PC9UeXBlL0dyb3VwL1MvVHJhbnNw\nYXJlbmN5L0NTL0RldmljZVJHQj4+L1RhYnMvUy9TdHJ1Y3RQYXJlbnRzIDY+Pg0KZW5kb2JqDQoz\nMiAwIG9iag0KPDwvRmlsdGVyL0ZsYXRlRGVjb2RlL0xlbmd0aCAyMTEyPj4NCnN0cmVhbQ0KeJyt\nGdlu20bw3YD/gY8kUK24B48tggB2ErdpEMBN3Cc3D1Sk2IpsSXWkBv777uxB7iy5FFMERZ0VOdfO\nPcP5xdNh/aX5fEhevJhfHA7N5/vVMrmd3+z2n+Y3z/vV/Lq5W2+bw3q3nX88Lg7w6PdVs1w9vXyZ\nXL5+lVzenJ/Nr1hCKclFcvPl/IwmufqPJkUuiKRJJUuSl8nN4/lZntzBn9/Oz27TKvuU3PxxfvZG\n4QONFovmRHAf6zZNPNh/zs/+xBiUcsIVRs1IyaIYyZv3r5J55LqXu8Nh9xi/8dVud0A3DngXVLEW\nk6TlSlF1nfCa0DqOoaVN5tcg5/tXb18nOVI3TyhDuqZFQWqlA1qRorZUGxKoeH4lenilslGB8ZIe\nWp9dVREqMdrFtnnIaJmuv2WV+ZNkMybT62xWp08ZE+nuWybTVTajRQon9Vqml+onM+DbbMZbRJk+\nN/rBnf7xEY6rTKRLONg3GcsVKM0tEXit+XzNZmUKwtQAOexmIucgevTiPQNQZICip5G6ILxISpmD\nYpxGMsbSRl/4YQ26+abOeboGycxRXU4Ime6fQOSdeiRToyThVASvFx7GVgPZBwailOkj/DYKUISO\n+0YdN4bz1qhJE9oAyF1HAcAOykpUn1pIILjSwt9ZGvYSgONk4TmWQpHH5I6aT+hNgQuVJSOFU5i9\nBbB6NOLB8R7EMsdHrUVt82GVDfNiJSd1iXnNorAVkQLDxs0zTIPnlBQBvwY801NOP8rK0Kc4E4QH\nZID1v+p/+Hd7SLIaPEsFA4hz6JHsuSlXt6OYYvQSpSSyxrDPmXCm0M5yp03hVLLEb1TYLuBo3ZKV\nKjC5M+pDZ99tG8fGw0E9nSfpF9rRtvov0UnllFdxldac0Jcqo3QyrEGGzdERn8nO9aORanPVSJQG\nMerjKWmfO+qecgzsRMXRIcVZMkaShWHi4tuA6NsaIQKSWkSnh19jxTjPdVbz1TmaJdlQjbQ2ySvC\nK0uE/p31nLXq59SKsAoj9sOmn4plTTjFaNexaM8LknMMu7J65iY/blSoziqVEo+gaZSSBKi2qqWf\nuLQRlwOJ1aVdYxDAWgRusbGM9ivf0kqC1uM8YHO0GO8gV//1wTicllXDGAmOm/FEbNRVVJJUVT8R\nd/fZd5cKSgutbT3Zfsk4txFi3OzRXcILKIsRMrlbhbdroUsXLc9O8ToUO4F+gUiwkEu/lgGjr7Ee\ngDNCK3xzK4MfwEDCKFidq/SDaVDgaS+uJym60FwNOyN9W7jbTLp23hf2cK3jqgayLDGx0cjk8cgs\nVJ0pXC/KfiAyEeL0yERo16az64ecDjhTD8KQYwPOo/G6lNrm5e8AxNOF8z/FolO6Ryvw0e1drCxK\nQUSJ7xDrJbi6b1Vj2GFmNkW3nrsxBedUInBJYNThhBqlnIv0/TjMFfrRI6hp5ZXDe78gg6jRcG8r\nvKfwiMli8T6qeP82e+wAcNaV8tjWx0jgi4rkxYBiIIPGIk5UqsOXCGk04MSpiU1C7Ikyh3YT6CW5\nmqDVLPL5Nl1MGt2UcwUENPL0+c3D9ea38VKJcMAVf/ao93p9dA2tPmjv34Bk0WGOV1RN01i0UdsU\nJ4Y5qx7OoY2f0kWyckofaSc+AB7pJeH1+MTHhmqPJ8XG6wBdIYR3y64FObaczelh0+iBz4nXmLZU\nOHa6ATCQ7RDo2Ah/HDzRmQvlRdLp9C3owE8iNj1FHJAKHYA+hQ8xWMYIFxg2JhmDNqDGsH6zXJq8\n3J8ICoGUvHQm5VbHy2gqU7UTsWtigEo0Foi27M0B99bEIE+vZBzti2M3XPmltCgj3eu+NW7b8ol4\nRrXW5VUNE6sR1JQITWZ6nRBdOOyPXQetVetem0ZQDDaCBga1gEKawXOgtQtb51IOjbhAIdaodRFl\nFSqC4GlxW6C9edrr/qesS3iRkwJXv65rGh4ThMmxy36tbFNDvJ0KkjiTht0q6tiqqJVIyu+62UAG\nstnESyQDnhBhUEuCtfBW+xNKIrEEIpie8nzsWP4QvCAMM4r2BaoTFxSBjtae8kRfwCtSw5pYwPbF\n0ONT2gFREskx3pROwCyOEdq71tcXUICPUMcOeq8IP+/tBlYv4pQtrzJKzRtTxHVPsFPnwu5guwWu\nrviaEhBXPsd/Uv2XHKSP3r1ng2pS/Wdqymm/KOg8YYJBR65NTsf7IIztaKj90ZRWbzT0PNzUCb9f\nGPN7JqE5xBI1bf6JVgQz/fq5L6JAIaDOIPJu+i312njqvYfaEiCxCDZPOOvT0Y4odOI6tBd8aRIc\nif8izy/py5MTqf3ahC5+IgUz1bjL05vhGWPDxQSeu7KhFOFV6mCrAoA723K1Jrz3XgYdiStRZn3O\n9aq0leQC3NcUds8r7Uv9WWARWLYroEwM+HPUlbnyxFMqVG0N73bKQ8tRT0P7znW0IkI9SV8uNMZ6\nMg4qyG0Z2ia4t5S2tSreczmzt/HxIxtYfnoDK0o1bnKssdHUVg/teeocFgFMhUnliEzbwKq0o9gi\nxOl7HoRmHFArxnzFiSVzxqkasKMsexeWAxdmOSVlZdzNDOvJrJuumylXZ/BBmyMSsfG6d39GJUHc\nb9P3rZf4u4+HLnzaPNA1SOG4hbukSCZXYgvMevyzZj6iPiFJ0akPPnDDbmKq9qoCUfhR7XWooL2Y\nryixSgzra/m49zbxq7YVxtt5/QyNAeH8+/9WhEiqEytCBNtjFmtnKaEco7abxIFPC0yeHhnGF4rW\nMoqvbFdwvqKifhus/yPU64KIGpMf6O7HVgRcjf2SYRKxFp8r36kFho31+JxzGMARbC+s/gNAX2CE\nDQplbmRzdHJlYW0NCmVuZG9iag0KMzMgMCBvYmoNCjw8L1R5cGUvRm9udC9TdWJ0eXBlL1R5cGUw\nL0Jhc2VGb250L1RpbWVzIzIwTmV3IzIwUm9tYW4vRW5jb2RpbmcvSWRlbnRpdHktSC9EZXNjZW5k\nYW50Rm9udHMgMzQgMCBSL1RvVW5pY29kZSAyODcgMCBSPj4NCmVuZG9iag0KMzQgMCBvYmoNClsg\nMzUgMCBSXSANCmVuZG9iag0KMzUgMCBvYmoNCjw8L0Jhc2VGb250L1RpbWVzIzIwTmV3IzIwUm9t\nYW4vU3VidHlwZS9DSURGb250VHlwZTIvVHlwZS9Gb250L0NJRFRvR0lETWFwL0lkZW50aXR5L0RX\nIDEwMDAvQ0lEU3lzdGVtSW5mbyAzNiAwIFIvRm9udERlc2NyaXB0b3IgMzcgMCBSL1cgMjg5IDAg\nUj4+DQplbmRvYmoNCjM2IDAgb2JqDQo8PC9PcmRlcmluZyhJZGVudGl0eSkgL1JlZ2lzdHJ5KEFk\nb2JlKSAvU3VwcGxlbWVudCAwPj4NCmVuZG9iag0KMzcgMCBvYmoNCjw8L1R5cGUvRm9udERlc2Ny\naXB0b3IvRm9udE5hbWUvVGltZXMjMjBOZXcjMjBSb21hbi9GbGFncyAzMi9JdGFsaWNBbmdsZSAw\nL0FzY2VudCA4OTEvRGVzY2VudCAtMjE2L0NhcEhlaWdodCA2OTMvQXZnV2lkdGggNDAxL01heFdp\nZHRoIDI2MTQvRm9udFdlaWdodCA0MDAvWEhlaWdodCAyNTAvTGVhZGluZyA0Mi9TdGVtViA0MC9G\nb250QkJveFsgLTU2OCAtMjE2IDIwNDYgNjkzXSAvRm9udEZpbGUyIDI4OCAwIFI+Pg0KZW5kb2Jq\nDQozOCAwIG9iag0KPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9SZXNvdXJjZXM8PC9Gb250PDwv\nRjIgOCAwIFIvRjMgMTMgMCBSL0Y0IDE1IDAgUi9GNSAxNyAwIFIvRjYgMjEgMCBSL0Y3IDI3IDAg\nUj4+L1Byb2NTZXRbL1BERi9UZXh0L0ltYWdlQi9JbWFnZUMvSW1hZ2VJXSA+Pi9NZWRpYUJveFsg\nMCAwIDU5NS40NCA4NDEuOTJdIC9Db250ZW50cyAzOSAwIFIvR3JvdXA8PC9UeXBlL0dyb3VwL1Mv\nVHJhbnNwYXJlbmN5L0NTL0RldmljZVJHQj4+L1RhYnMvUy9TdHJ1Y3RQYXJlbnRzIDc+Pg0KZW5k\nb2JqDQozOSAwIG9iag0KPDwvRmlsdGVyL0ZsYXRlRGVjb2RlL0xlbmd0aCAyNzkzPj4NCnN0cmVh\nbQ0KeJy1W91v20YSfzfg/4GPYlFR3A8ul4eiQBI3d7lciqR1cA9BH+hIllXFss6VcMh/fzOzS3KX\ny6Vo2YcitkXNzsdvZmdmudPFq8fD5rb+ekh++mnx6nCov96tlsmXxfXD/o/F9ff9avGxXm929WHz\nsFv8frw54KN/rOrl6vHnn5PXV2+S19eXF4u3PGEsy2VyfXt5wZIc/mNJkcusYklZqSxXyfX95UWe\nrPHH3y8vvsx0+kdy/c/Li19gPfJoV7E8k8Jd9WWWOLT/ubz45K9gTGQCVmieKR5dkfzy4U2yiJj7\n+uFweLiPW/z24eHgWdyTXTAQLSdpKwAorROhM6bjK0jbZPER9fzw5t1Vkntwi4RxD2smZKaqpGRl\n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\n+uB2R7R4oH14UbNsfxSaFe2PzpVD/VEo54n90fOcpyApxPujaG9ynlCRC6yUgdApvUnV600gM3Y9\nBZXNfmtCFG1n4pN05TvGxDYmRNH1JR6NU+K9XiIgss2c25V4NE4bEGdkDbfIDzYlDQXDC+ZhsyaQ\nGPgsySh+Y7o0FCOCDMSWZBxjR9JAh9QStcJGPNEYNuqKcXkt0ai8aVTh3X1+4vJeF5koaFqmipbi\nkCsbvN6uqOXCKRX7OvYjDi+095FmKKq7vQ1vm+bKuzHzL3vx0uUZV9yqcm/g7v5bp2ra5A94yzPK\nnd1Q4fAGmrCp11iwglnCoTkg2ENMeAKiY0Alxwszl3R8UEq0gw6RazxzFyhwEsSd99m5N2MsuONe\nbiL8sMHEGHX4OSOExGrZmyukhxQhJPN+g/MQ1mWG3PFhbD6H4cnAlbofH+VxSb3QwYk1kks+xs92\nPC02Y8bxWrZjF7nAjIVWofvLaa176Qi69AIMUWnja8KAjJQlzqx48Dhb0sK/f0b8cJyKsazfYYDs\nblPoF81d6nscr/kcDRiaPnAZ/BYjZQVdcTmk0YDgNKnrkkaG4ThNn4CaDI6fdmJVD41amqkb/G5o\nPAGf3wwOJ3RjmUjj4t4JGhASekTOeoNBzaBHs20g0e7sjO64syBm89JJH+3EhOgP9XHdXZKDFnek\nbRR0mWML2GMfo8Xy7NNaQ1qbd1aBK3he2kdOFRC5DS0TZT7mPlTIZdkbQ4VHnz9gI/z+Q3RKTuDM\npadjOyjsjEt1k4Dr7UiyGtj+Ulc4DuZJsLUF2fQnbwa2tv0/EjwOp9yPLdgk98d2rERZHpv9QA4F\noGwOJZbRSIDjUeFzi40tcjAAX8W5tONNCh9qUky/wyqV6WlcBif5LBdQCQ53U7jIES6SZSrK5X9D\n2FXpDQplbmRzdHJlYW0NCmVuZG9iag0KNDAgMCBvYmoNCjw8L1R5cGUvUGFnZS9QYXJlbnQgMiAw\nIFIvUmVzb3VyY2VzPDwvRm9udDw8L0YyIDggMCBSL0Y1IDE3IDAgUi9GNyAyNyAwIFIvRjYgMjEg\nMCBSL0YzIDEzIDAgUi9GNCAxNSAwIFI+Pi9FeHRHU3RhdGU8PC9HUzEyIDEyIDAgUi9HUzcgNyAw\nIFI+Pi9YT2JqZWN0PDwvSW1hZ2U0MiA0MiAwIFI+Pi9Qcm9jU2V0Wy9QREYvVGV4dC9JbWFnZUIv\nSW1hZ2VDL0ltYWdlSV0gPj4vTWVkaWFCb3hbIDAgMCA1OTUuNDQgODQxLjkyXSAvQ29udGVudHMg\nNDEgMCBSL0dyb3VwPDwvVHlwZS9Hcm91cC9TL1RyYW5zcGFyZW5jeS9DUy9EZXZpY2VSR0I+Pi9U\nYWJzL1MvU3RydWN0UGFyZW50cyA4Pj4NCmVuZG9iag0KNDEgMCBvYmoNCjw8L0ZpbHRlci9GbGF0\nZURlY29kZS9MZW5ndGggMjU0ND4+DQpzdHJlYW0NCnictVrdb9tGDH8PkP9Bj9KwyLpP6YZhQNKs\nXbZ16NYUewj24MSOm7mx09Ye0P9+5H1I9yHJTuIggGNLPJJH8sgf725y+mVzdzu92WQ//jg53Wym\nNx/ns+xqcrl++Gdy+e1hPnk3Xdytppu79Wryfnu9wUe/zKez+ZeffsrOzl9lZ5fHR5PXNCOkrHh2\neXt8RLIK/kgmKl4qktVKlpXMLu+B7s17QrPF1+OjKlvon7X99eb46CpXxT/Z5a/HRz8DS2TbMiJV\nyZnP6CrPPNrPx0d/hiMIYSWDEQ0tJR0ckf389lU2GbDA2XqzWd8PG+H1er0JjBDJFgRE8720ZWC7\npslYU5JmeITWNpu8Qz3fvro4z6rJ79PVIsvvZicX50XgDpGBnX1fUF6V6JGm5M6Cb6bFCWH5fUGa\n/LqgVT4teP6lOJGBbF9P2uCcQi7Eo000JD3moU1dSh4yKYsTBVLh48PXgpB8Dpron6+KWqv1tVDd\nw3PQu87vUG98t9A642QETGZEG9qjDWtYKWWoTTbGhPV5nBH0OK+rsm40k+ykKtH5N1f5dRlZc/K6\njr1DwDtcBAwqPTj2RI9nCVeR8Kv8fK5de1vAh7bTCn4r8/UrfK3M15S7TLirqmzqkHuvj5C/8dJO\njSmTZc1DnqM25302r+uSqIxzVhLnuNOC0nyGMfGw1QqtMKxBSUZV/qDDZO0pasIKX3OVfzMrAINI\nj1rYYZvihJrJwngq838LZsJu1pnUSdCPp8Yu+MCYGscaLm3IPuxheaYoZrtggltvHaCAG63vtHu6\n0/bIjpKQa6K3VlFP7xOoLPOlsQtMhw1ETusVIcoGgpGIUjj2nqH+xY+5ZvbJ2QKVX2oSz/o6sAK9\nnCfwp85Wjg3T9get7VPnqDt8s9yaUT8MZTQoKbUM9R0NRTGUcyMLMMhyynG8LE6aAcUHzNikTOiY\n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\n+TpzIPR/la+iZA0KZW5kc3RyZWFtDQplbmRvYmoNCjQyIDAgb2JqDQo8PC9UeXBlL1hPYmplY3Qv\nU3VidHlwZS9JbWFnZS9XaWR0aCA1NTYvSGVpZ2h0IDM1MS9Db2xvclNwYWNlL0RldmljZVJHQi9C\naXRzUGVyQ29tcG9uZW50IDgvSW50ZXJwb2xhdGUgZmFsc2UvRmlsdGVyL0ZsYXRlRGVjb2RlL0xl\nbmd0aCAyODY2Mz4+DQpzdHJlYW0NCnic7J1/TGTXefdX1Uql7VadlWiFVKwXd7GLHdaZJOOGOEQZ\nJ3SDHRqht1hLlUlCKqRie9IlDrGIjYKTySti05ZItCEtqqYKVmlf0vIH2pIIJ0hd1UjFCuulLW6o\nRZ11S2y8WSfEXtvs7ryfzPPu6c3MMMzc33d4PrKsu5d7zz1z7z3P93nuOec5uZyiKIqiKIqiKIqi\nKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqiKIqi\nKIqiKIqiKIqiKEo5jiiKoihuELQ5jyR63xRFUZyjttQeet8URVGco7bUHnrfFEVRnKO21B563xRF\nUZyjttQeet8URVGco7bUHnrfFEVRnKO21B563xRFUZyjttQeet8URVGco7bUHnrfFEVRnKO21B56\n3xRFUZyjttQeet8URVGco7bUHnrfFEVRnKO21B6Rvm+7u7tra2uzs7MjIyM9PT3JPO3t7U1FtLW1\nyV85bHh4mFNWV1c5PehfoChhoWRrouFoa6qQSNvSAIncfaOZTExMdHd30xZisVgikejt7R0dHaUh\nLOc5d+7cVhHslL9yWCaTSaVSnMjpjY2NXV1dY2NjKysre3t7Qf84RfEVbU0uEjlbGhIicd+2t7cn\nJydpKbzn8Xgc12txcZGdzkve2dmhKArEtaPwzs5OWtDFixedl6wo4URbk0dEwpaGkJDfN15p4v36\n+vqBgYH5+fnLly97d63d3V0ukU6nGxoacOcWFhYOoS+n1DDamjwl5LY0tITzvl25cmViYkK+PGez\nWf7p89VnZ2eTyWRjY2Mmk/H56oriLtqa/CGctjT8hPC+zc3NNTc39/b2rq+vB1uTjY2Nvr4+2s7M\nzEywNVEUe2hr8o0Q2tJIEKr7RjPBX0okEufOnQu6Lv/D6upqe3s7PiQbQddFUSpFW5PPhMqWRojw\n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', '', '103.160.118.2', 1641955654, 0.899121, '1', 200);
INSERT INTO `logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `rtime`, `authorized`, `response_code`) VALUES
(80, 'notifikasi/insert', 'post', 'a:14:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:3:"211";s:11:"id_pengirim";s:32:"6E68174FDB2AA961DA7FC2664F7EA6D5";s:15:"token_disposisi";s:0:"";s:16:"pesan_notifikasi";s:21:"Ada draft agenda baru";s:12:"token_agenda";s:32:"59C9E20F6B501B60A3C6274EAA60C17A";s:11:"id_penerima";s:32:"B6A6F83CC282E4FD98345162757D9CE3";s:15:"tipe_notifikasi";s:2:"SM";}', '', '103.160.118.2', 1641955655, 0.00868416, '1', 200),
(81, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955655, 0.0160239, '1', 200),
(82, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955655, 0.014195, '1', 200),
(83, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955655, 0.00977111, '1', 200),
(84, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955655, 0.00957203, '1', 200),
(85, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955871, 0.00636697, '1', 200),
(86, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955885, 0.0163219, '1', 200),
(87, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641955885, 0.00903916, '1', 200),
(88, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"11176132";}', '', '103.160.118.2', 1641955893, 0.00601387, '1', 200),
(89, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"11176132";}', '', '103.160.118.2', 1641955969, 0.013077, '1', 200),
(90, 'signin/login', 'post', 'a:10:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:2:"41";s:8:"password";s:9:"Asd@12345";s:8:"username";s:10:"ajudan_gub";}', '', '103.160.118.2', 1641956035, 0.28557, '1', 200),
(91, 'signin/log_session', 'post', 'a:12:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:3:"272";s:9:"device_id";s:152:"dFlzbcIwwWQ:APA91bG4FKgqztaedipp4-ttYBsDoNfc1OUwnSkFoftEls2nscWZrpTXvIfEU2sFrJNcxnhwkmc8ovhs5E9fwGmgIjlyJfUhfkdbUGrzHarT14rOaqsZsbTjLhW9Xq-94zMqq_U8-BJy";s:12:"device_model";s:32:"Google Android SDK built for x86";s:7:"id_user";s:32:"6E68174FDB2AA961DA7FC2664F7EA6D5";s:8:"username";s:10:"ajudan_gub";}', '', '103.160.118.2', 1641956035, 0.00692105, '1', 0),
(92, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956036, 0.0138512, '1', 200),
(93, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956036, 0.0150309, '1', 200),
(94, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956036, 0.0104821, '1', 200),
(95, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956036, 0.010252, '1', 200),
(96, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956038, 0.00658298, '1', 200),
(97, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956058, 0.0161991, '1', 200),
(98, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956058, 0.010453, '1', 200),
(99, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"11176124";}', '', '103.160.118.2', 1641956068, 0.00670409, '1', 200),
(100, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956249, 0.014173, '1', 200),
(101, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956249, 0.0155609, '1', 200),
(102, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956249, 0.0112259, '1', 200),
(103, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956249, 0.011008, '1', 200),
(104, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956264, 0.012676, '1', 200),
(105, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956264, 0.0141389, '1', 200),
(106, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956264, 0.0116441, '1', 200),
(107, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956264, 0.0142479, '1', 200),
(108, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956264, 0.00669599, '1', 200),
(109, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956285, 0.00956702, '1', 200),
(110, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:48:"application/x-www-form-urlencoded; charset=UTF-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"11176115";}', '', '103.160.118.2', 1641956289, 0.00602698, '1', 200),
(111, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956289, 0.014117, '1', 200),
(112, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956301, 0.017312, '1', 200),
(113, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956301, 0.00814199, '1', 200),
(114, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956344, 0.0151129, '1', 200),
(115, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641956344, 0.00911188, '1', 200),
(116, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957000, 0.0182328, '1', 200),
(117, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957000, 0.010592, '1', 200),
(118, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957009, 0.010792, '1', 200),
(119, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957009, 0.0148201, '1', 200),
(120, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957126, 0.0135579, '1', 200),
(121, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957126, 0.00744414, '1', 200),
(122, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957126, 0.0104241, '1', 200),
(123, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957126, 0.00868917, '1', 200),
(124, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957128, 0.00676703, '1', 200),
(125, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957153, 0.0149891, '1', 200),
(126, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957153, 0.0105321, '1', 200),
(127, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957215, 0.0124159, '1', 200),
(128, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957215, 0.0110309, '1', 200),
(129, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957215, 0.00862908, '1', 200),
(130, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957215, 0.00766397, '1', 200),
(131, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957217, 0.0064261, '1', 200),
(132, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957235, 0.0114429, '1', 200),
(133, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641957235, 0.0112119, '1', 200),
(134, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959375, 0.0208809, '1', 200),
(135, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959375, 0.0189269, '1', 200),
(136, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959385, 0.0106459, '1', 200),
(137, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959385, 0.00845408, '1', 200),
(138, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959412, 0.0110149, '1', 200),
(139, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959412, 0.0141139, '1', 200),
(140, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959412, 0.00847507, '1', 200),
(141, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959412, 0.00573587, '1', 200),
(142, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959417, 0.00455809, '1', 200),
(143, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959451, 0.00678802, '1', 200),
(144, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959451, 0.00864506, '1', 200),
(145, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959463, 0.0156519, '1', 200),
(146, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959463, 0.013828, '1', 200),
(147, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959463, 0.00650311, '1', 200),
(148, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959463, 0.008214, '1', 200),
(149, 'draft/list_penerima_agenda', 'get', 'a:6:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641959657, 0.00409698, '1', 200),
(150, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641960267, 0.0119789, '1', 200),
(151, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641960267, 0.0107331, '1', 200),
(152, 'draft/list_draft', 'get', 'a:7:{s:8:"id_group";s:3:"AJD";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641960267, 0.015763, '1', 200),
(153, 'agenda/list_agenda', 'get', 'a:8:{s:13:"status_agenda";s:2:"SH";s:12:"jenis_agenda";s:1:"P";s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";}', '', '103.160.118.2', 1641960267, 0.00793195, '1', 200),
(154, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:31:"application/json; charset=utf-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"10577030";}', '', '103.160.118.2', 1641960275, 0.00521183, '1', 200),
(155, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:31:"application/json; charset=utf-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"10577030";}', '', '103.160.118.2', 1641960279, 0.00734591, '1', 200),
(156, 'draft/insert_draft', 'post', 'a:8:{s:13:"Authorization";s:30:"Basic TnRhaGxhaDpBc2RAMTIzNDU=";s:14:"xxx-agenda-key";s:39:"6595E94DFE54F61849C5CA2983A77AC4P6HAGDK";s:12:"Content-Type";s:31:"application/json; charset=utf-8";s:10:"User-Agent";s:87:"Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)";s:4:"Host";s:25:"testing2.sumbarprov.go.id";s:10:"Connection";s:10:"Keep-Alive";s:15:"Accept-Encoding";s:4:"gzip";s:14:"Content-Length";s:8:"10577030";}', '', '103.160.118.2', 1641960296, 0.004498, '1', 200);

-- --------------------------------------------------------

--
-- Table structure for table `master_opd`
--

CREATE TABLE IF NOT EXISTS `master_opd` (
  `id_opd` int(11) NOT NULL,
  `kode_opd` varchar(255) NOT NULL,
  `nm_opd` varchar(255) NOT NULL,
  `order_no` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12401 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_opd`
--

INSERT INTO `master_opd` (`id_opd`, `kode_opd`, `nm_opd`, `order_no`, `parent_id`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`, `id_status`) VALUES
(2, '4.00.01.01.', 'SEKRETARIAT DAERAH', 2, 1, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(5, '4.00.01.01.01.', 'BIRO PEMERINTAHAN', 2, 1, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(6, '4.00.01.01.03.', 'BIRO HUKUM', 3, 0, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(7, '4.00.01.01.02.', 'BIRO HUMAS', 4, 0, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(8, '4.00.01.01.04.', 'BIRO PEREKONOMIAN', 5, 0, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(9, '4.00.01.01.05.', 'BIRO BINA MENTAL DAN KESEJAHTERAAN RAKYAT', 6, 0, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(10, '4.00.01.01.06.', 'BIRO KERJASAMA PEMBANGUNAN DAN RANTAU', 7, 0, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(11, '4.00.01.01.07.', 'BIRO ORGANISASI', 8, 0, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(12, '4.00.01.01.09.', 'BIRO ADMINISTRASI PENGADAAN DAN PENGELOLAAN BMD', 9, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(13, '4.00.01.01.08.', 'BIRO UMUM', 10, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(14, '4.00.02.01.', 'SEKRETARIAT DEWAN', 11, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(15, '3.00.01.01.', 'INSPEKTORAT', 12, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(16, '3.00.02.01.', 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', 13, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(17, '3.00.04.01.', 'BADAN KEPEGAWAIAN DAERAH', 14, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(18, '3.00.05.01.', 'BADAN PENGEMBANGAN SUMBER DAYA MANUSIA', 15, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(19, '3.00.03.02.', 'BADAN KEUANGAN DAERAH', 16, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(20, '3.00.06.01.', 'BADAN PENELITIAN DAN PENGEMBANGAN', 17, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(21, '3.00.07.01.', 'BADAN PENGHUBUNG', 18, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(22, '5.00.01.02.', 'BADAN PENANGGULANGAN BENCANA DAERAH', 19, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(23, '5.00.01.01.', 'BADAN KESATUAN BANGSA DAN POLITIK', 20, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(24, '1.01.01.01.', 'DINAS PENDIDIKAN', 21, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(25, '1.01.02.01.', 'DINAS KESEHATAN', 22, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(26, '1.01.03.01.', 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG', 23, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(27, '1.01.03.02.', 'DINAS PENGELOLAAN SUMBER DAYA AIR', 24, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(28, '1.01.04.01.', 'DINAS PERUMAHAN RAKYAT, KAWASAN PERMUKIMAN DAN PERTANAHAN', 25, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(29, '1.01.06.01.', 'DINAS SOSIAL', 26, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(30, '1.02.01.01.', 'DINAS TENAGA KERJA DAN TRANSMIGRASI', 27, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(31, '1.02.03.01.', 'DINAS PANGAN', 28, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(32, '1.02.02.01.', 'DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK', 29, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(33, '1.02.05.01.', 'DINAS LINGKUNGAN HIDUP', 30, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(34, '1.02.07.01.', 'DINAS PEMBERDAYAAN MASYARAKAT DESA', 31, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(35, '1.02.08.01.', 'DINAS PENGENDALIAN PENDUDUK, KB DAN DUKCAPIL', 32, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(36, '1.02.09.01.', 'DINAS PERHUBUNGAN', 33, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(37, '1.02.10.01.', 'DINAS KOMUNIKASI DAN INFORMATIKA', 34, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(38, '1.02.11.01.', 'DINAS KOPERASI USAHA KECIL DAN MENENGAH', 35, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(39, '1.02.12.01.', 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', 36, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(40, '1.02.13.01.', 'DINAS PEMUDA DAN OLAHRAGA', 37, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(41, '1.02.16.01.', 'DINAS KEBUDAYAAN', 38, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(42, '1.02.18.01.', 'DINAS KEARSIPAN DAN PERPUSTAKAAN', 39, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(43, '2.00.01.01.', 'DINAS KELAUTAN DAN PERIKANAN', 40, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(44, '2.00.02.01.', 'DINAS PARIWISATA', 41, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(45, '2.00.03.01.', 'DINAS TANAMAN PANGAN, HORTIKULTURA DAN PERKEBUNAN', 42, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(46, '2.00.03.02.', 'DINAS PETERNAKAN DAN KESEHATAN HEWAN', 43, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(47, '2.00.04.01.', 'DINAS KEHUTANAN', 44, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(48, '2.00.05.01.', 'DINAS ENERGI DAN SUMBER DAYA MINERAL', 45, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(49, '2.00.07.01.', 'DINAS PERINDUSTRIAN DAN PERDAGANGAN', 46, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(50, '1.01.05.01.', 'SATUAN POLISI PAMONG PRAJA DAN PEMADAM KEBAKARAN', 47, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(51, '1.01.02.02.', 'RS DR ACHMAD MOCHTAR BUKITTINGGI', 48, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(52, '1.01.02.07.', 'RSUD PARIAMAN', 49, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(53, '1.01.02.06.', 'RSUD M NATSIR', 50, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(54, '1.01.02.03.', 'RSJ HB SAANIN PADANG', 51, 0, '2', '2020-06-08 14:32:32', '', '', '0000-00-00 00:00:00', '', 1),
(1, '1', 'PROVINSI SUMATERA BARAT', 1, 0, '2', '2020-06-08 14:32:31', '', '', '0000-00-00 00:00:00', '', 1),
(55, '', 'Sekretariat', 1, 37, 'ntahlah', '2020-09-03 10:00:59', '::1', 'ntahlah', '2020-09-03 10:00:59', '::1', 1),
(56, '', 'BIDANG PENGELOLAAN INFORMASI DAN KOMUNIKASI PUBLIK', 1, 55, 'ntahlah', '2020-09-04 11:25:59', '::1', 'ntahlah', '2020-09-04 11:25:59', '::1', 1),
(57, '', 'BIDANG PENGELOLAAN INFRASTRUKTUR TIK/PENYELENGARAAN E-GOVERNMENT', 2, 55, 'ntahlah', '2020-09-04 11:26:16', '::1', 'ntahlah', '2020-09-04 11:26:16', '::1', 1),
(58, '', 'BIDANG LAYANAN KOMUNIKASI &amp; INFORMATIKA', 3, 55, 'ntahlah', '2020-09-04 11:26:31', '::1', 'ntahlah', '2020-09-04 11:26:31', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_status`
--

CREATE TABLE IF NOT EXISTS `master_status` (
  `id_status` varchar(2) NOT NULL,
  `nm_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_status`
--

INSERT INTO `master_status` (`id_status`, `nm_status`) VALUES
('CC', 'Diterima'),
('LK', 'Ditolak'),
('SH', 'Dihadiri'),
('SM', 'Menunggu Verifikasi'),
('SW', 'Diwakilkan');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_ci_captcha`
--

CREATE TABLE IF NOT EXISTS `xi_sa_ci_captcha` (
  `captcha_id` int(11) NOT NULL,
  `captcha_time` int(11) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_ci_captcha`
--

INSERT INTO `xi_sa_ci_captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(2, 1609994673, '::1', 'HxVES'),
(3, 1609994686, '::1', 'TluXo');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_ci_session`
--

CREATE TABLE IF NOT EXISTS `xi_sa_ci_session` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_ci_session`
--

INSERT INTO `xi_sa_ci_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('00k4gq8ko93sqdpqeo99hpsr86to9i6p', '194.233.78.120', 1642893150, ''),
('03rfp87p5tgjtau0f3h6rg890u3sbj2e', '183.136.226.3', 1642972920, ''),
('0b0pd0e7vcnq95n89rn1sv1rnsm4hhst', '10.5.49.77', 1642899605, ''),
('0beuqo4rupp878nbtu5i6snk2c0pl08l', '45.146.165.37', 1642993439, ''),
('0fsecfl3vt180m9bab9hpjaocn4kco7q', '52.53.234.196', 1642824668, ''),
('0ittc57gpcdi2nieuiabmq4qsfhmusbk', '193.118.53.210', 1642948165, ''),
('0oa62kek8f2t2fnafekijkv8m8hoebv1', '4.17.224.134', 1642877280, ''),
('0slm1tq74gf6huk0su7bsfcll24nfkh2', '171.25.193.20', 1642914921, ''),
('0uhgfncerb8fh648gra01j1ie63n9n8m', '45.146.165.37', 1642856968, ''),
('124h6e8h8fvh0o2pvnfkksbvtq8v0fm8', '194.233.78.120', 1642893150, ''),
('16c4qdbd2hck6m3r3hemju3k4b3io3dj', '194.233.78.120', 1642893150, ''),
('1fcd32kr2q7v00ni53iha4k61dsp5do3', '88.80.186.144', 1642882324, ''),
('1g0l0o6fvcdf3l90b46v8muq9ql41s3m', '45.146.165.37', 1642934366, ''),
('1i6rhqcvirg1eqev5ui3s5poije7878l', '45.146.165.37', 1642904140, ''),
('1l79an3ackvk01b1dkt4igv3rcu3tnbc', '74.82.47.3', 1642898642, ''),
('1o4288i4uacfs878eo4olgl9ptu7rnbe', '88.80.186.144', 1642882333, ''),
('1rmih7s6s5vsgt719jfr1te8i6nkerm5', '194.233.78.120', 1642893151, ''),
('1t82akc40g71andl0klmuvnad6tm1lm6', '194.233.78.120', 1642893149, ''),
('1uu376n9kmke7kajcmopde7sclfea2e2', '103.136.249.66', 1642818332, ''),
('1v41lqd6mh8podsamsml79ecj1hpnuqd', '163.172.102.84', 1642928109, ''),
('278899js6qldbchph5mjbarbhkbcmkes', '172.70.12.5', 1642920476, ''),
('2b01lmld2om6u99uvc2cc3vps00u77vd', '128.1.248.26', 1642887120, ''),
('2hgnnas91hb5pitlo803dn5upu4ponkf', '88.80.186.144', 1642882331, ''),
('2lea2pojnglvarmceiljfn236oldp8jk', '167.94.138.59', 1642841534, ''),
('2nsa67iis5olmd61lm1o2e5qc9k4788b', '194.233.78.120', 1642893150, ''),
('2o23qb5an0gpmb3ud7r1sc01ibqho9hl', '45.146.165.37', 1642926425, ''),
('2v6up23hrsj275co4hc1irm0dl87cu4q', '163.172.102.84', 1642928109, ''),
('30v9deug0rq7j753917abqjarqag7s4o', '89.248.165.52', 1642984605, ''),
('32i4d0f9f1c0d5gak19fifnhk2cv174c', '89.248.165.52', 1642965636, ''),
('351gck8qfq12gho3e5dvk8s4lamhloso', '52.229.96.169', 1642967499, ''),
('357ff1h90img0iil9duv7rgv50jn94s3', '10.5.49.77', 1643001126, ''),
('3ao2mpibpb72r3imk7846urium6fmmpt', '45.146.165.37', 1642848301, ''),
('3lgnpbs577g3obq11p8ps9itrvjbtcti', '128.1.248.42', 1642998943, ''),
('3m5f9fr681klqo92phbnoujmhl286hib', '45.146.165.37', 1642919722, ''),
('3mpi1cqj6loj3atv865hkdak9dl9pr0d', '45.146.165.37', 1642943980, ''),
('3ns56ljd8nedjb9rd8q62k56ilnp5hja', '88.80.186.144', 1642882324, ''),
('3pbcd10lf7bn99ml2i2iovl1t2vbgnga', '88.80.186.144', 1642882335, ''),
('3pn23hcous8g561ppn54e6ba46n3huh9', '88.80.186.144', 1642882325, ''),
('3scc3jbnj2pnk0arqtpg485ef56kfsam', '165.227.157.133', 1642946275, ''),
('40jqpd4ke1408eb0bgj5jt6pnjco7chg', '88.80.186.144', 1642882324, ''),
('450g2gdqf41b781s75v8nl80ncn1f8jt', '37.49.225.117', 1642877249, ''),
('48s2m2m2ocjt0sreplqtnlthu7eagj2r', '174.50.177.139', 1642816397, ''),
('49gut0ptl6ls14gclpvshqioneu5a34b', '88.80.186.144', 1642882328, ''),
('4gho6qr2hncviv9tsekf7e890bo30a3m', '174.50.177.139', 1642816404, ''),
('4ia158b8mcl03drd1t8nbhcsj3u5fmgs', '107.189.29.181', 1642880819, ''),
('4jo55gm401aihtu46c5ovd7mk3uk1cmg', '174.50.177.139', 1642816390, ''),
('4t5a6bvrbfh9e2j9gdb2fukl0mg2ivtv', '45.146.165.37', 1642892991, ''),
('5076mq684a9rrvbciapodrrec8pj7noq', '107.189.29.181', 1642971377, ''),
('53hffu42fqc0grp1i2lsmvm61ps1lvlt', '51.222.228.129', 1642883575, ''),
('543b7ap5qfot2021v90qj3ropilbf2vt', '10.5.49.77', 1642899605, ''),
('55tjpl8afjtiasbv3i1gscbf16csh2ld', '5.8.10.202', 1642894017, ''),
('57be5qja31v6q6997lavru8pb713k48g', '194.233.78.120', 1642893149, ''),
('57r59ahb0q1vqqe6o5kndie989e3m4kq', '194.233.78.120', 1642893150, ''),
('5bks5aq0tohabtu2udp8da9ibqhke5d3', '27.43.207.67', 1642966388, ''),
('5fqm90hbc74dkoj2ifemaqo3f90gs2fj', '104.140.188.38', 1642873077, ''),
('5iu1d7m74ct2d3r6e91m6mh2ci5qdhnk', '107.189.29.181', 1642905339, ''),
('5jcv1sk240n0aolin01s1d6sisk1s39q', '194.233.78.120', 1642893150, ''),
('5kfru3d78pdafeev5b72k9et8dp0bbjp', '174.50.177.139', 1642816405, ''),
('5m3v54531hktnbn30on5ulqplnpi9ort', '107.189.12.178', 1642850160, ''),
('5mpgo9bmtau06bfphc7ec8ppdt3g0tho', '45.146.165.37', 1642870735, ''),
('5nd4pl6if759b6kdjhaasfb75jl2j8tq', '88.80.186.144', 1642882327, ''),
('5pflhoseabjpabpqh76iatqf730dn9om', '107.189.28.51', 1642895781, ''),
('5sa3shi8017v9nr8c5k1ogh2u6pggh07', '107.189.28.51', 1642942157, ''),
('6b11apjuqpfnblvsiovjk5smd8gc9s9l', '85.202.169.88', 1642876199, ''),
('6hhqpbao1dd0o6r4k6u7lnlod50igvml', '163.172.102.84', 1642928110, ''),
('6jj4i98orr2c5onumjvnhl8m1hj9mgfm', '5.255.99.110', 1642892469, ''),
('6kjkt2tamphooh9rluetrhj70cdm9msv', '174.138.40.190', 1642850878, ''),
('6orsv7je9s6ot9m1cst1a9lasb9gfgv8', '194.44.56.66', 1642955319, ''),
('703e1g8hlu2o73qgrfdn1lqu6nsn63gv', '192.241.203.17', 1642899723, ''),
('73r57ti6upo5107s0i41drubinjidqcl', '5.199.143.202', 1642914920, ''),
('7cc50flloe5mur8bau8s755c4rhut0h0', '185.168.41.189', 1642844775, ''),
('7f6bqsi307eofkh0vnd3flptqirj2phh', '10.5.49.77', 1642929145, ''),
('7h5umltj4og0ohv9onp313j9omk52gk2', '37.49.225.117', 1642877250, ''),
('7iknivv51h7bhuu4h55bkjiot30aa3r5', '107.189.29.181', 1642979056, ''),
('7mca2lhgp3t0ns81ai6mda9cj8m34t36', '107.189.29.181', 1642880820, ''),
('7mhneueu6ggmq8mr23crk51co1lrt4bn', '89.248.165.52', 1642984606, ''),
('7n5upjppifhv7ijji6euaft4cvpt67fe', '107.189.29.181', 1642880112, ''),
('7pj9f1n9dukr6npa4qondq3kp93qc19h', '130.211.54.158', 1642955809, ''),
('7pmjn3e1hcqkqi6k7qih5tg0s6m22uu7', '88.80.186.144', 1642882327, ''),
('7usb0gvc9s4vfu26uc40ck4u8k6ufh3o', '107.189.29.181', 1642943141, ''),
('80p6dsn5labm7nrf2ldq88gr6sbnvj87', '128.199.160.152', 1642965061, ''),
('84pl731e87h2cnslv80da0vjc4scbvjj', '45.137.21.134', 1642944902, ''),
('8b3i3qmn7elf4529p523cuum10v5lhva', '10.5.49.77', 1642929144, ''),
('8e7p1kqfts4moqdu5nb92v0lcro4q11b', '5.8.10.202', 1642850235, ''),
('8fm5e8ubnfvjf4oqdufa3fcl0lb9han3', '174.50.177.139', 1642816389, ''),
('8ke3csdbj7afkk2dsvfcgih1v8u6342q', '5.8.10.202', 1642894021, ''),
('8l33k1t0gb23dughp6dnpjullk8sl3dr', '182.180.104.47', 1642932180, ''),
('8mbun48lql54r32s1amnn28oo0chsbkp', '45.146.165.37', 1642996137, ''),
('8qeaea85a3ld0qvcs649r6g3eori06d5', '109.237.103.38', 1642836598, ''),
('8qj4j1lroh22nocrq703q0sncegaaq1f', '192.241.207.167', 1642972939, ''),
('8r2qtmrob0ho2e0u3ktbfouob3s3geeu', '88.80.186.144', 1642882323, ''),
('8t2t9rk629urpe7a4n7oehkkd8brm5me', '185.168.41.189', 1642844773, ''),
('8tbhd9q0njk7c6vjrmd2b3j55i65ofir', '216.218.206.69', 1642821420, ''),
('92bet7vc73alt5tivcqac4hdnkti72cf', '10.5.49.77', 1642986002, ''),
('97mmbacas9tt41jtiir54tv81u9481ho', '109.237.103.38', 1642989635, ''),
('9aq6mu0fj3tv83qrmvmj93nq78qp9d9d', '128.1.248.26', 1642984857, ''),
('9c09bo137u5th4jd5quls01d4a00nges', '154.89.5.77', 1642960072, ''),
('9f9k8rvq5dk3ididpoh2pg6qr0g8tksp', '10.5.49.77', 1642828287, ''),
('9hvi377sbcd1u3umh3meshtp37mgm0uq', '88.80.186.144', 1642882332, ''),
('9q09p2bqq7dfhrb7ud3aisos93m86jk8', '194.233.78.120', 1642893150, ''),
('9r7dj2fo2ti813f4h0d4lmqbq2mh68ki', '52.229.96.169', 1642967498, ''),
('a2k9essnags7ala04tkrvj7j6632c6g4', '5.8.10.202', 1642850226, ''),
('a4limm2hd4avomrbrgna75s1vpip7o2b', '192.241.213.91', 1642915584, ''),
('a77j2r1vque8e203ap3frilpf7dk2pps', '138.68.232.158', 1642816409, ''),
('a8lhj9k31lmbu6c0vhropv868u8thldp', '172.70.12.5', 1642833583, ''),
('a8p1gdqdlesvs9evamqv99k8ivu02ma3', '88.80.186.144', 1642882334, ''),
('adung76np38gn45hb78upsv6mdk7p8ob', '68.183.150.101', 1642816961, ''),
('afashgk5mh48u1m7jcbfuepa3np7sikg', '88.80.186.144', 1642882325, ''),
('agr5amigb0ma3t6cjhcn5rchghr33mav', '136.144.41.117', 1642854905, ''),
('aidlisul3dic45ikfn488bmkcloq0jac', '138.68.232.158', 1642816415, ''),
('aiju22d3ug9nai4qgn1qiel1na54pkom', '37.49.225.117', 1642877248, ''),
('ajg0jv1najtdjduk960ig4lc0d3fv5vm', '192.241.205.175', 1642973415, ''),
('alj2b7cbfh689dqb2825onagil5dqmpi', '37.49.225.117', 1642877311, ''),
('apehkm8v0pee97gpd9to83gjbrmkerva', '4.17.224.134', 1642877279, ''),
('b0mfrgo6ap9mkkegq5qlrbnq7i86reim', '45.146.165.37', 1642820962, ''),
('b1mn3qib3okg4c40r8sllnni846b30j7', '138.68.232.158', 1642816407, ''),
('b84cfbj9qnphmchqol7fhvflhc8qi7bd', '107.189.12.178', 1642866384, ''),
('b8pq21sqc11ohb0et0isueihst533esg', '45.137.21.134', 1642885943, ''),
('bbtf2ehiavhu9lskejr6luhch60f8iaf', '194.233.78.120', 1642893150, ''),
('bduv9vshk5og7n248vlhb9gv5dvbvmg3', '174.50.177.139', 1642816393, ''),
('bem4201ie4ehpnqdmhhcmbhc49vp47uj', '81.39.100.157', 1642970895, ''),
('bgnlvb330lebjblrtnoei2p6qopbns5g', '88.80.186.144', 1642882325, ''),
('bh28ea4b3rpnuv5fajnpd6k13luo2o1r', '88.80.186.144', 1642882326, ''),
('bh6dsm4pki6tn1bmsjhammp89dcm46du', '174.50.177.139', 1642816393, ''),
('bipvl0s3a0n3ql5033l86e8aqea51kbk', '68.183.150.101', 1642816960, ''),
('bjioba53o4m8vqs1pfmkkrac9p6gf456', '193.118.53.194', 1642859280, ''),
('bjmkas1h83fgonrh5iiq7ij3c7j6v8qm', '182.1.30.95', 1643000222, ''),
('bk2jr16rr5te7tjqaijm6q61om5k2o9f', '192.241.205.222', 1642913083, ''),
('bmgojthh0e6c87ham91470o3sdkrkm19', '31.220.3.140', 1642961382, ''),
('bmue3lbm0vog94ena4pnsm50onbsmlc1', '43.130.10.173', 1642916191, ''),
('bpaao0tsqtm1ne29daulm204r3t1tov5', '88.80.186.144', 1642882324, ''),
('bqdlt5868di4214rcrg975etcq5strau', '107.189.12.178', 1642866384, ''),
('bsv9sb39hr0e66mcjh7u2h1k119k3o2h', '10.5.49.77', 1642857144, ''),
('c0eekomabo4h3njpaefgugn3oj0qg1dl', '162.142.125.59', 1642998430, ''),
('c6h67clalmjj8psv6n6te5tdb5qch4pg', '45.146.165.37', 1642843741, ''),
('c85evkkmrcc3oon4il2bsv9bsoc1bopc', '192.241.212.54', 1642983730, ''),
('c9achl6np9kek6dd8614f7g3iar8vik0', '54.89.178.52', 1642960032, ''),
('ca6nd340v3hhgfpbrul4cjjl9liri07n', '194.233.78.120', 1642893150, ''),
('chlmjpeohcfs6qtroitjmomf6j55mgui', '5.8.10.202', 1642894020, ''),
('ci3d6tkrs5vrj1nvickp6hga6luuci0t', '43.131.65.253', 1642820028, ''),
('cj718insvntkqkovucsmuu23o5ssi088', '119.18.153.203', 1642919371, ''),
('cjk7qnaujgc454od7j3ifmfs7btth14q', '107.189.29.181', 1642943140, ''),
('cl6it90oschfc6b40sg6pc1euljapb71', '194.233.78.120', 1642893149, ''),
('cm31hictijfhjrf4kf7guta8m06l75kd', '74.82.47.4', 1642988553, ''),
('cnkui61odmtojl8mfhbld720meq7t8d2', '137.184.198.10', 1643001541, ''),
('cqpnaddqqjuh3q7ulllpv89q3g1iei8t', '128.14.134.170', 1642852615, ''),
('ctg7c67qqjfr2q2aa53l7894231ur3o5', '136.144.41.117', 1642991701, ''),
('cu90ou3p2qaqj08vvhsnsjqj2iokt0t3', '10.5.49.77', 1642828287, ''),
('cvjsrf1pnle8nlc75d67pv1caj82pobl', '45.146.165.37', 1642952765, ''),
('d0mpllcdgdbtlpgbmdv08plhtet2536i', '174.50.177.139', 1642816396, ''),
('d2vj96mo3nkns6u06gsaarhfa97hci4o', '5.8.10.202', 1642850225, ''),
('d34ebb6hhdfk7f1kqq7979n46ms8pdod', '45.146.165.37', 1642995349, ''),
('d4u0qc5njuh6guum1b3qafqefhg0nl7m', '45.146.165.37', 1642944264, ''),
('d7bk87f2sla5afbpf7jfstjrq3g7kbli', '35.81.168.47', 1642994140, ''),
('daa921ed8ckui04n04f0gmg913cre036', '10.5.49.77', 1642871478, ''),
('dabomqkn26d3buhh00427a8dkrf7vcfe', '128.1.248.42', 1642829247, ''),
('db3v2b2l8p65t92nh084e19v22c3mos7', '174.138.40.190', 1642850877, ''),
('ddkfpb33ck6kqur4asfj2hqbvre8fike', '107.189.12.178', 1642850158, ''),
('dgglekem8sek8dvcc7to97611ahi6sgh', '109.237.103.123', 1642953153, ''),
('diqt0mv6gbng5nj57ppst8uqmetjo30e', '174.50.177.139', 1642816403, ''),
('dldk40ml8in3i0q76osch3oms4h5dgun', '194.233.78.120', 1642893150, ''),
('dnvhgq92oapqlcf1m8qtgckntctdmuk2', '115.144.69.136', 1643001657, ''),
('dpb97la6lblm97h2peat9vfl4jvu8tiu', '45.146.165.37', 1642831324, ''),
('dqscdgs4j8caiqgu3velg7n846ocapq2', '45.146.165.37', 1642854680, ''),
('dqu48h86ofc4oc8mul37ga8ecub0ngik', '45.146.165.37', 1642998284, ''),
('dria5lj2g38gd1k2u7807ccj2ol064d5', '194.233.78.120', 1642893149, ''),
('dsdaeu5g32tdt7s72d3ck7umdtki990j', '10.5.49.77', 1642957877, ''),
('duadfjgmf0jjdlsmcsa54825c6klnlls', '174.50.177.139', 1642816399, ''),
('e4br8kh1ukedfakhgacloul14q3g6k0d', '159.203.160.245', 1642838585, ''),
('e9p4itigc7274gaelsaear94emhh6lnq', '194.233.78.120', 1642893149, ''),
('eauhdovv3mij1vsrm12cn933p55v5ap3', '163.172.102.84', 1642928109, ''),
('ebc9enllangaig6480i8n1mf9l4aqhpf', '52.229.96.169', 1642967500, ''),
('eeqn9s2l6vhqukfjfeihq11fjm3ke8gk', '10.5.49.77', 1642842732, ''),
('egsn187vgj9hbu4l0bndn16hejtjvc7j', '88.80.186.144', 1642882324, ''),
('eohache8deqmb8llv1sncb1ofd87578d', '125.47.145.201', 1642912175, ''),
('ep59fqfkih29j4udqlug3c2bt8bcgk4i', '45.146.165.37', 1642888577, ''),
('eq8dup4cmdlq3i16jelfvje5lo71030n', '174.50.177.139', 1642816389, ''),
('eslpsa874j74ciss0nemnk5nburpr3at', '44.234.43.1', 1642961886, ''),
('et7fa23rj61st2u4a0kbhdmq6mnqoqha', '45.146.165.37', 1642896527, ''),
('eu5tie87u1hr97qmh0lsfdppj542okjr', '185.168.41.189', 1642844777, ''),
('f0t5e5eusm505es40iu0r6a8hnhusv32', '107.189.12.178', 1642868514, ''),
('f1dimkru4d05uc41f5tv2jcqaimh1no6', '88.80.186.144', 1642882324, ''),
('f1fe8nor90ale98c8ocafg1h5hmb1ruq', '174.50.177.139', 1642816399, ''),
('f2sq5hn7eeahrr56pgmr1mdr8b5k8jh1', '167.248.133.114', 1642883351, ''),
('f33tdh4152qkfmd3ep18jgllq1a6g78k', '88.80.186.144', 1642882335, ''),
('f4aj0p6051fn3evpeqomg24mkptuauem', '10.5.49.77', 1642842732, ''),
('f5ef79dtmqpqvbvv1d1krif5vfkpl9u0', '37.49.225.117', 1642877248, ''),
('f6qfbt6e3j7arj4bl3kjpoi41e3jf5l2', '45.146.165.37', 1642818500, ''),
('f8420hre2mvfngbu1rifmikejsvpapmq', '10.5.49.77', 1642957877, ''),
('fkqc013gt0ncfan663i21kq78qi3r2l0', '109.237.103.9', 1642831173, ''),
('fll0hkno90v8lpn23nje7ah8a66q4d6a', '107.189.28.51', 1642917032, ''),
('flqv4hi57gbm6jrbomd2rgu6tiiv7f38', '80.111.244.77', 1642995971, ''),
('fn9rv3stqd08qa85hr59pgs3rd9f81si', '128.14.209.162', 1642841990, ''),
('fp0t45s2qh8doarjuom5g2benjqisqcd', '115.144.69.136', 1643001980, ''),
('fttg1l1eblnf8uu0m9715p22174h9mc5', '115.144.69.136', 1642824704, ''),
('fv0vabqm2oubklimv9d1t67a0o286dln', '45.146.165.37', 1642853127, ''),
('g3q8gohj4r8f4sv1gm6i9isef2mfuh5h', '88.80.186.144', 1642882335, ''),
('g79km7dqqo43f90h3hsmq35ab3pq343e', '172.70.0.209', 1642845353, ''),
('gii2u1lh1gt2lrmc831fq237h86gorga', '103.102.153.153', 1642903918, ''),
('gji57igpm8ebc9eod0he39np973q6b8c', '10.5.49.77', 1642871478, ''),
('gktr3kce6oojs31rdgm4m7mmg48qtsgn', '152.32.209.213', 1642892117, ''),
('gmp26lfunmk8fpib03qjv4ld3gut2kfh', '49.143.32.6', 1642870597, ''),
('gnlrqbgiugddqq1mvn7ri68g07fv66f6', '174.50.177.139', 1642816395, ''),
('gsmb15e2vniadej15f2g05dkbiom2b55', '138.68.232.158', 1642816419, ''),
('h08424cd0ggvgrh34qoi2jo5ekv8rph2', '5.8.10.202', 1642894011, ''),
('h6bmoihk3h8npcvg2r1ttt5jl85copjm', '107.189.29.181', 1642979057, ''),
('h6itrj5acd8aut64pijktgq39d96gjvd', '209.141.54.110', 1642855350, ''),
('h880ommm62fik5f0hpkj1d9k24di97s3', '52.229.96.169', 1642967501, ''),
('h8tgi0jlkpti276k84heaope6kb7rfmd', '107.189.12.178', 1642817204, ''),
('hecnmfsie4bud87mpc438gc5hguj2oe9', '174.50.177.139', 1642816394, ''),
('heiom719sjsbuee0rt8lko3rpn9vu1ec', '89.248.173.131', 1642892873, ''),
('hgkdlddi6j40oiikalno0770jni64qkl', '138.68.82.61', 1642859206, ''),
('hkgilf6hccrn4dng8rp2u22elqf4fg2e', '185.168.41.189', 1642844778, ''),
('hlij9e35lf2akvd4mm63c5c3l2f1ja1f', '192.241.204.206', 1642975995, ''),
('hmn8vpal63s1robtpt1t2plc2bcdondp', '88.80.186.144', 1642882329, ''),
('hr11ftpf1bt5o9l9kt6avhalpltjnt16', '128.14.133.58', 1643001952, ''),
('hsdkv22t5ebbgne74ge5hj61ddo4fvpq', '185.168.41.189', 1642844777, ''),
('hu4uq8041thkig15lc9lb9bchfn9b71q', '138.68.232.158', 1642816405, ''),
('i7neik5cbajmvk8hgunscolahgd5359u', '115.144.69.136', 1643001979, ''),
('ib9480sqa7cj5lbpciv5v3lg64rgpa2h', '88.80.186.144', 1642882324, ''),
('ig67kc9d1eujmj0u93s1tkfjqenh7440', '88.80.186.144', 1642882324, ''),
('ihod583ri6hsarv3dupno7rqmu6k1h24', '185.168.41.189', 1642844776, ''),
('il5e2d6bdr1hod397h6o3d4okqgvbtsg', '10.5.49.77', 1642986002, ''),
('ios4g3983ojb4ltv3tho5du0fp9a6e1c', '194.233.78.120', 1642893149, ''),
('iostojdgobscsprhes9an70n14tbf6iv', '138.68.232.158', 1642816403, ''),
('isfmub5h2b05jo7le7uhnl25kf0lt1no', '185.168.41.189', 1642844776, ''),
('isms8c3o0bv35veoobbb99kocll9rr3i', '194.233.78.120', 1642893149, ''),
('itfc3oigsvk849tfiq7lmb62q494vios', '194.233.78.120', 1642893149, ''),
('iu7po1i3fjkvth2a0i16lh18a4pj6no7', '128.1.248.42', 1642918466, ''),
('j15fb8tc8dmkgutuulvn1fmorb5309ep', '185.168.41.189', 1642844775, ''),
('j1d4ol6uqn8ed8fsqin4scs48v7ddnsc', '185.168.41.189', 1642844774, ''),
('j1s7upcub58j2r03qi1okhlkp60nn8fe', '182.180.104.47', 1642932180, ''),
('j4auepgag795v0h39go70l2p8phbo03q', '216.218.206.69', 1642855939, ''),
('jbnctj2id4qo4j59n4l6jlpd3rjhdr5b', '45.146.165.37', 1642918334, ''),
('jg9rokg9s3mh2v4bs5lfo63lu1l0j2jn', '88.80.186.144', 1642882324, ''),
('jgr3jumbk1sunitt63m3ami0leiirpil', '45.146.165.37', 1643000498, ''),
('jlnb5i8o73nfkp1o4ck4qm0t99g1h7tv', '174.50.177.139', 1642816386, ''),
('jmdm10pvsatnjugov3s8g6rjpdp08rnv', '5.8.10.202', 1642894013, ''),
('jn215mpbfh2nljjdiast9krkdlubisa4', '45.137.21.134', 1642966377, ''),
('jsld2ir6eg7dor873fc5gsukdehu5juh', '115.144.69.136', 1643002044, ''),
('jv2h4o6v1atq2jc5a73cmm7c4a1ft5ur', '35.233.62.116', 1643002339, ''),
('k1f7l3jdd7rkqidq636u05b5f8116oc0', '107.189.29.181', 1642880112, ''),
('k3r3dvt6snjnmggvhqng0hae5lqsel8f', '107.189.29.181', 1642971377, ''),
('k4ticp5t7r3cqpulelifbdh2onij535d', '88.80.186.144', 1642882328, ''),
('k5d6el2itgb5ftqgc9b1ui57e5l8ivg2', '174.50.177.139', 1642816388, ''),
('k626f7la0t994s7on9s4o4ahcc52fb2m', '103.102.153.153', 1642903890, ''),
('k7d27o04u46co3mcprbceub1k9etpqoe', '194.233.78.120', 1642893149, ''),
('kfqpi5ah7kers9to2ipomctmtaf02ra9', '182.118.162.136', 1642831497, ''),
('kk0g0246nqveconvhckapjmjd4f0igs8', '174.50.177.139', 1642816391, ''),
('kk2ith5hvbjeqj33fg1m8tb5da6tqdum', '88.80.186.144', 1642882324, ''),
('klfd3t5qkm904lprjbdeu0r6hokl09lg', '107.189.29.181', 1642905339, ''),
('km85bpk0k7dfj27pgmt7ss2qj3e8k8r4', '35.233.62.116', 1642916600, ''),
('knj7pnmqffif8vi4cg4rts74lgtimnrb', '162.142.125.58', 1642958639, ''),
('knluimk7o45qbevll7qr5tg4scpl0456', '10.5.49.77', 1642943540, ''),
('kvboqsb1u4a6k8gld10413vvfnq2m0mp', '88.80.186.144', 1642882331, ''),
('l173jo9gufd2lft308r67mlc54o2fgig', '88.80.186.144', 1642882330, ''),
('l78onh5l68tgkus8gtcbfo3bo06dldm1', '138.68.232.158', 1642816398, ''),
('l7ep19n75clf7cngg12jcho2rib38250', '10.5.49.77', 1642857144, ''),
('lat6s82335p8n0g1g0f1od1nonkp303o', '10.5.49.77', 1642914676, ''),
('ld61i82oi4v8o11dpt94mop8abkep3g6', '194.233.78.120', 1642893148, ''),
('le6jbljretms0i5e00559n3654u839i4', '107.189.28.51', 1642942155, ''),
('licillhml8el58es7k23q2bn3354mbhr', '5.8.10.202', 1642850236, ''),
('ljfiju81sms7dho64shdu74ajurht1qk', '163.172.102.84', 1642928110, ''),
('lk1bjcsb0r3i087fac2o9cbrdok7e8mi', '10.5.49.77', 1643001125, ''),
('lrp0dcc18e8eo4aavmucf5agq9qj43s4', '107.189.28.51', 1642920892, ''),
('ltmrj6fd6qm3dv1vi819o135qf1rf34k', '88.80.186.144', 1642882324, ''),
('m0ru5s6jqmkc8jjom4crf6mcugreecs7', '5.8.10.202', 1642894015, ''),
('m6q5230194p0bkfuh6mqbaiskmdthhrv', '192.241.212.132', 1642886626, ''),
('m6rhcg06m28h2ud3l07ddl4v62ut408l', '36.69.8.120', 1643000991, ''),
('m8c58j8ucrmacnh57014vhlsugll1u80', '194.233.78.120', 1642893150, ''),
('mft9ernblikvgllif2i0rg6u0pk9ighg', '109.237.103.9', 1642963025, ''),
('mh1ibo13pqk75jjasu3a7hd9t8tc9k4b', '172.70.5.196', 1642939072, ''),
('mqu7s33sh8n51u9ch6tqf97ao3v3pi9e', '85.202.169.88', 1642860112, ''),
('msbaijcv754mkvqe98hqjensod291oaf', '115.144.69.136', 1643001979, ''),
('mso7ueasal3aqoso12pl1ml9k8acvs1p', '187.108.70.41', 1642959846, ''),
('mtp8efaf748qdjv2d5gc8ne2a704b8g0', '88.80.186.144', 1642882329, ''),
('mueq9qscrjmv672vqkmsl3bl0mcfd6l8', '107.189.28.51', 1642917033, ''),
('n89diu31o1m084e2sj3c55vhec876rsu', '107.189.29.181', 1642910515, ''),
('naqvjc9ed11edlk9qsbrpo8bf6mg001m', '194.233.78.120', 1642893150, ''),
('nfm985reo9t11ob06t5vtc6m9ionc9vq', '194.233.78.120', 1642893149, ''),
('nkglaua1caa2r7nipmaj2qc9u95u32kr', '45.146.165.37', 1642849869, ''),
('nqen9ubdo9e19dgj7tejcl49l77d6c1a', '115.144.69.136', 1643002043, ''),
('nqkn994l6s1h49j6qfvuq9k9dd16iekv', '88.80.186.144', 1642882324, ''),
('nrv6h7c863o88dne5add8796hml09pae', '143.110.222.104', 1642955793, ''),
('ntcufaqq3ql3et535e9rd48lciijg4af', '45.146.165.37', 1642852200, ''),
('ntu2cucoeign0lnhej7r1pr5tr7g19ac', '45.146.165.37', 1642930055, ''),
('nvafckj5hnm9f53q2prl5hvk1n1tb4br', '167.248.133.114', 1642883351, ''),
('nvvmur13us9jo1h7a996e79vndrvko3g', '52.229.96.169', 1642967507, ''),
('o2m979v2gh3hngebrleta91b37nfe2a7', '45.146.165.37', 1642937620, ''),
('oc1qkavv0oup41q979e4m5nd7vvm7s0g', '159.203.160.245', 1642912962, ''),
('odp6smjr72qvrsffp1rfe1htl96bl8l7', '130.211.54.158', 1642831149, ''),
('odq910bv968cl04iq2plgr61ipjad2u0', '107.189.12.178', 1642868519, ''),
('ovg5551lfolok6u8192d97muoff8db2k', '194.233.78.120', 1642893149, ''),
('p3irf5cguqgnagvsin4ncap4cesssaqh', '45.146.165.37', 1642816398, ''),
('p4pf68dfkjp1c1pt3j9m7l1htdfe49ap', '185.196.220.54', 1642890409, ''),
('p52vuhcokiihbam34mpm9phd10jc5ttc', '45.146.165.37', 1642922009, ''),
('p6pee8d37u7qusqavc40ko2b4l2chibs', '115.144.69.136', 1643001933, ''),
('paf0hi63gcubf9ekn580lolgdk9ccpnn', '88.80.186.144', 1642882325, ''),
('pcacgjouf3ecv25m57b0jppltkom1fnl', '192.241.211.246', 1642890754, ''),
('pikdjlf9au8k371p20649bpt14pnr8cf', '45.146.165.37', 1642824863, ''),
('piueog2luukampl8ti23f46ih5g0c605', '209.141.42.155', 1642929594, ''),
('pj77cr59ed975rgus28unohruoosku9u', '174.50.177.139', 1642816400, ''),
('pj99mpv6jvkkngk250p0n0lcbfnpl370', '128.14.134.134', 1642864157, ''),
('pm503qg57d1risbl3pc8gaci2c0nc9jh', '45.146.165.37', 1642860975, ''),
('ptkags66q94jhmbbv47g82dsphic8smg', '45.137.21.134', 1642997857, ''),
('q0hhf0cism40ln9604qurbjs9332s3rd', '88.80.186.144', 1642882324, ''),
('q3j9h4m0h5s4bv5s9ibuhsk2s2fgpilj', '194.233.78.120', 1642893149, ''),
('q5rhamortosusd2n7qlht97pvjo32ahh', '88.80.186.144', 1642882324, ''),
('qif594h91h9lsu2kuuj103o3799r1d3u', '174.50.177.139', 1642816402, ''),
('qk5jjifdisrvp75lv5ugcs3h0upg8ujc', '206.189.226.57', 1642924853, ''),
('qkvn3mvcoicqjjud2omkam4q0cnbjfog', '192.241.209.85', 1642989906, ''),
('qltngl3j986h45ou1bmn6cst9r6rirjv', '88.80.186.144', 1642882324, ''),
('qosk3i1o46rauhgo72j90rt078b6p4e9', '5.8.10.202', 1642894019, ''),
('qrk7lvcostg3qcbbfi0pquc03ru908ja', '84.38.189.2', 1642856303, ''),
('qthljdknc3df43pf49pein1qjq969kcg', '138.68.232.158', 1642816412, ''),
('qtiiatmf8iqoi2b4gm9rbt6ahte1p2c5', '185.168.41.189', 1642844774, ''),
('r4pruu3t359s4v2khq7mundiiggqihbl', '45.146.165.37', 1642970921, ''),
('r6eiji1j0tto1oej12r9bf37vcibelvr', '192.241.211.103', 1642886063, ''),
('r73flimeclfsdcdvobnitkuo0eqk2q21', '174.50.177.139', 1642816396, ''),
('rbhorrc9dkm5qv9tta6j6fubjsjhk73k', '88.80.186.144', 1642882325, ''),
('retpeu10kudlhbm3barl67mdrp0hu2kq', '192.241.213.121', 1643002015, ''),
('rfsqmpiobi7r3rqkjir1pn0s5117l1m4', '88.80.186.144', 1642882324, ''),
('rgr50oik1c8di1ggrhibsako8u3hfepb', '209.141.41.193', 1642929599, ''),
('rj9r2ii9tv77md8trlii60kosolkpn4m', '88.80.186.144', 1642882324, ''),
('rkdi0f16eorpk3drg9su1766d7psloi1', '45.137.21.134', 1642957979, ''),
('rnn8psdm5sr93r6jj5l6a6fkhu25fudh', '174.50.177.139', 1642816387, ''),
('rqidlo57j48gukeskvfav70hfn66lt91', '194.233.78.120', 1642893149, ''),
('rtp2h9ue86t2pmufhl2cd85ge7fh1tf5', '45.146.165.37', 1642962093, ''),
('rulkf963bp2f252ic18djcbck7kpodqi', '107.189.28.51', 1642920893, ''),
('rv0v1q4r2off6camqmvq7o046f379rnd', '167.94.138.59', 1642841535, ''),
('rvrle5pb7ecf7fp7ol0ej7c6osht55re', '45.137.21.134', 1642974019, ''),
('s1ln5jqbjbs7sqo9cd07ggids52au85m', '45.146.165.37', 1642925360, ''),
('s5voaccvhtjmotdeoamlsj6hauc2mq29', '10.5.49.77', 1642914676, ''),
('s6fd1fest9f7euu78s6t0leih3fsses3', '162.142.125.59', 1642998431, ''),
('s7mb1nas6o7prebjbtihanfu447hblkd', '115.144.69.136', 1642824704, ''),
('sa5m90cfg49kkqcmiid3cr3kav7s07fd', '138.68.232.158', 1642816398, ''),
('scjdhsf12va9p83q5taic9rqiul1h308', '136.144.41.117', 1642881282, ''),
('sdcqsiinp0i2ik1cm183lm7jkkkveomj', '107.189.12.178', 1642817203, ''),
('sj6inu643dclhlb64ndljrr7d5dc7qqg', '45.146.165.37', 1642872153, ''),
('skcpfh7tnanmj6ak9ig2erd2ft9ph8hc', '10.5.49.77', 1642943540, ''),
('sl6ghjhlagg893rgi5brknjppo1pms6p', '88.80.186.144', 1642882330, ''),
('smf029ajggov03o8g3hh8rnbqvka6j9f', '174.50.177.139', 1642816402, ''),
('spifnj7tbu0ac55v30e4oufs2omc5gl6', '107.189.28.51', 1642895782, ''),
('sqgh746m8ckcbgvo2ld68tkmkluhs7ej', '194.233.78.120', 1642893151, ''),
('ssq8i0gqf9h1lva6rpf408qujm35rnn4', '45.137.21.134', 1642862993, ''),
('st58pqg2uvi4b0oggqhlkifm9i6u6cei', '174.50.177.139', 1642816392, ''),
('sv2o01rb8u6vf41bmr8nj15822gpife5', '125.64.94.138', 1642995069, ''),
('t1nsgmshqsc3f8tk0nmae5p2254a2apf', '128.14.134.134', 1642985317, ''),
('t5alcng35nfu75slbt0r7qr00p6lcikp', '45.146.165.37', 1642957294, ''),
('t6bneubufrt3k64ajckp8lddhshfkhag', '118.239.20.144', 1642910604, ''),
('ta5i94ocbrra82d6scm6de7ll50c14l0', '10.5.49.77', 1642971615, ''),
('tcle32cq9cumrgbm4tlhphqhda89k80n', '45.178.16.194', 1643000571, ''),
('tdasu5cv1hg3kajsbd6tk7chnt5hc3oi', '128.1.248.42', 1642930579, ''),
('tgvp0gnouqh7i9iinc2s72vh17s3opiq', '85.62.28.71', 1642864510, ''),
('th089i8i2rq4gs4f3bbt2drge39miv86', '64.225.75.232', 1642980026, ''),
('ti0q8meta1kqoo5h7j9lv351c6b1v0vl', '107.189.29.181', 1642910515, ''),
('tm6sffh973opf8fr3fpcp5ghp9mk8soa', '47.103.66.91', 1642954079, ''),
('tnaqgfd5nrdru71iu0qt50p22dt9jjuj', '45.146.165.37', 1642949759, ''),
('to5fonlg3fan0p73252oh1p7m6472aik', '186.67.115.166', 1642835439, ''),
('tq24rqltggj9o1q57fq0vt7qcp0lkjtn', '194.233.78.120', 1642893150, ''),
('tsgsa4ekbh4rsed1on0udm40h98f7a93', '64.62.197.62', 1642919685, ''),
('tsqkvjn52iu2ei1vad1nq92353sbvi1o', '103.160.118.2', 1643002523, 0x6163636f756e745f6e616d657c733a373a226e7461686c6168223b454167656e6461417070403230323153657373696f6e7c733a3139323a226664343362373866303135663061623338616466616535346264613337616236333135323139643030353935636366633731386364383565643264386531396462613139396266303432303031316633353931623464663037376132643864626465346166613237386233613031333330353361393064393665393632336634362f4f4d6a786f636b457858624867596f57624b5a586c7562516c7a566a4a4b4568364136766a7a38704b2b424d315776334638376670387952634f30314338223b657870697265735f62797c693a313634333231383431343b69645f75736572737c733a313a2231223b66756c6c6e616d657c733a31343a224572696420416465205075747261223b67726f75705f6163746976657c733a313a2231223b67726f75705f6e616d657c733a31313a2253757065722041646d696e223b69645f6c6576656c5f616b7365737c733a313a2231223b6c6576656c5f616b7365737c733a31313a2253555045522041444d494e223b6e69636b5f6c6576656c7c733a333a22534144223b7573657269647c733a33323a223233314536393645394332313831303533354530384646464537304630383638223b69645f6f70647c4e3b67726f75705f7377697463687c613a343a7b693a303b613a323a7b733a383a2269645f67726f7570223b733a313a2231223b733a31303a226e616d615f67726f7570223b733a31313a2253757065722041646d696e223b7d693a313b613a323a7b733a383a2269645f67726f7570223b733a313a2232223b733a31303a226e616d615f67726f7570223b733a31333a2241646d696e6973747261746f72223b7d693a323b613a323a7b733a383a2269645f67726f7570223b733a313a2233223b733a31303a226e616d615f67726f7570223b733a383a2250696d70696e616e223b7d693a333b613a323a7b733a383a2269645f67726f7570223b733a323a223133223b733a31303a226e616d615f67726f7570223b733a363a22416a7564616e223b7d7d),
('u0lt10uunombr1o1ii9vqnla2a9su08o', '193.118.53.210', 1642949287, ''),
('u2lfeqi4bapvi0pbd7vavq9dda4ccv1c', '64.225.75.232', 1642980840, ''),
('u2mcneai2b4thevo0leehlmdutp3jp7r', '174.50.177.139', 1642816401, ''),
('u36cq3pfe1etebl5ua8kbhvueg0g1fcf', '88.80.186.144', 1642882324, ''),
('u5ldh38k8lacvuddabf8rhpd98rmk69t', '31.220.3.140', 1642874168, ''),
('u63s8nlc376cut531sljg2tkh475e9jn', '209.141.33.65', 1642929593, ''),
('u7n9dhke6nbkk8870n9vrp9e571bef7s', '35.233.62.116', 1642869980, ''),
('u8eh2r0en1o0vjhancuum6opm0vbmkt9', '106.75.246.50', 1642888636, ''),
('ufe5f12ikb72gfvsrmgifhpmi6jass4i', '192.241.206.6', 1642970740, ''),
('ufldukp0789ahrb9552gj5625s7goee1', '88.80.186.144', 1642882332, ''),
('un7sh8ns3da4t7nfpepcd4gi66gh40hk', '103.160.118.2', 1643002220, ''),
('unjepq7r5v0t0uq2rgsm0jsnkum3bnen', '115.144.69.136', 1642824704, ''),
('upjp72jv8snb55qp02c8v3tncq2qnkm0', '194.233.78.120', 1642893149, ''),
('utigbtds5la6tnntt860juil876koqi6', '10.5.49.77', 1642971615, ''),
('utjmpuq66cd41d1tntu5fce7ffr4cqvc', '88.80.186.144', 1642882325, ''),
('v0n2fqmqmd4b9oeprki7idv7e8pkbpr1', '174.50.177.139', 1642816398, ''),
('v2nh5000ea0a3segg25a71jkaoafmrjh', '109.237.103.9', 1642963025, ''),
('v4fjohg2q50jqlblobcghok0rh0od9oj', '109.237.103.9', 1642831173, ''),
('v5hlfpfvi1r5p2bie8ggflqj6q2na91k', '45.146.165.37', 1642975248, ''),
('v60tm8ub60k3kmv9crdj4cd5l2ecaeu6', '194.233.78.120', 1642893151, ''),
('v8mf9v7hhafmgpu098o6ru0bb7jsjbg9', '88.80.186.144', 1642882334, ''),
('vaie284dj8tugkd7msj5743ieeu32rl3', '194.233.78.120', 1642893150, ''),
('vc053n2el94k48vghtnrf9jfdudo4jf0', '109.237.103.123', 1642953153, ''),
('vhgcg3nfsuiio3efgi0fek0hrhb4llaa', '54.153.50.229', 1643000031, ''),
('vk7teb246b0p54moe3ndtm8hu3f5vt54', '45.137.21.134', 1642941261, ''),
('vkg2a7p7bca64tkac3drodbt9bjdmp79', '192.241.206.156', 1642913837, ''),
('vn2j4s6d16oejsasi1sdijrbons1gpbl', '194.233.78.120', 1642893150, ''),
('vu2jc9b27lcsm13giehc48l83vglr4ab', '206.189.226.57', 1642924854, ''),
('vu56ee2tkjq7ji6veehgjd70u9248l6c', '88.80.186.144', 1642882326, ''),
('vvulgj3lt6h87rameoichadm9j7f6du9', '45.146.165.37', 1642923108, '');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_fungsi`
--

CREATE TABLE IF NOT EXISTS `xi_sa_fungsi` (
  `id_fungsi` int(11) NOT NULL,
  `nama_fungsi` varchar(255) NOT NULL,
  `label_fungsi` varchar(255) NOT NULL,
  `url_fungsi` varchar(255) NOT NULL,
  `deskripsi_fungsi` varchar(255) NOT NULL,
  `id_jenis_fungsi` int(3) NOT NULL,
  `id_level_akses` int(3) NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_fungsi`
--

INSERT INTO `xi_sa_fungsi` (`id_fungsi`, `nama_fungsi`, `label_fungsi`, `url_fungsi`, `deskripsi_fungsi`, `id_jenis_fungsi`, `id_level_akses`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`, `id_status`) VALUES
(1, 'index', 'Index', 'index', 'Fungsi untuk menampilkan data', 1, 0, 'yogisolop', '2017-06-04 19:30:40', '::1', 'yogisolop', '2020-05-19 11:01:33', '::1', 1),
(2, 'create', 'Create Data', 'create', 'Fungsi untuk menambahkan data', 2, 0, 'yogisolop', '2017-06-04 19:32:33', '::1', 'yogisolop', '2017-09-05 17:52:35', '::1', 1),
(3, 'update', 'Update Data', 'update', 'Fungsi untuk merubah data', 2, 0, 'yogisolop', '2017-06-04 19:33:01', '::1', 'yogisolop', '2017-09-05 17:52:44', '::1', 1),
(4, 'delete', 'Delete Data', 'delete', 'Fungsi untuk menghapus data', 2, 0, 'yogisolop', '2017-06-04 19:33:33', '::1', 'yogisolop', '2017-09-05 17:52:52', '::1', 1),
(5, 'listview', 'List View Data', 'listview', 'Fungsi untuk menampilkan list data', 2, 0, 'yogisolop', '2017-11-06 13:59:43', '::1', 'yogisolop', '2017-11-06 13:59:43', '::1', 1),
(6, 'review', 'Review Data', 'review', 'Fungsi untuk mereview data kembali', 2, 0, 'yogisolop', '2017-12-17 23:45:14', '::1', 'yogisolop', '2017-12-17 23:45:29', '::1', 1),
(7, 'details', 'Data Details', 'details', 'Fungsi untuk melihat rincian data', 2, 0, 'yogisolop', '2017-12-27 08:28:13', '::1', 'yogisolop', '2017-12-27 08:28:13', '::1', 1),
(8, 'searching', 'Searching', 'searching', 'Fungsi untuk mencari data', 2, 0, 'yogisolop', '2017-11-07 13:21:59', '::1', 'yogisolop', '2017-11-07 13:21:59', '::1', 1),
(9, 'approve', 'Data Approve', 'approve', 'Fungsi untuk menyetujui data', 2, 0, 'yogisolop', '2018-04-03 09:22:12', '36.67.167.61', 'yogisolop', '2018-04-03 09:22:12', '36.67.167.61', 1),
(10, 'reject', 'Data Reject', 'reject', 'Fungsi untuk menolak data', 2, 0, 'yogisolop', '2018-04-03 09:22:12', '36.67.167.61', 'yogisolop', '2018-04-03 09:22:12', '36.67.167.61', 1),
(11, 'upload', 'Upload Data', 'upload', 'Fungsi untuk mengupload file', 2, 0, 'yogisolop', '2018-07-24 22:20:18', '::1', 'yogisolop', '2018-08-03 15:09:33', '::1', 1),
(12, 'download_file', 'download_file', 'download_file', 'Fungsi untuk mendownload file', 2, 0, 'yogisolop', '2018-07-24 22:21:04', '::1', 'ntahlah', '2021-04-13 09:13:21', '::1', 1),
(13, 'rules', 'Rules Module', 'rules', 'Fungsi untuk menampilkan rules module', 2, 0, 'yogisolop', '2017-06-05 10:51:09', '::1', 'yogisolop', '2020-04-07 22:38:12', '::1', 1),
(14, 'set_rules', 'Setting Rules', 'set-rules', 'Fungsi untuk setting rules module', 2, 0, 'yogisolop', '2017-06-05 10:51:53', '::1', 'yogisolop', '2020-05-19 12:09:59', '::1', 1),
(15, 'privileges', 'Privileges', 'privileges', 'Fungsi untuk setting rule group', 2, 0, 'yogisolop', '2017-06-10 22:23:24', '::1', 'yogisolop', '2017-08-03 12:20:22', '::1', 1),
(16, 'regency', 'Data Regency', 'regency', 'Fungsi untuk mengambil data regency', 2, 0, 'yogisolop', '2020-04-11 22:38:38', '::1', 'yogisolop', '2020-04-11 22:38:38', '::1', 1),
(17, 'district', 'Data District', 'district', 'Fungsi untuk mengambil data district', 2, 0, 'yogisolop', '2020-04-11 22:39:48', '::1', 'yogisolop', '2020-04-11 22:39:48', '::1', 1),
(18, 'village', 'Data Village', 'village', 'Fungsi untuk mengambil data village', 2, 0, 'yogisolop', '2020-04-11 22:40:11', '::1', 'yogisolop', '2020-04-11 22:40:11', '::1', 1),
(19, 'export_to_word', 'Download Word', 'export-to-word', 'Fungsi download laporan format word', 2, 0, 'yogisolop', '2020-05-02 07:16:39', '::1', 'yogisolop', '2020-05-22 08:03:33', '::1', 1),
(20, 'export_to_excel', 'Download Excel', 'export-to-excel', 'Fungsi download laporan format excel', 2, 0, 'yogisolop', '2020-05-11 08:27:30', '::1', 'yogisolop', '2020-05-11 08:27:30', '::1', 1),
(21, 'export_to_pdf', 'Download PDF', 'export-to-pdf', 'Fungsi download laporan format pdf', 2, 0, 'yogisolop', '2020-05-11 08:30:42', '::1', 'yogisolop', '2020-05-11 08:30:42', '::1', 1),
(29, 'subOpd', 'subOpd', 'subOpd', 'subOpd', 2, 0, 'ntahlah', '2020-09-03 11:01:35', '::1', 'ntahlah', '2020-09-03 11:01:35', '::1', 1),
(30, 'getPenerima', 'getPenerima', 'getPenerima', 'getPenerima', 2, 0, 'ntahlah', '2021-02-24 08:36:21', '::1', 'ntahlah', '2021-02-24 08:36:21', '::1', 1),
(31, 'getPenerimaDisposisi', 'getPenerimaDisposisi', 'getPenerimaDisposisi', 'getPenerimaDisposisi', 2, 0, 'ntahlah', '2021-02-24 11:35:08', '::1', 'ntahlah', '2021-02-24 11:35:08', '::1', 1),
(32, 'validasi', 'validasi', 'validasi', 'validasi', 2, 0, 'ntahlah', '2021-02-24 14:54:12', '::1', 'ntahlah', '2021-02-24 14:54:12', '::1', 1),
(33, 'getPegawai', 'getPegawai', 'getPegawai', 'getPegawai', 2, 0, 'ntahlah', '2021-04-01 13:57:32', '::1', 'ntahlah', '2021-04-01 13:57:32', '::1', 1),
(34, 'add', 'add', 'add', 'add', 2, 0, 'ntahlah', '2021-04-07 10:04:43', '::1', 'ntahlah', '2021-04-07 10:04:43', '::1', 1),
(35, 'edit', 'edit', 'edit', 'edit', 1, 0, 'ntahlah', '2021-04-07 15:45:50', '::1', 'ntahlah', '2021-04-07 15:45:50', '::1', 1),
(36, 'acc', 'acc', 'acc', 'acc', 2, 0, 'ntahlah', '2021-04-15 10:09:32', '::1', 'ntahlah', '2021-04-15 10:09:32', '::1', 1),
(37, 'listdisposisi', 'listdisposisi', 'listdisposisi', 'listdisposisi', 2, 0, 'ntahlah', '2021-04-21 11:25:23', '::1', 'ntahlah', '2021-04-21 11:25:23', '::1', 1),
(38, 'export', 'export', 'export', 'export', 2, 0, 'ntahlah', '2022-01-05 09:41:35', '::1', 'ntahlah', '2022-01-05 09:41:35', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_group`
--

CREATE TABLE IF NOT EXISTS `xi_sa_group` (
  `id_group` int(11) NOT NULL,
  `nama_group` varchar(255) NOT NULL,
  `id_level_akses` int(3) NOT NULL,
  `id_upk` int(3) NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_group`
--

INSERT INTO `xi_sa_group` (`id_group`, `nama_group`, `id_level_akses`, `id_upk`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`, `id_status`) VALUES
(1, 'Super Admin', 1, 0, 'yogisolop', '2020-04-07 00:00:00', '::1', 'yogisolop', '2020-04-07 00:00:00', '::1', 1),
(2, 'Administrator', 2, 0, 'yogisolop', '2020-06-03 16:29:28', '::1', 'yogisolop', '2020-06-03 16:31:22', '::1', 1),
(3, 'Pimpinan', 3, 0, 'ntahlah', '2021-12-07 08:24:44', '::1', 'ntahlah', '2021-12-07 08:24:44', '::1', 1),
(13, 'Ajudan', 13, 0, 'ntahlah', '2021-12-07 09:57:35', '::1', 'ntahlah', '2021-12-07 09:57:35', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_group_privileges`
--

CREATE TABLE IF NOT EXISTS `xi_sa_group_privileges` (
  `id_group_privileges` int(11) NOT NULL,
  `id_group` int(11) NOT NULL DEFAULT 0,
  `id_rules` int(11) NOT NULL DEFAULT 0,
  `id_status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB AUTO_INCREMENT=1602 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_group_privileges`
--

INSERT INTO `xi_sa_group_privileges` (`id_group_privileges`, `id_group`, `id_rules`, `id_status`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 10, 1),
(11, 1, 11, 1),
(12, 1, 12, 1),
(13, 1, 13, 1),
(14, 1, 14, 1),
(15, 1, 15, 1),
(16, 1, 16, 1),
(17, 1, 17, 1),
(18, 1, 18, 1),
(19, 1, 19, 1),
(20, 1, 20, 1),
(21, 1, 21, 1),
(22, 1, 22, 1),
(23, 1, 23, 1),
(24, 1, 24, 1),
(25, 1, 25, 1),
(26, 1, 26, 1),
(27, 1, 27, 1),
(28, 1, 28, 1),
(29, 1, 29, 1),
(30, 1, 30, 1),
(31, 1, 31, 1),
(32, 1, 32, 1),
(33, 1, 33, 1),
(34, 1, 34, 1),
(35, 1, 35, 1),
(36, 1, 36, 1),
(37, 1, 37, 0),
(38, 1, 38, 0),
(39, 1, 39, 0),
(40, 1, 40, 0),
(41, 1, 41, 0),
(42, 1, 42, 0),
(43, 1, 43, 0),
(44, 1, 44, 0),
(45, 1, 45, 0),
(46, 1, 46, 0),
(47, 1, 47, 0),
(48, 1, 48, 0),
(49, 1, 49, 1),
(50, 1, 50, 1),
(51, 1, 51, 1),
(52, 1, 52, 1),
(53, 1, 53, 1),
(54, 1, 60, 0),
(55, 1, 61, 0),
(56, 1, 62, 0),
(57, 1, 63, 0),
(58, 1, 64, 0),
(59, 1, 65, 0),
(60, 1, 66, 0),
(61, 1, 67, 0),
(62, 1, 68, 0),
(63, 1, 69, 0),
(64, 1, 70, 0),
(65, 1, 71, 0),
(66, 1, 72, 0),
(67, 1, 73, 0),
(68, 1, 74, 0),
(69, 1, 75, 0),
(70, 1, 76, 0),
(71, 1, 77, 0),
(72, 1, 78, 0),
(73, 1, 79, 0),
(74, 1, 80, 0),
(75, 1, 93, 0),
(76, 1, 94, 0),
(77, 1, 95, 0),
(78, 1, 96, 0),
(79, 1, 97, 0),
(80, 1, 98, 0),
(81, 1, 81, 0),
(82, 1, 82, 0),
(83, 1, 83, 0),
(84, 1, 84, 0),
(85, 1, 85, 0),
(86, 1, 86, 0),
(87, 1, 87, 0),
(88, 1, 88, 0),
(89, 1, 89, 0),
(90, 1, 90, 0),
(91, 1, 91, 0),
(92, 1, 92, 0),
(93, 1, 54, 0),
(94, 1, 55, 0),
(95, 1, 56, 0),
(96, 1, 57, 0),
(97, 1, 58, 0),
(98, 1, 59, 0),
(99, 1, 143, 0),
(100, 1, 144, 0),
(101, 1, 145, 0),
(102, 1, 146, 0),
(103, 1, 147, 0),
(104, 1, 148, 0),
(105, 1, 149, 0),
(106, 1, 150, 0),
(107, 1, 151, 0),
(108, 1, 152, 0),
(109, 1, 153, 0),
(110, 1, 154, 0),
(111, 1, 99, 0),
(112, 1, 100, 0),
(113, 1, 101, 0),
(114, 1, 102, 0),
(115, 1, 103, 0),
(116, 1, 104, 0),
(117, 1, 105, 0),
(118, 1, 106, 0),
(119, 1, 107, 0),
(120, 1, 108, 0),
(121, 1, 109, 0),
(122, 1, 110, 0),
(123, 1, 111, 0),
(124, 1, 112, 0),
(125, 1, 113, 0),
(126, 1, 114, 0),
(127, 1, 115, 0),
(128, 1, 116, 0),
(129, 1, 117, 0),
(130, 1, 118, 0),
(131, 1, 119, 0),
(132, 1, 120, 0),
(133, 1, 121, 0),
(134, 1, 122, 0),
(135, 1, 123, 0),
(136, 1, 124, 0),
(137, 1, 125, 0),
(138, 1, 126, 0),
(139, 1, 127, 0),
(140, 1, 128, 0),
(141, 1, 129, 0),
(142, 1, 130, 0),
(143, 1, 131, 0),
(144, 1, 132, 0),
(145, 1, 133, 0),
(146, 1, 134, 0),
(147, 1, 135, 0),
(148, 1, 136, 0),
(149, 1, 137, 0),
(150, 1, 138, 0),
(151, 1, 139, 0),
(152, 1, 140, 0),
(153, 1, 141, 0),
(154, 1, 142, 0),
(155, 2, 1, 1),
(156, 2, 34, 1),
(157, 2, 35, 1),
(158, 2, 36, 1),
(159, 2, 25, 1),
(160, 2, 26, 1),
(161, 2, 27, 1),
(162, 2, 28, 1),
(163, 2, 29, 1),
(164, 2, 30, 1),
(165, 2, 31, 1),
(166, 2, 32, 0),
(167, 2, 33, 0),
(168, 2, 37, 0),
(169, 2, 38, 0),
(170, 2, 39, 0),
(171, 2, 40, 0),
(172, 2, 41, 0),
(173, 2, 42, 0),
(174, 2, 43, 0),
(175, 2, 44, 0),
(176, 2, 45, 0),
(177, 2, 46, 0),
(178, 2, 47, 0),
(179, 2, 48, 0),
(180, 2, 60, 0),
(181, 2, 61, 0),
(182, 2, 62, 0),
(183, 2, 63, 0),
(184, 2, 64, 0),
(185, 2, 65, 0),
(186, 2, 66, 0),
(187, 2, 67, 0),
(188, 2, 68, 0),
(189, 2, 69, 0),
(190, 2, 70, 0),
(191, 2, 71, 0),
(192, 2, 72, 0),
(193, 2, 73, 0),
(194, 2, 74, 0),
(195, 2, 75, 0),
(196, 2, 76, 0),
(197, 2, 77, 0),
(198, 2, 78, 0),
(199, 2, 79, 0),
(200, 2, 80, 0),
(201, 2, 93, 0),
(202, 2, 94, 0),
(203, 2, 95, 0),
(204, 2, 96, 0),
(205, 2, 97, 0),
(206, 2, 98, 0),
(207, 2, 81, 0),
(208, 2, 82, 0),
(209, 2, 83, 0),
(210, 2, 84, 0),
(211, 2, 85, 0),
(212, 2, 86, 0),
(213, 2, 87, 0),
(214, 2, 88, 0),
(215, 2, 89, 0),
(216, 2, 90, 0),
(217, 2, 91, 0),
(218, 2, 92, 0),
(219, 2, 54, 0),
(220, 2, 55, 0),
(221, 2, 56, 0),
(222, 2, 57, 0),
(223, 2, 58, 0),
(224, 2, 59, 0),
(225, 2, 143, 0),
(226, 2, 144, 0),
(227, 2, 145, 0),
(228, 2, 146, 0),
(229, 2, 147, 0),
(230, 2, 148, 0),
(231, 2, 149, 0),
(232, 2, 150, 0),
(233, 2, 151, 0),
(234, 2, 152, 0),
(235, 2, 153, 0),
(236, 2, 154, 0),
(237, 2, 99, 0),
(238, 2, 100, 0),
(239, 2, 101, 0),
(240, 2, 102, 0),
(241, 2, 103, 0),
(242, 2, 104, 0),
(243, 2, 105, 0),
(244, 2, 106, 0),
(245, 2, 107, 0),
(246, 2, 108, 0),
(247, 2, 109, 0),
(248, 2, 110, 0),
(249, 2, 111, 0),
(250, 2, 112, 0),
(251, 2, 113, 0),
(252, 2, 114, 0),
(253, 2, 115, 0),
(254, 2, 116, 0),
(255, 2, 117, 0),
(256, 2, 118, 0),
(257, 2, 119, 0),
(258, 2, 120, 0),
(259, 2, 121, 0),
(260, 2, 122, 0),
(261, 2, 123, 0),
(262, 2, 124, 0),
(263, 2, 125, 0),
(264, 2, 126, 0),
(265, 2, 127, 0),
(266, 2, 128, 0),
(267, 2, 129, 0),
(268, 2, 130, 0),
(269, 2, 131, 0),
(270, 2, 132, 0),
(271, 2, 133, 0),
(272, 2, 134, 0),
(273, 2, 135, 0),
(274, 2, 136, 0),
(275, 2, 137, 0),
(276, 2, 138, 0),
(277, 2, 139, 0),
(278, 2, 140, 0),
(279, 2, 141, 0),
(280, 2, 142, 0),
(511, 1, 155, 0),
(512, 1, 156, 0),
(513, 1, 157, 0),
(514, 1, 158, 0),
(515, 1, 159, 0),
(516, 1, 160, 0),
(517, 1, 161, 0),
(518, 1, 162, 0),
(519, 1, 163, 0),
(520, 1, 164, 0),
(521, 1, 165, 0),
(522, 1, 166, 0),
(523, 1, 167, 0),
(524, 1, 168, 0),
(525, 1, 169, 0),
(526, 1, 170, 0),
(527, 1, 171, 0),
(528, 1, 172, 0),
(529, 1, 173, 0),
(530, 1, 174, 0),
(531, 1, 175, 0),
(532, 1, 176, 0),
(533, 1, 177, 0),
(534, 2, 156, 0),
(535, 2, 157, 0),
(536, 2, 161, 0),
(537, 2, 160, 0),
(538, 2, 158, 0),
(539, 2, 155, 0),
(540, 2, 159, 0),
(541, 2, 162, 0),
(542, 2, 163, 0),
(543, 2, 164, 0),
(544, 2, 175, 0),
(545, 2, 176, 0),
(546, 2, 177, 0),
(547, 2, 170, 0),
(548, 2, 171, 0),
(549, 2, 172, 0),
(550, 2, 173, 0),
(551, 2, 174, 0),
(552, 2, 165, 0),
(553, 2, 166, 0),
(554, 2, 169, 0),
(555, 2, 167, 0),
(556, 2, 168, 0),
(584, 1, 178, 1),
(585, 1, 179, 1),
(586, 1, 180, 1),
(587, 1, 181, 1),
(588, 1, 182, 1),
(589, 1, 183, 1),
(590, 1, 184, 1),
(591, 1, 185, 0),
(592, 1, 186, 0),
(593, 1, 187, 0),
(594, 1, 188, 0),
(595, 1, 189, 0),
(596, 1, 191, 0),
(597, 1, 190, 0),
(598, 1, 192, 0),
(599, 1, 193, 0),
(600, 1, 194, 0),
(601, 1, 195, 0),
(602, 1, 196, 0),
(603, 1, 197, 0),
(604, 2, 49, 0),
(605, 2, 50, 0),
(606, 2, 51, 0),
(607, 2, 52, 0),
(608, 2, 53, 0),
(609, 2, 178, 0),
(610, 2, 179, 0),
(611, 2, 180, 0),
(612, 2, 181, 0),
(613, 2, 182, 0),
(614, 2, 184, 0),
(615, 2, 183, 0),
(616, 2, 192, 0),
(617, 2, 193, 0),
(618, 2, 194, 0),
(619, 2, 195, 0),
(620, 2, 196, 0),
(621, 2, 197, 0),
(622, 2, 185, 0),
(623, 2, 186, 0),
(624, 2, 187, 0),
(625, 2, 188, 0),
(626, 2, 189, 0),
(627, 2, 191, 0),
(628, 2, 190, 0),
(629, 1, 198, 1),
(630, 1, 199, 0),
(631, 1, 200, 0),
(632, 1, 202, 0),
(633, 1, 201, 0),
(634, 1, 203, 0),
(635, 1, 204, 0),
(636, 1, 205, 0),
(637, 1, 206, 0),
(638, 1, 207, 0),
(639, 1, 208, 0),
(640, 1, 209, 0),
(641, 1, 210, 0),
(642, 1, 211, 0),
(643, 1, 212, 0),
(644, 1, 213, 0),
(645, 1, 214, 0),
(646, 1, 217, 0),
(647, 1, 215, 0),
(648, 1, 218, 0),
(649, 1, 219, 0),
(650, 1, 216, 0),
(651, 1, 220, 0),
(652, 1, 221, 0),
(653, 1, 222, 0),
(654, 2, 200, 0),
(655, 2, 204, 0),
(656, 2, 208, 0),
(657, 2, 202, 0),
(658, 2, 209, 0),
(659, 2, 199, 0),
(660, 2, 201, 0),
(661, 2, 203, 0),
(662, 2, 205, 0),
(663, 2, 206, 0),
(664, 2, 207, 0),
(665, 2, 210, 0),
(666, 2, 211, 0),
(667, 2, 212, 0),
(668, 2, 213, 0),
(669, 2, 214, 0),
(670, 2, 217, 0),
(671, 2, 215, 0),
(672, 2, 218, 0),
(673, 2, 219, 0),
(674, 2, 216, 0),
(675, 2, 220, 0),
(676, 2, 221, 0),
(677, 2, 222, 0),
(775, 1, 223, 0),
(776, 1, 224, 0),
(777, 1, 225, 0),
(778, 1, 226, 0),
(779, 1, 227, 0),
(780, 1, 228, 0),
(781, 1, 229, 0),
(782, 1, 230, 0),
(783, 1, 231, 0),
(784, 1, 232, 0),
(785, 1, 233, 0),
(786, 1, 234, 0),
(787, 1, 235, 0),
(788, 1, 236, 0),
(789, 1, 237, 0),
(790, 1, 238, 0),
(791, 1, 239, 0),
(792, 1, 240, 0),
(793, 1, 241, 0),
(794, 1, 242, 0),
(795, 1, 243, 0),
(796, 1, 244, 0),
(797, 1, 245, 0),
(798, 1, 246, 0),
(799, 1, 247, 0),
(800, 1, 248, 0),
(801, 1, 249, 0),
(802, 1, 250, 0),
(803, 1, 251, 0),
(804, 1, 252, 0),
(805, 2, 198, 1),
(806, 2, 237, 0),
(807, 2, 238, 0),
(808, 2, 239, 0),
(809, 2, 240, 0),
(810, 2, 241, 0),
(811, 2, 229, 0),
(812, 2, 230, 0),
(813, 2, 242, 0),
(814, 2, 243, 0),
(815, 2, 244, 0),
(816, 2, 245, 0),
(817, 2, 246, 0),
(818, 2, 247, 0),
(819, 2, 248, 0),
(820, 2, 249, 0),
(821, 2, 250, 0),
(822, 2, 251, 0),
(823, 2, 252, 0),
(824, 2, 223, 0),
(825, 2, 224, 0),
(826, 2, 225, 0),
(827, 2, 226, 0),
(828, 2, 227, 0),
(829, 2, 228, 0),
(830, 2, 231, 0),
(831, 2, 233, 0),
(832, 2, 234, 0),
(833, 2, 235, 0),
(834, 2, 236, 0),
(835, 2, 232, 0),
(896, 1, 253, 0),
(897, 1, 273, 0),
(898, 1, 274, 0),
(899, 1, 275, 0),
(900, 1, 276, 0),
(901, 1, 277, 0),
(902, 1, 278, 0),
(903, 1, 285, 0),
(904, 1, 286, 0),
(905, 1, 287, 0),
(906, 1, 288, 0),
(907, 1, 289, 0),
(908, 1, 290, 0),
(909, 1, 279, 0),
(910, 1, 280, 0),
(911, 1, 281, 0),
(912, 1, 282, 0),
(913, 1, 283, 0),
(914, 1, 284, 0),
(915, 1, 254, 0),
(916, 1, 255, 0),
(917, 1, 256, 0),
(918, 1, 257, 0),
(919, 1, 258, 0),
(920, 1, 259, 0),
(921, 1, 260, 0),
(922, 1, 261, 0),
(923, 1, 262, 0),
(924, 1, 263, 0),
(925, 1, 264, 0),
(926, 1, 265, 0),
(927, 1, 266, 0),
(928, 1, 267, 0),
(929, 1, 268, 0),
(930, 1, 269, 0),
(931, 1, 270, 0),
(932, 1, 271, 0),
(933, 1, 272, 0),
(934, 1, 291, 0),
(935, 1, 292, 0),
(936, 1, 293, 0),
(937, 1, 294, 0),
(938, 1, 295, 0),
(939, 1, 296, 0),
(940, 1, 297, 0),
(941, 1, 298, 0),
(942, 1, 299, 0),
(943, 1, 300, 0),
(944, 1, 301, 0),
(945, 1, 302, 0),
(946, 1, 305, 0),
(947, 1, 303, 0),
(948, 1, 304, 0),
(950, 1, 306, 0),
(951, 1, 307, 0),
(952, 1, 308, 0),
(953, 1, 309, 0),
(954, 1, 310, 0),
(955, 1, 311, 0),
(956, 1, 312, 0),
(957, 1, 313, 0),
(958, 1, 314, 0),
(959, 1, 315, 1),
(960, 1, 316, 1),
(961, 1, 317, 1),
(962, 1, 318, 1),
(963, 1, 319, 1),
(964, 1, 320, 1),
(965, 1, 321, 1),
(966, 1, 322, 1),
(967, 1, 323, 1),
(968, 1, 324, 1),
(969, 1, 325, 1),
(970, 1, 326, 1),
(971, 1, 327, 1),
(972, 1, 328, 1),
(973, 2, 315, 1),
(974, 2, 316, 1),
(975, 2, 317, 1),
(976, 2, 318, 1),
(977, 2, 319, 1),
(978, 2, 320, 1),
(979, 2, 321, 1),
(980, 2, 322, 1),
(981, 2, 323, 1),
(982, 2, 324, 1),
(983, 2, 325, 1),
(984, 2, 326, 1),
(985, 2, 327, 1),
(986, 2, 328, 1),
(987, 1, 329, 1),
(988, 1, 330, 1),
(989, 1, 331, 1),
(990, 1, 332, 1),
(991, 1, 333, 1),
(992, 1, 334, 1),
(993, 1, 335, 1),
(994, 1, 336, 1),
(995, 1, 337, 1),
(996, 1, 338, 1),
(997, 1, 339, 1),
(998, 1, 340, 1),
(999, 1, 341, 1),
(1000, 2, 329, 1),
(1001, 2, 331, 1),
(1002, 2, 330, 1),
(1003, 2, 332, 1),
(1004, 2, 333, 1),
(1005, 2, 334, 1),
(1006, 2, 335, 1),
(1007, 2, 336, 1),
(1008, 2, 337, 1),
(1009, 2, 338, 1),
(1010, 2, 339, 1),
(1011, 2, 340, 1),
(1012, 2, 341, 1),
(1214, 1, 342, 1),
(1215, 1, 343, 1),
(1216, 1, 344, 1),
(1217, 1, 345, 1),
(1218, 1, 346, 1),
(1219, 1, 347, 1),
(1220, 1, 348, 1),
(1221, 2, 342, 1),
(1222, 2, 343, 1),
(1223, 2, 344, 1),
(1224, 2, 345, 1),
(1225, 2, 346, 1),
(1226, 2, 347, 1),
(1227, 2, 348, 1),
(1321, 1, 349, 1),
(1322, 1, 350, 1),
(1325, 1, 351, 1),
(1327, 1, 352, 1),
(1328, 1, 353, 1),
(1329, 1, 354, 1),
(1330, 1, 355, 1),
(1331, 1, 356, 1),
(1332, 1, 357, 1),
(1333, 1, 358, 1),
(1334, 1, 359, 1),
(1335, 1, 360, 1),
(1336, 1, 361, 1),
(1337, 1, 362, 1),
(1338, 1, 363, 1),
(1339, 1, 364, 1),
(1340, 1, 365, 1),
(1341, 1, 366, 1),
(1342, 1, 367, 1),
(1343, 1, 368, 1),
(1344, 1, 369, 1),
(1345, 1, 370, 1),
(1346, 1, 371, 1),
(1347, 1, 372, 1),
(1348, 1, 373, 1),
(1349, 1, 374, 1),
(1350, 1, 375, 1),
(1351, 1, 376, 1),
(1352, 1, 377, 1),
(1353, 1, 378, 1),
(1354, 1, 379, 1),
(1355, 1, 380, 1),
(1356, 1, 381, 1),
(1357, 2, 349, 1),
(1358, 2, 350, 1),
(1359, 2, 351, 1),
(1360, 2, 361, 1),
(1361, 2, 362, 1),
(1362, 2, 363, 1),
(1363, 2, 364, 1),
(1364, 2, 365, 1),
(1365, 2, 366, 1),
(1366, 2, 367, 1),
(1367, 2, 368, 1),
(1368, 2, 369, 1),
(1369, 2, 370, 1),
(1370, 2, 371, 1),
(1371, 2, 372, 1),
(1372, 2, 373, 1),
(1373, 2, 374, 1),
(1374, 2, 375, 1),
(1375, 2, 376, 1),
(1376, 2, 377, 1),
(1377, 2, 378, 1),
(1378, 2, 379, 1),
(1379, 2, 380, 1),
(1380, 2, 381, 1),
(1381, 1, 382, 1),
(1382, 1, 383, 1),
(1456, 1, 384, 1),
(1457, 2, 382, 1),
(1458, 2, 384, 1),
(1460, 1, 385, 1),
(1461, 2, 383, 1),
(1462, 2, 385, 1),
(1469, 1, 386, 1),
(1476, 11, 1, 1),
(1477, 11, 383, 1),
(1478, 11, 385, 1),
(1479, 11, 34, 1),
(1480, 11, 35, 1),
(1481, 11, 36, 1),
(1488, 11, 387, 1),
(1489, 11, 388, 1),
(1490, 11, 389, 1),
(1491, 11, 390, 1),
(1492, 11, 391, 1),
(1493, 11, 392, 1),
(1494, 11, 393, 1),
(1495, 11, 394, 1),
(1496, 11, 395, 1),
(1510, 3, 1, 1),
(1511, 3, 383, 1),
(1512, 3, 385, 1),
(1513, 3, 34, 1),
(1514, 3, 35, 1),
(1515, 3, 36, 1),
(1516, 3, 315, 1),
(1517, 3, 316, 1),
(1518, 3, 317, 1),
(1519, 3, 318, 1),
(1520, 3, 319, 1),
(1521, 3, 329, 1),
(1522, 3, 320, 1),
(1523, 3, 331, 1),
(1524, 3, 330, 1),
(1525, 3, 332, 1),
(1526, 3, 333, 1),
(1527, 3, 334, 1),
(1528, 3, 335, 1),
(1529, 3, 336, 1),
(1530, 3, 337, 1),
(1531, 3, 338, 1),
(1532, 3, 339, 1),
(1533, 3, 340, 1),
(1534, 3, 341, 1),
(1535, 3, 382, 1),
(1536, 3, 349, 1),
(1537, 3, 350, 1),
(1538, 3, 351, 1),
(1539, 3, 384, 1),
(1540, 13, 1, 1),
(1541, 13, 383, 1),
(1542, 13, 385, 1),
(1543, 13, 34, 1),
(1544, 13, 35, 1),
(1545, 13, 36, 1),
(1546, 13, 315, 1),
(1547, 13, 316, 1),
(1548, 13, 317, 1),
(1549, 13, 318, 1),
(1550, 13, 319, 1),
(1551, 13, 329, 1),
(1552, 13, 320, 1),
(1553, 13, 331, 1),
(1554, 13, 330, 1),
(1555, 13, 332, 1),
(1556, 13, 333, 1),
(1557, 13, 334, 1),
(1558, 13, 335, 1),
(1559, 13, 336, 1),
(1560, 13, 337, 1),
(1561, 13, 338, 1),
(1562, 13, 339, 1),
(1563, 13, 340, 1),
(1564, 13, 341, 1),
(1565, 13, 382, 1),
(1566, 13, 349, 1),
(1567, 13, 350, 1),
(1568, 13, 351, 1),
(1569, 13, 384, 1),
(1570, 1, 387, 1),
(1571, 1, 388, 1),
(1572, 2, 387, 1),
(1573, 2, 388, 1),
(1574, 3, 387, 1),
(1575, 3, 388, 1),
(1576, 13, 387, 1),
(1577, 13, 388, 1),
(1578, 1, 389, 1),
(1579, 2, 389, 1),
(1580, 3, 389, 1),
(1581, 13, 389, 1),
(1582, 1, 390, 1),
(1583, 1, 391, 1),
(1584, 1, 392, 1),
(1585, 1, 393, 1),
(1586, 1, 394, 1),
(1587, 2, 390, 1),
(1588, 2, 391, 1),
(1589, 2, 392, 1),
(1590, 2, 393, 1),
(1591, 2, 394, 1),
(1592, 3, 390, 1),
(1593, 3, 391, 1),
(1594, 3, 392, 1),
(1595, 3, 393, 1),
(1596, 3, 394, 1),
(1597, 13, 390, 1),
(1598, 13, 391, 1),
(1599, 13, 392, 1),
(1600, 13, 393, 1),
(1601, 13, 394, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_jenis_fungsi`
--

CREATE TABLE IF NOT EXISTS `xi_sa_jenis_fungsi` (
  `id_jenis_fungsi` int(3) NOT NULL,
  `jenis_fungsi` varchar(100) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_jenis_fungsi`
--

INSERT INTO `xi_sa_jenis_fungsi` (`id_jenis_fungsi`, `jenis_fungsi`, `id_status`) VALUES
(1, 'Fungsi Public', 1),
(2, 'Fungsi Pendukung', 1),
(3, 'Fungsi Private', 1),
(4, 'Fungsi Belum Ada', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_jenis_user`
--

CREATE TABLE IF NOT EXISTS `xi_sa_jenis_user` (
  `id_jenis` char(2) NOT NULL,
  `nm_jenis` varchar(100) NOT NULL,
  `id_status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_jenis_user`
--

INSERT INTO `xi_sa_jenis_user` (`id_jenis`, `nm_jenis`, `id_status`) VALUES
('1', 'Pimpinan', '1'),
('2', 'Ajudan Pimpinan', '1');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_kontrol`
--

CREATE TABLE IF NOT EXISTS `xi_sa_kontrol` (
  `id_kontrol` int(11) NOT NULL,
  `nama_kontrol` varchar(255) NOT NULL,
  `label_kontrol` varchar(255) NOT NULL,
  `url_kontrol` varchar(255) NOT NULL,
  `deskripsi_kontrol` varchar(255) NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_kontrol`
--

INSERT INTO `xi_sa_kontrol` (`id_kontrol`, `nama_kontrol`, `label_kontrol`, `url_kontrol`, `deskripsi_kontrol`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`, `id_status`) VALUES
(1, 'home', 'Home', 'home', 'Halaman Dashboard atau Halaman Utama', '', '2017-06-04 19:36:44', '::1', 'ntahlah', '2020-09-22 10:02:28', '::1', 1),
(2, 'fungsi', 'Fungsi', 'fungsi', 'Halaman Manajamen Fungsi', '', '2017-06-04 19:37:18', '::1', '', '2017-06-07 11:42:03', '::1', 1),
(3, 'kontrol', 'Kontrol', 'kontrol', 'Halaman Manajemen Kontrol', '', '2017-06-04 19:37:38', '::1', '', '2017-06-07 11:41:55', '::1', 1),
(4, 'module', 'Module', 'module', 'Halaman Manajemen Module', '', '2017-06-04 19:37:58', '::1', '', '2017-06-07 11:41:47', '::1', 1),
(5, 'menu', 'Menu', 'menu', 'Halaman Majamen Menu', '', '2017-06-07 11:41:18', '::1', '', '2017-06-07 11:41:18', '::1', 1),
(6, 'group', 'Group', 'group', 'Halaman Manajemen Group', '', '2017-06-10 22:23:53', '::1', '', '2017-06-10 22:24:15', '::1', 1),
(7, 'users', 'Users', 'users', 'Halaman Manajemen Users', '', '2017-06-14 19:18:54', '::1', '', '2017-06-14 19:19:06', '::1', 1),
(8, 'admin', 'Admin', 'admin', 'Halaman Manajemen Admin', '', '2017-06-21 10:56:34', '::1', 'ntahlah', '2020-08-19 14:39:14', '::1', 1),
(9, 'inbox', 'Pesan Masuk', 'inbox', 'Halaman Data Pesan Masuk', 'yogisolop', '2020-05-11 12:21:08', '::1', 'yogisolop', '2020-05-11 13:06:23', '::1', 1),
(10, 'hospital', 'Data Fasyankes', 'hospital', 'Halaman Data Fasilitas Layanan Kesehatan', 'yogisolop', '2020-04-08 15:42:12', '::1', 'yogisolop', '2020-04-24 12:59:37', '::1', 1),
(15, 'instansi', 'Data Instansi', 'instansi', 'Data Instansi', 'ntahlah', '2020-07-23 08:59:45', '::1', 'ntahlah', '2020-07-23 08:59:45', '::1', 1),
(16, 'ajax', 'Data Ajax', 'ajax', 'Ajax', 'ntahlah', '2020-07-23 09:02:02', '::1', 'ntahlah', '2020-07-23 09:02:02', '::1', 1),
(30, 'spj', 'spj', 'spj', 'spj', 'ntahlah', '2020-08-19 10:49:55', '::1', 'ntahlah', '2020-08-19 10:49:55', '::1', 1),
(37, 'agenda', 'agenda', 'agenda', 'agenda', 'ntahlah', '2021-02-11 11:02:11', '::1', 'ntahlah', '2021-02-11 11:02:11', '::1', 1),
(38, 'disposisi', 'disposisi', 'disposisi', 'disposisi', 'ntahlah', '2021-02-11 11:05:24', '::1', 'ntahlah', '2021-02-11 11:05:24', '::1', 1),
(39, 'draft', 'draft', 'draft', 'draft', 'ntahlah', '2021-02-17 14:31:35', '::1', 'ntahlah', '2021-02-17 14:31:35', '::1', 1),
(40, 'dprd', 'dprd', 'dprd', 'dprd', 'ntahlah', '2021-02-22 09:49:28', '::1', 'ntahlah', '2021-02-22 09:49:28', '::1', 1),
(41, 'pegawai', 'pegawai', 'pegawai', 'pegawai', 'ntahlah', '2021-03-31 11:10:38', '::1', 'ntahlah', '2021-03-31 11:10:38', '::1', 1),
(42, 'dispokeluar', 'dispokeluar', 'dispokeluar', 'dispokeluar', 'ntahlah', '2021-04-08 10:37:54', '::1', 'ntahlah', '2021-04-09 15:49:05', '::1', 1),
(43, 'dispomasuk', 'dispomasuk', 'dispomasuk', 'dispomasuk', 'ntahlah', '2021-04-08 10:38:05', '::1', 'ntahlah', '2021-04-09 15:49:20', '::1', 1),
(44, 'laporan', 'laporan', 'laporan', 'laporan', 'ntahlah', '2022-01-05 09:28:14', '::1', 'ntahlah', '2022-01-05 09:28:14', '::1', 1),
(45, 'lap', 'lap', 'lap', 'lap', 'ntahlah', '2022-01-12 15:29:48', '103.160.118.2', 'ntahlah', '2022-01-12 15:29:48', '103.160.118.2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_level_akses`
--

CREATE TABLE IF NOT EXISTS `xi_sa_level_akses` (
  `id_level_akses` int(3) NOT NULL,
  `level_akses` varchar(100) NOT NULL,
  `nick_level` char(3) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_level_akses`
--

INSERT INTO `xi_sa_level_akses` (`id_level_akses`, `level_akses`, `nick_level`, `id_status`) VALUES
(1, 'SUPER ADMIN', 'SAD', 1),
(2, 'Administrator', 'ADM', 1),
(3, 'Pimpinan', 'PIM', 1),
(13, 'Ajudan', 'AJD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_log_akses`
--

CREATE TABLE IF NOT EXISTS `xi_sa_log_akses` (
  `id_log_akses` int(11) NOT NULL,
  `history_log` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_log_login`
--

CREATE TABLE IF NOT EXISTS `xi_sa_log_login` (
  `id_log` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login_time` int(11) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `user_agent` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_log_mobile`
--

CREATE TABLE IF NOT EXISTS `xi_sa_log_mobile` (
  `id_log` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `device_id` text NOT NULL,
  `device_model` text NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_date` datetime NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0=Logout, 1=Login'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_log_session`
--

CREATE TABLE IF NOT EXISTS `xi_sa_log_session` (
  `id_log_session` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login_time` int(11) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `id_status` int(1) NOT NULL,
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_log_session`
--

INSERT INTO `xi_sa_log_session` (`id_log_session`, `id_users`, `username`, `login_time`, `ip_address`, `user_agent`, `id_status`, `session_id`) VALUES
(1, 90, 'gubernur_sumbar', 1638848430, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 1, 'c472115780157ac8a182012ffebc50a9f8b08ae181419ca2ed745499b6b8ffb6e871066d966fc0c1197468de74b7297689c0230b6ea25950526074bc3ee353150S9vKx5uv0v4Gd183LsKRYCuD1fUOnN6AawojHRCwhbRQymhmImg5jPS2SWvJwsR'),
(2, 90, 'gubernur_sumbar', 1638848450, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 0, 'cb2b429e369364a31ebe734205c97e2d491863add2b9a04fa905b0a71233d4e47f8fbb33c3e972a7bd0cafdf347625931c5bc5d96380fe7fee8a936ff27dddaaGYlA+uzi7j+WpRq7bBCgKq4GjF5OZpjutbdN+k8ZgTuQ7T7FocOdjwI8bWtQex1Z'),
(3, 1, 'ntahlah', 1638848461, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 0, '65fc10b6a9ec4ade91921bd38bcc5e1e1d7f18a485918aa9e425415b53c1bb3121b986185993c6d6a2cee92b0d82cd87b4195b4f041ea0aa5cc6eb3b8e58ba264G6/pHpraY6Rr+xq2J5+UbGVaWovoe/IugrQzo5iKX9ywc/GjVU1EidGbkmmdltw'),
(4, 90, 'gubernur_sumbar', 1638848590, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 1, '67ebb707b3d45a0339e0938d5f520a39ab5464a8aa56997d377ae3555d5a0fbc3a78c46976cab6b374caf50a2cff6206fdb348b3063cf41e3caf4f84eceb2309N8vm+Ec6ELPwgkgOyNa8pyj5Nmb4AAvzy+sghghMjgoqHdoX8OyruIfaz6MjXjdz'),
(5, 90, 'gubernur_sumbar', 1638848715, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 0, '9d8939b66b88b8312a6c45e1a06fca5a8d4066d0f353c22afab3fb251deaf09968edd995575cd9bb3e569848754343cef98c72a6cf196cc566558a8447e8b92aFxd2X9mX8te6NHMlGkawj0rkzFFtmsM6J8tgDUahBujjtIxZ6KQx6IHIs7BLG5+S'),
(6, 88, 'ajudan_gub', 1638850068, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 1, '83ddac495bb8b16453c84b0ca84885f052e853b4b52bde91fe52516ed0ba2802c84b9fc31113900fb734698cb9031f6fd4926a7013c548e5cc863ed25d6a1c2bl8i7gRR3sjhVUDtNLnFNA6+8xIj3VTd7b0XJnGbyk95GqDARUMy9N4w0JEjkQ9su'),
(7, 90, 'gubernur_sumbar', 1638850108, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 1, '93aa48b2be24ad1b61dfba335128196dba30b0f99358813de14c8cc113ecc5ff22e109a9de71e1847fe05b15a0db4457bdcdc9efdf645287a952e3f2239c8299R4HDnpY9fPO2WNMDunkhCxchnA9Pejr6kaEOd/LV+WsqNozgkaay+qngq7dSKE+b'),
(8, 1, 'ntahlah', 1638850432, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 1, 'd934ef8434af408110039cb8e992b0e6b6e5476be37e9d93d2defb4c2436835984ecc73dc24d92a2f911738afdf64aaf80a4e940c8bbd7659c4159043ef8e726Jo3ha7XPVZ60/l6iV1Wf/OWoDSrZQph0Kd+EVguw2DWH+DqLyxKXR6ndsIcsLAnh'),
(9, 1, 'ntahlah', 1638863170, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 1, '5081d840ff321181447f7d57539f99e5bf8e5a394565da61177842ac96b7bf6eccc3fc866aa6b29d4f11c077cbf74edecfc97c2dd3783fd3ceae65aa51a4202ckR4TfdzVmCGPDrUwgoTHgXV3W7FZOptmu8vXij+mfOZlmgiKuE3x4rzhnThVeZdV'),
(10, 1, 'ntahlah', 1639111583, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36', 1, 'e528542deff3cc49fa584d896783b0461bbe8e9c0f843203466378491f4739e90c3b929c0f7563b1585ac5b8930f48829f11c16d0557d86f6a8d90e34fd0e29dS1OnP+9MgGoC0hFADbAl3aq3R7gtTYgD+fCnrK8+1hL0wlFGVP4oVdmNeLx+9rfZ'),
(11, 1, 'ntahlah', 1639118146, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36', 0, '765b47b00ad293c9d1831aa804a7d20a4047cb2a0cecc530c6d5cb0d98dd7477e5d7939542f980fc1b32906da72f2a7db8a139e056eb272d4451db062e4950a5Lon420MdV/mUKhhKdjegpZzzIQoCZ2eCBoHhNvkA+yoYmAMY96jM2o44gwj19GsX'),
(12, 1, 'ntahlah', 1639118183, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36', 1, '9db8f88c7070661d8ad66d7ef8d38525a78ebd516a312a40172516eb9413419712147eff3d712e16df5fe970c0e75507ed8cb9faed33f7425b64db9f459b232bw4b3EUST1I4K0Zd2T/jq73s8O6eoAG8S//z1p0h7MjYR+wmjfCQgu05B9UGf1Aa8'),
(13, 90, 'gubernur_sumbar', 1639118689, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36', 1, 'e828dd7fd3f83a7c90c0ea98feb296200feb90de4821f5544ef5eb430817e4aaf36bc287d408bf6efc136ff470c3de0d5ad7201da5e2129268ea54965c1d1da2JCgkoNWtd5AymDxtGTWkhSN0+66f7JSe0Q9WOQLNt4hwdDPjAIGhqz20FePHLcUk'),
(14, 1, 'ntahlah', 1639118852, '::1', 'PostmanRuntime/7.28.4', 1, '0'),
(15, 90, 'gubernur_sumbar', 1639118879, '::1', 'PostmanRuntime/7.28.4', 1, '0'),
(16, 90, 'gubernur_sumbar', 1640049434, '::1', 'PostmanRuntime/7.28.4', 1, '0'),
(17, 88, 'ajudan_gub', 1640049567, '::1', 'PostmanRuntime/7.28.4', 1, '0'),
(18, 90, 'gubernur_sumbar', 1640049662, '::1', 'PostmanRuntime/7.28.4', 1, '0'),
(19, 1, 'ntahlah', 1640830765, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 1, '0b4d842d94a02d91d1daa462461f1b36534ae2e83272363979501678f05ec9f3bfd6c91b30e033525e331be99ecc332cc8359bc4118566dfd1b0480d326edcd1JEPD11061GI+VSeEY502xOL8/j2iBxny2h5evEOlvAD7vnItipM3CV/f53OuWMvL'),
(20, 1, 'ntahlah', 1641173876, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 1, '249ed9be1f7359addda325ea03e1f95d35d11bd68cf41ba41d24e5386872bf36fa727307edc861bf355d5520808682c3823171eab8baeb5472878ee878c962cePh8Ac9wiMKvemrKzY7Gx3W+fzWSspr8WyJ2v8TN97iFkHwl7WkOFoEPvhnnDjS1z'),
(21, 1, 'ntahlah', 1641348190, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 0, '7e62669aeeb58892bf1001f6b9194f021bf304b58b173d4a32435794ecd8c0c34b17da30c4e3a6dc06faec0d4661581e6fe354a60d5a4ab88fd251cff164bb59Isl8C9zTE3q0Ro+yJ4pcOi2k0VB+gsWB33rg5FSpYyc1l9Rd1p5MZVYT3xPqyxkT'),
(22, 1, 'ntahlah', 1641354436, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 1, 'cd801c1c01d4ca8c0fab0049534051f729a7e729a136c68f4252208ddb9908d7a2a03e2a15c948963ff9ca12f542894be6cdf8f01d5ccbb735a556b1cbc72e18srzbpfabgoAsjzVl9DfNS/qti3QbWm5h2LshXqITaqw5kSTetHHBVpQBcfRA510R'),
(23, 1, 'ntahlah', 1641370859, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 1, 'e0037c5ea9b956c10e6116377c7091e9264e8cb5ffcb4b5dbd1ec0420166da1adee6da8007f9a69bacaa2de1384e18b548390bbc0cafeaa3d01ed7c5ec89120bW7Tl+orJZeqMogqhAtClWCZfqI46vDIx8fa0v8QwrEMSE8/h1QCXHYNaEAmDEBm7'),
(24, 88, 'ajudan_gub', 1641783015, '182.1.33.121', 'Dalvik/2.1.0 (Linux; U; Android 8.0.0; SM-J720F Build/R16NW)', 1, '0'),
(25, 1, 'Ntahlah', 1641783071, '182.1.36.51', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.104 Mobile Safari/537.36', 1, '98df52e51a9dcad48c5fc71d6aed9c663560d6b600650df6645a04698e2f574440e3bea92d52dc8e7d0cae4ed2058faaf750e9529114d328effff06c20397121pTLWzbNXB7Z9a0F2Qlx0Yt61lDzTaeg4/3nBRJXo2ucSOw7M4+b3v/X1BkLDfruI'),
(26, 1, 'Ntahlah', 1641783301, '182.1.36.51', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.104 Mobile Safari/537.36', 1, '34363dfeb092c502bda9f3e9067fe3811645419fb7baa171480c978f056beaa52fbd2c310d25aa40dc4e79259130a219f24bc7f4d8ee0a9b1bbdb7f439809be1PETKc73s2uS1ARoGFLr9gHslHfW/4AIEap00a9FcB6Wc3pUjXjF8TEtJiVmMYiT8'),
(27, 88, 'Ajudan_gub', 1641783409, '182.1.33.121', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-J720F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.62 Mobile Safari/537.36', 1, '6a7a2317fd0caafb2bbd1e61a4e018130c90eef568ef8b748e851def1af3729d0f21049d6e4358b5e12523255637bce86c5183d8279c1b82eefc67fc5081b19848txTAkHepjMSGd06EF+9l6YsWzCcypCg1WV+kdABg8QGcrSWgufylIxBsqpdZ2S'),
(28, 88, 'ajudan_gub', 1641783582, '36.69.9.128', 'Dalvik/2.1.0 (Linux; U; Android 11; sdk_gphone_x86_arm Build/RSR1.201013.001)', 1, '0'),
(29, 1, 'Ntahlah', 1641784315, '182.1.33.121', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-J720F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.62 Mobile Safari/537.36', 1, '56c24eb9e1cc90106ef34275a64e6231034bc277b134831f5e236bb4f436b24e4f69e2e9307f728027264a359d0bf27b6a7ff43bac45057ae1d0f4f4c201944fZmA7WfLlv5QTYsnI8+x6yY3EOrV8asILprXOnKfhpIzrppx3hUbl55QHH4SaPEkR'),
(30, 1, 'ntahlah', 1641786504, '182.1.2.86', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 1, '5d64fba930a8759bd942baff581150d9f531995a35c4eb6d0c872bbdd81b0a8945f3bb5ce7ecd5791b9fc4ba8c5d8a146561bb28e7abc35b1056477cf8c56fbaz8LuF5DvGOhnEIzpSuKuLElImlXHrBUhjmmCIFDfuJvvYwrA4YxUxav+5+eOe9ee'),
(31, 88, 'ajudan_gub', 1641786555, '182.1.9.96', 'Dalvik/2.1.0 (Linux; U; Android 11; SM-N770F Build/RP1A.200720.012)', 1, '0'),
(32, 1, 'ntahlah', 1641786654, '182.1.2.86', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 1, 'c834265e10559fa87eae69ae2a90939678feba92691b99926affdd0d2389ecce13b0da8afdbfb462182975585a42f89d2de06b012bbd6bc7b90fff98024d5cc0RKuA2jNmzQTIgldCEvYhgQ5v+H1+G1jSIAqI8el5JvxdLmqUYZwTUAI5m7oBVRi/'),
(33, 1, 'ntahlah', 1641797854, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'c0f33020eda1c98f460c477419e399965290e7eb8cae5fe0f63c89644ccda9b79bf2958f7a6dbecf3618c04720018aab04a40f9807c014bd09a0a73a5e1f1013OqTzXPf1Pl9xpOivJzLwvzQBFB2AyJGdQnKO6sfGqoaochHvMlk3WFSzAwmP48r+'),
(34, 1, 'ntahlah', 1641803281, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '905b393f32188fef95e8000333959c0a14e3512c941ebee86c62aa99934729bf0aea2447e9d26f5ce7b80de19fa617e1bb7a10c66c7ec7a32655325c5eb81a14thKapPkYR/2OeYvtgqujccKAI22TA/DtM6x7PMVpoKgeRLouuBN0gZO7DLGdG9zl'),
(35, 88, 'ajudan_gub', 1641805034, '36.69.9.128', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(36, 88, 'ajudan_gub', 1641805074, '36.69.9.128', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(37, 88, 'ajudan_gub', 1641805257, '182.1.2.189', 'Dalvik/2.1.0 (Linux; U; Android 8.0.0; SM-J720F Build/R16NW)', 1, '0'),
(38, 88, 'ajudan_gub', 1641805361, '36.69.9.128', 'Dalvik/2.1.0 (Linux; U; Android 11; SM-M307F Build/RP1A.200720.012)', 1, '0'),
(39, 1, 'ntahlah', 1641806589, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '26fb276bbb8f044829cb018af4b047c4f9cb5636f45182b49701219af6a668879ed25bd8146cb853bcb0ca802724cb0b118be95e249f1d6131ad67ec40071df4lDP8pSm2BOC+TORZP0z5kVWXrwCyjryF50soHpwEFYIhPZipK56Qb0Qhrx7D2IA2'),
(40, 1, 'ntahlah', 1641861840, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '655e83dc9abc2385c485d2d715d5c80d8c97ee2607f13f620fd94392f34f1153b49fce1f4f7a9bf76f099629361ded14c4763afc73787590a95fb3f22521914ftp53jgCdVx2KQjnm/9bKT5KAJNH5ZwLVZRzC6JlOd8z4tbg5QSTwFQunU/og9bTH'),
(41, 88, 'ajudan_gub', 1641865729, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(42, 1, 'ntahlah', 1641950870, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 0, '393e03519cc8f657a639ec9baea5f6bca267e99fd301d7ab8edb0d78852ac7d84cd89f5d8fb21f24f3e75fbd2ba745b2c4e6388cdaf684452f3e03ee6f1932fa6avP8BI+8Z0ed9/R1Lft+5eqrwC4TLlDt1tQlwVyAC8H5qEpbuILv1yEmm2Barg3'),
(43, 90, 'gubernur_sumbar', 1641951339, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(44, 88, 'ajudan_gub', 1641952638, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 11; M2101K6G Build/RKQ1.200826.002)', 1, '0'),
(45, 88, 'ajudan_gub', 1641953532, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(46, 88, 'ajudan_gub', 1641956035, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(47, 1, 'ntahlah', 1641962714, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'c5da623d48664a7621f3f1dced5b6de6fe0dbebe60d6a2cac4fe8e0b9123b3428806cf350fc3611f86ba2616c3eb424a352705af17843deb89801a0a1d1fd8bb+J71FBU9YIt4NuPVpFOJOMskrOtefgZOaSzKE6KLebTO0Of+xNun4nLWdNXiRB1P'),
(48, 1, 'ntahlah', 1641975078, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '305853316cc7551494835af3069173c659e58d9a31c54c0ee34a579fc4f9f53de4821243199f93ec014c696f707b49f172a23bc0e74c26f4deb6f51bded058731pmC+OC87ney7Y9xBYkVaxm3F2OfXOuBoTQ0sjFYr2wbaXsYWGjriGl7QWW3N1Dw'),
(49, 90, 'gubernur_sumbar', 1642037729, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(50, 88, 'ajudan_gub', 1642038039, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(51, 88, 'ajudan_gub', 1642039803, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 1, 'd124e2294677141a416b9b467fc5eee0192f84493697d35b3fae2348c83901819c2ac55eef87cba4ae659d3bbb859b70c10808d7d55f3c3cee29baa93ddbb2aaTv7B6z7n8WMK0cbJgr/JR7xDLkEavD22QbcWIHE+OcgEgYbfKEceeT1OMaInw4dy'),
(52, 1, 'ntahlah', 1642041142, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '1035202bd0a76af9df9cec175df92dd3921db30e02d3f889677945b68155dfe1a6f0b8ca99114018aa19418ac1b2a1a15dbacf6aa232713333ec1b263eab6d7bhbYUkowseiZ35pBLBt+qf93GIaxrf3FBleS+yjp6xYync8/otQWyzT+vkEN8G6dM'),
(53, 1, 'ntahlah', 1642049165, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 0, '9e158639ba3b9ae30825365744fd15b9024f3a224b291d8c4d971a75d5cff659544b2563599435987931ca853bfc1cdb7362962095723c1c45985ed61ce7f7bbISzcJUnWVgg/vNDasEAay8lsKJmVKUFPJzbxRGKBV7gov0W68ZL0Qmo58EYVIdOu'),
(54, 88, 'ajudan_gub', 1642060657, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(55, 90, 'gubernur_sumbar', 1642060896, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(56, 88, 'ajudan_gub', 1642144386, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(57, 88, 'ajudan_gub', 1642389149, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'bdca5321fdcb7a61d0e63b435fec9aea622481743bd2ca525863a1ea1fb5399a4a0c2b68f0f5c88455bfe69481ff66119440a6a6515e429efccd2b0fe757d28fZ3bfk+MhEPODwck7kpnexF0W5tasTVbpd1N8uVv3OfZfMnGn9AXjiaRYnKTvc0ub'),
(58, 88, 'ajudan_gub', 1642467405, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '963d15ae7594e54fc07bb7151470df0da7675a2af15d687e90d512b8d276793fa4b80d59bf7c95325d1a067f4f0f6c23a6d45b7128614b00d6728a4ba82f4fc3BKA67KNnbLLh0sCoq3qiRKh+7o1w4hX5/3XnvWlG4/3twwmeVYVfGMfnFZS7vWP7'),
(59, 90, 'gubernur_sumbar', 1642492800, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(60, 88, 'ajudan_gub', 1642493674, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(61, 90, 'gubernur_sumbar', 1642497541, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(62, 88, 'ajudan_gub', 1642497824, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '9f9f91eb0c9e6159512b20c5934c83902258d78135f4ee1e2e84fd2921c430ac79955a27a37c8d569cc435037e7f48f4817582f986a598b1a0650775af9e726dnBmC31QLXm47G6mTj4s7J49mt7NzUi+uB2iCIt3Y5dp0vhDkMgqLmyhSqDyBQcis'),
(63, 1, 'ntahlah', 1642555990, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '66a67f073aea4d8077917714bf48dd6e230856d7546bd012043d012a9a34b71e8604fabbdd762043d213357c645cb3d6bba317a4aed0ed70056970a2502918eflkj+ArCxgGVzJuvmfZoKND4KFb9fT8/8RSvQm8eXnvpBmR2PPiijlp00t4rwqdCc'),
(64, 90, 'gubernur_sumbar', 1642556538, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(65, 88, 'ajudan_gub', 1642556585, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(66, 88, 'ajudan_gub', 1642560291, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'ef437e7a9e3ea396f7cd771f80b322b4f4a53d9e03815686c2dff393f16d31a44bba613e9e3292a618cdafafd79759aaf73bc3514615fca11b284652c73709beH5qegPRvHm7HqIeyCjpKkGhMIESGX9hfIEU0mgR6j9En7f7L4CwYShxq/uGSMnsU'),
(67, 1, 'ntahlah', 1642573925, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '52f7967ff5d3cc31dc2b58c9f52580a1807534a3c32b8c2fba6085ebb41f4032d89ca9dad9fe42290f508e6295e909ab1b3f6d5da5d1cc82b620ced2375258ad2Hl5O1iLz4ZHAIhZwrAe2SodCGh0IBghyNRgwF1I5y1OmLN5RoPbnk2Q4zVe5UZd'),
(68, 88, 'ajudan_gub', 1642580035, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(69, 90, 'gubernur_sumbar', 1642580092, '103.160.118.2', 'PostmanRuntime/7.28.4', 1, '0'),
(70, 90, 'gubernur_sumbar', 1642580285, '103.160.118.2', 'PostmanRuntime/7.28.4', 1, '0'),
(71, 88, 'ajudan_gub', 1642580289, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(72, 88, 'ajudan_gub', 1642580308, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(73, 90, 'gubernur_sumbar', 1642581384, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(74, 90, 'gubernur_sumbar', 1642581853, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(75, 90, 'gubernur_sumbar', 1642582202, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(76, 90, 'gubernur_sumbar', 1642582262, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(77, 88, 'ajudan_gub', 1642582439, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(78, 88, 'ajudan_gub', 1642582561, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.0.2; Android SDK built for x86 Build/LSY66K)', 1, '0'),
(79, 88, 'ajudan_gub', 1642642420, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(80, 88, 'ajudan_gub', 1642645180, '103.160.118.2', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 0, 'c4969ced08470e836807d92f57fc82ad1bc6d4023c888c0674c2bb8b2a8eea59b49251d51d7d5541ea819631773b116f94b5f1bb18902109d548a1ea168d1456bu/w7qXH8iblIG9SnKwxeyPwgdv/ytmvvhkrXpGMMDwxwR2Y2rNzuoyhLay4t1vP'),
(81, 88, 'ajudan_gub', 1642645228, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '4f3cc606d3362020c1f9461cf613f379c55ce08886c976ddb8d208ce46129d2a6099edab13a1193c42dd424de37ef74e85065b2876923f739b5ffe5044791d941WRWd5XurdpPZlyFvcdRCMcF4aNQWGI2l0sHQM3Ekt1Z2SR+bOL+MKk8YuacVgS+'),
(82, 88, 'ajudan_gub', 1642645444, '103.160.118.2', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '657dac6d09698fa613deaca8ace6a26a03eca233a5e92797e3d4c0994bf937692562810eece9d6d6572b28c4f9f14d43f40ef274ba6710ccaad30a2149f4051f9IOdFUw0130sy2Vf7p8AEY/MMuMCir/bGn3Vz9Pb9qM2NZdMek5BCReQEiEySEx/'),
(83, 88, 'ajudan_gub', 1642647169, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 7.1.2; SM-G975N Build/N2G47O)', 1, '0'),
(84, 88, 'ajudan_gub', 1642648550, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(85, 90, 'gubernur_sumbar', 1642650993, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(86, 88, 'ajudan_gub', 1642651609, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(87, 88, 'ajudan_gub', 1642651686, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(88, 88, 'ajudan_gub', 1642653271, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(89, 88, 'ajudan_gub', 1642663468, '103.160.118.2', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 0, '028a0ca6b0e3f428a1b07c527506c33ce463fe19d3d611f56309759f936a783d2e2acc20f4f19e4480624ef844df14d2f579f18680684c342ea81fb9c608f355jHDQR/sWoybFrboYcp7CyC9fckkJ4ELjUzOkanI90q+ywsD0DUKDxX1X+3eqjrp3'),
(90, 88, 'ajudan_gub', 1642665249, '103.160.118.2', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'af60e6f97d6e7ba13996d87ed60248b2aac9a6634de91529090f7eef12d6bd47c134ae4fd3c6389640fd368c1f7bca3c006beb0a434a61b08d8dfc8c17e0031e2WvLBDMXlCY4rYpqQ/INIG+PBwnQF5mz0CsSACF4fr0HTcThaSX73YPWSHSqJfFl'),
(91, 1, 'ntahlah', 1642666910, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'e011d23019e16d5813293a92d72e667db0e11529c88bd53366534e7fd4ed01f30ec42dad490f603e4d28f1d3ee853548c4f30a8546c14025e2c63014dbe4258bSgrmldmSO1aiiD4g2dIKhHVvgKMu3PvncNqvE2tn+tAysZVXHu+2AuuFcvt3YXyL'),
(92, 88, 'ajudan_gub', 1642667914, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(93, 88, 'ajudan_gub', 1642671084, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(94, 88, 'ajudan_gub', 1642671296, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; Android SDK built for x86 Build/OSM1.180201.007)', 1, '0'),
(95, 88, 'ajudan_gub', 1642728981, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(96, 88, 'ajudan_gub', 1642730872, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(97, 88, 'ajudan_gub', 1642731134, '103.160.118.2', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '1ff87b0054e18dd5efa937c017fa5b29faeeff2a90a8d929e4153196a3373bf73b73d2062ac9ce4b42db819b3d3b78ee62aab58b53746c25ddac253bd79e5294Idu6md/wGAPVRVYth3UUyw/h+o39OD1rqOnB876d7jVIZEiIyhJwA4iNHGQ43UY1'),
(98, 88, 'ajudan_gub', 1643001912, '36.69.8.120', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(99, 88, 'ajudan_gub', 1643002028, '36.69.8.120', 'Dalvik/2.1.0 (Linux; U; Android 11; sdk_gphone_x86_arm Build/RSR1.201013.001)', 1, '0'),
(100, 88, 'ajudan_gub', 1643002134, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 5.1; A1601 Build/LMY47I)', 1, '0'),
(101, 88, 'ajudan_gub', 1643002230, '103.160.118.2', 'PostmanRuntime/7.28.4', 1, '0'),
(102, 88, 'ajudan_gub', 1643002344, '103.160.118.2', 'Dalvik/2.1.0 (Linux; U; Android 11; M2101K6G Build/RKQ1.200826.002)', 1, '0'),
(103, 1, 'ntahlah', 1643002397, '103.160.118.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'fd43b78f015f0ab38adfae54bda37ab6315219d00595ccfc718cd85ed2d8e19dba199bf0420011f3591b4df077a2d8dbde4afa278b3a0133053a90d96e9623f46/OMjxockExXbHgYoWbKZXlubQlzVjJKEh6A6vjz8pK+BM1Wv3F87fp8yRcO01C8');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_menu`
--

CREATE TABLE IF NOT EXISTS `xi_sa_menu` (
  `id_menu` int(11) NOT NULL,
  `title_menu` varchar(255) NOT NULL,
  `url_menu` varchar(255) NOT NULL,
  `icon_menu` varchar(100) NOT NULL,
  `order_menu` int(3) NOT NULL,
  `id_rules` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_parent` enum('Y','N') NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_menu`
--

INSERT INTO `xi_sa_menu` (`id_menu`, `title_menu`, `url_menu`, `icon_menu`, `order_menu`, `id_rules`, `parent_id`, `is_parent`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`, `id_status`) VALUES
(1, 'Beranda', '', 'fa fa-home', 1, 1, 0, 'N', '', '2017-06-07 12:09:31', '::1', 'ntahlah', '2021-02-11 11:09:20', '::1', 1),
(2, 'Manajemen', '#', 'fa fa-gears', 2, 0, 0, 'Y', '', '2017-06-07 12:09:47', '::1', 'yogisolop', '2019-04-23 14:32:10', '36.67.76.99', 1),
(3, 'Fungsi', '', '', 1, 2, 2, 'N', '', '2017-06-07 12:10:03', '::1', 'yogisolop', '2019-04-23 14:32:04', '36.67.76.99', 1),
(4, 'Kontrol', '', '', 2, 6, 2, 'N', '', '2017-06-07 12:10:26', '::1', 'yogisolop', '2019-04-23 14:32:20', '36.67.76.99', 1),
(5, 'Module', '', '', 3, 10, 2, 'N', '', '2017-06-07 12:10:48', '::1', 'yogisolop', '2019-04-23 14:32:26', '36.67.76.99', 1),
(6, 'Menu', '', '', 4, 16, 2, 'N', '', '2017-06-07 12:11:06', '::1', 'yogisolop', '2019-04-23 14:32:32', '36.67.76.99', 1),
(7, 'Group', '', '', 5, 20, 2, 'N', '', '2017-06-10 22:25:19', '::1', 'yogisolop', '2019-04-23 14:32:37', '36.67.76.99', 1),
(8, 'Users', '', '', 6, 25, 2, 'N', '', '2017-06-14 19:20:01', '::1', 'yogisolop', '2019-04-23 14:32:44', '36.67.76.99', 1),
(38, 'Input Data', '#', 'fa fa-pencil', 3, 0, 0, 'Y', 'ntahlah', '2021-02-11 11:06:54', '::1', 'ntahlah', '2021-02-17 14:27:29', '::1', 1),
(39, 'Draft Agenda', '', 'fa fa-caret-right', 1, 332, 38, 'N', 'ntahlah', '2021-02-11 11:07:28', '::1', 'ntahlah', '2021-02-17 14:36:22', '::1', 1),
(40, 'Data Agenda', '#', 'fa fa-calendar', 4, 0, 0, 'Y', 'ntahlah', '2021-02-11 11:07:42', '::1', 'ntahlah', '2021-02-17 14:29:27', '::1', 1),
(41, 'Agenda Harian', '', 'fa fa-caret-right', 1, 315, 40, 'N', 'ntahlah', '2021-02-11 11:08:04', '::1', 'ntahlah', '2021-04-01 09:20:59', '::1', 1),
(42, 'Laporan', '#', 'fa fa-print', 5, 0, 0, 'Y', 'ntahlah', '2022-01-05 09:30:37', '::1', 'ntahlah', '2022-01-12 15:31:14', '103.160.118.2', 1),
(43, 'Cetak Per Bulan', '', 'fa fa-caret-right', 1, 387, 42, 'N', 'ntahlah', '2022-01-12 15:31:33', '103.160.118.2', 'ntahlah', '2022-01-12 15:31:33', '103.160.118.2', 1),
(44, 'Cetak PerHari', '', 'fa fa-caret-right', 2, 390, 42, 'N', 'ntahlah', '2022-01-12 15:31:47', '103.160.118.2', 'ntahlah', '2022-01-12 15:32:01', '103.160.118.2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_module`
--

CREATE TABLE IF NOT EXISTS `xi_sa_module` (
  `id_module` int(11) NOT NULL,
  `nama_module` varchar(255) NOT NULL,
  `label_module` varchar(255) NOT NULL,
  `url_module` varchar(255) NOT NULL,
  `deskripsi_module` varchar(255) NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_module`
--

INSERT INTO `xi_sa_module` (`id_module`, `nama_module`, `label_module`, `url_module`, `deskripsi_module`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`, `id_status`) VALUES
(1, 'home', 'Home', 'home', 'Module home', 'yogisolop', '2017-06-04 19:39:22', '::1', 'yogisolop', '2020-05-19 11:06:41', '::1', 1),
(2, 'manajemen', 'Manajemen', 'manajemen', 'Module konfigurasi system khusus untuk superadmin', 'yogisolop', '2017-06-04 19:40:50', '::1', 'yogisolop', '2017-08-03 16:00:08', '::1', 1),
(4, 'dokumen', 'dokumen', 'dokumen', 'Module Dokumen', 'ntahlah', '2020-07-23 09:21:43', '::1', 'ntahlah', '2021-04-15 10:14:51', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_rules`
--

CREATE TABLE IF NOT EXISTS `xi_sa_rules` (
  `id_rules` int(11) NOT NULL,
  `id_module` int(11) NOT NULL,
  `id_kontrol` int(11) NOT NULL,
  `id_fungsi` int(11) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=395 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_rules`
--

INSERT INTO `xi_sa_rules` (`id_rules`, `id_module`, `id_kontrol`, `id_fungsi`, `id_status`) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 1, 1),
(3, 2, 2, 2, 1),
(4, 2, 2, 3, 1),
(5, 2, 2, 4, 1),
(6, 2, 3, 1, 1),
(7, 2, 3, 2, 1),
(8, 2, 3, 3, 1),
(9, 2, 3, 4, 1),
(10, 2, 4, 1, 1),
(11, 2, 4, 2, 1),
(12, 2, 4, 3, 1),
(13, 2, 4, 4, 1),
(14, 2, 4, 13, 1),
(15, 2, 4, 14, 1),
(16, 2, 5, 1, 1),
(17, 2, 5, 2, 1),
(18, 2, 5, 3, 1),
(19, 2, 5, 4, 1),
(20, 2, 6, 1, 1),
(21, 2, 6, 2, 1),
(22, 2, 6, 3, 1),
(23, 2, 6, 4, 1),
(24, 2, 6, 15, 1),
(25, 2, 7, 1, 1),
(26, 2, 7, 2, 1),
(27, 2, 7, 3, 1),
(28, 2, 7, 4, 1),
(29, 2, 7, 5, 1),
(30, 2, 7, 7, 1),
(31, 2, 7, 8, 1),
(32, 2, 8, 1, 1),
(33, 2, 8, 2, 1),
(34, 1, 9, 3, 1),
(35, 1, 9, 4, 1),
(36, 1, 9, 5, 1),
(49, 2, 15, 1, 1),
(50, 2, 15, 2, 1),
(51, 2, 15, 3, 1),
(52, 2, 15, 4, 1),
(53, 2, 15, 5, 1),
(178, 2, 30, 1, 1),
(179, 2, 30, 2, 1),
(180, 2, 30, 3, 1),
(181, 2, 30, 4, 1),
(182, 2, 30, 5, 1),
(183, 2, 30, 8, 1),
(184, 2, 30, 7, 1),
(198, 2, 7, 29, 1),
(315, 4, 37, 1, 1),
(316, 4, 37, 2, 1),
(317, 4, 37, 3, 1),
(318, 4, 37, 4, 1),
(319, 4, 37, 5, 1),
(320, 4, 37, 7, 1),
(321, 4, 38, 1, 1),
(322, 4, 38, 2, 1),
(323, 4, 38, 3, 1),
(324, 4, 38, 4, 1),
(325, 4, 38, 5, 1),
(326, 4, 38, 6, 1),
(327, 4, 38, 7, 1),
(328, 4, 38, 8, 1),
(329, 4, 37, 6, 1),
(330, 4, 37, 10, 1),
(331, 4, 37, 9, 1),
(332, 4, 39, 1, 1),
(333, 4, 39, 2, 1),
(334, 4, 39, 3, 1),
(335, 4, 39, 4, 1),
(336, 4, 39, 5, 1),
(337, 4, 39, 6, 1),
(338, 4, 39, 7, 1),
(339, 4, 39, 8, 1),
(340, 4, 39, 9, 1),
(341, 4, 39, 10, 1),
(342, 2, 40, 1, 1),
(343, 2, 40, 2, 1),
(344, 2, 40, 3, 1),
(345, 2, 40, 4, 1),
(346, 2, 40, 5, 1),
(347, 2, 40, 7, 1),
(348, 2, 40, 8, 1),
(349, 4, 39, 30, 1),
(350, 4, 39, 31, 1),
(351, 4, 39, 32, 1),
(352, 2, 41, 1, 1),
(353, 2, 41, 2, 1),
(354, 2, 41, 3, 1),
(355, 2, 41, 4, 1),
(356, 2, 41, 5, 1),
(357, 2, 41, 7, 1),
(358, 2, 41, 8, 1),
(359, 2, 7, 33, 1),
(360, 2, 7, 34, 1),
(361, 4, 42, 1, 1),
(362, 4, 42, 2, 1),
(363, 4, 42, 3, 1),
(364, 4, 42, 4, 1),
(365, 4, 42, 5, 1),
(366, 4, 42, 6, 1),
(367, 4, 42, 7, 1),
(368, 4, 42, 8, 1),
(369, 4, 42, 9, 1),
(370, 4, 42, 10, 1),
(371, 4, 42, 31, 1),
(372, 4, 43, 1, 1),
(373, 4, 43, 2, 1),
(374, 4, 43, 3, 1),
(375, 4, 43, 4, 1),
(376, 4, 43, 5, 1),
(377, 4, 43, 6, 1),
(378, 4, 43, 7, 1),
(379, 4, 43, 8, 1),
(380, 4, 43, 9, 1),
(381, 4, 43, 10, 1),
(382, 4, 39, 12, 1),
(383, 1, 1, 5, 1),
(384, 4, 39, 36, 1),
(385, 1, 1, 37, 1),
(386, 2, 7, 35, 1),
(387, 4, 44, 1, 1),
(388, 4, 44, 21, 1),
(389, 4, 44, 38, 1),
(390, 4, 45, 1, 1),
(391, 4, 45, 2, 1),
(392, 4, 45, 19, 1),
(393, 4, 45, 21, 1),
(394, 4, 45, 38, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_status`
--

CREATE TABLE IF NOT EXISTS `xi_sa_status` (
  `id_status` char(2) NOT NULL,
  `nm_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_status`
--

INSERT INTO `xi_sa_status` (`id_status`, `nm_status`) VALUES
('0', 'Tidak Aktif'),
('1', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_users`
--

CREATE TABLE IF NOT EXISTS `xi_sa_users` (
  `id_users` int(11) NOT NULL,
  `token` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `foto_profile` varchar(50) NOT NULL COMMENT 'Foto Profile',
  `blokir` int(1) NOT NULL COMMENT '0=diblokir, 1=tidak diblokir',
  `id_status` int(1) NOT NULL COMMENT '0=Tidak Aktif, 1=Aktif',
  `id_opd` int(11) DEFAULT NULL,
  `nm_opd` varchar(255) DEFAULT NULL,
  `sub_opd` int(11) DEFAULT NULL,
  `nm_sub_opd` text DEFAULT NULL,
  `jenis_user` int(11) NOT NULL,
  `account_type` enum('1','2','3') NOT NULL COMMENT '1 = Default dari app, 2 = Dari Simpeg, 3 = Dari Aspirasi DPRD',
  `validate_email_code` varchar(100) NOT NULL,
  `validate_email_status` int(1) NOT NULL,
  `reset_password_code` varchar(100) NOT NULL,
  `reset_password_status` int(1) NOT NULL,
  `reset_password_expired` int(11) NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_users`
--

INSERT INTO `xi_sa_users` (`id_users`, `token`, `username`, `password`, `email`, `fullname`, `foto_profile`, `blokir`, `id_status`, `id_opd`, `nm_opd`, `sub_opd`, `nm_sub_opd`, `jenis_user`, `account_type`, `validate_email_code`, `validate_email_status`, `reset_password_code`, `reset_password_status`, `reset_password_expired`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`) VALUES
(1, '231E696E9C21810535E08FFFE70F0868', 'ntahlah', '$2a$12$vBEyptGRVh96JCS2Go.04.DuNMbwrwnK85Ye8Gs/8lIdJ8oDPPOyi', '', 'Erid Ade Putra', 'default.png', 0, 1, 37, 'DINAS KOMUNIKASI DAN INFORMATIKA', 0, '', 0, '1', '', 0, '', 0, 0, '', '0000-00-00 00:00:00', '::1', 'ntahlah', '2021-12-10 13:36:11', '::1'),
(88, '6E68174FDB2AA961DA7FC2664F7EA6D5', 'ajudan_gub', '$2a$12$bvTLJLvAFw7QOUQxGmDc8eLKPl9Fo3gorzzZ4HTYxAITyUkh1TcE2', 'ajd@gmail.com', 'Ajudan Gubernur', 'default.png', 0, 1, 1, 'PROVINSI SUMATERA BARAT', 0, '', 0, '1', '', 0, '', 0, 0, 'ntahlah', '2021-12-07 09:58:48', '::1', 'ntahlah', '2021-12-07 09:58:48', '::1'),
(90, 'B6A6F83CC282E4FD98345162757D9CE3', 'gubernur_sumbar', '$2a$12$9D/rk5GpLxLf7x00yFnU1.JZb/It7lYVCNaz5qKQf86K4UqpYlfW6', 'gub@gmail.com', 'Gubernur Sumbar', 'default.png', 0, 1, 1, 'PROVINSI SUMATERA BARAT', 0, '', 0, '1', '', 0, '', 0, 0, 'ntahlah', '2021-12-07 10:29:40', '::1', 'ntahlah', '2021-12-07 10:29:40', '::1'),
(91, 'CBBB594293314410F1FCCF763DB21B0D', 'sekda_sumbar', '$2a$12$DVE.YHz/.UnmOtoJdNnGJuYB5X0XXEc2rs5ru.NmIXhXl7d9eXSB2', 'sekre@gmail.com', 'Sekretaris Daerah', 'default.png', 0, 1, 2, 'SEKRETARIAT DAERAH', 0, '', 0, '1', '', 0, '', 0, 0, 'ntahlah', '2021-12-07 11:20:55', '::1', 'ntahlah', '2021-12-07 11:20:55', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_users_default_pass`
--

CREATE TABLE IF NOT EXISTS `xi_sa_users_default_pass` (
  `id_default_pass` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `pass_plain` char(100) NOT NULL,
  `updated` enum('Y','N') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_users_default_pass`
--

INSERT INTO `xi_sa_users_default_pass` (`id_default_pass`, `id_users`, `pass_plain`, `updated`) VALUES
(3, 6, 'Diskominfo@2018', 'N'),
(4, 7, 'Diskominfo@@2018', 'N'),
(5, 8, 'Diskominfo@@2018', 'N'),
(6, 11, '$2y$12$82lyQgKwXgwR3G2VpbsTBOIMUcXdQbUnndnpsNq.r15znv5OvfcmW', 'N'),
(13, 18, 'Asd@1234', 'N'),
(14, 19, 'Asd@1234', 'N'),
(15, 20, 'Asd@1234', 'N'),
(17, 22, 'asd@12345??', 'N'),
(19, 25, 'CekAkunAspirasi12345', 'N'),
(20, 26, 'CekAkunAspirasi12345', 'N'),
(21, 27, 'CekAkunAspirasi12345', 'N'),
(22, 28, 'CekAkunAspirasi12345', 'N'),
(23, 29, 'CekAkunAspirasi12345', 'N'),
(24, 30, 'CekAkunAspirasi12345', 'N'),
(25, 31, 'CekAkunAspirasi12345', 'N'),
(26, 32, 'CekAkunAspirasi12345', 'N'),
(27, 33, 'CekAkunAspirasi12345', 'N'),
(28, 34, 'CekAkunAspirasi12345', 'N'),
(29, 35, 'CekAkunAspirasi12345', 'N'),
(30, 36, 'CekAkunAspirasi12345', 'N'),
(31, 37, 'CekAkunAspirasi12345', 'N'),
(32, 38, 'CekAkunAspirasi12345', 'N'),
(33, 39, 'CekAkunAspirasi12345', 'N'),
(34, 40, 'CekAkunAspirasi12345', 'N'),
(35, 41, 'CekAkunAspirasi12345', 'N'),
(36, 42, 'CekAkunAspirasi12345', 'N'),
(37, 43, 'CekAkunAspirasi12345', 'N'),
(38, 44, 'CekAkunAspirasi12345', 'N'),
(39, 45, 'CekAkunAspirasi12345', 'N'),
(40, 46, 'CekAkunAspirasi12345', 'N'),
(41, 47, 'CekAkunAspirasi12345', 'N'),
(42, 48, 'CekAkunAspirasi12345', 'N'),
(43, 49, 'CekAkunAspirasi12345', 'N'),
(44, 50, 'CekAkunAspirasi12345', 'N'),
(45, 51, 'CekAkunAspirasi12345', 'N'),
(46, 52, 'CekAkunAspirasi12345', 'N'),
(47, 53, 'CekAkunAspirasi12345', 'N'),
(48, 54, 'CekAkunAspirasi12345', 'N'),
(49, 55, 'CekAkunAspirasi12345', 'N'),
(50, 56, 'CekAkunAspirasi12345', 'N'),
(51, 57, 'CekAkunAspirasi12345', 'N'),
(52, 58, 'CekAkunAspirasi12345', 'N'),
(53, 59, 'CekAkunAspirasi12345', 'N'),
(54, 60, 'CekAkunAspirasi12345', 'N'),
(55, 61, 'CekAkunAspirasi12345', 'N'),
(56, 62, 'CekAkunAspirasi12345', 'N'),
(57, 63, 'CekAkunAspirasi12345', 'N'),
(58, 64, 'CekAkunAspirasi12345', 'N'),
(59, 65, 'CekAkunAspirasi12345', 'N'),
(60, 66, 'CekAkunAspirasi12345', 'N'),
(61, 67, 'CekAkunAspirasi12345', 'N'),
(62, 68, 'CekAkunAspirasi12345', 'N'),
(63, 69, 'CekAkunAspirasi12345', 'N'),
(64, 70, 'CekAkunAspirasi12345', 'N'),
(65, 71, 'CekAkunAspirasi12345', 'N'),
(66, 72, 'CekAkunAspirasi12345', 'N'),
(67, 73, 'CekAkunAspirasi12345', 'N'),
(68, 74, 'CekAkunAspirasi12345', 'N'),
(69, 75, 'CekAkunAspirasi12345', 'N'),
(70, 76, 'CekAkunAspirasi12345', 'N'),
(71, 77, 'CekAkunAspirasi12345', 'N'),
(72, 78, 'CekAkunAspirasi12345', 'N'),
(73, 79, 'CekAkunAspirasi12345', 'N'),
(74, 80, 'CekAkunAspirasi12345', 'N'),
(75, 81, 'Asd@1234', 'N'),
(76, 82, 'Asd@1234', 'N'),
(77, 83, 'Asd@1234', 'N'),
(78, 84, 'Asd@1234', 'N'),
(79, 85, 'Asd@1234', 'N'),
(80, 86, 'Asd@1234', 'N'),
(81, 88, 'Asd@12345', 'N'),
(82, 89, 'Asd@12345', 'N'),
(83, 90, 'Asd@12345', 'N'),
(84, 91, 'Asd@12345', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_users_privileges`
--

CREATE TABLE IF NOT EXISTS `xi_sa_users_privileges` (
  `id_users_privileges` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_users_privileges`
--

INSERT INTO `xi_sa_users_privileges` (`id_users_privileges`, `id_users`, `id_group`, `id_status`) VALUES
(1, 1, 1, 1),
(104, 88, 13, 1),
(106, 90, 3, 1),
(107, 91, 3, 1),
(108, 1, 2, 1),
(109, 1, 3, 1),
(110, 1, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_white_list`
--

CREATE TABLE IF NOT EXISTS `xi_sa_white_list` (
  `id_white_list` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `method_name` varchar(100) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_white_list`
--

INSERT INTO `xi_sa_white_list` (`id_white_list`, `module_name`, `class_name`, `method_name`, `id_status`) VALUES
(1, 'signin', 'signin', 'login', 1),
(2, 'signin', 'signin', 'logout', 1),
(3, 'signin', 'signin', 'switch_group', 1),
(4, 'signin', 'signin', 'timeout', 1),
(5, 'signin', 'backup', 'files', 1),
(6, 'signin', 'backup', 'db', 1),
(7, 'signin', 'cek_login', 'cek_login', 1),
(8, 'web', 'laporan', 'export', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_agenda`
--
ALTER TABLE `data_agenda`
  ADD PRIMARY KEY (`id_agenda`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `fk_data_agenda` (`status_verifikasi`);

--
-- Indexes for table `data_disposisi`
--
ALTER TABLE `data_disposisi`
  ADD PRIMARY KEY (`id_disposisi`);

--
-- Indexes for table `data_disposisi_masuk`
--
ALTER TABLE `data_disposisi_masuk`
  ADD PRIMARY KEY (`id_disposisi_masuk`);

--
-- Indexes for table `data_notifikasi`
--
ALTER TABLE `data_notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indexes for table `data_penerima`
--
ALTER TABLE `data_penerima`
  ADD PRIMARY KEY (`id_penerima`),
  ADD KEY `id_status` (`id_status`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_opd`
--
ALTER TABLE `master_opd`
  ADD PRIMARY KEY (`id_opd`);

--
-- Indexes for table `master_status`
--
ALTER TABLE `master_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `xi_sa_ci_captcha`
--
ALTER TABLE `xi_sa_ci_captcha`
  ADD PRIMARY KEY (`captcha_id`);

--
-- Indexes for table `xi_sa_ci_session`
--
ALTER TABLE `xi_sa_ci_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xi_sa_fungsi`
--
ALTER TABLE `xi_sa_fungsi`
  ADD PRIMARY KEY (`id_fungsi`);

--
-- Indexes for table `xi_sa_group`
--
ALTER TABLE `xi_sa_group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `xi_sa_group_privileges`
--
ALTER TABLE `xi_sa_group_privileges`
  ADD PRIMARY KEY (`id_group_privileges`);

--
-- Indexes for table `xi_sa_jenis_fungsi`
--
ALTER TABLE `xi_sa_jenis_fungsi`
  ADD PRIMARY KEY (`id_jenis_fungsi`);

--
-- Indexes for table `xi_sa_jenis_user`
--
ALTER TABLE `xi_sa_jenis_user`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `xi_sa_kontrol`
--
ALTER TABLE `xi_sa_kontrol`
  ADD PRIMARY KEY (`id_kontrol`);

--
-- Indexes for table `xi_sa_level_akses`
--
ALTER TABLE `xi_sa_level_akses`
  ADD PRIMARY KEY (`id_level_akses`);

--
-- Indexes for table `xi_sa_log_akses`
--
ALTER TABLE `xi_sa_log_akses`
  ADD PRIMARY KEY (`id_log_akses`);

--
-- Indexes for table `xi_sa_log_login`
--
ALTER TABLE `xi_sa_log_login`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `xi_sa_log_mobile`
--
ALTER TABLE `xi_sa_log_mobile`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `xi_sa_log_session`
--
ALTER TABLE `xi_sa_log_session`
  ADD PRIMARY KEY (`id_log_session`);

--
-- Indexes for table `xi_sa_menu`
--
ALTER TABLE `xi_sa_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `xi_sa_module`
--
ALTER TABLE `xi_sa_module`
  ADD PRIMARY KEY (`id_module`);

--
-- Indexes for table `xi_sa_rules`
--
ALTER TABLE `xi_sa_rules`
  ADD PRIMARY KEY (`id_rules`);

--
-- Indexes for table `xi_sa_status`
--
ALTER TABLE `xi_sa_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `xi_sa_users`
--
ALTER TABLE `xi_sa_users`
  ADD PRIMARY KEY (`id_users`);

--
-- Indexes for table `xi_sa_users_default_pass`
--
ALTER TABLE `xi_sa_users_default_pass`
  ADD PRIMARY KEY (`id_default_pass`);

--
-- Indexes for table `xi_sa_users_privileges`
--
ALTER TABLE `xi_sa_users_privileges`
  ADD PRIMARY KEY (`id_users_privileges`);

--
-- Indexes for table `xi_sa_white_list`
--
ALTER TABLE `xi_sa_white_list`
  ADD PRIMARY KEY (`id_white_list`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_agenda`
--
ALTER TABLE `data_agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `data_disposisi`
--
ALTER TABLE `data_disposisi`
  MODIFY `id_disposisi` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `data_disposisi_masuk`
--
ALTER TABLE `data_disposisi_masuk`
  MODIFY `id_disposisi_masuk` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `data_notifikasi`
--
ALTER TABLE `data_notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `data_penerima`
--
ALTER TABLE `data_penerima`
  MODIFY `id_penerima` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=157;
--
-- AUTO_INCREMENT for table `master_opd`
--
ALTER TABLE `master_opd`
  MODIFY `id_opd` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12401;
--
-- AUTO_INCREMENT for table `xi_sa_ci_captcha`
--
ALTER TABLE `xi_sa_ci_captcha`
  MODIFY `captcha_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `xi_sa_fungsi`
--
ALTER TABLE `xi_sa_fungsi`
  MODIFY `id_fungsi` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `xi_sa_group`
--
ALTER TABLE `xi_sa_group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `xi_sa_group_privileges`
--
ALTER TABLE `xi_sa_group_privileges`
  MODIFY `id_group_privileges` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1602;
--
-- AUTO_INCREMENT for table `xi_sa_jenis_fungsi`
--
ALTER TABLE `xi_sa_jenis_fungsi`
  MODIFY `id_jenis_fungsi` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `xi_sa_kontrol`
--
ALTER TABLE `xi_sa_kontrol`
  MODIFY `id_kontrol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `xi_sa_level_akses`
--
ALTER TABLE `xi_sa_level_akses`
  MODIFY `id_level_akses` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `xi_sa_log_akses`
--
ALTER TABLE `xi_sa_log_akses`
  MODIFY `id_log_akses` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `xi_sa_log_login`
--
ALTER TABLE `xi_sa_log_login`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `xi_sa_log_mobile`
--
ALTER TABLE `xi_sa_log_mobile`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `xi_sa_log_session`
--
ALTER TABLE `xi_sa_log_session`
  MODIFY `id_log_session` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `xi_sa_menu`
--
ALTER TABLE `xi_sa_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `xi_sa_module`
--
ALTER TABLE `xi_sa_module`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `xi_sa_rules`
--
ALTER TABLE `xi_sa_rules`
  MODIFY `id_rules` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=395;
--
-- AUTO_INCREMENT for table `xi_sa_users`
--
ALTER TABLE `xi_sa_users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `xi_sa_users_default_pass`
--
ALTER TABLE `xi_sa_users_default_pass`
  MODIFY `id_default_pass` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `xi_sa_users_privileges`
--
ALTER TABLE `xi_sa_users_privileges`
  MODIFY `id_users_privileges` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `xi_sa_white_list`
--
ALTER TABLE `xi_sa_white_list`
  MODIFY `id_white_list` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
