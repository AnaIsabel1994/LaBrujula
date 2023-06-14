<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Devuelve un listado de todas las ciudades, y el estado de DEST_SUGERIDO
$script="SELECT C.ID_CIUDAD, C.NOMBRE, P.NOMBRE, C.DEST_SUGERIDO FROM CIUDADES C JOIN PAISES P ON C.ID_PAIS=P.ID_PAIS";
$resultado=mysqli_query($c,$script); 
$arrayResultados=[];  
for ($i=1;mysqli_num_rows($resultado)>=$i;$i++){
    $fila=mysqli_fetch_row($resultado);
    $nuevoArray=array('id'=>$fila[0],'nombre'=>$fila[1], 'pais'=>$fila[2], 'sugerido'=>$fila[3]);
    array_push($arrayResultados,$nuevoArray);
} 
echo json_encode($arrayResultados);
?>