<?php
                                     
  
?>


    
                <div class="inner-page-title">
                    <h2><?php echo $title; ?></h2>
                    <span>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</span>
                </div>


<div class="content-box">
                    <form action="#" method="post" enctype="multipart/form-data" class="forms" name="form" >
                        <ul>
                            <li>
                                <label  class="desc">
                                    Employee Name
                                </label>
                                <div>
                                    <input type="text" tabindex="1" maxlength="255" value="" class="field text small" id="Employee_Name" />
                                </div>
                            </li>
                            <li>
                                <label  class="desc">
                                    Designation
                                </label>
                                <div>
                                    <input type="text" tabindex="1" maxlength="255" value="" class="field text small" id="Designation" />
                                </div>
                            </li>
                            <li>
                                <label  class="desc">
                                    Department
                                </label>
                                <div>
                                     <select tabindex="3" class="field select small" id="Department_Code" > 
                                     
                                     <option value="">Please select</option>
                                         <?php   foreach($alldepartments as $rowalldepartments){ ?>                                      
                                        <option value="<?php echo $rowalldepartments->Department_Code; ?>"><?php echo $rowalldepartments->Department_Name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label  class="desc">
                                    Email
                                </label>
                                <div>
                                    <input type="text" tabindex="1" maxlength="255" value="" class="field text small" id="Email" />
                                </div>
                            </li>
                            <li>
                                <label  class="desc">
                                    Secutiry Level
                                </label>
                                <div>
                                   <select tabindex="3" class="field select small" id="Level_Code" > 
                                       <option value="">Please select</option> 
                                      <?php   foreach($allaccesslevels as $rowallaccesslevels){ ?>                                      
                                        <option value="<?php echo $rowallaccesslevels->Level_Code; ?>"><?php echo $rowallaccesslevels->Description; ?></option>
                                        <?php } ?>
                                        
                                    </select>
                                </div>
                            </li>
                             <li>
                                <label  class="desc">
                                   
                                </label>
                                <div id="addnewempmsg">
                                          
                                </div>
                            </li>
                                                                             
                            <li class="buttons">
                                <button class="ui-state-default ui-corner-all ui-button" type="button" onclick="addEmployee()">Add</button>
                            </li>
                        </ul>
                    </form>
                    <div class="clear"></div>
                </div>
                
                               
                                