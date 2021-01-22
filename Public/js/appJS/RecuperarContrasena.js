$(document).ready(function() {    

//ENVIO DE CODIGO A CORREO QUE QUIERE RESTABLECER LA CONTRASEÑA

$("#frmcorreoRecuperar").bind("submit", function() {
  // event.preventDefault();

    $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: $(this).serialize(),
        success: function(response) {

            if (response.estado == "existe") {

                $("body").overhang({
                    type: "success",
                    message: "Enviado correo...",
                    callback: function() {
                        window.location.href = "?c=Usuarios&a=vistaRecuperarContrasena";
                    }
                });
            } 
            else if (response.estado == "noExiste") 
            {
             $("body").overhang({
                type: "warn",
                message: "No existe el correo en el sistema"
            });
         } 
         else
         {
            $("body").overhang({
                type: "error",
                message: "Campos Vacíos"
            });
        }
    },
        });

    return false;
});

//ENVIO DE CODIGO A CORREO QUE QUIERE RESTABLECER LA CONTRASEÑA

$("#frmCodigoRecuperar").bind("submit", function() {
    $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: $(this).serialize(),
        beforeSend: function() {
            $("#frmCodigoRecuperar button[type=submit]").html("Enviando...");
            $("#frmCodigoRecuperar button[type=submit]").attr("disabled", "disabled");
        },
        success: function(response) {

            if (response.estado == "true") {
                $("body").overhang({
                    type: "success",
                    message: "Código valido.",
                    callback: function() {
                        window.location.href = "?c=Usuarios&a=vistaNuevaContra";
                    }
                });
            }
            else
            {
                $("body").overhang({
                    type: "error",
                    message: "Código no valido"
                });
            }

            $("#frmCodigoRecuperar button[type=submit]").html("Ingresar");
            $("#frmCodigoRecuperar button[type=submit]").removeAttr("disabled");
        },
            // error: function() {
            //     $("body").overhang({
            //         type: "error",
            //         message: "Campos Vacíos"
            //     });

            //     $("#frmCodigoRecuperar button[type=submit]").html("Ingresar");
            //     $("#frmCodigoRecuperar button[type=submit]").removeAttr("disabled");
            // }
        });

    return false;
});


//CREAR NUEVA CONTRASEÑA
$("#restablecerContra").bind("submit", function() {

    $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: $(this).serialize(),
        success: function(response) {

            if (response.estado == "true") {
                $("body").overhang({
                    type: "success",
                    message: "Guardando información, espera...",
                    callback: function() {
                        window.location.href = "?c=Usuarios&a=index";
                    }
                });
            }
            else if (response.estado == "vacio") 
            {
             $("body").overhang({
                type: "error",
                message: "Campos vacíos"
            });
         } 
         else if (response.estado == "false") 
         {
             $("body").overhang({
                type: "error",
                message: "Error"
            });
         } 
         else if (response.estado == "error") 
         {
             $("body").overhang({
                type: "error",
                message: "Las contraseñas no coinciden"
            });
         } 
     },
 });

    return false;
});

//MOSTRAR Y OCULTAR CONTRASEÑA
$('#nuevaCon').click(function(){
  if($(this).hasClass('fa-eye'))
  {
      $('#txtPasswordN').attr('type','text');
      $('#nuevaCon').addClass('fa-eye-slash').removeClass('fa-eye');
  }
  
  else
  {
      //Establecemos el atributo y valor
      $('#txtPasswordN').attr('type','password');
      $('#nuevaCon').addClass('fa-eye').removeClass('fa-eye-slash');
  }
});


$('#repetirContra').click(function(){
  if($(this).hasClass('fa-eye'))
  {
      $('#txtPasswordN2').attr('type','text');
      $('#repetirContra').addClass('fa-eye-slash').removeClass('fa-eye');
  }
  
  else
  {
      //Establecemos el atributo y valor
      $('#txtPasswordN2').attr('type','password');
      $('#repetirContra').addClass('fa-eye').removeClass('fa-eye-slash');
  }
});


//VALIDAR CAMPOS DE TEXTO
$("#txtPasswordN").keyup(function(){
    var contraN=$("#txtPasswordN").val();
    if(contraN.length < 8){
        $("#alertaNuevaContra").css("display","block");
    }
    else{
        $("#alertaNuevaContra").css("display","none");
    }
});

$("#txtPasswordN2").keyup(function(){
    var contraN=$("#txtPasswordN2").val();
    if(contraN.length < 8){
        $("#alertaRepetirContra").css("display","block");
    }
    else{
        $("#alertaRepetirContra").css("display","none");
    }
});






//LLAVE FINAL
});



