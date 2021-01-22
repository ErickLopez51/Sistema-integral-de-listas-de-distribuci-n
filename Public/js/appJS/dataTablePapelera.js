$(document).ready(function() {


   var tablaPapelera = $('#tablaPapelera').DataTable({
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
    "url": "?c=Papeleras&a=mostrarCorreosPapelera",
    "type":"POST",
  },
  "columns": [
  { "data" : "enlaceCorreo" },
  { "data" : "asuntoC" },
  { "data" : "BotonEliminar" }
  ]
});

//LLAVE FINAL
});

//ELIMINAR CORREO RECIBIDO
 function EliminarPapelera(idCorreoSecundario)
{

    $.ajax({
    type: "POST",
  url: "?c=Papeleras&a=correoPapeleraEliminar",
      data: {idCorreoSecundario:idCorreoSecundario},
          beforeSend:function(){},
          success:function(){
 $('#tablaPapelera').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Se elimino correctamente.',
      'success'
    )

        } 
      });

}

 function alertaDefiCorreo(idCorreoSecundario)
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
          EliminarPapelera(idCorreoSecundario);
        }
      });
}


