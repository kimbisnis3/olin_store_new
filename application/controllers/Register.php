<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public $table       = 'mcustomer';
    public $foldername  = '';
    public $menuaktif   = 'register';
    public $indexpage   = 'register/v_register';

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

    function savedata()
    {
        $jencust = ($this->input->post('jencust') == 'res') ? '2019000004' : '2019000003';
        $d['nama']      = $this->input->post('nama');
        $d['alamat']    = $this->input->post('alamat');
        $d['telp']      = $this->input->post('telp');
        $d['email']     = $this->input->post('email');
        $d['pic']       = $this->input->post('pic');
        $d['ket']       = $this->input->post('ket');
        $d['ref_jenc']  = $jencust;
        $d['user']      = $this->input->post('user');
        $d['pass']      = md5($this->input->post('pass'));
        $d['aktif']     = 't';

        $user = $this->db->get_where($this->table,
            array(
                'user' => $d['user'], 
                'pass' => $d['pass'], 
            ))->num_rows();
        if ($user > 0) {
            $r['header']    = 'Gagal' ;
            $r['status']    = 'fail' ;
            $r['msg']       = 'Username Sudah Ada' ;
            $r['class']     = 'danger' ;
            echo json_encode($r);
        } else {
            $result = $this->db->insert($this->table,$d);
            if ($result) {
                $r['header']    = 'Sukses' ;
                $r['status']    = 'success' ;
                $r['msg']       = 'Berhasil' ;
                $r['class']     = 'success' ;
                echo json_encode($r);
            } else {
                $r['header']    = 'Gagal' ;
                $r['status']    = 'fail' ;
                $r['msg']       = 'Berhasil' ;
                $r['class']     = 'danger' ;
                echo json_encode($r);
            }
        }
    }
}
