<!--Espacio disponible para contenido--->
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-tag"></i> Etiquetas</h1>
  <p class="mb-4">Puedes crear carpetas para encontrar tus correos más rapido.</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tus carpetas creadas</h6>  

      <span class="float-right">
        <button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#crearCarpeta"><i class="fas fa-plus"></i> Crear etiqueta</button> 
       </span>
          
   </div>
   <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="tablaCarpetas" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Fecha de creación</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Nombre</th>
            <th>Fecha de creación</th>
            <th>Editar</th>
            <th>Eliminar</th>
         </tr>
       </tfoot>
       <tbody>
 
      </tbody>
    </table>
  </div>
</div>
</div>

<!-- Modal para crear carpeta -->
<div class="modal fade" id="crearCarpeta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-folder"></i> Crear etiqueta</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="card shadow mb-3">
      <br>
          <div  class="form-group col-8">
            <h6 class="m-0 font-weight-bold text-primary">Escribe el nombre de la etiqueta.</h6> 
            <br>
          <label for="exampleFormControlInput1"> <strong><span style="color: red;">*</span> Nombre de la etiqueta:</strong></label>
          <input type="text" class="form-control" title="Nombre de la carpeta" name="nomCarpeta" id="nomCarpeta" placeholder="Nombre de la carpeta..." >
          <p class="form-alert" id="alertaNomCarpeta" style="display:none;color:red;">Maximo de caracteres permitidos</p>
        </div>
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
        <button type="button" id="guardarCarpeta" class="btn btn-primary"><i class="fas fa-folder-plus"></i> Crear etiqueta</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA EDITAR ETIQUETA -->
<div class="modal fade" id="editarEtiqueta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-folder"></i> Editar etiqueta</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="card shadow mb-3">
      <br>
          <div  class="form-group col-8">
            <h6 class="m-0 font-weight-bold text-primary">Escribe el nombre de la etiqueta.</h6> 
            <br>
            <input type="hidden" name="idEtiqueta" id="idEtiqueta">
          <label for="exampleFormControlInput1"> <strong><span style="color: red;">*</span> Nombre de la etiqueta:</strong></label>
          <input type="text" class="form-control" title="Nombre de la carpeta" name="editaNombre" id="editaNombre" placeholder="Nombre de la carpeta..." >
          <p class="form-alert" id="alertaEditarEtiqueta" style="display:none;color:red;">Maximo de caracteres permitidos</p>
        </div>
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
        <button type="button" id="btnEditarEtiquetaMain" class="btn btn-warning"><i class="fas fa-folder-plus"></i> Actualizar etiqueta</button>
      </div>
    </div>
  </div>
</div>


</div>
<!-- /.container-fluid -->


<!---Fin espacio-->


