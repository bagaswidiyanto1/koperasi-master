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
$sql_total  = mysqli_query($konek, "SELECT SUM(Saldo_Simpanan) as Total_Wajib FROM simpanan 
        INNER JOIN anggota on anggota.ID_Tabungan = simpanan.ID_Tabungan WHERE Jenis_Simpanan='Simpanan Wajib' AND Status_Simpanan='Konfirmasi'");
$total_sw   = mysqli_fetch_array($sql_total);
$sw         = $total_sw['Total_Wajib'];

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="print.css">

    <title>Laporan Simpanan Wajib</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Simpanan Wajib</h3>
    Dari tanggal : ' . tgl($_GET['tgl1']) . ' - ' . tgl($_GET['tgl2']) .
    '<br>
    <span>Total: ' . rp($sw) . '</span>
    <hr>
    <table border="1" cellpadding="10" cellspacing="0">
            <tr align="center" class="table-w">
                <th>ID Simpanan</th>
                <th>ID Tabungan</th>
                <th>Nama_Anggota</th>
                <th>Tanggal Transaksi</th>
                <th>Saldo Simpanan</th>
            </tr>
            </thead>
            <tbody>';
$query = "SELECT * FROM simpanan INNER JOIN anggota 
        on anggota.ID_Tabungan = simpanan.ID_Tabungan WHERE Jenis_Simpanan='Simpanan Wajib' 
        AND Status_Simpanan='Konfirmasi' AND Tanggal_Transaksi BETWEEN '$_GET[tgl1]' AND '$_GET[tgl2]'";

$sql = mysqli_query($konek, "$query");
while ($w = mysqli_fetch_array($sql)) {

    $html .= ' <tr class="table-w">
                    <td align="center">' . $w["ID_Simpanan"] . '</td>
                    <td align="center">' . $w["ID_Tabungan"] . '</td>
                    <td width="220px">' . $w["Nama_Anggota"] . '</td>
                    <td align="center">' . tgl($w["Tanggal_Transaksi"]) . '</td>
                    <td align="right">' . rp($w["Saldo_Simpanan"]) . '</td>
                </tr>';
}
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
