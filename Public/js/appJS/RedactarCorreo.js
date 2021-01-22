
$(document).ready(function() {   
 
    var tablaListaEmpleados = $('#tablaListaEmpleados').DataTable({
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
      }
    });


    //OBTENER DATOS DEL CORREO

    $('#enviarCorreo').click(function(){

      //VALIDAR SI SE ELIGIERON DESTINATARIOS
      //OBTENER VALORES DE LOS SELECT'S
      var idArea= $("#idAreaEnvios").val();
      var idSubarea= $("#subAreaEnvios").val();
      var asuntoCorreo= $("#asuntoCorreo").val();

      if (idArea == 0) 
      {
        $("body").overhang({
          type: "error",
          message: "Sin destinatarios",
          duration: 1,
        });
        return false;
      }
      else if(asuntoCorreo == '')
      {
        $("body").overhang({
          type: "error",
          message: "Asunto vacío",
          duration: 1,
        });
        return false;
      }
      else
      {

        $.ajax({
          type: 'POST',
          data: {idArea : idArea, idSubarea:idSubarea},
          url: '?c=Envios&a=destinatariosTabla',
          success:function(destinatarios){
           var data = JSON.parse(destinatarios);
         //VALIDAR SI EL ARREGLO ESTA VACIO
         if (data.length === 0)
         {
           $("body").overhang({
            type: "error",
            message: "Sin destinatarios",
            duration: 1,
          });
           return false;
         }
         
           //RECIBIR ARCHIVOS ADJUNTOS

           var parametrosMail = new FormData($("#mail")[0]);


         //ENVIAR ARCHIVOS
         $.ajax({
          data: parametrosMail,
          type: "POST",
          url: '?c=Envios&a=enviarCorreo',
          cache: false,
          contentType: false,
          processData: false,
          beforesend: function()
          { 

           // $('#content').html('<div class="loading"><img src="/sild/Public/img/Loading.gif" alt="loading" /><br/>Un momento, por favor...</div>');

          },
          success: function(mail) {
               alert("SE ENVIO EL CORREO");
             window.location.href = "?c=Envios&a=MainEnviados";
              window.open('?c=Envios&a=VistaListaDestino&A='+idArea+'&S='+idSubarea+'', '_blank'); 
                // $('#tablaListaEmpleados').DataTable().destroy();
                

            }
          });
       }
     });
      }
      // var textareaValue = $('#compose-textarea').summernote('code');
      // var plainText = $($("#compose-textarea").summernote("code")).text();

    //   alert(plainText);
    // console.log(plainText);

    // var idArea= $("#idAreaEnvios").val();
    // var idSubarea= $("#subAreaEnvios").val();
    // var idPlantilla= $("#idPlantilla").val();
    // var asuntoCorreo= $("#asuntoCorreo").val();

//     //ENVIAR PRUEBA CORREO
//     $.ajax({
//       type: "POST",
//       data: {idArea:idArea,idSubarea:idSubarea,idPlantilla:idPlantilla,asuntoCorreo:asuntoCorreo},
//       url: "?c=Envios&a=enviarCorreo",
//   // success: function(){

//   //   location.reload();

//   // }

// });
//LLAVE FINAL DE OBTENER CORREO
});

   
  


     //CUERPO DE CORREO CREAR LIGA PARA IMAGENES 
    //Add text editor
    $('#compose-textarea').summernote({
      lang: "es-ES",
      height: 400,
      callbacks: {
        onImageUpload : function(files, editor, welEditable) {

         for(var i = files.length - 1; i >= 0; i--) {
           sendFile(files[i], this);
         }
       }
     }

   });

//FIN CUERPO DE CORREO

function sendFile(file, el) {
  var form_data = new FormData();
  form_data.append('file', file);
  $.ajax({
    data: form_data,
    type: "POST",
    url: '?c=Envios&a=archivoCorreo',
    cache: false,
    contentType: false,
    processData: false,
    success: function(url) {
      $(el).summernote('editor.insertImage', url);

    }
  });
}

  //FIN DE OBTENER TODO EL CORREO

    //MOSTRAR EN EL SELECT LOS GRUPOS DE CADA USUARIO, ASI COMO AREAS Y SUBAREAS

    $( "#idAreaEnvios" ).change(function() {
      var idArea= $("#idAreaEnvios").val();       

      if (idArea == 0)
      {
       $('#subAreaEnvios').empty();
       $('#subAreaEnvios').prop('disabled', 'disabled');
     }
     else if(idArea == 0.1)
     {

       $('#subAreaEnvios').empty();
       $('#subAreaEnvios').prop('disabled', 'disabled');
     }
       else if(idArea >= 1 && idArea < 12)
     {

       $('#subAreaEnvios').empty();
       $('#subAreaEnvios').prop('disabled', 'disabled');
     }
     else if (idArea == 0.2) 
     {
      $('#subAreaEnvios').prop('disabled', false);
            //GRUPOS 
            $.ajax({
              async: false,
              type: 'POST',
              data: {idArea : idArea},
              url: '?c=Envios&a=mostrarGruposEnvios',
              success:function(dataGrupos){
                var data = JSON.parse(dataGrupos);
                var subArea = $("#subAreaEnvios");
                subArea.empty();
                for (var i = data.length - 1; i >= 0; i--) {
                  subArea.append($("<option id='idSubCorreo' name='idSubCorreo' />").val(data[i].idGrupo).text(data[i].nombre_grupo));
                }  
              }
            });

          }
          else
          {

            $('#subAreaEnvios').prop('disabled', false);
           $.ajax({
            async: false,
            type: 'POST',
            data: {idArea : idArea},
            url: '?c=Envios&a=mostrarSubAreaEnvios',
            success:function(data){
              var data = JSON.parse(data);
              var subArea = $("#subAreaEnvios");
              subArea.empty();
              if (idArea>=1 && idArea<=11) 
              {
               for (var i = data.length - 1; i >= 0; i--) {
                subArea.append($("<option id='idSubCorreo' name='idSubCorreo' />").val(data[i].idSubarea).text(data[i].subarea));
              }               }
              else
              {
                subArea.append($("<option value='0.11' name='idSubCorreo' id='idSubCorreo'> TODA EL ÁREA</option>"));
                for (var i = data.length - 1; i >= 0; i--) {
                  subArea.append($("<option id='idSubCorreo' name='idSubCorreo' />").val(data[i].idSubarea).text(data[i].subarea));
                } 
              }

            }
          });

         }




       });

    //FIN
    //MOSTRAR DESTINATARIOS
    //DESACTIVAR MENSAJE DE ETIQUETA DIV, SIN RESULTADOS
    $('#msnDestinatarios').hide();

    $('#verDestinatarios').click(function(){

     $('#tablaDestinatarios').DataTable().destroy();

     var idArea= $("#idAreaEnvios").val();
     var idSubarea= $("#subAreaEnvios").val();

     //QUITAR WARINING DE DATATABLE
     $.fn.dataTable.ext.errMode = 'none';

     if (idArea == 0) 
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

      $('#tablaDestinatarios').DataTable({
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
        "url": "?c=Envios&a=destinatariosTabla",
        "type":"POST",
        "data": {
          idArea : idArea, idSubarea:idSubarea,
        },
      },
      "columns": [
      { "data" : "nombre" },
      { "data" : "correo" }
      ]
    });

      $.ajax({
        type: 'POST',
        data: {idArea : idArea, idSubarea:idSubarea},
        url: '?c=Envios&a=destinatariosTabla',
        success:function(destinatarios){
         var data = JSON.parse(destinatarios);
         //VALIDAR SI EL ARREGLO ESTA VACIO
         if (data.length === 0)
         {
           $('#numDestinatarios').html('<strong>0</strong>');
         }

         var count = data.data.length;
         $('#numDestinatarios').html('<strong>'+count+'</strong>');



       }
     });


    }
  });


//PLANTILLAS EN EL CUERPO DEL CORREO
$("#borrarPlantilla").attr('disabled', true);

$("#plantillas").change(function(){

 var idPlantilla = $('#plantillas').val(); 

 if(idPlantilla == 0)
 {

  $('#encabezado').hide();
  $('#marcaAgua').hide();
  $('#piePagina').hide();


}
else
{

  $.ajax({
   type: "POST",
   url: "?c=Envios&a=seleccionarPlantilla",
   data: {idPlantilla:idPlantilla},
   success: function(data) {

    $('#encabezado').show();
    $('#marcaAgua').show();
    $('#piePagina').show();

    var data = JSON.parse(data);

    for (var i = data.length - 1; i >= 0; i--) {



      $('#encabezado').prepend('<img id="imgEncabezado" src="'+data[i].encabezado+'" style="width: 80%; height: 80%;">');

      if (!data[i].marcaDeAgua) 
      {



      }
      else
      {

        $('#marcaAgua').prepend('<img id="imgMarcaAgua" src="'+data[i].marcaDeAgua+'" style="width: 80%; height: 80%;">');
      }

      if (!data[i].pieDePagina) 
      {


      }
      else
      {

       $('#piePagina').prepend('<img id="imgPiePagina" src="'+data[i].pieDePagina+'" style="width: 80%; height: 80%;">');
     }

   }  



 }

});

  // this.disabled = "disabled";
  $("#borrarPlantilla").attr('disabled', false);       
}
});



$('#borrarPlantilla').click(function(){

  $("#imgEncabezado").remove();
  $("#imgMarcaAgua").remove();
  $("#imgPiePagina").remove();

  $("#plantillas").attr('disabled', false);
  $("#borrarPlantilla").attr('disabled', true);
  $("#plantillas").val('0');

});

//PROGRAMAR ENVIO
$('#programarEnvio').click(function(){
 var fechaCorreo = $('[data-toggle="calendarioCorreo"]').val();
 var horaCorreo = $("#horaCorreo").val();

 if (fechaCorreo == '') 
 {
  $("body").overhang({
    type: "error",
    message: "Elegir fecha",
    duration: 1,
  });
  return false;
}
else if(horaCorreo == '')
{
  $("body").overhang({
    type: "error",
    message: "Elegir hora",
    duration: 1,
  });
  return false;
}
else
{
       //VALIDAR SI SE ELIGIERON DESTINATARIOS
      //OBTENER VALORES DE LOS SELECT'S
      var idArea= $("#idAreaEnvios").val();
      var idSubarea= $("#subAreaEnvios").val();
      var asuntoCorreo= $("#asuntoCorreo").val();

      if (idArea == 0) 
      {
        $("body").overhang({
          type: "error",
          message: "Sin destinatarios",
          duration: 1,
        });
        return false;
      }
      else if(asuntoCorreo == '')
      {
        $("body").overhang({
          type: "error",
          message: "Asunto vacío",
          duration: 1,
        });
        return false;
      }
      else
      {

    //RECIBIR ARCHIVOS ADJUNTOS

    var parametrosMail = new FormData($("#mail")[0]);


         //ENVIAR ARCHIVOS
         $.ajax({
          data: parametrosMail,
          type: "POST",
          url: '?c=Envios&a=enviarCorreoProgramado',
          cache: false,
          contentType: false,
          processData: false,
          success: function(response) {
           alert("EL CORREO SE PROGRAMO");
             window.location.href = "?c=CorreosProgramados&a=MainProgramados";
         }
       });
       }
     }





   });

//CALENDARIO PARA PROGRAMAR LOS CORREOS
$(function () {
  $('[data-toggle="calendarioCorreo"]').datepicker({
    beforeShowDay: $.datepicker.noWeekends ,
    autoHide: true,
    zIndex: 2048,
    dateFormat: 'yy-mm-dd',
    minDate: 0,
    firstDay: 1,
    monthNames: ['Enero', 'Febreo', 'Marzo',
    'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre',
    'Octubre', 'Noviembre', 'Diciembre'],
    dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
  });
});

//MOSTRAR HORAS PARA PROGRAMAR LOS CORREOS
$('#time').timepicker({
  template: 'modal',
  'minTime': '9:00am',
  'maxTime': '06:00pm',
  'step': 15,
   // 'disableTimeRanges' : [
   //  [ '1am' , '2am' ],
   //  [ '3am' , '4:01 am' ]
 });


//LLAVE FINAL
});


