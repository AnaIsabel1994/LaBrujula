<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');
session_start();
if ($_SESSION['tUsuario']=='admin'){
    unset($_SESSION["tUsuario"]);
}
if ($_SESSION['tUsuario']=='usuario'){
    unset($_SESSION["tUsuario"]);
    unset($_SESSION["usuario"]);
}
header("Refresh:0;url='../index.html'");
?>