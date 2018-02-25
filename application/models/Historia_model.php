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
class Historia_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Funcion que crea el registro de la historia en la base de datos
    function crear_historia($historia) {
        $this->db->insert('historia', $historia);
    }

    
    // Funcion que crea el registro de evolucion del paciente
    function ingresar_evolucion($evolucion) {
        $this->db->insert('evolucion', $evolucion);
    }

    // Funcion que obtiene la historia
    function get_historia($tipodoc,$numero) {
        $this->db->where('tipoDoc', $tipodoc);
        $this->db->where('documento', $numero);
        $query = $this->db->get('historia');
        return $query->row();
    }

    // Funcion que obtiene las evoluciones de un paciente
    function get_evoluciones($tipodoc,$numero) {
        $this->db->where('tipoDoc', $tipodoc);
        $this->db->where('ndoc', $numero);
        $this->db->order_by('fecha_registro', 'DESC');
        $query = $this->db->get('evolucion');
        return $query->result();
    }


    // Funcion que obtiene una evolucion por id
    function get_evolucion($id_evolucion) {
        $this->db->where('id_evolucion', $id_evolucion);
        $query = $this->db->get('evolucion');
        return $query->row();
    }
   

}
