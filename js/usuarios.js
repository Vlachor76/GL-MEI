$(document).ready(function() {

    if($("#permisos").val() == 'VER'){
        $("#documento").val($("#id_logueado").val());
        cargarUsuario();
        $("#documento").prop( "disabled", true );
    }

    /**
     * Funcion para registrar un nuevo usuario 
     */
    $( "#ingresarSistema" ).click(function() {
        if(document.getElementById("usuario").value == "")
        {
            alertify.set('notifier','position', 'top-center');
            alertify.error('Ingrese Usuario');
            document.getElementById("usuario").focus();
            return;	
        } 
        
        if(document.getElementById("contrasena").value == "")
        {
            alertify.set('notifier','position', 'top-center');
            alertify.error('Ingrese Contraseña');
            document.getElementById("contrasena").focus();
            return;	
        }


        $.post($('#formingreso').attr("action"),$('#formingreso').serialize(),
        function(data, status){
            if(data == "OK"){ 
                var url = $('#urlhome').val();
                location.href=url
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error(data);
            }   
        });

    });

     /**
       * BUscar datos paciente si existe en base de datos
       */
      $( "#documento" ).change(function() {
        cargarUsuario();
      });

      function cargarUsuario(){
        var identificacion = $( "#documento" ).val();
        $.post('./usuario/buscarusuario',{numero:identificacion},
        function(data, status){
            if(data != 'NO_USUARIO'){ 
                var usuario =JSON.parse(data);
                $.each(usuario, function(index, value){
                    $( "#"+index ).val(value);
                });
                $( "#password" ).val('11111');
            }else{
                $("#formusuario")[0].reset();
                $( "#documento" ).val(identificacion);
            }
           
        });
      }

      $( "#cambiarcontrasena" ).click(function() {
        var contrasenaNueva = $( "#password" ).val();
        if(contrasenaNueva == '11111'){
            alertify.set('notifier','position', 'top-center');
            alertify.error("No Se detecto Cambio Clave");
            $( "#password" ).focus();
            return;	
        } 
        if( contrasenaNueva != '' && $( "#documento" ).val() != ""){ 
            $.post('./usuario/cambiar_contrasena',{documento:$( "#documento" ).val() , password : contrasenaNueva },
            function(data, status){
                if(data == "OK"){
                    alertify.set('notifier','position', 'top-center');
                    alertify.success("Se cambio exitosamente la clave");
                    $("#formusuario")[0].reset();
                }else{
                    alertify.set('notifier','position', 'top-center');
                    alertify.error(data);
                }   
            });
        }else{
            alertify.set('notifier','position', 'top-center');
            alertify.error("Ingresar Usuario y Contraseña Valida "); 
        }
      });

    $( "#registrarusuario" ).click(function() {
        if($( "#documento" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine documento");
            $( "#documento" ).focus();
            return;	
        } 

        if($( "#nombre1" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Primer Nombre");
            $( "#nombre1" ).focus();
            return;	
        } 

        if($( "#apellido1" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Primer Apellido");
            $( "#apellido1" ).focus();
            return;	
        } 

        if($( "#edad" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Edad");
            $( "#edad" ).focus();
            return;	
        } 

        if($( "#fnacimiento" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Fecha Nacimiento");
            $( "#fnacimiento" ).focus();
            return;	
        }


        if($( "#fvinculacion" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Fecha Vinculacion");
            $( "#fvinculacion" ).focus();
            return;	
        }

        if($( "#profesional" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Profesional");
            $( "#profesional" ).focus();
            return;	
        }

        if($( "#celular" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Celular");
            $( "#celular" ).focus();
            return;	
        }

        if($( "#direccion" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Dirección");
            $( "#direccion" ).focus();
            return;	
        }

        if($( "#correo" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Correo Electronico");
            $( "#correo" ).focus();
            return;	
        }

        if($( "#cargo" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Cargo");
            $( "#cargo" ).focus();
            return;	
        }

        if($( "#eps" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Eps");
            $( "#eps" ).focus();
            return;	
        }

        if($( "#usuario" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Usuario");
            $( "#usuario" ).focus();
            return;	
        }

        if($( "#password" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Clave");
            $( "#password" ).focus();
            return;	
        }

        if($( "#psips" ).val() == ""){
            alertify.set('notifier','position', 'top-center');
            alertify.error("Determine Permisos de SIPS");
            $( "#psips" ).focus();
            return;	
        }
        $("#documento").prop( "disabled", false );
        $.post($('#formusuario').attr("action"),$('#formusuario').serialize(),
        function(data, status){
            if(data == "OK"){
                alertify.set('notifier','position', 'top-center');
                alertify.success("Se creo exitosamente el usuario");
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error(data);
            }   
        });
    });   

});

