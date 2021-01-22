<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/Papelera.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class Papeleras
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
    
    $this->modelo = new Papelera();
  }

  public function MainPapelera()
  {
   require_once 'Vista/Header.php';
   require_once 'Vista/Papelera/MainPapelera.php'; 
   require_once 'Vista/Footer.php';   
 }


 public function mostrarCorreosPapelera()
 { 

  $correosPapelera=$this->modelo->obtenerCorreosPapelera();
}

//CANCELAR CORREO PROGRAMADO
public function correoPapeleraEliminar()
{

  $idCorreo = $_POST['idCorreoSecundario'];
  $this->modelo->eliminarCorreoPapelera($idCorreo);
}

//LLAVE FINAL
}
