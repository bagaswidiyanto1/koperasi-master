
<?php

require 'PHPMailer/PHPMailerAutoload.php';
require 'koneksi.php';
$email_pengirim = "alifwidiyanto2459@gmail.com";
$subjek = "Pendaftaran Anggota Koperasi";
// post anggota
//simpan data anggota
$idAnggota          = $_POST['ID_Anggota'];
$idTabungan         = $_POST['ID_Tabungan'];
$namaAnggota        = $_POST['Nama_Anggota'];
$jenisKelamin       = $_POST['Jenis_Kelamin'];
$tempatLahir        = $_POST['Tempat_Lahir'];
$tanggalLahir       = $_POST['Tanggal_Lahir'];
$pendidikanTerakhir = $_POST['Pendidikan_Terakhir'];
$statusPerkawinan   = $_POST['Status_Perkawinan'];
$simpananPokok      = $_POST['Simpanan_Pokok'];
$noKtp              = $_POST['No_KTP'];
$noKK               = $_POST['No_KK'];
$noTelp             = $_POST['No_Telp'];
$noRek              = $_POST['No_Rek'];
$tanggalEntri       = $_POST['Tanggal_Entri'];
$alamat             = $_POST['Alamat'];

$idUser             = $_POST['ID_User'];
$username           = $_POST['Username'];
$password           = $_POST["Password"];
$password2          = $_POST["Password2"];
$emailTujuan        = $_POST['Email'];
$level              = $_POST['Level'];

//simpan data anggota
mysqli_query($konek, "INSERT INTO `anggota` (`ID_Anggota`, `ID_Tabungan`, `ID_User`, `Nama_Anggota`, `Jenis_Kelamin`, `Tempat_Lahir`, `Tanggal_Lahir`,`Pendidikan_Terakhir`, `Status_Perkawinan`, `Simpanan_Pokok`, `No_KTP`, `No_KK`, `No_Telp`, `No_Rek`, `Tanggal_Entri`, `Alamat`, `Status_Aktif`)
 VALUES ('$idAnggota', '$idTabungan', '$idUser', '$namaAnggota', '$jenisKelamin', '$tempatLahir', '$tanggalLahir', '$pendidikanTerakhir', '$statusPerkawinan', '$simpananPokok', '$noKtp', '$noKK', '$noTelp', '$noRek', '$tanggalEntri', '$alamat', 'Aktif')");



//simpan data tabungan
mysqli_query($konek, "INSERT INTO `tabungan` (`ID_Tabungan`, `ID_Anggota`, `Tgl_Mulai`, `Besar_Tabungan`)
 VALUES ('$idTabungan', '$idAnggota', '$tanggalEntri', '$simpananPokok');");

//simpan data user
mysqli_query($konek, "INSERT INTO `user` (`ID_User`, `Username`, `Password`, `Nama_Lengkap`, `Email`, `Level`)
 VALUES ('$idUser', '$username', '$password', '$namaAnggota', '$emailTujuan', '$level');");

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
    echo "<meta http-equiv='refresh' content='0; url=anggota.php'>";
}
