<?php
require_once __DIR__ . '/../vendor/autoload.php';

include "../koneksi.php";
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
$mpdf->AddPage('L');
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Anggota</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Anggota Koperasi</h3>
    <hr>';
$sqlAnggota = mysqli_query($konek, "SELECT * FROM anggota WHERE ID_Anggota='$_GET[ID_Anggota]'");
$da = mysqli_fetch_array($sqlAnggota);
$html .= '<table>
            <tr>
                <td width="100">Nama Siswa</td>
                <td width="4">:</td>
                <td>' . $da["Nama_Anggota"] . '</td>
            </tr>
            <tr>
                <td width="100">NIS</td>
                <td width="4">:</td>
                <td>' . $da["ID_Anggota"] . '</td>
            </tr>
        </table>
        <hr>

        <table border="1" cellpadding="10" cellspacing="0" style="font-size: 8px">
            <thead>
                <tr>
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
$a = mysqli_query($konek, "SELECT * FROM anggota WHERE ID_Anggota='$_GET[ID_Anggota]'");
$dta = mysqli_fetch_array($a);
$html .= '      <tr>
                    <td>' . $dta["ID_Anggota"] . '</td>
                    <td>' . $dta["ID_Tabungan"] . '</td>
                    <td>' . $dta["Nama_Anggota"] . '</td>
                    <td>' . $dta["Tempat_Lahir"] . ', ' . tgl($dta["Tanggal_Lahir"]) . '</td>
                    <td>' . $dta["Alamat"] . '</td>
                    <td>' . $dta["Jenis_Kelamin"] . '</td>
                    <td>' . $dta["Pendidikan_Terakhir"] . '</td>
                    <td>' . $dta["Status_Perkawinan"] . '</td>
                    <td>' . $dta["No_KTP"] . '</td>
                    <td>' . $dta["No_KK"] . '</td>
                    <td>' . $dta["No_Telp"] . '</td>
                    <td>' . $dta["No_Rek"] . '</td>
                </tr>
                
            </tbody>
        </table>

        
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
