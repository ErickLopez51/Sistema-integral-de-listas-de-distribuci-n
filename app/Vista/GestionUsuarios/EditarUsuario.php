<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-edit"></i> Editar Usuario "<?php echo $datosEditarUsuario->nombre; ?> <?php echo $datosEditarUsuario->ap; ?> <?php echo $datosEditarUsuario->am; ?>"</h1>
  <p class="mb-4">Formulario para editar de usuario.</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Puedes buscar al trabajador de las siguientes formas.</h6> 
      <br>


<form class="form-inline" method="post" action="#">
 <input type="hidden" class="form-control" name="idUsuario" id="idUsuario" value="<?php echo $datosEditarUsuario->idRfc; ?>">
 <div class="col-6 col-sm-5">
  <div class="form-check-inline">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" id="nombreTrabajador" name="BuscarTrabajador"><strong><i>Buscar por nombre</i></strong> 
    </label>
  </div>

  <div class="form-check-inline">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" id="correoTrabajador" name="BuscarTrabajador"><strong><i>Buscar por correo</i></strong>
    </label>
  </div>
</div>


<div class="col-6 col-sm-3">
 <label for="inputEmail4">Usuario:</label>
 <div class="form-group col-md-6">
  <input type="text" class="form-control" title="Nombre de usuario" placeholder="Nombre Usuario..." name="nombreUsuario" id="nombreUsuario" disabled>
</div>


</div>

<br>
<br>
<div class="col-6 col-sm-5" >
  <div class="input-group mb-7">
    <input type="text" class="form-control" placeholder="Buscar..." name="key" id="key"  aria-label="Recipient's username" aria-describedby="basic-addon2">
    <div class="input-group-append">
      <span class="input-group-text text-primary" id="basic-addon2"><i class="fas fa-search"></i></span>
    </div>
  </div>
  <div id="suggestions"></div> 

</div>




<div class="col-6 col-sm-3">
  <br>
 <label for="inputPassword4">Correo:</label>
 <div class="form-group col-md-6">
  <input type="text" class="form-control" title="Correo de usuario" placeholder="Correo..." name="correoUsuario"  id="correoUsuario" disabled >
</div>


</div>


<div class="col-6 col-sm-12">
<br>
<br>
  <div class="col text-center">
    <button  id="editarUsuario" type="submit" class="btn btn-outline-warning btn-rounded waves-effect"><i class="fas fa-edit"></i> Actualizar información</button>
  </div>



</div>



   


</form>

     




</div>
<!-- /.container-fluid -->


<!--Fin espacio -->





