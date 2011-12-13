<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Create_po_model extends CI_Model
    {
        function __construct() 
        {
            parent::__construct();
            
            $this->load->database();
        }
        
        public function load_suppliers($supplier_name)
        {
            $val = explode(' ', trim($supplier_name));

            $qry = '';

            $i = 0;
            while($i < count($val))
            {
                if($i == 0)
                {
                    $qry = "ta_ims_supplier_header.Supplier_Name LIKE '%" . $val[$i] . "%'";
                }
                else
                {
                    $qry = $qry . " AND ta_ims_supplier_header.Supplier_Name LIKE '%" . $val[$i] . "%'";
                }

                $i += 1;
            }
            
            $sql = "SELECT * FROM ta_ims_supplier_header WHERE " . trim($qry) . " AND Active = 1 ORDER BY Supplier_Name ASC";

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
        
        public function load_departments()
        {
            $sql = "SELECT * FROM ta_ims_department WHERE Department_Code != 1 AND Active = 1";

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
        
        public function load_employees()
        {
            $sql = "SELECT * FROM ta_ims_employee";

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
        
        public function load_pay_type()
        {
            $sql = "SELECT * FROM ta_ims_payment_type";

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
        
        public function load_currency()
        {
            $sql = "SELECT * FROM ta_ims_currency";

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
        
        public function load_units()
        {
            $sql = "SELECT * FROM ta_ims_unit";

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
        
        public function add_empty_po($Supplier_Code, $Order_Date, $Expected_Date, $Quote_No, $Attn, $Requested_Dept, $Requested_By, $Created_By, $Currency_Code, $Currency_Rate, $Payment_Type_Code, $PO_Purpose, $PO_Remarks, $PO_Payment_Remarks) //($Supplier_Code, $Order_Date, $Expected_Date, $Quote_No, $Attn, $Requested_Dept, $Requested_By, $Created_By, $Payment_Type_Code, $Currency_Code, $Currency_Rate, $PO_Payment_Remarks, $PO_Purpose, $PO_Remarks,                 $Discount, $Discount_Value, $PO_Total, $Payment_Status, $PO_Close_Date, $PO_Close_By, $PO_Close_Remarks, $PO_Cancel_Date, $PO_Cancel_By, $PO_Cancel_Remarks, $Print_Original, $Status_Code)
        {
            //$sql = "INSERT INTO ta_ims_po_header(Supplier_Code, Order_Date, Expected_Date, Quote_No, Attn, Requested_Dept, Requested_By, Created_By, Discount, Discount_Value, PO_Total, Currency_Code, Currency_Rate, Payment_Type_Code, Payment_Status, PO_Purpose, PO_Remarks, PO_Payment_Remarks, PO_Close_Date, PO_Close_By, PO_Close_Remarks, PO_Cancel_Date, PO_Cancel_By, PO_Cancel_Remarks, Print_Original, Status_Code) VALUES($Supplier_Code, '$Order_Date', '$Expected_Date', '$Quote_No', '$Attn', '$Requested_Dept', $Requested_By, $Created_By, $Discount, $Discount_Value, $PO_Total, $Currency_Code, $Currency_Rate, $Payment_Type_Code, $Payment_Status, '$PO_Purpose', '$PO_Remarks', '$PO_Payment_Remarks', '$PO_Close_Date', $PO_Close_By, '$PO_Close_Remarks', '$PO_Cancel_Date', $PO_Cancel_By, '$PO_Cancel_Remarks', $Print_Original, $Status_Code)";
            //$sql = "INSERT INTO ta_ims_po_header(Supplier_Code, Order_Date, Expected_Date, Quote_No, Attn, Requested_Dept, Requested_By, Created_By, Currency_Code, Currency_Rate, Payment_Type_Code, Payment_Status, PO_Purpose, PO_Remarks, PO_Payment_Remarks, Status_Code)
            //VALUES($Supplier_Code, '$Order_Date', '$Expected_Date', '$Quote_No', '$Attn', $Requested_Dept, $Requested_By, $Created_By, $Currency_Code, $Currency_Rate, '$PO_Payment_Remarks', '$PO_Purpose', '', '', '', '1')";
            
            $sql = "INSERT INTO ta_ims_po_header(Supplier_Code, Order_Date, Expected_Date, Quote_No, Attn, Requested_Dept, Requested_By, Created_By, PO_Total, Currency_Code, Currency_Rate, Payment_Type_Code, Payment_Status, PO_Purpose, PO_Remarks, PO_Payment_Remarks, Print_Original, Status_Code) VALUES($Supplier_Code, '$Order_Date', '$Expected_Date', '$Quote_No', '$Attn', $Requested_Dept, $Requested_By, $Created_By, 0, $Currency_Code, $Currency_Rate, $Payment_Type_Code, 0, '$PO_Purpose', '$PO_Remarks', '$PO_Payment_Remarks', 0, 1)";
            
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
        
        public function select_conv_rate($cc)
        {
            $sql = "SELECT * FROM ta_ims_currency WHERE Currency_Code = $cc";

            $query = $this->db->query($sql);
            $row = $query->row();
            
            return $row->Conversion_Rate;
        }
        
        public function add_items_to_po($PO_No, $Item_Code, $Unit, $Unit_Price, $Quantity, $Discount, $Discount_Amount, $Item_Value, $Ind_Tax, $Tax_Value, $Description)
        {
            //$sql = "INSERT INTO ta_ims_po_header(Supplier_Code, Order_Date, Expected_Date, Quote_No, Attn, Requested_Dept, Requested_By, Created_By, PO_Total, Currency_Code, Currency_Rate, Payment_Type_Code, Payment_Status, PO_Purpose, PO_Remarks, PO_Payment_Remarks, Print_Original, Status_Code) VALUES($Supplier_Code, '$Order_Date', '$Expected_Date', '$Quote_No', '$Attn', $Requested_Dept, $Requested_By, $Created_By, 0, $Currency_Code, $Currency_Rate, $Payment_Type_Code, 0, '$PO_Purpose', '$PO_Remarks', '$PO_Payment_Remarks', 0, 1)";
            
            $sql = "INSERT INTO ta_ims_po_details(Order_Code, Master_Item_Code, Unit, Unit_Price, Quantity, Discount, Discount_Value, Item_Value, Ind_Tax, Tax_Value, Description, Breakable, Breakable_Unit, Breakable_Qty) VALUE($PO_No, $Item_Code, $Unit, $Unit_Price, $Quantity, $Discount, $Discount_Amount, $Item_Value, $Ind_Tax, $Tax_Value, '$Description', 1, 1, 1)";
            
            echo $sql;
            
            $this->db->query($sql);
            
            return $sql;
            
            //return $this->db->affected_rows();

//            if($this->db->affected_rows() == 1)
//            {
//                return $this->db->insert_id();
//            }
//            else
//            {
//                return 0;
//            }
            
//            return "$PO_No + '----------' + $Item_Code + '----------' + $Unit + '----------' + $Unit_Price + '----------' + $Quantity + '----------' + $Discount + '----------' + $Discount_Amount + '----------' + $Item_Value + '----------' + $Ind_Tax + '----------' + $Tax_Value + '----------' + $Description";
        }
        
        public function get_po_items($pono)
        {
            $sql = "SELECT ta_ims_po_details.*, ta_ims_item_master.Item_Name, ta_ims_unit.Description FROM ta_ims_po_details INNER JOIN ta_ims_item_master ON ta_ims_po_details.Master_Item_Code = ta_ims_item_master.Master_Item_Code INNER JOIN ta_ims_unit ON ta_ims_po_details.Unit = ta_ims_unit.Unit_Code WHERE Order_Code = $pono";

            $query = $this->db->query($sql);
            
            return $query;
        }
        
        public function get_po_item($pono, $ic)
        {
            $sql = "SELECT ta_ims_po_details.*, ta_ims_item_master.Item_Name, ta_ims_unit.Description FROM ta_ims_po_details INNER JOIN ta_ims_item_master ON ta_ims_po_details.Master_Item_Code = ta_ims_item_master.Master_Item_Code INNER JOIN ta_ims_unit ON ta_ims_po_details.Unit = ta_ims_unit.Unit_Code WHERE ta_ims_po_details.Order_Code = $pono AND ta_ims_po_details.Master_Item_Code = $ic";

            $query = $this->db->query($sql);
            
            return $query;
        }
        
        public function delete_po_items($pono, $ic)
        {
            $sql = "DELETE FROM ta_ims_po_details WHERE Order_Code = $pono AND Master_Item_Code = $ic";

            $this->db->query($sql);

            return $this->db->affected_rows();
        }
    }
?>