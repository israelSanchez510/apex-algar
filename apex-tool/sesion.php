<?php
session_start();
if(!isset($_SESSION["USUARIO"])||!isset($_SESSION["sflag"]) || !isset($_SESSION['EXT'])){
    header("location:index.php");
    exit();
}
?>