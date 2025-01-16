-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 16 Jan 2025 pada 06.10
-- Versi server: 8.0.30
-- Versi PHP: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sis_pengaduanwifi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_kebakaran`
--

CREATE TABLE `laporan_kebakaran` (
  `id` int NOT NULL,
  `nama_pelapor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_telepon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lokasi_kebakaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Menunggu','Diproses','Selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Menunggu',
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_kebakaran`
--

INSERT INTO `laporan_kebakaran` (`id`, `nama_pelapor`, `no_telepon`, `lokasi_kebakaran`, `latitude`, `longitude`, `deskripsi`, `foto`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'halo', '089505880430', 'kebun bandara', '-7.555891947925125', '111.63336411167677', 'dsdsdsdsdsds', '1736842874_bf6d3b514efcb8905d88.jpeg', 'Menunggu', NULL, '2025-01-14 08:21:14', '2025-01-14 08:21:14'),
(2, 'halo', '089505880430', 'bukit 30', '-1.4768795780833035', '104.24813460152252', 'ugkhkhjnjkghbg', '1736887802_59fb2c4fab55eee30ea3.jpeg', 'Selesai', 'done', '2025-01-14 20:50:02', '2025-01-14 20:58:12'),
(3, 'halo', '089505880430', 'dssc', '-7.621436769152712', '111.80947849403115', 'sdcscsdc', '1736890245_6b9cc4804c21a4b17179.jpeg', 'Menunggu', NULL, '2025-01-14 21:30:45', '2025-01-14 21:30:45'),
(4, 'halo', '089505880430', 'kebun bandara', '-7.549629614677761', '111.60341726064965', 'sdsds', '1736890482_963ea00985780c1d5fb9.jpeg', 'Menunggu', NULL, '2025-01-14 21:34:42', '2025-01-14 21:34:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(4, 'admin', 'admin@example.com', '$2y$10$FvpKSMT1M0GAP/K/oWYeWuvOeiwJnEmw4jgvPHF04svD8prTiOX76', NULL, '2025-01-14 00:56:31', '2025-01-14 07:56:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `laporan_kebakaran`
--
ALTER TABLE `laporan_kebakaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan_kebakaran`
--
ALTER TABLE `laporan_kebakaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
