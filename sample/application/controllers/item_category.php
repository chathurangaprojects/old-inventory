<?php
    //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_category extends CI_Controller
    {
        var $pid = 2;
        
        function __construct()
        {
            parent::__construct();

            $this->load->library('session');

            $this->load->model('privileges/Privilege_model');
        }
    
        public function load_categories()
        {
            if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
                {
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