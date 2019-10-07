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
        $data['gb_karir_1']        = $this->db->get_where('tconfigimage', array('kode' => 'gb_karir_1'))->row();
        $data['gb_karir_2']        = $this->db->get_where('tconfigimage', array('kode' => 'gb_karir_2'))->row();
        $data['gb_karir_3']        = $this->db->get_where('tconfigimage', array('kode' => 'gb_karir_3'))->row();

        $data['tx_karir']        = $this->db->get_where('tconfigtext', array('kode' => 'tx_karir'))->row();

        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

}
