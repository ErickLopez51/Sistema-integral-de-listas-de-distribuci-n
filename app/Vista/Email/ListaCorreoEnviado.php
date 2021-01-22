<!--Espacio disponible para contenido--->
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-users"></i> Lista de empleados a los que se envió el correo</h1>
  <!-- <p class="mb-4">Puedes crear carpetas...</p> -->
  <!-- DataTales Example -->
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Lista de empleados</h6>  
 <!--      <span class="float-right">
       <a href="?c=Grupos&a=vistaAgregar" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
         <i class="fas fa-plus"></i>
       </span>
       <span class="text">Crear Carpeta</span>
     </a></span> -->
   </div>
   <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="tablaListaEmpleados" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nombre</th>
            <th>Correo</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
           <th>No.</th>
           <th>Nombre</th>
           <th>Correo</th>
         </tr>
       </tfoot>
       <tbody>

         <?php 
         $cont=1;
        foreach ($lista as $res) {?>
          
            
          
          <tr>

            <td><?php echo $cont++?></td>

            <td><?php echo $res['nombre'];?> <?php echo $res['ap'];?> <?php echo $res['am']; ?></td>

            <td><?php echo $res['email'];?></td>

          </tr>
          

        <?php } 
        ?>

       </tbody>
     </table>
   </div>
 </div>
</div>

<!-- Modal -->

<!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
</div> -->

</div>
<!-- /.container-fluid -->


<!---Fin espacio-->


