<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  // require_once ("phpmailer/class.phpmailer.php");
//require_once ("phpmailer/class.smtp.php");
    
              // echo base_url();
class Login extends CI_Controller
{
    var $pid = 1;

    function __construct()
    {
        parent::__construct();

        $this->load->library('session');   
        
        //random string generator class        
        $this->load->library('randomstringgenerator');      
        
        $this->load->library('email');       

        $this->load->model('login/Login_model');

        $this->load->model('privileges/Privilege_model');
    }
    
    private function __load_to_item_master()
    {
        $data['title'] = "Add New Master Items";
        
        $data['pagetitle'] = "Master Items";
        
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
        $this->load->view('ssi/contents/add_to_item_master.php', $data);
        $this->load->view('ssi/sidebar.php');
        $this->load->view('ssi/footer.php');
    }

    public function index()
    {
        if($this->session->userdata('logged_in'))
        {
            if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
            {
                $this->__load_to_item_master();
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

    
    function loging_in()
    {
        if($this->session->userdata('logged_in'))
        {
            if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
            {
                $this->__load_to_item_master();
            }
            
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
            
                     // echo $this->Login_model->loging_in();
                    //  die();
            if($this->Login_model->loging_in())
            {
				    // echo $this->Login_model->loging_in();
				   //  die();   
                        
                $row = $this->Login_model->get_emp_data($_POST['login_username']);
				//print_r($row);
				
                
                
                $emp_data = array
                (
                    'emp_id'  => $row['Employee_Code'],
                    'emp_name'  => $row['Employee_Name'],
                    'level'  => $row['Level_Code'],
                    'department'  => $row['Department_Code'],
                    'email'     => $row['Email'],
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($emp_data);
                        echo 1;
//                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->pid))
//                {
//                    $this->__load_to_item_master();
//                }
//                else
//                {
//                    $data = array('title' => 'Access Denied', 'desc' => 'You are not allowed to access this page.', 'subtitle' => 'Please Contact Administrator...', 'msg' => 'Your user account does not have previleges to access this page. Please contact System Administrator for more details.');
//                
//                    $this->load->view('ssi/header.php');
//                    $this->load->view('ssi/navigation.php');
//                    $this->load->view('ssi/search.php');
//                    $this->load->view('ssi/sub_navigation.php');
//                    $this->load->view('ssi/top_buttons.php');
//                    $this->load->view('ssi/errors/error_page.php', $data);
//                    $this->load->view('ssi/sidebar.php');
//                    $this->load->view('ssi/footer.php');
//                }
            }
            else
            {                  
                
               // $this->log_out();
               echo 2;
            }
        }
    }

    
   function check_registeredemail()
   {
   
  $this->Login_model->setEmail($_POST['registered_email']);  
       
   if($this->Login_model->check_registeredemail()==1){
       
                          
     $vertification_code = $this->randomstringgenerator->random_generator(40);
                  
     $this->Login_model->setConfirmation_Code($vertification_code);

     if($this->Login_model->add_confirmationcode()==1){           
          //  $this->mail->send_recoverpasswordconfirmation($_POST['registered_email'],$vertification_code);
  echo   Login :: send_pwrecovery_confirmation_email($_POST['registered_email'],$vertification_code);  
      } 
             
   } else{             
        return 2;
       
   }
   
   }       
    
 function send_pwrecovery_confirmation_email($registered_email,$vertification_code){        
     

$this->email->from('info@lankacom.net', 'LCS IMS');
$this->email->to($registered_email);
//$this->email->cc('another@another-example.com');
//$this->email->bcc('them@their-example.com');

$this->email->subject('Password Recovery Confirmation');

   $message =  "  
  <p>This e-mail is sent to you, because we have received a notification saying that you forgot your password and requested for a new one.</p>
  
  <p>Please verify yourself by clicking on the following in link to provide you with your temporary login details.<span color='red'>If you think there is no relevancy at all in receiving this email, please ignore it.</span></p>
   
   
   <p><a href='".base_url()."index.php/login/confirmation/".$registered_email."/".$vertification_code."'>link</a></p>
  ";    
        
$this->email->message($message);  

echo $this->email->send();  
//echo $this->email->print_debugger();     
 }  
 
 function confirmation($registered_email,$vertification_code){
     
     
     $this->Login_model->setEmail($registered_email);
     $this->Login_model->setConfirmation_Code($vertification_code);
     
     
         $res = $this->Login_model->getVerifyconfirmationcode(); 
         $this->Login_model->unset_confirmation_code();
     if($res==1){
    Login :: temparypassword($registered_email);          
     }  
     
       
      $this->load->view('ssi/header.php');     
      
        $data = array('title' => 'Recover Password Confirmation', 'desc' => 'Recover Password Confirmation.', 'subtitle' => 'Recover Password Confirmation', 'msg' => 'Recover Password Confirmation' , 'vertification_code' => $vertification_code, 'registered_email' => $registered_email , 'res'=>$res);     
      
                  $this->load->view('ssi/navigation.php');
                  $this->load->view('ssi/search.php'); 
                  $this->load->view('ssi/sub_navigation.php', $data);
                  $this->load->view('ssi/top_buttons.php');  
     
                     $this->load->view('ssi/contents/recover_password_confirmation.php', $data);
     
   
                   $this->load->view('ssi/sidebar.php');
                   $this->load->view('ssi/footer.php');      
     
     
 }
 
 function unsetconfirmation($registered_email){ 
     
  $this->Login_model->setEmail($registered_email); 
  $this->Login_model->unset_confirmation_code();     
 }
 
 
 
 function temparypassword($registered_email){
  
    $temppw = $this->randomstringgenerator->random_generator(5);      
     
  $this->Login_model->setEmail($registered_email);  
  $this->Login_model->setPassword($temppw);
               
 if($this->Login_model->settemparypassword()==1){       
    echo Login :: send_tempary_email($registered_email,$temppw); 
 }else{     
 echo 2;    
 } 
     
     
 }
 
 function send_tempary_email($registered_email,$temppw){        
     

$this->email->from('info@lankacom.net', 'LCS IMS');
$this->email->to($registered_email);
//$this->email->cc('another@another-example.com');
//$this->email->bcc('them@their-example.com');

$this->email->subject('Temparary Login Details');

   $message =  "  
  <p>This is your temparary login details that you  requested.</p>   
  <p>Email address = $registered_email</p>          
  <p>Password = $temppw</p>   
 ";    
        
$this->email->message($message);  

echo $this->email->send();  
//echo $this->email->print_debugger();     
 }  
 
 
 
 
 
 
    function log_out()
    {
        $emp_data = array
        (
            'emp_id'  => '',
            'emp_name'  => '',
            'level'  => '',
            'department'  => '',
            'email'     => '',
            'logged_in' => FALSE
        );

        $this->session->unset_userdata($emp_data);

        $this->load->view('login_view');
    }
    
  
  
  
  function load_manage_employees(){
      
      $this->load->library('pagination');  
      $offset='';
        
        
 $allemployees = $this->Login_model->get_allemployees();       

            $per_page = 15;
            $total = count($allemployees);
        
           $config['base_url'] = site_url()."/login/load_manage_employees/";
           $config['total_rows'] = $total;
           $config['per_page'] = $per_page;
           $config['first_link'] = 'First';
           $config['last_link'] = 'Last';
           $config['next_link'] = 'Next '.'&gt;';
           $config['prev_link'] = '&lt;'.' Previous';
                  
           $this->pagination->initialize($config);
           
            $allemployees = $this->Login_model->get_allemployeespaginated($per_page,$offset);   
    
      
    $data = array('title' => 'Manage Employees', 'desc' => 'Manage Employees.', 'subtitle' => 'Manage Employees', 'msg' => 'Manage Employees' , 'pagetitle' => 'Manage Employees', 'allemployees' => $allemployees);     

    $this->load->view('ssi/header.php', $data);
    $this->load->view('ssi/navigation.php');
    $this->load->view('ssi/search.php');
    $this->load->view('ssi/sub_navigation.php', $data);
    $this->load->view('ssi/top_buttons.php');

    $this->load->view('ssi/contents/user_management/manage_employees.php');

    $this->load->view('ssi/sidebar.php');
    $this->load->view('ssi/footer.php');
      
  }  
   
 
 function add_new_employee_view(){
     
    $alldepartments =  $this->Login_model->getallDepartments();
    $allaccesslevels = $this->Login_model->getallAccesslevels();
     
     
     
     
 $data = array(
 'title' => 'Add new Employee', 
 'desc' => 'Add new Employee', 
 'subtitle' => 'Add new Employee', 
 'msg' => 'Add new Employee' , 
 'pagetitle' => 'Add new Employee',
 'alldepartments' => $alldepartments,
 'allaccesslevels' => $allaccesslevels 
 
 );     

    $this->load->view('ssi/header.php', $data);
    $this->load->view('ssi/navigation.php');
    $this->load->view('ssi/search.php');
    $this->load->view('ssi/sub_navigation.php', $data);
    $this->load->view('ssi/top_buttons.php');

    $this->load->view('ssi/contents/user_management/add_new_employee.php');

    $this->load->view('ssi/sidebar.php');
    $this->load->view('ssi/footer.php');   
     
     
 }  
   
   
   
   
    
    
    
    
    function disable_employee(){
        //echo "D E";        
        $this->Login_model->setEmployee_Code($_POST['id']); 
        $this->Login_model->setStatus('0');                
        echo $this->Login_model->changestatus_of_employee();        
    }
    
      function enable_employee(){
         //echo "E E"; 
         $this->Login_model->setEmployee_Code($_POST['id']);   
         $this->Login_model->setStatus('1');
         echo $this->Login_model->changestatus_of_employee();        
    }  
    
    
    
    function add_new_employee(){
        
      // print_r($_POST);die();
      //  $vertification_code = $this->randomstringgenerator->random_generator(5);  
        
                //  $this->Login_model->setEmployee_Code($_POST['id']);   
           
           
          //$test = $_POST['Employee_Name'];//die();
             //  echo $rest;die();
      $this->Login_model->setEmployee_Name($_POST['Employee_Name']);
      $this->Login_model->setDesignation($_POST['Designation']);
      $this->Login_model->setDepartment_Code($_POST['Department_Code']);
      $this->Login_model->setEmail($_POST['Email']);
      $this->Login_model->setLevel_Code($_POST['Level_Code']);
      $this->Login_model->setPassword(444);
     
    echo $this->Login_model->add_new_employee();        
     
     
     
     
        
    }
    

//    public function adminloginfunc()
//    {
//        //$username=$_POST['login_username'];
//        //$password=$_POST['login_password'];
//        $this->load->helper('url');
//        $this->load->model('login/login_model');
//
//        $this->Login_model->setEmail($_POST['login_username']);
//        $this->Login_model->setPassword($_POST['login_password']);
//
//        echo $this->Login_model->userlogin();
//    }
}
?>