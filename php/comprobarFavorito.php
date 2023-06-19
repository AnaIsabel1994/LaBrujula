<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

session_start();
$usuario=$_SESSION['usuario'];
$idPtoInteres=$_GET['id'];
//Funcion que comprueba si un punto turistico esta guardado como favorito para el usuario logueado
$script="SELECT * FROM FAVORITOS WHERE ID_PTO='".$idPtoInteres."' AND ID_USUARIO=(SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$usuario."')"; 
$resultado=mysqli_query($c,$script);

if (mysqli_num_rows($resultado)!=0){
    echo json_encode(array('codigo'=>1));
}else{
    echo json_encode(array('codigo'=>2));
}

?>