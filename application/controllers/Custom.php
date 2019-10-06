<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'custom';
    public $indexpage   = 'custom/v_custom';

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
}
