<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin



$script="INSERT INTO PAISES (NOMBRE) VALUES ('".$_POST['nombreNuevoPais']."')";
if (mysqli_query($c,$script)){
    echo json_encode(array('codigo' => '1', 'mensaje' => 'El país se ha guardado correctamente'));
}else{
    echo json_encode(array('codigo' => '2', 'mensaje' => 'Ya existe un país con ese nombre'));
}
?>