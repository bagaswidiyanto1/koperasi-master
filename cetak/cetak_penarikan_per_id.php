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
    <hr>
    <table border="1" cellpadding="10" cellspacing="0">
            <tr align="center" class="table-w">
                <th>ID Penarikan</th>
                <th>ID Tabungan</th>
                <th>Nama Anggota</th>
                <th>Total Penarikan</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>';
$query = "SELECT * FROM penarikan INNER JOIN anggota USING(ID_Tabungan) WHERE Status_Penarikan='Konfirmasi' AND ID_Anggota='$_GET[ID_Anggota]'";

$sql = mysqli_query($konek, "$query");
while ($penarikan = mysqli_fetch_array($sql)) {

    $html .= ' <tr class="table-w">
                    <td align="center">' . $penarikan["ID_Penarikan"] . '</td>
                    <td align="center">' . $penarikan["ID_Tabungan"] . '</td>
                    <td width="270px">' . $penarikan["Nama_Anggota"] . '</td>
                    <td align="right">' . rp($penarikan["Besar_Penarikan"]) . '</td>
                    <td align="center">' . $penarikan["Tgl_Entri"] . '</td>
                </tr>';
}
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
