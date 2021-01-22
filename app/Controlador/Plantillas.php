<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/Plantilla.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class Plantillas
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new Plantilla();
  }

  public function MainPlantillas()
  { 

     require_once 'Vista/Header.php';
     require_once 'Vista/Plantillas/MainPlantillas.php';  
     require_once 'Vista/Footer.php';   

 }

     public function MostrarPlantillas()
  {
    $plantillasAll=$this->modelo->obtenerPlantillas();
  }

 public function VistaCrearPlantilla()
{

    require_once 'Vista/Header.php';
     require_once 'Vista/Plantillas/CrearPlantilla.php';  
     require_once 'Vista/Footer.php';   
}

 public function crearPlantilla()
{
    $nombrePlantilla = $_POST['nombrePlantilla'];
  $descripcionPlantilla = $_POST['descripcionPlantilla'];

 $resultado=$this->modelo->guardarPlantilla($nombrePlantilla,$descripcionPlantilla);

 if ($resultado == 'bien') {

 header('Location: ?c=Plantillas&a=MainPlantillas');
  
 }

  if ($resultado == 'error1') {
$this->VistaCrearPlantilla();
   echo '<script language="javascript">alert("error");</script>';
  
 }

  if ($resultado == 'error') {
$this->VistaCrearPlantilla();
   echo '<script language="javascript">alert("error");</script>';
  
 }

  if ($resultado == 'tamano') {

   // echo '<script language="javascript">alert("Tamaño de archivo");</script>';
    $this->VistaCrearPlantilla();
     echo '<script language="javascript">alert("Tamaño de archivo");</script>';
  
 }

  
}

 public function VistaEditarPlantilla()
{

     $datosEditar = new Plantilla();

     $idPlantilla=base64_decode($_REQUEST['g']);
        //Se obtienen los datos del proveedor a editar.
        if(isset($idPlantilla)){

          $datosEditar = $this->modelo->ObtenerPantillaEditar($idPlantilla);

        }

    require_once 'Vista/Header.php';
     require_once 'Vista/Plantillas/EditarPlantilla.php';  
     require_once 'Vista/Footer.php';   
}

//ELIMINAR IMAGENES EN EL MENU DE EDITAR
 public function borrarImagenEncabezado()
{

    $file = $_POST['id'];
   if (is_file($file))
   {
     chmod($file, 0777);
     if (!unlink($file)) {
      echo false;
       
     }
   }
}

 public function borrarImagenMarca()
{

    $file = $_POST['id'];
   if (is_file($file))
   {
     chmod($file, 0777);
     if (!unlink($file)) {
      echo false;
       
     }
   }
}

 public function borrarImagenPie()
{

    $file = $_POST['id'];
   if (is_file($file))
   {
     chmod($file, 0777);
     if (!unlink($file)) {
      echo false;
     }
   }
}

//FIN

//EDITAR PLANTILLA

 public function editarPlantilla()
{

    $editarNombrePlantilla = $_POST['editarNombrePlantilla'];
  $editarDescripcionPlantilla = $_POST['editarDescripcionPlantilla'];
  $idPlantilla = $_POST['idPlantilla'];

 $resultado=$this->modelo->editarPlantillaModelo($editarNombrePlantilla,$editarDescripcionPlantilla,$idPlantilla);

  if ($resultado == 'bien') {

 header('Location: ?c=Plantillas&a=MainPlantillas');
  
 }

  if ($resultado == 'error1') {
$this->VistaCrearPlantilla();
   echo '<script language="javascript">alert("error");</script>';
  
 }

  if ($resultado == 'error') {
$this->VistaCrearPlantilla();
   echo '<script language="javascript">alert("error");</script>';
  
 }

  if ($resultado == 'tamano') {

   $this->VistaCrearPlantilla();
         echo '<script language="javascript">alert("Tamaño de archivo");</script>';
  
 }
  
}

//FIN

//DAR DE BAJA PLANTILLA
 public function eliminarPlantilla()
{

    $idPlantilla = $_POST['idPlantilla'];
 $this->modelo->deletePlantilla($idPlantilla);
}



 
}




