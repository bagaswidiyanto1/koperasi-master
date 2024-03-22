<?php
// get id anggota untuk proses hapus
include "koneksi.php";
$hapus = mysqli_query($konek, "DELETE FROM jenis_pinjaman WHERE ID_Jenis_Pinjaman='$_GET[ID_Jenis_Pinjaman]'");

header('location:help_jasa.php');
