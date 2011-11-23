<?php

   /* Archivo controlador que contiene los llamados a las acciones de la vista
   de Login (LOGIN, LOGOUT) */
   
   require_once($_SERVER["DOCUMENT_ROOT"] . "/ucreauth/global.php");
   //require_once( __CLS_PATH . "cls_kerberos.php");
   require_once( __CLS_PATH . "cls_login.php");
   
   class ctr_Login {

      private $login_acc;
   
	   public function __construct()
	   {
			 $this->login_acc=new cls_Login();
	   }  	
   	  
	   //Si se presiona el boton ENTRAR en el login
	   function btn_login_click() { 
	   	           
		      $username=trim($_POST['txt_user']);
		      $password=trim($_POST['txt_pssw']);
		       
		      $this->login_acc->login($username, $password);
		      
		      //Si nos autentificamos correctamente
				if($this->login_acc->conn_status)
				{
				 	 $_SESSION['AUTH']="YES";
				 	 $_SESSION['USERNAME']=$this->login_acc->get_username();
				}else{
					 $_SESSION['AUTH']="NO";
				}
				
				header("Location: index.php");
	   }
	   
	   //Si se presiona el boton SALIR (logout)
	   function btn_logout_click() {

		   if (isset($_POST['btn_logout'])){
		       $this->login_acc->logout();
		   }

	   }
   }
	 
?>