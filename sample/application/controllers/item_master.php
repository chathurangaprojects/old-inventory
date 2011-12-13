<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_master extends CI_Controller
    {
        var $pid = 1;
        var $add_type = 2;
        var $add_prop = 3;
        
        function __construct()
        {
            parent::__construct();

            $this->load->library('session');

            $this->load->model('privileges/Privilege_model');
            
            $this->load->helper(array('form', 'url'));
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

        public function load_items()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->model('Item_master_model');
                    
                    $res = $this->Item_master_model->load_items(strtolower($_GET["q"]));
                    
                    if(! empty($res))
                    {
                        foreach ($res->result_array() as $row)
                        {
                            if(! empty($row['Category_Name']))
                            {
                                $cname = $row['Item_Type'] . ' - ' . $row['Category_Name'] . ' - ' . $row['Type_Code'];
                            }
                            else
                            {
                               $cname = $row['Item_Type'] . ' - (Undefined) - ' . $row['Type_Code'];
                            }
                            echo "$cname\n";
                        }
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function load_item_names()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->model('Item_master_model');
                    
                    $res = $this->Item_master_model->load_item_names(strtolower($_GET["q"]));
                    
                    if(! empty($res))
                    {
                        foreach ($res->result_array() as $row)
                        {
                            $cname = $row['Item_Name'] . ' - ' . $row['Master_Item_Code'];
                            
                            echo "$cname\n";
                        }
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function upload_master_item()
        {
            $this->load->library('lcs_ims');
                    
            $uploaddir = 'uploads/';
            $unique_tag='lcs_ims';

            $filename = $unique_tag.'_'.time().'_'. basename($_FILES['uploadfile']['name']);
            $file = $uploaddir . $filename;

            if($this->lcs_ims->createThumb($_FILES['uploadfile']['tmp_name'], $uploaddir.$filename,675,525))
            {
              echo $filename;
            }
            else
            {
                echo "error";
            }
        }
        
        public function add_items()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->library('lcs_ims');
                    
                    $in = trim($_POST['txt_item_name']);
                    
                    $itc = $this->lcs_ims->get_last_word(trim($_POST['txt_item_type']));
                    
                    $ip = trim($_POST['txt_item_prp']);
                    
                    $pic = trim($_POST['txt_picture']);
                    
                    $desc = trim($_POST['txt_description']);
                    
                    if(! empty($_POST['txt_reorder_level']))
                    {
                        $rol = trim($_POST['txt_reorder_level']);
                    }
                    else
                    {
                        $rol = 0;
                    }
                    
                    if(! empty($_POST['txt_reorder_qty']))
                    {
                        $roq = trim($_POST['txt_reorder_qty']);
                    }
                    else
                    {
                        $roq = 0;
                    }
                    
                    $ec = $this->session->userdata('emp_id');

                    $this->load->model('Item_master_model');
                    
                    if($this->Item_master_model->add_items($in, $itc, $pic, $desc, $rol, $roq, $ec, $ip))
                    {
                        //echo 'OK';
                        
                        $data = array('title' => 'Master Item Added', 'desc' => 'Master Item Added Successfully', 'subtitle' => 'Master Item Added', 'msg' => 'Master Item added to the system successfully.<br/><br/>Now you can make purchase order to the inserted item.');
                    
                        $this->load->view('ssi/header.php');
                        $this->load->view('ssi/navigation.php');
                        $this->load->view('ssi/search.php');
                        $this->load->view('ssi/sub_navigation.php', $data);
                        $this->load->view('ssi/top_buttons.php');
                        $this->load->view('ssi/messages/message_page.php', $data);
                        $this->load->view('ssi/sidebar.php');
                        $this->load->view('ssi/footer.php');
                    }
                    else
                    {
                        //echo 'Error';
                        
                        $data = array('title' => 'Error Adding Master Item', 'desc' => 'Error Adding Master Item', 'subtitle' => 'Error Adding Master Item', 'msg' => 'Error adding master item to the system.<br/><br/>Please Try Again...');
                    
                        $this->load->view('ssi/header.php');
                        $this->load->view('ssi/navigation.php');
                        $this->load->view('ssi/search.php');
                        $this->load->view('ssi/sub_navigation.php', $data);
                        $this->load->view('ssi/top_buttons.php');
                        $this->load->view('ssi/messages/message_page.php', $data);
                        $this->load->view('ssi/sidebar.php');
                        $this->load->view('ssi/footer.php');
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function edit_items()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->library('lcs_ims');
                    
                    $ic = $this->lcs_ims->get_last_word(trim($_POST['txt_item_name']));
                    
                    $in = trim($_POST['txt_new_item_name']);
                    
                    $itc = $this->lcs_ims->get_last_word(trim($_POST['txt_item_type']));
                    
                    $ip = trim($_POST['txt_item_prp']);
                    
                    $pic = trim($_POST['txt_picture']);
                    
                    $desc = trim($_POST['txt_description']);
                    
                    if(! empty($_POST['txt_reorder_level']))
                    {
                        $rol = trim($_POST['txt_reorder_level']);
                    }
                    else
                    {
                        $rol = 0;
                    }
                    
                    if(! empty($_POST['txt_reorder_qty']))
                    {
                        $roq = trim($_POST['txt_reorder_qty']);
                    }
                    else
                    {
                        $roq = 0;
                    }
                    
                    $ec = $this->session->userdata('emp_id');

                    $this->load->model('Item_master_model');
                    
                    if(! $this->Item_master_model->edit_items($ic, $in, $itc, $pic, $desc, $rol, $roq, $ec, $ip))
                    {
                        $data = array('title' => 'Master Item Updated', 'desc' => 'Master Item Updated Successfully', 'subtitle' => 'Master Item Updated', 'msg' => 'Master Item updated successfully.');
                    
                        $this->load->view('ssi/header.php');
                        $this->load->view('ssi/navigation.php');
                        $this->load->view('ssi/search.php');
                        $this->load->view('ssi/sub_navigation.php', $data);
                        $this->load->view('ssi/top_buttons.php');
                        $this->load->view('ssi/messages/message_page.php', $data);
                        $this->load->view('ssi/sidebar.php');
                        $this->load->view('ssi/footer.php');
                    }
                    else
                    {
                        $data = array('title' => 'Error Updating Master Item', 'desc' => 'Error Updating Master Item', 'subtitle' => 'Error Updating Master Item', 'msg' => 'Error updating existing master item in the system.<br/><br/>Please Try Again...');
                    
                        $this->load->view('ssi/header.php');
                        $this->load->view('ssi/navigation.php');
                        $this->load->view('ssi/search.php');
                        $this->load->view('ssi/sub_navigation.php', $data);
                        $this->load->view('ssi/top_buttons.php');
                        $this->load->view('ssi/messages/message_page.php', $data);
                        $this->load->view('ssi/sidebar.php');
                        $this->load->view('ssi/footer.php');
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function add_item_types()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->add_type))
                {
                    $it = trim($_POST['txt_it']);
                    $cc = trim($_POST['cmb_cat']);
                    $bc = trim($_POST['cmb_bt']);
                    $uc = trim($_POST['cmb_unit']);
                    $d = trim($_POST['txt_description']);
                    
                    $this->load->model('Item_type_model');
                    
                    if($this->Item_type_model->add_item_types($it, $cc, $bc, $uc, $d) == 1)
                    {
                        redirect(base_url() . 'index.php/login/index');
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function add_item_property()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->add_prop))
                {
                    $it = $this->__last_word(trim($_POST['txt_item_type2']));
                    $p = trim($_POST['txt_property']);
                    $d = trim($_POST['txt_description']);
                    
                    //echo $it;
                    
                    $this->load->model('Item_property_model');
                    
                    if($this->Item_property_model->add_item_property($it, $p, $d) == 1)
                    {
                        redirect(base_url() . 'index.php/login/index');
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function edit_item_master()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $data['title'] = "Edit Master Items";
        
                    $data['pagetitle'] = "Edit Master Items";
                    
                    $this->load->model('Item_category_model');
                    $data['categories'] =  $this->Item_category_model->load_categories();
                    
                    $this->load->model('Item_bulk_model');
                    $data['bulk'] =  $this->Item_bulk_model->load_bulk_type();
                    
                    $this->load->model('Item_unit_model');
                    $data['unit'] =  $this->Item_unit_model->load_units();

                    $this->load->view('ssi/header.php', $data);
                    $this->load->view('ssi/navigation.php');
                    $this->load->view('ssi/search.php');
                    $this->load->view('ssi/sub_navigation.php', $data);
                    $this->load->view('ssi/top_buttons.php');
                    $this->load->view('ssi/contents/edit_master_item.php', $data);
                    $this->load->view('ssi/sidebar.php');
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function get_item_name()
        {
             $item_code= $_POST['item_code'];   
             
            // echo $item_code;die(); 
            
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    
                    //echo 555;
                    //die();
                    $this->load->model('Item_master_model');
                    
                      //  echo 555;
                    //die();
                    echo $this->Item_master_model->get_item_name($item_code);
                    
                   // die();
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function get_item_type()
        {
            $item_code= $_POST['item_code'];
            
            
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->model('Item_master_model');
                    
                    $result = $this->Item_master_model->get_item_type($item_code);
                    
                    if(!empty($result))
                    {
                        foreach ($result->result_array() as $row)
                        {
                            $it = '(Undefined)';
                            $mc = '(Undefined)';
                            
                            if(!empty($row['Item_Type']))
                            {
                                $it = $row['Item_Type'];
                            }
                            
                            if(!empty($row['Category_Name']))
                            {
                                $mc = $row['Category_Name'];
                            }
                            
                            echo $it . ' - ' . $mc . ' - ' . $row['Type_Code'];
                        }
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function get_item_image($item_code)
        {
            //$item_code = '4357'; // $_POST['item_code'];
            
            if(empty($item_code))
            {
                echo '';
                
                return;
            }
            
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->model('Item_master_model');
                    
                    $result = $this->Item_master_model->get_item_type($item_code);
                    
                    if(!empty($result))
                    {
                        foreach ($result->result_array() as $row)
                        {
                            $img = '';
                            
                            if(!empty($row['Picture']))
                            {
                                $img = $row['Picture'];
                            }
                            
                            echo $img;
                        }
                    }
                    else
                    {
                        echo "";
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function get_item_description()
        {
            $item_code= $_POST['item_code'];
            
            
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->model('Item_master_model');
                    
                    $result = $this->Item_master_model->get_item_description($item_code);
                    
                    if(!empty($result))
                    {
                        foreach ($result->result_array() as $row)
                        {
                            $msg = $row["Description"];
                        }
                        
                        echo $msg;
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function get_item_rol()
        {
            $item_code= $_POST['item_code'];
            
            
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->model('Item_master_model');
                    
                    $result = $this->Item_master_model->get_item_type($item_code);
                    
                    if(!empty($result))
                    {
                        foreach ($result->result_array() as $row)
                        {
                            $msg = $row["R_Level"];
                        }
                        
                        echo $msg;
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
        
        public function get_item_roq()
        {
            $item_code= $_POST['item_code'];
            
            
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
                    $this->load->model('Item_master_model');
                    
                    $result = $this->Item_master_model->get_item_type($item_code);
                    
                    if(!empty($result))
                    {
                        foreach ($result->result_array() as $row)
                        {
                            $msg = $row["R_Qty"];
                        }
                        
                        echo $msg;
                    }
                }
                else
                {
                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
                    
                    $this->load->view('ssi/header.php');
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
    }
?>