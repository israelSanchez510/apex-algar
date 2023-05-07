<?php
include("sesion.php");
?>
<!doctype html>
<html lang="es">
<link href="w3pro.css" rel="stylesheet" type="text/css">
<link href="estilo.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js"></script>
<script src="ajax/jquery.min.js"></script>
<style>
    #cargador {
        margin: 0 auto 0 auto;
        position: relative;
        background: url(images/3.gif) no-repeat;
        height: 52px;
        width: 150px;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="images/apex-fav.ico"> 

    <title>Formulario</title>
</head>
<?php
include("db.php");
$mysqli = conn();
$qry = $mysqli->query("select * from apex_channel where status !=0");
if ($mysqli->affected_rows > 0) {
    while ($reg = $qry->fetch_assoc()) {
        if ($reg["id_channel"] == $_GET['e']) {
            $medio = $reg["name"];
            $idMedio = $reg["id_channel"];
            if ($medio == "Llamada" || $medio == "Whatsapp") {
                $url = "Numero telefonico";
            } else if ($medio == "Email") {
                $url = "Correo electronico";
            } else {
                $url = "URL";
            }
        }
    }
}

?>
<body>

<div class="w3-row contenido fgris">
    <?php
    if (isset($_GET['e']) && $_GET['e'] == 1) {
        ?>
        <h1>Llamar</h1>
        <div class="w3-row">
            <form id="callform">
                <p>Numero telefonico <input class="w3-input" type="number" name="telefono" id="numeroTelefonico"
                                            placeholder="Telefono" required></p>
                <input class="w3-button w3-half fnegro" id="Llamar" type="button" value="Llamar">
            </form>
        </div>
        <div class="w3-row" id="respuesta">

        </div>
        <?php

    }
    ?>
    <div id="formularios" style="display: <?php if ($_GET['e'] == 1) {
        echo "none";
    } else {
        echo "block";
    } ?>">
        <h1>Formulario <?php echo $medio ?></h1>
        <br>
        <div class="w3-row">
            <form action="guardarForm.php" method="post">
                <div id="idcall" style="display: none"></div>
                <p><?php echo $url; ?> <input id="url" class="w3-input" type="text" name="url"
                                              placeholder="<?php echo $url; ?>" required></p>
                <p>Estado </p>
                <?php
                if (isset($_GET['e'])) {
                    $qry = $mysqli->query("select * from apex_status");
                    if ($mysqli->affected_rows > 0) {
                        echo "<select name=\"estado\" id=\"estado\" class=\"w3-input\" required>
                                    <option value=\"\" ></option>";
                        while ($reg = $qry->fetch_assoc()) {

                            if ($reg['type'] == $medio) {
                                ?>
                                <option value="<?php echo $reg["final_status"] ?>"><?php echo $reg["status"] ?>
                                </option>

                                <?php
                            }
                        }
                    }
                }
                ?>
                </select>
                <div id="exitosa" style="display: none">
                    <p>Distribuidor</p>
                    <select name="distribuidor" id="distribuidor" onchange="showMarca()" class="w3-input">
                        <option value=""></option>
                        <?php
                        $qry = $mysqli->query("select * from apex_distribuitor where status !=0");
                        if ($mysqli->affected_rows > 0) {
                            while ($reg = $qry->fetch_assoc()) {

                                ?>
                                <option value=<?php echo $reg['id']; ?>>
                                    <?php
                                    echo $mysqli->real_escape_string($reg['name']);
                                    ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <p>Medio</p>
                    <select class="w3-input" disabled>
                        <option value=<?php echo $idMedio; ?>
                                selected>
                            <?php
                            echo $medio;
                            ?>
                        </option>
                    </select>

                    <select name="medio" id="medio" class="w3-input" style="display: none">
                        <option value=<?php echo $idMedio; ?>
                                selected>
                            <?php
                            echo $medio;
                            ?>
                        </option>
                    </select>

                    <p>Marca</p>
                    <select name="marca" id="marca" class="w3-input">
                        <option value=""></option>
                        <?php
                        $qry = $mysqli->query("select * from apex_marca where status !=0");
                        if ($mysqli->affected_rows > 0) {
                            while ($reg = $qry->fetch_assoc()) {

                                ?>
                                <option value="<?php echo $reg['name']; ?>">
                                    <?php
                                    echo $mysqli->real_escape_string($reg['name']);
                                    ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <p>SKU</p>
                    <select name="SKU" id="SKU" class="w3-input" onchange="elegirSku()">
                        <option value=""></option>
                        <?php
                        $qry = $mysqli->query("select * from apex_sku where status !=0");
                        if ($mysqli->affected_rows > 0) {
                            while ($reg = $qry->fetch_assoc()) {

                                ?>
                                <option value=<?php echo $reg['id']; ?>>
                                    <?php
                                    echo $mysqli->real_escape_string($reg['sku']);
                                    ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <p>Descripcion SKU</p>
                    <select name="desSKU" id="desSKU" class="w3-input" disabled>
                    </select>
                    <p>BRAND</p>
                    <select name="brand" id="brand" class="w3-input" disabled>
                    </select>
                    <p>Nombre Mercado Colombia</p>
                    <select name="nombreMercado" id="nombreMercado" class="w3-input" disabled>

                    </select>
                    <p>Precio (valor con IVA)</p>
                    <input name="precio" id="precio" class="w3-input" type="number">
                    <p>Posición en la que entregan la marca "SATA"</p>
                    <select name="posicSata" id="posicSata" class="w3-input">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    <p>El precio tiene promoción</p>
                    <select name="promocion" id="promocion" class="w3-input">
                        <option value="" selected></option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>
                    <p>Observación</p>
                    <textarea name="observacion" id="observacion" class="w3-input"></textarea>
                </div>
                <br>
                <input class="w3-button w3-half fnegro" type="submit" value="Guardar y salir">
                <input class="w3-button w3-half fnegro" id="guardarC" type="button" value="Guardar y continuar">

                <br>
            </form>
        </div>
    </div>
</div>
<script>
    document.querySelector("#estado").addEventListener("change", function () {
        document.querySelector('div[id="exitosa"]').style.display = this.value == "Exitosa" ? "block" : "none";
    });

    document.querySelector("#marca").addEventListener("change", function () {
        if (document.getElementById('marca').value != "") {
            var Numero = document.getElementById('marca').value;
            var valores = "num=" + Numero;
            //
            $('#desSKU').html("");
            $('#brand').html("");
            $('#nombreMercado').html("");
            $('#SKU').html("");
            //
            $.ajax({
                url: 'buscarSku.php',
                type: 'post',
                data: valores,
            }).done(function (res) {
                //$('#respuesta').html(res)
                var data = $.parseJSON(res)
                if (data.success) {
                    $('#desSKU').html(data.description);
                    $('#brand').html(data.brand);
                    $('#nombreMercado').html(data.nombreMercado);
                    $('#SKU').html(data.sku);

                } else {
                    $('#respuesta').html(data.description);
                }

            }).always(function () {
                console.log("Complete");
            });
        }
        else{
            $('#desSKU').html("");
            $('#brand').html("");
            $('#nombreMercado').html("");
            $('#SKU').html("");
        }
    });


    function elegirSku() {
        var sku = document.getElementById("SKU").value;
        var desSKU = document.getElementById("desSKU");
        var brand = document.getElementById("brand");
        var nombreMercado = document.getElementById("nombreMercado");
        desSKU.value = sku;
        brand.value = sku;
        nombreMercado.value = sku;
    }

    $('#Llamar').click(function () {
        if (document.getElementById('numeroTelefonico').value != "") {
            var Numero = document.getElementById('numeroTelefonico').value;
            var valores = "num=" + Numero;
            //
            $('#respuesta').html('<p><div id="cargador"></div></p>');
            //
            $.ajax({
                url: 'test_llamada.php',
                type: 'post',
                data: valores,
            }).done(function (res) {
                //$('#respuesta').html(res)
                var data = $.parseJSON(res)
                if (data.success) {
                    document.getElementById("url").value = document.getElementById("numeroTelefonico").value
                    document.querySelector('div[id="formularios"]').style.display = "block";
                    $('#respuesta').html('');
                    $('#idcall').html(data.description);
                } else {
                    $('#respuesta').html(data.description);
                }

            }).always(function () {
                console.log("Complete");
            });
        }
    });

    $('#guardarC').click(function () {
        var url = document.getElementById('url').value;
        var estado = document.getElementById('estado').value;
        var distribuidor = document.getElementById("distribuidor").value;
        var medio = document.getElementById("medio").value;
        var marca = document.getElementById("marca").value;
        var sku = document.getElementById("SKU").value;
        var precio = document.getElementById("precio").value;
        var posicSata = document.getElementById("posicSata").value;
        var promocion = document.getElementById("promocion").value;
        var observacion = document.getElementById("observacion").value;
        var valores =
            "url=" + url + "&estado=" + estado + "&distribuidor=" + distribuidor + "&medio=" + medio + "&marca=" + marca + "&SKU=" + sku
            + "&precio=" + precio + "&posicSata=" + posicSata + "&promocion=" + promocion + "&observacion=" + observacion;
        if (document.getElementById("idcallform")) {
            valores = valores + "&idcallform=" + document.getElementById("idcallform").value;
        }
        //
        //
        $.ajax({
            url: 'saveForm.php',
            type: 'post',
            data: valores,
        }).done(function (res) {
            //$('#respuesta').html(res)
            var data = $.parseJSON(res)
            if (data.success) {
                //document.getElementById("url").value="";
                document.getElementById("marca").value = "";
                document.getElementById("SKU").value = "";
                document.getElementById("desSKU").value = "";
                document.getElementById("brand").value = "";
                document.getElementById("nombreMercado").value = "";
                document.getElementById("precio").value = "";
                document.getElementById("posicSata").value = "";
                document.getElementById("promocion").value = "";
                document.getElementById("observacion").value = "";
            } else {
                alert("Hubo problemas al guardar");
            }

        });
    });

</script>
</body>
</html>