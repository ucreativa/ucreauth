﻿<?php

   require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
   require_once( __CLS_PATH . "cls_database.php");
   require_once( __CLS_PATH . "cls_html.php");

	class cls_Searchbox { 
	
	   private $data_provide;
	 	 
	   public function __construct(){
			$this->data_provide=new cls_Database();	   
	   } 	

	   public function show_data($form, $param){ 
	   
	      if ($form=="frm_user"){
					$result=$this->data_provide->sql_execute("SELECT tbl_users.user_id,
					                                        tbl_users.user_photo,  
	        														    tbl_users.user_krb_name,
	        															 tbl_users.user_email,
	        															 tbl_users.user_ident,
	        															 tbl_users.user_type,
	        															 tbl_users.user_group_fk
	        															 FROM tbl_users
	        															 WHERE tbl_users.user_krb_name LIKE '" . $param . "%'
	        															 ORDER BY tbl_users.user_krb_name ASC");

					return $this->data_provide->sql_get_rows($result);
			}
			
			if ($form=="frm_usergroup"){
					$result=$this->data_provide->sql_execute("SELECT tbl_users_groups.user_group_id,
																			tbl_users_groups.user_group_name,
																			tbl_users_groups.user_group_access
																			FROM tbl_users_groups
	        															   WHERE tbl_users_groups.user_group_name LIKE '" . $param . "%'");

					return $this->data_provide->sql_get_rows($result);
			}
      }  
      
      function show_searchbox($path_form, $title_form, $label_search, $ref_page, $form_name){
      	$frame="<iframe id='search_content' src='" . __VWS_HOST_PATH . "searchbox.php?path_form=" . $path_form . "&title_form=" . $title_form . "&label_search=" . $label_search . "&form=" . $form_name .  "' width='670' height='365' style='border: 0px;  margin-bottom: 50px;' frameborder='0'></iframe>";
      	$search_form="<div id='search_box' title='Búsqueda de Datos'>" . $frame . "</div><div id='inactive_base' style='display:block;'></div>";
      	return $search_form;
      }      
	}

?>