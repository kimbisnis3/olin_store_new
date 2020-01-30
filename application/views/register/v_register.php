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
                    <label>Alamat Lengkap</label>
                    <textarea class="form-control" rows="3" name="alamat"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select class="form-control" name="prov" id="prov">
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kota / Kabupaten</label>
                    <select class="form-control" name="city" id="city">
                      <option value="">-</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select class="form-control" name="kec" id="kec">
                      <option value="">-</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kelurahan</label>
                    <select class="form-control" name="kel" id="kel">
                      <option value="">-</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" class="form-control" name="kodepos" onkeypress="return inputangka(event)">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Jenis Pekerjaan</label>
                    <input type="text" class="form-control" name="jeniskerja">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>No. Wa</label>
                    <input type="text" class="form-control" name="telp" onkeypress="return inputangka(event)">
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
                  <button type="button" class="btn btn-hijau btn-md btn-block" id="btn-sign-up" onclick="register()"><i
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
      dpicker()
      $('[name="jencust"]').val('cust')
      $('.text-user').html('<i class="fa fa-users"></i> Customer')
      get_prov()
      $('#prov').prop('disabled', true);
      $('#city').prop('disabled', true);
      $('#kec').prop('disabled', true);
      $('#kel').prop('disabled', true);
      $("#prov").change(function(){
        $('#city').val('');
        $('#kec').val('');
        $('#kel').val('');
        $('#city').prop('disabled', true);
        $('#kec').prop('disabled', true);
        $('#kel').prop('disabled', true);
        get_city()
      });
      $("#city").change(function(){
        $('#kec').val('');
        $('#kel').val('');
        $('#kec').prop('disabled', true);
        $('#kel').prop('disabled', true);
        get_kec()
      });
      $("#kec").change(function(){
        $('#kel').val('');
        $('#kel').prop('disabled', true);
        get_kel()
      });
    })

    function get_prov()
    {
       $(`.classprov`).remove()
       $(`#prov`).val('');
       $('#prov').prop('disabled', true);
       $.ajax({
           url: `<?php echo base_url(); ?>apiloc/getprov`,
           type: "GET",
           dataType: "JSON",
           success: function(data) {
             $('#prov').prop('disabled', false);
             $(`#prov`).append(`<option class="classprov" value="">-</option>`);
                 $.each(data.data, function(i, v) {
                   $(`#prov`).append(`<option class="classprov" value="${v['kode']}">${v['nama']}</option>`);
                 })
           },
           error: function(jqXHR, textStatus, errorThrown) {
               $('#prov').prop('disabled', false);
               toastr.error('Internal Error')
           }
       });
    }

    function get_city()
    {
       let kodeprov = $('#prov').val();
       $('#city').prop('disabled', true);
       $(`.classcity`).remove()
       $(`#city`).val('');
       if (kodeprov) {
         $.ajax({
             url: `<?php echo base_url(); ?>apiloc/getcity?kodeprov=${kodeprov}`,
             type: "GET",
             dataType: "JSON",
             success: function(data) {
               $('#city').prop('disabled', false);
               $(`#city`).append(`<option class="classcity" value=""></option>`);
                   $.each(data.data, function(i, v) {
                     $(`#city`).append(`<option class="classcity" value="${v['kode']}">${v['nama']}</option>`);
                   })
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 $('#city').prop('disabled', false);
                 toastr.error('Internal Error')
             }
         });
       }
    }

    function get_kec()
    {
       let kodecity = $('#city').val();
       $('#kec').prop('disabled', true);
       $(`.classkec`).remove()
       $(`#kec`).val('');
       if (kodecity) {
         $.ajax({
             url: `<?php echo base_url(); ?>apiloc/getkec?kodecity=${kodecity}`,
             type: "GET",
             dataType: "JSON",
             success: function(data) {
               $('#kec').prop('disabled', false);
               $(`#kec`).append(`<option class="classkec" value=""></option>`);
                   $.each(data.data, function(i, v) {
                     $(`#kec`).append(`<option class="classkec" value="${v['kode']}">${v['nama']}</option>`);
                   })
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 $('#kec').prop('disabled', false);
                 toastr.error('Internal Error')
             }
         });
       }
    }

    function get_kel()
    {
       let kodekec = $('#kec').val();
       $('#kel').prop('disabled', true);
       $(`.classkel`).remove()
       $(`#kel`).val('');
       if (kodekec) {
         $.ajax({
             url: `<?php echo base_url(); ?>apiloc/getkel?kodekec=${kodekec}`,
             type: "GET",
             dataType: "JSON",
             success: function(data) {
               $('#kel').prop('disabled', false);
               $(`#kel`).append(`<option class="classkel" value=""></option>`);
                   $.each(data.data, function(i, v) {
                     $(`#kel`).append(`<option class="classkel" value="${v['kode']}">${v['nama']}</option>`);
                   })
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 $('#kel').prop('disabled', false);
                 toastr.error('Internal Error')
             }
         });
       }
    }

    function register() {
      if ($('[name="nama"]').val() == '' || $('[name="nama"]').val() == null) {
        $('[name="nama"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="alamat"]').val() == '' || $('[name="alamat"]').val() == null) {
        $('[name="alamat"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('#prov').val() == '' || $('#prov').val() == null) {
        $('#prov').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('#city').val() == '' || $('#city').val() == null) {
        $('#city').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('#kec').val() == '' || $('#kec').val() == null) {
        $('#kec').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('#kel').val() == '' || $('#kel').val() == null) {
        $('#kel').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="telp"]').val() == '' || $('[name="telp"]').val() == null) {
        $('[name="telp"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if ($('[name="telp"]').val().length <= 10) {
        $('[name="telp"]').focus()
        toastr.warning('No. WA minimal 10 Karakter')
        return false
      }
      if ($('[name="email"]').val() == '' || $('[name="email"]').val() == null) {
        $('[name="email"]').focus()
        toastr.warning('Lengkapi Data')
        return false
      }
      if (!validemail($('[name="email"]').val())) {
        $('[name="email"]').focus()
        toastr.warning('Email Tidak Valid')
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
        // data: $('#form-register').serializeArray(),
        data : {
          jencust : $('[name="jencust"]').val(),
          nama : $('[name="nama"]').val(),
          alamat : $('[name="alamat"]').val(),
          telp : $('[name="telp"]').val(),
          email : $('[name="email"]').val(),
          pic : $('[name="pic"]').val(),
          ket : $('[name="ket"]').val(),
          dob : $('[name="dob"]').val(),
          jk : $('[name="jk"]').val(),
          provkode : $('[name="prov"]').val(),
          provenama : $('[name="prov"] option:selected').html(),
          citykode : $('[name="city"]').val(),
          citynama : $('[name="city"] option:selected').html(),
          keckode : $('[name="kec"]').val(),
          kecnama : $('[name="kec"] option:selected').html(),
          kelkode : $('[name="kel"]').val(),
          kelnama : $('[name="kel"] option:selected').html(),
          kodepos : $('[name="kodepos"]').val(),
          jeniskerja : $('[name="jeniskerja"]').val(),
          user : $('[name="user"]').val(),
          pass : $('[name="pass"]').val(),
        },
        success: function (data) {
          if (data.status == 'success') {
            toastr.success(data.msg)
            $('.form-control').prop('readonly', false)
            btnproc('#btn-sign-up', 0)
            // location.href = "<?php echo base_url() ?>";
            $('#form-register')[0].reset();
            setTimeout(function(){ login_modal() }, 1500);
          } else {
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
