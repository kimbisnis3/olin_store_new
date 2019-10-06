<!DOCTYPE html>
<html lang="zxx">

<?php $this->load->view('_partials/head') ?>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->load->view('_partials/topbar') ?>
      <section class="img-diff-section">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4" style="border : 1px solid #d4cfcf">
                <div class="large-2 columns">
                  <div class="twentytwenty-container">
                    <img src="<?php echo base_url() ?>assets/images/before.png" class="img-diff"/>
                    <img src="<?php echo base_url() ?>assets/images/after.png" class="img-diff"/>
                  </div>
                </div>
              </div>
              <div class="col-md-8" style="border : 1px solid #d4cfcf">
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
				<div class="container-fluid">
							<section class="regular slider row">
								<div>
									<img src="http://placehold.it/470x100?text=1"  class="img-slide-small">
								</div>
								<div>
									<img src="http://placehold.it/470x100?text=1"  class="img-slide-small">
								</div>
								<div>
									<img src="http://placehold.it/470x100?text=1"  class="img-slide-small">
								</div>
								<div>
									<img src="http://placehold.it/470x100?text=1"  class="img-slide-small">
								</div>
								<div>
									<img src="http://placehold.it/470x100?text=1"  class="img-slide-small">
								</div>
							</section>
				</div>
				<section class="offer-wthree py-lg-5 py-3" id="offer">
					<div class="container-fluid  py-sm-5">
						<div class="row head-row-home text-center">
							<div class="col-lg-12 mx-auto">
								<div class="row">
									<div class="col-md-4 mx-auto">
										<div class="home-grid">
											<span class="fa fa-info-circle" aria-hidden="true"></span>
											<h4 class="home-title my-3">why choose us</h4>
										</div>
									</div>
									<div class="col-md-4 mx-auto">
										<div class="home-grid">
											<span class="fa fa-connectdevelop" aria-hidden="true"></span>
											<h4 class="home-title my-3">what we do</h4>
										</div>
									</div>
									<div class="col-md-4 mx-auto">
										<div class="home-grid">
											<span class="fa fa-users" aria-hidden="true"></span>
											<h4 class="home-title my-3">explore versatile</h4>
										</div>
									</div>
								</div>
                <div class="row" style="margin-top : 10px;">
									<div class="col-md-4 mx-auto">
										<div class="home-grid">
											<span class="fa fa-connectdevelop" aria-hidden="true"></span>
											<h4 class="home-title my-3">what we do</h4>
										</div>
									</div>
									<div class="col-md-4 mx-auto">
										<div class="home-grid">
											<span class="fa fa-users" aria-hidden="true"></span>
											<h4 class="home-title my-3">explore versatile</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
    <!-- // Register modal -->
    <!-- js -->
    <?php $this->load->view('_partials/foot') ?>
		<script type="text/javascript">
        $(function(){
          $(".regular").slick({
		        dots: false,
		        infinite: true,
		        slidesToShow: 3,
		        slidesToScroll: 3
		      });

          $(".twentytwenty-container").twentytwenty({
            no_overlay: true,
            default_offset_pct: 0.5,
          });
        });
		</script>
</body>

</html>
