<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<style media="screen">
.table-custom td,
.table-custom th {
        padding: .4rem !important;
        font-size: 1rem !important;
}
</style>
<body class="fadeIn animated">
  <?php $this->load->view('_partials/topbar.php'); ?>
  <div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-hijau"></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="box-body pad">
            <form id="form-data">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Pesanan</label>
                        <input type="hidden" name="kode">
                        <div class="input-group">
                          <input type="text" class="form-control" name="ref_order" readonly="true">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" onclick="open_order()"><i class="fa fa-table"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Total</label>
                        <input type="text" class="form-control" name="total" readonly="true">
                        <input type="text" class="form-control invisible" name="kurang" readonly="true">
                      </div>
                      <div class="form-group">
                        <label>Jenis Bayar</label>
                        <select class="form-control select2" name="ref_jenbayar" onchange="jenisbayar()">
                          <option value=""> - </option>
                          <?php foreach ($jenisbayar as $i => $v): ?>
                          <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                          <?php endforeach ?>
                        </select>
                        <input type="hidden" class="form-control" name="ref_jenbayar_mask">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control datepicker" name="tgl">
                      </div>
                      <div class="form-group">
                        <label>Bayar</label>
                        <input type="number" class="form-control" name="bayar" id="bayar">
                      </div>
                      <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="ket">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-oren btn-flat" data-dismiss="modal">Batal</button>
          <button type="button" id="btnSave" onclick="savedata()" class="btn btn-biru btn-flat">Simpan</button>
        </div>
      </div>
    </div>
    </div>  <!-- END MODAL INPUT-->
    <div class="modal fade" id="modal-order" role="dialog" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Daftar Order</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
                <div class="table-responsive mailbox-messages">
                  <table id="table-order" class="table-custom" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Ref Cust</th>
                        <th>Agen</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Dibayar</th>
                        <th>Kurang</th>
                        <th>Keterangan</th>
                        <th>Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
      </div>  <!-- END MODAL ORDER-->

      <section class="pt-1 mt-3">
        <div class="container">
          <button class="btn btn-teal btn-flat" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</button>
        </div>
      </section>
      <section class="p-3 mb-5">
        <div class="container">
          <div class="table-responsive">
            <table id="table" class="table-custom" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th></th>
                  <th width="5%">No</th>
                  <th>ID</th>
                  <th>Kode</th>
                  <th>Posted</th>
                  <th>Tanggal</th>
                  <th>Agen</th>
                  <th>Kode PO</th>
                  <th>Jenis Bayar</th>
                  <th>Bayar</th>
                  <th>Keterangan</th>
                  <th>Bank</th>
                  <th>No. Rekening</th>
                  <th>Kode Unik</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
      </div>
      </section>
      <?php $this->load->view('_partials/foot.php'); ?>
    </body>
<script src="<?php echo base_url()?>assets/pace/pace.js"></script>
<script>
    var path = 'payment';
    var apiurl = "<?php echo base_url('') ?>" + path;
    $(document).ready(function() {
        maindata()
    })

    function jenisbayar() {
      let ref_jenbayar = $('[name="ref_jenbayar"]').val()
      let total = $('[name="kurang"]').val()
      if (ref_jenbayar == 'GX0003') {
        $('#bayar').val(total / 2)
      } else if (ref_jenbayar == 'GX0001') {
        $('#bayar').val(total)
      }
    }

    function maindata() {
        table = $('#table').DataTable({
            "processing": true,
            "createdRow": function (row, data, dataIndex) {
                if (data.posted == "t") {
                    $(row).addClass('uni-green');
                } else {
                    $(row).addClass('uni-red');
                }
            },
            "ajax": {
                "url": `${apiurl}/getall`,
                "type": "POST",
                "data": {},
            },
            "columns": [
                { "data": "id", "visible" : false },
                { "data": "id", "note" : "numbers" },
                { "data": "id" , "visible" : false},
                { "data": "kode" , "visible" : false},
                { "data": "posted" , "visible" : false},
                { "data": "tgl" },
                { "data": "mcustomer_nama" , "visible" : false },
                { "data": "ref_jual" },
                { "data": "mjenbayar_nama" },
                { "data": "bayar" },
                { "data": "ket" },
                { "data": "bank_nama" },
                { "data": "norek" },
                { "data": "kodeunik" },
            ]
        });

        table.on('order.dt search.dt', function () {
            table.column(1, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        $('#table tbody').on('click', '.odd', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                idx = -1;
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                if (table.row(this).index() > -1) {
                    idx = table.row(this).index();
                }
            }
        });

        $('#table tbody').on('click', '.even', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                idx = -1;
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                if (table.row(this).index() > -1) {
                    idx = table.row(this).index();
                }
            }
        });

        $('#table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                format(row.child, row.data());
                tr.addClass('shown');
            }
        });
    }

    function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
    }

    function add_data() {
        state = 'add';
        $('#form-data')[0].reset();
        setMonth('tgl',0);
        if ('<?php echo $this->session->userdata('ref_jenc') ?>' == '2019000003' )
        {
          //customer biasa
          $('[name="ref_jenbayar"]').val('GX0001')
          $('[name="ref_jenbayar"]').attr('disabled', true)
          $('[name="bayar"]').attr('readonly', true)
        } else {
          //reseller
          $('[name="ref_jenbayar"]').val(null)
          $('[name="ref_jenbayar"]').attr('disabled', false)
          $('[name="bayar"]').attr('readonly', false)
        }
        $('#modal-data').modal('show');
        $('.modal-title').text('Pembayaran');
    }

    function edit_data() {
      kode = table.cell(idx, 3).data();
      let validasiValue = table.cell(idx, 4).data();
      if (validasiValue == 't') {
        // showNotif('Perhatian', 'Data Sudah Tervalidasi', 'warning')
        toastr.warning("Data Sudah Tervalidasi")
        return false;
      }
      if (idx == -1) {
        return false;
      }
      state = 'update';
      $('#form-data')[0].reset();
      $.ajax({
        url: `${apiurl}/edit`,
        type: "POST",
        data: {
          kode: kode,
        },
        dataType: "JSON",
        success: function (data) {
          $('[name="kode"]').val(data.kode);
          $('[name="ref_cust"]').val(data.ref_cust);
          $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
          $('[name="tgl"]').val(data.tgl);
          $('[name="total"]').val(data.total);
          $('[name="bayar"]').val(data.bayar);
          $('[name="ket"]').val(data.ket);
          $('[name="ref_order"]').val(data.ref_jual);
          $('[name="ref_jenbayar"]').val(data.ref_jenbayar);
          $('.select2').trigger('change');
          $('#modal-data').modal('show');
          $('.modal-title').text('Edit Data');
        },
        error: function (jqXHR, textStatus, errorThrown) {
          toastr.danger("Internal Error")
        }
      });
    }

    function savedata() {
        if (ceknull('ref_order')) { return false }
        if (ceknull('tgl')) { return false }
        if (ceknull('ref_jenbayar')) { return false }
        if (cekzero('bayar')) { return false }

        let ref_jenbayar = $('[name="ref_jenbayar"]').val()
        let total = $('[name="kurang"]').val()

        if (('<?php echo $this->session->userdata('ref_jenc') ?>' == '2019000004') && (ref_jenbayar == 'GX0003') && ($('#bayar').val() < (total / 2))) {
            // showNotif('Perhatian', 'Pembayaran Tidak Boleh Kurang dari 50%', 'danger');
            toastr.warning("Pembayaran Tidak Boleh Kurang dari 50%")
            return false
        }
        $('[name="ref_jenbayar_mask"]').val($('[name="ref_jenbayar"]').val())
        var url;
        $.ajax({
            url: `${apiurl}/savedata`,
            type: "POST",
            data: $('#form-data').serializeArray(),
            dataType: "JSON",
            success: function (data) {
                if (data.sukses == 'success') {
                    $('#modal-data').modal('hide');
                    refresh();
                    // showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success')
                    // showNotif('', 'Kode Unik Anda ' + data.kodeunik, 'success')
                    toastr.success('Data Berhasil Ditambahkan')
                    toastr.success('Kode Unik Anda ' + data.kodeunik)
                } else if (data.sukses == 'fail') {
                    $('#modal-data').modal('hide');
                    refresh();
                    // showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
                    toastr.danger('Internal Error')
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.danger('Internal Error')
            }
        });
    }

    function getbank() {
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

    function setMonth(name, days, tipe = '') {
      if ((tipe == 'min') || (tipe == '')) {
        let date = moment().subtract(days, 'days').format("DD MMM YYYY");
        $('[name="' + name + '"]').val(date)
      } else if (tipe == 'plus') {
        let date = moment().add(days, 'days').format("DD MMM YYYY");
        $('[name="' + name + '"]').val(date)
      }
    }

  function open_order() {
      $('#modal-order').modal('show');
      tableorder = $('#table-order').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/getorder`,
              "type": "POST",
              "data": {}
          },
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button id='pilih-order' class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
          }],
          "columns": [
            { "data": "no" },
            { "data": "id" , "visible" : false},
            { "data": "kode" , "visible" : true},
            { "data": "ref_cust" , "visible" : false},
            { "data": "mcustomer_nama" },
            { "data": "tgl" },
            { "data": "total" },
            { "data": "dibayar" },
            { "data": "kurang" },
            { "data": "ket" },
            { "data": "opsi" },
          ]

      });

      $('#table-order tbody').on('click', '#pilih-order', function() {
            var data = tableorder.row($(this).parents('tr')).data();
            $('[name="ref_cust"]').val(data.ref_cust);
            $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
            $('[name="ref_order"]').val(data.kode);
            $('[name="kurang"]').val(data.kurang);
            $('[name="total"]').val(data.total);
            $('[name="bayar"]').val(parseInt(data.kurang));
            // nilaimax('bayar',data.kurang)
            $('#modal-order').modal('hide');
        });

    }

</script>

</html>
