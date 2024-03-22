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

function hari($date)
{
    $hari_arr     = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $hari         = date('N', strtotime($date));
    return $hari_arr[$hari];
}

function rupiah($angka)
{
    $hasil_rupiah = "" . number_format($angka, 0, '', '.');
    return $hasil_rupiah;
}

function rp($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, '', '.');
    return $hasil_rupiah;
}

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="print.css">

    <title>Laporan Pinjaman Angsuran</title>
</head>
<body>
    <h1>KOPERASI RUKUN SANTOSO</h1>
    <h3>Pinjaman Angsuran</h3>
    <hr>';

$ql = mysqli_query($konek, "SELECT SUM(Besar_Angsuran) as Total_Lunas,ID_Pinjaman,anggota.ID_Anggota, anggota.Nama_Anggota FROM angsuran INNER JOIN anggota on anggota.ID_Anggota = angsuran.ID_Anggota WHERE ID_Pinjaman='$_GET[ID_Pinjaman]' AND Status_Angsuran='Lunas'");
$dl = mysqli_fetch_array($ql);
$total_lunas = $dl['Total_Lunas'];

$qbl = mysqli_query($konek, "SELECT SUM(Besar_Angsuran) as Total_Belum_Lunas FROM angsuran WHERE ID_Pinjaman='$_GET[ID_Pinjaman]' AND Status_Angsuran='Belum Lunas'");
$dbl = mysqli_fetch_array($qbl);
$total_belum_lunas = $dbl['Total_Belum_Lunas'];
$html .= '<table border="1" cellpadding="10" cellspacing="0" class="isi">
            <thead>
                <tr align="center">
                    <th>ID Angsuran</th>
                    <th>Angsuran</th>
                    <th>Nama Anggota</th>
                    <th>Besaran Angsuran</th>
                    <th>Jatuh Tempo</th>
                    <th>Konfirmasi</th>
                    <th>Denda</th>
                    <th>Telat Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';
$sql = mysqli_query($konek, "SELECT * FROM angsuran INNER JOIN anggota on anggota.ID_Anggota = angsuran.ID_Anggota
            WHERE ID_Angsuran='$_GET[ID_Angsuran]'");
while ($a = mysqli_fetch_array($sql)) {
    if ($a['Telat_Denda'] == null) {
        $telatDenda = '';
    } else {
        $telatDenda = $a['Telat_Denda'] . " Hari";
    }

    if ($a['Jatuh_Tempo'] == date('Y-m-d') && $a['Status_Angsuran'] == 'Belum Lunas') {
        $keterangan = "text-danger";
    } elseif ($a['Status_Angsuran'] == 'Belum Lunas') {
        $keterangan = "text-danger";
    } else {
        $keterangan = "text-primary";
    }
    if ($a['Tgl_Entri'] == null) {
        $tgl_konfirmasi = "";
    } else {
        $tgl_konfirmasi = tgl($a['Tgl_Entri']);
    }

    $html .= ' <tr class="' . $keterangan . '">
    <td align="center">' . $a["ID_Angsuran"] . '</td>
    <td align="center">' . $a["Angsuran"] . '</td>
    <td align="center">' . $a["Nama_Anggota"] . '</td>
    <td align="right">' . rupiah($a["Besar_Angsuran"]) . '</td>
    <td align="center">' . tgl($a["Jatuh_Tempo"]) . '</td>
    <td align="center">' . $tgl_konfirmasi . ' </td>
    <td align="right">' . $a["Denda"] . '</td>
    <td align="center">
        ' . $telatDenda . '
    </td>
    <td align="center">' . $a['Status_Angsuran'] . '</td>
</tr>';
}
$html .= ' </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
