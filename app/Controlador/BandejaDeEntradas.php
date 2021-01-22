<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/CorreosRecibido.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class BandejaDeEntradas
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
    $this->modelo = new CorreosRecibido();
  }

  //MOSTRAR VISTA DE BANDEJA DE ENTRADA
  public function MainBandejaDeEntrada()
  {

     require_once 'Vista/Header.php';
      require_once 'Vista/Email/BandejaEntrada.php'; 
     require_once 'Vista/Footer.php';   
 
 }

//LLENAR RABLA CON LOS CORREOS RECIBIDOS
  public function mostrarCorreosRecibidos()
 { 
  
    $correosRecibidos=$this->modelo->obtenerCorreosRecibidos();
 }

 //DAR DE BAJA CORREO RECIBIDO
 public function eliminarCorreoR()
{
 $idCorreo = $_POST['idCorreoSecundario'];
 $this->modelo->eliminarCorreoRecibido($idCorreo);
}

  public function tablaCarpetasCreadas()
  {
     $datosCarpeta = new CorreosRecibido();

     $idCorreo=base64_decode($_REQUEST['g']);

     require_once 'Vista/Header.php';
     require_once 'Vista/Email/CarpetasCorreo.php'; 
     require_once 'Vista/Footer.php';  

     return $idCorreo; 
 }

//MOSTRAR CARPETAS PARA AGREGAR CORREO

 //  public function mostrarCarpetas()
 // { 
  
 //    $carpetasCreadas=$this->modelo->obtenerCarpetasCreadas();
 // }








 
}
