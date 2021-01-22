<!--Espacio disponible para contenido--->
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"> <i class="fas fa-users"></i> Grupos</h1>
  <p class="mb-4">Puedes crear grupos...</p>
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tus grupos creados</h6>  
      <span class="float-right">
       <a href="?c=Grupos&a=vistaAgregar" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
         <i class="fas fa-plus"></i>
       </span>
       <span class="text">Crear Grupo</span>
     </a></span>
   </div>
   <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="grupos" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de creación</th>
            <th>Ver Miembros</th>
            <th>Editar</th>
            <th>Eliminar</th>
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
         </tr>
       </tfoot>
       <tbody>
        <?php 
        foreach ($grupo as $row) {?>
          <tr>
            <td><?php echo $row['nombre_grupo'];?></td>
                 <?php
                     $idGrupo = base64_encode($row['idGrupo']);
                  if ($row['descripcion'] == '')
            {
              ?>
                <td><i>Sin descripción</i></td>
            <?php } else { ?>

                 <td><?php echo $row['descripcion'];?></td>
          
               <?php } ?>

            <td><?php echo $row['fecha_grupo'];?></td>

            <td><div class="col text-center"><button  id="<?php echo $row['idGrupo'] ?>" data-toggle="modal" data-target=".bd-example-modal-lg" title="Ver Miembros" class="ver btn btn-info btn-circle"><i class="fas fa-eye"></i></button></div></td>

            
            <td><div class="col text-center"><a href="?c=Grupos&a=vistaEditarGrupo&XK=<?php echo $idGrupo  ?>" title="Editar Grupo" class="btn btn-warning btn-circle"><i class="editar fas fa-edit"></i></a></div></td>

             <td><div class="col text-center"><button onclick="alertaEliminarGrupo('<?php echo $row['idGrupo'] ?>');" title="Eliminar Grupo" class="eliminar btn btn-danger btn-circle"><i class="fas fa-trash"></i></button></div></td>





             
          </tr>
        <?php } 
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>

<!-- Modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Miembros del grupo</h5>
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

</div>
<!-- /.container-fluid -->


<!---Fin espacio-->


