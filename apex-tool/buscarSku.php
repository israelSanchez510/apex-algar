<?php
include("sesion.php");
$ext = $_SESSION['EXT'];
$marca = $_POST["num"];
$mysqli = @new mysqli('10.220.0.2', 'apex_user', '4p3x@4dm1n', 'apex');
if ($mysqli->connect_error) {
    $respuesta['success'] = false;
    $respuesta['description'] = 'Connection BD error';
} else {
    $valor = "";
    if ($marca!="") {
        $respuesta['success'] = true;
        $tabla =
            '<option value=""></option>';
        $concatenar = "";
        $descripcion ="";
        $nombreMercado = "";
        $sku = "";
        $qry = $mysqli->query("select * from apex_sku where brand ='".$marca."'");
        if ($mysqli->affected_rows > 0) {
            while ($reg = $qry->fetch_assoc()) {
                $descripcion= $descripcion .'<option value="'. $reg['id']. '">'.
                    $reg['descripcion'].
                    '</option>';
                $concatenar = $concatenar .'<option value="'. $reg['id']. '">'.
                     $reg['brand'].
                '</option>';
                $nombreMercado = $nombreMercado .'<option value="'. $reg['id']. '">'.
                    $reg['nombre_mercado_col'].
                    '</option>
';
                $sku = $sku .'<option value="'. $reg['id']. '">'.
                    $reg['sku'].
                    '</option>';
                            }
                        }
        $respuesta['description'] = $tabla . $descripcion ;
        $respuesta['brand'] = $tabla . $concatenar ;
        $respuesta['nombreMercado'] = $tabla . $nombreMercado ;
        $respuesta['sku'] = $tabla . $sku ;



    }
}
/*echo $respuesta['description'];
echo json_encode($respuesta['description']);*/
//echo "select * from apex_sku where brand ='".$marca."'";
//$respuesta['valor']=$imprimir;
//echo $respuesta['valor'];
/*echo json_encode($respuesta['description']);
echo "Hola";*/
print_r(json_encode($respuesta));
exit;
?>