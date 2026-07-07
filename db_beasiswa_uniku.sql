-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jul 2026 pada 16.41
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
(4, 'Beasiswa Prestasi Akademik Universitas', 'Biro Kemahasiswaan', 'Persyaratan:\r\n1. SKTM\r\n2. Surat Rekomendasi\r\n3. Transkrip\r\n4. IPK Minimal 3.00', 'uploads/y4mg8KhrPNDEjOFe6sevA46vgnd7ANrAghdT4c0O.jpg', '2026-06-29 03:14:41', '2026-06-29 03:14:41'),
(5, 'Beasiswa Bank Indonesia', 'Bank Indonesia', 'Beasiswa Bank Indonesia merupakan beasiswa yang diberikan oleh Bank Indonesia bagi para mahasiswa S1 di PTN & PTS serta pelajar SMK terpilih. Melalui beasiswa ini, BI akan memberikan bantuan untuk biaya pendidikan, tunjangan studi, dan juga biaya hidup.', 'uploads/3w4P3DlVFuxD5a9CopMb7I837NfGrYbc6syXSq9Z.png', '2026-06-29 03:15:13', '2026-07-06 22:52:34'),
(6, 'KIP Kuliah', 'Kemendikbudristek', 'Persyaratan:\r\n1. SKTM\r\n2. Surat Rekomendasi\r\n3. Transkrip\r\n4. IPK Minimal 3.00', 'uploads/wnzYtzVUsnuKlUiyEOPOUwys1eu1MXRaT7oqSbw9.jpg', '2026-06-29 03:15:50', '2026-06-29 03:15:50'),
(7, 'Beasiswa PPA', 'Direktorat Pembelajaran dan Kemahasiswaan, Kemristekdikti', 'Beasiswa Peningkatan Prestasi Akademik (PPA) merupakan beasiswa yang berasal dari Pemerintah melalui Direktorat Pembelajaran dan Kemahasiswaan, Kemristekdikti, untuk diberikan kepada mahasiswa yang mempunyai prestasi tinggi. Universitas Kuningan termasuk yang diberikan beasiswa yang nantinya disalurkan ke mahasiswa yang berprestasi.', NULL, '2026-07-06 22:31:29', '2026-07-06 22:31:29'),
(8, 'Beasiswa Pemprov', 'Pemprov Jabar', 'Beasiswa Pemprov Jabar merupakan beasiswa yang diberikan untuk mahasiswa warga Jawa Barat yang telah terdaftar di forlap dikti. Universitas Kuningan juga menerima beasiswa ini yang diberikan kepada mahasiswa yang berhak.', NULL, '2026-07-06 22:32:14', '2026-07-06 22:32:14'),
(9, 'Beasiswa Bidikmisi', 'Direktorat Jenderal Pendidikan Tinggi, Kementerian Pendidikan dan Kebudayaan', 'Beasiswa Bidikmisi merupakan bantuan biaya pendidikan dari pemerintah Republik Indonesia melalui Direktorat Jenderal Pendidikan Tinggi, Kementerian Pendidikan dan Kebudayaan bagi calon mahasiswa yang akan masuk perguruan tinggi yang tidak mampu secara ekonomi dan memiliki potensi akademik, baik untuk menempuh pendidikan di perguruan tinggi pada program studi unggulan sampai lulus tepat waktu.', NULL, '2026-07-06 22:33:19', '2026-07-06 22:33:19'),
(10, 'Baznaz Kuningan', 'Baznaz Kuningan', 'Beasiswa Badan Amil Zakat Nasional (BAZNAS) merupakan beasiswa untuk mahasiswa dan pelajar. BAZNAS Kabupaten Kuningan salah satunya yang memberikan beasiswa tersebut kepada perguruan tinggi maupun sekolah, untuk nantinya disalurkan kepada yang berhak menerima beasiswa.', NULL, '2026-07-06 22:34:28', '2026-07-06 22:34:28'),
(11, 'Baznaz Majalengka', 'Baznaz Majalengka', 'Beasiswa Badan Amil Zakat Nasional (BAZNAS) merupakan beasiswa untuk mahasiswa dan pelajar. BAZNAS Kabupaten Majalengka yang merupakan tetangga dari Kabupaten Kuningan juga memberikan beasiswa tersebut kepada perguruan tinggi maupun sekolah, untuk nantinya disalurkan kepada yang berhak menerima beasiswa.', NULL, '2026-07-06 22:34:59', '2026-07-06 22:34:59'),
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
(8, '20240810129', 'Salwa Hamdunah', 'Teknik Informatika', NULL, NULL);

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
(2, 3, 5, 'Salwa Hamdunah', '20240810129', 'Laki-laki', 'Teknik Informatika', '20240810129@uniku.ac.id', '08123456789', 'uploads/dokumen/NJjtTK1UtnwWkKC2tGLhCS2aDq3LRe3vjS70CkUO.pdf', 'uploads/dokumen/BLWfvIWfYfja7ccFGMnEGc6FAYdGCJGWQmIQThP2.pdf', NULL, NULL, NULL, NULL, NULL, NULL, 'SEDANG DITINJAU', '2026-06-29 06:58:19', '2026-06-29 20:24:07'),
(3, 4, 4, 'Arie Muhamad Syahrial', '20240810091', 'Laki-laki', 'Teknik Informatika', '20240810091@uniku.ac.id', '08987654321', 'uploads/dokumen/e8ZTqz1MCbWJFoMrhHkhCtSZvzYgxeyodGSp5q8Z.pdf', 'uploads/dokumen/ZVSyAhjp9JvhOinJzhf20GpAWxPlPVnsKWGiKaOP.pdf', NULL, NULL, NULL, NULL, NULL, NULL, 'LOLOS', '2026-06-29 07:29:30', '2026-06-29 07:30:01');

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
('vdkoZB2cVjZNx2IaZPhkjgOOerz4V9AiUKwfuvEE', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3VudEYxTnhBcUFKVnZqN3ZHN05xRUhFY3lDSWc1N0RPUFZ3d1MwZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4udXNlcnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1783434850);

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
(5, 'Muhammad Fahmi Firmansyah', '20240810034', '$2y$12$1U6rWZeXG5j43Jat4nUd7eFHRI8nGBc4kM5aUGwKrpvg5Ud6dgCza', 'mahasiswa', NULL, '2026-07-06 20:46:22', '2026-07-06 20:46:22'),
(6, 'Administrator', 'admin', '$2y$12$IiOSWtoyNNUJRmrL.WYjtONH7Qp.3cXkeBABDrFF8Tu/gFu.cuUju', 'admin', NULL, '2026-07-06 23:12:05', '2026-07-06 23:12:05');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pendaftarans`
--
ALTER TABLE `pendaftarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengumumen`
--
ALTER TABLE `pengumumen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
