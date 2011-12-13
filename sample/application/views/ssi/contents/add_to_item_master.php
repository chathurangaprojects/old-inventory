<div class="inner-page-title">
    <h2>Add New Master Items</h2>
    <span>You can add new master items to the system.</span>
</div>

<div class="content-box content-box-header">
    <div class="content-box-wrapper">
            <!-- <h3>How to achieve this ?</h3>
            <p>All you have to do is add <b>id="sidebar-left"</b> to the body tag.</p> -->

            <?php echo form_open_multipart(base_url() . 'index.php/item_master/add_items'); ?>
            <!-- <form class="forms" id="addItemForm" method="post" action="<?php //echo base_url(); ?>index.php/item_master/add_items"> -->
                <fieldset>
                        <ul>
                            <li>
                                <span class="cont tooltip ui-corner-all" title="Click here to add new Item Types">
                                    <a id="dialog_link" class="btn ui-state-default ui-corner-all" href="#">
                                        <span class="ui-icon ui-icon-newwin"></span>
                                        Add New Type
                                    </a>
                                </span>
                                
                                <span class="cont tooltip ui-corner-all" title="Click here to add new Properties to existing items">
                                    <a id="dialog_link2" class="btn ui-state-default ui-corner-all" href="#">
                                        <span class="ui-icon ui-icon-newwin"></span>
                                        Add New Properties
                                    </a>
                                </span>
                            
                                <span class="cont tooltip ui-corner-all" title="Click here to add values to existing Properties">
                                    <a id="dialog_link3" class="btn ui-state-default ui-corner-all" href="#">
                                        <span class="ui-icon ui-icon-newwin"></span>
                                        Add Property Values
                                    </a>
                                </span>
                            </li>
                            
                            <li>
                                <br/><br/><br/>
                                <label class="desc">Item Name *</label>
                                <div><input type="text" id="item_name" class="field text full" name="txt_item_name" /></div>
                                <script type="text/javascript">
                                    var item_name = new LiveValidation('item_name', {onlyOnSubmit: true });
                                    item_name.add( Validate.Presence, {failureMessage: "Please Enter Item Name"} );
                                </script>
                            </li>

                            <li>
                                <label  class="desc">Item Type *</label>
                                <div><input id="item_type" class="field text full" name="txt_item_type" onkeyup="showProperties3(this.value)" onchange="showProperties3(this.value)" onblur="showProperties3(this.value)"/></div>
                                <script type="text/javascript">
                                    var item_type = new LiveValidation('item_type', {onlyOnSubmit: true });
                                    item_type.add(Validate.Presence, {failureMessage: "Please Enter Item Type"});
                                </script>
                                
                                <span id="prop3"></span>
                                
                                <input type="hidden" id="item_prp" name="txt_item_prp" />
                            </li>

                            <li>
                                    <label class="desc">Picture</label>

                                    <div>
                                        <!-- <input type="file" id="picture" class="field file full" name="txt_picture" /> -->
                                        <input type="hidden" id="picture" class="field file full" name="txt_picture" />
                                        
                                        <div id="mainbody">
                                                <div id="upload" ><span>Upload Picture</span></div>
                                                <div id="sta"><span id="status" ></span></div>
                                                <span id="files" ></span>
                                        </div>
                                    </div>
                            </li>

                            <li>
                                <label  class="desc">Description</label>
                                <div>
                                    <!-- <textarea cols="50" rows="5" class="field textarea small" name="txt_description" ></textarea> -->
                                    <input type="text" id="txt_description" class="field text full" name="txt_description" />
                                </div>
                            </li>

                            <li>
                                <table width="100%">
                                    <tr>
                                        <td width="50%">
                                            <label class="desc">Re-Order Level</label>
                                            <div><input id="reorder_level" class="field text" name="txt_reorder_level" value="0" /></div>
                                            <script type="text/javascript">
                                                var reorder_level = new LiveValidation('reorder_level', {onlyOnSubmit: true });
                                                reorder_level.add(Validate.Numericality,{minimum: 0});
                                            </script>
                                        </td>
                                        
                                        <td width="50%">
                                            <label class="desc">Re-Order Quantity</label>
                                            <div><input id="reorder_quantity" class="field text" name="txt_reorder_qty" value="0" /></div>
                                            <script type="text/javascript">
                                                var reorder_quantity = new LiveValidation('reorder_quantity', {onlyOnSubmit: true });
                                                reorder_quantity.add(Validate.Numericality,{minimum: 0});
                                            </script>
                                        </td>
                                    </tr>
                                </table>
                            </li>

                            <li>
                                <!-- <input class="submit" type="submit" value="Submit"/> -->
                                <div>
                                    <button class="ui-state-default ui-corner-all float-left ui-button" type="submit">Add Item</button>
                                </div>
                            </li>
                        </ul>
                </fieldset>
        </form>
            
        <div id="dialog" title="Add New Item Type">
        <!-- <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p> -->
            
            <form class="forms" id="itForm" method="post" action="<?php echo base_url(); ?>index.php/item_master/add_item_types">
                <fieldset>
                        <ul>
                            <li>
                                    <label class="desc">Item Type *</label>
                                    <div><input type="text" id="it" class="field text full" name="txt_it" /></div>
                                    <script type="text/javascript">
                                        var it = new LiveValidation('it', {onlyOnSubmit: true });
                                        it.add( Validate.Presence, {failureMessage: "Please Enter Item Type"} );
                                    </script>
                            </li>

                            <li>
                                <label  class="desc">Category *</label>

                                <div>
                                    <select class="field select large" name="cmb_cat" >
                                        <?php
                                            foreach($categories as $cat)
                                            {
                                                echo  '<option value="' . $cat->Category_Code . '">' . $cat->Category_Name . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </li>

                            <li>
                                <label class="desc">Bulk Type</label>
                                <div>
                                    <select class="field select large" name="cmb_bt" >
                                        <?php
                                            foreach($bulk as $blk)
                                            {
                                                echo  '<option value="' . $blk->Bulk_Code . '">' . $blk->Description . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </li>

                            <li>
                                <label class="desc">Unit</label>
                                <div>
                                    <select class="field select large" name="cmb_unit" >
                                        <?php
                                            foreach($unit as $unt)
                                            {
                                                echo  '<option value="' . $unt->Unit_Code . '">' . $unt->Description . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </li>

                            <li>
                                <label  class="desc">Description</label>
                                <div>
                                        <!-- <textarea cols="50" rows="5" class="field textarea small" name="txt_description" ></textarea> -->
                                    <input type="text" id="description" class="field text full" name="txt_description" />
                                </div>
                            </li>

                            <li>
                                <!-- <input class="submit" type="submit" value="Submit"/> -->
                                <div>
                                    <button class="ui-state-default ui-corner-all float-left ui-button" type="submit">Add Item</button>
                                </div>
                            </li>
                        </ul>
                </fieldset>
            </form>
        </div>
            
        <div id="dialog2" title="Add New Property">
            <form class="forms" id="propForm" method="post" action="<?php echo base_url(); ?>index.php/item_master/add_item_property">
                <fieldset>
                        <ul>
                            <li>
                                <label class="desc">Item Type *</label>
                                <div>
                                    <input type="text" id="item_type2" class="field text full" name="txt_item_type2" onkeyup="showProperties(this.value)" onchange="showProperties(this.value)" onblur="showProperties(this.value)" onclick="showProperties(this.value)" />
                                </div>
                                <script type="text/javascript">
                                    var item_type2 = new LiveValidation('item_type2', {onlyOnSubmit: true });
                                    item_type2.add( Validate.Presence, {failureMessage: "Please Enter Item Type"} );
                                </script>
                                <span id="prop"></span>
                            </li>
                            
                            <!-- <li id="show_prop_link">
                                <span class="cont tooltip ui-corner-all" title="Click here to view existing Properties">
                                    <a id="dialog_link3" class="btn ui-state-default ui-corner-all" href="#" onclick="showProperties(document.getElementById('item_type2').value)">
                                        <span class="ui-icon ui-icon-newwin"></span>
                                        Show Properties
                                    </a>
                                </span>
                            </li> -->
                            
                            <li>
                                <label class="desc">Property *</label>
                                <div><input type="text" id="property" class="field text full" name="txt_property" /></div>
                                <script type="text/javascript">
                                    var property = new LiveValidation('property', {onlyOnSubmit: true });
                                    property.add( Validate.Presence, {failureMessage: "Please Enter Property"} );
                                </script>
                            </li>

                            <li>
                                <label  class="desc">Description</label>
                                <div>
                                    <textarea id="desc2" cols="50" rows="5" class="field textarea small" name="txt_description" ></textarea>
                                </div>
                            </li>

                            <li>
                                <!-- <input class="submit" type="submit" value="Submit"/> -->
                                <div>
                                    <button class="ui-state-default ui-corner-all float-left ui-button" type="submit">Add Property</button>
                                </div>
                            </li>
                        </ul>
                </fieldset>
            </form>
        </div>
            
        <div id="dialog3" title="Add Property Values">
            <form class="forms" id="addPropForm" method="post" action="<?php echo base_url(); ?>index.php/item_master/add_item_property">
                <fieldset>
                        <ul>
                            <li>
                                <label class="desc">Item Type *</label>
                                <div>
                                    <input type="text" id="item_type3" class="field text full" name="txt_item_type3" onkeyup="showProperties2(this.value)"  onchange="showProperties2(this.value)" onblur="showProperties2(this.value)" onclick="showProperties2(this.value)" />
                                </div>
                                <script type="text/javascript">
                                    var item_type3 = new LiveValidation('item_type3', {onlyOnSubmit: true });
                                    item_type3.add( Validate.Presence, {failureMessage: "Please Enter Item Type"} );
                                </script>
                                <span id="prop2"></span>
                            </li>
                        </ul>
                </fieldset>
            </form>
        </div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    </div>
</div>