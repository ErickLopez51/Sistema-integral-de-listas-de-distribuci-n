$(document).ready(function() {


          var tablaPlantillas = $('#tablaPlantillas').DataTable({
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
                  "url": "?c=Plantillas&a=MostrarPlantillas",
                  "type":"POST",
                },
                "columns": [
                { "data" : "nombre" },
                { "data" : "descripcion" },
                { "data" : "fechaCreacionPlantilla" },
                { "data" : "BotonEditar" },
                { "data" : "BotonEliminar" },
                ]
              });


          //BLOQUEAR BOTON PARA CREAR PLANTILLA, SI NO SE AH SUBIDO IMAGEN DE ENCABEZADO

          $("#encabezadoPlantilla").change(function(){
            $("#crearPlantilla").prop("disabled", this.files.length == 0);
          });


//   //ALERTA DE PLANTILLA CREADA 
//   $("#frm-crearGrupo").bind("submit", function() {
//     $.ajax({
//         type: $(this).attr("method"),
//         url: $(this).attr("action"),
//         data: $(this).serialize(),
//         success: function(response) {

//             if (response.estado == "true") {

//                 $("body").overhang({
//                     type: "success",
//                     message: "Guardanado plantilla...",
//                     callback: function() {
//                         window.location.href = "?c=Plantillas&a=MainPlantillas";
//                     }
//                 });
//             } 
//             else if (response.estado == "false") 
//             {
//              $("body").overhang({
//                 type: "error",
//                 message: "Error"
//             });
//          } 
//             else if (response.estado == "vacio") 
//             {
//              $("body").overhang({
//                 type: "error",
//                 message: "Campos Vacíos"
//             });
//          } 
//            else if (response.estado == "tamano") 
//             {
//              $("body").overhang({
//                 type: "warn",
//                 message: "Tamaño de archivo muy grande"
//             });
//          }
//         //  else
//         //  {
//         //     $("body").overhang({
//         //         type: "error",
//         //         message: "Error"
//         //     });
//         // }
//     },
//         });

//     return false;
// });



 //  $("#crearPlantilla").click(function(){

 // var nombrePlantilla = $('#nombrePlantilla').val();
 // var descripcionPlantilla = $('#descripcionPlantilla').val();

 // if (nombrePlantilla == '') 
 // {

 //  $("body").overhang({
 //    type: "error",
 //    message: "Nombre de platilla vacio",
 //    duration: 1,
 //  });

 //  return false;
 // }
 // else if(nombrePlantilla.length >= 100 ||  descripcionPlantilla.length >= 100)
 // {

 //  $("body").overhang({
 //    type: "error",
 //    message: "Maximo de caracteres permitidos",
 //    duration: 1,
 //  });
 //  return false;

 // }

      //    $.ajax({
      //     type: "POST",
      //     url: "?c=Plantillas&a=crearPlantilla",
      //     success:function(response){

      //      if (response == 1) 
      //      {

      
      //           $("body").overhang({
      //                   type: "success",
      //                   message: "Guardando Plantilla",
      //                   duration: 1,
      //                   callback: function() {
      //                       window.location.href = "?c=Plantillas&a=MainPlantillas";
      //                   }
      //               });
              


      //      }
      //       else if (response == 0)
      //           {
      //               $("body").overhang({
      //                   type: "error",
      //                   duration: 1,
      //                   message: "ERROR: VERIFICAR ARCHIVO"
      //               });
      //           }

      // }
      
      //   });

//            return false;  

// });

//EDITAR PLANTILLA

 //  $("#editarPlantilla").click(function(){

 // var nombrePlantilla = $('#editarNombrePlantilla').val();
 // var descripcionPlantilla = $('#editarDescripcionPlantilla').val();

 // if (nombrePlantilla == '') 
 // {

 //  $("body").overhang({
 //    type: "error",
 //    message: "Nombre de platilla vacio",
 //    duration: 1,
 //  });

 //  return false;
 // }
 // else if(nombrePlantilla.length >= 100 ||  descripcionPlantilla.length >= 100)
 // {

 //  $("body").overhang({
 //    type: "error",
 //    message: "Maximo de caracteres permitidos",
 //    duration: 1,
 //  });
 //  return false;

 // }

      //    $.ajax({
      //     type: "POST",
      //     url: "?c=Plantillas&a=crearPlantilla",
      //     success:function(response){

      //      if (response == 1) 
      //      {

      
      //           $("body").overhang({
      //                   type: "success",
      //                   message: "Guardando Plantilla",
      //                   duration: 1,
      //                   callback: function() {
      //                       window.location.href = "?c=Plantillas&a=MainPlantillas";
      //                   }
      //               });
              


      //      }
      //       else if (response == 0)
      //           {
      //               $("body").overhang({
      //                   type: "error",
      //                   duration: 1,
      //                   message: "ERROR: VERIFICAR ARCHIVO"
      //               });
      //           }

      // }
      
      //   });

//            return false;  

// });


//ELIMINAR IMAGEN LAS QUE TIENEN REGISTRADAS
$('.deleteEncabezado').click(function(){

  var parent = $(this).parent().attr('id');
  var service = $(this).parent().attr('data');
  var dataString = 'id='+service;

$.ajax({
  type: "POST",
  data: dataString,
  url: "?c=Plantillas&a=borrarImagenEncabezado",
  success: function(){

    location.reload();
  
  }


});

});

$('.deleteMarca').click(function(){

  var parent = $(this).parent().attr('id');
  var service = $(this).parent().attr('data');
  var dataString = 'id='+service;

$.ajax({
  type: "POST",
  data: dataString,
  url: "?c=Plantillas&a=borrarImagenMarca",
  success: function(){

    location.reload();
  
  }

});

});

$('.deletePie').click(function(){

  var parent = $(this).parent().attr('id');
  var service = $(this).parent().attr('data');
  var dataString = 'id='+service;

$.ajax({
  type: "POST",
  data: dataString,
  url: "?c=Plantillas&a=borrarImagenPie",
  success: function(){

    location.reload();
  
  }


});

});





//FIN
});


//ELIMINAR PLANTILLA
 function EliminarPlantila(idPlantilla)
{

    $.ajax({
    type: "POST",
  url: "?c=Plantillas&a=eliminarPlantilla",
      data: {idPlantilla:idPlantilla},
          beforeSend:function(){},
          success:function(){
 $('#tablaPlantillas').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Plantilla Eliminada Correctamente',
      'success'
    )

        } 
      });

}

 function alertaPlantilla(idPlantilla)
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
          EliminarPlantila(idPlantilla);
        }
      });
}

