<div class="container-fluid">
    <fieldset>
        <legend><b>Switch to a different CA<br \></legend>
        If you wish to create a new Sub-CA please select create CSR and select device type as Sub_CA.

        <form action="index.php" method="post">
            <input type="hidden" name="menuoption" value="switchca" />
            <table style="width: 600px;">
                <tr>
                    <td>Certificate Authority:</td>
                    <td><select name="ca_name" rows="6">
                            <option value="">--- Select a CA</option>
                            <option value="zzCREATEZZnewZZ">Create New Root CA</option>
                            <?PHP
                            while (($file = readdir($dh)) !== false) {
                                //	if (substr($file, -4) == ".csr") {
                                if (is_dir($config['certstore_path'] . $file) && ($file != '.') && ($file != '..')) {
                                    print "<option>$file</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><input type="submit" value="Submit CA" /></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>