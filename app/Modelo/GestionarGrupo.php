<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class GestionarGrupo 
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



    public function obtenerTodosGrupos()
    {


        try
        {
            //Sentencia SQL para selección de datos.
            $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion,fecha_grupo,idUserGrupo FROM grupo where estatusGrupo = 1");


            //Ejecución de la sentencia SQL.
            $stm->execute();
            $datos = array();
            while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

                $idGrupo = $row['idGrupo'];
                $idGrupoCodificado =  base64_encode($row['idGrupo']);
                $idUserGrupo = $row['idUserGrupo'];
                $nombreGrupo = $row['nombre_grupo'];
                $descripcion = $row['descripcion'];

                if ($descripcion == '') {
                    $descripcion="<td><i>Sin descripción</i></td>";
                }

                $fecha_grupo = $row['fecha_grupo'];

                $BotonVer="  <td><div class='col text-center'><button  id='".$idGrupo."' data-toggle='modal' data-target='.miembrosGestor' title='Ver Miembros' class='VerMiembrosGestor btn btn-info btn-circle'><i class='fas fa-eye'></i></button></div></td>";

                $BotonEditar="<td><div class='col text-center'><a href='?c=GestionarGrupos&a=vistaEditarGrupoGestor&XK=".$idGrupoCodificado."' title='Editar información' class='btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></a></div></td>";

                $BotonEliminar="<td><div class='col text-center'><button onclick='EliminarGrupoGestor(".$idGrupo.",".$idUserGrupo.");'  title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

                $BotonPermiso="<td><div class='col text-center'><button  id='".$idGrupo."'  data-toggle='modal' data-target='.usuarios' title='Permisos' class='permisos btn btn-success btn-circle'><i class='fas fa-lock-open'></i></button></div></td>";

                $BotonQuitarPermiso="<td><div class='col text-center'><button  id='".$idGrupo."'  data-toggle='modal' data-target='.quitarPermiso' title='Quitar Permisos' class='Quitarpermisos btn btn-danger btn-circle'><i class='fas fa-lock'></i></button></div></td>";


                $datos[] = array(
                    'nombreGrupo' => $nombreGrupo, 
                    'descripcion' => $descripcion,
                    'fecha_grupo' => $fecha_grupo, 
                    'BotonVer' => $BotonVer, 
                    'BotonEditar' => $BotonEditar, 
                    'BotonEliminar' => $BotonEliminar,
                    'BotonPermiso' => $BotonPermiso,
                    'BotonQuitarPermiso' => $BotonQuitarPermiso);

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

    public function EncontrarEmpleadoGrupo($dataString,$key)
    {
      try
      {

        $html = '';
        $idEmpleadoActual=$_SESSION["usuario"]["Empleado_idRfc"];

            //Sentencia SQL para selección de datos.

        $Empleado = $this->pdo->prepare('SELECT * FROM empleado WHERE idRfc <> "'.$idEmpleadoActual.'" and nombre LIKE "%'.strip_tags($key).'%"');
            //Ejecución de la sentencia SQL.
        $Empleado->execute();
        while ($row = $Empleado->fetch(PDO::FETCH_ASSOC)) {

            $html .= '<div><a class="suggest-element" correo="'.$row['email'].'" data="'.$row['nombre'].' '.$row['ap'].' '.$row['am'].'" id="'.$row['idRfc'].'">'.$row['nombre'].' '.$row['ap'].' '.$row['am'].'</a></div>';

        }
        echo $html;

    }
    catch(Exception $e)
    {
            //Obtener mensaje de error.
        die($e->getMessage());
    }

}

public function EncontrarCorreoGrupo($dataString,$key)
{
  try
  {

    $html = '';
    $idEmpleadoActual=$_SESSION["usuario"]["Empleado_idRfc"];

            //Sentencia SQL para selección de datos.

    $Empleado = $this->pdo->prepare('SELECT * FROM empleado WHERE idRfc <> "'.$idEmpleadoActual.'" and email LIKE "%'.strip_tags($key).'%"');
            //Ejecución de la sentencia SQL.
    $Empleado->execute();
    while ($row = $Empleado->fetch(PDO::FETCH_ASSOC)) {

        $html .= '<div><a class="suggest-element" data="'.$row['email'].'" id="'.$row['idRfc'].'">'.$row['email'].'</a></div>';

    }
    echo $html;

}
catch(Exception $e)
{
            //Obtener mensaje de error.
    die($e->getMessage());
}

}

public function ObtenerGruposPorUsuario($idEmpleado)
{


    try
    {
        $datos=array();
            //Sentencia SQL para selección de datos.
        $stm = $this->pdo->prepare("SELECT * FROM usuario where estatus = 1 and Empleado_idRfc='$idEmpleado'");
            //Ejecución de la sentencia SQL.
        $stm->execute();
        $resultadoEmpleado=$stm->fetch(PDO::FETCH_ASSOC);
        $idUsuario = $resultadoEmpleado['idUsuario'];


        $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion,fecha_grupo FROM grupo where estatusGrupo = 1 and idUserGrupo='$idUsuario';");
            //Ejecución de la sentencia SQL.
        $stm->execute();

        $datos = array();
        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

            $idGrupo = $row['idGrupo'];
            $idGrupoCodificado =  base64_encode($row['idGrupo']);
            $nombreGrupo = $row['nombre_grupo'];
            $descripcion = $row['descripcion'];

            if ($descripcion == '') {
                $descripcion="<td><i>Sin descripción</i></td>";
            }

            $fecha_grupo = $row['fecha_grupo'];

            $BotonVer="  <td><div class='col text-center'><button  id='".$idGrupo."' data-toggle='modal' data-target='.miembrosGestor' title='Ver Miembros' class='VerMiembrosGestor btn btn-info btn-circle'><i class='fas fa-eye'></i></button></div></td>";

            $BotonEditar="<td><div class='col text-center'><a href='?c=GestionarGrupos&a=vistaEditarGrupoGestor&XK=".$idGrupoCodificado."' title='Editar información' class='btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></a></div></td>";

            $BotonEliminar="<td><div class='col text-center'><button onclick='EliminarGrupoGestor(".$idGrupo.",".$idUsuario.");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

            $BotonPermiso="<td><div class='col text-center'><button  id='".$idGrupo."'  data-toggle='modal' data-target='.usuarios' title='Permisos' class='permisos btn btn-success btn-circle'><i class='fas fa-lock-open'></i></button></div></td>";

            $BotonQuitarPermiso="<td><div class='col text-center'><button  id='".$idGrupo."'  data-toggle='modal' data-target='.quitarPermiso' title='Quitar Permisos' class='Quitarpermisos btn btn-danger btn-circle'><i class='fas fa-lock'></i></button></div></td>";



            $datos[] = array(
                'nombreGrupo' => $nombreGrupo, 
                'descripcion' => $descripcion,
                'fecha_grupo' => $fecha_grupo, 
                'BotonVer' => $BotonVer, 
                'BotonEditar' => $BotonEditar, 
                'BotonEliminar' => $BotonEliminar,
                'BotonPermiso' => $BotonPermiso,
                'BotonQuitarPermiso' => $BotonQuitarPermiso);

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


public function ConsultarMiembrosGestor($idBotonVer)
{


    try
    {

        $datos=array();
        $iduser=$_SESSION["usuario"]["idUsuario"];
            //Sentencia SQL para selección de datos.
        $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1  and idGrupo='$idBotonVer';");
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

public function obtenerUsuariosTbalaElegir($idGrupo)
{
    try
    {
        //OBTENER EL ID DEL USUARIO QUE CREO EL GRUPO Y TODOS LO USUARIOS REGISTRADOS
         //Sentencia SQL para selección de datos.
     $datos = array(); 
     $datosId = array();
     $datosUsuarios = array();
     $datoPermiso = array();
     $stm = $this->pdo->prepare("SELECT idUserGrupo FROM grupo where idGrupo='$idGrupo'");
            //Ejecución de la sentencia SQL.
     $stm->execute();
     $resultadoIdUser=$stm->fetch(PDO::FETCH_ASSOC);
     $idUsuario=$resultadoIdUser['idUserGrupo'];

            //Sentencia SQL para selección de datos.
     $stm = $this->pdo->prepare("SELECT idUsuario,nombre,am,ap,correo FROM usuario,empleado where empleado.idRfc=usuario.Empleado_idRfc and usuario.idUsuario <> $idUsuario");
            //Ejecución de la sentencia SQL.
     $stm->execute();
     while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
        $idUsuario = $row['idUsuario'];
        $datosUsuarios[] = array('idUsuario' => $idUsuario);
    }

    //OBTENER TODOS LOS USUARIOS DE LA TABLA PERMISOS GRUPO
    $permisoId = $this->pdo->prepare("SELECT * FROM permisogrupo where idGrupoPermiso='$idGrupo' AND estatusPermisoGrupo=1");
            //Ejecución de la sentencia SQL.
    $permisoId->execute();
    while ($fila = $permisoId->fetch(PDO::FETCH_ASSOC)) {
        $idUsuario = $fila['idUsuario'];
        $datoPermiso[] = array('idUsuario' => $idUsuario);
    }

    foreach ($datosUsuarios as $value1) {
    $encontrado=false;
    foreach ($datoPermiso as $value2) {
        if ($value1 == $value2)
        {
            $encontrado=true;
            $break;
        }
    }
    if ($encontrado == false){
        $idUsuario=$value1;
        array_push($datosId,$idUsuario);    
    }
}

    foreach ($datosId as $valor) 
    {
        $idUsuario=$valor['idUsuario'];

                  //Sentencia SQL para selección de datos.
        $stm = $this->pdo->prepare("SELECT idUsuario,nombre,am,ap,correo FROM usuario,empleado where empleado.idRfc=usuario.Empleado_idRfc and usuario.idUsuario=$idUsuario");
            //Ejecución de la sentencia SQL.
        $stm->execute();
        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $idEmpleado = $row['idUsuario'];
            $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
            $correo = $row['correo'];


            $datos[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
                'correo' => $correo);
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

public function UsuariosQuitarPermiso($idGrupo)
{
    try
    {

              //Sentencia SQL para selección de datos.
        $stm = $this->pdo->prepare("SELECT idUsuario FROM permisogrupo where idGrupoPermiso='$idGrupo' and estatusPermisoGrupo= 1");
            //Ejecución de la sentencia SQL.
        $stm->execute();

        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $idUsuario = $row['idUsuario'];

            $datosIdUsuarios[] = array('idUsuario' => $idUsuario);

        }

        for ($i=0;  $i < sizeof($datosIdUsuarios) ; $i++) { 

            $idUsuario=$datosIdUsuarios[$i]['idUsuario'];


                        //Sentencia SQL para selección de datos.
            $stm = $this->pdo->prepare("SELECT idUsuario,nombre,am,ap,correo FROM usuario,empleado where empleado.idRfc=usuario.Empleado_idRfc and usuario.idUsuario='$idUsuario'");
            //Ejecución de la sentencia SQL.
            $stm->execute();

            while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                $idEmpleado = $row['idUsuario'];
                $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
                $correo = $row['correo'];


                $datosUsuarios[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
                    'correo' => $correo);


            }

        }


        $tabla = array(
         "data"       =>  $datosUsuarios

     );


        echo json_encode($tabla);


    }
    catch(Exception $e)
    {
            //Obtener mensaje de error.
        die($e->getMessage());
    }
}

//DAR DE BAJA LOS PERMISOS A LOS USUARIOS ELEGIDOS DEL GRUPO QUE SE SELECCIONO

public function quitarPermisosArrayUsuarios($idGrupo,$data)
{

    try
    {

      for ($i=0;  $i < sizeof($data) ; $i++) { 

        $actualizarGrupoPermiso = $this->pdo->prepare("UPDATE permisogrupo SET estatusPermisoGrupo=0 where idGrupoPermiso='$idGrupo' and idUsuario='$data[$i]'");
                        //Ejecución de la sentencia SQL.
        $actualizarGrupoPermiso->execute();

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
 die($e->getMessage());
}
}

public function almacenarArrayUsuarios($idGrupo,$data)
{

    try
    {



      for ($i=0;  $i < sizeof($data) ; $i++) { 

        $guardarGrupoPermiso = $this->pdo->prepare("INSERT INTO permisogrupo (idGrupoPermiso,idUsuario,estatusPermisoGrupo)
            VALUES ('$idGrupo','$data[$i]',1)");
                        //Ejecución de la sentencia SQL.
        $guardarGrupoPermiso->execute();

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
 die($e->getMessage());
}
}

public function eliminarGrupoGestorAdmin($idGrupo,$idUsuario)
{
  try
  {

      //OBTENER LOS MIEMBROS ACTUALES AGREGADOS
            //Sentencia SQL para selección de datos.

    $borrarGrupo = $this->pdo->prepare("UPDATE grupo SET estatusGrupo=0 WHERE idGrupo = '$idGrupo'");
            //Ejecución de la sentencia SQL.
    $borrarGrupo->execute();

    $borrarGrupoEmpleado = $this->pdo->prepare("UPDATE grupoempleado SET estatusMiembro = 0 WHERE idGrupo = '$idGrupo' and  idUserGrupoEmpleado='$idUsuario'");
            //Ejecución de la sentencia SQL.
    $borrarGrupoEmpleado->execute();


    
}
catch(Exception $e)
{
            //Obtener mensaje de error.
    die($e->getMessage());
}

}

//ACTUALIZAR GRUPO EN GESTOR
public function ObtenerDatosEditarGestor($XK)
{

  try
  {

    $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion,idUserGrupo FROM grupo WHERE idGrupo = '$XK'");
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
public function MiembrosEditarGestor($XK)
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

public function ActualizarInformacionGrupoGestor($idGrupoActualizar,$nombreGrupoA,$descripcionGrupo,$dataFinal,$dataEliminadosEditar,$idUserGrupo)
{
 try
 {

   $actualizarGrupo = $this->pdo->prepare("UPDATE grupo SET nombre_grupo='$nombreGrupoA', descripcion='$descripcionGrupo' WHERE idGrupo='$idGrupoActualizar' and idUserGrupo='$idUserGrupo'");
                        //Ejecución de la sentencia SQL.
   $actualizarGrupo->execute();


   for ($i=0;  $i < sizeof($dataEliminadosEditar) ; $i++) { 
    $idEmpleado = $dataEliminadosEditar[$i];
    $actualizarUsuariosEliminados = $this->pdo->prepare("UPDATE grupoempleado SET estatusMiembro=0 WHERE idGrupo='$idGrupoActualizar' and idRfc='$idEmpleado' and idUserGrupoEmpleado='$idUserGrupo'");
            //Ejecución de la sentencia SQL.
    $actualizarUsuariosEliminados->execute();
}

for ($i=0;  $i < sizeof($dataFinal) ; $i++) { 
    $idEmpleado = $dataFinal[$i];
    $guardarUsuariosActualizados = $this->pdo->prepare("INSERT INTO grupoempleado (idGrupo,idRfc, idUserGrupoEmpleado,estatusMiembro)
      VALUES ('$idGrupoActualizar','$idEmpleado','$idUserGrupo',1)");
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



//LLAVE FINAL
}