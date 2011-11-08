<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
    require_once(__CLS_PATH . "cls_html.php");
    require(__CTR_PATH . "ctr_login.php");
    
    //Declaramos el controlador de la vista actual el cual contiene las acciones a ejecutar
    $ctr_Login=new ctr_Login();
?>
   <script type="text/javascript">$(document).ready(function(){$('#login').slideUp(0);});</script>
<<<<<<< HEAD
   <div class="menu_item" id="login_item" onclick="show_close_menu('login');"><p class="text_cpbar">Iniciar Sesión</p></div>
=======
   <div class="menu_item" id="login_item" onclick="show_close_menu('login');"><p class="text_cpbar">Iniciar Sesión</p></div>

   <? //cls_Message::show_message("Servicio de autenticación suspendido temporalmente.","info",""); ?>
        
>>>>>>> cbfa9a613a68f475aebbe0b2cd70a1d77a981008
	<div id="login">
	
	    <?php echo cls_HTML::html_form_tag("frm_login", "" ,"","post");	 ?>
	    <!-- <?php echo cls_HTML::html_label_tag("USUARIO:"); ?> -->
	    <?php echo cls_HTML::html_input_text("txt_user","txt_user","text txt_login",64,"","","Nombre de Usuario",1,"","placeholder='USUARIO'","required"); ?>
	    <br /><br />
	    <!-- <?php echo cls_HTML::html_label_tag("PASSWORD:"); ?> -->
	    <?php echo cls_HTML::html_input_password("txt_pssw","txt_pssw","text txt_login",64,"","Contraseña del Usuario",2,"","placeholder='PASSWORD'","required"); ?>
	    <br /><br />
	    <?php echo cls_HTML::html_input_button("submit","btn_login","btn_login","button","Ingresar",3,"",""); ?>
	    <br /><br />
	    <?php echo cls_HTML::html_form_end(); ?>
	    
<!-- 	    <div class="separator"></div>
	    
	    <div id="sub_login">
			<?php
		        //Parámetros del: html_link_tag($text, $id, $class, $href, $target, $title, $event)
			     //echo cls_HTML::html_link_tag("¿Olvidaste tu contraseña?", "btn_forgot", "link", "#", "_self", "¿Olvidaste tu contraseña?","");
			     //echo cls_HTML::html_link_tag("Registrarse", "btn_register", "link", "#", "_self", "Registrarse","");
			?>
      </div> -->
	</div>


 <?php
      //Eventos click de los botones de acción
      
	   if(isset($_POST['btn_login'])){
	   	$ctr_Login->btn_login_click();
	   }
 ?>


