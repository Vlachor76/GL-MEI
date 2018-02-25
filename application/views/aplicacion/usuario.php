<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SiipsWeb Usuarios</title>


	<!-- Lib Ext css -->
	<link href="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ext_libraries/alertify/alertify.css">


	<!-- Customs CSS -->
	<link rel="stylesheet" type="text/css" href="css/fuente.css">
	<link rel="stylesheet" type="text/css" href="css/generales.css">
	<link rel="stylesheet" type="text/css" href="css/citas.css">
	
	


</head>
<body>
<nav class="navbar navbar-default">
<div class="container-fluid">
<div class="navbar-header">
	<a class="navbar-brand" href="#">SIIPSWEB</a>
</div>
<ul class="nav navbar-nav">
	<li  ><a href="<?php echo base_url(); ?>cita"  title="">Agenda Citas</a></li>
	<li><a href="<?php echo base_url(); ?>paciente" title="" >Pacientes</a></li>
	<li><a href="<?php echo base_url(); ?>historia" title="" >Historia</a></li>
	<li class="active"><a href="<?php echo base_url(); ?>usuario" title="" >Usuarios</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
	  <li><a class="navbar-brand" href="#"></span>Usuario : <?php echo $this->session->userdata('nombre'); ?></a></li>
      <li><a href="<?php echo base_url(); ?>Login/logout"><span class="glyphicon glyphicon-log-in"></span> Cerrar Sesión</a></li>
</ul>
</div>
</nav>
	<section class="contenedor">
	<input type="hidden" id="permisos"  value="<?php echo $permisos ?>">
	<input type="hidden" id="id_logueado"  value="<?php echo $this->session->userdata('idusuario'); ?>">
		<form id="formusuario" style="padding: 5%;" class="formularios" action="<?php echo site_url('usuario/crear_usuario/'); ?>"  method="get" accept-charset="utf-8">
			<label>Documento
				<input type="number" id="documento"  name="documento" placeholder="Nro. Documento">
			</label>
			<label>Primer Nombre
				<input type="text" id="nombre1"  name="nombre1" placeholder="Primer  Nombre">
			</label>
			<label>Segundo Nombre
				<input type="text" id="nombre2"  name="nombre2" placeholder="Segundo Nombre">
			</label>
			<label>Primer Apellido
				<input type="text" id="apellido1"  name="apellido1"  placeholder="Primer Apellido">
			</label>
			<label>Segundo Apellido
				<input type="text" id="apellido2"  name="apellido2" placeholder="Segundo Apellido">
			</label>
			<label>Edad
				<input type="number" id="edad" name="edad" placeholder="Edad">
			</label>
			<label>Fecha de Nacimiento
				<input type="date" id="fnacimiento"  name="fnacimiento" placeholder="F. de Nacimiento">
			</label>
			<label>Fecha Vinculación
				<input type="date" id="fvinculacion" name="fvinculacion" placeholder="F. de Vinculación">
			</label>
			<label>Profesional
				<input type="text" id="profesional"  name="profesional" placeholder="Profesional">
			</label>
			<label>Telefono
				<input type="number" id="telefono"  name="telefono" placeholder="Telefono">
			</label>
			<label>Celular
				<input type="number" id="celular"  name="celular" placeholder="Celular">
			</label>
			<label>Dirección Residencia
				<input type="text" id="direccion" name="direccion"  placeholder="Dirección">
			</label>
			<label>Correo Electronico
				<input type="text" id="correo"  name="correo" placeholder="Correo Electronica">
			</label>
			<label>Cargo
				<input type="text" id="cargo" name="cargo"   placeholder="Cargo">
			</label>
			<label>EPS
				<input type="text" id="eps" name="eps" placeholder="EPS">
			</label>
			<label>Nombre de Usuario
				<input type="text" id="usuario" name="usuario"  placeholder="Nombre de Usuario">
			</label>
			<label>Contraseña
				<input type="password" id="password" name="password" placeholder="Contraseña">
			</label>
			<label>Permisos SIPS
				<select id="psips" name="psips" >
					<option value="1">MEDICINA</option>
					<option value="2">ENFERMERIA</option>
					<option value="3">COSMETOLOGÍA</option>
					<option value="4">RECEPCIÓN</option>
					<option value="5">MERCADEO</option>
					<option value="6">ADMINISTRACIÓN</option>
					<option value="7">AUDITORIA</option>
				</select>
			</label>
			<button type="button" id="registrarusuario" >Guardar</button>
			<button type="button" id="cambiarcontrasena" >Cambiar Contraseña</button>
		</form>
	</section>

	 <!-- Lib core JavaScript -->
	 <script src="<?php echo base_url(); ?>ext_libraries/jquery/jquery_3_2_1.min.js"></script>
    <script src="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.js"></script>
    <script src="<?php echo base_url(); ?>ext_libraries/alertify/alertify.js"></script>	
    <!-- Customs JavaScript -->
	<script src="<?php echo base_url(); ?>js/usuarios.js"></script>
</body>
</html>