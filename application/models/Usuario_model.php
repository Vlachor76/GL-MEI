<?php

/**
 * Autor:     
 * Email:      
 * Web:        
 * class Login_model
 *
 * Clase donde reposan las sentencias de bases de datos utilizadas para la clase Login, donde se autentica
 * y se ingresa al sistema
 *
 * @package    
 * @author     
 * @version    
 * @copyright  
 */
class Usuario_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Funcion que retorna los datos del usuario segun el usuario
    function validar($usuario) {
        $this->db->select('ceu_usuario.*', FALSE);
        $this->db->where('usuario', $usuario);
        $query = $this->db->get('ceu_usuario');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return FALSE;
        }
    }


     // Funcion que retorna los datos del usuario segun id o falso si no existe
     function get_usuario($cedula) {
        $this->db->select('ceu_usuario.*', FALSE);
        $this->db->where('documento', $cedula);
        $query = $this->db->get('ceu_usuario');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    // Funcion que crea un registro en la base de datos de un usuario
    function crear_usuario($usuario) {
        $this->db->insert('ceu_usuario', $usuario);
    }
    
    // Funcion que actualiza los datos del paciente
    function actualizar_usuario($documento,$datosUsuario) {
    $this->db->update('ceu_usuario', $datosUsuario, array('documento' => $documento));
    }


}
