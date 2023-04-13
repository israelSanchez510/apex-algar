<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cerrar Sesión</title>
</head>
<body>
<div class="w3-row">
<?php
if(session_destroy()){
    ?>
    <div class="aviso">
        la sesión ha finalidado
    </div>
<?php
    }
?>
</div>

</body>
</html><?php
