-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jul 2026 pada 15.34
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_beasiswa_uniku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `beasiswas`
--

CREATE TABLE `beasiswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_beasiswa` varchar(255) NOT NULL,
  `penyedia` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `beasiswas`
--

INSERT INTO `beasiswas` (`id`, `nama_beasiswa`, `penyedia`, `deskripsi`, `foto`, `created_at`, `updated_at`) VALUES
(4, 'Beasiswa Prestasi Akademik Universitas', 'Biro Kemahasiswaan', '-', 'uploads/y4mg8KhrPNDEjOFe6sevA46vgnd7ANrAghdT4c0O.jpg', '2026-06-29 03:14:41', '2026-07-08 06:12:00'),
(5, 'Beasiswa Bank Indonesia', 'Bank Indonesia', 'Beasiswa Bank Indonesia merupakan beasiswa yang diberikan oleh Bank Indonesia bagi para mahasiswa S1 di PTN & PTS serta pelajar SMK terpilih. Melalui beasiswa ini, BI akan memberikan bantuan untuk biaya pendidikan, tunjangan studi, dan juga biaya hidup.', 'uploads/3w4P3DlVFuxD5a9CopMb7I837NfGrYbc6syXSq9Z.png', '2026-06-29 03:15:13', '2026-07-06 22:52:34'),
(6, 'KIP Kuliah', 'Kemendikbudristek', '-', 'uploads/wnzYtzVUsnuKlUiyEOPOUwys1eu1MXRaT7oqSbw9.jpg', '2026-06-29 03:15:50', '2026-07-08 06:14:33'),
(7, 'Beasiswa PPA', 'Direktorat Pembelajaran dan Kemahasiswaan, Kemristekdikti', 'Beasiswa Peningkatan Prestasi Akademik (PPA) merupakan beasiswa yang berasal dari Pemerintah melalui Direktorat Pembelajaran dan Kemahasiswaan, Kemristekdikti, untuk diberikan kepada mahasiswa yang mempunyai prestasi tinggi. Universitas Kuningan termasuk yang diberikan beasiswa yang nantinya disalurkan ke mahasiswa yang berprestasi.', 'uploads/Dg12v2cnM3n6kpCR0ZCzD0td4ZwH2AxF8SvXXVkY.webp', '2026-07-06 22:31:29', '2026-07-08 06:11:31'),
(8, 'Beasiswa Pemprov', 'Pemprov Jabar', 'Beasiswa Pemprov Jabar merupakan beasiswa yang diberikan untuk mahasiswa warga Jawa Barat yang telah terdaftar di forlap dikti. Universitas Kuningan juga menerima beasiswa ini yang diberikan kepada mahasiswa yang berhak.', 'uploads/WMcpjLZaL3noqCCnziqro4vQyr4rcX06LAC6MCH8.png', '2026-07-06 22:32:14', '2026-07-08 06:11:38'),
(9, 'Beasiswa Bidikmisi', 'Direktorat Jenderal Pendidikan Tinggi, Kementerian Pendidikan dan Kebudayaan', 'Beasiswa Bidikmisi merupakan bantuan biaya pendidikan dari pemerintah Republik Indonesia melalui Direktorat Jenderal Pendidikan Tinggi, Kementerian Pendidikan dan Kebudayaan bagi calon mahasiswa yang akan masuk perguruan tinggi yang tidak mampu secara ekonomi dan memiliki potensi akademik, baik untuk menempuh pendidikan di perguruan tinggi pada program studi unggulan sampai lulus tepat waktu.', 'uploads/mUJQ8mPve9BYWaznfFiDVRrb0hsG1wV3CyBTITHw.jpg', '2026-07-06 22:33:19', '2026-07-08 06:11:45'),
(10, 'Baznaz Kuningan', 'Baznaz Kuningan', 'Beasiswa Badan Amil Zakat Nasional (BAZNAS) merupakan beasiswa untuk mahasiswa dan pelajar. BAZNAS Kabupaten Kuningan salah satunya yang memberikan beasiswa tersebut kepada perguruan tinggi maupun sekolah, untuk nantinya disalurkan kepada yang berhak menerima beasiswa.', 'uploads/CPAakqaNu9SnukRz5mmj2wrc4AMWslZaybYzS08B.jpg', '2026-07-06 22:34:28', '2026-07-08 06:08:52'),
(11, 'Baznaz Majalengka', 'Baznaz Majalengka', 'Beasiswa Badan Amil Zakat Nasional (BAZNAS) merupakan beasiswa untuk mahasiswa dan pelajar. BAZNAS Kabupaten Majalengka yang merupakan tetangga dari Kabupaten Kuningan juga memberikan beasiswa tersebut kepada perguruan tinggi maupun sekolah, untuk nantinya disalurkan kepada yang berhak menerima beasiswa.', 'uploads/H7bfsAnpXX2egxBv2WbzDIfRacQBRArqxPOgnNqO.png', '2026-07-06 22:34:59', '2026-07-08 06:09:24'),
(12, 'UNIKU Peduli', 'Universitas Kuningan', 'Beasiswa UNIKU Peduli merupakan beasiswa yang diberikan dari UNIKU dengan harapan dapat bermanfaat dan menghasilkan sinergi yang berguna bagi peningkatan kualitas pendidikan di Universitas Kuningan dan sekaligus menumbuhkan kecintaan terhadap almamater.', NULL, '2026-07-06 22:35:18', '2026-07-06 22:35:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_mahasiswas`
--

CREATE TABLE `master_mahasiswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `master_mahasiswas`
--

INSERT INTO `master_mahasiswas` (`id`, `nim`, `nama_lengkap`, `jurusan`, `created_at`, `updated_at`) VALUES
(6, '20240810034', 'Muhammad Fahmi Firmansyah', 'Teknik Informatika', NULL, NULL),
(7, '20240810091', 'Arie Muhamad Syahrial', 'Teknik Informatika', NULL, NULL),
(8, '20240810129', 'Salwa Hamdunah', 'Teknik Informatika', NULL, NULL),
(9, '20230810004', 'Adhitya Maulana Wijaya', 'Teknik Informatika', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(10, '20241410075', 'Sinta Meilany Putri', 'Ilmu Hukum', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(11, '20241410064', 'Herlambang Syaban Nurdiansyah', 'Ilmu Hukum', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(12, '20240510298', 'Abdan Dzikrillah Alghifari', 'Manajemen', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(13, '20220610078', 'Riki Khaerun Rijki', 'Akuntansi', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(14, '20230510337', 'Shela Anjali', 'Manajemen', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(15, '20241410062', 'Sri Noviyanti Fadilah', 'Ilmu Hukum', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(16, '20230610067', 'Yoga Dwi Saputra', 'Akuntansi', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(17, '20230610088', 'Yulita Yuna Nadiana', 'Akuntansi', '2026-07-08 05:35:35', '2026-07-08 05:35:35'),
(18, '20220710067', 'Amalia Nugraha', 'Kehutanan', '2026-07-08 05:35:35', '2026-07-08 05:35:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_29_084944_create_beasiswas_table', 1),
(5, '2026_06_29_084944_create_pengumumen_table', 1),
(6, '2026_06_29_084945_create_pendaftarans_table', 1),
(7, '2026_06_29_091226_create_master_mahasiswas_table', 2),
(8, '2026_07_07_034137_add_new_requirements_to_pendaftarans_table', 3),
(9, '2026_07_07_061130_alter_role_enum_in_users_table', 4),
(10, '2026_07_07_115549_drop_ipk_and_rekomendasi_from_pendaftarans_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftarans`
--

CREATE TABLE `pendaftarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `beasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `file_sktm` varchar(255) NOT NULL,
  `file_transkrip` varchar(255) NOT NULL,
  `file_aktif_kuliah` varchar(255) DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `file_ktm` varchar(255) DEFAULT NULL,
  `file_krs` varchar(255) DEFAULT NULL,
  `file_tidak_menerima_beasiswa` varchar(255) DEFAULT NULL,
  `penghasilan_ortu` enum('< 500000','500000 - 1000000','1000000 - 1500000','1500000 - 2000000','> 2000000') DEFAULT NULL,
  `status_verifikasi` enum('MENUNGGU','SEDANG DITINJAU','LOLOS','DITOLAK') NOT NULL DEFAULT 'MENUNGGU',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendaftarans`
--

INSERT INTO `pendaftarans` (`id`, `user_id`, `beasiswa_id`, `nama_lengkap`, `nim`, `jenis_kelamin`, `jurusan`, `email`, `no_hp`, `file_sktm`, `file_transkrip`, `file_aktif_kuliah`, `file_ktp`, `file_ktm`, `file_krs`, `file_tidak_menerima_beasiswa`, `penghasilan_ortu`, `status_verifikasi`, `created_at`, `updated_at`) VALUES
(4, 7, 5, 'Adhitya Maulana Wijaya', '20230810004', 'Laki-laki', 'S1 Teknik Informatika', '20230810004@uniku.ac.id', '08238432', 'uploads/dokumen/B7XtuBeD8gKNuVZn4rlGy03iPF8w2pVQs3ZelyUj.pdf', 'uploads/dokumen/hl3T1lu2jysRiz42993t496FlbvDWNG8WB6a2guX.pdf', 'uploads/dokumen/YrkUt3w793XIOpnrrhkuPEUPO0L0lZxC3ndsCdaV.pdf', 'uploads/dokumen/BTFJ4I7hrUlZ89L3Dcx2HfOMKbTdFfo272nrQmsT.pdf', 'uploads/dokumen/E5QTwfEyATzQpaf2UkmTjDr2VFulmCWYVx440oNX.pdf', 'uploads/dokumen/h1rKmFCRp9JjLvL0Kes94YSG1Jqt1UdBKCMiiINe.pdf', 'uploads/dokumen/udHnrFXZ8mBdIr36MJ0Dp13RLNSQGm2CK43COG0g.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:44:20', '2026-07-08 06:02:00'),
(5, 8, 5, 'Sinta Meilany Putri', '20241410075', 'Perempuan', 'S1 Ilmu Hukum', '20241410075@uniku.ac.id', '082178232', 'uploads/dokumen/XXVDI04hFdeqJskXJ119RceVQdxATrmhxXCsJ8Fp.pdf', 'uploads/dokumen/SQ0GQA5G8d8ed5I8Dxl54Bx6lye86EWea4wI3yIG.pdf', 'uploads/dokumen/JQQoXJkTOZ8nZbuGgfuMu8bCfYPFGkZXVJZBendV.pdf', 'uploads/dokumen/5ZW3sZuprXLqq5Mlfr8FbEnLm0ATWb8QFmR8X8Cj.pdf', 'uploads/dokumen/6eE2ffMKoDxOb4OeftnsKh1B4bYbGZtteynp0JTh.pdf', 'uploads/dokumen/JN5xpxR0KJ11LE4USdp5YWBntzTPQyBqha1wXcdF.pdf', 'uploads/dokumen/wUSK2XtTkfk1TLWGhFE2pDYkXHJohZSd2WPOVtbA.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:47:07', '2026-07-08 06:01:57'),
(6, 9, 5, 'Herlambang Syaban Nurdiansyah', '20241410064', 'Laki-laki', 'S1 Ilmu Hukum', '20241410064@uniku.ac.id', '0826312312', 'uploads/dokumen/qePgTNiWJDggBpkrTBv5jeGuvui6UYdZxKvcf8rZ.pdf', 'uploads/dokumen/0WxE550qoZzmqyvibaG8s0OvjgiO0qupCtLneAJP.pdf', 'uploads/dokumen/EsAG9J601iEDhkkxwDFrTFhDh6zbJz1M2mXF2fo8.pdf', 'uploads/dokumen/y5dfhmIy3j5hiaZ6G4uVucmTGkg2v4lZIkHHVddz.pdf', 'uploads/dokumen/6q94ixtTlo0y5aeVm3CbOs4aJKF5UVVtyE6aSbip.pdf', 'uploads/dokumen/87JZag3q6lG1SVKVBejcm3UqyH908ZHiIvMRx5RL.pdf', 'uploads/dokumen/wCj7LyZNJxmpii3BgP7Z57ImDlpv813pt5H3DOJs.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:48:18', '2026-07-08 06:01:54'),
(7, 10, 5, 'Abdan Dzikrillah Alghifari', '20240510298', 'Laki-laki', 'S1 Manajemen', '20240510298@uniku.ac.id', '0826412762', 'uploads/dokumen/UUXZEZr5nMeHsfsvCgao66ZO2XCkFXMsl8MMS51X.pdf', 'uploads/dokumen/pHbAWJ604l4QInyL2kRc0Wfrxoxv6NFdY8CCrfWV.pdf', 'uploads/dokumen/sKzKjJ51z4Kh4Sczu2jdMEX6aDubHiYwZONHON0V.pdf', 'uploads/dokumen/4s1i1LC6SqMnUGGh6KwzkI71gRFboL7ykBT3M7JZ.pdf', 'uploads/dokumen/iJzpfEaJlHSHYTYcf80dBidAkOVFL7IlAVP2ThQ0.pdf', 'uploads/dokumen/swu8onU6kONsi2KxY22nGt8vBuG56ejspPmCmLH4.pdf', 'uploads/dokumen/RJ03FnNYzpEBrds80ysF5FC0FvFyrsP025b8DcfK.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:53:00', '2026-07-08 06:01:51'),
(8, 11, 5, 'Riki Khaerun Rijki', '20220610078', 'Laki-laki', 'S1 Akuntansi', '20220610078@uniku.ac.id', '08276341273', 'uploads/dokumen/GwQs4wNeg1tD6ON91mp1eW9I8W18wC9DwNOuSo0E.pdf', 'uploads/dokumen/NZYoEqjnbOqj4lHMKELSbjWXGN7yLXw09HDQR5uO.pdf', 'uploads/dokumen/bAZtcRWAQPw0kJbFiM0YnzwvtyJPLwm1HywTuSsn.pdf', 'uploads/dokumen/mC2vIPkxJfi0uetDJMjJCOxRl61xK6JQ9jH3kjfH.pdf', 'uploads/dokumen/58nLEwhac2J1QoW7QpocxSpEQHodtjwxsNqSUMER.pdf', 'uploads/dokumen/KxdHh0Bj9UH2Llb0REl4eMm6Ik2JgC40RtfUZ50H.pdf', 'uploads/dokumen/4bBT3NR3Fm2oN9PZZPbe9Kxf4wIuNPOBGTpBsYvk.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:54:07', '2026-07-08 06:01:48'),
(9, 12, 5, 'Shela Anjali', '20230510337', 'Perempuan', 'S1 Manajemen', '20230510337@uniku.ac.id', '0812412422', 'uploads/dokumen/L9smi12ohHDhsuUYbCTTOCLHDo4dUrfBqG7Uhfmh.pdf', 'uploads/dokumen/pslAImLyvvAAifA0Xzd7mdgbvYSEugsAoMLpzpKF.pdf', 'uploads/dokumen/jqTmPt91ynmlIDPh34fIs9fPepR6CUrtOnO0x2bT.pdf', 'uploads/dokumen/cgrHsgprtIousAPpZnY8iCu0koHhMgHc5moszryQ.pdf', 'uploads/dokumen/RBo203u1vGcZfnh68G4yMeI88TDxP5QHONUAuNk7.pdf', 'uploads/dokumen/k8HdIzjNuKuTLL36Vvmntk6jlJZKd2Jl3cnsmskV.pdf', 'uploads/dokumen/my7bGcBOvGLaHY4T6O4gMV5MiTlfBdkCn1pL2E34.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:55:29', '2026-07-08 06:01:46'),
(10, 13, 5, 'Sri Noviyanti Fadilah', '20241410062', 'Perempuan', 'S1 Ilmu Hukum', '20241410062@uniku.ac.id', '08247182342', 'uploads/dokumen/yySkslrccHNuMCv6aFlwI7AFErnsJaaAzCttxncr.pdf', 'uploads/dokumen/m0FtFWGgWe4O3iLMc1vyQ2tzG0LcMjVJUwTLl5X9.pdf', 'uploads/dokumen/JAvMdzZdgXVGHXmA2KUeYszU2JGx9ccULAmx3icj.pdf', 'uploads/dokumen/hfuzJ5nSy31twTteFWTwEtvqeTWd4srHuvKZbKD3.pdf', 'uploads/dokumen/AV76Q1lZgqTa7Dic9ScFE65cAfCJSiQdKroemkC3.pdf', 'uploads/dokumen/PEdwH32JXU36CyHwkgX7TWd8tjldW5IMDqrv01TO.pdf', 'uploads/dokumen/7T4m5jKH9hSaFVk0FKtmlZiKndv48idQwB1Ypske.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:56:40', '2026-07-08 06:01:43'),
(11, 14, 5, 'Yoga Dwi Saputra', '20230610067', 'Laki-laki', 'S1 Akuntansi', '20230610067@uniku.ac.id', '081234734', 'uploads/dokumen/FlyUOq222OUx7UcRSgsgPrsnOD6IyNrv7u6WwM7i.pdf', 'uploads/dokumen/bSyLkfJ3oqWkeACa2XBS8bqRPBV2Gdudw0he89CS.pdf', 'uploads/dokumen/ntY1QuoqIxDikgoAVuEI0DYkd3obESvuEikV7fDw.pdf', 'uploads/dokumen/BZWr53CUhVHxP8LmbFq1cRE07mPNF0a15hXbiWp1.pdf', 'uploads/dokumen/et9a8IplCgJqA1UCTGl7S68P0F0x05MldOjqmiXt.pdf', 'uploads/dokumen/9NfYlWfiJvx0S0xKLMv5FgCgbhWUy37Ojh0GzPed.pdf', 'uploads/dokumen/apz5JHiVVSA4qIoOqWJr5NtK4V8GUdAqb4buqXOo.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:57:59', '2026-07-08 06:01:40'),
(12, 15, 5, 'Yulita Yuna Nadiana', '20230610088', 'Perempuan', 'S1 Akuntansi', '20230610088@uniku.ac.id', '08126462744', 'uploads/dokumen/cWS9NfFX1E6TDBWmRA6dnyAWVBpfZTF3HlAsvCf8.pdf', 'uploads/dokumen/lOE2Na6rQ43PviZyt39OwN5zs09qUNxQAuqoAOLx.pdf', 'uploads/dokumen/PZtHTj68YNwmG4HjgrYgJZnISDwLOn0WfJJrmDWo.pdf', 'uploads/dokumen/JNSWxxzhJ6Z4eVKXMxAHdd3ZfHRQky4e2AM1UWkQ.pdf', 'uploads/dokumen/UDN7uELgLb9cJPyEiYQQuVmTi1KpzYW14wFnOakc.pdf', 'uploads/dokumen/2Eezmkm3wXqI9BLPbx8oq5lkxBfJgJNFZoY9PxxP.pdf', 'uploads/dokumen/i9QL9yDhdnUQbhScV5YIioTKywrtNw2A6f9ZCpZL.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 05:59:15', '2026-07-08 06:01:37'),
(13, 16, 5, 'Amalia Nugraha', '20220710067', 'Perempuan', 'S1 Kehutanan', '20220710067@uniku.ac.id', '08123661442', 'uploads/dokumen/NGacXdsLqsmFqm9sM5cEStG8ETzhG0nBQMNVH7S7.pdf', 'uploads/dokumen/Mt4BD5gq93Lze0btJAQUCV9KS1XoEPbIlxxzago9.pdf', 'uploads/dokumen/17A4NzfoWfdsFZCY5sPSRoDvuwf4jT0M4GtcUL3E.pdf', 'uploads/dokumen/iNUVZ0enJDw0FtdR4zZtNMjPUnY8EaCiHVLYL48O.pdf', 'uploads/dokumen/hr4WKtpi5WygsfYSSdv5uscY3h13HVkw9XU3Ym2q.pdf', 'uploads/dokumen/hdrSvMupm4p8VdhxTwOg1wvXaW42yrQzpwG7Nepp.pdf', 'uploads/dokumen/OUMyvO9wNQsdjNCArKRLlFpGau9xdwWMiOsrxXLH.pdf', '1000000 - 1500000', 'LOLOS', '2026-07-08 06:00:24', '2026-07-08 06:01:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumumen`
--

CREATE TABLE `pengumumen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` date NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengumumen`
--

INSERT INTO `pengumumen` (`id`, `judul`, `isi`, `tanggal`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Pengumuman', 'Tiga mahasiswa Program Studi Manajemen Fakultas Ekonomi dan Bisnis (FEB) Universitas Kuningan (Uniku) berhasil mengharumkan nama kampus dengan meraih Juara 2 pada ajang Lomba Business Plan tingkat Jawa Barat yang diselenggarakan oleh Bank Indonesia (BI) dalam rangkaian kegiatan Karya Kreatif Jawa Barat (KKJ) 2026 dan West Java Sharia Economic Festival (WJSEF) 2026.', '2026-06-29', 'uploads/C9MsXax5VrKYsLbI67r5nAhy1AB7FrCnZO82bUdv.jpg', '2026-06-29 02:40:10', '2026-06-29 02:40:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('pNg3rHpDfKPyFXP2iIV036syOztriglcZ7PABfii', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXRIaG5NZ2pubWhHSmE2ME92cTZyZ1pxbHpDenJSUkZvampYaHVXVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1783517584);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nim_username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','baak','mahasiswa') DEFAULT 'mahasiswa',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `nim_username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'BAAK', 'baak', '$2y$12$uwl6F8.O8x/b2fzBDVlexuCz4RpP43/O.byRDKY7vXxXd.Q5lC7ai', 'baak', NULL, '2026-06-29 01:50:56', '2026-06-29 01:50:56'),
(3, 'Salwa Hamdunah', '20240810129', '$2y$12$pXzhl493w0GRp3B5XSohG.VtCcnoR8ORB7Tb7SW.Cu.L3eDbq9PPO', 'mahasiswa', NULL, '2026-06-29 06:51:48', '2026-06-29 06:51:48'),
(4, 'Arie Muhamad Syahrial', '20240810091', '$2y$12$UCaLGV1A0zA1PkoOh0iQquEQDMJafI97pxhbjtdu3xveGgziw1kpi', 'mahasiswa', NULL, '2026-06-29 07:28:07', '2026-06-29 07:28:07'),
(6, 'Administrator', 'admin', '$2y$12$IiOSWtoyNNUJRmrL.WYjtONH7Qp.3cXkeBABDrFF8Tu/gFu.cuUju', 'admin', NULL, '2026-07-06 23:12:05', '2026-07-06 23:12:05'),
(7, 'Adhitya Maulana Wijaya', '20230810004', '$2y$12$vn9TyHjRqLndoT31dKkxLePW1s0KICHRA/E/8.cDlC9JnQvTDjnq.', 'mahasiswa', NULL, '2026-07-08 05:37:43', '2026-07-08 05:37:43'),
(8, 'Sinta Meilany Putri', '20241410075', '$2y$12$eTcTFFr2.0rU0IQtj7faOu9pZZXr2LsGFI9C8.9o0zJ6XY7XMPoHK', 'mahasiswa', NULL, '2026-07-08 05:46:11', '2026-07-08 05:46:11'),
(9, 'Herlambang Syaban Nurdiansyah', '20241410064', '$2y$12$teuqvdxWpQd2dQF166N40utu0yXjQZpglvrcaJFajHfp90J.OczEy', 'mahasiswa', NULL, '2026-07-08 05:47:25', '2026-07-08 05:47:25'),
(10, 'Abdan Dzikrillah Alghifari', '20240510298', '$2y$12$T2H57QmwfGJG1aKAqVoDC.rz3RSOHIPorYFNfDZCKB7/qmXgh5Ara', 'mahasiswa', NULL, '2026-07-08 05:49:05', '2026-07-08 05:49:05'),
(11, 'Riki Khaerun Rijki', '20220610078', '$2y$12$frZc3GtODrxYYnxoSSxso.k3vn01Bp0yQKFKuP405g3tbJoNhFQ4S', 'mahasiswa', NULL, '2026-07-08 05:53:14', '2026-07-08 05:53:14'),
(12, 'Shela Anjali', '20230510337', '$2y$12$uEXuWN7Kca4PDcHSQx3aaODGsybGuq89zXKyNhqSX1gFao4I5MDyO', 'mahasiswa', NULL, '2026-07-08 05:54:22', '2026-07-08 05:54:22'),
(13, 'Sri Noviyanti Fadilah', '20241410062', '$2y$12$/wmEA0erpPA1eLoq8wrXyelDpEkKKfens2JhdTSw2IKqZZJs7zPUm', 'mahasiswa', NULL, '2026-07-08 05:55:42', '2026-07-08 05:55:42'),
(14, 'Yoga Dwi Saputra', '20230610067', '$2y$12$EW8omwlJYw40v7mCIs4KS.K5cFqO5FPOx9g3RIWMirjlsfR.Hfoeu', 'mahasiswa', NULL, '2026-07-08 05:57:04', '2026-07-08 05:57:04'),
(15, 'Yulita Yuna Nadiana', '20230610088', '$2y$12$Bp1g/h9yBJ29YLwW2y.P9Oil7haMgiosF0Zw.bFPNVrcWq90Yx58u', 'mahasiswa', NULL, '2026-07-08 05:58:15', '2026-07-08 05:58:15'),
(16, 'Amalia Nugraha', '20220710067', '$2y$12$FdihxhQgDRdVV.KW4hWbhe7YIdFCyve1hx3wW067/0vYTIKTog7Di', 'mahasiswa', NULL, '2026-07-08 05:59:28', '2026-07-08 05:59:28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `beasiswas`
--
ALTER TABLE `beasiswas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_mahasiswas`
--
ALTER TABLE `master_mahasiswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_mahasiswas_nim_unique` (`nim`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pendaftarans`
--
ALTER TABLE `pendaftarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftarans_user_id_foreign` (`user_id`),
  ADD KEY `pendaftarans_beasiswa_id_foreign` (`beasiswa_id`);

--
-- Indeks untuk tabel `pengumumen`
--
ALTER TABLE `pengumumen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nim_username_unique` (`nim_username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `beasiswas`
--
ALTER TABLE `beasiswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_mahasiswas`
--
ALTER TABLE `master_mahasiswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pendaftarans`
--
ALTER TABLE `pendaftarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pengumumen`
--
ALTER TABLE `pengumumen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pendaftarans`
--
ALTER TABLE `pendaftarans`
  ADD CONSTRAINT `pendaftarans_beasiswa_id_foreign` FOREIGN KEY (`beasiswa_id`) REFERENCES `beasiswas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
