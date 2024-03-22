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

    <title>Laporan Simpanan Wajib</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Simpanan Wajib</h3>
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
        AND Status_Simpanan='Konfirmasi' AND ID_Anggota='$_GET[ID_Anggota]'";

$sql = mysqli_query($konek, "$query");
while ($w = mysqli_fetch_array($sql)) {
    $html .= ' <tr class="table-w">
                    <td align="center">' . $w["ID_Simpanan"] . '</td>
                    <td align="center">' . $w["ID_Tabungan"] . '</td>
                    <td width="270px">' . $w["Nama_Anggota"] . '</td>
                    <td align="center">' . $w["Tanggal_Transaksi"] . '</td>
                    <td align="right">' . rp($w["Saldo_Simpanan"]) . '</td>
                </tr>';
}
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
