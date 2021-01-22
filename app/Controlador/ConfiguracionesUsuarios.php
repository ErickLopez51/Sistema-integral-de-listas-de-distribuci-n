<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/ConfiguracionUsuario.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class ConfiguracionesUsuarios
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
     $this->modelo = new ConfiguracionUusario();
  }

  public function MainConfiguracion()
  {

      $area=$this->modelo->obtenerArea();
     require_once 'Vista/Header.php';
      require_once 'Vista/Configuracion/MainConfiguracion.php'; 
     require_once 'Vista/Footer.php';   
 

 }

   public function mostrarAreaSub()
  {

   $idArea=$_POST['idArea'];
   $data=$this->modelo->obtenerSubarea($idArea);
 }

  public function FiltroConfigUsuario()
 {

  $idArea=$_POST['idArea'];
  $idSubarea=$_POST['idSubarea'];
  $datos=$this->modelo->obtenerUsuariosConfig($idArea,$idSubarea);
  
}

public function datosPapelera()
{

  $idUsuario=$_POST['idUsuario'];
  $diasPapelera=$_POST['diasPapelera'];


  $this->modelo->papeleraBorradoAuto($idUsuario,$diasPapelera);

}

public function datosBandejaEntrada()
{

  $idUsuario=$_POST['idUsuario'];
  $tamBandeja=$_POST['tamBandeja'];


  $this->modelo->tamBanEntrada($idUsuario,$tamBandeja);

}

public function datosTArchivos()
{

  $idUsuario=$_POST['idUsuario'];
  $tamArchivo=$_POST['tamArchivo'];


  $this->modelo->tamArchivos($idUsuario,$tamArchivo);

}

public function mostrarDatosConfig()
{

  $idUsuario=$_POST['idUsuario'];

  $dataConfig=$this->modelo->obtenerDatosConfig($idUsuario);

}



}
