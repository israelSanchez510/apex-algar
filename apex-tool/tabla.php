<?php
include ("sesionC.php");
?>
<!DOCTYPE html>
<html lang="es">
<?php
include("db.php");
$mysqli = conn();
?>

<head>
    <title>Tabla Dif</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="ajax/chart.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="ajax/jquery.min.js"></script>
    <link rel="stylesheet" href="w3.css">
    <link href="w3pro.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="images/apex-fav.ico">
    <style>
        html, body, h1, h2, h3, h4, h5 {
            font-family: "Raleway", sans-serif
        }
        #cargador {
            margin: 0 auto 0 auto;
            position: relative;
            background: url(images/3.gif) no-repeat;
            height: 52px;
            width: 150px;
        }
    </style>
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i
            class="fa fa-bars"></i>  Menu
    </button>
    <!--<span class="w3-bar-item w3-right">Logo</span>-->
    <a href="cerrar.php" class="w3-bar-item w3-button w3-padding" style="float:right">Cerrar Sesión </a>

</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:250px;" id="mySidebar"><br>
<div class="w3-container w3-row">
        <div class="w3-col ">
            <img src="images/apex-logo.png" class="w3-margin-right" style="width:180px">
            <img src="images/logoAlgar_.png" class="" style="width: 50px;float: right;">

        </div>
        
        <div class="w3-col s8 w3-bar" style="margin-top: 15px;">

            <span>Hola <strong><?php echo $_SESSION['USUARIO']; ?></strong></span><br>
            <!--<a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
            <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
            <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>-->
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5>Grafico</h5>
    </div>
    <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black"
           onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Cerrar Menu</a>
        <a href="dashboard.php" class="w3-bar-item w3-button w3-padding "><i class="fa fa-users fa-fw"></i>  Tabla Dif</a>
        <a href="grafico.php" class="w3-bar-item w3-button w3-padding "><i class="fa fa-users fa-fw"></i>  Analisis Referencias </a>
        <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Tabla marca cantidad</a>
        <a href="grafico_sata.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Grafico posicion SATA</a>
        <a href="tabla_ponde.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Tabla promoción ponderado</a>

    </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"
     title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Tabla Dif</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-quarter">
            <p>SKU</p>
            <select name="SKU" id="SKU"  class="w3-input">
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
            <p>Fecha inicio</p>
            <input type="date" class="w3-input" name="fecha1" id="fecha1">
        </div>
        <div class="w3-quarter">
            <p>Nombre Mercado Colombia</p>
            <select name="nombreMercado" id="nombreMercado"  class="w3-input">
                <option value=""></option>
                <?php
                $qry = $mysqli->query("select * from apex_sku where status !=0");
                if ($mysqli->affected_rows > 0) {
                    while ($reg = $qry->fetch_assoc()) {

                        ?>
                        <option value=<?php echo $reg['id']; ?>>
                            <?php
                            echo $mysqli->real_escape_string($reg['nombre_mercado_col']);
                            ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
            <p>Fecha final</p>
            <input type="date" class="w3-input" name="fecha2" id="fecha2">
        </div>
        <div class="w3-quarter">
            <p>Distribuidor</p>
            <select name="distribuidor" id="distribuidor"  class="w3-input">
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
        </div>
        <div class="w3-quarter" style="align-items: center">
            <p>Marca</p>
            <select name="marca" id="marca"  class="w3-input">
                <option value=""></option>
                <?php
                $qry = $mysqli->query("select * from apex_marca where status !=0");
                if ($mysqli->affected_rows > 0) {
                    while ($reg = $qry->fetch_assoc()) {

                        ?>
                        <option value=<?php echo $reg['name']; ?>>
                            <?php
                            echo $mysqli->real_escape_string($reg['name']);
                            ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <input class="w3-button w3-half fnegro" style="width: 50%" id="guardarC" type="button" value="Buscar">
    <br>
    <div class="w3-row-padding w3-margin-bottom">
        <div id="respuesta" class="w3-left" style="margin-top: 30px; width: 49.9%"></div>
        <div id="respuesta2" class="w3-right" style="margin-top: 30px; width: 49.9%"></div>
    </div>

    <hr>


    <br>
    <!-- End page content -->
</div>

<script>
    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    // Close the sidebar with the close button
    function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }


    $('#guardarC').click(function () {
        var distribuidor = document.getElementById("distribuidor").value;
        var sku = document.getElementById("SKU").value;
        var precio = document.getElementById("fecha1").value;
        var posicSata = document.getElementById("fecha2").value;
        var promocion = document.getElementById("nombreMercado").value;
        var marca = document.getElementById("marca").value;
        var valores =
            "valor=3&distribuidor=" + distribuidor + "&SKU=" + sku
            + "&fecha1=" + precio + "&fecha2=" + posicSata + "&nombreMercado=" + promocion+ "&marca="+marca ;
        //
        //
        $('#respuesta').html('<p><div id="cargador"></div></p>');

        $.ajax({
            url: 'buscar_dashboard.php',
            type: 'post',
            data: valores,
        }).done(function (res) {

            //$('#respuesta').html(res)
            var data = $.parseJSON(res)
            if (data.success) {
                //document.getElementById("url").value="";
                $('#respuesta').html(data.description);

            } else {
                alert("Hubo problemas al guardar");
            }

        });
    });

    function seleccionar(marca){
        var distribuidor = document.getElementById("distribuidor").value;
        var sku = document.getElementById("SKU").value;
        var precio = document.getElementById("fecha1").value;
        var posicSata = document.getElementById("fecha2").value;
        var promocion = document.getElementById("nombreMercado").value;
        var valores =
            "valor=4&distribuidor=" + distribuidor + "&SKU=" + sku
            + "&fecha1=" + precio + "&fecha2=" + posicSata + "&nombreMercado=" + promocion+ "&marca="+marca ;
        //
        //
        $('#respuesta2').html('<p><div id="cargador"></div></p>');

        $.ajax({
            url: 'buscar_dashboard.php',
            type: 'post',
            data: valores,
        }).done(function (res) {

            //$('#respuesta').html(res)
            var data = $.parseJSON(res)
            if (data.success) {
                //document.getElementById("url").value="";
                $('#respuesta2').html(data.description);

            } else {
                alert("Hubo problemas al guardar");
            }

        });
    }


</script>

</body>
</html>
