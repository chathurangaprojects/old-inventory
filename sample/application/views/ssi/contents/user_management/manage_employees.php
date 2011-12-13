<?php
                                     
  
?>

<div class="hastable">   

<table id="sort-table"> 
                        <thead> 
                        <tr>
                            <th><input type="checkbox" value="check_none" onclick="this.value=check(this.form.list)" class="submit"/></th>
                            <th>Employee Name</th> 
                            <th>Designation</th> 
                            <th>Department</th> 
                            <th>Email</th> 
                            <th>Level</th>
                            <th style="width:128px">Options</th> 
                        </tr> 
                        </thead> 
                        
                        
                        <tbody> 
                        
                         <?php   foreach($allemployees as $rowallemployees)
                            { ?>
                        <tr id="employees<?php echo $rowallemployees->Employee_Code ; ?>">
                            <td class="center"><input type="checkbox" value="1" name="list" class="checkbox"/></td> 
                            <td><?php echo $rowallemployees->Employee_Name; ?></td> 
                            <td><?php echo $rowallemployees->Designation; ?></td>   
                            <td><?php echo $rowallemployees->Department_Name; ?></td>   
                            <td><?php echo $rowallemployees->Email; ?></td>   
                            <td><?php echo $rowallemployees->Level." - ".$rowallemployees->Description; ?></td>   
                            <td>
                                <a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Edit this example" href="#">
                                    <span class="ui-icon ui-icon-wrench"></span>
                                </a>
                              
                              
                              <span id="emp_status<?php echo $rowallemployees->Employee_Code ; ?>">
                              
                                
                                <?php
                                 if($rowallemployees->Status=='0'){
                                 ?>
                                <a onclick="enableEmployee(<?php echo $rowallemployees->Employee_Code ; ?>)" class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Mark as Enabled."  style="cursor:pointer;">
                                    <span class="ui-icon ui-icon-arrowreturnthick-1-n"></span>
                                </a>                                  
                                 <?php } ?>
                                 
                                                                 <?php
                                 if($rowallemployees->Status=='1'){
                                 ?>
                                <a onclick="disableEmployee(<?php echo $rowallemployees->Employee_Code ; ?>)" class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Mark as Disabled."  style="cursor:pointer;">
                                    <span class="ui-icon ui-icon-arrowreturnthick-1-s"></span>
                                </a>                                  
                                 <?php } ?>
                                 </span>   
                                
                                
                                <a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Delete this Empoyee" href="#" onclick="deleteitems('employees<?php echo $rowallemployees->Employee_Code; ?>','del_employees',<?php echo $rowallemployees->Employee_Code; ?>,'Are you sure want to delete this Employee?')">
                                    <span class="ui-icon ui-icon-circle-close"></span>
                                </a>
                            </td>
                        </tr> 
                        <?php } ?>
                        
                        
                             </tbody>  
                        
                        </table>
                              <div class="pagination"> <?php echo $this->pagination->create_links(); ?></div>    
                        </div>
                        
 
              