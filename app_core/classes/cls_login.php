<?php

	 require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
    require_once( __CLS_PATH . "cls_kerberos.php");
    require_once( __CLS_PATH . "cls_database.php");
    require_once( __CLS_PATH . "cls_user.php");
    
    class cls_Login {
    	
		 var $auth_krb5;
		 var $auth_db;
		 var $my_ticket;
		 var $conn_status;
		 var $username;
		 var $usercore;
		 
		 function __construct(){
		   $this->auth_krb5=new cls_Kerberos();
         $this->auth_db=new cls_Database();
         $this->usercore=new cls_User();
		 }

		 function get_username(){
		 	return $this->username;
		 }
		 
		 public function login($user, $pssw){

         $userdata=$this->usercore->get_userdata($user,-1);
         $lifetime=$userdata[0][12];
         // Verifica la conexion con kerberos y la conexion con postgre
		 	if($this->auth_db->is_connect()){
		 		if($this->auth_krb5->krb5_connect($user, $pssw, $lifetime)){
		 		   $this->my_ticket=$this->auth_krb5->get_ticket();
		 		   $this->conn_status=true;
		 		   $this->username=$user;	
		 		}else{
		 		   $this->my_ticket=null;
		   	   $this->conn_status=false;
		 		}
		   }else{
		   	   $this->my_ticket=null;
		   	   $this->conn_status=false;
		   }
		 }
		 
		 public function logout(){
            unset($this->auth_krb5);
            unset($this->auth_db);
		   	$this->my_ticket=null;
		   	$this->conn_status=false;
		 }  
    }

	
?>