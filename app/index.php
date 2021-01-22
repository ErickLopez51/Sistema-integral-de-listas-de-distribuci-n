<?php
  //Se incluye la configuración de conexión de la base de datos
  require_once 'Librerias/Base.php';


  $controller = 'Usuarios';

  // Todo esta lógica hara el papel de un FrontController
  if(!isset($_REQUEST['c']))
  {
    //Llamado de la página principal
    require_once "Controlador/$controller.php";
    $controller = ucwords($controller);
    $controller = new $controller;
    $controller->Index();
  }
  else
  {
    // Obtiene el controlador a cargar
    // $controller = strtolower($_REQUEST['c']);
    $controller = ucwords($_REQUEST['c']);
    $accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';

    // Instancia el controlador
    require_once "Controlador/$controller.php";
    $controller = ucwords($controller);
    $controller = new $controller;

    // Llama la accion
    call_user_func( array( $controller, $accion ) );
  }
