<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/GestionarUsuario.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class GestionarUsuarios
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
    $this->modelo = new GestionarUsuario();
  }

  public function MainGestorUsuarios()
  { 

    $area=$this->modelo->obtenerArea();
    require_once 'Vista/Header.php';
    require_once 'Vista/GestionUsuarios/MainGestorUsuarios.php';  
    require_once 'Vista/Footer.php';   
  }


  public function mostrarAreaSub()
  {

   $idArea=$_POST['idArea'];
   $data=$this->modelo->obtenerSubarea($idArea);
 }

 public function FiltroGestorUsuario()
 {

  $idArea=$_POST['idArea'];
  $idSubarea=$_POST['idSubarea'];
  $datos=$this->modelo->obtenerUsuariosGestor($idArea,$idSubarea);
  
}

public function VistaAltaUsuario()
{

 require_once 'Vista/Header.php';
 require_once 'Vista/GestionUsuarios/AltaUsuario.php'; 
 require_once 'Vista/Footer.php';  


}

public function datosDeUsuario()
{
 $idBotonVer=$_POST['idBotonVer'];
 $datosPerfil=$this->modelo->InfoPerfilUsuario($idBotonVer);
}

public function EditarDatosUsuario()
{

 $datosEditarUsuario = new GestionarUsuario();
 $idEmpleado=base64_decode($_REQUEST['g']);
        //Se obtienen los datos del proveedor a editar.
 if(isset($idEmpleado)){

  $datosEditarUsuario = $this->modelo->ObtenerDatosEditarUsuario($idEmpleado);
}

require_once 'Vista/Header.php';
require_once 'Vista/GestionUsuarios/EditarUsuario.php'; 
require_once 'Vista/Footer.php';  


}


public function bajaUsuario()
{

  $idUsuario=$_POST['idUsuario'];
  var_dump($idUsuario);
  $this->modelo->DarDeBajaUsuario($idUsuario);


}

public function BuscarEmpleadoRegistro()
{

  $dataString=$_POST['dataString'];
  $key=$_POST['key'];
  $this->modelo->BuscarEmpleado($dataString,$key);


}

public function BuscarEmpleadoCorreo()
{

  $dataString=$_POST['dataString'];
  $key=$_POST['key'];
  $this->modelo->ObtenerCorreoEmpleado($dataString,$key);


}

public function darDeAltaUsuario()
{

  $nombreUsuario=$_POST['nombreUsuario'];
  $correoUsuario=$_POST['correoUsuario'];
  $idEmpleado=$_POST['idEmpleado'];
  $datosAlta=$this->modelo->GuardarUsuarioAlta($nombreUsuario,$correoUsuario,$idEmpleado);
}


public function ActualizarUsuario()
{

  $idUsuario=$_POST['idUsuario'];
  $nombreUsuario=$_POST['nombreUsuario'];
  $correoUsuario=$_POST['correoUsuario'];
  $datosEditados=$this->modelo->ActualizarInfoUsuario($idUsuario,$nombreUsuario,$correoUsuario);
}



}



