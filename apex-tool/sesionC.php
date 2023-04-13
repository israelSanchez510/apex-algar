<?php
session_start();
if(!isset($_SESSION["USUARIO"])||!isset($_SESSION["sflag"]) || !isset($_SESSION['EXT']) || $_SESSION["sflag"]!=2){
    header("location:index.php");
    exit();
}
?>