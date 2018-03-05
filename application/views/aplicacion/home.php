<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SIIPSWEB</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fuente.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generales.css">
    <link href="<?php echo base_url(); ?>ext_libraries/alertify/alertify.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />	
</head>
<body>
		<nav class="navbar navbar-default">
		<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">SIIPSWEB</a>
		</div>
		<ul class="nav navbar-nav">
			<li><a href="<?php echo base_url(); ?>cita"  title="">Agenda Citas</a></li>
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
		
		<?php if(isset($mensaje)) { ?>
		   <h1 style="color:#B61F24;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  <?php echo $mensaje  ?></h1>
		<?php } ?>

</body>
   <!-- Lib core JavaScript -->
   <script src="<?php echo base_url(); ?>ext_libraries/jquery/jquery_3_2_1.min.js"></script>
   <script src="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.js"></script>
   <script src="<?php echo base_url(); ?>ext_libraries/alertify/alertify.js"></script>	
    <!-- Customs JavaScript -->

	
</html>