<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php"><?PHP echo $my_title; ?></a>
            
            <ul class="nav navbar-nav">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?PHP echo $addclass;?>" data-toggle="dropdown" href="#">CSR Functions</a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?menuoption=createCSR_form" class="dropdown-item"><i class="fas fa-plus" style="color:greenyellow !important"></i> Create a CSR</a></li>
                        <li><a href="index.php?menuoption=import_CSR_form" class="dropdown-item"><i class="fas fa-file-import" style="color:goldenrod !important"></i> Import a CSR</a></li>
                        <li><a href="index.php?menuoption=upload_CSR_form" class="dropdown-item"><i class="fas fa-upload" style="color:blueviolet !important"></i> Upload a CSR</a></li>
                        <li><a href="index.php?menuoption=download_csr_form" class="dropdown-item"><i class="fas fa-download" style="color:cornflowerblue !important"></i> Download a CSR</a></li>
                        <li><a href="index.php?menuoption=view_csr_details_form" class="dropdown-item"><i class="fas fa-glasses" style="color:blue !important"></i> View a CSR's Details</a></li>
                        <li><a href="index.php?menuoption=sign_csr_form" class="dropdown-item"><i class="fas fa-sign" style="color:olive !important"></i> Sign a CSR</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle <?PHP echo $addclass;?>" data-toggle="dropdown" href="#">Certificate Functions</a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?menuoption=download_cert_form" class="dropdown-item"><i class="fas fa-download" style="color:blue !important"></i> Download a Cert/ PKCS#12</a></li>
                        <li><a href="index.php?menuoption=revoke_cert_form" class="dropdown-item"><i class="fas fa-hourglass-end"></i> Revoke a Certificate</a></li>
                        <li><a href="index.php?menuoption=convert_cert_pkcs12_form" class="dropdown-item"><i class="fas fa-recycle    " style="color:green !important"></i> Convert a Certificate to PKCS#12</a></li>
                        <li><a href="index.php?menuoption=view_cert_details_form" class="dropdown-item"><i class="fas fa-glasses    " style="color:blue !important"></i> View a Certificate's Details</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?PHP echo $addclass;?>" data-toggle="dropdown" href="#">Key Functions</a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?menuoption=get_public_ssh_key_form" class="dropdown-item"><i class="fas fa-key" style="color:green !important"></i> Get Public SSH Key</a></li>
                        <li><a href="index.php?menuoption=get_mod_private_form" class="dropdown-item"><i class="fas fa-key" style="color:goldenrod !important"></i> Get Private Key</a></li>
                        <li><a href="index.php?menuoption=check_key_passphrase_form" class="dropdown-item"><i class="fas fa-unlock" style="color:goldenrod !important"></i> Check a private key's passphrase</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle <?PHP echo $addclass;?>" data-toggle="dropdown" href="#">CA Functions</a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?menuoption=switchca_form" class="dropdown-item"><i class="fas fa-certificate    " style="color:green !important"></i> Switch to a different CA</a></li>
                        <li><a href="index.php?menuoption=download_crl_form" class="dropdown-item"><i class="fas fa-download    " style="color:red !important"></i> Download CRL</a></li>
                        <li><a href="index.php?menuoption=delete_ca_form" class="dropdown-item"><i class="fas fa-trash    " style="color:red !important"></i> Delete CA</a></li>
                    </ul>
                </li>

                <li class="nav-link <?PHP echo $addclass;?>"><a href="index.php?menuoption=show_summary"><i class="fas fa-link    "></i> Show Summary</a></li>

            </ul>
        </div>
    </nav>
    <script>
        $('#navId a').click(e => {
            e.preventDefault();
            $(this).tab('show');
        });
    </script>


<div id="mainContent" class="container-fluid">