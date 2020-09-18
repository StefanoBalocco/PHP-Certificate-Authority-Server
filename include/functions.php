<?PHP
//home for generic functions

//use this when we can't use the PHP header
function javaJump($url){
    print("<script>\n");
    print("window.location='" . $url . "'");
    print("</script>");
  }

//this is just printing rawdata during dev
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
    }// else {
    //   print("<pre>");
    //   print($payload);
    //   print("</pre>");
    // }
    
  }

  function printHeader($my_title='PHP CA Server',$SHOW_CA_NAME=FALSE) {
    include("./include/header.php");
    
    if (($SHOW_CA_NAME==TRUE) and isset($_SESSION['my_ca']) ) print "<H2>".strtoupper($_SESSION['my_ca'])."</H2>\n";
    }
  
  function printMenu($status){
    global $my_title;
    //if no ca selected menu is globally disabled
    if($status == true){
      $addclass="disabled";
    } else {
      $addclass="";
    }
    
    include("./include/menu.php");//this includes the body tag
  }

  function printFooter($SHOW_CA_NAME=FALSE) {
      global $my_title;
      include("./include/footer.php");
     
      }
  ?>