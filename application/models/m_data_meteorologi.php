<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_meteorologi extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function inputData($data)
    {
        return $this->db->insert('data_meteorologi', $data);
    }

    public function importData($data)
    {
        return $this->db->insert_batch('data_meteorologi', $data);
    }

    public function getData( $data_id = -1 )
    {
        $sql = "
            SELECT * FROM data_meteorologi
        ";
        if( $data_id != -1 ){
            $sql .= "
                where data_id = '$data_id'
            ";  
        }
        return $query = $this->db->query($sql)->result();
    }

    public function updateData( $data_meteorologi, $data_meteorologi_param )
    {
        return  $this->db->update('data_meteorologi', $data_meteorologi, $data_meteorologi_param);
    }

    public function deleteData( $data_meteorologi_param )
    {
        return $this->db->delete( "data_meteorologi" , $data_meteorologi_param);
    }

    public function count(  )
    {
        return $this->db->count_all("data_meteorologi");
    }

    public function clear()
    {
        return $query = $this->db->query( " TRUNCATE data_meteorologi " );
    }
}

?>
