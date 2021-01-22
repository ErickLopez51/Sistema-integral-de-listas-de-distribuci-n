$(document).ready(function() {


    $("#loginForm").bind("submit", function() {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function() {
                $("#loginForm button[type=submit]").html("Enviando...");
                $("#loginForm button[type=submit]").attr("disabled", "disabled");
            },
            success: function(response) {
                if (response.estado == "true") {
                 $("body").overhang({
                    type: "success",
                    message: "Usuario encontrado, te estamos redirigiendo...",
                    callback: function() {
                        window.location.href = "?c=Usuarios&a=ingresar";
                    }
                });
             } else {
                $("body").overhang({
                    type: "error",
                    message: "Correo o password incorrecto!"
                });
            }

            $("#loginForm button[type=submit]").html("Ingresar");
            $("#loginForm button[type=submit]").removeAttr("disabled");
        },
        error: function() {
            $("body").overhang({
                type: "error",
                message: "Usuario o password incorrecto!"
            });

            $("#loginForm button[type=submit]").html("Ingresar");
            $("#loginForm button[type=submit]").removeAttr("disabled");
        }
    });

        return false;
    });

});

$(document).ready(function() {

    $("#login2Form").bind("submit", function() {

        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function() {
                $("#login2Form button[type=submit]").html("Enviando...");
                $("#login2Form button[type=submit]").attr("disabled", "disabled");
            },
            success: function(response) {
                if (response.estado == "true") {
                    $("body").overhang({
                        type: "success",
                        message: "Guardando información, espera...",
                        callback: function() {
                            window.location.href = "?c=BandejaDeEntradas&a=MainBandejaDeEntrada";
                        }
                    });
                } else {
                    $("body").overhang({
                        type: "error",
                        message: "Las contraseñas no coinciden"
                    });
                }

                $("#login2Form button[type=submit]").html("Guardar");
                $("#login2Form button[type=submit]").removeAttr("disabled");
            },
            error: function() {
                $("body").overhang({
                    type: "error",
                    message: "Las contraseñas no coinciden"
                });

                $("#login2Form button[type=submit]").html("Guardar");
                $("#login2Form button[type=submit]").removeAttr("disabled");
            }
        });

        return false;
    });

    //MOSTRAR Y OCULTAR CONTRASEÑA
    $('#mostrarContraInicio').click(function(){
      if($(this).hasClass('fa-eye'))
      {
          $('#txtPassword').attr('type','text');
          $('#mostrarContraInicio').addClass('fa-eye-slash').removeClass('fa-eye');
      }

      else
      {
      //Establecemos el atributo y valor
      $('#txtPassword').attr('type','password');
      $('#mostrarContraInicio').addClass('fa-eye').removeClass('fa-eye-slash');
  }
});




});


