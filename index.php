<?php
      require_once("global.php");
	   require_once( __CLS_PATH . "cls_html.php");
?>

<html>

  <head>
      <?php
          echo cls_HTML::html_js_header(__JS_PATH . "jquery-1.6.2.min.js");
          echo cls_HTML::html_js_header(__JS_PATH . "jquery-ui-1.8.6.custom.min.js");
          echo cls_HTML::html_js_header(__JS_PATH . "functions.js");
          echo cls_HTML::html_js_header(__JS_PATH . "jquery.betterTooltip.js");
          echo cls_HTML::html_css_header(__CSS_PATH . "style.css","screen");
          echo cls_HTML::html_css_header(__CSS_PATH . "tooltip/theme/style_tooltip.css","screen");
      ?>

    <title>UCREATIVA <? //echo $array_global_settings['sys_version'];?></title>
  </head>
   <?

     // Restricción para versiones de Internet Explorer 8 o inferior
     echo "<script type='text/javascript'>checkVersion();</script>"; 
   ?>
   
  <div id="inactive_base"></div>
  <body id="main_page">

		 <iframe id="mainframe" type="text/html" src="http://www.ucreativa.com/ucreasite" width="100%" height="97%"></iframe>  

   
  	<div id="cp_bar">
	    <?php

	       //Inicio la sesión
		    session_name("UCREAUTH");
		    session_start();
		    $_SESSION['LOGOUT']="NO";
		    	    
          //unset($_SESSION['AUTH']);
          if(isset($_SESSION['AUTH'])){
		       if($_SESSION['AUTH']!="YES"){
		       	include_once(__VWS_PATH . "/login.php"); 
		       }else{
		       	include_once(__VWS_PATH . "/access_cp.php");
		       }
		    }else{
            include_once(__VWS_PATH . "/login.php");    
		    }

		    echo "<script>$('#mainframe').attr('src','http://www.ucreativa.com/ucreasite')</script>";
	    ?>
   </div>
  
  </body>
</html>
