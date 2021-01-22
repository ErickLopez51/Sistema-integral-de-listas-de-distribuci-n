
$(document).ready(function() {




 function llenar_tablaConfigUsuarios(idArea = '', idSubarea = '')
 {

  $('#configUsuarios').DataTable({
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
    "url": "?c=ConfiguracionesUsuarios&a=FiltroConfigUsuario",
    "type":"POST",
    "data": {
      idArea:idArea, idSubarea:idSubarea
    },
  },
  "columns": [
  { "data" : "nombre" },
  { "data" : "correo" },
  { "data" : "Papelera" },
  { "data" : "Recibidos" },
  { "data" : "Tamano" }
  ]
});


}

$('#FiltroConfig').click(function(){
 var idArea = $('#idArea').val();
 var idSubarea = $('#subArea').val();

 if(idArea != 0 && idSubarea != '' )
 {
  $('#configUsuarios').DataTable().destroy();
  llenar_tablaConfigUsuarios(idArea, idSubarea);
  
}
else
{
  $("body").overhang({
    type: "error",
    message: "Ninguna opción seleccionada",
    duration: 1,
  });
  $('#configUsuarios').DataTable().destroy();
  llenar_tablaConfigUsuarios();

}
});


//SALIR DE LA PANTALLA MODAL, PARA CAMBIAR LOS VALORES DEL SELECT

$('#salirConfig').click(function(){

  $("#papeleraSelect").val('0');
  $("#bandejaSelect").val('0');
  $("#archivoSelect").val('0');

});


//OBTENER ID DEL USUARIO DE LA TABLA
//VARIABLE GLOBAL PARA GUARDAR EL ID DEL USUARIO
var idUsuario;
$('#configUsuarios tbody').on("click", "button.idUsuarioConfig",function(){
 idUsuario =$(this).attr("id");

 $.ajax({
  type: "POST",
  url: "?c=ConfiguracionesUsuarios&a=mostrarDatosConfig",
  data: {idUsuario:idUsuario },
  success:function(dataConfig){

    var data = JSON.parse(dataConfig);

    if (data.length == 0) 
    {
       $("#mostrarPapelera").val("Valores por defecto");
       $("#mostrarBanEntrada").val("Valores por defecto");
       $("#mostrarTamArchivos").val("Valores por defecto");
    }
    else
    {
      for (var i = data.length - 1; i >= 0; i--) {
       $("#mostrarPapelera").val(data[i].papelera+" Días"+"");
       $("#mostrarBanEntrada").val(data[i].bEntrada+" GB"+"");
       $("#mostrarTamArchivos").val(data[i].Tarchivo+" MB"+"");
     }  
   }



 }

});

});


   //BORRAR AUTOMATICAMENTE LA PAPELERA
   $('#guardarPapelera').click(function(){
     var diasPapelera = $('#papeleraSelect').val();

     if (diasPapelera == 0)
     {
       $("body").overhang({
        type: "error",
        message: "Ninguna opción seleccionada",
        duration: 1,
      });
       return false;
     }
     else
     {

   //    LLENAR CAMPOS DE TEXTO CON LA INFORMACION DE PERFIL 
   $.ajax({
    type: "POST",
    url: "?c=ConfiguracionesUsuarios&a=datosPapelera",
    data: {diasPapelera:diasPapelera,idUsuario:idUsuario },
    success:function(response){

     if (response.estado == "true") {
      $("body").overhang({
        type: "success",
        message: "Guardando información",
        duration: 1,
        callback: function() {
          window.location.href = "?c=ConfiguracionesUsuarios&a=MainConfiguracion";
        }
      });
    } else {
      $("body").overhang({
        type: "error",
        duration: 1,
        message: "Error al guardar información!"
      });
    }

  }

});

   $("#papeleraSelect").val('0');
 }

});



//TAMAÑO PARA LA BANDEJA DE ENTRADA
$('#guardarRecibidos').click(function(){
 var tamBandeja = $('#bandejaSelect').val();


 if (tamBandeja == 0)
 {
   $("body").overhang({
    type: "error",
    message: "Ninguna opción seleccionada",
    duration: 1,
  });
   return false;
 }
 else
 {

   //    LLENAR CAMPOS DE TEXTO CON LA INFORMACION DE PERFIL 
   $.ajax({
    type: "POST",
    url: "?c=ConfiguracionesUsuarios&a=datosBandejaEntrada",
    data: {tamBandeja:tamBandeja,idUsuario:idUsuario },
    success:function(response){

     if (response.estado == "true") {
      $("body").overhang({
        type: "success",
        message: "Guardando información",
        duration: 1,
        callback: function() {
          window.location.href = "?c=ConfiguracionesUsuarios&a=MainConfiguracion";
        }
      });
    } else {
      $("body").overhang({
        type: "error",
        duration: 1,
        message: "Error al guardar información!"
      });
    }

  }

});

   $("#bandejaSelect").val('0');
 }
 
});

//TAMAÑO PARA ARCHIVOS
$('#guardarTamano').click(function(){
 var tamArchivo = $('#archivoSelect').val();

 if (tamArchivo == 0)
 {
   $("body").overhang({
    type: "error",
    message: "Ninguna opción seleccionada",
    duration: 1,
  });
   return false;
 }
 else
 {

   //    LLENAR CAMPOS DE TEXTO CON LA INFORMACION DE PERFIL 
   $.ajax({
    type: "POST",
    url: "?c=ConfiguracionesUsuarios&a=datosTArchivos",
    data: {tamArchivo:tamArchivo,idUsuario:idUsuario },
    success:function(response){

     if (response.estado == "true") {
      $("body").overhang({
        type: "success",
        message: "Guardando información",
        duration: 1,
        callback: function() {
          window.location.href = "?c=ConfiguracionesUsuarios&a=MainConfiguracion";
        }
      });
    } else {
      $("body").overhang({
        type: "error",
        duration: 1,
        message: "Error al guardar información!"
      });
    }


  }

});

   $("#archivoSelect").val('0');
 }
 
});






//LLAVE FINAL
});
