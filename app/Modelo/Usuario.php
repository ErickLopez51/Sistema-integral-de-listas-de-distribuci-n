<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/EntidadesUsuario.php");
require_once ("$root/sild/app/Librerias/Conexion.php");

require_once ("$root/sild/Public/PHPMailer/src/Exception.php");
require_once ("$root/sild/Public/PHPMailer/src/PHPMailer.php");
require_once ("$root/sild/Public/PHPMailer/src/SMTP.php");

/**
 * 
 */
class Usuario 
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

    /**
     * Metodo que sirve para validar el login
     *
     * @param      object         $usuario
     * @return     boolean
     */
    public static function login($usuario)
    {

     $query = "SELECT correo,password,Empleado_idRfc,estatus FROM usuario WHERE correo = :correo AND password = :password and estatus=1";

     self::getConexion();

     $resultado = self::$cnx->prepare($query);

     $resultado->bindValue(":correo", $usuario->getCorreo());
     $resultado->bindValue(":password", $usuario->getPassword());
     $resultado->execute();

     if ($resultado->rowCount() > 0) 
     {
      $filas = $resultado->fetch();

      if ($filas["correo"] == $usuario->getCorreo()  && $filas["password"] == $usuario->getPassword())
      {  
        return true;
      }
    }

    return false;
  }

    /**
     * Metodo que sirve obtener un usuario
     *
     * @param      object         $usuario
     * @return     object
     */
    public static function getUsuario($usuario)
    {
      $query = "SELECT idUsuario, usuario,password, correo, estatus, tipo,Empleado_idRfc  FROM usuario WHERE correo = :correo AND password = :password";

      self::getConexion();

      $resultado = self::$cnx->prepare($query);

      $resultado->bindValue(":correo", $usuario->getCorreo());
      $resultado->bindValue(":password", $usuario->getPassword());

      $resultado->execute();

      $filas = $resultado->fetch();

      $idEmpleado=$filas["Empleado_idRfc"];
      $tipoUsuario=$filas["tipo"];
      $idUsuario=$filas["idUsuario"];


         //Sentencia SQL para selección de datos.
      $queryEmpleado = ("SELECT nombre,am,ap FROM empleado WHERE idRfc='$idEmpleado'");


      $resultadoEmpleado = self::$cnx->prepare($queryEmpleado);

      $resultadoEmpleado->execute();
      $filasEmpleado = $resultadoEmpleado->fetch();

      if ($tipoUsuario==1) {
       $nombre = "Eres administrador: ".$filasEmpleado['nombre']." ".$filasEmpleado['ap']." ".$filasEmpleado['am'];

     }
     else if($tipoUsuario==2)
     {
       $nombre = $filasEmpleado['nombre']." ".$filasEmpleado['ap']." ".$filasEmpleado['am'];
     }

     //OBTENER DATOS DE LA CONFIGURACIÓN DE USUARIO
        $queryConfig = ("SELECT * FROM configusuario WHERE idUsuarioConfig='$idUsuario'");


      $resultadoConfig = self::$cnx->prepare($queryConfig);

      $resultadoConfig->execute();
      $filasconfig = $resultadoConfig->fetch();
      $papelera=$filasconfig["papelera"];
      $bEntrada=$filasconfig["bEntrada"];
      $Tarchivo=$filasconfig["Tarchivo"];
  

      if ($filasconfig["papelera"]==null) {
        $papelera=30;

      }
      if ($filasconfig["bEntrada"]==null)
      {

          $bEntrada=3;
     
      }
      if($filasconfig["Tarchivo"]==null)
      {
         $Tarchivo=300;

      }

     $usuario = new EntidadesUsuario();
     $usuario->setIdUsuario($filas["idUsuario"]);
     $usuario->setUsuario($filas["usuario"]);
     $usuario->setCorreo($filas["correo"]);
     $usuario->setPassword($filas["password"]);
     $usuario->setTipo($filas["tipo"]);
     $usuario->setEstatus($filas["estatus"]);
     $usuario->setEmpleado_idRfc($filas["Empleado_idRfc"]);
     $usuario->SetnombreEmpleado($nombre);
     $usuario->setTiempoPapelera($papelera);
     $usuario->setTamBandeja($bEntrada);
     $usuario->setTamArchivo($Tarchivo);

     return $usuario;
   }


   public function seguimientoSesion($ipCliente)
   {

     try{
                 //INSERTAR SEGUIMIENTO DE ACCESO AL USUARIO
      // var_dump($correo);
      // var_dump($ipCliente);
      
      date_default_timezone_set('America/Mexico_City');
      $fecha_actual = date('Y-m-d H:i:s');
      $idUser=$_SESSION["usuario"]["idUsuario"];

      $stm = $this->pdo->prepare("INSERT INTO seguimientoacceso(fechaSeg, ip, idUsuario) VALUES ('$fecha_actual','$ipCliente','$idUser')");
            //Ejecución de la sentencia SQL.
      $stm->execute();

    } 
    catch(Exception $e)
    {
            //Obtener mensaje de error.
      die($e->getMessage());
      return 0;
    }


  }




//FUNCION PARA ACTUALIZAR CONTRASEÑA AL INICIAR SESIÓN POR PRIMERA VEZ
  public function actualizarContra($datos)
  {
    try{
      $idUser=$_SESSION["usuario"]["idUsuario"];
      $txtPasswordN =sha1($datos['txtPasswordN']);


             //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("UPDATE usuario SET password='$txtPasswordN' WHERE idUsuario='$idUser' ");
            //Ejecución de la sentencia SQL.
      $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados

    } 
    catch(Exception $e)
    {
            //Obtener mensaje de error.
      die($e->getMessage());
      return 0;
    }

  }

  //FUNCION PARA RESTABLECER LA CONTRASEÑA
  public function actualizarContraRecuperar($datos,$correo)
  {
    try{

      // $txtPasswordN = $datos['txtPasswordN'];
       $txtPasswordN =sha1($datos['txtPasswordN']);


             //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("UPDATE usuario SET password='$txtPasswordN' WHERE correo='$correo' ");
            //Ejecución de la sentencia SQL.
      $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados

    } 
    catch(Exception $e)
    {
            //Obtener mensaje de error.
      die($e->getMessage());
      return 0;
    }

  }

  public function cambioDeContrasena($contraActual,$contraNueva,$confirmarContra)
  {
    try{
      $idUser=$_SESSION["usuario"]["idUsuario"];

             //Sentencia SQL para selección de datos.
      $contraActualSQL = $this->pdo->prepare("SELECT password FROM usuario WHERE idUsuario='$idUser'");
            //Ejecución de la sentencia SQL.
      $contraActualSQL->execute();
      $resultadoContraActual=$contraActualSQL->fetch(PDO::FETCH_ASSOC);
      $contraActualBase = $resultadoContraActual['password'];
      header('Content-type: application/json');
      $resultado = array();
      if (strcmp($contraActualBase,$contraActual) == 0 and strcmp($contraNueva,$confirmarContra) == 0)
      {
        $contra=sha1($contraNueva);

       $cambiarContra = $this->pdo->prepare("UPDATE usuario SET password='$contra' WHERE idUsuario='$idUser' ");
                 //Ejecución de la sentencia SQL.
       $cambiarContra->execute();
       $resultado = array("estadoContra" => "true");
       return print(json_encode($resultado));
     }
     elseif (strcmp($contraActualBase,$contraActual) != 0 || strcmp($contraNueva,$confirmarContra) != 0)
     {
       $resultado = array("estadoContra" => "false");
       return print(json_encode($resultado));
     }

   } 
   catch(Exception $e)
   {
            //Obtener mensaje de error.
    die($e->getMessage());
    return 0;
  }


}

public function InfoPerfil()
{
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

    //FUNCION PARA VERIFICAR SI EL CORREO ESTA DADO DE ALTA EN EL SISTEMA
public function buscarCorreo($correoRecuperar)
{
  try{

    header('Content-type: application/json');
    $resultado = array(); 

             //Sentencia SQL para selección de datos.
    $conCorreo = $this->pdo->prepare(" SELECT * FROM usuario WHERE correo='$correoRecuperar' ");
            //Ejecución de la sentencia SQL.
    $conCorreo->execute();
    $resultado=$conCorreo->fetch(PDO::FETCH_ASSOC);

    return $resultado;
  } 
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
    return 0;
  }
}

   //FUNCION PARA ENVIAR CORREO DE RECUPERACION
public function enviarCorreoRecuperacion($codigo,$datosUsuario)
{
  try{

    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');

      //CONSULTA PARA OBTENER DATOS DEL EMPLEADO
    header('Content-type: application/json');
    $resultado = array(); 

    $idEmpleado=$datosUsuario['Empleado_idRfc'];
    $correo=$datosUsuario['correo'];
    $idUser=$datosUsuario['idUsuario'];

             //Sentencia SQL para selección de datos.
    $empeladoInfo = $this->pdo->prepare("SELECT * FROM empleado WHERE idRfc='$idEmpleado'");
            //Ejecución de la sentencia SQL.
    $empeladoInfo->execute();
    $resultado=$empeladoInfo->fetch(PDO::FETCH_ASSOC);

    $nombre = $resultado['nombre']." ".$resultado['ap']." ".$resultado['am'] ;

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
      $mail->setFrom('inventariotic8@gmail.com', 'SILD');
      $mail->addAddress('loeo160013@upemor.edu.mx', 'Prueba Recibir');     // Add a recipient
      // $mail->addAddress('ellen@example.com');               // Name is optional
      // $mail->addReplyTo('info@example.com', 'Information');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      // Content
      $mail->isHTML(true);  
      $mail->Subject = 'UTF-8';     
      // Set email format to HTML
      $asunto='Recuperación de contraseña Sistema de Listas de Distribución del IMTA';
      $asuntoLimpio=$this->eliminar_acentos($asunto);
      $mail->Subject = $asuntoLimpio;
      // $mail->Body    = $cuerpo;
      $cuerpo = "Hola $nombre, has solicitado restablecer tu <b>contraseña.</b><br>Codigo de recuperación: $codigo";

      $mail->Body = $cuerpo;

      // $mail->send();

      if ($mail->send()) {
     //GUARDAR INFORMACIÓN DE RESTABLECER 
        $guardarRestablecimiento = $this->pdo->prepare("INSERT INTO restablecercontra (correoRestablecer,codigo,estatusRestablecer,fechaRestablecer,idUsuarioContra)
          VALUES ('$correo','$codigo',1,'$fecha_actual','$idUser')");
                        //Ejecución de la sentencia SQL.
      // $guardarRestablecimiento->execute();
        return true; 
      }




    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                  //Obtener mensaje de error.
      die($e->getMessage());
      die($mail->ErrorInfo);

      return 0;
      return false;
    }


  } 
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
    return 0;
  }
}

//FUNCION PARA DAR DE BAJA EL CODIGO DE RECUPERACION CUANDO SE TERMINE EL TIEMPO
public function CodigoExpiro($code)
{
  try{

             //Sentencia SQL para selección de datos.

    $codigo = $this->pdo->prepare(" UPDATE restablecercontra SET estatusRestablecer=0 WHERE codigo='$code'");
            //Ejecución de la sentencia SQL.
    $codigo->execute();
  } 
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
    return 0;
  }
}

//FUNCION PARA BUSCAR CODIGO DE RECUPERACION EN LA BASE DE DATOS

public function buscarCodigo($codigoRecuperar)
{
  try{

    header('Content-type: application/json');
    $resultado = array(); 

             //Sentencia SQL para selección de datos.
    $codigo = $this->pdo->prepare(" SELECT * FROM restablecercontra WHERE codigo='$codigoRecuperar' and estatusRestablecer=1 ");
            //Ejecución de la sentencia SQL.
    $codigo->execute();
    $resultado=$codigo->fetch(PDO::FETCH_ASSOC);

    return $resultado;
  } 
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
    return 0;
  }
}

//FUNCION PARA DAR DE BAJA CODIGO 

public function codigoBaja($codigoRecuperar)
{
  try{

    header('Content-type: application/json');
    $resultado = array(); 

             //Sentencia SQL para selección de datos.

    $codigo = $this->pdo->prepare(" UPDATE restablecercontra SET estatusRestablecer=0 WHERE codigo='$codigoRecuperar'");
            //Ejecución de la sentencia SQL.
    $codigo->execute();
  } 
  catch(Exception $e)
  {
            //Obtener mensaje de error.
    die($e->getMessage());
    return 0;
  }
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




//LLAVE FINAL
}



