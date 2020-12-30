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
      $this->load->view("templates/header");
      $this->load->view("templates/sidebar");
      $this->load->view("view_admin/fuzzy/v_fuzzy",$data);
      $this->load->view("templates/footer");
  }

  public function fuzzifikasi(){
    $this->m_fuzzy->clear();
    $data_meteorologi = $this->m_data_meteorologi->getData();

    if(empty($data_meteorologi)){
            redirect(site_url('admin/data_meteorologi'));
            return;
    }

    for( $i=0; $i< count($data_meteorologi); $i++ ){
      
      $data_fuzzifikasi[$i]['data_id'] = $data_meteorologi[$i]->data_id;
      $data_fuzzifikasi[$i]['data_tanggal'] = $data_meteorologi[$i]->data_tanggal;
      $data_fuzzifikasi[$i]['data_curah_hujan'] = $data_meteorologi[$i]->data_curah_hujan;

      //fuzzifikasi temperatur
      $data_fuzzifikasi[$i]['data_temperaturUsejuk'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 25.7, 25.7, 27.5, 28);
      $data_fuzzifikasi[$i]['data_temperaturLsejuk'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 25.7, 25.7, 27.3, 27.8);
      $data_fuzzifikasi[$i]['data_temperaturUnormal'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 27.5, 28, 29.5, 29.9);
      $data_fuzzifikasi[$i]['data_temperaturLnormal'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 27.7, 28.2, 29.3, 29.7);
      $data_fuzzifikasi[$i]['data_temperaturUpanas'] = $this->Upper_trapmf($data_meteorologi[$i]->data_temperatur, 29.5, 29.9, 31, 31);
      $data_fuzzifikasi[$i]['data_temperaturLpanas'] = $this->Lower_trapmf($data_meteorologi[$i]->data_temperatur, 29.7, 30.1, 31, 31);

      //fuzzifikasi kelembapan
      $data_fuzzifikasi[$i]['data_kelembapanUkering'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kelembapan, 59, 59, 68, 70);
      $data_fuzzifikasi[$i]['data_kelembapanLkering'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kelembapan, 59, 59, 67, 69);
      $data_fuzzifikasi[$i]['data_kelembapanUlembab'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kelembapan, 68, 70, 78, 80);
      $data_fuzzifikasi[$i]['data_kelembapanLlembab'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kelembapan, 69, 71, 77, 79);
      $data_fuzzifikasi[$i]['data_kelembapanUbasah'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kelembapan, 78, 80, 92, 92);
      $data_fuzzifikasi[$i]['data_kelembapanLbasah'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kelembapan, 79, 81, 92, 92);

      //fuzzifikasi kecepatan angin
      $data_fuzzifikasi[$i]['data_kecepatan_anginUlambat'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 0, 0, 4, 5);
      $data_fuzzifikasi[$i]['data_kecepatan_anginLlambat'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 0, 0, 3.5, 4.5);
      $data_fuzzifikasi[$i]['data_kecepatan_anginUagakkencang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 4, 5, 8, 9);
      $data_fuzzifikasi[$i]['data_kecepatan_anginLagakkencang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 4.5, 5.5, 7.5, 8.5);
      $data_fuzzifikasi[$i]['data_kecepatan_anginUkencang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 8, 9, 12, 12);
      $data_fuzzifikasi[$i]['data_kecepatan_anginLkencang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_kecepatan_angin, 8.5, 9.5, 12, 12);

      //fuzzifikasi lama penyinaran matahari
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUrendah'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 0, 0, 35, 40);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLrendah'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 0, 0, 33, 38);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUsedang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 35, 40, 75, 80);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLsedang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 38, 43, 73, 78);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariUtinggi'] = $this->Upper_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 75, 80, 100, 100);
      $data_fuzzifikasi[$i]['data_lama_penyinaran_matahariLtinggi'] = $this->Lower_trapmf($data_meteorologi[$i]->data_lama_penyinaran_matahari, 78, 83, 100, 100);

      //fuzzifikasi tekanan udara
      $data_fuzzifikasi[$i]['data_tekanan_udaraUrendah'] = $this->Upper_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1007, 1007, 1008.5, 1008.9);
      $data_fuzzifikasi[$i]['data_tekanan_udaraLrendah'] = $this->Lower_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1007, 1007, 1008.3, 1008.7);
      $data_fuzzifikasi[$i]['data_tekanan_udaraUsedang'] = $this->Upper_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1008.5, 1009, 1012.5, 1012.9);
      $data_fuzzifikasi[$i]['data_tekanan_udaraLsedang'] = $this->Lower_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1008.9, 1009.1, 1012.3, 1012.7);
      $data_fuzzifikasi[$i]['data_tekanan_udaraUtinggi'] = $this->Upper_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1012.5, 1012.9, 1014, 1014);
      $data_fuzzifikasi[$i]['data_tekanan_udaraLtinggi'] = $this->Lower_trapmf($data_meteorologi[$i]->data_tekanan_udara, 1012.7, 1013.1, 1014, 1014);

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
    $data_fuzzifikasi = $this->m_fuzzy->getData();

    if(empty($data_fuzzifikasi)){
            redirect(site_url('admin/fuzzy'));
            return;
    }

    for( $i=0; $i< count($data_fuzzifikasi); $i++ ){

      $data[$i]['data_id'] = $data_fuzzifikasi[$i]->data_id;

      //Rule 1
      if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 2
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 3
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 4
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 5
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 6
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 7
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 8
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 9
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 10
      if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 11
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 12
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 13
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 14
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 15
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 16
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 17
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 18
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 19
      if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Sedang'; 
      }

      //Rule 20
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Sedang';
      }

      //Rule 21
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Sedang';
      }

      //Rule 22
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Sedang'; 
      }

      //Rule 23
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Sedang'; 
      }

      //Rule 24
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Sedang'; 
      }

      //Rule 25
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Agak Lebat'; 
      }

      //Rule 26
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Agak Lebat'; 
      }

      //Rule 27
      else if($data_fuzzifikasi[$i]->data_temperaturUsejuk != 0 && $data_fuzzifikasi[$i]->data_temperaturLsejuk != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUsejuk * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLsejuk * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Agak Lebat'; 
      }

      //Rule 28
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 29
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 30
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 31
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 32
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 33
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 34
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 35
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 36
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 37
      if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 38
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 39
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 40
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 41
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 42
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 43
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 44
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 45
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 46
      if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 47
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 48
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 49
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 50
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 51
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 52
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 53
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 54
      else if($data_fuzzifikasi[$i]->data_temperaturUnormal != 0 && $data_fuzzifikasi[$i]->data_temperaturLnormal != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUnormal * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLnormal * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 55
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 56
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 57
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 58
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 59
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 60
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 61
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 62
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 63
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUkering != 0 && $data_fuzzifikasi[$i]->data_kelembapanLkering != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUkering * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLkering * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 64
      if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 65
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 66
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 67
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 68
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 69
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 70
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 71
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 72
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUlembab != 0 && $data_fuzzifikasi[$i]->data_kelembapanLlembab != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLlembab * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 73
      if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 74
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 75
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLlambat * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan';
      }

      //Rule 76
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 77
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 78
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLagakkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 79
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUrendah;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLrendah;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 80
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUsedang;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLsedang;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }

      //Rule 81
      else if($data_fuzzifikasi[$i]->data_temperaturUpanas != 0 && $data_fuzzifikasi[$i]->data_temperaturLpanas != 0 &&
        $data_fuzzifikasi[$i]->data_kelembapanUbasah != 0 && $data_fuzzifikasi[$i]->data_kelembapanLbasah != 0 &&
      $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang != 0 && $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi != 0 && $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtinggi != 0)
      {
        $upper = $data_fuzzifikasi[$i]->data_temperaturUpanas * $data_fuzzifikasi[$i]->data_kelembapanUbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginUkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariUtinggi;
        $lower = $data_fuzzifikasi[$i]->data_temperaturLpanas * $data_fuzzifikasi[$i]->data_kelembapanLbasah * $data_fuzzifikasi[$i]->data_kecepatan_anginLkencang * $data_fuzzifikasi[$i]->data_lama_penyinaran_matahariLtingi;

        $data[$i]['deffuzifikasi'] = ($upper + $lower)/2;
        $data[$i]['rules'] = 'Ringan'; 
      }
    }
    echo var_dump($data);

    // echo "<br>".$data[9]['rules'];
  }


  public function km(){
    $fu = 1;
    $fl = 0.3072;
    $yu = 19.9;
    $yl = 5;

    // $fn = ($fu+$fl)/2;

    $yl = ($fu*$yl)/$fu;
    $yr = ($fl*$yu)/$fl;

    $y = ($yl+$yr)/2;

    echo $yl.' + '.$yr.' = '.$y;

  }

}