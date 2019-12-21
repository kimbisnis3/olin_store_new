<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {

    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'billing';
    public $indexpage   = 'billing/v_billing';

    function __construct() {
        parent::__construct();
        include(APPPATH . 'libraries/sessionakses.php');
    }

    function index() {
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

    function getlayanan() {
        echo json_encode($this->db->get_where('mlayanan',array('aktif' => 't' ))->result());
    }

    function getkirim() {
        echo json_encode($this->db->get('mkirim')->result());
    }

    function getbank() {
        $result = $this->db->get('mbank')->result();
        echo json_encode($result);
    }

    function getprov() {
        $response = $this->libre->get_province_pro();
        echo $response;
    }

    function getcity() {
        $provincecode = $this->input->get('provincecode');
        $response = $this->libre->get_city_pro($provincecode);
        echo $response;
    }

    function getdist() {
        $citycode = $this->input->get('citycode');
        $response = $this->libre->get_dist_pro($citycode);
        echo $response;
    }

    function getongkir() {
        $origin         = '6164'; //Laweyan
        $destination    = $this->input->get('destination');
        $origintype     = 'subdistrict';
        $destinationtype= 'subdistrict';
        // $weight         = $this->input->get('weight') * 1000;
        $weight         = 1 * 1000;
        $courier        = $this->input->get('kurir');
        $response       = $this->libre->get_ongkir_pro($origin, $origintype, $destination, $destinationtype, $weight, $courier);
        echo $response;
    }

    function getnorek() {
        $kode   = $this->input->get('kode');
        $result = $this->db->get_where('mbank',array('kode' => $kode ))->row();
        echo json_encode($result);
    }

    function gethargalayanan() {
        $kode   = $this->input->get('kode');
        $result = $this->db->get_where('mlayanan',array('kode' => $kode ))->row();
        echo json_encode($result);
    }


}
