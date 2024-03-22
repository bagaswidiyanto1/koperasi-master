
<?php
// get id anggota untuk proses hapus
include "koneksi.php";
if (isset($_GET['act'])) {

    if ($_GET['act'] == 'aktif') {
        $ID_Anggota = $_GET['ID_Anggota'];
        mysqli_query($konek, "UPDATE anggota SET Status_Aktif='Aktif' WHERE ID_Anggota='$ID_Anggota'");

        echo "<script>document.location.href = 'anggota.php';</script>";
    }

    if ($_GET['act'] == 'non_aktif') {

        require 'PHPMailer/PHPMailerAutoload.php';
        require 'koneksi.php';
        $email_pengirim = "alifwidiyanto2459@gmail.com";
        $subjek = "Pendaftaran Anggota Koperasi";
        // post anggota
        //simpan data anggota
        $ID_Anggota         = $_GET['ID_Anggota'];

        $sql = mysqli_query($konek, "SELECT * FROM anggota INNER JOIN user using(ID_User) WHERE ID_Anggota = '$ID_Anggota'");
        $dta = mysqli_fetch_array($sql);

        $idTabungan         = $dta['ID_Tabungan'];
        $namaAnggota        = $dta['Nama_Anggota'];

        $idUser             = $dta['ID_User'];
        $username           = $dta['Username'];
        $password           = $dta["Password"];
        $emailTujuan        = $dta['Email'];
        $level              = $dta['Level'];


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
            <html>
                <body>
                    <h4 >Kepada yang terhormat $namaAnggota</h4 >
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
                    <h2>Akun anda telah di <strong>Non Aktifkan</strong></h2>
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

        mysqli_query($konek, "UPDATE anggota SET Status_Aktif='Non Aktif' WHERE ID_Anggota='$ID_Anggota'");

        echo "<script>document.location.href = 'anggota.php';</script>";
    }
}
