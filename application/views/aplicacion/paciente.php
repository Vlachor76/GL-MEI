<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">


	<title>SiipsWEB Pacientes</title>

	<!-- Lib Ext css -->
	<link href="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ext_libraries/alertify/alertify.css">

    <!-- Customs CSS -->
	<link rel="stylesheet" href="css/pacientes.css">
	<link rel="stylesheet" type="text/css" href="css/fuente.css">
	<link rel="stylesheet" type="text/css" href="css/generales.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
<nav class="navbar navbar-default">
<div class="container-fluid">
<div class="navbar-header">
	<a class="navbar-brand" href="#">SIIPSWEB</a>
</div>
<ul class="nav navbar-nav">
	<li  ><a href="<?php echo base_url(); ?>cita"  title="">Agenda Citas</a></li>
	<li class="active" ><a href="<?php echo base_url(); ?>paciente" title="" >Pacientes</a></li>
	<li><a href="<?php echo base_url(); ?>historia" title="" >Historia</a></li>
	<li><a href="<?php echo base_url(); ?>usuario" title="" >Usuarios</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
	  <li><a class="navbar-brand" href="#"></span>Usuario : <?php echo $this->session->userdata('nombre'); ?></a></li>
      <li><a href="<?php echo base_url(); ?>Login/logout"><span class="glyphicon glyphicon-log-in"></span> Cerrar Sesión</a></li>
</ul>
</div>
</nav>
	<section class="cuerpo">
		<div class="formulario">
			<form id="formpaciente" action="<?php echo site_url('paciente/crear_paciente/'); ?>" method="get" accept-charset="utf-8">
				<fieldset>
					<legend>Datos Personales</legend>
					<select id="tipoDoc" name="tipoDoc">
						<option value="CC">CC</option>
						<option value="TI">TI</option>
						<option value="NU">NU</option>
						<option value="RC">RC</option>
						<option value="PP">PP</option>
						<option value="CE">CE</option>
						<option value="MS">MS</option>
						<option value="AS">AS</option>
					</select>
					<input type="text" id="ndoc" name="ndoc" placeholder="Nro. Documento">
					<input type="text" id="nombre1" name="nombre1" placeholder="1er. nombre">
					<input type="text" id="nombre2" name="nombre2"  placeholder="2do. Nombre">
					<input type="text" id="apellido1" name="apellido1"  placeholder="1er. Apellido">
					<input type="text" id="apellido2"  name="apellido2" placeholder="2do. Apellido">
					<select id="sexo" name="sexo">
						<option value="M">Masculino</option>
						<option value="F">Femenino</option>
						<option value="0">Sex Pend</option>
					</select>
					<input type="date" id="cumple" name="cumple" placeholder="F. Cumpleaños" >
					<input type="number" id="edad" name="edad" placeholder="Edad">
					<select id="lugarnac" name="lugarnac"></select>
				</fieldset>
				<fieldset>
					<legend>Información de Contacto</legend>
					<select id="codiUbi" name="codiUbi">
						<option value="05001">Medellín</option>
						<option value="envigado">Envigado</option>
						<option value="0000">Pendiente</option>
					</select>
					<input type="hidden" name="municipio" id="municipio">
					<input id="reside" type="text" name="reside" placeholder="Dirección Residencia">
					<input type="text" id="tel1"  name="tel1" placeholder="Telefono 1">
					<input type="text" id="tel2"  name="tel2" placeholder="Telefono 2">
					<input type="text" id="celular"  name="celular" placeholder="Celular">
					<select id="estciv" name="estciv">
						<option value="SOLTERO/A">Soltero(a)</option>
						<option value="CASADO/A">Casado(a)</option>
						<option value="SEPARADO/A">Separado(a)</option>
						<option value="DIVORCIADO/A">Divorciado(a)</option>
						<option value="UNION LIBRE">Union Libre</option>
						<option value="VIUDO/A">Viudo(a)</option>
						<option value="OTRO">Otro</option>
						<option value="0">Pendiente</option>
					</select>
				</fieldset>
				<fieldset>
					<legend>Datos Aseguradora</legend>
					<input id="eps" type="text" name="eps" placeholder="Aseguradora">
					<select id="tipoafi" name="tipoafi">
						<option value="1">Cotizante</option>
						<option value="2">Beneficiario</option>
						<option value="3">Subsidiado</option>
						<option value="4">No tiene</option>
						<option value="0">Pendiente</option>
					</select>
					<input id="ocupacion" name="ocupacion" type="text" placeholder="Ocupación">
					<input id="email" name="email" type="text" placeholder="Correo Electronico">
				</fieldset>
				<fieldset>
					<legend>Datos Acompañante</legend>
					<input id="resp"  name="resp"   type="text" placeholder="Responsable" onchange="resp();">
					<input id="dirresp"  name="dirresp"  type="text" placeholder="Dirección Responsable">
					<input id="telresp"  name="telresp"   type="text" placeholder="Telefono Responsable">
					<select id="parenresp" name="parenresp">
						<option value="MADRE">Madre</option>
						<option value="PADRE">Padre</option>
						<option value="HIJO/A">Hijo(a)</option>
						<option value="HERMANO/A">Hermano(a)</option>
						<option value="ESPOSO/A">Esposo(a)</option>
						<option value="TIO/A">Tio(a)</option>
						<option value="ABUELO/A">Abuelo(a)</option>
						<option value="OTRO">Otros(a)</option>
						<option value="0">Pendiente</option>
					</select>
					<input id="acomp"  name="acomp" type="text" placeholder="Acompañante">
					<input id="telacomp" name="telacomp" type="text" placeholder="Telfono Acompañante">
				</fieldset>
				<fieldset>
					<legend>Ultima Visita</legend>
					<input id="fecha_uc"  name="fecha_uc" type="date" placeholder="F. Ultima Cita">
					<input id="medico_uc"  name="medico_uc" type="text" placeholder="Atendido Por">
					<select id="medio" name="medio">
					<option value="INSTAGRAM">Instagram</option>
					<option value="FACEBOOK">Facebook</option>
					<option value="RECOMENDACION">Referido</option>
					<option value="LOCAL">Local</option>
					<option value="PAGINA WEB">Pagina Web</option>
					<option value="PACIENTE ANTIGUO">Paciente Antiguo</option>
					<option value="OO">Otro</option>
					</select>
					<select id="consentimiento" name="consentimiento" >
						<option>Consentimiento</option>
						<option value="SI">SI</option>
						<option value="NO">NO</option>
						<option value="0">Consen Pend</option>
					</select>
					<input id="id_tipocir"  name="id_tipocir" type="text" placeholder="Procedimiento">
					<input id="refpor"  name="refpor" type="text" placeholder="Referido Por">
					<?php if($permisos == "EDITAR") {  ?>
						<button onclick="registrarpaciente()" type="button" class="icon-save" title="Registrar"></button>
						<button id="valorarPaciente" data-toggle="modal" data-target="#modalValoracion" type="button" class="icon-clipboard" title="Valoracion"></button>
					<?php } ?>
					<?php if($this->session->userdata('rol') == "6") {  ?>
						<button type="button" title="Cambiar Identificación" onclick="cambiarIdentificacion();" class="icon-refresh-ccw" ></button>
					<?php } ?>
					<button type="button" title="Exportar Pacientes" onclick="exportarPacientes();"  class="icon-grid" ></button>
					<button type="button" title="Buscar Pacientes" onclick="showModalBuscarPacientes();" class="icon-eye" ></button>
					<button id="limpiarFormPacientes" type="button" onclick="" class="icon-file" title="Limpiar Formulario"></button>
				</fieldset>				
			</form>
		</div>	
	</section>

	<!-- modalValoracion -->
	<div class="modal fade" id="modalValoracion" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-md">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Valoracion</h4>
				</div>
				<div class="modal-body">
				<div aling="center" >		
                    <div class="form-group">
					    <label for="email">Procedimientos Generales</label>
                        <textarea class="form-control" rows="6" id="descripcionValoracion"></textarea>
                    </div>
                    <br>
				   <div class="row" style="width: 80%;">
				        <div class="form-group">						
								<button type="button"  id="guardarValoracion" title="Guardar Valoracion"  class="botonesModal icon-save"></button>
								<button type="button" title="Imprimir Valoracion" onclick="imprimir_valoracion();" class="botonesModal icon-printer"></button>	
						</div>	
				   </div>
				</div>			
				</div>
			</div>  
        </div>
	</div>	


<!-- Modal Exportar Pacientes-->
	<div class="modal fade" id="modalExportPacientes" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-md">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Exportar Pacientes</h4>
				</div>
				<div class="modal-body">
					<form  accept-charset="utf-8" style="padding: 0;">
						Fecha Inicio
							<input type="date" style="height: 30px;" id="fechaInicio" placeholder="">					
						Fecha Fin
							<input type="date" style="height: 30px;" id="fechaFinal" placeholder="">
						<button type="button" title="Exportar Pacientes" onclick="exporPacientesExcel();" style="margin-top: 20px;" class="botonesModal icon-file-text"></button>									
					</form>
				</div>
			</div>  
		</div>
    </div>


	<!-- Modal Cambio Identificacion Paciente-->
	<div class="modal fade" id="modalCambioIdentidad" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-md">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cambiar Identidad</h4>
				</div>
				<div class="modal-body">
					<form  accept-charset="utf-8" style="padding: 0;">
						Doc Actual
							<input type="text" id="documentoActual" style="height: 30px;" disabled value="">					
						Doc Nuevo
							<input type="text" style="height: 30px;" id="documentoNuevo" placeholder="">
						<button type="button" title="Cambiar Identidad" onclick="cambiarIdentidad();" style="margin-top: 20px;" class="botonesModal icon-check-circle"></button>									
					</form>
				</div>
			</div>  
		</div>
    </div>


	<!-- Modal myModalBuscarCita-->
	<div class="modal fade" id="modalBuscarPaciente" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-lg">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Buscar Paciente</h4>
				</div>
				<div class="modal-body" style="height: 550px"	>
					<form class="modalPacientes" accept-charset="utf-8" style="padding: 0;">
						<input type="text" id="primerNombreBusqueda" placeholder="Nombre" >
						<input type="text" id="primerApellidoBusqueda"  placeholder="Apellido">
						<input type="text" id="telBusqueda" placeholder="Telefono">
						<input type="text" id="correoBusqueda" placeholder="Correo">
						<input type="text" id="celBusqueda" placeholder="Celular">
						<button type="button" title="Buscar Paciente" onclick="buscarPaciente();" style="margin-top: 20px;" class="botonesModal icon-eye"></button>
					</form>
					<div id="resultadoBusquedaPaciente" class="table-responsive" style="max-height: 400px;margin-top: 20px;">
					</div>
				</div>
			</div>  
		</div>
    </div>


    <!-- Lib core JavaScript -->
	<script src="<?php echo base_url(); ?>ext_libraries/jquery/jquery_3_2_1.min.js"></script>
    <script src="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.js"></script>
    <script src="<?php echo base_url(); ?>ext_libraries/alertify/alertify.js"></script>	
    <!-- Customs JavaScript -->
	<script src="<?php echo base_url(); ?>js/pacientes.js"></script>

</body>
</html>