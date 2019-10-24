<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<style media="screen">
  .img-produk {
    width: 100% !important;
  }
</style>
<body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
    <section class="section-x pt-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <img onerror="imgError(this)" src="<?php echo prep_url(api_url()).$pr->gambardesign ?>" data-imagezoom="true" class="img-produk"/>
            </div>
            <div class="col-md-6 col-sm-6">
              <h3 class="my-2"><?php echo $pr->namabarang ?></h3>
              <hr>
              <p>Desc : <?php echo $pr->ketbarang ?></p>
              <hr>
              <p>Warna : <?php echo $pr->warna ?></p>
              <hr>
              <div class="bg-gray py-2 mt-4">
                <h2 class="mb-0">
                Rp. <?php echo number_format($pr->harga) ?>
                </h2>
              </div>
              <div class="mt-4">
                <button type="button" class="btn btn-primary btn-lg btn-flat" onclick="add_cart('<?php echo $pr->kodebarang ?>')">
                  <i class="fa fa-cart-plus fa-lg mr-2"></i>
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php $this->load->view('_partials/foot.php'); ?>
</body>
<script>
    $(window).load(function() {
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: false
      });
    });

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
