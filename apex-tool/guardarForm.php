<?php
include('db.php');
include("sesion.php");
$conexion=conn();
$email = $_POST['url'];
$estado = $_POST['estado'];
$distribuidor = $_POST['distribuidor'];
$marca = $_POST['marca'];
$medio=$_POST['medio'];
$sku=$_POST['SKU'];
$precio=$_POST['precio'];
$posicionSATA=$_POST['posicSata'];
$promocion=$_POST['promocion'];
$observacion=$_POST['observacion'];
$idUsuario = $_SESSION["ID_USUARIO"];
if($estado=="Exitosa") {
    if (!$precio==""||!$precio==null) {
        $precioSinIVA=(float)$precio*0.84;
    }
    else{
        $precioSinIVA="";
    }
    if(!isset($_POST['idcallform'])){
        $insertar = "INSERT INTO apex_form (url_pagina, status, id_distribuitor, channel_id, marca, id_sku, precio, posicion_sata,promocion,descripcion, id_user, create_form, precio_sin_iva)" .
            " VALUES ('$email','$estado','$distribuidor','$medio','$marca','$sku','$precio','$posicionSATA','$promocion','$observacion', '$idUsuario', now(),'$precioSinIVA')";
    }
    else{
        $idcallform=$_POST['idcallform'];
        $insertar = "INSERT INTO apex_form (url_pagina, status, id_distribuitor, channel_id, marca, id_sku, precio, posicion_sata,promocion,descripcion, id_user, create_form, call_id, precio_sin_iva)" .
            " VALUES ('$email', '$estado', '$distribuidor','$medio','$marca','$sku','$precio','$posicionSATA','$promocion','$observacion', '$idUsuario', now(), '$idcallform','$precioSinIVA')";
    }
}
else{
    if(!isset($_POST['idcallform'])){
        $insertar = "INSERT INTO apex_form (url_pagina, status,  channel_id,  id_user, create_form )" .
            " VALUES ('$email', '$estado','$medio', '$idUsuario', now())";
    }
    else{
        $idcallform=$_POST['idcallform'];
        $insertar = "INSERT INTO apex_form (url_pagina, status,  channel_id,  id_user, create_form, call_id )" .
            " VALUES ('$email', '$estado','$medio', '$idUsuario', now(), '$idcallform')";
    }
}
echo $insertar;
$query = mysqli_query($conexion, $insertar);
if($query){
    header("location:inicio.php");
}
else{
    header("location:inicio.php?e=1");
}

?>