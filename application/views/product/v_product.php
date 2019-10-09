<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->load->view('_partials/topbar') ?>
      <section>
        <div class="container-fluid">
          <section class="regular slider row">
            <div>
              <img src="https://via.placeholder.com/1000x500" class="img-slide-produk">
            </div>
            <div>
              <img src="https://via.placeholder.com/1000x500" class="img-slide-produk">
            </div>
            <div>
              <img src="https://via.placeholder.com/1000x500" class="img-slide-produk">
            </div>
          </section>
        </div>
      </section>
      <section class="section-list-produk">
        <div class="container-fluid">
          <div class="list-product">
            <img src="https://via.placeholder.com/400x500" class="img-list-produk">
          </div>
          <div class="list-product">
            <img src="https://via.placeholder.com/400x500" class="img-list-produk">
          </div>
          <div class="list-product">
            <img src="https://via.placeholder.com/400x500" class="img-list-produk">
          </div>
        </div>
			</section>
    <?php $this->load->view('_partials/foot') ?>
</body>
<script>
    $(function(){
      $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
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
              showNotif('Sukses', 'Produk Ditambahkan Ke Keranjang', 'success')
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
          }
      });
    }
</script>
</html>
