<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

require_once ("$root/sild/Public/PHPMailer/src/Exception.php");
require_once ("$root/sild/Public/PHPMailer/src/PHPMailer.php");
require_once ("$root/sild/Public/PHPMailer/src/SMTP.php");


/**
 * 
 */
class RedactarCorreo
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

  public function listarPlantillas()
  {
    try
    {
      $result = array();
            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT * FROM plantilla");
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

  //OBTENER ETIQUETAS
  public function listarEtiquetas()
  {
    try
    {

      $idUsuario=$_SESSION["usuario"]["idUsuario"];

            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT * FROM carpeta WHERE idUsuarioCarpeta='$idUsuario' AND estatusCarpeta=1");

            //Ejecución de la sentencia SQL.
      $stm->execute();
      $row=$stm->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }
    catch(Exception $e)
    {
            //Obtener mensaje de error.
      die($e->getMessage());
    }
  }


    //OBTENER PLANTILLA SELECCIONADA POR EL USUARIO
  public function obtenerPlantilla($idPlantilla)
  {
    try
    {
      $result = array();
            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT * FROM plantilla WHERE idPlantilla='$idPlantilla'");
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

    //OBTENER AREAS DEL SELECT
  public function obtenerAreaEnviados()
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

      //OBTENER GRUPOS DE LA TABLA GRUPOSPUESTO
  public function obtenerGruposPuesto()
  {
    try
    {
      $result = array();
            //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT * FROM grupospuesto where estatus=1");
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

  public function obtenerSubareaEnviados($idArea)
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

    //OBTENER GRUPOS
  public function obtenerGruposSelect($idArea)
  {
    try
    {
     $iduser=$_SESSION["usuario"]["idUsuario"];
     $datosIdPermiso=array();

     //OBTENER PERMISOS SI ES QUE TIENE ALGUN GRUPO
     $stm = $this->pdo->prepare("SELECT idPermisoGrupo,idGrupoPermiso,idUsuario,estatusPermisoGrupo FROM permisogrupo where estatusPermisoGrupo = 1 and idUsuario='$iduser'");
            //Ejecución de la sentencia SQL.
     $stm->execute();
     while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
       $idGrupoPermiso = $row['idGrupoPermiso'];

       $datosIdPermiso[] = array('idGrupoPermiso' => $idGrupoPermiso);
     }

     for ($i=0;  $i < sizeof($datosIdPermiso) ; $i++) { 

      $idGrupoPermiso=$datosIdPermiso[$i]['idGrupoPermiso'];
      $stm = $this->pdo->prepare("SELECT idGrupo,nombre_grupo,descripcion,fecha_grupo FROM grupo where estatusGrupo=1 and idGrupo='$idGrupoPermiso'");
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
   $stm = $this->pdo->prepare("SELECT * FROM grupo where estatusGrupo=1 and idUserGrupo='$iduser'");
            //Ejecución de la sentencia SQL.
   $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
     // $row=$stm->fetchAll(PDO::FETCH_ASSOC);
   while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {


     $datosGruposPermiso[] = $row;
   } 
   
   echo json_encode($datosGruposPermiso);

 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

    //OBTENER DESTINATARIOS

public function obtenerDestinatarios($idArea,$idSubarea)
{
  try
  {
   $iduser=$_SESSION["usuario"]["idUsuario"];
   $count=0;

   if ($idArea == 0.1) 
   {


             //OBTENER TODOS LO DESTINATARIOS DEL IMTA
             //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT nombre,ap,am,email FROM empleado WHERE indicador='A'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
     $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
     $correo = $row['email'];



     $datos[] = array('nombre' => $nombre, 
      'correo' => $correo);

     $count++;


   }

   $tabla = array(
     "data"       =>  $datos

   );

   echo json_encode($tabla);
 }
 elseif ($idArea == 0.2) 
 {

  //OBTENER LOS MIEMBROS DEL GRUPO
  $datos=array();
  //Sentencia SQL para selección de datos.
  $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1 and idGrupo='$idSubarea'");
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

 $tabla = array(
   "data"       =>  $datos

 );
 
 echo json_encode($tabla);


}
elseif ($idSubarea == 0.11) {

      //OBTENER LOS MIEMBROS DEL AREA
    //Sentencia SQL para selección de datos.
  $stm = $this->pdo->prepare("SELECT nombre,ap,am,email FROM empleado where idArea='$idArea' and indicador='A'");
            //Ejecución de la sentencia SQL. 
  $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
  $datos=array();
  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
   $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
   $correo = $row['email'];



   $datos[] = array('nombre' => $nombre, 
    'correo' => $correo);
 }
 $tabla = array(
   "data"       =>  $datos

 );


 echo json_encode($tabla);
}
else
{

    //OBTENER LOS MIEMBROS DE LA SUBAREA
    //Sentencia SQL para selección de datos.
  $stm = $this->pdo->prepare("SELECT nombre,ap,am,email FROM empleado where idSubArea='$idSubarea' and indicador='A'");
            //Ejecución de la sentencia SQL. 
  $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
  $datos=array();
  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
   $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
   $correo = $row['email'];



   $datos[] = array('nombre' => $nombre, 
    'correo' => $correo);
 }


     //OBTENER LOS MIEMBROS DE LA TABLA GRUPONIVELES

  //Sentencia SQL para selección de datos.
 $stm = $this->pdo->prepare("SELECT * FROM gruponiveles WHERE idgruposPuesto='$idArea' and estatus=1");
            //Ejecución de la sentencia SQL.
 $stm->execute();
 while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
  $puesto = $row['Puesto_puesto'];
  $Miembros = $this->pdo->prepare("SELECT nombre,am,ap,email FROM empleado WHERE puesto='$puesto' and indicador='A'");
            //Ejecución de la sentencia SQL.
  $Miembros->execute();
  while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {
   $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
   $correo = $row['email'];


   $datos[] = array('nombre' => $nombre, 
    'correo' => $correo);


 }
}

// var_dump($datos);

if (empty($datos)) {
 $datos=array();
 echo json_encode($datos);
}
else{



 $tabla = array(
   "data"       =>  $datos

 );


 echo json_encode($tabla);
}

}          

}
catch(Exception $e)
{
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

//OBTENER LISTA DE LOS DESTINATARIOS QUE SE ENVIÓ EL CORREO
public function obtenerListaDestino($idAreaEnvios,$subAreaCorreo)
{
  try
  {
   $iduser=$_SESSION["usuario"]["idUsuario"];
   $datos=array();
     // var_dump($idAreaEnvios);
     // var_dump($subAreaCorreo);
          //OBTENER DESTINATARIOS
    //DESTINATARIOS DE TODO EL IMTA
   if ($idAreaEnvios == 0.1) 
   {
             //OBTENER TODOS LO DESTINATARIOS DEL IMTA
             //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado WHERE indicador='A'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
    $res=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }
   //OBTENER DESTINATARIOS DE TODA EL AREA SELECCIONADA
  elseif ($subAreaCorreo == 0.11) {

      //OBTENER LOS MIEMBROS DEL AREA
    //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado where idArea='$idAreaEnvios' and indicador='A'");
    $stm->execute();
    $res=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $res;

  }
 //GRUPOS CREADOS POR EL USUSARIO
  elseif ($idAreaEnvios == 0.2) 
  {
    $res=array();
    //OBTENER LOS MIEMBROS DEL GRUPO
   //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1 and idGrupo='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
      $idEmpleado = $row['idRfc'];
      $Miembros = $this->pdo->prepare("SELECT idRfc,nombre,am,ap,email FROM empleado WHERE idRfc='$idEmpleado' AND indicador='A' ");
            //Ejecución de la sentencia SQL.
      $Miembros->execute();
      $res[]=$Miembros->fetch(PDO::FETCH_ASSOC);

    }
    return $res;
  }

//OBTENER MIEMBROS DE LOS GRUPOS PUESTO
  else if($idAreaEnvios > 0 && $idAreaEnvios < 11)
  {
    $res=array();
    $resPuesto=array();
    $empleados=array();
      //OBTENER LOS MIEMBROS DE LA TABLA GRUPONIVELES
  //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM gruponiveles WHERE idgruposPuesto='$idAreaEnvios' and estatus=1");
            //Ejecución de la sentencia SQL.
    $stm->execute();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
      $resPuesto[] = $row['Puesto_puesto'];

    }

    foreach ($resPuesto as $puesto) {
      $Miembros = $this->pdo->prepare("SELECT idRfc,nombre,am,ap,email FROM empleado WHERE puesto='$puesto' and indicador='A'");
            //Ejecución de la sentencia SQL.
      $Miembros->execute();
      while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {
        // $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
        $nombre = $row['nombre'];
        $ap=$row['ap'];
        $am=$row['am'];
        $email = $row['email'];
        $empleados[]=array('nombre' => $nombre,'ap' => $ap,'am' => $am,'email' => $email);
      }
    }
    return $empleados;
  }
  else
  {
      //OBTENER LOS MIEMBROS DE LA SUBAREA

    //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado where idSubArea='$subAreaCorreo' and indicador='A'");
            //Ejecución de la sentencia SQL.
    $stm->execute();
    $res=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }
}
catch(Exception $e)
{
            //Obtener mensaje de error.
  die($e->getMessage());
}
}


    //OBTENER INFORMACION DEL CORREO PARA ALMACENARLA EN LA BASE DE DATOS
public function crearMail($idAreaEnvios,$subAreaCorreo,$asuntoCorreo,$Nameplantillas,$cuerpo,$nameEtiquetas)
{
  set_time_limit(50);
  try
  {
    $iduser=$_SESSION["usuario"]["idUsuario"];
        //OBTENER FECHA ACTUAL
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');
    $fecha_doc = date('d-m-Y');
    $arrayIdAdjuntos=array();

       //OBTENER DESTINATARIOS
    //DESTINATARIOS DE TODO EL IMTA
    if ($idAreaEnvios == 0.1) 
    {
             //OBTENER TODOS LO DESTINATARIOS DEL IMTA
             //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado WHERE indicador='A'");
            //Ejecución de la sentencia SQL.
      $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
       $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
       $correo = $row['email'];
       $idRfc = $row['idRfc'];

       $datos[] = array('nombre' => $nombre, 
        'correo' => $correo,'idRfc' => $idRfc);

     }

     // $arrayDestinatarios[]=$datos;
   }
   //OBTENER DESTINATARIOS DE TODA EL AREA SELECCIONADA
   elseif ($subAreaCorreo == 0.11) {

      //OBTENER LOS MIEMBROS DEL AREA
    //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado where idArea='$idAreaEnvios' and indicador='A'");
            //Ejecución de la sentencia SQL. 
    $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
    $datos=array();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
     $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
     $correo = $row['email'];
     $idRfc = $row['idRfc'];

     $datos[] = array('nombre' => $nombre, 
      'correo' => $correo,'idRfc' => $idRfc);
   }
     // $arrayDestinatarios[]=$datos;


 }
 //GRUPOS CREADOS POR EL USUSARIO
 elseif ($idAreaEnvios == 0.2) 
 {

    //OBTENER LOS MIEMBROS DEL GRUPO
   //Sentencia SQL para selección de datos.
  $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1 and idGrupo='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
  $stm->execute();
  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
    $idEmpleado = $row['idRfc'];
    $Miembros = $this->pdo->prepare("SELECT idRfc,nombre,am,ap,email FROM empleado WHERE idRfc='$idEmpleado' and indicador='A'");
            //Ejecución de la sentencia SQL.
    $Miembros->execute();
    while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {
     $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
     $correo = $row['email'];
     $idRfc = $row['idRfc'];

     $datos[] = array('nombre' => $nombre, 
      'correo' => $correo,'idRfc' => $idRfc);
   }
 }

   // $arrayDestinatarios[]=$datos;
}

//OBTENER MIEMBROS DE LA SUBAREA
else
{
    //OBTENER LOS MIEMBROS DE LA SUBAREA

    //Sentencia SQL para selección de datos.
  $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado where idSubArea='$subAreaCorreo' and indicador='A'");
            //Ejecución de la sentencia SQL.
  $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
   $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
   $correo = $row['email'];
   $idRfc = $row['idRfc'];

   $datos[] = array('nombre' => $nombre, 
    'correo' => $correo,'idRfc' => $idRfc);
 }
      //OBTENER LOS MIEMBROS DE LA TABLA GRUPONIVELES
  //Sentencia SQL para selección de datos.
 $stm = $this->pdo->prepare("SELECT * FROM gruponiveles WHERE idgruposPuesto='$idAreaEnvios' and estatus=1");
            //Ejecución de la sentencia SQL.
 $stm->execute();
 while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
  $puesto = $row['Puesto_puesto'];
  $Miembros = $this->pdo->prepare("SELECT idRfc,nombre,am,ap,email FROM empleado WHERE puesto='$puesto' and indicador='A'");
            //Ejecución de la sentencia SQL.
  $Miembros->execute();
  while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {
   $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
   $correo = $row['email'];
   $idRfc = $row['idRfc'];

   $datos[] = array('nombre' => $nombre, 
    'correo' => $correo,'idRfc' => $idRfc);


 }
}

// $arrayDestinatarios[]=$datos;
}          
 //FIN DE OBTENER DESTINATARIOS
      //DATOS DEL USUARIO QUE ESTA ENVIANDO EL CORREO
$idUser=$_SESSION["usuario"]["idUsuario"];

                       //Sentencia SQL para selección de datos.
$usuarioSQL = $this->pdo->prepare("SELECT Empleado_idRfc,correo FROM usuario WHERE idUsuario='$idUser'");
            //Ejecución de la sentencia SQL.
$usuarioSQL->execute();
$resultadoUsuario=$usuarioSQL->fetch(PDO::FETCH_ASSOC);
$idEmpleado = $resultadoUsuario['Empleado_idRfc'];
$correoEmpleado = $resultadoUsuario['correo'];

$empleadoSQL = $this->pdo->prepare("SELECT nombre,ap,am,idArea,idSubArea FROM empleado WHERE idRfc='$idEmpleado'");
            //Ejecución de la sentencia SQL.
$empleadoSQL->execute();
$resultadoEmpleado=$empleadoSQL->fetch(PDO::FETCH_ASSOC);
$nombre = $resultadoEmpleado['nombre']." ".$resultadoEmpleado['ap']." ".$resultadoEmpleado['am'] ;
$idArea=$resultadoEmpleado['idArea'];
$idSubArea=$resultadoEmpleado['idSubArea'];

            //FIN DATOS DEL QUE ENVIO EL CORREO

//SI EL USUARIO NO ELIGIO NINGUNA PLANTILLA
if ($Nameplantillas == 0) 
{

            // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
      //Server settings
      $mail->SMTPDebug = 2;                      // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'inventariotic8@gmail.com';                     // SMTP username
      $mail->Password   = 'imta2019';                               // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('inventariotic8@gmail.com', 'Listas de distribución');
      $mail->addAddress('loeo160013@upemor.edu.mx', 'Prueba Recibir');     // Add a recipient
      // $mail->addAddress('ellen@example.com');               // Name is optional
      // $mail->addReplyTo('info@example.com', 'Information');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      // Content
      $mail->isHTML(true);  
      $mail->Subject = 'UTF-8';     
      // Set email format to HTML
      $asuntoLimpio=$this->eliminar_acentos($asuntoCorreo);
      $mail->Subject = $asuntoLimpio;
      // $mail->Body    = $cuerpo;
      $archivos = " ";
      $archivoMsg=" ";


      // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Attachments

      //COMPROBAR SI LOS ARCHIVOS NO SUPERAN EL TAMAÑO QUE TIENE PERMITIDO EL USUARIO SUBIR
          if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
           $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tamano = $_FILES["archivos"]["size"][$key];
          $totalSize=$tamano + $totalSize;
        } #if
        } # foreach
    } # if

           //CONVERSION DE MB A BYTES
    $tamanoBytes=$_SESSION["usuario"]["Tarchivo"] * 1048576;
    if ($totalSize > $tamanoBytes) {
      echo "SUPERASTE EL TAMAÑO DE ARCHIVO PERMITIDO";
    }
    else
    {

        if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
          $archivoMsg .= "<ul>";
          $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
          $name = $_FILES["archivos"]["name"][$key];
          $tamano = $_FILES["archivos"]["size"][$key];
          $nombre = pathinfo($name, PATHINFO_FILENAME);
          $ext = pathinfo($name, PATHINFO_EXTENSION);
          // OBTENER EXTENSION DEL ARCHIVO
          // $info = new SplFileInfo($name);
          // $extension=$info->getExtension();
          $nombreSinEspacio = str_replace(' ', "_", $nombre);
          $identificador=$this->numerosAleatorios();
          $nombreFinal=$this->eliminar_acentos($nombreSinEspacio);
            $nombreArchivo = $nombreFinal . '_' . $fecha_doc . '_' . $identificador . '.' . $ext; # Generar un nombre único para el archivo

            $ligaArchivo="http://localhost/sild/Adjuntos/". $nombreArchivo;
            // 'http://localhost/sild/Adjuntos/$nombreArchivo'
            $archivoMsg .= "<b>Archivo Adjunto</b>";
            $archivoMsg .= "<li>Nombre: $name <br>Liga: <a href=".$ligaArchivo.">$ligaArchivo</a> </li>";


          // Si se van a guardar los archivos en un directorio, deberían descomentarse
          // las siguientes líneas, si se van a guardar los nombres 
          // de los archivos en una base de datos, aquí debería realizarse algo...         

          move_uploaded_file($tmp_name,"../Adjuntos/$nombreArchivo"); # Guardar el archivo en una ubicación, debe tener los permisos necesarios

          // echo 'http://localhost/sild/Adjuntos/'. $name;

          //INSERTAR ARCHIVOS EN BASE DE DATOS.
          $guardarArchivos = $this->pdo->prepare("INSERT INTO adjuntos(nombre_archivo, ruta, tamano) VALUES ('$nombreArchivo','$ligaArchivo','$tamano')");
          $guardarArchivos->execute();
          $ultimoIdAdjunto=$this->pdo->lastInsertId();
          $arrayIdAdjuntos[]=array('ultimoIdAdjunto' => $ultimoIdAdjunto);

        } #if

        } # foreach

        $archivoMsg .= "</ul>";

    } # if
  }

var_dump($datos);

  $cuerpo.=$archivoMsg;
  $mail->Body = $cuerpo;

    //INSERTAR CORREO EN LA BASE DE DATOS
//IF ANIDADOS PARA SABER A QUE GRUPO O SUBAREA SE ENVIO EL CORREO
  if ($idAreaEnvios == 0.1) 
  {
    $destinatario="TODO EL IMTA";
  }
  else if ($subAreaCorreo==0.11)
  {
    //OBTENER NOMBRE DE LA AREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM area WHERE idArea='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $area=$resultado['area'];
    $destinatario="TODA EL ÁREA DE ".$area."";
  }
  else if ($idAreaEnvios == 0.2) {

    $idUser=$_SESSION["usuario"]["idUsuario"];
        //OBTENER NOMBRE DEL GRUPO
    $stm = $this->pdo->prepare("SELECT * FROM grupo WHERE estatusGrupo=1 and idUserGrupo='$iduser' and idGrupo='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombre_grupo'];
  }
  else if($subAreaCorreo==0)
  {


              //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM grupospuesto WHERE idgruposPuesto='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombreGrupoPuesto'];

  }
  else
  {
            //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM subarea WHERE idSubArea='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['subarea'];
  }

    //INSERTAR CORREO EN LA BASE DE DATOS

  $idUser=$_SESSION["usuario"]["idUsuario"];


  $guardarCorreo = $this->pdo->prepare("INSERT INTO correo(asunto, mensaje, fechac, idUsuarioEnvioCorreo, grupoDestinatario) VALUES ('$asuntoCorreo','$cuerpo','$fecha_actual','$iduser','$destinatario')");
  $guardarCorreo->execute();
  // var_dump($guardarCorreo);


  $ultimoIdGuardarCorreo=$this->pdo->lastInsertId();

  //GUARDAR EL SEGUIMIENTO DE CORREO
  $guardarSeguimiento = $this->pdo->prepare("INSERT INTO seguimiento_correo(Estatus_idEstatus, Correo_idCorreo, fechaActualizar, estatusSeguimiento) VALUES (1,'$ultimoIdGuardarCorreo','$fecha_actual',1)");
  $guardarSeguimiento->execute();

  
  if ($nameEtiquetas!=0) {

   $guardarEtiqueta = $this->pdo->prepare("INSERT INTO carpeta_correo (idCarpeta, Correo_idCorreo, idUsuarioCarpetaCorreo,carpetaEstatus) VALUES ('$nameEtiquetas','$ultimoIdGuardarCorreo','$idUser',1)");
            //Ejecución de la sentencia SQL.
   $guardarEtiqueta->execute();
 }

   //RECORRER ARREGLO DE DESTINATARIOS E INSERTAR EN LA BASE DE DATOS
//  foreach ($arrayDestinatarios as $row)
//  {
//   foreach ($row as $key ) {
//     $idRfc=$key['idRfc'];
//     $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
//     $guardarDestinatarios->execute();
//   } 
// }


 foreach ($datos as $key ) {
  $idRfc=$key['idRfc'];
  $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
  $guardarDestinatarios->execute();
} 

   // //INSERTAR EN LA TABLA CORREO ADJUNTOS, PARA RELACIONAR LOS ARCHIVOS CON EL CORREO

if (!empty($arrayIdAdjuntos)) 
{
  for ($i=0;  $i < sizeof($arrayIdAdjuntos) ; $i++) { 
    $idAdjuntos=$arrayIdAdjuntos[$i]['ultimoIdAdjunto'];
    $guardarAdjuntoCorreo = $this->pdo->prepare("INSERT INTO correo_adjuntos(idAdjuntos, Correo_idCorreo) VALUES ('$idAdjuntos','$ultimoIdGuardarCorreo')");
    $guardarAdjuntoCorreo->execute();
  }
}

    // var_dump($arrayDestinatarios);
// var_dump($datos);
  //  foreach ($datos as $email) {
  //   var_dump($email['correo']);
  //   var_dump($email['nombre']);
  // // $mail->AddAddress($email); // Cargamos el e-mail destinatario a la clase PHPMailer
  // // $mail->Send(); // Realiza el envío =)
  // // $mail->ClearAddresses(); // Limpia los "Address" cargados previamente para volver a cargar uno.
  // }



      // $mail->send();
echo 'Se ha enviado el correo';

} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

//SI EL USUARIO ELIGIO ALGUNA PLANTILLA, SE BUSCA LA PLANTILLA QUE ELIGIO EN LA BASE DE DATOS
else
{

          //Sentencia SQL para selección de datos.
  $plantillaSQL = $this->pdo->prepare("SELECT encabezado FROM plantilla WHERE idPlantilla='$Nameplantillas'");
            //Ejecución de la sentencia SQL.
  $plantillaSQL->execute();
  $resultadoPlantilla=$plantillaSQL->fetch(PDO::FETCH_ASSOC);
  $encabezado = $resultadoPlantilla['encabezado'];
   // $marcaDeAgua = $resultadoPlantilla['marcaDeAgua'];
   // $pieDePagina = $resultadoPlantilla['pieDePagina'];
  if (!isset($resultadoPlantilla['marcaDeAgua'])) {
    $marcaDeAgua=0;

  }
  if (!isset($resultadoPlantilla['pieDePagina'])) {
    $pieDePagina=0;

  }

                // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
      //Server settings
      $mail->SMTPDebug = 2;                      // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'inventariotic8@gmail.com';                     // SMTP username
      $mail->Password   = 'imta2019';                               // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('inventariotic8@gmail.com', 'Enviado Prueba');
      $mail->addAddress('loeo160013@upemor.edu.mx', 'Prueba Recibir');     // Add a recipient
      // $mail->addAddress('ellen@example.com');               // Name is optional
      // $mail->addReplyTo('info@example.com', 'Information');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      // Content
      $mail->isHTML(true);  
      $mail->Subject = 'UTF-8';     
      // Set email format to HTML
      $asuntoLimpio=$this->eliminar_acentos($asuntoCorreo);
      $mail->Subject = $asuntoLimpio;

      if ($marcaDeAgua != NULL) {

       $mail->Body    =

       "<div id='encabezado'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>
       ".$cuerpo."
       <div id='piePagina'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>";

     }

     if ($pieDePagina != NULL) {

       $mail->Body    =
       "<div id='encabezado'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>
       ".$cuerpo."
       <div id='marcaDeAgua'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>";
     }

     $mail->Body    =
     "<div id='encabezado'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>
     ".$cuerpo."";

     $archivos = " ";
     $archivoMsg=" ";


      //COMPROBAR SI LOS ARCHIVOS NO SUPERAN EL TAMAÑO QUE TIENE PERMITIDO EL USUARIO SUBIR
          if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
           $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tamano = $_FILES["archivos"]["size"][$key];
          $totalSize=$tamano + $totalSize;
        } #if
        } # foreach
    } # if

           //CONVERSION DE MB A BYTES
    $tamanoBytes=$_SESSION["usuario"]["Tarchivo"] * 1048576;

    if ($totalSize > $tamanoBytes) {
      echo "SUPERASTE EL TAMAÑO DE ARCHIVO PERMITIDO";
    }
    else
    {

        if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
          $archivoMsg .= "<ul>";
          $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
          $name = $_FILES["archivos"]["name"][$key];
          $tamano = $_FILES["archivos"]["size"][$key];
          $nombre = pathinfo($name, PATHINFO_FILENAME);
          $ext = pathinfo($name, PATHINFO_EXTENSION);
          $identificador=$this->numerosAleatorios();
          $nombreSinEspacio = str_replace(' ', "_", $nombre);
          $nombreFinal=$this->eliminar_acentos($nombreSinEspacio);
            $nombreArchivo = $nombreFinal . '_' . $fecha_doc . '_' . $identificador . '.' . $ext; # Generar un nombre único para el archivo

            $ligaArchivo="http://localhost/sild/Adjuntos/". $nombreArchivo;
            // 'http://localhost/sild/Adjuntos/$nombreArchivo'
            $archivoMsg .= "<b>Archivo Adjunto</b>";
            $archivoMsg .= "<li>Nombre: $name <br>Liga: <a href=".$ligaArchivo.">$ligaArchivo</a> </li>";

          // Si se van a guardar los archivos en un directorio, deberían descomentarse
          // las siguientes líneas, si se van a guardar los nombres 
          // de los archivos en una base de datos, aquí debería realizarse algo...         

          move_uploaded_file($tmp_name,"../Adjuntos/$nombreArchivo"); # Guardar el archivo en una ubicación, debe tener los permisos necesarios

          //INSERTAR ARCHIVOS EN BASE DE DATOS.
          $guardarArchivos = $this->pdo->prepare("INSERT INTO adjuntos(nombre_archivo, ruta, tamano) VALUES ('$nombreArchivo','$ligaArchivo','$tamano')");
          $guardarArchivos->execute();
          $ultimoIdAdjunto=$this->pdo->lastInsertId();
          $arrayIdAdjuntos[]=array('ultimoIdAdjunto' => $ultimoIdAdjunto);

        } #if

        } # foreach

        $archivoMsg .= "</ul>";

    } # if
  }

  $cuerpo.=$archivoMsg;
  $mail->Body = $cuerpo;




    //INSERTAR CORREO EN LA BASE DE DATOS
//IF ANIDADOS PARA SABER A QUE GRUPO O SUBAREA SE ENVIO EL CORREO
  if ($idAreaEnvios == 0.1) 
  {
    $destinatario="TODO EL IMTA";
  }
  else if ($subAreaCorreo==0.11)
  {
    //OBTENER NOMBRE DE LA AREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM area WHERE idArea='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $area=$resultado['area'];
    $destinatario="TODA EL ÁREA DE ".$area."";
  }
  else if ($idAreaEnvios == 0.2) {

    $idUser=$_SESSION["usuario"]["idUsuario"];
        //OBTENER NOMBRE DEL GRUPO
    $stm = $this->pdo->prepare("SELECT * FROM grupo WHERE estatusGrupo=1 and idUserGrupo='$iduser' and idGrupo='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombre_grupo'];
  }
  else if($subAreaCorreo==0)
  {


              //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM grupospuesto WHERE idgruposPuesto='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombreGrupoPuesto'];

  }
  else
  {
            //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM subarea WHERE idSubArea='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['subarea'];
  }

    //INSERTAR CORREO EN LA BASE DE DATOS

  $idUser=$_SESSION["usuario"]["idUsuario"];


  $guardarCorreo = $this->pdo->prepare("INSERT INTO correo(asunto, mensaje, fechac, idUsuarioEnvioCorreo, grupoDestinatario) VALUES ('$asuntoCorreo','$cuerpo','$fecha_actual','$iduser','$destinatario')");
  $guardarCorreo->execute();
  // var_dump($guardarCorreo);


  $ultimoIdGuardarCorreo=$this->pdo->lastInsertId();


    //GUARDAR EL SEGUIMIENTO DE CORREO
  $guardarSeguimiento = $this->pdo->prepare("INSERT INTO seguimiento_correo(Estatus_idEstatus, Correo_idCorreo, fechaActualizar, estatusSeguimiento) VALUES (1,'$ultimoIdGuardarCorreo','$fecha_actual',1)");
  $guardarSeguimiento->execute();

  if ($nameEtiquetas!=0) {

   $guardarEtiqueta = $this->pdo->prepare("INSERT INTO carpeta_correo (idCarpeta, Correo_idCorreo, idUsuarioCarpetaCorreo,carpetaEstatus) VALUES ('$nameEtiquetas','$ultimoIdGuardarCorreo','$idUser',1)");
            //Ejecución de la sentencia SQL.
   $guardarEtiqueta->execute();
 }

   //RECORRER ARREGLO DE DESTINATARIOS E INSERTAR EN LA BASE DE DATOS
//  foreach ($arrayDestinatarios as $row)
//  {
//   foreach ($row as $key ) {
//     $idRfc=$key['idRfc'];
//     $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
//     $guardarDestinatarios->execute();
//   } 
// }

 foreach ($datos as $key ) {
  $idRfc=$key['idRfc'];
  $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
  $guardarDestinatarios->execute();
} 


   // //INSERTAR EN LA TABLA CORREO ADJUNTOS, PARA RELACIONAR LOS ARCHIVOS CON EL CORREO



if (!empty($arrayIdAdjuntos)) 
{
  for ($i=0;  $i < sizeof($arrayIdAdjuntos) ; $i++) { 
    $idAdjuntos=$arrayIdAdjuntos[$i]['ultimoIdAdjunto'];
    $guardarAdjuntoCorreo = $this->pdo->prepare("INSERT INTO correo_adjuntos(idAdjuntos, Correo_idCorreo) VALUES ('$idAdjuntos','$ultimoIdGuardarCorreo')");
    $guardarAdjuntoCorreo->execute();
  }
}

$guardarPlantilla = $this->pdo->prepare("INSERT INTO catalogoplantillas(idPlantillaCatalogo, idCorreoCatalogo) VALUES ('$Nameplantillas','$ultimoIdGuardarCorreo')");
$guardarPlantilla->execute();

$mail->send();
  // echo 'Message has been sent';
      // $mail->send();
echo 'Se ha enviado el correo';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


}

}
catch(Exception $e)
{
            //Obtener mensaje de error.
  die($e->getMessage());
}

}


//FUNCION PARA CORREOS PROGRAMADOS
public function crearMailProgramado($idAreaEnvios,$subAreaCorreo,$asuntoCorreo,$Nameplantillas,$cuerpo,$nameEtiquetas,$calendarioCorreo,$hora)
{
  try
  {
    $iduser=$_SESSION["usuario"]["idUsuario"];
        //OBTENER FECHA ACTUAL
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');
    $fecha_doc = date('d-m-Y');
    $arrayIdAdjuntos=null;

       //OBTENER DESTINATARIOS
    //DESTINATARIOS DE TODO EL IMTA
    if ($idAreaEnvios == 0.1) 
    {
             //OBTENER TODOS LO DESTINATARIOS DEL IMTA
             //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado WHERE indicador='A'");
            //Ejecución de la sentencia SQL.
      $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
       $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
       $correo = $row['email'];
       $idRfc = $row['idRfc'];

       $datos[] = array('nombre' => $nombre, 
        'correo' => $correo,'idRfc' => $idRfc);

     }
     
   }
      //OBTENER DESTINATARIOS DE TODA EL AREA SELECCIONADA
   elseif ($subAreaCorreo == 0.11) {

      //OBTENER LOS MIEMBROS DEL AREA
    //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado where idArea='$idAreaEnvios' and indicador='A'");
            //Ejecución de la sentencia SQL. 
    $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
    $datos=array();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
     $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
     $correo = $row['email'];
     $idRfc = $row['idRfc'];

     $datos[] = array('nombre' => $nombre, 
      'correo' => $correo,'idRfc' => $idRfc);
   }



 }
 //GRUPOS CREADOS POR EL USUSARIO
 elseif ($idAreaEnvios == 0.2) 
 {

    //OBTENER LOS MIEMBROS DEL GRUPO
   //Sentencia SQL para selección de datos.
  $stm = $this->pdo->prepare("SELECT idRfc FROM grupoempleado WHERE estatusMiembro=1 and idGrupo='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
  $stm->execute();
  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
    $idEmpleado = $row['idRfc'];
    $Miembros = $this->pdo->prepare("SELECT idRfc,nombre,am,ap,correo FROM usuario,empleado WHERE empleado.idRfc=usuario.Empleado_idRfc and empleado.idRfc='$idEmpleado' and indicador='A'");
            //Ejecución de la sentencia SQL.
    $Miembros->execute();
    while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {
     $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
     $correo = $row['correo'];
     $idRfc = $row['idRfc'];

     $datos[] = array('nombre' => $nombre, 
      'correo' => $correo,'idRfc' => $idRfc);
   }
 }


}

//OBTENER MIEMBROS DE LA SUBAREA
else
{
    //OBTENER LOS MIEMBROS DE LA SUBAREA

    //Sentencia SQL para selección de datos.
  $stm = $this->pdo->prepare("SELECT idRfc,nombre,ap,am,email FROM empleado where idSubArea='$subAreaCorreo' and indicador='A'");
            //Ejecución de la sentencia SQL.
  $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
   $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
   $correo = $row['email'];
   $idRfc = $row['idRfc'];

   $datos[] = array('nombre' => $nombre, 
    'correo' => $correo,'idRfc' => $idRfc);
 }
      //OBTENER LOS MIEMBROS DE LA TABLA GRUPONIVELES
  //Sentencia SQL para selección de datos.
 $stm = $this->pdo->prepare("SELECT * FROM gruponiveles WHERE idgruposPuesto='$idAreaEnvios' and estatus=1");
            //Ejecución de la sentencia SQL.
 $stm->execute();
 while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
  $puesto = $row['Puesto_puesto'];
  $Miembros = $this->pdo->prepare("SELECT idRfc,nombre,am,ap,email FROM empleado WHERE puesto='$puesto' and indicador='A'");
            //Ejecución de la sentencia SQL.
  $Miembros->execute();
  while ($row = $Miembros->fetch(PDO::FETCH_ASSOC)) {
   $nombre = $row['nombre']." ".$row['ap']." ".$row['am'] ;
   $correo = $row['email'];
   $idRfc = $row['idRfc'];

   $datos[] = array('nombre' => $nombre, 
    'correo' => $correo,'idRfc' => $idRfc);


 }
}

// $arrayDestinatarios[]=$datos;

}          
 //FIN DE OBTENER DESTINATARIOS
      //DATOS DEL USUARIO QUE ESTA ENVIANDO EL CORREO
$idUser=$_SESSION["usuario"]["idUsuario"];

                       //Sentencia SQL para selección de datos.
$usuarioSQL = $this->pdo->prepare("SELECT Empleado_idRfc,correo FROM usuario WHERE idUsuario='$idUser'");
            //Ejecución de la sentencia SQL.
$usuarioSQL->execute();
$resultadoUsuario=$usuarioSQL->fetch(PDO::FETCH_ASSOC);
$idEmpleado = $resultadoUsuario['Empleado_idRfc'];
$correoEmpleado = $resultadoUsuario['correo'];

$empleadoSQL = $this->pdo->prepare("SELECT nombre,ap,am,idArea,idSubArea FROM empleado WHERE idRfc='$idEmpleado'");
            //Ejecución de la sentencia SQL.
$empleadoSQL->execute();
$resultadoEmpleado=$empleadoSQL->fetch(PDO::FETCH_ASSOC);
$nombre = $resultadoEmpleado['nombre']." ".$resultadoEmpleado['ap']." ".$resultadoEmpleado['am'] ;
$idArea=$resultadoEmpleado['idArea'];
$idSubArea=$resultadoEmpleado['idSubArea'];

            //FIN DATOS DEL QUE ENVIO EL CORREO

//SI EL USUARIO NO ELIGIO NINGUNA PLANTILLA
if ($Nameplantillas == 0) 
{

            // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
      //Server settings
      // $mail->SMTPDebug = 2;                      // Enable verbose debug output
      // $mail->isSMTP();                                            // Send using SMTP
      // $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      // $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      // $mail->Username   = 'inventariotic8@gmail.com';                     // SMTP username
      // $mail->Password   = 'imta2019';                               // SMTP password
      // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      // $mail->Port       = 587;                                    // TCP port to connect to

      // //Recipients
      // $mail->setFrom('inventariotic8@gmail.com', 'Enviado Prueba');
      // $mail->addAddress('loeo160013@upemor.edu.mx', 'Prueba Recibir');     // Add a recipient
      // // $mail->addAddress('ellen@example.com');               // Name is optional
      // // $mail->addReplyTo('info@example.com', 'Information');
      // // $mail->addCC('cc@example.com');
      // // $mail->addBCC('bcc@example.com');

      // // Content
      // $mail->isHTML(true);  
      // $mail->Subject = 'UTF-8';     
      // // Set email format to HTML
      // $asuntoLimpio=$this->eliminar_acentos($asuntoCorreo);
      // $mail->Subject = $asuntoLimpio;
      // $mail->Body    = $cuerpo;
      $archivos = " ";
      $archivoMsg=" ";


      // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Attachments

      //COMPROBAR SI LOS ARCHIVOS NO SUPERAN EL TAMAÑO QUE TIENE PERMITIDO EL USUARIO SUBIR
          if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
           $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tamano = $_FILES["archivos"]["size"][$key];
          $totalSize=$tamano + $totalSize;
        } #if
        } # foreach
    } # if

           //CONVERSION DE MB A BYTES
    $tamanoBytes=$_SESSION["usuario"]["Tarchivo"] * 1048576;
    if ($totalSize > $tamanoBytes) {
      echo "SUPERASTE EL TAMAÑO DE ARCHIVO PERMITIDO";
    }
    else
    {

        if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
          $archivoMsg .= "<ul>";
          $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
          $name = $_FILES["archivos"]["name"][$key];
          $tamano = $_FILES["archivos"]["size"][$key];
          $nombre = pathinfo($name, PATHINFO_FILENAME);
          $ext = pathinfo($name, PATHINFO_EXTENSION);
          // OBTENER EXTENSION DEL ARCHIVO
          // $info = new SplFileInfo($name);
          // $extension=$info->getExtension();
          $nombreSinEspacio = str_replace(' ', "_", $nombre);
          $identificador=$this->numerosAleatorios();
          $nombreFinal=$this->eliminar_acentos($nombreSinEspacio);
            $nombreArchivo = $nombreFinal . '_' . $fecha_doc . '_' . $identificador . '.' . $ext; # Generar un nombre único para el archivo

            $ligaArchivo="http://localhost/sild/Adjuntos/". $nombreArchivo;
            // 'http://localhost/sild/Adjuntos/$nombreArchivo'
            $archivoMsg .= "<b>Archivo Adjunto</b>";
            $archivoMsg .= "<li>Nombre: $name <br>Liga: <a href=".$ligaArchivo.">$ligaArchivo</a> </li>";


          // Si se van a guardar los archivos en un directorio, deberían descomentarse
          // las siguientes líneas, si se van a guardar los nombres 
          // de los archivos en una base de datos, aquí debería realizarse algo...         

          move_uploaded_file($tmp_name,"../Adjuntos/$nombreArchivo"); # Guardar el archivo en una ubicación, debe tener los permisos necesarios

          // echo 'http://localhost/sild/Adjuntos/'. $name;

          //INSERTAR ARCHIVOS EN BASE DE DATOS.
          $guardarArchivos = $this->pdo->prepare("INSERT INTO adjuntos(nombre_archivo, ruta, tamano) VALUES ('$nombreArchivo','$ligaArchivo','$tamano')");
          $guardarArchivos->execute();
          $ultimoIdAdjunto=$this->pdo->lastInsertId();
          $arrayIdAdjuntos[]=array('ultimoIdAdjunto' => $ultimoIdAdjunto);

        } #if

        } # foreach

        $archivoMsg .= "</ul>";

    } # if
  }


  $cuerpo.=$archivoMsg;
  $mail->Body = $cuerpo;

    //INSERTAR CORREO EN LA BASE DE DATOS
//IF ANIDADOS PARA SABER A QUE GRUPO O SUBAREA SE ENVIO EL CORREO
  if ($idAreaEnvios == 0.1) 
  {
    $destinatario="TODO EL IMTA";
  }
  else if ($subAreaCorreo==0.11)
  {
    //OBTENER NOMBRE DE LA AREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM area WHERE idArea='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $area=$resultado['area'];
    $destinatario="TODA EL ÁREA DE ".$area."";
  }
  else if ($idAreaEnvios == 0.2) {

    $idUser=$_SESSION["usuario"]["idUsuario"];
        //OBTENER NOMBRE DEL GRUPO
    $stm = $this->pdo->prepare("SELECT * FROM grupo WHERE estatusGrupo=1 and idUserGrupo='$iduser' and idGrupo='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombre_grupo'];
  }
  else if($subAreaCorreo==0)
  {


              //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM grupospuesto WHERE idgruposPuesto='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombreGrupoPuesto'];

  }
  else
  {
            //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM subarea WHERE idSubArea='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['subarea'];
  }

    //INSERTAR CORREO EN LA BASE DE DATOS

  $idUser=$_SESSION["usuario"]["idUsuario"];


  $guardarCorreo = $this->pdo->prepare("INSERT INTO correo(asunto, mensaje, fechac, idUsuarioEnvioCorreo, grupoDestinatario) VALUES ('$asuntoCorreo','$cuerpo','$fecha_actual','$iduser','$destinatario')");
  $guardarCorreo->execute();
  // var_dump($guardarCorreo);


  $ultimoIdGuardarCorreo=$this->pdo->lastInsertId();

  //GUARDAR EL SEGUIMIENTO DE CORREO
  $guardarSeguimiento = $this->pdo->prepare("INSERT INTO seguimiento_correo(Estatus_idEstatus, Correo_idCorreo, fechaActualizar, estatusSeguimiento) VALUES (2,'$ultimoIdGuardarCorreo','$fecha_actual',1)");
  $guardarSeguimiento->execute();

  
  if ($nameEtiquetas!=0) {

   $guardarEtiqueta = $this->pdo->prepare("INSERT INTO carpeta_correo (idCarpeta, Correo_idCorreo, idUsuarioCarpetaCorreo,carpetaEstatus) VALUES ('$nameEtiquetas','$ultimoIdGuardarCorreo','$idUser',1)");
            //Ejecución de la sentencia SQL.
   $guardarEtiqueta->execute();
 }

   //RECORRER ARREGLO DE DESTINATARIOS E INSERTAR EN LA BASE DE DATOS
//  foreach ($arrayDestinatarios as $row)
//  {
//   foreach ($row as $key ) {
//     $idRfc=$key['idRfc'];
//     $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
//     $guardarDestinatarios->execute();
//   } 
// }

 foreach ($datos as $key ) {
  $idRfc=$key['idRfc'];
  $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
  $guardarDestinatarios->execute();
} 

   // //INSERTAR EN LA TABLA CORREO ADJUNTOS, PARA RELACIONAR LOS ARCHIVOS CON EL CORREO



if (!empty($arrayIdAdjuntos)) 
{
  for ($i=0;  $i < sizeof($arrayIdAdjuntos) ; $i++) { 
    $idAdjuntos=$arrayIdAdjuntos[$i]['ultimoIdAdjunto'];
    $guardarAdjuntoCorreo = $this->pdo->prepare("INSERT INTO correo_adjuntos(idAdjuntos, Correo_idCorreo) VALUES ('$idAdjuntos','$ultimoIdGuardarCorreo')");
    $guardarAdjuntoCorreo->execute();
  }
}

//GUARDAR DATOS EN LA TABLA DE PROGRAMADOS
$guardarCorreoProgramado = $this->pdo->prepare("INSERT INTO programarcorreos(fechaProgramar, hora, estatusProgramar, Correo_idCorreo) VALUES ('$calendarioCorreo','$hora',1,'$ultimoIdGuardarCorreo')");
$guardarCorreoProgramado->execute();





    // var_dump($arrayDestinatarios);
  //  foreach ($arrayDestinatarios as $email) {
  //   var_dump($email['correo']);
  // // $mail->AddAddress($email); // Cargamos el e-mail destinatario a la clase PHPMailer
  // // $mail->Send(); // Realiza el envío =)
  // // $mail->ClearAddresses(); // Limpia los "Address" cargados previamente para volver a cargar uno.
  // }

      // $mail->send();
//    echo '<script language="javascript">alert("error");</script>';
// echo 'Se ha enviado el correo';

} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

//SI EL USUARIO ELIGIO ALGUNA PLANTILLA, SE BUSCA LA PLANTILLA QUE ELIGIO EN LA BASE DE DATOS
else
{

          //Sentencia SQL para selección de datos.
  $plantillaSQL = $this->pdo->prepare("SELECT encabezado FROM plantilla WHERE idPlantilla='$Nameplantillas'");
            //Ejecución de la sentencia SQL.
  $plantillaSQL->execute();
  $resultadoPlantilla=$plantillaSQL->fetch(PDO::FETCH_ASSOC);
  $encabezado = $resultadoPlantilla['encabezado'];
   // $marcaDeAgua = $resultadoPlantilla['marcaDeAgua'];
   // $pieDePagina = $resultadoPlantilla['pieDePagina'];
  if (!isset($resultadoPlantilla['marcaDeAgua'])) {
    $marcaDeAgua=0;

  }
  if (!isset($resultadoPlantilla['pieDePagina'])) {
    $pieDePagina=0;

  }

                // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
      //Server settings
      $mail->SMTPDebug = 2;                      // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'inventariotic8@gmail.com';                     // SMTP username
      $mail->Password   = 'imta2019';                               // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('inventariotic8@gmail.com', 'Enviado Prueba');
      $mail->addAddress('loeo160013@upemor.edu.mx', 'Prueba Recibir');     // Add a recipient
      // $mail->addAddress('ellen@example.com');               // Name is optional
      // $mail->addReplyTo('info@example.com', 'Information');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      // Content
      $mail->isHTML(true);  
      $mail->Subject = 'UTF-8';     
      // Set email format to HTML
      $asuntoLimpio=$this->eliminar_acentos($asuntoCorreo);
      $mail->Subject = $asuntoLimpio;

      if ($marcaDeAgua != NULL) {

       $mail->Body    =

       "<div id='encabezado'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>
       ".$cuerpo."
       <div id='piePagina'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>";

     }

     if ($pieDePagina != NULL) {

       $mail->Body    =
       "<div id='encabezado'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>
       ".$cuerpo."
       <div id='marcaDeAgua'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>";
     }

     $mail->Body    =
     "<div id='encabezado'><img id='imgEncabezado' src='http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg' style='width: 80%; height: 80%;'></div>
     ".$cuerpo."";

     $archivos = " ";
     $archivoMsg=" ";


      //COMPROBAR SI LOS ARCHIVOS NO SUPERAN EL TAMAÑO QUE TIENE PERMITIDO EL USUARIO SUBIR
          if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
           $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tamano = $_FILES["archivos"]["size"][$key];
          $totalSize=$tamano + $totalSize;
        } #if
        } # foreach
    } # if

           //CONVERSION DE MB A BYTES
    $tamanoBytes=$_SESSION["usuario"]["Tarchivo"] * 1048576;

    if ($totalSize > $tamanoBytes) {
      echo "SUPERASTE EL TAMAÑO DE ARCHIVO PERMITIDO";
    }
    else
    {

        if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
          $archivoMsg .= "<ul>";
          $totalSize=0;
      foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
        if ($error == UPLOAD_ERR_OK) { // Si no hay error
          $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
          $name = $_FILES["archivos"]["name"][$key];
          $tamano = $_FILES["archivos"]["size"][$key];
          $nombre = pathinfo($name, PATHINFO_FILENAME);
          $ext = pathinfo($name, PATHINFO_EXTENSION);
          $identificador=$this->numerosAleatorios();
          $nombreSinEspacio = str_replace(' ', "_", $nombre);
          $nombreFinal=$this->eliminar_acentos($nombreSinEspacio);
            $nombreArchivo = $nombreFinal . '_' . $fecha_doc . '_' . $identificador . '.' . $ext; # Generar un nombre único para el archivo

            $ligaArchivo="http://localhost/sild/Adjuntos/". $nombreArchivo;
            // 'http://localhost/sild/Adjuntos/$nombreArchivo'
            $archivoMsg .= "<b>Archivo Adjunto</b>";
            $archivoMsg .= "<li>Nombre: $name <br>Liga: <a href=".$ligaArchivo.">$ligaArchivo</a> </li>";

          // Si se van a guardar los archivos en un directorio, deberían descomentarse
          // las siguientes líneas, si se van a guardar los nombres 
          // de los archivos en una base de datos, aquí debería realizarse algo...         

          move_uploaded_file($tmp_name,"../Adjuntos/$nombreArchivo"); # Guardar el archivo en una ubicación, debe tener los permisos necesarios

          //INSERTAR ARCHIVOS EN BASE DE DATOS.
          $guardarArchivos = $this->pdo->prepare("INSERT INTO adjuntos(nombre_archivo, ruta, tamano) VALUES ('$nombreArchivo','$ligaArchivo','$tamano')");
          $guardarArchivos->execute();
          $ultimoIdAdjunto=$this->pdo->lastInsertId();
          $arrayIdAdjuntos[]=array('ultimoIdAdjunto' => $ultimoIdAdjunto);

        } #if

        } # foreach

        $archivoMsg .= "</ul>";

    } # if
  }

  $cuerpo.=$archivoMsg;
  $mail->Body = $cuerpo;




    //INSERTAR CORREO EN LA BASE DE DATOS
//IF ANIDADOS PARA SABER A QUE GRUPO O SUBAREA SE ENVIO EL CORREO
  if ($idAreaEnvios == 0.1) 
  {
    $destinatario="TODO EL IMTA";
  }
  else if ($subAreaCorreo==0.11)
  {
    //OBTENER NOMBRE DE LA AREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM area WHERE idArea='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $area=$resultado['area'];
    $destinatario="TODA EL ÁREA DE ".$area."";
  }
  else if ($idAreaEnvios == 0.2) {

    $idUser=$_SESSION["usuario"]["idUsuario"];
        //OBTENER NOMBRE DEL GRUPO
    $stm = $this->pdo->prepare("SELECT * FROM grupo WHERE estatusGrupo=1 and idUserGrupo='$iduser' and idGrupo='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombre_grupo'];
  }
  else if($subAreaCorreo==0)
  {


              //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM grupospuesto WHERE idgruposPuesto='$idAreaEnvios'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['nombreGrupoPuesto'];

  }
  else
  {
            //OBTENER NOMBRE DE LA SUBAREA AL QUE SE ENVIO EL CORREO
    $stm = $this->pdo->prepare("SELECT * FROM subarea WHERE idSubArea='$subAreaCorreo'");
  //Ejecución de la sentencia SQL.
    $stm->execute();
    $resultado=$stm->fetch(PDO::FETCH_ASSOC);

    $destinatario=$resultado['subarea'];
  }

    //INSERTAR CORREO EN LA BASE DE DATOS

  $idUser=$_SESSION["usuario"]["idUsuario"];


  $guardarCorreo = $this->pdo->prepare("INSERT INTO correo(asunto, mensaje, fechac, estatus, idUsuarioEnvioCorreo, grupoDestinatario) VALUES ('$asuntoCorreo','$cuerpo','$fecha_actual',1,'$iduser','$destinatario')");
  $guardarCorreo->execute();
  // var_dump($guardarCorreo);


  $ultimoIdGuardarCorreo=$this->pdo->lastInsertId();


    //GUARDAR EL SEGUIMIENTO DE CORREO
  $guardarSeguimiento = $this->pdo->prepare("INSERT INTO seguimiento_correo(Estatus_idEstatus, Correo_idCorreo, fechaActualizar, estatusSeguimiento) VALUES (2,'$ultimoIdGuardarCorreo','$fecha_actual',1)");
  $guardarSeguimiento->execute();

  if ($nameEtiquetas!=0) {

   $guardarEtiqueta = $this->pdo->prepare("INSERT INTO carpeta_correo (idCarpeta, Correo_idCorreo, idUsuarioCarpetaCorreo,carpetaEstatus) VALUES ('$nameEtiquetas','$ultimoIdGuardarCorreo','$idUser',1)");
            //Ejecución de la sentencia SQL.
   $guardarEtiqueta->execute();
 }

   //RECORRER ARREGLO DE DESTINATARIOS E INSERTAR EN LA BASE DE DATOS
//  foreach ($arrayDestinatarios as $row)
//  {
//   foreach ($row as $key ) {
//     $idRfc=$key['idRfc'];
//     $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
//     $guardarDestinatarios->execute();
//   } 
// }

 foreach ($datos as $key ) {
  $idRfc=$key['idRfc'];
  $guardarDestinatarios = $this->pdo->prepare("INSERT INTO destinatario(idCorreo, Empleado_idRfc) VALUES ('$ultimoIdGuardarCorreo','$idRfc')");
  $guardarDestinatarios->execute();
} 

   // //INSERTAR EN LA TABLA CORREO ADJUNTOS, PARA RELACIONAR LOS ARCHIVOS CON EL CORREO



if (!empty($arrayIdAdjuntos)) 
{
  for ($i=0;  $i < sizeof($arrayIdAdjuntos) ; $i++) { 
    $idAdjuntos=$arrayIdAdjuntos[$i]['ultimoIdAdjunto'];
    $guardarAdjuntoCorreo = $this->pdo->prepare("INSERT INTO correo_adjuntos(idAdjuntos, Correo_idCorreo) VALUES ('$idAdjuntos','$ultimoIdGuardarCorreo')");
    $guardarAdjuntoCorreo->execute();
  }
}

$guardarPlantilla = $this->pdo->prepare("INSERT INTO catalogoplantillas(idPlantillaCatalogo, idCorreoCatalogo) VALUES ('$Nameplantillas','$ultimoIdGuardarCorreo')");
$guardarPlantilla->execute();

//GUARDAR DATOS EN LA TABLA DE PROGRAMADOS
$guardarCorreoProgramado = $this->pdo->prepare("INSERT INTO programarcorreos(fechaProgramar, hora, estatusProgramar, Correo_idCorreo) VALUES ('$calendarioCorreo','$hora',1,'$ultimoIdGuardarCorreo')");
$guardarCorreoProgramado->execute();

  // $mail->send();
  // echo 'Message has been sent';
      // $mail->send();
echo 'Se ha enviado el correo';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


}

}
catch(Exception $e)
{
            //Obtener mensaje de error.
  die($e->getMessage());
}

}



//FUNCION PARA LLENAR LA TABLA DE CORREOS ENVIADOS
public function obtenerEnviados()
{

  try
  {

    $idEmpleado=$_SESSION["usuario"]["idUsuario"];

            //Sentencia SQL para selección de datos.
    $stm = $this->pdo->prepare("SELECT * FROM correo WHERE idUsuarioEnvioCorreo='$idEmpleado' ORDER BY fechac DESC");
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
      $buscarSeguimiento = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=1 AND estatusSeguimiento=1");
      $buscarSeguimiento->execute();

      while ($filaSeguimiento = $buscarSeguimiento->fetch(PDO::FETCH_ASSOC)) {

       $idSeguimiento_correo=$filaSeguimiento['idSeguimiento_correo'];


       $enlaceCorreo="<td><div class='col text-center'><a href='?c=Envios&a=correoEnviado&g=".$dataIdCorreo[$i]['idCorreo']."' title='Ver correo'>".$dataIdCorreo[$i]['grupoDestinatario']."</a></div></td>";

       $asuntoC="<td><div class='col text-center'>".$dataIdCorreo[$i]['asunto']."</div></td>";

       $BotonEliminar="<td><div class='col text-center'><button onclick='borrarCorreoEnviado(".$dataIdCorreo[$i]['idCorreoSecundario'].");' title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";

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



//ELIMINAR CORREO ENVIADOS

public function eliminarCorreoEnviado($idCorreo)
{
  try
  {
          //OBTENER FECHA ACTUAL
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');

    $buscarCorreo = $this->pdo->prepare("SELECT * FROM seguimiento_correo WHERE Correo_idCorreo='$idCorreo' AND Estatus_idEstatus=1 AND estatusSeguimiento=1");
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

//LLENAR FORMULARIO DE CORREO

public function ObtenerCorreo($idCorreo)
{
  try
  {
   $infoCorreo = $this->pdo->prepare("SELECT * FROM correo WHERE idCorreo='$idCorreo'");
            //Ejecución de la sentencia SQL.
   // $infoCorreo->execute();
   $infoCorreo->execute(array($idCorreo));
   return $infoCorreo->fetch(PDO::FETCH_OBJ);
   // $resultadoCorreo=$infoCorreo->fetch(PDO::FETCH_ASSOC);
   // // $mensaje=$resultadoCorreo['mensaje'];

   // return $resultadoCorreo;
 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

//CREAR NUMEROS ALEATORIOS PARA IDENTIFICAR LOS ARCHIVOS
public function numerosAleatorios()
{

  return rand(100,100001);
}

public function eliminar_acentos($cadena){

    //Reemplazamos la A y a
  $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
  );

    //Reemplazamos la E y e
  $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );

    //Reemplazamos la I y i
  $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );

    //Reemplazamos la O y o
  $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );

    //Reemplazamos la U y u
  $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );

    //Reemplazamos la N, n, C y c
  $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $cadena
  );

  return $cadena;
}




//LAVE FINAL
}
