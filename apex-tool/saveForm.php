<?php
include("sesion.php");
$email = $_POST['url'];
$estado = $_POST['estado'];
$distribuidor = $_POST['distribuidor'];
$marca = $_POST['marca'];
$medio = $_POST['medio'];
$sku = $_POST['SKU'];
$precio = $_POST['precio'];
$posicionSATA = $_POST['posicSata'];
$promocion = $_POST['promocion'];
$observacion = $_POST['observacion'];
$idUsuario = $_SESSION["ID_USUARIO"];
$mysqli = @new mysqli('10.220.0.2', 'apex_user', '4p3x@4dm1n', 'apex');
if ($mysqli->connect_error) {
    $respuesta['success'] = false;
    $respuesta['description'] = 'Connection BD error';
} else {
    if ($estado == "Exitosa") {
        if (!$precio==""||!$precio==null) {
            $precioSinIVA=(float)$precio*0.84;
        }
        else{
            $precioSinIVA="";
        }
        if (!isset($_POST['idcallform'])) {
            $insertar = "INSERT INTO apex_form (url_pagina, status, id_distribuitor, channel_id, marca, id_sku, precio, posicion_sata,promocion,descripcion, id_user, create_form, precio_sin_iva)" .
                " VALUES ('$email', '$estado', '$distribuidor',$medio,'$marca', '$sku','$precio','$posicionSATA','$promocion','$observacion', '$idUsuario', now(),'$precioSinIVA' )";
        } else {
            $idcallform = $_POST['idcallform'];
            $insertar = "INSERT INTO apex_form (url_pagina, status, id_distribuitor, channel_id, marca, id_sku, precio, posicion_sata,promocion,descripcion, id_user, create_form, call_id, precio_sin_iva)" .
                " VALUES ('$email', '$estado', '$distribuidor','$medio','$marca', '$sku','$precio','$posicionSATA','$promocion','$observacion', '$idUsuario', now(), '$idcallform','$precioSinIVA')";
        }
    } else {
        if (!isset($_POST['idcallform'])) {
            $insertar = "INSERT INTO apex_form (url_pagina, status,  channel_id,  id_user, create_form )" .
                " VALUES ('$email', '$estado','$medio', '$idUsuario', now())";
        } else {
            $idcallform = $_POST['idcallform'];
            $insertar = "INSERT INTO apex_form (url_pagina, status,  channel_id,  id_user, create_form, call_id )" .
                " VALUES ('$email', '$estado','$medio', '$idUsuario', now(), '$idcallform')";
        }
    }
    $mysqli->set_charset("utf8");
    $mysqli->query($insertar);
    if ($mysqli->errno == 0) {
        $respuesta['success'] = true;
        $respuesta['description'] = 'Se agrego correctamente';
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