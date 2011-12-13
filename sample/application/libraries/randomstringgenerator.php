<?php   
 class Randomstringgenerator {
  
		function random_generator($digits){
          srand ((double) microtime() * 10000000);
         
         $input = array ("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q",
"R","S","T","U","V","W","X","Y","Z");

         $random_generator="";
         for($i=1;$i<$digits+1;$i++){

         if(rand(1,2) == 1){
  
        $rand_index = array_rand($input);
         $random_generator .=$input[$rand_index]; 

        }else{

        
        $random_generator .=rand(1,9); 
         } 
         } 
        return $random_generator;
     } 
		
}
?>