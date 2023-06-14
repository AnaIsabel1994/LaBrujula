<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$id=intval($_GET['id']);//Recojo el dato pasado por la URL

$script="SELECT ID_PTO, NOMBRE, TIPO FROM PUNTOS_TURISTICOS WHERE ID_CIUDAD=".$id;

//Consulto la base de datos buscando los puntos de interes guardados en la base de datos, en funcion del pais
$resultado=mysqli_query($c,$script); 

$monumentos=array();
$barrios=array();
$iglesias=array();
$museos=array();
$vCercanas=array();

for ($i=1;mysqli_num_rows($resultado)>=$i;$i++){
    $fila=mysqli_fetch_row($resultado);
    $arrayAux=array('codigo'=>$fila[0],'nombre'=>$fila[1]);
    switch ($fila[2]) {
        case 'MONUMENTO':
            array_push($monumentos, $arrayAux);
            break;
        case 'BARRIO':
            array_push($barrios, $arrayAux);
            break;
        case 'IGLESIA':
            array_push($iglesias, $arrayAux);
            break;
        case 'MUSEO':
            array_push($museos, $arrayAux);
            break;
        case 'V_CERCANAS':
            array_push($vCercanas, $arrayAux);
            break;
    }
} 
$arrayResultados=[];
$arrayResultados=array('monumentos'=>$monumentos, 'barrios'=>$barrios, 'iglesias'=>$iglesias, 'museos'=>$museos, 'vCercanas'=>$vCercanas, 'script'=>$script);
echo json_encode($arrayResultados);
?>