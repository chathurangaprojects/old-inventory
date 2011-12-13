<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Purchase_order extends CI_Controller
    {
        var $make_po = 4;
        
        function __construct()
        {
            parent::__construct();
            
            $this->load->library('session');
            
            $this->load->model('privileges/Privilege_model');
        }
        
        private function __last_word($string)
        {
            if(strrpos($string, " "))
            {
                $letztes_wort_anfang = strrpos($string, " ") + 1;
                $laenge_letztes_wort = strlen($string) - $letztes_wort_anfang;
                $letztes_wort = substr($string, $letztes_wort_anfang, $laenge_letztes_wort);
                
                return $letztes_wort;
            }
            else
            {
                return $string;
            }
        }
        
        public function make_po()
        {
            if($this->session->userdata('logged_in'))
            {
                $this->load->model('Create_po_model');
                
                $res1 = $this->Create_po_model->load_departments();
                $data['depts'] = $res1;
                
                $res2 = $this->Create_po_model->load_employees();
                $data['emps'] = $res2;
                
                $res3 = $this->Create_po_model->load_pay_type();
                $data['pay_types'] = $res3;
                
                $res4 = $this->Create_po_model->load_currency();
                $data['currency'] = $res4;
                
                $res5 = $this->Create_po_model->load_units();
                $data['units'] = $res5;
                
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->make_po))
                {
                    $data['title'] = "Create New Purchase Order";

                    $this->load->view('ssi/header_po.php', $data);
                    $this->load->view('ssi/navigation.php');
                    $this->load->view('ssi/search.php');
                    $this->load->view('ssi/sub_navigation.php');
                    $this->load->view('ssi/top_buttons.php');
                    $this->load->view('ssi/contents/po/create_po_request.php', $data);
                    $this->load->view('ssi/sidebar.php');
                    $this->load->view('ssi/footer.php');
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php', $data);
                    $this->load->view('ssi/navigation.php');
                    $this->load->view('ssi/search.php');
                    $this->load->view('ssi/sub_navigation.php', $data);
                    $this->load->view('ssi/top_buttons.php');
                    $this->load->view('ssi/errors/error_page.php', $data);
                    $this->load->view('ssi/sidebar.php');
                    $this->load->view('ssi/footer.php');
                }
            }
            else
            {
                $this->load->view('login_view');
            }
        }
        
        public function load_suppliers()
        {
            if($this->session->userdata('logged_in'))
            {
                $this->load->model('Create_po_model');
                
                $res = $this->Create_po_model->load_suppliers(strtolower($_GET["q"]));
                
                if(! empty($res))
                {
                    foreach ($res->result_array() as $row)
                    {
                        $sup = $row['Supplier_Name'] . ' - ' . $row['Supplier_Code'];
                        
                        echo "$sup\n";
                    }
                }
            }
            else
            {
                $this->load->view('login_view');
            }
        }
        
        public function add_empty_po()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->make_po))
                {
                    $Supplier_Code = $this->__last_word(trim($_POST['sn']));
                    $Order_Date = $_POST['od'];
                    $Expected_Date = $_POST['ed'];
                    $Quote_No = $_POST['qn'];
                    $Attn = $_POST['a'];
                    $Requested_Dept = $_POST['d'];
                    $Requested_By = $_POST['rb'];
                    $Created_By = 1;
                    $Payment_Type_Code = $_POST['pt'];
                    $Currency_Code = $_POST['c'];
                    $Currency_Rate = $_POST['cr'];
                    $PO_Purpose = $_POST['pop'];
                    $PO_Remarks = $_POST['por'];
                    $PO_Payment_Remarks = $_POST['pr'];
                    
                    $this->load->model('Create_po_model');
                
                    $res = $this->Create_po_model->add_empty_po($Supplier_Code, $Order_Date, $Expected_Date, $Quote_No, $Attn, $Requested_Dept, $Requested_By, $Created_By, $Currency_Code, $Currency_Rate, $Payment_Type_Code, $PO_Purpose, $PO_Remarks, $PO_Payment_Remarks); //add_empty_po($sn, $od, $ed, $qn, $a, $d, $rb, $pt, $c, $cr, $pr, $pop, $por);
                    
                    echo $res;
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php', $data);
                    $this->load->view('ssi/navigation.php');
                    $this->load->view('ssi/search.php');
                    $this->load->view('ssi/sub_navigation.php', $data);
                    $this->load->view('ssi/top_buttons.php');
                    $this->load->view('ssi/errors/error_page.php', $data);
                    $this->load->view('ssi/sidebar.php');
                    $this->load->view('ssi/footer.php');
                    
                    echo "b";
                }
            }
            else
            {
                $this->load->view('login_view');
            }
        }
        
        public function select_conv_rate()
        {
            $this->load->model('Create_po_model');
                
            echo $this->Create_po_model->select_conv_rate($_POST['cc']);
        }
        
        public function add_items_to_po()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->make_po))
                {
                    /*
                    
                    $Supplier_Code = $this->__last_word(trim($_POST['sn']));
                    $Order_Date = $_POST['od'];
                    $Expected_Date = $_POST['ed'];
                    $Quote_No = $_POST['qn'];
                    $Attn = $_POST['a'];
                    $Requested_Dept = $_POST['d'];
                    $Requested_By = $_POST['rb'];
                    $Created_By = 1;
                    $Payment_Type_Code = $_POST['pt'];
                    $Currency_Code = $_POST['c'];
                    $Currency_Rate = $_POST['cr'];
                    $PO_Purpose = $_POST['pop'];
                    $PO_Remarks = $_POST['por'];
                    $PO_Payment_Remarks = $_POST['pr'];
                    
                    $this->load->model('Create_po_model');
                
                    echo $this->Create_po_model->add_items_to_po();
                    
                    */
                    
                    $PO_No = $_POST['pono'];
                    $Item_Code = $this->__last_word(trim($_POST['ic']));
                    $Unit = $_POST['u'];
                    $Unit_Price = $_POST['up'];
                    $Quantity = $_POST['q'];
                    
                    if(empty($_POST['d']))
                    {
                        $Discount = '0';
                    }
                    else
                    {
                        $Discount = $_POST['da'];
                    }
                    
                    if(empty($_POST['da']))
                    {
                        $Discount_Amount = '0';
                    }
                    else
                    {
                        $Discount_Amount = $_POST['da'];
                    }
                    
                    $Item_Value = $_POST['iv'];
                    
                    if(empty($_POST['it']))
                    {
                        $Ind_Tax = '0';
                    }
                    else
                    {
                        $Ind_Tax = $_POST['it'];
                    }
                    
                    if(empty($_POST['tv']))
                    {
                        $Tax_Value = '0';
                    }
                    else
                    {
                        $Tax_Value = $_POST['tv'];
                    }
                    
                    $Description = $_POST['desc'];
                    
                    $this->load->model('Create_po_model');
                
                    echo $this->Create_po_model->add_items_to_po($PO_No, $Item_Code, $Unit, $Unit_Price, $Quantity, $Discount, $Discount_Amount, $Item_Value, $Ind_Tax, $Tax_Value, $Description);
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php', $data);
                    $this->load->view('ssi/navigation.php');
                    $this->load->view('ssi/search.php');
                    $this->load->view('ssi/sub_navigation.php', $data);
                    $this->load->view('ssi/top_buttons.php');
                    $this->load->view('ssi/errors/error_page.php', $data);
                    $this->load->view('ssi/sidebar.php');
                    $this->load->view('ssi/footer.php');
                }
            }
            else
            {
                $this->load->view('login_view');
            }
        }
        
        public function get_po_items()
        {
?>

            <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/custom.js"></script>
            
<?php
            $pono = trim($_POST['pono']);
            
            $this->load->model('Create_po_model');
                
            $result = $this->Create_po_model->get_po_items($pono);
            
            if(!empty($result))
            {
                echo '<table width="100%">';
                echo '<tr style="background-color: #CDB79E;height: 25px;margine: 5px;" valign="middle">';
                //echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Item Code</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Item Description</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Quantity</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Unit</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Price</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Item Value</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Discount %</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Discount Value</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Ind Tax %</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Ind Tax Value</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Net Value</th>';
                echo '<th style="padding: 5px 5px 5px 0;font-weight:bold;">Action</th>';
                echo '</tr>';
                
                $i = 1;
                
                foreach ($result->result_array() as $row)
                {
                    $iv = ((floatval($row['Unit_Price']) - (floatval($row['Unit_Price']) * floatval($row['Discount']) / 100) + (floatval(floatval($row['Unit_Price']) - (floatval($row['Unit_Price']) * floatval($row['Discount']) / 100)) * floatval($row['Ind_Tax']) / 100)) * floatval($row['Quantity'])) - floatval($row['Discount_Value']) + floatval($row['Tax_Value']);
                    
                    $i = 1 - $i;
                    
                    if($i == 0)
                    {
                        echo '<tr style="background-color: #FFFFFF;">';
                    }
                    else
                    {
                        echo '<tr style="background-color: #F5F5DC;">';
                    }
                    
                    //echo '<td style="padding: 5px 5px 5px 0;">' . $row['Master_Item_Code'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Item_Name'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Quantity'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Description'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Unit_Price'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Item_Value'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Discount'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Discount_Value'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Ind_Tax'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $row['Tax_Value'] . '</td>';
                    echo '<td style="padding: 5px 5px 5px 0;">' . $iv . '<input type="hidden" id="net_val_' . $row['Master_Item_Code'] . '" name="txt_net_val_' . $row['Master_Item_Code'] . '" value="' . $iv . '"/></td>';
                    echo '<td style="padding: 5px 5px 5px 0;">

                            <a class="lnk_edit_item" href="#" title="Edit Item" onclick="load_item_to_edit(' . $row['Master_Item_Code'] . ');">
                                <img src="' . base_url() . 'resources/images/edit_item.png" alt="Edit Item"/>
                            </a>

                            <a class="lnk_delete_item" href="#" onclick="delete_po_items(' . $row['Master_Item_Code'] . ');" title="Delete Item">
                                <img src="' . base_url() . 'resources/images/delete_item.png" alt="Delete"/>
                            </a>
                            
                            <a class="lnk_read_more" href="#" title="Read More">
                                <img src="' . base_url() . 'resources/images/read_more.png" alt="Read More"/>
                            </a>
                        </td>';
                    echo '</tr>';
                }
                
                echo '</table>';
            }
        }
        
        public function delete_po_items()
        {
            $this->load->model('Create_po_model');
                
            echo $this->Create_po_model->delete_po_items($_POST['pono'], $_POST['ic']);
        }
    }
?>