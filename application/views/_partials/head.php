<?php
    $tx_titlepage = $this->db->get_where('tconfigtext', array('kode' => 'tx_titlepage'))->row();
?>
<head>
    <title><?php echo $tx_titlepage->teks ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="Versatile" />
    <link href="<?php echo base_url() ?>assets/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo base_url() ?>assets/css/style.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo base_url() ?>assets/css/custom.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo base_url() ?>assets/css/font-awesome.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/slick/slick-theme.css"/>
    <link href="<?php echo base_url() ?>assets/twentytwenty/css/twentytwenty-no-compass.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/magnify/css/magnify.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/toastr/toastr.css" />
    <link href="<?php echo base_url() ?>assets/pace/pace.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .selected {
            background-color: #00B5AD !important;
            color: #ffffff !important;
        }
        td.details-control {
            background: url('<?php echo base_url(); ?>assets/details_open.png') no-repeat center center !important;
                cursor: pointer  !important;
        }

        tr.shown td.details-control {
            background: url('<?php echo base_url(); ?>assets/details_close.png') no-repeat center center !important;
        }
        .img-item {
            height: 25vh;
        }
    </style>
</head>
<?php
$d = array(
    'kode_ref'    => session_id(),
);
$this->session->set_userdata($d);
?>
