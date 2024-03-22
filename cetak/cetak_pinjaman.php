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

    <title>Laporan Pinjaman</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Pinjaman Anggota</h3>

<hr>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr align="center" class="table-w">
                <th>No</th>
                <th>ID Pinjaman</th>
                <th width="100px">Tgl Pinjam</th>
                <th>Nama Anggota</th>
                <th>Jenis Pinjaman</th>
                <th>Jumlah Pinjaman</th>
                <th>Angsuran</th>
                <th>Bunga</th>
                <th>Jumlah Angsuran</th>
                <th>Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>';
$no = 1;
$query = "SELECT * FROM pinjaman INNER JOIN anggota USING(ID_Anggota) WHERE Status_Pinjaman='Konfirmasi'";
$sql = mysqli_query($konek, "$query");
while ($pinjaman = mysqli_fetch_array($sql)) {

    $html .= ' <tr class="table-w">
                    <td align="center">' . $no++ . '</td>
                    <td align="center">' . $pinjaman["ID_Pinjaman"] . '</td>
                    <td align="center">' . tgl($pinjaman["Tgl_Entri"]) . '</td>
                    <td width="250px">' . $pinjaman["Nama_Anggota"] . '</td>
                    <td align="center">' . $pinjaman["Nama_Pinjaman"] . '</td>
                    <td align="right">' . rp($pinjaman["Besar_Pinjaman"]) . '</td>
                    <td align="right">' . rp($pinjaman["Besar_Angsuran"]) . '</td>
                    <td align="right">' . $pinjaman["Bunga"] . '%</td>
                    <td align="right">' . $pinjaman["Lama_Angsuran"] . 'x</td>
                    <td align="right">' . tgl($pinjaman["Jatuh_Tempo"]) . '</td>
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
