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
        echo json_encode($this->db->get('mlayanan')->result()); 
    }

    function getkirim() {
        echo json_encode($this->db->get('mkirim')->result()); 
    }

    function getbank() {
        $result = $this->db->get('mbank')->result();
        echo json_encode($result); 
    }
    
    function getprov() {
        $response = $this->libre->get_province_ro();
        echo $response; 
    }

    function getcity() {
        $provincecode = $this->input->get('provincecode');
        $response = $this->libre->get_city_ro($provincecode);
        echo $response; 
    }

    function getongkir() {
        $origin         = '445'; //Solo / Surakarta  
        $destination    = $this->input->get('destination'); 
        // $weight         = $this->input->get('weight') * 1000;
        $weight         = 1 * 1000;
        $courier        = $this->input->get('kurir');
        $response = $this->libre->get_ongkir_ro($origin,$destination,$weight,$courier);
        echo $response; 
        
    }
    

}
