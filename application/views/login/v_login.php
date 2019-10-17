<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head.php'); ?>
  <style>
    .box-input {
      max-width: 30%;
      margin: 35px auto;
      border : 2px solid #53e074 !important;
      padding : 30px;
      border-radius: 16px;
    }

    .box-button {
      max-width: 60%;
      margin: 35px auto;
      padding : 30px;
      border-radius: 16px;
    }

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
    <div class="x">
      <div class="box-input container neon box-user">
      <div class="row">
        <div class="col-md-12">
          <div class="pull-right">
            <h4 class="text-hijau text-user"> </h4>
          </div>
        </div>
      </div>
        <form id="form-login">
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
        </form>
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-hijau btn-md btn-block" id="btn-log-in" onclick="login()"><i
                class="fa fa-sign-in"></i> Login</button>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('_partials/foot.php'); ?>
  </body>

  <script>

    $(document).ready(function(){
      // $('.box-user').hide()
    })

    function login() {
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
      // $('.form-control').prop('readonly', true)
      // btnproc('#btn-log-in', 1)
      $.ajax({
        url: `<?php echo base_url() ?>login/auth_process`,
        type: "POST",
        dataType: "JSON",
        data: $('#form-login').serializeArray(),
        success: function (data) {
          if (data.status == 'success') {
            $('.form-control').prop('readonly', false)
            // btnproc('#btn-log-in', 0)
            toastr.success(data.msg)
            location.href = "<?php echo base_url() ?>";
            $('#form-login')[0].reset();
          } else {
            $('.form-control').prop('readonly', false)
            toastr.error(data.msg)
            // btnproc('#btn-log-in', 0)
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $('.form-control').prop('readonly', false)
          toastr.error(data.msg)
          // btnproc('#btn-log-in', 0)
        }
      });
    }
	</script>
</html>
