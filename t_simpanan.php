<?php $menu = 'tambah_simpanan'; ?>
<?php include 'header.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="container text-center" style="margin-top: 250px;">
            <a href="tambah_simpanan.php" style="color: white;">
                <button style="background-color: blue;">
                    <h1>Tambah Simpanan</h1>
                </button>
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<!-- memunculkan gambar -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#Jenis_Simpanan').change(function() {
            jenis_simpanan = $(this).val();
            console.log(jenis_simpanan);
            if (jenis_simpanan == 'Simpanan Wajib') {
                $('#Saldo_Simpanan').val(20000).attr("readonly", true)
            } else if (jenis_simpanan == 'Simpanan Dana Sosial') {
                $('#Saldo_Simpanan').val(5000).attr("readonly", true)
            } else {
                $('#Saldo_Simpanan').val('').attr("readonly", false)
            }
        })

        // $('#Jenis_Simpanan').change(function() {
        //     jenis_simpanan = $(this).val();
        //     console.log(jenis_simpanan);
        //     if (jenis_simpanan == 'Simpanan Dana Sosial') {
        //         $('#Saldo_Simpanan').val(5000).attr("readonly", true)
        //     } else {
        //         $('#Saldo_Simpanan').val('').attr("readonly", false)
        //     }
        // })



        function bacaGambar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#v_gambar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#gambar").change(function() {
            bacaGambar(this);
        });
    })
</script>