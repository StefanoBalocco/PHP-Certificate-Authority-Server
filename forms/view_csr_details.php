<div class="container-fluid">
    <div class="row">
        <div class="col-1-sm">&nbsp;</div>
        <div class="col-1-sm">&nbsp;</div>
        <div class="col-1-sm">&nbsp;</div>
        <div class="col-3-sm">
            <fieldset class="bg-light">
                <legend class="bg-info fg-white form-head"><b><?PHP echo $form_title; ?></b></legend>
                <input type='button' class='button' style='margin-left: 100px;' onclick="window.location='<?PHP echo $return_url; ?>'" value="Back"><br>
                <?php
                print "<b>Loading CSR from file...</b><br/>";
                $fp = fopen($config['req_path'] . $my_base64_csrfile, "r") or die('Fatal: Error opening CSR file ' . $my_base64_csrfile);
                $my_csr = fread($fp, filesize($config['req_path'] . $my_base64_csrfile)) or die('Fatal: Error reading CSR file ' . $my_base64_csrfile);
                fclose($fp) or die('Fatal: Error closing CSR file ' . $my_base64_csrfile);
                print "Done<br/><br/>\n";
                //removing html formatting
                print("<pre>");
                print $my_csr;
                print("</pre>");
                print "<BR><BR><BR>\n\n\n";
                $my_details = openssl_csr_get_subject($my_csr);
                $my_public_key_details = openssl_pkey_get_details(openssl_csr_get_public_key($my_csr));
                ?>
                <table style='border:1px solid #000000; padding: 10px' class='boxbg'>
                    <tr>
                        <th class='formtitles'>Common Name (eg www.golf.local)</th>
                        <td><?PHP print $my_details['CN']; ?></td>
                    </tr>
                    <tr>
                        <th class='formtitles'>Contact Email Address</th>
                        <td><?PHP print $my_details['emailAddress']; ?></td>
                    </tr>
                    <tr>
                        <th class='formtitles'>Organizational Unit Name</th>
                        <td><?PHP print $my_details['OU']; ?></td>
                    </tr>
                    <tr>
                        <th class='formtitles'>Organization Name</th>
                        <td><?PHP print $my_details['O']; ?></td>
                    </tr>
                    <tr>
                        <th class='formtitles'>City</th>
                        <td><?PHP print $my_details['L']; ?></td>
                    </tr>
                    <tr>
                        <th class='formtitles'>State</th>
                        <td><?PHP print $my_details['ST']; ?></td>
                    </tr>
                    <tr>
                        <th class='formtitles'>Country</th>
                        <td><?PHP print $my_details['C']; ?></td>
                    </tr>
                    <tr>
                        <th class='formtitles'>Key Size</th>
                        <td><?PHP print $my_public_key_details['bits']; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <form action="" method="post" name="form1" id="form1"><input type="hidden" name="" value=""></form>>
                        </td>
                    </tr>
                </table>
                <br>
                <input type='button' class='button' style='margin-left: 100px;' onclick="window.location='<?PHP echo $return_url; ?>'" value="Back">
            </fieldset>
        </div>
    </div>

</div>