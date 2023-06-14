<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');
session_start();

//Compruebo si existe una sesión de usuario activa (no admin)
$arrayResultados=[];
if (!isset($_SESSION['usuario'])){
    $arrayResultados=array('codigo'=>2,'varSesion'=>$_SESSION['tUsuario']);
}else{
    $arrayResultados=array('codigo'=>1,'varSesion'=>$_SESSION['tUsuario']);
}
echo json_encode($arrayResultados);
?>