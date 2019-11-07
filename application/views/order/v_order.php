<!DOCTYPE html>
<html lang="zxx">
<?php $this->load->view('_partials/head') ?>
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
                <th>Keterangan</th>
                <th>Status</th>
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
            { "data": "ket" },
            { "data": "statusorder" }]
        });

        $('#table tbody').on('click', '.odd', function() {
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

        $('#table tbody').on('click', '.even', function() {
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

</script>
</html>
