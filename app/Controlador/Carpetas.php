<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/Carpeta.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class Carpetas
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new Carpeta();
  }


  public function MainCarpetas()
  {
   require_once 'Vista/Header.php';
   require_once 'Vista/CarpetasDeCorreos/MainCarpetas.php'; 
   require_once 'Vista/Footer.php';  
 }

  //MOSTRAR CARPETAS EN DATATABLE
 public function mostrarCarpetas()
 { 

  $carpetasCreadas=$this->modelo->obtenerTodasEtiquetas();
}

 //GUARDAR ETIQUETA
public function crearCarpeta()
{ 
  $nomCarpeta=$_POST['nomCarpeta'];
  $guardarCarpeta=$this->modelo->guardarCarpeta($nomCarpeta);
}

 //GUARDAR ETIQUETA
public function editarEtiqueta()
{ 
  $editaNombre=$_POST['editaNombre'];
   $idEtiqueta=base64_decode($_POST['idEtiqueta']);
  $editarEti=$this->modelo->editarEtiquetaBD($editaNombre,$idEtiqueta);
}

//ELIMINAR ETIQUETA
public function etiquetaBorrar()
{

  $idCarpetaSecundario = $_POST['idCarpetaSecundario'];
  $this->modelo->eliminarEtiquetaBase($idCarpetaSecundario);
}




//LLAVE FINAL
}

