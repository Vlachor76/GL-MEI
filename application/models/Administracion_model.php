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


    // Funcion obtiene los datos de la empresa
    function get_datos_empresa() {
        $query = $this->db->get('sedegen');
        return $query->row();
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

    
    // Funcion obtiene los diagnosticos 
    function  get_diagnosticos($cod_diag) {
        $this->db->like('codconsult', $cod_diag);
        $query = $this->db->get('cie10_diag',7);
        return $query->result();
    }

    // Funcion obtiene los procedimientos 
    function  get_procedimientos($cod_proc) {
        $this->db->like('codigo', $cod_proc);
        $query = $this->db->get('cups_proc',7);
        return $query->result();
    }


    // Funcion obtiene una sede especifica
    function  get_sede($id_sede) {
        $this->db->like('id_sede', $id_sede);
        $query = $this->db->get('sedes');
        return $query->row();
    }

}
