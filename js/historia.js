



  var objetoAntescedentes = {
    "personales" : "ninguno",
    "familiares" : "ninguno",
    "quirurgicos" : "ninguno",
    "toxicologicos" : "ninguno",
    "esquema" : "ninguno",
    "traumaticos" : "ninguno",
    "infecciosos" : "ninguno",
    "ginecoobstetricos" : "ninguno",
    "otros" : "ninguno"
  }

  var objetoExamen = {
    "Estado" : "clinicamente normal",
    "Cabeza" : "clinicamente normal",
    "Cara" : "clinicamente normal",
    "Orofaringe" : "clinicamente normal",
    "Cuello" : "clinicamente normal",
    "Extremidades" : "clinicamente normal",
    "Torax" : "clinicamente normal",
    "Abdomen" : "clinicamente normal",
    "Dorso" : "clinicamente normal",
    "Neurologico" : "clinicamente normal",
    "Piel" : "clinicamente normal",
    "Faneras" : "clinicamente normal",
    "Otros" : "clinicamente normal"
  }

var sesionesUsuario ;
var indexSesionUsuario;

$(document).ready(function() {


    var fechaActual = new Date();
    var day = ("0" + fechaActual.getDate()).slice(-2);
    var month = ("0" + (fechaActual.getMonth() + 1)).slice(-2);
    var today = fechaActual.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fActual').val(today);

  
    
    $('#divevolucion').hide();
    $('#divhistoria').hide();
    /**
     * Funcion para registrar un nuevo historia  
     */
    $( "#ingresarHistoria" ).click(function() {
        var textNombre =  $( "#nombre" ).text();
        textNombre = textNombre.trim();
        if(textNombre != ""){ 

            var signos = "TA:"+$('#ta').val() + " FC:"+$('#fc').val()+
                        " PESO:"+$('#peso').val() + " TALLA:"+$('#talla').val()+
                        " IMC:"+$('#imc').val();
            $('#signos').val(signos);
            $('#antecedentes').val(JSON.stringify(objetoAntescedentes));   
            var tipo_examen = $('#tipo_examen').val();
            $('#examen').val(JSON.stringify(objetoExamen));  
            $.post($('#formhistoria').attr("action"),$('#formhistoria').serialize(),
            function(data, status){
                alertify.set('notifier','position', 'top-center');
                alertify.success("Se Guardo Existosamente La Historia");  
                location.reload();
            });
        }else{
            alertify.set('notifier','position', 'top-center');
            alertify.error("Ingresar Un Paciente Valido");
        }    

    });
 
    $( ".diag" ).autocomplete({
        source: function( request, response ) {
        $.ajax( {
            url: "./administracion/obtener_diagnosticos",
            dataType: "json",
            data: {
            term: request.term
            },
            success: function( data ) {
            response( data );
            }
        } );
        },
        minLength: 2,
        select: function( event, ui ) {
            llenarCampoDesripcionAutomcompletador(ui.item.label,this);
        }
    } );

    $( ".proc" ).autocomplete({
        source: function( request, response ) {
        $.ajax( {
            url: "./administracion/obtener_procedimientos",
            dataType: "json",
            data: {
            term: request.term
            },
            success: function( data ) {
            response( data );
            }
        } );
        },
        minLength: 1,
        select: function( event, ui ) {
            llenarCampoDesripcionAutomcompletador(ui.item.label,this);
        }
    } );

    function llenarCampoDesripcionAutomcompletador(texto,objeto){
        if(objeto.id=="procehistoria"){
            $( "#procedimientoHistoria" ).val(texto);
        }
        if(objeto.id=="codiag"){
            $( "#diagnostico" ).val(texto);
        }
        if(objeto.id=="diagevol"){
            var textoEvolucion = $( "#evolucion" ).val();
            textoEvolucion = textoEvolucion +"\nDIAGNOSTICO EVOLUCION : "+texto;
            $( "#evolucion" ).val(textoEvolucion);
        }

        if(objeto.id=="proceevol"){
            var textoEvolucion = $( "#evolucion" ).val();
            textoEvolucion = textoEvolucion +"\nPROCEDIMIENTO EVOLUCION : "+texto;
            $( "#evolucion" ).val(textoEvolucion);
        }
        
    }
     

    /**
     * Funcion para registrar un nuevo evolucion  
     */
    $( "#ingresarEvolucion" ).click(function() {
            $.post('./historia/ingresar_evolucion',{
                tipodoc:$( "#tDocumnto" ).val(),
                ndoc:$( "#documento" ).val(),
                evol:$( "#evolucion" ).val(),
                id_usuario:$( "#id_usuario" ).val(),
                id_sede:$( "#id_sede" ).val(),
                codiag :$( "#diagevol" ).val(),
                coproc :$( "#proceevol" ).val()
            },
            function(data, status){
                if(data != 'null'){
                    alertify.set('notifier','position', 'top-center');
                    alertify.success("Se Guardo Existosamente La Evolucion");
                    location.reload();
                }
            });
    });


    /**
     * Funcion para consultar  historia y evoluciones del paciente
     */
    $( "#consultarHistoria" ).click(function() {
        $.post('./historia/consultar_historia',{
            tipodoc:$( "#tDocumnto" ).val(),
            documento:$( "#documento" ).val()
        },
        function(data, status){
            var dataObject = JSON.parse(data);
            sesionesUsuario = dataObject.evoluciones;
            indexSesionUsuario = 0;
            $('#encabezado').val(dataObject.historia != null ?dataObject.historia.antecedentes:"SIN NOTA INICIAL");
            cargarEvolciones();
            $('#modalVerHistoria').modal('show');
        });

    });


     /**
     * Funcion para iterar por cada evolucion que tiene el paciente
     */
    function  cargarEvolciones(){
        var stringSesionTem  = "";
        if(sesionesUsuario.length != 0 ){
        var sesionTemporal = sesionesUsuario[indexSesionUsuario] ; 
        stringSesionTem = sesionTemporal.fecha + "\n"+sesionTemporal.evol
        }
        $('#evoluciones').val(stringSesionTem);
        
    }

    $( "#cargarPrimeraSesion" ).click(function() {
        indexSesionUsuario = 0;
        cargarEvolciones();
    });

    $( "#cargarSiguienteSesion" ).click(function() {
        var indexTemporal = indexSesionUsuario+1;
        if(indexTemporal <= sesionesUsuario.length-1){ 
            indexSesionUsuario = indexTemporal;
            cargarEvolciones();
        }
    });

    $( "#cargarAnteriorSesion" ).click(function() {
        var indexTemporal = indexSesionUsuario-1;
        if(indexTemporal >= 0){ 
            indexSesionUsuario = indexTemporal;
            cargarEvolciones();
        }
    });
    
    $( "#cargarUltimaSesion" ).click(function() {
        indexSesionUsuario = sesionesUsuario.length-1;
        cargarEvolciones();
    });
    

     /**
     * Funcion para consultar la valoracion
     */
    $( ".consultarValoracion" ).click(function() {
        var textNombre =  $( "#nombre" ).text();
        textNombre = textNombre.trim();
        if(textNombre != ""){ 
            $.post('./paciente/get_valoracion',{
                tipodoc:$( "#tDocumnto" ).val(),
                documento:$( "#documento" ).val()
            },
            function(data, status){
                var dataObject = JSON.parse(data);
                $('#descripcionValoracion').val(dataObject.descripcion);
                $('#valorValoracion').val(dataObject.valor);
                $( "#ndoc" ).val($( "#documento" ).val());
                $('#modalValoracion').modal('show');
            });
        }else{
            alertify.set('notifier','position', 'top-center');
            alertify.error("Ingresar Un Paciente Valido Por Favor");
        }    
    });

    /**
       * BUscar datos paciente si existe en base de datos
       */
    $( "#documento" ).change(function() {
        cargarDatos();
    });

    function cargarDatos(){
        $.post('./paciente/buscarpaciente',{numero:$( "#documento" ).val()},
        function(data, status){
            if(data != 'null'){
                var paciente =JSON.parse(data);
                console.log(paciente);
                $( "#sexo" ).text(paciente.sexo);
                $( "#eCivil" ).text(paciente.estciv);
                $( "#nombre" ).text(paciente.nombre1 +" "+paciente.apellido1 +" "+paciente.apellido2);
                $( "#edad" ).text(paciente.edad);
                $( "#fn" ).text(paciente.cumple);
                $( "#mun" ).text(paciente.codiUbi); 
                verificarpermisos();       
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error("No Existe Usuario con la identificación ingresada"); 
            }
        
        });
    }

    function verificarpermisos(){
        var permisos = $('#permisos').val();

        if(permisos == "NOTA_INICIAL"){
            $('#divhistoria').show();           
        }

        if(permisos == "NOTA_EVOLUCION"){
            $('#divevolucion').show(); 
            $('.notasoap').hide(); 
        }

        if(permisos == "VER"){
            $('#ingresarHistoria').hide(); 
            $('#ingresarEvolucion').hide();
            $('#notasoap').hide(); 
        }
        consultahistoriapaciente(); 

    }


    /**
       * Va agregando los antescedentes del pacientes
       */
      $( "#ant_temporal" ).change(function() { 
          var tipo_antescedentes = $('#tipo_antescedentes').val();
          objetoAntescedentes[tipo_antescedentes]= $('#ant_temporal').val();
     });


      /**
       * Va agregando los examenes del pacientes
       */
      $( "#examen_tem" ).change(function() { 
        var tipo_examen = $('#tipo_examen').val();
        objetoExamen[tipo_examen]= $('#examen_tem').val();
   });

     /**
       * consulta los antecedentes agregados
       */
      $( "#tipo_antescedentes" ).change(function() { 
        var tipo_antescedentes = $('#tipo_antescedentes').val();
        $('#ant_temporal').val(objetoAntescedentes[tipo_antescedentes]);
   });

   /**
       * consulta los examenes agregados
       */
      $( "#tipo_examen" ).change(function() { 
        var tipo_examen = $('#tipo_examen').val();
        $('#examen_tem').val(objetoExamen[tipo_examen]);
   });


    /**
       * Calcula IMC 
       */
      $( "#talla" ).change(function() {
        var imc = $('#peso').val() / ( $('#talla').val() * $('#talla').val() );
        $('#imc').val(imc);
      });


      function consultahistoriapaciente(){
        var permisos = $('#permisos').val();
        $.post('./historia/tiene_historia',{numero:$( "#documento" ).val(),
                                            tipodoc:$( "#tDocumnto" ).val()},
        function(data, status){
            var respuesta = JSON.parse(data);
            if(respuesta.historia == 'TRUE'){  
                $('#divhistoria').hide();
                if(permisos == "NOTA_INICIAL"){
                    respuesta.signos = respuesta.signos +"\n\n"+
                    "SUBJETIVO:\n"+
                    "OBJETIVO:\n"+
                    "ANALISIS:\n"+
                    "PLAN:\n"
                }
                $('#evolucion').val(respuesta.signos);
                $('#divevolucion').show();    
            }  
        });
      }
});


function showModalInformes(){
    $('#modalExportHistoria').modal('show');
}

function exporHistoriaExcel(){
    var feini = $("#fechaInicioHistoria").val();
    var fefin = $("#fechaFinalHistoria").val();
    location.href="./historia/export_excel_historia?feini="+feini+"&fefin="+fefin
}

function imprimirHistoria(){
    var num = $("#documento").val();
    var tipo = $("#tDocumnto").val();
    window.open("./historia/historia_medica_pdf?numero="+num+"&tipodoc="+tipo, '_blank');
}




