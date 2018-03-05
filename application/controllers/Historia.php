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
        $antecedentes = $historia["antecedentes"]; 
        $antecedentes =  str_replace("{\"","",$antecedentes);
        $antecedentes = str_replace("\":\""," = ",$antecedentes);
        $antecedentes = str_replace("\",\"","\n",$antecedentes);
        $antecedentes = str_replace("\"}","",$antecedentes);
        $historia["antecedentes"] = $antecedentes;
        $historia['psips'] =$this->session->userdata('rol');
        $this->historia_model->crear_historia($historia);
        echo "OK";
    }

    // Funcion que guarda la evolucion del paciente
    function ingresar_evolucion() {
        $evolucion =  $_POST;
        $evolucion['psips'] =$this->session->userdata('rol');
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
                                    'fecha_registro' => $historia->fecha,
                                    'id_sede' => $historia->id_sede,                             
                                    'id_usuario' => $historia->id_usuario,
                                    'psips' => $historia->psips);
            $evoluciones[$contador] = $wrapper_evolucion;
            $contador ++ ;
        }
        
        echo  json_encode(array('historia' => $historias[0] , 'evoluciones' => $evoluciones));
    }
    
     // Funcion que  construye el texto para mostrar la historia
    function obtener_texto_historia($historiaTemporal){
        $textoHistoria = "Nota Medica:". $historiaTemporal->id_usuario."\n\n";    
        $textoHistoria = $textoHistoria."Motivo : ". $historiaTemporal->motivo."\n";     
        $textoHistoria = $textoHistoria."Revisi贸n : ". $historiaTemporal->revision."\n";
        $textoHistoria = $textoHistoria."Examen Fisico : ". $historiaTemporal->examen."\n";
        $textoHistoria = $textoHistoria."Signos Vitales : ". $historiaTemporal->signos."\n";
        $textoHistoria = $textoHistoria."Diagnostico : ". $historiaTemporal->diagnostico."\n";
        $textoHistoria = $textoHistoria."Conducta: ". $historiaTemporal->conducta."\n";
        return $textoHistoria;
    }

    // Funcion que guarda crea la historia clinica del paciente
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


}
