-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2022 at 10:27 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agendagub`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_nama_opd` (`p_id_opd` INT) RETURNS VARCHAR(255) CHARSET latin1 BEGIN
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

CREATE TABLE `data_agenda` (
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
  `penyelenggara` varchar(255) NOT NULL,
  `cp` text NOT NULL,
  `keterangan` text,
  `dokumen` text NOT NULL,
  `status_verifikasi` varchar(2) NOT NULL,
  `pesan_verifikasi` text NOT NULL,
  `status_disposisi` enum('SD','BD') NOT NULL COMMENT 'SD=Sudah Disposisi, BD=Belum Disposisi',
  `id_status` varchar(11) NOT NULL,
  `keterangan_hadir` text,
  `create_by` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  `mod_by` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_ip` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_disposisi`
--

CREATE TABLE `data_disposisi` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_disposisi_masuk`
--

CREATE TABLE `data_disposisi_masuk` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_notifikasi`
--

CREATE TABLE `data_notifikasi` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_penerima`
--

CREATE TABLE `data_penerima` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 1, '6595E94DFE54F61849C5CA2983A77AC4P6HAGDK', 1, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `master_opd`
--

CREATE TABLE `master_opd` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `master_status` (
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

CREATE TABLE `xi_sa_ci_captcha` (
  `captcha_id` int(11) NOT NULL,
  `captcha_time` int(11) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `xi_sa_ci_session` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_ci_session`
--

INSERT INTO `xi_sa_ci_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('c8rllu0u7gvlsbk5edse01cbsuri45hl', '::1', 1642574863, 0x6163636f756e745f6e616d657c733a373a226e7461686c6168223b454167656e6461417070403230323153657373696f6e7c733a3139323a223630346130666132653133666462613036346361303136626536353939336339383566363531656363356132393164303436643538373736653161383331383233663263323962383135393330666136346366663835653734393463336237306230666466383733373834353031643138623336616664373865653863643535474b2b33583375796379365279716757754e75584d335a74537a6e4e45556e4370757766324f43346955587a66656237516246763353667567422f3670676a73223b657870697265735f62797c693a313634323739303836323b69645f75736572737c733a313a2231223b66756c6c6e616d657c733a31343a224572696420416465205075747261223b67726f75705f6163746976657c733a313a2231223b67726f75705f6e616d657c733a31313a2253757065722041646d696e223b69645f6c6576656c5f616b7365737c733a313a2231223b6c6576656c5f616b7365737c733a31313a2253555045522041444d494e223b6e69636b5f6c6576656c7c733a333a22534144223b7573657269647c733a33323a223233314536393645394332313831303533354530384646464537304630383638223b69645f6f70647c4e3b67726f75705f7377697463687c613a343a7b693a303b613a323a7b733a383a2269645f67726f7570223b733a313a2231223b733a31303a226e616d615f67726f7570223b733a31313a2253757065722041646d696e223b7d693a313b613a323a7b733a383a2269645f67726f7570223b733a313a2232223b733a31303a226e616d615f67726f7570223b733a31333a2241646d696e6973747261746f72223b7d693a323b613a323a7b733a383a2269645f67726f7570223b733a313a2233223b733a31303a226e616d615f67726f7570223b733a383a2250696d70696e616e223b7d693a333b613a323a7b733a383a2269645f67726f7570223b733a323a223133223b733a31303a226e616d615f67726f7570223b733a363a22416a7564616e223b7d7d),
('d9jtrsg5mpavkurtp5eh68eesr9kos8o', '::1', 1642651333, ''),
('k7f3b5e140cqvc5q1bfm9bd0fvm32m2l', '::1', 1642667380, '');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_fungsi`
--

CREATE TABLE `xi_sa_fungsi` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `xi_sa_group` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `xi_sa_group_privileges` (
  `id_group_privileges` int(11) NOT NULL,
  `id_group` int(11) NOT NULL DEFAULT '0',
  `id_rules` int(11) NOT NULL DEFAULT '0',
  `id_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `xi_sa_jenis_fungsi` (
  `id_jenis_fungsi` int(3) NOT NULL,
  `jenis_fungsi` varchar(100) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `xi_sa_jenis_user` (
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

CREATE TABLE `xi_sa_kontrol` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(45, 'lap', 'lap', 'lap', 'lap', 'ntahlah', '2022-01-12 15:26:11', '::1', 'ntahlah', '2022-01-12 15:26:11', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_level_akses`
--

CREATE TABLE `xi_sa_level_akses` (
  `id_level_akses` int(3) NOT NULL,
  `level_akses` varchar(100) NOT NULL,
  `nick_level` char(3) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `xi_sa_log_akses` (
  `id_log_akses` int(11) NOT NULL,
  `history_log` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_log_login`
--

CREATE TABLE `xi_sa_log_login` (
  `id_log` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login_time` int(11) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `user_agent` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_log_mobile`
--

CREATE TABLE `xi_sa_log_mobile` (
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

CREATE TABLE `xi_sa_log_session` (
  `id_log_session` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login_time` int(11) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `id_status` int(1) NOT NULL,
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(24, 1, 'ntahlah', 1641951943, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, 'f4d455b305258b3e3c5adfc8c6b975b80a8cb65f7a9f518fee75511e733b47c5202b831040716e70f5d7a510c6b679eb218eb12f456decb023b23c4ae555f627v2tk+TfSy1rBBAPJnSNw3kfr3BEYQ8tiPw121RV0DvEG6w2aoqYfzpmesgDUhwFq'),
(25, 1, 'ntahlah', 1642038042, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '4930719ea855fff566ca4876465daddcb8f3716b6ee0cc5e958da81599cd013984414ae2a0c7fc69f842364da67d7f11cb878363a839f1264baa76d3b28fe50bbjfaXdJuckoykp85IOITwm4yqxS1micYA8Fi7v3iNNyAVhNFWv7AZsNkO9yTUOmC'),
(26, 1, 'ntahlah', 1642491631, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '7f37130f2d6c416c16e9908ec4e6a440554134bedfda29e95dab0a3d805b901757660cf50f4d3e10b97db1f710fd7950fef0c0e5f9e4128288109b18525a5b0eWYpoUZnDoNW08VVdXIym5sNaA38lxnln6G280T6RAs4wVqlqlGxVFifM64JeB5fe'),
(27, 1, 'ntahlah', 1642560416, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 1, '604a0fa2e13fdba064ca016be65993c985f651ecc5a291d046d58776e1a831823f2c29b815930fa64cff85e7494c3b70b0fdf873784501d18b36afd78ee8cd55GK+3X3uycy6RyqgWuNuXM3ZtSznNEUnCpuwf2OC4iUXzfeb7QbFv3SfugB/6pgjs');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_menu`
--

CREATE TABLE `xi_sa_menu` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(42, 'Laporan', '#', 'fa fa-print', 5, 0, 0, 'Y', 'ntahlah', '2022-01-05 09:30:37', '::1', 'ntahlah', '2022-01-12 15:19:38', '::1', 1),
(43, 'Cetak Per Bulan', '', 'fa fa-caret-right', 1, 387, 42, 'N', 'ntahlah', '2022-01-12 15:20:27', '::1', 'ntahlah', '2022-01-12 15:20:27', '::1', 1),
(44, 'Cetak PerHari', '', 'fa fa-caret-right', 2, 390, 42, 'N', 'ntahlah', '2022-01-12 15:28:01', '::1', 'ntahlah', '2022-01-12 15:28:16', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_module`
--

CREATE TABLE `xi_sa_module` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `xi_sa_rules` (
  `id_rules` int(11) NOT NULL,
  `id_module` int(11) NOT NULL,
  `id_kontrol` int(11) NOT NULL,
  `id_fungsi` int(11) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `xi_sa_users`
--

CREATE TABLE `xi_sa_users` (
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
  `nm_sub_opd` text,
  `jenis_user` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xi_sa_users`
--

INSERT INTO `xi_sa_users` (`id_users`, `token`, `username`, `password`, `email`, `fullname`, `foto_profile`, `blokir`, `id_status`, `id_opd`, `nm_opd`, `sub_opd`, `nm_sub_opd`, `jenis_user`, `account_type`, `validate_email_code`, `validate_email_status`, `reset_password_code`, `reset_password_status`, `reset_password_expired`, `create_by`, `create_date`, `create_ip`, `mod_by`, `mod_date`, `mod_ip`) VALUES
(1, '231E696E9C21810535E08FFFE70F0868', 'ntahlah', '$2a$12$vBEyptGRVh96JCS2Go.04.DuNMbwrwnK85Ye8Gs/8lIdJ8oDPPOyi', '', 'Erid Ade Putra', 'default.png', 0, 1, 37, 'DINAS KOMUNIKASI DAN INFORMATIKA', 0, '', NULL, '1', '', 0, '', 0, 0, '', '0000-00-00 00:00:00', '::1', 'ntahlah', '2021-12-10 13:36:11', '::1'),
(88, '6E68174FDB2AA961DA7FC2664F7EA6D5', 'ajudan_gub', '$2a$12$bvTLJLvAFw7QOUQxGmDc8eLKPl9Fo3gorzzZ4HTYxAITyUkh1TcE2', 'ajd@gmail.com', 'Ajudan Gubernur', 'default.png', 0, 1, 1, 'PROVINSI SUMATERA BARAT', 0, '', NULL, '1', '', 0, '', 0, 0, 'ntahlah', '2021-12-07 09:58:48', '::1', 'ntahlah', '2021-12-07 09:58:48', '::1'),
(90, 'B6A6F83CC282E4FD98345162757D9CE3', 'gubernur_sumbar', '$2a$12$9D/rk5GpLxLf7x00yFnU1.JZb/It7lYVCNaz5qKQf86K4UqpYlfW6', 'gub@gmail.com', 'Gubernur Sumbar', 'default.png', 0, 1, 1, 'PROVINSI SUMATERA BARAT', 0, '', NULL, '1', '', 0, '', 0, 0, 'ntahlah', '2021-12-07 10:29:40', '::1', 'ntahlah', '2021-12-07 10:29:40', '::1'),
(91, 'CBBB594293314410F1FCCF763DB21B0D', 'sekda_sumbar', '$2a$12$DVE.YHz/.UnmOtoJdNnGJuYB5X0XXEc2rs5ru.NmIXhXl7d9eXSB2', 'sekre@gmail.com', 'Sekretaris Daerah', 'default.png', 0, 1, 2, 'SEKRETARIAT DAERAH', 0, '', NULL, '1', '', 0, '', 0, 0, 'ntahlah', '2021-12-07 11:20:55', '::1', 'ntahlah', '2021-12-07 11:20:55', '::1'),
(92, 'FEE17E7875E3AB8E7016A5392DC217E0', 'asd312312', '$2a$12$KQQbtLiKi0eNvr/5uD91cOo7Vd435daLmUZ11vbVc42B6r9CQHoPi', 'asdsad@asd.com', 'dasdas', 'default.png', 0, 1, 1, 'PROVINSI SUMATERA BARAT', 0, '', 1, '1', '', 0, '', 0, 0, 'ntahlah', '2022-01-19 10:14:17', '::1', 'ntahlah', '2022-01-19 10:14:25', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_users_default_pass`
--

CREATE TABLE `xi_sa_users_default_pass` (
  `id_default_pass` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `pass_plain` char(100) NOT NULL,
  `updated` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(84, 91, 'Asd@12345', 'N'),
(85, 92, 'Asd@12345', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_users_privileges`
--

CREATE TABLE `xi_sa_users_privileges` (
  `id_users_privileges` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(110, 1, 13, 1),
(111, 92, 3, 1),
(112, 92, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xi_sa_white_list`
--

CREATE TABLE `xi_sa_white_list` (
  `id_white_list` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `method_name` varchar(100) NOT NULL,
  `id_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_disposisi`
--
ALTER TABLE `data_disposisi`
  MODIFY `id_disposisi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_disposisi_masuk`
--
ALTER TABLE `data_disposisi_masuk`
  MODIFY `id_disposisi_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_notifikasi`
--
ALTER TABLE `data_notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_penerima`
--
ALTER TABLE `data_penerima`
  MODIFY `id_penerima` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_opd`
--
ALTER TABLE `master_opd`
  MODIFY `id_opd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12401;

--
-- AUTO_INCREMENT for table `xi_sa_ci_captcha`
--
ALTER TABLE `xi_sa_ci_captcha`
  MODIFY `captcha_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `xi_sa_fungsi`
--
ALTER TABLE `xi_sa_fungsi`
  MODIFY `id_fungsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `xi_sa_group`
--
ALTER TABLE `xi_sa_group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `xi_sa_group_privileges`
--
ALTER TABLE `xi_sa_group_privileges`
  MODIFY `id_group_privileges` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1602;

--
-- AUTO_INCREMENT for table `xi_sa_jenis_fungsi`
--
ALTER TABLE `xi_sa_jenis_fungsi`
  MODIFY `id_jenis_fungsi` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xi_sa_kontrol`
--
ALTER TABLE `xi_sa_kontrol`
  MODIFY `id_kontrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `xi_sa_level_akses`
--
ALTER TABLE `xi_sa_level_akses`
  MODIFY `id_level_akses` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `xi_sa_log_akses`
--
ALTER TABLE `xi_sa_log_akses`
  MODIFY `id_log_akses` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xi_sa_log_login`
--
ALTER TABLE `xi_sa_log_login`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xi_sa_log_mobile`
--
ALTER TABLE `xi_sa_log_mobile`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xi_sa_log_session`
--
ALTER TABLE `xi_sa_log_session`
  MODIFY `id_log_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `xi_sa_menu`
--
ALTER TABLE `xi_sa_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `xi_sa_module`
--
ALTER TABLE `xi_sa_module`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xi_sa_rules`
--
ALTER TABLE `xi_sa_rules`
  MODIFY `id_rules` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;

--
-- AUTO_INCREMENT for table `xi_sa_users`
--
ALTER TABLE `xi_sa_users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `xi_sa_users_default_pass`
--
ALTER TABLE `xi_sa_users_default_pass`
  MODIFY `id_default_pass` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `xi_sa_users_privileges`
--
ALTER TABLE `xi_sa_users_privileges`
  MODIFY `id_users_privileges` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `xi_sa_white_list`
--
ALTER TABLE `xi_sa_white_list`
  MODIFY `id_white_list` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
