<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/CorreoProgramado.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class CorreosProgramados
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new CorreoProgramado();
  }

  public function MainProgramados()
  {
   require_once 'Vista/Header.php';
   require_once 'Vista/Email/Programados.php'; 
   require_once 'Vista/Footer.php';   
 }

   public function verCorreosProgramados()
  {
   require_once 'Vista/Header.php';
   require_once 'Vista/PosponerCorreos/MainCorreosProgramados.php'; 
   require_once 'Vista/Footer.php';   
 }

  public function mostrarCorreosProgramados()
 { 

  $correosRecibidos=$this->modelo->obtenerCorreosProgramados();
}

  public function mostrarTodos()
 { 

  $correosRecibidos=$this->modelo->obtenerTodos();
}


 //CANCELAR CORREO PROGRAMADO
public function eliminarCorreoProgramado()
{

  $idCorreo = $_POST['Correo_idCorreo'];
  $this->modelo->CancelarCorreoProgramado($idCorreo);
}


   public function MainBorradores()
  {
   require_once 'Vista/Header.php';
   require_once 'Vista/Email/Borradores.php'; 
   require_once 'Vista/Footer.php';   
 }

  public function mostrarCorreosBorradores()
 { 

  $correosBorrador=$this->modelo->obtenerCorreosBorradores();
}


 //ELIMINAR CORREO BORRADOR
public function eliminarCorreoBorrador()
{

  $idCorreo = $_POST['Correo_idCorreo'];
  $this->modelo->EliminarCorreoBorrador($idCorreo);
}






 //LLAVE FINAL
}
