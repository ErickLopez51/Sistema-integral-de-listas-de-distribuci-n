<?php
//Llamar al controlador d eusuario y ayudas para los campos
//include 'Controlador/Usuarios.php';
//include 'Librerias/Helps.php';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once ("$root/sild/app/Controlador/Usuarios.php");
    require_once ("$root/sild/app/Librerias/Helps.php");

//Iniciar una sesión
session_start();

//Importar json
header('Content-type: application/json');
$resultado = array();

//Aqui se compara si los datos que se ingresaron al formulario son correctos o no
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["txtUsuario"]) && isset($_POST["txtPassword"])) {

        $txtUsuario  = validar_campo($_POST["txtUsuario"]);
         $contra = $_POST["txtPassword"];

        $txtPassword = sha1($contra);
      
        //si es correcto manda un texto de true
        $resultado = array("estado" => "true");

        //Obtener los datos del usuario
        if (Usuarios::login($txtUsuario, $txtPassword)) {
            $usuario             = Usuarios::getUsuario($txtUsuario, $txtPassword);
            $_SESSION["usuario"] = array(
              "idUsuario"         => $usuario->getIdUsuario(),
                "usuario"     => $usuario->getUsuario(),
                "correo"    => $usuario->getCorreo(),
                "password"    => $usuario->getPassword(),
                "tipo"      => $usuario->getTipo(),
                "estatus"      => $usuario->getEstatus(),
                "Empleado_idRfc"      => $usuario->getEmpleado_idRfc(),
                 "nombre"      => $usuario->GetnombreEmpleado(),
                 "papelera"      => $usuario->getTiempoPapelera(),
                 "bEntrada"      => $usuario->getTamBandeja(),
                 "Tarchivo"      => $usuario->getTamArchivo(),
            );
            return print(json_encode($resultado));
        }

    }
}
//Si los datos no son correctos retorna false
$resultado = array("estado" => "false");

return print(json_encode($resultado));
