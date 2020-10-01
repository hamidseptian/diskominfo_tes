-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Okt 2020 pada 09.16
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diskominfo_tes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `nasabah`
--

CREATE TABLE `nasabah` (
  `id_nasabah` int(11) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `no_rekening` varchar(25) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nasabah`
--

INSERT INTO `nasabah` (`id_nasabah`, `nama`, `alamat`, `nohp`, `no_rekening`, `status`) VALUES
(8, 'Hamid Septian', 'Maransi', '081993962256', '002-00-201001-081808', 'Nasabah'),
(9, 'Faisal Maryono', 'Solok', '081212121212', '002-008-201001-081819', 'Calon Nasabah'),
(10, 'Ghino Martin', 'LA', '08124343634', '002-009-201001-081856', 'Calon Nasabah'),
(11, 'Hendra Sukma', 'Siteba', '0832852385', '002-010-201001-081905', 'Nasabah'),
(12, 'Irfan Maulana', 'Lubay', '000000', '002-011-201001-081909', 'Calon Nasabah'),
(13, 'Hendri Faisal', '??', '081919191919', '002-012-201001-081921', 'Calon Nasabah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_nasabah` varchar(5) NOT NULL,
  `id_nasabah2` varchar(5) NOT NULL,
  `jumlah` int(16) NOT NULL,
  `jenis` varchar(25) NOT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `jam_transaksi` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_nasabah`, `id_nasabah2`, `jumlah`, `jenis`, `tgl_transaksi`, `jam_transaksi`) VALUES
(25, '8', '', 500000, 'Setoran', '2020-10-01', '08:22:16'),
(26, '8', '11', 50000, 'Transfer', '2020-10-01', '08:22:43'),
(27, '11', '8', 50000, 'Terima Transfer', '2020-10-13', '08:22:43'),
(28, '11', '', 50000, 'Setoran', '2020-10-12', '08:26:31'),
(29, '11', '10', 1000, 'Transfer', '2020-10-01', '08:36:05'),
(30, '10', '11', 1000, 'Terima Transfer', '2020-10-01', '08:36:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `level`) VALUES
(1, 'Hamid Sptian', '123', '123', 'CS'),
(2, 'NAsruddin', '11', '11', 'BO'),
(3, 'Faisa', '22', '22', 'Teller');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id_nasabah`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id_nasabah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
