<!--Espacio disponible para contenido--->
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-folder"></i> Carpetas</h1>
  <p class="mb-4">Elije la carpeta en la que quieres guardar el correo. <br>
  Al terminar dar clic en el boton que se encuentra del lado derecho.</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tus carpetas creadas</h6>  

      <span class="float-right">
        <button type="button" class="btn btn-success btn-rounded" title="Guardar correo en carpetas"><i class="far fa-save"></i> Guardar</button> 
       </span>
    </div>
    <input type="hidden" name="idCorreo" id="idCorreo" value="<?php echo $idCorreo;  ?>" >
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaCarpetasCorreo" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nombre de la carpeta</th>
              <th>Agregar</th>
              <th>Quitar</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nombre de la carpeta</th>
              <th>Agregar</th>
              <th>Quitar</th>
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


<!---Fin espacio-->






