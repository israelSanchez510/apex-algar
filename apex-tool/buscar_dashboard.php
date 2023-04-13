<?php
include("sesionC.php");
$reporte=$_POST["valor"];
$ext = $_SESSION['EXT'];


$mysqli = @new mysqli('10.220.0.2', 'apex_user', '4p3x@4dm1n', 'apex');
if ($mysqli->connect_error) {
    $respuesta['success'] = false;
    $respuesta['description'] = 'Connection BD error';
} else {
    if ($reporte==1) {
        $distribuidor = $_POST["distribuidor"];
        $sku = $_POST["SKU"];
        $fecha1 = $_POST["fecha1"];
        $fecha2 = $_POST["fecha2"];
        $nombreM = $_POST["nombreMercado"];
        $valor = "";
        $fechas= "";
        if ($distribuidor!="") {
            $valor = $valor." and f.id_distribuitor =" . $distribuidor;
        }if ($sku!="") {
            $valor = $valor." and s.id =" . $sku;
        }if ($nombreM!="") {
            $valor = $valor." and s.id =" . $nombreM;
        }
        if ($fecha1!="") {
            $valor =$valor. " and create_form >='" . $fecha1."'";
            $fechas = $fechas." and create_form >='" . $fecha1."'";
        }
        if ($fecha2!="") {
            $valor = $valor." and create_form <='" . $fecha2. " 23:59'";
            $fechas = $fechas." and create_form <='" . $fecha2. " 23:59'";

        }
        $respuesta['success'] = true;
        $tabla =
            '<table class="w3-table w3-striped w3-bordered  w3-white"
               style=" display: block; overflow: scroll; height: 350px; width: 100%">
            <tr class="w3-hover-blue fnegro">
                <th>Nombre Mercado Colombia</th>
<!--                <th>Cantidad</th>-->
                <th>Precio sin IVA</th>
                <th>Dif % to Sata</th>
                <th>Dif $ to Sata</th>
                <th>Dif % to promedio</th>
                <th>Dif $ to promedio</th>
            </tr>';
        $concatenar = "";
        $qry = $mysqli->query("SELECT s.id as idSku,  " .
            " s.nombre_mercado_col, f.precio " .
            " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
            "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
            "where f.status ='Exitosa'".$valor." order by create_form ;");
        if ($mysqli->affected_rows > 0) {
            while ($reg = $qry->fetch_assoc()) {
                $concatenar = $concatenar .
                    "<tr>
                        <td>" .
                    $reg['nombre_mercado_col'] .
                    "</td>";
                $query =
                    $mysqli->query("SELECT  f.marca,s.id as idSku, s.sku, " .
                        "  s.nombre_mercado_col, f.precio, f.posicion_sata,  date(f.create_form) as fechaC," .
                        " f.create_form from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
                        "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
                        "where f.status ='Exitosa' and s.nombre_mercado_col='" . $reg['nombre_mercado_col'] . "' order by create_form ;");
                if ($mysqli->affected_rows > 0) {
                    $cantidad=0;
                    $cantidadProm=0;
                    $precioSata=0.0;
                    $precioProm=0.0;

                    while ($rog = $query->fetch_assoc()) {
                        $precioProm=$precioProm+$rog["precio"];
                        $cantidadProm++;
                        if ($rog["marca"]=="SATA"){
                            $precioSata=$precioSata+$rog["precio"];
                            $cantidad++;
                        }

                    }
                    //echo "<td>" . $cantidad . "</td>";
                    $difSata=0;
                    $difSataM=0;
                    if($cantidad!=0) {
                        $precioSata = $precioSata / $cantidad;
                        $difSata= (($precioSata-$reg["precio"])/$reg["precio"])*100;
                        $difSataM=$precioSata-$reg["precio"];
                    }
                    $difProm=0;
                    $difPromM=0;
                    if ($cantidadProm!=0){
                        $precioProm = $precioProm / $cantidadProm;
                        $difProm= (($precioProm-$reg["precio"])/$reg["precio"])*100;
                        $difPromM=$precioProm-$reg["precio"];
                    }
                    $concatenar=$concatenar. "<td>$ ".$reg["precio"]."</td><td>".number_format($difSata, 2)." %</td><td>$ ".
                        number_format($difSataM,2)."</td><td>".number_format($difProm, 2)." %</td><td>$ ".
                        number_format($difPromM,2)."</td>";

                } else {
                    $concatenar=$concatenar."
                        <td>$ 0.0</td>
                        <td>0 %</td>
                        <td>$ 0</td>
                        <td>0 %</td>
                        <td>$ 0</td>";
                }

                $concatenar = $concatenar.'</tr>';

            }
        }
        $respuesta['description'] = $tabla . $concatenar . "</table>";
    }
    if ($reporte==2){
        $distribuidor = $_POST["distribuidor"];
        $sku = $_POST["SKU"];
        $fecha1 = $_POST["fecha1"];
        $fecha2 = $_POST["fecha2"];
        $nombreM = $_POST["nombreMercado"];
        $marca = $_POST["marca"];

        $valor = "";
        $fechas= "";
        if ($distribuidor!="") {
            $valor = $valor." and f.id_distribuitor =" . $distribuidor;
        }
        if ($sku!="") {
            $valor = $valor." and s.id =" . $sku;
        }
        if ($nombreM!="") {
            $valor = $valor." and s.id =" . $nombreM;
        }
        if ($fecha1!="") {
            $valor =$valor. " and create_form >='" . $fecha1."'";
            $fechas = $fechas." and create_form >='" . $fecha1."'";
        }
        if ($fecha2!="") {
            $valor = $valor." and create_form <='" . $fecha2. " 23:59'";
            $fechas = $fechas." and create_form <='" . $fecha2. " 23:59'";

        }
        if ($marca!="") {
            $valor = $valor." and marca =='" . $marca."'";

        }
        $qry = $mysqli->query("SELECT f.marca, s.id as idSku, s.sku, " .
            " s.brand, s.nombre_mercado_col, f.precio " .
            " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
            "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
            "where f.status ='Exitosa' " .$valor. " order by create_form ;");
        if ($mysqli->affected_rows > 0) {
            $sata=0;
            $lufkin=0;
            $stanley=0;
            $irwin=0;
            $contsata=0;
            $contlufkin=0;
            $contstanley=0;
            $contirwin=0;
            while ($reg = $qry->fetch_assoc()) {

                if ($reg["marca"]=="SATA"){
                    $sata=$sata+$reg["precio"];
                    $contsata++;
                }
                if ($reg["marca"]=="IRWIN"){
                    $irwin=$irwin+$reg["precio"];
                    $contirwin++;
                }
                if ($reg["marca"]=="LUFKIN"){
                    $lufkin=$lufkin+$reg["precio"];
                    $contlufkin++;
                }
                if ($reg["marca"]=="STANLEY"){
                    $stanley=$stanley+$reg["precio"];
                    $contstanley++;
                }
            }
            if ($contsata!=0) {
                $sata = $sata / $contsata;
            }
            if ($contlufkin!=0) {
                $lufkin = $lufkin / $contlufkin;
            }
            if ($contstanley!=0){
                $stanley=$stanley/$contstanley;
            }
            if ($contirwin!=0){
                $irwin=$irwin/$contirwin;
            }
            $respuesta['success'] = true;
            $respuesta['sata'] = $sata;
            $respuesta['lufkin'] = $lufkin;
            $respuesta['stanley'] = $stanley;
            $respuesta['irwin'] = $irwin;
            $respuesta['query']= "SELECT f.marca, s.id as idSku, s.sku, " .
                " s.brand, s.nombre_mercado_col, f.precio " .
                " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
                "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
                "where f.status ='Exitosa' " .$valor. " order by create_form ;";
        }
    }
    if($reporte==3){
        $marcas=array("SATA", "LUFKIN", "STANLEY", "IRWIN");
        $distribuidor = $_POST["distribuidor"];
        $sku = $_POST["SKU"];
        $fecha1 = $_POST["fecha1"];
        $fecha2 = $_POST["fecha2"];
        $nombreM = $_POST["nombreMercado"];
        $valor = "";
        $fechas= "";
        if ($distribuidor!="") {
            $valor = $valor." and f.id_distribuitor =" . $distribuidor;
        }if ($sku!="") {
            $valor = $valor." and s.id =" . $sku;
        }if ($nombreM!="") {
            $valor = $valor." and s.id =" . $nombreM;
        }
        if ($fecha1!="") {
            $valor =$valor. " and create_form >='" . $fecha1."'";
            $fechas = $fechas." and create_form >='" . $fecha1."'";
        }
        if ($fecha2!="") {
            $valor = $valor." and create_form <='" . $fecha2. " 23:59'";
            $fechas = $fechas." and create_form <='" . $fecha2. " 23:59'";

        }
        $respuesta['success'] = true;
        $tabla =
            '<table class="w3-table w3-striped w3-bordered  w3-white"
               style=" display: block; overflow: scroll; height: 305px; width: 100%">
            <tr class="w3-hover-black fnegro">
                <th style="width: 20%">Marca</th>
<!--                <th>Cantidad</th>-->
                <th style="width: 20%">Cantidad</th>
                <th style="width: 20%">%</th>
                <th style="width: 20%">Precio con IVA</th>
                <th style="width: 20%">Precio sin IVA</th>
            </tr>';
        $concatenar = "";
        for ($i = 0; $i <= 3; $i++) {
        $qry = $mysqli->query("SELECT s.id as idSku, f.marca, " .
            " s.nombre_mercado_col, f.precio, f.precio_sin_iva " .
            " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
            "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
            "where f.status ='Exitosa'".$valor." order by create_form ;");
        if ($mysqli->affected_rows > 0) {
                $concatenar = $concatenar .
                    "<tr class='w3-hover-blue'>
                        <td onclick='seleccionar(\"".$marcas[$i]."\")'>" .
                    $marcas[$i] .
                    "   </td>";
                $contador=0;
                $sinIVA=0;
                $conIVA=0;
                while ($reg = $qry->fetch_assoc()) {
                    if($reg['marca']==$marcas[$i]){
                        $contador++;
                        $sinIVA=$sinIVA+$reg["precio_sin_iva"];
                        $conIVA= $conIVA+$reg["precio"];
                    }
                }
                if ($contador!=0) {
                    $sinIVA = $sinIVA / $contador;
                    $conIVA = $conIVA / $contador;
                }
                $porcentaje=$contador*100/$mysqli->affected_rows;
                $concatenar = $concatenar . "<td onclick='seleccionar(\"".$marcas[$i]."\")'>" . $contador . "</td>".
                    "<td onclick='seleccionar(\"".$marcas[$i]."\")'>" . number_format($porcentaje,2) .
                    " %</td><td onclick='seleccionar(\"".$marcas[$i]."\")'>$ " .
                    number_format($conIVA,2). "</td><td onclick='seleccionar(\"".$marcas[$i]."\")'>$" .
                    number_format($sinIVA,2) . "</td>";

                $concatenar = $concatenar . '</tr>';
            }
        }
        $respuesta['query']="SELECT s.id as idSku, f.marca, " .
            " s.nombre_mercado_col, f.precio, f.precio_sin_iva " .
            " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
            "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
            "where f.status ='Exitosa'".$valor." order by create_form ;";
        $respuesta['description'] = $tabla . $concatenar . "</table>";
    }
    if($reporte==4){
        $distribuidor = $_POST["distribuidor"];
        $sku = $_POST["SKU"];
        $fecha1 = $_POST["fecha1"];
        $fecha2 = $_POST["fecha2"];
        $nombreM = $_POST["nombreMercado"];
        $marca = $_POST["marca"];
        $valor = "";
        $fechas= "";
        if ($distribuidor!="") {
            $valor = $valor." and f.id_distribuitor =" . $distribuidor;
        }if ($sku!="") {
            $valor = $valor." and s.id =" . $sku;
        }if ($nombreM!="") {
            $valor = $valor." and s.id =" . $nombreM;
        }
        if ($fecha1!="") {
            $valor =$valor. " and create_form >='" . $fecha1."'";
            $fechas = $fechas." and create_form >='" . $fecha1."'";
        }
        if ($fecha2!="") {
            $valor = $valor." and create_form <='" . $fecha2. " 23:59'";
            $fechas = $fechas." and create_form <='" . $fecha2. " 23:59'";

        }
        $respuesta['success'] = true;
        $tabla =
            '<table class="w3-table w3-striped w3-bordered  w3-white"
               style=" display: block; overflow: scroll; height: 305px; width: 100%">
            <tr class="w3-hover-black fnegro">
                <th style="width: 20%">Nombre mercado colombia</th>
                <!--<th style="width: 20%">Cantidad</th>
                <th style="width: 20%">%</th>-->
                <th style="width: 20%">Precio con IVA</th>
                <th style="width: 20%">Precio sin IVA</th>
            </tr>';
        $concatenar = "";
            $qry = $mysqli->query("SELECT s.id as idSku, f.marca, " .
                " s.nombre_mercado_col, f.precio, f.precio_sin_iva " .
                " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
                "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
                "where f.status ='Exitosa'".$valor." order by create_form ;");
            if ($mysqli->affected_rows > 0) {
                $contador=0;
                $sinIVA=0;
                $conIVA=0;
                while ($reg = $qry->fetch_assoc()) {
                    if($reg['marca']==$marca)
                    $concatenar = $concatenar .
                        "<tr class='w3-hover-blue'>
                            <td>" .
                                $reg['nombre_mercado_col'] .
                            " </td><td>" .
                        $reg['precio'] .
                        " </td><td>" .
                        $reg['precio_sin_iva'] .
                        " </td></tr>";
                    }
                }
            $respuesta['description'] = $tabla . $concatenar . "</table>";
    }
    if ($reporte==5){
        $distribuidor = $_POST["distribuidor"];
        $sku = $_POST["SKU"];
        $fecha1 = $_POST["fecha1"];
        $fecha2 = $_POST["fecha2"];
        $nombreM = $_POST["nombreMercado"];
        $marca = $_POST["marca"];

        $valor = "";
        $fechas= "";
        if ($distribuidor!="") {
            $valor = $valor." and f.id_distribuitor =" . $distribuidor;
        }
        if ($sku!="") {
            $valor = $valor." and s.id =" . $sku;
        }
        if ($nombreM!="") {
            $valor = $valor." and s.id =" . $nombreM;
        }
        if ($fecha1!="") {
            $valor =$valor. " and create_form >='" . $fecha1."'";
            $fechas = $fechas." and create_form >='" . $fecha1."'";
        }
        if ($fecha2!="") {
            $valor = $valor." and create_form <='" . $fecha2. " 23:59'";
            $fechas = $fechas." and create_form <='" . $fecha2. " 23:59'";

        }
        if ($marca!="") {
            $valor = $valor." and marca =='" . $marca."'";

        }
        $qry = $mysqli->query("SELECT f.marca, s.id as idSku, s.sku, " .
            " s.brand, s.nombre_mercado_col, f.precio, f.posicion_sata " .
            " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
            "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
            "where f.status ='Exitosa' and f.marca='SATA' " .$valor. " order by create_form ;");
        if ($mysqli->affected_rows > 0) {
            $uno=0;
            $dos=0;
            $tres=0;
            $cuatro=0;
            while ($reg = $qry->fetch_assoc()) {

                if ($reg["posicion_sata"]==1){
                    $uno++;
                }
                if ($reg["posicion_sata"]==2){
                    $dos++;
                }
                if ($reg["posicion_sata"]==3){
                    $tres++;
                }
                if ($reg["posicion_sata"]==4){
                    $cuatro++;
                }
            }
            $respuesta['success'] = true;
            $respuesta['uno'] = $uno;
            $respuesta['dos'] = $dos;
            $respuesta['tres'] = $tres;
            $respuesta['cuatro'] = $cuatro;
            $respuesta['query']= "SELECT f.marca, s.id as idSku, s.sku, " .
                " s.brand, s.nombre_mercado_col, f.precio " .
                " from apex_form f inner join apex_distribuitor d on f.id_distribuitor = d.id inner join apex_channel " .
                "c on f.channel_id = c.id_channel inner join apex_sku s on f.id_sku = s.id INNER JOIN apex_login u on u.id = f.id_user  " .
                "where f.status ='Exitosa' " .$valor. " order by create_form ;";
        }
    }


}
//$respuesta['valor']=$imprimir;
//echo $respuesta['valor'];
/*echo json_encode($respuesta['description']);
echo "Hola";*/
//echo $imprimir;
print_r(json_encode($respuesta));
exit;
?>