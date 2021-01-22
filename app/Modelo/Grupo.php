<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class Grupo 
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

    //Este método selecciona todas las tuplas de la tabla
  public function obtenerGrupos()
  {
    try
    {
      $iduser=$_SESSION["usuario"]["idUsuario"];
      $result = array();

            //OBTENER PERMISOS SI ES QUE TIENE ALGUN GRUPO

      $stm = $this->pdo->prepare("SELECT idPermisoGrupo,idGrupoPermiso,idUsuario,estatusPermisoGrupo FROM permisogrupo where estatusPermisoGrupo = 1 and idUsuario='$iduser'");
            //Ejecución de la sentencia SQL.
      $stm->execute();
      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
       $idGrupoPermiso = $row['idGrupoPermiso'];

       $datosIdPermiso[] = array('idGrupoPermiso' => $idGrupoPermiso);
     }

     if (empty($datosIdPermiso)) {
                //Sentencia SQL para selección de datos.
   $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion,fecha_grupo FROM grupo where estatusGrupo = 1 and idUserGrupo='$iduser'");
            //Ejecución de la sentencia SQL.
   $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
            // $row=$stm->fetchAll(PDO::FETCH_ASSOC);
    $row=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
     }
     else
     {

     for ($i=0;  $i < sizeof($datosIdPermiso) ; $i++) { 

      $idGrupoPermiso=$datosIdPermiso[$i]['idGrupoPermiso'];
      $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion,fecha_grupo FROM grupo where idGrupo='$idGrupoPermiso'");
            //Ejecución de la sentencia SQL.
      $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
            // var_dump($stm->fetchAll(PDO::FETCH_ASSOC));

      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {


       $datosGruposPermiso[] = $row;
     }  

   }
            //Sentencia SQL para selección de datos.
   $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion,fecha_grupo FROM grupo where estatusGrupo = 1 and idUserGrupo='$iduser'");
            //Ejecución de la sentencia SQL.
   $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
            // $row=$stm->fetchAll(PDO::FETCH_ASSOC);

   while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {


     $datosGruposPermiso[] = $row;
   } 

   return $datosGruposPermiso;
 }
 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
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

public function obtenerUsuarios($idArea,$idSubarea,$data)
{


  try
  {
    if ($idArea == 0.1 and $idSubarea == 0) 
    {
            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT nombre,am,ap,email,idRfc FROM empleado where indicador='A'");
            //Ejecución de la sentencia SQL.
      $stm->execute();
      $datos = array();
      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
        $idEmpleado = $row['idRfc'];
        $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
        $correo = $row['email'];
        $cadena="<td><div class='col text-center'><button id='".$idEmpleado."' title='Agregar usuario al grupo' class='agregar1 btn btn-success btn-circle'><i class='fas fa-user-plus'></i></button></div></td>";


        $datos[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
          'correo' => $correo,'cadena' => $cadena);


      }

              // sacar la logitud de datos en un for

      for ($i=0;  $i < sizeof($datos) ; $i++) { 
        for ($x=0;  $x < sizeof($data) ; $x++) { 
         if($datos[$i]['idEmpleado']==$data[$x])
         {

           $datos[$i]['cadena']="<td><div class='col text-center'><button disabled id='".$datos[$i]['idEmpleado']."' title='Agregar usuario al grupo' class='agregar btn btn-danger  btn-circle'><i class='fas fa-user-plus'></i></button></div></td>";
         }
       }
     }
     $tabla = array(
       "data"       =>  $datos

     );


     echo json_encode($tabla);


   }
   else
   {
            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT nombre,am,ap,email,idRfc FROM empleado where indicador='A' and idSubarea='$idSubarea'");


            //Ejecución de la sentencia SQL.
    $stm->execute();
    $datos = array();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
      $idEmpleado = $row['idRfc'];
      $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
      $correo = $row['email'];
      $cadena="<td><div class='col text-center'><button id='".$idEmpleado."' title='Agregar usuario al grupo' class='agregar1 btn btn-success btn-circle'><i class='fas fa-user-plus'></i></button></div></td>";


      $datos[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
        'correo' => $correo,'cadena' => $cadena);


    }

              // sacar la logitud de datos en un for

    for ($i=0;  $i < sizeof($datos) ; $i++) { 
      for ($x=0;  $x < sizeof($data) ; $x++) { 
       if($datos[$i]['idEmpleado']==$data[$x])
       {

         $datos[$i]['cadena']="<td><div class='col text-center'><button disabled id='".$datos[$i]['idEmpleado']."' title='Agregar usuario al grupo' class='agregar btn btn-danger  btn-circle'><i class='fas fa-user-plus'></i></button></div></td>";
       }
     }
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

public function GuardarInfoGrupo($nombreGrupoA,$descripcionGrupo,$dataFinal)
{
 try
 {
  $iduser=$_SESSION["usuario"]["idUsuario"];
  date_default_timezone_set('America/Mexico_City');
  $fecha_actual = date('Y-m-d H:i:s');

  $guardarGrupo = $this->pdo->prepare("INSERT INTO grupo (nombre_grupo,fecha_grupo,descripcion,idUserGrupo,estatusGrupo)
    VALUES ('$nombreGrupoA','$fecha_actual','$descripcionGrupo','$iduser',1)");
                        //Ejecución de la sentencia SQL.
  $guardarGrupo->execute();

  $obteneridGrupo = $this->pdo->prepare("SELECT idGrupo FROM grupo WHERE nombre_grupo='$nombreGrupoA' and descripcion='$descripcionGrupo'");
                        //Ejecución de la sentencia SQL.
  $obteneridGrupo->execute();
  $resultadoIdGrupo=$obteneridGrupo->fetch(PDO::FETCH_ASSOC);
  $idGrupo = $resultadoIdGrupo['idGrupo'];

  for ($i=0;  $i < sizeof($dataFinal) ; $i++) { 
    $idEmpleado = $dataFinal[$i];
    $guardarUsuarios = $this->pdo->prepare("INSERT INTO grupoempleado (idGrupo,idRfc, idUserGrupoEmpleado,estatusMiembro)
      VALUES ('$idGrupo','$idEmpleado','$iduser',1)");
            //Ejecución de la sentencia SQL.
    $guardarUsuarios->execute();
  }

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

public function ActualizarInformacionGrupo($idGrupoActualizar,$nombreGrupoA,$descripcionGrupo,$dataFinal,$dataEliminadosEditar)
{
 try
 {
   $iduser=$_SESSION["usuario"]["idUsuario"];

   $actualizarGrupo = $this->pdo->prepare("UPDATE grupo SET nombre_grupo='$nombreGrupoA', descripcion='$descripcionGrupo' WHERE idGrupo='$idGrupoActualizar' and idUserGrupo='$iduser'");
                        //Ejecución de la sentencia SQL.
   $actualizarGrupo->execute();


   for ($i=0;  $i < sizeof($dataEliminadosEditar) ; $i++) { 
    $idEmpleado = $dataEliminadosEditar[$i];
    $actualizarUsuariosEliminados = $this->pdo->prepare("UPDATE grupoempleado SET estatusMiembro=0 WHERE idGrupo='$idGrupoActualizar' and idRfc='$idEmpleado'");
            //Ejecución de la sentencia SQL.
    $actualizarUsuariosEliminados->execute();
  }

  for ($i=0;  $i < sizeof($dataFinal) ; $i++) { 
    $idEmpleado = $dataFinal[$i];
    $guardarUsuariosActualizados = $this->pdo->prepare("INSERT INTO grupoempleado (idGrupo,idRfc, idUserGrupoEmpleado,estatusMiembro)
      VALUES ('$idGrupoActualizar','$idEmpleado','$iduser',1)");
            //Ejecución de la sentencia SQL.
    $guardarUsuariosActualizados->execute();
  }

  header('Content-type: application/json');
  $resultado = array();
  $resultado = array("estado" => "true");
  return print(json_encode($resultado));

}
catch(Exception $e)
{
  $resultado = array("estado" => "false");
  return print(json_encode($resultado));
            //Obtener mensaje de error.
            // die($e->getMessage());
}

}

public function ConsultarMiembros($idBotonVer)
{


  try
  {
    $iduser=$_SESSION["usuario"]["idUsuario"];
    $datos=array();
            //Sentencia SQL para selección de datos.
    // $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1 and idUserGrupoEmpleado='$iduser' and idGrupo='$idBotonVer'");
     $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1 and idGrupo='$idBotonVer'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
      $idEmpleado = $row['idRfc'];
      $Miembros = $this->pdo->prepare("SELECT nombre,am,ap,email FROM empleado WHERE idRfc='$idEmpleado'");
            //Ejecución de la sentencia SQL.
      $Miembros->execute();
      while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {
       $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
       $correo = $row['email'];



       $datos[] = array('nombre' => $nombre, 
        'correo' => $correo);


     }

   }

   $tablaMiembros = array(
     "data"       =>  $datos

   );


   echo json_encode($tablaMiembros);


 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

//$XK ES EL ID DEL GRUPO
public function ObtenerDatosEditar($XK)
{

  try
  {

    $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion FROM grupo WHERE idGrupo = '$XK'");
    $stm->execute(array($XK));
    return $stm->fetch(PDO::FETCH_OBJ);
  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}

//$XK ES EL ID DEL GRUPO
public function MiembrosEditar($XK)
{

  try
  {
    $datos=array();
    $datosMiembros=array();
      //OBTENER LOS MIEMBROS ACTUALES AGREGADOS
    $iduser=$_SESSION["usuario"]["idUsuario"];
            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1 and idGrupo='$XK';");
            //Ejecución de la sentencia SQL.
    $stm->execute();

    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
     $idEmpleado = $row['idRfc'];

     $datos[] = array('idEmpleado' => $idEmpleado);
   }


   for ($i=0;  $i < sizeof($datos) ; $i++) { 
            // var_dump($datos[$i]['idEmpleado']);

    $idEmpleado=$datos[$i]['idEmpleado'];
    $Miembros = $this->pdo->prepare("SELECT idRfc,nombre,am,ap,email FROM empleado WHERE idRfc='$idEmpleado'");
            //Ejecución de la sentencia SQL.
    $Miembros->execute();

    while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {


     $datosMiembros[] = $row;
   }  

 }


 return $datosMiembros;

}
catch(Exception $e)
{
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

public function eliminarGrupo($idGrupo)
{
  try
  {

      //OBTENER LOS MIEMBROS ACTUALES AGREGADOS
    $iduser=$_SESSION["usuario"]["idUsuario"];
            //Sentencia SQL para selección de datos.

    $borrarGrupo = $this->pdo->prepare("UPDATE grupo SET estatusGrupo=0 WHERE idGrupo = '$idGrupo'");
            //Ejecución de la sentencia SQL.
    $borrarGrupo->execute();

    $borrarGrupoEmpleado = $this->pdo->prepare("UPDATE grupoempleado SET estatusMiembro = 0 WHERE idGrupo = '$idGrupo' and  idUserGrupoEmpleado='$iduser'");
            //Ejecución de la sentencia SQL.
    $borrarGrupoEmpleado->execute();


    
  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
  }

}




}