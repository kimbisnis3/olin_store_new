<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'custom';
    public $indexpage   = 'custom/v_custom';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function index()
    {
        $data['menuaktif'] = $this->menuaktif;
        $data['banner'] = $this->db->get_where('tconfigimage',array('kode' => 'banner_custom' ))->row();
        $q = "SELECT
              msatbrg. ID,
              msatbrg.konv,
              msatbrg.ket,
              msatbrg.harga,
              msatbrg.def,
              mbarang. ID idbarang,
              mbarang.kode kodebarang,
              mbarang.ket ketbarang,
              mbarang.nama namabarang,
              mbarang.id_prod_lumise,
              msatuan.nama namasatuan,
              mgudang.nama namagudang,
              mmodesign.gambar gambardesign,
              mmodesign.nama namadesign,
              mwarna.colorc kodewarna,
              mkategori.nama kategori_nama
          FROM
              msatbrg
          LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
          LEFT JOIN mkategori ON mkategori.kode = mbarang.ref_ktg
          LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
          LEFT JOIN mmodesign ON mmodesign.kode = mbarangs.model
          LEFT JOIN mwarna ON mwarna.kode = mbarangs.warna
          LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
          LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
          WHERE
              msatbrg.def = 't'
          AND mbarang.ref_ktg = 'GX0003'";
        $data['pr']  = $this->db->query($q)->result_array();
        $this->load->view($this->indexpage,$data);
    }
}
