<?PHP
//creating this file to consolidate functions instead of going to multiple pages for edits

/*
###############################################################################
###############################################################################
#####################         CSR Functions          ##########################
###############################################################################
*/

function create_config($config, $cn){
    //this function will create the custom config file allowing for multiple subject alternative names such as wildcard domains
    print("<div class='alert-success'>Creating Custom OpenSSL config file</div><br>");
    $template = $config['config_dir'] . $cn . "-openssl.conf";
    copy($config['ca_path'] .  "openssl.conf", $template);
    
    return $template;
}

function create_csr($my_cert_dn, $my_keysize, $my_passphrase, $my_device_type)
{
    //this needs to be broken into multiple functions to reduce code
    $config = $_SESSION['config'];
    // update the conf
    $configfile = create_config($config,$_POST['cert_dn']['commonName']);
    //

    //if there are subject alternative names then update the config file to include
    //lines for SAN

    if (isset($_POST['san'])) {
        $san_list = explode("\n", trim($_POST['san']));
        create_conf($san_list, $configfile);
    }

    //reset default config file to new domain specific config file
    $config['config'] = $configfile;

    $cert_dn = array();

    print "<div class='alert-success'>Creating Certificate Key</div>";
    print "<div class='alert-warning'>PASSWORD set: " . $my_passphrase . "</div><br>";

    foreach ($my_cert_dn as $key => $val) {
        if (array_key_exists($key, $my_cert_dn))
            if (strlen($my_cert_dn[$key]) > 0) {
                if($key != "keySize"){
                    $cert_dn[$key] = $my_cert_dn[$key];
                }
                
            }
    }

    $my_csrfile = "";
    foreach ($config['blank_dn'] as $key => $value) {
        if (isset($cert_dn[$config['convert_dn'][$key]]))
            $my_csrfile = $my_csrfile . $cert_dn[$config['convert_dn'][$key]] . ":";
        else
            $my_csrfile = $my_csrfile . ":";
    }

    $my_csrfile = substr($my_csrfile, 0, strrpos($my_csrfile, ':'));

    $filename = base64_encode($my_csrfile);
    print "<div class='alert-success'>CSR Filename : " . $my_csrfile . "</div>";

    if ($my_device_type == 'ca_cert') {
        $client_keyFile = $config['cakey'];
        $client_reqFile = $config['req_path'] . $filename . ".pem";
    } else {
        $client_keyFile = $config['key_path'] . $filename . ".pem";
        $client_reqFile = $config['req_path'] . $filename . ".pem";
    }

    print "<div class='alert-success'>Creating Client CSR and Client Key</div><br>";

    print "<div class='alert-success'><b>Checking your DN (Distinguished Name)...</b></div>";
    
    $my_new_config = array('config' => $config['config'], 'private_key_bits' => (int)$my_keysize);
    
    $privkey = openssl_pkey_new($my_new_config) or die('Fatal: Error creating Certificate Key');
    
    print "<div class='alert-secondary'>Done</div><br/>\n";

    if ($my_device_type == 'ca_cert') {
        print "<div class='alert-success'><b>Exporting encoded private key to CA Key file...</b></div>";
    } else {
        print "<div class='alert-success'><b>Exporting encoded private key to file...</b></div>";
    }
    openssl_pkey_export_to_file($privkey, $client_keyFile, $my_passphrase) or die('Fatal: Error exporting Certificate Key to file');


    print "<div class='alert-secondary'>Done</div><br/>\n";

    print "<div class='alert-success'><b>Creating CSR...</b></div>";
  
    /*
    $cert_dn
    Array
(
    [commonName] => www.example3.com
    [emailAddress] => cert@example.com
    [organizationalUnitName] => Device
    [organizationName] => Example.com
    [localityName] => Abita
    [stateOrProvinceName] => Louisiana
    [countryName] => US
    [keySize] => 2048bits
)
    */
    $my_csr = openssl_csr_new($cert_dn, $privkey, $config) or die('Fatal: Error creating CSR');
    //openssl req -new -sha256 -key example_com.key -out example_com.csr -config C:\WampDeveloper\Config\Apache\openssl.cnf
    print "<div class='alert-secondary'>Done</div><br/>\n";

    print "<div class='alert-success'><b>Exporting CSR to file...</b></div>";
    openssl_csr_export_to_file($my_csr, $client_reqFile, FALSE) or die('Fatal: Error exporting CSR to file');
    
    print "<div class='alert-secondary'>Done</div><br/>\n";

    $my_details = openssl_csr_get_subject($my_csr);
    $my_public_key_details = openssl_pkey_get_details(openssl_csr_get_public_key($my_csr));

    // print_r($my_details);
    print "<div class='alert-success'><b>Client CSR and Key - Generated successfully</b></div>";

    // print($my_public_key_details['key']);
    $data = openssl_public_decrypt($my_public_key_details['key'],$finaltext, $my_public_key_details['key']);

    return array($my_details,$my_public_key_details,$my_csrfile);
}


//create openssl config file
function create_conf($san_list,$configfile){
    $config = $_SESSION['config'];
    //get contents of the openssl.conf template
    $openssl_conf_array = parse_ini_file($config['config'], true);
    $newconfig = "";

    foreach($openssl_conf_array as $key => $val){
      
        
        if($key == " v3_req "){
            //if sub alt names then add line
            $newconfig .= "[$key]" . "\n";
            if(strlen($san_list[0]) >= 3){
                foreach($val as $key2 => $val2){
                  $newconfig .= $key2 . " = " . $val2 . "\n";
                }
                $newconfig .= "subjectAltName = @subject_alt_names";
                $newconfig .= "\n";
  
                $newconfig .= "\n\n[subject_alt_names]\n";
                $san_list_formated = "";
                for($i=0; $i<count($san_list); $i++){
                    $index = $i + 1;
                    $san_list_formated .= 'DNS.' . $index . " = " . $san_list[$i] . "\n";
                    
                  }
                  $newconfig .= $san_list_formated;
            } else {
                foreach($val as $key2 => $val2){
                  $newconfig .= $key2 . " = " . $val2 . "\n";
                }
                $newconfig .= "\n";
            }
          
          
          }elseif($key == " req_ext "){
              if(strlen($san_list[0]) >= 3){
                $newconfig .= "\n[ req_ext ] \n";
                $newconfig .= "subjectAltName          = @subject_alt_names\n";
              }      
        } else {
          $newconfig .= "[$key]" . "\n";
            foreach($val as $key2 => $val2){
              if($key2 == "nsComment"){
                $newconfig .= $key2 . " = " . $_SESSION['my_ca'] . " " . $val2 . "\n";
              }elseif($key2 == "subjectAltName" && $val2 == "@subject_alt_names" && strlen($san_list[0]) < 3){
                $newconfig .= $key2 . " = email:copy";
              } else {
                $newconfig .= $key2 . " = " . $val2 . "\n";
              }
              
            }
        }
        
        $newconfig .= "\n";
    }
  
  //write new config
  file_put_contents($configfile, $newconfig);
  }


  //Download CSR
  function download_csr($this_cert, $cer_ext)
{
  $config = $_SESSION['config'];
  if (!isset($cer_ext))
    $cer_ext = 'FALSE';

  if ($this_cert == "zzTHISzzCAzz") {
    $my_x509_parse = openssl_x509_parse(file_get_contents($config['cacert']));
    $filename = $my_x509_parse['subject']['CN'] . ":" . $my_x509_parse['subject']['OU'] . ":" . $my_x509_parse['subject']['O'] . ":" . $my_x509_parse['subject']['L'] . ":" . $my_x509_parse['subject']['ST'] . ":" . $my_x509_parse['subject']['C'];
    $download_certfile = $config['cacert'];
    $ext = ".pem";
    //$application_type="application/x-x509-ca-cert";
    $application_type = 'application/octet-stream';
  } else {
    $filename = substr($this_cert, 0, strrpos($this_cert, '.'));
    $ext = substr($this_cert, strrpos($this_cert, '.'));
    $download_certfile = base64_encode($filename);
    $download_certfile = $config['req_path'] . $download_certfile . $ext;
    $application_type = 'application/octet-stream';
  }
  if ($cer_ext != 'FALSE')
    $ext = '.' . $cer_ext;

  if (file_exists($download_certfile)) {
    $myCert = join("", file($download_certfile));
    download_header_code($filename . $ext, $myCert, $application_type);
  } else {
    printHeader("Certificate Retrieval");
    print "<h1> $filename - X509 CA certificate not found</h1>\n";
    printFooter(FALSE);
  }
}

function create_ca($my_certstore_path, $my_device_type, $my_cert_dn, $my_passphrase)
  {

    //if (!is_dir($my_certstore_path.$my_cert_dn['commonName']))
    create_cert_store($my_certstore_path, $my_cert_dn['commonName']);
    //else
    //  die('Fatal: CA Store already exists for '. $my_cert_dn['commonName']);

    $my_days = $my_cert_dn['days'];
    $my_keysize = $my_cert_dn['keySize'];
    unset($my_cert_dn['days']);
    unset($my_cert_dn['keySize']);

    $result = create_csr($my_cert_dn, $my_keysize, $my_passphrase, $my_device_type);
    $my_csrfile = $result[2] . ".pem";
    
    sign_csr($my_passphrase, $my_csrfile, $my_days, $my_device_type);
    //to do, check sign_csr code for device type
  }



function printFormatedBox($heading="", $formatedtext=""){

  $code = "<div class=\"container-fluid\">\n";
  $code .= "\t<div class=\"row\">\n";
  $code .= "\t\t<fieldset class=\"bg-light\">\n";
  $code .= "\t\t\t<legend class=\"bg-info fg-white form-head\">";
  $code .= $heading;
  $code .= "</legend>\n";
  $code .= "\t\t\t" . $formatedtext . "\n";
  $code .= "\t\t</fieldset>\n";
  $code .= "\t</div>\n";
  $code .= "</div>\n";
  return $code;
}



  function import_csr($my_csr)
{
  $config = $_SESSION['config'];

  //CN:Email:OU:O:L:ST:GB 
  $cert_dn = openssl_csr_get_subject($my_csr);
  $my_csrfile = "";
  foreach($config['blank_dn'] as $key => $val) {
    if (isset($cert_dn[$key]))
      $my_csrfile = $my_csrfile . $cert_dn[$key] . ":";
    else
      $my_csrfile = $my_csrfile . ":";
  }
  
  
  $text = p2($cert_dn, 'a');
  $my_csrfile = substr($my_csrfile, 0, strrpos($my_csrfile, ':'));
  $my_csrfile = $config['req_path'] . base64_encode($my_csrfile) . ".pem";
  $text.= "<b>Saving your CSR...</b><br/>";
  if ($fp = fopen($my_csrfile, 'w') or die('Fatal: Error open write $my_csrfile')) {
    fputs($fp, $my_csr)  or die('Fatal: Error writing to $my_csrfile');
    fclose($fp)  or die('Fatal: Error closing write $my_csrfile');
  }
  //removing the path from the file name as we should not be exposing that
  $text .= "CSR Filename:" . str_replace($_SESSION['config']['req_path'],"", $my_csrfile);
  $text .= "<br><b>Done</b>";
  
  print(printFormatedBox("CSR Upload Processed", $text));

}
?>