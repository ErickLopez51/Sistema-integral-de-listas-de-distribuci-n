<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-cog"></i> Configuración</h1>
  <p  class="m-0 font-weight-bold text-primary mb-4" >Configuración de usuarios para el tamaño de archivos, borrado automático de papelera y capacidad para el espacio en bandeja de entrada de cada usuario.</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Busca a los usuarios por área y subárea.
        <br>Lista de usuarios.</h6> 
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
      <button  id="FiltroConfig" type="button" class="btn btn-primary"><i class="fas fa-filter"></i> Filtro</button>

    </div>
    <br>

    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="configUsuarios" width="100%" cellspacing="0">
            <thead>
              <tr>
               <th>Nombre</th>
               <th>Correo</th>
               <th>Papelera</th>
               <th>Bandeja de entrada</th>
               <th>Tamaño archivos</th>
             </tr>
           </thead>
           <tfoot>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Papelera</th>
              <th>Bandeja de entrada</th>
              <th>Tamaño archivos</th>
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

<!-- MODAL PARA EL TIEMPO DE BORRADO AUTOMATICO EN PAPELERA -->
<div class="modal fade" id="papelera" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class='fas fa-trash'></i> Borrado de papelera</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div  class="form-group col-10">
        <h6 class="m-0 font-weight-bold text-primary">Selecciona el tiempo para vaciar la papelera.</h6> 
      </div>

         <div class="form-group col-8">
         <label for="exampleFormControlSelect1">Tiempo actual de borrado automatico:</label>
         <input disabled type="text" class="form-control" title="Tiempo" id="mostrarPapelera"> 
        </div>
      
      <div  class="form-group col-5">
       <label for="inputState">Tiempo (Días):</label>
       <select name="papeleraSelect" id="papeleraSelect" class="form-control">
        <option value="0" name="optionPapelera">Selecciona...</option>
        <option value="10" name="optionPapelera">10 días</option>
        <option value="15" name="optionPapelera">15 días</option>
        <option value="20" name="optionPapelera">20 días</option>
        <option value="30" name="optionPapelera">30 días</option>
      </select>
    </div>
    <div class="modal-footer">
      <button id="guardarPapelera" type="button" class="btn btn-success">Guardar</button>
      <button type="button" id="salirConfig" class="btn btn-danger" data-dismiss="modal">Salir</button>
    </div>
  </div>
</div>
</div>

<!-- MODAL PARA EL TAMAÑO DE LA BANDEJA DE ENTRADA -->
<div class="modal fade" id="recibidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class='fas fa-inbox'></i> Capacidad de bandeja de entrada</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>

          <div  class="form-group col-10">
        <h6 class="m-0 font-weight-bold text-primary">Selecciona la capacidad para la bandeja de entrada.</h6> 
      </div>

         <div class="form-group col-8">
         <label for="exampleFormControlSelect1">Capacidad actual para bandeja de entrada:</label>
         <input disabled type="text" class="form-control" title="Capacidad de bandeja de entrada" id="mostrarBanEntrada"> 
        </div>

      <div  class="form-group col-5">
       <label for="inputState">Tamaño (GB):</label>
       <select name="bandejaSelect" id="bandejaSelect" class="form-control">
        <option value="0" name="optionPapelera">Selecciona...</option>
        <option value="2" name="optionPapelera">2 GB</option>
        <option value="4" name="optionPapelera">4 GB</option>
        <option value="6" name="optionPapelera">6 GB</option>
        <option value="8" name="optionPapelera">8 GB</option>
      </select>
    </div>


     <div class="modal-footer">
      <button id="guardarRecibidos" type="button" class="btn btn-success">Guardar</button>
      <button type="button" id="salirConfig" class="btn btn-danger" data-dismiss="modal">Salir</button>
    </div>
  </div>
</div>
</div>

<!-- MODAL PARA EL TAMAÑO DE ARCHIVOS POR USUARIO -->
<div class="modal fade" id="tamano" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-file-alt"></i> Tamaño de archivos por usuario</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>

         <div  class="form-group col-10">
        <h6 class="m-0 font-weight-bold text-primary">Selecciona el tamaño para los archivos.</h6> 
      </div>

          <div class="form-group col-8">
         <label for="exampleFormControlSelect1">Tamaño actual para envio de archivos:</label>
         <input disabled type="text" class="form-control" title="Tamaño para envio de archivos" id="mostrarTamArchivos">
        </div>
      <div  class="form-group col-5">
       <label for="inputState">Tamaño (MB):</label>
       <select name="archivoSelect" id="archivoSelect" class="form-control">
        <option value="0" name="optionPapelera">Selecciona...</option>
        <option value="200" name="optionPapelera">200 MB</option>
        <option value="400" name="optionPapelera">400 MB</option>
        <option value="600" name="optionPapelera">600 MB</option>
        <option value="800" name="optionPapelera">800 MB</option>
      </select>
    </div>



     <div class="modal-footer">
      <button id="guardarTamano" type="button" class="btn btn-success">Guardar</button>
      <button type="button" id="salirConfig" class="btn btn-danger" data-dismiss="modal">Salir</button>
    </div>
  </div>
</div>
</div>

</div>
<!-- /.container-fluid -->


<!---Fin espacio-->


<!--Fin espacio -->



