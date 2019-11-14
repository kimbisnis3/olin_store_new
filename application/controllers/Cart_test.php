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
            include(APPPATH.'libraries/db_mysql.php');
        }
    // ------------------TESTING PURPOSE ONLY------------------

    public function tesreset()
    {
        $ref_cust = '000000000004';
        $ref_brg  = 'GX0002';
        $res = $this->h_resethandler($ref_cust, $ref_brg);
        print_r($res);
    }

    public function tesupdate()
    {
        $ref_cust = '000000000004';
        $ref_brg  = 'GX0002';
        $qty      = '16';
        $res = $this->h_updatehandler($ref_cust, $ref_brg, $qty);
        print_r($res);
    }

    function add_try()
    {
        $data = array(
            'id'          => 'GH55667',
            'kode'        => 'GH55667',
            'qty'         => 1,
            'price'       => 20000,
            'harga'       => 20000,
            'diskon'      => 0,
            'kodepromo'   => '',
            'name'        => 'Tas A',
            'image'       => 'kjadjjjekd.jpg',
            'berat'       => 1,
            '_product_id' => '12',
            '_design_id'  => '12',
            '_order_id'   => '7',
        );
        $this->cart->insert($data);
    }

    function update_try()
    {
        $data = array(
            'rowid'     => '9c4a529a21163d651520820d20b74856',
            'kodepromo' => 'zz',
            'qty'       => 1,
        );
        $this->cart->update($data);
    }

    function delete_try()
    {
        $this->cart->destroy();
    }

    // public function h_proses()
    // {
    //     $harga    = '';
    //     $ref_cust = '000000000004';
    //     $ref_brg  = 'GX0002';
    //     $tgl      = '13 Nov 2019';
    //     $qty      = '2';
    //     $barang   = $this->db->get_where('msatbrg',
    //       array(
    //         'ref_brg' => $ref_brg,
    //         'def'     => 't',
    //       ))->row();
    //     $minorder   = $barang->minorder;
    //     $get_harga  = $barang->harga;
    //     $get_harga1 = $barang->harga1;
    //     //cek apakah ada data barang dan customer di dlm tb thandlerorder
    //     $cek = $this->h_cekorder($ref_cust, $ref_brg);
    //     if ($cek <= 0) {
    //       //jika tidak ada
    //       //masukan data baru dgn qty 0
    //       $this->h_entrybaru($ref_cust, $ref_brg);
    //       //jika ada
    //       //hitung order sebulan kebelakang
    //       $jml = $this->h_hitung_order($ref_cust, $ref_brg, $tgl);
    //       if ($jml <= 0) {
    //         //jika tidak ada order sebulan kebelakang reset jumlah order dalam handler karna tidak ada
    //         $this->h_resethandler($ref_cust, $ref_brg);
    //       }
    //       //hitung jml order di dlm tbhandler dan tmbah dgn qty yang baru
    //       $current_qty = $this->h_curr_qty($ref_cust, $ref_brg);
    //       $new_qty     = $qty;
    //       if (($current_qty + $new_qty) >= $minorder) {
    //         //jika jumlah order yg ada di tambah jumlah yg bary > minorder use harga 1(diskon)
    //         $harga = $get_harga1;
    //       } elseif($current_qty + $new_qty) < $minorder) {
    //         //jika jumlah order yg ada di tambah jumlah yg bary < minorder use harga (normal)
    //         $harga = $get_harga;
    //       }
    //     } else {
    //       //jika ada
    //       //hitung order sebulan kebelakang
    //       $jml = $this->h_hitung_order($ref_cust, $ref_brg, $tgl);
    //       if ($jml <= 0) {
    //         //jika tidak ada order sebulan kebelakang reset jumlah order dalam handler karna tidak ada
    //         $this->h_resethandler($ref_cust, $ref_brg);
    //       }
    //       //hitung jml order di dlm tbhandler dan tmbah dgn qty yang baru
    //       $current_qty = $this->h_curr_qty($ref_cust, $ref_brg);
    //       $new_qty     = $qty;
    //       if (($current_qty + $new_qty) >= $minorder) {
    //         //jika jumlah order yg ada di tambah jumlah yg bary > minorder use harga 1(diskon)
    //         $harga = $get_harga1;
    //       } elseif($current_qty + $new_qty) < $minorder) {
    //         //jika jumlah order yg ada di tambah jumlah yg bary < minorder use harga (normal)
    //         $harga = $get_harga;
    //       }
    //     }
    //     return $harga;
    // }



    //SEDANG TIDAK DIPAKAI KARNA SUDAH DI HANDEL DI CONTROLLER DESIGN
    // function add()
    // {
    //     $kode = $this->input->post('kode');
    //     $q = "SELECT
    //             msatbrg. ID,
    //             msatbrg.konv,
    //             msatbrg.ket,
    //             msatbrg.harga,
    //             msatbrg.beratkg,
    //             msatbrg.def,
    //             mbarang. ID idbarang,
    //             mbarang.kode kodebarang,
    //             mbarang.ket ketbarang,
    //             mbarang.nama namabarang,
    //             msatuan.nama namasatuan,
    //             mgudang.nama namagudang,
    //             mmodesign.gambar gambardesign,
    //             mmodesign.nama namadesign,
    //             mwarna.colorc kodewarna,
    //             mkategori.nama kategori_nama
    //         FROM
    //             msatbrg
    //         LEFT JOIN mbarang ON mbarang.kode = msatbrg.ref_brg
    //         LEFT JOIN mkategori ON mkategori.kode = mbarang.ref_ktg
    //         LEFT JOIN mbarangs ON mbarang.kode = mbarangs.ref_brg
    //         LEFT JOIN mmodesign ON mmodesign.kode = mbarangs.model
    //         LEFT JOIN mwarna ON mwarna.kode = mbarangs.warna
    //         LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
    //         LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
    //         WHERE
    //             msatbrg.def = 't'
    //         AND
    //             mbarang.kode ='$kode'";
    //     $res = $this->db->query($q)->row();
    //     $data = array(
    //         'id'      => $res->kodebarang,
    //         'qty'     => 1,
    //         'price'   => $res->harga,
    //         'name'    => $res->namabarang,
    //         'image'   => $res->gambardesign,
    //         'berat'   => $res->beratkg,
    //     );
    //
    //     $result = $this->cart->insert($data);
    //     $r['sukses']= $result ? 'success' : 'fail' ;
    //     $r['total_items']= $this->cart->total_items() ;
    //     echo json_encode($r);
    // }
}
