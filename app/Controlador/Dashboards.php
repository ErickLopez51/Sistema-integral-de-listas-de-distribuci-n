<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/Dashboard.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class Dashboards
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
       $this->modelo = new Dashboard();
  }

  public function MainDash()
  { 

     require_once 'Vista/Dashboard/MainDashboard.php';    
 }

//GRAFICA 1 SEGUIMIENTO DE CORREO
  public function graficaSeguimiento()
 {
 $datos=$this->modelo->obtenerSeguimientoGrafica();  
 }

 //GRAFICA 2 CORREOS POR ÁREA
  public function graficaCorreos()
 { 

  $correosAreas=$this->modelo->obtenerCorreos();
 }

 //GRAFICA 3 CORREOS POR PUESTO DE NIVEL
 public function graficaGrupoNiveles()
 { 

  $correosGrupoPuesto=$this->modelo->obtenerGruposNiveles();

 } 

  //GRAFICA CORREOS POR GRUPOS CREADOS POR USUARIOS
 public function graficaGrupoUsuarios()
 { 

  $correosGrupo=$this->modelo->obtenerGruposUsuarios();

 }


  //GRAFICA CORREOS POR RANGO DE FECHAS
 public function graficaFechas()
 { 
  $fechaInicio=$_POST['fecha1'];
  $fechaFin=$_POST['fecha2'];

  $correosFechas=$this->modelo->obtenerInfoFechas($fechaInicio,$fechaFin);

 } 
 





}