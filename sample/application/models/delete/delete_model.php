<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    
  class Delete_model extends CI_Model
  {
      
           private $Employee_Code;        
      
       //setters
        public function setEmployee_Code($Employee_Code) {
            $this->Employee_Code = $Employee_Code;
        }       
                         
        
         //getters
        public function getEmployee_Code() {
            return $this->db->$Employee_Code;
        }
      
      
     function deleteEmloyees(){
         
         $sql = "DELETE FROM ta_ims_employee WHERE Employee_Code='".(int)$_POST['Id']."' ";
         $result =  $this->db->query($sql); 
         return $result;
         
     } 
      
      
      
      
  }
  
  
  
?>
