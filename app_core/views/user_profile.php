﻿<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
    require_once(__CLS_PATH . "cls_html.php");
    require_once(__CLS_PATH . "cls_searchbox.php");
?>

<html>
 <head>
	   <?php
	       echo cls_HTML::html_js_header(__JS_PATH . "jquery-1.6.2.min.js");
	       echo cls_HTML::html_js_header(__JS_PATH . "jquery-ui-1.8.6.custom.min.js");
	       echo cls_HTML::html_js_header(__JS_PATH . "functions.js");
	       echo cls_HTML::html_js_header(__JS_PATH . "dateselect/dateSelectBoxes.js");
          echo cls_HTML::html_css_header(__CSS_PATH . "style.css","screen");
	      
	   ?>
	 <title>UCREAUTH v1.0</title>
 </head>

  <body>

<?php

    require(__CTR_PATH . "ctr_user.php");

	 //Declaramos el controlador de la vista actual el cual contiene las acciones a ejecutar
    $ctr_User=new ctr_User();
?>
        <script>
            $(document).ready(function() {
               $().dateSelectBoxes($('#cmb_month'),$('#cmb_day'),$('#cmb_year'));
					disable_edit($('#chk_editprofile'));
            });

            function show_pssw_box(element){
	         	if($('#'+element.id).attr('checked')=="checked"){
	         	  $('#txt_chpassw').attr('value','KRB5_CHPSSW');
	         	  $('#password_box').css('display','block');
	         	  $('#txt_pssw').attr('required','required');
	         	}else{
	         	  $('#txt_chpassw').attr('value','');
	         	  $('#password_box').css('display','none');
	         	  $('#txt_pssw').removeAttr('required');
	         	}
            }
            
             function enable_edit(element){
	         	if($('#'+element.id).attr('checked')=="checked"){
	               $('.text').css('border','');
	               $('#txt_user').css('border','none');
	 					$('.textarea').css('border','');
	 					$('.combo').css('border','');
	 					$('.text').removeAttr('readonly');
	 					$('.textarea').removeAttr('readonly');
	 					$('#txt_user').attr('readonly','readonly');
						$('.combo').removeAttr('disabled');
						$('.combo').css('background','');
						$('.combo').css('color','');
						$('#btn_save').css('display','block');
						$('#opt_chpassword').css('display','block');
	         	  }else{
	         	  	disable_edit(element);
	         	  }
             }
             
            function disable_edit(element){
	         	if($('#'+element.id).attr('checked')!="checked"){
	         		show_pssw_box($('#chk_password'));
	         		$('#chk_password').removeAttr('checked','');
	               $('.text').css('border','none');
	 					$('.textarea').css('border','none');
	 					$('.text').attr('readonly','readonly');
	 					$('.textarea').attr('readonly','readonly');
	 					$('.combo').css('border','none');
						$('.combo').attr('disabled','disabled');
						$('.combo').css('background','#fff');
						$('.combo').css('color','#000');
						$('#btn_save').css('display','none');
						$('#opt_chpassword').css('display','none');
	         	  }
             }
             
        </script>

	<div class="general_form_page">
		<div id="userpage">
		    <?php echo cls_HTML::html_form_tag("frm_user", "","","post"); ?>
		    <div id="sub_options">
		    <div id="chpssw_option">
		    <?php echo cls_HTML::html_check("chk_editprofile", "check", "", 1, "", "onclick='enable_edit(this);'"); ?>
		    <?php echo cls_HTML::html_label_tag("Habilitar Edición"); ?>
		    &nbsp;&nbsp;&nbsp;
		    <span id="opt_chpassword" style="float:right;">
		    <?php echo cls_HTML::html_check("chk_password", "check", "", 2, "", "onclick='show_pssw_box(this);'"); ?>
			 <?php echo cls_HTML::html_label_tag("Habilitar cambio de contraseña"); ?>
			 </span>
			 </div>
			 </div>
			 <br /><br />
		    <fieldset id="gpb_profile" class="groupbox"> <legend>MI PERFIL</legend>
			    <div class="block_form">
				    <?php echo cls_HTML::html_input_hidden("txt_id",""); ?>
				    <?php echo cls_HTML::html_input_hidden("txt_chpassw",""); ?>
				    <?php echo cls_HTML::html_input_text("txt_user","txt_user","text",64,"","","Nombre de Usuario",1,"","","required"); ?>
				    <br /><br />
				    <div id="password_box">
				    <?php echo cls_HTML::html_label_tag("Password:"); ?>
				    <br />
				    <?php echo cls_HTML::html_input_password("txt_pssw","txt_pssw","text",64,"","Contraseña",2,"","","required"); ?>
				    <br /><br />
				    <?php echo cls_HTML::html_label_tag("Confirme el Password:"); ?>
				    <br />
				    <?php echo cls_HTML::html_input_password("txt_pssw","txt_cpssw","text",64,"","Contraseña",3,"","",""); ?>
				    </div>
				    <br />
				    <?php echo cls_HTML::html_label_tag("Nombre Completo:"); ?>
				    <br />
				    <?php echo cls_HTML::html_input_text("txt_realname","txt_realname","text",128,"","","Nombre Real",4,"","","required"); ?>
				    <br /><br />
				    <?php echo cls_HTML::html_label_tag("Cédula:"); ?>
				    <br />
		          <?php echo cls_HTML::html_input_text("txt_ident","txt_ident","text",9,"","","Cédula",5,"","onkeypress='return validarOnlyNum(event);'","required"); ?>
				    <br /><br />
				    <?php echo cls_HTML::html_label_tag("Fecha de Nacimiento:"); ?>
				    <br />
		          <?php echo cls_HTML::html_select_date("combo", 6, "", ""); ?>
		          <br /><br />
				 </div>
			    <div class="block_form">
				    <?php echo cls_HTML::html_label_tag("Teléfono:"); ?>
				    <br />
		          <?php echo cls_HTML::html_input_text("txt_phone","txt_phone","text",8,"","","Teléfono",9,"","onkeypress='return validarOnlyNum(event);'",""); ?>
				    <br /><br />
				    <?php echo cls_HTML::html_label_tag("Género:"); ?>
				    <br />
		          <?php echo cls_HTML::html_select("cmb_gender", array('M'=>'Masculino', 'F'=>'Femenino'), "cmb_gender", "combo", 11, "", ""); ?>
		          <br /><br />
		          <?php echo cls_HTML::html_label_tag("E-mail (Sólo para envío de contraseña):"); ?>
				    <br />
		          <?php echo cls_HTML::html_input_email("txt_email", "txt_email", "text", "E-mail alternativo (Sólo para envío de contraseña)", 128,"",12, "", "","required"); ?>
		          <br /><br />
				 	 <?php echo cls_HTML::html_label_tag("Descripción breve:"); ?>
				    <br />
				    <?php echo cls_HTML::html_textarea(7,30,"txt_info","txt_info","textarea","",13,"","",""); ?>
				 </div>
			 </fieldset>
	 		 <div id="action_buttons_form">
			    <?php echo cls_HTML::html_input_button("submit","btn_save","btn_save","button","Guardar",12,"","onclick=\"if($('#password_box').css('display')!='none'){return validate_pssw();}\""); ?>
		    </div>
		    <?php echo cls_HTML::html_form_end(); ?>
		</div>

      <?php
	      //Eventos click de los botones de acción

		   if(isset($_POST['btn_save'])){
		   	$ctr_User->btn_saveprofile_click();
		   }


		   /*Procedemos a llenar el formulario con los datos traídos del formulario
		    de búsqueda */

		  	if(isset($_GET['edit']) && isset($_GET['id'])){

		  		if($_GET['edit']=="1"){
		  			$user_data=$ctr_User->get_userdata($_GET['id']);
		  			echo "<script>
		  			         $('#txt_user').attr('readonly','readonly');
		  			         $('#txt_id').attr('value','" . $user_data[0][0] . "');
		  			         $('#txt_user').attr('value','      " . $user_data[0][2] . "');
		  			         $('#txt_ident').attr('value','" . $user_data[0][3] . "');
		  			         $('#txt_email').attr('value','" . $user_data[0][4] . "');
		  			         $('#txt_phone').attr('value','" . $user_data[0][5] . "');
		  			         $('#img_userphoto').attr('value','" . $user_data[0][6] . "');
		  			         $('#cmb_gender').attr('value','" . $user_data[0][7] . "');
		  			         $('#cmb_day').attr('value','" . substr($user_data[0][8], 8, 2) . "');
		  			         $('#cmb_month').attr('value','" . substr($user_data[0][8], 5, 2) . "');
		  			         $('#cmb_year').attr('value','" . substr($user_data[0][8], 0, 4)  . "');
		  			         $('#cmb_status').attr('value','" . $user_data[0][9] . "');
		  			         $('#txt_info').attr('value','" . $user_data[0][11] . "');
		  			         $('#txt_realname').attr('value','" . $user_data[0][13] . "');

		  			         $('#password_box').css('display','none');
		  			         $('#password_box').css('padding','5px');
		  			         $('#password_box').css('background','#CCC');
			  	            $('#chpssw_option').css('display','block');
			  	            $('#txt_pssw').removeAttr('required');
		  			      </script>";
		  			      
		  			     echo "<script>
									//$('#btn_save').css('background','#4185F3');
									$('#txt_user').css('border','none');
									$('#txt_user').css('font-weight','bold');
									$('#txt_user').css('font-size','16px');
									$('#gpb_profile').css('background','no-repeat left url(" . __RSC_PHO_HOST_PATH . "/default.png)');
									$('#gpb_profile').css('background-position','top right');
									$('#txt_user').css('background','no-repeat left url(" . __RSC_PHO_HOST_PATH . "thumbs/default.png)');
		  			         </script>";
		  		}

		   }else{
		  	   echo "<script>
		  	           $('#txt_id').attr('value','_NEW');
		  	           $('#password_box').css('display','block');
		  	           $('#chpssw_option').css('display','none');
		  	         </script>";
		   }

     ?>

	</div>
  </body>
 </html>
