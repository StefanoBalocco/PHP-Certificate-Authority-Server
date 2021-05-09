<div class="container-fluid">
    <div class="row">
        <fieldset class="bg-light">
            <legend class="bg-info fg-white form-head"><b>Select CSR to Reject/Delete</b></legend>
            <?php
            //View an existing CSR code form. Uses some PHP code first to ensure there are some valid CSRs available.
            $valid_files = 0;
            $dh = opendir($config['req_path']) or die('Unable to open  requests path');
            while (($file = readdir($dh)) !== false) {

                if (($file !== ".htaccess") && is_file($config['req_path'] . $file)) {
                    if (!is_file($config['cert_path'] . $file)) {
                        $valid_files++;
                    }
                }
            }
            closedir($dh);

            if ($valid_files) {

            ?>
                <form action="index.php" method="post">

                    <input type="hidden" name="menuoption" value="view_csr_details" />
                    <input type="hidden" name="form-action" value="delete" />
                    <table>
                        <tr>
                            <td><b>Name:</b>
                            <td><select name="csr_name" class="form-control">
                                    <option value="">--- Select a CSR
                                        <?php

                                        $dh = opendir($config['req_path']) or die('Unable to open  requests path');

                                        while (($file = readdir($dh)) !== false) {
                                            if (($file !== ".htaccess") && is_file($config['req_path'] . $file)) {
                                                if (!is_file($config['cert_path'] . $file)) {
                                                    $name = base64_decode(substr($file, 0, strrpos($file, '.')));
                                                    $ext = substr($file, strrpos($file, '.'));
                                                    print "<option value=\"$name$ext\">$name$ext</option>\n";
                                                }
                                            }
                                        }
                                        closedir($dh);
                                        ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>
                            <td><input type="submit" class="form-control btn-primary" value="View CSR">
                    </table>
                </form>
            <?php
            } else
                print "<b> No Valid CSRs are available to view.</b>\n";
            ?>
        </fieldset>
    </div>

</div>