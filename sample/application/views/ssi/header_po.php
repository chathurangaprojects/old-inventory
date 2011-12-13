<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>LCS IMS <?php echo $title;?></title>
    
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/js/jquery-1.3.2.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/js/ajaxupload.3.5.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/js/jquery.alerts.js" ></script>
      
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/scripts/js/styles.css" />
        
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/js-functions.js"></script>
        
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/ui/ui.core.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/superfish.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/live_search.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/tooltip.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/ui/ui.sortable.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/ui/ui.draggable.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/ui/ui.resizable.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/ui/ui.dialog.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/custom.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/livevalidation_standalone.js"></script>
        <link href="<?php echo base_url(); ?>resources/scripts/livevalidation_standalone.css" rel="stylesheet" media="all" />
        
        <link href="<?php echo base_url(); ?>resources/css/ui/ui.base.css" rel="stylesheet" media="all" />

    <link href="<?php echo base_url(); ?>resources/css/themes/black_rose/ui.css" rel="stylesheet" title="style" media="all" />
    <link href="<?php echo base_url(); ?>resources/css/jquery.alerts.css" rel="stylesheet" title="style" media="all" />
        
        <!-- <script type="text/javascript" src="<?php //echo base_url() ?>resources/autocomplete/jquery.js"></script> -->
        <script type="text/javascript" src="<?php echo base_url() ?>resources/autocomplete/jquery.autocomplete.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/autocomplete/jquery.autocomplete.css" />
        


    <!--[if IE 6]>
    <link href="css/ie6.css" rel="stylesheet" media="all" />
    
    <script src="js/pngfix.js"></script>
    <script>
      /* Fix IE6 Transparent PNG */
      DD_belatedPNG.fix('.logo, .other ul#dashboard-buttons li a');

    </script>
    <![endif]-->
    <!--[if IE 7]>
    <link href="css/ie7.css" rel="stylesheet" media="all" />
    <![endif]-->
</head>
<body id="sidebar-left" onload="get_po_items(13)">
    <div id="page_wrapper">
        <div id="page-header">
            <div id="page-header-wrapper">
                            <div id="top">
                    <!-- <a href="dashboard.html" class="logo" title="Admintasia V2.0">Admintasia V2.0</a> -->
                    
                    <a href="<?php echo base_url(); ?>" title="Home"><img src="<?php echo base_url(); ?>resources/images/lankacom-logo.png" alt="Logo"/></a>
                    
                                        <?php if($this->session->userdata('logged_in')){ ?>
                    <div class="welcome">
                        <span class="note">Welcome, <a title="Welcome, <?php echo $this->session->userdata('emp_name'); ?>"><?php echo $this->session->userdata('emp_name'); ?></a></span>
                        <!-- <a class="btn ui-state-default ui-corner-all" href="#">
                            <span class="ui-icon ui-icon-wrench"></span>
                            Settings
                        </a>
                        <a class="btn ui-state-default ui-corner-all" href="#">
                            <span class="ui-icon ui-icon-person"></span>
                            My account
                        </a> -->
                        <a class="btn ui-state-default ui-corner-all" href="<?php echo base_url() . 'index.php/login/log_out' ?>">
                            <span class="ui-icon ui-icon-power"></span>
                            Logout
                        </a>                        
                    </div>
                                        <?php }else{ ?>
                                        <div class="welcome">
                        <span class="note"></span>
                        <!-- <a class="btn ui-state-default ui-corner-all" href="#">
                            <span class="ui-icon ui-icon-wrench"></span>
                            Settings
                        </a>
                        <a class="btn ui-state-default ui-corner-all" href="#">
                            <span class="ui-icon ui-icon-person"></span>
                            My account
                        </a> -->
                        <a class="btn ui-state-default ui-corner-all" href="<?php echo base_url() . 'index.php/login/index' ?>">
                            <span class="ui-icon ui-icon-power"></span>
                            Login
                        </a>                        
                    </div>
                                        <?php } ?>
                </div>
