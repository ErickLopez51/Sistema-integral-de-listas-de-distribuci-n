<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-plus"></i> Crear Grupo</h1>
  <p class="mb-4">Formulario para la creación de grupos.</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Llena correctamente la información que se te pide.</h6> 
      <br>

      <form  id="frm-crearGrupo" action="" method="post" enctype="multipart/form-data">
       <div class="row">
        <div class="form-group col-md-3">
          <label for="exampleFormControlInput1"><span style="color: red;">*</span> Nombre del grupo:</label>
          <input type="text" class="form-control" title="Escribe el nombre del grupo" placeholder="Nombre Grupo..." name="nombre_grupo" id="nombreGrupo">
          <p class="form-alert" id="alertnombregrupo" style="display:none;color:red;">Máximo de caracteres permitidos</p>  
        </div>
        <div class="col">
         <label for="exampleFormControlSelect1">Descripción (Opcional):</label>
         <input type="text" class="form-control" title="Añade una pequeña Descripción" placeholder="Descripción..." name="descripcion" id="descripcionGrupo">
          <p class="form-alert" id="alertdescripcion" style="display:none;color:red;">Máximo de caracteres permitidos</p>  
       </div>
     </div>
     <h6 class="m-0 font-weight-bold text-primary">Para elegir a los usuarios que quieres agregar, puedes buscarlos por area.</h6>
     <h6 class="m-0 font-weight-bold text-danger"><span style="color: red;">*</span> Por lo menos dos usuarios se deben de agregar al grupo para que pueda ser creado.</h6>
     <br>
     <div class="row">
      <div class="form-group col-md-4">
        <label for="inputState">Área:</label>
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
  <button  id="Filtro" type="button" class="btn btn-primary"><i class="fas fa-filter"></i> Filtro</button>

                   </div>
                   <br>

  <div class="card shadow mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="grupos1" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
               <th>Agregar</th>
              
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
               <th>Agregar</th>
            </tr>
          </tfoot>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
  <h6 class="m-0 font-weight-bold text-primary text-center">Usuarios agregados al grupo.</h6>
  <div class="card shadow mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaAgregados" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
               <th>Eliminar</th>
              
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
               <th>Eliminar</th>
            </tr>
          </tfoot>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
  <div class="col text-center">

    <button  id="guardarGrupo" type="submit" class="btn btn-outline-success btn-rounded waves-effect"><i class="fas fa-plus"></i>  Guardar Grupo</button>
    
  </div>
</form>


</div>
<!-- /.container-fluid -->


<!--Fin espacio -->