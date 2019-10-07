<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'home';
    public $indexpage   = 'home/v_home';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function index()
    {
        // $data['gb_before'] = $this->db->get_where('tconfigimage', array('kode' => 'gb_before'))->row();
        // $data['gb_after']  = $this->db->get_where('tconfigimage', array('kode' => 'gb_after'))->row();
        // $data['gb_big']    = $this->db->get_where('tconfigimage', array('kode' => 'gb_big'))->row();
        // $data['icon1']     = $this->db->get_where('tconfigimage', array('kode' => 'icon1'))->row();
        // $data['icon2']     = $this->db->get_where('tconfigimage', array('kode' => 'icon2'))->row();
        // $data['icon3']     = $this->db->get_where('tconfigimage', array('kode' => 'icon3'))->row();
        // $data['icon4']     = $this->db->get_where('tconfigimage', array('kode' => 'icon4'))->row();
        // $data['icon5']     = $this->db->get_where('tconfigimage', array('kode' => 'icon5'))->row();
        // $data['ss']        = $this->db->get_where('tconfigimage', array('kode' => 'ss'))->result();
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
                msatbrg.def = 't'";
        $data['produk']  = $this->db->query($q)->result();
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

}
