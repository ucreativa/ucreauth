<?php    
    require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
    require_once(__CLS_PATH . "cls_html.php");
    
    session_name("UCREAUTH");
    session_start();
    
    if (!(isset($_SESSION['USERNAME']))){
    	header("Location: index.php");
    }
?>

<html>

  <head>
      <?php
          echo cls_HTML::html_js_header(__JS_PATH . "jquery-1.6.2.min.js");
          echo cls_HTML::html_js_header(__JS_PATH . "jquery-ui-1.8.6.custom.min.js");
          echo cls_HTML::html_js_header(__JS_PATH . "jquery.betterTooltip.js");
          echo cls_HTML::html_js_header(__JS_PATH . "functions.js");
          echo cls_HTML::html_css_header(__CSS_PATH . "style.css","screen");
          echo cls_HTML::html_css_header(__CSS_PATH . "tooltip/theme/style_tooltip.css","screen");
      ?>
    <title>UCREAUTH <? echo $array_global_settings['sys_version'];?></title>
  </head>

  <body id="cp_page">

        <script> 
               $(document).ready(function(){$("#form_base").draggable();});
        </script>
        
      <div id="app_info">
      <span><? echo cls_HTML::html_img_tag(__IMG_PATH . "hand.png", "img_app", "img_app", "UC-CMS", "") 
                    . $array_global_settings['sys_name'] . " " . $array_global_settings['sys_version']; ?> - SISTEMA DE ADMINISTRACIÓN DE USUARIOS - KRB5</span>
            <? echo "<br/><span>Bienvenid@ <b>" . $_SESSION['USERNAME'] . "</b></span>"; ?>
      </div>

		<div id="control_panel">
			 <div id="cp_icons_panel">
			     <?php echo cls_HTML::html_img_link(__IMG_PATH . "usuarios.png" , "#", "" ,"Usuarios", "icon_1", "cp_icons", "new_user","", "onclick=\"open_form('users.php',825,420);\""); ?>
			     <?php echo cls_HTML::html_img_link(__IMG_PATH . "usr_servicios.png" , "#", "" ,"Asignar Servicios", "icon_2", "cp_icons", "usr_serv","", "onclick=\"open_form('userservices.php',660,460);\""); ?>
			     <?php //echo cls_HTML::html_img_link(__IMG_PATH . "grupos.png" , "#", "" ,"Grupos", "icon_2", "cp_icons", "new_group","", "onclick=\"open_form('usersgroups.php',700,380);\""); ?>
		    </div>
      </div>

     <div id="form_base">
       <?php echo cls_HTML::html_img_link(__IMG_PATH . "close.png" , "#", "_self" ,"Cerrar", "button_close", "button_action", "cerrar", "", "onclick=\"close_form();\""); ?>
       <iframe id="form_container" src=""></iframe>
     </div>
	     
    <div id="inactive_base"></div>
   
  </body>
</html>

