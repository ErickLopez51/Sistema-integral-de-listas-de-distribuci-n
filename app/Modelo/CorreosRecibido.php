<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class CorreosRecibido 
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

    //FUNCION PARA LLENAR LA TABLA DE CORREOS RECIBIDOS
    //SI EL ESTATUS ES 1 SIGNIFICA QUE ES RECIBIDO
  public function obtenerCorreosRecibidos()
  {

    try
    {

      $idEmpleado=$_SESSION["usuario"]["Empleado_idRfc"];
      $idUsuario=$_SESSION["usuario"]["idUsuario"];
      $idCorreos = array();
      $datos = array();

            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT * FROM destinatario WHERE Empleado_idRfc='$idEmpleado'");
      $stm->execute();

      while ($fila = $stm->fetch(PDO::FETCH_ASSOC)) {

        $idCorreo=$fila['idCorreo'];
        $idCorreos[] = array('idCorreo' => $idCorreo);

      }

      foreach ($idCorreos as $valor) {
        $idCorreo=$valor['idCorreo'];

        $infoCorreo = $this->pdo->prepare("SELECT * FROM seguimiento_correo,correo WHERE seguimiento_correo.Correo_idCorreo=correo.idCorreo  AND idCorreo='$idCorreo' AND idUsuarioEnvioCorreo <>'$idUsuario' AND Estatus_idEstatus=1 AND estatusSeguimiento=1 ORDER BY fechac DESC");
        $infoCorreo->execute();

         while ($row = $infoCorreo->fetch(PDO::FETCH_ASSOC)) {
        $idUsuarioCorreo=$row['idUsuarioEnvioCorreo'];
         $infousuario = $this->pdo->prepare("SELECT * FROM usuario,empleado WHERE usuario.Empleado_idRfc=empleado.idRfc AND idUsuario='$idUsuarioCorreo'");
         $infousuario->execute();
         $resUsuario=$infousuario->fetch(PDO::FETCH_ASSOC);
          $nombre = $resUsuario['nombre']." ".$resUsuario['ap']." ".$resUsuario['am'];

        $idCorreo=base64_encode($row['idCorreo']);
        $idCorreoSecundario=$row['idCorreo'];
        $asunto=$row['asunto'];
        $descripcion=$row['grupoDestinatario'];

        $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$idCorreo."' title='Ver correo'>De: ".$nombre."</a></div></td>";

        $asuntoC="<td><div class='col text-center'>".$asunto."</div></td>";

        $BotonEliminar="<td><div class='col text-center'><button onclick='alertaBajaCorreoR(".$idCorreoSecundario.");' title='Eliminar correo' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

        $datos[] = array('enlaceCorreo' => $enlaceCorreo, 'asuntoC' => $asuntoC,'BotonEliminar' => $BotonEliminar);

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

//ELIMINAR CORREO BANDEJA DE ENTREADA

  public function eliminarCorreoRecibido($idCorreo)
  {
    try
    {
     $borrarCorreoRecibido = $this->pdo->prepare("UPDATE correo SET estatus = 4 WHERE idCorreo = '$idCorreo'");
            //Ejecución de la sentencia SQL.
     $borrarCorreoRecibido->execute();
   }
   catch(Exception $e)
   {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}




//LLAVE FINAL
}
