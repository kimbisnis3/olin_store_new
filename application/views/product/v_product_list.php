<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<style media="screen">
  .img-produk {
    height: 100%;
    width: 100%;
  }
  .img-slide-pr {
    width : 100% !important;
    height : 400px !important
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
  @media only screen and (max-width: 600px) {
    .img-slide-pr {
      width : 100% !important;
      height : 200px !important
    }
  }
</style>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<?php $this->load->view('_partials/topbar') ?>
  <section>
    <div class="container">
      <div class="row list-produk">
        <?php foreach ($product as $i => $v) { ?>
        <div class="col-md-3 p-3">
          <div class="card item-flat border-0 my-2">
            <div class="card-header text-center border-0">
              <?php if ($v['is_design'] == true): ?>
              <a href="<?php echo base_url(); ?>product/detail?q=<?php echo $v['kodebarang'] ?>" class="link-href">
                <strong><?php echo $v['namabarang'] ?></strong>
              </a>
              <?php else: ?>
              <div onclick="open_detail('<?php echo $v['kodebarang'] ?>')" class="pointer">
                <strong><?php echo $v['namabarang'] ?></strong>
              </div>
              <?php endif; ?>
            </div>
            <div class="card-body text-center p-0">
              <?php if ($v['is_design'] == true): ?>
              <a href="<?php echo base_url(); ?>product/detail?q=<?php echo $v['kodebarang'] ?>" class="link-href">
                <img src="<?php echo prep_url(api_url()).$v['gambardesign'] ?>" alt="" class="img-produk">
              </a>
              <?php else: ?>
              <div onclick="open_detail('<?php echo $v['kodebarang'] ?>')" class="pointer">
                <img src="<?php echo prep_url(api_url()).$v['gambardesign'] ?>" alt="" class="img-produk">
              </div>
              <?php endif; ?>
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
  <?php if ($this->input->get('q') != 'GX0001'): ?>
    <section class="pl-4 mb-0">
      <h4>CARA ORDER</h4>
    </section>
    <section class="py-3">
      <div class="container-fluid">
        <img src="<?php echo prep_url(api_url()).$banner->image ?>" data-magnify-src="<?php echo prep_url(api_url()).$banner->image ?>" class="img-slide-pr">
      </div>
    </section>
  <?php endif; ?>

<?php $this->load->view('_partials/foot') ?>
<script src="<?php echo base_url()?>assets/js/imagezoom_bottom.js"></script>
</body>
<div class="modal fade" id="modal-image" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-0">
      <div class="modal-header no-border">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="box-body pad">
          <div class="row list-image">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <script>

  $(document).ready(function() {
    $('.img-slide-pr').magnify({
    	magnifiedWidth : 1700,
    	magnifiedHeight : 900
    });
  });

  function open_detail(kode) {
    $.ajax({
        url: `<?php echo base_url() ?>product/detail_image`,
        type: "POST",
        dataType: "JSON",
        data: {
            kode: kode,
        },
        success: function(data) {
            console.log(data)
            $('.item-image').remove();
            $('#modal-image').modal('show');
            $.each(data, function( i, v ) {
                $('.list-image').append(`
                  <div class="col-md-4 item-image">
                    <img src="<?php echo prep_url(api_url()) ?>${v['image']}" data-imagezoom="true" class="img-fluid img-produk">
                  </div>
                `)
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr.error('Internal Error')
        }
    });
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
