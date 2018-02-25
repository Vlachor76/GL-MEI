
// Se llama la consulta de los datos para llenar la grilla
var listadoCitas ;
var objetoActual ;

setInterval("llenarGrillaCitas()", 10000);

$(document).ready(function() {
    $( "#sedeSeleccionada" ).val($("#id_sede").val());
    llenarDatosSede();
});


  $( "#selectorLugares" ).change(function() {
    llenarGrillaCitas();
  });

  $( "#sedeSeleccionada" ).change(function() {
    $("#opcionLugar7").text("");
    $("#opcionLugar8").text("");
    $("#opcionLugar9").text("");
    $('#selectorLugares').find('option').remove();
    llenarDatosSede();
  });

  

  $( "#fechaGrilla" ).change(function() {
    llenarGrillaCitas();
  });

  $( "#sedeSeleccionada" ).change(function() {
    llenarGrillaCitas();
  });

/*llenarDatosSede
* Es la funcion encargada de setear los valores iniciales de la grilla
* Setea el valor del dia actual , la sede actual y el lugar predeterminado por cada sede
*
*/
function llenarDatosSede(){
    var fechaActual = new Date();
    var day = ("0" + fechaActual.getDate()).slice(-2);
    var month = ("0" + (fechaActual.getMonth() + 1)).slice(-2);
    var today = fechaActual.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechaGrilla').val(today);
    //$('#fechaGrilla').prop('min',today);
    var sede = $( "#sedeSeleccionada" ).val();
    $.ajax({
        method: "POST",
        url: "./cita/lugarsede",
        data: { sede: sede },
        context: document.body})
        .done(function(data) {  
           $.each(JSON.parse(data), function(index, value){
            $('#selectorLugares').append('<option value="'+value.id_lugar_sede+'">'+value.nombre+'</option>');
            var lugarTemporal = "#opcionLugar"+value.id_lugar_sede;
            $(lugarTemporal).text(value.nombre_corto);
        });
        llenarGrillaCitas()
        });
    $("#sedeSeleccionada").val(sede);
}

/*llenarGrillaCitas
* Es la funcion encargada de consultar via ajax la informacion de la grilla
* consulta las citas de una sede,lugar y fecha especifica
*/
function llenarGrillaCitas(){
    var inHTML = ""; 
    var lugarCitas = $("#selectorLugares").val()
    var sede = $("#sedeSeleccionada").val();
    var fechaGrilla = $("#fechaGrilla").val();
    $.ajax({
        method: "POST",
        url: "./cita/getcitas",
        data: { lugar: lugarCitas ,sede: sede , fecha :fechaGrilla },
        context: document.body})
        .done(function(data) {  
            listadoCitas = data;
            $.each(JSON.parse(listadoCitas), function(index, value){     
                var newItem = "<div class='grup' style='background:"+value.color+"'>"+
                "<div class='hora'><a  onclick='showModalTomarCita("+index+")'  >"+ value.hora +"</a></div>"+
                "<div class='paciente' onclick='showModalTomarCita("+index+")' >"+value.primerNombre +" "+value.primerApellido +"</div>"+
                "<div class='telefono' onclick='showModalTomarCita("+index+")' >"+(value.telefono?value.telefono:"")+"</div>"+
                "<div class='paciente' onclick='showModalTomarCita("+index+")' >"+value.observacion+"</div>"+
                "<div class='tipo'     onclick='showModalTomarCita("+index+")' >"+(value.estadoConsulta?value.estadoConsulta:"")+"</div>"+
                "<div class='espacio'>  </div>"+
                "<div class='prof' onclick='cambiarLugar(1)' >"+(value.lugar1?value.lugar1:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(2)' >"+(value.lugar2?value.lugar2:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(3)' >"+(value.lugar3?value.lugar3:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(4)' >"+(value.lugar4?value.lugar4:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(5)' >"+(value.lugar5?value.lugar5:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(6)' >"+(value.lugar6?value.lugar6:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(7)' >"+(value.lugar7?value.lugar7:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(8)' >"+(value.lugar8?value.lugar8:"")+"</div>"+
                "<div class='prof' onclick='cambiarLugar(9)' >"+(value.lugar9?value.lugar9:"")+"</div>"+
                "</div>"
                    inHTML += newItem;  
                });
                $("div#divCitas").html(inHTML);
    });

    
}


function cambiarLugar(idLugar){
    var existeLugar = $("#selectorLugares option[value='" + idLugar + "']").length !== 0;
    if(existeLugar){ 
    $("#selectorLugares").val(idLugar);
    llenarGrillaCitas(); 
   }
}

function exportarCitas (){
    var lugarCitas = $("#selectorLugares").val()
    var sede = $("#sedeSeleccionada").val();
    var fechaGrilla = $("#fechaGrilla").val();
    location.href="./cita/export_excel?lugar="+lugarCitas+"&sede="+sede+"&fecha="+fechaGrilla
}


function showModalEliminarCita(){   
    var idCitaUNico = $('#idCitaUnicoEliminar').val();
    if(idCitaUNico!=0){ 
     $('#myModalEliminar').modal('show')
    } 
}

function showModalbuscarCita(){
    $('#myModalBuscarCita').modal('show');
}

function buscarCita(){
    $("div#resultadoBusquedaCitas").html("");
    if($('#fechaInicio').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Determine Fecha Inicio Busqueda");         
        $('#fechaInicio').focus();
        return;	
    } 

    if($('#fechaFinal').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Determine Fecha Final Busqueda");         
        $('#fechaFinal').focus();
        return;	
    }

    var inHTML = ""; 
    var sede = $("#sedeSeleccionada").val();
    var fechaInicio = $("#fechaInicio").val();
    var fechaFinal = $("#fechaFinal").val();
    var primerNombreBusqueda = $("#primerNombreBusqueda").val();
    var nroDocumentoBusqueda = $("#nroDocumentoBusqueda").val();
    var correoBusqueda = $("#correoBusqueda").val();
    $.ajax({
        method: "POST",
        url: "./cita/buscarcitas",
        data: { fechaFinal: fechaFinal ,sede: sede , fechaInicio :fechaInicio,
                primerNombreBusqueda:primerNombreBusqueda , nroDocumentoBusqueda:nroDocumentoBusqueda,
                correoBusqueda:correoBusqueda },
        context: document.body})
        .done(function(data) {  
            if(data != 'NO_DATOS') { 
            inHTML +='<div class="grupo">'+
            '<div class="hora">hora</div>'+
            '<div class="paciente">Documento</div>'+
            '<div class="paciente">Paciente</div>'+
            '<div class="telefono">Estado</div>'+
            '<div class="datos_adicionales">Fecha</div>'+
            '<div class="datos_adicionales">Accion</div>'+
            '</div>'
            $.each(JSON.parse(data), function(index, value){     
                var newItem = "<div class='grup'>"+
                "<div class='hora'>"+ value.hora +"</div>"+
                "<div class='paciente'>"+ value.nroDocumento +"</a></div>"+
                "<div class='paciente'  >"+value.primerNombre +" "+value.primerApellido +"</div>"+
                "<div class='telefono'  >"+value.estadoConsulta+"</div>"+
                "<div class='datos_adicionales'  >"+value.fecha+"</div>"+   
                "<div class='datos_adicionales'  ><a onclick='irAgenda(\""+value.fecha+"\",\""+value.idArea+"\",\""+value.idsede+"\");' href='#'>Ir Agenda</a></div>"+
                "</div>"
                    inHTML += newItem;  
                }); 
                $("div#resultadoBusquedaCitas").html(inHTML);
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error("No se Encontraron Coincidencias con los datos ingresados");
            }    
                
    });
  

}


/**
 * BUscar datos paciente si existe en base de datos
 */
$( "#nroDocumento" ).change(function() {
$.post('./paciente/buscarpaciente',{numero:$( "#nroDocumento" ).val()},
function(data, status){
    if(data != 'null'){
        var paciente =JSON.parse(data);
        $( "#primerNombre").val(paciente.nombre1);
        $( "#segundoNombre").val(paciente.nombre2);
        $( "#primerApellido").val(paciente.apellido1);
        $( "#segundoApellido").val(paciente.apellido2);
        $( "#telefono").val(paciente.tel1);
        $( "#celular").val(paciente.celular);
        $( "#correo").val(paciente.email);
        $( "#fechaNacimiento").val(paciente.cumple);
        $( "#crearUsuario").val("false");
    }
    
});
});

function irAgenda(fecha,idarea,idsede){
    $.ajax({
        method: "POST",
        url: "./cita/lugarsede",
        data: { sede: idsede },
        context: document.body})
        .done(function(data) {  
           $.each(JSON.parse(data), function(index, value){
            $('#selectorLugares').append('<option value="'+value.id_lugar_sede+'">'+value.nombre+'</option>');
            var lugarTemporal = "#opcionLugar"+value.id_lugar_sede;
            $(lugarTemporal).text(value.nombre_corto);
    });
        $("#selectorLugares").val(idarea);
        $("#fechaGrilla").val(fecha);
        llenarGrillaCitas();
        $('#myModalBuscarCita').modal('hide');
        });
}

function formato(fecha){
    return fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
  }

function showModalTomarCita (idCita) {
        var listadoJson = JSON.parse(listadoCitas);
        var obj = listadoJson[idCita];
        objetoActual = obj;   
        $('#accion').val('insert'); 
        $('#horaSeleccionada').val(obj.hora);
        var fechaSeleccionada =  $('#fechaGrilla').val();
        fechaSeleccionada =formato(fechaSeleccionada);
        var usuario = $('#userlogueado').val();
        $.ajax({
            method: "POST",
            url: "./cita/verificaredicion",
            data: { horaSeleccionada: $('#horaSeleccionada').val() ,lugar:$('#selectorLugares').val() ,
                    sedeSeleccionada:$('#sedeSeleccionada').val(),fechaSolicitada:$('#fechaGrilla').val()}, 
            context: document.body})
            .done(function(data) {  
              if(data.trim() == "OK"){
                $('#idCitaUnico').val(obj.idUnicoCita);
                if(obj.nroDocumento == '' && localStorage.getItem("citaMover")){
                    obj=JSON.parse(localStorage.getItem("citaMover"));
                    $('#accion').val('move');
                    $('#idCitaUnico').val(obj.idUnicoCita);    
                }
                
                $('#tituloModalCita').text("Tomar Cita  "+ fechaSeleccionada+"  "+obj.hora +"  por "+usuario);
                $('#idCitaUnicoEliminar').val(obj.idUnicoCita);  
                $('#nroDocumento').val(obj.nroDocumento);
                $('#primerNombre').val(obj.primerNombre);
                $('#segundoNombre').val(obj.segundoNombre);
                $('#primerApellido').val(obj.primerApellido);
                $('#segundoApellido').val(obj.segundoApellido);
                $('#telefono').val(obj.telefono);
                $('#celular').val(obj.celular);
                $('#correo').val(obj.correo);
                $('#observacion').val(obj.observacion);
                $('#tipoConsulta').val((obj.tipoConsulta?obj.tipoConsulta:"CM"));
                $('#estadoConsulta').val((obj.estadoConsulta?obj.estadoConsulta:"I"));
                $('#medio').val((obj.medio?obj.medio:""));
                $('#fechaNacimiento').val(obj.fechaNacimiento);
                $('#tipo_viejo').val(obj.tipoViejo);
                $('#fechaSeleccionada').val($('#fechaGrilla').val())
                $('#fechaSolicitada').val($('#fechaGrilla').val());
                if(obj.vista == 1){
                 $('#vista').prop('checked', true); 
                }
                if(obj.nroDocumento!=''){
                    $('#moverCita').disabled=true;
                }
                $('#myModal').modal('show')
              }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error("El espacio esta siendo editado por otro usuario");
              }
        });
        
        
}

$("#myModal").on('hidden.bs.modal', function () {
    $('#vista').prop('checked', false); 
    $.ajax({
        method: "POST",
        url: "./cita/eliminaredicion",
        data: { horaSeleccionada: $('#horaSeleccionada').val() ,lugar:$('#selectorLugares').val() ,
                sedeSeleccionada:$('#sedeSeleccionada').val(),fechaSolicitada:$('#fechaGrilla').val()}, 
        context: document.body})
        .done(function(data) {     
        });
});

function eliminarCita(){
    if($('#observacionEliminar').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Ingrese Una Observacion Valida");             
        $('#observacionEliminar').focus();
        return;	
   } 
    var confirmar=confirm("Estas Seguro de Eliminar La Cita"); 
    if (confirmar) { 
        $.ajax({
            method: "POST",
            url: "./cita/curdcita",
            data: { accion: "delete" ,idUnicoCita:$('#idCitaUnicoEliminar').val(),
            observacionEliminar: $('#observacionEliminar').val()}, 
            context: document.body})
            .done(function(data) {  
              if(data.trim() == "OK"){
                alertify.set('notifier','position', 'top-center');
                alertify.success("Se realizo la Operacion Con Exito");
                  llenarGrillaCitas();
                  $('#myModalEliminar').modal('hide');
                  $('#myModal').modal('hide');
              }
        });
    }else{
        $('#myModalEliminar').modal('hide');
    } 
}  

function borrarDatosModal(){
    $('#nroDocumento').val("");
    $('#primerNombre').val("");
    $('#segundoNombre').val("");
    $('#primerApellido').val("");
    $('#segundoApellido').val("");
    $('#observacion').val("");
    $('#tipoConsulta').val("C");
    $('#estadoConsulta').val("P");
    $('#medio').val("IN");
    $('#fechaNacimiento').val("");
    $('#fechaSolicitada').val($('#fechaGrilla').val());
}

function guardarDatosModal(){
    var isValido=validarFormularioModal();
    if(isValido){ 
    var usuario = localStorage.getItem("usuario");
    var vista_check =  $('#vista').is(':checked') ? "1":"0";   
    $.ajax({
        method: "POST",
        url: "./cita/curdcita",
        data: { accion: $('#accion').val() ,nroDocumento: $('#nroDocumento').val() ,
                primerNombre :$('#primerNombre').val(),segundoNombre:$('#segundoNombre').val(),
                segundoApellido:$('#segundoApellido').val(),primerApellido:$('#primerApellido').val(),
                observacion:$('#observacion').val(),
                tipoConsulta:$('#tipoConsulta').val(),estadoConsulta:$('#estadoConsulta').val(),
                medio:$('#medio').val(),fechaNacimiento:$('#fechaNacimiento').val(),fechacita:$('#fechaSeleccionada').val(),
                horaSeleccionada:$('#horaSeleccionada').val(),fechaSolicitada:$('#fechaSolicitada').val(),
                celular:$('#celular').val(),correo:$('#correo').val(),vista:vista_check,
                telefono:$('#telefono').val(),sedeSeleccionada:$('#sedeSeleccionada').val(),
                lugar:$('#selectorLugares').val(),idUnicoCita:$('#idCitaUnico').val(),
                crearUsuario : $('#crearUsuario').val(),tipoDoc : $('#tdocumento').val()
              }, 
        context: document.body})
        .done(function(data) {  
          if(data.trim() == "OK"){
            alertify.set('notifier','position', 'top-center');
            alertify.success("Se realizo la Operacion Con Exito");
              llenarGrillaCitas();
              $('#myModal').modal('hide');
              localStorage.removeItem("citaMover");
          }
    });
  }
}

function moverCita(){
   if(objetoActual.primerNombre != ''){
      localStorage.setItem("citaMover",JSON.stringify(objetoActual));
      $('#myModal').modal('hide');
   }
}

function validarFormularioModal(){
    var tipoConsulta  = $('#tipoConsulta').val()
    if(tipoConsulta == 'B'){
        $('#crearUsuario').val('false')
        return true;
    } 

    if($('#primerNombre').val() == '*'){
        $('#crearUsuario').val('false')
        return true;
    } 

    if($('#tdocumento').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Determine TipoDoc");         
            $('#tdocumento').focus();
            return false;	
    } 

    if($('#nroDocumento').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Determine Numero Documento");     
        $('#nroDocumento').focus();
        return false;	
    } 

    if($('#primerNombre').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Determine Primer Nombre");
        $('#primerNombre').focus();
        return false;	
    } 
    if($('#primerApellido').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Determine Primer Apellido");
        $('#primerApellido').focus();
        return false;		
    } 
    if($('#fechaNacimiento').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Determine fecha Nacimiento");
        $('#fechaNacimiento').focus();
        return false;		
    } 
    return true;
}


function imprimir(){
    window.print();
}