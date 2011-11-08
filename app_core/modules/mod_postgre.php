<?php

	class mod_Postgre{
	   
	   var $conn_data;
	   var $core_conn;
	   var $conn_status;

	   public function __construct($connection){
			$this->conn_data=$connection;
	   } 

	   public function db_connect() {
		    try{
				 	$this->core_conn=pg_pconnect($this->conn_data->get_strconn());
			 }catch(Exception $e){
				   cls_Message::show_message($e->getMessage(),"error",""); 
			 }
			 
			 return $this->core_conn;
 	   }
	 
	   //Método para ejecutar una sentencia sql 
	   public function sql_execute($sql){ 
		   try{	
				$result=pg_query($this->db_connect(),$sql);
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
               while($row=pg_fetch_row($result)){
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
	         $row=pg_fetch_assoc($result);
		   }catch(Exception $e){
		   		cls_Message::show_message($e->getMessage(),"error","");
		   }
		  return $row;
	   }

	}
	
?>