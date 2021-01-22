
var arrayAgregados=[];
var arrayEliminadosEditar=[];


$(document).ready(function() {



 function llenar_tabla(idArea = '', idSubarea = '')
 {

  var dataTable = $('#grupos1').DataTable({
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
    "url": "?c=Grupos&a=Filtro",
    "type":"POST",
    "data": {
      idArea:idArea, idSubarea:idSubarea, 'arrayAgregados': JSON.stringify(arrayAgregados)
    },
  },
  "columns": [
  { "data" : "nombre" },
  { "data" : "correo" },
  { "data" : "cadena" }
  ]
});


}

$('#grupos1 tbody').on("click", "button.agregar1",function(){
 var idBoton =$(this).attr("id");
 var idBotonEditar =$("button.eliminarEditar").attr("id");
 if (idBoton==idBotonEditar) 
 {

   this.disabled=true;
   $("body").overhang({
    type: "error",
    message: "Ya se encuentra agregado en el grupo",
    duration: 1,
  });

 }
 else
 {

   arrayAgregados.push(idBoton);
   this.disabled=true;
   var usuario = $(this).parents("tr").find("td").eq(0).text();
   var correo = $(this).parents("tr").find("td").eq(1).text();
   var rowNode = agregados.row.add( [ usuario, correo,"<div class='col text-center'><button id='"+idBoton+"' title='Eliminar usuario al grupo' class='eliminar btn btn-danger btn-circle'><i class='fas fa-trash'></i></button></div>"  ] )
   .draw()
   .node();
 }

});

$('#tablaAgregados tbody').on("click", "button.eliminar",function(){
  var idAgregado =$(this).attr("id");
  var indice=$(this).closest('td').parent()[0].sectionRowIndex;
  agregados.row(':eq('+indice+')').remove().draw();
  $('#grupos1.'+idAgregado).prop("disabled",true);
  arrayAgregados.forEach( function(valor, indice, array) {
    if(valor==idAgregado)
    {
      arrayAgregados.splice(indice, valor);
    }   
  });
  var idArea = $('#idArea').val();
  var idSubarea = $('#subArea').val();
  $('#grupos1').DataTable().destroy();
  llenar_tabla(idArea, idSubarea);

});

//ELIMINAR DE LA TABLA EDITAR 
$('#tablaAgregados tbody').on("click", "button.eliminarEditar",function(){
  agregados.row( $(this).parents('tr') ).remove().draw();
  var idBotonEditar =$(this).attr("id");
  arrayEliminadosEditar.push(idBotonEditar);
  var idArea = $('#idArea').val();
  var idSubarea = $('#subArea').val();
  $('#grupos1').DataTable().destroy();
  llenar_tabla(idArea, idSubarea);

  return false;
});

$("#editarGrupo").click(function(){


 var filas = $("#tablaAgregados").DataTable().rows();

 var nombreGrupoA = $('#nombreGrupo').val().trim();
 var descripcionGrupo=$("#descripcionGrupo").val().trim();
 var idGrupoActualizar=$("#idGrupo").val().trim();

 if (nombreGrupoA == '') 
 {

  $("body").overhang({
    type: "error",
    message: "Nombre del grupo vacio",
    duration: 1,
  });

  return false;
}
// else if(filas.length < 2)
// {

//   $("body").overhang({
//     type: "error",
//     message: "Se necesita tener al menos dos usuarios agregados",
//     duration: 1,
//   });
//   return false;

// }
else
{
  $.ajax({
    type: "POST",
    url: "?c=Grupos&a=ActualizarGrupo",
          data: {nombreGrupoA:nombreGrupoA, idUserGrupo:idUserGrupo, descripcionGrupo:descripcionGrupo,idGrupoActualizar:idGrupoActualizar, 'arrayAgregados': JSON.stringify(arrayAgregados),'arrayEliminadosEditar': JSON.stringify(arrayEliminadosEditar)},//capturo array 
          success:function(response){

           if (response.estado == "true") {
            $("body").overhang({
              type: "success",
              message: "Actualizando información",
              duration: 1,
              callback: function() {           
                window.location.href = "?c=Grupos&a=MainGrupo";
              }
            });
          } else {
            $("body").overhang({
              type: "error",
              duration: 1,
              message: "Error al actualizar información"
            });
          }  

        }

      });
  return false;  
}

});


$('#Filtro').click(function(){
 var idArea = $('#idArea').val();
 var idSubarea = $('#subArea').val();

 if(idArea != 0 && idSubarea != '' )
 {
  $('#grupos1').DataTable().destroy();
  llenar_tabla(idArea, idSubarea);
  
}
else
{
  $("body").overhang({
    type: "error",
    message: "Ninguna opción seleccionada",
    duration: 1,
  });
  $('#grupos1').DataTable().destroy();
  llenar_tabla();

}
});

var nombreGrupo;
var descripcionGrupo;

$("#nombreGrupo").keyup(function(){
  nombreGrupo=$("#nombreGrupo").val();
  if(nombreGrupo.length > 100){
    $("#alertnombregrupo").css("display","block");
  }
  else{
    $("#alertnombregrupo").css("display","none");
  }
});

$("#descripcionGrupo").keyup(function(){
  descripcionGrupo=$("#descripcionGrupo").val();
  if(descripcionGrupo.length > 100){
    $("#alertdescripcion").css("display","block");
  }
  else{
    $("#alertdescripcion").css("display","none");
  }
});


$("#guardarGrupo").click(function(){
 var nombreGrupoA = $('#nombreGrupo').val().trim();
 var descripcionGrupo=$("#descripcionGrupo").val().trim();

 if (nombreGrupoA == '') 
 {

  $("body").overhang({
    type: "error",
    message: "Nombre del grupo vacio",
    duration: 1,
  });

  return false;
}
else if(arrayAgregados.length < 2)
{

  $("body").overhang({
    type: "error",
    message: "Se necesita tener al menos dos usuarios agregados",
    duration: 1,
  });
  return false;

}
else
{
  $.ajax({
    type: "POST",
    url: "?c=Grupos&a=GuardarGrupo",
          data: {nombreGrupoA:nombreGrupoA, descripcionGrupo:descripcionGrupo, 'arrayAgregados': JSON.stringify(arrayAgregados)},//capturo array 
          success:function(response){

           if (response.estado == "true") {
            $("body").overhang({
              type: "success",
              message: "Guardando información",
              duration: 1,
              callback: function() {
                window.location.href = "?c=Grupos&a=MainGrupo";
              }
            });
          } else {
            $("body").overhang({
              type: "error",
              duration: 1,
              message: "Error al guardar información"
            });
          }  

        }

      });
  return false;  
}

});




});


function alertaEliminarGrupo(idGrupo)
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


      $.ajax({
        type: "POST",
        url: "?c=Grupos&a=eliminarGrupo",
        data: {idGrupo:idGrupo},
        beforeSend:function(){},
        success:function(){

          $("body").overhang({
            type: "success",
            message: "¡Grupo eliminado!",
            callback: function() {
              window.location.href = "?c=Grupos&a=MainGrupo";
            }
          });



        } 
      });


    }
  });
}