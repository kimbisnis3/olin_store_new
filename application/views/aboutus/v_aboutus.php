<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<style type="text/css">
    img {
        max-height: 40vh;
    }
</style>
<body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs-main">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url() ?>">Home</a></li>
                    <li class="active">About Us</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="konten" style="margin-top: 25px;">
        <div class="container">
            <div class="typo-top heading">
                <h2><?php echo $data->judul; ?></h2>
            </div>
            <div class="typo-bottom">
                <div class="headdings">
                    <img onerror='imgError(this)' class="img-responsive zoom-img" src="<?php echo prep_url(api_url()).$data->image ?>">
                </div>
                <div class="headdings">
                    <p><?php echo $data->ket; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/foot.php'); ?>
</body>
<script>
    
</script>
</html>