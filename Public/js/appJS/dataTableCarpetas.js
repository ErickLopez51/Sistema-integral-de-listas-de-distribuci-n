$(document).ready(function() {


//LLENAR TABLA CON LAS CARPETAS CREADAS DE CADA USUARIO
var tablaCarpetas = $('#tablaCarpetas').DataTable({
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
  "url": "?c=Carpetas&a=mostrarCarpetas",
  "type":"POST",
},
"columns": [
{ "data" : "nombreCarpeta" },
{ "data" : "fechaCreacion" },
{ "data" : "BotonEditar" },
{ "data" : "BotonEliminar" }
]
});

//GUARDAR CARPETA
$('#guardarCarpeta').click(function(){

 var nomCarpeta = $('#nomCarpeta').val();

 if (nomCarpeta == '') 
 {

  $("body").overhang({
    type: "error",
    message: "Campos vacios",
    duration: 1,
  });

  return false;
}
else if(nomCarpeta.length >= 100)
{

  $("body").overhang({
    type: "error",
    message: "Maximo de caracteres permitidos",
    duration: 1,
  });
  return false;

}
else
{

 $.ajax({
  type: "POST",
  url: "?c=Carpetas&a=crearCarpeta",
  data: {nomCarpeta:nomCarpeta},
  success:function(response){

    if (response.estado == "true") 
    {


     $("body").overhang({
      type: "success",
      message: "Guardando etiqueta...",
      duration: 1,
      callback: function() {
        window.location.href = "?c=Carpetas&a=MainCarpetas";
      }
    });



   }
   else if (response.estado == "false")
   {
    $("body").overhang({
      type: "error",
      duration: 1,
      message: "ERROR"
    });
  }

}

});

}

});

  //VALIDAR CAMPOS DE TEXTO
  $("#nomCarpeta").keyup(function(){
    var nomCarpeta=$("#nomCarpeta").val();
    if(nomCarpeta.length >= 100){
      $("#alertaNomCarpeta").css("display","block");
    }
    else{
      $("#alertaNomCarpeta").css("display","none");
    }
  });

  $("#editaNombre").keyup(function(){
    var editaNombre=$("#editaNombre").val();
    if(editaNombre.length >= 100){
      $("#alertaEditarEtiqueta").css("display","block");
    }
    else{
      $("#alertaEditarEtiqueta").css("display","none");
    }
  });




  //EDITAR ETIQUETA

  $('#tablaCarpetas tbody').on("click", "button.editar",function(){
    var idEtiqueta = $(this).attr("id");
       $("#idEtiqueta").val(idEtiqueta);

  });

      $('#btnEditarEtiquetaMain').click(function(){

     var editaNombre = $('#editaNombre').val();
     var idEtiqueta = $('#idEtiqueta').val();
     console.log(idEtiqueta);
     if (editaNombre == '') 
     {

      $("body").overhang({
        type: "error",
        message: "Campos vacios",
        duration: 1,
      });

      return false;
    }
    else if(editaNombre.length >= 100)
    {

      $("body").overhang({
        type: "error",
        message: "Maximo de caracteres permitidos",
        duration: 1,
      });
      return false;

    }
    else
    {

     $.ajax({
      type: "POST",
      url: "?c=Carpetas&a=editarEtiqueta",
      data: {editaNombre:editaNombre,idEtiqueta:idEtiqueta},
      success:function(response){

        if (response.estado == "true") 
        {


         $("body").overhang({
          type: "success",
          message: "Actualizando...",
          duration: 1,
          callback: function() {
            window.location.href = "?c=Carpetas&a=MainCarpetas";
          }
        });
       }
       else if (response.estado == "false")
       {
        $("body").overhang({
          type: "error",
          duration: 1,
          message: "ERROR"
        });
      }

    }

  });

   }

 });




//LLAVE FINAL
});

//ELIMINAR CORREO RECIBIDO
 function borrarEtiqueta(idCarpetaSecundario)
{

    $.ajax({
    type: "POST",
  url: "?c=Carpetas&a=etiquetaBorrar",
      data: {idCarpetaSecundario:idCarpetaSecundario},
          beforeSend:function(){},
          success:function(){
 $('#tablaCarpetas').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Se elimino la etiqueta',
      'success'
    )

        } 
      });

}

 function eliminarEtiquetaMain(idCarpetaSecundario)
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
          borrarEtiqueta(idCarpetaSecundario);
        }
      });
}
