<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
// require_once ("$root/sild/app/Modelo/CorreosRecibido.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class RespaldoDB
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();
  }

  public function MainRespaldoBD()
  {

     require_once 'Vista/Header.php';
      require_once 'Vista/RespaldoBD/VistaRespaldoBD.php'; 
     require_once 'Vista/Footer.php';   
 

 }

   public function generarRespaldo()
  {
  $db_host = 'localhost'; //Host del Servidor MySQL
  $db_name = 'sild'; //Nombre de la Base de datos
  $db_user = 'root'; //Usuario de MySQL
  $db_pass = ''; //Password de Usuario MySQL
  
  date_default_timezone_set('America/Mexico_City');
  $fecha = date("Ymd-His"); //Obtenemos la fecha y hora para identificar el respaldo
    
 
  // Construimos el nombre de archivo SQL Ejemplo: mibase_20170101-081120.sql
  $salida_sql = $db_name.'_'.$fecha.'.sql'; 
  
  //Comando para genera respaldo de MySQL, enviamos las variales de conexion y el destino
$dump = "C:/xampp/mysql/bin/mysqldump --user=".$db_user." --password=".$db_pass." --host=".$db_host." ".$db_name." > $salida_sql";
  system($dump, $output); //Ejecutamos el comando para respaldo
  
  $zip = new ZipArchive(); //Objeto de Libreria ZipArchive
  
  //Construimos el nombre del archivo ZIP Ejemplo: mibase_20160101-081120.zip
  $salida_zip = $db_name.'_'.$fecha.'.zip';
  
  if($zip->open($salida_zip,ZIPARCHIVE::CREATE)===true) { //Creamos y abrimos el archivo ZIP
    $zip->addEmptyDir('C:/xampp/htdocs/sild/Copias de seguridad BD'); 
    $zip->addFile($salida_sql); //Agregamos el archivo SQL a ZIP
    $zip->close(); //Cerramos el ZIP
    unlink($salida_sql); //Eliminamos el archivo temporal SQL
    header ("Location: $salida_zip"); // Redireccionamos para descargar el Arcivo ZIP
    } else {
    echo 'Error'; //Enviamos el mensaje de error
  }  
 }
 
//LLAVE FINAL
}
