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
class Paquete extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('paquete_model');
        $this->load->model('paciente_model');
        $this->load->model('administracion_model');
        $this->load->helper('mysql_to_excel_helper');
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
        $permisos =  $this->administracion_model->get_permisos_rol($this->session->userdata('rol'),"paquete");
        if (isset($permisos)) {
            $data['permisos'] = $permisos->nombre_permiso;
            $this->load->view('aplicacion/paquetes',$data);
        }else{
            $data['mensaje'] = "Acceso Denegado";
            $this->load->view('aplicacion/home',$data); //Vista que se carga
        }
    }

    


    /**
     * function idpaquete
     *
     * Funcion funcion que trae la informacion de un paquete por id 
     */
    function idpaquete() {

        $idPac = $_REQUEST["idpxp"];


        $resultado_paquete = $this->paquete_model->id_paquete($idPac);

        $objetoPaquete = (object) array('fecha' => $resultado_paquete->fechaini,
                                        'sede' => $this->getNombreSede($resultado_paquete->id_sede),
                                        'total' => $resultado_paquete->total,
                                        'actual' => $resultado_paquete->actual,
                                        'pend' => $resultado_paquete->pend,
                                        'fechaini' => $resultado_paquete->fechaini,
                                        'valor' => $resultado_paquete->valorp,
                                        'abonos' => $resultado_paquete->abonos,
                                        'observaciones' => $resultado_paquete->observaciones,
                                        'saldo' => $resultado_paquete->valorp - $resultado_paquete->abonos);     


        
        $resultado_sesiones_paquete = $this->paquete_model->sesiones_x_paquete($resultado_paquete->id_pxp,$resultado_paquete->id_sede); 
        
        $sesiones = array();
        $contador=1;
        foreach ($resultado_sesiones_paquete as $row) {
        $sesionTemporal = (object) array(   'id_sesion' => $row->sesion,
                                            'fecha'=>$row->fecha,
                                            'usuario'=>$row->usuario,
                                            'sede'=> $this->getNombreSede($row->id_sede),
                                            'observacion'=>$row->observacion,
                                            'abono'=>$row->valor,'valor'=>$row->valor);
            $sesiones[$contador] = $sesionTemporal;
            $contador++;
        }
        $objetoPaquete->sesionespaquete = $sesiones;
        echo json_encode($objetoPaquete);  
        
    }

    /**
     * function getNombreSede
     *
     * Funcion getNombreSede trae el nombre de la sede segun codigo
     */

    function getNombreSede($id_sede) {
        if($id_sede == 2 ){
            return "CEU CAMINO REAL";
        }

        if($id_sede == 3 ){
            return "CEU MAYORCA";
        }

        if($id_sede == 1 ){
            return "CEU PALMAS";
        }
    }

    

    /**
     * function paquetes_usuario
     *
     * Funcion paquetes_usuario que trae los paquetes de un paciente
     */
    function paquetes_usuario() {
    
        $nrodocumento = $_REQUEST["nrodocumento"];
        $tipoDocPaq = $_REQUEST["tipoDocPaq"];

        $resultado_paquetes_paciente = $this->paquete_model->paquetes_x_paciente($tipoDocPaq,$nrodocumento);

        $paquetes = array();
        $contador=1;
        foreach ($resultado_paquetes_paciente as $row) {

            $paqueteTemporal = (object) array( 'id_paquete' => $row->id_pac,
                                                'nombre_paquete' => $row->nombre);
            $paquetes[$contador] = $paqueteTemporal;
            $contador++;
        }

        $resultado_paciente = $this->paciente_model->get_paciente($nrodocumento,$tipoDocPaq);
        if(isset($resultado_paciente)){ 
        $datosIniciales = (object) array('nombre' => $resultado_paciente->nombre1,
                                        'apellidos' => $resultado_paciente->apellido1);
        }else{
            $datosIniciales = (object) array('nombre' => "",
                                        'apellidos' => "");
        }
        $datosIniciales->paquetesActivos = $paquetes;
        echo json_encode($datosIniciales);
    }


    /**
     * function crearpaquete
     *
     * Funcion crea paquete para un paciente
     *
     */
    function crearpaquete() {
        $nroDocumento = $_REQUEST["nroDocumento"];
        $tipoDocPaq = $_REQUEST["tipoDocPaq"];
        $paqNuevo = $_REQUEST["paqNuevo"];
        $sesionesPaqNuevo = $_REQUEST["sesionesPaqNuevo"];
        $observacionesPaqNuevo = $_REQUEST["observacionesPaqNuevo"];
        $precioPaqNuevo = $_REQUEST["precioPaqNuevo"];
        $fechaini = getdate();
        $fechaini = $fechaini['year'].'-'.$fechaini['mon'].'-'.$fechaini['mday'];
        $autoincrement = $this->paquete_model->id_pac_siguiente();
        $autoincrement =  $autoincrement->id_pac+1;
        $paquete = array(
            'tipodoc' => $tipoDocPaq,
            'ndoc' => $nroDocumento,
            'id_paq' => $paqNuevo,
            'total' => $sesionesPaqNuevo,
            'actual' => '0',
            'pend' => $sesionesPaqNuevo,
            'fechaini' => $fechaini,
            'id_pxp' => $autoincrement,
            'csec' => '1',
            'activo' => '1',
            'id_sede' => $this->session->userdata('id_sede'),
            'valorp' => $precioPaqNuevo,
            'abonos' => '0',
            'observaciones' =>$observacionesPaqNuevo);

        $this->paquete_model->crear_paquete($paquete);

        echo "OK";
    }

    /**
     * function crearsesion
     *
     * Funcion crea sesion  para un paquete
     *
     */
    function crearsesion() {

        $activo = $_REQUEST["activo"];
        $nrosesion = $_REQUEST["nrosesion"];
        $abonosesion = $_REQUEST["abonosesion"];
        $observacionSesion = $_REQUEST["observacionSesion"];
        $idpxp = $_REQUEST["idpxp"];

        $resultado_paquete = $this->paquete_model->id_paquete($idpxp);

        $sesion = array(
            'id_pxp' => $resultado_paquete->id_pxp,
            'sesion' => $nrosesion,
            'observacion' => $observacionSesion,
            'activo' => $activo,
            'usuario' => $this->session->userdata('usuario'),
            'idsedepxp'=> $resultado_paquete->id_sede,
            'id_sede' => $this->session->userdata('id_sede'),
            'valor' => $abonosesion);

        $this->paquete_model->crear_sesion($sesion);

        $this->paquete_model->actualizar_paquete($nrosesion,$abonosesion, $resultado_paquete->id_pxp);

        echo "OK";
    }


    /**
     * function regresar_sesion
     *
     * Funcion regresa sesion  para un paquete
     *
     */
    function regresar_sesion() {

        $observacionSesion = $_REQUEST["observacionregreso"];
        $idpxp = $_REQUEST["idpxp"];
        $observacionSesion = "REGRESION : ".$observacionSesion;
        $resultado_paquete = $this->paquete_model->id_paquete($idpxp);

        $abono_ultimo = $this->paquete_model->ultimo_abono_paquete($idpxp,$resultado_paquete->id_sede,$resultado_paquete->actual);

        $valor_nuevo = $resultado_paquete->abonos - $abono_ultimo->valor;
        $actual_nuevo = $resultado_paquete->actual - 1;
        $pendiente_nuevo = $resultado_paquete->pend + 1;

        $sesion = array(
            'id_pxp' => $resultado_paquete->id_pxp,
            'sesion' => $resultado_paquete->actual,
            'observacion' => $observacionSesion,
            'activo' => '1',
            'usuario' => $this->session->userdata('usuario'),
            'idsedepxp'=> $resultado_paquete->id_sede,
            'id_sede' => $this->session->userdata('id_sede'),
            'valor' => '');

        $this->paquete_model->crear_sesion($sesion);


        $paqxpac = array(
            'actual' => $actual_nuevo,
            'abonos' => $valor_nuevo,
            'pend' => $pendiente_nuevo);

        $this->paquete_model->actualizar_paquete_array($resultado_paquete->id_pac,$paqxpac);

        echo "OK";
    }

     /**
     * function eliminar_paquete_unico
     *
     * Funcion eliminar_paquete_unico elimina el paquete 
     */
    function eliminar_paquete_unico() {
    $idPaquete = $_REQUEST["idpaquete"];
    $observacion_eliminar = $_REQUEST["observacionEliminar"];
    $resultado_paquete = $this->paquete_model->id_paquete($idPaquete);
    $resultado_paquete->observaciones=$observacion_eliminar;
    $this->paquete_model->crear_paquete_eliminado($resultado_paquete);
    $id_pxp = $resultado_paquete->id_pxp;
    $id_sede = $resultado_paquete->id_sede;
    $this->paquete_model->eliminar_paquete($id_pxp,$id_sede);
    $this->paquete_model->eliminar_sesiones_x_paquete($id_pxp,$id_sede);
    echo "OK";
    }



    /**
     * function export_excel_sesiones
     *
     * Funcion export_excel_sesiones exporta a excel las sesiones de una rango de fechas
     *
     */
    function export_excel_sesiones() {
        $feini = $_REQUEST["feini"];
        $fefin = $_REQUEST["fefin"];
        $resultado_sesiones_paquete = $this->paquete_model->sesiones_x_paquete_informe($feini,$fefin); 

        $fields = array("cod_paquete","id_paquete","fecha","tipodoc","ndoc","nombre","sesion",
                        "observacion","id_sede","nombre_sede","paquete_paciente");
        $nombre_archivo="sesiones_".$feini."_".$fefin;

        to_excel($fields, $resultado_sesiones_paquete , $nombre_archivo);

        
    } 


    /**
     * function export_excel_paquete
     *
     * Funcion export_excel_paquete exporta a excel los paquetes de una rango de fechas
     *
     */
    function export_excel_paquete() {
        $feini = $_REQUEST["feini"];
        $fefin = $_REQUEST["fefin"];

        $resultado_sesiones_paquete = $this->paquete_model->paquete_informe($feini,$fefin); 

        $fields = array("tipodoc","ndoc","nombre","apellidos","sexo","correo","celular","telefono",
                        "cumple","nombre_paquete","fechaini","total",
                        "actual","pend","valorp","abonos","observacion","nombre_sede");
        $nombre_archivo="paquetes_".$feini."_".$fefin;

        to_excel($fields, $resultado_sesiones_paquete , $nombre_archivo);


    } 


    



    
    


}
