<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design extends CI_Controller {

    public $menuaktif   = 'design';
    public $indexpage   = 'design/v_design';
    public $detailpage  = 'design/v_design_det';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/dbinclude.php');
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
        $data['pr']         = $this->db->query($q)->result_array();
        $data['menuaktif']  = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

    function start()
    {
        $sess_kode  = $this->session->userdata('kode_ref_design');
        $product_id = $this->input->get('product_id');
        $arr = array('kode_ref_design' => md5(time()));
        if ($sess_kode) {
          redirect(lumise_url().'index.php?product='.$product_id.'&ref='.$sess_kode, 'refresh');
        } else {
          $this->session->set_userdata($arr);
          $sess_kode = $this->session->userdata('kode_ref_design');
          if ($sess_kode) {
              redirect(lumise_url().'index.php?product='.$product_id.'&ref='.$sess_kode, 'refresh');
          }
        }
    }

    function finish()
    {
        $sess_kode  = $this->session->userdata('kode_ref_design');
        $q = "SELECT lumise_order_products.* FROM lumise_order_products LEFT JOIN lumise_orders ON lumise_orders.id = lumise_order_products.order_id  WHERE kode_ref = '$sess_kode' ";
        $result = $this->dblumise->query($q)->result();
        foreach ($result as $i => $v) {
          $product_id = $v->product_id;
          $q        = "SELECT mbarang. ID idbarang, mbarang.kode kodebarang FROM mbarang WHERE id_prod_lumise = '$product_id'";
          $res      = $this->db->query($q)->row();
          $kodebrg  = $res->kodebarang;
          $q_cart   = "SELECT
                          msatbrg.harga,
                          msatbrg.beratkg,
                          mbarang. ID idbarang,
                          mbarang.kode kodebarang,
                          mbarang.nama namabarang,
                          mmodesign.gambar gambardesign
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
                          mbarang.kode ='$kodebrg'";
          $res_cart = $this->db->query($q_cart)->row();
          $data_cart = array(
              'id'      => $res_cart->kodebarang,
              'qty'     => 1,
              'price'   => $res_cart->harga,
              'name'    => $res_cart->namabarang,
              'image'   => $res_cart->gambardesign,
              'berat'   => $res_cart->beratkg,
            );
        }
        $add_cart = $this->cart->insert($data_cart);
        // $r['sukses']      = $add_cart ? 'success' : 'fail' ;
        // $r['total_items'] = $this->cart->total_items() ;
        // echo json_encode($this->cart->contents());
        if ($add_cart) {
          redirect(base_url('cart'));
        }
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

    function ceksess()
    {
        print_r($this->session->userdata());
    }

    function delsess()
    {
        $this->session->unset_userdata('kode_ref_design');
    }


}
