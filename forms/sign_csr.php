<div class="container-fluid">
  <div class="row">
    <div class="col formDiv">
      <fieldset class="bg-light">
        <legend class="bg-info fg-white form-head">Signing certificate request</legend>

        <div id="status_banner"></div>
        <script>
          write_to_banner("status_banner", "We will sign the requested CSR with this CA's key.");
        </script>

        </p>

        <p>
          Now signing certificate... Please wait...
        </p>


        <script>
          write_to_banner("status_banner", "Loading CA Key...");
        </script>
        <form action="index.php" method="post">
          <input type="hidden" name="menuoption" value="download_cert">
          <input type="hidden" name="cert_name" value="<?PHP if ($my_device_type == 'ca_cert') print 'zzTHISzzCAzz';
                                                        else print $my_csrfile; ?>">
          <input type="submit" value="Download Signed Certificate">
        </form>
        <BR>
        <form action="index.php" method="post">
          <input type="hidden" name="menuoption" value="download_cert">
          <input type="hidden" name="cert_name" value="<?PHP print 'zzTHISzzCAzz'; ?>">
          <input type="submit" value="Download CA Trusted Root Certificate">
        </form>
        <BR><BR>
        <?PHP
        print "<b>Your certificate:</b>\n<pre>$my_x509_scert</pre>\n";
        ?>
        <h1>Successfully signed certificate request with CA key.</h1>
      </fieldset>
    </div>
  </div>



</div>