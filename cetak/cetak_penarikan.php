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

$sql_penarikan   = mysqli_query($konek, "SELECT SUM(Besar_Penarikan) AS penarikan FROM penarikan 
                INNER JOIN anggota ON anggota.ID_Tabungan = penarikan.ID_Tabungan WHERE Status_Penarikan='Konfirmasi'");
$penarikan       = mysqli_fetch_array($sql_penarikan);
$total_penarikan = $penarikan['penarikan'];

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="print.css">

    <title>Laporan Penarikan</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Penarikan Anggota</h3>
    <span>Total: ' . rp($total_penarikan) . '</span>
    <hr>
    <table border="1" cellpadding="10" cellspacing="0">
            <tr align="center" class="table-w">
                <th>No</th>
                <th>ID Penarikan</th>
                <th>ID Tabungan</th>
                <th>Nama Anggota
                <th>Total Penarikan</th>
                <th>Tanggal Penarikan</th>
            </tr>
            </thead>
            <tbody>';
$no = 1;
$query = "SELECT * FROM penarikan INNER JOIN anggota USING(ID_Tabungan) WHERE Status_Penarikan='Konfirmasi'";

$sql = mysqli_query($konek, "$query");
while ($penarikan = mysqli_fetch_array($sql)) {

    $html .= ' <tr class="table-w">
                    <td align="center">' . $no++ . '</td>
                    <td align="center">' . $penarikan["ID_Penarikan"] . '</td>
                    <td align="center">' . $penarikan["ID_Tabungan"] . '</td>
                    <td width="270px">' . $penarikan["Nama_Anggota"] . '</td>
                    <td align="center">' . rp($penarikan["Besar_Penarikan"]) . '</td>
                    <td align="right">' . $penarikan["Tgl_Entri"] . '</td>
                </tr>';
}
$no++;
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
