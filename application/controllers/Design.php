<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design extends CI_Controller {

    public $menuaktif   = 'design';
    public $indexpage   = 'design/v_design';
    public $detailpage  = 'design/v_design_det';

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/db_mysql.php');
    }

    function start()
    {
        $product_id = $this->input->get('product_id');
        $arr = array('kode_ref_design' => md5(time()));
        $this->session->set_userdata($arr);
        $sess_kode = $this->session->userdata('kode_ref_design');
        redirect(lumise_url().'index.php?product='.$product_id.'&ref='.$sess_kode, 'refresh');
    }

    function finish()
    {
        $sess_kode  = $this->session->userdata('kode_ref_design');
        $q = "SELECT lumise_order_products.* FROM lumise_order_products LEFT JOIN lumise_orders ON lumise_orders.id = lumise_order_products.order_id  WHERE kode_ref = '$sess_kode' ";
        $result = $this->dblumise->query($q)->result();
        $cart_number = count($this->cart->contents());
        $cart_contents = [];
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
          $harga = $res_cart->harga;
          $data_cart = array(
              'id'          => md5(time().$i),//kode unique
              'kode'        => $res_cart->kodebarang,
              'qty'         => 1,
              'price'       => $res_cart->harga,
              'harga'       => $harga,
              'diskon'      => 0,
              'kodepromo'   => '',
              'name'        => $res_cart->namabarang,
              'image'       => $res_cart->gambardesign,
              'berat'       => $res_cart->beratkg,
              '_product_id' => $v->product_id,
              '_design_id'  => $v->design,
              '_order_id'   => $v->order_id,
            );
          $add_cart = $this->cart->insert($data_cart);
        }
        redirect(base_url('cart'));
    }

    function ceksess()
    {
        // print_r($this->session->userdata());
        // print_r($this->cart->contents());
        $sum_diskon = 0;
        foreach($this->cart->contents() as $i => $v) {
            $sum_diskon += ($v['diskon'] * $v['qty']);
        }
        print_r($sum_diskon);
    }

    function setsession()
    {
      $arr = array('kode_ref_design' => md5(time()));
      $this->session->set_userdata($arr);
      $sess_kode = $this->session->userdata('kode_ref_design');
      print_r($sess_kode);
    }

    function delsess()
    {
        $this->session->unset_userdata('kode_ref_design');
    }


}
