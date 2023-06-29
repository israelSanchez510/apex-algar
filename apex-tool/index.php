<?php session_start();
if (isset($_SESSION['sflag'])) {
    if ($_SESSION['sflag'] == 1) {
        header(("location:inicio.php"));
        exit();
    }
    if ($_SESSION['sflag'] == 2) {
        header(("location:dashboard.php"));
        exit();
    } else {
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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/x-icon" href="images/apex-fav.ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Login</title>
</head>

<body class="fnegro">
    <div class="cuerpo ">
        <div class="contenido fblanco">
            <div class="w3-row w3-center">

                <img src="images/apex-logo.png" class="" style="width: 300px;">
                <img src="images/logoAlgar_.png" class="" style="width: 70px;float: right;">

                <form action="validar.php" method="post" style="margin-top: 40px;">
                    <h1 style="margin-top: 20px;">Inicio de sesión</h1>
                    <p>Usuario <input class="w3-input" type="text" placeholder="Usuario" name="usuario" required></p>
                    <p>Contraseña <input class="w3-input" type="password" placeholder="Contraseña" name="contraseña" required></p>
                    <p>Extensión</p>
                    <select name="ext" class="w3-input" required>
                        <option></option>
                        <option value="9002">9002</option>
                        <option value="9003">9003</option>
                        <option value="9004">9004</option>
                        <option value="9005">9005</option>
                        <option value="9007">9007</option>
                        <option value="9008">9008</option>
                    </select>
                    <br>

                    <input class="w3-button fnegro w3-center" style="border-radius:10px;" type="submit" value="Ingresar">
                    <br>
                    <?php
                    if (isset($_GET['e'])) {
                        if ($_GET['e'] == 1) {
                            // echo "<div class=\"alert alert-danger error\"> Usuario y/o contraseña incorrectos</div>";
                        echo "<script>Swal.fire({icon:'error', text:'Usuario y/o contraseña incorrectos!'});</script>";
                        
                        }
                    }
                    ?>
                </form>
                
            </div>
        </div>
    </div>
</body>

</html>