<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-users-cog"></i> Gestión de usuarios</h1>
  <p class="mb-4">Gestionar usuarios</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Usuarios registrados</h6> 
            <span class="float-right">
       <a href="?c=GestionarUsuarios&a=VistaAltaUsuario" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
         <i class="fas fa-plus"></i>
       </span>
       <span class="text">Dar de alta usuario</span>
     </a></span> 
      <br>

     <div class="row">
      <div class="form-group col-md-4">
        <label for="inputState">Area:</label>
        <select name="idArea" id="idArea" class="form-control">
            <option value="0" name="todos">Selecciona...</option>
           <option value="0.1" name="todos">Todos los usuarios</option>
          <?php foreach ($area as $row) {?>
            <option value="<?php echo $row['idArea']; ?>"><?php echo $row['area']; ?>
          </option>  
        <?php }  ?>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">SubArea:</label>
      <select id="subArea" name="subArea" class="form-control">
      </select>
    </div>
  </div>
<div class="col text-center">
  <button  id="FiltroGestorUsuario" type="button" class="btn btn-primary"><i class="fas fa-filter"></i> Filtro</button>

                   </div>
                   <br>

  <div class="card shadow mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="GestorUsuarios" width="100%" cellspacing="0">
          <thead>
            <tr>
           <th>Nombre</th>
           <th>Correo</th>
           <th>Ver Información</th>
           <th>Editar</th>
           <th>Dar de baja</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
           <th>Nombre</th>
           <th>Correo</th>
           <th>Ver Información</th>
           <th>Editar</th>
           <th>Dar de baja</th>
            </tr>
          </tfoot>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Información del usuario</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
       <div  class="form-group col-8">
            <h6 class="m-0 font-weight-bold text-primary">Datos</h6> 
            <br>
                <label for="exampleFormControlInput1"> Nombre:</label>
          <input disabled type="text" class="form-control" title="Nombre" id="nombreEmpleadoGestor">

        </div>
          <div class="form-group col-8">
                     <label for="exampleFormControlSelect1">Correo:</label>
         <input disabled type="text" class="form-control" title="Correo" id="correoEmpleadoGestor"> 

        </div>
          <div class="form-group col-8">
         <label for="exampleFormControlSelect1">Area:</label>
         <input disabled type="text" class="form-control" title="Area" id="AreaEmpleadoGestor"> 
        </div>
                 <div class="form-group col-8">
         <label for="exampleFormControlSelect1">Subarea:</label>
         <input disabled type="text" class="form-control" title="Subarea" id="SubareaEmpleadoGestor"> 
        </div>



      <div class="modal-footer">
        <button type="button" id="salirModalPerfil" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->


<!---Fin espacio-->


<!--Fin espacio -->



