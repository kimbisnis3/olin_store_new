<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<body>
<?php $this->load->view('_partials/topbar') ?>
  <section>
    <div class="container-fluid">
      <div class="row">
        <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_karir_1->image ?>" class="img-karir">
      </div>
      <div class="row">
        <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_karir_2->image ?>" class="img-karir">
      </div>
      <div class="row">
        <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_karir_3->image ?>" class="img-karir">
      </div>
    </div>
  </section>
  <section style="padding : 50px">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <h2><strong><?php echo $tx_karir->teks ?></strong></h2>
      </div>
      <div class="row justify-content-center" style="padding : 20px">
        <a href="<?php echo base_url(); ?>register/reseller" type="button" class="btn btn-lg btn-biru">Register Reseller</a>
      </div>
    </div>
  </section>
  <?php $this->load->view('_partials/foot') ?>
</body>

</html>
