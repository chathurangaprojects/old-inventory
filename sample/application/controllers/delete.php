<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

  class Delete extends CI_Controller{
      
        function __construct()
    {
        parent::__construct();

        $this->load->library('session');   
        
        //random string generator class        
        $this->load->library('randomstringgenerator');         
        
        $this->load->library('email');       

        $this->load->model('delete/Delete_model');

        $this->load->model('privileges/Privilege_model');
    }  
      
 
 
 
 function delete_items(){
     
           //  echo $_POST['Id'];
            // die();
     
     $this->Delete_model->setEmployee_Code($_POST['Id']);
   //$this->Login_model->setEmail($registered_email); 
  
switch ($_POST['action']) {
    case 'del_employees':
        echo  $this->Delete_model->deleteEmloyees();  
        break;
    case 1:
        echo "i equals 1";
        break;
    case 2:
        echo "i equals 2";
        break;
}
     
     
     
     
     
 }     
      
      
      
      
      
      
      
      
      
      
      
  }
?>
