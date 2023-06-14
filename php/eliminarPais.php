<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, DELETE');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

$valor=$_GET['idPais'];

$script="DELETE FROM PAISES WHERE ID_PAIS='".$valor."' AND ID_PAIS NOT IN (SELECT DISTINCT ID_PAIS FROM CIUDADES)";
if (mysqli_query($c,$script)){
    echo json_encode(array('codigo' => '1', 'mensaje' => 'El país se ha eliminado correctamente'));
}else{
    echo json_encode(array('codigo' => '2', 'mensaje' => 'El pais tiene ciudades asociadas'));
}
?>