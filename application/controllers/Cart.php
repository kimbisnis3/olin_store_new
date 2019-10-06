<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'cart';
    public $indexpage   = 'cart/v_cart';

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

    function add()
    {
        $kode = $this->input->post('kode');
        $q = "SELECT
                msatbrg. ID,
                msatbrg.konv,
                msatbrg.ket,
                msatbrg.harga,
                msatbrg.beratkg,
                msatbrg.def,
                mbarang. ID idbarang,
                mbarang.kode kodebarang,
                mbarang.ket ketbarang,
                mbarang.nama namabarang,
                msatuan.nama namasatuan,
                mgudang.nama namagudang,
                mmodesign.gambar gambardesign,
                mmodesign.nama namadesign,
                mwarna.colorc kodewarna,
                mkategori.nama kategori_nama
            FROM
                msatbrg
            LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
            LEFT JOIN mkategori ON mkategori.kode = mbarang.ref_ktg
            LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
            LEFT JOIN mmodesign ON mmodesign.kode = mbarangs.model
            LEFT JOIN mwarna ON mwarna.kode = mbarangs.warna
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE
                msatbrg.def = 't'
            AND
                mbarang.kode ='$kode'";
        $res = $this->db->query($q)->row();
        $data = array(
            'id'      => $res->kodebarang,
            'qty'     => 1,
            'price'   => $res->harga,
            'name'    => $res->namabarang,
            'image'   => $res->gambardesign,
            'berat'   => $res->beratkg,
        );
        
        $result = $this->cart->insert($data);
        $r['sukses']= $result ? 'success' : 'fail' ;
        $r['total_items']= $this->cart->total_items() ;
        echo json_encode($r);

    }

    function content_cart()
    {
        $berat = 0;
        foreach($this->cart->contents() as $i => $v) {
            $berat += $v['berat'] * $v['qty'];
        }
        echo json_encode(
            array(
                'content'     => $this->cart->contents(), 
                'total_items' => $this->cart->total_items(), 
                'total_price' => $this->cart->total(), 
                'berattotal'  => $berat 
        ));
    }

    function add_try()
    {
        $data = array(
            'id'      => 'GX7777',
            'qty'     => 1,
            'price'   => '20000',
            'name'    => 'Tas Oke',
            'image'   => '/uploads/img1.png'
        );
        $this->cart->insert($data);
    }

    function update()
    {
        $rowid  = $this->input->post('rowid');
        $jumlah = $this->input->post('jumlah');
        if ($rowid === "all") {
            $this->cart->destroy();
        } else {
            $data = array(
                'rowid'   => $rowid,
                'qty'     => $jumlah
            );
            $result = $this->cart->update($data);
            $r['sukses']= $result ? 'success' : 'fail' ;
            $r['total_items']= $this->cart->total_items();
            $r['total_price']= $this->cart->total();
            echo json_encode($r);
        }
    }

    function remove()
    {
        $rowid = $this->input->post('rowid');
        if ($rowid === "all") {
            $this->cart->destroy();
            $r['sukses']=  'success' ;
            $r['respon']=  'Keranjang Berhasil Dikosongkan' ;
            echo json_encode($r);
        } else {
            $data = array(
                'rowid'   => $rowid,
                'qty'     => 0
            );
            $result = $this->cart->update($data);
            $r['sukses']= $result ? 'success' : 'fail' ;
            $r['respon']=  'Produk Berhasil Dihapus Dari Keranjang' ;
            $r['total_items']= $this->cart->total_items();
            $r['total_price']= $this->cart->total();
            echo json_encode($r);
        }
    }
}
