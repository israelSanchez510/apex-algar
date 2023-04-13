<?php
$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
$ext=$_POST['ext'];
session_start();
$_SESSION['USUARIO']=$usuario;
$_SESSION['EXT']=$ext;

include('db.php');
$conexion=conn();
$consulta="SELECT * FROM apex_login  where user='$usuario' and password ='$contraseña'";
$qry = $conexion->query($consulta);
if ($conexion->affected_rows > 0) {
    while ($reg = $qry->fetch_assoc()) {
        $_SESSION["ID_USUARIO"]=$reg['id'];
        $_SESSION['sflag']=$reg['tipo'];
    }
}

$resultado = mysqli_query($conexion,$consulta);
$fila = mysqli_num_rows($resultado);

if($_SESSION['sflag']==1){
    header("location:inicio.php");
}
else if($_SESSION['sflag']==2){
    header("location:dashboard.php");
}
else{
    header("location:index.php?e=1");
    session_destroy();
}
?>