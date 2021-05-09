<fieldset class="bg-light">
    <legend class="bg-info fg-white form-head"><b>Create a new CSR</b></legend>
    <div class="container-fluid">
        <div class="row">
            <form action="index.php" method="post">
                <div class="form-group">
                    <input type="hidden" name="menuoption" value="createCSRComplete" />

                    <table style="width: 100%;" >
                        <tr>
                            <th style='text-align: right'>Common Name</th>
                            <td><input type="text" name="cert_dn[commonName]" class="form-control-sm" value="www.example.com"></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>Alternative Names (SAN)</th>
                            <td><small><i>Please enter one per line</i></small><br><textarea rows="10" cols="37" name='san' id='san' class="form-control-sm" style="height:70px !important;"></textarea></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>Contact Email Address</th>
                            <td><input type="text" name="cert_dn[emailAddress]" class="form-control-sm" value=<?PHP if (array_key_exists('emailAddress', $my_x509_parse['subject'])) print $my_x509_parse['subject']['emailAddress'];
                                                                                        else print '""'; ?> ></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>Organizational Unit Name</th>
                            <td><input type="text" name="cert_dn[organizationalUnitName]" class="form-control-sm" value=<?PHP if (array_key_exists('OU', $my_x509_parse['subject'])) print $my_x509_parse['subject']['OU'];
                                                                                                else print '""'; ?> ></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>Organization Name</th>
                            <td><input type="text" name="cert_dn[organizationName]" class="form-control-sm" value=<?PHP if (array_key_exists('O', $my_x509_parse['subject'])) print $my_x509_parse['subject']['O'];
                                                                                            else print '""'; ?> ></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>City</th>
                            <td><input type="text" name="cert_dn[localityName]" class="form-control-sm" value=<?PHP if (array_key_exists('L', $my_x509_parse['subject'])) print $my_x509_parse['subject']['L'];
                                                                                        else print '""'; ?> ></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>State</th>
                            <td><input type="text" name="cert_dn[stateOrProvinceName]" class="form-control-sm" value=<?PHP if (array_key_exists('ST', $my_x509_parse['subject'])) print $my_x509_parse['subject']['ST'];
                                                                                                else print '""'; ?>></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>Country</th>
                            <td><input type="text" name="cert_dn[countryName]" class="form-control-sm" value=<?PHP if (array_key_exists('C', $my_x509_parse['subject'])) print $my_x509_parse['subject']['C'];
                                                                                        else print '""'; ?>></td>
                        </tr>
                        <tr>
                            <th style='text-align: right'>Key Size</th>
                            <td><select name="cert_dn[keySize]" class="form-control-sm">
                                    <option value="1024">1024bits</option>
                                    <option value="2048bits" selected>2048bits</option>
                                    <option value="4096bits">4096bits</option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <th style='text-align: right' >Device Type</th>
                            <td>
                                <select name="device_type" class="form-control-sm">
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
                            <td><input type="password" class="form-control-sm" name="passphrase" /></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td style='text-align: right'><input type="submit" class="form-control btn-success" value="Create CSR" /></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>

    </div>
</fieldset>