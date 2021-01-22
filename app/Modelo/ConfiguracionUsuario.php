<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class ConfiguracionUusario 
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

  public function obtenerArea()
  {
    try
    {
      $result = array();
            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT idArea,id_meta4,area FROM area");
            //Ejecución de la sentencia SQL.
      $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
      $row=$stm->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }
    catch(Exception $e)
    {
            //Obtener mensaje de error.
      die($e->getMessage());
    }
  }

  public function obtenerSubarea($idArea)
  {
    try
    {
     $rangoSubArea=$idArea + 50;
            //Sentencia SQL para selección de datos.
      // $stm = $this->pdo->prepare("SELECT idSubarea,subarea FROM subarea where idSubarea='$idArea'");
     $stm = $this->pdo->prepare("SELECT idSubarea,subarea FROM subarea where idSubarea between '$idArea' and '$rangoSubArea'");
            //Ejecución de la sentencia SQL.
     $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
     $row=$stm->fetchAll(PDO::FETCH_ASSOC);
     echo json_encode($row);

   }
   catch(Exception $e)
   {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}

public function obtenerUsuariosConfig($idArea,$idSubarea)
{


  try
  {
    $idEmpleado=$_SESSION["usuario"]["Empleado_idRfc"];
    if ($idArea == 0.1 and $idSubarea == 0) 
    {
            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT nombre,am,ap,correo,Empleado_idRfc,idUsuario FROM usuario,empleado where empleado.idRfc=usuario.Empleado_idRfc and Empleado_idRfc <> '$idEmpleado' and estatus=1  ");
            //Ejecución de la sentencia SQL.
      $stm->execute();
      $datos = array();
      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
        $idEmpleado = $row['idUsuario'];
        $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
        $correo = $row['correo'];

        $Papelera="<td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#papelera' title='Tiempo de borrado papelera' class='idUsuarioConfig btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

        $Recibidos="<td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#recibidos' title='Espacio en la bandeja de entrada' class='idUsuarioConfig btn btn-info btn-circle'><i class='fas fa-inbox'></i></button></div></td>";

        $Tamano="<td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#tamano' title='Tamaño de archivos permitidos' class='idUsuarioConfig btn btn-warning btn-circle'><i class='fas fa-file-alt'></i></button></div></td>";

        $datos[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
          'correo' => $correo,'Papelera' => $Papelera,'Recibidos' => $Recibidos,'Tamano' => $Tamano);


      }


      $tabla = array(
       "data"       =>  $datos

     );


      echo json_encode($tabla);


    }
    else
    {
            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT nombre,am,ap,correo,Empleado_idRfc,idUsuario FROM usuario,empleado where empleado.idRfc=usuario.Empleado_idRfc and empleado.idSubarea='$idSubarea' and Empleado_idRfc <> '$idEmpleado' and estatus=1 ");


            //Ejecución de la sentencia SQL.
      $stm->execute();
      $datos = array();
      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
        $idEmpleado = $row['idUsuario'];
        $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
        $correo = $row['correo'];


        $Papelera="<td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#papelera' title='Tiempo de borrado papelera' class='idUsuarioConfig btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

        $Recibidos="<td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#recibidos' title='Espacio en la bandeja de entrada' class='idUsuarioConfig btn btn-info btn-circle'><i class='fas fa-inbox'></i></button></div></td>";

        $Tamano="<td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#tamano' title='Tamaño de archivos permitidos' class='idUsuarioConfig btn btn-warning btn-circle'><i class='fas fa-file-alt'></i></button></div></td>";

        $datos[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
          'correo' => $correo,'Papelera' => $Papelera,'Recibidos' => $Recibidos,'Tamano' => $Tamano);



      }


      $tabla = array(
       "data"       =>  $datos
     );


      echo json_encode($tabla);

    }

  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}


  //FUNCIONES PARA LA CONFIGURACION DEL USUARIO

  //FUNCION PARA EL BORRADO AUTOMATICO DE PAPELERA

public function papeleraBorradoAuto($idUsuario,$diasPapelera)
{
  try
  {
    header('Content-type: application/json');
    $resultado = array();

            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idUsuarioConfig FROM configusuario WHERE idUsuarioConfig='$idUsuario'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
    $row=$stm->fetchAll(PDO::FETCH_ASSOC);

    if(empty($row)) 
    {

            // ARRAY VACIO
      $guardarDiasPapelera = $this->pdo->prepare("INSERT INTO configusuario (papelera,bEntrada,Tarchivo,idUsuarioConfig)
        VALUES ('$diasPapelera','0','0','$idUsuario')");
                        //Ejecución de la sentencia SQL.
      $guardarDiasPapelera->execute();


      $resultado = array("estado" => "true");
      return print(json_encode($resultado));

    }
    else 
    {
            //ARRAY CON DATOS
      $actualizarPapelera = $this->pdo->prepare("UPDATE configusuario SET papelera='$diasPapelera' WHERE idUsuarioConfig='$idUsuario'");
                        //Ejecución de la sentencia SQL.
      $actualizarPapelera->execute();

      $resultado = array("estado" => "true");
      return print(json_encode($resultado));

      
    }
  }
  catch(Exception $e)
  {
   $resultado = array("estado" => "false");
   return print(json_encode($resultado));
            //Obtener mensaje de error.
   die($e->getMessage());
 }
}

  //FUNCION PARA TAMAÑO DE LA BANDEJA DE ENTRADA

public function tamBanEntrada($idUsuario,$tamBandeja)
{
  try
  {
    header('Content-type: application/json');
    $resultado = array();

            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idUsuarioConfig FROM configusuario WHERE idUsuarioConfig='$idUsuario'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
    $row=$stm->fetchAll(PDO::FETCH_ASSOC);

    if(empty($row)) 
    {

            // ARRAY VACIO
      $guardarBanEntrada = $this->pdo->prepare("INSERT INTO configusuario (papelera,bEntrada,Tarchivo,idUsuarioConfig)
        VALUES ('0','$tamBandeja','0','$idUsuario')");
                        //Ejecución de la sentencia SQL.
      $guardarBanEntrada->execute();


      $resultado = array("estado" => "true");
      return print(json_encode($resultado));

    }
    else 
    {
            //ARRAY CON DATOS
      $actualizarBanEntrada = $this->pdo->prepare("UPDATE configusuario SET bEntrada='$tamBandeja' WHERE idUsuarioConfig='$idUsuario'");
                        //Ejecución de la sentencia SQL.
      $actualizarBanEntrada->execute();

      $resultado = array("estado" => "true");
      return print(json_encode($resultado));

      
    }
  }
  catch(Exception $e)
  {
   $resultado = array("estado" => "false");
   return print(json_encode($resultado));
            //Obtener mensaje de error.
   die($e->getMessage());
 }
}

  //FUNCION PARA TAMAÑO DE LOS ARCHIVOS

public function tamArchivos($idUsuario,$tamArchivo)
{
  try
  {
    header('Content-type: application/json');
    $resultado = array();

            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idUsuarioConfig FROM configusuario WHERE idUsuarioConfig='$idUsuario'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
    $row=$stm->fetchAll(PDO::FETCH_ASSOC);

    if(empty($row)) 
    {

            // ARRAY VACIO
      $guardarTamArchivo = $this->pdo->prepare("INSERT INTO configusuario (papelera,bEntrada,Tarchivo,idUsuarioConfig)
        VALUES ('0','0','$tamArchivo','$idUsuario')");
                        //Ejecución de la sentencia SQL.
      $guardarTamArchivo->execute();


      $resultado = array("estado" => "true");
      return print(json_encode($resultado));

    }
    else 
    {
            //ARRAY CON DATOS
      $actualizarTamArchivo = $this->pdo->prepare("UPDATE configusuario SET Tarchivo='$tamArchivo' WHERE idUsuarioConfig='$idUsuario'");
                        //Ejecución de la sentencia SQL.
      $actualizarTamArchivo->execute();

      $resultado = array("estado" => "true");
      return print(json_encode($resultado));

      
    }
  }
  catch(Exception $e)
  {
   $resultado = array("estado" => "false");
   return print(json_encode($resultado));
            //Obtener mensaje de error.
   die($e->getMessage());
 }
}

//OBTENER DATOS DE CONFIGURACIÓN DEL USUARIO
public function obtenerDatosConfig($idUsuario)
{
  try
  {
       //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM configusuario where idUsuarioConfig='$idUsuario'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
    $row=$stm->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($row);
  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
   die($e->getMessage());
 }
}






}