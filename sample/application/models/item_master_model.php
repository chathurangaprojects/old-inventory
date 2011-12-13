<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_master_model extends CI_Model
    {
        function __construct() 
        {
            parent::__construct();
            
            $this->load->database();
        }
        
        function load_items($type)
        {
            $val = explode(' ', trim($type));

            $qry = '';

            $i = 0;
            while($i < count($val))
            {
                if($i == 0)
                {
                    $qry = "ta_ims_item_type.Item_Type LIKE '%" . $val[$i] . "%'";
                }
                else
                {
                    $qry = $qry . " AND ta_ims_item_type.Item_Type LIKE '%" . $val[$i] . "%'";
                }

                $i += 1;
            }

            //$sql = "SELECT * FROM ta_ims_item_type WHERE " . trim($qry) . " OR ta_ims_item_type.Description LIKE '%" . trim($type) . "%'";
            
            $sql = "SELECT ta_ims_item_type.*, ta_ims_main_category.Category_Name FROM ta_ims_item_type INNER JOIN ta_ims_main_category ON ta_ims_item_type.Category_Code = ta_ims_main_category.Category_Code WHERE " . trim($qry) . " OR ta_ims_item_type.Description LIKE '%" . trim($type) . "%'";
            
            //echo $sql;

            ///$sql = "SELECT * FROM ta_ims_item_type WHERE Item_Type LIKE '%$type%' OR Description LIKE '%$type%'";

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
        
        function load_item_names($item_name)
        {
            $val = explode(' ', trim($item_name));

            $qry = '';

            $i = 0;
            while($i < count($val))
            {
                if($i == 0)
                {
                    $qry = "ta_ims_item_master.Item_Name LIKE '%" . $val[$i] . "%'";
                }
                else
                {
                    $qry = $qry . " AND ta_ims_item_master.Item_Name LIKE '%" . $val[$i] . "%'";
                }

                $i += 1;
            }
            //$sql = "SELECT ta_ims_item_type.*, ta_ims_main_category.Category_Name FROM ta_ims_item_type INNER JOIN ta_ims_main_category ON ta_ims_item_type.Category_Code = ta_ims_main_category.Category_Code WHERE " . trim($qry) . " OR ta_ims_item_type.Description LIKE '%" . trim($type) . "%'";
            $sql = "SELECT * FROM ta_ims_item_master WHERE " . trim($qry) . " ORDER BY Item_Name ASC";

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
        
        public function add_items($in, $itc, $pic, $desc, $rol, $roq, $ec, $ip)
        {
            $this->db->trans_begin();
            
            $sql = "INSERT INTO ta_ims_item_master(Item_Name, Type_Code, Picture, Description, R_Level, R_Qty, Employee_Code) VALUES('$in', $itc, '$pic', '$desc', $rol, $roq, $ec)";

            $res = $this->db->query($sql);
            
            $imid = $this->db->insert_id();
            
            $val = explode(',', trim($ip));
            
            $i = 0;
            
            while($i < count($val))
            {
                if(! empty($val[$i]))
                {
                    $this->db->query("INSERT INTO ta_ims_item_property_value(Master_Item_Code, Property_Value_Code) VALUES($imid, $val[$i])");
                    
                    echo $val[$i] . "<br/>";
                }
                
                $i++;
            }
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
               
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                
                return TRUE;
            }
        }
        
        public function edit_items($ic, $in, $itc, $pic, $desc, $rol, $roq, $ec, $ip)
        {
            //$this->db->trans_begin();
            
            $sql = "UPDATE ta_ims_item_master SET Item_Name = '$in', Type_Code = $itc, Picture = '$pic', Description = '$desc', R_Level = $rol, R_Qty = $roq, Employee_Code = $ec WHERE Master_Item_Code = $ic";

            $res = $this->db->query($sql);
            
            /*
            $imid = $this->db->insert_id();
            
            $val = explode(',', trim($ip));
            
            $i = 0;
            
            while($i < count($val))
            {
                if(! empty($val[$i]))
                {
                    $this->db->query("INSERT INTO ta_ims_item_property_value(Master_Item_Code, Property_Value_Code) VALUES($imid, $val[$i])");
                    
                    echo $val[$i] . "<br/>";
                }
                
                $i++;
            }
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
               
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                
                return TRUE;
            }
            */
        }
        
        public function get_item_name($item_code)
        {
            $sql = "SELECT * FROM ta_ims_item_master WHERE Master_Item_Code='".$item_code."' ";

            $results = $this->db->query($sql);

            
         //  echo "chaa333".count($results);
            
         //  die();
            
            if(count($results) > 0)
            {
                
               // echo 44444  ;die();
                
              //  print_r($results->result());die();
                
                foreach ($results->result() as $row)
                {
                    return trim($row->Item_Name);
                }
            }
            else
            {
                return "No item found.";
            }
        }
        
        public function get_item_type($item_code)
        {
            $sql = "SELECT * FROM ta_ims_item_master INNER JOIN ta_ims_item_type ON ta_ims_item_master.Type_Code = ta_ims_item_type.Type_Code INNER JOIN ta_ims_main_category ON ta_ims_item_type.Category_Code = ta_ims_main_category.Category_Code WHERE ta_ims_item_master.Master_Item_Code = " . $item_code;

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
        
        public function get_item_description($item_code)
        {
            $sql = "SELECT * FROM ta_ims_item_master WHERE Master_Item_Code = " . $item_code;

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
    }
?>