<?php
require_once __DIR__ . '/../vendor/autoload.php';

include "../koneksi.php";

function rp($angka)
{

    $hasil_rupiah = "Rp. " . number_format($angka, 0, '', '.');
    return $hasil_rupiah;
}

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
    <h3>Penarikan</h3>
    <hr>';
$sqlSW = mysqli_query($konek, "SELECT * FROM penarikan INNER JOIN anggota 
    on anggota.ID_Tabungan = penarikan.ID_Tabungan WHERE ID_Penarikan='$_GET[ID_Penarikan]'");
$dsw = mysqli_fetch_array($sqlSW);
$html .= '<table >
                <tr>
                    <td width="130">ID Penarikan</td>
                    <td width="4">:</td>
                    <td>' . $dsw["ID_Penarikan"] . '</td>
                </tr>
                <tr>
                    <td>Nama Anggota</td>
                    <td>:</td>
                    <td>' . $dsw["Nama_Anggota"] . '</td>
                </tr>
            </table>
            <hr>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr  class="table-p">
                <th>ID Penarikan</th>
                <th>ID Tabungan</th>
                <th>Nama_Anggota</th>
                <th>Tanggal Transaksi</th>
                <th>Saldo Penarikan</th>
            </tr>
            </thead>
            <tbody>';
$query = "SELECT * FROM Penarikan INNER JOIN anggota 
        on anggota.ID_Tabungan = Penarikan.ID_Tabungan WHERE ID_Penarikan='$_GET[ID_Penarikan]' AND Status_Penarikan='Konfirmasi'";

$sql = mysqli_query($konek, "$query");
while ($p = mysqli_fetch_array($sql)) {

    $html .= ' <tr class="table-p">
                    <td align="center">' . $p["ID_Penarikan"] . '</td>
                    <td align="center">' . $p["ID_Tabungan"] . '</td>
                    <td>' . $p["Nama_Anggota"] . '</td>
                    <td align="center">' . $p["Tgl_Entri"] . '</td>
                    <td align="right">' . rp($p["Besar_Penarikan"]) . '</td>
                </tr>';
}
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
