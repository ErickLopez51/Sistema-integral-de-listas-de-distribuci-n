<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/GestionarEtiqueta.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class GestionarEtiquetas
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new GestionarEtiqueta();
  }


  public function MainGestorEtiquetas()
  {
     require_once 'Vista/Header.php';
     require_once 'Vista/GestionEtiquetas/MainGestorEtiquetas.php'; 
     require_once 'Vista/Footer.php';   
  }

  //MOSTRAR TODAS LAS ETIQUETAS EN DATATABLE
 public function todasEtiquetas()
 { 

  $carpetasCreadas=$this->modelo->obtenerTodasEtiquetas();
}


  //BUSCAR POR NOMBRE
  public function BuscarEmpleadoEtiqueta()
{

  $dataString=$_POST['dataString'];
  $key=$_POST['key'];
  $this->modelo->EncontrarEmpleadoEtiqueta($dataString,$key);
}


//BUSCAR POR CORREO
public function BuscarCorreoEtiqueta()
{

  $dataString=$_POST['dataString'];
  $key=$_POST['key'];
  $this->modelo->EncontrarCorreoEtiqueta($dataString,$key);

}
//LLENAR TABLA POR NOMBRE Y POR CORREO
public function LlenarTablaPorNombreEtiqueta()
{

  $idEmpleado=$_POST['idEmpleado'];
  $dataTablaNombre=$this->modelo->ObtenerEtiquetasPorUsuario($idEmpleado);

}
public function LlenarTablaPorCorreoEtiqueta()
{

  $idEmpleado=$_POST['idEmpleado'];
  $dataTablaNombre=$this->modelo->ObtenerEtiquetasPorUsuario($idEmpleado);

}

 //GUARDAR ETIQUETA
public function editarEtiquetaGestor()
{ 
  $editaNombre=$_POST['editaNombre'];
   $idEtiqueta=base64_decode($_POST['idEtiqueta']);
  $editarEti=$this->modelo->editarEtiquetaGestor($editaNombre,$idEtiqueta);
}

//ELIMINAR ETIQUETA
public function etiquetaBorrarGestor()
{

  $idCarpetaSecundario = $_POST['idCarpetaSecundario'];
  $this->modelo->eliminarEtiquetaGestor($idCarpetaSecundario);
}


}

