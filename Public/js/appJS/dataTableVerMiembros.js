//Código para Datables

//$('#example').DataTable(); //Para inicializar datatables de la manera más simple
 $(document).ready(function() {   


 function llenar_tabla_Miembros(idBotonVer = '')
 {

  var verMiembrosTabla = $('#tablaVerMiembros').DataTable({
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
    "url": "?c=Grupos&a=VerMiembros",
    "type":"POST",
    "data": {
      idBotonVer:idBotonVer,
    },
  },
  "columns": [
  { "data" : "nombre" },
  { "data" : "correo" }
  ]
});


}
   

   $("button.ver").click(function(){
      var idBotonVer =$(this).attr("id");
        $('#tablaVerMiembros').DataTable().destroy();
  llenar_tabla_Miembros(idBotonVer);
    });

   //LLENAR TABLA DE VENTANA MODAL DE GESTOR DE GRUPOS 


 function llenar_tabla_MiembrosGestor(idBotonVer = '')
 {

  var verMiembrosTabla = $('#tablaVerMiembros').DataTable({
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
    "url": "?c=GestionarGrupos&a=VerMiembrosGestor",
    "type":"POST",
    "data": {
      idBotonVer:idBotonVer,
    },
  },
  "columns": [
  { "data" : "nombre" },
  { "data" : "correo" }
  ]
});


}
        $('#GestorGrupos tbody').on("click", "button.VerMiembrosGestor",function(){
      var idBotonVer =$(this).attr("id");
        $('#tablaVerMiembros').DataTable().destroy();
  llenar_tabla_MiembrosGestor(idBotonVer);
    });



  });