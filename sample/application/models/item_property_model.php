<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_property_model extends CI_Model
    {
        function __construct() 
        {
            parent::__construct();
            
            $this->load->database();
        }
        
        public function add_item_property($it, $p, $d)
        {
            $sql = "INSERT INTO ta_ims_property(Type_Code, Property, Property_Description) VALUES($it, '$p', '$d')";
            
            $this->db->query($sql);

            return $this->db->affected_rows();
        }
        
        public function get_item_property($tc)
        {
            $sql = "SELECT * FROM ta_ims_property WHERE Type_Code = $tc";

            $results = $this->db->query($sql);

            if($results->num_rows() > 0)
            {
                return $results;
            }
            else
            {
                return NULL;
            }
        }
		
		public function get_item_property2($tc, $ic)
        {
            $sql = "SELECT * FROM ta_ims_property WHERE Type_Code = $tc";
			
			//$sql = "SELECT ta_ims_property.*, ta_ims_item_property_value.* FROM ta_ims_property INNER JOIN ta_ims_property_value ON ta_ims_property.Propertiy_Code = ta_ims_property_value.Propertiy_Code INNER JOIN ta_ims_item_property_value ON ta_ims_property_value.Property_Value_Code = ta_ims_item_property_value.Property_Value_Code WHERE ta_ims_property.Type_Code = $tc and ta_ims_item_property_value.Master_Item_Code = $ic";

            $results = $this->db->query($sql);

            if($results->num_rows() > 0)
            {
                return $results;
            }
            else
            {
                return NULL;
            }
        }
        
        public function load_property_values($pc)
        {
            $sql = "SELECT * FROM ta_ims_property_value WHERE Propertiy_Code = $pc";

            $results = $this->db->query($sql);

            if($results->num_rows() > 0)
            {
                return $results;
            }
            else
            {
                return NULL;
            }
        }
        
        public function add_item_property_value($pc, $pv)
        {
            $sql = "INSERT INTO ta_ims_property_value(Propertiy_Code, Propertiy_Values) VALUES($pc, '$pv')";
            
            $this->db->query($sql);

            if($this->db->affected_rows() == 1)
            {
                return $this->db->insert_id();
            }
            else
            {
                return 0;
            }
        }
        
        public function select_prop($ic, $pc)
        {
            $query = $this->db->query('SELECT ta_ims_item_master.*, ta_ims_property_value.* FROM ta_ims_item_master INNER JOIN ta_ims_item_property_value ON ta_ims_item_master.Master_Item_Code = ta_ims_item_property_value.Master_Item_Code INNER JOIN ta_ims_property_value ON ta_ims_item_property_value.Property_Value_Code = ta_ims_property_value.Property_Value_Code WHERE ta_ims_item_master.Master_Item_Code = ' . $ic . ' AND ta_ims_property_value.Propertiy_Code = ' . $pc);

            $row = $query->row();
            
            if(! empty($row->Propertiy_Values))
            {
                return $row->Propertiy_Values;
            }
            else
            {
                return '';
            }
        }
    }
?>