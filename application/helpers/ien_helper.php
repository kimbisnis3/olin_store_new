<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** If empty null helper **/
if (!function_exists('status')) {

    function insert_id($table){
      $ci =& get_instance();
      return $ci->db->insert_id('public."'.$table.'_id_seq"');
    }

    function prefix_sess() {
        return '_olinstore_';
    }

    function sess_data($data) {
        $ci =& get_instance();
        return $ci->session->userdata($data);
    }

    function api_url() {
        // return 'https://mkj.olinbags.com/agen/';
        return 'localhost/olin/agen/';
    }

    function lumise_url() {
        // return 'https://https://pabriktascustom.com/design/';
        return 'http://localhost/lumise_new_update/';
    }

    function ien($text)
    {
        if ($text=='') {
            $text = NULL;
        }
        else {
            $text = $text;
        }

        return $text;
    }

    function dfh($text)
    {
        if ($text=='') {
            $text = NULL;
        }
        else {
            $text = date('Y-m-d', strtotime($text));
        }

        return $text;
    }

    function tip($text)
    {
        if ($text=='') {
            $text = NULL;
        }
        else {
            $text = $this->input->post($text);
        }

        return $text;
    }

    function query_to_var($query,$filter) {
        $find       = array_keys($filter);
        $replace    = array_values($filter);
        $n          = str_replace($find, $replace, $query);
        return $n ;
    }

    function truefalse($data, $labeltrue, $labelfalse)
    {
        if ($data=='0' || $data=='NULL' || $data=='' || $data=='f') {
            $data = '<span class="label label-danger">'.$labelfalse.'</span>';
        }
        else {
            $data = '<span class="label label-success">'.$labeltrue.'</span>';
        }

        return $data;
    }

    //IMAGE MANIPULATION

    function showimage($i){

        if ($i == NULL){
            $i = "(Noimage)";
        } else {
            $img = base_url().''.$i;
            $i = "<img onerror='imgError(this)' style='max-width : 60px;' src='".$img."'>";
        }
        return $i;
    }

    function showimagecustom($i,$maxw){
        if ($i == NULL){
            $i = "(Noimage)";
        } else {
            $img = base_url().''.$i;
            $i = "<img style='max-width : ".$maxw."px;' src='".$img."'>";
        }

        return $i;
    }

    function dlimage($img){
        $path = ".".$img;
        if ($img == null || $img == "") {
            $img = "(Noimage)";
        } else {
            if (file_exists($path)) {
                $img = '<a href="'.$img.'" title="ImageName"  download="img_'.time().'" ><img style="max-width : 60px;" src="'.base_url().$img.'" alt="ImageName"></a>';
            } else {
                $img = "<img style='max-width : 60px;'  src='".base_url()."/assets/gambar/noimage.png'>";
            }
        }
        return $img;
    }

    function imgerr($img)
    {
        $path = ".".$img;

        if ($img == null || $img == "") {
            $img = "(Noimage)";
        } else {
            if (file_exists($path)) {
                $img = $img;
            } else {
                $img = '/assets/gambar/noimage.png';
            }
        }
        return $img;


    }

    function imghandler($img,$maxw)
    {
        $path = ".".$img;

        if ($img == null || $img == "") {
            $img = "(Noimage)";
        } else {
            if (file_exists($path)) {
                $img = "<img style='max-width : ".$maxw."px;' src='".base_url().$img."'>";
            } else {
                $img = "<img style='max-width : ".$maxw."px;'  src='".base_url()."/assets/gambar/noimage.png'>";
            }
        }
        return $img;


    }

    function slug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    function id_date($date)
    {
        if ($date != NULL) {

        $indonesian_month = array("Jan", "Feb", "Mar",
            "Apr", "Mei", "Jun",
            "Jul", "Agt", "Sep",
            "Okto", "Nov", "Des");
        $year        = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
        $month       = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
        $currentdate = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
        $result = $currentdate . " " . $indonesian_month[(int) $month - 1] . " " . $year;

        return $result;
    }else {

    }
    }

    function indonesian_date($date)
    {
        // fungsi atau method untuk mengubah tanggal ke format indonesia
        // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
        $indonesian_month = array("Januari", "Februari", "Maret",
            "April", "Mei", "Juni",
            "Juli", "Agustus", "September",
            "Oktober", "November", "Desember");
        $year        = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
        $month       = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
        $currentdate = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
        $result = $currentdate . " " . $indonesian_month[(int) $month - 1] . " " . $year;
        return $result;
    }

    function normal_date($date)
    {
        if ($date != NULL) {

        $indonesian_month = array("Jan", "Feb", "Mar",
            "Apr", "May", "Jun",
            "Jul", "Aug", "Sep",
            "Oct", "Nov", "Dec");
        $year        = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
        $month       = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
        $currentdate = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
        $result = $currentdate . " " . $indonesian_month[(int) $month - 1] . " " . $year;

        return $result;
        }
    }

    function aktif($text)
    {
        if ($text=='0' || $text=='NULL' || $text=='') {
            $text = '<span class="label label-danger">Tidak Aktif</span>';
        }
        else {
            $text = '<span class="label label-success">Aktif</span>';
        }

        return $text;
    }

}
