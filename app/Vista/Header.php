<!DOCTYPE html>
<html lang="en">

<head>
  <title>SILD</title>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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


  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
  
<!--   <link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css"> -->

 <!-- <link href="/sild/Public/datepicker/jquery-ui.css" rel="stylesheet"> -->

<!--   <link href="/sild/Public/datepicker/jquery.timepicker.js" rel="stylesheet"> -->
  <link href="/sild/Public/datepicker/jquery.timepicker.css" rel="stylesheet"> 





   <!-- SELECT2-->
  <link href="/sild/Public/vendor/select2/css/select2.min.css" rel="stylesheet" />
 <link href="/sild/Public/vendor/select2/css/select2.css" rel="stylesheet" />

    <!-- sweetalert2-->
  <link href="/sild/Public/css/sweetalert2.min.css" rel="stylesheet">

      <!-- DATATABLE EXPORT STYLE-->
  <link href="/sild/Public/DataTableExport/css/buttons.dataTables.min.css" rel="stylesheet">

      <!-- DATATABLE checkbox-->
  <link href="/sild/Public/DataTableExport/css/dataTables.checkboxes.css" rel="stylesheet">

    <!-- summernote -->
  <link rel="stylesheet" href="/sild/Public/summernote/summernote-bs4.css">

   <link rel="stylesheet" href="/sild/Public/css/Estilo/buscarUsuarios.css">



  <!-- Custom styles for this page -->
  <link href="/sild/Public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

      <!-- favicon
    ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="/sild/Public/img/favicon.ico">


</head>

<body id="page-top">
  


  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="?c=Usuarios&a=ingresar">
        <div class="sidebar-brand-icon rotate-n-15">

             <!--  <img style="width: 40px" class="img-profile rounded-circle" src="/sild/Public/img/correo.png"> -->
              <img style="width: 90px"  src="/sild/Public/img/correoBlanco.png" alt="">
          <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3">IMTA<sup>SILD</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Redactar correo Boton -->
      <li class="nav-item">
        <a class="nav-link" href="?c=Envios&a=MainRedactar">
      <i class="far fa-envelope"></i>
          <span>Redactar</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
         Menú
      </div>

      <!-- Nav Item - Charts -->
      <!-- <li class="nav-item active"> -->
        <li class="nav-item">
        <a class="nav-link" href="?c=BandejaDeEntradas&a=MainBandejaDeEntrada">
         <i class="fas fa-inbox"></i>
          <span>Recibidos</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="?c=Envios&a=MainEnviados">
        <i class="far fa-paper-plane"></i>
          <span>Enviados</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="?c=CorreosProgramados&a=MainBorradores">
          <i class="fas fa-file"></i>
          <span>Borradores</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="?c=CorreosProgramados&a=MainProgramados">
          <i class="fas fa-clock"></i>
          <span>Programados</span></a>
      </li>

            <?php
      if (($_SESSION["usuario"]["tipo"] == 1)) 
      {
        ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Menú Admin
        </div>

          <li class="nav-item">
        <a class="nav-link" href="?c=Dashboards&a=MainDash">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>


        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Administrar</span>
          </a>
          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Menu Admin:</h6>
              <a class="collapse-item active" href="?c=Reportes&a=MainReportes"><i class="far fa-file-pdf"></i> Reportes</a>
              <a class="collapse-item active" href="?c=CorreosProgramados&a=verCorreosProgramados"><i class="fas fa-clock"></i> Correos programados</a>
              <a class="collapse-item active" href="?c=GestionarUsuarios&a=MainGestorUsuarios"><i class="fas fa-user-friends"></i> Gestión de Usuarios</a>
              <a class="collapse-item active" href="?c=GestionarGrupos&a=MainGestorGrupos"><i class="fas fa-users-cog"></i> Gestión de Grupos</a>
              <a class="collapse-item active" href="?c=GestionarEtiquetas&a=MainGestorEtiquetas"><i class="fas fa-tags"></i> Gestión de Etiquetas</a>
              <a class="collapse-item active" href="?c=GestionarCorreos&a=MainGestorCorreos"><i class="fas fa-envelope"></i> Ver todos los correos</a>
              <a class="collapse-item active" href="?c=Plantillas&a=MainPlantillas"><i class="fas fa-edit"></i> Plantillas</a>
              <a class="collapse-item active" href="?c=ConfiguracionesUsuarios&a=MainConfiguracion"><i class="fas fa-cogs"></i> Configuración</a>
              <a class="collapse-item active" href="?c=RespaldoDB&a=MainRespaldoBD"><i class="fas fa-database"></i> Respaldo BD</a>
            </div>
          </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <?php
      }
      ?>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="?c=Carpetas&a=MainCarpetas">
         <i class="fas fa-tags"></i>
          <span>Etiquetas de correo</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="?c=Grupos&a=MainGrupo">
         <i class="fas fa-users"></i>
          <span>Grupos</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="?c=Papeleras&a=MainPapelera">
         <i class="fas fa-trash-alt"></i>
          <span>Papelera</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- Fin del menu-->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
               <img src="/sild/Public/img/logo_logo_imta2019.png">
              <!-- <img class="img-profile rounded-circle" src="/sild/Public/img/logo_logo_imta2019.png"> -->
          <!--     <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt=""> -->
         <!--      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div> -->
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
        <!--     <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i> -->
                <!-- Counter - Alerts -->
               <!--  <span class="badge badge-danger badge-counter">3+</span>
              </a> -->
              <!-- Dropdown - Alerts -->
      <!--         <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li> -->

            <!-- Nav Item - Messages -->

            <li class="nav-item dropdown no-arrow mx-1">

               <li class="nav-item dropdown no-arrow mx-1">
              <a href="?c=ChatController&a=MainChat" title="Chat" class="nav-link dropdown-toggle"><i class="fas fa-comments"></i></a>
            </li>

             <!--  <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fas fa-comments"></i> -->
                <!-- Counter - Messages -->
             <!--    <span class="badge badge-danger badge-counter">7</span>
              </a> -->
              <!-- Dropdown - Messages -->

          
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo utf8_encode($_SESSION["usuario"]["nombre"]); ?></span>
                <img class="img-profile rounded-circle" src="/sild/Public/img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="?c=Usuarios&a=InformacionPerfil">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Perfil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar sesión
                </a>
              </div>
            </li>

          </ul>
        </nav>
        <!-- End of Topbar -->

