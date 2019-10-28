<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design extends CI_Controller {

    function __construct() {
        parent::__construct();
        include(APPPATH.'libraries/dbinclude.php');
    }

    function index()
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
                          mmodesign.gambar gambardesign,
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
        $res_cart = $this->db->query($q)->row();
        $data_cart = array(
            'id'      => $res_cart->kodebarang,
            'qty'     => 1,
            'price'   => $res_cart->harga,
            'name'    => $res_cart->namabarang,
            'image'   => $res_cart->gambardesign,
            'berat'   => $res_cart->beratkg,
          );
        }
        $add_cart = $this->cart->insert($data);
        $r['sukses']      = $add_cart ? 'success' : 'fail' ;
        $r['total_items'] = $this->cart->total_items() ;
        echo json_encode($r);
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
