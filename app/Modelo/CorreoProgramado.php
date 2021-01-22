<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class CorreoProgramado 
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

      //FUNCION PARA LLENAR LA TABLA DE CORREOS PROGRAMADOS
    //SI EL ESTATUS ES 4 SIGNIFICA QUE EL CORREO ESTA PROGRAMADO
public function obtenerCorreosProgramados()
{
  try
  {
       $idEmpleado=$_SESSION["usuario"]["idUsuario"];

            //Sentencia SQL para selección de datos.
    // $stm = $this->pdo->prepare("SELECT * FROM correo WHERE idUsuarioEnvioCorreo='$idEmpleado'");
        $stm = $this->pdo->prepare("SELECT * FROM correo,programarcorreos WHERE correo.idCorreo=programarcorreos.Correo_idCorreo and programarcorreos.estatusProgramar=1 and correo.idUsuarioEnvioCorreo='$idEmpleado'");
    
            //Ejecución de la sentencia SQL.
    $stm->execute();
    $datos=array();
    $datosSeguimiento=array();
    $dataIdCorreo=array();
    $datosEtiqueta=array();
    $etiqueta="<td><div class='col text-center'><i>Sin etiqueta</i></div></td>";
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

      $idCorreo=base64_encode($row['idCorreo']);
      $idCorreoSecundario=$row['idCorreo'];      
      $asunto=$row['asunto'];
      $grupoDestinatario=$row['grupoDestinatario'];
      $fechaEnvio="<td><div class='col text-center'>".$row['fechaProgramar']." ".$row['hora']."</div></td>";
       // var_dump($idCorreoSecundario);

      $dataIdCorreo[] = array('idCorreoSecundario' => $idCorreoSecundario,'idCorreo' => $idCorreo,'asunto' => $asunto,'grupoDestinatario' => $grupoDestinatario);

    }


    if (!empty($dataIdCorreo)) {

      for ($i=0;  $i < sizeof($dataIdCorreo) ; $i++) { 

        $idCorreo=$dataIdCorreo[$i]['idCorreoSecundario'];

              //BUSCAR ETIQUETA DE CORREO
        $buscarEtiqueta = $this->pdo->prepare("SELECT * FROM carpeta_correo WHERE idUsuarioCarpetaCorreo='$idEmpleado' AND Correo_idCorreo='$idCorreo' AND carpetaEstatus=1");
        $buscarEtiqueta->execute();

        while ($filaEtiquetas = $buscarEtiqueta->fetch(PDO::FETCH_ASSOC)) {
         $idEtiqueta=$filaEtiquetas['idCarpeta'];
         $idCorreoEtiqueta=$filaEtiquetas['Correo_idCorreo'];
        //var_dump($idEtiqueta);

         $etiqueta = $this->pdo->prepare("SELECT * FROM carpeta WHERE idCarpeta='$idEtiqueta' AND estatusCarpeta=1");
         $etiqueta->execute();
         $resultadoEtiqueta=$etiqueta->fetch(PDO::FETCH_ASSOC);

         $nombreEtiqueta=$resultadoEtiqueta['nombre_carpeta'];

         $datosEtiqueta[] = array('idCorreoEtiqueta' => $idCorreoEtiqueta, 'nombreEtiqueta' => $nombreEtiqueta);
       }


       if (!empty($datosEtiqueta)) {
         for ($x=0;  $x < sizeof($datosEtiqueta); $x++) { 

          $idCorreoEtiqueta=$datosEtiqueta[$x]['idCorreoEtiqueta'];
          $nombreEtiqueta=$datosEtiqueta[$x]['nombreEtiqueta'];
          if ($idCorreo==$idCorreoEtiqueta) {

            $etiqueta="<td><div class='col text-center'><b>".$nombreEtiqueta."</b></div></td>";

          }
        }
      }


      //BUSCAR SEGUIMIENTO DE CORREO
      $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=2 AND estatusSeguimiento=1");
      $buscarSeguimiento->execute();

      while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {

       $idSeguimiento_correo=$filaSeguimiento['idSeguimiento_correo'];


       $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

       $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

       $BotonEliminar="<td><div class='col text-center'><button onclick='alertaCancelarP(".$dataIdCorreo[$i]['idCorreoSecundario'].");' title='Cancelar envío' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-window-close'></i></button></div></td>";

       $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC, 'etiqueta' => $etiqueta,'fechaEnvio' => $fechaEnvio,'BotonEliminar' => $BotonEliminar);

     } 

   }
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

  //FUNCION PARA LLENAR LA TABLA DE CORREOS PROGRAMADOS
    //SI EL ESTATUS ES 4 SIGNIFICA QUE EL CORREO ESTA PROGRAMADO
public function obtenerTodos()
{
  try
  {
       $idEmpleado=$_SESSION["usuario"]["idUsuario"];

            //Sentencia SQL para selección de datos.
    // $stm = $this->pdo->prepare("SELECT * FROM correo WHERE idUsuarioEnvioCorreo='$idEmpleado'");
        $stm = $this->pdo->prepare("SELECT * FROM correo,programarcorreos WHERE correo.idCorreo=programarcorreos.Correo_idCorreo and programarcorreos.estatusProgramar=1");
    
            //Ejecución de la sentencia SQL.
    $stm->execute();
    $datos=array();
    $datosSeguimiento=array();
    $dataIdCorreo=array();
    $datosEtiqueta=array();
    $etiqueta="<td><div class='col text-center'><i>Sin etiqueta</i></div></td>";
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

      $idCorreo=base64_encode($row['idCorreo']);
      $idCorreoSecundario=$row['idCorreo'];      
      $asunto=$row['asunto'];
      $grupoDestinatario=$row['grupoDestinatario'];
      $fechaEnvio="<td><div class='col text-center'>".$row['fechaProgramar']." ".$row['hora']."</div></td>";
       // var_dump($idCorreoSecundario);

      $dataIdCorreo[] = array('idCorreoSecundario' => $idCorreoSecundario,'idCorreo' => $idCorreo,'asunto' => $asunto,'grupoDestinatario' => $grupoDestinatario);

    }


    if (!empty($dataIdCorreo)) {

      for ($i=0;  $i < sizeof($dataIdCorreo) ; $i++) { 

        $idCorreo=$dataIdCorreo[$i]['idCorreoSecundario'];

              //BUSCAR ETIQUETA DE CORREO
        $buscarEtiqueta = $this->pdo->prepare("SELECT * FROM carpeta_correo WHERE Correo_idCorreo='$idCorreo' AND carpetaEstatus=1");
        $buscarEtiqueta->execute();

        while ($filaEtiquetas = $buscarEtiqueta->fetch(PDO::FETCH_ASSOC)) {
         $idEtiqueta=$filaEtiquetas['idCarpeta'];
         $idCorreoEtiqueta=$filaEtiquetas['Correo_idCorreo'];
        //var_dump($idEtiqueta);

         $etiqueta = $this->pdo->prepare("SELECT * FROM carpeta WHERE idCarpeta='$idEtiqueta' AND estatusCarpeta=1");
         $etiqueta->execute();
         $resultadoEtiqueta=$etiqueta->fetch(PDO::FETCH_ASSOC);

         $nombreEtiqueta=$resultadoEtiqueta['nombre_carpeta'];

         $datosEtiqueta[] = array('idCorreoEtiqueta' => $idCorreoEtiqueta, 'nombreEtiqueta' => $nombreEtiqueta);
       }


       if (!empty($datosEtiqueta)) {
         for ($x=0;  $x < sizeof($datosEtiqueta); $x++) { 

          $idCorreoEtiqueta=$datosEtiqueta[$x]['idCorreoEtiqueta'];
          $nombreEtiqueta=$datosEtiqueta[$x]['nombreEtiqueta'];
          if ($idCorreo==$idCorreoEtiqueta) {

            $etiqueta="<td><div class='col text-center'><b>".$nombreEtiqueta."</b></div></td>";

          }
        }
      }


      //BUSCAR SEGUIMIENTO DE CORREO
      $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=2 AND estatusSeguimiento=1");
      $buscarSeguimiento->execute();

      while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {

       $idSeguimiento_correo=$filaSeguimiento['idSeguimiento_correo'];


       $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

       $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

       $BotonEliminar="<td><div class='col text-center'><button onclick='alertaCancelarP(".$dataIdCorreo[$i]['idCorreoSecundario'].");' title='Cancelar envío' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-window-close'></i></button></div></td>";

       $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC, 'etiqueta' => $etiqueta,'fechaEnvio' => $fechaEnvio,'BotonEliminar' => $BotonEliminar);

     } 

   }
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


//CANCELAR CORREO PROGRAMADO

public function CancelarCorreoProgramado($idCorreo)
{
  try
  {
   $cancelarCorreo = $this->pdo->prepare("UPDATE programarcorreos SET estatusProgramar = 0 WHERE Correo_idCorreo = '$idCorreo'");
            //Ejecución de la sentencia SQL.
   $cancelarCorreo->execute();

             //OBTENER FECHA ACTUAL
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');

    $buscarCorreo = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=2 AND estatusSeguimiento=1");
            //Ejecución de la sentencia SQL.
    $buscarCorreo->execute();
    $filasCorreo=$buscarCorreo->fetch(PDO::FETCH_ASSOC);

    $idSeguimiento_correo=$filasCorreo['idSeguimiento_correo'];

    $borrarCorreoEnviado = $this->pdo->prepare("UPDATE seguimiento_correo SET estatusSeguimiento=0 WHERE Correo_idCorreo ='$idCorreo' AND idSeguimiento_correo='$idSeguimiento_correo'");
    //Ejecución de la sentencia SQL.
    $borrarCorreoEnviado->execute();

       //GUARDAR EL SEGUIMIENTO DE CORREO
    $guardarSeguimiento = $this->pdo->prepare("INSERT INTO seguimiento_correo(Estatus_idEstatus, Correo_idCorreo, fechaActualizar, estatusSeguimiento) VALUES (3,'$idCorreo','$fecha_actual',1)");
    $guardarSeguimiento->execute();

 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

      //FUNCION PARA LLENAR LA TABLA DE CORREOS BORRADORES
    //SI EL ESTATUS ES 3 SIGNIFICA QUE EL CORREO ESTA EN BORRADOR
public function obtenerCorreosBorradores()
{

  try
  {

       $idEmpleado=$_SESSION["usuario"]["idUsuario"];

            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM correo WHERE idUsuarioEnvioCorreo='$idEmpleado'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
    $datos=array();
    $datosSeguimiento=array();
    $dataIdCorreo=array();
    $datosEtiqueta=array();
    $etiqueta="<td><div class='col text-center'><i>Sin etiqueta</i></div></td>";
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

      $idCorreo=base64_encode($row['idCorreo']);
      $idCorreoSecundario=$row['idCorreo'];      
      $asunto=$row['asunto'];
      $grupoDestinatario=$row['grupoDestinatario'];
       // var_dump($idCorreoSecundario);

      $dataIdCorreo[] = array('idCorreoSecundario' => $idCorreoSecundario,'idCorreo' => $idCorreo,'asunto' => $asunto,'grupoDestinatario' => $grupoDestinatario);

    }


    if (!empty($dataIdCorreo)) {

      for ($i=0;  $i < sizeof($dataIdCorreo) ; $i++) { 

        $idCorreo=$dataIdCorreo[$i]['idCorreoSecundario'];

              //BUSCAR ETIQUETA DE CORREO
        $buscarEtiqueta = $this->pdo->prepare("SELECT * FROM carpeta_correo WHERE idUsuarioCarpetaCorreo='$idEmpleado' AND Correo_idCorreo='$idCorreo' AND carpetaEstatus=1");
        $buscarEtiqueta->execute();

        while ($filaEtiquetas = $buscarEtiqueta->fetch(PDO::FETCH_ASSOC)) {
         $idEtiqueta=$filaEtiquetas['idCarpeta'];
         $idCorreoEtiqueta=$filaEtiquetas['Correo_idCorreo'];
        //var_dump($idEtiqueta);

         $etiqueta = $this->pdo->prepare("SELECT * FROM carpeta WHERE idCarpeta='$idEtiqueta' AND estatusCarpeta=1");
         $etiqueta->execute();
         $resultadoEtiqueta=$etiqueta->fetch(PDO::FETCH_ASSOC);

         $nombreEtiqueta=$resultadoEtiqueta['nombre_carpeta'];

         $datosEtiqueta[] = array('idCorreoEtiqueta' => $idCorreoEtiqueta, 'nombreEtiqueta' => $nombreEtiqueta);
       }


       if (!empty($datosEtiqueta)) {
         for ($x=0;  $x < sizeof($datosEtiqueta); $x++) { 

          $idCorreoEtiqueta=$datosEtiqueta[$x]['idCorreoEtiqueta'];
          $nombreEtiqueta=$datosEtiqueta[$x]['nombreEtiqueta'];
          if ($idCorreo==$idCorreoEtiqueta) {

            $etiqueta="<td><div class='col text-center'><b>".$nombreEtiqueta."</b></div></td>";

          }
        }
      }


      //BUSCAR SEGUIMIENTO DE CORREO
      $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=3 AND estatusSeguimiento=1");
      $buscarSeguimiento->execute();

      while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {

       $idSeguimiento_correo=$filaSeguimiento['idSeguimiento_correo'];


       $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

       $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

       $BotonEliminar="<td><div class='col text-center'><button onclick='alertaEliminarBorrador(".$dataIdCorreo[$i]['idCorreoSecundario'].");' title='Cancelar envío' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

       $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC,  'etiqueta' => $etiqueta,'BotonEliminar' => $BotonEliminar);

     }

   }
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


//ELIMINAR CORREO BORRADORES

public function EliminarCorreoBorrador($idCorreo)
{
  try
  {
             //OBTENER FECHA ACTUAL
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');

    $buscarCorreo = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=3 AND estatusSeguimiento=1");
            //Ejecución de la sentencia SQL.
    $buscarCorreo->execute();
    $filasCorreo=$buscarCorreo->fetch(PDO::FETCH_ASSOC);

    $idSeguimiento_correo=$filasCorreo['idSeguimiento_correo'];

    $borrarCorreoEnviado = $this->pdo->prepare("UPDATE seguimiento_correo SET estatusSeguimiento=0 WHERE Correo_idCorreo ='$idCorreo' AND idSeguimiento_correo='$idSeguimiento_correo'");
    //Ejecución de la sentencia SQL.
    $borrarCorreoEnviado->execute();

       //GUARDAR EL SEGUIMIENTO DE CORREO
    $guardarSeguimiento = $this->pdo->prepare("INSERT INTO seguimiento_correo(Estatus_idEstatus, Correo_idCorreo, fechaActualizar, estatusSeguimiento) VALUES (4,'$idCorreo','$fecha_actual',1)");
    $guardarSeguimiento->execute();

 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}


//LLAVE FINAL
}


