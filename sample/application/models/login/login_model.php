<?php
 //   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Login_model extends CI_Model
    {
        private $Employee_Code;
        private $Employee_Name;
        private $Designation;
        private $Department_Code;
        private $Level_Code;        
        private $Email;
        private $Password;
        private $Status;

        //setters
        public function setEmployee_Code($Employee_Code) {
            $this->Employee_Code = $Employee_Code;
        }

        public function setEmployee_Name($Employee_Name) {            
         echo $Employee_Name;die();
           $this->Employee_Name=$Employee_Name;
        }

        public function setDesignation($Designation) {
            $this->Designation = $Designation;
        }

        public function setDepartment_Code($Department_Code) {
            $this->Department_Code = $Department_Code;
        }

         public function setLevel_Code($Level_Code) {
            $this->Level_Code = $Level_Code;
        }
        
        
        public function setEmail($Email) {
            $this->Email = $Email;
        }

        public function setPassword($Password) {
            $this->Password = $Password;
        }

        public function setStatus($Status) {
            $this->Status = $Status;
        }

        public function setConfirmation_Code($Confirmation_Code) {
            $this->Confirmation_Code = $Confirmation_Code;
        }

        

        //getters
        public function getEmployee_Code() {
            return $this->db->escape($this->Employee_Code);
        }

        public function getEmployee_Name() {
            return $this->db->escape($this->Employee_Name);
        }

        public function getDesignation() {
            return $this->db->escape($this->Designation);
        }

        public function getDepartment_Code() {
            return $this->db->escape($this->Department_Code);
        }

        public function getLevel_Code() {
            return $this->db->escape($this->Level_Code);
        }
        
        
        public function getPassword() {
            return $this->Password;
        }

        public function getStatus() {
            return $this->db->escape($this->Status);
        }

        public function getEmail() {
            return $this->db->escape($this->Email);
        }
        
         public function getConfirmation_Code() {
            return $this->db->escape($this->Confirmation_Code);
        }
        

        public function userlogin()
        {
           
            $sql = "SELECT * FROM ta_ims_employee WHERE
                                Email='$this->getEmail()' AND
                                Password='md5($this->getPassword())' ";

          $result =  $this->db->query($sql);


           echo $result->num_rows();
        }


        function __construct()
        {
            parent::__construct();

            $this->load->database();
        }


        function loging_in()
        {
            $un = '';
            $pwd = '';
            if(!empty($_POST['login_username']))
            {
                $un = $_POST['login_username'];
            }
            else
            {
                return FALSE;
            }

            if(!empty($_POST['login_password']))
            {
                $pwd = $_POST['login_password'];
            }
            else
            {
                return FALSE;
            }

            $sql = "SELECT * FROM ta_ims_employee WHERE Email = '$un' AND Password = MD5('$pwd')";

            $results = $this->db->query($sql);

            if($results->num_rows() != 1)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        }

        function get_emp_data($email)
        {
            $sql = "SELECT * FROM ta_ims_employee WHERE Email = '$email'";
            $results = $this->db->query($sql);
            $row = $results->row_array();
            return $row;
        }
        
        
        function check_registeredemail(){     
                     
            $sql = "SELECT * FROM ta_ims_employee WHERE Email = ".$this->getEmail()." "; 
            $results = $this->db->query($sql);            
            return    $results->num_rows();    
        }
        
        
        
        function add_confirmationcode(){
        $sql = "UPDATE ta_ims_employee SET Confirmation_Code=".$this->getConfirmation_Code()." WHERE Email = ".$this->getEmail()." ";  
        return $this->db->query($sql); 
        }
        
        
        function getVerifyconfirmationcode(){
         $sql = "SELECT * FROM ta_ims_employee WHERE Confirmation_Code=".$this->getConfirmation_Code()." AND Email = ".$this->getEmail()."  ";   
         $results = $this->db->query($sql);   
          return    $results->num_rows();      
        }
        
        
       function unset_confirmation_code(){
        $sql = "UPDATE ta_ims_employee SET Confirmation_Code='DONE' WHERE Email = ".$this->getEmail()." ";  
        return $this->db->query($sql);
       } 
       
       
       function settemparypassword(){              
        $sql = "UPDATE ta_ims_employee SET Password='".md5($this->getPassword())."' WHERE Email = ".$this->getEmail()." ";  
        return $this->db->query($sql);    
       }
        
      
      function get_allemployees(){ 
          
          $sql  = "SELECT 
                    ta_ims_employee.Employee_Code,
                    ta_ims_employee.Employee_Code,
                    ta_ims_employee.Employee_Name,
                    ta_ims_employee.Designation,
                    ta_ims_employee.Email,
                    ta_ims_employee.Status,
                    ta_ims_department.Department_Name,
                    ta_ims_level.Level,         
                    ta_ims_level.Description          
                                             FROM ta_ims_employee
              INNER JOIN ta_ims_department ON   ta_ims_employee.Department_Code=ta_ims_department.Department_Code
              INNER JOIN ta_ims_level ON   ta_ims_employee.Level_Code=ta_ims_level.Level_Code
              
          ORDER BY Employee_Code DESC";
          $results = $this->db->query($sql);   
          return    $results->result();         
      }  
        
   function get_allemployeespaginated($per_page,$offset){ 
          
          $sql  = "SELECT 
                    ta_ims_employee.Employee_Code,
                    ta_ims_employee.Employee_Code,
                    ta_ims_employee.Employee_Name,
                    ta_ims_employee.Designation,
                    ta_ims_employee.Email,
                    ta_ims_employee.Status,
                    ta_ims_department.Department_Name,
                    ta_ims_level.Level,         
                    ta_ims_level.Description          
                                             FROM ta_ims_employee
              INNER JOIN ta_ims_department ON   ta_ims_employee.Department_Code=ta_ims_department.Department_Code
              INNER JOIN ta_ims_level ON   ta_ims_employee.Level_Code=ta_ims_level.Level_Code
              
          ORDER BY Employee_Code DESC limit $per_page";
          $results = $this->db->query($sql);   
          return    $results->result();         
      }    
           
    
    function changestatus_of_employee(){        
        $sql = "UPDATE ta_ims_employee SET Status=".$this->getStatus()." WHERE Employee_Code=".$this->getEmployee_Code()." ";
        return $this->db->query($sql);
    }    
        
  
  function getallDepartments(){
      $sql = "SELECT * FROM ta_ims_department ORDER BY Department_Code DESC";
      $results = $this->db->query($sql);   
      return    $results->result(); 
  }
  
   function getallAccesslevels(){
      $sql = "SELECT * FROM ta_ims_level ORDER BY Level_Code DESC";
      $results = $this->db->query($sql);   
      return    $results->result(); 
  } 
      
  
  
  function add_new_employee(){
      
      echo $this->setEmployee_Name();die();
      
      $sql = "INSERT INTO ta_ims_employee(Employee_Name,Designation,Level_Code,Department_Code,Email,Password) 
                                VALUES(".$this->setEmployee_Name().",
                                       ".$this->setDesignation().",
                                       ".$this->setLevel_Code().",
                                       ".$this->setDepartment_Code().",
                                       ".$this->setEmail().",
                                       ".$this->setPassword()." )";
     return $this->db->query($sql);  
      
      
      
  }    
      
      
      
      
      
        
        
    }
?>