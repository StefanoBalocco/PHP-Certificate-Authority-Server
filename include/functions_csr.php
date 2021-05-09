<?PHP
// ==================================================================================================================
// =================== CREATE CSR =====================================================================================
// ==================================================================================================================

function createCSR_form($config)
{
  $my_x509_parse = openssl_x509_parse(file_get_contents($config['cacert']));
  include("forms/create_csr.php");

}

function createCSRComplete($my_cert_dn, $my_keysize, $my_passphrase, $my_device_type){
  //call function create csr from ssl-functions
  $results = create_csr($my_cert_dn, $my_keysize, $my_passphrase, $my_device_type);
  
  $my_details = $results[0];
  $my_public_key_details = $results[1];
  // $my_csrfile = $results[2];

  include("forms/create_csr_complete.php");

}
// ==================================================================================================================
// =================== DOWNLOAD CSR =====================================================================================
// ==================================================================================================================

function download_csr_form($config)
{
include("./forms/download_csr.php");
}




// ==================================================================================================================
// =================== IMPORT CSR =====================================================================================
// ==================================================================================================================


function import_CSR_form($config)
{
include("./forms/import_csr.php");
}





// ==================================================================================================================
// =================== UPLOAD CSR =====================================================================================
// ==================================================================================================================



function upload_CSR_form()
{
 include("./forms/upload_csr.php");
}


function upload_csr($uploaded_file)
{
  $config = $_SESSION['config'];

  if (!is_dir($config['csr_upload_path']))
    mkdir($config['csr_upload_path'], 0777, true) or die('Fatal: Unable to create upload folder');

  if ($uploaded_file["error"] > 0)
    die('Uploaded File Error: ' . $uploaded_file["error"]);
  else
  if ($uploaded_file["size"] > 20000)
    die('Fatal: CSR file is too large.');
  else {
    $my_uploaded_file = $config['csr_upload_path'] . $uploaded_file["name"];
    if (file_exists($my_uploaded_file)) {
      unlink($my_uploaded_file);
      //      echo $uploaded_file["name"] . " already exists. ";
    }
    move_uploaded_file($uploaded_file["tmp_name"], $my_uploaded_file) or die('Fatal: Error moving uploaded file');
    print "<b>Reading Uploaded CSR file...</b><br/>";
    $fp = fopen($my_uploaded_file, "r") or die('Fatal: Error opening uploaded file');
    $my_csr = fread($fp, filesize($my_uploaded_file)) or die('Fatal: Error reading CSR file');
    fclose($fp) or die('Fatal: Error closing CSR file ');
    print "Done<br/><br/>\n";
    $cert_dn = openssl_csr_get_subject($my_csr) or die('Invalid CSR Format.');
    print "<table  style=\"width: 90%;\">";
    print "<tr><th width=100>Certificate Details</th><td></td></tr>";
    $my_index_name = '';
    $my_csrfile = "";
    foreach($config["blank_dn"] as $key => $val) {
      if (isset($cert_dn[$key])) {
        $my_csrfile = $my_csrfile . $cert_dn[$key] . ":";
        print "<tr><th>" . $config['blank_dn'][$key] . "</th><td>" . $cert_dn[$key] . "</td></tr>\n";
        $my_index_name = "/" . $key . "=" . $cert_dn[$key] . $my_index_name;
      } else
        $my_csrfile = $my_csrfile . ":";
    }
    $my_csrfile = substr($my_csrfile, 0, strrpos($my_csrfile, ':'));
    print "</table>\n";
    if (does_cert_exist($my_index_name))
      die('Fatal: A certificate already exists for uploaded CSR.');
    else {
      $filename = base64_encode($my_csrfile) . ".pem";
      $client_reqFile = $config['req_path'] . $filename;
      print "<b>Saving your CSR...</b><br/>";
      if ($fp = fopen($client_reqFile, 'w') or die('Fatal: Error open write $my_csrfile')) {
        fputs($fp, $my_csr)  or die('Fatal: Error writing to $my_csrfile');
        fclose($fp)  or die('Fatal: Error closing write $my_csrfile');
      }
      print "CSR file saved as $filename\n<br>\n";
      print "<b>Done";
    }
  }
}


// ==================================================================================================================
// =================== VIEW CSR =====================================================================================
// ==================================================================================================================


function view_csr_details_form($config)
{  
  include("./forms/view_csr.php");
}


function view_csr($my_csrfile)
{
  $config = $_SESSION['config'];
  $name = base64_encode(substr($my_csrfile, 0, strrpos($my_csrfile, '.')));
  $ext = substr($my_csrfile, strrpos($my_csrfile, '.'));
  $my_base64_csrfile = $name . $ext;
  

            if(isset($_POST['form-action'])){
         
                $return_url="index.php?menuoption=delete_csr_form";
                $form_title="Reject/Delete this CSR";
            } else {
              $form_title="Viewing certificate request";
              $return_url="index.php?menuoption=view_csr_details_form";
            }
  include("./forms/view_csr_details.php");
}


// ==================================================================================================================
// =================== SIGN CSR =====================================================================================
// ==================================================================================================================


function sign_csr_form($config,$my_values = array('csr_name' => '::zz::'))
{
  include("./forms/sign_csr_form.php");
}

function reject_csr_form($config){
  include("./forms/delete_csr_form.php");
}


  function sign_csr($passPhrase, $my_csrfile, $my_days, $my_device_type)
  {
    $mycsrfilename = $my_csrfile;
    $namearr = explode(":",$mycsrfilename);
    $mydom = $namearr[0];
    //replace generic openssl.conf with domain specific
    $_SESSION['config']['config'] = $_SESSION['config']['config_dir'] . $mydom . "-openssl.conf";
    $config = $_SESSION['config'];
    
    
    $name = base64_encode(substr($my_csrfile, 0, strrpos($my_csrfile, '.')));
    $ext = substr($my_csrfile, strrpos($my_csrfile, '.'));
    $my_base64_csrfile = $name . $ext;
    $fp = fopen($config['cakey'], "r") or die('Fatal: Error opening CA Key' . $config['cakey']);
    $my_key = fread($fp, filesize($config['cakey'])) or die('Fatal: Error reading CA Key' . $config['cakey']);
    fclose($fp) or die('Fatal: Error closing CA Key' . $config['cakey']);
    print "Done<br/><br/>\n";

    print "<b>Decoding CA key...</b><br/>";
    $my_ca_privkey = openssl_pkey_get_private($my_key, $passPhrase) or die('Fatal: Error decoding CA Key. Passphrase Incorrect');
    print "Done<br/><br/>\n";

    if (!($my_device_type == 'ca_cert')) {
      print "<b>Loading CA Certificate...</b><br/>";
      $fp = fopen($config['cacert'], "r") or die('Fatal: Error opening CA Certificate' . $config['cacert']);
      $my_ca_cert = fread($fp, filesize($config['cacert'])) or die('Fatal: Error reading CA Certificate' . $config['cacert']);
      fclose($fp) or die('Fatal: Error closing CA Certificate' . $config['cacert']);
      print "Done<br/><br/>\n";
    } else
      $my_ca_cert = NULL;

    print "<b>Loading CSR from file...</b><br/>";
    
    $fp = fopen($config['req_path'] . $my_base64_csrfile, "r") or die('Fatal: Error opening CSR file' . $my_base64_csrfile);
    
    $my_csr = fread($fp, filesize($config['req_path'] . $my_base64_csrfile)) or die('Fatal: Error reading CSR file' . $my_base64_csrfile);
    fclose($fp) or die('Fatal: Error closing CSR file ' . $my_base64_csrfile);
    print "Done<br/><br/>\n";

    if ($my_device_type == 'ca_cert') {
      print "<b>Deleting CSR file from Cert Store...</b><br/>";
      unlink($config['req_path'] . $my_base64_csrfile) or die('Fatal: Error deleting CSR file' . $my_base64_csrfile);
      print "Done<br/><br/>\n";
    }

    print "<b>Signing CSR...</b><br/>";
    $my_serial = sprintf("%04d", get_serial());    
 
    $my_scert = openssl_csr_sign($my_csr, $my_ca_cert, $my_ca_privkey, $my_days, $config, $my_serial) or die('Fatal: Error signing CSR.');
    print "Done<br/><br/>\n";

    print "<b>Exporting X509 Certificate...</b><br/>";
    openssl_x509_export($my_scert, $my_x509_scert);
    print "Done<br/><br/>\n";

    $my_x509_parse = openssl_x509_parse($my_x509_scert);
    $my_hex_serial = dechex($my_serial);
    if (is_int((strlen($my_hex_serial) + 1) / 2))
      $my_hex_serial = "0" . $my_hex_serial;
    //$index_line="V\t".$my_x509_parse['validTo']."\t\t".$my_serial."\tunknown\t".$my_x509_parse['name'];
    $my_index_name = "/C=" . $my_x509_parse['subject']['C'] . "/ST=" . $my_x509_parse['subject']['ST'] . "/L=" . $my_x509_parse['subject']['L'] . "/O=" . $my_x509_parse['subject']['O'] . "/OU=" . $my_x509_parse['subject']['OU'] . "/CN=" . $my_x509_parse['subject']['CN'] . "/emailAddress=" . $my_x509_parse['subject']['emailAddress'];
    $index_line = "V\t" . $my_x509_parse['validTo'] . "\t\t" . $my_hex_serial . "\tunknown\t" . $my_index_name;

    //Patern to match the index lines
    $pattern = '/(\D)\t(\d+[Z])\t(\d+[Z])?\t(\d+)\t(\D+)\t(.+)/';

    //Check to see if the certificate already exists in the Index file (ie. If someone clicks refresh on the webpage after creating a cert)
    $my_valid_cert = does_cert_exist($my_index_name);

    if ($my_valid_cert == 0) {
      print "<b>Saving X509 Certificate...</b><br/>";
      if ($my_device_type == 'ca_cert')
        $my_scertfile = $config['cacert'];
      else
        $my_scertfile = $config['cert_path'] . $my_base64_csrfile;
      if ($fp = fopen($my_scertfile, 'w') or die('Fatal: Error opening Signed Cert X509 file $my_scertfile')) {
        fputs($fp, $my_x509_scert)  or die('Fatal: Error writing Signed Cert X509 file $my_scertfile');
        fclose($fp)  or die('Fatal: Error closing Signed Cert X509 file $my_scertfile');
      }
      if (!($my_device_type == 'ca_cert')) {
        $my_scertfile = $config['newcert_path'] . $my_serial . ".pem";
        if ($fp = fopen($my_scertfile, 'w') or die('Fatal: Error opening Signed Cert X509 file $my_scertfile')) {
          fputs($fp, $my_x509_scert)  or die('Fatal: Error writing Signed Cert X509 file $my_scertfile');
          fclose($fp)  or die('Fatal: Error closing Signed Cert X509 file $my_scertfile');
        }
        print "Done\n<br>\n";
        print "<b>Updating Index File...</b><br>";
        $my_index_handle = fopen($config['index'], "a") or die('Fatal: Unable to open Index file for appending');
        fwrite($my_index_handle, $index_line . "\n") or die('Fatal: Unable to append data to end of Index file');
        fclose($my_index_handle) or die('Fatal: Unable to close Index file');
      }
      print "Done";
      print "<br><br>";
      print "<b>Download Certificate:</b>\n<br>\n<br>\n";


    include("./forms/sign_csr.php");
  ?>
    
  <?PHP

      if ($my_device_type == 'subca_cert') {
        print "Creating Sub-CA certificate Store...\n<br>";
        $my_cert_dn = openssl_csr_get_subject($my_csr) or die('Fatal: Getting Subject details from CSR');
        create_cert_store($config['certstore_path'], $my_cert_dn['CN']);
        print "Copying Sub CA Certificate over...\n<br>";
        copy($config['cert_path'] . $my_base64_csrfile, $config['certstore_path'] . $my_cert_dn['CN'] . '/cacert.pem') or die('Fatal: Unable to copy sub-ca cacert.pem from Existing CA to Sub-CA Certificate Store');
        print "Done\n<br>";
        print "Copying Sub CA Certificate over...\n<br>";
        copy($config['key_path'] . $my_base64_csrfile, $config['certstore_path'] . $my_cert_dn['CN'] . '/cacert.key') or die('Fatal: Unable to copy sub-ca cakey.pem from Existing CA to Sub-CA Certificate Store');
        print "Done\n<br>";
      }
    } else
      print "<h1>" . $my_x509_parse['name'] . " already exists in the Index file and is Valid.</h1>";
  } //end of function sign_cert()

  ?>