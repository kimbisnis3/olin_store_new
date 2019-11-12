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
  <section class="section-x my-4">
    <div class="container pb-3">
      <div class="box-button">
        <div class="row">
          <div class="col-md-12 text-center">
            <h3>User Profile</h3>
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
                  <input type="hidden" class="form-control" name="kode">
                  <input type="text" class="form-control" name="nama">
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
                <button type="button" class="btn btn-hijau btn-md btn-block" id="btn-sign-up" onclick="savedata()"><i
                class="fa fa-sign-in"></i> Simpan</button>
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
      getdata()
    })

    function getdata() {
      $.ajax({
        url: `<?php echo base_url() ?>user/edit`,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
          $('[name="kode"]').val(data.kode)
          $('[name="nama"]').val(data.nama)
          $('[name="telp"]').val(data.telp)
          $('[name="email"]').val(data.email)
          $('[name="alamat"]').val(data.alamat)
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // toastr.danger('Internal Error')
        }
      });
    }

    function savedata() {
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
      // if ($('[name="pass"]').val() == '' || $('[name="pass"]').val() == null) {
      //   $('[name="pass"]').focus()
      //   showNotif('Perhatian', 'Lengkapi Data', 'warning')
      //   return false
      // }
      if ($('[name="typepass"]').val() != $('[name="pass"]').val()) {
        $('[name="typepass"]').focus()
        showNotif('Perhatian', 'Ketik Ulang Password Harus Sesuai Dengan Password', 'warning')
        return false
      }
      $('.form-control').prop('readonly', true)
      $.ajax({
        url: `<?php echo base_url() ?>user/updatedata`,
        type: "POST",
        dataType: "JSON",
        data: $('#form-register').serializeArray(),
        success: function (data) {
          if (data.status == 'success') {
            toastr.success('Sukses')
            $('.form-control').prop('readonly', false)
            location.href = "<?php echo base_url() ?>user";
          } else {
            toastr.error('Gagal')
            $('.form-control').prop('readonly', false)
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $('.form-control').prop('readonly', false)
          toastr.error('Internal Error')
        }
      });
    }
	</script>
</html>
