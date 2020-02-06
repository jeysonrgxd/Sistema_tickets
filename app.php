
<?php
   // aqui se encontrara la logica de programacion
   require_once './app/config.php';
   require_once './app/db.php';
   require_once './app/send_mail.php';

   function obtener_cupo ($actividad_id){

      $sql = "SELECT a.actividad_id, a.bloque, a.disciplina, a.horario, a.cupo,
      ( SELECT COUNT(*) FROM registros AS r WHERE r.actividad = a.actividad_id ) AS registrados FROM actividades AS a WHERE a.actividad_id = ?";
      
      $data = array($actividad_id);

      /* 
         especificamos true por que no es algo que afectara la base de datos es mas bien una consulta para leer datos por esta razon es pecificamos el primer true el segundo true es por que estamos asiendo la consulta para que nos muestre un solo registro por eso lo ponemos true
      */
      $result = db_query($sql, $data, true, true);

      return $result;

   }
   
   function obtener_horarios($disciplina){

      $sql = "SELECT * FROM actividades WHERE disciplina = ? ORDER BY actividad_id";
      $data = array($disciplina);
      $result = db_query($sql, $data,true);

      if ( count($result) === 0 ) {
         // http_response_code(400); //le mandamos el status que ubo un error
         echo "No se encontro un horario para la disciplina $disciplina";
      } else {
         // echo "<pre>";
         // echo var_dump($result);
         // echo "</pre>";
         $html = '';

         foreach($result as $row){
            $cupo = obtener_cupo($row['actividad_id']);
            $lugares_disponibles = $cupo['cupo'] - $cupo['registrados'];
            $html .='
               <p>
                  <label>
                     <input name="horario" type="radio" value="'. $row['actividad_id'] .'" required>
                     <span>'.$row["horario"].'</span>
                     <span>'.$row["bloque"].'</span>
                     <span>Quedan <b>'.$lugares_disponibles.'</b> lugares disponibles</span>
                  </label>
               </p>
            ';
         }
         echo $html;
         // var_dump($result);
      }
      
   }

   if(isset($_POST["disciplina"])) obtener_horarios($_POST["disciplina"]);

   function existe_registro ( $email ){
      $sql = "SELECT p.email, p.nombre, p.apellidos, p.nacimiento, a.bloque, a.disciplina, a.horario, r.fecha FROM registros AS r INNER JOIN actividades AS a ON a.actividad_id = r.actividad INNER JOIN participantes AS p ON p.email = r.email WHERE r.email = ?"; 

      $data = array($email);
      $resp = db_query($sql, $data, true , true );
      
      return $resp;


   }

   function crear_registro ( $nombre, $apellido, $email,  $nacimiento, $actividad ){

      $registrado = existe_registro($email);

      if( !$registrado ){
         $cupo = obtener_cupo( $actividad );

         if($cupo["registrados"] === $cupo["cupo"]){

            $resp = array(
               "err" => true,
               "msg" => "El horario y actividad que elegistes ya no está disponible, elige otra."
            );

         } 
         else {

            $sql = "CALL registrar_participante(?,?,?,?,?)";
            $data = array($email, $nombre, $apellido, $nacimiento, $actividad);
            $resdb = db_query($sql, $data);
            
            if($resdb){

               $resp = array(
                  "err" => false,
                  "msg" => "Tu registro se efectuó con éxito. En breve recibirás un email con la agenda del bloque que elegiste."
               );
               // obtenemos el registro que emos insertado para posterior mente pasarselo como parametro ala funcion enviar_email($email)
               $registro = existe_registro($email);
               enviar_email($registro);

            } 
            else{
               $resp = array(
                  "err" => true,
                  "msg" => "Ocurrió un error con el registro, Intenta nuevamente"
               );
            }

         }

      }
      else{
         $resp = array(
            "err" => true,
            "msg" => "Tu correo electrónico ya ha sido registrado previamente, sólo puedes registrarte una vez."
         );
      }
      // le desimos que me emprimira en formato json
      header('content-type:application/json');
      echo json_encode($resp);//convertimos a formato json
      
   }

   if(isset($_POST["email"])) 
      crear_registro(
         $_POST['nombre'],
         $_POST['apellidos'],
         $_POST['email'],
         $_POST['nacimiento'],
         $_POST['horario']
      );

   function obtener_registros(){
      $sql = "SELECT p.email, p.nombre, p.apellidos, p.nacimiento, a.bloque, a.disciplina, a.horario, r.fecha FROM registros AS r INNER JOIN actividades AS a ON a.actividad_id = r.actividad INNER JOIN participantes AS p ON p.email = r.email ORDER BY r.fecha, a.bloque, a.disciplina, a.horario";
      
      $resp = db_query($sql, null, true ); //recordar que me trae un array asociativo
      $html ="";
      if(count($resp) === 0 ){
         return "No existen registros";
      } else {
         foreach($resp as $row){
            $html .='
               <tr>
                  <td>' .$row['email']. '</td>
                  <td>' .$row['nombre']. '</td>
                  <td>' .$row['apellidos']. '</td>
                  <td>' .$row['nacimiento']. '</td>
                  <td>' .$row['bloque']. '</td>
                  <td>' .$row['disciplina']. '</td>
                  <td>' .$row['horario']. '</td>
                  <td>' .$row['fecha']. '</td>
                  <td>
                     <a href="#" class="btn-floating lime">
                        <i  class="material-icons delete" data-registro="'.$row["email"].'">delete</i>
                     </a>
                  </td>
               </tr>';
         }
         return $html;
      }
      
   }

   function eliminar_participante($email){
      $sql = "CALL eliminar_participante(?)";
      $data = array($email);
      $resp = db_query($sql, $data);
      return $resp;

   }

   if(isset($_POST["elimina_registro"])) eliminar_participante($_POST["elimina_registro"])
   // echo var_dump(eliminar_participante('test10@gmail.com')) . PHP_EOL;
   // echo var_dump(obtener_registros());

   // echo "<p>";
   // echo var_dump(crear_registro("jeyson","ramos garcia","jeysonrgxd@gmail.com","1994-12-10","1P"));
   // echo "</p>";

   // $datos = obtener_cupo('1K');
   // obtener_horarios('PILATES');


?>


