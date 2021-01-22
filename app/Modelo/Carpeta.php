<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class Carpeta 
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

      //FUNCION PARA MOSTRAR LAS CARPETAS CREADAS
public function obtenerTodasEtiquetas()
{

  try
  {

    $idUsuario=$_SESSION["usuario"]["idUsuario"];

            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM carpeta WHERE idUsuarioCarpeta='$idUsuario' AND estatusCarpeta=1");

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

       $BotonEliminar="<td><div class='col text-center'><button onclick='eliminarEtiquetaMain(".$idCarpetaSecundario.");' title='Eliminar etiqueta' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

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


//GUARDAR ETIQUETA
public function guardarCarpeta($nomCarpeta)
{
 try
 {
  $iduser=$_SESSION["usuario"]["idUsuario"];
  date_default_timezone_set('America/Mexico_City');
  $fecha_actual = date('Y-m-d H:i:s');

   $guardarCarpeta = $this->pdo->prepare("  INSERT INTO carpeta(nombre_carpeta, fecha_registro, idUsuarioCarpeta, estatusCarpeta) VALUES ('$nomCarpeta','$fecha_actual','$iduser',1)");


                        //Ejecución de la sentencia SQL.
  $guardarCarpeta->execute();


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

//ACTUALIZAR NOMBRE DE LA ETIQUETA

public function editarEtiquetaBD($editaNombre,$idEtiqueta)
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

public function eliminarEtiquetaBase($idCarpetaSecundario)
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





//LLAVE FINAL


}