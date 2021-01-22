<!-- Espacio disponible para contenido -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading --> 
  <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-mail-bulk"></i> Reporte: Seguimientos de correos</h1>
  <p class="mb-4">Información del reporte.</p>
  <div class="card shadow mb-3">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Elige como quiere exportar la información del reporte.</h6> 
      <br>
      <form action="generar/generar-pdf.php">
        <a href="?c=Reportes&a=crearReporte1PDF" target="_blank" title="Crear reporte PDF" class="btn btn-danger  btn-lg"><i class="fas fa-file-pdf"></i> PDF</a>
      </form>
      
      <br>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="Reporte1" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Seguimiento correo</th>
                <th>Cantidad total</th>
                <th>Porcentaje</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
               <th>Seguimiento correo</th>
               <th>Cantidad total</th>
               <th>Porcentaje</th>
             </tr>
           </tfoot>
           <tbody>
            <th>Eviados</th>
          </tbody>
        </table>
      </div>
    </div>




  </div>
</div>
<!-- /.container-fluid -->


<!--Fin espacio -->