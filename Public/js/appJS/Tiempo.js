
$(document).ready(function() {    

    setTimeout(refrescar, 10000);
function refrescar(){

   var code = $('#asr').val();

   $.ajax({
    type: "POST",
    url: "?c=Usuarios&a=BajaCode",
    data: {code:code},
});
}

});

window.onload = updateClock;

var totalTime = 10;

function updateClock() {
  document.getElementById('tiempoExpira').innerHTML = totalTime;
  if(totalTime==0){

    $("body").overhang({
        type: "error",
        message: "El codigo ya expiro.",
        callback: function() {
            window.location.href = "?c=Usuarios&a=RestablecerContra";
        }
    });



}else{
    totalTime-=1;
    setTimeout("updateClock()",1000);
}
}