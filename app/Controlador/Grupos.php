<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/Grupo.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class Grupos
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new Grupo();
  }


  public function MainGrupo()
  {


    $grupo=$this->modelo->obtenerGrupos();
    require_once 'Vista/Header.php';
    require_once 'Vista/Grupos/MainGrupos.php'; 
    require_once 'Vista/Footer.php';   

  }

  public function vistaAgregar()
  {
   $area=$this->modelo->obtenerArea();

   require_once 'Vista/Header.php';
   require_once 'Vista/Grupos/CrearGrupo.php'; 
   require_once 'Vista/Footer.php';  


 }

 public function mostrarAreaSub()
 {

   $idArea=$_POST['idArea'];
   $data=$this->modelo->obtenerSubarea($idArea);
   
 }

 public function Filtro()
 {

  $idArea=$_POST['idArea'];
  $idSubarea=$_POST['idSubarea'];
  $data = json_decode($_POST['arrayAgregados'],true);
  $datos=$this->modelo->obtenerUsuarios($idArea,$idSubarea,$data);
  
}

public function GuardarGrupo()
{
  $nombreGrupoA=$_POST['nombreGrupoA'];
  $descripcionGrupo=$_POST['descripcionGrupo'];
  $dataFinal = json_decode($_POST['arrayAgregados'],true);
  $datosAgregados=$this->modelo->GuardarInfoGrupo($nombreGrupoA,$descripcionGrupo,$dataFinal);
}

public function ActualizarGrupo()
{
  $idGrupoActualizar=$_POST['idGrupoActualizar'];
  $nombreGrupoA=$_POST['nombreGrupoA'];
  $descripcionGrupo=$_POST['descripcionGrupo'];
  $dataFinal = json_decode($_POST['arrayAgregados'],true);
  $dataEliminadosEditar = json_decode($_POST['arrayEliminadosEditar'],true);
  $datosAgregados=$this->modelo->ActualizarInformacionGrupo($idGrupoActualizar,$nombreGrupoA,$descripcionGrupo,$dataFinal,$dataEliminadosEditar);
}



public function VerMiembros()
{
  $idBotonVer=$_POST['idBotonVer'];
  $datosMiembros=$this->modelo->ConsultarMiembros($idBotonVer);
   // $nombreGrupoActual=$this->modelo->GrupoActualNombre($idBotonVer);
}

public function vistaEditarGrupo()
{

 $datosEditar = new Grupo();

 $idGrupo=base64_decode($_REQUEST['XK']);
        //Se obtienen los datos del proveedor a editar.
 if(isset($idGrupo)){

  $datosEditar = $this->modelo->ObtenerDatosEditar($idGrupo);
  $miembrosEditar = $this->modelo->MiembrosEditar($idGrupo);
  
}

$area=$this->modelo->obtenerArea();

require_once 'Vista/Header.php';
require_once 'Vista/Grupos/EditarGrupo.php'; 
require_once 'Vista/Footer.php';  

}

public function eliminarGrupo()
{

  $idGrupo=$_POST['idGrupo'];
  $this->modelo->eliminarGrupo($idGrupo);


}

}

