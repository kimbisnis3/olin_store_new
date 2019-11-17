<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
    public $table       = '';
    public $foldername  = '';
    public $menuaktif   = 'payment';
    public $indexpage   = 'payment/v_payment';

    function __construct()
    {
        parent::__construct();
        include(APPPATH . 'libraries/dbinclude.php');
        include(APPPATH . 'libraries/sessionakses.php');
    }

    function index()
    {
        $data['menuaktif'] = $this->menuaktif;
        $data['jenisbayar'] = $this->db->get('mjenbayar')->result();
        $this->load->view($this->indexpage,$data);
    }

    public function getall(){
        $filteragen = $this->session->userdata('kodecust');
        $q = "SELECT
                xpelunasan.id,
                xpelunasan.kode,
                xpelunasan.tgl tgl_real,
                to_char(xpelunasan.tgl, 'DD Mon YYYY') tgl,
                xpelunasan.total,
                xpelunasan.bayar,
                xpelunasan.total - xpelunasan.bayar kurang,
                xpelunasan.posted,
                xpelunasan.ket,
                xpelunasan.ref_jual,
                xpelunasan.kodeunik,
                mcustomer.nama mcustomer_nama,
                mgudang.nama mgudang_nama,
                mjenbayar.nama mjenbayar_nama,
                mbank.nama bank_nama,
              	mbank.norek
            FROM
                xpelunasan
            LEFT JOIN mcustomer ON mcustomer.kode = xpelunasan.ref_cust
            LEFT JOIN mgudang ON mgudang.kode = xpelunasan.ref_gud
            LEFT JOIN mjenbayar ON mjenbayar.kode = xpelunasan.ref_jenbayar
            LEFT JOIN xorder ON xorder.kode = xpelunasan.ref_jual
            LEFT JOIN mbank ON mbank.kode = xorder.ref_bank
            WHERE xpelunasan.void IS NOT TRUE";
        if ($filteragen) {
            $q .= " AND xpelunasan.ref_cust = '$filteragen'";
        }
        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['tgl']             = $r->tgl;
            $row['mcustomer_nama']  = $r->mcustomer_nama;
            $row['mgudang_nama']    = $r->mgudang_nama;
            $row['mjenbayar_nama']  = $r->mjenbayar_nama;
            $row['total']           = number_format($r->total);
            $row['bayar']           = number_format($r->bayar);
            $row['kurang']          = number_format($r->kurang);
            $row['ket']             = $r->ket;
            $row['posted']          = $r->posted;
            $row['ref_jual']        = $r->ref_jual;
            $row['kodeunik']        = $r->kodeunik;
            $row['norek']           = $r->norek;
            $row['bank_nama']       = $r->bank_nama;

            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }

    public function savedata()
    {
        $this->db->trans_begin();
        $a['useri']     = $this->session->userdata('username');
        $a['ref_cust']  = $this->session->userdata('kodecust');
        $a['tgl']       = date('Y-m-d', strtotime($this->input->post('tgl')));
        $a['total']     = $this->input->post('total');
        $a['bayar']     = $this->input->post('bayar');
        $a['ket']       = $this->input->post('ket');
        $a['ref_jual']  = $this->input->post('ref_order');
        $a['ref_jenbayar']  = $this->input->post('ref_jenbayar_mask');
        $a['ref_gud']   = $this->libre->gud_def();
        $a['posted']    = 'f';

        $result = $this->db->insert('xpelunasan',$a);
        // $idpelun = $this->db->insert_id();
        $idpelun    = insert_id('xpelunasan');
        $kodepelun  = $this->db->get_where('xpelunasan',array('id' => $idpelun))->row()->kode;
        $kodeunik   = $this->db->get_where('xpelunasan',array('id' => $idpelun))->row()->kodeunik;
        $dataOrderd = $this->db->get_where('xorderd',array('ref_order' => $this->input->post('ref_order')))->result();
        foreach ($dataOrderd as $r) {
            $row    = array(
                "useri"     => $this->session->userdata(prefix_sess().'username'),
                "ref_pelun" => $kodepelun,
                "ref_brg"   => $r->ref_brg,
                "jumlah"    => $r->jumlah,
                "ref_satbrg"=> $r->ref_satbrg,
                "ket"       => $r->ket,
                "harga"     => $r->harga,
            );
            $b[] = $row;
        }
        $result = $this->db->insert_batch('xpelunasand',$b);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $r = array(
                'sukses' => 'fail'
            );
        }
        else {
            $this->db->trans_commit();
            $r = array(
                'sukses' => 'success',
                'kodeunik' => $kodeunik
                );
        }
        echo json_encode($r);
    }

    public function getdetail()
    {
        $kodepelunasan = $this->input->post('kodepelunasan');
        $q = "SELECT
                mbarang.id,
                mbarang.kode,
                mbarang.nama,
                mbarang.ket,
                msatbrg.id idsatbarang,
                msatbrg.konv,
                msatbrg.ket ketsat,
                msatbrg.harga,
                msatbrg.ref_brg,
                msatbrg.ref_sat,
                msatuan.nama satuan_nama
            FROM
                xpelunasand
            LEFT JOIN mbarang ON mbarang.kode = xpelunasand.ref_brg
            LEFT JOIN msatbrg ON msatbrg.kode = xpelunasand.ref_satbrg
            LEFT JOIN msatuan ON msatuan.kode = msatbrg.ref_sat
            WHERE xpelunasand.ref_pelun = '$kodepelunasan'";
        $result     = $this->db->query($q)->result();
        $str        = '<table class="table fadeIn animated">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Konv</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                        </tr>';
        foreach ($result as $i => $r) {
            $str    .= '<tr>
                            <td>'.($i + 1).'.</td>
                            <td>'.$r->nama.'</td>
                            <td>'.$r->konv.'</td>
                            <td>'.$r->satuan_nama.'</td>
                            <td>'.$r->harga.'</td>
                            <td>'.$r->ket.'</td>
                        </tr>';
        }

        $str        .= '</table>';
        echo $str;
    }

    public function getorder(){
        $kodecust = $this->session->userdata('kodecust');
        $q = "select qr.*, (COALESCE(qr.total,0))- (COALESCE(qr.dibayar,0)) kurang
            from (
            select
            xorder.id,
            xorder.kode,
            xorder.tgl,
            xorder.ket,
            xorder.pic,
            xorder.kgkirim,
            xorder.bykirim,
            xorder.ref_cust,
            xorder.ref_kirim,
            mcustomer.nama mcustomer_nama,
            case xorder.ref_kirim
            when 'GX0002' then xorder.total
            when 'GX0001' then xorder.total - xorder.bykirim
            end as total,
            (select sum(xpelunasan.bayar) from xpelunasan
            where xpelunasan.void is not true
            and xpelunasan.ref_jual = xorder.kode) dibayar
            from xorder
            join mcustomer on mcustomer.kode = xorder.ref_cust
            ) qr
            where (qr.total - (COALESCE(qr.dibayar,0))) > 0
            AND qr.ref_cust ='$kodecust'";

        $result     = $this->db->query($q)->result();
        $list       = [];
        foreach ($result as $i => $r) {
            $row['no']              = $i + 1;
            $row['id']              = $r->id;
            $row['kode']            = $r->kode;
            $row['ref_cust']        = $r->ref_cust;
            $row['mcustomer_nama']  = $r->mcustomer_nama;
            $row['tgl']             = normal_date($r->tgl);
            $row['total']           = $r->total;
            $row['dibayar']         = $r->dibayar;
            $row['kurang']          = $r->kurang;
            $row['ket']             = $r->ket;

            $list[] = $row;
        }
        echo json_encode(array('data' => $list));
    }
}
