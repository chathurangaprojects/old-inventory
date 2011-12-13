<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Privilege_model extends CI_Model
    {
        function  __construct()
        {
            parent::__construct();
        }

        function grant_privilege($lc, $dc, $pc)
        {
//            if($this->session->userdata('logged_in'))
//            {
                //$sql = "SELECT * FROM ta_ims_level_privilege WHERE Level_Code = " . $this->session->userdata('level') . " AND Department_Code = " . $this->session->userdata('department') . " AND Privilege_Code = " . $pid;
                $sql = "SELECT * FROM ta_ims_level_privilege WHERE Level_Code = $lc AND Department_Code = $dc AND Privilege_Code = $pc";

                $results = $this->db->query($sql);

                if($results->num_rows() > 0)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
//            }
//            else
//            {
//                return FALSE;
//            }
        }
    }
?>