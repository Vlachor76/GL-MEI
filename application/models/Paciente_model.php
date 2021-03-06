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
class Paciente_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Funcion que retorna los datos del paciente segun identificacion
    function get_paciente($nrodocumento,$tipodoc) {
        $this->db->where('ndoc', $nrodocumento);
        $this->db->where('tipodoc', $tipodoc);
        $query = $this->db->get('paciente');
        return $query->row();
    }

    // Funcion que retorna los datos del paciente segun identificacion
    function crear_paciente($paciente) {
        $this->db->insert('paciente', $paciente);
    }
  
     // Funcion que actualiza los datos del paciente
     function actualizar_paciente($nro_identidad,$datosPaciente) {
        $this->db->update('paciente', $datosPaciente, array('ndoc' => $nro_identidad));
    }

    // Funcion que pacientes creados en un rando de fechas
    function get_pacientes_excel($fechaInicio,$fechaFinal) {
        $this->db->select("paciente.*,DAY(cumple) as diacumple , MONTH(cumple) as mescumple ,sedes.nombre_sede");
        $this->db->from('paciente');
        $this->db->join('sedes', 'sedes.id_sede = paciente.id_sede ');
        $this->db->where('fecinsc  >=', $fechaInicio);
        $this->db->where('fecinsc  <=', $fechaFinal);
        $query = $this->db->get();
        return $query;
    }

   


    // Funcion que guarda la valoracion por el medico de un paciente
    function guardar_valoracion($cedula, $valoracion) {
        $this->db->update('paciente', $valoracion, array('ndoc' => $cedula));
    }

    

    // Funcion que cambia la identificacion de un paciente
    function cambiar_identificacion($documentoActual, $documentoNuevo) {
        $this->db->update('paciente',  array('ndoc' => $documentoNuevo), array('ndoc' => $documentoActual));
    }

    // Funcion que retorna la valoracion de un paciente
    function get_valoracion($numero,$tipodoc) {
        $this->db->select('valoracion');
        $this->db->where('ndoc', $numero);
        $this->db->where('tipoDoc', $tipodoc);
        $query = $this->db->get('paciente');
        return $query->row();
    }

    // Funcion que registra el cambio de identificacion
    function insertar_cambio_identificacion($cambioIdentificacion) {
        $this->db->insert('cambios_identificacion', $cambioIdentificacion);
    } 

    // Funcion que obtiene las citas de un determinado paciente
    function get_pacientes($nombre,$apellido,$correo,$celular,$telefono) {
        if($nombre != ""){
            $this->db->where('nombre1 =', $nombre);
        }
        if($correo != ""){
            $this->db->where('email =', $correo);
        }
        if($apellido != ""){
            $this->db->where('apellido1 =', $apellido);
        }
        if($celular != ""){
            $this->db->where('celular =', $celular);
        }
        if($telefono != ""){
            $this->db->where('tel1 =', $telefono);
        }
        $query = $this->db->get('paciente');
        return $query->result();
        
    }

    

}
