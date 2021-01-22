<?php 
//$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
//header("refresh:200; url=$self"); //Refrescamos cada 300 segundos
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>SILD</title>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!--NOTIFICACIONES JS -->
  <link rel="stylesheet" type="text/css" href="/sild/Public/css/overhang.min.css" />

  <!-- Custom fonts for this template-->
  <link href="/sild/Public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/sild/Public/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="/sild/Public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- favicon
          ============================================ -->
          <link rel="shortcut icon" type="image/x-icon" href="/sild/Public/img/favicon.ico">
                    <link href="/sild/Public/css/Estilo/login.css" rel="stylesheet">



        </head>
        <body class="bg-gradient-primary">


<div class="wrapper">
        <div id="formContent">
            <!-- Tabs Titles -->

            <div>
                <h4>
                    Nueva contraseña
                </h4>
            </div>

            <!-- Icon -->
            <div>
                <img src="/sild/Public/img/lock.png" id="icon" alt="User Icon" />
            </div>

            <div class="text-center">    <strong><span class="help-block" style="color: #8a9597;">Usa 8 o más caracteres con una combinación de letras, números y símbolos.</span></strong></div>
           

            <!-- Login Form -->
            <form  method="POST" id="restablecerContra" action="?c=Usuarios&a=GuardarContraRecuperar">


               <input type="hidden" id="correoRe" name="correoRe" value="<?php echo $_SESSION['correoUsuario']; ?>">
                  <input type="password" id="txtPasswordN" name="txtPasswordN" placeholder="Nueva Contraseña">
                   <i class="fa fa-eye" id="nuevaCon"></i>
                    <p class="form-alert" id="alertaNuevaContra" style="display:none;color:red;">Minimo 8 carateres</p>
                <input type="password" id="txtPasswordN2" name="txtPasswordN2" placeholder="Repetir Contraseña">
                 <i class="fa fa-eye" id="repetirContra"></i>
                  <p class="form-alert" id="alertaRepetirContra" style="display:none;color:red;">Minimo 8 carateres</p>
                
                <div class="loginButton">
                    <input type="submit" value="Guardar">
                </div>
                
            </form>
                               <!-- Footer -->
        <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2019 <a href="https://www.gob.mx/imta">Instituto Mexicano de Tecnología del Agua (IMTA)</a></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

        </div>
    </div>



        <!-- Bootstrap core JavaScript-->
        <script src="/sild/Public/vendor/jquery/jquery.min.js"></script>
        <script src="/sild/Public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="/sild/Public/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="/sild/Public/js/sb-admin-2.min.js"></script>


        <!--NOTIFICACIONES JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/sild/Public/js/overhang.min.js"></script>


        <!-- Page level plugins -->
        <script src="/sild/Public/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="/sild/Public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="/sild/Public/js/demo/datatables-demo.js"></script>

  <script src="/sild/Public/js/appJS/app.js"></script>

  <script src="/sild/Public/js/appJS/RecuperarContrasena.js"></script>



      </body>

      </html>
