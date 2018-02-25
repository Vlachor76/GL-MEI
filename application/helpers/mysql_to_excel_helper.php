<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Author: Derek Allard
*/

function to_excel($fields, $resultado , $nombre_archivo)
{
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$nombre_archivo.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    ?>
    <table >
    <tr>
    <?php  foreach($fields as $field): ?>
            <td><?=$field?></td>
    <?php endforeach;?>
    </tr>
    
    <?php  foreach($resultado as $row): ?>
    <tr>
        <?php  foreach($row as $value): ?>
            <td><?=$value?></td>
        <?php endforeach;?>    
    </tr>
    <?php endforeach;?>
    

    </table>

    <?php } ?>