-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 05:12 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `10542`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivasi_tahunans`
--

CREATE TABLE `aktivasi_tahunans` (
  `id_aktivasi_tahunan` varchar(255) NOT NULL,
  `id_member` varchar(255) NOT NULL,
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `masa_aktif` date NOT NULL,
  `aktivasi_tahunan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id_customer` varchar(255) NOT NULL,
  `nama_customer` varchar(255) NOT NULL,
  `alamat_customer` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin_customer` varchar(255) NOT NULL,
  `no_telp_customer` varchar(255) NOT NULL,
  `foto_customer` varchar(255) NOT NULL,
  `ktp_customer` varchar(255) NOT NULL,
  `sim_customer` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_customer` varchar(255) NOT NULL DEFAULT 'Belum Terverifikasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_kelas`
--

CREATE TABLE `deposit_kelas` (
  `id_deposit_kelas` varchar(255) NOT NULL,
  `id_member` varchar(255) NOT NULL,
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `berlaku` date NOT NULL,
  `total_deposit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_uangs`
--

CREATE TABLE `deposit_uangs` (
  `id_deposit_uang` varchar(255) NOT NULL,
  `id_member` varchar(255) NOT NULL,
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `bonus_deposit` varchar(255) NOT NULL,
  `sisa_deposit` varchar(255) NOT NULL,
  `deposit` varchar(255) NOT NULL,
  `total_deposit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_jadwals`
--

CREATE TABLE `detail_jadwals` (
  `id_detail_jadwal` bigint(20) UNSIGNED NOT NULL,
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal_pegawai` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id_driver` varchar(255) NOT NULL,
  `nama_driver` varchar(255) NOT NULL,
  `alamat_driver` varchar(255) NOT NULL,
  `tanggal_lahir_driver` date NOT NULL,
  `jenis_kelamin_driver` varchar(255) NOT NULL,
  `no_telp_driver` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sim_driver` varchar(255) NOT NULL,
  `surat_bebas_napza` varchar(255) NOT NULL,
  `surat_kesehatan_jiwa` varchar(255) NOT NULL,
  `surat_kesehatan_jasmani` varchar(255) NOT NULL,
  `skck` varchar(255) NOT NULL,
  `foto_driver` varchar(255) NOT NULL,
  `bahasa_asing` varchar(255) NOT NULL,
  `tarif_driver_perhari` double(8,2) NOT NULL,
  `rerata_rating_driver` double(8,2) NOT NULL,
  `status_ketersediaan_driver` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id_driver`, `nama_driver`, `alamat_driver`, `tanggal_lahir_driver`, `jenis_kelamin_driver`, `no_telp_driver`, `email`, `password`, `sim_driver`, `surat_bebas_napza`, `surat_kesehatan_jiwa`, `surat_kesehatan_jasmani`, `skck`, `foto_driver`, `bahasa_asing`, `tarif_driver_perhari`, `rerata_rating_driver`, `status_ketersediaan_driver`, `created_at`, `updated_at`) VALUES
('DRV-070523001', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$jIVycf7mSK00K8foJlHml.pdGkbnm1cdGAZWU/q2Fln8jFm8T59ei', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:43', '2023-05-07 11:14:43'),
('DRV-070523002', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$iAr1KJfy9xMmmEdNtLbrjejqnvfepZ4p9bQaqfmYhrX1/9TJfrpom', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:45', '2023-05-07 11:14:45'),
('DRV-070523003', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$v61UHF5Kllq.eNH3zWvOreF5GQHExVvllnquhUrQeBQ0Mv3qSCR1m', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:47', '2023-05-07 11:14:47'),
('DRV-070523004', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$QHg0w0AEWEbEb8ZsNFLKBeRYEZkurcaTD/G.bfrGjlA2YHCjt3Fju', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:48', '2023-05-07 11:14:48'),
('DRV-070523005', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$EgQg5cXstOONkeWu57YSOuber.Wt0WBBdylbkMHVdyVUuwu8mAqhC', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:48', '2023-05-07 11:14:48'),
('DRV-070523006', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$96OwI7X6PDtR97UXyVLeMOa.jPNe7A88ydB/dkP.nW0NjTw6gZQVK', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:49', '2023-05-07 11:14:49'),
('DRV-070523007', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$fQKjjJtv19XrERx6cPspEuRjaWe8lUTu0tLLSm33zBiHSRiIbJTru', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:50', '2023-05-07 11:14:50'),
('DRV-070523008', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$FmD.FtACFUADOWOBtk4emuUeHV6Iqkukwz7vSzZN2DLYv9zr5YxKm', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:51', '2023-05-07 11:14:51'),
('DRV-070523009', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$HbLa.kfHb0QNEfz9DGigdeVz1S3uw3jPhuGPUt4ZjZdz2kfhWH1FG', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:55', '2023-05-07 11:14:55'),
('DRV-070523010', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$XEfMjmKFDOLMneCasNlGCOKruRILutae5LVi4nmBQLmsILguA4CbS', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:56', '2023-05-07 11:14:56'),
('DRV-070523011', 'a', 'a', '2023-05-07', 'Pria', '081212121212', 'a@gmail.com', '$2y$10$JncExYjp1gDRwzFgFPBWBu7xfpuxdsxr8kLVU7YTPtoyIHo2O8pVK', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'gym.jpg', 'Bahasa Indonesia', 100000.00, 5.00, 'Tidak Tersedia', '2023-05-07 11:14:57', '2023-05-07 11:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instrukturs`
--

CREATE TABLE `instrukturs` (
  `id_instruktur` bigint(20) UNSIGNED NOT NULL,
  `nama_instruktur` varchar(255) NOT NULL,
  `no_telp_instruktur` varchar(255) NOT NULL,
  `jenis_kelamin_instruktur` varchar(255) NOT NULL,
  `tanggal_lahir_instruktur` date NOT NULL,
  `alamat_instruktur` varchar(255) NOT NULL,
  `waktu_terlambat` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instrukturs`
--

INSERT INTO `instrukturs` (`id_instruktur`, `nama_instruktur`, `no_telp_instruktur`, `jenis_kelamin_instruktur`, `tanggal_lahir_instruktur`, `alamat_instruktur`, `waktu_terlambat`, `email`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'coba', '08123412341', 'Wanita', '2023-05-08', 'jalan1', '1', 'coba@gmail.com', 'coba', 'coba', '2023-05-07 04:03:45', '2023-05-07 14:01:31'),
(2, 'aaa', '081234567890', 'Wanita', '2023-05-08', 'aaa', '1', 'a@email.com', 'a', 'a', '2023-05-07 06:53:34', '2023-05-07 06:53:34'),
(3, 'b', '08124545454', 'Wanita', '2023-05-02', 'b', '1', 'b@gmail.com', 'b', 'b', '2023-05-07 11:31:40', '2023-05-07 11:31:40'),
(5, 'as', '081233082422', 'Wanita', '2023-05-01', 'as', '1', '57902456@email.com', 'as', 'as', '2023-05-08 11:33:11', '2023-05-08 11:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `id_instruktur` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `hari_kerja` varchar(255) NOT NULL,
  `jam` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id_jadwal`, `id_instruktur`, `id_kelas`, `hari_kerja`, `jam`, `created_at`, `updated_at`) VALUES
(2, 1, 1, '1', '1', '2023-05-08 13:29:17', '2023-05-08 13:29:17'),
(3, 2, 2, '2', 'II (15.00 - 22.00)', '2023-05-08 14:32:29', '2023-05-08 14:32:29'),
(4, 2, 2, '2', '2', '2023-05-08 14:51:14', '2023-05-08 14:51:14'),
(5, 2, 2, '2', '2', '2023-05-08 14:52:17', '2023-05-08 14:52:17');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_harians`
--

CREATE TABLE `jadwal_harians` (
  `id_jadwal_harian` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `id_instruktur` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_harians`
--

INSERT INTO `jadwal_harians` (`id_jadwal_harian`, `id_jadwal`, `id_instruktur`, `id_kelas`, `tanggal`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 2, '2023-05-10', 'libur', NULL, NULL),
(2, 3, 2, 2, '2023-05-10', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_pegawais`
--

CREATE TABLE `jadwal_pegawais` (
  `id_jadwal_pegawai` bigint(20) UNSIGNED NOT NULL,
  `hari_kerja` varchar(255) NOT NULL,
  `shift` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `jumlah_peserta` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jumlah_peserta`, `created_at`, `updated_at`) VALUES
(1, 'p3l', 10, NULL, NULL),
(2, 'coding p3l', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id_member` varchar(255) NOT NULL,
  `nama_member` varchar(255) NOT NULL,
  `alamat_member` varchar(255) NOT NULL,
  `tanggal_lahir_member` date NOT NULL,
  `no_telp_member` varchar(255) NOT NULL,
  `jenis_kelamin_member` varchar(255) NOT NULL,
  `umur` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sisa_deposit_uang` varchar(255) NOT NULL,
  `sisa_deposit_kelas` varchar(255) NOT NULL,
  `masa_berlaku` varchar(255) NOT NULL,
  `paket` varchar(255) NOT NULL,
  `status_member` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id_member`, `nama_member`, `alamat_member`, `tanggal_lahir_member`, `no_telp_member`, `jenis_kelamin_member`, `umur`, `email`, `username`, `password`, `sisa_deposit_uang`, `sisa_deposit_kelas`, `masa_berlaku`, `paket`, `status_member`, `created_at`, `updated_at`) VALUES
('23.05.001', 'a', 'a', '2023-05-12', '081233087208', 'Pria', '12', 'a@email.com', 'a', '$2y$10$aVuuu1aSkuGEFObsLiXeuO61/KQKqZ2ZPVEj4oCKLI9UfUy2Qd2su', '1', '1', '1', 'a', 'Sudah Terverifikasi', '2023-05-12 03:22:48', '2023-05-12 03:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(9, '2022_04_10_212809_create_promos_table', 1),
(10, '2022_04_10_225248_create_roles_table', 1),
(11, '2022_04_10_231443_create_pegawais_table', 1),
(12, '2022_04_14_203152_create_pemilik_mobils_table', 1),
(13, '2022_04_14_204036_create_mobils_table', 1),
(14, '2022_05_06_201815_create_customers_table', 1),
(15, '2022_05_06_210807_create_drivers_table', 1),
(16, '2022_05_07_095449_create_jadwal_pegawais_table', 1),
(17, '2022_05_07_110023_create_detail_jadwals_table', 1),
(18, '2022_06_07_215533_create_transaksis_table', 1),
(19, '2023_05_06_195850_create_instrukturs_table', 2),
(20, '2023_05_07_111949_create_members_table', 3),
(21, '2023_05_07_184142_create_jadwals_table', 3),
(22, '2023_05_07_184354_create_kelas_table', 3),
(23, '2023_05_07_185411_create_jadwals_table', 4),
(24, '2023_05_09_110207_create_jadwal_harians_table', 5),
(25, '2023_05_09_204907_create_aktivasi_tahunans_table', 6),
(26, '2023_05_10_103149_create_deposit_kelas_table', 7),
(27, '2023_05_10_112405_create_deposit_uangs_table', 8),
(28, '2023_05_12_212421_create_deposit_kelas_table', 9),
(29, '2023_05_12_212612_create_deposit_uangs_table', 10),
(30, '2023_05_12_212750_create_deposit_kelas_table', 10),
(31, '2023_05_12_213355_create_aktivasi_tahunans_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mobils`
--

CREATE TABLE `mobils` (
  `id_mobil` bigint(20) UNSIGNED NOT NULL,
  `id_pemilik_mobil` bigint(20) UNSIGNED NOT NULL,
  `plat_nomor` varchar(255) NOT NULL,
  `nomor_stnk` varchar(255) NOT NULL,
  `gambar_mobil` varchar(255) NOT NULL,
  `nama_mobil` varchar(255) NOT NULL,
  `tipe_mobil` varchar(255) NOT NULL,
  `jenis_transmisi` varchar(255) NOT NULL,
  `jenis_bahan_bakar` varchar(255) NOT NULL,
  `warna_mobil` varchar(255) NOT NULL,
  `kapasitas_penumpang` int(11) NOT NULL,
  `fasilitas` varchar(255) NOT NULL,
  `volume_bagasi` varchar(255) NOT NULL,
  `kategori_aset` varchar(255) NOT NULL,
  `tanggal_kontrak_mulai_mobil` date NOT NULL,
  `tanggal_kontrak_selesai_mobil` date NOT NULL,
  `tanggal_terakhir_servis_mobil` date NOT NULL,
  `harga_sewa_mobil_perhari` double(8,2) NOT NULL,
  `status_ketersediaan_mobil` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawais`
--

CREATE TABLE `pegawais` (
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `foto_pegawai` varchar(255) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `tanggal_lahir_pegawai` date NOT NULL,
  `jenis_kelamin_pegawai` varchar(255) NOT NULL,
  `alamat_pegawai` varchar(255) NOT NULL,
  `no_telp_pegawai` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawais`
--

INSERT INTO `pegawais` (`id_pegawai`, `id_role`, `foto_pegawai`, `nama_pegawai`, `tanggal_lahir_pegawai`, `jenis_kelamin_pegawai`, `alamat_pegawai`, `no_telp_pegawai`, `email`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, '', 'anton', '2023-05-11', 'laki', 'jalan 2', '081233087208', 'anton@gmail.com', 'anton', '$2a$04$c29KbPnS5WcXRisyhJMIo.inwjwnALPRbYRjbVTmoTUoDBCidEDAC', NULL, NULL, NULL),
(2, 2, '', 'resa', '2023-05-07', 'wanita', 'jalan2', '081233452345', 'resa@gmail.com', 'resa', '$2y$10$fhFzmNreDqpsqLdyKEWeVeH4Vf8UCQ0LVOgDx/BSlCgFIY121Q2PG', NULL, NULL, NULL),
(3, 3, '', 'putri', '2023-04-21', 'wanita', 'jalan kristus', '08123454545', 'putri@gmail.com', 'putri', '$2y$10$e22JER1S00tSVYSrjbTWqO6IbTv2Yu95uZCPbi2iYCCj5YF9cZugm', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemilik_mobils`
--

CREATE TABLE `pemilik_mobils` (
  `id_pemilik_mobil` bigint(20) UNSIGNED NOT NULL,
  `nama_pemilik_mobil` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `alamat_pemilik_mobil` varchar(255) NOT NULL,
  `no_telp_pemilik_mobil` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id_promo` bigint(20) UNSIGNED NOT NULL,
  `kode_promo` varchar(255) NOT NULL,
  `jenis_promo` varchar(255) NOT NULL,
  `keterangan_promo` varchar(255) NOT NULL,
  `diskon` double NOT NULL,
  `status_promo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `nama_role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Kasir', NULL, NULL),
(3, 'Manager', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id_transaksi` varchar(255) NOT NULL,
  `id_customer` varchar(255) NOT NULL,
  `id_mobil` bigint(20) UNSIGNED NOT NULL,
  `id_driver` varchar(255) DEFAULT NULL,
  `id_pegawai` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `tanggal_mulai_sewa` datetime NOT NULL,
  `tanggal_selesai_sewa` datetime NOT NULL,
  `status_transaksi` varchar(25) DEFAULT NULL,
  `id_promo` bigint(20) UNSIGNED DEFAULT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tanggal_pengembalian` datetime DEFAULT NULL,
  `total_denda` double(50,2) NOT NULL,
  `total_pembayaran` double(50,2) NOT NULL,
  `status_pembayaran` varchar(50) DEFAULT NULL,
  `total_tarif_driver` double(50,2) NOT NULL,
  `jenis_peminjaman` varchar(25) NOT NULL,
  `rating_driver_transaksi` double(50,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivasi_tahunans`
--
ALTER TABLE `aktivasi_tahunans`
  ADD PRIMARY KEY (`id_aktivasi_tahunan`),
  ADD KEY `aktivasi_tahunans_id_member_foreign` (`id_member`),
  ADD KEY `aktivasi_tahunans_id_pegawai_index` (`id_pegawai`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `deposit_kelas`
--
ALTER TABLE `deposit_kelas`
  ADD PRIMARY KEY (`id_deposit_kelas`),
  ADD KEY `deposit_kelas_id_member_foreign` (`id_member`),
  ADD KEY `deposit_kelas_id_pegawai_index` (`id_pegawai`),
  ADD KEY `deposit_kelas_id_kelas_index` (`id_kelas`);

--
-- Indexes for table `deposit_uangs`
--
ALTER TABLE `deposit_uangs`
  ADD PRIMARY KEY (`id_deposit_uang`),
  ADD KEY `deposit_uangs_id_member_foreign` (`id_member`),
  ADD KEY `deposit_uangs_id_pegawai_index` (`id_pegawai`),
  ADD KEY `deposit_uangs_id_kelas_index` (`id_kelas`);

--
-- Indexes for table `detail_jadwals`
--
ALTER TABLE `detail_jadwals`
  ADD PRIMARY KEY (`id_detail_jadwal`),
  ADD KEY `detail_jadwals_id_pegawai_foreign` (`id_pegawai`),
  ADD KEY `detail_jadwals_id_jadwal_pegawai_foreign` (`id_jadwal_pegawai`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id_driver`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `instrukturs`
--
ALTER TABLE `instrukturs`
  ADD PRIMARY KEY (`id_instruktur`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jadwals_id_instruktur_foreign` (`id_instruktur`),
  ADD KEY `jadwals_id_kelas_foreign` (`id_kelas`);

--
-- Indexes for table `jadwal_harians`
--
ALTER TABLE `jadwal_harians`
  ADD PRIMARY KEY (`id_jadwal_harian`),
  ADD KEY `jadwal_harians_id_jadwal_index` (`id_jadwal`),
  ADD KEY `jadwal_harians_id_instruktur_index` (`id_instruktur`),
  ADD KEY `jadwal_harians_id_kelas_index` (`id_kelas`);

--
-- Indexes for table `jadwal_pegawais`
--
ALTER TABLE `jadwal_pegawais`
  ADD PRIMARY KEY (`id_jadwal_pegawai`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobils`
--
ALTER TABLE `mobils`
  ADD PRIMARY KEY (`id_mobil`),
  ADD KEY `mobils_id_pemilik_mobil_foreign` (`id_pemilik_mobil`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pegawais`
--
ALTER TABLE `pegawais`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `pegawais_id_role_foreign` (`id_role`);

--
-- Indexes for table `pemilik_mobils`
--
ALTER TABLE `pemilik_mobils`
  ADD PRIMARY KEY (`id_pemilik_mobil`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id_promo`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `transaksis_id_customer_foreign` (`id_customer`),
  ADD KEY `transaksis_id_driver_foreign` (`id_driver`),
  ADD KEY `transaksis_id_mobil_index` (`id_mobil`),
  ADD KEY `transaksis_id_pegawai_index` (`id_pegawai`),
  ADD KEY `transaksis_id_promo_index` (`id_promo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_jadwals`
--
ALTER TABLE `detail_jadwals`
  MODIFY `id_detail_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instrukturs`
--
ALTER TABLE `instrukturs`
  MODIFY `id_instruktur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jadwal_harians`
--
ALTER TABLE `jadwal_harians`
  MODIFY `id_jadwal_harian` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jadwal_pegawais`
--
ALTER TABLE `jadwal_pegawais`
  MODIFY `id_jadwal_pegawai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `mobils`
--
ALTER TABLE `mobils`
  MODIFY `id_mobil` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pegawais`
--
ALTER TABLE `pegawais`
  MODIFY `id_pegawai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pemilik_mobils`
--
ALTER TABLE `pemilik_mobils`
  MODIFY `id_pemilik_mobil` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id_promo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivasi_tahunans`
--
ALTER TABLE `aktivasi_tahunans`
  ADD CONSTRAINT `aktivasi_tahunans_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`),
  ADD CONSTRAINT `aktivasi_tahunans_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawais` (`id_pegawai`);

--
-- Constraints for table `deposit_kelas`
--
ALTER TABLE `deposit_kelas`
  ADD CONSTRAINT `deposit_kelas_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `deposit_kelas_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`),
  ADD CONSTRAINT `deposit_kelas_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawais` (`id_pegawai`);

--
-- Constraints for table `deposit_uangs`
--
ALTER TABLE `deposit_uangs`
  ADD CONSTRAINT `deposit_uangs_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `deposit_uangs_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`),
  ADD CONSTRAINT `deposit_uangs_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawais` (`id_pegawai`);

--
-- Constraints for table `detail_jadwals`
--
ALTER TABLE `detail_jadwals`
  ADD CONSTRAINT `detail_jadwals_id_jadwal_pegawai_foreign` FOREIGN KEY (`id_jadwal_pegawai`) REFERENCES `jadwal_pegawais` (`id_jadwal_pegawai`),
  ADD CONSTRAINT `detail_jadwals_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawais` (`id_pegawai`);

--
-- Constraints for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD CONSTRAINT `jadwals_id_instruktur_foreign` FOREIGN KEY (`id_instruktur`) REFERENCES `instrukturs` (`id_instruktur`),
  ADD CONSTRAINT `jadwals_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `jadwal_harians`
--
ALTER TABLE `jadwal_harians`
  ADD CONSTRAINT `jadwal_harians_id_instruktur_foreign` FOREIGN KEY (`id_instruktur`) REFERENCES `instrukturs` (`id_instruktur`),
  ADD CONSTRAINT `jadwal_harians_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwals` (`id_jadwal`),
  ADD CONSTRAINT `jadwal_harians_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `mobils`
--
ALTER TABLE `mobils`
  ADD CONSTRAINT `mobils_id_pemilik_mobil_foreign` FOREIGN KEY (`id_pemilik_mobil`) REFERENCES `pemilik_mobils` (`id_pemilik_mobil`) ON DELETE CASCADE;

--
-- Constraints for table `pegawais`
--
ALTER TABLE `pegawais`
  ADD CONSTRAINT `pegawais_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_id_customer_foreign` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id_customer`),
  ADD CONSTRAINT `transaksis_id_driver_foreign` FOREIGN KEY (`id_driver`) REFERENCES `drivers` (`id_driver`),
  ADD CONSTRAINT `transaksis_id_mobil_foreign` FOREIGN KEY (`id_mobil`) REFERENCES `mobils` (`id_mobil`),
  ADD CONSTRAINT `transaksis_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawais` (`id_pegawai`),
  ADD CONSTRAINT `transaksis_id_promo_foreign` FOREIGN KEY (`id_promo`) REFERENCES `promos` (`id_promo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
