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
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('usuario_model');
        $this->load->database('default');
        date_default_timezone_set("America/Bogota");
    }


    // Funcion que nos carga la vista del formulario de acceso al sistema
    function index() {
        $this->load->view('login/formulario_index'); //Vista que se carga
    }

    function reservar() {
        $this->load->view('login/formulario_ingreso'); //Vista que se carga
    }

    function cita() {
        $this->load->view('login/formulario_ingreso'); //Vista que se carga
    }

    // Funcion que valida que el usuario si exista en la base da datos
    function validar_usuario() {
        $sede = $this->input->post('sede');
            $query = $this->usuario_model->validar($this->input->post('usuario'));
            if ($query) {
                $sha1contraseña = sha1($this->input->post('contrasena'));
                if ($query->password == $sha1contraseña ) {
                        $arraydata = array(
                            'nombre'  => $query->nombre1 ." ".$query->nombre2." ".$query->apellido1,
                            'apellido' => $query->apellido1,
                            'correo' => $query->correo,
                            'celular' => $query->celular,
                            'idusuario' => $query->documento,
                            'cargo' => $query->cargo,
                            'usuario' => $query->usuario,
                            'rol' => $query->psips,
                            'id_sede' =>  $sede,
                            'is_logged_in' => TRUE,
                    );
                    $this->session->set_userdata($arraydata);
                    echo "OK";
                }else{
                    echo 'Usuario y/o Contraseña Erronea'; 
                }
            } else {
                echo 'Usuario y/o Contraseña Erronea'; 
            }
    }

    // Funcion que permite deslogear a un usuario del sistema
    function logout() {
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }

}
