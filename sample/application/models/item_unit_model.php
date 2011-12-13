<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_unit_model extends CI_Model
    {
        function __construct() 
        {
            parent::__construct();
            
            $this->load->database();
        }
        
        public function load_units()
        {
            $sql = "SELECT * FROM ta_ims_unit";

            $results = $this->db->query($sql);

            return $results->result();
        }
    }
?>