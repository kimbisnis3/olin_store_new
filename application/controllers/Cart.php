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

    function content_cart()
    {
        $berat = 0;
        foreach($this->cart->contents() as $i => $v) {
            $berat += ceil($v['berat']) * $v['qty'];
        }
        $result = $this->cart->contents();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['name']    = $r['name'];
            $row['price']   = $r['price'];
            $row['harga']   = $r['harga'];
            $row['diskon']  = $r['diskon'] * $r['qty'];
            $row['kodepromo']= $r['kodepromo'];
            $row['image']   = $r['image'];
            $row['qty']     = $r['qty'];
            $row['berat']   = $r['berat'] * $r['qty'];
            $row['sub_total_after'] = $r['subtotal'] - ($r['diskon'] * $r['qty']);
            $row['subtotal']= $r['subtotal'];
            $row['id']      = $r['id'];
            $row['kode']    = $r['kode'];
            $row['rowid']   = $r['rowid'];
            $list[] = $row;
        }
        //total diskon cart
        $sum_diskon = 0;
        foreach($this->cart->contents() as $i => $v) {
            $sum_diskon += ($v['diskon'] * $v['qty']);
        }
        //total harga cart
        // $sum_harga = 0;
        // foreach($this->cart->contents() as $i => $v) {
        //     $sum_harga += ($v['harga'] * $v['qty']);
        // }
        echo json_encode(
            array(
                'data'        => $list,
                'total_items' => $this->cart->total_items(),
                'total_price' => $this->cart->total(),
                // 'total_price' => $this->cart->total() - $sum_diskon,
                // 'total_harga' => $sum_harga - $sum_diskon,
                'berattotal'  => $berat
        ));
    }

    function update()
    {
        $rowid  = $this->input->post('rowid');
        $jumlah = $this->input->post('jumlah');
        //koding get new harga new harga every update
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

    public function getharga()
    {
        $ref_cust = '000000000004';
        $ref_brg  = 'GX0002';
        $tgl      = '13 Nov 2019';
        $qty      = '16';
        $harga    = $this->h_proses($ref_cust, $ref_brg, $tgl, $qty);
        print_r($harga);
    }

    public function h_proses($ref_cust, $ref_brg, $tgl, $qty)
    {
        $barang   = $this->db->get_where('msatbrg',
          array(
            'ref_brg' => $ref_brg,
            'def'     => 't',
          ))->row();
        $minorder   = $barang->minorder;
        $get_harga  = $barang->harga;
        $get_harga1 = $barang->harga1;

        $cek = $this->h_cekorder($ref_cust, $ref_brg);
        if ($cek <= 0) {
          $this->h_entrybaru($ref_cust, $ref_brg);
        }

        $jml = $this->h_hitung_order($ref_cust, $ref_brg, $tgl);
        if ($jml <= 0) {
          $this->h_resethandler($ref_cust, $ref_brg);
        }

        $current_qty = $this->h_curr_qty($ref_cust, $ref_brg);
        $new_qty     = $qty;
        if (($current_qty + $new_qty) >= $minorder) {
          $harga = $get_harga1;
        } elseif (($current_qty + $new_qty) < $minorder) {
          $harga = $get_harga;
        }
        return $harga;
    }

    public function h_cekorder($ref_cust, $ref_brg)
    {
        $w['ref_cust']  = $ref_cust;
        $w['ref_brg']   = $ref_brg;
        $num_rows       = $this->db->get_where('thandlerorder',$w)->num_rows();
        return $num_rows;
    }

    public function h_curr_qty($ref_cust, $ref_brg)
    {
        $w['ref_cust']  = $ref_cust;
        $w['ref_brg']   = $ref_brg;
        $result = $this->db->get_where('thandlerorder',$w)->row();
        return $result->order;
    }

    public function h_entrybaru($ref_cust, $ref_brg)
    {
        $d['ref_cust']  = $ref_cust;
        $d['ref_brg']   = $ref_brg;
        $d['order']     = 0;
        $result = $this->db->insert('thandlerorder',$d);
        return $result;
    }

    public function h_updatehandler($ref_cust, $ref_brg, $qty)
    {
        $w['ref_cust']  = $ref_cust;
        $w['ref_brg']   = $ref_brg;
        $curr           = $this->db->get_where('thandlerorder',$w)->row();
        $current_qty    = $curr->order;
        $new_qty        = $current_qty + $qty;
        $d['order']     = $new_qty;
        $result         = $this->db->update('thandlerorder',$d,$w);
        return $result;
    }

    public function h_resethandler($ref_cust, $ref_brg)
    {
        $w['ref_cust']  = $ref_cust;
        $w['ref_brg']   = $ref_brg;
        $d['order']     = 0;
        $result = $this->db->update('thandlerorder',$d,$w);
        return $result;
    }

    public function h_hitung_order($kodecust, $kodebrg, $tgl)
    {
        $tglstart = date('Y-m-d', strtotime("-30 day", strtotime($tgl))); //tgl minus 30 days;
        $tglend   = date('Y-m-d', strtotime($tgl));
        $q = "SELECT
              	*
              FROM
              	xorderd
              LEFT JOIN xorder ON xorder.kode = xorderd.ref_order
              WHERE
              	xorder.ref_cust = '$kodecust'
              AND xorderd.ref_brg = '$kodebrg'
              AND xorder.tgl BETWEEN '$tglstart' AND '$tglend'
              ORDER BY xorder.tgl DESC";
        $jumlah         = $this->db->query($q)->num_rows();
        $row            = $this->db->query($q)->row_array();
        $data['jumlah'] = $jumlah;
        $data['row']    = $row;
        return $data;
    }

    public function cek_order()
    {
        $minorder   = 17;
        $kodecust   = '000000000004';
        $kodebrg    = 'GX0002';
        $tgl        = '2019-10-08';
        $hitungorder  = $this->hitung_order($kodecust, $kodebrg, $tgl);
        $jml          = $hitungorder['jumlah'];
        $loop = '';
        for ($i = 0; $i < 30; $i++) {
          $abc = new $this->hitung_order($kodecust, $kodebrg, $tgl);
          $jml          = $abc['jumlah'];
          $tgl          = $abc['row']['tgl'];
          $loop[$i] = $abc['row']['tgl'];
          // echo "tgl : ".$tgl. "<br />jml : " . $jml . "<br />".$i."<br /> <br />";
        }

        echo json_encode($loop);
    }

    function update_promo()
    {
      $kodepromo  = $this->input->post('promo_kode');
      $rowid      = $this->input->post('promo_rowid');
      $kodebrg    = $this->input->post('promo_kodebrg');
      $qty        = $this->input->post('promo_qty');
      $ref_cust   = $this->session->userdata('kodecust');
      //cek kode
      $q = "SELECT mpromodiskon.* FROM mpromodiskon";
      $q .= " WHERE mpromodiskon.kode = '$kodepromo'";
      $q .= " AND mpromodiskon.ref_cust = '$ref_cust'";
      $q .= " AND mpromodiskon.ref_brg = '$kodebrg'";
      $q .= " AND $qty >= mpromodiskon.minorder";
      $q .= " AND mpromodiskon.aktif = TRUE";
      $result = $this->db->query($q)->row();

      if (count($result) > 0) {
        $data = array(
            'rowid'     => $rowid,
            'diskon'    => $result->nominal,
            'kodepromo' => $result->kode,
        );
        $res = $this->cart->update($data);
        echo json_encode(
          array(
            // 'result' => $res,
            'status' => 'success',
            'msg' => 'Kode Promo Diterapkan',
          )
        );
      } else {
        echo json_encode(
          array(
            // 'result' => $res,
            'status' => 'fail',
            'msg' => 'Kode Promo Tidak Tersedia',
          )
        );
      }
    }

    function delete_promo()
    {
      $rowid      = $this->input->post('promo_rowid');
      $data = array(
          'rowid'     => $rowid,
          'diskon'    => 0,
          'kodepromo' => '',
      );
      $res = $this->cart->update($data);
      if ($res) {
        echo json_encode(
          array(
            'status' => 'success',
            'msg' => 'Kode Promo Dihapus',
          )
        );
      }
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
