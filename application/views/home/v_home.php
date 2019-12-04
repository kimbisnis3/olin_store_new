<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<style media="screen">
  .img-icon-mini {
    width: 72px !important;
    height: 70px !important;
  }
  .img-dfr {
    /* height: 100% !important;
   	width: 100%!important; */
  }
  .img-big-home {
  	height: 100% !important;
  	width: 100% !important;
  }

  .slide-mobile {
    padding-left: 10% !important;
    padding-right: 10% !important;
  }

  @media only screen and (max-width: 600px) {
    .img-dfr {
      /* height: 180px !important;
     	width: 100%!important; */
    }
    .img-big-home {
      width : 100% !important;
  	  height : 200px !important
    }
    .home-title {
      font-size: 0.75em !important;
    }
  }
</style>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->load->view('_partials/topbar') ?>
      <section class="img-diff-section">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">
                <div class="large-2 columns">
                  <div class="twentytwenty-container">
                    <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_before->image ?>" class="img-dfr"/>
                    <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_after->image ?>" class="img-dfr"/>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <a href="<?php echo base_url(); ?>custom">
                  <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_big->image ?>" class="img-big-home"/>
                </a>
              </div>
            </div>
          </div>
        </section>
        <section class="section-teks-desc">
          <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center text-star">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <div class="row h-100 justify-content-center align-items-center text-why">
                Kenapa Harus di Progresso Promosindo
            </div>
          </div>
        </section>
				<div class="container-fluid slide-pc">
					<section class="regular slider row">
            <?php foreach ($ss as $i => $v): ?>
              <div>
                <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$v->image ?>" class="img-slide-small">
  							<!-- <img onerror='imgError(this)' src="<?php echo base_url()?>assets/tas.png" class="img-slide-small"> -->
  						</div>
            <?php endforeach; ?>
					</section>
				</div>
        <div class="container-fluid slide-mobile">
					<section class="regular-mobile slider row">
            <?php foreach ($ss as $i => $v): ?>
              <div>
                <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$v->image ?>" class="img-slide-small">
  							<!-- <img onerror='imgError(this)' src="<?php echo base_url()?>assets/tas.png" class="img-slide-small"> -->
  						</div>
            <?php endforeach; ?>
					</section>
				</div>
				<section class="offer-wthree py-lg-5 py-3 mt-3 mb-3" id="offer">
					<div class="container-fluid  py-sm-5">
						<div class="row head-row-home text-center justify-content-center">
							<div class="col-lg-9 col-md-9 col-sm-6 col-xs-4 mx-auto">
								<div class="row">
									<div class="col-md-4 col-4">
										<div class="home-grid">
											<!-- <span class="<?php echo $icon1->image; ?>" aria-hidden="true"></span> -->
                      <img src="<?php echo prep_url(api_url()).$icon1->image ?>" class="img-icon-mini">
											<h4 class="home-title my-3"><?php echo $icon1->ket; ?></h4>
										</div>
									</div>
									<div class="col-md-4 col-4">
										<div class="home-grid">
											<!-- <span class="<?php echo $icon2->image; ?>" aria-hidden="true"></span> -->
                      <img src="<?php echo prep_url(api_url()).$icon2->image ?>" class="img-icon-mini">
											<h4 class="home-title my-3"><?php echo $icon2->ket; ?></h4>
										</div>
									</div>
									<div class="col-md-4 col-4">
										<div class="home-grid">
											<!-- <span class="<?php echo $icon3->image; ?>" aria-hidden="true"></span> -->
                      <img src="<?php echo prep_url(api_url()).$icon3->image ?>" class="img-icon-mini">
											<h4 class="home-title my-3"><?php echo $icon3->ket; ?></h4>
										</div>
									</div>
								</div>
                <div class="row justify-content-center" style="margin-top : 10px;">
									<div class="col-md-4 col-4">
										<div class="home-grid">
											<!-- <span class="<?php echo $icon4->image; ?>" aria-hidden="true"></span> -->
                      <img src="<?php echo prep_url(api_url()).$icon4->image ?>" class="img-icon-mini">
											<h4 class="home-title my-3"><?php echo $icon4->ket; ?></h4>
										</div>
									</div>
									<div class="col-md-4 col-4">
										<div class="home-grid">
											<!-- <span class="<?php echo $icon5->image; ?>" aria-hidden="true"></span> -->
                      <img src="<?php echo prep_url(api_url()).$icon5->image ?>" class="img-icon-mini">
											<h4 class="home-title my-3"><?php echo $icon5->ket; ?></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
    </body>
    <?php $this->load->view('_partials/foot') ?>
		<script type="text/javascript">
        $(function(){
          setTimeout(function()
          {
            $(".twentytwenty-container").twentytwenty({
              no_overlay: true,
              default_offset_pct: 0.5,
            });
          }, 500);


          $(".regular").slick({
		        dots: false,
		        infinite: true,
		        slidesToShow: 3,
		        slidesToScroll: 3
		      });

          $(".regular-mobile").slick({
		        dots: true,
		        infinite: true,
		        slidesToShow: 1,
		        slidesToScroll: 1
		      });


        });
		</script>

</html>
