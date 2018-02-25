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
class Menu extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->helper('url');
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
     * Funcion que nos carga la vista del calendario para ingresar al encuentro virtual
     *
     */
    function index() {
        $data['main_content'] = 'aplicacion/home';
        //$this->load->view('aplicacion/includes/template', $data); //Vista que se carga
        $this->load->view('aplicacion/home');
    }


}
