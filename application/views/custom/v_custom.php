</html>
<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->load->view('_partials/topbar') ?>
      <section style="padding : 10px !important">
        <div class="container-fluid">
          <img src="https://via.placeholder.com/1400x500" data-magnify-src="https://via.placeholder.com/1400x500" class="img-slide-produk">
        </div>
      </section>
      <section class="offer-wthree py-lg-5 py-3" id="offer">
        <div class="container-fluid  py-sm-5">
          <div class="row head-row-home text-center justify-content-center">
            <div class="col-lg-9 mx-auto">
              <div class="row">
                <div class="col-md-4">
                  <div class="pagecutom-grid">
                    <img src="https://via.placeholder.com/200x200" style="width : 100%;">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="pagecutom-grid">
                    <img src="https://via.placeholder.com/200x200" style="width : 100%;">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="pagecutom-grid">
                    <img src="https://via.placeholder.com/200x200" style="width : 100%;">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php $this->load->view('_partials/foot') ?>
</body>
<script>
$(document).ready(function() {
  $('.img-slide-produk').magnify();
});
    // $(function(){
		// 	var f=$('#iframe')
		// 	f.load(function(){
    //             f.contents().find(`
    //                 name,
    //                 price ,
    //                 desc,
    //                 #lumise-change-product,
    //                 #lumise-top-tools,
    //                 .how-calculate,
    //                 .lumise-prints,
    //                 [data-tab="bug"],
    //                 [data-type="quantity"]
    //             `).remove()
		// 	})
		// })
</script>
</html>
