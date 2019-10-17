<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<style type="text/css"></style>
<body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
    <div class="konten" style="margin-top: 25px;">
        <div class="container">
            <div class="typo-top heading">
                <h2>Kontak Kami</h2>
            </div>
            <div class="typo-bottom" style="margin-top: 10px !important; padding-top: 5px !important;">
                <div class="headdings">
                    <div class="contact-text">
                        <div class="col-md-12 contact-right">
                            <form id="form-data">
                                <input type="text" name="nama" placeholder="Name">
                                <input type="text" name="hp"  placeholder="Phone">
                                <input type="text" name="email"   placeholder="Email">
                                <textarea placeholder="Message" name="pesan"></textarea>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="submit-btn">
                                            <btn class="btn btn-hitam btn-block btn-submit" onclick="savedata()">Kirim</btn>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/foot.php'); ?>
</body>
<script>
    function savedata() {
        btnproc('.btn-submit', 1)
        $.ajax({
            url: `<?php echo base_url() ?>contactus/savedata`,
            type: "POST",
            dataType: "JSON",
            data: $('#form-data').serializeArray(),
            success: function(data) {
                if (data.sukses == 'success') {
                    total_items(data.total_items)
                    showNotif('Terkirim', 'Terimakasih telah mengirimkan pesan', 'success')
                    btnproc('.btn-submit', 0)
                    $("#form-data")[0].reset()
                    location.href= '<?php echo base_url() ?>'
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
                btnproc('.btn-submit', 0)
            }
        });
    }
</script>
</html>
