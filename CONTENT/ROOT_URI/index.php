<?php //var_dump($url);echo "<br>FD=",F_D,"<br>lnk=",$lnk,"<br>"; //phpinfo();

$lnk2 = explode('?', $lnk);
 if($lnk==""){
   	include("_header.php");
   	 include("_home.php");
   	 include("_footer.php");

   } 
   elseif(file_exists(__DIR__."/".$lnk.".php")){
   	include("_header.php");
   	 include($lnk.".php");
   	 include("_footer.php");

   }  
   elseif(isset($lnk2[1]) && file_exists(__DIR__."/".$lnk2[0].".php") ){
   	include("_header.php");
   	  include($lnk2[0].".php");
   	  include("_footer.php");

   } 
   else{
   	include("_header.php");
     include("_404.php");
     include("_footer.php");

   } 

?>
