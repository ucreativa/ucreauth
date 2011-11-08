﻿﻿<?php

   require_once( __CLS_PATH . "cls_database.php");

	class cls_Usergroup { 
	
	   private $data_provide;
	 	 
	   public function __construct(){
			$this->data_provide=new cls_Database();	   
	   } 	
	 
	   public function get_users_groups(){ 
	   
			$result=$this->data_provide->sql_execute("SELECT tbl_users_groups.user_group_id,
																	tbl_users_groups.user_group_name,
																	tbl_users_groups.user_group_access
																	FROM tbl_users_groups
																	WHERE tbl_users_groups.user_group_status = 'A'");
			                      		                          
			return $this->data_provide->sql_get_rows($result);
      }
      
      public function insert_usergroupdata($usergroupdata = array()){ 
      
	      $success=false; 
			$result=$this->data_provide->sql_execute("INSERT INTO tbl_users_groups 
																  (user_group_name,
																	user_group_access,
																	user_group_status,
																	user_group_created,
																	user_group_description)
																	VALUES ('" . $usergroupdata[0] . "','" . $usergroupdata[1] . "','" . $usergroupdata[2] . "',
																	'" . $usergroupdata[3] . "','" . $usergroupdata[4] . "')");
			if($result){
				$success=true;
			}
			
			 return $success;
			                      		                          
      }
      
      public function update_usergroupdata($usergroupdata = array(),$id_group){ 
	   
	      $success=false; 
			$result=$this->data_provide->sql_execute("UPDATE tbl_users SET
																	user_group_name = '".$usergroupdata[0]."',
																	user_group_access = '".$usergroupdata[1]."',
																	user_group_status = '".$usergroupdata[2]."',
																	user_group_created = '".$usergroupdata[3]."',
																	user_group_description = '".$usergroupdata[4]."'
																	WHERE tbl_users_groups.user_group_id = " . $id_group);
			if($result){
				$success=true;
			}
			
	      return $success;
			                      		                          
      }     
  
      
	}

?>