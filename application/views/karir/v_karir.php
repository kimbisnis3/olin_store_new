<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<body>
<?php $this->load->view('_partials/topbar') ?>
  <section>
    <div class="container-fluid">
      <div class="row">
        <img src="http://placehold.it/1400x400?text=1" class="img-karir">
      </div>
      <div class="row">
        <img src="http://placehold.it/1400x400?text=2" class="img-karir">
      </div>
      <div class="row">
        <img src="http://placehold.it/1400x400?text=3" class="img-karir">
      </div>
    </div>
  </section>
  <section style="padding : 50px">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <h2><strong><?php echo $tx_karir->teks ?></strong></h2>
      </div>
      <div class="row justify-content-center" style="padding : 20px">
        <a href="<?php echo base_url(); ?>register" type="button" class="btn btn-lg btn-biru">Register Reseller</a>
      </div>
    </div>
  </section>
  <?php $this->load->view('_partials/foot') ?>
</body>

</html>
