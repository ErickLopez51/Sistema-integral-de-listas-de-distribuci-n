<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class GestionarCorreo 
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


    //FUNCION PARA LLENAR LA TABLA DE TODOS LOS CORREOS
public function obtenerCorreosTodos()
{
  try
  {


            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM correo ORDER BY fechac DESC");
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


      // //BUSCAR SEGUIMIENTO DE CORREO
      // $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus='$idEstatus'");
      // $buscarSeguimiento->execute();

      // while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {

      //  $idSeguimiento_correo=$filaSeguimiento['idSeguimiento_correo'];


       $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

       $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

       $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC,  'etiqueta' => $etiqueta);

     // }

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




//     //FUNCION PARA LLENAR LA TABLA DE CORREOS ELIMINADOS
// public function obtenerCorreosEliminados($idEstatus)
// {

//   try
//   {


//             //Sentencia SQL para selección de datos.
//     $stm = $this->pdo->prepare("SELECT * FROM correo");
//             //Ejecución de la sentencia SQL.
//     $stm->execute();
//     $datos=array();
//     $datosSeguimiento=array();
//     $dataIdCorreo=array();
//     $datosEtiqueta=array();
//     $etiqueta="<td><div class='col text-center'><i>Sin etiqueta</i></div></td>";
//     while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

//       $idCorreo=base64_encode($row['idCorreo']);
//       $idCorreoSecundario=$row['idCorreo'];      
//       $asunto=$row['asunto'];
//       $grupoDestinatario=$row['grupoDestinatario'];
//        // var_dump($idCorreoSecundario);

//       $dataIdCorreo[] = array('idCorreoSecundario' => $idCorreoSecundario,'idCorreo' => $idCorreo,'asunto' => $asunto,'grupoDestinatario' => $grupoDestinatario);

//     }


//     if (!empty($dataIdCorreo)) {

//       for ($i=0;  $i < sizeof($dataIdCorreo) ; $i++) { 

//         $idCorreo=$dataIdCorreo[$i]['idCorreoSecundario'];

//               //BUSCAR ETIQUETA DE CORREO
//         $buscarEtiqueta = $this->pdo->prepare("SELECT * FROM carpeta_correo WHERE idUsuarioCarpetaCorreo='$idEmpleado' AND Correo_idCorreo='$idCorreo' AND carpetaEstatus=1");
//         $buscarEtiqueta->execute();

//         while ($filaEtiquetas = $buscarEtiqueta->fetch(PDO::FETCH_ASSOC)) {
//          $idEtiqueta=$filaEtiquetas['idCarpeta'];
//          $idCorreoEtiqueta=$filaEtiquetas['Correo_idCorreo'];
//         //var_dump($idEtiqueta);

//          $etiqueta = $this->pdo->prepare("SELECT * FROM carpeta WHERE idCarpeta='$idEtiqueta' AND estatusCarpeta=1");
//          $etiqueta->execute();
//          $resultadoEtiqueta=$etiqueta->fetch(PDO::FETCH_ASSOC);

//          $nombreEtiqueta=$resultadoEtiqueta['nombre_carpeta'];

//          $datosEtiqueta[] = array('idCorreoEtiqueta' => $idCorreoEtiqueta, 'nombreEtiqueta' => $nombreEtiqueta);
//        }


//        if (!empty($datosEtiqueta)) {
//          for ($x=0;  $x < sizeof($datosEtiqueta); $x++) { 

//           $idCorreoEtiqueta=$datosEtiqueta[$x]['idCorreoEtiqueta'];
//           $nombreEtiqueta=$datosEtiqueta[$x]['nombreEtiqueta'];
//           if ($idCorreo==$idCorreoEtiqueta) {

//             $etiqueta="<td><div class='col text-center'><b>".$nombreEtiqueta."</b></div></td>";

//           }
//         }
//       }


//       //BUSCAR SEGUIMIENTO DE CORREO
//       $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus='$idEstatus'");
//       $buscarSeguimiento->execute();

//       while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {

//        $idSeguimiento_correo=$filaSeguimiento['idSeguimiento_correo'];


//        $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

//        $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

//        $BotonEliminar="<td><div class='col text-center'><button onclick='alertaBajaCorreoE(".$dataIdCorreo[$i]['idCorreoSecundario'].");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

//        $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC,  'etiqueta' => $etiqueta,'BotonEliminar' => $BotonEliminar);

//      }

//    }
//  }


//  $tabla = array(
//    "data"       =>  $datos

//  );

//  echo json_encode($tabla);

// }
// catch(Exception $e)
// {
//             //Obtener mensaje de error.
//   die($e->getMessage());
// }
// }





}