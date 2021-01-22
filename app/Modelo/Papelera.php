<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class Papelera 
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

        //FUNCION PARA LLENAR LA TABLA DE LA PAPELERA
    //SI EL ESTATUS ES 4 SIGNIFICA QUE ESTA EN LA PAPELERA
  public function obtenerCorreosPapelera()
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
          $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=4 AND estatusSeguimiento=1");
          $buscarSeguimiento->execute();

          while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {

           $idSeguimiento_correo=$filaSeguimiento['idSeguimiento_correo'];
           // var_dump($idSeguimiento_correo);
           // var_dump($dataIdCorreo[$i]['asunto']);

           $enlaceCorreo="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

           $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

         // $BotonRestablecer="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCorreo."'title='Editar información' class='btn btn-warning btn-circle'><i class='fas fa-trash-restore'></i></a></div></td>";

           $BotonEliminar="<td><div class='col text-center'><button onclick='alertaDefiCorreo(".$dataIdCorreo[$i]['idCorreoSecundario'].");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

           $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC,'BotonEliminar' => $BotonEliminar);

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

//ELIMINAR CORREO DEFINITIVAMENTE DE LA PAPELERA

public function eliminarCorreoPapelera($idCorreo)
{
  try
  {

   //OBTENER FECHA ACTUAL
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');

    $buscarCorreo = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=4 AND estatusSeguimiento=1");
            //Ejecución de la sentencia SQL.
    $buscarCorreo->execute();
    $filasCorreo=$buscarCorreo->fetch(PDO::FETCH_ASSOC);

    $idSeguimiento_correo=$filasCorreo['idSeguimiento_correo'];

    $borrarCorreoEnviado = $this->pdo->prepare("UPDATE seguimiento_correo SET estatusSeguimiento=0 WHERE Correo_idCorreo ='$idCorreo' AND idSeguimiento_correo='$idSeguimiento_correo'");
    //Ejecución de la sentencia SQL.
    $borrarCorreoEnviado->execute();

       //GUARDAR EL SEGUIMIENTO DE CORREO
    $guardarSeguimiento = $this->pdo->prepare("INSERT INTO seguimiento_correo(Estatus_idEstatus, Correo_idCorreo, fechaActualizar, estatusSeguimiento) VALUES (0,'$idCorreo','$fecha_actual',1)");
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


// $idEmpleado=$_SESSION["usuario"]["idUsuario"];

//             //Sentencia SQL para selección de datos.
// $stm = $this->pdo->prepare("SELECT * FROM correo WHERE idUsuarioEnvioCorreo='$idEmpleado'");

//             //Ejecución de la sentencia SQL.
// $stm->execute();
// $datosSeguimiento=array();
// $etiqueta="<td><div class='col text-center'><i>Sin etiqueta</i></div></td>";
// while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

//   $idCorreo=base64_encode($row['idCorreo']);
//   $idCorreoSecundario=$row['idCorreo'];      
//   $asunto=$row['asunto'];
//   $grupoDestinatario=$row['grupoDestinatario'];
//        // var_dump($idCorreoSecundario);

//   $dataIdCorreo[] = array('idCorreoSecundario' => $idCorreoSecundario,'idCorreo' => $idCorreo,'asunto' => $asunto,'grupoDestinatario' => $grupoDestinatario);

// }

// if (!empty($dataIdCorreo)) {

//   for ($i=0;  $i < sizeof($dataIdCorreo) ; $i++) { 

//     $idCorreo=$dataIdCorreo[$i]['idCorreoSecundario'];

//     //BUSCAR ETIQUETA DE CORREO
//     $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=4 AND estatusSeguimiento=1");
//     $buscarSeguimiento->execute();

//     while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {
//      $idCorreoSecundario=$filaSeguimiento['idCorreoSecundario'];
//      $idCorreoSeguimiento=$filaSeguimiento['Correo_idCorreo'];

//      $datosSeguimiento[] = array('idCorreoSecundario' => $idCorreoSecundario, 'idCorreoSeguimiento' => $idCorreoSeguimiento);
//    }

//    var_dump($datosSeguimiento);

//    if (!empty($datosSeguimiento)) {
//      for ($x=0;  $x < sizeof($datosSeguimiento); $x++) { 

//       $idCorreoSeguimiento=$datosSeguimiento[$x]['idCorreoSeguimiento'];
//       $nombreEtiqueta=$datosSeguimiento[$x]['nombreEtiqueta'];
//       if ($idCorreo==$idCorreoSeguimiento) {


//         $enlaceCorreo="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCorreo."' title='Ver correo'>".$grupoDestinatario."</a></div></td>";

//         $asuntoC="<td><div class='col text-center'>".$asunto."</div></td>";

//          // $BotonRestablecer="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCorreo."'title='Editar información' class='btn btn-warning btn-circle'><i class='fas fa-trash-restore'></i></a></div></td>";

//         $BotonEliminar="<td><div class='col text-center'><button onclick='alertaDefiCorreo(".$idCorreoSecundario.");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

//         $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC,'BotonEliminar' => $BotonEliminar);

//       }

//       $tabla = array(
//        "data"       =>  $datos

//      );

//       echo json_encode($tabla);

//       }
//     }
//   }

//   $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

//   $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

//      // $etiqueta="<td><div class='col text-center'><b>Sin etiqueta</b></div></td>";

//   $BotonEliminar="<td><div class='col text-center'><button onclick='alertaBajaCorreoE(".$dataIdCorreo[$i]['idCorreoSecundario'].");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

//   $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC,  'etiqueta' => $etiqueta,'BotonEliminar' => $BotonEliminar);


// }


// $tabla = array(
//  "data"       =>  $datos

// );


// echo json_encode($tabla);
// }