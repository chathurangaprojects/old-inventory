<div class="inner-page-title">

</div>

<div class="content-box content-box-header">
    <div class="content-box-wrapper">
        <h3>Purchase Order Form</h3>
        
        <?php echo form_open_multipart(base_url() . 'index.php/po/purchase_order/add_po'); ?>
            <fieldset>
                <table width="100%" border="1px" class="flexme2">
                    <tr>
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <b>Supplier Type *</b>
                        </td>
                        
                        <td colspan="3" style="padding: 5px 5px 5px 0;">
                            <select id="sup_type" class="field select full" name="cmb_sup_type" onchange="select_currency();">
                                <option value=""></option>
                                <option value="0">Local Supplier</option>
                                <option value="1">Foreign Supplier</option>
                            </select>
                            <script type="text/javascript">
                                var sup_type = new LiveValidation('sup_type', {onlyOnSubmit: true });
                                sup_type.add( Validate.Presence, {failureMessage: "Please Select Supplier Type"} );
                            </script>
                        </td>
                        
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <b>Supplier Name *</b>
                        </td>
                        
                        <td colspan="3" style="padding: 5px 5px 5px 0;">
                            <input type="text" id="sup_name" class="field text full" name="txt_sup_name" />
                            <script type="text/javascript">
                                var sup_name = new LiveValidation('sup_name', {onlyOnSubmit: true });
                                sup_name.add( Validate.Presence, {failureMessage: "Please Enter Supplier Name"} );
                            </script>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;">
                            <b>Order Date *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <input type="text" id="ord_date" class="field text full" name="txt_ord_date" value="<?php echo date("Y-m-d"); ?>" readonly="readonly"/>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <b>Expected Date</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <input type="text" id="exp_date" class="field text full" name="txt_exp_date" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <b>Quotation No.</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <input type="text" id="quote_no" class="field text full" name="txt_quote_no" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <b>Attention</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <input type="text" id="attention" class="field text full" name="txt_attention" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <b>Department *</b>
                        </td>
                        
                        <td colspan="3" style="padding: 5px 5px 5px 0;">
                            <select id="req_dept" class="field select full" name="cmb_req_dept">
                                <option value=""></option>
                                <?php
                                    foreach ($depts->result_array() as $row)
                                    {
                                        echo '<option value="' . $row['Department_Code'] . '">' . $row['Department_Name'] . '</option>';
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                var req_dept = new LiveValidation('req_dept', {onlyOnSubmit: true });
                                req_dept.add( Validate.Presence, {failureMessage: "Please Select Requested Department"} );
                            </script>
                        </td>
                        
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <b>Requested By *</b>
                        </td>
                        
                        <td colspan="3" style="padding: 5px 5px 5px 0;">
                            <select id="req_by" class="field select full" name="cmb_req_by">
                                <?php
                                    foreach ($emps->result_array() as $row)
                                    {
                                        echo '<option value="' . $row['Employee_Code'] . '">' . $row['Employee_Name'] . '</option>';
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                var req_by = new LiveValidation('req_by', {onlyOnSubmit: true });
                                req_by.add( Validate.Presence, {failureMessage: "Please Select Requested Employee"} );
                            </script>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <b>Payment Type *</b>
                        </td>
                        
                        <td colspan="3" style="padding: 5px 5px 5px 0;">
                            <select id="pay_type" class="field select full" name="cmb_pay_type">
                                <option value=""></option>
                                <?php
                                    foreach ($pay_types->result_array() as $row)
                                    {
                                        echo '<option value="' . $row['Payment_Type_Code'] . '">' . $row['Payment_Type'] . '</option>';
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                var pay_type = new LiveValidation('pay_type', {onlyOnSubmit: true });
                                pay_type.add( Validate.Presence, {failureMessage: "Please Select Payment Type"} );
                            </script>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <b>Currency *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <select id="curr" class="field select full" name="cmb_curr" onchange="select_conv_rate();">
                                <option value=""></option>
                                <?php
                                    foreach ($currency->result_array() as $row)
                                    {
                                        echo '<option value="' . $row['Currency_Code'] . '">' . $row['Currency'] . '</option>';
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                var curr = new LiveValidation('curr', {onlyOnSubmit: true });
                                curr.add( Validate.Presence, {failureMessage: "Please Select Currency"} );
                            </script>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <b>Conversion Rate *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <input type="text" id="con_rate" class="field text full" name="txt_con_rate" />
                            <script type="text/javascript">
                                var con_rate = new LiveValidation('con_rate', {onlyOnSubmit: true });
                                con_rate.add( Validate.Presence, {failureMessage: "Please Enter Conversion Rate"} );
                            </script>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <b>Payment Remarks</b>
                        </td>
                        
                        <td colspan="7" style="padding: 5px 5px 5px 0;">
                            <!-- <input type="text" id="pay_remark" class="field text full" name="txt_pay_remark" /> -->
                            <textarea id="pay_remark" class="field text full" name="txt_pay_remark" rows="2"></textarea>
                        </td>
                        
                        <!-- <td style="padding: 5px 5px 5px 0;">
                            <b>Discount %</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <input type="text" id="discount" class="field text full" name="txt_discount" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <b>Discount Amount</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;">
                            <input type="text" id="discount_amount" class="field text full" name="txt_discount_amount" />
                        </td> -->
                    </tr>
                    
                    <tr>
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <label class="desc">PO Purpose</label>
                        </td>
                        
                        <td colspan="3" style="padding: 5px 5px 5px 0;">
                            <!-- <input type="text" id="po_purpose" class="field text full" name="txt_po_purpose" /> -->
                            <textarea id="po_purpose" class="field text full" name="txt_po_purpose" rows="2"></textarea>
                        </td>
                        
                        <td colspan="1" style="padding: 5px 5px 5px 0;">
                            <label class="desc">PO Remarks</label>
                        </td>
                        
                        <td colspan="3" style="padding: 5px 5px 5px 0;">
                            <!-- <input type="text" id="po_remarks" class="field text full" name="txt_po_remarks" /> -->
                            <textarea id="po_remarks" class="field text full" name="txt_po_remarks" rows="2"></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="8">
                            <input type="hidden" name="txt_po_no" id="po_no" value="13">
                            
                            <span class="cont tooltip ui-corner-all" title="Click here to add an Item">
                                <a id="lnk_add_item" class="btn ui-state-default ui-corner-all" href="#">
                                    <span class="ui-icon ui-icon-newwin"></span>
                                    Add Item
                                </a>
                            </span>
                            
                            <!-- <button class="ui-state-default ui-corner-all float-left ui-button" type="submit" disabled="disabled">Save</button> -->
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
        
        <div id="po_items">
        </div>
        
        <div id="dlg_add_item" title="Add Item to Purchase Order">
            <form>
                <table style="width: 100%">
<!--                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 33%">
                            <b>Item Name</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 67%" colspan="3">
                             <input type="text" id="po_item_name" class="field text full" name="txt_po_item_name" /> 
                            <input type="text" id="po_item_name" class="field text full" name="txt_po_item_name" onkeypress="get_po_item_name(this.value);" onchange="get_po_item_name(this.value);" onblur="get_po_item_name(this.value);"/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 25%">
                            <b>Unit</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 25%">
                            <input type="text" id="po_item_unit" class="field text full" name="txt_po_item_unit" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 25%">
                            <b>Unit Price</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 25%">
                            <input type="text" id="po_item_unit_price" class="field text full" name="txt_po_item_unit_price" />
                        </td>
                    </tr>-->
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Item Name *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;" colspan="5">
                            <input type="text" id="po_item_name" class="field text full" name="txt_po_item_name" onkeypress="get_po_item_name(this.value);" onchange="get_po_item_name(this.value);" onblur="get_po_item_name(this.value);"/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Unit *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <!-- <input type="text" id="po_item_unit" class="field text full" name="txt_po_item_unit" /> -->
                            <select id="po_item_unit" class="field select full" name="cmb_po_item_unit">
                                <option value=""></option>
                                <?php
                                    foreach ($units->result_array() as $row)
                                    {
                                        echo '<option value="' . $row['Unit_Code'] . '">' . $row['Description'] . '</option>';
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                var req_dept = new LiveValidation('req_dept', {onlyOnSubmit: true });
                                req_dept.add( Validate.Presence, {failureMessage: "Please Select Requested Department"} );
                            </script>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Unit Price *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_item_unit_price" class="field text full" name="txt_po_item_unit_price" style="font-weight: bold;text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Quantity *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 18%">
                            <input type="text" id="po_qty" class="field text full" name="txt_po_qty" style="font-weight: bold;text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Discount %</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_disc_per" class="field text full" name="txt_po_disc_per" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Discount Amount</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_disc" class="field text full" name="txt_po_disc" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 18%">
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Individual Tax %</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_ind_tax" class="field text full" name="txt_po_ind_tax" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Tax Value</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_tax_val" class="field text full" name="txt_po_tax_val" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%;text-align: right;font-size: 15px;">
                            <b>Item Value</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 18%;">
                            <input type="text" readonly="readonly" id="po_item_val" class="field text full" name="txt_po_item_val" style="text-align: right;background-color: #99f099;font-size: 15px;font-weight: bold;" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%;">
                            <b>Description</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;" colspan="5">
                            <!-- <input type="text" id="po_desc" class="field text full" name="txt_po_desc" /> -->
                            <textarea id="po_desc" class="field text full" name="txt_po_desc" rows="2"></textarea>
                        </td>
                    </tr>
                    
                    <!-- <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Breakable</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <select id="breakable" class="field select full" name="cmb_breakable" >
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Breakable Unit</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_brk_unit" class="field text full" name="txt_po_brk_unit" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Breakable Quantity</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 18%">
                            <input type="text" id="po_brk_qty" class="field text full" name="txt_po_brk_qty" />
                        </td>
                    </tr> -->
                </table>
                
                <!--<input type="button" value="Submit" onclick="abc();"/> -->
                
                <button class="ui-state-default ui-corner-all float-left ui-button" type="button" onclick="add_items_to_po();">Add</button>
            </form>
        </div>
        
        <div class="dlg_edit_item" title="Edit Item">
            <form>
                <table style="width: 100%">
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Item Name *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;" colspan="5">
                            <input type="hidden" id="ic2" name="txt_ic2"/>
                            
                            <input type="text" id="po_item_name2" class="field text full" name="txt_po_item_name2" readonly="readonly"/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Unit *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <!-- <input type="text" id="po_item_unit" class="field text full" name="txt_po_item_unit" /> -->
                            <select id="po_item_unit2" class="field select full" name="cmb_po_item_unit2">
                                <option value=""></option>
                                <?php
                                    foreach ($units->result_array() as $row)
                                    {
                                        echo '<option value="' . $row['Unit_Code'] . '">' . $row['Description'] . '</option>';
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                var req_dept2 = new LiveValidation('req_dept2', {onlyOnSubmit: true });
                                req_dept2.add( Validate.Presence, {failureMessage: "Please Select Requested Department"} );
                            </script>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Unit Price *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_item_unit_price2" class="field text full" name="txt_po_item_unit_price2" style="font-weight: bold;text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Quantity *</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 18%">
                            <input type="text" id="po_qty2" class="field text full" name="txt_po_qty2" style="font-weight: bold;text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Discount %</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_disc_per2" class="field text full" name="txt_po_disc_per2" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Discount Amount</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_disc2" class="field text full" name="txt_po_disc2" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 18%">
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Individual Tax %</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_ind_tax2" class="field text full" name="txt_po_ind_tax2" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%">
                            <b>Tax Value</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 17%">
                            <input type="text" id="po_tax_val2" class="field text full" name="txt_po_tax_val2" style="text-align: right;" onkeyup="calculate_item_value();" />
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 16%;text-align: right;font-size: 15px;">
                            <b>Item Value</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;width: 18%;">
                            <input type="text" readonly="readonly" id="po_item_val2" class="field text full" name="txt_po_item_val2" style="text-align: right;background-color: #99f099;font-size: 15px;font-weight: bold;" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 5px 5px 5px 0;width: 16%;">
                            <b>Description</b>
                        </td>
                        
                        <td style="padding: 5px 5px 5px 0;" colspan="5">
                            <!-- <input type="text" id="po_desc" class="field text full" name="txt_po_desc" /> -->
                            <textarea id="po_desc2" class="field text full" name="txt_po_desc2" rows="2"></textarea>
                        </td>
                    </tr>
                </table>
                
                <button class="ui-state-default ui-corner-all float-left ui-button" type="button" onclick="edit_po_items();">Update</button>
            </form>
        </div>
    </div>
</div>