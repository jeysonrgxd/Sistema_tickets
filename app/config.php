<?php
   // en este fichero defineros variables que me permitan trabajar con la base de datos o si tenemos constante para utilizar en el sitio web la definiermos aca
   define('ENV','dev');
   define('DB', array(
      'dsn' => (ENV === 'dev') ? 'mysql:host=localhost;dbname=sistema_tickets': '',
      'user' => (ENV === 'dev') ? 'root' : '',
      'pass' => (ENV === 'dev') ? '': '',
   ));

?>