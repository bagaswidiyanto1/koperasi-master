<?php $menu = 'laporan'; ?>
<?php include 'header.php'; ?>


<div class="main-content">
    <div class="container-fluid">
        <table class="table table-bordered">
            <tr class="text-white text-center" style="background-color: #404E67;">
                <th>Nama Laporan</th>
                <th width="200">Cetak</th>
            </tr>
            <!-- ANGGOTA -->
            <tr class="text-white" style="background-color:#8c8d8e;">
                <th>Anggota</th>
                <th></th>
            </tr>
            <tr>
                <td><b>Laporan Anggota</b></td>
                <td>
                    <a href="cetak/cetak_anggota.php" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> CETAK</button></a>
                </td>
            </tr>
            <!-- END ANGGOTA -->

            <!-- SIMPANAN WAJIB -->
            <tr class="text-white" style="background-color:#8c8d8e;">
                <th>Simpanan Wajib</th>
                <th></th>
            </tr>
            <tr>
                <td>
                    <b>Laporan Simpanan Wajib</b>
                </td>
                <td>
                    <a href="cetak/cetak_sw.php" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> CETAK</button></a>
                </td>
            </tr>
            <form class="col-md-2" action="cetak/cetak_sw_pertanggal.php" method="GET" target="_blank">
                <td>
                    <b>Laporan Simpanan Wajib Per Periode</b>
                </td>
                <td>
                    Mulai Tanggal <input class="form-control" type="date" name="tgl1" value="<?= date('Y-m-d') ?>">
                    Sampai Tanggal <input class="form-control" type="date" name="tgl2" value="<?= date('Y-m-d') ?>">
                    <button class="btn btn-primary btn-lg" type="submit" name="tampil" style="margin-top: 10px"><i class="fa fa-eye" aria-hidden="true"></i>Tampilkan</button>
                </td>
            </form>
            <!-- END SIMPANAN WAJIB -->

            <!-- SIMPANAN SUKARELA -->
            <tr class="text-white" style="background-color:#8c8d8e;">
                <th>Simpanan Sukarela</th>
                <th></th>
            </tr>
            <tr>
                <td>
                    <b>Laporan Simpanan Sukarela</b>
                </td>
                <td>
                    <a href="cetak/cetak_ss.php" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> CETAK</button></a>
                </td>
            </tr>
            <form class="col-md-2" action="cetak/cetak_ss_pertanggal.php" method="GET" target="_blank">
                <td>
                    <b>Laporan Simpanan Sukarela Per Periode</b>
                </td>
                <td>
                    Mulai Tanggal <input class="form-control" type="date" name="tgl1" value="<?= date('Y-m-d') ?>">
                    Sampai Tanggal <input class="form-control" type="date" name="tgl2" value="<?= date('Y-m-d') ?>">
                    <button class="btn btn-primary btn-lg" type="submit" name="tampil" style="margin-top: 10px"><i class="fa fa-eye" aria-hidden="true"></i>Tampilkan</button>
                </td>
            </form>
            <!-- END SIMPANAN SUKARELA -->

            <!-- SIMPANAN DANA SOSIAL -->
            <tr class="text-white" style="background-color:#8c8d8e;">
                <th>Simpanan Dana Sosial</th>
                <th></th>
            </tr>
            <tr>
                <td>
                    <b>Laporan Simpanan Dana Sosial</b>
                </td>
                <td>
                    <a href="cetak/cetak_ds.php" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> CETAK</button></a>
                </td>
            </tr>
            <form class="col-md-2" action="cetak/cetak_ds_pertanggal.php" method="GET" target="_blank">
                <td>
                    <b>Laporan Simpanan Dana Sosial Per Periode</b>
                </td>
                <td>
                    Mulai Tanggal <input class="form-control" type="date" name="tgl1" value="<?= date('Y-m-d') ?>">
                    Sampai Tanggal <input class="form-control" type="date" name="tgl2" value="<?= date('Y-m-d') ?>">
                    <button class="btn btn-primary btn-lg" type="submit" name="tampil" style="margin-top: 10px"><i class="fa fa-eye" aria-hidden="true"></i>Tampilkan</button>
                </td>
            </form>
            <!-- END SIMPANAN DANA SOSIAL -->

            <!-- PENARIKAN -->
            <tr class="text-white" style="background-color:#8c8d8e;">
                <th>Penarikan</th>
                <th></th>
            </tr>
            <tr>
                <td>
                    <b>Laporan Penarikan</b>
                </td>
                <td>
                    <a href="cetak/cetak_penarikan.php" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> CETAK</button></a>
                </td>
            </tr>
            <!-- <form class="col-md-2" action="cetak/cetak_penarikan_pertanggal.php" method="GET" target="_blank">
                <td>
                    <b>Laporan Penarikan Per Periode</b>
                </td>
                <td>
                    Mulai Tanggal <input class="form-control" type="date" name="tgl1" value="<?= date('Y-m-d') ?>">
                    Sampai Tanggal <input class="form-control" type="date" name="tgl2" value="<?= date('Y-m-d') ?>">
                    <button class="btn btn-primary btn-lg" type="submit" name="tampil" style="margin-top: 10px"><i class="fa fa-eye" aria-hidden="true"></i>Tampilkan</button>
                </td>
            </form> -->
            <!-- END PENARIKAN -->

            <!-- PINJAMAN -->
            <tr class="text-white" style="background-color:#8c8d8e;">
                <th>Pinjaman</th>
                <th></th>
            </tr>
            <tr>
                <td>
                    <b>Laporan Pinjaman</b>
                </td>
                <td>
                    <a href="cetak/cetak_pinjaman.php" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> CETAK</button></a>
                </td>
            </tr>
            <form class="col-md-2" action="" method="GET" target="_blank">
                <td>
                    <b>Laporan Pinjaman Per Periode</b>
                </td>
                <td>
                    Mulai Tanggal <input class="form-control" type="date" name="tgl1" value="<?= date('Y-m-d') ?>">
                    Sampai Tanggal <input class="form-control" type="date" name="tgl2" value="<?= date('Y-m-d') ?>">
                    <button class="btn btn-primary btn-lg" type="submit" name="tampil" style="margin-top: 10px"><i class="fa fa-eye" aria-hidden="true"></i>Tampilkan</button>
                </td>
            </form>
            <!-- END PINJAMAN -->
        </table>
    </div>
</div>



<?php include 'footer.php'; ?>