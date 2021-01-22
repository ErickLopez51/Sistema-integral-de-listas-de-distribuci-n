<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/Usuario.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class Usuarios
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();


    $this->modelo = new Usuario();
  }

  public function index()
  {
    require_once 'Vista/Login/Login.php';	

  }


	//Los parametros que recibe son: $usuario: es el correo del usuario y $password: es la contraseña del usuario
    //manda a llamar a la funcion login y retorna.
  public static function login($usuario, $password)
  {

    $obj_usuario = new EntidadesUsuario();
    $obj_usuario->setCorreo($usuario);
    $obj_usuario->setPassword($password);

    return Usuario::login($obj_usuario);
  }

  public function getUsuario($usuario, $password)
  {
    $obj_usuario = new EntidadesUsuario();
    $obj_usuario->setCorreo($usuario);
    $obj_usuario->setPassword($password);

    return Usuario::getUsuario($obj_usuario);
  }

  public function ingresar()
  {

    $this->seguimientoUsuario();
        //Comparar el tipo de usuario que inicio sesión
    $contraNueva="IMTA2019";
    $contra=sha1($contraNueva);

    if (isset($_SESSION["usuario"])) {
      if ($_SESSION["usuario"]["tipo"] == 2 and strcasecmp ($_SESSION["usuario"]["password"], $contra) === 0) {

       require_once 'Vista/Login/Login2.php'; 

     }
     else if ($_SESSION["usuario"]["tipo"] == 1)
     {
       require_once 'Vista/Header.php';
       require_once 'Vista/Email/BandejaEntrada.php'; 
       require_once 'Vista/Footer.php';    

     }
     else if ($_SESSION["usuario"]["tipo"] == 2) {
       require_once 'Vista/Header.php';
       require_once 'Vista/Email/BandejaEntrada.php'; 
       require_once 'Vista/Footer.php';   

     } else {
          //retornar al login
      $this->index();
    }
  }
  else
  {
      //retornar al login
    // header("location: Login.php");
    $this->index();
  }
}

public function seguimientoUsuario()
{
  $ipCliente=$this->getRealIP();
   $this->modelo->seguimientoSesion($ipCliente);
}

        //obtener IP DEL CLIENTE

  public function getRealIP()
  {

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
      return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
      return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
      return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
      return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
      return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
      return $_SERVER["REMOTE_ADDR"];
    }

  }

public function salir()
{
  session_destroy();
  session_unset();
  require_once 'Vista/Login/Login.php';  
}

//VISTA PARA CREAR NUEV CONTRASEÑA
public function vistaNuevaContra()
{
  require_once 'Vista/Login/NuevaContrasena.php';  
  usent($_SESSION['correoUsuario']);
}
/*
public function mostrar_preguntasecreta(){
    $data=$this->modelo->obtenerPreguntasecreta();
    return $data;
}

public function nuevaContra()
{
    $newcontra= new Usuario();
    $pregunta=$this->mostrar_preguntasecreta();
    require_once 'Vista/Login/Login2.php';    
}
*/

public function GuardarContra()
{
  $contra1=$_POST['txtPasswordN'];
  $contra2=$_POST['txtPasswordN2'];


  header('Content-type: application/json');
  $resultado = array();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strcasecmp ($contra1, $contra2) === 0)
    {
      $contra1  = validar_campo($_POST["txtPasswordN"]);
      $contra2 = validar_campo($_POST["txtPasswordN2"]);
    //ENCRIPTAR CONTRASEÑA
    //$txtPasswordN = password_hash($contra1, PASSWORD_BCRYPT);
      $datos = array(

        'txtPasswordN' => $_POST['txtPasswordN']
      );
      $this->modelo->actualizarContra($datos);
     //si es correcto manda un texto de true
      $resultado = array("estado" => "true");
      return print(json_encode($resultado));
    }
  }
//Si los datos no son correctos retorna false
  $resultado = array("estado" => "false");

  return print(json_encode($resultado));

}

public function GuardarContraRecuperar()
{

  header('Content-type: application/json');
  $resultado = array();

  $contra1=$_POST['txtPasswordN'];
  $contra2=$_POST['txtPasswordN2'];
  $correo=$_SESSION['correoUsuario'];

  //VALIDAR CAMPOS VACIOS
  if ($contra1==null || $contra2==null) {
    $resultado = array("estado" => "vacio");
    return print(json_encode($resultado));
  }
  else if (strcasecmp ($contra1, $contra2) === 0) 
  {
     //ENCRIPTAR CONTRASEÑA
    //$txtPasswordN = password_hash($contra1, PASSWORD_BCRYPT);
    $datos = array(

      'txtPasswordN' => $_POST['txtPasswordN']
    );
    $this->modelo->actualizarContraRecuperar($datos,$correo);
    session_destroy();
    $resultado = array("estado" => "true");
    return print(json_encode($resultado));
  }
  else
  {
        $resultado = array("estado" => "error");
    return print(json_encode($resultado));
  }

  $resultado = array("estado" => "false");
  return print(json_encode($resultado));


}


public function MainUsuario()
{
 require_once 'Vista/Header.php';
 require_once 'Vista/Footer.php'; 
}



public function RestablecerContra()
{
  require_once 'Vista/Login/RestablecerContra.php';  
}

public function InformacionPerfil()
{

  require_once 'Vista/Header.php';
  require_once 'Vista/InfoPerfil.php'; 
  require_once 'Vista/Footer.php';   
}

public function cambiarContrasena()
{
 $contraActual=$_POST['contraActual'];
 $contraNueva=$_POST['contraNueva'];
 $confirmarContra=$_POST['confirmarContra'];  
 $dataCambioContra=$this->modelo->cambioDeContrasena($contraActual,$contraNueva,$confirmarContra);
}

public function datosPerfil()
{
  $datosPerfil=$this->modelo->InfoPerfil();
}

public function recuperarContrasena()
{

 $correoRecuperar=$_POST['correoRecuperar'];
 $_SESSION['correoUsuario']=$_POST['correoRecuperar'];
 $codigo = $this->codigoRandom();
 $_SESSION['ard']=$codigo;
 header('Content-type: application/json');
 $resultado = array(); 

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($correoRecuperar == '')
  {
    $resultado = array("estado" => "false");
    return print(json_encode($resultado));
  }
  else
  {
    $datosUsuario=$this->modelo->buscarCorreo($correoRecuperar);

    if ($datosUsuario==false) {

     $resultado = array("estado" => "noExiste");
     return print(json_encode($resultado));

   }
   else
   {
    $correoRecuperar=$this->modelo->enviarCorreoRecuperacion($codigo,$datosUsuario);
    if ($correoRecuperar == true) {
      $resultado = array("estado" => "existe");
      return print(json_encode($resultado));
    }
  }
}
}
}
//DAR DE BAJA CODIGO CUANDO SE TERMINE EL TIEMPO
public function BajaCode()
{


  $code=$_POST['code'];
  $this->modelo->CodigoExpiro($code);
  

}


//MOSTRAR VISTA PARA RECUPERAR LA CONTRASEÑA
public function vistaRecuperarContrasena()
{
  require_once 'Vista/Login/CodigoResContra.php'; 
}

//CREAR CODIGO PARA RECUPERAR CONTRASEÑA
public function codigoRandom()
{
  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
  srand((double)microtime()*1000000);
  $i = 0;
  $pass = '' ;

  while ($i <= 7) {
    $num = rand() % 33;
    $tmp = substr($chars, $num, 1);
    $pass = $pass . $tmp;
    $i++;
  }

  // return time().$pass;
  return $pass;
}

//FUNCION PARA BUSCAR CODIGO DE RECUPERACION EN LA BASE DE DATOS
public function validarCodigo()
{
 $codigoRecuperar=$_POST['codigoRecuperar'];
 $resCodigo=$this->modelo->buscarCodigo($codigoRecuperar);

 if (empty($resCodigo)) {

    // var_dump("SI EL CODIGO ESTA MAL");
  $resultado = array("estado" => "false");
  return print(json_encode($resultado));

}
else
{
     //DAR DE BAJA CODIGO
  $this->modelo->codigoBaja($codigoRecuperar);
    // var_dump("EL CODIGO ES CORRECTO");
  $resultado = array("estado" => "true");
  return print(json_encode($resultado));

}
}



//LLAVE FINAL
}


