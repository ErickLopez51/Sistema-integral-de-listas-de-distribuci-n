var usuariosElegidosGrupo=[];

$(document).ready(function() {    

	$("#etiquetasTodos").attr('checked', 'checked');

	if ($("#etiquetasTodos").is(':checked'))
	{

	$('#buscadorEtiquetaEtiqueta').hide(); //oculto div mediante id
	$('#GestorEtiquetas').DataTable().destroy();
	var GestorEtiquetas = $('#GestorEtiquetas').DataTable({
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
			"url": "?c=GestionarEtiquetas&a=todasEtiquetas",
			"type":"POST",
		},
		"columns": [
		{ "data" : "nombreCarpeta" },
		{ "data" : "fechaCreacion" },
		{ "data" : "BotonEditar" },
		{ "data" : "BotonEliminar" }
		]
	});
}


$("input[name=BuscarEtiqueta]").click(function () {    
	var buscarInfo = $(this).attr('id');


	if (buscarInfo == 'etiquetasTodos')
	{


	$('#buscadorEtiqueta').hide(); //oculto div mediante id
	$('#GestorEtiquetas').DataTable().destroy();
	var GestorEtiquetas = $('#GestorEtiquetas').DataTable({
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
			"url": "?c=GestionarEtiquetas&a=todasEtiquetas",
			"type":"POST",
		},
		"columns": [
		{ "data" : "nombreCarpeta" },
		{ "data" : "fechaCreacion" },
		{ "data" : "BotonEditar" },
		{ "data" : "BotonEliminar" }
		]
	});


}
else if (buscarInfo == 'etiquetaUsuarioNombre')
{

	$('#GestorEtiquetas').dataTable().fnClearTable();
	$('#GestorEtiquetas').DataTable().destroy();
	$('#buscadorEtiqueta').show();

            	//BUSCAR TRABAJADOR POR NOMBRE
            	$('#key').on('keyup', function() {
            		var key = $(this).val();    
            		var dataString = 'key='+key;
            		$.ajax({
            			type: "POST",
            			url: "?c=GestionarEtiquetas&a=BuscarEmpleadoEtiqueta",
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

                        $('#GestorEtiquetas').DataTable().destroy();
                        var GestorEtiquetas = $('#GestorEtiquetas').DataTable({
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
                        		"url": "?c=GestionarEtiquetas&a=LlenarTablaPorNombreEtiqueta",
                        		"type":"POST",
                        		"data": {
                        			idEmpleado:idEmpleado
                        		},
                        	},
                        	"columns": [
                        	{ "data" : "nombreCarpeta" },
                        	{ "data" : "fechaCreacion" },
                        	{ "data" : "BotonEditar" },
                        	{ "data" : "BotonEliminar" }
                        	]
                        });

                        return false;
                    });
            }
        });

            	});


            }
            else if (buscarInfo == 'etiquetaUsuarioCorreo')
            {
            	$('#GestorEtiquetas').dataTable().fnClearTable();
            	$('#GestorEtiquetas').DataTable().destroy();
            	$('#buscadorEtiqueta').show();

             	        //BUSCAR TRABAJADOR POR NOMBRE
             	        $('#key').on('keyup', function() {
             	        	var key = $(this).val();    
             	        	var dataString = 'key='+key;
             	        	$.ajax({
             	        		type: "POST",
             	        		url: "?c=GestionarEtiquetas&a=BuscarCorreoEtiqueta",
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

                        $('#GestorEtiquetas').DataTable().destroy();
                        var GestorEtiquetas = $('#GestorEtiquetas').DataTable({
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
                        		"url": "?c=GestionarEtiquetas&a=LlenarTablaPorCorreoEtiqueta",
                        		"type":"POST",
                        		"data": {
                        			idEmpleado:idEmpleado
                        		},
                        	},
                        	"columns": [
                        	{ "data" : "nombreCarpeta" },
                        	{ "data" : "fechaCreacion" },
                        	{ "data" : "BotonEditar" },
                        	{ "data" : "BotonEliminar" }
                        	]
                        });

                        return false;
                    });
            }
        });
             	        });

             	    }


             	});


  //EDITAR ETIQUETA

  $('#GestorEtiquetas tbody').on("click", "button.editar",function(){
    var idEtiqueta = $(this).attr("id");
       $("#idEtiqueta").val(idEtiqueta);

  });

      $('#btnEditarEtiqueta').click(function(){

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
      url: "?c=GestionarEtiquetas&a=editarEtiquetaGestor",
      data: {editaNombre:editaNombre,idEtiqueta:idEtiqueta},
      success:function(response){

        if (response.estado == "true") 
        {


         $("body").overhang({
          type: "success",
          message: "Actualizando...",
          duration: 1,
          callback: function() {
            window.location.href = "?c=GestionarEtiquetas&a=MainGestorEtiquetas";
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
 function EliminarEtiquetaJs(idCarpetaSecundario)
{

    $.ajax({
    type: "POST",
  url: "?c=GestionarEtiquetas&a=etiquetaBorrarGestor",
      data: {idCarpetaSecundario:idCarpetaSecundario},
          beforeSend:function(){},
          success:function(){
 $('#GestorEtiquetas').DataTable().ajax.reload();

     Swal.fire(
      '¡Eliminado!',
      'Se elimino la etiqueta',
      'success'
    )

        } 
      });

}

 function eliminarEtiqueta(idCarpetaSecundario)
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
          EliminarEtiquetaJs(idCarpetaSecundario);
        }
      });
}