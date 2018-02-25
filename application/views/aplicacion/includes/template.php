<?php
/**
 * Autor:       
 * Email:       
 * Web:         
 * @package     
 * @author      
 * @version     
 * @copyright   
 */
?>
<?php $this->load->view('aplicacion/includes/header'); ?>
<?php
if (!isset($output)) {
    $this->load->view($main_content);
} else {
    $this->load->view($main_content, $output);
}
/*
$this->load->view('administrador/includes/footer');
*/