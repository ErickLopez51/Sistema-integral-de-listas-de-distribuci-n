
$(document).ready(function() {


   function llenar_tablaGestorUsuarios(idArea = '', idSubarea = '')
 {

  $('#GestorUsuarios').DataTable({
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
    "url": "?c=GestionarUsuarios&a=FiltroGestorUsuario",
    "type":"POST",
    "data": {
      idArea:idArea, idSubarea:idSubarea
    },
  },
  "columns": [
  { "data" : "nombre" },
  { "data" : "correo" },
  { "data" : "BotonVer" },
  { "data" : "BotonEditar" },
  { "data" : "BotonEliminar" }
  ]
});


}

$('#FiltroGestorUsuario').click(function(){
 var idArea = $('#idArea').val();
 var idSubarea = $('#subArea').val();

 if(idArea != 0 && idSubarea != '' )
 {
  $('#GestorUsuarios').DataTable().destroy();
  llenar_tablaGestorUsuarios(idArea, idSubarea);
  
}
else
{
  $("body").overhang({
    type: "error",
    message: "Ninguna opción seleccionada",
    duration: 1,
  });
  $('#GestorUsuarios').DataTable().destroy();
  llenar_tablaGestorUsuarios();

}
});


   $('#GestorUsuarios tbody').on("click", "button.Verinfo",function(){
     var idBotonVer =$(this).attr("id");

    //LLENAR CAMPOS DE TEXTO CON LA INFORMACION DE PERFIL 
    $.ajax({
      type: "POST",
      url: "?c=GestionarUsuarios&a=datosDeUsuario",
      data: {idBotonVer:idBotonVer},
      success:function(data){

        var data = JSON.parse(data);

        for (var i = data.length - 1; i >= 0; i--) {
         $("#nombreEmpleadoGestor").val(data[i].nombre);
         $("#correoEmpleadoGestor").val(data[i].correoEmpleado);
         $("#AreaEmpleadoGestor").val(data[i].nombreArea);
         $("#SubareaEmpleadoGestor").val(data[i].nombreSubArea);
       }  


     }

   });
   });


$("#nombreTrabajador").attr('checked', 'checked');

if ($("#nombreTrabajador").is(':checked'))
{
  //BUSCAR TRABAJADOR POR NOMBRE
$('#key').on('keyup', function() {
  var key = $(this).val();    
  var dataString = 'key='+key;
  $.ajax({
    type: "POST",
    url: "?c=GestionarUsuarios&a=BuscarEmpleadoRegistro",
    data: {dataString:dataString,key:key},
    success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#key').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        // alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        var correoEmpleado = $('#'+id).attr('correo');
                        var usuario = correoEmpleado.split('@')[0];
                        var idEmpleado = $('#'+id).attr('id');
                        $('#nombreUsuario').val(usuario);
                        $('#correoUsuario').val(correoEmpleado);
                        $('#idEmpleado').val(idEmpleado);
                        return false;
                      });
              }
            });
});
}


  $("input[name=BuscarTrabajador]").click(function () {    
           var buscarInfo = $(this).attr('id');
           

           if (buscarInfo== 'nombreTrabajador')
            {


//BUSCAR TRABAJADOR POR NOMBRE
$('#key').on('keyup', function() {
  var key = $(this).val();    
  var dataString = 'key='+key;
  $.ajax({
    type: "POST",
    url: "?c=GestionarUsuarios&a=BuscarEmpleadoRegistro",
    data: {dataString:dataString,key:key},
    success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#key').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        // alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        var correoEmpleado = $('#'+id).attr('correo');
                        var usuario = correoEmpleado.split('@')[0];
                        var idEmpleado = $('#'+id).attr('id');
                        $('#nombreUsuario').val(usuario);
                        $('#correoUsuario').val(correoEmpleado);
                        $('#idEmpleado').val(idEmpleado);
                        return false;
                      });
              }
            });
});

            }
            else if (buscarInfo== 'correoTrabajador')
            {

              //BUSCAR TRABAJADOR POR NOMBRE
              $('#key').on('keyup', function() {
                var key = $(this).val();    
                var dataString = 'key='+key;
                $.ajax({
                  type: "POST",
                  url: "?c=GestionarUsuarios&a=BuscarEmpleadoCorreo",
                  data: {dataString:dataString,key:key},
                  success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#key').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        // alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        var correoEmpleado = $('#'+id).attr('data');
                        var usuario = correoEmpleado.split('@')[0];
                        var idEmpleado = $('#'+id).attr('id');
                        $('#nombreUsuario').val(usuario);
                        $('#correoUsuario').val(correoEmpleado);
                        $('#idEmpleado').val(idEmpleado);
                        return false;
                      });
              }
            });
              });
              

            }
  
    });

//DAR DE ALTA A USUARIO
$('#UsuarioAlta').click(function(){
 var nombreUsuario = $('#nombreUsuario').val();
 var correoUsuario = $('#correoUsuario').val();
 var idEmpleado = $('#idEmpleado').val();

 if (nombreUsuario == ' ' &&  correoUsuario == '' && idEmpleado == '')
 {
    $("body").overhang({
              type: "error",
              duration: 1,
              message: "Campos vacios"
            });
     return false;
 }
 else
 {

   $.ajax({
    type: "POST",
  url: "?c=GestionarUsuarios&a=darDeAltaUsuario",
      data: {nombreUsuario:nombreUsuario,correoUsuario:correoUsuario,idEmpleado:idEmpleado},
        success:function(response){

           if (response.estado == "true") {
            $("body").overhang({
              type: "success",
              message: "Guardando información",
              duration: 1,
              callback: function() {
                window.location.href = "?c=GestionarUsuarios&a=MainGestorUsuarios";
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

//EDITAR USUARIO
$("#editarUsuario").click(function(){
 var idUsuario = $('#idUsuario').val().trim();
 var nombreUsuario=$("#nombreUsuario").val().trim();
 var correoUsuario=$("#correoUsuario").val().trim();


  $.ajax({
    type: "POST",
    url: "?c=GestionarUsuarios&a=ActualizarUsuario",
          data: {idUsuario:idUsuario, nombreUsuario:nombreUsuario,correoUsuario:correoUsuario},//capturo array 
          success:function(response){

           if (response.estado == "true") {
            $("body").overhang({
              type: "success",
              message: "Actualizando información",
              duration: 1,
              callback: function() {           
                window.location.href = "?c=GestionarUsuarios&a=MainGestorUsuarios";
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
});
});


//DAR DE BAJA A USUARIO
 function EliminarUsuario(idUsuario)
{

    $.ajax({
    type: "POST",
  url: "?c=GestionarUsuarios&a=bajaUsuario",
      data: {idUsuario:idUsuario},
          beforeSend:function(){},
          success:function(){
 $('#GestorUsuarios').DataTable().ajax.reload();
    Swal.fire(
            '¡Hecho!',
            'El usuario fue dado de baja.',
            'success'
            )

        } 
      });
 
 
}

 function alertaBajaUsuario(idUsuario)
{
      Swal.fire({
        title: '¿Estás seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
         cancelButtonText: '¡Cancelar!',
        confirmButtonText: 'Sí, ¡Dar de baja!'
      }).then((result) => {
        if (result.value) {
          EliminarUsuario(idUsuario);
        }
      });
}

