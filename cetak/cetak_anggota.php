<?php
require_once __DIR__ . '/../vendor/autoload.php';

include "../koneksi.php";

function rp($angka)
{

    $hasil_rupiah = "Rp. " . number_format($angka, 0, '', '.');
    return $hasil_rupiah;
}
function tgl($tanggal)
{
    $bulan_arr    = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    // $hari_arr     = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    $ex           = explode('-', $tanggal);
    $hari         = date('N', strtotime($tanggal));
    $tanggal_indo = $ex[2] . ' ' . $bulan_arr[(int)$ex[1]] . ' ' . $ex[0];

    return $tanggal_indo;
}

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="print.css">

    <title>Laporan Anggota</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Anggota Koperasi</h3>';

$html .= '

<hr>
    <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr align="center" class="table-w">
                    <th>No</th>
                    <th>ID Anggota</th>
                    <th>ID Tabungan</th>
                    <th width="150px">Nama Anggota</th>
                    <th width="115px" >Tempat, Tanggal Lahir</th>
                    <th width="200px">Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Pendidikan Terakhir</th>
                    <th>Status Perkawinan</th>
                    <th>No.KTP</th>
                    <th>No.KK</th>
                    <th>No.Telp</th>
                    <th>No Rekening</th>
                </tr>
            </thead>
            <tbody>';
$no = 1;
$query = "SELECT *  FROM anggota";

$sql = mysqli_query($konek, "$query");
while ($anggota = mysqli_fetch_array($sql)) {

    $html .= ' <tr class="table-w">
                    <td>' . $no++ . '</td>
                    <td>' . $anggota["ID_Anggota"] . '</td>
                    <td>' . $anggota["ID_Tabungan"] . '</td>
                    <td>' . $anggota["Nama_Anggota"] . '</td>
                    <td>' . $anggota["Tempat_Lahir"] . ', ' . tgl($anggota["Tanggal_Lahir"]) . '</td>
                    <td>' . $anggota["Alamat"] . '</td>
                    <td>' . $anggota["Jenis_Kelamin"] . '</td>
                    <td>' . $anggota["Pendidikan_Terakhir"] . '</td>
                    <td>' . $anggota["Status_Perkawinan"] . '</td>
                    <td>' . $anggota["No_KTP"] . '</td>
                    <td>' . $anggota["No_KK"] . '</td>
                    <td>' . $anggota["No_Telp"] . '</td>
                    <td>' . $anggota["No_Rek"] . '</td>
                </tr>';
}
$no++;
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->AddPage('L');
$mpdf->WriteHTML($html);
$mpdf->Output();
