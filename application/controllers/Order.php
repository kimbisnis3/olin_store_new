<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'order';
    public $indexpage   = 'order/v_order.php';

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

    public function getall(){
        $filterawal = date('Y-m-d', strtotime($this->input->post('filterawal')));
        $filterakhir = date('Y-m-d', strtotime($this->input->post('filterakhir')));
        $kodecust   = $this->session->userdata('kodecust');
        $q = "SELECT
                xorder.id,
                xorder.kode,
                xorder.tgl,
                xorder.ket,
                xorder.pic,
                xorder.kgkirim,
                xorder.kirimke,
                xorder.bykirim,
                xorder.ref_layanan,
                xorder.kurir,
                xorder.kodekurir,
                xorder.lokasidari,
                xorder.lokasike,
                xorder.pathcorel,
                xorder.pathimage,
                xorder.status,
                xorder.total,
                mcustomer.nama namacust,
                mkirim.nama mkirim_nama,
                mlayanan.nama mlayanan_nama,
                xsuratjalan.noresi,
                (SELECT count(statusd) FROM xorderd WHERE xorderd.ref_order = xorder.kode) jmlorder,
                (SELECT count(statusd) FROM xorderd WHERE xorderd.ref_order = xorder.kode AND statusd=4) orderdone,
                (SELECT count(ref_jual) FROM xpelunasan WHERE xorder.kode = xpelunasan.ref_jual) sdhbayar
            FROM
                xorder
            LEFT JOIN mcustomer ON mcustomer.kode = xorder.ref_cust
            LEFT JOIN mkirim ON mkirim.kode = xorder.ref_kirim
            LEFT JOIN mlayanan ON mlayanan.kode = xorder.ref_layanan
            LEFT JOIN xsuratjalan ON xsuratjalan.ref_order = xorder.kode
            WHERE xorder.void IS NOT TRUE
            ";
        if ($kodecust) {
            $q .= " AND xorder.ref_cust = '$kodecust'";
        }
        // if ($filterawal || $filterakhir) {
        //     $q .= " AND
        //         xorder.tgl
        //     BETWEEN '$filterawal' AND '$filterakhir'";
        // }

        $q .=" ORDER BY xorder.id DESC" ;
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']      = $i + 1;
            $row['id']          = $r->id;
            $row['kode']        = $r->kode;
            $row['tgl']         = normal_date($r->tgl);
            $row['namacust']    = $r->namacust;
            $row['kgkirim']     = $r->kgkirim;
            $row['bykirim']     = number_format($r->bykirim);
            $row['mkirim_nama'] = $r->mkirim_nama." - ".strtoupper($r->kurir);
            $row['lokasidari']  = $r->lokasidari;
            $row['lokasike']    = $r->lokasike;
            $row['ket']         = $r->ket;
            $row['pathcorel']   = $r->pathcorel;
            $row['pathimage']   = $r->pathimage;
            $row['kirimke']     = $r->kirimke;
            $row['mlayanan_nama']= $r->mlayanan_nama;
            $row['status']      = $this->status_po($r->status);
            $row['jmlorder']    = $r->jmlorder;
            $row['orderdone']   = $r->orderdone;
            $row['noresi']      = $r->noresi;
            $row['sdhbayar']    = $r->sdhbayar;
            $row['totalall']    = number_format($r->total + $r->bykirim);
            // $row['statusorder'] = ($r->orderdone == $r->jmlorder) ? '<span class="label label-success">Selesai Semua</span>' : '<span class="label label-warning">Belum Selesai</span>' ;
            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function status_po($s)
    {
        if ($s == 0) {
            $s = '<span class="label label-warning">Pending</span>';
        } else if($s == 1) {
            $s = '<span class="label label-success">Proses</span>';
        } else if($s >= 2) {
            $s = '<span class="label label-info">Sudah Dikirim</span>';
        }
        return $s;
    }

    public function deletedata()
    {
        $d['void']    = 't';
        $d['tglvoid'] = 'now()';
        $w['id']      = $this->input->post('id');
        $result       = $this->db->update($this->table,$d,$w);
        $r['sukses']  = $result ? 'success' : 'fail' ;
        echo json_encode($r);
    }

    public function getdetail()
    {
        $xorderkode = $this->input->post('xorderkode');
        $q = "SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
                msatbrg.id idsatbarang,
                msatbrg.konv,
                msatbrg.ket ketsat,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatuan.nama satuan,
                mgudang.nama gudang,
                xorderd.harga,
                xorderd.jumlah,
                xorderd.statusd,
                xorderd.jumlah * xorderd.harga subtotal,
                xorderd._product_id,
                xorderd._design_id,
                xorderd._order_id
            FROM
                xorderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xorderd.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            LEFT JOIN mgudang ON mgudang.kode = msatbrg.ref_gud
            WHERE xorderd.ref_order = '$xorderkode'";
        $brg     = $this->db->query($q)->result();

        $p ="SELECT
                xorderds.id,
                xorderds.ket,
                mbarang.nama,
                mmodesign.nama mmodesign_nama,
                mmodesign.gambar mmodesign_gambar,
                mwarna.nama mwarna_nama,
                mwarna.colorc mwarna_colorc
            FROM
                xorderds
            LEFT JOIN mmodesign ON mmodesign.kode = xorderds.ref_modesign
            LEFT JOIN mwarna ON mwarna.kode = xorderds.ref_warna
            LEFT JOIN xorderd ON xorderd. ID = xorderds.ref_orderd
            LEFT JOIN mbarang ON mbarang.kode = xorderd.ref_brg
            LEFT JOIN xorder ON xorder.kode = xorderd.ref_order
            WHERE xorder.kode = '$xorderkode'";
        $spek    = $this->db->query($p)->result();
        $tabs   = '<div class="nav-tabs-custom fadeIn animated">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Data Produk</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Data Spesifikasi</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">';
        $tabs   .= '<table class="table-custom">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Keterangan</th>
                            <th>Design</th>
                        </tr>
                        <thead>';
        foreach ($brg as $i => $r) {
            $tabs    .= '<tbody>
                        <tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->kode.'</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->jumlah.'</td>
                            <td>'.$r->satuan.'</td>
                            <td>'.number_format($r->harga).'</td>
                            <td>'.number_format($r->subtotal).'</td>
                            <td>'.$r->ket.'</td>
                            <td><button class="btn btn-success btn-flat btn-sm" onclick="grab_design(\''.$r->_product_id.'\',\''.$r->_design_id.'\',\''.$r->_order_id.'\')">Design</button></td>
                        </tr>
                        </tbody>';
        }
        $tabs .= '</table>';
        $tabs .=    '</div>
                    <div class="tab-pane" id="tab_2">';

        $tabs   .= '<table class="table-custom">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Nama Spesifikasi</th>
                            <th>Gambar</th>
                            <th>Nama Warna</th>
                            <th>Warna</th>
                        </tr>
                        <thead>';
        foreach ($spek as $i => $r) {
            $tabs    .= '<tbody>
                        <tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->mmodesign_nama.'</td>
                            <td>'.showimage(str_replace('/agen/','',$r->mmodesign_gambar)).'</td>
                            <td>'.$r->mwarna_nama.'</td>
                            <td><div style="witdh:10px; height:20px; background-color:'.$r->mwarna_colorc.'" ></div></td>
                        </tr>
                        </tbody>';
        }
        $tabs .= '</table>';
        $tabs .='   </div>
                  </div>
                </div>';
        echo $tabs;
    }

    public function savedata()
    {
        // $this->db->trans_begin();
        $provfrom = '10';
        $cityfrom = '445';
        $distfrom = '6164';
        $prov     = 'Jawa Tengah';
        $city     = 'Surakarta (Solo)';
        $dist     = 'Laweyan';

        $a['ref_cust']  = $this->session->userdata('kodecust');
        $a['tgl']       = 'now()';
        $a['ref_gud']   = $this->libre->gud_def();
        $a['ket']       = $this->input->post('ket');
        $a['ref_kirim'] = $this->input->post('ref_kirim');
        $a['ref_layanan'] = $this->input->post('ref_layanan');
        $a['kirimke']   = $this->input->post('nama_penerima');
        $a['alamat']    = $this->input->post('alamat_penerima');
        $a['email']     = $this->input->post('email_penerima');
        $a['telp']      = $this->input->post('telp_penerima');
        $a['ref_bank']  = $this->input->post('bank');
        $a['alamatcod'] = $this->input->post('alamatcod');
        if ($this->input->post('ref_kirim') == 'GX0002') {
            $a['kodeprovfrom']  = $provfrom ;
            $a['kodecityfrom']  = $cityfrom;
            $a['kodedistfrom']  = $distfrom;
            $a['kodeprovto']    = $this->input->post('provinsito');
            $a['kodecityto']    = $this->input->post('cityto');
            $a['kodedistto']    = $this->input->post('distto');
            $a['lokasidari']    = $prov.' - '.$city;
            $a['lokasike']      = $this->input->post('maskprovinsito').' - '.$this->input->post('maskcityto');
            $a['kgkirim']       = $this->input->post('kgkirim');
            $a['bykirim']       = $this->input->post('bykirim');
            $a['kodekurir']     = $this->input->post('kodekurir');
            $a['kurir']         = $this->input->post('kurir');
            $a['namakirim']     = $this->input->post('namakirim');
            $a['hpkirim']       = $this->input->post('hpkirim');
            // $a['alamatkirim']   = $this->input->post('alamatkirim');
        }
        $this->db->insert('xorder',$a);
        // $idOrder    = $this->db->insert_id();
        $idOrder    = insert_id('xorder');
        $kodeOrder  = $this->db->get_where('xorder',array('id' => $idOrder))->row()->kode;
        $arr_produk = $this->cart->contents();
        foreach ($this->cart->contents() as $r) {
            $kodebrg = $r['kode'];
            $Brg = $this->db->query("
            SELECT
                msatbrg.kode msatbrg_kode,
                msatbrg.ref_brg msatbrg_ref_brg,
                msatbrg.harga msatbrg_harga,
                msatbrg.ref_gud msatbrg_ref_gud,
                msatbrg.ket msatbrg_ket
            FROM
                mbarang
            LEFT JOIN msatbrg ON msatbrg.ref_brg = mbarang.kode
            WHERE
                msatbrg.def = 't'
            AND mbarang.kode = '".$kodebrg."'")->row();
            $rowb['useri']        = $this->session->userdata('user');
            $rowb['ref_order']    = $kodeOrder;
            $rowb['ref_satbrg']   = $Brg->msatbrg_kode;
            $rowb['ref_gud']      = $Brg->msatbrg_ref_gud;
            $rowb['ket']          = $Brg->msatbrg_ket;
            // $rowb['ref_brg']      = $Brg->msatbrg_ref_brg;
            // $rowb['harga']        = $Brg->msatbrg_harga;
            $rowb['ref_brg']      = $r['kode'];
            $rowb['harga']        = $r['harga'];
            $rowb['jumlah']       = $r['qty'];
            $rowb['diskon']       = $r['diskon'];
            $rowb['_product_id']  = $r['_product_id'];
            $rowb['_design_id']   = $r['_design_id'];
            $rowb['_order_id']    = $r['_order_id'];
            $b[] = $rowb;

            $jml_order = $this->db->get_where(
              'thandlerorder',
              array(
                'ref_cust'  => $this->session->userdata('kodecust'),
                // 'ref_brg'   => $kodebrg,
              ))->row();
            $old_jml = $jml_order->order;
            $new_jml = $r['qty'];
            $_w['ref_cust']    = $this->session->userdata('kodecust');
            // $_w['ref_brg']     = $kodebrg;
            $_d['order']       = $old_jml + $new_jml;
            $this->db->update('thandlerorder',$_d,$_w);
        }
        $this->db->delete('xorderd',array('ref_order' => $kodeOrder));
        $this->db->insert_batch('xorderd',$b);
        $idOrderd = $this->db->get_where('xorderd',array('ref_order' => $kodeOrder))->result();
        foreach ($idOrderd as $i) {
        $kodebarang = $this->db->get_where('xorderd',array('id' => $i->id))->row()->ref_brg;
        $design = $this->db->get_where('mbarangs',array('ref_brg' => $kodebarang))->result();
            foreach ($design as $r) {
                $row    = array(
                    "useri"         => $this->session->userdata('username'),
                    "ref_orderd"    => $i->id,
                    "ref_modesign"  => $r->model,
                    "ref_warna"     => $r->warna,
                    "ket"           => $r->ket
                );
                $c[] = $row;
            }
        }
        if (count($design) > 0) {
            $this->db->insert_batch('xorderds',$c);
        }
        //Total Diskon
        // $sum_diskon = 0;
        // foreach($this->cart->contents() as $i => $v) {
        //     $sum_diskon += ($v['diskon'] * $v['qty']);
        // }
        // $d['total'] = ($this->cart->total() - $sum_diskon) + $this->input->post('bykirim');
        $hargalayanan = $this->gethargalayanan($this->input->post('ref_layanan'));
        // $d['total']   = ($this->cart->total()) + $this->input->post('bykirim')  + $hargalayanan;
        $bykirim 	= $this->input->post('bykirim') == null || $this->input->post('bykirim') == '' ? 0 : $this->input->post('bykirim') ;
        $d['total'] = $this->input->post('total_cart') + $bykirim  + $hargalayanan;
        $this->db->update('xorder',$d,array('kode' => $kodeOrder));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail',
            );
        }
        else
        {
            $this->db->trans_commit();
            $this->cart->destroy();
            $r = array(
                'sukses' => 'success',
                );
        }
        echo json_encode($r);
    }

    function gethargalayanan($ref_layanan)
    {
        $harga = $this->db->get_where('mlayanan',array('kode' => $ref_layanan))->row();
        return $harga->harga;
    }

    function try_save()
    {
      $provfrom = '10';
      $cityfrom = '445';
      $prov     = 'Jawa Tengah';
      $city     = 'Surakarta (Solo)';
      $a['ref_cust']      = '000000000004';
      $a['tgl']           = 'now()';
      $a['ref_gud']       = 'GX0001';
      $a['ket']           = '';
      $a['ref_kirim']     = 'GX0002';
      $a['ref_layanan']   = '2019000001';
      $a['kirimke']       = 'Roberto';
      $a['alamat']        = 'Liverpool, England';
      $a['email']         = 'bobby@gmail.com';
      $a['telp']          = '234234242';
      $a['ref_bank']      = 'GX0001';
      $a['kodeprovfrom']  = $provfrom ;
      $a['kodecityfrom']  = $cityfrom;
      $a['kodeprovto']    = '7';
      $a['kodecityto']    = '129';
      $a['lokasidari']    = 'Jawa Tengah - Surakarta (Solo)';
      $a['lokasike']      = 'Gorontalo - Gorontalo';
      $a['kgkirim']       = '1';
      $a['bykirim']       = '58000';
      $a['kodekurir']     = 'OKE';
      $a['kurir']         = 'jne';
      $this->db->insert('xorder',$a);
      $idOrder = insert_id('xorder');
      print_r($idOrder);
    }
}
