<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Librerias/Conexion.php");

/**
 * 
 */
class Plantilla 
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

  public function obtenerPlantillas()
  {
    try
    {


                    //Sentencia SQL para selección de datos.
      $stm = $this->pdo->prepare("SELECT * FROM plantilla where estatus = 1");


            //Ejecución de la sentencia SQL.
      $stm->execute();
      $datos = array();
      while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

        $idPlantilla = $row['idPlantilla'];
        $idPlantillaURL = base64_encode($row['idPlantilla']);
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];

        if ($descripcion == '') {
          $descripcion="<td><i>Sin descripción</i></td>";
        }

        $fechaCreacionPlantilla = $row['fechaCreacionPlantilla'];

        $BotonEditar="<td><div class='col text-center'><a href='?c=Plantillas&a=VistaEditarPlantilla&g=".$idPlantillaURL."' title='Editar información' class='btn btn-warning btn-circle'><i class='editar fas fa-edit'></i></a></div></td>";

        $BotonEliminar="<td><div class='col text-center'><button onclick='alertaPlantilla(".$idPlantilla.");'  title='Dar de baja' class='bajaUsuario btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div></td>";



        $datos[] = array(
          'nombre' => $nombre, 
          'descripcion' => $descripcion,
          'fechaCreacionPlantilla' => $fechaCreacionPlantilla,  
          'BotonEditar' => $BotonEditar, 
          'BotonEliminar' => $BotonEliminar);

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

    //GUARDAR PLANTILLA
  public function guardarPlantilla($nombrePlantilla,$descripcionPlantilla)
  {
    try
    {
        //   header('Content-type: application/json');
        //   $resultado = array();
        //     //VALIDAR SI LA VARIABLE NOMBRE PLANTILLA NO ESTA VACIA
        //   if ($nombrePlantilla==null) {
        //     $resultado = array("estado" => "vacio");
        //     return print(json_encode($resultado));
        // }

        // var_dump( $_FILES["encabezadoPlantilla"]["name"]);

      date_default_timezone_set('America/Mexico_City');
      $fecha_actual = date('Y-m-d H:i:s');
      $anio = date('Y');

      $ultimoId=null;
      $ultimoId=$_SESSION['ultimoId']+1;
      // unset($_SESSION['ultimoId']);


            //GUARDAR IMAGENES
      if ( $_FILES["encabezadoPlantilla"]["error"] > 0 && $_FILES["marcaAgua"]["error"] > 0 && $_FILES["piePagina"]["error"] > 0)
      {
             // echo "error";
         // $resultado = array("estado" => "false");
         // return print(json_encode($resultado));
      }
      else
      {
       $permitidos = array("image/png","image/pjpeg","image/jpeg");
       $limite_kb=1000;

       if(in_array($_FILES["encabezadoPlantilla"]["type"], $permitidos) && $_FILES["encabezadoPlantilla"]["size"] < $limite_kb * 1024 || in_array($_FILES["marcaAgua"]["type"], $permitidos) && $_FILES["marcaAgua"]["size"] < $limite_kb * 1024 || in_array($_FILES["piePagina"]["type"], $permitidos) && $_FILES["piePagina"]["size"] < $limite_kb * 1024 )
       {

                //GUARDAR ARCHIVO

        $ruta = '../Plantillas/'.$ultimoId.'-'.$nombrePlantilla.'-'.$anio.'/';

        $encabezadoImagen=$ruta.$_FILES["encabezadoPlantilla"]["name"];

        var_dump($ruta);


        if ($_FILES["marcaAgua"]["name"] != NULL) {
          $marcaImagen=$ruta.$_FILES["marcaAgua"]["name"];
        }
        else
        {
          $marcaImagen=NULL;
        }

        if ($_FILES["piePagina"]["name"] != NULL) 
        {
          $pieImagen=$ruta.$_FILES["piePagina"]["name"];
        }
        else
        {
         $pieImagen=NULL;
       }

       if(!file_exists($ruta))
       {
        mkdir($ruta);
      }

      if(!file_exists($encabezadoImagen) || !file_exists($marcaImagen) || !file_exists($pieImagen))
      {

        $resultado1 = @move_uploaded_file($_FILES["encabezadoPlantilla"]["tmp_name"],$encabezadoImagen);
        $resultado2 = @move_uploaded_file($_FILES["marcaAgua"]["tmp_name"],$marcaImagen);
        $resultado3 = @move_uploaded_file($_FILES["piePagina"]["tmp_name"],$pieImagen);

        if($resultado1 || $resultado2 || $resultado3)
        {

                //CONSULTA PARA GUARDAR RUTA DE IMAGENES
                 //GUARDAR NOMBRE Y DESCRIPCION DE IMAGENES
          $guardarPlantilla = $this->pdo->prepare("INSERT INTO plantilla (nombre,descripcion,anio,encabezado,estatus,pieDepagina,marcaDeAgua,fechaCreacionPlantilla)
            VALUES ('$nombrePlantilla','$descripcionPlantilla','$anio','$encabezadoImagen',1,'$pieImagen','$marcaImagen','$fecha_actual')");
                        //Ejecución de la sentencia SQL.
          $guardarPlantilla->execute();
          $ultimoId=$this->pdo->lastInsertId();
          $_SESSION['ultimoId']=$ultimoId;
          var_dump($ruta);
                        //GUARDAR ARCHIVO
          $bien="bien";
          return $bien;
    
        }
        else
        {
         $error1="error1";
         return $error1;
                
       }

     }
     else
     {
  
       $error="error";
       return $error;
     }

   }
   else
   {
            
    $tamano="tamano";
    return $tamano;
  }
}




}
catch(Exception $e)
{
            //Obtener mensaje de error.
  die($e->getMessage());
}
}


//EDITAR PLANTILLA
public function editarPlantillaModelo($editarNombrePlantilla,$editarDescripcionPlantilla,$idPlantilla)
{
  try
  {


    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');
    $anio = date('Y');

            //GUARDAR IMAGENES
    if ( $_FILES["editarEncabezadoPlantilla"]["error"] > 0 && $_FILES["editarMarcaAgua"]["error"] > 0 && $_FILES["editarPiePagina"]["error"] > 0)
    {
      echo "error al cargar archivo";
    }
    else
    {
     $permitidos = array("image/png","image/pjpeg","image/jpeg");
     $limite_kb=1000;

     if(in_array($_FILES["editarEncabezadoPlantilla"]["type"], $permitidos) && $_FILES["editarEncabezadoPlantilla"]["size"] < $limite_kb * 1024 || in_array($_FILES["editarMarcaAgua"]["type"], $permitidos) && $_FILES["editarMarcaAgua"]["size"] < $limite_kb * 1024 || in_array($_FILES["editarPiePagina"]["type"], $permitidos) && $_FILES["editarPiePagina"]["size"] < $limite_kb * 1024 )
     {

                //GUARDAR ARCHIVO
      $ruta = '../Plantillas/'.$idPlantilla.'-'.$editarNombrePlantilla.'-'.$anio.'/';

      $encabezadoImagen=$ruta.$_FILES["editarEncabezadoPlantilla"]["name"];

      if ($_FILES["editarMarcaAgua"]["name"] != NULL) {
        $marcaImagen=$ruta.$_FILES["editarMarcaAgua"]["name"];
      }
      else
      {
        $marcaImagen=NULL;
      }

      if ($_FILES["editarPiePagina"]["name"] != NULL) 
      {
        $pieImagen=$ruta.$_FILES["editarPiePagina"]["name"];
      }
      else
      {
       $pieImagen=NULL;
     }

     if(!file_exists($ruta))
     {
      mkdir($ruta);
    }

    if(!file_exists($encabezadoImagen) || !file_exists($marcaImagen) || !file_exists($pieImagen))
    {

      $resultado1 = @move_uploaded_file($_FILES["editarEncabezadoPlantilla"]["tmp_name"],$encabezadoImagen);
      $resultado2 = @move_uploaded_file($_FILES["editarMarcaAgua"]["tmp_name"],$marcaImagen);
      $resultado3 = @move_uploaded_file($_FILES["editarPiePagina"]["tmp_name"],$pieImagen);

      if($resultado1 || $resultado2 || $resultado3)
      {


                 //CONSULTA PARA GUARDAR RUTA DE IMAGENES
                 //ACTUALIZAR NOMBRE Y DESCRIPCION DE IMAGENES

        $editarPlantilla = $this->pdo->prepare("UPDATE plantilla SET
         nombre='$editarNombrePlantilla', 
         descripcion='$editarDescripcionPlantilla',
         anio='$anio',
         encabezado='$encabezadoImagen',
         estatus=1,
         pieDepagina='$pieImagen',
         marcaDeAgua='$marcaImagen',
         fechaCreacionPlantilla='$fecha_actual' 
         WHERE idPlantilla='$idPlantilla'");
                        //Ejecución de la sentencia SQL.
        $editarPlantilla->execute();

          
         $bien="bien";
          return $bien;
        }
        else
        {
         $error1="error1";
         return $error1;
       }

     }
     else
     {
  
       $error="error";
       return $error;
     }

   }
   else
   {
                
    $tamano="tamano";
    return $tamano;

  }
}





}
catch(Exception $e)
{
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

//ELIMINAR PLANTILLA
public function deletePlantilla($idPlantilla)
{
  try
  {
   $borrarPlantilla = $this->pdo->prepare("UPDATE plantilla SET estatus = 0 WHERE idPlantilla = '$idPlantilla'");
            //Ejecución de la sentencia SQL.
   $borrarPlantilla->execute();
 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

//EDITAR PLANTILLA
public function ObtenerPantillaEditar($idPlantilla)
{
  try
  {
   $stm = $this->pdo->prepare("SELECT * FROM plantilla WHERE idPlantilla = '$idPlantilla'");
   $stm->execute(array($idPlantilla));
   return $stm->fetch(PDO::FETCH_OBJ);
 }
 catch(Exception $e)
 {
            //Obtener mensaje de error.
  die($e->getMessage());
}
}

}
