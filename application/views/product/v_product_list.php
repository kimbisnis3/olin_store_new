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

  .link-href:hover
  {
       color: black !important;
       text-decoration:none !important;
       cursor:pointer !important;
  }
</style>
  <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
      <?php $this->load->view('_partials/topbar') ?>
        <section>
          <div class="container">
              <div class="row list-produk">
                  <?php foreach ($product as $i => $v) { ?>
                  <div class="col-md-3 p-3">
                      <div class="card item-flat border-0">
                          <div class="card-header text-center border-0">
                            <a href="<?php echo base_url(); ?>product/detail?q=<?php echo $v['kodebarang'] ?>" class="link-href">
                              <strong><?php echo $v['namabarang'] ?></strong>
                            </a>
                          </div>
                          <div class="card-body text-center p-1">
                              <img src="<?php echo prep_url(api_url()).$v['gambardesign'] ?>" alt="" class="img-fluid img-produk">
                          </div>
                          <!-- <div class="card-footer text-center p-1 border-0">
                              <h5>Rp. <?php echo number_format($v['harga']) ?></h5>
                          </div> -->
                          <!-- <div class="card-footer p-0">
                              <button type="button" class="btn btn-info btn-block item-flat" onclick="add_cart('<?php echo $v['kodebarang'] ?>')"><i></i> Add to Cart</button>
                          </div> -->
                      </div>
                  </div>
                  <?php } ?>
              </div>
          </div>
        </section>
      <?php $this->load->view('_partials/foot') ?>
  </body>
  <script>
      function add_cart(kode) {
          $.ajax({
            url: `<?php echo base_url() ?>cart/add`,
            type: "POST",
            dataType: "JSON",
            data: {
                kode: kode,
            },
            success: function(data) {
              if (data.sukses == 'success') {
                total_items(data.total_items)
                toastr.success('Produk Ditambahkan Ke Keranjang')
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                  console.log('gagal')
            }
        });
      }
  </script>
</html>
