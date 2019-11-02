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
        $data['ss_about']       = $this->db->get_where('tconfigimage', array('tipe' => 'ss_about'))->result();
        $data['tx_about_head']  = $this->db->get_where('tconfigtext', array('kode' => 'tx_about_head'))->row();
        $data['tx_about_body']  = $this->db->get_where('tconfigtext', array('kode' => 'tx_about_body'))->row();
        $data['tx_link_alamat'] = $this->db->get_where('tconfigtext', array('kode' => 'tx_link_alamat'))->row();
        $data['tx_link_wa']     = $this->db->get_where('tconfigtext', array('kode' => 'tx_link_wa'))->row();
        $data['tx_link_wa']     = $this->db->get_where('tconfigtext', array('kode' => 'tx_link_wa'))->row();
        $data['tx_link_map']    = $this->db->get_where('tconfigtext', array('kode' => 'tx_link_map'))->row();

        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }
}
