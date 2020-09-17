<fieldset>
    <legend><b>Create a new CSR</b></legend>
    <form action="index.php" method="post">
        <input type="hidden" name="menuoption" value="createCSRComplete" />

        <table style="width: 100%;">
            <tr>
                <th style='text-align: right'>Common Name</th>
                <td><input type="text" name="cert_dn[commonName]" value="www.example.com" size="40"></td>
            </tr>
            <tr>
                <th style='text-align: right'>Alternative Names (SAN)</th>
                <td><small><i>Please enter one per line</i></small><br><textarea rows=4 cols=37 name='san' id='san'></textarea></td>
            </tr>
            <tr>
                <th style='text-align: right'>Contact Email Address</th>
                <td><input type="text" name="cert_dn[emailAddress]" value=<?PHP if (array_key_exists('emailAddress', $my_x509_parse['subject'])) print $my_x509_parse['subject']['emailAddress'];
                                                                            else print '""'; ?> size="30"></td>
            </tr>
            <tr>
                <th style='text-align: right'>Organizational Unit Name</th>
                <td><input type="text" name="cert_dn[organizationalUnitName]" value=<?PHP if (array_key_exists('OU', $my_x509_parse['subject'])) print $my_x509_parse['subject']['OU'];
                                                                                    else print '""'; ?> size="30"></td>
            </tr>
            <tr>
                <th style='text-align: right'>Organization Name</th>
                <td><input type="text" name="cert_dn[organizationName]" value=<?PHP if (array_key_exists('O', $my_x509_parse['subject'])) print $my_x509_parse['subject']['O'];
                                                                                else print '""'; ?> size="25"></td>
            </tr>
            <tr>
                <th style='text-align: right'>City</th>
                <td><input type="text" name="cert_dn[localityName]" value=<?PHP if (array_key_exists('L', $my_x509_parse['subject'])) print $my_x509_parse['subject']['L'];
                                                                            else print '""'; ?> size="25"></td>
            </tr>
            <tr>
                <th style='text-align: right'>State</th>
                <td><input type="text" name="cert_dn[stateOrProvinceName]" value=<?PHP if (array_key_exists('ST', $my_x509_parse['subject'])) print $my_x509_parse['subject']['ST'];
                                                                                    else print '""'; ?> size="25"></td>
            </tr>
            <tr>
                <th style='text-align: right'>Country</th>
                <td><input type="text" name="cert_dn[countryName]" value=<?PHP if (array_key_exists('C', $my_x509_parse['subject'])) print $my_x509_parse['subject']['C'];
                                                                            else print '""'; ?> size="2"></td>
            </tr>
            <tr>
                <th style='text-align: right'>Key Size</th>
                <td><select name="cert_dn[keySize]">
                        <option value="1024">1024bits</option>
                        <option value="2048bits" selected>2048bits</option>
                        <option value="4096bits">4096bits</option>
                    </select>

                </td>
            </tr>
            <tr>
                <th style='text-align: right'>Device Type</th>
                <td>
                    <select name="device_type">
                        <option value="client_cert">Client</option>
                        <option value="server_cert" selected="selected">Server</option>
                        <option value="msdc_cert">Microsoft Domain Controller</option>
                        <option value="subca_cert">Sub_CA</option>
                        <option value="8021x_client_cert">802.1x Client</option>
                        <option value="8021x_server_cert">802.1x Server</option>
                        
                    </select>
                </td>
            </tr>
            <tr>
                <th style='text-align: right'>Certificate Passphrase</th>
                <td><input type="password" name="passphrase" /></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td style='text-align: right'><input type="submit" value="Create CSR" /></td>
            </tr>
        </table>
    </form>
</fieldset>