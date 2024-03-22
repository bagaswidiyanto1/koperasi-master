<?php $menu = 'penarikan'; ?>
<?php include 'header.php';

function rp($angka)
{

    $hasil_rupiah = "Rp. " . number_format($angka, 0, '', '.');
    return $hasil_rupiah;
}
?>
<script language="javascript">
    $(document).ready(function() {
        $("#Tgl_Entri").datepicker({
            inline: true,
            dateFormat: "dd/mm/yy",
            changeFirstDay: false,
            minDate: +7
        });
    });
</script>

<div class="main-content">
    <div class="container-fluid">
        <?php if ($_SESSION['Level'] == 'Petugas') { ?>
            <ol class="breadcrumb mb-4" style="font-size: 16px">
                <li><i class="fa fa-home" aria-hidden="true"></i></li>
                <li class="breadcrumb-item" style="margin-left: 10px"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item no-drop active">Penarikan</li>
                <li class="breadcrumb-item no-drop active">Tambah Penarikan</li>
                <li class="ml-auto active font-weight-bold">Penarikan</li>
            </ol>
        <?php } else { ?>
            <ol class="breadcrumb" style="font-size: 16px">
                <li><i class="fa fa-home" aria-hidden="true"></i></li>
                <li class="ml-auto active font-weight-bold">Tambah Penarikan</li>
            </ol>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-form-tambah-penarikan">
                            <div class="card-body">
                                <?php if ($_SESSION['Level'] == 'Petugas') { ?>
                                    <div class="row clearfix">
                                        <a href="pengajuan_penarikan.php" data-toggle="tooltip" data-placement="top" title="Kembali"><button type=" button" class="btn btn-danger btn-sm"><i class="ik ik-arrow-left"></i>&nbsp; Kembali</button></a>
                                    </div>
                                <?php } else { ?>
                                    <div class="row clearfix">
                                        <a href="penarikan.php"> <button type="button" class="btn btn-danger btn-sm"><i class="ik ik-arrow-left"></i>&nbsp; Kembali</button></a>
                                    </div>
                                <?php } ?>
                                <br>
                                <form method="post" action="" class="was-validated" style="border: 4px">
                                    <div class="row">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="p-3 font-weight-bold bg-primary text-center">
                                                    <a class="h6 text-left text-white col-md-10">Pengajuan Penarikan</a>
                                                </div>
                                                <div class="card-body shadow p-3 rounded">
                                                    <?php
                                                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


                                                        $idPenarikan        = $_POST['ID_Penarikan'];
                                                        $idTabungan         = $_POST['ID_Tabungan'];
                                                        $besarPenarikan     = $_POST['Besar_Penarikan'];
                                                        $tglEntri           = $_POST['Tgl_Entri'];
                                                        $namaAnggota = 'Penarikan';

                                                        // history saldo
                                                        $sql_hs         = mysqli_query($konek, "SELECT * FROM tabungan WHERE ID_Tabungan='$idTabungan'");
                                                        $hs             = mysqli_fetch_array($sql_hs);
                                                        $id_hs          = $hs['Besar_Tabungan'];
                                                        $Saldo_Terakhir = $id_hs - $besarPenarikan;

                                                        //simpan data history
                                                        mysqli_query(
                                                            $konek,
                                                            "INSERT INTO `history` (`ID_History`, `ID_Tabungan`, `Jenis_History`, `Jumlah_History`, `Saldo_Terakhir`, `Waktu_History`)
                                                    VALUES (NULL, '$idTabungan', '$namaAnggota', '$besarPenarikan', '$Saldo_Terakhir', '$tglEntri');"
                                                        );

                                                        $qp = mysqli_query($konek, "SELECT * FROM penarikan WHERE ID_Tabungan='$idTabungan' AND Status_Penarikan='Menunggu'");
                                                        $dp = mysqli_fetch_array($qp);
                                                        if ($idTabungan == '' | $besarPenarikan == '' | $tglEntri == '' | $idPenarikan == '') {
                                                            echo "<div class='alert alert-warning fade show alert-dismissible mt-2'>
                                                                Data Belum lengkap !!!
                                                                </div>";
                                                        } else {
                                                            if (mysqli_num_rows($qp) > 0) {
                                                                echo "<div class='alert alert-primary fade show alert-dismissible mt-2'>
                                                                            Data penarikan lain blm di setujui ! 
                                                                        </div>";
                                                            } elseif ($hs['Besar_Tabungan'] < $besarPenarikan) {
                                                                echo "<div class='alert alert-info fade show alert-dismissible mt-2'>
                                                                        Tabungan Tidak Mencukupi !!!
                                                                    </div>";
                                                            } else {
                                                                // simpan data penarikan
                                                                $simpan = mysqli_query(
                                                                    $konek,
                                                                    "INSERT INTO `penarikan` (`ID_Penarikan`, `ID_Tabungan`, `Besar_Penarikan`, `Tgl_Entri`, `Status_Penarikan`)
                                                                VALUES ('$idPenarikan', '$idTabungan', '$besarPenarikan', '$tglEntri', 'Menunggu')"
                                                                );
                                                                if ($_SESSION['Level'] == 'Petugas') {
                                                                    echo "<script>document.location.href = 'pengajuan_penarikan.php';</script>";
                                                                } elseif ($_SESSION['Level'] == 'Anggota') {
                                                                    echo "<script>document.location.href = 'penarikan.php';</script>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                    //membuat ID Penarikan
                                                    $today           = "P19";
                                                    $query           = mysqli_query($konek, "SELECT max(ID_Penarikan) AS last FROM penarikan WHERE ID_Penarikan LIKE '$today%'");
                                                    $data            = mysqli_fetch_array($query);
                                                    $lastNoBayar     = $data['last'];
                                                    $lastNoUrut      = substr($lastNoBayar, 3, 4);
                                                    $nextNoUrut      = $lastNoUrut + 1;
                                                    $nextNoPenarikan = $today . sprintf('%04s', $nextNoUrut);
                                                    ?>
                                                    <br>
                                                    <!-- <div class="border p-2">
                                                        <?php
                                                        $sqltb = mysqli_query($konek, "SELECT * FROM tabungan WHERE ID_Tabungan = '$da[ID_Tabungan]'");
                                                        $dtb   = mysqli_fetch_array($sqltb);
                                                        echo "$dtb";
                                                        ?>
                                                        <span class="h5">Tabungan : <?= rp($dtb['Besar_Tabungan']); ?></span>
                                                        </div> -->
                                                    <div class="form-group row">
                                                        <label for="ID_Penarikan" class="col-sm-3 col-form-label text-left">ID Penarikan :</label>
                                                        <div class="col-sm-7">
                                                            <div class="md-form mt-0">
                                                                <input class="form-control" type="text" value="<?= $nextNoPenarikan; ?>" name="ID_Penarikan" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if ($_SESSION['Level'] == 'Petugas') { ?>
                                                        <div class="form-group row">
                                                            <label for="ID_Tabungan" class="col-sm-3 col-form-label text-left">Anggota :</label>
                                                            <div class="col-sm-7">
                                                                <div class="md-form mt-0">
                                                                    <select name="ID_Tabungan" class="form-control" id="tabungan_anggota">
                                                                        <option selected value="0" readonly>-- Pilih Tabungan --</option>
                                                                        <?php
                                                                        $sql_a = mysqli_query($konek, "SELECT * FROM tabungan INNER JOIN anggota on anggota.ID_Tabungan = tabungan.ID_Tabungan");
                                                                        while ($a = mysqli_fetch_array($sql_a)) {
                                                                        ?>
                                                                            <option value="<?= $a['ID_Tabungan'] ?>" <?php if (isset($idTabungan)) {
                                                                                                                            if ($a['ID_Tabungan'] == $idTabungan) {
                                                                                                                                echo "selected";
                                                                                                                            }
                                                                                                                        } ?>>
                                                                                <?= $a['Nama_Anggota'] . " - " . $a['ID_Tabungan'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="form-group row">
                                                            <label for="ID_Tabungan" class="col-sm-3 col-form-label text-left">Anggota :</label>
                                                            <div class="col-sm-7">
                                                                <div class="md-form mt-0">
                                                                    <input class="form-control" type="text" value="<?= $da['Nama_Anggota'] . " - " . $da['ID_Tabungan']; ?>" name="" readonly>
                                                                    <input class="form-control" type="hidden" value="<?= $da['ID_Tabungan']; ?>" name="ID_Tabungan" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <div class="form-group row">
                                                        <label for="Besar_Penarikan" class="col-sm-3 col-form-label text-left">Besar Penarikan :</label>
                                                        <div class="col-sm-7">

                                                            <div class="md-form mt-0">
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <input type="number" value="<?php if (isset($besarPenarikan)) {
                                                                                                        echo $besarPenarikan;
                                                                                                    } ?>" class="form-control text-left" id="Besar_Penarikan" placeholder="0.00" name="Besar_Penarikan" required>
                                                                        <div class="valid-feedback">Valid.</div>
                                                                        <?php
                                                                        if ($_SESSION['Level'] == 'Anggota') {
                                                                            $tb = mysqli_query($konek, "SELECT * FROM tabungan WHERE ID_Tabungan = '$da[ID_Tabungan]'");
                                                                            $dtb = mysqli_fetch_array($tb);
                                                                        ?>
                                                                            <input type="hidden" id="Total_Tabungan_Hidden" value="<?= $dtb['Besar_Tabungan']; ?> ">
                                                                            <div class="p-2 border shadow-sm mt-2">Total Tabungan : <input type="text" id="Hasil" value="<?= rp($dtb['Besar_Tabungan']); ?> " disabled></div>
                                                                        <?php } ?>
                                                                        <div class="invalid-feedback">Harap isi kolom ini.</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="Tgl_Entri" class="col-sm-3 col-form-label text-left">Tanggal Penarikan :</label>
                                                        <div class="col-sm-5">
                                                            <div class="md-form mt-0">
                                                                <input type="text" class="form-control text-left" id="Tgl_Entri" placeholder="Tanggal" name="Tgl_Entri" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label text-left"></label>
                                                        <div class="col-sm-7">
                                                            <div class="md-form mt-0">
                                                                <input type="submit" value="Simpan" name="simpan" id="btn" id data-toggle="tooltip" data-placement="top" title="Simpan" class="btn btn-success" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>

<script type="text/javascript">
    $("#Besar_Penarikan").keyup(function() {
        var BPenarikan = parseInt($("#Besar_Penarikan").val());
        var TTabunganHidden = parseInt($("#Total_Tabungan_Hidden").val());

        var Total = TTabunganHidden - BPenarikan;
        $("#Hasil").val(Total);
    });

    function myFunction(pj) {
        var nama_anggota = pj.target.value
        var ex = nama_anggota.split("-");
        document.getElementById("Besar_Tabungan").value = ex[0];
    }

    $(function() {

        $("#btn").on('click', function() {
            if ($("#Tgl_entri").val() == '') {
                alert("Please Select Date First!");
            }
        });
    });
</script>