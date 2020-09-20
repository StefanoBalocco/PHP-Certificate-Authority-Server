<div class="continer-fluid">
  <div class="row ">
    <div class="col-1-sm">&nbsp;</div>
    <div class="col-1-sm">&nbsp;</div>
    <div class="col-1-sm">


      <fieldset class="bg-light">
        <legend class="bg-info fg-white form-head"><b>Download a CSR</b></legend>
        <form action="index.php" method="post" class="form-group">
          <input type="hidden" name="menuoption" value="download_csr">
          <table style="width: 90%;">

            <tr>
              <th>Rename Extension</th>
              <td>
                <select class="form-control" name="rename_ext">
                  <option value="FALSE">Do not rename</option>
                  <option value="cer">Rename to cer</option>
                  <option value="csr">Rename to csr</option>
                </select>
                
              </td>
            </tr>
            <?PHP
            /*

<input type="radio" name="cer_ext" value="FALSE" checked /> No <input type="radio" name="cer_ext" value="CER" /> Yes</td></tr>
<tr><th>Rename Extension to .pfx</th><td><input type="radio" name="pfx_ext" value="FALSE" checked /> No <input type="radio" name="cer_ext" value="PFX" /> Yes</td></tr>
*/
            ?>
            <tr>
              <th>Name </th>
              <td><select name="csr_name" rows="6" class="form-control">
                  <option value="">--- Select a CSR
                    <?php
                    $dh = opendir($config['req_path']) or die('Unable to open ' . $config['req_path']);
                    while (($file = readdir($dh)) !== false) {
                      if (($file !== ".htaccess") && is_file($config['req_path'] . $file)) {
                        $name = base64_decode(substr($file, 0, strrpos($file, '.')));
                        $ext = substr($file, strrpos($file, '.'));
                        print "<option value=\"$name$ext\">$name$ext</option>\n";
                      }
                    }
                    ?>
                </select></td>
            </tr>
            <tr>
              <td>
              <td><input type="submit" value="Download CSR" class="form-control btn-secondary">
          </table>
        </form>
      </fieldset>

    </div>
  </div>
</div>