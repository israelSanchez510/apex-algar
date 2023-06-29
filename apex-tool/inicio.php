<?php
include ("sesion.php");
?>
<!doctype html>
<html lang="es">
<link href="w3pro.css" rel="stylesheet" type="text/css">
<link href="estilo.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="images/apex-fav.ico"> 

    <title>Inicio</title>
</head>
<?php
    include("db.php");
    $mysqli=conn();
?>
<body>
    <a href="cerrar.php" class="w3-bar-item w3-button w3-padding" style="float:right">Cerrar Sesión </a>

    <div class="w3-row contenido fgris">
        <h1>Selecciona canal de comunicación</h1>
        <br>
        <div class="w3-row" style="align-items: center">
            <?php
            $qry=$mysqli->query("select * from apex_channel where status !=0");
            if($mysqli->affected_rows>0){
                while($reg=$qry->fetch_assoc()){

            ?>
                    <a href="form.php?e=<?php echo ($reg['id_channel'])?>">
                        <div class="tarjeta">
                            <?php
                                echo $reg['name'];
                            ?>
                        </div>
                    </a> <br>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>
</html>