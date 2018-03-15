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
class Cita extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('cita_model');
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

    /**
     * function index
     *
     * Funcion que nos carga la vista de citas
     *
     */
    function index() {
        $permisos =  $this->administracion_model->get_permisos_rol($this->session->userdata('rol'),"cita");
        if (isset($permisos)) {
         $data['permisos'] = $permisos->nombre_permiso;
         $this->load->view('aplicacion/cita',$data);
        }else{
         $data['mensaje'] = "Acceso Denegado";
         $this->load->view('aplicacion/home',$data);
        }
    }

    


     /**
     * function lugarsede
     *
     * Funcion consulta los lugares de cada sede
     *
     */
    function lugarsede() {
    $sede = $_REQUEST["sede"];
    $resultadolugares = $this->cita_model->get_lugares_sede($sede); 

     echo json_encode($resultadolugares);
    }
    


    /**
     * function getcitas
     *
     * Funcion getcita consulta las citas reservadas para una sede y lugar determinado
     *
     */
    function getcitas() {
        $horasDias = array(
            "07:00","07:15","07:30","07:45",
            "08:00","08:15","08:30","08:45",
            "09:00","09:15","09:30","09:45",
            "10:00","10:15","10:30","10:45",
            "11:00","11:15","11:30","11:45",
            "12:00","12:15","12:30","12:45",
            "13:00","13:15","13:30","13:45",
            "14:00","14:15","14:30","14:45",
            "15:00","15:15","15:30","15:45",
            "16:00","16:15","16:30","16:45",
            "17:00","17:15","17:30","17:45",
            "18:00","18:15","18:30","18:45",
            "19:00","19:15","19:30","19:45");

        $id_area = $_REQUEST["lugar"];
        $id_sede = $_REQUEST["sede"];
        $fecha = $_REQUEST["fecha"];

        $resultadocitas = $this->cita_model->get_citas($fecha,$id_area,$id_sede);

        $citas = array();

        foreach ($resultadocitas as $row) {
            $observacion_corta = $row->observa ;
            if($observacion_corta != ""){ 
             $observacion_corta = substr($row->observa,0,20) ;
            }
            $telefono = $row->telefono;
            if($this->session->userdata('rol') < 4 ){
                $telefono = $row->nro_documento;
            }
            $objetoTemporal = (object) array(  'nroDocumento' => $row->nro_documento,
                                                'primerNombre' => $row->primer_nombre,
                                                'segundoNombre' => $row->segundo_nombre,
                                                'primerApellido' => $row->primer_apellido,
                                                'segundoApellido' => $row->segundo_apellido,
                                                'observacion' => $observacion_corta,
                                                'tipoConsulta' => $row->tipo_consulta,
                                                'tipoViejo' => $row->tipo_viejo,
                                                'estadoConsulta' =>$row->estado,
                                                'medio' => $row->medios,
                                                'vista' => $row->vista,
                                                'fechaNacimiento' => $row->cumple,
                                                'hora' => $row->hora,
                                                'idUnicoCita' => $row->id_cita,
                                                'correo' => $row->correo,
                                                'celular' => $row->celular,
                                                'color' => $row->color,
                                                'usuini' => $row->usuini,
                                                'usult' => $row->usult,
                                                'telefono' => $telefono);
             $citas[$row->hora] = $objetoTemporal;
        }

        $resultTiposConsultas = $this->cita_model->get_tipo_consultas($id_sede,$fecha);

        foreach ($resultTiposConsultas as $row) {
            $lugar = "lugar".$row->id_area;
            $tipoConsulta = $row->tipo_consulta ; 
            if($tipoConsulta == "ANT"){
               $tipoConsulta = $row->tipo_viejo;
            }
            
            if(isset($citas[$row->hora])){
                    $objet = $citas[$row->hora]; 
                    $objet->$lugar=$tipoConsulta;
            }else{
                $objetoTemporal = (object) array( 'nroDocumento' => '',
                                    'primerNombre' => '',
                                    'segundoNombre' => '',
                                    'primerApellido' => '',
                                    'segundoApellido' => '',
                                    'observacion' => '',
                                    'tipoConsulta' => '',
                                    'estadoConsulta' => '',
                                    'medio' => '',
                                    'usuini' => '',
                                    'usult' => '',
                                    'fechaNacimiento' => '',
                                    'color' => 'white',
                                    'hora' => $row->hora);
                $objetoTemporal->$lugar=$tipoConsulta;                       
                $citas[$row->hora]=$objetoTemporal;
            }
        }
     
        $citasDia = array();
        $identificador=1;
        foreach ($horasDias as &$hora) {        
            if(isset($citas[$hora])){
                 $citasDia[$identificador]=$citas[$hora];
            }else{
                $obj = (object) array( 'nroDocumento' => '',
                                        'primerNombre' => '',
                                        'segundoNombre' => '',
                                        'primerApellido' => '',
                                        'segundoApellido' => '',
                                        'observacion' => '',
                                        'tipoConsulta' => '',
                                        'estadoConsulta' => '',
                                        'medio' => '',
                                        'usuini' => '',
                                        'usult' => '',
                                        'fechaNacimiento' => '',
                                        'color' => 'white',
                                        'hora' => $hora);
                $citasDia[$identificador]=$obj;
            }
               $identificador++;  
             
        } 
        echo json_encode($citasDia); 
    }

     /**
     * function verificaredicion
     *
     * Funcion consulta que el espacio en la cita no este utilizado por otra persona
     *
     */
    function verificaredicion() {
        $hora = $_REQUEST["horaSeleccionada"];
        $fecha = $_REQUEST["fechaSolicitada"];
        $id_sede = $_REQUEST["sedeSeleccionada"];
        $id_area = $_REQUEST["lugar"];
        
       $objeto_reserva = $this->cita_model->verificar_reserva($id_sede,$id_area,$fecha,$hora);

        if (isset($objeto_reserva->id_reserva)) {
            echo "Espacio Utilizado Por Otro Usuario";
        } else {
            $reserva = array(
                            'id_sede' => $id_sede,
                            'id_area' => $id_area,
                            'fecha' => $fecha,
                            'hora' => $hora,
                            'usuario' => $this->session->userdata('usuario'));
            $this->cita_model->crear_reserva($reserva);
            echo "OK";
        } 
    }

    /**
     * function eliminar_edicion
     *
     * Funcion consulta que elimina registros de la tabla cue_edicion
     *
     */
    function eliminar_edicion_tabla() {
        $this->cita_model->eliminar_reservas($this->session->userdata('id_sede'));
        echo "OK";

    }



    /**
     * function verificaredicion desde cache
     *
     * Funcion consulta que el espacio en la cita no este utilizado por otra persona
     *
     */
    function verificaredicion_cache() {
        // Load library
        
        // Lets try to get the key


        $hora = $_REQUEST["horaSeleccionada"];
        $fecha = $_REQUEST["fechaSolicitada"];
        $id_sede = $_REQUEST["sedeSeleccionada"];
        $id_area = $_REQUEST["lugar"];

        $key_cache = $fecha."_".$hora."_".$id_sede."_".$id_area;


        $CacheID = $key_cache;
 
        if(!$this->memcached_library->get($CacheID)) {
        
        $this->memcached_library->add($CacheID,'TRUE');
        
        } else {
        $result = $this->memcached_library->get($CacheID);
        }
        echo $result;

        

        
        
        $this->cache->save($key_cache, 'TRUE', 120);
       
       $objeto_reserva_cache = $this->cache->file->get($key_cache);
        var_dump($objeto_reserva_cache);
        if (isset($objeto_reserva_cache)) {
            echo "Espacio Utilizado Por Otro Usuario";
        } else {
            $this->cache->memcached->save($key_cache, 'TRUE', 120);
            echo "OK";
        } 
    }


    /**
     * function verificarcita
     *
     * Funcion consulta que el espacio en la cita no este asignada
     *
     */
    function verificarcita() {
        $hora = $_REQUEST["horaSeleccionada"];
        $fecha = $_REQUEST["fechaSolicitada"];
        $id_sede = $_REQUEST["sedeSeleccionada"];
        $id_area = $_REQUEST["lugar"];
        $row = $this->cita_model->verificar_cita($id_sede,$id_area,$fecha,$hora);
        if (isset($row->id_cita)) {
            $objetoTemporal = (object) array(  'nroDocumento' => $row->nro_documento,
                                                'primerNombre' => $row->primer_nombre,
                                                'segundoNombre' => $row->segundo_nombre,
                                                'primerApellido' => $row->primer_apellido,
                                                'segundoApellido' => $row->segundo_apellido,
                                                'observacion' =>  $row->observa,
                                                'tipoConsulta' => $row->tipo_consulta,
                                                'tipoViejo' => $row->tipo_viejo,
                                                'estadoConsulta' =>$row->estado,
                                                'medio' => $row->medios,
                                                'vista' => $row->vista,
                                                'fechaNacimiento' => $row->cumple,
                                                'hora' => $row->hora,
                                                'idUnicoCita' => $row->id_cita,
                                                'correo' => $row->correo,
                                                'usuini' => $row->usuini,
                                                'usult' => $row->usult,
                                                'celular' => $row->celular,
                                                'telefono' => $row->telefono);

            echo json_encode($objetoTemporal);
        } else {
            echo "OK";
        } 
    }

     /**
     * function curdcita
     *
     * Funcion crea la cita en la agenda de una sede
     *
     */
    function curdcita() {
        if($_POST["accion"] == 'insert'){ 
            $nroDocumento = $_REQUEST["nroDocumento"];
            $tipoDoc = $_REQUEST["tipoDoc"];
            $primerNombre = $_REQUEST["primerNombre"];
            $segundoNombre = $_REQUEST["segundoNombre"];
            $primerApellido = $_REQUEST["primerApellido"];
            $segundoApellido = $_REQUEST["segundoApellido"];
            $observacion = $_REQUEST["observacion"];
            $tipoConsulta = $_REQUEST["tipoConsulta"];
            $estadoConsulta = $_REQUEST["estadoConsulta"];
            $medio = $_REQUEST["medio"];
            $vista = $_REQUEST["vista"];
            $fechaNacimiento = $_REQUEST["fechaNacimiento"];
            $hora = $_REQUEST["horaSeleccionada"];
            $fechaSolicitada = $_REQUEST["fechaSolicitada"];
            $fechaCita = $_REQUEST["fechacita"]; 
            $celular = $_REQUEST["celular"];
            $telefono = $_REQUEST["telefono"];
            $sedeSeleccionada = $_REQUEST["sedeSeleccionada"];
            $id_cita = $_REQUEST["idUnicoCita"];
            $id_area = $_REQUEST["lugar"];
            $correo = $_REQUEST["correo"];
            $id_cita = $_REQUEST["idUnicoCita"];
            $edad = $_REQUEST["edad"];
            
            $cita = array(
                            'primer_nombre' => $primerNombre,
                            'segundo_nombre' => $segundoNombre,
                            'primer_apellido' => $primerApellido,
                            'segundo_apellido' => $segundoApellido,
                            'telefono' => $telefono,
                            'observa' => $observacion,
                            'hora' => $hora,
                            'estado' => $estadoConsulta,
                            'fecha' => $fechaCita,
                            'vista' => $vista, 
                            'cumple' => $fechaNacimiento,                         
                            'usult' => $this->session->userdata('usuario'),
                            'celular' => $celular,
                            'medios' => $medio,
                            'id_profe' => '',
                            'fecha_sol' => $fechaSolicitada,
                            'id_sede' => $sedeSeleccionada,
                            'id_area' => $id_area,
                            'tipo_consulta' => $tipoConsulta,
                            'correo' => $correo);
            if($id_cita == ''){
                $cita['usuini'] = $this->session->userdata('usuario');
                $cita['tipoDoc'] =$tipoDoc;
                $cita['nro_documento'] =$nroDocumento;
                $this->cita_model->crear_cita($cita);
            }else{
                $fechault = date('Y-m-d H:i:s', time());
                $cita['fecha_ult'] = $fechault;
                $cita['tipo_viejo'] = "";
                $this->cita_model->actualizar_cita($id_cita, $cita);
            }
            
            if($_POST["crearUsuario"] == 'true'){
                $pacienteBD = $this->paciente_model->get_paciente($nroDocumento,$tipoDoc);
                if(!isset($pacienteBD)){ 
                    $paciente = array(
                        'nombre1' => $primerNombre,
                        'nombre2' => $segundoNombre,
                        'apellido1' => $primerApellido,
                        'apellido2' => $segundoApellido,
                        'tel1' => $telefono,
                        'cumple' => $fechaNacimiento,
                        'celular' => $celular,
                        'email' => $correo,
                        'medio' => $medio,
                        'id_sede' => $sedeSeleccionada,
                        'edad' => $edad,
                        'ndoc' => $nroDocumento,
                        'tipoDoc' => $tipoDoc);
                $this->paciente_model->crear_paciente($paciente);
               } 
            }

            echo "OK";  
        }
        
        if($_POST["accion"] == 'move'){

            $fecha = $_REQUEST["fechaSolicitada"];
            $hora = $_REQUEST["horaSeleccionada"];
            $id_area = $_REQUEST["lugar"];
            $sedeSeleccionada = $_REQUEST["sedeSeleccionada"];
            $id_cita = $_REQUEST["idUnicoCita"];
            $cita = array(
                        'fecha' => $fecha,
                        'hora' => $hora,
                        'id_sede' => $sedeSeleccionada,
                        'id_area' => $id_area);
            $this->cita_model->actualizar_cita($id_cita, $cita);
            echo "OK";
        }

        if($_POST["accion"] == 'delete'){
            $id_cita = $_REQUEST["idUnicoCita"]; 
            $observacionEliminar = $_REQUEST["observacionEliminar"];
            $this->cita_model->eliminar_cita($id_cita,$observacionEliminar);
            echo "OK";
        }

        
    }

    
    /**
     * function eliminaredicion
     *
     * Funcion elimina la edicion del espacio utilizado por un usuario
     *
     */
    function eliminaredicion() {
        $hora = $_REQUEST["horaSeleccionada"];
        $fecha = $_REQUEST["fechaSolicitada"];
        $id_sede = $_REQUEST["sedeSeleccionada"];
        $id_area = $_REQUEST["lugar"];   
        $this->cita_model->eliminar_reserva($id_sede,$id_area,$fecha,$hora);
        echo "OK";
    } 


    /**
     * function buscarcitas
     *
     * Funcion buscarcitas busca la cita de un usuario por nombre, cedula , correo
     *
     */
    function buscarcitas() {

        $id_sede = $_REQUEST["sede"];
        $fechaFinal = $_REQUEST["fechaFinal"];
        $fechaInicio = $_REQUEST["fechaInicio"];
        $nombre = $_REQUEST["primerNombreBusqueda"];
        $documento = $_REQUEST["nroDocumentoBusqueda"];
        $correo = $_REQUEST["correoBusqueda"]; 
        $celular = $_REQUEST["celBusqueda"]; 
        $telefono = $_REQUEST["telBusqueda"]; 
        
        $resultado_citas_paciente = $this->cita_model->get_citas_paciente($fechaInicio,$fechaFinal,$nombre,
                                                            $correo,$documento,$celular,$telefono);
        
        if(isset($resultado_citas_paciente)){
            $citasEncontradas = array();
            foreach ($resultado_citas_paciente as $row) {
                $objetoTemporal = (object) array(   'hora' => $row->hora,
                                                    'fecha' => $row->fecha,
                                                    'idArea' => $row->id_area,
                                                    'idsede' => $row->id_sede,
                                                    'nroDocumento' => $row->nro_documento,
                                                    'primerNombre' => $row->primer_nombre,
                                                    'segundoNombre' => $row->segundo_nombre,
                                                    'primerApellido' => $row->primer_apellido,
                                                    'segundoApellido' => $row->segundo_apellido,
                                                    'observacion' => $row->observa,
                                                    'tipoConsulta' => $row->tipo_consulta,
                                                    'tipoViejo' => $row->tipo_viejo,
                                                    'estadoConsulta' =>$row->estado
                                                    );
                    $citasEncontradas[] = $objetoTemporal;
                }
            echo json_encode($citasEncontradas);
        }else{
            echo "NO_DATOS";
        }    
    } 

     /**
     * function buscarcitas
     *
     * Funcion buscarcitas_eliminadas busca citas eliminadas dentro de un rango de fechas
     *
     */
    function buscarcitas_eliminadas() {

        $id_sede = $_REQUEST["sede"];
        $fechaFinal = $_REQUEST["fechaFinal"];
        $fechaInicio = $_REQUEST["fechaInicio"];
        
        $resultado_citas_eliminadas = $this->cita_model->get_citas_eliminadas($fechaInicio,$fechaFinal);
        
        if(isset($resultado_citas_eliminadas)){
            $citasEncontradas = array();
            foreach ($resultado_citas_eliminadas as $row) {
                $objetoTemporal = (object) array(   'hora' => $row->hora,
                                                    'fecha' => $row->fecha,
                                                    'fecha_ult' => $row->fecha_ult,
                                                    'usult' => $row->usult,
                                                    'idArea' => $row->id_area,
                                                    'idsede' => $row->id_sede,
                                                    'lugar' => $row->nombre_corto,
                                                    'nombre_sede' => $row->nombre_sede,
                                                    'nroDocumento' => $row->nro_documento,
                                                    'primerNombre' => $row->primer_nombre,
                                                    'segundoNombre' => $row->segundo_nombre,
                                                    'primerApellido' => $row->primer_apellido,
                                                    'segundoApellido' => $row->segundo_apellido,
                                                    'observacion' => $row->observa,
                                                    'tipoConsulta' => $row->tipo_consulta,
                                                    'estadoConsulta' =>$row->estado
                                                    );
                    $citasEncontradas[] = $objetoTemporal;
                }
            echo json_encode($citasEncontradas);
        }else{
            echo "NO_DATOS";
        }    
    } 
    


     /**
     * function export_excel
     *
     * Funcion export_excel exporta a excel las citas de un dia 
     *
     */
    function export_excel() {
        $fechaIni = $_REQUEST["fechaIni"];
        $fechaFin = $_REQUEST["fechaFin"];

        $resultadocitas = $this->cita_model->get_citas_excel($fechaIni,$fechaFin);


        $fields = array("lugar","fecha","hora","tipoDoc","nro_documento","nombre","Apellidos","fecha_sol",
                        "pvez","usuini","usult","tipo_consulta","Tipo Anterior","observa","estado",
                        "telefono","celular","correo","sede");

        $nombre_archivo="citas_".$fechaIni."-".$fechaFin;
        to_excel($fields, $resultadocitas , $nombre_archivo);    
    } 


    function impresion_agenda(){
        $this->load->library('mydompdf');
        $fecha =  $_REQUEST["fecha"];
        $id_sede =$_REQUEST["sede"];
        $id_area =$_REQUEST["lugar"];
        $fecha_date = new DateTime($fecha);
        $resultadocitas = $this->cita_model->get_citas($fecha,$id_area,$id_sede);
        $data["empresa"] = $this->administracion_model->get_datos_empresa();
        $data["citas"] = $this->cita_model->get_citas($fecha,$id_area,$id_sede);
        $data["lugar"] = $this->cita_model->get_lugar_sede($id_sede,$id_area);
        $data["fecha"] = $fecha_date;
        $data["sede"] = $this->administracion_model->get_sede($id_sede);
        $html = $this->load->view('aplicacion/pdf/citas_pdf', $data, true);
        $this->mydompdf->load_html($html);
        $this->mydompdf->render();
        $this->mydompdf->stream("Citas_".$fecha.".pdf", array("Attachment" => false));     
    }
}
