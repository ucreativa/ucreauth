<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
    require_once( __CLS_PATH . "cls_kerberos.php");

    try{    	 

    	 if(!(isset($_SESSION["USERNAME"]))){
    	 	cls_Message::show_message("","msg_box_user","expired_session");
    	 }
    	 
    	 $ccache_clone = new KRB5CCache();
       $dir_ccache='app_core/resources/temps/my.ccache_' . $_SESSION['USERNAME'];
    	  
	    if(file_exists($dir_ccache))
	    {
	        $ccache_clone->open($dir_ccache);
	        
	        /*if(!$ccache_clone->isValid()){
	          $_SESSION["AUTH"]="NO";
	        }*/

	    }else{
	    	$_SESSION["AUTH"]="NO";
	    }
	
		//Comprueba que el usuario esté autentificado
		if ($_SESSION["AUTH"] != "YES") {
			//además salgo de este script y borro el archivo ccache
	      if(file_exists($dir_ccache))
	      {
	          unlink($dir_ccache);
	          cls_Message::show_message("","msg_box_user","expired_session");
	      }
	   
         //Si no cerramos desde el la opción SALIR
         if($_SESSION['LOGOUT']!='YES'){
             //Mostramos mensaje de sesión expirada
            session_name("UCREAUTH");
	         session_destroy();
		      cls_Message::show_message("","msg_box_user","expired_session");
         }else{
         	session_name("UCREAUTH");
	         session_destroy();
            header('Location: index.php');
         }

	   }
   }catch(Exception $e){
      if(file_exists($dir_ccache))
      {
          unlink($dir_ccache);
      }
   
      session_name("UCREAUTH");
      session_destroy();
	  //si no existe, envio a la página de autentificación
	  cls_Message::show_message("","msg_box_user","expired_session");
   }

?>