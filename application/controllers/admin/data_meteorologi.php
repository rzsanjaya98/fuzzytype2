<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Meteorologi extends Admin_Controller {
  // class Home extends CI_Controller {

  public function __construct(){
      parent::__construct();
      // $this->output->enable_profiler(TRUE);
    // $this->load->model("m_login");
    // $this->load->model("m_register");
    // $this->load->model("m_admin");
    $this->load->model("m_fuzzy");
    $this->load->model("m_user");
    $this->load->model("m_data_meteorologi");
    $this->load->helper('array');
    $this->load->library("pagination");
  }

  public function index() 
  {
      $data['page_name'] = "Data Meteorologi";
    
      $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'));
      $data['data_meteorologi'] = $this->m_data_meteorologi->getData();
      $this->load->view("templates/header");
      $this->load->view("templates/sidebar");
      $this->load->view("view_admin/data_meteorologi/v_data_meteorologi",$data);
      $this->load->view("templates/footer");
    // }
  }

  public function input_data(){
    $data['page_name'] = "Input Data Meteorologi";
    $this->load->helper('form');  
    $this->load->library('form_validation');
    $config = array(
          array(   
                  'field' => 'data_tanggal',
                  'label' => 'Tanggal',
                  'rules' =>  'trim|required',    
                  'errors' => array(
                          'required' => 'tanggal harus di isi'   
                  ),
          ),
          array(
                  'field' => 'data_temperatur',
                  'label' => 'Temperatur',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Temperatur harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          array(
                  'field' => 'data_kelembapan',
                  'label' => 'Kelembapan',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Kelembapan harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          array(
                  'field' => 'data_lama_penyinaran_matahari',
                  'label' => 'Lama Penyinaran Matahari',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Lama Penyinaran Matahari harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          array(
                  'field' => 'data_kecepatan_angin',
                  'label' => 'Kecepatan Angin',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Kecepatan Angin harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          // array(
          //         'field' => 'data_tekanan_udara',
          //         'label' => 'Tekanan Udara',   
          //         'rules' => 'required|numeric',
          //         'errors' => array(  
          //                 'required' => 'Tekanan Udara harus di isi',
          //                 'numeric' => 'Pengisian hanya menggunakan angka'
          //         ),
          // ),
          array(
                  'field' => 'data_curah_hujan',
                  'label' => 'Curah Hujan',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Curah Hujan harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          )
       );

    $this->form_validation->set_rules($config);
    if($this->form_validation->run() == true){
      $dataEdit['data_tanggal'] = $this->input->post('data_tanggal');
      $dataEdit['data_temperatur'] = $this->input->post('data_temperatur');
      $dataEdit['data_kelembapan'] = $this->input->post('data_kelembapan');
      $dataEdit['data_lama_penyinaran_matahari'] = $this->input->post('data_lama_penyinaran_matahari');
      $dataEdit['data_kecepatan_angin'] = $this->input->post('data_kecepatan_angin');
      // $dataEdit['data_tekanan_udara'] = $this->input->post('data_tekanan_udara');
      $dataEdit['data_curah_hujan'] = $this->input->post('data_curah_hujan');
      $result = $this->m_data_meteorologi->inputData($dataEdit);
      if(!empty($result)){
        $this->session->set_flashdata('info', array(
                'from' => 1,
                'message' =>  'data berhasil ditambah'
            ));
        redirect(site_url('admin/data_meteorologi'));
      }else{
        $this->session->set_flashdata('info', array(
                'from' => 0,
                'message' =>  'terjadi kesalahan saat mengirim data'
            ));
        redirect(site_url('admin/data_meteorologi'));
      }
    }else{
      $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'));
      $this->load->view("templates/header");
      $this->load->view("templates/sidebar");
      $this->load->view("view_admin/data_meteorologi/v_input_data",$data);
      $this->load->view("templates/footer");
    }
  }

  public function update_data($data_id = null){
    $data['page_name'] = "Edit Data Meteorologi";
    $this->load->helper('form');  
    $this->load->library('form_validation');
    $config = array(
          array(   
                  'field' => 'data_tanggal',
                  'label' => 'Tanggal',
                  'rules' =>  'trim|required',    
                  'errors' => array(
                          'required' => 'tanggal harus di isi'   
                  ),
          ),
          array(
                  'field' => 'data_temperatur',
                  'label' => 'Temperatur',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Temperatur harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          array(
                  'field' => 'data_kelembapan',
                  'label' => 'Kelembapan',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Kelembapan harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          array(
                  'field' => 'data_lama_penyinaran_matahari',
                  'label' => 'Lama Penyinaran Matahari',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Lama Penyinaran Matahari harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          array(
                  'field' => 'data_kecepatan_angin',
                  'label' => 'Kecepatan Angin',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Kecepatan Angin harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          ),
          // array(
          //         'field' => 'data_tekanan_udara',
          //         'label' => 'Tekanan Udara',   
          //         'rules' => 'required|numeric',
          //         'errors' => array(  
          //                 'required' => 'Tekanan Udara harus di isi',
          //                 'numeric' => 'Pengisian hanya menggunakan angka'
          //         ),
          // ),
          array(
                  'field' => 'data_curah_hujan',
                  'label' => 'Curah Hujan',   
                  'rules' => 'required|numeric',
                  'errors' => array(  
                          'required' => 'Curah Hujan harus di isi',
                          'numeric' => 'Pengisian hanya menggunakan angka'
                  ),
          )
       );

    $this->form_validation->set_rules($config);
    if($this->form_validation->run() == true){
      $dataEdit['data_tanggal'] = $this->input->post('data_tanggal');
      $dataEdit['data_temperatur'] = $this->input->post('data_temperatur');
      $dataEdit['data_kelembapan'] = $this->input->post('data_kelembapan');
      $dataEdit['data_lama_penyinaran_matahari'] = $this->input->post('data_lama_penyinaran_matahari');
      $dataEdit['data_kecepatan_angin'] = $this->input->post('data_kecepatan_angin');
      // $dataEdit['data_tekanan_udara'] = $this->input->post('data_tekanan_udara');
      $dataEdit['data_curah_hujan'] = $this->input->post('data_curah_hujan');
      $data_param['data_id'] = $this->input->post('data_id');
      $result = $this->m_data_meteorologi->updateData($dataEdit, $data_param);
      if(!empty($result)){
        $this->session->set_flashdata('info', array(
                'from' => 1,
                'message' =>  'data berhasil diedit'
            ));
        redirect(site_url('admin/data_meteorologi'));
      }else{
        $this->session->set_flashdata('info', array(
                'from' => 0,
                'message' =>  'terjadi kesalahan saat mengirim data'
            ));
        redirect(site_url('admin/data_meteorologi'));
      }
    }else{
      if($data_id == null) redirect(site_url('admin/data_meteorologi'));

      $data['data_meteorologi'] = $this->m_data_meteorologi->getData($data_id);
      $data['user'] = $this->m_user->getUser($this->session->userdata('user_id'));
      $this->load->view("templates/header");
      $this->load->view("templates/sidebar");
      $this->load->view("view_admin/data_meteorologi/v_update_data",$data);
      $this->load->view("templates/footer");
    }
  }

  public function delete_data($data_id = null)
  {
    if( $data_id == null ) redirect(site_url('admin/data_meteorologi'));

    $data_param['data_id'] = $data_id;
    if($this->m_data_meteorologi->deleteData($data_param)){
        $this->session->set_flashdata('info', array(
            'from' => 1,
            'message' =>  'data berhasil dihapus'
          ));
          redirect(site_url('admin/data_meteorologi'));
          return;
    }
    $this->session->set_flashdata('info', array(
        'from' => 0,
        'message' =>  'terjadi kesalahan saat mengirim data'
      ));
      redirect(site_url('admin/data_meteorologi'));

  }

  public function import_data()
  {
    $data['page_name'] = "Import Data Meteorologi";
    // if( !($_POST) ) redirect(site_url(''));  

    $this->load->library('upload'); // Load librari upload
    $filename = "excel";
    $config['upload_path'] = './upload/datameteorologi/';
    $config['allowed_types'] = "xls|xlsx";
    $config['overwrite']="true";
    $config['max_size']="2048";
    $config['file_name'] = ''.$filename;
    $this->upload->initialize($config);

    if($this->upload->do_upload("document_file"))
    {
        $filename = $this->upload->data()["file_name"];
        // echo $filename;
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel.php';
        
        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('upload/datameteorologi/'.$filename); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        // Buat sebuah vari
        $data_meteorologi = array();
        $numrow = 1;
        foreach($sheet as $row){
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            if($numrow > 1 &&  !empty( $row['A'] ) ){
                $data_import["data_tanggal"] = $row['A'] ;
                $data_import["data_temperatur"] = $row['B'];
                $data_import["data_kelembapan"] = $row['C'];
                $data_import["data_lama_penyinaran_matahari"] = $row['D'];
                $data_import["data_kecepatan_angin"] = $row['E'];
                // $data_import["data_tekanan_udara"] = $row['F'];
                $data_import["data_curah_hujan"] = $row['F'];
                // Kita push (add) array data ke variabel data
                array_push($data_meteorologi, $data_import) ;
            }
            
            $numrow++; // Tambah 1 setiap kali looping
        }
        // echo var_dump($data_meteorologi);
        if($this->m_data_meteorologi->importData($data_meteorologi)){
            $this->session->set_flashdata('info', array(
                'from' => 1,
                'message' =>  'data berhasil diimport'
              ));
              redirect(site_url('admin/data_meteorologi'));
              return;
        }
        $this->session->set_flashdata('info', array(
            'from' => 0,
            'message' =>  'terjadi kesalahan saat mengimport data'
          ));
          redirect(site_url('admin/data_meteorologi'));

    }else{
      echo  $this->upload->display_errors();
      $this->load->view("templates/header");
      $this->load->view("templates/sidebar");
      $this->load->view("view_admin/data_meteorologi/v_import_data",$data);
      $this->load->view("templates/footer"); 
    }

  }

  public function deleteAll()
  {
    $result = $this->m_data_meteorologi->clear();
    $result = $this->m_fuzzy->kosongkan();
    $result = $this->m_fuzzy->clear();
    // if( $data_id == null ) redirect(site_url('admin/data_meteorologi'));
    if(!empty($result)){
        $this->session->set_flashdata('info', array(
            'from' => 1,
            'message' =>  'data berhasil dikosongkan'
          ));
          redirect(site_url('admin/data_meteorologi'));
          return;
    }
    $this->session->set_flashdata('info', array(
        'from' => 0,
        'message' =>  'terjadi kesalahan saat mengosongkan data'
      ));
      redirect(site_url('admin/data_meteorologi'));

  }

}