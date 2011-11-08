﻿<?php

   require_once( __CLS_PATH . "cls_database.php");

	class cls_Usergroup { 
	
	   private $data_provide;
	 	 
	   public function __construct(){
			$this->data_provide=new cls_Database();	   
	   } 	
	 
	   public function get_users_groups(){ 
	   
			$result=$this->data_provide->sql_execute("SELECT tbl_users_groups.user_group_id,
																	tbl_users_groups.user_group_name,
																	tbl_users_groups.user_group_acces
																	FROM tbl_users_groups");
			                      		                          
			return $this->data_provide->sql_get_rows($result);
      }  
      
	}

?>