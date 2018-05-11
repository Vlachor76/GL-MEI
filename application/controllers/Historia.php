<?php

/**
 * Autor:     
 * Email:     
 * Web:
 * class Login
 *
 * Clase que me controla la autenticacion y elfomulario de ingreso al sistema
 *
 * @package    
 * @author     
 * @version    
 * @copyright  
 */
class Historia extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->helper('url');
        $this->load->model('historia_model');
        $this->load->model('paciente_model');
        $this->load->helper('mysql_to_excel_helper');
        $this->load->model('administracion_model');
        date_default_timezone_set("America/Bogota");
    }

    /**
     * function is_logged_in
     *
     * Funcion que verifica si el usuario se encuentra o no autenticado en el sistema
     *
     * @return boolean
     */
    function is_logged_in() {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            redirect('/login', 'refresh');
            die();
        }
    }

    // Funcion que nos carga la vista del formulario de acceso al sistema
    function index() {
        $permisos =  $this->administracion_model->get_permisos_rol($this->session->userdata('rol'),"historia");
        if (isset($permisos)) {
         $data['permisos'] = $permisos->nombre_permiso;
         $this->load->view('aplicacion/historia',$data);
        }else{
         $data['mensaje'] = "Acceso Denegado";
         $this->load->view('aplicacion/home',$data); //Vista que se carga
        } 
    }

     // Funcion que guarda crea la historia clinica del paciente
     function crear_historia() {
        $historia =  $_POST;
        $historia["antecedentes"] = $this->replace_json($historia["antecedentes"]);
        $historia["examen"] = $this->replace_json($historia["examen"]);
        $historia["psips"] = $this->session->userdata('rol');
        $historia["prof"] = $this->session->userdata('nombre');
        $this->historia_model->crear_historia($historia);
        echo "OK";
    }


    function replace_json($objeto_json){
        $srt =  str_replace("{\"","",$objeto_json);
        $srt = str_replace("\":\""," = ",$srt);
        $srt = str_replace("\",\"","\n",$srt);
        $srt = str_replace("\"}","",$srt);
        return $srt;
    }

    // Funcion que guarda la evolucion del paciente
    function ingresar_evolucion() {
        $evolucion =  $_POST;
        $evolucion["psips"] = $this->session->userdata('rol');
        $evolucion["prof"] = $this->session->userdata('nombre');
        $this->historia_model->ingresar_evolucion($evolucion);
        echo "OK";
    }

    
     // Funcion que consulta la historia del paciente
     function consultar_historia() {
        
        $numero = $this->input->post('documento');
        $tipodoc = $this->input->post('tipodoc');
        $historias = $this->historia_model->get_historia($tipodoc,$numero);
        $evoluciones = array();
        $contador = 0;
        $resultado_evoluciones = $this->historia_model->get_evoluciones($tipodoc,$numero);
        foreach ($resultado_evoluciones as $value) {
            $evoluciones[$contador] =  $value;
            $contador ++;
        }
        foreach ($historias as $historia) {
            $wrapper_evolucion = (object) array('id_evolucion' => $historia->id_historia,
                                    'tipodoc' => $historia->tipodoc,
                                    'ndoc' => $historia->documento,
                                    'codiag' => $historia->codiag,
                                    'coproc' => '',
                                    'evol' => $this->obtener_texto_historia($historia),
                                    'fecha' => $historia->fecha,
                                    'id_sede' => $historia->id_sede,                             
                                    'id_usuario' => $historia->id_usuario,
                                    'prof' => $historia->prof,
                                    'psips' => $historia->psips);
            $evoluciones[$contador] = $wrapper_evolucion;
            $contador ++ ;
        }
        
        if (empty($historias)){
            echo  json_encode(array('historia' => $historias, 'evoluciones' => $evoluciones));
        }
        else{
            echo  json_encode(array('historia' => $historias[0], 'evoluciones' => $evoluciones));
        }
            
    }

      // Funcion que  construye el texto para mostrar la historia
      function obtener_texto_historia($historiaTemporal){
        $textoHistoria = "Nota Medica:\n\n";    
        $textoHistoria = $textoHistoria."Motivo : ". $historiaTemporal->motivo."\n";     
        $textoHistoria = $textoHistoria."Revisión : ". $historiaTemporal->revision."\n";
        $textoHistoria = $textoHistoria."Examen Fisico : ". $historiaTemporal->examen."\n";
        $textoHistoria = $textoHistoria."Signos Vitales : ". $historiaTemporal->signos."\n";
        $textoHistoria = $textoHistoria."Diagnostico : ". $historiaTemporal->diagnostico."\n";
        $textoHistoria = $textoHistoria."Conducta: ". $historiaTemporal->conducta."\n";
        return $textoHistoria;
    }

    // Funcion que consulta si el paciente tiene historia 
    function tiene_historia() {
        $numero = $this->input->post('numero');
        $tipodoc = $this->input->post('tipodoc');
        $historia = $this->historia_model->get_historia($tipodoc,$numero);

        if(isset($historia[0]->documento)){
            echo  json_encode(array('historia' => 'TRUE' , 'signos' => $historia[0]->signos));
        }else{
            echo  json_encode(array('historia' => 'FALSE' , 'signos' => ''));
        }
    }

    

    /**
     * function export_excel_historia
     *
     * Funcion export_excel_historia exporta a excel las historias de una rango de fechas
     *
     */
    function export_excel_historia() {
        $feini = $_REQUEST["feini"];
        $fefin = $_REQUEST["fefin"];

        $resultado_sesiones_paquete = $this->historia_model->historia_informe_excel($feini,$fefin);
        $fields = array("fecha","tipodoc","ndoc","nombres","apellidos","sexo","edad","reside",
                        "codubi","municipio","celular","correo","cumple","codrips","tipocons","sede",
                        "nombre profesional","apellido profesional","cargo");
        $nombre_archivo="historia_".$feini."_".$fefin;

        to_excel($fields, $resultado_sesiones_paquete , $nombre_archivo);


    } 

    /**
     * function historia_medica_pdf
     *
     * Funcion exporta en pdf la historia medica de una paciente
     *
     */

    function historia_medica_pdf(){
        $this->load->library('mydompdf');
        //Servirá para iterar y generar hojas para ver
            //el header y footer en varias hojas
        $nro_identidad =  $_REQUEST["numero"];
        $tipodoc =$_REQUEST["tipodoc"];
        $data["empresa"] = $this->administracion_model->get_datos_empresa();
        $data["paciente"] = $this->paciente_model->get_paciente($nro_identidad,$tipodoc);
        $data["historias"] = $this->historia_model->get_historia($tipodoc,$nro_identidad);
        $data["evoluciones"] = $this->historia_model->get_evoluciones($tipodoc,$nro_identidad);
        $html = $this->load->view('aplicacion/pdf/historia_pdf', $data, true);
        $this->mydompdf->load_html($html);
        $this->mydompdf->render();
        $this->mydompdf->stream("Historia_".$tipodoc."_".$nro_identidad.".pdf", array(
            "Attachment" => false
        ));
        
    }


}
