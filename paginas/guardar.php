<?php

// Se incluye el archivo que define la clase MiClase
require_once '../clases/claseGenesis.php';

// Se crea una instancia de la clase Genesis
$objeto1 = new Genesis();

/**
 * Se verifica si la petición al servidor es de tipo post
 * si es así obtenemos los valores y se envian a la
 * función agregarRegistro
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $resultado = $objeto1->agregarRegistro($nombre, $apellido, $email, $password);

  // Devuelve la respuesta de la función guardarDatos() como texto plano
  echo $resultado;
}

?>
