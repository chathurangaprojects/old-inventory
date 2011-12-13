<?php
    //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Item_property extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();

            $this->load->library('session');

            $this->load->model('privileges/Privilege_model');
        }
    
        public function load_property($tc)
        {
            if($this->session->userdata('logged_in'))
            {
                $this->load->model('Item_property_model');

                $result = $this->Item_property_model->get_item_property($tc);
                
                if(empty($result))
                {
                    echo '<h1><b>Selected Item Type Does Not Have Any Properties.</b></h1>';
                }
                else
                {
                    echo '<h1><b>Existing Properties</b></h1>';
                    
                    $i = 1;
                    
                    foreach ($result->result_array() as $row)
                    {
                        echo '<b>' . $i . '.</b> ' . $row['Property'] . '<br/>';
                        
                        $i += 1;
                    }
                }
            }
            else
            {
                $this->load->view('login_view');
            }
        }
        
        public function load_properties($tc)
        {
            if($this->session->userdata('logged_in'))
            {
                $this->load->model('Item_property_model');

                $result = $this->Item_property_model->get_item_property($tc);
                
                if(empty($result))
                {
                    echo '<h1><b>Selected Item Type Does Not Have Any Properties.</b></h1>';
                }
                else
                {
                    echo '<h1><b><u>Existing Properties</u></b></h1>';
                    
                    $i = 1;
                    
                    echo '<table>';
                    
                    foreach ($result->result_array() as $row)
                    {
                        echo '<tr>';
                        
                        echo '<td>';
                        echo '<b>' . $i . '. </b>';
                        echo '</td>';
                        
                        echo '<td>';
                        echo '<h1><b>' . trim($row['Property']) . '</b></h1>';
                        echo '<input type="hidden" id="pid' . $i . '"  name="txt_pid' . $i . '" value="' . trim($row['Propertiy_Code']) . '" />';
                        echo '</td>';
                        
                        echo '<td>';
                        
                        echo '<div id="props' . $i . '">';
                        $this->fill_combo(trim($row['Propertiy_Code']), $i);
                        echo '</div>';
                        
                        echo '</td>';
                        
                        echo '<td>';
                        echo '<input type="text" id="' . $i . '" class="field text" name="txt_prop' . $i . '" />';
                        echo '</td>';
                        
                        echo '<td>';
                        //echo '<input type="button" name="btn' . $i . '" value="Add Value" onclick="add_property_value(document.getElementById(\'pid' . $i . '\').value, document.getElementById(' . $i . ').value, \'props' . $i . '\')" />';
                        
                        //echo '<input type="button" name="btn' . $i . '" value="Add New Value" onclick="add_property_value(' . trim($row['Propertiy_Code']) . ', document.getElementById(' . $i . ').value, ' . $i . ')" />';
                        echo '<input type="button" name="btn' . $i . '" value="Add New Value" onclick="add_property_value(' . trim($row['Propertiy_Code']) . ', document.getElementById(' . $i . ').value, ' . $i . ', \'' . trim($row['Property']) . '\')" />';
                        
                        //echo '<input type="button" name="btn2' . $i . '" value="Add Value" onclick="alert(document.getElementById(' . $i . ').value)" />';
                        echo '</td>';
                        
                        echo '</tr>';
                        
                        $i++;
                    }
                    
                    echo '</table>';
                }
            }
            else
            {
                $this->load->view('login_view');
            }
        }
        
        public function show_properties($tc, $ic)
        {
            if($this->session->userdata('logged_in'))
            {
                $this->load->model('Item_property_model');

                $result = $this->Item_property_model->get_item_property2($tc, $ic);
                
                if(empty($result))
                {
                    echo '<h1><b>Selected Item Type Does Not Have Any Properties.</b></h1>';
                }
                else
                {
                    //echo '<h1><b><u>Existing Properties</u></b></h1>';
                    
                    $i = 1;
                    
                    echo '<table>';
                    echo '<input name="txt_item_count" id="item_count" type="hidden" value="'.count($result->result_array()).'">';
                    foreach ($result->result_array() as $row)
                    {
                        echo '<tr>';
                        
                        echo '<td>';
                        echo '<b>' . $i . '. </b>';
                        echo '</td>';
                        
                        echo '<td>';
                        echo '<h1><b>' . trim($row['Property']) . '</b></h1>';
                        echo '<input type="hidden" id="prid' . $i . '"  name="txt_prid' . $i . '" value="' . trim($row['Propertiy_Code']) . '" />';
                        echo '</td>';
                        
                        echo '<td>';
                        echo '<span id="ex_prp' . $i . '"></span>';
                        echo '</td>';
                        
                        echo '<td>';
                        echo '<div id="pr' . $i . '">';
                        $this->fill_combo2(trim($row['Propertiy_Code']), $i);      
                        echo '</div>';
                        echo '</td>';
                        
                        echo '<td>';
                        echo '<input type="text" id="prp' . $i . '" class="field text" name="txt_prp' . $i . '" />';
                        echo '</td>';
                        
                        echo '<td>';
                        echo '<input type="button" name="btn2' . $i . '" value="Add New Value" onclick="add_property_value2(' . trim($row['Propertiy_Code']) . ', document.getElementById(\'prp' . $i . '\').value, ' . $i . ', \'' . trim($row['Property']) . '\')" />';
                        echo '</td>';
                        
                        echo '</tr>';
                        
                        $i++;
                    }
                    
                    echo '</table>';
                }
            }
            else
            {
                $this->load->view('login_view');
            }
        }
        
        public function fill_combo($pc, $i)
        {
            $this->load->model('Item_property_model');

            $result = $this->Item_property_model->load_property_values($pc);

            echo '<select id="cmb_pid' . $i . '" style="width:150px;">';
            //echo '<option value=""></option>';

            if(! empty($result))
            {
                foreach ($result->result_array() as $row)
                {
                    echo '<option>' . $row['Propertiy_Values'] . '</option>';
                }
            }

            //echo '<option value="Add">&lt;ADD NEW PROPERTY&gt;</option>';
            echo '</select>';
        }
        
        public function fill_combo2($pc, $i)
        {
            $this->load->model('Item_property_model');

            $result = $this->Item_property_model->load_property_values($pc);

            echo '<select id="cmb_pid2' . $i . '" style="width:150px;" onchange="get_property_code(this.value, ' . $i . ')">';
            echo '<option value=""></option>';

            if(! empty($result))
            {
                foreach ($result->result_array() as $row)
                {
                    echo '<option value="' . trim($row['Property_Value_Code']) . '">' . trim($row['Propertiy_Values']) . '</option>';
                }
            }

            echo '</select>';
        }
        
        public function add_item_property_value($pc, $pv)
        {
            $this->load->model('Item_property_model');

            echo $this->Item_property_model->add_item_property_value($pc, $pv);
        }
        
        public function select_prop()
        {
            $item_code= $_POST['item_code'];
            $prop_code= $_POST['prop_code'];
            
            $this->load->model('Item_property_model');

            echo $this->Item_property_model->select_prop($item_code, $prop_code);
        }
    }
?>
