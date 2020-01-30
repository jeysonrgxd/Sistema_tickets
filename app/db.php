<?php

   function db_connect(){

      // inicializamos las variables de conexion extraidas de la constantes declaradas en config.php
      $dsn = DB["dsn"];
      $user = DB["user"];
      $pass = DB["pass"];
      $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

      try{

         $db = new PDO($dsn,$user,$pass,$option);
         return $db;
      }
      catch(PDOException $e){

         echo "<p>¡Error: <mark>".$e->getMessage()."</mark></p>";
         die(); //matamos el proceso
      }

   }

   function db_query($sql, $data=array(), $is_search = false, $search_one = false){

      $db = db_connect();
      $PDOstate = $db->prepare($sql); //preparamos la consulta enviandole el array de conexion
      $PDOstate->execute($data); //ejecutamos laconsulta pasandole el array de valores

      if( $is_search ){
         // para consultas de tipo READ

         if( $search_one ){
            //para buscar un registro
            $result = $PDOstate->fetch(PDO::FETCH_ASSOC); 
         } else {
            // para buscar todos los registros
            $result = $PDOstate->fetchAll(PDO::FETCH_ASSOC); 

         }
         $bd = null; // con esto cerramos la conexion en PDO
         return $result;

      } else {
         // para consultas de Tipo CREATE, UPDATE Y DELETE

         $bd = null; // con esto cerramos la conexion en PDO
         return true; // la consulta se ejecuto
      }


   }



?>