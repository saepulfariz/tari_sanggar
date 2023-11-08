-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2023 pada 23.16
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tari_sanggar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_role`
--

CREATE TABLE `tb_role` (
  `id` int(11) NOT NULL,
  `nama_role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_role`
--

INSERT INTO `tb_role` (`id`, `nama_role`) VALUES
(1, 'admin'),
(2, 'manager'),
(3, 'konsumen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sanggar`
--

CREATE TABLE `tb_sanggar` (
  `id` int(11) NOT NULL,
  `nama_sanggar` varchar(128) NOT NULL,
  `lokasi_sanggar` varchar(256) NOT NULL,
  `tentang_sanggar` text NOT NULL,
  `no_rek` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sanggar_galleri`
--

CREATE TABLE `tb_sanggar_galleri` (
  `id` int(11) NOT NULL,
  `id_sanggar` int(11) NOT NULL,
  `gambar` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sanggar_order`
--

CREATE TABLE `tb_sanggar_order` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `nama_acara` varchar(128) NOT NULL,
  `tanggal_acara` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `domisili` varchar(128) NOT NULL,
  `alamat` text NOT NULL,
  `catatan_patner` text DEFAULT NULL,
  `bukti_tf1` varchar(128) NOT NULL,
  `bukti_tf2` varchar(128) DEFAULT NULL,
  `is_dp` int(11) NOT NULL,
  `bayar1` int(11) NOT NULL,
  `bayar2` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `status` varchar(128) NOT NULL DEFAULT 'PENDING',
  `mulai_order` datetime NOT NULL DEFAULT current_timestamp(),
  `selesai_order` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sanggar_paket`
--

CREATE TABLE `tb_sanggar_paket` (
  `id` int(11) NOT NULL,
  `id_sanggar` int(11) NOT NULL,
  `nama_paket` varchar(128) NOT NULL,
  `keterangan_paket` text NOT NULL,
  `harga_paket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nama_lengkap` varchar(128) NOT NULL,
  `id_role` int(11) NOT NULL,
  `image` varchar(128) NOT NULL DEFAULT 'user.png',
  `is_active` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `did` int(11) DEFAULT NULL,
  `cname` varchar(256) DEFAULT NULL,
  `uname` varchar(256) DEFAULT NULL,
  `dname` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `email`, `username`, `password`, `nama_lengkap`, `id_role`, `image`, `is_active`, `cid`, `uid`, `did`, `cname`, `uname`, `dname`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@gmail.com', 'admin', '$2y$10$j1DUadXW3FpeYAtRab7YXOmxdQSETLN7Pvza/ay3P9CX0TFi4KBzm', 'admin', 1, 'user.png', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_sanggar`
--
ALTER TABLE `tb_sanggar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_sanggar_galleri`
--
ALTER TABLE `tb_sanggar_galleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sanggar` (`id_sanggar`);

--
-- Indeks untuk tabel `tb_sanggar_order`
--
ALTER TABLE `tb_sanggar_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indeks untuk tabel `tb_sanggar_paket`
--
ALTER TABLE `tb_sanggar_paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sanggar` (`id_sanggar`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_sanggar`
--
ALTER TABLE `tb_sanggar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_sanggar_galleri`
--
ALTER TABLE `tb_sanggar_galleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_sanggar_order`
--
ALTER TABLE `tb_sanggar_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_sanggar_paket`
--
ALTER TABLE `tb_sanggar_paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_sanggar_galleri`
--
ALTER TABLE `tb_sanggar_galleri`
  ADD CONSTRAINT `galleri_sanggar_id` FOREIGN KEY (`id_sanggar`) REFERENCES `tb_sanggar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_sanggar_order`
--
ALTER TABLE `tb_sanggar_order`
  ADD CONSTRAINT `order_paket_od` FOREIGN KEY (`id_paket`) REFERENCES `tb_sanggar_paket` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `order_user_id` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_sanggar_paket`
--
ALTER TABLE `tb_sanggar_paket`
  ADD CONSTRAINT `paket_sanggar_id` FOREIGN KEY (`id_sanggar`) REFERENCES `tb_sanggar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `user_role_id` FOREIGN KEY (`id_role`) REFERENCES `tb_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
