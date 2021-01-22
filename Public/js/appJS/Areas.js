
$(document).ready(function() {
  $( "#idArea" ).change(function() {
    var idArea= $("#idArea").val();

    if (idArea == 0)
    {
     $('#subArea').empty();
   }
   else if(idArea == 0.1)
   {

     $('#subArea').empty();
   }
   else
   {
     $.ajax({
      async: false,
      type: 'POST',
      data: {idArea : idArea},
      url: '?c=Grupos&a=mostrarAreaSub',
      success:function(data){
        var data = JSON.parse(data);
        // console.log(data);
        var subArea = $("#subArea");
        subArea.empty();
        for (var i = data.length - 1; i >= 0; i--) {
          subArea.append($("<option />").val(data[i].idSubarea).text(data[i].subarea));
        }  
      }


    });
   }

 });

});
