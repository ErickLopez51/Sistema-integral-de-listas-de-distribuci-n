$(document).ready(function() {

// $.fn.dataTable.ext.errMode = 'none';
   var tablaEnviados = $('#tablaEnviados').DataTable({
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
    "url": "?c=Envios&a=mostrarCorreosEnviados",
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


//ELIMINAR CORREO RECIBIDO
 function EliminarC(idCorreoSecundario)
{

    $.ajax({
    type: "POST",
  url: "?c=Envios&a=eliminarCorreoE",
      data: {idCorreoSecundario:idCorreoSecundario},
          beforeSend:function(){},
          success:function(){
 $('#tablaEnviados').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Correo enviado a papelera',
      'success'
    )

        } 
      });

}

 function borrarCorreoEnviado(idCorreoSecundario)
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
          EliminarC(idCorreoSecundario);
        }
      });
}
