<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class GestionarEtiqueta 
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

          //FUNCION PARA MOSTRAR TODAS LAS ETIQUETAS
public function obtenerTodasEtiquetas()
{

  try
  {


            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM carpeta WHERE estatusCarpeta=1");

            //Ejecución de la sentencia SQL.
    $stm->execute();
    $datos = array();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

      $idCarpeta=base64_encode($row['idCarpeta']);
      $idCarpetaSecundario=$row['idCarpeta'];
      $nombreCarpeta=$row['nombre_carpeta'];
      $fecha_registro=$row['fecha_registro'];

      // $enlaceCorreo="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCorreo."' title='Ver correo'>".$descripcion."</a></div></td>";

      $nombreCarpeta="<td><div class='col text-center'>".$nombreCarpeta."</div></td>";

      $fechaCreacion="<td><div class='col text-center'>".$fecha_registro."</div></td>";

         // $BotonVer="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCarpeta."' title='Editar información' class='btn btn-info  btn-circle'><i class='fas fa-folder-open'></i></a></div></td>";

           // $BotonEditar="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCarpeta."' title='Editar carpeta' class='btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></a></div></td>";

           $BotonEditar="<td><div class='col text-center'><button  id=".$idCarpeta." data-toggle='modal' data-target='#editarEtiqueta' title='Editar carpeta'class='editar btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></button></div></td>";

       $BotonEliminar="<td><div class='col text-center'><button onclick='eliminarEtiqueta(".$idCarpetaSecundario.");' title='Eliminar etiqueta' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

      $datos[] = array('nombreCarpeta' => $nombreCarpeta, 'fechaCreacion' => $fechaCreacion,'BotonEditar' => $BotonEditar,'BotonEliminar' => $BotonEliminar);

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


//BUSCAR ETIQUETAS POR USUSARIO Y CORREO

    public function EncontrarEmpleadoEtiqueta($dataString,$key)
    {
      try
      {

        $html = '';
        $idEmpleadoActual=$_SESSION["usuario"]["Empleado_idRfc"];

            //Sentencia SQL para selección de datos.

        $Empleado = $this->pdo->prepare('SELECT * FROM usuario,empleado WHERE empleado.idRfc=usuario.Empleado_idRfc AND nombre LIKE "%'.strip_tags($key).'%"');
            //Ejecución de la sentencia SQL.
        $Empleado->execute();
        while ($row = $Empleado->fetch(PDO::FETCH_ASSOC)) {
          
            $html .= '<div><a class="suggest-element" correo="'.$row['email'].'" data="'.$row['nombre'].' '.$row['ap'].' '.$row['am'].'" id="'.$row['idUsuario'].'">'.$row['nombre'].' '.$row['ap'].' '.$row['am'].'</a></div>';

        }
        echo $html;

    }
    catch(Exception $e)
    {
            //Obtener mensaje de error.
        die($e->getMessage());
    }

}

public function EncontrarCorreoEtiqueta($dataString,$key)
{
  try
  {

    $html = '';
    $idEmpleadoActual=$_SESSION["usuario"]["Empleado_idRfc"];

            //Sentencia SQL para selección de datos.

    $Empleado = $this->pdo->prepare('SELECT * FROM usuario,empleado WHERE empleado.idRfc=usuario.Empleado_idRfc AND email LIKE "%'.strip_tags($key).'%"');
            //Ejecución de la sentencia SQL.
    $Empleado->execute();
    while ($row = $Empleado->fetch(PDO::FETCH_ASSOC)) {
      
        $html .= '<div><a class="suggest-element" data="'.$row['email'].'" id="'.$row['idUsuario'].'">'.$row['email'].'</a></div>';

    }
    echo $html;

}
catch(Exception $e)
{
            //Obtener mensaje de error.
    die($e->getMessage());
}

}

          //FUNCION PARA MOSTRAR TODAS LAS ETIQUETAS
public function ObtenerEtiquetasPorUsuario($idEmpleado)
{

  try
  {


            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM carpeta WHERE estatusCarpeta=1 and idUsuarioCarpeta='$idEmpleado'");

            //Ejecución de la sentencia SQL.
    $stm->execute();
    $datos = array();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

      $idCarpeta=base64_encode($row['idCarpeta']);
      $idCarpetaSecundario=$row['idCarpeta'];
      $nombreCarpeta=$row['nombre_carpeta'];
      $fecha_registro=$row['fecha_registro'];

      // $enlaceCorreo="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCorreo."' title='Ver correo'>".$descripcion."</a></div></td>";

      $nombreCarpeta="<td><div class='col text-center'>".$nombreCarpeta."</div></td>";

      $fechaCreacion="<td><div class='col text-center'>".$fecha_registro."</div></td>";

         // $BotonVer="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCarpeta."' title='Editar información' class='btn btn-info  btn-circle'><i class='fas fa-folder-open'></i></a></div></td>";

           // $BotonEditar="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idCarpeta."' title='Editar carpeta' class='btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></a></div></td>";

           $BotonEditar="<td><div class='col text-center'><button  id=".$idCarpeta." data-toggle='modal' data-target='#editarEtiqueta' title='Editar carpeta'class='editar btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></button></div></td>";

       $BotonEliminar="<td><div class='col text-center'><button onclick='eliminarEtiqueta(".$idCarpetaSecundario.");' title='Eliminar etiqueta' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

      $datos[] = array('nombreCarpeta' => $nombreCarpeta, 'fechaCreacion' => $fechaCreacion,'BotonEditar' => $BotonEditar,'BotonEliminar' => $BotonEliminar);

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


//ACTUALIZAR NOMBRE DE LA ETIQUETA

public function editarEtiquetaGestor($editaNombre,$idEtiqueta)
{
 try
 {
  $iduser=$_SESSION["usuario"]["idUsuario"];
  date_default_timezone_set('America/Mexico_City');
  $fecha_actual = date('Y-m-d H:i:s');

   $editarEtiqueta = $this->pdo->prepare(" UPDATE carpeta SET nombre_carpeta='$editaNombre',fecha_registro='$fecha_actual',idUsuarioCarpeta='$iduser',estatusCarpeta=1 WHERE idCarpeta='$idEtiqueta'");
  $editarEtiqueta->execute();

  header('Content-type: application/json');
  $resultado = array();
  $resultado = array("estado" => "true");
  return print(json_encode($resultado));

            //Sentencia SQL para selección de datos.
            // $stm = $this->pdo->prepare("SELECT idSubarea,subarea FROM subarea where id_submeta4='$idArea'");

}
catch(Exception $e)
{
  $resultado = array("estado" => "false");
  return print(json_encode($resultado));
            //Obtener mensaje de error.
            // die($e->getMessage());
}

}

//ELIMINAR ETIQUETA

public function eliminarEtiquetaGestor($idCarpetaSecundario)
{
  try
  {

    $idUsuario=$_SESSION["usuario"]["idUsuario"];

       $eliminarE = $this->pdo->prepare("UPDATE carpeta SET estatusCarpeta = 0 WHERE idCarpeta = '$idCarpetaSecundario'");
            //Ejecución de la sentencia SQL.
   $eliminarE->execute();

     $stm = $this->pdo->prepare("SELECT * FROM carpeta_correo WHERE idUsuarioCarpetaCorreo='$idUsuario' AND idCarpeta='$idCarpetaSecundario' AND carpetaEstatus=1");
            //Ejecución de la sentencia SQL.
    $stm->execute();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
      $idCarpeta=$row['idcarpeta_correo'];
        $bajaEtiquetas = $this->pdo->prepare("UPDATE carpeta_correo SET carpetaEstatus = 0 WHERE idcarpeta_correo = '$idCarpeta'");
            //Ejecución de la sentencia SQL.
   $bajaEtiquetas->execute();
    }

 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}




}