<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$codPais=intval($_GET['id']);
$script="SELECT * FROM CIUDADES WHERE ID_PAIS=".$codPais;
//Consulto la base de datos buscando las ciudades pertenecientes al pais indicando
$resultado=mysqli_query($c,$script); 
$arrayResultados=[];  
for ($i=1;mysqli_num_rows($resultado)>=$i;$i++){
    $fila=mysqli_fetch_row($resultado);
    $nuevoArray=array('id'=>$fila[0],'nombre'=>$fila[1]);
    array_push($arrayResultados,$nuevoArray);
} 
echo json_encode($arrayResultados);
?>