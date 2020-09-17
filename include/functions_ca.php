<?PHP
function switch_ca_form()
{
  session_unset();
  $config = update_config();
  //check for dir before failing
    $dh = opendir($config['certstore_path']) or die("Certstore not found-- check settings.php or your folder names");
  // 
include("./forms/switch_ca.php");
}

function delete_ca_form(&$my_errors = array('errors' => FALSE))
{
  session_unset();
  ?>
    <h1>PHP-CA Delete CA</h1>
    <?PHP
    $config = update_config();
    $dh = opendir($config['certstore_path']) or die('Fatal: Unable to opendir Certificate Store.');
    if ($my_errors['errors']) {
      if (!$my_errors['valid_text'])
        print "<b><font color='red'> Error. Please enter the correct confirmation text. DELETEME</font><BR></b>\n\n";
      if (!$my_errors['valid_ca_name'])
        print "<b><font color='red'> Error. Please select a valid certificate authority</font><BR></b>\n\n";
    }

    ?>
    <p>
      <b>Delete a certificate authority</b><br />
      This is NON REVERSIBLE!!
      You will not be prompted any further once you enter the details and click submit!!
      <form action="index.php" method="post">
        <input type="hidden" name="menuoption" value="delete_ca" />
        <table style="width: 350px;">
          <tr>
            <td>Please type DELETEME<BR>all one word.
            <td><input type="text" name="confirm_text" value="XXXX">
          <tr>
            <td>Certificate Authority:
            <td><select name="ca_name" rows="6">
                <option value="zzzDELETECAzzz">--- Select a CA
                  <?php
                  while (($file = readdir($dh)) !== false) {
                    //	if (substr($file, -4) == ".csr") {
                    if (is_dir($config['certstore_path'] . $file) && ($file != '.') && ($file != '..')) {
                      print "<option>$file";
                    }
                  }
                  ?>
              </select>
          </tr>
          <tr>
            <td>
            <td><input type="submit" value="Submit CA to delete" />
        </table>
      </form>
    </p>
  <?PHP
}

function rrmdir($dir)
{
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir . "/" . $object) == "dir") rrmdir($dir . "/" . $object);
        else unlink($dir . "/" . $object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
}

function delete_ca($my_certstore, $my_ca_name)
{
  //$this_dir = $my_certstore.htmlspecialchars($my_ca_name);
  $this_dir = $my_certstore . $my_ca_name;
  if (is_dir($this_dir)) {
    rrmdir($this_dir);
    print "<h2> Certificate Authority $my_ca_name Deleted!!</h2>";
  } else
    print "Unable to delete folder. Please check file permissions.";
}

function create_ca_form()
{
  $_SESSION['my_ca'] = 'create_ca';
  include("./forms/create_ca.php");
  ?>
    


    <?PHP
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
    $my_csrfile = create_csr($my_cert_dn, $my_keysize, $my_passphrase, $my_device_type);
    sign_csr($my_passphrase, $my_csrfile, $my_days, $my_device_type);
    //to do, check sign_csr code for device type
  }


  function download_crl_form()
  {
    $config = $_SESSION['config'];
    $this_ca = $_SESSION['my_ca'];

    //Sign an existing CSR code form. Uses some PHP code first to ensure there are some valid CSRs available.
    $valid_files = 0;
    $dh = opendir($config['crl_path']) or die('Unable to open crl path');
    while (($file = readdir($dh)) !== false) {
      if (($file !== ".htaccess") && is_file($config['crl_path'] . $file)) {
        if (is_file($config['crl_path'] . $file)) {
          $valid_files++;
        }
      }
    }
    closedir($dh);

    if ($valid_files) {
    ?>
      <p>
        <b>Download a CRL</b><br />
        <form action="index.php" method="post">
          <input type="hidden" name="menuoption" value="download_crl">
          <table style="width: 400px;">

            <tr>
              <th>Rename Extension</th>
              <td><input type="radio" name="rename_ext" value="FALSE" checked />Do not Rename<br><input type="radio" name="rename_ext" value="crl" /> Rename to crl</td>
            </tr>
            <tr>
              <th>Rename Filename to <BR><?PHP print $this_ca; ?></th>
              <td><input type="checkbox" name="rename_filename" /></td>
            </tr>

            <tr>
              <td width=100>Name:
              <td><select name="crl_name" rows="6">
                  <option value="">--- Select a CRL
                    <?php
                    $dh = opendir($config['crl_path']) or die('Unable to open ' . $config['crl_path']);
                    while (($file = readdir($dh)) !== false) {
                      if (($file !== ".htaccess") && is_file($config['crl_path'] . $file)) {
                        $name = substr($file, 0, strrpos($file, '.'));
                        $ext = substr($file, strrpos($file, '.'));
                        print "<option value=\"$name$ext\">$name$ext</option>\n";
                      }
                    }
                    ?>
                </select></td>
            </tr>
            <tr>
              <td>
              <td><input type="submit" value="Download CRL File">
          </table>
        </form>
      </p>
  <?PHP
    } else
      print "<b> No Valid CRLs are available to download.</b>\n";
  }

  function download_crl($this_crl, $crl_ext, $crl_filename)
  {
    $this_ca = $_SESSION['my_ca'];
    $config = $_SESSION['config'];
    if (!isset($crl_ext))
      $crl_ext = 'FALSE';

    $filename = substr($this_crl, 0, strrpos($this_crl, '.'));
    $ext = substr($this_crl, strrpos($this_crl, '.'));
    $download_crlfile = $config['crl_path'] . $filename . $ext;
    $application_type = 'application/octet-stream';

    if ($crl_ext != 'FALSE')
      $ext = '.' . $crl_ext;

    if ($crl_filename != 'off')
      $filename = $this_ca;

    if (file_exists($download_crlfile)) {
      $myCRL = join("", file($download_crlfile));
      download_header_code($filename . $ext, $myCRL, $application_type);
    } else {
      printHeader("Certificate Retrieval");
      print "<h1> $filename - X509 CRL not found</h1>\n";
      printFooter();
    }
  }


  ?>