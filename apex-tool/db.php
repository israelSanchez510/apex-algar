<?php
function conn()
{
    $conexion = mysqli_connect("10.220.0.2", "usuarioapex", "ap3x@2023", "apex");
    //$conexion = mysqli_connect("localhost", "root", "fernanda123", "apex");

    return $conexion;
}
?>