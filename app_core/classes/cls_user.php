<?php

   require_once( __CLS_PATH . "cls_database.php");

	class cls_User { 
	
	   private $data_provide;
	 	 
	   public function __construct(){
			$this->data_provide=new cls_Database();	   
	   } 	

	   public function get_userdata($user_krb_name,$id_user){

			$result=$this->data_provide->sql_execute("SELECT tbl_users.user_id,
																	tbl_users.user_group_fk,
																	tbl_users.user_krb_name,
																	tbl_users.user_ident,
																	tbl_users.user_email,
																	tbl_users.user_phone,
																	tbl_users.user_photo,
																	tbl_users.user_gen,
																	tbl_users.user_datebirth,
																	tbl_users.user_status,
																	tbl_users.user_created,
																	tbl_users.user_description,
																	tbl_users.user_lifetime,
																	tbl_users.user_realname,
																	tbl_users.user_type,
																	tbl_users.user_chpssw,
																	tbl_users.user_genpssw,
																	tbl_users.user_chprofile
																	FROM tbl_users
																	WHERE tbl_users.user_krb_name = '" . $user_krb_name . "'
																	OR tbl_users.user_id = " . $id_user);
			                      		                          
			return $this->data_provide->sql_get_rows($result);
      } 
      
      public function get_userdata_by_email($user_email){

			$result=$this->data_provide->sql_execute("SELECT tbl_users.user_id,
																	tbl_users.user_krb_name,
																	tbl_users.user_email,
																	tbl_users.user_status
																	FROM tbl_users
																	WHERE tbl_users.user_email = '" . $user_email . "'
																	AND tbl_users.user_status = 'A'");
			                      		                          
			return $this->data_provide->sql_get_rows($result);
      } 
      
      public function get_user_status($user_krb_name){

			$result=$this->data_provide->sql_execute("SELECT tbl_users.user_status
																	FROM tbl_users
																	WHERE tbl_users.user_krb_name = '" . $user_krb_name . "'");
																	
			$status=$this->data_provide->sql_get_rows($result);                     		                          
			return $status[0][0];
			
      } 
      
      public function insert_userdata($userdata = array()){ 
      
	      $success=false; 
			$result=$this->data_provide->sql_execute("INSERT INTO tbl_users 
																  (user_group_fk,
																	user_krb_name,
																	user_ident,
																	user_email,
																	user_phone,
																	user_photo,
																	user_gen,
																	user_datebirth,
																	user_status,
																	user_created,
																	user_description,
																	user_lifetime,
																	user_realname,
																	user_type)
																	VALUES (" . $userdata[0] . ",'" . $userdata[1] . "','" . $userdata[2] . "',
																	'" . $userdata[3] . "','" . $userdata[4] . "','" . $userdata[5] . "',
																	'" . $userdata[6] . "','" . $userdata[7] . "','" . $userdata[8] . "',
																	'" . $userdata[9] . "','" . $userdata[10] . "'," . $userdata[11] . ",
																	'" . $userdata[12] . "','" . $userdata[13] . "')");
			if($result){
				$success=true;
			}
			
			 return $success;
			                      		                          
      }
      
      public function update_userdata($userdata = array(),$id_user){ 
	   
	      $success=false; 
			$result=$this->data_provide->sql_execute("UPDATE tbl_users SET
																	user_group_fk = ".$userdata[0].",
																	user_krb_name = '".$userdata[1]."',
																	user_ident = '".$userdata[2]."',
																	user_email = '".$userdata[3]."',
																	user_phone = '".$userdata[4]."',
																	user_photo = '".$userdata[5]."',
																	user_gen = '".$userdata[6]."',
																	user_datebirth = '".$userdata[7]."',
																	user_status = '".$userdata[8]."',
																	user_description = '".$userdata[10]."',
																	user_lifetime = ".$userdata[11].",
																	user_realname = '".$userdata[12]."',
																	user_type = '".$userdata[13]."',
																	user_chpssw = '".$userdata[16]."',
																	user_chprofile = '".$userdata[17]."'
																	WHERE tbl_users.user_id = " . $id_user);
																	

			if($result){
				$success=true;
			}
			
	      return $success;
			                      		                          
      }
      
      public function update_userprofile($userdata = array(),$id_user){ 
	   
	      $success=false; 
			$result=$this->data_provide->sql_execute("UPDATE tbl_users SET
																	user_ident = '".$userdata[2]."',
																	user_email = '".$userdata[3]."',
																	user_phone = '".$userdata[4]."',
																	user_gen = '".$userdata[6]."',
																	user_datebirth = '".$userdata[7]."',
																	user_description = '".$userdata[10]."',
																	user_realname = '".$userdata[12]."',
																	user_chprofile = '0'
																	WHERE tbl_users.user_id = " . $id_user);
			if($result){
				$success=true;
			}
			
	      return $success;
			                      		                          
      }
      
      
      public function update_chpssw($username,$val="0"){ 
	      /*Ponemos el flag de cambio de contraseña a 0 
          para no volver a preguntar por cambio de password*/
       
	      $success=false; 
			$result=$this->data_provide->sql_execute("UPDATE tbl_users SET
																	user_chpssw = '".$val."'
																	WHERE tbl_users.user_krb_name = '" . $username . "'");
			if($result){
				$success=true;
			}
			
	      return $success;
			                      		                          
      } 
 

	}
	
?>