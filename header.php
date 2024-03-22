<?php include "koneksi.php";

session_start();
if (!isset($_SESSION['login'])) {
    header('location:login.php');
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

function hari($date)
{
    $hari_arr     = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $hari         = date('N', strtotime($date));
    return $hari_arr[$hari];
}



$timezone = new DateTimeZone('Asia/Jakarta');
$date = new DateTime();
$date->setTimeZone($timezone);

?>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<style>
    .header,
    .footer {
        width: 100%;
        position: sticky;
        background: #fff;
        padding: 10px 0;
        color: black;

    }

    .header {
        top: 0;
    }

    .footer {
        bottom: 0;
    }

    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-size: 500px;
        background: url('img/packman.gif') 50% 50% no-repeat rgb(255, 255, 255);
        opacity: inherit;
    }
</style>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>KSP Cibinong</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="asset/background.css">
    <link rel="stylesheet" href="plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/jquery-toast-plugin/dist/jquery.toast.min.css">
    <link rel="stylesheet" href="plugins/weather-icons/css/weather-icons.min.css">
    <link rel="stylesheet" href="plugins/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="plugins/c3/c3.min.css">
    <link rel="stylesheet" href="plugins/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="plugins/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="dist/css/theme.min.css">
    <link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet" type="text/css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


    <script type="text/javascript">
        $(document).load(function() {
            setTimeout(function() {
                $(".loader").fadeOut("slow");
            });
        });
    </script>

</head>

<body>
    <!--<div class="loader"></div>-->
    <div class="wrapper">
        <header class="header-top" header-theme="light">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <?php if ($_SESSION['Level'] == 'Petugas') { ?>
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                            <div class="header-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                    <input type="text" class="form-control">
                                    <a>Selamat Datang <b class="text-dark ml-2"><?= $_SESSION['Nama_Lengkap']; ?></b></a>
                                    <!-- <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button> -->
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                            <a><b class="text-dark ml-2"><?= $_SESSION['Nama_Lengkap']; ?></b></a>
                            <div class="header-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                    <!-- <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button> -->
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="top-menu d-flex align-items-center">
                        <?php if ($_SESSION['Level'] == 'Petugas') { ?>
                            <div class="dropdown">
                                <?php
                                $pSimpanan = mysqli_query($konek, "SELECT COUNT(ID_Simpanan) as total_simpanan FROM simpanan WHERE Status_Simpanan ='Menunggu'");
                                $dSimpanan = mysqli_fetch_array($pSimpanan);
                                $total_simpanan = $dSimpanan['total_simpanan'];

                                $pPenarikan = mysqli_query($konek, "SELECT COUNT(ID_Penarikan) as total_penarikan FROM penarikan WHERE Status_Penarikan ='Menunggu'");
                                $dPenarikan = mysqli_fetch_array($pPenarikan);
                                $total_penarikan = $dPenarikan['total_penarikan'] + $total_simpanan;

                                $pPinjaman = mysqli_query($konek, "SELECT COUNT(ID_Pinjaman) as total_pinjaman FROM pinjaman WHERE Status_Pinjaman ='Menunggu'");
                                $dPinjaman = mysqli_fetch_array($pPinjaman);
                                $total_pinjaman = $dPinjaman['total_pinjaman'] + $total_penarikan;
                                ?>
                                <button class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ik ik-bell" title="Notif Simpanan"></i><span class="badge bg-danger"><?= $total_pinjaman; ?></span></button>


                                <div class="dropdown-menu dropdown-menu-right notification-dropdown" style=" height: 500px; width: 400px; overflow: auto;" aria-labelledby="notiDropdown">
                                    <h3 class="header" align="right">Notifications <span class="badge badge-danger text-bold" style="margin-left: 60px;"><?= $total_pinjaman; ?> NEW</span></h3>

                                    <div class="notifications-wrap">
                                        <!-- Notifikasi Simpanan -->
                                        <?php
                                        $qNotif = mysqli_query($konek, "SELECT A.* FROM (SELECT c.Nama_Anggota, 'simpanan' as menu, a.Tanggal_Transaksi as tanggal, a.Jenis_Simpanan as jenis_simpanan FROM simpanan as a INNER JOIN anggota as c USING(ID_Tabungan) WHERE Status_Simpanan ='Menunggu'
                                        UNION
                                        SELECT d.Nama_Anggota, 'penarikan' as menu, b.Tgl_Entri as tanggal, '' as jenis_simpanan FROM penarikan as b INNER JOIN anggota as d USING(ID_Tabungan) WHERE Status_Penarikan = 'Menunggu'
                                        UNION
                                        SELECT e.Nama_Anggota, 'pinjaman' as menu, f.Tgl_Entri as tanggal, '' as jenis_simpanan FROM pinjaman AS f INNER JOIN anggota as e USING(ID_Anggota) WHERE Status_pinjaman ='Menunggu') as A ORDER BY A.tanggal DESC");
                                        while ($dNotif = mysqli_fetch_array($qNotif)) {
                                            if ($dNotif['jenis_simpanan'] == 'Simpanan Wajib') {
                                                $simpanan = "warning";
                                            } elseif ($dNotif['jenis_simpanan'] == 'Simpanan Sukarela') {
                                                $simpanan = "warning";
                                            } else {
                                                $simpanan = "warning";
                                            }
                                            $namamenu = "";
                                            $link = "";
                                            if ($dNotif['menu'] == 'simpanan') {
                                                $namamenu = $dNotif['jenis_simpanan'];
                                                $link = 'pengajuan_simpanan.php';
                                            } elseif ($dNotif['menu'] == 'penarikan') {
                                                $namamenu = 'Penarikan';
                                                $link = 'pengajuan_penarikan.php';
                                            } elseif ($dNotif['menu'] == 'pinjaman') {
                                                $namamenu = 'Pinjaman';
                                                $link = 'pengajuan_pinjaman.php';
                                            }
                                        ?>

                                            <a href="<?= $link; ?>" class="media">
                                                <span class="media-body">
                                                    <small><i class="ml-4 text-red"><?= $dNotif['tanggal'] ?></i></small><br />
                                                    <span class="media-content mr-2 h6"><i class="text-danger ik ik-info"></i></span>
                                                    <span class="media-content h6 text-dark text-red"><?= $dNotif['Nama_Anggota']; ?> - </span>
                                                    <span class="media-content h6 text-<?= $simpanan; ?>">
                                                        <?= $namamenu ?>
                                                    </span>
                                                </span>
                                            </a>

                                        <?php } ?>

                                    </div>
                                    <!-- <div class="footer"><a href="javascript:void(0);">See all activity</a></div> -->
                                </div>
                            </div>


                        <?php } ?>

                        <div class="dropdown">
                            <?php
                            $dtfoto = mysqli_query($konek, "SELECT * FROM user INNER JOIN gambar USING(ID_User) WHERE user.ID_User='$_SESSION[ID_User]'");
                            $df     = mysqli_fetch_array($dtfoto);
                            ?>

                            <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="img/profil/<?= $df['Profil_Image']; ?>" title="<?= $_SESSION['Nama_Lengkap']; ?>"></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profil.php"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                                <a class="dropdown-item" href="logout.php"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <div class="page-wrap">
            <!-- Sidebar -->
            <div class="app-sidebar colored">
                <div class="sidebar-header">
                    <a class="header-brand" href="index.html">
                        <div class="logo-img">
                            <img src="0001.png" width="125" style="color: white; margin-top: 140px;" class="header-brand-img" alt="lavalite">
                        </div>
                        <span class="text" style="margin-left: 8px">Bedahan</span>
                    </a>
                    <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                    <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                </div>

                <div class="sidebar-content">
                    <div class="nav-container font-weight-bold">
                        <?php if ($_SESSION['Level'] == 'Petugas') { ?>
                            <nav id="main-menu-navigation" class="navigation-main">
                                <?php
                                if ($menu == 'index') {
                                    $index          = "active";
                                    $text_index     = "text-danger";
                                } elseif ($menu == 'form_pend') {
                                    $anggota        = "active open";
                                    $text_anggota   = "text-danger";
                                    $form_pend      = "active";
                                } elseif ($menu == 'data_anggota') {
                                    $anggota        = "active open";
                                    $text_anggota   = "text-danger";
                                    $data_anggota   = "active";
                                } elseif ($menu == 'tabungan') {
                                    $anggota        = "active open";
                                    $text_anggota   = "text-danger";
                                    $tabungan       = "active";
                                } elseif ($menu == 'wajib') {
                                    $simpanan       = "active open";
                                    $text_simpanan  = "text-danger";
                                    $wajib = "active";
                                } elseif ($menu == 'sukarela') {
                                    $simpanan       = "active open";
                                    $text_simpanan  = "text-danger";
                                    $sukarela       = "active";
                                } elseif ($menu == 'dana_sosial') {
                                    $simpanan       = "active open";
                                    $text_simpanan  = "text-danger";
                                    $dana_sosial    = "active";
                                } elseif ($menu == 'pengajuanS') {
                                    $simpanan       = "active open";
                                    $text_simpanan  = "text-danger";
                                    $pengajuanS     = "active";
                                } elseif ($menu == 'penarikan') {
                                    $penarikan      = "active open";
                                    $text_penarikan = "text-danger";
                                    $penarikann     = "active";
                                } elseif ($menu == 'pengajuanP') {
                                    $penarikan      = "active open";
                                    $text_penarikan = "text-danger";
                                    $pengajuanP     = "active";
                                } elseif ($menu == 'pinjaman') {
                                    $pinjaman       = "active open";
                                    $text_pinjaman  = "text-danger";
                                    $pinjamann      = "active";
                                } elseif ($menu == 'pengajuanPI') {
                                    $pinjaman       = "active open";
                                    $text_pinjaman  = "text-danger";
                                    $pengajuanPI    = "active";
                                } elseif ($menu == 'angsuran') {
                                    $angsuran       = "active";
                                    $text_angsuran  = "text-danger";
                                } elseif ($menu == 'help') {
                                    $help           = "active";
                                    $text_help      = "text-danger";
                                } elseif ($menu == 'laporan') {
                                    $laporan        = "active";
                                    $text_laporan   = "text-danger";
                                }
                                ?>
                                <div class="nav-lavel" style="">Home</div>
                                <div class="nav-item <?= $index; ?>">
                                    <a href="index.php" class="<?= $text_index; ?>"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <!-- Anggota -->
                                <div class="nav-lavel">Anggota</div>
                                <div class="nav-item has-sub <?= $anggota; ?>">
                                    <a href="javascript:void(0)" class="<?= $text_anggota; ?>"><i class="fas fa-id-card"></i><span>Anggota</span></a>
                                    <div class="submenu-content">
                                        <a href="syarat_anggota.php" class="menu-item <?= $form_pend; ?>">Syarat Pendaftaran</a>
                                        <a href="anggota.php" class="menu-item <?= $data_anggota; ?>">Anggota</a>
                                        <a href="tabungan.php" class="menu-item <?= $tabungan; ?>">Tabungan</a>
                                    </div>
                                </div>
                                <div class="nav-item has-sub <?= $simpanan; ?>">
                                    <a href="javascript:void(0)" class="<?= $text_simpanan; ?>"><i class="fas fa-wallet"></i><span>Simpanan</span></a>
                                    <div class="submenu-content">
                                        <a href="simpanan_wajib.php" class="menu-item <?= $wajib; ?>">Wajib</a>
                                        <a href="simpanan_sukarela.php" class="menu-item <?= $sukarela; ?>">Sukarela</a>
                                        <a href="simpanan_dana_sosial.php" class="menu-item <?= $dana_sosial; ?>">Dana Sosial</a>
                                        <a href="pengajuan_simpanan.php" class="menu-item <?= $pengajuanS; ?>">Pengajuan Simpanan</a>
                                    </div>
                                </div>
                                <div class="nav-item has-sub <?= $penarikan; ?>">
                                    <a href="javascript:void(0)" class="<?= $text_penarikan; ?>"><i class="fas fa-money-check"></i><span>Penarikan</span></a>
                                    <div class="submenu-content">
                                        <a href="penarikan.php" class="menu-item <?= $penarikann; ?>">Penarikan</a>
                                        <a href="pengajuan_penarikan.php" class="menu-item <?= $pengajuanP; ?>">Pengajuan Penarikan</a>
                                    </div>
                                </div>
                                <!-- Peminjaman -->
                                <div class="nav-lavel">Peminjaman</div>
                                <div class="nav-item has-sub <?= $pinjaman; ?>">
                                    <a href="javascript:void(0)" class="<?= $text_pinjaman; ?>"><i class="fas fa-credit-card"></i><span>Pinjaman</span></a>
                                    <div class="submenu-content">
                                        <a href="pinjaman.php" class="menu-item <?= $pinjamann; ?>"><span>Pinjaman</span></a>
                                        <a href="pengajuan_pinjaman.php" class="menu-item <?= $pengajuanPI; ?>">Pengajuan Pinjaman</a>
                                    </div>
                                </div>
                                <div class="nav-item <?= $help; ?>">
                                    <a href="help_jasa.php" class="menu-item <?= $text_help; ?>"><i class="fas fa-question-circle <?= $text_help; ?>"></i>Help</a>
                                </div>
                                <div class="nav-item <?= $laporan; ?>">
                                    <a href="laporan.php" class="menu-item <?= $text_laporan; ?>"><i class="fas fa-book <?= $text_laporan; ?>"></i>Laporan</a>
                                </div>
                            </nav>
                        <?php } elseif ($_SESSION['Level'] == 'Anggota') {  ?>
                            <?php
                            $sqlAnggota = mysqli_query($konek, "SELECT * FROM anggota WHERE ID_User = '$_SESSION[ID_User]'");
                            $da         = mysqli_fetch_array($sqlAnggota);
                            ?>
                            <nav id="main-menu-navigation" class="navigation-main">
                                <?php
                                if ($menu == 'index') {
                                    $index              = "active";
                                    $text_index         = "text-danger";
                                } elseif ($menu == 'history_anggota') {
                                    $history_anggota    = "active";
                                    $text_history_anggota = "text-danger";
                                } elseif ($menu == 'wajib') {
                                    $simpanan           = "active open";
                                    $text_simpanan      = "text-danger";
                                    $wajib              = "active";
                                } elseif ($menu == 'sukarela') {
                                    $simpanan           = "active open";
                                    $text_simpanan      = "text-danger";
                                    $sukarela           = "active";
                                } elseif ($menu == 'dana_sosial') {
                                    $simpanan           = "active open";
                                    $text_simpanan      = "text-danger";
                                    $dana_sosial        = "active";
                                } elseif ($menu == 'tambah_simpanan') {
                                    $simpanan           = "active open";
                                    $text_simpanan      = "text-danger";
                                    $tambah_simpanan    = "active";
                                } elseif ($menu == 'penarikan') {
                                    $penarikan          = "active";
                                    $text_penarikan     = "text-danger";
                                } elseif ($menu == 'pinjaman') {
                                    $pinjaman           = "active";
                                    $text_pinjaman      = "text-danger";
                                } elseif ($menu == 'help') {
                                    $help               = "active";
                                    $text_help          = "text-danger";
                                } elseif ($menu == 'angsuran') {
                                    $angsuran           = "active";
                                    $text_angsuran      = "text-danger";
                                }
                                ?>
                                <div class="nav-lavel">Menu</div>
                                <div class="nav-item <?= $index; ?>">
                                    <a href="index_anggota.php" class="<?= $text_index; ?>"><i class="ik ik-bar-chart-2 <?= $text_index; ?>"></i><span>Dashboard</span></a>
                                </div>

                                <div class="nav-item <?= $history_anggota; ?>">
                                    <a href="history_anggota.php?ID_Tabungan=<?= $da['ID_Tabungan']; ?>&ID_Anggota=<?= $da['ID_Anggota']; ?>" class="menu-item <?= $text_history_anggota; ?>"><i class="fas fa-id-card <?= $text_history_anggota; ?>"></i>History Saya</a>
                                </div>

                                <div class="nav-item has-sub <?= $simpanan; ?>">
                                    <a href="javascript:void(0)" class="<?= $text_simpanan; ?>"><i class="fas fa-wallet <?= $text_simpanan; ?>"></i><span>Simpanan</span></a>
                                    <div class="submenu-content">
                                        <a href="t_simpanan.php" class="menu-item <?= $tambah_simpanan; ?>">Tambah Simpanan</a>
                                        <a href="simpanan_wajib.php" class="menu-item <?= $wajib; ?>">Wajib</a>
                                        <a href="simpanan_sukarela.php" class="menu-item <?= $sukarela; ?>">Sukarela</a>
                                        <a href="simpanan_dana_sosial.php" class="menu-item <?= $dana_sosial; ?>">Dana Sosial</a>
                                    </div>
                                </div>
                                <div class="nav-item <?= $penarikan; ?>">
                                    <a href="penarikan.php" class="menu-item <?= $text_penarikan; ?>"><i class="fas fa-money-check <?= $text_penarikan; ?>"></i>Penarikan</a>
                                </div>

                                <div class="nav-item <?= $pinjaman; ?>">
                                    <a href="pinjaman.php" class="menu-item <?= $text_pinjaman; ?>"><i class="fas fa-credit-card <?= $text_pinjaman; ?>"></i>Pinjaman</a>
                                </div>

                                <div class="nav-item <?= $help; ?>">
                                    <a href="help_jasa.php" class="menu-item <?= $text_help; ?>"><i class="fas fa-question-circle <?= $text_help; ?>"></i>Help</a>
                                </div>
                            </nav>

                        <?php } else { ?>
                            <nav id="main-menu-navigation" class="navigation-main">
                                <?php
                                if ($menu == 'index') {
                                    $index          = "active";
                                    $text_index     = "text-danger";
                                } elseif ($menu == 'laporan') {
                                    $laporan        = "active";
                                    $text_laporan   = "text-danger";
                                }
                                ?>
                                <div class="nav-lavel" style="">Home</div>
                                <div class="nav-item <?= $index; ?>">
                                    <a href="index.php" class="<?= $text_index; ?>"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <div class="nav-item <?= $laporan; ?>">
                                    <a href="laporan.php" class="menu-item <?= $text_laporan; ?>"><i class="fas fa-book <?= $text_laporan; ?>"></i>Laporan</a>
                                </div>
                            </nav>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- END Sidebar -->