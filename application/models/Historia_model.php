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
        $this->db->select("historia.*,usuario.nombre1,usuario.nombre2");
        $this->db->select("usuario.apellido1,usuario.apellido2");
        $this->db->from('historia');
        $this->db->join('usuario', 'usuario.documento = historia.id_usuario');
        $this->db->where('historia.tipoDoc', $tipodoc);
        $this->db->where('historia.documento', $numero);
        $this->db->order_by('fecha', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }


    // Funcion que obtiene las evoluciones de un paciente
    function get_evoluciones($tipodoc,$numero) {
        $this->db->select("evolucion.*,usuario.nombre1,usuario.nombre2");
        $this->db->select("usuario.apellido1,usuario.apellido2");
        $this->db->from('evolucion');
        $this->db->join('usuario', 'usuario.documento = evolucion.id_usuario');
        $this->db->where('tipoDoc', $tipodoc);
        $this->db->where('ndoc', $numero);
        $this->db->order_by('fecha', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }


    // Funcion que obtiene una evolucion por id
    function get_evolucion($id_evolucion) {
        $this->db->where('id_evolucion', $id_evolucion);
        $query = $this->db->get('evolucion');
        return $query->row();
    }

    // Funcion que cambia la identificacion de un paciente
    function cambiar_identificacion($documentoActual, $documentoNuevo) {
        $this->db->update('historia',  array('documento' => $documentoNuevo), array('documento' => $documentoActual));
        $this->db->update('evolucion',  array('ndoc' => $documentoNuevo), array('ndoc' => $documentoActual));   
    }


    // Funcion que busca las sesiones de un paquete para el informe de excel
    function historia_informe_excel($fecha_ini,$fecha_fin) {
        $sqlInforme = "SELECT historia.fecha, paciente.tipodoc, paciente.ndoc, 
        paciente.nombre1, paciente.apellido1, paciente.sexo, paciente.edad,paciente.reside, 
        paciente.codiUbi, paciente.municipio, historia.codiag, historia.coproc 
        FROM historia 
        JOIN `paciente` ON historia.documento = paciente.ndoc 
                            and historia.tipodoc = paciente.tipodoc 
        WHERE historia.fecha >= '$fecha_ini' AND historia.fecha <= '$fecha_fin'  
        UNION 
        SELECT evolucion.fecha, paciente.tipodoc, paciente.ndoc, paciente.nombre1, 
        paciente.apellido1, paciente.sexo,paciente.edad, paciente.reside, paciente.codiUbi, 
        paciente.municipio, evolucion.codiag, evolucion.coproc 
        FROM evolucion 
        JOIN paciente ON evolucion.ndoc = paciente.ndoc 
                          and evolucion.tipodoc = paciente.tipodoc 
        WHERE evolucion.fecha >= '$fecha_ini' AND evolucion.fecha <= '$fecha_fin'";
        $query = $this->db->query($sqlInforme);
        return $query->result();
    }
   

}
