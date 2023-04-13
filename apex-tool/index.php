<?php session_start();
if (isset($_SESSION['sflag'])) {
    if ($_SESSION['sflag'] == 1) {
        header(("location:inicio.php"));
        exit();
    }if ($_SESSION['sflag'] == 2) {
        header(("location:dashboard.php"));
        exit();
    }
    else {
        session_destroy();
    }
}
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
    <title>Login</title>
</head>
<body class="fnegro">
<div class="cuerpo ">
    <div class="contenido fblanco">
        <div class="w3-row">
            <?php
            if (isset($_GET['e'])) {
                if ($_GET['e'] == 1) {
                    echo "<div class=\"aviso txtrojo\">Usuario y/o contraseña incorrectos</div>";
                }
            }
            ?>
            <form action="validar.php" method="post">
                <h1>Login</h1>
                <p>Usuario <input class="w3-input" type="text" placeholder="Usuario" name="usuario" required></p>
                <p>Contraseña <input class="w3-input" type="password" placeholder="Contraseña" name="contraseña"
                                     required></p>
                <p>Extensión</p>
                <select name="ext" class="w3-input" required>
                    <option></option>
                    <option value="9003">9003</option>
                    <option value="9004">9004</option>
                    <option value="9005">9005</option>
                    <option value="9007">9007</option>
                    <option value="9008">9008</option>
                </select>
                <br>
                <input class="w3-button w3-half fnegro" type="submit" value="Ingresar">
                <br>
            </form>
        </div>
    </div>
</div>
</body>
</html>