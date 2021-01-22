<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-pen-square"></i> Crear Plantilla</h1>
  <p class="mb-4">Formulario para crear plantilla.</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">LLena correctamente lo que se te pide.</h6> 
      <br>


 <form  id="frm-crearGrupo" action="?c=Plantillas&a=crearPlantilla" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="form-group col-md-3">
          <label for="exampleFormControlInput1"><span style="color: red;">*</span> Nombre:</label>
          <input type="text" class="form-control" title="Escribe el nombre de la plantilla" placeholder="Nombre de la plantilla..." name="nombrePlantilla" id="nombrePlantilla">
          <p class="form-alert" id="alertnombregrupo" style="display:none;color:red;">Máximo de caracteres permitidos</p>  
        </div>
        <div class="col">
         <label for="exampleFormControlSelect1">Descripción (Opcional):</label>
         <input type="text" class="form-control" title="Añade una pequeña Descripción" placeholder="Descripción..." name="descripcionPlantilla" id="descripcionPlantilla">
          <p class="form-alert" id="alertdescripcion" style="display:none;color:red;">Máximo de caracteres permitidos</p>  
       </div>
     </div>

      <label for="exampleFormControlInput1"><span style="color: red;">*</span> Encabezado:</label>
  <div class="form-group">
    <input type="file" class="form-control-file" name="encabezadoPlantilla" id="encabezadoPlantilla" accept="image/*">
  </div>

  <label for="exampleFormControlInput1"> Marca de agua (Opcional):</label>
  <div class="form-group">
    <input type="file" class="form-control-file" name="marcaAgua" id="marcaAgua" accept="image/*">
  </div>

  <label for="exampleFormControlInput1"> Pie de pagina (Opcional):</label>
  <div class="form-group">
    <input type="file" class="form-control-file" name="piePagina" id="piePagina" accept="image/*">
  </div>


<div class="col-6 col-sm-12">
<br>
<br>
  <div class="col text-center">
    <button  id="crearPlantilla" disabled="disabled" type="submit" class="btn btn-outline-success btn-rounded waves-effect"><i class="fas fa-plus"></i> Crear Plantilla</button>
  </div>
</div>
</form>
</div>
<!-- /.container-fluid -->


<!--Fin espacio -->







