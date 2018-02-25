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
class Administracion_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Funcion obtiene los lugares de  cada sede
    function get_paquetes() {
        $query = $this->db->get('paquetes');
        return $query->result();
    }

    // Funcion obtiene los municipios de  cada sede
    function get_municipios() {
        $query = $this->db->get('municipios');
        return $query->result();
    }

    // Funcion obtiene el permiso de un rol en un controlador
    function get_permisos_rol($id_rol,$modulo) {
        $this->db->where('id_rol', $id_rol);
        $this->db->where('nombre_modulo', $modulo);
        $query = $this->db->get('permisos_roles');
        return $query->row();
    }

}
