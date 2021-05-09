<div class="container-fluid">
    <fieldset class="bg-light">
        <legend class="bg-info fg-white form-head"><b>Switch to a different CA<br \></legend>
        If you wish to create a new Sub-CA please select create CSR and select device type as Sub_CA.

        <form action="index.php" method="post" class="formDiv">
            <input type="hidden" name="menuoption" value="switchca" />
            <table style="width: 600px;">
                <tr>
                    <td><i class="fas fa-certificate" style="font-size:28px; color:goldenrod"></i>&nbsp;Certificate Authority:</td>
                    <td>
                        <select name="ca_name">
                            <option value="">--- Select a CA</option>
                            <option value="zzCREATEZZnewZZ">Create New Root CA</option>
                            <?PHP
                            while (($file = readdir($dh)) !== false) {
                                //	if (substr($file, -4) == ".csr") {
                                if (is_dir($config['certstore_path'] . $file) && ($file != '.') && ($file != '..')) {
                                    print "<option value='" .$file . "'>$file</option>";
                                }
                            }
                            ?>
                            <option value="disco-all">Disconnect from All CAs</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center"><input type="submit" value="Submit CA" /></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>