<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/GestionarGrupo.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class GestionarGrupos
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new GestionarGrupo();
  }


  public function MainGestorGrupos()
  {
    $area=$this->modelo->obtenerArea();
     require_once 'Vista/Header.php';
     require_once 'Vista/GestionGrupos/MainGestorGrupos.php'; 
     require_once 'Vista/Footer.php';   
  }

    public function MostrarTodosGrupos()
  {
    $gruposAll=$this->modelo->obtenerTodosGrupos();
  }

  public function BuscarEmpleadoGrupo()
{

  $dataString=$_POST['dataString'];
  $key=$_POST['key'];
  $this->modelo->EncontrarEmpleadoGrupo($dataString,$key);


}

public function BuscarCorreoGrupo()
{

  $dataString=$_POST['dataString'];
  $key=$_POST['key'];
  $this->modelo->EncontrarCorreoGrupo($dataString,$key);

}

public function LlenarTablaPorNombre()
{

  $idEmpleado=$_POST['idEmpleado'];
  $dataTablaNombre=$this->modelo->ObtenerGruposPorUsuario($idEmpleado);

}

public function LlenarTablaPorCorreo()
{

  $idEmpleado=$_POST['idEmpleado'];
  $dataTablaNombre=$this->modelo->ObtenerGruposPorUsuario($idEmpleado);

}

 public function VerMiembrosGestor()
 {
  $idBotonVer=$_POST['idBotonVer'];
   $datosMiembros=$this->modelo->ConsultarMiembrosGestor($idBotonVer);
 }

  public function TodosUsuarios()
 {

  $idGrupo=$_POST['idGrupo'];
  $datos=$this->modelo->obtenerUsuariosTbalaElegir($idGrupo);
  
}

  public function arrayUsuariosElegidos()
 {
    $idGrupo=$_POST['idGrupo'];
        $data = json_decode($_POST['usuariosElegidosGrupo'],true);
           $datos=$this->modelo->almacenarArrayUsuarios($idGrupo,$data);
     
 }

 //ACTUALIZAR GRUPO, GESTOR GRUPOS
 public function ActualizarGrupoGestor()
{
  $idGrupoActualizar=$_POST['idGrupoActualizar'];
  $idUserGrupo=$_POST['idUserGrupo'];
  $nombreGrupoA=$_POST['nombreGrupoA'];
  $descripcionGrupo=$_POST['descripcionGrupo'];
  $dataFinal = json_decode($_POST['arrayAgregados'],true);
  $dataEliminadosEditar = json_decode($_POST['arrayEliminadosEditar'],true);
  $datosAgregados=$this->modelo->ActualizarInformacionGrupoGestor($idGrupoActualizar,$nombreGrupoA,$descripcionGrupo,$dataFinal,$dataEliminadosEditar,$idUserGrupo);
}


public function vistaEditarGrupoGestor()
{

 $datosEditar = new GestionarGrupo();

 $idGrupo=base64_decode($_REQUEST['XK']);
        //Se obtienen los datos del proveedor a editar.
 if(isset($idGrupo)){

  $datosEditar = $this->modelo->ObtenerDatosEditarGestor($idGrupo);
  $miembrosEditar = $this->modelo->MiembrosEditarGestor($idGrupo);
}

$area=$this->modelo->obtenerArea();

require_once 'Vista/Header.php';
require_once 'Vista/GestionGrupos/EditarGestorGrupos.php'; 
require_once 'Vista/Footer.php';  

}


//MOSTRAR USUARIOS QUE TIENEN PERMISO DEL GRUPO SELECCIONADO
   public function TodosUsuariosGrupoSeleccionado()
 {

  $idGrupo=$_POST['idGrupo'];
  $datos=$this->modelo->UsuariosQuitarPermiso($idGrupo);
  
}

  public function arrayUsuariosQuitarPermisos()
 {
    $idGrupo=$_POST['idGrupo'];
        $data = json_decode($_POST['usuariosElegidosGrupo'],true);
           $datos=$this->modelo->quitarPermisosArrayUsuarios($idGrupo,$data);
     
 }

   public function eliminarGrupoGestor()
 {

  $idGrupo=$_POST['idGrupo'];
  $idUsuario=$_POST['idUsuario'];
  $this->modelo->eliminarGrupoGestorAdmin($idGrupo,$idUsuario);


 }



}

