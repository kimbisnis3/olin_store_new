<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<body>
<?php $this->load->view('_partials/topbar') ?>
        <section>
          <div class="container-fluid">
            <section class="regular slider row">
              <div>
                <img src="http://placehold.it/1400x400?text=1"  class="img-slide-large">
              </div>
              <div>
                <img src="http://placehold.it/1400x400?text=2"  class="img-slide-large">
              </div>
              <div>
                <img src="http://placehold.it/1400x400?text=3"  class="img-slide-large">
              </div>
              <div>
                <img src="http://placehold.it/1400x400?text=4"  class="img-slide-large">
              </div>
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
                CONTACT
              </div>
              <div class="col-md-6">

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
