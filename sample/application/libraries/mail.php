<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 //require('../config/config.php');
 
  class Mail{ 
      

function send_recoverpasswordconfirmation($emailaddress,$confirm_code){
    
    //echo $emailaddress;
   // echo $confirm_code;  
    
    
     //  echo $this->config->SMTPSECURE;     
        
       //echo $this->config->item('SMTPSECURE'); 
      
     // $autoload['config'] = array();
      
     // print_r($autoload['config']);
            //    die();   
        
       // echo $get_instance()->config->load('SMTPSECURE');

    

    
    
       $emailbody ="
Email address = ".$_POST['user_email']."<br />
Password = ".$_POST['user_password']."<br />
Login URL = ".HTTP_PATH."<br />

";

$mail             = new PHPMailer();

$body             = $emailbody; //$mail->getFile('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = SMTPAUTH;     // enable SMTP authentication
$mail->SMTPSecure = SMTPSECURE;   // sets the prefix to the servier
$mail->Host       = HOST;      // sets the SMTP server
$mail->Port       = PORT;      // set the SMTP port

$mail->Username   = MAIL_USERNAME;  
$mail->Password   = MAIL_PASSWORD;   

$mail->From       = 'info@lankacom.net';
$mail->FromName   = "LakacomWiFi Admin";
$mail->Subject    = "Login Details of WiFi Hotspot Panel ";
$mail->AltBody    = "Login Details of WiFi Hotspot Panel"; //Text Body
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

//$mail->AddReplyTo("viranf@lankacom.net","Webmaster");

//$mail->AddAttachment("/path/to/file.zip");             // attachment
//$mail->AddAttachment("/path/to/ivimage.jpg", "new.jpg"); // attachment

$mail->AddAddress($_POST['user_email'],$_POST['user_email']);

$mail->IsHTML(true); // send as HTML

if(!$mail->Send()) {
  
  echo "1";
  //echo "Mailer Error: " . $mail->ErrorInfo;
  // email address are not the actual email addressess!!
} else {
  echo "1";
} 
                 
                 
    
    
    
    
    
    
    
    
    
    
    
    
    
}      
      
      
      
      
      
      
      
      
      
  }
?>
