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
class Paciente extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('paciente_model');
        $this->load->model('administracion_model');
        $this->load->helper('mysql_to_excel_helper');
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


    function index() {
        $permisos =  $this->administracion_model->get_permisos_rol($this->session->userdata('rol'),"paciente");
        if (isset($permisos)) {
         $data['permisos'] = $permisos->nombre_permiso;
         $this->load->view('aplicacion/paciente',$data);
        }else{
         $data['mensaje'] = "Acceso Denegado";
         $this->load->view('aplicacion/home',$data); //Vista que se carga
        }
    }


    function excel() {
       $this->load->view('aplicacion/excel');
    }

    

    
    /**
     * function buscarpaciente
     *
     * Funcion que busca un paciente en la base de datos
     *
     */
    function buscarpaciente() {
        $nro_identidad =  $_REQUEST["numero"];
        $paciente = $this->paciente_model->get_paciente($nro_identidad);
        echo json_encode($paciente);
    }


    /**
     * function crear_paciente
     *
     * Funcion que crea un  nuevo paciente para la app 
     *
     */
    function crear_paciente() {
        $nro_identidad =  $_REQUEST["ndoc"];
        $pacienteBuscado = $this->paciente_model->get_paciente($nro_identidad);

        if(isset($pacienteBuscado)){
            $datosPaciente =  $_POST;
            $this->paciente_model->actualizar_paciente($nro_identidad,$datosPaciente);
            echo "OK";
        }else{
            $paciente =  $_POST;
            $paciente['id_sede']=$this->session->userdata('id_sede');
            $this->paciente_model->crear_paciente($paciente);
            echo "OK";
        }  
    }


     /**
     * function get_valoracion
     *
     * Funcion que obtiene la valoracion de un paciente
     *
     */
    function get_valoracion() {
        $numero = $this->input->post('documento');
        $tipodoc = $this->input->post('tipodoc');
        $valoracion =  $this->paciente_model->get_valoracion($numero,$tipodoc);
        echo  json_encode(array('descripcion' => $valoracion->valoracion , 'valor' => '100 000'));
    }

    /**
     * function guardar_valoracion
     *
     * Funcion que guarda la valoracion de un paciente
     *
     */
    function guardar_valoracion() {
        $valoracionDato = $this->input->post('valoracion');
        $cedula = $this->input->post('numero');
        $valoracionArray = array( 'valoracion' => $valoracionDato);

        $this->paciente_model->guardar_valoracion($cedula, $valoracionArray);
        echo  "OK";
    }

    /**
     * function export_excel
     *
     * Funcion export_excel exporta a excel las los pacientes creados en un rango de tiempo
     *
     */
    function export_excel() {
        $feini = $_REQUEST["feini"];
        $fefin = $_REQUEST["fefin"];
        $resultadoPacientes = $this->paciente_model->get_pacientes_excel($feini,$fefin);
        $fields = array("CUMPLE","DIA_CUMPLE","MES_CUMPLE","EDAD","TIPO_DOC","N_DOC","NOMBRES",
                        "APELLIDOS","EMAIL","TEL1","TEL2","CELULAR","RESIDE");
        $nombre_archivo="pacientes_".$feini."-".$fefin;
        to_excel($fields, $resultadoPacientes , $nombre_archivo);        
    } 

}
