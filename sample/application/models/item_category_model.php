<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_category_model extends CI_Model
    {
        function __construct() 
        {
            parent::__construct();
            
            $this->load->database();
        }
        
        public function load_categories()
        {
            $sql = "SELECT * FROM ta_ims_main_category";

            $results = $this->db->query($sql);

            return $results->result();
        }
    }
?>