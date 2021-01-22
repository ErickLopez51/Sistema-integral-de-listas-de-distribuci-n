$(document).ready(function() {    


    var Reporte1 = $('#Reporte1').DataTable({
      dom: 'Bfrtip',
      buttons: [
      'copy', 'csv', 'excel', 'print'
      ],
    //para cambiar el lenguaje a español
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast":"Último",
            "sNext":"Siguiente",
            "sPrevious": "Anterior"
        },
        "sProcessing":"Procesando...",
    },
    "ajax": {
      "url": "?c=Reportes&a=tablaReporteSeguimiento",
      "type":"POST",
  },
  "columns": [
  { "data" : "estatus" },
  { "data" : "total" },
  { "data" : "porcentaje"},
  ]
}); 

//LLAVE FINAL
});

