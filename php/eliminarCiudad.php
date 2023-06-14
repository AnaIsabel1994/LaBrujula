<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, DELETE');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

$valor=$_GET['idCiudad'];
$script1="SELECT * FROM PUNTOS_TURISTICOS WHERE ID_CIUDAD='".$valor."'";
$resultado=mysqli_query($c,$script1);
if (mysqli_num_rows($resultado)==0){
    $script2="DELETE FROM CIUDADES WHERE ID_CIUDAD='".$valor."' AND ID_CIUDAD NOT IN (SELECT DISTINCT ID_CIUDAD FROM PUNTOS_TURISTICOS)";
    mysqli_query($c,$script2);
    echo json_encode(array('codigo' => '1', 'mensaje' => 'La ciudad se ha eliminado correctamente'));
}else{
     echo json_encode(array('codigo' => '2', 'mensaje' => 'La ciudad tiene puntos turisticos asociados'));
}
?>