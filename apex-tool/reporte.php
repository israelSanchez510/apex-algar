<?php
include("sesion.php");
?>
<!doctype html>
<html lang="es">
<link href="w3pro.css" rel="stylesheet" type="text/css">
<link href="estilo.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js"></script>
<script src="ajax/jquery.min.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
</head>
<?php
include("db.php");
$mysqli = conn();
?>
<body>
<div class="w3-row contenido fgris">
    <h1>Reporte</h1>
    <br>
    <form action="">
        <div class="w3-half">
            <p>Estatus</p>
            <select name="estatus" id="estatus" class="w3-input">
                <option value="Exitosa">Exitosa</option>
                <option value="No exitosa">No exitosa</option>
            </select>
            <p>Canal de comunicacion </p>
            <select name="canalCo" id="canalCo" class="w3-input">
                <option value="" selected></option>
                <?php
                $qry = $mysqli->query("select * from apex_channel");
                if ($mysqli->affected_rows > 0) {
                    while ($reg = $qry->fetch_assoc()) {
                        echo "<option value='" . $reg["id_channel"] . "'>" . $reg["name"] . "</option>";
                    }
                }

                ?>
            </select>
            <br>
            <input class="w3-button w3-half fnegro" id="buscar" type="button" value="Buscar">
            <br><br>
        </div>
    </form>
    <div class="w3-row" id="respuesta" style="align-items: center">
    </div>
</div>
<script>
    $('#buscar').click(function () {
        var Numero = document.getElementById('estatus').value;
        var canal = document.getElementById('canalCo').value;
        var valores = "num=" + Numero + "&canal=" + canal;
        //
        $('#respuesta').html('<p><div id="cargador"></div></p>');
        //
        $.ajax({
            url: 'buscar_reporte.php',
            type: 'post',
            data: valores,
        }).done(function (res) {
            //$('#respuesta').html(res)
            var data = $.parseJSON(res)
            if (data.success) {
                $('#respuesta').html(data.description);
            } else {
                $('#respuesta').html(data.description);
            }

        });
    });

</script>
</body>
</html>