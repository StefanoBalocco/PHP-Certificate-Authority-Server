<fieldset class="bg-light">
    <legend class="bg-info fg-white form-head"><b>Sign a CSR - Generate a Certificate</b></legend>
    <?php
    //Sign an existing CSR code form. Uses some PHP code first to ensure there are some valid CSRs available.
    $valid_files = 0;
    $dh = opendir($config['req_path']) or die('Unable to open  requests path');
    // echo $config['cert_path'];
    while (($file = readdir($dh)) !== false) {
      if (($file !== ".htaccess") && is_file($config['req_path'] . $file)) {
        $name = base64_decode(substr($file, 0, strrpos($file, '.')));
        $ext = substr($file, strrpos($file, '.'));
        if (!is_file($config['cert_path'] . $file) or ($my_values['csr_name'] == "$name$ext")) {
          $valid_files++;
        }
      }
    }
    closedir($dh);

    if ($valid_files) {
    ?>
      <form action="index.php" method="post">
        <input type="hidden" name="menuoption" value="sign_csr" />
        <table>
          <tr>
            <th class='formtitles'>CA Passphrase:</th>
            <td><input class="form-control" type="password" name="pass" /></td>
          <tr>
            <th class='formtitles'>Expiration:</th>
            <td><input class="form-control" type="text" name="days" value="730" />
              <small style='color:red; font-style:italic;'>Number of days Certificate is to be valid for:</small></td>

          <tr>
            <th class='formtitles'>Certificate Type:</th>
            
            <td><select name="device_type" class="form-control">
              <option value="client_cert">Client</option>
              <option value="server_cert" selected="selected">Server</option>
              <option value="msdc_cert">Microsoft Domain Controller</option>
              <option value="subca_cert">Sub_CA</option>
              <option value="8021x_client_cert">802.1x Client</option>
              <option value="8021x_server_cert">802.1x Server</option>
            </select></td>
          </tr>
          <tr>
            <th class='formtitles'>CSR Name:</th>
            <td><select name="csr_name" class="form-control">
                <option value="">--- Select a CSR ---</option>
                <?php

                $dh = opendir($config['req_path']) or die('Unable to open  requests path');
                while (($file = readdir($dh)) !== false) {
                  if (($file !== ".htaccess") && is_file($config['req_path'] . $file)) {
                    $name = base64_decode(substr($file, 0, strrpos($file, '.')));
                    $ext = substr($file, strrpos($file, '.'));
                    if (!is_file($config['cert_path'] . $file) or ($my_values['csr_name'] == "$name$ext")) {
                      if ($my_values['csr_name'] == "$name$ext") $this_selected = " selected=\"selected\"";
                      else $this_selected = "";
                      print "<option value=\"$name$ext\"" . $this_selected . ">$name $ext</option>\n";
                    }
                  }
                }
                closedir($dh);
                ?>
              </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="formtitles"><input class="form-control btn-primary" type="submit" value="Sign CSR"></td>
        </table>
      </form>
      <p>
        <br>

      <?php
    } else
      print "<b> No Valid CSRs are available to sign.</b>\n";
      ?>
      </p>
      </fieldset>