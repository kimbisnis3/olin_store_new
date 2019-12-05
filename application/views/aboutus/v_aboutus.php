<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<style media="screen">
  .tx-white {
    color: #fff;
  }
  .contact-big {
    display: none !important;
   }

  .tx-black > a {
    color: black !important;
  }

  .img-slide {
  	width : 100% !important;
  	height: 100% !important;
  }

  .contact-mobile {
    display: none !important;
   }

  .contact-big {
    display: inline !important;
  }

  .tx_about_body {
    text-align: center;
  }

  @media only screen and (max-width: 600px) {
    .a {
      padding-left: 7% !important;
      padding-right: 7% !important;
    }
    .contact-big {
      display: none !important;
     }
    .contact-mobile {
      display: inline !important;
    }
    .tx_about_head {
      font-size: 18px !important;
    }
    .tx_about_body {
      font-size: 12px !important;
    }
  }
</style>
<body>
<?php $this->load->view('_partials/topbar') ?>
  <section>
    <div class="container-fluid a">
      <section class="regular slider row">
        <?php foreach ($ss_about as $i => $v): ?>
          <div>
            <img src="<?php echo prep_url(api_url()).$v->image ?>" class="img-fluid">
          </div>
        <?php endforeach; ?>
      </section>
    </div>
  </section>
  <section class="about-us-text">
    <div class="container-fluid">
      <div class="text-center my-3">
        <h1 class="tx_about_head"><strong><?php echo $tx_about_head->teks ?></strong></h1>
      </div>
      <div class="row justify-content-center">
      </h4 class="tx_about_body"><strong><?php echo $tx_about_body->teks ?></strong></h4>
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
                <li class="tx-black contact-big"><i class="fa fa-map-marker"></i> <a href="#"><?php echo $tx_link_alamat->teks ?></a></li>
                <li class="tx-white">spaner</li>
                <li class="tx-black"><i class="fa fa-whatsapp"></i> <a href="#"><?php echo $tx_link_wa->teks ?></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-8 p-1">
          <div class="mapouter">
            <div class="gmap_canvas embed-responsive embed-responsive-16by9">
              <iframe id="gmap_canvas" class="embed-responsive-item" src="<?php echo $tx_link_map->teks; ?>" frameborder="0" scrolling="no"></iframe>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 p-1">
        </div>
        <div class="col-md-8 p-1">
          <div class="row">
            <div class="col-md-12">
              <ul>
                <li class="tx-black contact-mobile"><a href="#" style="font-size : 5px !important"><?php echo $tx_link_alamat->teks ?></a></li>
              </ul>
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
