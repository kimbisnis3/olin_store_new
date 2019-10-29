<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<style media="screen">
  .img-produk {
      height: 200px;
      width: 100%;
  }
  .link-href {
      color: black !important;
      text-decoration: none !important;
  }
  .link-href:hover {
       color: black !important;
       text-decoration:none !important;
       cursor:pointer !important;
  }
  .btn-link {
      background-color: #17a2b8 !important;
      border: 0 !important;
      color: #ffffff;
  }
  .btn-link:hover {
      text-decoration: none !important;
      border-radius : 0 !important;
      color: #ffffff !important;
      border: 0 !important;
      background-color: #0056b3 !important;
  }
</style>
  <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
      <?php $this->load->view('_partials/topbar') ?>
        <section class="mb-5">
          <div class="container">
              <div class="row list-produk">
                  <?php foreach ($pr as $i => $v) { ?>
                  <div class="col-md-3 p-3">
                      <div class="card item-flat border-0">
                          <div class="card-header text-center border-0">
                            <a href="<?php echo base_url(); ?>product/detail?q=<?php echo $v['kodebarang'] ?>" class="link-href">
                              <?php echo $v['namabarang'] ?>
                            </a>
                          </div>
                          <div class="card-body text-center p-1">
                              <img src="<?php echo prep_url(api_url()).$v['gambardesign'] ?>" alt="" class="img-fluid img-produk">
                          </div>
                          <div class="card-footer text-center p-2 border-0">
                              <h5>Rp. <?php echo number_format($v['harga']) ?></h5>
                          </div>
                          <div class="card-footer p-0">
                              <a type="button" href="<?php echo base_url(); ?>design/start?product_id=<?php echo $v['id_prod_lumise'] ?>" class="btn btn-info btn-block item-flat btn-link"><i></i> Design</a>
                          </div>
                      </div>
                  </div>
                  <?php } ?>
              </div>
          </div>
        </section>
      <?php $this->load->view('_partials/foot') ?>
  </body>
</html>
