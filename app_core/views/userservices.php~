<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
    require_once(__CLS_PATH . "cls_html.php");
    require_once(__CLS_PATH . "cls_searchbox.php");
    require(__CTR_PATH . "ctr_userservice.php");
    require(__CLS_PATH . "cls_service.php");
    	
	 //Declaramos el controlador de la vista actual el cual contiene las acciones a ejecutar
    $ctr_Userservice=new ctr_Userservice();
    $services=new cls_Service();
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
	 <title>UCREAUTH v1.0</title>
 </head>

  <body>
        <script>
            $(document).ready(function() {
            	basic_tooltip('.text');
            });
        </script>

	<div class="general_form_page">
		<div id="userpage">
		    <?php echo cls_HTML::html_form_tag("frm_userservices", "","","post"); ?>
		    <fieldset class="groupbox" id="gpb_services"> <legend>ASIGNAR SERVICIOS</legend>
			    <div class="block_form">
				    <?php echo cls_HTML::html_input_hidden("txt_id",""); ?>
				    <?php echo cls_HTML::html_label_tag("Usuario:"); ?>
				    <br /><br />
				    <?php echo cls_HTML::html_input_text("txt_username","txt_username","",32,"","","Nombre de Usuario",1,"","","required"); ?>
				    <br /><br /><br /><br />
				    <fieldset class="groupbox"> <legend>SERVICIOS</legend>
				      <div class="block_form" style="padding: 5px; overflow: scroll; height:200px;">
				      <? 
					      $row=$services->get_services();
					      $i=0;
					     // echo "<table>";
					     	
					      foreach($row as $value){				      	
					      	?>
					      	<table cellpadding="0" border="0">
					      	<tr>
						      <td><?php echo cls_HTML::html_check("chk_". $value[0], "check", "", $i+3, "", "");?></td>
						      <td width="140"><?php echo cls_HTML::html_label_tag($value[1]); ?></td>
						      <td><?php echo cls_HTML::html_input_text("txt_uservname_". $value[0],"txt_uservname_". $value[0],"text",32,"","","Nombre de Usuario",$i+4,"","placeholder='USERNAME'",""); ?></td>				      
						      </tr>
						      </table>
						      <br />
					   <? $i++;
					       
					      }
				      ?>
				      <?php echo cls_HTML::html_input_hidden("txt_totalservs",$i); ?>
				      </div>
				    </fieldset> 
				 </div>
			 </fieldset> 
	 		 <div id="action_buttons_form">
	 		    <?php echo cls_HTML::html_input_button("submit","btn_new","btn_new","button","Cancelar",11,"","onclick=\"$('#frm_userservices').attr('novalidate','novalidate');\""); ?>
			    <?php echo cls_HTML::html_input_button("submit","btn_save","btn_save","button","Guardar",12,"",""); ?>
			    <?php echo cls_HTML::html_input_button("submit","btn_search","btn_search","button","Buscar",13,"","onclick=\"$('#frm_userservices').attr('novalidate','novalidate');\""); ?>
			    <br /><br />
		    </div>
		    <?php echo cls_HTML::html_form_end(); ?>
		</div>
		
      <?php
	      //Eventos click de los botones de acción
	      
		   if(isset($_POST['btn_new'])){
		   	$ctr_Userservice->btn_new_click();
		   }
		    
		   if(isset($_POST['btn_save'])){
		   	$ctr_Userservice->btn_save_click();
		   }

		   if(isset($_POST['btn_search'])){
		   	 $search=new cls_Searchbox();
		       echo $search->show_searchbox(__VWS_HOST_PATH . "userservices.php", "Búsqueda de Usuarios", "&nbsp;&nbsp;Digite el nombre del usuario:", "userservices.php", "frm_user");
		   }
		   
		   /*Procedemos a llenar el formulario con los datos traídos del formulario
		    de búsqueda */

		  	if(isset($_GET['edit']) && isset($_GET['id'])){

		  		if($_GET['edit']=="1"){
		  			
		  			$userservice_data=$ctr_Userservice->get_userservicedata($_GET['id']);
		  			
		  			//Si el usuario no tiene servicios asignados solo obtenemos su id y nombre
		  			
		  			$id_user="";
		  			$name_user="";
		  			
					if(count($userservice_data[0])!=2){
			  			 foreach($userservice_data as $value){
			  			  	  echo "<script>
			  			         $('#chk_". $value[2] ."').attr('checked','cheked');
			  			         $('#txt_uservname_". $value[2] ."').attr('value','".$value[3]."');
			  			     </script>";
			  			 }
			  			 $id_user=$userservice_data[0][1];
			  			 $name_user=$userservice_data[0][5];
		  			}else{
		  				 $id_user=$userservice_data[0][0];
			  			 $name_user=$userservice_data[0][1];
		  			}

		  			echo "<script>
		  			         $('#txt_id').attr('value','" . $id_user . "');
		  			         $('#txt_username').attr('value','      " . $name_user . "');
								$('#btn_save').css('background','#4185F3');
								$('#txt_username').css('border','none');
								$('#txt_username').css('font-weight','bold');
								$('#txt_username').css('font-size','16px');
								$('#txt_username').css('background','no-repeat left url(" . __RSC_PHO_HOST_PATH . "thumbs/default.png)');
		  			     </script>";
		  		}
		  		
		   }else{
		  	   echo "<script>
		  	           $('#txt_id').attr('value','_NEW'); 
		  	           $('#gpb_services').attr('disabled','disabled'); 
		  	           $('#btn_save').attr('disabled','disabled'); 
		  	           $('#btn_save').css('background','#AAA');  
		  	         </script>";
		   }
     ?>
    
	</div>
  </body>
 </html>
