<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, DELETE');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

$idUsuario=$_GET['uId'];
//Compruebo si el usuario tiene favoritos guardados (de ser así, los borro)
$script1="DELETE FROM FAVORITOS WHERE ID_USUARIO=".$idUsuario;
if (mysqli_query($c,$script1)){
    $script2="DELETE FROM USUARIOS WHERE ID_USUARIO='".$idUsuario."'";
    if (mysqli_query($c,$script2)){
        echo json_encode(array('codigo' => '1', 'mensaje' => 'El usuario se ha eliminado correctamente correctamente'));
    }else{
        echo json_encode(array('codigo' => '2', 'mensaje' => 'Se ha producido un error al eliminar el usuario'));
    }
}else{
    echo json_encode(array('codigo' => '2', 'mensaje' => 'Se ha producido un error'));
}
?>