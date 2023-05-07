<?php
function conn()
{
    //$conexion = mysqli_connect("localhost", "apex_user", "4p3x@4dm1n", "apex");
    $conexion = mysqli_connect("10.220.0.2", "apex_user", "4p3x@4dm1n", "apex");
    return $conexion;
}
?>