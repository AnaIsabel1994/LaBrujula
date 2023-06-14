<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$script="SELECT * FROM USUARIOS WHERE ID_USUARIO<>'1'";
//Consulto la base de datos buscando los paises guardados en la base de datos
$resultado=mysqli_query($c,$script); 
$arrayResultados=[];  
for ($i=1;mysqli_num_rows($resultado)>=$i;$i++){
    $fila=mysqli_fetch_row($resultado);
    $nuevoArray=array('id'=>$fila[0],'email'=>$fila[1]);
    array_push($arrayResultados,$nuevoArray);
} 
echo json_encode($arrayResultados);
?>