<?php

   /* Archivo controlador que contiene los llamados a las acciones de la vista
   de Usuarios (ADD,EDIT,DELETE,SEARCH) */
   
   require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
   require_once( __CLS_PATH . "cls_userservice.php");  
     
   class ctr_Userservice {
   	
   	private $userservicedata;
      var $userservices;
      
      public function __construct()
	   {
        $this->userservices=new cls_Userservice();
	   }
	   
	   public function get_userservicedata($id_user)
	   {
			 return $this->userservicedata->get_userservicedata($id_user);
	   }  
	   
   	  
   	//Si se presiona el botón Agregar 
	   function btn_save_click() 
	   {
	   	         
	      $userserviceinfo=array();
	      $id_user=$_POST['txt_id'];
        
	      $userserviceinfo[0]=$_POST['txt_id'];
	      $userserviceinfo[1]=$_POST['txt_service'];
	      $userserviceinfo[2]=$_POST['txt_username'];
	      $userserviceinfo[4]=$_POST['txt_rol'];

	   	
	   	/*Si vamos a insertar un registro nuevo (_NEW) o actualizar en caso de que
	   	$_GET['id'] tenga un valor asignado desde el formulario de búsqueda*/   	
	   	if($id_user=="_NEW"){
		   	if(($this->userservicedata->insert_usergroupdata($userserviceinfo)==1)){   
		      	cls_Message::show_message("","success","success_insert");
		      }
		   }else{
		   	if(($this->userservicedata->update_usergroupdata($userserviceinfo,$id_user))){		   		   
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
	   
	   function btn_delete_click() {

	   }
   }
	
?>