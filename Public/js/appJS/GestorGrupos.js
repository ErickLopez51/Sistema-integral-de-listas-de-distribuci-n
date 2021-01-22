var usuariosElegidosGrupo=[];

$(document).ready(function() {    

	$("#gruposTodos").attr('checked', 'checked');

if ($("#gruposTodos").is(':checked'))
{

	$('#buscador').hide(); //oculto div mediante id
	 $('#GestorGrupos').DataTable().destroy();
            	var tablaGestorGrupos = $('#GestorGrupos').DataTable({
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
            			"url": "?c=GestionarGrupos&a=MostrarTodosGrupos",
            			"type":"POST",
            		},
            		"columns": [
            		{ "data" : "nombreGrupo" },
            		{ "data" : "descripcion" },
            		{ "data" : "fecha_grupo" },
            		{ "data" : "BotonVer" },
            		{ "data" : "BotonEditar" },
            		{ "data" : "BotonEliminar" },
                { "data" : "BotonPermiso" },
                { "data" : "BotonQuitarPermiso" }
            		]
            	});
}


  $("input[name=BuscarGrupo]").click(function () {    
           var buscarInfo = $(this).attr('id');
           

           if (buscarInfo == 'gruposTodos')
            {


	$('#buscador').hide(); //oculto div mediante id
	$('#GestorGrupos').DataTable().destroy();
	var tablaGestorGrupos = $('#GestorGrupos').DataTable({
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
			"url": "?c=GestionarGrupos&a=MostrarTodosGrupos",
			"type":"POST",
		},
		"columns": [
		{ "data" : "nombreGrupo" },
		{ "data" : "descripcion" },
		{ "data" : "fecha_grupo" },
		{ "data" : "BotonVer" },
		{ "data" : "BotonEditar" },
		{ "data" : "BotonEliminar" },
    { "data" : "BotonPermiso" },
    { "data" : "BotonQuitarPermiso" }
		]
	});


            }
            else if (buscarInfo == 'grupoUsuarioNombre')
            {
            	
            	$('#GestorGrupos').dataTable().fnClearTable();
            	$('#GestorGrupos').DataTable().destroy();
            	$('#buscador').show();

            	//BUSCAR TRABAJADOR POR NOMBRE
            	$('#key').on('keyup', function() {
            		var key = $(this).val();    
            		var dataString = 'key='+key;
            		$.ajax({
            			type: "POST",
            			url: "?c=GestionarGrupos&a=BuscarEmpleadoGrupo",
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

                        $('#GestorGrupos').DataTable().destroy();
                        var tablaGestorGrupos = $('#GestorGrupos').DataTable({
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
                        		"url": "?c=GestionarGrupos&a=LlenarTablaPorNombre",
                        		"type":"POST",
                        		"data": {
                        			idEmpleado:idEmpleado
                        		},
                        	},
                        	"columns": [
                        	{ "data" : "nombreGrupo" },
                        	{ "data" : "descripcion" },
                        	{ "data" : "fecha_grupo" },
                        	{ "data" : "BotonVer" },
                        	{ "data" : "BotonEditar" },
                        	{ "data" : "BotonEliminar" },
                          { "data" : "BotonPermiso" },
                          { "data" : "BotonQuitarPermiso" }
                        	]
                        });

                        return false;
                    });
            }
        });

            	});
              

            }
             else if (buscarInfo == 'grupoUsuarioCorreo')
             {
             	$('#GestorGrupos').dataTable().fnClearTable();
             	$('#GestorGrupos').DataTable().destroy();
             	$('#buscador').show();

             	        //BUSCAR TRABAJADOR POR NOMBRE
              $('#key').on('keyup', function() {
                var key = $(this).val();    
                var dataString = 'key='+key;
                $.ajax({
                  type: "POST",
                  url: "?c=GestionarGrupos&a=BuscarCorreoGrupo",
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

                        $('#GestorGrupos').DataTable().destroy();
                        var tablaGestorGrupos = $('#GestorGrupos').DataTable({
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
                        		"url": "?c=GestionarGrupos&a=LlenarTablaPorCorreo",
                        		"type":"POST",
                        		"data": {
                        			idEmpleado:idEmpleado
                        		},
                        	},
                        	"columns": [
                        	{ "data" : "nombreGrupo" },
                        	{ "data" : "descripcion" },
                        	{ "data" : "fecha_grupo" },
                        	{ "data" : "BotonVer" },
                        	{ "data" : "BotonEditar" },
                        	{ "data" : "BotonEliminar" },
                          { "data" : "BotonPermiso" },
                          { "data" : "BotonQuitarPermiso" }
                        	]
                        });

                        return false;
                      });
              }
            });
              });

             }
            
  
    });


//TABLA DE VENTANA MODAL DE CREAR GRUPO, PARA ELEGIR A LOS USUARIOS


$('#GestorGrupos tbody').on("click", "button.permisos",function(){


  $('#ElegirUsuarios').DataTable().destroy();
  var idGrupo = $(this).attr("id");

  var tablaModalElegirUsuarios = $('#ElegirUsuarios').DataTable({
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
    "url": "?c=GestionarGrupos&a=TodosUsuarios",
    "type":"POST",
    "data": { idGrupo:idGrupo },
  },
  "columns": [
  { "data" : "idEmpleado" },
  { "data" : "nombre" },
  { "data" : "correo" }
  ],
  'columnDefs': [
  {
    'targets': 0,
    'checkboxes': {
     'selectRow': true
   }
 }
 ],
 'select': {
   'style': 'multi'
 },
 'order': [[1, 'asc']]
});


   // Handle form submission event 
   $('#frm-example').on('submit', function(e){
    var form = this;
    usuariosElegidosGrupo.length=0;

    var rows_selected = tablaModalElegirUsuarios.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         usuariosElegidosGrupo.push(rowId);
       });
      if(usuariosElegidosGrupo.length == 0)
      {

        $("body").overhang({
          type: "error",
          duration: 1,
          message: "Ningun usuario seleccionado"
        });

      }
      else
      {
       $.ajax({
        type: "POST",
        url: "?c=GestionarGrupos&a=arrayUsuariosElegidos",
        data: {'usuariosElegidosGrupo': JSON.stringify(usuariosElegidosGrupo),idGrupo:idGrupo},
        success: function(response) {

          if (response.estado == "true") {
            $("body").overhang({
              type: "success",
              message: "Guardando informción",
              duration: 1,
              callback: function() {
                window.location.href = "?c=GestionarGrupos&a=MainGestorGrupos";
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
     }

     e.preventDefault();
   });


 });

//QUITAR PERMISOS A LOS USUARIOS SELECCIONADOS DE VER GRUPO

$('#GestorGrupos tbody').on("click", "button.Quitarpermisos",function(){


$('#QuitarPermisoUsuarios').DataTable().destroy();
  var idGrupo = $(this).attr("id");

   var tablaModalQuitarPermisoUsuarios = $('#QuitarPermisoUsuarios').DataTable({
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
    "url": "?c=GestionarGrupos&a=TodosUsuariosGrupoSeleccionado",
    "type":"POST",
    "data": { idGrupo:idGrupo },
  },
  "columns": [
  { "data" : "idEmpleado" },
  { "data" : "nombre" },
  { "data" : "correo" }
  ],
                  'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            }
         }
      ],
      'select': {
         'style': 'multi'
      },
      'order': [[1, 'asc']]
});


   // Handle form submission event 
   $('#frm-quitarPermiso').on('submit', function(e){
      var form = this;
      usuariosElegidosGrupo.length=0;
      
      var rows_selected = tablaModalQuitarPermisoUsuarios.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         usuariosElegidosGrupo.push(rowId);
      });
if(usuariosElegidosGrupo.length == 0)
{

      $("body").overhang({
              type: "error",
              duration: 1,
              message: "Ningun usuario seleccionado"
            });

}
else
{
     $.ajax({
    type: "POST",
  url: "?c=GestionarGrupos&a=arrayUsuariosQuitarPermisos",
      data: {'usuariosElegidosGrupo': JSON.stringify(usuariosElegidosGrupo),idGrupo:idGrupo},
           success: function(response) {

                if (response.estado == "true") {
                    $("body").overhang({
                        type: "success",
                        message: "Permisos actualizados",
                        duration: 1,
                        callback: function() {
                            window.location.href = "?c=GestionarGrupos&a=MainGestorGrupos";
                        }
                    });
                } else {
               $("body").overhang({
              type: "error",
              duration: 1,
              message: "Error al actualizar permisos"
            });
                }

               
            }
  
      });
}

      e.preventDefault();
   });


});

//BOTON PARA ACTUALIZAR GRUPO EN GESTOR
$("#editarGrupoGestor").click(function(){


 var filas = $("#tablaAgregados").DataTable().rows();

 var nombreGrupoA = $('#nombreGrupo').val().trim();
 var descripcionGrupo=$("#descripcionGrupo").val().trim();
 var idGrupoActualizar=$("#idGrupo").val().trim();
  var idUserGrupo=$("#idUserGrupo").val().trim();

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
    url: "?c=GestionarGrupos&a=ActualizarGrupoGestor",
          data: {nombreGrupoA:nombreGrupoA,idUserGrupo:idUserGrupo, descripcionGrupo:descripcionGrupo,idGrupoActualizar:idGrupoActualizar, 'arrayAgregados': JSON.stringify(arrayAgregados),'arrayEliminadosEditar': JSON.stringify(arrayEliminadosEditar)},//capturo array 
          success:function(response){

           if (response.estado == "true") {
            $("body").overhang({
              type: "success",
              message: "Actualizando información",
              duration: 1,
              callback: function() {           
                window.location.href = "?c=GestionarGrupos&a=MainGestorGrupos";
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












   
//LLAVE FINAL
});



 function EliminarGrupo(idGrupo,idUsuario)
{

    $.ajax({
    type: "POST",
  url: "?c=GestionarGrupos&a=eliminarGrupoGestor",
      data: {idGrupo:idGrupo,idUsuario:idUsuario},
          beforeSend:function(){},
          success:function(){
 $('#GestorGrupos').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Grupo Eliminado Correctamente',
      'success'
    )

        } 
      });

}

 function EliminarGrupoGestor(idGrupo,idUsuario)
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
          EliminarGrupo(idGrupo,idUsuario);
        }
      });
}
