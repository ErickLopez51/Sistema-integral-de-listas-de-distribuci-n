<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/RedactarCorreo.php");
require_once ("$root/sild/app/Librerias/Helps.php");

require_once ("$root/sild/Public/PHPMailer/src/Exception.php");
require_once ("$root/sild/Public/PHPMailer/src/PHPMailer.php");
require_once ("$root/sild/Public/PHPMailer/src/SMTP.php");


/**
 * 
 */
class Envios
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
    $this->modelo = new RedactarCorreo();
  }

  public function MainRedactar()
  { 
   $area=$this->modelo->obtenerAreaEnviados();
   $gruposPuesto=$this->modelo->obtenerGruposPuesto();
   $plantilla=$this->modelo->listarPlantillas();
   $etiqueta=$this->modelo->listarEtiquetas();

   require_once 'Vista/Header.php';
   require_once 'Vista/Email/Redactar.php';  
   require_once 'Vista/Footer.php';   
 }

 public function MainEnviados()
 { 
   require_once 'Vista/Header.php';
   require_once 'Vista/Email/CorreosEnviados.php';  
   require_once 'Vista/Footer.php';   
 }

 public function VistaListaDestino()
 { 
     $lista = new RedactarCorreo();

    // $idAreaEnvios=base64_decode($_REQUEST['A']);
    // $subAreaCorreo=base64_decode($_REQUEST['S']);

    $idAreaEnvios=$_REQUEST['A'];
    $subAreaCorreo=$_REQUEST['S'];
    
  $lista=$this->modelo->obtenerListaDestino($idAreaEnvios,$subAreaCorreo);

   require_once 'Vista/Header.php';
   require_once 'Vista/Email/ListaCorreoEnviado.php';  
   require_once 'Vista/Footer.php';   
 }

 public function mostrarCorreosEnviados()
 { 

  $correosEnviados=$this->modelo->obtenerEnviados();
 }

public function seleccionarPlantilla()
{ 

  $idPlantilla=$_POST['idPlantilla'];
  $plantillaSeleccionada=$this->modelo->obtenerPlantilla($idPlantilla);
}

public function mostrarSubAreaEnvios()
{

 $idArea=$_POST['idArea'];
 $data=$this->modelo->obtenerSubareaEnviados($idArea);
}

public function mostrarGruposEnvios()
{

 $idArea=$_POST['idArea'];
 $dataGrupos=$this->modelo->obtenerGruposSelect($idArea);
   // var_dump($data);
}



public function destinatariosTabla()
{ 

 $idArea=$_POST['idArea'];
 $idSubarea=$_POST['idSubarea'];
 $destinatarios=$this->modelo->obtenerDestinatarios($idArea,$idSubarea);
 
}

public function archivoCorreo()
{ 

 if ($_FILES['file']['name']) {
  if (!$_FILES['file']['error']) {
    $name = md5(rand(100, 200));
    $ext = explode('.', $_FILES['file']['name']);
    $filename = $name . '.' . $ext[1];
                $destination = '../imagenesCorreo/'. $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                // $ligaImagen='http://localhost/sild/imagenesCorreo/'. $filename;
                // $ligaImagen=' http://tajin.imta.mx/comunicados/2019/'. $filename;

                echo "http://tajin.imta.mx/comunicados/2019/Boletin_octubre_2019_1.jpg";
                  // echo 'http://tajin.imta.mx/comunicados/2019/'. $filename;//change this URL
                //echo 'http://localhost/sild/imagenesCorreo/'. $filename;//change this URL
              }
              else
              {
                echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
              }
            }
          }

          public function archivosAdjuntos()
          { 

   // print_r($_POST);

       // echo htmlspecialchars($_POST['compose-textarea']);


     // $cuerpo=htmlspecialchars($_POST['compose-textarea']);
       // $cuerpo=$_POST['compose-textarea'];
       // var_dump($cuerpo);


    //           // Instantiation and passing `true` enables exceptions
    //         $mail = new PHPMailer(true);

    //         try {
    //   //Server settings
    //   $mail->SMTPDebug = 2;                      // Enable verbose debug output
    //   $mail->isSMTP();                                            // Send using SMTP
    //   $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    //   $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    //   $mail->Username   = 'inventariotic8@gmail.com';                     // SMTP username
    //   $mail->Password   = 'imta2019';                               // SMTP password
    //   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    //   $mail->Port       = 587;                                    // TCP port to connect to

    //   //Recipients
    //   $mail->setFrom('inventariotic8@gmail.com', 'Enviado Prueba');
    //   $mail->addAddress('loeo160013@upemor.edu.mx', 'Prueba Recibir');     // Add a recipient
    //   // $mail->addAddress('ellen@example.com');               // Name is optional
    //   // $mail->addReplyTo('info@example.com', 'Information');
    //   // $mail->addCC('cc@example.com');
    //   // $mail->addBCC('bcc@example.com');

    //   // Attachments
    //   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //   // Content
    //   $mail->isHTML(true);  
    //   $mail->Subject = 'UTF-8';     
    //   // Set email format to HTML
    //   $mail->Subject = 'Asunto';
    //   $mail->Body    = "

    //   <div id='encabezado'></div>
    //   ".$cuerpo."
    //    <div id='piePagina'> </div>";



    //   $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //   $mail->send();
    //   echo 'Message has been sent';
    // } catch (Exception $e) {
    //   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    // }


    //   if (isset ($_FILES["archivos"])) { # Si es que se subió algún archivo
    //   foreach ($_FILES["archivos"]["error"] as $key => $error) { # Iterar sobre la colección de archivos
    //     if ($error == UPLOAD_ERR_OK) { // Si no hay error
    //       $tmp_name = $_FILES["archivos"]["tmp_name"][$key];
    //       $name = $_FILES["archivos"]["name"][$key];
    //       // OBTENER EXTENSION DEL ARCHIVO
    //       // $info = new SplFileInfo($name);
    //       // var_dump($info->getExtension());
    //       $name = uniqid('bc') . '_' . $name; # Generar un nombre único para el archivo
    //       // $mail -> AddAttachment ($tmp_name, $name); # Añade el archivo adjunto
    //       // var_dump($name);

    //       // Si se van a guardar los archivos en un directorio, deberían descomentarse
    //       // las siguientes líneas, si se van a guardar los nombres 
    //       // de los archivos en una base de datos, aquí debería realizarse algo...         

    //       move_uploaded_file($tmp_name, "../Adjuntos/$name"); # Guardar el archivo en una ubicación, debe tener los permisos necesarios

    //       // echo 'http://localhost/sild/Adjuntos/'. $name;

    //      //  $_SESSION['ligaAdjunto']= 'http://localhost/sild/Adjuntos/'. $name;
    //      // return $_SESSION['ligaAdjunto'];

    //     } #if
    //     } # foreach
    // } # if

 // if ($_FILES['file']['name']) {
 //  if (!$_FILES['file']['error']) {
 //    $name = md5(rand(100, 200));
 //    $ext = explode('.', $_FILES['file']['name']);
 //    $filename = $name . '.' . $ext[1];
 //                $destination = '../imagenesCorreo/'. $filename; //change this directory
 //                $location = $_FILES["file"]["tmp_name"];
 //                move_uploaded_file($location, $destination);
 //                $ligaImagen='http://localhost/sild/imagenesCorreo/'. $filename;
 //                echo 'http://localhost/sild/imagenesCorreo/'. $filename;//change this URL
 //              }
 //              else
 //              {
 //                echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
 //              }
 //            }
          }

          public function enviarCorreo()
          {

  //   // Primero creamos un ID de conexión a nuestro servidor
  // $cid = ftp_connect("tajin.imta.mx");
  // // Luego creamos un login al mismo con nuestro usuario y contraseña
  // $resultado = ftp_login($cid, "developer","dev123456");
  // // Comprobamos que se creo el Id de conexión y se pudo hacer el login
  // if ((!$cid) || (!$resultado)) {
  //   echo "Fallo en la conexión"; die;
  // } else {
  //   echo "Conectado.";
  // }
// $conn_id="tajin.imta.mx";
// $ftp_user_name="developer";
// $ftp_user_pass="dev123456";

            # Cambie estos datos por los de su Servidor FTP
// define("SERVER","tajin.imta.mx"); //IP o Nombre del Servidor
// define("PORT",22); //Puerto
// define("USER","developer"); //Nombre de Usuario
// define("PASSWORD","dev123456"); //Contraseña de acceso
// define("PASV",true); //Activa modo pasivo

// $id_ftp=ftp_connect(SERVER,PORT); //Obtiene un manejador del Servidor FTP
// ftp_login($id_ftp,USER,PASSWORD); //Se loguea al Servidor FTP
// ftp_pasv($id_ftp,MODO); //Establece el modo de conexión
// return $id_ftp; //Devuelve el manejador a la función

// $ftp_server = "tajin.imta.mx";
// $ftp_user = "developer";
// $ftp_pass = "dev123456";
// $port="22";

// // establecer una conexión o finalizarla
// $conn_id = ftp_connect($ftp_server,$port) or die("No se pudo conectar a $ftp_server"); 

// // intentar iniciar sesión
// if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
//     echo "Conectado como $ftp_user@$ftp_server\n";
// } else {
//     echo "No se pudo conectar como $ftp_user\n";
// }

// $connect= ftp_connect("tajin.imta.mx");

// $user= "developer";

// $password= "dev123456";

// $login= ftp_login($connect, $user, $password);

  //           // Primero creamos un ID de conexión a nuestro servidor
  // $cid = ftp_connect("tajin.imta.mx");
  // // Luego creamos un login al mismo con nuestro usuario y contraseña
  // $resultado = ftp_login($cid, "developer","dev123456");
  // // Comprobamos que se creo el Id de conexión y se pudo hacer el login
  // if ((!$cid) || (!$resultado)) {
  //   echo "Fallo en la conexión"; die;
  // } else {
  //   echo "Conectado.";
  // }


//   $conn_id="tajin.imta.mx";
//   $ftp_user_name="developer";
//   $ftp_user_pass="dev123456";

//   if($conn_id){
//      // login with username and password
//     var_dump($conn_id);
//      $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
// }
// else
// {
//   var_dump("FALSE");
// }

// $ftp_server = "tajin.imta.mx";

// // establecer una conexión o finalizarla
// $conn_id = ftp_connect($ftp_server) or die("No se pudo conectar a $ftp_server"); 
// var_dump($conn_id);


//             # Cambie estos datos por los de su Servidor FTP
// define("SERVER","tajin.imta.mx"); //IP o Nombre del Servidor
// define("PORT",22); //Puerto
// define("USER","developer"); //Nombre de Usuario
// define("PASSWORD","dev123456"); //Contraseña de acceso
// define("PASV",true); //Activa modo pasivo

//  $id_ftp=ftp_connect(SERVER,PORT) or die( "Error al conectar el server: " . SERVER . ", puerto: " . PORT ); //Obtiene un manejador del Servidor FTP
//  ftp_login($id_ftp,USER,PASSWORD); //Se loguea al Servidor FTP
//  ftp_pasv($id_ftp,PASV); //Establece el modo de conexión

// $host = 'tajin.imta.mx';
// $password = 'developer';
// $username = 'dev123456';
// $port = 22;
// $timeout = 29;

//       $con = ftp_connect($host, $port, $timeout);
//         if (false === $con) {
//             throw new Exception('Unable to connect to FTP Server.');
//         }
//         $loggedIn = ftp_login($con,  $username,  $password);
//         ftp_close($con);
//         if (true === $loggedIn) {
//             return true;
//         } else {
//             throw new Exception('Unable to log in.');
//         }

//  $servidor_ftp = "tajin.imta.mx";
// $conexion_id = ftp_connect($servidor_ftp);
// var_dump($conexion_id);
// $ftp_usuario = "developer";
// $ftp_clave = "dev123456";
// // $ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/tu_carpeta/local/";
// // $ftp_carpeta_remota= "/tu_carpeta/remota/";
// // $mi_nombredearchivo="nombre_archivo.jpg";
// // $nombre_archivo = $ftp_carpeta_local.$mi_nombredearchivo;
// // $archivo_destino = $ftp_remote_path.$mi_nombredearchivo;
// $resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave);
// if ((!$conexion_id) || (!$resultado_login)) {
//        echo  "La conexion ha fallado! al conectar con  $servidor_ftp para usuario $ftp_usuario";
//        exit;
//    } else {
//        echo "Conectado con $servidor_ftp, para usuario $ftp_usuario";
//    }
// $upload = ftp_put($conexion_id, $archivo_destino, $nombre_archivo, FTP_BINARY);
// if (!$upload) {
//        echo "Ha ocurrido un error al subir el archivo";
//    } else {
//        echo "Subido $nombre_archivo a $servidor_ftp as $archivo_destino";
//    }
// ftp_close($conexion_id);

            $idAreaEnvios=$_POST['idAreaEnvios'];
            $asuntoCorreo=$_POST['asuntoCorreo'];
            $Nameplantillas=$_POST['Nameplantillas'];
            $cuerpo=$_POST['compose-textarea'];
            $nameEtiquetas=$_POST['nameEtiquetas'];

            if (isset($_POST['subAreaCorreo'])) {
             $subAreaCorreo=$_POST['subAreaCorreo'];
           }
           else
           {
            $subAreaCorreo=0;
          }


            // var_dump("-----");
            // var_dump($subAreaCorreo);
            // var_dump("-----");
            // var_dump($asuntoCorreo);
            // var_dump("-----");
             // var_dump($subAreaCorreo); 
            // var_dump("-----");
            // var_dump($cuerpo); 
          $mail=$this->modelo->crearMail($idAreaEnvios,$subAreaCorreo,$asuntoCorreo,$Nameplantillas,$cuerpo,$nameEtiquetas);
          

        }

        public function enviarCorreoProgramado()
        {

          $idAreaEnvios=$_POST['idAreaEnvios'];
          $asuntoCorreo=$_POST['asuntoCorreo'];
          $Nameplantillas=$_POST['Nameplantillas'];
          $nameEtiquetas=$_POST['nameEtiquetas'];
          $cuerpo=$_POST['compose-textarea'];
          $calendarioCorreo=$_POST['calendarioCorreo'];
          $time=$_POST['time'];
          $hora=date("H:i",strtotime($time));


          if (isset($_POST['subAreaCorreo'])) {
           $subAreaCorreo=$_POST['subAreaCorreo'];
         }
         else
         {
          $subAreaCorreo=0;
        }


            // if ($subAreaCorreo == NULL) {
            //   $subAreaCorreo=0;
            // }

          // var_dump($calendarioCorreo);
          // var_dump($hora);
            // var_dump("-----");
            // var_dump($subAreaCorreo);
            // var_dump("-----");
            // var_dump($asuntoCorreo);
            // var_dump("-----");
             // var_dump($subAreaCorreo); 
            // var_dump("-----");
            // var_dump($cuerpo); 

        $mail=$this->modelo->crearMailProgramado($idAreaEnvios,$subAreaCorreo,$asuntoCorreo,$Nameplantillas,$cuerpo,$nameEtiquetas,$calendarioCorreo,$hora);
      }


            //DAR DE BAJA CORREO ENVIADO
      public function eliminarCorreoE()
      {

        $idCorreo = $_POST['idCorreoSecundario'];
        $this->modelo->eliminarCorreoEnviado($idCorreo);
      }

        //FUNCIONES PARA VER MENSAJE ENVIADO

      public function correoEnviado()
      {

        $datosCorreo = new RedactarCorreo();

        $idCorreo=base64_decode($_REQUEST['g']);
        //Se obtienen los datos del proveedor a editar.
        if(isset($idCorreo)){

          $datosCorreo = $this->modelo->ObtenerCorreo($idCorreo);
        }   
        
        $area=$this->modelo->obtenerAreaEnviados();
        $gruposPuesto=$this->modelo->obtenerGruposPuesto();
        $plantilla=$this->modelo->listarPlantillas();
        $etiqueta=$this->modelo->listarEtiquetas();
        require_once 'Vista/Header.php';
        require_once 'Vista/Email/EnviadoRedactar.php';  
        require_once 'Vista/Footer.php';
      }

//LLAVE FINAL
    }




