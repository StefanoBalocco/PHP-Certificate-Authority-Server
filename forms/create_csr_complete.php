<table style='border:1px solid black; width:600px'>
    <tr>
        <th>Common Name (eg www.golf.local)</th>
        <td><?PHP print $my_details['CN']; ?></td>
    </tr>
    <tr>
        <th>Contact Email Address</th>
        <td><?PHP print $my_details['emailAddress']; ?></td>
    </tr>
    <tr>
        <th>Organizational Unit Name</th>
        <td><?PHP print $my_details['OU']; ?></td>
    </tr>
    <tr>
        <th>Organization Name</th>
        <td><?PHP print $my_details['O']; ?></td>
    </tr>
    <tr>
        <th>City</th>
        <td><?PHP print $my_details['L']; ?></td>
    </tr>
    <tr>
        <th>State</th>
        <td><?PHP print $my_details['ST']; ?></td>
    </tr>
    <tr>
        <th>Country</th>
        <td><?PHP print $my_details['C']; ?></td>
    </tr>
    <tr>
        <th>Key Size</th>
        <td><?PHP print $my_public_key_details['bits']; ?></td>
    </tr>

</table>