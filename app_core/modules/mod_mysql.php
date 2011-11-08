<?php

	class mod_Mysql {
	   
	   var $conn_data;
	   var $core_conn;
	   var $conn_status;

	   public function __construct($connection){
          $this->conn_data=$connection;
	   }

	   public function db_connect() {
		    try{
                $this->core_conn=mysql_pconnect($this->conn_data->get_dbhost(),$this->conn_data->get_dbuser(),$this->conn_data->get_dbpassw());
                mysql_select_db($this->conn_data->get_dbname());
                mysql_query ("SET NAMES 'utf8'");
			 }catch(Exception $e){
				 cls_Message::show_message($e->getMessage(),"error","");
			 }

			 return $this->core_conn;
 	   }
	 
	   //Método para ejecutar una sentencia sql 
	   public function sql_execute($sql){ 
		   try{
                $result=mysql_query($sql,$this->db_connect());
			}catch(Exception $e){
		   		cls_Message::show_message($e->getMessage(),"error","");
		   }
		   return $result;
	   } 
	   
	   //Método para obtener los resultados de una sentencia sql en un array
	   public function sql_get_rows($result){
	      try{
	         $array=array();
	         $i=0;
			   while($row=mysql_fetch_row($result)){
			   	$array[$i]=$row;
			   	$i++;
			   }
		   }catch(Exception $e){
		   		cls_Message::show_message($e->getMessage(),"error","");
		   }
		  return $array;
	   }

       //Método para obtener los resultados de una sentencia sql
	   public function sql_get_fetchassoc($result){
	      try{
			 $row=mysql_fetch_assoc($result);
		   }catch(Exception $e){
		   		cls_Message::show_message($e->getMessage(),"error","");
		   }
		  return $row;
	   }

	}
	
?>