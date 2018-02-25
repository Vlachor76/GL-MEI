<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="description" content="">
	<meta name="author" content="">
	<meta name="copyright" content="© 2018" />
     <!-- Lib Ext css -->
	<link href="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ext_libraries/alertify/alertify.css">
    <!-- Customs CSS -->
	<link href="<?php echo base_url(); ?>css/index.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/fuente.css" rel="stylesheet">
	
	<title>Consultorio Profesional Independiente</title>
  </head>

  <body>
        <section id="cuerpo"  class="cuerpo">
        <h1>Ingreso SiipsWEB</h1>
        <div class="formulario">
           <input type="hidden" id="urlhome" value="<?php echo site_url('menu'); ?>">
            <form action="<?php echo site_url('login/validar_usuario/'); ?>"  id="formingreso" method="post" accept-charset="utf-8">
                <input type="text"  id="usuario"  name="usuario" placeholder="NOMBRE DE USUARIO" maxlength="10">
                <input type="password" id="contrasena" name="contrasena" placeholder="CONTRASEÑA" maxlength="10">
                <select id="sede" name="sede">
                    <option value="1">Consultorio</option>
                </select>
                <button type="button" id="ingresarSistema">Entrar</button>
            </form>
        </div>
        </section>
  </body>

   <!-- Lib core JavaScript -->
   <script src="<?php echo base_url(); ?>ext_libraries/jquery/jquery_3_2_1.min.js"></script>
   <script src="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.js"></script>
   <script src="<?php echo base_url(); ?>ext_libraries/alertify/alertify.js" charset="utf-8" async defer></script>	
    <!-- Customs JavaScript -->
    <script src="<?php echo base_url(); ?>js/usuarios.js"></script>

</html>


  </head>