
<?php

require 'PHPMailer/PHPMailerAutoload.php';
require 'koneksi.php';
$email_pengirim = "alifwidiyanto2459@gmail.com";
$subjek = "Pendaftaran Anggota Koperasi";
// post anggota
//simpan data anggota

$idSimpanan         = $_POST['ID_Simpanan'];
$idTabungan         = $_POST['ID_Tabungan'];
$jenisSimpanan      = $_POST['Jenis_Simpanan'];
$tanggalTransaksi   = $_POST['Tanggal_Transaksi'];
$saldoSimpanan      = $_POST['Saldo_Simpanan'];

$sql = mysqli_query($konek, "SELECT * FROM `anggota` INNER JOIN user USING(ID_User) WHERE ID_Tabungan='$idSimpanan'");
$tb = mysqli_fetch_array($sql);
$namaAnggota        = $tb['Nama_Anggota'];

$emailTujuan        = $tb['Email'];

mysqli_query(
    $konek,
    "INSERT INTO `simpanan` (`ID_Simpanan`,`ID_Tabungan`, `Jenis_Simpanan`, `Tanggal_Transaksi`, `Saldo_Simpanan`, `Status_Simpanan`, `gambar`)
    VALUES ('$idSimpanan','$idTabungan', '$jenisSimpanan', '$tanggalTransaksi', '$saldoSimpanan', 'Menunggu', '$gambar')"
);

//simpan data anggota
mysqli_query($konek, "INSERT INTO `anggota` (`ID_Anggota`, `ID_Tabungan`, `ID_User`, `Nama_Anggota`, `Jenis_Kelamin`, `Tempat_Lahir`, `Tanggal_Lahir`,`Pendidikan_Terakhir`, `Status_Perkawinan`, `Simpanan_Pokok`, `No_KTP`, `No_KK`, `No_Telp`, `No_Rek`, `Tanggal_Entri`, `Alamat`, `Status_Aktif`)
 VALUES ('$tb[ID_Anggota]', '$tb[ID_Tabungan]', $tb[ID_User]', '$tb[Nama_Anggota]', '$tb[Jenis_Kelamin]', '$tb[Tempat_Lahir]', '$tb[Tanggal_Lahir]', '$tb[Pendidikan_Terakhir]', '$tb[Status_Perkawinan]', '$tb[Simpanan_Pokok]', '$tb[No_KTP]', '$tb[No_KK]', '$tb[No_Telp]', '$tb[No_Rek]', '$tb[Tanggal_Entri]', '$tb[Alamat]', '$tb[Status_Aktif]')");

//simpan data user
mysqli_query($konek, "INSERT INTO `user` (`ID_User`, `Username`, `Password`, `Nama_Lengkap`, `Email`, `Level`)
 VALUES ('$tb[ID_User]', '$tb[Username]', '$tb[Password]', '$tb[Nama_Lengkap]', '$tb[Email]', '$tb[Level]');");

$mail = new PHPMailer();

$mail->IsHTML(true);    // set email format to HTML
$mail->IsSMTP();   // we are going to use SMTP
$mail->SMTPAuth   = true; // enabled SMTP authentication
$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
$mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
$mail->Port       = 465;                   // SMTP port to connect to GMail
$mail->Username   = $email_pengirim;  // alamat email kamu
$mail->Password   = "lxgfarrlstifbcwc";            // password GMail
$mail->SetFrom($email_pengirim, 'Koperasi');  //Siapa yg mengirim email
$mail->Subject    = $subjek;
$mail->AddAddress($emailTujuan);
$mail->MsgHTML("
    `<html>
        <body>
            <p>Kepada yang terhormat $namaAnggota</p>
            <h2>Pendaftaran $namaAnggota sebagai Anggota telah Berhasil</h2>
            <table>
                <tr>
                    <td>ID Anggota</td>
                    <td>:</td>
                    <td>$idAnggota</td>
                </tr>
                <tr>
                    <td>ID Tabungan</td>
                    <td>:</td>
                    <td>$idTabungan</td>
                </tr>
                <tr>
                    <td>Nama Anggota</td>
                    <td>:</td>
                    <td>$namaAnggota</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>$jenisKelamin</td>
                </tr>
                <tr>
                    <td>Tanggal Masuk</td>
                    <td>:</td>
                    <td>$tanggalEntri</td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>$tempatLahir, $tanggalLahir</td>
                </tr>
                <tr>
                    <td>Pendidikan Terakhir</td>
                    <td>:</td>
                    <td>$pendidikanTerakhir</td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td>:</td>
                    <td>$statusPerkawinan</td>
                </tr>
                <tr>
                    <td>Simpanan Pokok</td>
                    <td>:</td>
                    <td>$simpananPokok</td>
                </tr>
                <tr>
                    <td>No KTP</td>
                    <td>:</td>
                    <td>$noKtp</td>
                </tr>
                <tr>
                    <td>No KK</td>
                    <td>:</td>
                    <td>$noKK</td>
                </tr>
                <tr>
                    <td>No Telepon</td>
                    <td>:</td>
                    <td>$noTelp</td>
                </tr>
                <tr>
                    <td>No Rekening</td>
                    <td>:</td>
                    <td>$noRek</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>$alamat</td>
                </tr>
            </table>
            <br>
            <br>
            <h2>Akses login $namaAnggota</h2>
            <table>
                <tr>
                    <td>ID User</td>
                    <td>:</td>
                    <td>$idUser</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td>$username</td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td>$password</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>$emailTujuan</td>
                </tr>
            </table>
        </body>
    </html>
    "); //pesan`

if (!$mail->Send()) {
    echo "<script>alert('GAGAL')</script>" . $mail->ErrorInfo;
    exit;
} else {
    echo "<script>alert('Kirim Pesan Sukses')</script>";
    echo "<meta http-equiv='refresh' content='0; url=simpanan_wajib.php'>";
}
