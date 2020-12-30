<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {
  // class Home extends CI_Controller {

  public function __construct(){
      parent::__construct();
      // $this->output->enable_profiler(TRUE);
    // $this->load->model("m_login");
    // $this->load->model("m_register");
    // $this->load->model("m_admin");
    $this->load->model("m_user");
    $this->load->model("m_data_meteorologi");
    $this->load->model("m_fuzzy");
    // $this->load->model("m_log");
    $this->load->helper('array');
    $this->load->library("pagination");
  }

  public function index() 
  {
    // if($this->session->userdata('user_id') == NULL)
    // {
    //     redirect('' . base_url());
    // }else{
      $data['page_name'] = "Beranda";
      $data['chart_name'] = "Data Prediksi Curah Hujan";
    
      $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'));
      $data['data_meteorologi_count'] = $this->m_data_meteorologi->count();
      $data['grafik'] = json_encode($this->m_fuzzy->getDataPrediksi());
      $data['rmse'] = $this->rmse();
      // $data['mae'] = $this->mae();
      // $data['mape'] = $this->mape();
      // $data['data_uji'] = $this->m_user->getUser( $this->session->userdata('user_id') );
    //   $this->load->view("_user/_template/header1");
    // //   $this->load->view("_user/_template/sidebar_menu");
    //       $this->load->view("_user/_template/content",$data);
    //   $this->load->view("_user/_template/footer");  
      $this->load->view("templates/header");
      $this->load->view("templates/sidebar");
      $this->load->view("view_admin/v_beranda",$data);
      // $this->load->view("_admin/_template/content",$data);
      $this->load->view("templates/footer");
    // }
  }

  public function rmse(){
    // $data['data_prediksi_count'] = $this->m_fuzzy->count();
    $data_prediksi = $this->m_fuzzy->getDataPrediksi();
    if(count($data_prediksi) != 0){ 
      $prediksi = 0;
      for ($i=0; $i < count($data_prediksi); $i++) { 
        // $prediksi = $prediksi + pow(($data_prediksi[$i]->data_curah_hujan - $data_prediksi[$i]->data_curah_hujan_prediksi), 2);
        $prediksi = $prediksi + pow(($data_prediksi[$i]->data_curah_hujan - $data_prediksi[$i]->data_curah_hujan_prediksi), 2);
      }
      $prediksi = $prediksi/count($data_prediksi);
      $prediksi = sqrt($prediksi);

      return $prediksi;
    }else{
      return 'Data belum ada';
    }

  }

  // public function mae(){
  //   $data_prediksi = $this->m_fuzzy->getDataPrediksi();
  //   if(count($data_prediksi) != 0){
  //     $prediksi = 0;
  //     for ($i=0; $i < count($data_prediksi); $i++) { 
  //       // $prediksi = $prediksi + pow(($data_prediksi[$i]->data_curah_hujan - $data_prediksi[$i]->data_curah_hujan_prediksi), 2);
  //       $prediksi = $prediksi + ($data_prediksi[$i]->data_curah_hujan - $data_prediksi[$i]->data_curah_hujan_prediksi);
  //     }
  //     $prediksi = $prediksi/count($data_prediksi);
  //     // $prediksi = sqrt($prediksi);

  //     return $prediksi;
  //   }else{
  //     return 'Data Belum ada';
  //   } 
  // }

  // public function mape(){
  //   $data_prediksi = $this->m_fuzzy->getDataPrediksi();
  //   if(count($data_prediksi) != 0){
  //     $prediksi = 0;
  //     for ($i=0; $i < count($data_prediksi); $i++) { 
  //       // $prediksi = $prediksi + pow(($data_prediksi[$i]->data_curah_hujan - $data_prediksi[$i]->data_curah_hujan_prediksi), 2);
  //       $prediksi = $prediksi + (($data_prediksi[$i]->data_curah_hujan - $data_prediksi[$i]->data_curah_hujan_prediksi)/$data_prediksi[$i]->data_curah_hujan_prediksi);
  //     }
  //     $prediksi = $prediksi*100;
  //     // $prediksi = sqrt($prediksi);

  //     return $prediksi;
  //   }else{
  //     return 'Data Belum ada';
  //   } 
  // }
}