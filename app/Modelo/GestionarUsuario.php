<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class GestionarUsuario 
{
	protected static $cnx; 
    //Atributo para conexión a SGBD
  private $pdo;

  private $host  = 'localhost';
  private $user  = 'root';
  private $password   = "";
  private $database  = "php_chat";      
  private $chatTable = 'chat';
  private $chatUsersTable = 'chat_users';
  private $chatLoginDetailsTable = 'chat_login_details';
  private $dbConnect = false;

  // public function __construct(){
  //   if(!$this->dbConnect){ 
  //     $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
  //     if($conn->connect_error){
  //       die("Error failed to connect to MySQL: " . $conn->connect_error);
  //     }else{
  //       $this->dbConnect = $conn;
  //     }
  //   }
  // }

    //Método de conexión a SGBD.
  public function __CONSTRUCT()
  {
    try
    {
      $this->pdo = Base::Conectar();
          if(!$this->dbConnect){ 
      $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
      if($conn->connect_error){
        die("Error failed to connect to MySQL: " . $conn->connect_error);
      }else{
        $this->dbConnect = $conn;
      }
    }
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

      // $numArea = substr($idArea, 0,1);
    // var_dump($numArea);
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

  public function obtenerUsuariosGestor($idArea,$idSubarea)
  {

    try
    {

      $idEmpleado=$_SESSION["usuario"]["Empleado_idRfc"];
      if ($idArea == 0.1 and $idSubarea == 0) 
      {
            //Sentencia SQL para selección de datos.
        $stm = $this->pdo->prepare("SELECT idUsuario,nombre,am,ap,correo,Empleado_idRfc FROM usuario,empleado where empleado.idRfc=usuario.Empleado_idRfc and Empleado_idRfc <> '$idEmpleado' and estatus=1  ");
            //Ejecución de la sentencia SQL.
        $stm->execute();
        $datos = array();
        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
          $idEmpleado = $row['Empleado_idRfc'];
          $idUsuario = $row['idUsuario'];
          $idEmpleadoURL = base64_encode($row['Empleado_idRfc']);
          $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
          $correo = $row['correo'];
          $BotonVer="  <td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#exampleModalCenter' title='Ver información' class='Verinfo btn btn-info btn-circle'><i class='fas fa-eye'></i></button></div></td>";

          $BotonEditar="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idEmpleadoURL."' title='Editar información' class='btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></a></div></td>";

          $BotonEliminar="<td><div class='col text-center'><button onclick='alertaBajaUsuario(".$idUsuario.");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";



          $datos[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
            'correo' => $correo,'BotonVer' => $BotonVer,'BotonEditar' => $BotonEditar,'BotonEliminar' => $BotonEliminar);


        }

        
        $tabla = array(
         "data"       =>  $datos

       );


        echo json_encode($tabla);


      }
      else
      {
            //Sentencia SQL para selección de datos.
        $stm = $this->pdo->prepare("SELECT idUsuario,nombre,am,ap,correo,Empleado_idRfc FROM usuario,empleado where empleado.idRfc=usuario.Empleado_idRfc and empleado.idSubarea='$idSubarea' and Empleado_idRfc <> '$idEmpleado' and estatus=1 ");


            //Ejecución de la sentencia SQL.
        $stm->execute();
        $datos = array();
        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
          $idEmpleado = $row['Empleado_idRfc'];
          $idUsuario = $row['idUsuario'];
          $idEmpleadoURL = base64_encode($row['Empleado_idRfc']);
          $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
          $correo = $row['correo'];
          $BotonVer="  <td><div class='col text-center'><button  id='".$idEmpleado."' data-toggle='modal' data-target='#exampleModalCenter' title='Ver Información' class='Verinfo btn btn-info btn-circle'><i class='fas fa-eye'></i></button></div></td>";

          $BotonEditar="<td><div class='col text-center'><a href='?c=GestionarUsuarios&a=EditarDatosUsuario&g=".$idEmpleadoURL."' title='Editar Usuario' class='btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></a></div></td>";

          $BotonEliminar="<td><div class='col text-center'><button onclick='alertaBajaUsuario(".$idUsuario.");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";



          $datos[] = array('idEmpleado' => $idEmpleado, 'nombre' => $nombre, 
            'correo' => $correo,'BotonVer' => $BotonVer,'BotonEditar' => $BotonEditar,'BotonEliminar' => $BotonEliminar);


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



  public function InfoPerfilUsuario($idBotonVer)
  {
    $idUser=$idBotonVer;

    //          //Sentencia SQL para selección de datos.
    // $usuarioSQL = $this->pdo->prepare("SELECT Empleado_idRfc,correo FROM usuario WHERE idUsuario='$idUser'");
    //         //Ejecución de la sentencia SQL.
    // $usuarioSQL->execute();
    // $resultadoUsuario=$usuarioSQL->fetch(PDO::FETCH_ASSOC);
    // $idEmpleado = $resultadoUsuario['Empleado_idRfc'];
    // $correoEmpleado = $resultadoUsuario['correo'];

    $empleadoSQL = $this->pdo->prepare("SELECT nombre,ap,am,idArea,idSubArea,email FROM empleado WHERE idRfc='$idUser'");
            //Ejecución de la sentencia SQL.
    $empleadoSQL->execute();
    $resultadoEmpleado=$empleadoSQL->fetch(PDO::FETCH_ASSOC);
    $nombre = $resultadoEmpleado['nombre']." ".$resultadoEmpleado['ap']." ".$resultadoEmpleado['am'] ;
    $idArea=$resultadoEmpleado['idArea'];
    $idSubArea=$resultadoEmpleado['idSubArea'];
    $correoEmpleado = $resultadoEmpleado['email'];

    $empleadoArea = $this->pdo->prepare("SELECT area FROM area WHERE idArea='$idArea'");
            //Ejecución de la sentencia SQL.
    $empleadoArea->execute();
    $resultadoArea=$empleadoArea->fetch(PDO::FETCH_ASSOC);
    $nombreArea=$resultadoArea['area'];

    $empleadoSubArea = $this->pdo->prepare("SELECT subarea FROM subarea WHERE idsubarea='$idSubArea'");
            //Ejecución de la sentencia SQL.
    $empleadoSubArea->execute();
    $resultadoSubArea=$empleadoSubArea->fetch(PDO::FETCH_ASSOC);
    $nombreSubArea=$resultadoSubArea['subarea'];

    $datosPerfil = array();

    $datosPerfil[] = array('correoEmpleado' => $correoEmpleado, 'nombre' => $nombre, 
      'nombreArea' => $nombreArea,'nombreSubArea' => $nombreSubArea);

    echo json_encode($datosPerfil);
    
  }

  public function DarDeBajaUsuario($idUsuario)
  {
    try
    {


            //Sentencia SQL para selección de datos.

      $bajaUsuario = $this->pdo->prepare("UPDATE usuario SET estatus=0 WHERE idUsuario = '$idUsuario'");
            //Ejecución de la sentencia SQL.
      $bajaUsuario->execute();
    }
    catch(Exception $e)
    {
            //Obtener mensaje de error.
      die($e->getMessage());
    }

  }

  public function BuscarEmpleado($dataString,$key)
  {
    try
    {

      $html = '';
      $idEmpleadoActual=$_SESSION["usuario"]["Empleado_idRfc"];

            //Sentencia SQL para selección de datos.

      $Empleado = $this->pdo->prepare('SELECT * FROM empleado WHERE indicador="A" and idRfc <> "'.$idEmpleadoActual.'" and nombre LIKE "%'.strip_tags($key).'%"');
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

  public function ObtenerCorreoEmpleado($dataString,$key)
  {
    try
    {

      $html = '';
      $idEmpleadoActual=$_SESSION["usuario"]["Empleado_idRfc"];

            //Sentencia SQL para selección de datos.

      $Empleado = $this->pdo->prepare('SELECT * FROM empleado WHERE indicador="A" and idRfc <> "'.$idEmpleadoActual.'" and email LIKE "%'.strip_tags($key).'%"');
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

  public function GuardarUsuarioAlta($nombreUsuario,$correoUsuario,$idEmpleado)
  {
   try
   {
    $contra="IMTA2019";
    $contraEncriptada=sha1($contra);
    $guardarUsuario = $this->pdo->prepare("INSERT INTO usuario (usuario,password,correo,estatus,tipo,Empleado_idRfc)
      VALUES ('$nombreUsuario','$contraEncriptada','$correoUsuario',1,2,'$idEmpleado')");
                        //Ejecución de la sentencia SQL.
    $guardarUsuario->execute();
    $ultimoId=$this->pdo->lastInsertId();

      $sqlInsert = "
      INSERT INTO ".$this->chatUsersTable." 
      (userid, username, password, avatar,current_session,online) 
      VALUES ('".$ultimoId."', '".$nombreUsuario."', '".$contra."','user1.jpg','1', '1')";
    $result = mysqli_query($this->dbConnect, $sqlInsert);

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


public function ObtenerDatosEditarUsuario($idEmpleado)
{

  try
  {
    $stm = $this->pdo->prepare("SELECT * FROM empleado WHERE idRfc = '$idEmpleado'");
    $stm->execute(array($idEmpleado));
    return $stm->fetch(PDO::FETCH_OBJ);
  }
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
  }
}

public function ActualizarInfoUsuario($idUsuario,$nombreUsuario,$correoUsuario)
{

 try
 {

   $empelado = $this->pdo->prepare("SELECT * FROM empleado WHERE email='$correoUsuario'");
            //Ejecución de la sentencia SQL.
   $empelado->execute();
   $resultado=$empelado->fetch(PDO::FETCH_ASSOC);
   $idEmpleado=$resultado['idRfc'];




   $actualizarUsuario = $this->pdo->prepare("UPDATE usuario SET usuario='$nombreUsuario', correo='$correoUsuario', password='IMTA2019', estatus=1, tipo=2, Empleado_idRfc='$idEmpleado' WHERE Empleado_idRfc='$idUsuario'");
                        //Ejecución de la sentencia SQL.
   $actualizarUsuario->execute();

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







}