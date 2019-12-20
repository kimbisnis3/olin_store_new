<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head.php'); ?>
  <style>
    .neon {
      border : 2px solid #53e074 !important;
      animation: hue 20s infinite linear;
    }

    @keyframes neon {
        from {
          filter: hue-rotate(0deg);
        }

        to {
          filter: hue-rotate(-360deg);
        }
      }
  </style>
  <body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
  <section class="section-x mb-5">
    <div class="container p-3">
      <div class="box-button p-3 col-md-6 mx-auto">
        <div class="row">
          <div class="col-md-12">
            <!-- <div class="row">
              <div class="col-md-6 pb-3">
                <button class="btn btn-biru btn-block" onclick="open_cust()"><i class="fa fa-user"></i> Daftar Sebagai Customer</button>
              </div>
              <div class="col-md-6 pb-3">
                <button class="btn btn-teal btn-block" onclick="open_reseller()"><i class="fa fa-users"></i> Daftar Sebagai Reseller</button>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="box-input neon box-user p-3 col-md-6 mx-auto">
        <div class="col-md-12">
          <form id="form-register">
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-hijau text-user text-center"> </h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama">
                  <input type="hidden" class="form-control" name="jencust">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Telp</label>
                  <input type="text" class="form-control" name="telp">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" class="form-control" name="alamat">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="user">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="pass">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Ketik Ulang Password</label>
                  <input type="password" class="form-control" name="typepass">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-hijau btn-md btn-block" id="btn-sign-up" onclick="register()"><i
                class="fa fa-sign-in"></i> Register</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
    <?php $this->load->view('_partials/foot.php'); ?>
  </body>

  <script>

    $(document).ready(function(){
      // $('.box-user').hide()
      open_cust()
    })

    function open_reseller() {
      $('.box-user').hide()
      $('.box-user').show()
      $('[name="jencust"]').val('res')
      $('.text-user').html('<i class="fa fa-users"></i> Reseller')
      $('#form-register')[0].reset();
    }

    function open_cust() {
      $('.box-user').hide()
      $('.box-user').show()
      $('[name="jencust"]').val('cust')
      $('.text-user').html('<i class="fa fa-user"></i> Customer')
      $('#form-register')[0].reset();
    }

    function register() {
      if ($('[name="nama"]').val() == '' || $('[name="nama"]').val() == null) {
        $('[name="nama"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="telp"]').val() == '' || $('[name="telp"]').val() == null) {
        $('[name="telp"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="email"]').val() == '' || $('[name="email"]').val() == null) {
        $('[name="email"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="alamat"]').val() == '' || $('[name="alamat"]').val() == null) {
        $('[name="alamat"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="user"]').val() == '' || $('[name="user"]').val() == null) {
        $('[name="user"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="pass"]').val() == '' || $('[name="pass"]').val() == null) {
        $('[name="pass"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="typepass"]').val() != $('[name="pass"]').val()) {
        $('[name="typepass"]').focus()
        toastr.warning('Ketik Ulang Password Harus Sesuai Dengan Password')
        return false
      }
      $('.form-control').prop('readonly', true)
      btnproc('#btn-sign-up', 1)
      $.ajax({
        url: `<?php echo base_url() ?>register/savedata`,
        type: "POST",
        dataType: "JSON",
        data: $('#form-register').serializeArray(),
        success: function (data) {
          if (data.status == 'success') {
            // showNotif(data.header, data.msg, data.class)
            toastr.success(data.msg)
            $('.form-control').prop('readonly', false)
            btnproc('#btn-sign-up', 0)
            // location.href = "<?php echo base_url() ?>";
            $('#form-register')[0].reset();
            setTimeout(function(){ login_modal() }, 1500);
          } else {
            // showNotif(data.header, data.msg, data.class)
            toastr.danger(data.msg)
            $('.form-control').prop('readonly', false)
            btnproc('#btn-sign-up', 0)
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $('.form-control').prop('readonly', false)
          toastr.danger(data.msg)
          btnproc('#btn-sign-up', 0)
        }
      });
    }
	</script>
</html>
