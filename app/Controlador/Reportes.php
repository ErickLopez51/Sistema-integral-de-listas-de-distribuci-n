<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/Reporte.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class Reportes
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
        $this->modelo = new Reporte();
  }

  public function MainReportes()
  { 
     require_once 'Vista/Header.php';
     require_once 'Vista/Reportes/MainReporte.php';  
     require_once 'Vista/Footer.php';   

 }

 public function Reporte1()
 {
    require_once 'Vista/Header.php';
     require_once 'Vista/Reportes/Reporte1.php';  
     require_once 'Vista/Footer.php';   
 }

 public function Reporte2()
 {
    require_once 'Vista/Header.php';
     require_once 'Vista/Reportes/Reporte2.php';  
     require_once 'Vista/Footer.php';   
     // $correosAreas=$this->modelo->obtenerDatosTablaReporte2();
 }

 public function Reporte3()
 {
    require_once 'Vista/Header.php';
     require_once 'Vista/Reportes/Reporte3.php';  
     require_once 'Vista/Footer.php';   
 }

//TABLA DE REPORTE 1
 public function tablaReporteSeguimiento()
 { 

  $correoSeguimiento=$this->modelo->obtenerCorreosSeguimiento();
 }

//REPORTE 1 EN PDF
 public function crearReporte1PDF()
 { 

     $datosCorreo=$this->modelo->reporte1PDF(); 
     var_dump($datosCorreo);
   require_once 'Vista/Reportes/Reporte1PDF.php'; 
}

//TABLA DE REPORTE 2
  public function tablaReporte2()
 { 

  $correosAreas=$this->modelo->obtenerDatosTablaReporte2();
 }


//REPORTE 2 EN PDF 
  public function crearReporte2PDF()
 { 

     $datosCorreos=$this->modelo->reporte2PDF(); 
   require_once 'Vista/Reportes/Reporte2PDF.php'; 
}





}