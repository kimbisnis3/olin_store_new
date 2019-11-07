<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'produk';
    public $indexpage   = 'product/v_product';
    public $detailpage  = 'product/v_product_det';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function index()
    {
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
        $q_kategori = "SELECT * FROM mkategori ORDER BY datei";
        $data['product']  = $this->db->query($q)->result();
        $data['ktg']      = $this->db->query($q_kategori)->result();
        $data['banner']   = $this->db->get_where('tconfigimage',array('kode' => 'banner_produk'))->row();
        $data['menuaktif']= $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

    function pr_list()
    {
        $ref_ktg = $this->input->get('q');
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
                mbarang.is_design,
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
            AND mbarang.ref_ktg = '$ref_ktg'";
        $q .= " ORDER BY mbarang.is_design ASC , mbarang.datei desc";
        $data['product'] = $this->db->query($q)->result_array();
        $data['menuaktif'] = $this->menuaktif;
        $data['banner'] = $this->db->get_where('tconfigimage',array('kode' => 'banner_custom' ))->row();
        $this->load->view('product/v_product_list',$data);
    }

    function detail()
    {
        $kode = $this->input->get('q');
        $data['kode'] = $kode;
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
                mbarang.bahan,
                mbarang.dimensi,
                mbarang.kapasitas,
                mbarang.id_prod_lumise,
                msatuan.nama namasatuan,
                mgudang.nama namagudang,
                mmodesign.gambar gambardesign,
                mmodesign.nama namadesign,
                mwarna.colorc kodewarna,
                mwarna.nama warna,
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
            AND mbarang.kode = '$kode'";

        $q_image = "SELECT * FROM mbarangpic WHERE ref_barang = '$kode'";

        $data['pr'] = $this->db->query($q)->row();
        $data['img'] = $this->db->query($q_image)->result();
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->detailpage,$data);
    }

    function detail_image()
    {
        $kode = $this->input->post('kode');
        $q_image = "SELECT * FROM mbarangpic WHERE ref_barang = '$kode'";
        $data = $this->db->query($q_image)->result();
        echo json_encode($data);
    }
}
