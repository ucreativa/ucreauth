﻿<?php

   require_once( __CLS_PATH . "cls_database.php");

	class cls_Userservice { 
	
	   private $data_provide;
	 	 
	   public function __construct(){
			$this->data_provide=new cls_Database();	   
	   } 	
	 
	   public function get_users_services($usr_id){ 
	   
			$result=$this->data_provide->sql_execute("SELECT tbl_users_services.user_service_id,
																	tbl_users_services.user_fk,
																	tbl_users_services.service_fk,
																	tbl_users_services.user_service_username,
																	tbl_users_services.user_service_rol
																	FROM tbl_users_services
																	WHERE tbl_users_services.user_fk = " . $usr_id);
			                      		                          
			return $this->data_provide->sql_get_rows($result);
      }
      
      public function insert_user_service($userservicedata = array()){ 
      
	      $success=false; 
			$result=$this->data_provide->sql_execute("INSERT INTO tbl_users_services 
																  (user_fk,
																	service_fk,
																	user_service_username,
																	user_service_rol)
																	VALUES (" . $userservicedata[0] . "," . $userservicedata[1] . ",'" . $userservicedata[2] . "',
																	'" . $userservicedata[3] . "')");
			if($result){
				$success=true;
			}
			
			 return $success;
			                      		                          
      }
      
      public function update_usergroupdata($userservicedata = array(),$id_userserv){ 
	   
	      $success=false; 
			$result=$this->data_provide->sql_execute("UPDATE tbl_users SET
																	user_fk = '".$userservicedata[0]."',
																	service_fk = '".$userservicedata[1]."',
																	user_service_username = '".$userservicedata[2]."',
																	user_service_rol = '".$userservicedata[3]."'
																	WHERE tbl_users_services.user_service_id = " . $id_userserv);
			if($result){
				$success=true;
			}
			
	      return $success;
			                      		                          
      }     
  
      
	}

?>