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

    function ceksess()
    {
        // print_r($this->session->userdata());
        // print_r($this->cart->contents());
        $harga = $this->h_getsumharga($this->cart->contents(), 'GX0002', 'qty');
        print_r($harga);
    }

    public function h_getsumharga($arr, $barang, $key)
    {
      $list = [];
      foreach ($arr as $i => $r) {
          if ($r['kode'] == $barang) {
            $row[$key] = $r[$key];
            $list[] = $row;
          }
      }
      $sum_harga = array_column($list, $key);
      return array_sum($sum_harga);
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
