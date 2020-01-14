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
        include(APPPATH.'libraries/dbinclude.php');
        include(APPPATH.'libraries/db_mysql.php');
    }

    function index()
    {
        $data['menuaktif'] = $this->menuaktif;
        $this->load->view($this->indexpage,$data);
    }

    function add_by_design()
    {
        $sess_kode  = $this->session->userdata('kode_ref_design');
        $q = "SELECT lumise_order_products.* FROM lumise_order_products LEFT JOIN lumise_orders ON lumise_orders.id = lumise_order_products.order_id  WHERE kode_ref = '$sess_kode' ";
        $result = $this->dblumise->query($q)->result();
        $cart_number = count($this->cart->contents());
        $cart_contents = [];
        foreach ($result as $i => $v) {
          $product_id = $v->product_id;
          $q        = "SELECT mbarang. ID idbarang, mbarang.kode kodebarang FROM mbarang WHERE id_prod_lumise = '$product_id'";
          $res      = $this->db->query($q)->row();
          $kodebrg  = $res->kodebarang;
          $ref_cust = $this->session->userdata('kodecust');
          $q_cart   = "SELECT
                          msatbrg.harga,
                          msatbrg.beratkg,
                          mbarang. ID idbarang,
                          mbarang.kode kodebarang,
                          mbarang.nama namabarang,
                          mmodesign.gambar gambardesign
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
                          mbarang.kode ='$kodebrg'";
          $res_cart = $this->db->query($q_cart)->row();
          // $harga = $res_cart->harga;
          $data_cart = array(
              'id'          => md5(time().$i),//kode unique
              'kode'        => $res_cart->kodebarang,
              'qty'         => 1,
              'price'       => $res_cart->harga,
              'harga'       => $harga,
              'diskon'      => 0,
              'kodepromo'   => '',
              'name'        => $res_cart->namabarang,
              'image'       => $res_cart->gambardesign,
              'berat'       => $res_cart->beratkg,
              '_product_id' => $v->product_id,
              '_design_id'  => $v->design,
              '_order_id'   => $v->order_id,
          );
          $add_cart = $this->cart->insert($data_cart);
        }
        if ($this->session->userdata('in') == TRUE) {
          $this->h_diskon();
        }
        redirect(base_url('cart'));
    }

    function content_cart()
    {
        $result = $this->cart->contents();
        $list   = [];
        foreach ($result as $i => $r) {
            $row['name']      = $r['name'];
            $row['price']     = $r['price'];
            $row['harga']     = $r['harga'];
            $row['diskon']    = $r['diskon'] * $r['qty'];
            $row['kodepromo'] = $r['kodepromo'];
            $row['image']     = $r['image'];
            $row['qty']       = $r['qty'];
            $row['berat']     = $r['berat'] * $r['qty'];
            $row['sub_total_after'] = $r['subtotal'] - ($r['diskon'] * $r['qty']);
            $row['subtotal']  = $r['subtotal'];
            $row['subharga']  = $r['harga'] * $r['qty'];
            $row['id']        = $r['id'];
            $row['kode']      = $r['kode'];
            $row['rowid']     = $r['rowid'];
            $list[] = $row;
        }
        echo json_encode(
            array(
                'data'        => $list,
        ));
    }

    function totalcart()
    {
        //total diskon cart
        $sum_diskon = 0;
        foreach($this->cart->contents() as $i => $v) {
            $sum_diskon += ($v['diskon'] * $v['qty']);
        }
        // total harga cart
        $sum_harga = 0;
        foreach($this->cart->contents() as $i => $v) {
            $sum_harga += ($v['harga'] * $v['qty']);
        }
        // total berat cart
        $berat = 0;
        foreach($this->cart->contents() as $i => $v) {
            $berat += ceil($v['berat'] * $v['qty']);
        }
        echo json_encode(
            array(
                'total_items' => $this->cart->total_items(),
                'total_price' => $this->cart->total(),
                'total_harga' => $sum_harga,
                'berattotal'  => $berat
        ));
    }

    function update()
    {
        $rowid    = $this->input->post('rowid');
        $ref_brg  = $this->input->post('ref_brg');
        $ref_cust = $this->session->userdata('kodecust');
        $tgl      = date("d M Y");
        $qty      = $this->input->post('jumlah');
        // update qty
        $data = array(
            'rowid'   => $rowid,
            'qty'     => $qty,
        );
        $result = $this->cart->update($data);
        if ($this->session->userdata('in') == TRUE) {
          $this->h_diskon();
        }
        $r['sukses']  = $result ? 'success' : 'fail';
        echo json_encode($r);
    }

    function h_diskon()
    {
        // KHUSUS MEMBER LOGIN
        $tgl      = date("d M Y");
        $minorder = 17;
        $ref_cust = $this->session->userdata('kodecust');
        $cekcust  = $this->h_cekcust($ref_cust);
        if ($cekcust > 0) {
          $cek = $this->h_cekorder($ref_cust);
          if ($cek <= 0) {
            $this->h_entrybaru($ref_cust);
          }
          $jml = $this->h_hitung_order($ref_cust, $tgl);
          if ($jml <= 0) {
            $this->h_resethandler($ref_cust);
          }
          $arr      = $this->cart->contents();
          $list     = [];
          foreach ($arr as $i => $r) {
              $row['qty'] = $r['qty'];
              $list[]     = $row;
          }
          $sum_qty  = array_column($list, 'qty');
          $qty_now  = array_sum($sum_qty);
          $qty_old  = $this->db->get_where('thandlerorder', array('ref_cust' =>$ref_cust ))->row()->order;
          if (($qty_old + $qty_now) >= $minorder) {
            //DAPAT DISKON
            foreach ($arr as $i => $v) {
              $d = array(
                  'rowid'   => $v['rowid'],
                  'harga'   => $this->get_harga_diskon($v['kode'])
              );
              $res = $this->cart->update($d);
            }
          } else {
            //TIDAK DAPAT DISKON
            foreach ($arr as $i => $v) {
              $d = array(
                  'rowid'   => $v['rowid'],
                  'harga'   => $this->get_harga_biasa($v['kode'])
              );
              $res = $this->cart->update($d);
            }
          }
        }
    }

    public function get_harga_diskon($ref_brg)
    {
        $barang   = $this->db->get_where('msatbrg',
          array(
            'ref_brg' => $ref_brg,
            'def'     => 't',
          ))->row();
        return $barang->harga1;
    }

    public function get_harga_biasa($ref_brg)
    {
        $barang   = $this->db->get_where('msatbrg',
          array(
            'ref_brg' => $ref_brg,
            'def'     => 't',
          ))->row();
        return $barang->harga;
    }

    public function h_cekorder($ref_cust)
    {
        $w['ref_cust']  = $ref_cust;
        $num_rows       = $this->db->get_where('thandlerorder',$w)->num_rows();
        return $num_rows;
    }

    public function h_cekcust($ref_cust)
    {
        $w['kode']  = $ref_cust;
        $num_rows   = $this->db->get_where('mcustomer',$w)->num_rows();
        return $num_rows;
    }

    public function h_curr_qty($ref_cust)
    {
        $w['ref_cust']  = $ref_cust;
        $result = $this->db->get_where('thandlerorder',$w)->row();
        return $result->order;
    }

    public function h_entrybaru($ref_cust)
    {
        $d['ref_cust']  = $ref_cust;
        $d['order']     = 0;
        $result = $this->db->insert('thandlerorder',$d);
        return $result;
    }

    public function h_updatehandler($ref_cust, $ref_brg, $qty)
    {
        $w['ref_cust']  = $ref_cust;
        // $w['ref_brg']   = $ref_brg;
        $curr           = $this->db->get_where('thandlerorder',$w)->row();
        $current_qty    = $curr->order;
        $new_qty        = $current_qty + $qty;
        $d['order']     = $new_qty;
        $result         = $this->db->update('thandlerorder',$d,$w);
        return $result;
    }

    public function h_resethandler($ref_cust)
    {
        $w['ref_cust']  = $ref_cust;
        $d['order']     = 0;
        $result = $this->db->update('thandlerorder',$d,$w);
        return $result;
    }

    public function h_hitung_order($kodecust, $tgl)
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
              AND xorder.tgl BETWEEN '$tglstart' AND '$tglend'
              ORDER BY xorder.tgl DESC";
        $jumlah         = $this->db->query($q)->num_rows();
        $row            = $this->db->query($q)->row_array();
        $data['jumlah'] = $jumlah;
        $data['row']    = $row;
        return $data;
    }

    function remove()
    {
        $rowid = $this->input->post('rowid');
        $data = array(
            'rowid'   => $rowid,
            'qty'     => 0
        );
        $result = $this->cart->update($data);
        $r['sukses']= $result ? 'success' : 'fail' ;
        $r['respon']=  'Produk Berhasil Dihapus Dari Keranjang' ;
        echo json_encode($r);
    }

    //------------------------------------------TEST-----------------------------------------------
    public function getharga()
    {
        $ref_cust = '000000000004';
        $ref_brg  = 'GX0002';
        $tgl      = '13 Nov 2019';
        $qty      = '16';
        $harga    = $this->h_proses($ref_cust, $ref_brg, $tgl, $qty);
        print_r($harga);
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

}
