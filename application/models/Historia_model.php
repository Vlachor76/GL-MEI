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
        $this->db->insert('ceu_evolucion', $evolucion);
    }

    // Funcion que obtiene la historia
    function get_historia($tipodoc,$numero) {
        $this->db->select("ceu_historia.*,ceu_usuario.nombre1,ceu_usuario.nombre2");
        $this->db->select("ceu_usuario.apellido1,ceu_usuario.apellido2");
        $this->db->from('ceu_historia');
        $this->db->join('ceu_usuario', 'ceu_usuario.documento = ceu_historia.id_usuario');
        $this->db->where('ceu_historia.tipoDoc', $tipodoc);
        $this->db->where('ceu_historia.documento', $numero);
        $this->db->order_by('fecha', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
 

    // Funcion que obtiene las evoluciones de un paciente
    function get_evoluciones($tipodoc,$numero) {
        $this->db->select("ceu_evolucion.*,ceu_usuario.nombre1,ceu_usuario.nombre2");
        $this->db->select("ceu_usuario.apellido1,ceu_usuario.apellido2");
        $this->db->from('ceu_evolucion');
        $this->db->join('ceu_usuario', 'ceu_usuario.documento = ceu_evolucion.id_usuario');
        $this->db->where('tipoDoc', $tipodoc);
        $this->db->where('ndoc', $numero);
        $this->db->order_by('fecha', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }


    // Funcion que obtiene una evolucion por id
    function get_evolucion($id_evolucion) {
        $this->db->where('id_evolucion', $id_evolucion);
        $query = $this->db->get('ceu_evolucion');
        return $query->row();
    }

    // Funcion que cambia la identificacion de un paciente
    function cambiar_identificacion($documentoActual, $documentoNuevo) {
        $this->db->update('ceu_historia',  array('documento' => $documentoNuevo), array('documento' => $documentoActual));
        $this->db->update('ceu_evolucion',  array('ndoc' => $documentoNuevo), array('ndoc' => $documentoActual));   
    }


    // Funcion que busca las sesiones de un paquete para el informe de excel
    function historia_informe_excel($fecha_ini,$fecha_fin) {
        $sqlInforme = "SELECT ceu_historia.fecha, ceu_paciente.tipodoc, ceu_paciente.ndoc, 
        ceu_paciente.nombre1, ceu_paciente.apellido1, ceu_paciente.sexo, ceu_paciente.edad,ceu_paciente.reside, 
        ceu_paciente.codiUbi, ceu_paciente.municipio,ceu_paciente.celular,ceu_paciente.email,ceu_paciente.cumple, 
        ceu_historia.codiag, ceu_historia.coproc,ceu_sedes.nombre_sede,ceu_usuario.nombre1 as n_medico,
        ceu_usuario.apellido1 as a_medico ,roles.nombre
        FROM ceu_historia 
        JOIN `ceu_paciente` ON ceu_historia.documento = ceu_paciente.ndoc 
                            and ceu_historia.tipodoc = ceu_paciente.tipodoc 
        JOIN `ceu_usuario` ON ceu_usuario.documento = ceu_historia.id_usuario
        JOIN `roles` ON roles.psips = ceu_historia.psips
        JOIN `ceu_sedes` ON ceu_sedes.id_sede = ceu_historia.id_sede
        WHERE ceu_historia.fecha >= '$fecha_ini' AND ceu_historia.fecha <= '$fecha_fin'  
        UNION 
        SELECT ceu_evolucion.fecha, ceu_paciente.tipodoc, ceu_paciente.ndoc, ceu_paciente.nombre1, 
        ceu_paciente.apellido1, ceu_paciente.sexo,ceu_paciente.edad, ceu_paciente.reside, ceu_paciente.codiUbi, 
        ceu_paciente.municipio,ceu_paciente.celular,ceu_paciente.email,ceu_paciente.cumple, 
        ceu_evolucion.codiag, ceu_evolucion.coproc,ceu_sedes.nombre_sede,ceu_usuario.nombre1 as n_medico,
        ceu_usuario.apellido1 as a_medico ,roles.nombre
        FROM ceu_evolucion 
        JOIN ceu_paciente ON ceu_evolucion.ndoc = ceu_paciente.ndoc 
                          and ceu_evolucion.tipodoc = ceu_paciente.tipodoc
        JOIN `ceu_usuario` ON ceu_usuario.documento = ceu_evolucion.id_usuario
        JOIN `roles` ON roles.psips = ceu_evolucion.psips 
        JOIN `ceu_sedes` ON ceu_sedes.id_sede = ceu_evolucion.id_sede 
        WHERE ceu_evolucion.fecha >= '$fecha_ini' AND ceu_evolucion.fecha <= '$fecha_fin'";
        $query = $this->db->query($sqlInforme);
        return $query->result();
    }
}
