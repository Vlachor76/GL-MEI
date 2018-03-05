    $(document).ready(function() {
        $("#mo").hide();

        var fechaActual = new Date();
        var day = ("0" + fechaActual.getDate()).slice(-2);
        var month = ("0" + (fechaActual.getMonth() + 1)).slice(-2);
        var today = fechaActual.getFullYear()+"-"+(month)+"-"+(day) ;
        $('#fecha_uc').val(today);

    obtenerMunicipios();

    function obtenerMunicipios(){
        $.ajax({
            method: "POST",
            url: "./administracion/obtener_municipios",
            context: document.body})
            .done(function(data) {  
               var  municipios = JSON.parse(data);
               $('#codiUbi').find('option').remove();
                $.each(municipios, function(index, value){     
                    $('#codiUbi').append('<option value="'+value.codubi+'">'+value.municipio+'</option>');
                });    
            });
    };
        
    $( "#registrarpaciente" ).click(function() {
        if($( "#ndoc" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Numero Documento");
            $( "#ndoc" ).focus();
            return;	
        } 

        if($( "#nombre1" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Primer Nombre ");
            $( "#nombre1" ).focus();
            return;	
        }

        if($( "#apellido1" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Primer Apellido ");
            $( "#apellido1" ).focus();
            return;	
        }

        if($( "#sexo" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Sexo");
            $( "#sexo" ).focus();
            return;	
        }

        if($( "#cumple" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Fecha Cumpleaños");
            $( "#cumple" ).focus();
            return;	
        }

        if($( "#reside" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Residencia");
            $( "#reside" ).focus();
            return;	
        }

        if($( "#codiUbi" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Ciudad");
            $( "#codiUbi" ).focus();
            return;	
        }

        if($( "#tel1" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Telefono Principal");
            $( "#tel1" ).focus();
            return;	
        }

        if($( "#celular" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Celular");
            $( "#celular" ).focus();
            return;	
        }

        if($( "#estciv" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Estado Civil");
            $( "#estciv" ).focus();
            return;	
        }

        if($( "#eps" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Eps");
            $( "#eps" ).focus();
            return;	
        }

        if($( "#tipoafi" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Tipo Afiliación");
            $( "#tipoafi" ).focus();
            return;	
        }

        if($( "#resp" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine El Nombre Responsable");
            $( "#resp" ).focus();
            return;	
        }

        if($( "#dirresp" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine La Dirección Responsable ");
            $( "#dirresp" ).focus();
            return;	
        }

        if($( "#parenresp" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine El Parentesco Del Responsable ");
            $( "#parenresp" ).focus();
            return;	
        }

        if($( "#acomp" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine El Acompañante ");
            $( "#acomp" ).focus();
            return;	
        }

        if($( "#telacomp" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine El Telefono Acompañante ");
            $( "#telacomp" ).focus();
            return;	
        }

       

        

       

        

        

       
        $("#ndoc").prop( "disabled", false );
        $("#tipoDoc").prop( "disabled", false );

        $.post($('#formpaciente').attr("action"),$('#formpaciente').serialize(),
        function(data, status){
            if(data == "OK"){
                alertify.set('notifier','position', 'top-center');
                alertify.success("Se creo y/o edito exitosamente el paciente");
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error(data);
            }   
        });


      });

      /**
       * BUscar datos paciente si existe en base de datos
       */
      $( "#ndoc" ).change(function() {
        $.post('./paciente/buscarpaciente',{numero:$( "#ndoc" ).val()},
        function(data, status){
            if(data != 'null'){
                var paciente =JSON.parse(data);
                $.each(paciente, function(index, value){
                    $( "#"+index ).val(value);
                });
                $("#descripcionValoracion").val(paciente.valoracion);
                $("#ndoc").prop( "disabled", true );
                $("#tipoDoc").prop( "disabled", true );
                calcularEdad();
            }
           
        });
      });


      /**
       * Guarda la valoracion del paciente
       */
      $( "#guardarValoracion" ).click(function() {
        var numero = $( "#ndoc" ).val();
        if(numero != ""){ 
        $.post('./paciente/guardar_valoracion',{
            numero:$( "#ndoc" ).val(),
            valoracion : $( "#descripcionValoracion" ).val() },
        function(data, status){
            if(data == 'OK'){
                alertify.set('notifier','position', 'top-center');
                alertify.success("Se creo exitosamente la valoración");
                $('#modalValoracion').modal('hide'); 
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error("Error Al Guardar Valoración");
            }
        });

        }else{
            alertify.set('notifier','position', 'top-center');
            alertify.error("Ingresar Un Paciente Valido");     
        }  

      });


      /**
       * Limpiar Formulario Paciente
       */
      $( "#limpiarFormPacientes" ).click(function() {
        $("#ndoc").prop( "disabled", false );
        $("#tipoDoc").prop( "disabled", false );
        $("#formpaciente")[0].reset(); 
      });

      /**
       * Calcular Cumpleaños
       */
      $( "#cumple" ).change(function() {
         calcularEdad();
      });

      function calcularEdad(){
        var hoy = new Date();
        var cumpleanos = new Date($("#cumple").val());
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
            edad--;
        }
        $("#edad").val(edad);
      }
      
});


function exportarPacientes(){
    $('#modalExportPacientes').modal('show');
}

function cambiarIdentificacion(){
    var identificacionActual = $('#ndoc').val();
    if(identificacionActual.length > 1 ){
      $('#documentoActual').val(identificacionActual);
      $('#modalCambioIdentidad').modal('show');
    }else{
        alertify.set('notifier','position', 'top-center');
        alertify.error("Ingresar Un Paciente Valido"); 
    }   
}

function cambiarIdentidad () { 
    var identificacionActual = $('#ndoc').val();
    var identificacionNueva = $( "#documentoNuevo" ).val();
    if(identificacionNueva.length > 1){
        if(confirm("Estas Seguro de cambiar Numero :"+identificacionActual +" Por : "+identificacionNueva)){ 
            
            $.post('./paciente/cambiar_identificacion',{
                identificacionActual:identificacionActual,
                identificacionNueva : identificacionNueva },
            function(data, status){
                if(data == 'OK'){
                    alertify.set('notifier','position', 'top-center');
                    alertify.success("Se Cambio Exitosamente El Documento");
                    $('#ndoc').val(identificacionNueva);
                    $('#modalCambioIdentidad').modal('hide'); 
                }else{
                    alertify.set('notifier','position', 'top-center');
                    alertify.error("Error Al Guardar Valoración");
                }
            });
        }
    }else{
        alertify.set('notifier','position', 'top-center');
        alertify.error("Ingresar Un Documento Nuevo Valido");     
    }
    }

function exporPacientesExcel(){
    $('#fechaInicio').val();
    $('#fechaFinal').val();

    var fechaInicio = $('#fechaInicio').val();
    var fechaFinal = $("#fechaFinal").val();
    location.href="./paciente/export_excel?feini="+fechaInicio+"&fefin="+fechaFinal
}





