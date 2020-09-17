<?PHP

/*
http://onehackoranother.com/projects/jquery/droppy/
http://archive.plugins.jquery.com/project/droppy
http://docs.jquery.com/UI/Dialog
http://stackoverflow.com/a/1328731/5738
*/




function printHeader($my_title='PHP CA Server',$SHOW_CA_NAME=TRUE) {
include("./include/header.php");
include("./include/menu.php");//this includes the body tag
if (($SHOW_CA_NAME==TRUE) and isset($_SESSION['my_ca']) ) print "<H2>".strtoupper($_SESSION['my_ca'])."</H2>\n";
}

function printFooter($SHOW_CA_NAME=TRUE) {
if ($SHOW_CA_NAME==TRUE) print "<H2>".strtoupper($_SESSION['my_ca'])."</H2>";
print "</div> <!-- end .mainContent -->\n";
print "</div><!-- /page -->\n";
print "</body>\n";
print "</html>\n";
}
?>
