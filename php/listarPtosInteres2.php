<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$script="SELECT T.ID_PTO, T.NOMBRE, C.NOMBRE, P.NOMBRE FROM PUNTOS_TURISTICOS T JOIN CIUDADES C ON C.ID_CIUDAD=T.ID_CIUDAD JOIN PAISES P ON C.ID_PAIS=P.ID_PAIS";
$resultado=mysqli_query($c,$script); 
$arrayResultados=[];  
for ($i=1;mysqli_num_rows($resultado)>=$i;$i++){
    $fila=mysqli_fetch_row($resultado);
    $nuevoArray=array('idPto'=>$fila[0],'nombrePto'=>$fila[1],'nombreCiudad'=>$fila[2],'nombrePais'=>$fila[3]);
    array_push($arrayResultados,$nuevoArray);
} 
echo json_encode($arrayResultados);
?>