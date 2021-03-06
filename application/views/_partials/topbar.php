<?php
  //text
  $tx_header_top_1    = $this->db->get_where('tconfigtext', array('kode' => 'tx_header_top_1'))->row();
  $tx_header_top_2    = $this->db->get_where('tconfigtext', array('kode' => 'tx_header_top_2'))->row();
  $tx_header_top_3    = $this->db->get_where('tconfigtext', array('kode' => 'tx_header_top_3'))->row();
  $tx_header_top_4    = $this->db->get_where('tconfigtext', array('kode' => 'tx_header_top_4'))->row();
  $tx_header_bottom_1 = $this->db->get_where('tconfigtext', array('kode' => 'tx_header_bottom_1'))->row();
  $tx_header_bottom_2 = $this->db->get_where('tconfigtext', array('kode' => 'tx_header_bottom_2'))->row();
  $tx_header_bottom_3 = $this->db->get_where('tconfigtext', array('kode' => 'tx_header_bottom_3'))->row();

  //image
  $logoheader  = $this->db->get_where('tconfigimage', array('kode' => 'logoheader'))->row();
  $gb_header_1 = $this->db->get_where('tconfigimage', array('kode' => 'gb_header_1'))->row();
  $gb_header_2 = $this->db->get_where('tconfigimage', array('kode' => 'gb_header_2'))->row();
	$gb_header_3 = $this->db->get_where('tconfigimage', array('kode' => 'gb_header_3'))->row();

  function activelink($link)
  {
    if ($this->uri->segment('1') == $link) {
      echo "active";
    }
  }
 ?>
 <style media="screen">
 .main-header2 {
    display: none;
    position: fixed;
    top: 0;
    z-index: 99;
    width: 100%;
  }

 .header2 {
    display: none;
    position: fixed;
    top: 50px;
    z-index: 98;
    width: 100%;
  }

  @media only screen and (max-width: 600px) {
    .main-header1 {
      display: none;
    }

    .header1 {
      display: none;
    }

    .main-header2 {
       display: inline;
       position: fixed;
       top: 0;
       z-index: 99;
       width: 100%;
     }

    .header2 {
       display: inline;
       position: fixed;
       top: 50px;
       z-index: 98;
       width: 100%;
     }
  }
 </style>
 <div class="main-header">
 		<div class="header-top text-md-left text-center">
 				<div class="container-fluid">
 						<div class="d-md-flex justify-content-between">
 							<ul class="social-icons" style="padding-left: 80px !important">
 									<li>
 											<strong><p class="text-capitalize"><?php echo $tx_header_top_1->teks; ?> <span class="year-header">2007</span></p></strong>
 									</li>
 									<li>
 											<strong><p class="text-capitalize"><?php echo $tx_header_top_2->teks; ?> <img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_header_1->image ?>" class="img-header"> </p></strong>
 									</li>
 							</ul>
 							<ul class="social-icons">
 									<li style="display : none">
 											<strong><img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_header_2->image ?>" class="img-header"> <?php echo $tx_header_top_3->teks; ?></strong>
 									</li>
 									<li  style="display : none">
 											<strong><img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$gb_header_3->image ?>" class="img-header"> <?php echo $tx_header_top_4->teks; ?></strong>
 									</li>
                  <li>
 											<strong><a href="<?php echo base_url() ?>user"><?php echo $this->session->userdata('nama'); ?></a> <i class="fa fa-user pl-1"></i></strong>
 									</li>
 								</ul>
 						</div>
 				</div>
 		</div>
 		<div class="before-main-header main-header1">
 			<header class="main-header">
 					<nav class="navbar second navbar-expand-lg sticky-top navbar-light pagescrollfix">
 							<div class="container-fluid">
 									<h1>
 											<a class="navbar-brand" href="<?php echo base_url() ?>">
 													<img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$logoheader->image ?>" class="img-logo">
 											</a>
 									</h1>
 									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-toggle"
 											aria-controls="navbarNavAltMarkup1" aria-expanded="false" aria-label="Toggle navigation">
 											<span class="navbar-toggler-icon"></span>
 									</button>
 									<div class="collapse navbar-collapse navbar-toggle" id="navbarNavAltMarkup1">
 											<div class="navbar-nav secondfix ml-lg-auto">
 													<ul class="navbar-nav text-center">
 															<li class="nav-item menu-home mr-lg-3">
 																	<a class="nav-link" href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
 															</li>
 															<li class="nav-item menu-produk mr-lg-4">
 																	<a class="nav-link" href="<?php echo base_url() ?>product">Produk</a>
 															</li>
 															<li class="nav-item menu-custom mr-lg-4">
 																	<a class="nav-link" href="<?php echo base_url() ?>custom">Design Sendiri</a>
 															</li>
 															<li class="nav-item menu-karir mr-lg-4">
 																	<a class="nav-link" href="<?php echo base_url() ?>karir">Karir</a>
 															</li>
 															<li class="nav-item menu-aboutus">
 																	<a class="nav-link" href="<?php echo base_url() ?>aboutus">Tentang Kami</a>
 															</li>
                              <?php if ($this->session->userdata('in') == 1): ?>
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Shop
                                  </a>
                                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo base_url() ?>order">Order</a>
                                    <a class="dropdown-item" href="<?php echo base_url() ?>payment">Pembayaran</a>
                                  </div>
                                </li>
                              <?php endif; ?>
                              <li class="nav-item menu-cart">
 																	<a class="nav-link text-primary" href="<?php echo base_url() ?>cart"><i class="fa fa-shopping-cart"></i> (<span class="total_items"></span>) </a>
 															</li>
 													</ul>
 											</div>
 									</div>
 							</div>
 					</nav>
 			</header>
 		</div>

    <div class="before-main-header main-header2">
 			<header class="main-header">
 					<nav class="navbar second navbar-expand-lg sticky-top navbar-light pagescrollfix">
 							<div class="container-fluid">
 									<h1>
 											<a class="navbar-brand" href="<?php echo base_url() ?>">
 													<img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$logoheader->image ?>" class="img-logo">
 											</a>
 									</h1>
 									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-toggle"
 											aria-controls="navbarNavAltMarkup1" aria-expanded="false" aria-label="Toggle navigation">
 											<span class="navbar-toggler-icon"></span>
 									</button>
 									<div class="collapse navbar-collapse navbar-toggle" id="navbarNavAltMarkup1">
 											<div class="navbar-nav secondfix ml-lg-auto">
 													<ul class="navbar-nav text-center">
 															<li class="nav-item menu-home mr-lg-3">
 																	<a class="nav-link" href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
 															</li>
 															<li class="nav-item menu-produk mr-lg-4">
 																	<a class="nav-link" href="<?php echo base_url() ?>product">Produk</a>
 															</li>
 															<li class="nav-item menu-custom mr-lg-4">
 																	<a class="nav-link" href="<?php echo base_url() ?>custom">Design Sendiri</a>
 															</li>
 															<li class="nav-item menu-karir mr-lg-4">
 																	<a class="nav-link" href="<?php echo base_url() ?>karir">Karir</a>
 															</li>
 															<li class="nav-item menu-aboutus">
 																	<a class="nav-link" href="<?php echo base_url() ?>aboutus">Tentang Kami</a>
 															</li>
                              <?php if ($this->session->userdata('in') == 1): ?>
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Shop
                                  </a>
                                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo base_url() ?>order">Order</a>
                                    <a class="dropdown-item" href="<?php echo base_url() ?>payment">Pembayaran</a>
                                  </div>
                                </li>
                              <?php endif; ?>
                              <li class="nav-item menu-cart">
 																	<a class="nav-link text-primary" href="<?php echo base_url() ?>cart"><i class="fa fa-shopping-cart"></i> (<span class="total_items"></span>) </a>
 															</li>
 													</ul>
 											</div>
 									</div>
 							</div>
 					</nav>
 			</header>
 		</div>

 		<div class="middle-header header1">
 				<div class="container-fluid">
 						<div class="row">
 								<div class="col-md-4">
 										<span><img onerror='imgError(this)' src="<?php echo base_url() ?>assets/images/wa.png" class="img-wa"> </span> <strong><?php echo $tx_header_bottom_1->teks ?></strong>
 								</div>
 								<div class="col-md-7">
 										<i class="fa fa-envelope icon-header"></i> <span class="text-header-mid"><?php echo $tx_header_bottom_2->teks ?></span> <span class="vl"></span><i class="fa fa-map-marker icon-header"></i> <span class="text-header-mid"><?php echo $tx_header_bottom_3->teks ?> </span>
 								</div>
 								<div class="col-md-1">
 										<div class="float-right">
                      <?php if ($this->session->userdata('in') == 1) {
                        echo "<a href='".base_url()."login/logout'> <strong>Logout</strong></a>";
                      } else {
                        echo "<a href='".base_url()."login'> <strong>Login</strong></a>";
                      }
                      ?>

 										</div>
 								</div>
 						</div>
 				</div>
 		</div>
    <div class="middle-header header2">
 				<div class="container-fluid">
 						<div class="row">
 								<div class="col-md-12">
 										<div class="float-right">
                      <?php if ($this->session->userdata('in') == 1) {
                        echo "<a href='".base_url()."login/logout'> <strong>Logout</strong></a>";
                      } else {
                        echo "<a href='".base_url()."login'> <strong>Login</strong></a>";
                      }
                      ?>

 										</div>
 								</div>
 						</div>
 				</div>
 		</div>
 </div>
