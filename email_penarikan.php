
<?php

require 'PHPMailer/PHPMailerAutoload.php';
require 'koneksi.php';
$email_pengirim = "alifwidiyanto2459@gmail.com";
$subjek = "Pendaftaran Anggota Koperasi";
// post anggota
//simpan data anggota
$idPenarikan        = $_POST['ID_Penarikan'];
$idTabungan         = $_POST['ID_Tabungan'];
$besarPenarikan     = $_POST['Besar_Penarikan'];
$tglEntri           = $_POST['Tgl_Entri'];

$sql = mysqli_query($konek, "SELECT * FROM penarikan INNER JOIN anggota USING(ID_Tabungan) INNER JOIN user USING(ID_User) WHERE Status_Penarikan='Konfirmasi'");
$dta = mysqli_fetch_array($sql);

$idTabungan         = $dta['ID_Tabungan'];
$namaAnggota        = $dta['Nama_Anggota'];
$emailTujuan        = $dta['Email'];

mysqli_query(
    $konek,
    "INSERT INTO `penarikan` (`ID_Penarikan`, `ID_Tabungan`, `Besar_Penarikan`, `Tgl_Entri`, `Status_Penarikan`)
VALUES ('$idPenarikan', '$idTabungan', '$besarPenarikan', '$tglEntri', 'Menunggu')"
);

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
            <h2>Penarikan</h2>
            
        </body>
    </html>
    "); //pesan`

if (!$mail->Send()) {
    echo "<script>alert('GAGAL')</script>" . $mail->ErrorInfo;
    exit;
} else {
    echo "<script>alert('Kirim Pesan Sukses')</script>";
    echo "<meta http-equiv='refresh' content='0; url=pengajuan_penarikan.php'>";
}
