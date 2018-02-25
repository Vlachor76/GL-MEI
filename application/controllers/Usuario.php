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
class Usuario extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('usuario_model');
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


    function index() {   
        $permisos =  $this->administracion_model->get_permisos_rol($this->session->userdata('rol'),"usuario");
        if (isset($permisos)) {
        $data['permisos'] = $permisos->nombre_permiso;
        $this->load->view('aplicacion/usuario',$data);
        }else{
        $data['mensaje'] = "Acceso Denegado";
        $this->load->view('aplicacion/home',$data); //Vista que se carga
        }
    }



    

     /**
     * function buscarusuario
     *
     * Funcion buscar usuario por identificacion
     *
     */
    function buscarusuario() {
        $documento = $_REQUEST["numero"];
        $resultadousuario =  $this->usuario_model->get_usuario($documento);
        if(isset($resultadousuario->documento)){
            echo json_encode($resultadousuario);
        }else{        
            echo "NO_USUARIO";
        }
    }
            
    


    /**
     * function crear_usuario
     *
     * Funcion que crea un  nuevo usuario para la app 
     *
     */

    function crear_usuario() {
        $documento =  $_REQUEST["documento"];
        $resultadousuario =  $this->usuario_model->get_usuario($documento);
        if($resultadousuario){
            $datosUsuario =  $_POST;
            $datosUsuario['password']=$resultadousuario->password;
            $this->usuario_model->actualizar_usuario($documento,$datosUsuario);
            echo "OK";
        }else{
            $usuario =  $_POST;
            $usuario['password']=sha1($usuario['password']);
            $this->usuario_model->crear_usuario($usuario);
            echo "OK";
        }  
    }



      /**
     * function cambiar_contrasena
     *
     * Funcion que cambia la contrasena de un usuario
     *
     */

    function cambiar_contrasena() {
        $documento =  $_REQUEST["documento"];
        $password =  $_REQUEST["password"];
        $datosUsuario['password']=sha1($password);
        $this->usuario_model->actualizar_usuario($documento,$datosUsuario);
        echo "OK";
    }
    


}
