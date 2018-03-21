<html>
  <head>
      <link rel="stylesheet" type="text/css" href="./css/citas_pdf.css">
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
                  <h5><?php echo $sede->nombre_sede ?></h5>
                  <h5><?php echo $lugar->nombre ?></h5>
                  <h5><?php echo date('Y-m-d H:i:s', time()) ?></h5>
              </td>
          </tr>
      </table>
      <hr>
  </header>
  <footer>
      <div id="footer_texto"> <br> <div><?php echo $empresa->texto ?></div> <div>NIT:<?php echo $empresa->NIT ?></div> </div>
  </footer>

  <div>
    <h2>Citas <?php echo $fecha->format('d/m/Y') ?>  </h2>

<table id="citas">
    <tr>
        <th>Hora</th>
        <th>Documento</th>
        <th>Paciente</th>
        <th>Observación</th>
        <th>Estado</th>
        <th>Tipo</th>
    </tr>
    <?php foreach ($citas as $cita) { ?>
        <tr>
            <td><?php echo $cita->hora ?></td>
            <td><?php echo $cita->nro_documento ?></td>
            <td><?php echo $cita->primer_nombre ." ".$cita->segundo_nombre ?></td>
            <td><?php echo $cita->observa ?></td>
            <td><?php echo $cita->estado ?></td>
            <td><?php echo $cita->tipo_consulta ?></td>
        </tr>
    <?php };?> 
</table>

</body>
</html>

</div>

</html>
