$(document).ready(function() {


   var tablaProgramados = $('#tablaProgramados').DataTable({
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
    "url": "?c=CorreosProgramados&a=mostrarCorreosProgramados",
    "type":"POST",
  },
  "columns": [
  { "data" : "enlaceCorreo" },
  { "data" : "asuntoC" },
   { "data" : "etiqueta" },
  { "data" : "fechaEnvio" },
  { "data" : "BotonEliminar" }
  ]
});

      var tablaBorradores = $('#tablaBorradores').DataTable({
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
    "url": "?c=CorreosProgramados&a=mostrarCorreosBorradores",
    "type":"POST",
  },
  "columns": [
  { "data" : "enlaceCorreo" },
  { "data" : "asuntoC" },
   { "data" : "etiqueta" },
  { "data" : "BotonEliminar" }
  ]
});

//LLAVE FINAL
});

//CANCELAR CORREO PROGRAMADO
 function EliminarP(Correo_idCorreo)
{

    $.ajax({
    type: "POST",
  url: "?c=CorreosProgramados&a=eliminarCorreoProgramado",
      data: {Correo_idCorreo:Correo_idCorreo},
          beforeSend:function(){},
          success:function(){
 $('#tablaProgramados').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Se cancelo la programación, correo en borradores',
      'success'
    )

        } 
      });

}

 function alertaCancelarP(Correo_idCorreo)
{
      Swal.fire({
        title: '¿Estás seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
         cancelButtonText: '¡Cancelar!',
        confirmButtonText: 'Sí, ¡Eliminar!'
      }).then((result) => {
        if (result.value) {
          EliminarP(Correo_idCorreo);
        }
      });
}

//CANCELAR CORREO PROGRAMADO
 function EliminarBorrador(Correo_idCorreo)
{

    $.ajax({
    type: "POST",
  url: "?c=CorreosProgramados&a=eliminarCorreoBorrador",
      data: {Correo_idCorreo:Correo_idCorreo},
          beforeSend:function(){},
          success:function(){
 $('#tablaBorradores').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Correo enviado a papelera',
      'success'
    )

        } 
      });

}

 function alertaEliminarBorrador(Correo_idCorreo)
{
      Swal.fire({
        title: '¿Estás seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
         cancelButtonText: '¡Cancelar!',
        confirmButtonText: 'Sí, ¡Eliminar!'
      }).then((result) => {
        if (result.value) {
          EliminarBorrador(Correo_idCorreo);
        }
      });
}

