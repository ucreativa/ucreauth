<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
    require_once(__CLS_PATH . "cls_html.php");
?>

<html>
 <head>
	   <?php
	       echo cls_HTML::html_js_header(__JS_PATH . "jquery-1.6.2.min.js");
	       echo cls_HTML::html_js_header(__JS_PATH . "jquery-ui-1.8.6.custom.min.js");
	       echo cls_HTML::html_js_header(__JS_PATH . "functions.js");
	       echo cls_HTML::html_js_header(__JS_PATH . "basic_tooltip.js");
          echo cls_HTML::html_css_header(__CSS_PATH . "style.css","screen");
	   ?>
	 <title></title>
 </head>

  <body>

<?php
    require(__CTR_PATH . "ctr_user.php");

	 //Declaramos el controlador de la vista actual el cual contiene las acciones a ejecutar
    $user_adm=new ctr_User();
?>
        <script>   
            $(document).ready(function() {
					basic_tooltip('.sbox');
            });  
        </script>

	<div class="general_form_page">
		<div id="userpage">
		    <?php echo cls_HTML::html_form_tag("frm_fgpssw", "","","post"); ?>
		    <fieldset class="groupbox"> <legend>RECORDATORIO DE CONTRASEÑA</legend>
			    <div class="block_form">
				    <?php echo cls_HTML::html_label_tag("E-mail alternativo asociado a la cuenta:"); ?>
				    <br /><br />
				    <span class="sbox" title="Una nueva contraseña será enviada al correo especificado.">
				    	<?php echo cls_HTML::html_input_email("txt_email", "txt_email", "text", "", 64,"",1, "", "","required"); ?>
				    </span>
				    <br /><br />
				 </div>
			 </fieldset>
	 		 <div id="action_buttons_form">
			    <?php echo cls_HTML::html_input_button("submit","btn_send","btn_send","button","Enviar contraseña",4,"",""); ?>
			    <br /><br />
		    </div>
		    <?php echo cls_HTML::html_form_end(); ?>
		</div>

      <?php
	      //Eventos click de los botones de acción

		   if(isset($_POST['btn_send'])){
		   	$row=$user_adm->get_userdata_by_email(trim($_POST['txt_email']));
		   	
		   	if($row[0][1]==""){
		   		cls_Message::show_message("E-mail no registrado!","warning","");
		   	}else{
		   	   $new_pssw=password_shuffle(8);		   	
			   	if($user_adm->update_chpssw($row[0][1],$new_pssw,$row[0][2],"1")==true){
			   		$message=cls_Message::show_message("Contraseña enviada!","success","");
			   		echo "<script>parent.location.href='http://www.ucreativa.com';</script>"; 
			   	}   
		   	}

		   }
		   
     ?>
     
	</div>
  </body>
 </html>
