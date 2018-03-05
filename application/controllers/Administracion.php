<?php

/**
 * Autor:     
 * Email:     
 * Web:
 * class Administracion
 *
 * Modulo que tiene acceso a todo lo administrativo de la aplicacion
 *
 * @package    
 * @author     
 * @version    
 * @copyright  
 */
class Administracion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('cita_model');
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

    /**
     * function index
     *
     * Funcion que nos carga la vista de administracion
     *
     */
    function index() {
        //Vista que se carga
    }


     /**
     * function obtener_paquetes
     *
     * Funcion consulta los paquetes activos
     *
     */
    function obtener_paquetes() {
    $resultadoPaquetes = $this->administracion_model->get_paquetes(); 
     echo json_encode($resultadoPaquetes);
    }


    /**
     * function obtener_municipios
     *
     * Funcion consulta los municipios
     *
     */
    function obtener_municipios() {
        $resultadoMunicipios = $this->administracion_model->get_municipios(); 
         echo json_encode($resultadoMunicipios);
        }


    

     /**
     * function obtener_procedimientos
     *
     * Funcion consulta los procedimientos
     *
     */
    function obtener_procedimientos() {
        $cod_proc = $_REQUEST["term"];
        $resultadoProcedimientos = $this->administracion_model->get_procedimientos($cod_proc);
        $procedimientos = array();
        $contador=0;
        foreach ($resultadoProcedimientos as $row) {
            $objetoTemporal = (object) array(   'id' => $row->codigo,
                                                'label' => $row->procedi,
                                                'value' => $row->codigo);
        $procedimientos[$contador] = $objetoTemporal;
        $contador++;
        }
        echo json_encode($procedimientos);
        } 

    /**
     * function obtener_diagnosticos
     *
     * Funcion consulta los diagnosticos
     *
     */
    function obtener_diagnosticos() {
        $cod_diag = $_REQUEST["term"];
        $resultadoDiagnosticos = $this->administracion_model->get_diagnosticos($cod_diag);
        $diagnosticos = array();
        $contador=0;
        foreach ($resultadoDiagnosticos as $row) {
            $objetoTemporal = (object) array(   'id' => $row->codconsult,
                                                'label' => $row->diag,
                                                'value' => $row->codconsult);
        $diagnosticos[$contador] = $objetoTemporal;
        $contador++;
        }
        echo json_encode($diagnosticos);
    }





    }