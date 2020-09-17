    <nav class="navbar">
    <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"><?PHP echo $my_title;?></a>
    </div>
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">CSR Functions</a>
            <ul class="dropdown-menu">
                <li><a href="index.php?menuoption=createCSR_form">Create a CSR</a></li>
                <li><a href="index.php?menuoption=import_CSR_form">Import a CSR</a></li>
                <li><a href="index.php?menuoption=upload_CSR_form">Upload a CSR</a></li>
                <li><a href="index.php?menuoption=download_csr_form">Download a CSR</a></li>
                <li><a href="index.php?menuoption=view_csr_details_form">View a CSR's Details</a></li>
                <li><a href="index.php?menuoption=sign_csr_form">Sign a CSR</a></li>
            </ul>
        </li>
  
   
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Certificate Functions</a>
            <ul class="dropdown-menu">
            <li><a href="index.php?menuoption=download_cert_form">Download a Cert/ PKCS#12</a></li>
            <li><a href="index.php?menuoption=revoke_cert_form">Revoke a Certificate</a></li>
            <li><a href="index.php?menuoption=convert_cert_pkcs12_form">Convert a Certificate to PKCS#12</a></li>
            <li><a href="index.php?menuoption=view_cert_details_form">View a Certificate's Details</a></li>
            </ul>
        </li>
    
  
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Key Functions</a>
            <ul class="dropdown-menu">
            <li><a href="index.php?menuoption=get_public_ssh_key_form">Get Public SSH Key</a></li>
            <li><a href="index.php?menuoption=get_mod_private_form">Get Private Key</a></li>
            <li><a href="index.php?menuoption=check_key_passphrase_form">Check a private key's passphrase</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">CA Functions</a>
            <ul class="dropdown-menu">
            <li><a href="index.php?menuoption=switchca_form">Switch to a different CA</a></li>
            <li><a href="index.php?menuoption=download_crl_form">Download CRL</a></li>
            <li><a href="index.php?menuoption=delete_ca_form">Delete CA</a></li>
            </ul>
        </li>
        <li class="navitem"><a href="index.php?menuoption=show_summary">Show Summary</a></li>
    </ul>
    </div>
    </nav>
    <script>
        $('#navId a').click(e => {
            e.preventDefault();
            $(this).tab('show');
        });
    </script>


    <div id=mainContent>