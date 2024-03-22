<?php $menu = 'penarikan'; ?>
<?php include 'header.php'; ?>
<?php
//membuat format rupiah dengan PHP
//tutorial www.malasngoding.com

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
?>

<script>
    function showSuccessToast() {
        'use strict';
        resetToastPosition();
        toastr.success({
            heading: 'Success',
            text: 'And these were just the basic demos! Scroll down to check further details on how to customize the output.',
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#f96868',
            position: 'top-right'
        })
    };
</script>
<div class="main-content">
    <div class="container-fluid">
        <?php if ($_SESSION['Level'] == 'Petugas') { ?>
            <ol class="breadcrumb mb-4" style="font-size: 16px">
                <li><i class="fa fa-home" aria-hidden="true"></i></li>
                <li class="breadcrumb-item" style="margin-left: 10px"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item no-drop active">Penarikan</li>
                <li class="ml-auto active font-weight-bold">Penarikan</li>
            </ol>
        <?php } else { ?>
            <ol class="breadcrumb" style="font-size: 16px">
                <li><i class="fa fa-home" aria-hidden="true"></i></li>
                <li class="ml-auto active font-weight-bold">Penarikan</li>
            </ol>
        <?php } ?>
        <div class="row">
            <?php if ($_SESSION['Level'] == 'Petugas') { ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="cetak/cetak_penarikan_per_id.php?ID_Anggota=<?= $_GET['ID_Anggota']; ?>" target="_blank" class="btn btn-success btn-sm" style="margin-bottom: 10px; height: auto" title="Laporan Simpanan Wajib"><i class="fa fa-print" aria-hidden="true"></i>Laporan</a>
                            <div class="dt-responsive p-4" style="overflow: scroll;">
                                <table class=" table table-bordered display nowrap" id="alt-pg-dt" style="font-size: 16px;">
                                    <col width="130px">
                                    <col width="130px">
                                    <col width="350px">
                                    <col width="130px">
                                    <col width="130px">

                                    <thead>
                                        <tr align="center">
                                            <th>ID Penarikan</th>
                                            <th>ID Tabungan</th>
                                            <th>Nama Anggota</th>
                                            <th>Total Penarikan</th>
                                            <th>Tanggal Penarikan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($konek, "SELECT * FROM penarikan INNER JOIN anggota USING(ID_Tabungan) WHERE Status_Penarikan='Konfirmasi' AND ID_Anggota = '$_GET[ID_Anggota]'");
                                        while ($p = mysqli_fetch_array($sql)) {
                                            $color = "color:" . ($p['Status_Penarikan'] == 'Konfirmasi' ? 'black' : 'red') . "";
                                        ?>
                                            <tr style="<?= $color; ?>">
                                                <td align="center"><?= $p["ID_Penarikan"]; ?></td>
                                                <td align="center"><?= $p["ID_Tabungan"]; ?></td>
                                                <td><?= $p["Nama_Anggota"]; ?></td>
                                                <td align="right"><?= rp($p['Besar_Penarikan']); ?></td>
                                                <td align="center"><?= $p["Tgl_Entri"]; ?></td>
                                                <td align="center"><?= $p["Status_Penarikan"]; ?></td>
                                                <td align="center"><a href="cetak/cetak_per_penarikan.php?ID_Penarikan=<?= $p['ID_Penarikan'] ?>" title="Cetak"><button class="btn btn-icon btn-outline-primary"><i class='fas fa-print'></i></button></a></td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-md-12">
                    <a href="tambah_penarikan.php" title="Tambah Pengajuan Penarikan">
                        <button class="mb-10 btn btn-sm ik ik-plus bg-primary text-white"></button></a>

                    <?php
                    $sql = mysqli_query($konek, "SELECT * FROM penarikan INNER JOIN anggota USING(ID_Tabungan) WHERE ID_Tabungan = '$da[ID_Tabungan]' ORDER BY ID_Penarikan DESC");
                    while ($p = mysqli_fetch_array($sql)) {
                        $color = ($p['Status_Penarikan'] == 'Konfirmasi' ? 'text-success' : 'text-danger');
                    ?>
                        <div class="widget border shadow-sm" style="margin-bottom:2px">
                            <div class="widget-header bg-purple text-white">
                                <h3 class="widget-title h5 font-weight-bold">- <?= $p['ID_Penarikan'] ?> -</h3>
                                <div class="widget-tools pull-right">
                                    <!-- Modal Info Penarikan -->
                                    <?php
                                    if ($p['Status_Penarikan'] == 'Konfirmasi') { ?>
                                        <a href="cetak/cetak_per_penarikan.php?ID_Penarikan=<?= $p['ID_Penarikan'] ?>" title="Cetak" target="_blank"><button class="btn btn-sm btn-widget-tool fas fa-print text-white"></button></a>
                                        <a href="#" title="Detail"><button class="btn btn-sm btn-widget-tool ik ik-info text-white" data-toggle="modal" data-target="#exampleModal<?= $p['ID_Penarikan'] ?>"></button></a>
                                        <button type="button" class="btn btn-sm btn-widget-tool minimize-widget text-white ik ik-minus" title="Minimize"></button>
                                    <?php } else { ?>
                                        <a href="#" title="Detail"><button class="btn btn-sm btn-widget-tool ik ik-info text-white" data-toggle="modal" data-target="#exampleModal<?= $p['ID_Penarikan'] ?>"></button></a>
                                        <button type="button" class="btn btn-sm btn-widget-tool minimize-widget text-white ik ik-minus" title="Minimize"></button>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="widget-body" style="padding: 0px 10px;">
                                <table class="table">
                                    <tr>
                                        <td><i class="fas fa-clipboard-list text-primary"></i></td>
                                        <td>Tanggal Penarikan</td>
                                        <td><?= $p['Tgl_Entri']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-clipboard-check text-success"></i></td>
                                        <td>Besar Penarikan</td>
                                        <td><?= rp($p['Besar_Penarikan']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="ik ik-info text-info"></i></td>
                                        <td>Status Penarikan</td>
                                        <td class="<?= $color; ?>"><?= $p['Status_Penarikan']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?= $p['ID_Penarikan'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">INFORMASI PENARIKAN</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                    $id = $p['ID_Penarikan'];
                                    $gid = mysqli_query($konek, "SELECT * FROM penarikan WHERE ID_Penarikan='$id'");
                                    $g = mysqli_fetch_array($gid);
                                    ?>
                                    <div class="modal-body">
                                        <div class="row invoice-info">
                                            <div class="col-sm-12 invoice-col">
                                                <address>
                                                    <strong>ID Penarikan</strong><br>
                                                    <p class="text-danger h5"><?= $p['ID_Penarikan']; ?></p>
                                                </address>
                                                <address>
                                                    <strong>ID Tabungan</strong><br>
                                                    <p class="text-danger h5"><?= $p['ID_Tabungan']; ?></p>
                                                </address>
                                                <address>
                                                    <strong>Besar Penarikan</strong><br>
                                                    <p class="text-danger h5"><?= rp($p['Besar_Penarikan']); ?></p>
                                                </address>
                                                <address>
                                                    <strong>Tanggal Entri</strong><br>
                                                    <p class="text-danger h5"><?= $p['Tgl_Entri']; ?></p>
                                                </address>
                                                <address>
                                                    <strong>Status Penarikan</strong><br>
                                                    <p class="text-danger h5"><?= $p['Status_Penarikan']; ?></p>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>