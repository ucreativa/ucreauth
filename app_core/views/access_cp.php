<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/security.php");
    //require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/lock.php");
    require_once(__CLS_PATH . "cls_html.php");
    require_once(__CLS_PATH . "cls_kerberos.php");
    require_once(__CLS_PATH . "cls_user.php");
    require_once(__CTR_PATH . "ctr_login.php");
    require_once(__CLS_PATH . "cls_service.php");
    require_once(__CLS_PATH . "cls_gmatom.php");

    //Declaramos el controlador de la vista actual el cual contiene las acciones a ejecutar
    $ctr_Login=new ctr_Login();
    $GMatom=new cls_GmAtom();
    $GMatom->GmAtom($_SESSION['USERNAME'] . $array_global_settings['realm_server'], "solodios");
?>

﻿ <?php
      //Eventos click de los botones de acción

	   if(isset($_POST['btn_logout'])){
	     $ctr_Login->btn_logout_click();
	     $_SESSION['AUTH']="NO";
         $_SESSION['LOGOUT']="YES";
        include($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/security.php");
	   }
 ?>

      <script type="text/javascript"> 
	      $(document).ready(function() {$("#form_base").draggable();});
	      $(document).ready(function(){$('#login').slideUp(0);});
      </script>
		<div id="access_panel">
			 <?php
			 
		        $userdata=new cls_User();
		   	  $row=$userdata->get_userdata($_SESSION['USERNAME'],"-1");
              $usr_data=$row;
    			  echo "<div class='menu_item' id='user_item' onclick=\"show_close_menu('login');\">" 
    			  . cls_HTML::html_img_tag(__RSC_PHO_HOST_PATH . "thumbs/" . $row[0][6] , "tn_img_user", "img_link" ,$row[0][13], "width=20") 
    			  . "<p class='text_cpbar'>" . $row[0][13] . "</p></div>";

				  echo "<div id='login'>";
	              echo cls_HTML::html_form_tag("frm_logout", "" ,"","post");
	              //echo cls_HTML::html_input_button("button","btn_profile","btn_profile","subitem button","Mi perfil",0,"","");
	              //echo cls_HTML::html_input_button("button","btn_service","btn_profile","subitem button","Solicitar servicio",0,"","");
	  		        echo cls_HTML::html_input_button("submit","btn_logout","btn_logout","subitem button","Salir",0,"","");
	  			     echo cls_HTML::html_form_end();
	  			  echo "</div>";
		     ?>
			 <div id="services_icons">
				 <?php
				     //Obtenemos los servicios habilitados para el usuario
				 	  $services=new cls_Service();
   			     $row=$services->get_services_by_username($row[0][2]);

				      if($row){
						  foreach($row as $value){
						  	  //Parámetros de: html_img_tag($src, $id, $class, $alt, $size)
						  	  $external_link="onclick=\"$('#mainframe').attr('src','".$value[4]."?username=".$value[7]."');\"";
						  	  $GMcount="";
						  	  //Si el servicio es de correo entonces lo abrimos en una ventana nueva
						  	  if($value[1]=='correo'){
						  	    $external_link="onclick=\"window.open('".$value[4]."','');\"";
						  	    $GMcount="<span id='gmalert'>" . $GMatom->check() . "</span>";
						  	  }
						  	  
						  	    echo "<div title='".$value[3]."'" . $external_link . " >" 
						  	          . cls_HTML::html_img_tag(__RSC_IMG_HOST_PATH . $value[2], $value[1], "img_link" ,$value[1], "") . $GMcount . "</div>";
						  }
					   }
				 ?>
			 </div>
     </div>
     <div style="position:relative; top:300px;">
	     <div id="form_base">
		       <?php echo cls_HTML::html_img_link(__IMG_PATH . "close.png" , "", "_self" ,"Cerrar", "button_close", "button_action", "cerrar", "", "onclick=\"close_form();\""); ?>
		       <iframe id="form_container" src=""></iframe>
	     </div>
     </div>
     
     <?
       //Si requiere cambio de contraseña mostramos el formulario correspondiente
       if($usr_data[0][15]=='1'){
         echo "<script type='text/javascript'>open_form('".__VWS_HOST_PATH."change_pssw.php?usr=".$_SESSION['USERNAME']."',310,210);</script>";  
       }     
     ?>
