<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

$id=$_POST['idModifPto'];
//Creo la ruta de destino
$script="SELECT ID_CIUDAD FROM PUNTOS_TURISTICOS WHERE ID_PTO='".$id."'";
//Consulto la base de datos buscando las ciudades pertenecientes al pais indicando
$resultado=mysqli_query($c,$script); 
$arrayResultados=[];  
for ($i=1;mysqli_num_rows($resultado)>=$i;$i++){
    $fila=mysqli_fetch_row($resultado);
    array_push($arrayResultados,$fila[0]);
}
$miCarpeta="../archivos/".$arrayResultados[0]."/".$id;

if ($_FILES['imagenModifPto']['name']!=''){
    $imagen=$_FILES['imagenModifPto'];
    $formato=substr($imagen['type'], 6);
    $script="UPDATE PUNTOS_TURISTICOS SET FORMATO_IMAGEN='.".$formato."' WHERE ID_PTO='".$id."'";
    mysqli_query($c,$script);
    move_uploaded_file($imagen['tmp_name'],$miCarpeta.'/fotoIndex.'.$formato);
}
if ($_FILES['infoModifPto']['name']!=''){
    $info=$_FILES['infoModifPto'];
    move_uploaded_file($info['tmp_name'],$miCarpeta.'/info1.txt');
}
if ($_FILES['infoModif2Pto']['name']!=''){
    $info2=$_FILES['infoModif2Pto'];
    move_uploaded_file($info2['tmp_name'],$miCarpeta.'/info2.txt');
}
if ($_FILES['infoModif3Pto']['name']!=''){
    $info3=$_FILES['infoModif3Pto'];
    move_uploaded_file($info3['tmp_name'],$miCarpeta.'/info3.txt');
}
header("Refresh:10;url='../admin.html'");
?>