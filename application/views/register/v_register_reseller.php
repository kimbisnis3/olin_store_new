<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head.php'); ?>
  <style>
    .neon {
      border : 2px solid #53e074 !important;
      animation: hue 20s infinite linear;
    }

    .btn-top {
      background-color: #5EC6C5 !important;
      border: 2px solid #5EC6C5 !important;
      color : #ffdc61 !important;
      font-weight: bolder;
      border-radius: 15px;
    }

    @media only screen and (max-width: 600px) {
      .btn-top {
        font-size: 67% !important;
      }
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
  <section class="p-3">
    <div class="container">
      <div class="row justify-content-md-center my-3">
        <div class="col-md-auto">
          <a href="<?php echo base_url() ?>uploads/pdf/rules_reseller.pdf" download><button type="button" class="btn btn-primary btn-top" onclick="get_pdf()">klik disini untuk melihat syarat dan ketentuan reseller</button></a>
        </div>
      </div>
      <div class="row justify-content-md-center">
        <div class="col-md-auto">
          <div class="col-md-12 neon p-3">
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
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" name="alamat">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>No. Wa</label>
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
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select type="text" class="form-control" name="jk">
                      <option value=""></option>
                      <option value="Laki-Laki">Laki-Laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control datepicker" name="dob">
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
                  <button class="btn btn-hijau btn-md btn-block" id="btn-sign-up" onclick="register()"><i
                  class="fa fa-sign-in"></i> Register</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
    <?php $this->load->view('_partials/foot.php'); ?>
  </body>

  <script>

    $(document).ready(function(){
      // $('.box-user').hide()
      open_reseller()
      dpicker()
    })

    function get_pdf()
    {
       // <a href="'.$img.'" title="ImageName"  download="img_'.time().'" ><img onerror="imgError(this)" style="max-width : 60px;" src="'.$img.'" alt="ImageName"></a>
    }

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
        showNotif('Perhatian', 'Lengkapi Data', 'warning')
        return false
      }
      if ($('[name="telp"]').val() == '' || $('[name="telp"]').val() == null) {
        $('[name="telp"]').focus()
        showNotif('Perhatian', 'Lengkapi Data', 'warning')
        return false
      }
      if ($('[name="email"]').val() == '' || $('[name="email"]').val() == null) {
        $('[name="email"]').focus()
        showNotif('Perhatian', 'Lengkapi Data', 'warning')
        return false
      }
      if ($('[name="alamat"]').val() == '' || $('[name="alamat"]').val() == null) {
        $('[name="alamat"]').focus()
        showNotif('Perhatian', 'Lengkapi Data', 'warning')
        return false
      }
      if ($('[name="user"]').val() == '' || $('[name="user"]').val() == null) {
        $('[name="user"]').focus()
        showNotif('Perhatian', 'Lengkapi Data', 'warning')
        return false
      }
      if ($('[name="pass"]').val() == '' || $('[name="pass"]').val() == null) {
        $('[name="pass"]').focus()
        showNotif('Perhatian', 'Lengkapi Data', 'warning')
        return false
      }
      if ($('[name="typepass"]').val() != $('[name="pass"]').val()) {
        $('[name="typepass"]').focus()
        showNotif('Perhatian', 'Ketik Ulang Password Harus Sesuai Dengan Password', 'warning')
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
