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
$sql_total  = mysqli_query($konek, "SELECT SUM(Saldo_Simpanan) as Total_Sukarela FROM simpanan 
        INNER JOIN anggota on anggota.ID_Tabungan = simpanan.ID_Tabungan WHERE Jenis_Simpanan='Simpanan Sukarela' AND Status_Simpanan='Konfirmasi'");
$total_sw   = mysqli_fetch_array($sql_total);
$ss         = $total_sw['Total_Sukarela'];

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="print.css">

    <title>Laporan Sukarela</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Simpanan Sukarela</h3>
    <span>Total: ' . rp($ss) . '</span>
    <hr>
    <table border="1" cellpadding="10" cellspacing="0">
            <tr align="center" class="table-w">
                <th>No</th>
                <th>ID Simpanan</th>
                <th>ID Tabungan</th>
                <th>Nama_Anggota</th>
                <th>Tanggal Transaksi</th>
                <th>Saldo Simpanan</th>
            </tr>
            </thead>
            <tbody>';
$no = 1;
$query = "SELECT * FROM simpanan INNER JOIN anggota 
        on anggota.ID_Tabungan = simpanan.ID_Tabungan WHERE Jenis_Simpanan='Simpanan Sukarela' 
        AND Status_Simpanan='Konfirmasi'";

$sql = mysqli_query($konek, "$query");
while ($ss = mysqli_fetch_array($sql)) {

    $html .= ' <tr class="table-w">
                    <td align="center">' . $no++ . '</td>
                    <td align="center">' . $ss["ID_Simpanan"] . '</td>
                    <td align="center">' . $ss["ID_Tabungan"] . '</td>
                    <td width="270px">' . $ss["Nama_Anggota"] . '</td>
                    <td align="center">' . tgl($ss["Tanggal_Transaksi"]) . '</td>
                    <td align="right">' . rp($ss["Saldo_Simpanan"]) . '</td>
                </tr>';
}
$no++;
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
