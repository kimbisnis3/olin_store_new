<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<style media="screen">
  .tx-white {
    color: #fff;
  }
  .tx-black > a {
    color: black !important;
  }
</style>
<body>
<?php $this->load->view('_partials/topbar') ?>
  <section>
    <div class="container-fluid">
      <section class="regular slider row">
        <?php foreach ($ss_about as $i => $v): ?>
          <div>
            <img src="<?php echo prep_url(api_url()).$v->image ?>" class="img-slide-large">
          </div>
        <?php endforeach; ?>
      </section>
    </div>
  </section>
  <section class="about-us-text">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <h5><strong><?php echo $tx_about_head->teks ?></strong></h5>
      </div>
      <div class="row justify-content-center">
        <?php echo $tx_about_body->teks ?>
      </div>
    </div>
  </section>
  <section class="about-us-location-text" style="border : 1px solid #d4cfcf">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-12">
              <ul>
                <li>Contact</li>
                <li class="tx-white">spaner</li>
                <li class="tx-white">spaner</li>
                <li class="tx-black"><i class="fa fa-map-marker"></i> <a href="#"><?php echo $tx_link_alamat->teks ?></a></li>
                <li class="tx-white">spaner</li>
                <li class="tx-white">spaner</li>
                <li class="tx-black"><i class="fa fa-whatsapp"></i> <a href="#"><?php echo $tx_link_wa->teks ?></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mapouter">
            <div class="gmap_canvas">
              <iframe id="gmap_canvas" src="https://maps.google.com/maps?q=solo%20square&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" style="width : 890px !important; height : 500px !important"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php $this->load->view('_partials/foot') ?>
	<script type="text/javascript">
        $(function(){
          $(".regular").slick({
		        dots: true,
		        infinite: true,
		        slidesToShow: 1,
		        slidesToScroll: 1
		      });
        });
	</script>
</body>

</html>
