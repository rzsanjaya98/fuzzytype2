<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fuzzy extends Admin_Controller {
  // class Home extends CI_Controller {

  public function __construct(){
      parent::__construct();

    $this->load->model("m_user");
    $this->load->model("m_data_meteorologi");
    $this->load->helper('array');
    $this->load->library("pagination");
    $this->load->model("m_fuzzy");
  }

  public function index() 
  {
      $data['page_name'] = "FuzzyType-2";
    
      $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'));
      $data['data_fuzzifikasi'] = $this->m_fuzzy->getData();
      $data['data_prediksi'] = $this->m_fuzzy->getDataPrediksi();  
      $this->load->view("templates/header");
      $this->load->view("templates/sidebar");
      $this->load->view("view_admin/fuzzy/v_fuzzy",$data);
      $this->load->view("templates/footer");
  }

  public function fuzzifikasi(){
    $this->m_fuzzy->clear();
    $data_meteorologi = $this->m_data_meteorologi->getData();

    if(empty($data_meteorologi)){
            redirect(site_url('admin/fuzzy'));
            return;
    }

    for( $i=0; $i< count($data_meteorologi); $i++ ){
      
      $data_fuzzifikasi[$i]['data_id'] = $data_meteorologi[$i]->data_id;
      $data_fuzzifikasi[$i]['data_tanggal'] = $data_meteorologi[$i]->data_tanggal;
      $data_fuzzifikasi[$i]['data_curah_hujan'] = $data_meteorologi[$i]->data_curah_hujan;

      //fuzzifikasi temperatur
      $data_fuzzifikasi[$i]['data_temperaturUsejuk'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 24, 24, 27.5, 28);
      $data_fuzzifikasi[$i]['data_temperaturLsejuk'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 24, 24, 27.3, 27.8);
      $data_fuzzifikasi[$i]['data_temperaturUnormal'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 27.5, 28, 29.5, 29.9);
      $data_fuzzifikasi[$i]['data_temperaturLnormal'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 27.7, 28.2, 29.3, 29.7);
      $data_fuzzifikasi[$i]['data_temperaturUpanas'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 29.5, 29.9, 31, 31);
      $data_fuzzifikasi[$i]['data_temperaturLpanas'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 29.7, 30.1, 31, 31);

      // $data_fuzzifikasi[$i]['data_temperaturUsejuk'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 23, 23, 26, 27);
      // $data_fuzzifikasi[$i]['data_temperaturLsejuk'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 23, 23, 25.5, 26.5);
      // $data_fuzzifikasi[$i]['data_temperaturUnormal'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 26, 27, 29, 30);
      // $data_fuzzifikasi[$i]['data_temperaturLnormal'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 26.5, 27.5, 28.5, 29.5);
      // $data_fuzzifikasi[$i]['data_temperaturUpanas'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 29, 30, 31, 31);
      // $data_fuzzifikasi[$i]['data_temperaturLpanas'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 29.5, 30.5, 31, 31);

      //fuzzifikasi kelembapan
      $data_fuzzifikasi[$i]['data_kelembapanUkering'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kelembapan, 59, 59, 68, 70);
      $data_fuzzifikasi[$i]['data_kelembapanLkering'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kelembapan, 59, 59, 67, 69);
      $data_fuzzifikasi[$i]['data_kelembapanUlembab'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kelembapan, 68, 70, 78, 80);
      $data_fuzzifikasi[$i]['data_kelembapanLlembab'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kelembapan, 69, 71, 77, 79);
      $data_fuzzifikasi[$i]['data_kelembapanUbasah'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kelembapan, 78, 80, 98, 98);
      $data_fuzzifikasi[$i]['data_kelembapanLbasah'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kelembapan, 79, 81, 98, 98);

      //fuzzifikasi kecepatan angin
      $data_fuzzifikasi[$i]['data_kecepatan_anginUlambat'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 0, 0, 4, 5);
      $data_fuzzifikasi[$i]['data_kecepatan_anginLlambat'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 0, 0, 3.5, 4.5);
      $data_fuzzifikasi[$i]['data_kecepatan_anginUagakkencang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 4, 5, 8, 9);
      $data_fuzzifikasi[$i]['data_kecepatan_anginLagakkencang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 4.5, 5.5, 7.5, 8.5);
      $data_fuzzifikasi[$i]['data_kecepatan_anginUkencang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 8, 9, 12, 12);
      $data_fuzzifikasi[$i]['data_kecepatan_anginLkencang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 8.5, 9.5, 12, 12);

      //fuzzifikasi lama penyinaran matahari
      // $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUrendah'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 0, 0, 35, 40);
      // $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLrendah'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 0, 0, 33, 38);
      // $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUsedang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 35, 40, 75, 80);
      // $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLsedang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 38, 43, 73, 78);
      // $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUtinggi'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 75, 80, 100, 100);
      // $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLtinggi'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 78, 83, 100, 100);

      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUrendah'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 0, 0, 4, 5);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLrendah'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 0, 0, 3.5, 4.5);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUsedang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 4, 5, 8, 9);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLsedang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 4.5, 5.5, 7.5, 8.5);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUtinggi'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 8, 9, 12, 12);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLtinggi'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 8.5, 9.5, 12, 12);

      //fuzzifikasi tekanan udara
      // $data_fuzzifikasi[$i]['data_tekanan_udaraUrendah'] = $this->Upper_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1007, 1007, 1008.5, 1008.9);
      // $data_fuzzifikasi[$i]['data_tekanan_udaraLrendah'] = $this->Lower_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1007, 1007, 1008.3, 1008.7);
      // $data_fuzzifikasi[$i]['data_tekanan_udaraUsedang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1008.5, 1009, 1012.5, 1012.9);
      // $data_fuzzifikasi[$i]['data_tekanan_udaraLsedang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1008.9, 1009.1, 1012.3, 1012.7);
      // $data_fuzzifikasi[$i]['data_tekanan_udaraUtinggi'] = $this->Upper_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1012.5, 1012.9, 1014, 1014);
      // $data_fuzzifikasi[$i]['data_tekanan_udaraLtinggi'] = $this->Lower_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1012.7, 1013.1, 1014, 1014);

      // echo var_dump($data_fuzzifikasi);
      // echo count($data_meteorologi);
    }
    if($this->m_fuzzy->create($data_fuzzifikasi)){
            $this->session->set_flashdata('info', array(
                'from' => 1,
                'message' =>  'data berhasil di fuzzifikasi'
              ));
              redirect(site_url('admin/fuzzy'));
              return;
        }
        $this->session->set_flashdata('info', array(
            'from' => 0,
            'message' =>  'terjadi kesalahan saat fuzzifikasi data'
          ));
          redirect(site_url('admin/fuzzy'));
  }

  public function Upper_trapmf($x, $a, $b, $c, $d){
    if($x>=$a AND $x<$b){
      $x = ($x-$a)/($b-$a);
    }else if($x>=$b AND $x<=$c){
      $x = 1;
    }else if($x>$c AND $x<=$d){
      $x = ($d-$x)/($d-$c);
    }else{
      $x = 0;
    }

    return $x;
  }

  public function Lower_trapmf($x, $a, $b, $c, $d){
    if($x>=$a AND $x<$b){
      $x = ($x-$a)/($b-$a);
    }else if($x>=$b AND $x<=$c){
      $x = 0.8;
    }else if($x>$c AND $x<=$d){
      $x = ($d-$x)/($d-$c);
    }else{
      $x = 0;
    }

    return $x;
  }

  public function inference(){
    $this->m_fuzzy->kosongkan();
    $data_fuzzifikasi = $this->m_fuzzy->getData();

    if(empty($data_fuzzifikasi)){
            redirect(site_url('admin/fuzzy'));
            return;
    }

    for( $i=0; $i< count($data_fuzzifikasi); $i++ ){

      $j=0;

      //Rule 1
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 2
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 3
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 4
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 5
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 6
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 7
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 8
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 9
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 10
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 11
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 12
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 13
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 14
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 15
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 16
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 17
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 18
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 19
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Sedang'; $j++; 
      }

      //Rule 20
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Sedang'; $j++;
      }

      //Rule 21
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Sedang'; $j++;
      }

      //Rule 22
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Sedang'; $j++; 
      }

      //Rule 23
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Sedang'; $j++; 
      }

      //Rule 24
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Sedang'; $j++; 
      }

      //Rule 25
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Agak Lebat'; $j++; 
      }

      //Rule 26
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Agak Lebat'; $j++; 
      }

      //Rule 27
      if(($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 || $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Agak Lebat'; $j++; 
      }

      //Rule 28
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 29
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 30
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 31
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 32
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 33
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 34
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 35
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 36
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 37
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 38
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 39
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 40
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 41
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 42
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 43
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 44
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 45
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 46
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 47
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 48
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 49
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 50
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 51
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 52
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 53
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 54
      if(($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 || $data_fuzzifikasi[$i]->data_temperaturLnormal != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 55
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 56
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 57
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 58
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 59
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 60
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 61
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 62
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 63
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUkering != 0 || $data_fuzzifikasi[$i]->data_kelembapanLkering != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 64
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 65
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 66
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 67
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 68
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 69
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 70
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 71
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 72
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 || $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 73
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 74
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 75
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++;
      }

      //Rule 76
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 77
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 78
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 79
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 80
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

      //Rule 81
      if(($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 || $data_fuzzifikasi[$i]->data_temperaturLpanas != 0) &&
        ($data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 || $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0) &&
      ($data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 || $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0) && ($data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 || $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0))
      {
        $inference[$i]['upper'][$j] = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $inference[$i]['lower'][$j] = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        //$data[$i]['deffuzifikasi'] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
        $inference[$i]['rules'][$j] = 'Ringan'; $j++; 
      }

    }

    $yl = $this->yl($inference);
    $yr = $this->yr($inference);
    for ($i=0; $i < count($data_fuzzifikasi); $i++) { 
      $data[$i]['data_id'] = $data_fuzzifikasi[$i]->data_id;
      $data[$i]['data_tanggal'] = $data_fuzzifikasi[$i]->data_tanggal;
      $data[$i]['data_curah_hujan'] = $data_fuzzifikasi[$i]->data_curah_hujan;
      $data[$i]['data_curah_hujan_prediksi'] = ($yl['yl'][$i] + $yr['yr'][$i])/2;
      // $data[$i]['data_curah_hujan_prediksi'] = max($yl['yl'][$i], $yr['yr'][$i]);
    }

    if($this->m_fuzzy->prediksi($data)){
            $this->session->set_flashdata('info', array(
                'from' => 1,
                'message' =>  'data berhasil di prediksi'
              ));
              redirect(site_url('admin/fuzzy'));
              return;
        }
        $this->session->set_flashdata('info', array(
            'from' => 0,
            'message' =>  'terjadi kesalahan saat prediksi data'
          ));
          redirect(site_url('admin/fuzzy'));        
    // echo var_dump($y_lower);
    // echo json_encode($yr);
    // echo count($inference);
    // echo count($y_lower);
    // echo $inference[0]['lower'][0];
    // echo $y_lower[0][0];
    
    // echo var_dump($yl);
    // echo json_encode($yl);
    // echo "<br>";
    // echo json_encode($yr);
    // echo $yl['yl'][0];
    // echo "<br>".$data[9]['rules'];
  }

  public function sortingYlower($inference){
    for ($i=0; $i < count($inference); $i++) { 
      for ($j=0; $j < count($inference[$i]['rules']); $j++) { 
        if($inference[$i]['rules'][$j] == 'Ringan'){
          // $y_upper[$i][$j] = 4.9;
          $y[$i][$j] = 0.1;
        }else if($inference[$i]['rules'][$j] == 'Sedang'){
          // $y_upper[$i][$j] = 19.9;
          $y[$i][$j] = 5;
        }else if($inference[$i]['rules'][$j] == 'Agak Lebat'){
          // $y_upper[$i][$j] = 49.9;
          $y[$i][$j] = 20;
        }
      }

      sort($y[$i]);
    }

    return $y;
    // echo var_dump($y_lower);
    // echo json_encode($y);
  }

  public function sortingYupper($inference){
    for ($i=0; $i < count($inference); $i++) { 
      for ($j=0; $j < count($inference[$i]['rules']); $j++) { 
        if($inference[$i]['rules'][$j] == 'Ringan'){
          $y[$i][$j] = 4.9;
          // $y[$i][$j] = 0;
        }else if($inference[$i]['rules'][$j] == 'Sedang'){
          $y[$i][$j] = 20;
          // $y[$i][$j] = 5;
        }else if($inference[$i]['rules'][$j] == 'Agak Lebat'){
          $y[$i][$j] = 50;
          // $y[$i][$j] = 20;
        }
      }

      sort($y[$i]);
    }

    return $y;

    // echo var_dump($y_lower);
    // echo json_encode($y);
  }

  public function yl($inference){
    $y_lower = $this->sortingYlower($inference);
    for ($i=0; $i < count($inference); $i++) { 
      $N = count($inference[$i]['lower']);
      for ($j=0; $j < $N; $j++) { 
        $f[$j] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
      }
      $atas = 0;
      $bawah = 0;
      for ($j=0; $j < $N; $j++) { 
        $atas = $atas + ($y_lower[$i][$j] * $f[$j]);
        $bawah = $bawah + $f[$j];
        // $atas =  + $x; 
      }
      // $bawah = 0;
      // for ($j=0; $j < $N; $j++) { 
      //   $bawah = $bawah + $f[$j];
      //   // $atas = $atas+$x; 
      // }
      if($bawah != 0){
            $y = $atas/$bawah;  
          }else{
            $y = $atas;
          }
      // $y = $atas/$bawah;

      $k = 0;
      do{
        // if($yl != $y){
        //   $y = $yl;
        // }
          $k++;
          $a = 0;
          $b = 0;
          for ($n=0; $n < $N; $n++) { 
            if($n<=$k){
              $a = $a + ($y_lower[$i][$n] * $inference[$i]['upper'][$n]);
              $b = $b + $inference[$i]['upper'][$n];
            }else{
              $a = $a + ($y_lower[$i][$n] * $inference[$i]['lower'][$n]);
              $b = $b + $inference[$i]['lower'][$n];
            }
          }
          // $b = 0;
          // for ($n=0; $n < $N; $n++) { 
          //   if($n+1<=$k){
          //     $b = $b + $inference[$i]['upper'][$n];
          //   }else{
          //     $b = $b + $inference[$i]['lower'][$n];
          //   }
          // }
          if($b != 0){
            $yl = $a/$b;  
          }else{
            $yl = $a;
          }

          // $yl = $a/$b;
          if($yl != $y){
            $y = $yl;
          }else{
            break;
          }
      }while($k != 0);

      $y_l['yl'][$i] = $y;
      $y_l['l'][$i] = $k;
      // echo $atas;
      // echo var_dump($f);
      // echo "<br>";
      // echo var_dump($y_lower[$i]);
      // echo "<br>";
    }
    // echo var_dump($f);
    return $y_l;
  }

  public function yr($inference){
    $y_upper = $this->sortingYupper($inference);
    for ($i=0; $i < count($inference); $i++) { 
      $N = count($inference[$i]['upper']);
      for ($j=0; $j < $N; $j++) { 
        $f[$j] = ($inference[$i]['upper'][$j] + $inference[$i]['lower'][$j])/2;
      }
      $atas = 0;
      $bawah = 0;
      for ($j=0; $j < $N; $j++) { 
        $atas = $atas + ($y_upper[$i][$j] * $f[$j]);
        $bawah = $bawah + $f[$j];
        // $atas =  + $x; 
      }
      // $bawah = 0;
      // for ($j=0; $j < $N; $j++) { 
      //   $bawah = $bawah + $f[$j];
      //   // $atas = $atas+$x; 
      // }
      // $y = $atas/$bawah;
      if($bawah != 0){
            $y = $atas/$bawah;  
          }else{
            $y = $atas;
          }

      $k = 0;
      do{
        // if($yl != $y){
        //   $y = $yl;
        // }
          $k++;
          $a = 0;
          $b = 0;
          for ($n=0; $n < $N; $n++) { 
            if($n<=$k){
              $a = $a + ($y_upper[$i][$n] * $inference[$i]['lower'][$n]);
              $b = $b + $inference[$i]['lower'][$n];
            }else{
              $a = $a + ($y_upper[$i][$n] * $inference[$i]['upper'][$n]);
              $b = $b + $inference[$i]['upper'][$n];
            }
          }
          // $b = 0;
          // for ($n=0; $n < $N; $n++) { 
          //   if($n+1<=$k){
          //     $b = $b + $inference[$i]['upper'][$n];
          //   }else{
          //     $b = $b + $inference[$i]['lower'][$n];
          //   }
          // }
          if($b != 0){
            $yr = $a/$b;  
          }else{
            $yr = $a;
          }
          
          if($yr != $y){
            $y = $yr;
          }else{
            break;
          }
      }while($k != 0);

      $y_u['yr'][$i] = $y;
      $y_u['r'][$i] = $k;
    }
    return $y_u;
  }

}