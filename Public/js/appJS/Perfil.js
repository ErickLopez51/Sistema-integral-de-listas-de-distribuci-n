$(document).ready(function() {

$('#cambiarContraseña').click(function(){
 var contraActual = $('#contraActual').val();
 var contraNueva = $('#nuevaContra').val();
 var confirmarContra = $('#confirmarContra').val();

 if (contraActual == '' || contraNueva == '' || confirmarContra == '') 
 {

 	$("body").overhang({
 		type: "error",
 		message: "Campos vacios",
 		duration: 1,
 	});

 	return false;
 }
 else if(contraActual.length > 100 ||  contraNueva.length > 100 || confirmarContra.length > 100 )
 {

 	$("body").overhang({
 		type: "error",
 		message: "Maximo de caracteres permitidos",
 		duration: 1,
 	});
 	return false;

 }
 else if(contraNueva.length < 8 )
 {

 	$("body").overhang({
 		type: "error",
 		message: "Contraseña nueva, minimo 8 caracteres",
 		duration: 1,
 	});
 	return false;

 }
 else
 {
 	       $.ajax({
          type: "POST",
          url: "?c=Usuarios&a=cambiarContrasena",
          data: {contraActual:contraActual, contraNueva:contraNueva,confirmarContra:confirmarContra},
          success:function(response){

          	if (response.estadoContra == "true") 
          	{

      
          		   $("body").overhang({
                        type: "success",
                        message: "Actualizando contraseña",
                        duration: 1,
                        callback: function() {
                            window.location.href = "?c=Usuarios&a=InformacionPerfil";
                        }
                    });
          		


          	}
            else if (response.estadoContra == "false")
                {
                    $("body").overhang({
                        type: "error",
                        duration: 1,
                        message: "Contraseñas incorrectas"
                    });
                }

      }
      
        });

 }
});

    
    


//LIMPIAR CAMPOS DE TEXTO
$('#salirModalPerfil').click(function(){
	 $("#contraActual").val('');
	 $("#nuevaContra").val('');
	 $("#confirmarContra").val('');

	});

//MOSTRAR Y OCULTAR CONTRASEÑA
  $('#mostrarActual').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#contraActual').removeAttr('type');
      $('#mostrarActual').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#contraActual').attr('type','password');
      $('#mostrarActual').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });

    $('#mostrarNueva').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#nuevaContra').removeAttr('type');
      $('#mostrarNueva').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#nuevaContra').attr('type','password');
      $('#mostrarNueva').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });

        $('#mostrarNuevaC').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#confirmarContra').removeAttr('type');
      $('#mostrarNuevaC').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#confirmarContra').attr('type','password');
      $('#mostrarNuevaC').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });

//VALIDAR CAMPOS DE TEXTO
$("#contraActual").keyup(function(){
    var contraActual=$("#contraActual").val();
    if(contraActual.length >= 100){
    $("#alertaContraActual").css("display","block");
    }
  else{
    $("#alertaContraActual").css("display","none");
    }
});

$("#nuevaContra").keyup(function(){
    var nuevaContra=$("#nuevaContra").val();
    if(nuevaContra.length >= 100){
    $("#alertanuevacontraseñacaracteres").css("display","block");
    }
  else{
    $("#alertanuevacontraseñacaracteres").css("display","none");
    }
});

$("#nuevaContra").keyup(function(){
    var contraN=$("#nuevaContra").val();
    if(contraN.length < 8){
    $("#alertanuevacontraseña").css("display","block");
    }
  else{
    $("#alertanuevacontraseña").css("display","none");
    }
});

$("#confirmarContra").keyup(function(){
    var confirmarContra=$("#confirmarContra").val();
    if(confirmarContra.length >= 100){
    $("#alertaconfirmarcontra").css("display","block");
    }
  else{
    $("#alertaconfirmarcontra").css("display","none");
    }
});

//LLENAR CAMPOS DE TEXTO CON LA INFORMACION DE PERFIL 
$.ajax({
          type: "POST",
          url: "?c=Usuarios&a=datosPerfil",
          success:function(data){

            var data = JSON.parse(data);

            for (var i = data.length - 1; i >= 0; i--) {
                   $("#nombreEmpleado").val(data[i].nombre);
                   $("#correoEmpleado").val(data[i].correoEmpleado);
                   $("#AreaEmpleado").val(data[i].nombreArea);
                   $("#SubareaEmpleado").val(data[i].nombreSubArea);
            }  


      }
      
        });


//REALIZAR RESPALDO DE BASE DE DATOS

$('#respaldoBD').click(function(){
 $.ajax({
          type: "POST",
          url: "?c=RespaldoDB&a=generarRespaldo",
          success:function(response){  

            Swal.fire({
              position: 'top-end',
              type: 'success',
              title: 'El archivo se encuentra en la carpeta del proyecto',
              showConfirmButton: false,
              timer: 1500
            });

      }
      
        });
  });


//LLAVE FINAL
});

//FUNCION QUE SIRVE PARA INACTIVIDAD Y CERRAR LA SESION AUTOMATICAMENTE
// window.onload = function(){
//   killerSession();
// }

// function killerSession()
// {
// setTimeout("window.open('?c=Usuarios&a=salir','_top');",1800000);
// }

// window.onload = function(){
//   killerSession();
// }

// function killerSession()
// {
// setTimeout("window.open('?c=Usuarios&a=salir','_top');",5000);
// }