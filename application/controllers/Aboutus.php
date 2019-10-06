<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aboutus extends CI_Controller
{
    public $table       = 'tconfigimage';
    public $foldername  = '';
    public $menuaktif   = 'aboutus';
    public $indexpage   = 'aboutus/v_aboutus';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function index()
    {
        $w['tipe'] = 'aboutus';
        $data['data'] = $this->db->get_where($this->table,$w)->row();
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }
}
