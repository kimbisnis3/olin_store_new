<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karir extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'karir';
    public $indexpage   = 'karir/v_karir';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function index()
    {
        // $data['ss_karir']        = $this->db->get_where('tconfigimage', array('kode' => 'ss_karir'))->result();

        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

}
