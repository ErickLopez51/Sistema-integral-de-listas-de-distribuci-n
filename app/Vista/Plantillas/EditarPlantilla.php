<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-edit"></i> Editar Plantilla</h1>
  <p class="mb-4">Formulario para editar plantilla.</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">LLena correctamente lo que se te pide.</h6> 
      <br>


 <form  id="frm-crearGrupo" action="?c=Plantillas&a=editarPlantilla" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="form-group col-md-3">
            <input type="hidden" class="form-control" name="idPlantilla" id="idPlantilla" value="<?php echo $datosEditar->idPlantilla; ?>">
          <label for="exampleFormControlInput1"><span style="color: red;">*</span> Nombre:</label>
          <input type="text" class="form-control" title="Escribe el nombre de la plantilla" placeholder="Nombre de la plantilla..." name="editarNombrePlantilla" id="editarNombrePlantilla" value="<?php echo $datosEditar->nombre; ?>">
          <p class="form-alert" id="alertnombregrupo" style="display:none;color:red;">Máximo de caracteres permitidos</p>  
        </div>
        <div class="col">
         <label for="exampleFormControlSelect1">Descripción (Opcional):</label>
         <input type="text" class="form-control" title="Añade una pequeña Descripción" placeholder="Descripción..." name="editarDescripcionPlantilla" id="editarDescripcionPlantilla" value="<?php echo $datosEditar->descripcion; ?>">
          <p class="form-alert" id="alertdescripcion" style="display:none;color:red;">Máximo de caracteres permitidos</p>  
       </div>
     </div>

      <label for="exampleFormControlInput1"><span style="color: red;">*</span> Encabezado:</label>
  <div class="form-group">
    <input type="file" class="form-control-file" name="editarEncabezadoPlantilla" id="editarEncabezadoPlantilla" accept="image/*">
    <br>

    <?php

    //NOMBRE DE IMAGEN DEL ENCABEZADO

    $path="../Plantillas/".$datosEditar->idPlantilla."-".$datosEditar->nombre."-".$datosEditar->anio."/";

    if (file_exists($path)) 
    {
      $directorio = opendir($path);

      while ($archivo = readdir($directorio)) 
      {

        if (!is_dir($archivo)) 
        {
          //UNIR CADENAS PARA COMPARAR LAS IMAGENES
          $rutaImagen= $path. $archivo;

          if (strcmp($rutaImagen,$datosEditar->encabezado) == 0) 
          {

            echo "<div data='".$rutaImagen."'><a herf='".$rutaImagen."' title='Ver imagen'></a>";

            echo "$archivo <a href='#' class='btn btn-danger btn-circle btn-sm deleteEncabezado' title='Eliminar imagen'>
            <i class='fas fa-trash'></i></a></div>";

            echo "<img src='../Plantillas/$datosEditar->idPlantilla-$datosEditar->nombre-$datosEditar->anio/$archivo' width='300'";

            break;
          }
     
        }

      }


    }


    ?>

  </div>

  <br>
  <br>

  <div class="form-group">
      <label for="exampleFormControlInput1"> Marca de agua (Opcional):</label>
    <input type="file" class="form-control-file" name="editarMarcaAgua" id="editarMarcaAgua" accept="image/*">
    <br>

    <?php

    //NOMBRE DE IMAGEN DE MARCA DE AGUA
    $path="../Plantillas/".$datosEditar->idPlantilla."-".$datosEditar->nombre."-".$datosEditar->anio."/";

    if (file_exists($path)) 
    {
      $directorio = opendir($path);

      while ($archivo = readdir($directorio)) 
      {

        if (!is_dir($archivo)) 
        {
          //UNIR CADENAS PARA COMPARAR LAS IMAGENES
          $rutaImagen= $path. $archivo;


          if (strcmp($rutaImagen,$datosEditar->marcaDeAgua) == 0) 
          {
           echo "<div data='".$rutaImagen."'><a herf='".$rutaImagen."' title='Ver imagen'></a>";

            echo "$archivo <a href='#' class='btn btn-danger btn-circle btn-sm deleteMarca' title='Eliminar imagen'>
            <i class='fas fa-trash'></i></a></div>";

            echo "<img src='../Plantillas/$datosEditar->idPlantilla-$datosEditar->nombre-$datosEditar->anio/$archivo' width='300'";
            break;
          }
     
        }

      }


    }


    ?>

  </div>

  <br>
  <br>
 
  <div class="form-group">
     <label for="exampleFormControlInput1"> Pie de pagina (Opcional):</label>
    <input type="file" class="form-control-file" name="editarPiePagina" id="editarPiePagina" accept="image/*">
    <br>

        <?php

    //NOMBRE DE IMAGEN DEL ENCABEZADO

    $path="../Plantillas/".$datosEditar->idPlantilla."-".$datosEditar->nombre."-".$datosEditar->anio."/";

    if (file_exists($path)) 
    {
      $directorio = opendir($path);

      while ($archivo = readdir($directorio)) 
      {

        if (!is_dir($archivo)) 
        {
          //UNIR CADENAS PARA COMPARAR LAS IMAGENES
          $rutaImagen= $path. $archivo;

          if (strcmp($rutaImagen,$datosEditar->pieDePagina) == 0) 
          {
          echo "<div data='".$rutaImagen."'><a herf='".$rutaImagen."' title='Ver imagen'></a>";

            echo "$archivo <a href='#' class='btn btn-danger btn-circle btn-sm deletePie' title='Eliminar imagen'>
            <i class='fas fa-trash'></i></a></div>";

            echo "<img src='../Plantillas/$datosEditar->idPlantilla-$datosEditar->nombre-$datosEditar->anio/$archivo' width='300'";
            break;
          }
     
        }

      }


    }


    ?>
  </div>


<div class="col-6 col-sm-12">
<br>
<br>
  <div class="col text-center">
    <button  id="editarPlantilla" type="submit" class="btn btn-outline-warning btn-rounded waves-effect"><i class="fas fa-plus"></i> Actualizar Plantilla</button>
  </div>

</div>



   


</form>

     




</div>
<!-- /.container-fluid -->


<!--Fin espacio -->





