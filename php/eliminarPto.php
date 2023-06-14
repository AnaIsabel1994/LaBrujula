<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, DELETE');


include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
$valor=$_GET['pId'];
$ruta="../archivos/".$valor;

$script1="DELETE FROM FAVORITOS WHERE ID_PTO='".$valor."'";
if (mysqli_query($c,$script1)){
    $script2="DELETE FROM PUNTOS_TURISTICOS WHERE ID_PTO='".$valor."'";
    if(mysqli_query($c,$script2)){
        //Borro tambien la carpeta asociada
        $script="SELECT ID_CIUDAD FROM PUNTOS_TURISTICOS WHERE ID_PTO='".$valor."'";
        $resultado=mysqli_query($c,$script);
        $fila=mysqli_fetch_row($resultado);
        $ruta="../archivos/".$valor."/".$fila[0];
        echo json_encode(array('codigo' => '1', 'mensaje' => 'El punto de interes se ha eliminado correctamente'));
    }else{
        echo json_encode(array('codigo' => '2', 'mensaje' => 'Se ha producido un error al borrar el punto de interes'));
    }
}else{
   echo json_encode(array('codigo' => '2', 'mensaje' => 'Se ha producido un error al borrar el punto de interes'));
}
?>