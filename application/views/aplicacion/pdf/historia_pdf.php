<html>
  <head>
      <link rel="stylesheet" type="text/css" href="./css/pdf.css">
  </head>

<body>

  <header>
      <table>
          <tr>
              <td id="header_logo">
                  
              </td>
              <td id="header_texto">
                  <div><?php echo $empresa->slogan ?></div>
                  <div><?php echo $empresa->dir ?></div>
                  <div><?php echo $empresa->tel ?></div>
              </td>
              <td id="header_logos">
                  <h5>Historia Medica</h5>
                  <h5><?php echo date('Y-m-d H:i:s', time()) ?> </h5>
                  <b>Historia</b>
                 <?php echo $paciente->tipodoc; ?>
                 <?php echo $paciente->ndoc; ?>
              </td>
          </tr>
      </table>
      <hr>
<p>IDENTIFICACION DEL PACIENTE</p>
<table style="width:100%">
  <tr>
    <td><b>Nombres</b></td>
    <td colspan="4"><?php echo $paciente->nombre1." ".$paciente->nombre2; ?></td>
    <td><b>Apellidos</td>
    <td colspan="3"><?php echo $paciente->apellido1." ".$paciente->apellido2; ?></td>
  </tr>
  <tr>
    <td><b>DOC</b></td>
    <td><?php echo $paciente->tipodoc; ?></td>
    <td><?php echo $paciente->ndoc; ?></td>
    <td><b>Sexo</b></td>
    <td><?php echo $paciente->sexo; ?></td>
    <td><b>F Nacimiento</b></td>
    <td><?php echo $paciente->cumple; ?></td>
    <td><b>Edad</b></td>
    <td><?php echo $paciente->edad; ?> Años</td>
  </tr>
  <tr>
    <td><b>Dirección Domicilio</b></td>
    <td colspan="4"><?php echo $paciente->reside; ?></td>
    <td><b>Lugar Residencia</b></td>
    <td colspan="3"><?php echo $paciente->municipio; ?></td>
  </tr>
  <tr>
    <td><b>Tel</b></td>
    <td colspan="2">                 
    <td><b>Ocupación</b></td>
    <td colspan="3"><?php echo $paciente->ocupacion; ?></td>
    <td><b>Estado Civil</b></td>
    <td colspan="3"><?php echo $paciente->estciv; ?></td>
  </tr>
</table>
<hr>
<table style="width:100%">
  <tr>
    <td><b>Aseguradora</b></td>
    <td colspan="4"><?php echo $paciente->eps; ?></td>
    <td><b>Tipo Vinculacion</td>
    <td colspan="3"><?php echo $paciente->tipoafi; ?></td>
  </tr>
  <tr>
    <td><b>Persona Responsable</b></td>
    <td><?php echo $paciente->resp; ?></td>
    <td><b>Parentesco</b></td>
    <td><?php echo $paciente->parenresp; ?></td>
    <td><b>Tel</b></td>
    <td><?php echo $paciente->telresp; ?></td>
  </tr>
  <tr>
    <td><b>Persona Acompañante</b></td>
    <td colspan="4"><?php echo $paciente->acomp; ?></td>
    <td><b>Tel Acompañante</td>
    <td colspan="3"><?php echo $paciente->telacomp; ?></td>
  </tr>
</table>
<hr>
  </header>
  <footer>
      <div id="footer_texto"> <br> <div><?php echo $empresa->texto ?></div> <div>NIT:<?php echo $empresa->NIT ?></div> </div>
  </footer>


  <div>
    <?php foreach ($historias as $historia) { ?>
     <h4><?php echo $historia->fecha ?> NOTA MEDICA <?php echo nl2br($historia->nombre1 ." ".$historia->nombre2 ." ".$historia->apellido1  ." ".$historia->apellido2); ?></h4>
     <p>MOTIVO DE CONSULTA</p>
     <?php echo nl2br($historia->motivo); ?>
     <br>
     <p>ANTECEDENTES</p>
     <?php echo  nl2br($historia->antecedentes); ?>
     <p>EXAMEN FISICO</p>
     <?php echo nl2br($historia->examen); ?>
     <p>SIGNOS VITALES</p>
     <?php echo nl2br($historia->signos); ?>
     <p>REVISION POR SISTEMA</p>
     <?php echo nl2br($historia->revision); ?>
     <br>
     <p>DIAGNÓSTICO</p>
     <?php echo nl2br($historia->codiag ." . ".$historia->diagnostico); ?>
     <br>
     <p>PROCEDIMIENTO</p>
     <?php echo nl2br($historia->coproc ." . ".$historia->procedimiento); ?>
     <br>
     <p>CONDUCTA DE ENTRADA</p>
     <?php echo nl2br($historia->conducta); ?>
     <br>
    <?php };?>    
</div>


<div>
    <?php foreach ($evoluciones as $evolucion) { ?>
    <br><br>
     <h3><?php echo $evolucion->fecha ?> NOTA EVOLUCION <?php echo nl2br($evolucion->nombre1 ." ".$evolucion->nombre2 ." ".$evolucion->apellido1  ." ".$evolucion->apellido2); ?> </h3>
     <p>EVOLUCION</p>
     <?php echo  $evolucion->evol ?> 
     <br>  
     <?php }?>
     
</div>




</html>
