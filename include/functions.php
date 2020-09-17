<?PHP
//home for generic functions
function javaJump($url){
    print("<script>\n");
    print("window.location='" . $url . "'");
    print("</script>");
  }

function p($payload,$type=""){
    if($type=="a"){
      print("<pre>");
      print_r($payload);
      print("</pre>");
    } 
    if($type=="c"){
      print("<textarea cols=100 rows=20>");
      print($payload);
      print("</textarea><br>");
    } else {
      print("<pre>");
      print($payload);
      print("</pre>");
    }
    
  }
  ?>