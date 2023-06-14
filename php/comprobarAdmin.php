<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');
session_start();

//Compruebo si existe una sesión de usuario activa (no admin)
$arrayResultados=[];  
if ($_SESSION['tUsuario']=='admin'){
    $arrayResultados=array('codigo'=>1);
}else{
    $arrayResultados=array('codigo'=>2);
}
echo json_encode($arrayResultados);
?>