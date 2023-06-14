<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

if (isset($_GET['dest1'])){
    $dest1=$_GET['dest1'];
}else{
    $dest1=0;
}
if (isset($_GET['dest2'])){
    $dest2=$_GET['dest2'];
}else{
    $dest2=0;
}
if (isset($_GET['dest3'])){
    $dest3=$_GET['dest3'];
}else{
    $dest3=0;
}

$script="SELECT * FROM CIUDADES";
$resultado=mysqli_query($c,$script); 
$numFilas=mysqli_num_rows($resultado);
for ($i=0;$i<$numFilas;$i++){
    $fila = mysqli_fetch_row($resultado);
    if ($fila[0]==$dest1 || $fila[0]==$dest2 || $fila[0]==$dest3){
        $script2="UPDATE CIUDADES SET DEST_SUGERIDO='SI' WHERE ID_CIUDAD='".$fila[0]."'";
        mysqli_query($c,$script2);
    }else{
        $script2="UPDATE CIUDADES SET DEST_SUGERIDO='NO' WHERE ID_CIUDAD='".$fila[0]."'";
        mysqli_query($c,$script2); 
    }
}
echo json_encode(array('codigo'=>1));
?>