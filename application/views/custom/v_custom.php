</html>
<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->load->view('_partials/topbar') ?>
      <section style="padding : 10px !important">
        <div class="container-fluid">
          <img src="<?php echo prep_url(api_url()).$banner->image ?>" data-magnify-src="<?php echo prep_url(api_url()).$banner->image ?>" class="img-slide-produk">
        </div>
      </section>
      <section class="offer-wthree py-lg-5 py-3" id="offer">
        <div class="container-fluid  py-sm-5">
          <div class="row head-row-home text-center justify-content-center">
            <div class="col-lg-9 mx-auto">
              <div class="row">
                <?php foreach ($pr as $i => $v): ?>
                  <div class="col-md-4">
                    <div class="card item-flat border-0">
                        <div class="card-body text-center p-1">
                            <img src="<?php echo prep_url(api_url()).$v['gambardesign'] ?>" alt="" class="img-fluid img-produk">
                        </div>
                        <div class="card-footer text-center p-2 border-0 bg-white">
                            <h5><?php echo $v['namabarang'] ?></h5>
                        </div>
                    </div>
                  </div>
                <?php endforeach; ?>
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
