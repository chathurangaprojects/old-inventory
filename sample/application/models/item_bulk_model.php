<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_bulk_model extends CI_Model
    {
        function __construct() 
        {
            parent::__construct();
            
            $this->load->database();
        }
        
        public function load_bulk_type()
        {
            $sql = "SELECT * FROM ta_ims_bulk_type";

            $results = $this->db->query($sql);

            return $results->result();
        }
    }
?>