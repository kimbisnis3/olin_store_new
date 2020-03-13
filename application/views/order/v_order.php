<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
<style media="screen">
.table-custom td,
.table-custom th {
        padding: .4rem !important;
        font-size: 1rem !important;
}
</style>
<div id="modal-konfirmasi" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center><h4 class="modal-title"></h4></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tidak</button>
        <button type="button" id="btnHapus" class="btn btn-danger btn-flat">Ya</button>
      </div>
    </div>
  </div>
</div>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <?php $this->load->view('_partials/topbar') ?>
    <section class="py-1 my-4">
      <div class="container">
        <div class="table-responsive">
          <table id="table" class="table-custom" cellspacing="0" style="width : 100% !important">
            <thead>
              <tr>
                <th width="5%"></th>
                <th width="5%">No</th>
                <th>ID</th>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Agen</th>
                <th>Layanan</th>
                <th>Pengiriman</th>
                <th>Resi</th>
                <th>Ongkir</th>
                <th>Total</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Sudah Bayar</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </section>
    <?php $this->load->view('_partials/foot') ?>
</body>
<script>
    var path = 'order';
    var designUrl = "<?php echo lumise_url() ?>" + 'editor.php';
    var apiurl = "<?php echo base_url('') ?>" + path;
    $(document).ready(function() {
        maindata()
    })

    function maindata() {
        table = $('#table').DataTable({
            "processing": true,
            "ajax": {
                "url": `${apiurl}/getall`,
                "type": "POST",
                "data": {},
            },
            "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": "no" },
            { "data": "id" , "visible" : false},
            { "data": "kode" },
            { "data": "tgl" },
            { "data": "namacust", "visible" : false },
            { "data": "mlayanan_nama" },
            { "data": "mkirim_nama" },
            { "data": "noresi" },
            { "data": "bykirim" },
            { "data": "totalall" },
            { "data": "ket" },
            { "data": "status" },
            { "data": "sdhbayar", "visible" : false },
            { "title" : "Opsi", "width" : "10%", "render" : (data,type,row,meta) =>
            {
               return `<button type="button" class="btn btn-danger btn-flat btn-sm" name="button" onclick="hapus_data(${row.id},${row.sdhbayar})"><i class="fa fa-trash"></i></button>`
            }},
          ]
        });

        // $('#table tbody').on('click', '.odd', function() {
        //     if ($(this).hasClass('selected')) {
        //         $(this).removeClass('selected');
        //         idx = -1;
        //     } else {
        //         table.$('tr.selected').removeClass('selected');
        //         $(this).addClass('selected');
        //         if (table.row(this).index() > -1) {
        //             idx = table.row(this).index();
        //         }
        //     }
        // });
        //
        // $('#table tbody').on('click', '.even', function() {
        //     if ($(this).hasClass('selected')) {
        //         $(this).removeClass('selected');
        //         idx = -1;
        //     } else {
        //         table.$('tr.selected').removeClass('selected');
        //         $(this).addClass('selected');
        //         if (table.row(this).index() > -1) {
        //             idx = table.row(this).index();
        //         }
        //     }
        // });

        $('#table tbody').on('click', 'td.details-control', function() {
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

    function format(callback, data) {
        $.ajax({
            url: `${apiurl}/getdetail`,
            type: "POST",
            data: {
                xorderkode: data.kode
            },
            success: function(response) {
                callback($(response)).show();
                imgError(image)
            },
            error: function() {
                $('#output').html('Bummer: there was an error!');
            }
        });
    }

    function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
    }

    function hapus_data(id, sdhbayar) {
        if (sdhbayar > 0) {
        	toastr.error("Pesanan Tidak Dapat di Void, Sudah Ada Pembayaran")
            return false;
        }
        $('.modal-title').text('Yakin Void Data ?');
        $('#modal-konfirmasi').modal('show');
        $('#btnHapus').attr('onclick', 'delete_data(' + id + ')');
    }

    function delete_data(id) {
        $.ajax({
            url: `${apiurl}/deletedata`,
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(data) {
                $('#modal-konfirmasi').modal('hide');
                if (data.sukses == 'success') {
                    refresh();
                	toastr.success("Data Berhasil Divoid")
                } else if (data.sukses == 'fail') {
                    $('#modal-data').modal('hide');
                    refresh();
                	toastr.error("Data Gagal Divoid")
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error("Internal Error")
            }
        });
    }

    function grab_design(product_id, design_id, order_id) {
      window.open(
        `${designUrl}?product_base=${product_id}&design_print=${design_id}&order_print=${order_id}`,
        `_blank`
      );
    }

</script>
</html>
