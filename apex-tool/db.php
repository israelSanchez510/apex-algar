<?php
function conn()
{
    $conexion = mysqli_connect("localhost", "apex_user", "4p3x@4dm1n", "apex");
    return $conexion;
}
?>