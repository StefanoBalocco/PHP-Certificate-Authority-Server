<?php
session_start();

include('./include/functions.php');
include('./include/settings.php');
//update config
$config = update_config();
$_SESSION['config']=$config;

include('./include/functions_setup.php');
include('./include/ssl-functions.php');
include('./include/functions_csr.php');
include('./include/functions_cert.php');
include('./include/functions_key.php');
include('./include/functions_ca.php');
include('./include/functions_show_summary.php');
include('./include/functions_misc.php');

$_SESSION['cwd'] = dirname(__FILE__);
$page_variables=array();

if (count($_POST) or count($_GET)) {
  $page_variables = array_merge($_POST,$_GET);
  }
  
if (!isset($page_variables['menuoption'])){
  $page_variables['menuoption'] = FALSE;
}
    
if (!isset($page_variables['ca_name'])){
  $page_variables['ca_name'] = FALSE;
}
    
if (!isset($page_variables['print_content_only'])){
  $page_variables['print_content_only'] = FALSE;
}
    

// Various IF statements to check current status of the PHP CA
//Initial page when nothing is defined and we need to create the certificate store
if (strtoupper(get_KeyValue($config, 'certstore_path')) == 'NOT_DEFINED' && get_KeyValue($page_variables, 'menuoption') != 'setup_certstore') {
  $page_variables['menuoption'] = 'setup_certstore_form';
  $menuoption='setup_certstore_form';
  }
elseif (get_KeyValue($page_variables, 'menuoption') =='switchca' && get_KeyValue($page_variables, 'ca_name') !== FALSE) {
  // Checks for creating a CA
    if ($page_variables['ca_name'] == 'zzCREATEZZnewZZ'){
       
        $menuoption='create_ca_form';
      } else {
      // If not creating a CA set current CA to requested CA
        $menuoption = 'switchca';
        $_SESSION['my_ca'] = $page_variables['ca_name'];
        $config=update_config();
      }
  }
elseif ((get_KeyValue($page_variables, 'menuoption') === FALSE && !isset($_SESSION['my_ca'])) || 
        (!isset($_SESSION['my_ca']) && get_KeyValue($page_variables, 'menuoption') != 'setup_certstore' 
		&& get_KeyValue($page_variables, 'menuoption') != 'create_ca_form' 
		&& get_KeyValue($page_variables, 'menuoption') != 'delete_ca_form' 
		&& get_KeyValue($page_variables, 'menuoption') != 'switchca' 
		&& get_KeyValue($page_variables, 'menuoption') != 'delete_ca') ) {
  //Covers First Time Page accessed or No parameters for my_ca
  
   $menuoption = 'switchca_form';
  }
elseif (get_KeyValue($page_variables, 'menuoption') === FALSE && isset($_SESSION['my_ca']) ) {
  // Checks to see if there is an existing session CA configured, even if the menuoption parameter is empty
  $menuoption = 'menu';
  }
elseif (get_KeyValue($page_variables, 'menuoption') !== FALSE) {
  // Covers off any other valid options
  $menuoption=$page_variables['menuoption'];
  }
  
// if the session isnt configured for the config area, create a blank config array inside the session before importing the session variables into the
// config array
if (!isset($_SESSION['config'])) {
  $_SESSION['config']=array();
  }

if (isset($page_variables['device_type'])) {
  $config['x509_extensions'] = $page_variables['device_type'];
  }
if (isset($page_variables['cert_dn']['keySize'])) {
  $config['private_key_bits'] = $page_variables['cert_dn']['keySize'];
  }

// =================================================================================================================================================================
// =================================================================================================================================================================

//this will call header and footer
include('menu_switch.php');