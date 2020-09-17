<fieldset>

 
    <legend>Download a CSR</legend>
    <form action="index.php" method="post">
      <input type="hidden" name="menuoption" value="download_csr">
      <table style="width: 90%;">

        <tr>
          <th>Rename Extension</th>
          <td><input type="radio" name="rename_ext" value="FALSE" checked />Do not Rename<br>
          <input type="radio" name="rename_ext" value="cer" /> Rename to cer<br>
          <input type="radio" name="rename_ext" value="csr" /> Rename to csr<br></td>
        </tr>
        <?PHP
        /*

<input type="radio" name="cer_ext" value="FALSE" checked /> No <input type="radio" name="cer_ext" value="CER" /> Yes</td></tr>
<tr><th>Rename Extension to .pfx</th><td><input type="radio" name="pfx_ext" value="FALSE" checked /> No <input type="radio" name="cer_ext" value="PFX" /> Yes</td></tr>
*/
        ?>
        <tr>
          <th>Name </th>
          <td><select name="csr_name" rows="6">
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
          <td><input type="submit" value="Download CSR">
      </table>
    </form>
    </fieldset>