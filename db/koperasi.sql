-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Agu 2023 pada 06.13
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `ID_Anggota` varchar(20) NOT NULL,
  `ID_Tabungan` varchar(20) NOT NULL,
  `ID_User` varchar(20) NOT NULL,
  `Nama_Anggota` varchar(200) NOT NULL,
  `Jenis_Kelamin` varchar(10) NOT NULL,
  `Tempat_Lahir` varchar(50) NOT NULL,
  `Tanggal_Lahir` date NOT NULL,
  `Pendidikan_Terakhir` varchar(5) NOT NULL,
  `Status_Perkawinan` varchar(15) NOT NULL,
  `Simpanan_Pokok` int(11) NOT NULL,
  `No_KTP` int(11) NOT NULL,
  `No_KK` int(11) NOT NULL,
  `No_Telp` int(11) NOT NULL,
  `No_Rek` int(11) NOT NULL,
  `Tanggal_Entri` varchar(15) NOT NULL,
  `Alamat` text NOT NULL,
  `Status_Aktif` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`ID_Anggota`, `ID_Tabungan`, `ID_User`, `Nama_Anggota`, `Jenis_Kelamin`, `Tempat_Lahir`, `Tanggal_Lahir`, `Pendidikan_Terakhir`, `Status_Perkawinan`, `Simpanan_Pokok`, `No_KTP`, `No_KK`, `No_Telp`, `No_Rek`, `Tanggal_Entri`, `Alamat`, `Status_Aktif`) VALUES
('KSA250001', 'KST200001', 'KSP200001', 'Bagas Widiyanto', 'Laki-Laki', 'Jauh', '2023-08-21', 'D3', 'Belum Menikah', 150000, 2147483647, 2147483647, 2147483647, 2147483647, '2023-08-01', 'Cibinong', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `angsuran`
--

CREATE TABLE `angsuran` (
  `ID_Angsuran` varchar(20) NOT NULL,
  `ID_Pinjaman` varchar(20) NOT NULL,
  `Angsuran` int(11) NOT NULL,
  `Besar_Angsuran` int(11) NOT NULL,
  `ID_Anggota` varchar(20) NOT NULL,
  `Tgl_Entri` date NOT NULL,
  `Denda` int(11) NOT NULL,
  `Telat_Denda` int(11) NOT NULL,
  `Jatuh_Tempo` date NOT NULL,
  `Status_Angsuran` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar`
--

CREATE TABLE `gambar` (
  `ID_Gambar` int(11) NOT NULL,
  `Profil_Image` varchar(255) NOT NULL,
  `ID_User` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `ID_History` int(11) NOT NULL,
  `ID_Tabungan` varchar(20) NOT NULL,
  `Jenis_History` varchar(20) NOT NULL,
  `Jumlah_History` int(11) NOT NULL,
  `Saldo_Terakhir` int(11) NOT NULL,
  `Waktu_History` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `history`
--

INSERT INTO `history` (`ID_History`, `ID_Tabungan`, `Jenis_History`, `Jumlah_History`, `Saldo_Terakhir`, `Waktu_History`) VALUES
(1, 'KST200001', 'Simpanan Wajib', 20000, 170000, '2023-08-21'),
(2, 'KST200001', 'Penarikan', 20000000, -19850000, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pinjaman`
--

CREATE TABLE `jenis_pinjaman` (
  `ID_Jenis_Pinjaman` int(11) NOT NULL,
  `Nama_Pinjaman` varchar(50) NOT NULL,
  `Max_Pinjaman` int(11) NOT NULL,
  `Bunga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_simpanan`
--

CREATE TABLE `jenis_simpanan` (
  `ID_Jenis_Simpanan` int(11) NOT NULL,
  `Nama_Simpanan` varchar(50) NOT NULL,
  `Besar_Simpanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_simpanan`
--

INSERT INTO `jenis_simpanan` (`ID_Jenis_Simpanan`, `Nama_Simpanan`, `Besar_Simpanan`) VALUES
(1, 'Simpanan Wajib', 30000),
(2, 'Simpanan Sukarela', 0),
(3, 'Simpanan Dana Sosial', 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `ID_Konfigurasi` int(11) NOT NULL,
  `Nama_Konfigurasi` varchar(200) NOT NULL,
  `Isi_Konfigurasi` text NOT NULL,
  `Tanggal_Ubah` date NOT NULL,
  `Jenis_Konfigurasi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penarikan`
--

CREATE TABLE `penarikan` (
  `ID_Penarikan` varchar(20) NOT NULL,
  `ID_Tabungan` varchar(20) NOT NULL,
  `Besar_Penarikan` int(11) NOT NULL,
  `Tgl_Entri` date NOT NULL,
  `Status_Penarikan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjaman`
--

CREATE TABLE `pinjaman` (
  `ID_Pinjaman` varchar(20) NOT NULL,
  `ID_Anggota` varchar(20) NOT NULL,
  `Nama_Pinjaman` varchar(200) NOT NULL,
  `Besar_Pinjaman` int(11) NOT NULL,
  `Besar_Angsuran` int(11) NOT NULL,
  `Lama_Angsuran` int(11) NOT NULL,
  `Bunga` double NOT NULL,
  `Tgl_Entri` date NOT NULL,
  `Jatuh_Tempo` date NOT NULL,
  `Status_Pinjaman` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `simpanan`
--

CREATE TABLE `simpanan` (
  `ID_Simpanan` varchar(20) NOT NULL,
  `ID_Anggota` varchar(20) NOT NULL,
  `ID_Tabungan` varchar(20) NOT NULL,
  `Jenis_Simpanan` varchar(20) NOT NULL,
  `Tanggal_Transaksi` date NOT NULL,
  `Saldo_Simpanan` int(11) NOT NULL,
  `Status_Simpanan` varchar(15) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `simpanan`
--

INSERT INTO `simpanan` (`ID_Simpanan`, `ID_Anggota`, `ID_Tabungan`, `Jenis_Simpanan`, `Tanggal_Transaksi`, `Saldo_Simpanan`, `Status_Simpanan`, `gambar`) VALUES
('KSS290001', '', 'KST200001', 'Simpanan Wajib', '2023-08-21', 20000, 'Menunggu', '64e2de1483e98.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabungan`
--

CREATE TABLE `tabungan` (
  `ID_Tabungan` varchar(20) NOT NULL,
  `ID_Anggota` varchar(20) NOT NULL,
  `Tgl_Mulai` varchar(15) NOT NULL,
  `Besar_Tabungan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabungan`
--

INSERT INTO `tabungan` (`ID_Tabungan`, `ID_Anggota`, `Tgl_Mulai`, `Besar_Tabungan`) VALUES
('KST200001', 'KSA250001', '0000-00-00', 150000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `ID_User` varchar(20) NOT NULL,
  `Username` varchar(16) DEFAULT NULL,
  `Password` varchar(16) DEFAULT NULL,
  `Nama_Lengkap` varchar(200) DEFAULT NULL,
  `Jabatan` varchar(100) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Level` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`ID_User`, `Username`, `Password`, `Nama_Lengkap`, `Jabatan`, `Email`, `Level`) VALUES
('KSP200001', 'bagas_widiyanto', '123456', 'Bagas Widiyanto', NULL, 'bagaswidiyanto@gmail.com', 'Anggota'),
('L200001', 'bagas', '123456', 'Bagas Widiyanto', '-', 'bagas@gmail.com', 'Petugas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`ID_Anggota`);

--
-- Indeks untuk tabel `angsuran`
--
ALTER TABLE `angsuran`
  ADD PRIMARY KEY (`ID_Angsuran`);

--
-- Indeks untuk tabel `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`ID_Gambar`);

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`ID_History`);

--
-- Indeks untuk tabel `jenis_pinjaman`
--
ALTER TABLE `jenis_pinjaman`
  ADD PRIMARY KEY (`ID_Jenis_Pinjaman`);

--
-- Indeks untuk tabel `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  ADD PRIMARY KEY (`ID_Jenis_Simpanan`);

--
-- Indeks untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`ID_Konfigurasi`);

--
-- Indeks untuk tabel `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`ID_Penarikan`);

--
-- Indeks untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`ID_Pinjaman`);

--
-- Indeks untuk tabel `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`ID_Simpanan`);

--
-- Indeks untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD PRIMARY KEY (`ID_Tabungan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_User`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `history`
--
ALTER TABLE `history`
  MODIFY `ID_History` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_pinjaman`
--
ALTER TABLE `jenis_pinjaman`
  MODIFY `ID_Jenis_Pinjaman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  MODIFY `ID_Jenis_Simpanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `ID_Konfigurasi` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
