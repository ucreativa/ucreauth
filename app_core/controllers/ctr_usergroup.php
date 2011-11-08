<?php

   /* Archivo controlador que contiene los llamados a las acciones de la vista
   de Usuarios (ADD,EDIT,DELETE,SEARCH) */
   
   require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
   require_once( __CLS_PATH . "cls_usergroup.php");  
     
   class ctr_Usergroup {
   	
   	private $usergroupdata;
      var $usersgroups;
      
      public function __construct()
	   {
        $this->usersgroups=new cls_Usergroup();
	   }
	   
	   public function get_usergroupdata($id_group)
	   {
			 return $this->usergroupdata->get_usergroupdata("",$id_user);
	   }  
	   
   	  
   	//Si se presiona el botón Agregar 
	   function btn_save_click() 
	   {
	   	         
	      $usergroupinfo=array();
	      $id_group=$_POST['txt_id'];
        
	      $usergroupinfo[0]=$_POST['txt_groupname'];
	      $usergroupinfo[1]=$_POST['txt_access'];
	      $usergroupinfo[2]=$_POST['cmb_status'];
	      $usergroupinfo[4]=$_POST['txt_description'];

	   	
	   	/*Si vamos a insertar un registro nuevo (_NEW) o actualizar en caso de que
	   	$_GET['id'] tenga un valor asignado desde el formulario de búsqueda*/   	
	   	if($id_user=="_NEW"){
		   	if(($this->usergroupdata->insert_usergroupdata($usergroupinfo)==1)){   
		      	cls_Message::show_message("","success","success_insert");
		      }
		   }else{
		   	if(($this->usergroupdata->update_usergroupdata($usergroupinfo,$id_group))){		   		   
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