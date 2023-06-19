<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

$id=$_POST['idModifPto'];
//Creo la ruta de destino
$script="SELECT ID_CIUDAD FROM PUNTOS_TURISTICOS WHERE ID_PTO='".$id."'";
//Consulto la base de datos buscando el punto turistico indicado
$resultado=mysqli_query($c,$script); 
$fila=mysqli_fetch_row($resultado);
$miCarpeta="../archivos/".$fila[0]."/".$id;
$script="UPDATE PUNTOS_TURISTICOS SET TIPO='".$_POST['tipoModifPto']."' WHERE ID_PTO='".$id."'";
mysqli_query($c,$script);

if ($_FILES['imagenModifPto']['name']!=''){
    $imagen=$_FILES['imagenModifPto'];
    $formato=substr($imagen['type'], 6);
    $script="UPDATE PUNTOS_TURISTICOS SET FORMATO_IMAGEN='.".$formato."' WHERE ID_PTO='".$id."'";
    mysqli_query($c,$script);
    move_uploaded_file($imagen['tmp_name'],$miCarpeta.'/imagen.'.$formato);
}
if ($_FILES['infoModifPto']['name']!=''){
    $info=$_FILES['infoModifPto'];
    move_uploaded_file($info['tmp_name'],$miCarpeta.'/info1.txt');
}
if ($_FILES['info2ModifPto']['name']!=''){
    $info2=$_FILES['info2ModifPto'];
    move_uploaded_file($info2['tmp_name'],$miCarpeta.'/info2.txt');
}
if ($_FILES['info3ModifPto']['name']!=''){
    $info3=$_FILES['info3ModifPto'];
    move_uploaded_file($info3['tmp_name'],$miCarpeta.'/info3.txt');
}
header("Refresh:0;url='../admin.html'");
?>