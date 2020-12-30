<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_fuzzy extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getData( $data_id = -1 )
    {
        $sql = "
            SELECT * FROM data_meteorologi_fuzzifikasi
        ";
        if( $data_id != -1 ){
            $sql .= "
                where data_id = '$data_id'
            ";  
        }
        return $query = $this->db->query($sql)->result();
    }

    public function count(  )
    {
        return $this->db->count_all("data_prediksi");
    }

    public function getDataPrediksi( $data_id = -1 )
    {
        $sql = "
            SELECT * FROM data_prediksi
        ";
        if( $data_id != -1 ){
            $sql .= "
                where data_id = '$data_id'
            ";  
        }
        return $query = $this->db->query($sql)->result();
    }

    public function create($data_fuzzifikasi)
    {
        return $this->db->insert_batch('data_meteorologi_fuzzifikasi', $data_fuzzifikasi);
    }

    public function prediksi($data)
    {
        return $this->db->insert_batch('data_prediksi', $data);
    }

    public function clear()
    {
        return $query = $this->db->query( " TRUNCATE data_meteorologi_fuzzifikasi " );
    }

    public function kosongkan()
    {
        return $query = $this->db->query( " TRUNCATE data_prediksi " );
    }
}

?>
