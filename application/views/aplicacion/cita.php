<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SiipsWEB Toma de Citas</title>	
    <!-- Lib Ext css -->
	<link href="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ext_libraries/alertify/alertify.css">
	<!-- Customs CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/fuente.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/citas.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/generales.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
	
</head>
<body>
<nav class="navbar navbar-default">
<div class="container-fluid">
<div class="navbar-header">
	<a class="navbar-brand" href="#">SIIPSWEB</a>
</div>
<ul class="nav navbar-nav">
	<li class="active" ><a href="<?php echo base_url(); ?>cita"  title="">Agenda Citas</a></li>
	<li><a href="<?php echo base_url(); ?>paciente" title="" >Pacientes</a></li>
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
		<div class="grilla">
			<form action=""  accept-charset="utf-8">
			<input type="hidden" id="id_sede"    value="<?php echo $this->session->userdata('id_sede'); ?>">
			<input type="hidden" id="rol"    value="<?php echo $this->session->userdata('rol'); ?>">
				<select name="sedeSeleccionada" id="sedeSeleccionada">
	                <option value="1">Consultorio</option>
				</select>
				<select name="selectorLugares" id="selectorLugares">
				</select>
				<input type="date" id="fechaGrilla">
				<button type="button" title="Buscar Cita"   onclick="showModalbuscarCita();"><span class="icon-eye"></span></button>
				<button type="button" title="Imprimir Agenda Actual" onclick="imprimir();"><span class="icon-printer"></span></button>
				<button type="button" title="Buscar Cita Eliminadas"  onclick="showModalbuscarCitaEliminadas();"  ><span class="icon-eye-off"></span></button>
				<button type="button" title="Exportar Citas" onclick="exportarCitas();"><span class="icon-grid"></span></button>
				<button type="button" style="float: right;margin-right:15px;" title="Eliminar Bloqueos" onclick="eliminar_reservas();"><span class="icon-x"></span></button>
				<div class="grupo">
						<div class="hora">hora</div>
						<div class="paciente">Paciente</div>
						<div class="telefono">Telefono</div>
						<div class="paciente">Observación</div>
						<div class="tipo">Est</div>
						<div class="espacio"></div>
						<div class="prof" id="opcionLugar1"></div>
						<div class="prof" id="opcionLugar2"></div>
						<div class="prof" id="opcionLugar3"></div>
						<div class="prof" id="opcionLugar4"></div>
						<div class="prof" id="opcionLugar5"></div>
						<div class="prof" id="opcionLugar6"></div>
						<div class="prof" id="opcionLugar7"></div>
						<div class="prof" id="opcionLugar8"></div>
						<div class="prof" id="opcionLugar9"></div>
				</div>
				<div id="divCitas" > 
				</div>
			</form>
		</div>
		<div  style="height: 60px">
			
		</div>
	</section>
	<div class="modal fade" id="myModal" role="dialog" style="padding: 10px;">
			<div class="modal-dialog modal-lg">
			<input type="hidden" id="userlogueado" value="<?php echo $this->session->userdata('usuario'); ?>" >
			  <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="tituloModalCita"></h4>
					</div>
					<div class="modal-body" style="height: 410px"	>
							<form class="formularios" accept-charset="utf-8" style="padding: 0;">	
									<input type="hidden"  id="accion" value>
									<input type="hidden"  id="idCitaUnico" value>	
									<input type="hidden"  id="crearUsuario" value="true">
									<input type="hidden"  id="fechaSeleccionada" value=>	
									<input type="hidden"  id="horaSeleccionada" value>				
									<label>Tipo de Documento
										<select id="tdocumento">
											<option value="CC">CC</option>
											<option value="TI">TI</option>
											<option value="NU">NU</option>
											<option value="RC">RC</option>
											<option value="PP">PP</option>
											<option value="CE">CE</option>
											<option value="MS">MS</option>
											<option value="AS">AS</option>
										</select>
									</label>
									<label>Nro de Documento
										<input type="text" id="nroDocumento" placeholder="Nro. Documento" >
									</label>
									<label>Primer Nombre
										<input type="text" id="primerNombre" placeholder="">
									</label>
									<label>Segundo Nombre
										<input type="text" id="segundoNombre" placeholder="">
									</label>
									<label>Primer Apellido
										<input type="text" id="primerApellido" placeholder="">
									</label>
									<label>Segundo Apellido
										<input type="text" id="segundoApellido" placeholder="">
									</label>

									<label>Telefono
										<input type="text" id="telefono" placeholder="">
									</label>
									<label>Celular
										<input type="text" id="celular" placeholder="">
									</label>
									<label>Correo
										<input type="text" id="correo" placeholder="">
									</label>									
									<label>Observación
										<input type="text" id="observacion" placeholder="">
									</label>
									<label>Fecha Nacimiento
										<input type="date" id="fechaNacimiento" placeholder="">
									</label>
									<label>Fecha Solicitada
										<input type="date" id="fechaSolicitada" placeholder="">
									</label>
									<label>Tipo
										<select id="tipoConsulta">
										<option value="BQ">Bloqueado, no dar citas varios</option>
											<option value="CM">Consulta Medica</option>
											<option value="CR">Consulta Revisión</option>
											<option value="TT">Tratamiento</option>
											<option value="EV">Consulta Evaluacion</option>
										</select>
									</label>
									<label>Estado
										<select id="estadoConsulta">
										   <option value="I">Nota Importante</option>
											<option value="V">Visto</option>
											<option value="C">Confirmado</option>
											<option value="X">Inasistio</option>
											<option value="W">Esperando</option>
											<option value="P">Pendiente</option>
											<option value="N">Novedades</option>
											<option value="R">Revisión</option>
										</select>
									</label>
									<label>Medio
										<select id="medio">
											<option value="IN">Instagram</option>
											<option value="FC">Facebook</option>
											<option value="RF">Referido</option>
											<option value="LC">Local</option>
											<option value="PW">Pagina Web</option>
											<option value="PA">Paciente Antiguo</option>
											<option value="">Otro</option>
										</select>
									</label>
									<label>Tipo Viejo
										<input disabled  id="tipo_viejo">
									</label>
									<label>
										<input  type="checkbox" style="margin-top: 18px;" value="1" id="vista">
									</label>
																		
								</form>
					</div>
					<?php if($permisos == "EDITAR") {  ?>
					<div class="modal-footer">
							<button type="button"  title="Eliminar Cita" onclick="showModalEliminarCita();" class="botonesModal  icon-delete"></button>
							<button type="button" id="moverCita" title="Mover Cita" onclick="moverCita();" class="botonesModal  icon-repeat"></button>
							<button type="button" title="Guardar" onclick="guardarDatosModal();" class="botonesModal icon-save"></button>
							<button type="button" title="Borrar Datos" onclick="borrarDatosModal()" class="botonesModal icon-user-x" onclick=""></button>						
					</div>
					<?php }  ?>
				</div>  
			</div>
	</div>

	<div class="modal fade" id="myModalEliminar" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-sm">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Eliminar Cita</h4>
				</div>
				<div class="modal-body" 	>
						<form class="formularios" accept-charset="utf-8" style="padding: 0;">	
							<input type="hidden"  id="idCitaUnicoEliminar" value="0">	
							 <textarea placeholder="Ingresar El Motivo de Eliminar La Consulta" name="" id="observacionEliminar" cols="36" rows="4"></textarea>								
							</form>
				</div>
				<div class="modal-footer">
						<button type="button" title="Eliminar Cita" onclick="eliminarCita();" class="botonesModal icon-x-square"></button>
				</div>
			</div>  
		</div>
	</div>
	
	<div class="modal fade" id="myModalBuscarCita" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-lg">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Buscar Cita</h4>
				</div>
				<div class="modal-body" style="height: 550px"	>
					<form class="formularios" accept-charset="utf-8" style="padding: 0;">
						
						<label>Nro de Documento
							<input type="text" id="nroDocumentoBusqueda"  >
						</label>
						<label>Primer Nombre
							<input type="text" id="primerNombreBusqueda"  placeholder="">
						</label>
						<label>Correo
							<input type="text" id="correoBusqueda" placeholder="">
						</label>
						<label>Fecha Inicio
							<input type="date" id="fechaInicio" placeholder="">
						</label>
						<label>Fecha Fin
							<input type="date" id="fechaFinal" placeholder="">
						</label>
						<label>
						<button type="button" title="Buscar Cita" onclick="buscarCita();" style="margin-top: 20px;" class="botonesModal icon-eye"></button>									
					   </label>
					</form>
					<div id="resultadoBusquedaCitas" class="table-responsive" style="max-height: 350px;margin-top: 140px;">
					</div>
				</div>
			</div>  
		</div>
    </div>


 <!-- Modal Modal de citas eliminadas-->
	<div class="modal fade" id="myModalBuscarCitasEliminadas" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-lg">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Buscar Cita Eliminadas</h4>
				</div>
				<div class="modal-body" style="height: 400px"	>
					<form class="formularios" accept-charset="utf-8" style="padding: 0;">
						<label>Fecha Inicio
							<input type="date" id="fechaInicioEliminadas" placeholder="">
						</label>
						<label>Fecha Fin
							<input type="date" id="fechaFinalEliminadas" placeholder="">
						</label>
						<label>
						<button type="button" title="Buscar Cita ELiminadas" onclick="buscarCitasEliminadas();" style="margin-top: 20px;" class="botonesModal icon-eye"></button>									
					   </label>
					</form>
					<div id="resultadoBusquedaCitasEliminadas" class="table-responsive" style="max-height: 300px;margin-top: 70px;">
					</div>
				</div>
			</div>  
		</div>
    </div>
	

	
</body>
    <!-- Lib core JavaScript -->
    <script src="<?php echo base_url(); ?>ext_libraries/jquery/jquery_3_2_1.min.js"></script>
    <script src="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.js"></script>
	<script src="<?php echo base_url(); ?>ext_libraries/alertify/alertify.js" charset="utf-8" async defer></script>
    <!-- Customs JavaScript -->
	<script src="<?php echo base_url(); ?>js/citas.js"></script>
</html>