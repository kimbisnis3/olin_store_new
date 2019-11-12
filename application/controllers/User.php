<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public $table       = 'mcustomer';
    public $foldername  = '';
    public $menuaktif   = 'user';
    public $indexpage   = 'user/v_user';

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

    public function edit()
    {
        $w['kode']  = $this->session->userdata('kodecust');
        $data       = $this->db->get_where($this->table,$w)->row();
        echo json_encode($data);
    }

    function updatedata()
    {
        $w['kode']      = $this->input->post('kode');
        $d['nama']      = $this->input->post('nama');
        $d['telp']      = $this->input->post('telp');
        $d['email']     = $this->input->post('email');
        $d['alamat']    = $this->input->post('alamat');

        if ($this->input->post('pass') != '' || $this->input->post('pass') != null) {
          $d['pass']  = md5($this->input->post('pass'));
        }
        $result = $this->db->update($this->table,$d,$w);
        $sess = array(
            'nama'      => $this->input->post('nama'),
        );
        $this->session->set_userdata($sess);
        $r['status']    = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }
}
