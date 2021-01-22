<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user"></i> Perfil</h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Información de perfil.</h6> 
      <br>

      <form  id="frm-crearGrupo" action="" method="post" enctype="multipart/form-data">
       <div class="row">
        <div class="form-group col-5">
          <label for="exampleFormControlInput1"> Nombre:</label>
          <input disabled type="text" class="form-control" title="Nombre" id="nombreEmpleado">
        </div>
        <div class="form-group col-5">
         <label for="exampleFormControlSelect1">Correo:</label>
         <input disabled type="text" class="form-control" title="Correo" id="correoEmpleado"> 
       </div>

        <div class="form-group col-5">
         <label for="exampleFormControlSelect1">Area:</label>
         <input disabled type="text" class="form-control" title="Area" id="AreaEmpleado"> 
       </div>
        <div class="form-group col-5">
         <label for="exampleFormControlSelect1">Subarea:</label>
         <input disabled type="text" class="form-control" title="Subarea" id="SubareaEmpleado"> 
       </div>
       <div class="col-5">
        <button type="button" class="btn btn-warning btn-rounded" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-lock"></i> Cambiar contraseña</button> 
       </div>
     </div>
</form>

<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Restablecer contraseña</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="card shadow mb-3">
      <br>
          <div  class="form-group col-8">
            <h6 class="m-0 font-weight-bold text-primary">Cambiar la contraseña</h6> 
            <br>
          <label for="exampleFormControlInput1"> <strong><span style="color: red;">*</span> Contraseña actual:</strong></label>
          <i class="fa fa-eye" id="mostrarActual"></i>
          <input type="password" class="form-control" title="Introduzca su contraseña actual" name="contraActual" id="contraActual" placeholder="Contraseña actual..." >
          <p class="form-alert" id="alertaContraActual" style="display:none;color:red;">Maximo de caracteres permitidos</p>
        </div>
          <div class="form-group col-8">
          <label for="exampleFormControlInput1"> <strong><span style="color: red;">*</span> Nueva contraseña:</strong></label>
          <i class="fa fa-eye" id="mostrarNueva"></i>
          <input type="password" class="form-control" title="Introduzca su nueva contraseña" name="nuevaContra" id="nuevaContra" placeholder="Nueva contraseña..." >
          <p class="form-alert" id="alertanuevacontraseña" style="display:none;color:red;">Minimo 8 carateres</p>
           <p class="form-alert" id="alertanuevacontraseñacaracteres" style="display:none;color:red;">Maximo de caracteres permitidos</p>
          <strong><span class="help-block small" style="color: #8a9597;">Usa 8 o más caracteres con una combinación de letras, números y símbolos.</span></strong>
        </div>
          <div class="form-group col-8">
          <label for="exampleFormControlInput1"> <strong><span style="color: red;">*</span> Confirmar contraseña:</strong></label>
          <i class="fa fa-eye" id="mostrarNuevaC"></i>
          <input type="password" class="form-control" title="Introduzca de nuevo la contraseña" name="confirmarContra" id="confirmarContra" placeholder="Confirmar contraseña..." >
           <p class="form-alert" id="alertaconfirmarcontra" style="display:none;color:red;">Maximo de caracteres permitidos</p>
        </div>
  </div>
      <div class="modal-footer">
        <button type="button" id="salirModalPerfil" class="btn btn-danger" data-dismiss="modal">Salir</button>
        <button type="button" id="cambiarContraseña" class="btn btn-primary"><i class="fas fa-save"></i> Cambiar contraseña</button>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->


<!--Fin espacio -->