<?php $menu = 'dana_sosial'; ?>
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

<div class="main-content">
    <div class="container-fluid">
        <?php if ($_SESSION['Level'] == 'Petugas') { ?>
            <ol class="breadcrumb mb-4" style="font-size: 16px">
                <li><i class="fa fa-home" aria-hidden="true"></i></li>
                <li class="breadcrumb-item" style="margin-left: 10px"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item no-drop active">Simpanan Dana Sosial</li>
                <li class="ml-auto active font-weight-bold">Simpanan Dana Sosial</li>
            </ol>
        <?php } else { ?>
            <ol class="breadcrumb" style="font-size: 16px">
                <li><i class="fa fa-home" aria-hidden="true"></i></li>
                <li class="ml-auto active font-weight-bold">Simpanan Dana Sosial</li>
            </ol>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="cetak/cetak_ds_per_id.php?ID_Anggota=<?= $_GET['ID_Anggota']; ?>" target="_blank" class="btn btn-success btn-sm" style="margin-bottom: 10px; height: auto" title="Laporan Simpanan Wajib"><i class="fa fa-print" aria-hidden="true"></i>Laporan</a>
                        <br>
                        <div class="dt-responsive p-4" style="overflow-x: auto;">
                            <table class=" table table-bordered display nowrap fixed" id="alt-pg-dt" style="font-size: 16px;">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>ID Simpanan</th>
                                        <th>ID Tabungan</th>
                                        <th>Nama_Anggota</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Saldo Simpanan</th>
                                        <th>Gambar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $query = "SELECT * FROM simpanan INNER JOIN anggota 
                                                on anggota.ID_Tabungan = simpanan.ID_Tabungan WHERE Jenis_Simpanan='Simpanan Dana Sosial' 
                                                AND Status_Simpanan='Konfirmasi' AND ID_Anggota = '$_GET[ID_Anggota]'";



                                    $sql = mysqli_query($konek, "$query");
                                    while ($ds = mysqli_fetch_array($sql)) {
                                        $color = "color:" . ($ds['Status_Simpanan'] == 'Konfirmasi' ? 'black' : 'red') . "";
                                        $sql_total  = mysqli_query($konek, "SELECT SUM(Saldo_Simpanan) as Total_Dana_Sosial FROM simpanan 
                                        INNER JOIN anggota on anggota.ID_Tabungan = simpanan.ID_Tabungan WHERE Jenis_Simpanan='Simpanan Dana Sosial' AND ID_Anggota = '$ds[ID_Anggota]' AND Status_Simpanan='Konfirmasi' ORDER BY ID_Simpanan ASC");
                                        $total_sw   = mysqli_fetch_array($sql_total);
                                        $sdsAnggota = $total_sw['Total_Dana_Sosial'];

                                    ?>
                                        <tr style="<?= $color; ?>">
                                            <td align="center"><?= $i++; ?></td>
                                            <td align="center"><?= $ds["ID_Simpanan"]; ?></td>
                                            <td align="center"><?= $ds["ID_Tabungan"]; ?></td>
                                            <td><?= $ds["Nama_Anggota"]; ?></td>
                                            <td align="right"><?= $ds["Tanggal_Transaksi"]; ?></td>
                                            <td align="right"><?= rupiah($ds['Saldo_Simpanan']); ?></td>
                                            <td align="center">

                                                <a href="#" type="button" class="btn-sm" data-toggle="modal" data-target="#myModal1<?= $ds['ID_Simpanan']; ?>"><button class="btn btn-icon btn-outline-success"><i class='fa fa-image'></i></button></a>

                                                <div class="modal fade" id="myModal1<?= $ds['ID_Simpanan']; ?>" role="dialog">
                                                    <div class="modal-dialog modal-lg">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Bukti Pembayaran </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                $id = $ds['ID_Simpanan'];
                                                                $gid = mysqli_query($konek, "SELECT * FROM simpanan WHERE ID_Simpanan='$id'");
                                                                $g = mysqli_fetch_array($gid);
                                                                ?>
                                                                <img id="myImg" src="img/<?= $g['gambar'] ?>" alt="picture" width="100%">,

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td align="center"><?= $ds["Status_Simpanan"]; ?></td>
                                            <td align="center"><a href="cetak/cetak_per_ds.php?ID_Simpanan=<?= $ds['ID_Simpanan'] ?>" title="Cetak" target="_blank"><button class="btn btn-icon btn-outline-primary"><i class='fas fa-print'></i></button></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class='border'>
                            <p class="p-2">Total Simpanan Dana Sosial : <?php if (isset($sdsAnggota)) {
                                                                            echo rp($sdsAnggota);
                                                                        } ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>