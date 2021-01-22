<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class Dashboard 
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



      //FUNCION PARA LLENAR GRAFICA 1 DE DASHBOARD
  public function obtenerSeguimientoGrafica()
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

      $datos=array();

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

     $borradores=$porcentajeBorradores;
     $eliminados=$porcentajeEliminados;
     $enviados=$porcentajeEnviados;
     $papelera=$porcentajePapelera;
     $programados=$porcentajeProgramados;

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

     echo json_encode($datos);

   }
   catch(Exception $e)
   {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}


  //FUNCION PARA LLENAR GRAFICA 2 DE DASHBOARD
public function obtenerCorreos()
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


   echo json_encode($datos);

 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

 //FUNCION PARA LLENAR GRAFICA 3 DASH, GRUPOS NIVELES
public function obtenerGruposNiveles()
{
  try
  {
    $gruposPuesto=array();
    $datosGrupoPues=array();

      //Sentencia SQL para selección de datos.
    $gruposPues = $this->pdo->prepare("SELECT * FROM grupospuesto WHERE estatus=1");
      //Ejecución de la sentencia SQL.
    $gruposPues->execute();
    while ($fila = $gruposPues->fetch(PDO::FETCH_ASSOC)) {
      $nombreGrupoPuesto=$fila['nombreGrupoPuesto'];

      $gruposPuesto[] = array('nombreGrupoPuesto' => $nombreGrupoPuesto);
    }

    foreach ($gruposPuesto as $grupoPues) 
    {
      $grupo=$grupoPues['nombreGrupoPuesto'];
      $buscarGrupo = $this->pdo->prepare("SELECT count(grupoDestinatario),grupoDestinatario FROM correo where grupoDestinatario='$grupo'");
            //Ejecución de la sentencia SQL.
      $buscarGrupo->execute();
      $res=$buscarGrupo->fetch(PDO::FETCH_ASSOC);
      $total=$res['count(grupoDestinatario)'];
      $datosGrupoPues[] = array('grupo' => $grupo,'total' => $total);
    }

    echo json_encode($datosGrupoPues);

  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}

 //FUNCION PARA LLENAR DASH, GRUPOS CREADOS POR USUARIOS
public function obtenerGruposUsuarios()
{
  try
  {
    $grupos=array();
    $datosGrupo=array();

      //Sentencia SQL para selección de datos.
    $gruposquery = $this->pdo->prepare("SELECT * FROM grupo WHERE estatusGrupo=1");
      //Ejecución de la sentencia SQL.
    $gruposquery->execute();
    while ($fila = $gruposquery->fetch(PDO::FETCH_ASSOC)) {
      $nombreGrupo=$fila['nombre_grupo'];

      $grupos[] = array('nombreGrupo' => $nombreGrupo);
    }

    foreach ($grupos as $grupoPues) 
    {
      $grupo=$grupoPues['nombreGrupo'];
      $buscarGrupo = $this->pdo->prepare("SELECT count(grupoDestinatario),grupoDestinatario FROM correo where grupoDestinatario='$grupo'");
            //Ejecución de la sentencia SQL.
      $buscarGrupo->execute();
      $res=$buscarGrupo->fetch(PDO::FETCH_ASSOC);
      $total=$res['count(grupoDestinatario)'];
      $datosGrupo[] = array('grupo' => $grupo,'total' => $total);
    }

    echo json_encode($datosGrupo);

  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}

 //FUNCION PARA LLENAR GRAFICAS POR RANGO DE FECHAS
public function obtenerInfoFechas($fechaInicio,$fechaFin)
{
  try
  {
    // var_export($fechaInicio);
    // var_dump($fechaFin);

    $datosCorreo=array();

              //Sentencia SQL para selección de datos.
    $correosFechas = $this->pdo->prepare("SELECT idCorreo,DATE_FORMAT(fechac,'%Y/%m/%d') AS fechac FROM correo");
            //Ejecución de la sentencia SQL.
    $correosFechas->execute();

    while ($correos = $correosFechas->fetch(PDO::FETCH_ASSOC)) {
      $idCorreo=$correos['idCorreo'];
      $fechaCorreo=$correos['fechac'];

      $datosCorreo[] = array('idCorreo' => $idCorreo,'fechaCorreo' => $fechaCorreo);
    }
    var_dump($datosCorreo);
    foreach ($datosCorreo as $fecha) 
    {
       if( $fechaInicio>= $fecha['fechaCorreo'] && $fechaFin<=$fecha['fechaCorreo'])
       {
        var_dump($fecha['idCorreo']);
       }
       else
       {
        var_dump("no entro");
       }
      // $correosFechas = $this->pdo->prepare("SELECT * FROM correo");
      // $correosFechas->execute();

    }

  //   $grupos=array();
  //   $datosGrupo=array();

  //     //Sentencia SQL para selección de datos.
  //   $gruposquery = $this->pdo->prepare("SELECT * FROM grupo WHERE estatusGrupo=1");
  //     //Ejecución de la sentencia SQL.
  //   $gruposquery->execute();
  //   while ($fila = $gruposquery->fetch(PDO::FETCH_ASSOC)) {
  //     $nombreGrupo=$fila['nombre_grupo'];

  //     $grupos[] = array('nombreGrupo' => $nombreGrupo);
  //   }

  //   foreach ($grupos as $grupoPues) 
  //   {
  //     $grupo=$grupoPues['nombreGrupo'];
  //     $buscarGrupo = $this->pdo->prepare("SELECT count(grupoDestinatario),grupoDestinatario FROM correo where grupoDestinatario='$grupo'");
  //           //Ejecución de la sentencia SQL.
  //     $buscarGrupo->execute();
  //     $res=$buscarGrupo->fetch(PDO::FETCH_ASSOC);
  //     $total=$res['count(grupoDestinatario)'];
  //      $datosGrupo[] = array('grupo' => $grupo,'total' => $total);
  //   }
    
  // echo json_encode($datosGrupo);

  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}



}