<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$openssl_conf_array = parse_ini_file("include/openssl.conf", true);

print("<pre>");
$san_list[0]="*.example.com";
$san_list[1]="text.example.com";
foreach($openssl_conf_array as $key => $val){
    if($key == " v3_req "){
        //if sub alt names then add line
        print("[$key]" . "\n");
        if(strlen($san_list[0]) >= 3){
            foreach($val as $key2 => $val2){
                print($key2 . " = " . $val2 . "\n");
            }
            print("subjectAltName = @subject_alt_names");
            print("\n");

            print("\n\n[subject_alt_names]\n");
            $san_list_formated = "";
            for($i=0; $i<count($san_list); $i++){
                $index = $i + 1;
                $san_list_formated .= 'DNS.' . $index . " = " . $san_list[$i] . "\n";
                
              }
            print($san_list_formated);
        } else {
            foreach($val as $key2 => $val2){
                print($key2 . " = " . $val2 . "\n");
            }
            print("\n");
        }
        
        
    } else {
        print("[$key]" . "\n");
        foreach($val as $key2 => $val2){
            print($key2 . " = " . $val2 . "\n");
        }
    }
    
    print("\n");
}
print("</pre>");


?>