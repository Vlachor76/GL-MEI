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
class Cita_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Funcion que crea el registro de edicion cita en base de datos  del la reserva
    function crear_reserva($reserva) {
        $this->db->insert('edicion', $reserva);
    }

     // Funcion que crea el registro de una cita reservada en base de datos  del la reserva
     function crear_cita($cita) {
        $this->db->insert('citas', $cita);
    }

    function actualizar_cita($id_cita, $datos) {
        $this->db->update('citas', $datos, array('id_cita' => $id_cita));
    }

    

    // Funcion que elimina el registro en base de datos  del la reserva
    function eliminar_reserva($id_sede,$id_area,$fecha,$hora) {
        $this->db->where('fecha =',$fecha);
        $this->db->where('id_sede =',$id_sede);
        $this->db->where('id_area =',$id_area);
        $this->db->where('hora =',$hora);
        $this->db->delete('edicion');
    }


    // Funcion obtiene los lugares de  cada sede
    function get_lugares_sede($id_sede) {
        $this->db->where('id_sede =', $id_sede);
        $this->db->order_by('id_lugar_sede ', "ASC");
        $query = $this->db->get('lugares');
        return $query->result();
    }


    

    function eliminar_cita($id_cita,$observacion){
        $fechault = date('Y-m-d H:i:s', time());
        $this->db->update('citas',array('estado' => 'E','fecha_ult' => $fechault,'observa' => $observacion), array('id_cita' => $id_cita));
    }

    // Funcion que obtiene las citas creadas
    function get_citas($fecha,$id_area,$id_sede) {
        $this->db->select("*");
        $this->db->from('citas');
        $this->db->join('colores_x_estado', 'colores_x_estado.cod_estado = citas.estado');
        $this->db->where('fecha =', $fecha);
        $this->db->where('id_area =', $id_area);
        $this->db->where('id_sede =', $id_sede);
        $this->db->where('estado !=', 'E');
        $query = $this->db->get();
        return $query->result();
    }

    // Funcion que obtiene las citas creadas para el informe de excel
    function get_citas_excel($fecha,$id_area,$id_sede) {
        $this->db->select("tipoDoc,nro_documento,CONCAT(primer_nombre,'',segundo_nombre) AS nombre,fecha,fecha_sol,vista,usuini,usult");
        $this->db->where('fecha =', $fecha);
        $this->db->where('id_area =', $id_area);
        $this->db->where('id_sede =', $id_sede);
        $this->db->where('estado !=', 'E');
        $query = $this->db->get('citas');
        return $query->result();
    }

    // Funcion get tipos consulta
    function get_tipo_consultas($id_sede,$fecha) {
        $this->db->select('id_area,hora,tipo_viejo,tipo_consulta');
        $this->db->where('fecha =', $fecha);
        $this->db->where('id_sede =', $id_sede);
        $this->db->where('estado !=', 'E');
        $this->db->order_by("id_area","desc");
        $query = $this->db->get('citas');
        return $query->result();
    }

    // Funcion get tipos consulta
    function verificar_reserva($id_sede,$id_area,$fecha,$hora) {
        $this->db->select('id_reserva');
        $this->db->where('fecha =', $fecha);
        $this->db->where('id_sede =', $id_sede);
        $this->db->where('id_area =', $id_area);
        $this->db->where('hora =', $hora);
        $query = $this->db->get('edicion');
        return $query->row();
    }

     // Funcion que obtiene las citas de un determinado paciente
     function get_citas_paciente($fechaInicio,$fechaFinal,$nombre,$correo,$documento) {
       
        $this->db->where('fecha  >=', $fechaInicio);
        $this->db->where('fecha  <=', $fechaFinal);
        if($nombre != ""){
            $this->db->where('primer_nombre =', $nombre);
        }
        if($correo != ""){
            $this->db->where('correo =', $correo);
        }
        if($documento != ""){
            $this->db->where('nro_documento =', $documento);
        }
        $query = $this->db->get('citas',7);
        return $query->result();
        
    }
}
