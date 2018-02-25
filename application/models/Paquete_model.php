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
class Paquete_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    // Funcion que busca un paquete por id
    function crear_paquete($paquete) {
        $this->db->insert('paqxpac', $paquete);
    }

    // Funcion que busca un paquete por id
    function crear_sesion($sesion) {
        $this->db->insert('sesiones', $sesion);
    }

    // Funcion que busca un paquete por id
    function id_paquete($id_paquete) {
        $this->db->where('id_pxp =', $id_paquete);
        $query = $this->db->get('paqxpac');
        return $query->row();
    }

    // Funcion selecciona el maximo valor de id_paq
    function id_pac_siguiente() {
        $this->db->select_max('id_pac');
        $query = $this->db->get('paqxpac'); 
        return $query->row();;
    }

    // Funcion que busca las sesiones de un paquete
    function sesiones_x_paquete($id_paquete,$id_sede) {
        $this->db->where('id_pxp =', $id_paquete);
        $this->db->where('idsedepxp =', $id_sede);
        $query = $this->db->get('sesiones');
        return $query->result();
    }

    
    // Funcion que busca las sesiones de un paquete para el informe de excel
    function sesiones_x_paquete_informe($fecha_ini,$fecha_fin) {
        $sqlInforme = "SELECT ceu_paciente.tipodoc ,ceu_paciente.ndoc,ceu_paciente.nombre1,
        CONCAT(ceu_paciente.apellido1,' ',ceu_paciente.apellido2),paquetes.nombre,paqxpac.fechaini,sesiones.sesion,
        sesiones.fecha,sesiones.observacion,ceu_sedes.nombre_sede
        FROM `sesiones` 
        JOIN `paqxpac` ON `sesiones`.`id_pxp` = `paqxpac`.`id_pxp` 
        JOIN `paquetes` ON `paquetes`.`id_paq` = `paqxpac`.`id_paq`
        JOIN `ceu_paciente` ON `paqxpac`.`ndoc` = `ceu_paciente`.`ndoc`
        JOIN `ceu_sedes` ON `ceu_sedes`.`id_sede` = `paqxpac`.`id_sede`
        WHERE `fecha` >= '$fecha_ini' AND `fecha` <= '$fecha_fin' ";
        $query = $this->db->query($sqlInforme);
        return $query->result();
    }

    // Funcion que busca los paquetes de una rango de fechas para el  informe de excel
    function paquete_informe($fecha_ini,$fecha_fin) {
        $sqlInforme = "SELECT ceu_paciente.tipodoc ,ceu_paciente.ndoc,ceu_paciente.nombre1,
        CONCAT(ceu_paciente.apellido1,' ',ceu_paciente.apellido2),paquetes.nombre,paqxpac.fechaini,
        paqxpac.total,paqxpac.actual,paqxpac.pend,paqxpac.valorp,sesiones.sesion,
        sesiones.fecha,sesiones.observacion,paqxpac.abonos,ceu_sedes.nombre_sede
        FROM `sesiones` 
        JOIN `paqxpac` ON `sesiones`.`id_pxp` = `paqxpac`.`id_pxp` 
        JOIN `paquetes` ON `paquetes`.`id_paq` = `paqxpac`.`id_paq`
        JOIN `ceu_paciente` ON `paqxpac`.`ndoc` = `ceu_paciente`.`ndoc`
        JOIN `ceu_sedes` ON `ceu_sedes`.`id_sede` = `paqxpac`.`id_sede`
        WHERE `fecha` >= '$fecha_ini' AND `fecha` <= '$fecha_fin' ";
        $query = $this->db->query($sqlInforme);
        return $query->result();
    }


    // Funcion que busca los paquetes de un paciente
    function paquetes_x_paciente($tipoDocPaq,$nrodocumento) {
        $this->db->select("*");
        $this->db->from('paqxpac');
        $this->db->join('paquetes', 'paquetes.id_paq = paqxpac.id_paq');
        $this->db->where('tipodoc =', $tipoDocPaq);
        $this->db->where('ndoc =', $nrodocumento);
        $query = $this->db->get();
        return $query->result();
    }  

    //Funcion que actualiza los datos del paquete
    function actualizar_paquete($nrosesion,$abonosesion,$idpxp){ 
    $sqlUpdate = "UPDATE paqxpac SET actual='$nrosesion' ,  
                  pend =pend-1  ,  abonos=abonos+'$abonosesion' 
                  WHERE id_pxp='$idpxp'";
    $query = $this->db->query($sqlUpdate);
    return $query;
    }  

    // Funcion que actualiza los datos del paciente
    function actualizar_paquete_array($id_pac,$datosPXP) {
        $this->db->update('paqxpac', $datosPXP, array('id_pac' => $id_pac));
        }
    

    // Funcion selecciona el maximo valor de id_paq
    function ultimo_abono_paquete($id_pxp,$id_sede_origen,$actual) {
        $this->db->select("valor");
        $this->db->where('id_pxp =', $id_pxp);
        $this->db->where('idsedepxp =', $id_sede_origen);
        $this->db->where('sesion =', $actual);
        $query = $this->db->get('sesiones'); 
        return $query->row();
    }
}
