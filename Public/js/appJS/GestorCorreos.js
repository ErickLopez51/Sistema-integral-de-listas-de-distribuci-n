$(document).ready(function() {    


    //MOSTRAR LOS CORREOS EN TABLA

       var tablaTodosCorreos = $('#tablaTodosCorreos').DataTable({
           "order": [[ 0, "desc" ]],
          "ordering": false,
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
          "url": "?c=GestionarCorreos&a=correosTodos",
          "type":"POST",
        },
        "columns": [
        { "data" : "enlaceCorreo" },  
        { "data" : "asuntoC" },
        { "data" : "etiqueta" },
        ]
      });

          


    //LLAVE FINAL
  });