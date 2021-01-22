    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Redactar nuevo mensaje</h3>
        </div>
        <!-- /.card-header -->
        
        <div class="card-body">
          <form id="mail" action="" method="post" enctype="multipart/form-data">
            <div id="loading" style="display: none;"></div>
            <div class="row">

              <div class="col-sm">

               <label for="inputState"><strong>Para:</strong></label>

               <div class="row">

                <div class="form-group col-md-4">

                  <select name="idAreaEnvios" id="idAreaEnvios" class="form-control">
                    <option value="0" name="idAreaCorreo" id="idAreaCorreo" >Selecciona...</option>
                    <option value="0.1" name="idAreaCorreo" id="idAreaCorreo" >Todo el IMTA</option>
                    <option value="0.2" name="idAreaCorreo" id="idAreaCorreo" >GRUPOS</option>
                    
                    <?php foreach ($gruposPuesto as $row) {?>
                      <option value="<?php echo $row['idgruposPuesto']; ?>"><?php echo $row['nombreGrupoPuesto']; ?>
                    </option>  
                  <?php }  ?>
                  <optgroup label="Áreas:">
                    <?php foreach ($area as $row) {?>
                      <option value="<?php echo $row['idArea']; ?>"><?php echo $row['area']; ?>
                    </option>  
                  <?php }  ?>
                </optgroup>

                

              </select>

            </div>

            <div class="form-group col-md-4">
              <select id="subAreaEnvios" name="subAreaCorreo" class="form-control">
              </select>

            </div>

            <div class="col-sm">

             <button id="verDestinatarios" type="button" class="verDestinatarios btn btn-warning btn-rounded waves-effect" data-toggle="modal" data-target=".destinatarios"><i class="fas fa-search"></i> Ver destinatarios</button>

           </div>

         </div>
         <div class="form-group">
           <label for="inputState"><strong>Asunto:</strong></label>
           <input id="asuntoCorreo" name="asuntoCorreo" class="form-control" placeholder="Asunto:">

         </div>

       </div>

     </div>

     <div class="row">

      <div class="col-md-4">

           <!-- ETIQUETAS -->

     <div class="row">

      <div class="col-sm">

       <label for="inputState"><strong>Etiqueta:</strong></label>

       <div class="row">

        <div class="form-group col-md-9">

          <select  name="nameEtiquetas" id="Etiquetas" class="form-control">
            <option value="0" >Ninguna</option>
            <?php foreach ($etiqueta as $row) {?>
              <option value="<?php echo $row['idCarpeta'];?>"><?php echo $row['nombre_carpeta'];?></option>  
            <?php }  ?>
          </select>

        </div>

      </div>

    </div>

  </div>

  <!-- FIN ETIQUETAS -->

    </div>


      <div class="col-md-8">

  <!-- PLANTILLAS -->

  <div class="row">

    <div class="col-sm">

     <label for="inputState"><strong>Plantillas:</strong></label>

     <div class="row">

      <div class="form-group col-md-6">

        <select  name="Nameplantillas" id="plantillas" class="form-control">
          <option value="0" >Ninguna</option>
          <?php foreach ($plantilla as $row) {?>
            <option value="<?php echo $row['idPlantilla'];?>"><?php echo $row['nombre'];?></option>  
          <?php }  ?>
        </select>

      </div>

      <div class="col-sm">

       <button  id="borrarPlantilla" type="button" class="btn btn-outline-danger btn-rounded waves-effect"><i class="fas fa-trash-alt"></i>  Borrar plantilla</button>

     </div>

   </div>

 </div>

</div>

<!-- FIN PLANTILLAS -->

    </div>

    </div>



<br>

<div class="form-group">

  <!-- <form id="mail" action="" method="post" enctype="multipart/form-data"> -->

    <textarea id="compose-textarea" name="compose-textarea" class="form-control" style="height: 400px">

      <div  id="encabezado"></div>


   <!--    <div id="marcaAgua" style="width:300px;height:400px;filter:alpha(opacity=25);-moz-opacity:.25;opacity:.25;background:url()">
   </div> -->


   <div id="piePagina"></div>

 </textarea>
</div>

<div class="form-group">
  <div class="btn btn-default btn-file">
    <i class="fas fa-paperclip"></i> 
    <input type="file" name="archivos[]" multiple>
  </div>
  <p class="help-block" style="color: red;">Max. <?php echo utf8_encode($_SESSION["usuario"]["Tarchivo"]); ?> MB </p>
</div>

<!-- /.card-body -->
<div class="card-footer">
  <div class="float-right">
    <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>

    <!-- Example split danger button -->
    <div class="btn-group">
      <button id="enviarCorreo"  type="button" class="btn btn-primary"><i class="far fa-envelope"></i> Enviar</button>
      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu">
       <button  type="button" class="btn btn-info" data-toggle="modal" data-target=".posponer"><i class="fas fa-history"></i> Programar envió</button>
     </div>
   </div>
 </div>
 <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Descartar</button>
</div>
<!-- /.card-footer -->
</div>

<!-- </form>
-->
<!-- /.card -->
</div>


<!-- MODAL PARA MOSTRAR LOS DESTINATARIOS -->
<div class="modal fade bd-example-modal-lg destinatarios" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-eye"></i> Destinatarios ( <span id="numDestinatarios"></span> )</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span> 
        </button>
      </div>

      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="tablaDestinatarios" width="100%" cellspacing="0">
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

<!-- MODAL PARA POSPONER CORREOS -->
<!-- ELEGIR FECHA Y HORA PARA PROGRAMAR CORREO -->
<div class="modal fade bd-example-modal-sm posponer"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-clock"></i> Programar envío</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span> 
      </button>
    </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar-day"></i> Elegir fecha y hora</h6>  
    </div>
    <div class="card shadow mb-3">

     <div class="card-body">
      <div class="table-responsive">
       <label for="inputState"><strong>Fecha:</strong></label>
       <input type="text" class="form-control" name="calendarioCorreo" data-toggle="calendarioCorreo" placeholder="Fecha">
       <br>
       <label for="inputState"><strong>Hora:</strong></label>
       <input type="text"  class="form-control" id="time" name="time" placeholder="Hora">
     </div>
   </div>
 </div>
 <div class="modal-footer">
  <button id="programarEnvio" type="button" class="btn btn-success">Programar envío</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
</div>
</div>

</div>
</div>
</form>
