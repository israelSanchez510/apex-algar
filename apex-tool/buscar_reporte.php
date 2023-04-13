<?php
include("sesion.php");
$ext = $_SESSION['EXT'];
$estatus = $_POST["num"];
$canal = $_POST["canal"];
$mysqli = @new mysqli('10.220.0.2', 'apex_user', '4p3x@4dm1n', 'apex');
if ($mysqli->connect_error) {
    $respuesta['success'] = false;
    $respuesta['description'] = 'Connection BD error';
} else {
    $valor = "";
    if ($canal!="") {
        $valor = "and f.channel_id =" . $canal;
    }
    if ($estatus == "No exitosa") {
        $respuesta['success'] = true;
        $tabla =
            '<table class="w3-table w3-striped w3-bordered" style=" display: block; overflow-x: scroll; width: 100%">
            <tr class="w3-hover-blue fnegro">
                <th>Telefono/Url Pagina</th>
                <th>Estatus</th>
                <th>Nombre canal</th>
                <th>Fecha</th>

            </tr>';
        $concatenar = "";
        $qry = $mysqli->query("select f.url_pagina, f.status, c.name as nameC,  f.create_form from apex_form f inner join apex_channel c "
            . "on f.channel_id  = c.id_channel where f.status ='No exitosa' " . $valor . ";");
        if ($mysqli->affected_rows > 0) {
            while ($reg = $qry->fetch_assoc()) {
                $concatenar = $concatenar .
                    "<tr>
                        <td>" .
                    $reg['url_pagina'] .
                    "</td>
                        <td>" .
                    $reg['status'] .
                    "</td>
                        <td>" .
                    $reg['nameC'] .

                    "</td>
                        <td>" .
                    $reg['create_form'] .
                    "</td>
                    </tr>";

            }
        }
        $respuesta['description'] = $tabla . $concatenar . "</table>";
    } else {
        $respuesta['success'] = true;
        $tabla =
            '<table class="w3-table w3-striped w3-bordered" style=" display: block; overflow-x: scroll; width: 100%">
            <tr class="w3-hover-blue fnegro" >
                <th>Telefono/Url Pagina</th>
                <th>Estatus</th>
                <th>Nombre distribuidor</th>
                <th>Nombre canal</th>
                <th>Marca</th>
                <th>SKU</th>
                <th>Descripcion SKU</th>
                <th>BRAND</th>
                <th>Nombre mercado colombia</th>
                <th>Precio</th>
                <th>Posicion SATA</th>
                <th>Promocion</th>
                <th>Observacion</th>
                <th>Fecha</th>
            </tr>';
        $concatenar = "";
        $qry = $mysqli->query("SELECT f.url_pagina, f.status, d.name AS nameS, c.name as nameC, f.marca, s.sku, s.descripcion, s.brand, s.nombre_mercado_col," .
            " f.precio, f.posicion_sata, f.promocion, f.descripcion, f.create_form from apex_form f " .
            "inner join apex_distribuitor d on f.id_distribuitor = d.id " .
            "inner join apex_channel c on f.channel_id  = c.id_channel inner join apex_sku s on f.id_sku = s.id where f.status ='Exitosa' " . $valor . "; ");
        if ($mysqli->affected_rows > 0) {
            while ($reg = $qry->fetch_assoc()) {
                if ($reg['promocion'] == 1) {
                    $prom = "Si";
                } else {
                    $prom = "No";
                }

                $concatenar = $concatenar . "<tr>
                        <td>" .
                    $reg['url_pagina'] . "                            
                        </td>
                        <td>" .

                    $reg['status'] .

                    "</td>
                        <td>" .

                    $reg['nameS'] .

                    "</td>
                        <td>" .

                    $reg['nameC'] .

                    "</td>
                        <td>" .

                    $reg['marca'] .

                    "</td>
                        <td>" .

                    $reg['sku'] .

                    "</td>
                        <td>" .
                    $reg['descripcion'] .

                    "</td>
                        <td>" .
                    $reg['brand'] .

                    "</td>
                        <td>" .
                    $reg['nombre_mercado_col'] .

                    "</td>
                        <td>" .

                    $reg['precio'] .

                    "</td>
                        <td>" .

                    $reg['posicion_sata'] .

                    "</td>
                        <td>" .

                    $prom .

                    "</td>

                        <td>" .
                    $reg['descripcion'] .

                    "</td>
                        <td>" .

                    $reg['create_form'] .

                    "</td>
                    </tr>";

            }
        }
        $respuesta['description'] = $tabla . $concatenar . "</table>";
    }
}
$respuesta['valor']=$valor;

//echo "<pre>";
//$respuesta['success'] = true;
//$respuesta['description'] ='<input style="display:none" name="idcall" value=2 class="w3-input">';
print_r(json_encode($respuesta));
//echo "</pre>";
exit;
?>