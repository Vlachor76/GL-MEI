<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />

    <title>SiipsWEB Historia</title>

    <!-- Lib Ext css -->
	<link href="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ext_libraries/alertify/alertify.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Customs CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <link rel="stylesheet" type="text/css" href="css/historia.css">
    <link rel="stylesheet" type="text/css" href="css/fuente.css">
	<link rel="stylesheet" type="text/css" href="css/generales.css">

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
	<li class="active"><a href="<?php echo base_url(); ?>historia" title="" >Historia</a></li>
	<li><a href="<?php echo base_url(); ?>paquete" title="" >Paquetes</a></li>
	<li><a href="<?php echo base_url(); ?>usuario" title="" >Usuarios</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
	  <li><a class="navbar-brand" href="#"></span>Usuario : <?php echo $this->session->userdata('nombre'); ?></a></li>
      <li><a href="<?php echo base_url(); ?>Login/logout"><span class="glyphicon glyphicon-log-in"></span> Cerrar Sesión</a></li>
</ul>
</div>
</nav>
  <form id="formhistoria" action="<?php echo site_url('historia/crear_historia/'); ?>" method="get" accept-charset="utf-8">
    <input type="hidden" id="permisos"  value="<?php echo $permisos ?>">
    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $this->session->userdata('idusuario'); ?>">
    <input type="hidden" id="id_sede" name="id_sede"   value="<?php echo $this->session->userdata('id_sede'); ?>">
    <input type="hidden" name="signos" id="signos"  value="">
    <input type="hidden" name="antecedentes" id="antecedentes"  value="">
    <input type="hidden" name="examen" id="examen"  value="">
    <label>
        Fecha
        <input type="date" id="fActual"  placeholder="">
    </label>
    <label>
        Fact
        <input type="text" id="fact"  name="factura" placeholder="Factura">
    </label>
    <label>Nombre
        <div id="nombre"> </div>
    </label>
    <label>Edad
        <div id="edad"> </div>
    </label>
    <label>FN
    <button type="button" title="Exportar Historias" onclick="showModalInformes();" style=" margin-left: 200px;" class="botonesModal icon-grid"></button>
        <div id="fn"> </div>
    </label>
    <label>Tipo Documento
        <select id="tDocumnto" name="tipodoc">
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
    <label>Documento
        <input type="text" id="documento" name="documento" placeholder="">
    </label>
    <label>Sexo
        <div id="sexo"> </div>
    </label>
    <label>Estado Civil
        <div id="eCivil"> </div>
    </label>
    <label>MUN
        <div id="mun"> </div>
    </label>
    <div style="width: 100%; border-bottom: solid 1px #000; float: left;"></div>
    <div class="datos" id="divhistoria">
        <label>Motivo de Consulta y enfermedad Actual
            <textarea style="margin-top: 19px;" name="motivo"></textarea>
        </label>
        <div class="svitales">
            <label>Antecedentes
            </label>
            <label>
                <select id="tipo_antescedentes" >
                        <option value="Patológicos">Patológicos</option>
                        <option value="Farmacológicos">Farmacológicos</option>
                        <option value="Psiquiátricos">Psiquiátricos</option>
                        <option value="Familiares">Familiares</option>
                        <option value="Quirurgicos">Quirurgicos</option>
                        <option value="Alérgicos">Alérgicos</option>
                        <option value="Toxicològicos">Toxicològicos</option>
                        <option value="Gineco obstétricos">Gineco obstétricos</option>
                        <option value="Traumáticos">Traumáticos</option>
                        <option value="Infecciosos">Infecciosos</option>
                        <option value="Esquema de vacunación">Esquema de vacunación</option>
                        <option value="Otros">Otros</option>
                </select>
            </label>
        </div>
        <label>
            <textarea id="ant_temporal" ></textarea>
        </label>

        <label>Revision por Sistema
            <textarea style="margin-top: 19px;" name="revision">Negativos</textarea>
        </label>
        <div class="svitales">
            <label>Examen Fisico
            </label>
            <label>
                <select id="tipo_examen">
                        <option value="Estado">Estado general</option>
                        <option value="Cabeza">Cabeza</option>
                        <option value="Cara">Cara</option>
                        <option value="Orofaringe">Orofaringe</option>
                        <option value="Cuello">Cuello</option>
                        <option value="Extremidades">Extremidades</option>
                        <option value="Torax">Torax</option>
                        <option value="Abdomen">Abdomen</option>
                        <option value="Dorso">Dorso</option>
                        <option value="Neurologico">Neurológico</option>
                        <option value="Piel">Piel</option>
                        <option value="Faneras">faneras</option>
                        <option value="Otros">Otros</option>
                </select>
            </label>
        </div>
        <label>
            <textarea id="examen_tem" ></textarea>
        </label>
        <label>
        <div class="svitales">
            <label>TA
                <input type="text" id="ta"  value="120/70" placeholder="">
            </label>
            <label>FC
                <input type="text" id="fc" value="80" placeholder="">
            </label>
            <label>PESO
                <input type="text" id="peso" value="" placeholder="">
            </label>
            <label>TALLA
                <input type="text" id="talla" value="" placeholder="">
            </label>
            <label>IMC
                <input type="text" id="imc" value="" placeholder="">
            </label>
        </div>
        </label>
        <label>
        <div class="svitales">
            <label>Diagnostico Ppl</label>
            <label>
                <select  id="tipo_diag" name="tipo_diagnostico" >
                    <option value="0">---</option>
                    <option value="impresion">Impresión Diagnóstica</option>
                    <option value="confirmadoN">Confirmado Nuevo</option>
                    <option value="confirmadoR">Confirmado Repetido</option>
                </select>
            </label>
            <label>Codigo</label>
            <label>
                <input type="text" class="diag" name="codiag" id="codiag" placeholder="">
            </label>
        </div>
            <textarea name="diagnostico"  id="diagnostico"></textarea>
        </label>
        <label>Medicamentos
            <textarea id="medicamentos" >Ninguno</textarea>
        </label>
        <label>
        <div class="svitales">
            <label>Diagnostico 2
                <input type="text" class="diag" name="codiag2" id="codiag2" value="" placeholder="">
            </label>
            <label>Diagnostico 3
                <input type="text" class="diag" name="codiag3" id="codiag3" value="" placeholder="">
            </label>
            <label>Diagnostico 4
                <input type="text" class="diag" name="codiag4" id="codiag4" value="" placeholder="">
            </label>
        </div>
            <textarea name="diagnostico2" id="diagnostico2"></textarea>
        </label>
        <div style="width: 100%; border-bottom: solid 1px #000; float: left;"></div>
        <label>Conducta De Entrada Y Tratamiento
            <textarea style="margin-top: 19px;" name="conducta"></textarea>
        </label>
        <label><div class="svitales">
            <label>Procedimiento</label>
            <label>
            <input type="text" name="coproc" class="proc" id="procehistoria">
            </label>
        </div>
            <textarea name="procedimiento" id="procedimientoHistoria"></textarea>
        </label>
        <label> <br> 
            <button type="button" title="Ver Valoración" class="consultarValoracion botonesModal icon-airplay"></button>
            <button type="button" title="Guardar Historia" id="ingresarHistoria" class="botonesModal icon-save"></button>
        </label>
    </div>

    <div class="datos" id="divevolucion">
        <label>
        <div class="svitales" >
            <label>EVOLUCION</label>
            <label class="notasoap">Diagnostico
                <input type="text"  class="diag" id="diagevol" >
            </label>
            <label class="notasoap" >Procedimiento
                <input type="text"  class="proc" id="proceevol">
            </label>
        </div>
            <textarea id="evolucion" rows="10" ></textarea>
        </label>
        <label> <br> 
            <button type="button" title="Ver Valoración" class="consultarValoracion  botonesModal icon-airplay"></button>
            <button type="button" title="Ver Historia" id="consultarHistoria" class="botonesModal icon-clipboard"></button>
            <button type="button" title="Ingresar Historia" id="verHistoria" class="botonesModal icon-edit"></button>
            <button type="button" title="Guardar Evolución" id="ingresarEvolucion" class="botonesModal icon-save"></button>
        </label>
    </div>
  </form>
  </div>


	<!-- modalVerHistoria -->
	<div class="modal fade" id="modalVerHistoria" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-lg">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Historia clínica y registros asistenciales</h4>
				</div>
				<div class="modal-body">
				<div align="center" >		
                    <div class="form-group">
                        <textarea class="form-control" rows="5" id="encabezado"></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <textarea class="form-control" rows="15" id="evoluciones"></textarea>
                    </div>
				    <div class="row" style="width: 80%;">
                    <input type="checkbox" class= "chkVisor" id="chk1" value="1">Historia Clínica<br>
                    <input type="checkbox" class= "chkVisor" id="chk2" value="2" checked>Notas enfermería<br>
                    <input type="checkbox" class= "chkVisor" id="chk3" value="3" checked>Notas cosmetología<br>
                    <ul class="pager">
                        <li class="previous">
                            <button  id="cargarPrimeraSesion" type="button" class="botonesModal">
                                <span class="glyphicon glyphicon-fast-backward"></span>
                            </button>
                            <button  id="cargarAnteriorSesion" type="button" class="botonesModal">
                                <span class="glyphicon glyphicon-backward"></span>
                            </button>
                        </li>
                        <li class="next">
                            <button id="cargarSiguienteSesion" type="button" class="botonesModal">
                             <span class="glyphicon glyphicon-forward"></span>
                            </button>
                            <button id="cargarUltimaSesion"  type="button" class="botonesModal">
                             <span class="glyphicon glyphicon-fast-forward"></span>
                            </button>
                        </li>
                    </ul>
                    <button type="button" title="Imprimir Historia"  onclick="imprimirHistoria()" class="botonesModal icon-printer"></button>
				   </div>
				</div>			
				</div>
			</div>  
        </div>
	</div>	



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
				<div align="center" >		
                <input type="hidden" id="ndoc">
                    <div class="form-group">
					    <label >Procedimientos Generales</label>
                        <textarea class="form-control" rows="6" id="descripcionValoracion"></textarea>
                    </div>
                    <br>
				   <div class="row" style="width: 80%;">	
                        <div class="form-group">						
                            <button type="button"  id="guardarValoracion" title="Guardar Valoracion"  class="botonesModal icon-save"></button>
						</div>	
                </div>
				</div>			
				</div>
			</div>  
        </div>
	</div>


    	<!-- Modal Exportar Historia-->
	<div class="modal fade" id="modalExportHistoria" role="dialog" style="padding: 10px;">
		<div class="modal-dialog modal-md">
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Exportar Informes Historia</h4>
				</div>
				<div class="modal-body">
						Fecha Inicio
							<input type="date" style="height: 30px;" id="fechaInicioHistoria" placeholder="">					
						Fecha Fin
							<input type="date" style="height: 30px;" id="fechaFinalHistoria" placeholder="">
						<button type="button" title="Exportar Historia" onclick="exporHistoriaExcel();" style="margin-top: 20px;" class="botonesModal icon-file-text"></button>
				</div>
			</div>  
		</div>
    </div>

    <!-- Lib core JavaScript -->
	<script src="<?php echo base_url(); ?>ext_libraries/jquery/jquery_3_2_1.min.js"></script>
    <script src="<?php echo base_url(); ?>ext_libraries/bootstrap/bootstrap_3_3_7.min.js"></script>
    <script src="<?php echo base_url(); ?>ext_libraries/alertify/alertify.js"></script>	
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Customs JavaScript -->
    <script src="<?php echo base_url(); ?>js/historia.js"></script>
    <script src="<?php echo base_url(); ?>js/pacientes.js"></script>
</body>
</html>