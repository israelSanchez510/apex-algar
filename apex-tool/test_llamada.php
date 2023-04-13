<?php
include("../pbx-api/apex-class.php");
include("sesion.php");
$ext = $_SESSION['EXT'];
$numero = $_POST["num"];
//$ext 	     = '1003';
//$numero      = '3023336612';
$mysqli = @new mysqli('10.220.0.2', 'apex_user', '4p3x@4dm1n', 'apex');
if ($mysqli->connect_error) {
    $respuesta['success'] = false;
    $respuesta['description'] = 'Connection BD error';
} else {
    $mysqli->set_charset("utf8");
    $query = "insert into apex_calls(phone_form,create_form,ext_pbx,channel)values('{$numero}',now(),'{$ext}',1)";
    $mysqli->query($query);
    if ($mysqli->errno == 0) {
        $id_marcado = $mysqli->insert_id;
        #Generar llamada API-PBX
        //echo "$ext,$id_marcado,$numero";
        $respuesta['description'] = marcar_numero($ext, $id_marcado, $numero);
        if (trim($respuesta['description']) == "Originate successfully queued") {
            #Enlazado al agente llamada al agente
            $respuesta['success'] = true;
            $respuesta['description'] = '<input style="display:none" name="idcallform" id="idcallform" value=' . $id_marcado . ' class="w3-input">';
            $respuesta['id_call'] = $id_marcado;
        } else {
            #Error al enlazar llamada al agente
            $respuesta['success'] = false;
            $qu = "update apex_calls set estado_pbx = '{$respuesta['description']}' where id_call = '{$id_marcado}'";
            $mysqli->query($qu);
            $respuesta['description'] = '<br><strong class="txtrojo">No se pudo enlazar la llamada</strong><br>';
        }
    } else {
        $respuesta['success'] = false;
        $respuesta['description'] = 'Insert BD error';
    }
}

//echo "<pre>";
//$respuesta['success'] = true;
//$respuesta['description'] ='<input style="display:none" name="idcall" value=2 class="w3-input">';
print_r(json_encode($respuesta));
//echo "</pre>";
exit;
?>