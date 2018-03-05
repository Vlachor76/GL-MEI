$('#nroDocPaq').keyup(function(e) {
    if(e.keyCode == 13) {
        consultarPaquetesPaciente(0);
    }
});



$('#resultadoPaquetes').hide();

function showModalNuevoPaquete(){
    $.ajax({
        method: "POST",
        url: "./administracion/obtener_paquetes",
        context: document.body})
        .done(function(data) {  
           var  paquetes = JSON.parse(data);
           $('#paqNuevo').find('option').remove();
            $.each(paquetes, function(index, value){     
                $('#paqNuevo').append('<option value="'+value.id_paq+'">'+value.nombre+'</option>');
            });    
            $('#modalNuevoPaquete').modal('show');
        });
    
}


function showModalEliminarPaquete(){   
    var idPaquete = $('#idPaquete').val();
    if(idPaquete!=0){ 
     $('#modalEliminarPaquete').modal('show')
    } 
}

function eliminarPaquete(){
if($('#observacionEliminarP').val() == ""){
    alertify.set('notifier','position', 'top-center');
    alertify.error("Ingrese Una Motivo Valida");             
    $('#observacionEliminarP').focus();
    return;	
} 
var confirmar=confirm("Estas Seguro de Eliminar El Paquete"); 
if (confirmar) { 
    $.ajax({
        method: "POST",
        url: "./paquete/eliminar_paquete_unico",
        data: { idpaquete:$('#paqAdquiridos').val(),
        observacionEliminar: $('#observacionEliminarP').val()}, 
        context: document.body})
        .done(function(data) {  
          if(data.trim() == "OK"){
            alertify.set('notifier','position', 'top-center');
            alertify.success("Se realizo la Operacion Con Exito");
            consultarPaquetesPaciente(0);
            $('#modalEliminarPaquete').modal('hide');
          }
    });
}else{
    $('#modalEliminarPaquete').modal('hide');
} 
} 



function showModalInformes(){
    $('#modalExportPaquetes').modal('show');
}


function showModalNuevaSesion(){
    $('#abonoSesion').val(0);
    $('#modalNuevaSesion').modal('show');
}


function showModalRegresarSesion(){
    $('#modalRegresarSesion').modal('show');
}


function exporSesionesExcel(){
    var feini = $("#fechaInicioSesiones").val();
    var fefin = $("#fechaFinalSesiones").val();
    location.href="./paquete/export_excel_sesiones?feini="+feini+"&fefin="+fefin
}


function exporPaqueteExcel(){
    var feini = $("#fechaInicioPaquete").val();
    var fefin = $("#fechaFinalPaquetes").val();
    location.href="./paquete/export_excel_paquete?feini="+feini+"&fefin="+fefin
}


function showModalSesiones(){
    var inHTML = "";
    $.ajax({
        method: "POST",
        url: "./paquete/idpaquete",
        data: { idpxp: $("#paqAdquiridos").val() },
        context: document.body})
        .done(function(data) {  
           var  datosPaquete = JSON.parse(data);
           var sesionespaquete = datosPaquete.sesionespaquete;
           $.each(sesionespaquete, function(index, value){ 
                var newItem = "<tr>"+
                "<td>"+ value.fecha +"</td>"+
                "<td>"+ value.usuario +"</td>"+
                "<td>"+ value.abono +"</td>"+
                "<td>"+ value.observacion +"</td>"+
                "<td>"+ value.sede +"</td>"+
                "<td>"+ value.valor +"</td>"+     
                "</tr>"
                    inHTML += newItem;  
            });      
            $("#bodyTableSesionesModal").html(inHTML);         
            $('#modalSesiones').modal('show') 
        });   
}


function guardarPaqueteNuevo(){
    var isValido=validarFormularioModal();
    if(isValido){
    $.ajax({
        method: "POST",
        url: "./paquete/crearpaquete",
        data: { nroDocumento: $('#nroDocPaq').val() ,
                tipoDocPaq :$('#tipoDocPaq').val(),paqNuevo:$('#paqNuevo').val(),
                sesionesPaqNuevo:$('#sesionesPaqNuevo').val(),observacionesPaqNuevo:$('#observacionesPaqNuevo').val(),
                precioPaqNuevo:$('#precioPaqNuevo').val()
              }, 
        context: document.body})
        .done(function(data) {  
          if(data.trim() == "OK"){
              $('#precioPaqNuevo').val('');
              $('#sesionesPaqNuevo').val('');
              $('#observacionesPaqNuevo').val('');
              $('#precioPaqNuevo').val('');
              $('#modalNuevoPaquete').modal('hide');
              consultarPaquetesPaciente(0);
          }
    });
  }
}


function regresarSesionPaquete(){

    if($('#observacionRegresarSesion').val() == ""){
        alertify.set('notifier','position', 'top-center');
        alertify.error("Ingresar Una Observación Para Regresar La Sesion");              
        $('#observacionRegresarSesion').focus();
        return ;	
    }

     $.ajax({
        method: "POST",
        url: "./paquete/regresar_sesion",
        data: { observacionregreso: $('#observacionRegresarSesion').val(),
                idpxp: $("#paqAdquiridos").val()
              }, 
        context: document.body})
        .done(function(data) {  
          if(data.trim() == "OK"){
              $('#observacionRegresarSesion').val('');
              $('#modalRegresarSesion').modal('hide');
              consultarPaquetesPaciente($("#paqAdquiridos").val());
          }
    });

}

function guardarSesionPaquete(){
    var isValido=validarFormularioModalSesion();
    if(isValido){ 
        var nrosesion = parseInt($("#actual").text())+1;
        var activo;
        if(nrosesion ==  parseInt($("#total").text())){
            activo = 0;
        }else{
            activo = 1;
        }
    $.ajax({
        method: "POST",
        url: "./paquete/crearsesion",
        data: { accion:"insert",abonosesion: $('#abonoSesion').val() ,
                observacionSesion :$('#observacionSesion').val(),
                idpxp: $("#paqAdquiridos").val(),nrosesion:nrosesion,activo:activo
              }, 
        context: document.body})
        .done(function(data) {  
          if(data.trim() == "OK"){
              $('#abonoSesion').val('');
              $('#observacionSesion').val('');
              $('#modalNuevaSesion').modal('hide');
              consultarPaquetesPaciente($("#paqAdquiridos").val());
          }
    });
  }
}



function validarFormularioModalSesion(){
    if($('#abonoSesion').val() == ""){
            alert("Determine Abono de la sesion actual");         
            $('#abonoSesion').focus();
            return false;	
    } 


    if($('#observacionSesion').val() == ""){
        alert("Determine Observacion sesion");     
        $('#observacionSesion').focus();
        return false;	
    } 

    if(parseInt($("#pend").text()) == 0){
        alert("Paquete Sin Sesiones Pendientes");
        return false;	
    }

    return true;
}

function validarFormularioModal(){
    if($('#paqNuevo').val() == ""){
            alert("Determine Paquete a Crear");         
            $('#paqNuevo').focus();
            return false;	
    } 

    if($('#sesionesPaqNuevo').val() == ""){
        alert("Determine Numero Sesiones del Paquete");     
        $('#sesionesPaqNuevo').focus();
        return false;	
    } 

    if($('#precioPaqNuevo').val() == ""){
        alert("Determine El precio del paquete");
        $('#precioPaqNuevo').focus();
        return false;	
    } 

    return true;
}





function consultarPaquetesPaciente(paquete_default){

    if($("#nroDocPaq").val()!= ''){ 
    $.ajax({
        method: "POST",
        url: "./paquete/paquetes_usuario",
        data: { nrodocumento: $("#nroDocPaq").val() , 
                tipoDocPaq :$('#tipoDocPaq').val() },
        context: document.body})
        .done(function(data) {  
           var  datosIniciales = JSON.parse(data);
           if(datosIniciales.nombre != '' ){
            borrarFormularioPaquetes(); 
            $("#nombresPaquete").val(datosIniciales.nombre);
            $("#apellidosPaquete").val(datosIniciales.apellidos);
            var paquetes = datosIniciales.paquetesActivos;
            $('#paqAdquiridos').find('option').remove();
            $.each(paquetes, function(index, value){     
                $('#paqAdquiridos').append('<option value="'+value.id_paquete+'">'+value.nombre_paquete+'</option>');
            });
            if(paquete_default != 0){
                $('#paqAdquiridos').val(paquete_default);
            }           
                if(Object.keys(paquetes).length > 0){
                    consultaridpaquete();
                }else{
                    alertify.set('notifier','position', 'top-center');
                    alertify.error("El Paciente No Tiene Paquetes Disponibles");
                    $('#resultadoPaquetes').show(); 
                }
            }else{
              alertify.set('notifier','position', 'top-center');
              alertify.error("Paciente No Registrado,Verifique el documento por favor");
              borrarFormularioPaquetes(); 
              $('#resultadoPaquetes').hide(); 
            }    
                
        });   
    }else{
        alertify.set('notifier','position', 'top-center');
        alertify.error("Ingresar un numero de identificacion válidor");
        $("#nroDocPaq").focus();
    }    
}

function borrarFormularioPaquetes(){
    $("#formPaquetes")[0].reset(); 
    $("#bodyTableSesiones").html("");
    $("#total").text("");
    $("#actual").text("");
    $("#pend").text("");
}

function consultaridpaquete(){
    var inHTML = "";
    $.ajax({
        method: "POST",
        url: "./paquete/idpaquete",
        data: { idpxp: $("#paqAdquiridos").val() },
        context: document.body})
        .done(function(data) {  
           var  datosPaquete = JSON.parse(data);
           $("#sedePaquete").val(datosPaquete.sede);
           $("#total").text(datosPaquete.total);
           $("#actual").text(datosPaquete.actual);
           $("#pend").text(datosPaquete.pend);
           $("#fechaini").val(datosPaquete.fechaini);
           $("#valortotal").val(datosPaquete.valor);
           $("#abonos").val(datosPaquete.abonos);
           $("#saldo").val(datosPaquete.saldo);
           $("#observacion").val(datosPaquete.observaciones);

           var sesionespaquete = datosPaquete.sesionespaquete;
           $.each(sesionespaquete, function(index, value){ 
                var newItem = "<tr>"+
                "<td>"+ value.fecha +"</td>"+
                "<td>"+ value.usuario +"</td>"+
                "<td>"+ value.abono +"</td>"+
                "<td>"+ value.observacion +"</td>"+
                "<td>"+ value.sede +"</td>"+
                "<td>"+ value.valor +"</td>"+     
                "</tr>"
                    inHTML += newItem;  
            });      
            $("#bodyTableSesiones").html(inHTML);
           
            $('#resultadoPaquetes').show();    
        });   
}


$( "#paqAdquiridos" ).change(function() {
    consultaridpaquete();
  });


