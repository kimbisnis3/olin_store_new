<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public $table       = 'mcustomer';
    public $foldername  = '';
    public $menuaktif   = 'register';
    public $indexpage   = 'register/v_register';
    public $indexpage2  = 'register/v_register_reseller';

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

    function reseller()
    {
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage2,$data);
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
        $d['dob']       = dfh($this->input->post('dob'));
        $d['jk']        = $this->input->post('jk');
        $d['provkode']  = $this->input->post('provkode');
        $d['provenama'] = $this->input->post('provenama');
        $d['citykode']  = $this->input->post('citykode');
        $d['citynama']  = $this->input->post('citynama');
        $d['keckode']   = $this->input->post('keckode');
        $d['kecnama']   = $this->input->post('kecnama');
        $d['kelkode']   = $this->input->post('kelkode');
        $d['kelnama']   = $this->input->post('kelnama');
        $d['kodepos']   = $this->input->post('kodepos');
        $d['jeniskerja']= $this->input->post('jeniskerja');
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
