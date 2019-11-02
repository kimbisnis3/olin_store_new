<?php

class Login extends CI_Controller{

    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'login';
    public $indexpage   = 'login/v_login';

    function __construct(){
        parent::__construct();
    }

    function index()
    {
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view('login/v_login',$data);
    }

    function auth_process(){
        $username = $this->input->post('user');
        $password = $this->input->post('pass');
            $where = array(
                'aktif'     => 't',
                'user'      => $username,
                'pass'      => md5($password),
                );
            $cek = $this->db->get_where("mcustomer",$where)->num_rows();
            if($cek > 0){
                $this->db->trans_start();
                $q = "SELECT
                        mcustomer.id,
                        mcustomer.kode,
                        mcustomer.nama,
                        mcustomer.alamat,
                        mcustomer.telp,
                        mcustomer.email,
                        mcustomer.aktif,
                        mcustomer.ref_jenc,
                        mcustomer.user,
                        mcustomer.pass,
                        mjencust.nama mjencust_nama
                    FROM
                        mcustomer
                    LEFT JOIN mjencust ON mjencust.kode = mcustomer.ref_jenc
                    WHERE mcustomer.user = '$username'";
                $result = $this->db->query($q)->row();
                $d = array(
                    'status'    => "online",
                    'in'        => TRUE,
                    'id'        => $result->id,
                    'nama'      => $result->nama,
                    'user'      => $result->user,
                    'kodecust'  => $result->kode,
                    'mjencust_nama'=> $result->mjencust_nama,
                    'ref_jenc'  => $result->ref_jenc,
                );
                $this->session->set_userdata($d);
                $this->db->trans_complete();
                $r['status']    = 'success';
                $r['caption']   = 'Sukses';
                $r['msg']       = 'Login Sukses';
                $r['class']     = 'success';
                echo json_encode($r);
            }else{
                $r['status']    = 'fail';
                $r['caption']   = 'Gagal';
                $r['msg']       = 'Username dan Password tidak sesuai';
                $r['class']     = 'danger';
                echo json_encode($r);
            }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }

    function sessdata() {
        $kode = $this->session->userdata('kodecust');
        $q = "SELECT
            mcustomer.id,
            mcustomer.kode,
            mcustomer.nama,
            mcustomer.alamat,
            mcustomer.telp,
            mcustomer.email,
            mcustomer.aktif,
            mcustomer.ref_jenc,
            mcustomer.user,
            mcustomer.pass,
            mjencust.nama mjencust_nama
        FROM
            mcustomer
        LEFT JOIN mjencust ON mjencust.kode = mcustomer.ref_jenc
        WHERE mcustomer.kode = '$kode'
        ";
        $r = $this->db->query($q)->row();
        $result = array(
            'nama'  => $r->nama,
            'alamat'=> $r->alamat,
            'telp'  => $r->telp,
            'email' => $r->email,
            'jeniscust' => $r->mjencust_nama,
        );
        echo json_encode($result);
    }

    function login_try(){
        // print_r(json_encode($this->session->all_userdata()));
        // echo sess_data('status');
        // $d = array(
        //     prefix_sess().'status'    => "online",
        // );
        // $this->session->set_userdata($d);
    }
}
