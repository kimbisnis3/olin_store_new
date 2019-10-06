<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contactus extends CI_Controller
{
    public $table       = 'tcontactus';
    public $foldername  = '';
    public $menuaktif   = 'contactus';
    public $indexpage   = 'contactus/v_contactus';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function index()
    {
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

    public function savedata()
    {
        $d['nama']      = $this->input->post('nama');
        $d['email']     = $this->input->post('email');
        $d['alamat']    = $this->input->post('alamat');
        $d['hp']        = $this->input->post('hp');
        $d['pesan']     = $this->input->post('pesan');

        $result = $this->dbtwo->insert($this->table,$d);
        $r['sukses'] = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}
