<div class="continer-fluid">
    <div class="row ">
        <div class="col-1-sm">&nbsp;</div>
        <div class="col-1-sm">&nbsp;</div>
        <div class="col-1-sm">
            <fieldset class="bg-light">
                <legend class="bg-info fg-white form-head"><b>Upload a CSR</b></legend>

                <form class="form-group" enctype="multipart/form-data" action="index.php" method="POST">
                    <input class="form-control" type="hidden" name="menuoption" value="upload_CSR" />
                    <input class="form-control-file" type="hidden" name="MAX_FILE_SIZE" value="100000" />
                    <table style="width: 90%;">
                        <tr>
                            <th>Choose a CSR to upload:</th>
                        </tr>
                        <tr>
                            <td><input class="btn-light" name="uploadedfile" type="file" id="uploaded_csr" />
                        <tr>
                            <td><input class="btn-primary" type="submit" value="Upload CSR" />
                    </table>
                </form>
            </fieldset>
        </div>
    </div>
</div>