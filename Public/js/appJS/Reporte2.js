$(document).ready(function() {    


$.fn.dataTable.ext.errMode = 'none';

    var Reporte2 = $('#Reporte2').DataTable({
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
      "url": "?c=Reportes&a=tablaReporte2",
      "type":"POST",
  },
  "columns": [
  { "data" : "grupoDestinatario" },
  { "data" : "total" },
  { "data" : "porcentaje"},
  ]
}); 



});