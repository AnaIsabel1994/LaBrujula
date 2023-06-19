<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$usuario=$_SESSION['usuario'];
$ptoInteres=$_GET['id'];
$accion=$_GET['accion'];
if ($_GET['accion']=='si'){//Se quiere marcar el punto turistico como favorito
    $script="INSERT INTO FAVORITOS(ID_USUARIO, ID_PTO) VALUES ((SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$usuario."'),'".$ptoInteres."')";
    if (mysqli_query($c,$script)){
        echo json_encode(array('codigo' => '1'));
    }else{
        echo json_encode(array('codigo' => '2', 'mensaje'=>'Error al marcar como favorito', 'script'=>$script));
    }
}else{//Se quiere desmarcar el punto turistico como favorito
    $script="DELETE FROM FAVORITOS WHERE ID_PTO=".$ptoInteres." AND ID_USUARIO=(SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$usuario."')";
    if (mysqli_query($c,$script)){
        echo json_encode(array('codigo' => '1'));
    }else{
        echo json_encode(array('codigo' => '2', 'mensaje'=>'Error al desmarcar como favorito'));
    }
}

?>