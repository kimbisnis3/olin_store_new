<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/flexslider/flexslider.css" />
<style media="screen">
  .img-produk {
    width: 100% !important;
  }

  .tx-design {
    font-size: 72px;
    background: -webkit-linear-gradient(left, pink, blue);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .btn-design {
    border: 0 solid #ffffff !important;
    color : #fff;
    background-color: #000;
  }

  .box-color {
    width : 30px !important ; height : 30px !important;
  }

  .selected_box {
    border: 5px solid #007bff !important;
  }
</style>
<body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
    <section class="section-x pt-3 container">
      <div class="card mb-3 mt-2">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <!-- <img onerror="imgError(this)" src="<?php echo prep_url(api_url()).$pr->gambardesign ?>" data-imagezoom="true" class="img-produk"/> -->
              <div class="flexslider">
                <ul class="slides">
                  <?php foreach ($img as $i => $v): ?>
                    <li data-thumb="<?php echo prep_url(api_url()).$v->image ?>">
          	    	    <img src="<?php echo prep_url(api_url()).$v->image ?>" data-imagezoom="true" class="img-produk"/>
          	    		</li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="tx-design" style="font-size: 1em !important;"><strong>Design Sendiri</strong></div>
              <h4 class="mb-2"><strong><?php echo $pr->namabarang ?></strong></h4>
              <div class="bg-gray py-0">
                <h5 class="mb-0">
                <strong>Rp. <?php echo number_format($pr->harga) ?></strong>
                </h5>
              </div>
              <div class="mt-4">
                <table class="table" style="font-size: 0.9em !important">
                  <tbody>
                    <tr>
                      <th class="px-0 py-1" style="width : 20% !important">Bahan</th>
                      <th class="px-0 py-1" style="width : 10% !important">:</th>
                      <th class="px-0 py-1" style="width : 70% !important"><?php echo $pr->bahan ?></th>
                    </tr>
                    <tr>
                      <th class="px-0 py-1">Dimensi</th>
                      <th class="px-0 py-1">:</th>
                      <th class="px-0 py-1"><?php echo $pr->dimensi ?></th>
                    </tr>
                    <tr>
                      <th class="px-0 py-1">Kapasitas</th>
                      <th class="px-0 py-1">:</th>
                      <th class="px-0 py-1"><?php echo $pr->kapasitas ?></th>
                    </tr>
                    <tr>
                      <th class="px-0 py-1" colspan="3"><?php echo $pr->ketbarang ?></th>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="my-3">
                <div class="row">
                  <div class="col-md-12">
                    <small>Warna</small>
                  </div>
                </div>
                <div class="row">
                  <?php if ($pr->kodebarang != 'GX0010'): ?>
                    <?php foreach ($warna as $i => $v): ?>
                      <div class="col-md-1">
                        <div style="background : <?php echo $v->kodewarna ?> !important;" class="box-color" id="box-<?php echo $v->id ?>" onclick="pilih_warna('<?php echo $v->id ?>','<?php echo $v->kodewarna ?>','<?php echo $v->id_prod_lumise ?>')"></div>
                      </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
              </div>

              <div class="mt-4">
                <?php if ($pr->kodebarang != 'GX0010'): ?>
                  <button type="button" class="btn btn-lg btn-flat btn-design" disabled>
                    <strong>Design Sendiri</strong>
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php $this->load->view('_partials/foot.php'); ?>
    <script src="<?php echo base_url()?>assets/js/imagezoom.js"></script>
    <script src="<?php echo base_url()?>assets/flexslider/jquery.flexslider.js"></script>
</body>
<script>

    // $(function(){
    //   SyntaxHighlighter.all();
    // });

    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });

    function pilih_warna(id, color, id_lumise)
    {
        $(`.box-color`).removeClass('selected_box');
        $(`#box-${id}`).addClass('selected_box');
        $('.btn-design').css({"background-color": color, "color": "#000"});
        $('.btn-design').attr('onclick', 'design(' + id_lumise + ')');
        $('.btn-design').removeAttr('disabled','');
    }

    function design(id) {
      location.href = `<?php echo base_url(); ?>design/start?product_id=${id}`
    }

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
