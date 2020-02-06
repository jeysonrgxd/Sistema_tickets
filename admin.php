<?php
   require './app.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Entrena tu Glamour</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="icon" href="./assets/img/favicon.ico">
  <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
   <main class="container">
      <header class="Header">
         <img src="./assets/img/foto_principal.jpg" class="responsive-img  Header-bg">
         <img src="./assets/img/logo_entrena.png" class="responsive-img  Header-glamour">
         <img src="./assets/img/logos.png" class="responsive-img Header-logos">
         <p class="flow-text  lime-text  Header-phrase">LISTA DE PARTICIPANTES</p>
      </header>

   <article class="center  u-m1p1  white">
      <table class="highlight">
        <thead>
          <tr>
              <th>Email</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Fecha Nacimiento</th>
              <th>Bloque</th>
              <th>Disciplina</th>
              <th>Horario</th>
              <th>Fecha Registro</th>
          </tr>
        </thead>
        <tbody>
          <?= obtener_registros()?>
        </tbody>
      </table>
   </article>

   </main>
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="./assets/script.js"></script>
</body>
</html>