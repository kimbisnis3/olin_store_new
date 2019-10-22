<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<style>
    .checkout {
        margin: 20px !important;
    }
</style>
<body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
    <div class="checkout">
        <div class="container">
            <div class="ckeckout-top">
                <div class="cart-items">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-6">
                            <h4>My Cart Items (<span class="total_items"></span>)</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right">
                                <button class="btn btn-md btn-merah btn-flat btn-clear-cart" onclick="remove_cart('all')"><i class="fa fa-trash"></i> Clear Cart</button>
                                <button class="btn btn-md btn-hijau btn-flat btn-checkout" onclick="checkout()"><i class="fa fa-shopping-cart"></i></i> Checkout</button>
                            </div>
                        </div>
                    </div>
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Product</th>
                                <th>Harga</th>
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
                                <td align="center">Total</td>
                                <td class="total-cart" align="right"> </td>
                            </tr>
                        </tbody>
                    </table>
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
        load_cart()
    })

    function checkout() {
        if ($('#sess_in').val() == '' || $('#sess_in').val() == null) {
            login_modal_cart()
        } else {
            window.location = '<?php echo base_url() ?>billing';
        }
    }

    function load_cart() {
        $('.tr-tb').remove();
        $.ajax({
          url: `<?php echo base_url() ?>cart/content_cart`,
          type: "GET",
          dataType: "JSON",
          data: {},
          success: function(data) {
            //   console.log(data[0]['price'])
            $.each(data.content, function( i, v ) {
                $('.body-tb').append(`
                    <tr class="tr-tb fadeIn animated">
                        <td align="center">${showimage(v.image)}</td>
                        <td>${v.name}</td>
                        <td align="right">Rp. ${numeral(v.price).format('0,0')}</td>
                        <td align="center"><input style="height : 30px !important; width : 30px !important;" id="qty-${v.rowid}" type="text" value="${v.qty}"></td>
                        <td align="right">Rp. ${numeral(v.subtotal).format('0,0')}</td>
                        <td align="center">
                            <button style="border-radius : 0 !important" class="btn btn-md btn-edit-cart"  onclick="update_cart('${v.rowid}')"><i class="fa fa-save"></i></button>
                            <button style="border-radius : 0 !important" class="btn btn-md btn-delete-cart"  onclick="remove_cart('${v.rowid}')"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                `)

            });
            total_cart(data.total_price)
            btn_action(data.total_items)
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
          }
      });
    }

    function update_cart(rowid) {
        $('.btn-edit-cart').prop('disabled',true);
        $.ajax({
          url: `<?php echo base_url() ?>cart/update`,
          type: "POST",
          dataType: "JSON",
          data: {
            rowid: rowid,
            jumlah: $(`#qty-${rowid}`).val(),
          },
          success: function(data) {
              if (data.sukses == 'success') {
                total_items(data.total_items)
                total_cart(data.total_price)
                load_cart()
                // showNotif('Sukses', 'Produk Diubah', 'success')
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

    function remove_cart(rowid) {
        $('.btn-delete-cart').prop('disabled',true);
        $(".overlay").show();
        $.ajax({
          url: `<?php echo base_url() ?>cart/remove`,
          type: "POST",
          dataType: "JSON",
          data: {
            rowid: rowid,
          },
          success: function(data) {
            if (data.sukses == 'success') {
              total_items(data.total_items)
              total_cart(data.total_price)
              load_cart()
              // showNotif('Sukses', data.respon, 'success')
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
