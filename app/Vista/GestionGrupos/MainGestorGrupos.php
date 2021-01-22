<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-users-cog"></i> Gestión de Grupos</h1>
  <p class="mb-4">Gestionar Grupos</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Puedes buscar el usuario por correo o nombre para ver sus grupos o ver todos los grupos registrados.</h6>   
      <br>

<div class="col-9 col-sm-8" >
     <div class="form-check-inline">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" id="gruposTodos" name="BuscarGrupo"><strong><i>Ver Todos los grupos</i></strong> 
    </label>
  </div>

  <div class="form-check-inline">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" id="grupoUsuarioNombre" name="BuscarGrupo"><strong><i>Buscar usuario por nombre</i></strong> 
    </label>
  </div>

  <div class="form-check-inline">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" id="grupoUsuarioCorreo" name="BuscarGrupo"><strong><i>Buscar usuario por correo</i></strong>
    </label>
  </div>

</div>
  <br>
<div class="col-6 col-sm-5" >
  <div class="input-group mb-7" id="buscador">
    <input type="text" class="form-control" placeholder="Buscar..." name="key" id="key"  aria-label="Recipient's username" aria-describedby="basic-addon2">
    <div class="input-group-append">
      <span class="input-group-text text-primary" id="basic-addon2"><i class="fas fa-search"></i></span>
    </div>
  </div>
  <div id="suggestions"></div> 
</diV>


                   <br>
                   <br>
                   <div class="text-center">
    <h6 class="m-0 font-weight-bold text-primary">Resultados</h6> 
  </div>
    <br>
  <div class="card shadow mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="GestorGrupos" width="100%" cellspacing="0">
          <thead>
            <tr>
             <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de creación</th>
            <th>Ver Miembros</th>
            <th>Editar</th>
            <th>Eliminar</th>
             <th>Permiso</th>
            <th>Quitar Permiso</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de creación</th>
            <th>Ver Miembros</th>
            <th>Editar</th>
            <th>Eliminar</th>
             <th>Permiso</th>
             <th>Quitar Permiso</th>
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


<!-- Modal para ver miembros -->
<div class="modal fade bd-example-modal-lg miembrosGestor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-users"></i> Miembros del grupo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span> 
        </button>
      </div>
    <div class="card shadow mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaVerMiembros" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
              
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
            </tr>
          </tfoot>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>


    </div>
  </div>
</div>

<!-- Modal para darle permiso a los usuarios del grupo -->
<div class="modal fade bd-example-modal-lg usuarios" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-users"></i> Elegir usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- inicio contenido -->


    <div class="card-body">
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Selecciona los usuarios a los que le quieres dar permiso de ver el grupo seleccionado</h6> 
                   <br>
<form id="frm-example" method="POST">
  <div class="card shadow mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="ElegirUsuarios" width="100%" cellspacing="0">
          <thead>
            <tr>
             <th> </th>
             <th>Usuario</th>
             <th>Correo</th>
           </tr>
         </thead>
         <tfoot>
          <tr>
            <th> </th>
            <th>Usuario</th>
            <th>Correo</th>
          </tr>
        </tfoot>
        <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>


<hr>


        <div class="modal-footer">
          <button id="ElegirUsuariosGrupo" type="submit" class="btn btn-primary">Confirmar permisos</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </form>


    </div>
  </div>
</div>



        


             
<!-- fin contenido -->
</div>
</div>

</div>


<!-- Modal para quitar permisos a los usuarios del grupo -->
<div class="modal fade bd-example-modal-lg quitarPermiso" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-users"></i> Quitar permiso a usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- inicio contenido -->


    <div class="card-body">
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Selecciona los usuarios a los que le quieres quitar permiso de ver el grupo seleccionado</h6> 
                   <br>
<form id="frm-quitarPermiso" method="POST">
  <div class="card shadow mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="QuitarPermisoUsuarios" width="100%" cellspacing="0">
          <thead>
            <tr>
             <th> </th>
             <th>Usuario</th>
             <th>Correo</th>
           </tr>
         </thead>
         <tfoot>
          <tr>
            <th> </th>
            <th>Usuario</th>
            <th>Correo</th>
          </tr>
        </tfoot>
        <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>


<hr>


        <div class="modal-footer">
          <button id="ElegirUsuariosGrupo" type="submit" class="btn btn-warning">Quitar permisos</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </form>


    </div>
  </div>
</div>



        


             
<!-- fin contenido -->
</div>
</div>

</div>

