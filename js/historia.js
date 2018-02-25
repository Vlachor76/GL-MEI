
  var objetoAntescedentes = {
    "personales" : "ninguno",
    "familiares" : "ninguno",
    "qx" : "ninguno",
    "toxicologicos" : "ninguno",
    "esquema" : "ninguno",
    "traumaticos" : "ninguno",
    "infecciosos" : "ninguno",
    "ginecoobstetricos" : "ninguno",
    "otros" : "ninguno"
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
            $('#examen').val(tipo_examen+"|"+$('#examen').val());
            $.post($('#formhistoria').attr("action"),$('#formhistoria').serialize(),
            function(data, status){
                alertify.set('notifier','position', 'top-center');
                alertify.success("Se Guardo Existosamente La Historia");  
                cargarDatos();
            });
        }else{
            alertify.set('notifier','position', 'top-center');
            alertify.error("Ingresar Un Paciente Valido");
        }    

    });


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
                    cargarDatos();
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
        stringSesionTem = sesionTemporal.fecha_registro + "\n"+sesionTemporal.evol
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
       * consulta los antecedentes agregados
       */
      $( "#tipo_antescedentes" ).change(function() { 
        var tipo_antescedentes = $('#tipo_antescedentes').val();
        $('#ant_temporal').val(objetoAntescedentes[tipo_antescedentes]);
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
      
      /**
       * Autocompletador de procedimientos 
       
      var availableTags = [
        "Rock",
        "Rap",
        "Trova",
        "Blues",
        "Country",
        "Folk",
        "Jass",
        "POP",
        "Electronic"
      ];
      $( "#tags" ).autocomplete({
        source: availableTags
      });

      $( "#tags" ).keyup(function( event ) {
        var procedimiento = $("#tags").val();
        if(procedimiento.length > 1){
            $.post('./administracion/obtener_procedimientos',{procedimiento:$( "#tags" ).val()},
        function(data, status){
            var respuesta = JSON.parse(data);
            var nombres = respuesta.nombre;
            $( "#tags" ).autocomplete({
                source: nombres
            });
        });
        }
        
      });

      $("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "./administracion/obtener_procedimientos",
		data:'procedimiento='+$(this).val(),
		success: function(data){
            var respuesta = JSON.parse(data);
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(respuesta);
			$("#search-box").css("background","#FFF");
		 }
		});
    });
    */

});



