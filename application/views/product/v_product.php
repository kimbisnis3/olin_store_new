<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<style></style>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->load->view('_partials/topbar') ?>
      <section style="padding : 10px !important">
        <div class="container-fluid">
          <div class="row py-0">
            <img src="<?php echo prep_url(api_url()).$banner->image ?>" class="img-fluid">
          </div>
        </div>
      </section>
      <section class="section-list-produk">
        <div class="container-fluid">
          <?php foreach ($ktg as $i => $v): ?>
            <div class="list-product">
              <a href="<?php echo base_url(); ?>product/pr_list?q=<?php echo $v->kode ?>">
                <img src="<?php echo prep_url(api_url()).$v->image ?>" class="img-list-produk">
              </a>
            </div>
          <?php endforeach; ?>
        </div>
			</section>
    <?php $this->load->view('_partials/foot') ?>
</body>
<script>
    $(function(){
      $(".regular").slick({
        dots: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
      });
    });
</script>
</html>
