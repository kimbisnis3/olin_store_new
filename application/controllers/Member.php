<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'member';
    public $indexpage   = 'member/v_member';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
    }

    function index()
    {
        $this->load->view($this->indexpage);
    }

    function getorder()
    {
        
    }
}
