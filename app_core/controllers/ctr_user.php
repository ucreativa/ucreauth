﻿<?php

   /* Archivo controlador que contiene los llamados a las acciones de la vista
   de Usuarios (ADD,EDIT,DELETE,SEARCH) */
   
   require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
   require_once( __CLS_PATH . "cls_user.php");
   require_once( __CLS_PATH . "cls_kerberos.php");
   require_once( __CLS_PATH . "cls_usergroup.php");  
     
   class ctr_User {
   	
   	private $userdata;
      private $kadmin;
      var $usersgroups;
      
      public function __construct()
	   {
		  $this->userdata=new cls_User();
        $this->kadmin=new cls_Kerberos(); 
        $this->usersgroups=new cls_Usergroup();
	   }
	   
	   public function get_userdata($id_user)
	   {
			 return $this->userdata->get_userdata("",$id_user);
	   }  
	   
   	  
   	//Si se presiona el botón Agregar Usuario 
	   function btn_save_click() 
	   {
	   	         
	      $userinfo=array();
	      $id_user=$_POST['txt_id'];
	      
	      if($_POST['txt_photo']==''){
	      	$_POST['txt_photo']="default.png";
	      }    
	      
	      $userinfo[0]=$_POST['cmb_groups'];
	      $userinfo[1]=$_POST['txt_user'];
	      $userinfo[2]=$_POST['txt_ident'];
	      $userinfo[3]=$_POST['txt_email'];
	      $userinfo[4]=$_POST['txt_phone'];
	      $userinfo[5]=$_POST['txt_photo'];
	      $userinfo[6]=$_POST['cmb_gender'];
	      $userinfo[7]=$_POST['cmb_year'] . '-' . $_POST['cmb_month'] . '-' . $_POST['cmb_day'];
			$userinfo[8]=$_POST['cmb_status'];
	      $userinfo[9]=date('Y-m-d');	
	      $userinfo[10]=$_POST['txt_info'];
	      $userinfo[11]=$_POST['txt_lifetime'];
	      $userinfo[12]=$_POST['txt_realname'];
	      $userinfo[13]=$_POST['cmb_usertype'];
	      $userinfo[14]=$_POST['txt_pssw'];
	      $userinfo[15]=$_POST['txt_chpassw'];
	   	
	   	/*Si vamos a insertar un registro nuevo (_NEW) o actualizar en caso de que
	   	$_GET['id'] tenga un valor asignado desde el formulario de búsqueda*/   	
	   	if($id_user=="_NEW"){
		   	if(($this->userdata->insert_userdata($userinfo)==1)&&($this->kadmin->krb5_add_user($userinfo[1],$userinfo[14]))){   
		      	cls_Message::show_message("","success","success_insert");
		      }
		   }else{
		   	if(($this->userdata->update_userdata($userinfo,$id_user))){
		   		 //si la opcion de cambio de password está seleccionada se procede a el cambio
		   		 if($userinfo[15]=='KRB5_CHPSSW'){
		   		 	$this->kadmin->krb5_edit_userpssw($userinfo[1],$userinfo[14]);
		   		 }
		   		   
		      	 cls_Message::show_message("","success","success_update");
                //Limpiamos las variables para inicializar la página con _NEW
		      	 unset($_GET['id']);
                unset($_GET['edit']);
		      }
		   } 
	   }

      function btn_new_click() {
   		//Limpiamos las variables para inicializar la página con _NEW
      	 unset($_GET['id']);
          unset($_GET['edit']);
	   }
	   
	   function update_chpssw($username,$password) {
	   	$success=false;
			if($this->kadmin->krb5_edit_userpssw($username,$password)==true 
			   && $this->userdata->update_chpssw($username)==true){
			     $success=true;	
			}
			return $success;
	   }
	   
	   function btn_delete_click() {

	   }
   }
	
?>