<?php
  //text
  $tx_footer  	 = $this->db->get_where('tconfigtext', array('kode' => 'tx_footer'))->row();

  //image
  $logofooter = $this->db->get_where('tconfigimage', array('kode' => 'logofooter'))->row();
 ?>
 <div class="footer-top py-lg-5 py-4">
		 <div class="container-fluid">
				 <div class="row">
						 <div class="col-md-3 footer-logo mb-lg-0 mb-4">
								 <ul class="post-links">
									 <h5 class="footer-top-title"><img onerror='imgError(this)' src="<?php echo prep_url(api_url()).$logofooter->image ?>" class="img-logo"></h5>
										 <li>
                       <?php echo $tx_footer->teks ?>
                     </li>
								 </ul>
						 </div>
						 <div class="col-md-3">
								 <h5 class="footer-top-title">Produk</h5>
								 <ul class="post-links">
										 <li><a href="#">Tas Sekolah</a></li>
										 <li><a href="#">Backpack</a></li>
								 </ul>
						 </div>
						 <div class="col-md-3">
								 <h5 class="footer-top-title">Design Sendiri</h5>
								 <ul class="post-links">
										 <li>Tas Anak Tanpa Kantong</li>
										 <li>Tas Anak Dengan Kantong</li>
								 </ul>
						 </div>
						 <div class="col-md-3">
								 <h5 class="footer-top-title">Login</h5>
								 <ul class="post-links">
										 <li><strong><a href="<?php echo base_url() ?>karir">Karir</a></strong></li>
										 <li><strong><a href="<?php echo base_url() ?>aboutus">Tentang Kami</a></strong></li>
								 </ul>
						 </div>
				 </div>
		 </div>
 </div>
 <script src="<?php echo base_url(); ?>assets/js/jquery-2.2.3.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/move-top.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
 <script src="<?php echo base_url(); ?>assets/slick/slick.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/twentytwenty/js/jquery.event.move.js"></script>
 <script src="<?php echo base_url(); ?>assets/twentytwenty/js/jquery.twentytwenty.js"></script>
 <script src="<?php echo base_url(); ?>assets/magnify/js/jquery.magnify.js"></script>
 <script src="<?php echo base_url() ?>assets/toastr/toastr.min.js"></script>
 <script>
 		jQuery(document).ready(function ($) {
 				$(".scroll").click(function (event) {
 						event.preventDefault();

 						$('html,body').animate({
 								scrollTop: $(this.hash).offset().top
 						}, 1000);
 				});
 		});
 </script>
<script>
	total_items(<?php echo $this->cart->total_items() ?>)
	menuaktif('<?php echo $menuaktif ?>')

	function total_items(x) {
		$('.total_items').html(x);
	}

	function menuaktif(menu) {
		$(`.menu-${menu}`).addClass('active');
	}

    function total_cart(x)
    {
        $('.total-cart').html(`Rp.${numeral(x).format('0,0')}`)
    }

    function total_biaya(x)
    {
        $('.total-biaya').html(`Rp.${numeral(x).format('0,0')}`)
    }

	function select2() {
	    $('.select2').select2({
	        placeholder: 'Select an option',
	        allowClear: true
	    });
	}

	function showNotif(title, msg, jenis) {
	    $.notify({
	        title: '<strong>' + title + '</strong>',
	        message: msg
	    }, {
	        type: jenis,
	        z_index: 2000,
	        allow_dismiss: true,
	        delay: 10,
	        animate: {
	            enter: 'animated bounceIn',
				exit: 'animated zoomOut'
	        },
	    }, );
	}

	function showimage(url) {
	    return `<img class="img-responsive" onerror="this.onerror=null; this.src='assets/noimage.png'" style="max-width : 60px;" src="<?php echo prep_url(api_url()) ?>${url}" >`
	}

	function imgError(image) {
	    image.onerror = "";
	    image.src = `<?php echo base_url() ?>assets/noimage.png`;
	    return true;
	}

	function login() {
		// if ($('[name="user"]').val() == '' || $('[name="user"]').val() == null) {
		// 	$('[name="user"]').focus()
		// 	showNotif('Perhatian', 'Lengkapi Data', 'warning')
		// 	return false
		// }
		// if ($('[name="pass"]').val() == '' || $('[name="pass"]').val() == null) {
		// 	$('[name="pass"]').focus()
		// 	showNotif('Perhatian', 'Lengkapi Data', 'warning')
		// 	return false
		// }
		$('[name="user"]').prop('readonly', true)
		$('[name="pass"]').prop('readonly', true)
		btnproc('#btn-sign-in', 1)
		$.ajax({
			url: `<?php echo base_url() ?>login/auth_process`,
			type: "POST",
			dataType: "JSON",
			data: $('#form-login').serialize(),
			success: function (data) {
				if (data.status == 'success') {
					showNotif(data.caption, data.msg, data.class)
					$('[name="user"]').prop('readonly', false)
					$('[name="pass"]').prop('readonly', false)
					location.reload();
					btnproc('#btn-sign-in', 0)
					location.href = "<?php echo base_url() ?>";
				} else {
					showNotif(data.caption, data.msg, data.class)
					$('[name="user"]').prop('readonly', false)
					$('[name="pass"]').prop('readonly', false)
					btnproc('#btn-sign-in', 0)
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$('[name="user"]').prop('readonly', false)
				$('[name="pass"]').prop('readonly', false)
				btnproc('#btn-sign-in', 0)
			}
		});
	}

	function login_cart(tipe) {
		// if ($('[name="user"]').val() == '' || $('[name="user"]').val() == null) {
		// 	$('[name="user"]').focus()
		// 	showNotif('Perhatian', 'Lengkapi Data', 'warning')
		// 	return false
		// }
		// if ($('[name="pass"]').val() == '' || $('[name="pass"]').val() == null) {
		// 	$('[name="pass"]').focus()
		// 	showNotif('Perhatian', 'Lengkapi Data', 'warning')
		// 	return false
		// }
		$('[name="user"]').prop('readonly', true)
		$('[name="pass"]').prop('readonly', true)
		btnproc('#btn-sign-in', 1)
		$.ajax({
			url: `<?php echo base_url() ?>login/auth_process`,
			type: "POST",
			dataType: "JSON",
			data: $('#form-login').serialize(),
			success: function (data) {
				if (data.status == 'success') {
					showNotif(data.caption, data.msg, data.class)
					$('[name="user"]').prop('readonly', false)
					$('[name="pass"]').prop('readonly', false)
					location.reload();
					btnproc('#btn-sign-in', 0)
					if (tipe == 'cart') {
						location.href = "<?php echo base_url() ?>billing";
					} else {
						location.href = "<?php echo base_url() ?>";
					}
				} else {
					showNotif(data.caption, data.msg, data.class)
					$('[name="user"]').prop('readonly', false)
					$('[name="pass"]').prop('readonly', false)
					btnproc('#btn-sign-in', 0)
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$('[name="user"]').prop('readonly', false)
				$('[name="pass"]').prop('readonly', false)
				btnproc('#btn-sign-in', 0)
			}
		});
	}

    function login_modal() {
    	$('.label-login').html('Masuk');
		$('#modal-data').modal('show');
		$('#btn-sign-in').attr('onclick','login_cart("all")');
	}

	function login_modal_cart() {
		$('.label-login').html('Masuk Untuk Checkout');
		$('#modal-data').modal('show');
		$('#btn-sign-in').attr('onclick','login_cart("cart")');
    }

	function btnproc(prop, tipe, label = 'Processing') {
      if (tipe == 1) {
          label_old_btn = ($(prop).html());
          $(prop).prop('disabled', true);
          $(prop).html(`<i class="fa fa-spinner fa-spin"></i> ${label}`);
      } else if (tipe == 0) {
          $(prop).prop('disabled', false);
          $(prop).html(`${label_old_btn}`);
      }
	}

	function ceknull(x) {
	    if ($('[name="' + x + '"]').val() == '' || $('[name="' + x + '"]').val() == null) {
			showNotif('', 'Kolom '+ x +' Wajib Diisi', 'danger');
	        $('[name="' + x + '"]').focus()
	        return true
			$('.btn-save').prop('disabled',false);
	    } else {
	        return false
	    }
	}

	function cekzero(x) {
	    if ($('[name="' + x + '"]').val() <= '0' || $('[name="' + x + '"]').val() <= 0 || $('[name="' + x + '"]').val() == null) {
			showNotif('', 'Kolom '+ x +' Wajib Diisi', 'danger');
	        $('[name="' + x + '"]').focus()
	        return true
			$('.btn-save').prop('disabled',false);
	    } else {
	        return false
	    }
	}


</script>
