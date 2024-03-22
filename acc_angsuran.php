<?php
// get id anggota untuk proses hapus
include "koneksi.php";
function tgl($tanggal)
{
    $bulan_arr    = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    // $hari_arr     = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    $ex           = explode('-', $tanggal);
    $hari         = date('N', strtotime($tanggal));
    $tanggal_indo = $ex[2] . ' ' . $bulan_arr[(int)$ex[1]] . ' ' . $ex[0];

    return $tanggal_indo;
}
if (isset($_GET['act'])) {

    if ($_GET['act'] == 'acc') {
        $ID_Angsuran = $_GET['ID_Angsuran'];
        $Konfirmasi  = date('Y-m-d');
        $src_id      = $_GET['idp'];
        $jt          = $_GET['Jatuh_Tempo'];


        if ($Konfirmasi > $jt) {
            $jatuhTempo = $jt;
            $konfirm = date('Y-m-d');
            $jatuhTempo = new DateTime($jatuhTempo);
            $selesai =  new DateTime($konfirm);
            $selisih = $selesai->diff($jatuhTempo);
            $hari =  $selisih->days;

            $denda = 500 * $hari;
        } else {
            $denda = "0";
            $hari  = "";
        }

        $update = mysqli_query($konek, "UPDATE angsuran SET
                                            Tgl_Entri='$Konfirmasi',
                                            Denda='$denda',
                                            Telat_Denda = '$hari',
                                            Status_Angsuran='Lunas'
                                            WHERE ID_Angsuran='$ID_Angsuran'");
        echo "<script>document.location.href = 'angsuran.php?ID_Pinjaman=$src_id';</script>";
    }

    if ($_GET['act'] == 'batal') {
        $ID_Angsuran = $_GET['ID_Angsuran'];
        $Konfirmasi  = date('Y-m-d');
        $src_id      = $_GET['idp'];

        $update = mysqli_query($konek, "UPDATE angsuran SET
                                            Tgl_Entri='',
                                            Denda='',
                                            Telat_Denda='',
                                            Status_Angsuran='Belum Lunas'
                                            WHERE ID_Angsuran='$ID_Angsuran'");
        echo "<script>document.location.href = 'angsuran.php?ID_Pinjaman=$src_id';</script>";
    }
}
