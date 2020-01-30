<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
	<section class="section-x py-5">
        <div class="container step step-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-4">
                            <label for="">Nama Penerima</label>
                            <input type="text" class="form-control" name="nama_penerima">
                        </div>
                        <div class="col-md-4">
                            <label for="">Telp Penerima</label>
                            <input type="text" class="form-control" name="telp_penerima">
                        </div>
                        <div class="col-md-4">
                            <label for="">Email Penerima</label>
                            <input type="text" class="form-control" name="email_penerima">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-8">
                            <label for="">Alamat Lengkap Penerima</label>
                            <input type="text" class="form-control" name="alamat_penerima">
                            <!-- <textarea name="alamat_penerima" rows="4" class="form-control"></textarea> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container step step-2">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-6">
                            <label for="">Layanan</label>
                            <select class="form-control" name="layanan" id="layanan">
                                <option value="">-</option>
                            </select>
                            <input type="hidden" class="form-control" name="hargalayanan" id="hargalayanan">
                        </div>
                        <div class="col-md-6">
                            <label for="">Pengiriman</label>
                            <select class="form-control" name="kirim" id="kirim" onchange="changekirim()">
                                <option value="">-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row box-cod fadeIn animated">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <label for="">Alamat COD</label>
                            <input type="text" class="form-control" name="alamatcod" id="alamatcod">
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row box-kurir fadeIn animated">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-4">
                            <label for="">Provinsi</label>
                            <select class="form-control input-kurir" name="provinsi" id="provinsi" onchange="getcity()">
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Kota</label>
                            <select class="form-control input-kurir" name="kota" id="kota" onchange="changecity(); getdist()">
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Kecamatan</label>
                            <select class="form-control input-kurir" name="kecamatan" id="kecamatan">
                                <option value="">-</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row mb-2">
                        <div class="col-md-8">
                            <label for="">Alamat Pengiriman</label>
                            <input type="text" class="form-control" name="alamatkirim" id="alamatkirim">
                        </div>
                    </div> -->
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row box-kurir fadeIn animated">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-4">
                            <label for="">Kurir</label>
                            <select class="form-control input-kurir" name="kurir" id="kurir" onchange="getservice()">
                                <option value="">-</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS</option>
                                <option value="jnt">J&T</option>
                                <option value="sicepat">SICEPAT</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Service</label>
                            <select class="form-control input-kurir" name="service" id="service" onchange="getongkir()">
                                <option value="">-</option>
                            </select>
                            <input type="hidden" class="form-control input-kurir" name="arr_service" id="arr_service"/>
                        </div>
                        <div class="col-md-4">
                            <label for="">Biaya Kirim</label>
                            <input type="text" class="form-control input-kurir" name="biaya" id="biaya" readonly="true"/>
                            <!-- <input type="hidden" class="form-control" name="kodekurir" id="kodekurir" readonly="true"/>
                            <input type="text" class="form-control" name="berattotal" id="berattotal" readonly="true"/> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row box-kurir fadeIn animated">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-4">
                            <label>Nama Pengirim</label>
                            <input type="text" class="form-control" name="namakirim">
                        </div>
                        <div class="col-md-4">
                            <label>No. HP Pengirim</label>
                            <input type="text" class="form-control" name="hpkirim" onkeypress="return inputangka(event)">
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row invisible">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-4">
                            <label for="">Kode Kurir</label>
                            <input type="text" class="form-control input-kurir" name="kodekurir" id="kodekurir" readonly="true"/>
                        </div>
                        <div class="col-md-4">
                            <label for="">Total Berat</label>
                            <input type="text" class="form-control" name="berattotal" id="berattotal" readonly="true"/>
                        </div>
                        <div class="col-md-4">
                            <label for="">Total Cart</label>
                            <input type="text" class="form-control" name="carttotal" id="carttotal" readonly="true"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

        <div class="container step step-3">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-12">
                            <label for="">Pilihan Bank</label>
                            <select class="form-control" name="bank" id="bank" onchange="getnorek()">
                                <option value="">-</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px !important;">
                        <div class="col-md-12">
                            <label>No Rekening : <strong><span id="norek"></span></strong></label><br>
                            <label>Atas Nama : <strong><span id="atasnama"></span></strong></label>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="col-md-12">
                            <label for="">Keterangan Pengiriman</label>
                            <textarea class="form-control" name="ket" id="ket" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="container step step-4">
            <div class="d-flex justify-content-center py-1">
              <h4>Ringkasan Pembelian</h4>
            </div>
            <div class="d-flex justify-content-center p-3">
              <div class="col-md-12">
                <table class="table">
                  <tr>
                    <td>Nama Penerima</th>
                    <td>:</th>
                    <td><span id="k_nama_penerima"></span></td>
                    <td>Telp Penerima</th>
                    <td>:</th>
                    <td><span id="k_telp_penerima"></span></td>
                  </tr>
                  <tr>
                    <td>Email Penerima</th>
                    <td>:</th>
                    <td><span id="k_email_penerima"></span></td>
                    <td>Alamat Penerima</th>
                    <td>:</th>
                    <td><span id="k_alamat_penerima"></span></td>
                  </tr>
                  <tr id="visible_cod">
                    <td>Alamat COD</th>
                    <td>:</th>
                    <td><span id="k_alamat_cod"></span></td>
                  </tr>
                  <!-- <tr id="visible_kirim">
                    <td>Alamat Pengiriman</th>
                    <td>:</th>
                    <td><span id="k_alamat_Kirim"></span></td>
                  </tr> -->
                  <tr>
                    <td>Nama Pengirim</th>
                    <td>:</th>
                    <td><span id="k_namakirim"></span></td>
                    <td>HP Pengirim</th>
                    <td>:</th>
                    <td><span id="k_hpkirim"></span></td>
                  </tr>
                  <tr>
                    <td>Provinsi</th>
                    <td>:</th>
                    <td><span id="k_provinsi"></span></td>
                    <td>Kota</th>
                    <td>:</th>
                    <td><span id="k_kota"></span></td>
                  </tr>
                  <tr>
                    <td>Pengiriman</th>
                    <td>:</th>
                    <td><span id="k_kirim"></span></td>
                    <td>Kurir</th>
                    <td>:</th>
                    <td><span id="k_kurir"></span></td>
                  </tr>
                  <tr>
                    <td>Layanan</th>
                    <td>:</th>
                    <td><span id="k_layanan"></span></td>
                    <td>Biaya Layanan</th>
                    <td>:</th>
                    <td><span id="k_hargalayanan"></span></td>
                  </tr>
                  <tr>
                    <td>Bank</th>
                    <td>:</th>
                    <td><span id="k_bank"></span></td>
                    <td>No Rekening</th>
                    <td>:</th>
                    <td><span id="k_norek"></span></td>
                  </tr>
                  <tr>
                    <td>Total Berat</th>
                    <td>:</th>
                    <td><span id="k_berattotal"></span></td>
                    <td>Biaya Kirim</th>
                    <td>:</th>
                    <td><span id="k_biaya"></span></td>
                  </tr>
                  <tr>
                    <td>Total Pembelian</th>
                    <td>:</th>
                    <td><span id="k_total"></span></td>
                    <td>Total Bayar</th>
                    <td>:</th>
                    <td><span id="k_totalbayar"></span></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <button class="btn btn-block btn-hijau btn-md btn-konfirmasi" onclick="savedata()"><i class="fa fa-check"></i> Konfirmasi Pesanan ?</button>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="containter btn-step mt-3">
            <div class="ckeck-top heading">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-md btn-merah btn-prev" onclick="prev_page()"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                        <button type="button" class="btn btn-md btn-teal btn-next" onclick="next_page()">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
	</section>
	<?php $this->load->view('_partials/foot.php'); ?>
</body>
<script src="<?php echo base_url()?>assets/pace/pace.js"></script>
<script>
    var page = 1;
    var maxpage = 4;
    var minpage = 1;
    var arr_barang = [];
    $(document).ready(function() {
        getsessdata()
        initstep()
        Pace.stop()
        btn_direct()
        getprov()
        getbank()
        getlayanan()
        getkirim()
        gettotal()
        // getdata()
    })

    function getsessdata() {
        $.ajax({
	        url: `<?php echo base_url() ?>login/sessdata`,
	        type: "GET",
	        dataType: "JSON",
	        success: function(data) {
                $('[name="nama_penerima"]').val(data.nama);
                $('[name="telp_penerima"]').val(data.telp);
                $('[name="email_penerima"]').val(data.email);
                $('[name="alamat_penerima"]').val(data.alamat);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error on process');
	        }
	    });
    }

    function savedata(){
        btnproc('.btn-konfirmasi',1)
        $.ajax({
	        url: `<?php echo base_url() ?>order/savedata`,
	        type: "POST",
	        dataType: "JSON",
            data : {
                nama_penerima   : $('[name="nama_penerima"]').val(),
                telp_penerima   : $('[name="telp_penerima"]').val(),
                email_penerima  : $('[name="email_penerima"]').val(),
                alamat_penerima : $('[name="alamat_penerima"]').val() ,
                provinsito      : $('[name="provinsi"]').val(),
                cityto          : $('[name="kota"]').val(),
                kecato          : $('[name="kecamatan"]').val(),
                maskprovinsito  : $('[name="provinsi"] option:selected').html(),
                maskcityto      : $('[name="kota"] option:selected').html(),
                kgkirim         : $('[name="berattotal"]').val(),
                bykirim         : $('[name="biaya"]').val(),
                kodekurir       : $('[name="kodekurir"]').val(),
                kurir           : $('[name="kurir"]').val(),
                ref_kirim       : $('[name="kirim"]').val(),
                ref_layanan     : $('[name="layanan"]').val(),
                ket             : $('[name="ket"]').val(),
                bank            : $('[name="bank"]').val(),
                hargalayanan    : $('[name="hargalayanan"]').val(),
                total_cart      : $('[name="carttotal"]').val(),
                alamatcod       : $('[name="alamatcod"]').val(),
                namakirim       : $('[name="namakirim"]').val(),
                hpkirim         : $('[name="hpkirim"]').val(),
                // alamatkirim     : $('[name="alamatkirim"]').val(),
                // arr_produk      : arr_barang.content
            },
	        success: function(data) {
                if (data.sukses == 'success') {
                    console.log('sukses')
                    toastr.success("Pesanan Berhasil Dilakukan, Segera Masukan Data Pembayaran")
                    btnproc('.btn-konfirmasi',0)
                    setTimeout(function(){
                        location.href = '<?php echo base_url() ?>payment';
                    }, 2000);

                } else {
                    toastr.error("Internal Error")
                    btnproc('.btn-konfirmasi',0)
                }

	        },
	        error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error on process');
                toastr.error("Internal Error")
                btnproc('.btn-konfirmasi',0)
	        }
	    });
    }

    function next_page() {
        Pace.stop();
      	Pace.bar.render();
        //validation form here

        let page_datakirim = 1;
        if(page == page_datakirim && $('[name="nama_penerima"]').val() == '') {
            $('[name="nama_penerima"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if(page == page_datakirim && $('[name="telp_penerima"]').val() == '') {
            $('[name="telp_penerima"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if(page == page_datakirim && $('[name="email_penerima"]').val() == '') {
            $('[name="email_penerima"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if(page == page_datakirim && $('[name="alamat_penerima"]').val() == '') {
            $('[name="alamat_penerima"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }

        let page_ongkir = 2;
        if(page == page_ongkir && $('[name="layanan"]').val() == '') {
            $('[name="layanan"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if(page == page_ongkir && $('[name="kirim"]').val() == '') {
            $('[name="kirim"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }

        if(page == page_ongkir && $('[name="provinsi"]').val() == '' && $('#kirim').val() == 'GX0002') {
            $('[name="provinsi"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if(page == page_ongkir && $('[name="kota"]').val() == '' && $('#kirim').val() == 'GX0002') {
            $('[name="kota"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if(page == page_ongkir && $('[name="kurir"]').val() == '' && $('#kirim').val() == 'GX0002') {
            $('[name="kurir"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if(page == page_ongkir && $('[name="service"]').val() == '' && $('#kirim').val() == 'GX0002') {
            $('[name="service"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }
        if (page == page_ongkir) {
          gethargalayanan()
        }

        let page_bank = 3;
        if(page == page_bank && $('[name="bank"]').val() == '') {
            $('[name="bank"]').focus()
            toastr.warning("Lengkapi Data")
            return false
        }

        if(page != maxpage) {
            page = page + 1
            $(`.step`).hide()
        }

        if(page == maxpage) {
            $('.btn-next').addClass('invisible')
            load_konfirmasi()
        } else {
            $('.btn-next').removeClass('invisible')
        }

        let b = $('#biaya').val()
        let bykirim = b.length == 0 ? 0 : parseInt(b)
        let tot_cart = $('#carttotal').val()
        $('.bykirim').html(`Rp.${numeral(bykirim).format('0,0')}`)
        let t = bykirim + parseInt(tot_cart)
        $('.totbiaya').html(`Rp.${numeral(t).format('0,0')}`)
        $(`.step-${page}`).show()

        Pace.start()
        btn_direct()
    }

    function prev_page() {
        Pace.stop();
      	Pace.bar.render();
        if(page != minpage) {
            page = page - 1
            $(`.step`).hide()
        }
        $(`.step-${page}`).show()
        Pace.start();
        btn_direct()
    }

    function initstep() {
        $(`.step-2`).hide()
        $(`.step-3`).hide()
        $(`.step-4`).hide()
        $(`.step-5`).hide()
    }

    function load_konfirmasi()
    {
      $('#k_namakirim').html($('[name="namakirim"]').val())
      $('#k_hpkirim').html($('[name="hpkirim"]').val())
      $('#k_nama_penerima').html($('[name="nama_penerima"]').val())
      $('#k_telp_penerima').html($('[name="telp_penerima"]').val())
      $('#k_email_penerima').html($('[name="email_penerima"]').val())
      $('#k_alamat_penerima').html($('[name="alamat_penerima"]').val())
      $('#k_provinsi').html($('[name="provinsi"] option:selected').html())
      $('#k_kota').html($('[name="kota"] option:selected').html())
      $('#k_berattotal').html($('[name="berattotal"]').val() + ' kg')
      $('#k_biaya').html('Rp ' + numeral($('[name="biaya"]').val()).format('0,0'))
      $('#k_kodekurir').html($('[name="kodekurir"]').val())
      $('#k_kurir').html($('[name="kurir"]').val())
      $('#k_kirim').html($('[name="kirim"] option:selected').html())
      $('#k_layanan').html($('[name="layanan"] option:selected').html())
      $('#k_hargalayanan').html('Rp '+ numeral($('#hargalayanan').val()).format('0,0'))
      $('#k_ket').html($('[name="ket"]').val())
      $('#k_bank').html($('[name="bank"] option:selected').html())
      $('#k_norek').html($('#norek').html())
      $('#k_total').html('Rp '+ numeral($('#carttotal').val()).format('0,0'))
      let biayakirim      = ($('[name="biaya"]').val() == '' | $('[name="biaya"]').val() == null) ? 0 : $('[name="biaya"]').val()
      let totalcart       = $('#carttotal').val()
      let hargalayanan    = $('#hargalayanan').val()
      $('#k_totalbayar').html('Rp '+ numeral(parseInt(totalcart) + parseInt(biayakirim) + parseInt(hargalayanan)).format('0,0'))
      if ($('#kirim').val() == 'GX0002') {
        //kirim
        $('#visible_cod').addClass('invisible');
        $('#visible_kirim').removeClass('invisible');
        $('#k_alamat_Kirim').html($('#alamatkirim').val());
      } else {
        //cod
        $('#visible_cod').removeClass('invisible');
        $('#visible_kirim').addClass('invisible');
        $('#k_alamat_cod').html($('#alamatcod').val());
      }
    }

    function gettotal() {
        $.ajax({
          url: `<?php echo base_url() ?>cart/totalcart`,
          type: "GET",
          dataType: "JSON",
          data: {},
          success: function(data) {
            total_cart(data.total_harga)
            $('#berattotal').val(data.berattotal)
            $('#carttotal').val(data.total_harga)
            // $('#carttotal').val(data.total_price)
          },
          error: function(jqXHR, textStatus, errorThrown) {
                console.log('gagal')
          }
      });
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
              { "render" : (data,type,row,meta) => { return `${showimage(row.image)}` }},
              { "data": "name" },
              { "render" : (data,type,row,meta) => { return `${numeral(row.price).format('0,0')}` }},
              { "render" : (data,type,row,meta) => { return `<input style="height : 30px !important; width : 30px !important;" id="qty-${row.rowid}" type="text" value="${row.qty}">` }},
              { "render" : (data,type,row,meta) => { return `${numeral(row.subtotal).format('0,0')}` }},
          ]
      });
    }

    function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
    }

    function btn_direct(){
        if(page == maxpage){
            $('.btn-next').addClass('invisible')
        } else {
            $('.btn-next').removeClass('invisible')
        }
        if(page == minpage){
            $('.btn-prev').addClass('invisible')
        } else {
            $('.btn-prev').removeClass('invisible')
        }

    }

    function changekirim() {
        $('#alamatcod').val('')
        $('#alamatcod').val('')
        let kode = $('#kirim').val();
        let label = $('#kirim option:selected').html();
        if ((kode == 'GX0002') || (label == 'kurir')) {
            $('.box-kurir').removeClass('invisible');
            $('.box-cod').addClass('invisible');
        } else {
            $('.box-kurir').addClass('invisible');
            $('.box-cod').removeClass('invisible');
            $('.input-kurir').val('');
            $('.kelaskota').remove('')
            $('.kelasservice').remove('')
        }
    }

    function getbank() {
        $(`#bank`).attr('readonly', true);
        $.ajax({
	        url: `<?php echo base_url() ?>billing/getbank`,
	        type: "GET",
	        dataType: "JSON",
	        success: function(data) {
                let arr = data;
                getselect('#bank', 'kelasbank', 'kode', 'nama',arr)
                $(`#bank`).attr('readonly', false);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error on process');
                $(`#bank`).attr('readonly', false);
	        }
	    });
    }

    function getlayanan() {
        $(`#layanan`).attr('readonly', true);
        $.ajax({
            url: `<?php echo base_url() ?>billing/getlayanan`,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let arr = data;
                getselect('#layanan', 'kelaslayanan', 'kode', 'nama',arr)
                $(`#layanan`).attr('readonly', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error on process');
                $(`#bank`).attr('readonly', false);
            }
        });
    }

    function getkirim() {
        $(`#kirim`).attr('readonly', true);
        $.ajax({
            url: `<?php echo base_url() ?>billing/getkirim`,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let arr = data;
                getselect('#kirim', 'kelaskirim', 'kode', 'nama',arr)
                $(`#kirim`).attr('readonly', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error on process');
                $(`#kirim`).attr('readonly', false);
            }
        });
    }


    function getprov() {
	    $(`#provinsi`).attr('readonly', true);
        $.ajax({
	        url: `<?php echo base_url() ?>billing/getprov`,
	        type: "GET",
	        dataType: "JSON",
	        success: function(data) {
                let arr = data.rajaongkir.results;
                getselect('#provinsi', 'kelasprov', 'province_id', 'province',arr)
                $(`#provinsi`).attr('readonly', false);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error on process');
                $(`#provinsi`).attr('readonly', false);
	        }
	    });
    }

    function getnorek() {
      if ($('#bank').val() != '' | $('#bank').val() != null) {
        setTimeout(function(){
          $.ajax({
              url: `<?php echo base_url() ?>billing/getnorek`,
              type: "GET",
              dataType: "JSON",
              data : {
                kode : $('#bank').val()
              },
              success: function(data) {
                  $('#norek').html(data.norek)
                  $('#atasnama').html(data.ket)
              }
          });
        })
      }
    }

    function gethargalayanan(){
        $.ajax({
            url: `<?php echo base_url() ?>billing/gethargalayanan`,
            type: "GET",
            dataType: "JSON",
            data : {
              kode : $('#layanan').val()
            },
            success: function(data) {
              $('#hargalayanan').val(data.harga)
            }
        });
    }

    function changecity(){
        $('#biaya').val('')
        $('#kurir').val('')
        $('#kodekurir').val('')
        $('#service').val('')
        $('.kelasservice').remove('')
    }

    function getcity() {
        $('#biaya').val('')
        $('#kodekurir').val('')
        $('#service').val('')
        let kodeprovinsi = $(`#provinsi`).val()
        $(`#kota`).attr('readonly', true);
        if ($('#provinsi').val().length != 0) {
            $.ajax({
                url: `<?php echo base_url() ?>billing/getcity?provincecode=${kodeprovinsi}`,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    let arr = data.rajaongkir.results;
                    getselect('#kota', 'kelaskota', 'city_id', 'city_name', arr)
                    $(`#kota`).attr('readonly', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error on process');
                    $(`#kota`).attr('readonly', false);
                }
            });
        } else {
            console.log('empty')
        }

    }

    function getdist() {
        $('#biaya').val('')
        $('#kodekurir').val('')
        $('#service').val('')
        let kodecity = $(`#kota`).val()
        $(`#kecamatan`).attr('readonly', true);
        if ($('#kota').val().length != 0) {
            $.ajax({
                url: `<?php echo base_url() ?>billing/getdist?citycode=${kodecity}`,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    let arr = data.rajaongkir.results;
                    getselect('#kecamatan', 'kelaskecamatan', 'subdistrict_id', 'subdistrict_name', arr)
                    $(`#kecamatan`).attr('readonly', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error on process');
                    $(`#kecamatan`).attr('readonly', false);
                }
            });
        } else {
            console.log('empty')
        }

    }

    function getservice() {
        let kodekurir       = $(`#kurir`).val()
        let kodekota        = $(`#kecamatan`).val()
        $(`#service`).attr('readonly', true);
        $.ajax({
	        url: `<?php echo base_url() ?>billing/getongkir?destination=${kodekota}&kurir=${kodekurir}`,
	        type: "GET",
	        dataType: "JSON",
	        success: function(data) {
                let arr = data.rajaongkir.results[0].costs;
                getselect('#service', 'kelasservice', 'service', 'description', arr)
                $(`#arr_service`).val(JSON.stringify(arr));
	            $(`#service`).attr('readonly', false);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error on process');
                $(`#service`).attr('readonly', false);
	        }
	    });
    }

    function getongkir() {
        $('#biaya').val('')
        $('#kodekurir').val('')
        if ($('#service').val() != '') {
            let arr = $(`#arr_service`).val()
            let arr_parse = JSON.parse(arr)
            let i = _.findIndex(arr_parse, {
                'service': $('#service').val(),
            })
            let ongkos  = (arr_parse[i].cost[0].value);
            let etd     = (arr_parse[i].cost[0].etd);
            let berattotal = $('#berattotal').val()
            $('#biaya').val(ongkos * berattotal)
            $('#kodekurir').val(arr_parse[i].service)
        }
    }

    function getselect(prop, classoption, val, caption, arr) {
	      $(`${prop}`).after(function() { $(`.${classoption}`).remove() });
		    $(`${prop}`).val('');
        $(`${prop}`).trigger('change');
        // $(`${prop}`).append(`<option class="${classoption}" value="">-</option>`);
        $.each(arr, function (i, v) {
            $(`${prop}`).append(`<option class="${classoption}" value="${v[val]}">${v[caption]}</option>`);
        })
	}



  //  <div class="container step step-4">
  //   <table class="table-custom" id="table" style="width :100% !important; overflow-x:auto !important;">
  //       <thead>
  //           <tr>
  //               <th>Item</th>
  //               <th>Product</th>
  //               <th>Harga</th>
  //               <th>Jumlah</th>
  //               <th>Subtotal</th>
  //           </tr>
  //       </thead>
  //       <tbody class="body-tb">
  //       </tbody>
  //       <tfoot>
  //           <tr class="tr-total">
  //               <td></td>
  //               <td></td>
  //               <td></td>
  //               <td align="center">Total</td>
  //               <td class="total-cart"> </td>
  //           </tr>
  //           <tr class="tr-total">
  //               <td></td>
  //               <td></td>
  //               <td></td>
  //               <td align="center">Biaya Kirim</td>
  //               <td class="bykirim"> </td>
  //           </tr>
  //           <tr class="tr-total">
  //               <td></td>
  //               <td></td>
  //               <td></td>
  //               <td align="center">Total Biaya</td>
  //               <td class="totbiaya"> </td>
  //           </tr>
  //       </tfoot>
  //   </table>
  // </div>

  // function load_cart() {
  //     $('.tr-tb').remove();
  //     $.ajax({
  //       url: `<?php echo base_url() ?>cart/content_cart`,
  //       type: "GET",
  //       dataType: "JSON",
  //       data: {},
  //       success: function(data) {
  //         arr_barang = data;
  //         $.each(data.data, function( i, v ) {
  //             $('.body-tb').append(`
  //                 <tr class="tr-tb fadeIn animated">
  //                     <td align="center">${showimage(v.image)}</td>
  //                     <td>${v.name}</td>
  //                     <td align="right">Rp. ${numeral(v.price).format('0,0')}</td>
  //                     <td align="center">${v.qty}</td>
  //                     <td align="right">Rp. ${numeral(v.subtotal).format('0,0')}</td>
  //                 </tr>
  //             `)
  //
  //         });
  //         total_cart(data.total_price)
  //         $('#berattotal').val(data.berattotal)
  //         $('#carttotal').val(data.total_price)
  //       },
  //       error: function(jqXHR, textStatus, errorThrown) {
  //             console.log('gagal')
  //       }
  //   });
  // }

</script>

</html>
