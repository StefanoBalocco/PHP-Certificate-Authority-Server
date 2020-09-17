<div class="container-fluid">
    <fieldset>

        <legend><b>Create a new Root Certificate Authority</b></legend>
        <form action="index.php" method="post" class="formDiv">
            <input type="hidden" name="create_ca" value="create_ca" />
            <input type="hidden" name="menuoption" value="create_ca" />
            <input type="hidden" name="device_type" value="ca_cert" />
            <div style=" width:600px !important;">
              <label for="cert_dn[commonName]">Common Name</label>
              <input type="text" class="form-control" name="cert_dn[commonName]" id="cn" aria-describedby="helpIdCN" placeholder="root.example.com">
              <small id="helpIdCN" class="form-text text-muted">(eg root-ca.golf.local)</small>
                <br>
              <label for="cert_dn[commonName]">Contact Email Address</label>
              <input type="text" class="form-control" name="cert_dn[emailAddress]" id="email" aria-describedby="helpIdE" placeholder="cert@example.com">
              <small id="helpE" class="form-text text-muted">contact email address</small>
              <br>
              <label for="cert_dn[organizationalUnitName]">Organizational Unit Name</label>
              <input type="text" class="form-control" name="cert_dn[organizationalUnitName]" id="OU" aria-describedby="helpIdUO" placeholder="root-ca.example.com">
              <small id="helpOU" class="form-text text-muted">root-ca.example.com</small>
                <br>
              <label for="cert_dn[organizationName]">Organization Name</label>
              <input type="text" class="form-control" name="cert_dn[organizationName]" id="OU" aria-describedby="helpIdON" placeholder="Example.com Device Authority">
              <small id="helpON" class="form-text text-muted">Example.com Device Authority</small>
              <br>
              <label for="cert_dn[localityName]">City or Locality</label>
              <input type="text" class="form-control" name="cert_dn[localityName]" id="locality" aria-describedby="helpIdlocality" placeholder="New Orleans">
              <small id="helplocality" class="form-text text-muted">City (Full Name)</small>
              <div class="container">
                  <div class="row">
                      <div class="col-sm-2">
                        <label for="cert_dn[stateOrProvinceName]">State or Province</label>
                        <input type="text" name="cert_dn[stateOrProvinceName]" id="state" style="width:50px;" aria-describedby="helpIdstate" placeholder="LA">
                        <!-- <br> -->
                        <!-- <small id="helpstate" class=" text-muted">State or Province (two letter abbreviation)</small> -->
                      </div>
                      <div class="col-sm-1">
                        <label for="cert_dn[countryName]">Country</label>
                        <!-- <br> -->
                        <input type="text" name="cert_dn[countryName]" id="country" style="width:50px;" aria-describedby="helpcountry" placeholder="US">
                        <!-- <br> -->
                        <!-- <small id="helpcountry" class="text-muted">Country (two letter abbreviation)</small> -->
                      </div>
                      <div class="col-sm-2">
                        <label for="cert_dn[keySize]">Key Size</label><br>
                        <select name="cert_dn[keySize]">
                            <option value='2048'>2048bits</option>
                            <option value='4096' selected>4096bits</option>
                        </select>
                        
                      </div>
                      <div class="col-sm-2">
                          <label for="days">Number of Days</label>
                          <input type="text" name="cert_dn[days]" size="4" value="7300" />
                      </div>
                  </div>
              
              </div>
              <label for="passphrase">Passphrase</label>
              <input type="password" name="passphrase" class="form-control">
              <br>
              <input type="submit" value="Create Root CA" class="form-control button-green">
              
  
            </div>
    
        </form>
    </fieldset>
</div>