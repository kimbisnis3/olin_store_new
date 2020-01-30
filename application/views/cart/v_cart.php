<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<style>

</style>
<body class="fadeIn animated">
<?php $this->load->view('_partials/topbar.php'); ?>
  <section class="section-x">
    <div class="container pt-4">
      <div class="row">
        <div class="col-md-12">
          <div class="">
              <button class="btn btn-md btn-merah btn-flat btn-clear-cart" onclick="remove_cart('all')"><i class="fa fa-trash"></i> Clear Cart</button>
              <button class="btn btn-md btn-hijau btn-flat btn-checkout" onclick="checkout()"><i class="fa fa-shopping-cart"></i></i> Checkout</button>
          </div>
        </div>
      </div>
    </div>
    <div class="container my-3">
      <div class="table-responsive">
        <table class="table-custom" id="table" style="width :100% !important">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Item</th>
                    <th>Product</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="body-tb">
            </tbody>
            <tbody>
                <tr class="tr-total">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="center">Total</td>
                    <td class="total-cart"></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </section>
  <div class="modal fade" id="modal-promo" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header no-border">
          <h5 class="modal-title text-hijau label-login">Masukan Kode Promo</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="box-body pad">
            <form id="form-promo">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group invisible">
                    <label>Row ID</label>
                    <input type="text" class="form-control" name="promo_rowid" id="promo_rowid">
                  </div>
                  <div class="form-group invisible">
                    <label>QTY</label>
                    <input type="text" class="form-control" name="promo_qty" id="promo_qty">
                  </div>
                  <div class="form-group invisible">
                    <label>Kode Barang</label>
                    <input type="text" class="form-control" name="promo_kodebrg" id="promo_kodebrg">
                  </div>
                  <div class="form-group">
                    <label>Kode Promo</label>
                    <input type="text" class="form-control" name="promo_kode" id="promo_kode">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-hijau btn-md btn-block" onclick="do_update_promo()"><i class="fa fa-paper-plane"></i> Submit</button>
        </div>
      </div>
    </div>
  </div>
    <?php $this->load->view('_partials/foot.php'); ?>
    <script src="<?php echo base_url()?>assets/pace/pace.js"></script>
</body>
<script>
    var total_all_items = <?php echo $this->cart->total_items() ?>;
    $(document).ready(function() {
        getdata()
        gettotal()
    })

    function checkout() {
        if ($('#sess_in').val() == '' || $('#sess_in').val() == null) {
            login_modal_cart()
        } else {
            window.location = '<?php echo base_url() ?>billing';
        }
    }

    function getdata()
    {
      table = $('#table').DataTable({
          "processing": true,
          "scrollX": true,
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "ajax": {
              "url": `<?php echo base_url(); ?>cart/content_cart`,
              "type": "POST",
              "data": {},
          },
          "columns": [
              { "data": "id", "visible" : false },
              // { "render" : (data,type,row,meta) => { return `${showimage(row.image)}` }},
              { "render" : (data,type,row,meta) => { return `<img class="img-responsive" onerror="this.onerror=null; this.src='assets/noimage.png'" style="max-width : 60px;" src="${row.imagedsgn}" >` }},
              { "data": "name" },
              { "render" : (data,type,row,meta) => { return `${numeral(row.harga).format('0,0')}` }},
              { "render" : (data,type,row,meta) => { return `${numeral(row.diskon).format('0,0')} <i class="fa fa-times pointer text-danger invisible" onclick=do_delete_promo('${row.rowid}')></i>` } , "visible" : false},
              { "render" : (data,type,row,meta) => { return `<input style="height : 30px !important; width : 30px !important;" id="qty-${row.rowid}" type="text" value="${row.qty}">` }},
              { "render" : (data,type,row,meta) => { return `${numeral(row.subharga).format('0,0')}` }},
              { "render" : (data,type,row,meta) => {return `
                <button style="border-radius : 0 !important" class="btn btn-md btn-edit-cart"  onclick="update_cart('${row.rowid}', '${row.kode}')"><i class="fa fa-save"></i></button>
                <button style="border-radius : 0 !important" class="btn btn-md btn-delete-cart"  onclick="remove_cart('${row.rowid}', '${row.kode}')"><i class="fa fa-times"></i></button>
                <button style="border-radius : 0 !important" class="btn btn-md btn-edit-promo invisible"  onclick="update_promo('${row.rowid}','${row.kode}','${row.qty}')"><i class="fa fa-tag"></i></button>
              `} },
          ]
      });
    }

    function gettotal() {
        $.ajax({
          url: `<?php echo base_url() ?>cart/totalcart`,
          type: "GET",
          dataType: "JSON",
          data: {},
          success: function(data) {
            total_cart(data.total_harga)
            btn_action(data.total_items)
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
          }
      });
    }

    function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
    }

    function update_cart(rowid, ref_brg) {
        $('.btn-edit-cart').prop('disabled',true);
        $.ajax({
          url: `<?php echo base_url() ?>cart/update`,
          type: "POST",
          dataType: "JSON",
          data: {
            rowid   : rowid,
            ref_brg : ref_brg,
            jumlah  : $(`#qty-${rowid}`).val(),
          },
          success: function(data) {
              if (data.sukses == 'success') {
                gettotal()
                refresh()
                toastr.success('Produk Diubah')
                $('.btn-delete-cart').prop('disabled',false);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
                $('.btn-delete-cart').prop('disabled',false);
          }
      });
    }

    function remove_cart(rowid, ref_brg) {
        $('.btn-delete-cart').prop('disabled',true);
        $(".overlay").show();
        $.ajax({
          url: `<?php echo base_url() ?>cart/update`,
          type: "POST",
          dataType: "JSON",
          data: {
            rowid   : rowid,
            ref_brg : ref_brg,
            jumlah  : 0,
          },
          success: function(data) {
            if (data.sukses == 'success') {
              gettotal()
              refresh()
              toastr.success(data.respon)
              $('.btn-delete-cart').prop('disabled',true);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
                $('.btn-delete-cart').prop('disabled',true);
          }
      });
    }

    function notifLoading() {
	    $.notify({
	        title: '<strong> Processing ... </strong>',
	        message: '',
	        icon: 'fa fa-circle-o-notch fa-spin',
	    }, {
	        type: 'warning',
	        placement: {
	            align: 'center'
	        },
	        z_index: 2000,
	        allow_dismiss: 'false',
	        animate: {
	            enter: 'animated fadeIn',
	            exit: 'animated fadeOut'
	        },
	    }, );
	}

  function update_promo(rowid, kodebrg, qty) {
      $('#promo_kode').val('')
      $('#promo_qty').val(qty)
      $('#promo_rowid').val(rowid)
      $('#promo_kodebrg').val(kodebrg)
      $('#modal-promo').modal('show')
  }

  function do_update_promo() {
      $.ajax({
          url: `<?php echo base_url() ?>cart/update_promo`,
          type: "POST",
          dataType: "JSON",
          data: $('#form-promo').serializeArray(),
          success: function(data) {
              if (data.status == 'success') {
                toastr.success(data.msg)
                refresh()
                $('#modal-promo').modal('hide')
              } else {
                toastr.error(data.msg)
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
          }
      });
  }

  function do_delete_promo(rowid) {
      $.ajax({
          url: `<?php echo base_url() ?>cart/delete_promo`,
          type: "POST",
          dataType: "JSON",
          data: {
            promo_rowid : rowid
          },
          success: function(data) {
              if (data.status == 'success') {
                toastr.success(data.msg)
                refresh()
              } else {
                toastr.error(data.msg)
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
          }
      });
  }

    function btn_action(x) {
        if(x == 0) {
            $('.btn-checkout').addClass('invisible')
            $('.btn-clear-cart').addClass('invisible')
        } else {
            $('.btn-checkout').removeClass('invisible')
            $('.btn-clear-cart').removeClass('invisible')
        }
    }

</script>
</html>
