<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class Reporte
{
	protected static $cnx; 
    //Atributo para conexión a SGBD
  private $pdo;

    //Método de conexión a SGBD.
  public function __CONSTRUCT()
  {
    try
    {
      $this->pdo = Base::Conectar();
    }
    catch(Exception $e)
    {
      die($e->getMessage());
    }
  }

  private static function getConexion()
  {
    self::$cnx = Conexion::conectar();
  }

  private static function desconectar()
  {
    self::$cnx = null;
  }

  public function reporte1PDF()
  {
    try
    {
      $totalCorreos=0;
      $totalCorreosSeguimiento=0;
      $totalCorreosEliminados=0;
      $totalCorreosEnviados=0;
      $totalCorreosProgramados=0;
      $totalCorreosBorradores=0;
      $totalCorreosPapelera=0;

            //Sentencia SQL para selección de datos.
      $bucarCorreos = $this->pdo->prepare("SELECT * FROM correo");
            //Ejecución de la sentencia SQL.
      $bucarCorreos->execute();

      while ($filasCorreo = $bucarCorreos->fetch(PDO::FETCH_ASSOC)) {
       $idCorreo = $filasCorreo['idCorreo'];
       $totalCorreos++;
       $datosCorreo[] = array('idCorreo' => $idCorreo);
     }


      //TOTAL DE REGISTROS EN EL SEGUIMIENTO DE CORREO 

     $correosSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo");
     $correosSeguimiento->execute();

     while ($row = $correosSeguimiento->fetch(PDO::FETCH_ASSOC)) {
       $totalCorreosSeguimiento++;
     } 

     //BUSCAR CORREOS ELIMINADOS 

     $correosEliminados = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=0");
     $correosEliminados->execute();

     while ($row = $correosEliminados->fetch(PDO::FETCH_ASSOC)) {
       $totalCorreosEliminados++;
     } 


     //BUSCAR CORREOS ENVIADOS

     $correosEnviados = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=1");
     $correosEnviados->execute();

     while ($row = $correosEnviados->fetch(PDO::FETCH_ASSOC)) {
       $totalCorreosEnviados++;
     }  


     //BUSCAR CORREOS PROGRAMADOS

     $correosProgramados = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=2");
     $correosProgramados->execute();

     while ($row = $correosProgramados->fetch(PDO::FETCH_ASSOC)) {
       $totalCorreosProgramados++;
     }  

         //BUSCAR CORREOS BORRADORES

     $correosBorradores = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=3");
     $correosBorradores->execute();

     while ($row = $correosBorradores->fetch(PDO::FETCH_ASSOC)) {
       $totalCorreosBorradores++;
     }  

         //BUSCAR CORREOS EN PAPELERA

     $correosPapelera = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=4");
     $correosPapelera->execute();

     while ($row = $correosPapelera->fetch(PDO::FETCH_ASSOC)) {
       $totalCorreosPapelera++;
     }  
     //CREAR ARRAY PARA GUARDAR LOS PORCENTAJES
     $porcentajeEliminados=round ((100 * $totalCorreosEliminados) / $totalCorreosSeguimiento);
     $porcentajeEnviados=round ((100 * $totalCorreosEnviados) / $totalCorreosSeguimiento);
     $porcentajeProgramados=round ((100 * $totalCorreosProgramados) / $totalCorreosSeguimiento);
     $porcentajeBorradores=round ((100 * $totalCorreosBorradores) / $totalCorreosSeguimiento);
     $porcentajePapelera=round ((100 * $totalCorreosPapelera) / $totalCorreosSeguimiento);

     $borradores=$porcentajeBorradores." %";
     $eliminados=$porcentajeEliminados." %";
     $enviados=$porcentajeEnviados." %";
     $papelera=$porcentajePapelera." %";
     $programados=$porcentajeProgramados." %";

     $Borrador="Borrador";
     $Eliminado="Eliminado";
     $Enviado="Enviado";
     $Papelera="Papelera";
     $Programado="Programado";

     $dataPorcentaje=array($borradores,$eliminados,$enviados,$papelera,$programados);

     $dataTotal=array('totalCorreosBorradores' => $totalCorreosBorradores,'totalCorreosEliminados' => $totalCorreosEliminados,'totalCorreosEnviados' => $totalCorreosEnviados,'totalCorreosPapelera' => $totalCorreosPapelera,'totalCorreosProgramados' => $totalCorreosProgramados);

     $datosestatus=array( $Borrador,$Eliminado, $Enviado,$Papelera,$Programado);

     $cont=0;
     $count=0;

     foreach ($dataTotal as $total) {

       $datos[] = array('estatus' => $datosestatus[$count++],'porcentaje' => $dataPorcentaje[$cont++],'total' => $total);

     }

     return $datos;

   }
   catch(Exception $e)
   {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}


    //LLENAR DATATABLE DE REPORTE 1
public function obtenerCorreosSeguimiento()
{
  try
  {
    $totalCorreos=0;
    $totalCorreosSeguimiento=0;
    $totalCorreosEliminados=0;
    $totalCorreosEnviados=0;
    $totalCorreosProgramados=0;
    $totalCorreosBorradores=0;
    $totalCorreosPapelera=0;

            //Sentencia SQL para selección de datos.
    $bucarCorreos = $this->pdo->prepare("SELECT * FROM correo");
            //Ejecución de la sentencia SQL.
    $bucarCorreos->execute();

    while ($filasCorreo = $bucarCorreos->fetch(PDO::FETCH_ASSOC)) {
     $idCorreo = $filasCorreo['idCorreo'];
     $totalCorreos++;
     $datosCorreo[] = array('idCorreo' => $idCorreo);
   }

     //TOTAL DE REGISTROS EN EL SEGUIMIENTO DE CORREO 

   $correosSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo");
   $correosSeguimiento->execute();

   while ($row = $correosSeguimiento->fetch(PDO::FETCH_ASSOC)) {
     $totalCorreosSeguimiento++;
   } 

     //BUSCAR CORREOS ELIMINADOS 

   $correosEliminados = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=0");
   $correosEliminados->execute();

   while ($row = $correosEliminados->fetch(PDO::FETCH_ASSOC)) {
     $totalCorreosEliminados++;
   } 


     //BUSCAR CORREOS ENVIADOS

   $correosEnviados = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=1");
   $correosEnviados->execute();

   while ($row = $correosEnviados->fetch(PDO::FETCH_ASSOC)) {
     $totalCorreosEnviados++;
   }  


     //BUSCAR CORREOS PROGRAMADOS

   $correosProgramados = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=2");
   $correosProgramados->execute();

   while ($row = $correosProgramados->fetch(PDO::FETCH_ASSOC)) {
     $totalCorreosProgramados++;
   }  

         //BUSCAR CORREOS BORRADORES

   $correosBorradores = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=3");
   $correosBorradores->execute();

   while ($row = $correosBorradores->fetch(PDO::FETCH_ASSOC)) {
     $totalCorreosBorradores++;
   }  

         //BUSCAR CORREOS EN PAPELERA

   $correosPapelera = $this->pdo->prepare("SELECT * FROM seguimiento_correo where Estatus_idEstatus=4");
   $correosPapelera->execute();

   while ($row = $correosPapelera->fetch(PDO::FETCH_ASSOC)) {
     $totalCorreosPapelera++;
   }  
     //CREAR ARRAY PARA GUARDAR LOS PORCENTAJES
   $porcentajeEliminados=round ((100 * $totalCorreosEliminados) / $totalCorreosSeguimiento);
   $porcentajeEnviados=round ((100 * $totalCorreosEnviados) / $totalCorreosSeguimiento);
   $porcentajeProgramados=round ((100 * $totalCorreosProgramados) / $totalCorreosSeguimiento);
   $porcentajeBorradores=round ((100 * $totalCorreosBorradores) / $totalCorreosSeguimiento);
   $porcentajePapelera=round ((100 * $totalCorreosPapelera) / $totalCorreosSeguimiento);

   $borradores=$porcentajeBorradores." %";
   $eliminados=$porcentajeEliminados." %";
   $enviados=$porcentajeEnviados." %";
   $papelera=$porcentajePapelera." %";
   $programados=$porcentajeProgramados." %";
   
   $Borrador="Borrador";
   $Eliminado="Eliminado";
   $Enviado="Enviado";
   $Papelera="Papelera";
   $Programado="Programado";

   $dataPorcentaje=array($borradores,$eliminados,$enviados,$papelera,$programados);

   $dataTotal=array('totalCorreosBorradores' => $totalCorreosBorradores,'totalCorreosEliminados' => $totalCorreosEliminados,'totalCorreosEnviados' => $totalCorreosEnviados,'totalCorreosPapelera' => $totalCorreosPapelera,'totalCorreosProgramados' => $totalCorreosProgramados);

   $datosestatus=array( $Borrador,$Eliminado, $Enviado,$Papelera,$Programado);

   $cont=0;
   $count=0;

   foreach ($dataTotal as $total) {

     $datos[] = array('estatus' => $datosestatus[$count++],'porcentaje' => $dataPorcentaje[$cont++],'total' => $total);

   }  


   $tabla = array(
     "data"       =>  $datos
   );


   echo json_encode($tabla);

 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}



//LLENAR DATTABLE PARA EL REPORTE 2
public function obtenerDatosTablaReporte2()
{
  try
  {

    $totalCorreos=0;
              //Sentencia SQL para selección de datos.
    $cantCorreos = $this->pdo->prepare("SELECT * FROM correo");
            //Ejecución de la sentencia SQL.
    $cantCorreos->execute();

    $datosCorreo=array();

    while ($correos = $cantCorreos->fetch(PDO::FETCH_ASSOC)) {
      $totalCorreos++;
    }

            //Sentencia SQL para selección de datos.
    $bucarCorreos = $this->pdo->prepare("SELECT * FROM correo");
            //Ejecución de la sentencia SQL.
    $bucarCorreos->execute();

    $datosCorreo=array();

    while ($filasCorreo = $bucarCorreos->fetch(PDO::FETCH_ASSOC)) {

     $grupoDestinatario = $filasCorreo['grupoDestinatario'];
                        //Sentencia SQL para selección de datos.
     $buscarGrupo = $this->pdo->prepare("SELECT count(grupoDestinatario) FROM correo where grupoDestinatario='$grupoDestinatario'");
            //Ejecución de la sentencia SQL.
     $buscarGrupo->execute();
     $cantidad=$buscarGrupo->fetch(PDO::FETCH_ASSOC);
     $total=$cantidad['count(grupoDestinatario)'];
     $resultado=round ((100 * $total) / $totalCorreos);
     $porcentaje=$resultado." %";

     $datosCorreo[] = array('grupoDestinatario' => $grupoDestinatario,'total' => $total,'porcentaje' => $porcentaje);
   }

   //ELIMINAR VALORES REPETIDOS EN EL ARREGLO
   $datos = array_values(array_unique($datosCorreo,SORT_REGULAR));

   $tabla = array(
     "data"       =>  $datos
   );


   echo json_encode($tabla);

 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}


public function reporte2PDF()
{
  try
  {

    $totalCorreos=0;
              //Sentencia SQL para selección de datos.
    $cantCorreos = $this->pdo->prepare("SELECT * FROM correo");
            //Ejecución de la sentencia SQL.
    $cantCorreos->execute();

    $datosCorreo=array();

    while ($correos = $cantCorreos->fetch(PDO::FETCH_ASSOC)) {
      $totalCorreos++;
    }

            //Sentencia SQL para selección de datos.
    $bucarCorreos = $this->pdo->prepare("SELECT * FROM correo");
            //Ejecución de la sentencia SQL.
    $bucarCorreos->execute();

    $datosCorreo=array();

    while ($filasCorreo = $bucarCorreos->fetch(PDO::FETCH_ASSOC)) {

     $grupoDestinatario = $filasCorreo['grupoDestinatario'];
                        //Sentencia SQL para selección de datos.
     $buscarGrupo = $this->pdo->prepare("SELECT count(grupoDestinatario) FROM correo where grupoDestinatario='$grupoDestinatario'");
            //Ejecución de la sentencia SQL.
     $buscarGrupo->execute();
     $cantidad=$buscarGrupo->fetch(PDO::FETCH_ASSOC);
     $total=$cantidad['count(grupoDestinatario)'];
     $resultado=round ((100 * $total) / $totalCorreos);
     $porcentaje=$resultado." %";

     $datosCorreo[] = array('grupoDestinatario' => $grupoDestinatario,'total' => $total,'porcentaje' => $porcentaje,'totalCorreos' => $totalCorreos);
   }

   //ELIMINAR VALORES REPETIDOS EN EL ARREGLO
   $datos = array_values(array_unique($datosCorreo,SORT_REGULAR));

   return $datos;
 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}




//LLAVE FINAL
}