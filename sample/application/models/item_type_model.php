<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_type_model extends CI_Model
    {
        function __construct() 
        {
            parent::__construct();
            
            $this->load->database();
        }
        
        public function add_item_types($it, $cc, $bc, $uc, $d)
        {
            $sql = "INSERT INTO ta_ims_item_type(Item_Type, Category_Code, Bulk_Code, Unit_Code, Description) VALUES('$it', $cc, $bc, $uc, '$d')";
            
            $this->db->query($sql);

            return $this->db->affected_rows();
        }
    }
?>