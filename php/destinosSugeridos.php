<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

$script="SELECT * FROM CIUDADES WHERE DEST_SUGERIDO='SI'";//Consulto la base de datos buscando los destinos marcados como sugeridos

session_start();

$resultado=mysqli_query($c,$script); 
$arrayResultados=[];  
if(mysqli_num_rows($resultado)>0 && mysqli_num_rows($resultado)<3){
    for ($i=1;$i<=mysqli_num_rows($resultado);$i++){
        $fila=mysqli_fetch_row($resultado);
        $nuevoArray=array('id'=>$fila[0],'nombre'=>$fila[1],'formatoFoto'=>$fila[2]);
        array_push($arrayResultados,$nuevoArray);
    } 
    echo json_encode(array('codigo'=>1,'sugerencias'=>$arrayResultados));
}else{
    echo json_encode(array('codigo'=>2,'mensaje'=>'<p>Aún no tenemos sugerencias</p><p>¿Por que no revisas el menú principal?</p>'));
}
$c->close();//Cierre de la Base de Datos
?>