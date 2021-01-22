<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/GestionarCorreo.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class GestionarCorreos
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new GestionarCorreo();
  }


  public function MainGestorCorreos()
  {
     require_once 'Vista/Header.php';
     require_once 'Vista/GestionCorreos/MainGestorCorreos.php'; 
     require_once 'Vista/Footer.php';   
  }

    //MOSTRAR TODOS LOS CORREOS
 public function correosTodos()
 { 

  $correosTodos=$this->modelo->obtenerCorreosTodos();
}

}

