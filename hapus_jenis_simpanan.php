<?php
// get id anggota untuk proses hapus
include "koneksi.php";
$hapus = mysqli_query($konek, "DELETE FROM jenis_simpanan WHERE ID_Jenis_Simpanan='$_GET[ID_Jenis_Simpanan]'");

header('location:help_jasa.php');
