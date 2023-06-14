<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin

$id=$_POST['idModifCiudad'];
//Muevo todos los archivos a la ruta de destino
$miCarpeta="../archivos/".$id;

if ($_FILES['imagenModifCiudad']['name']!=''){
    $imagen=$_FILES['imagenModifCiudad'];
    $formato=substr($imagen['type'], 6);
    $script="UPDATE CIUDADES SET FORMATO_FOTO='.".$formato."' WHERE ID_CIUDAD='".$id."'";
    mysqli_query($c,$script);
    move_uploaded_file($imagen['tmp_name'],$miCarpeta.'/fotoIndex.'.$formato);
}
if ($_FILES['descModifCiudad']['name']!=''){
    $info=$_FILES['descModifCiudad'];
    move_uploaded_file($info['tmp_name'],$miCarpeta.'/infoIndex.txt');
}
if ($_FILES['docuModifCiudad']['name']!=''){
    $documentacion=$_FILES['docuModifCiudad'];
    move_uploaded_file($documentacion['tmp_name'],$miCarpeta.'/documentacion.txt');
}
if ($_FILES['festModifCiudad']['name']!=''){
    $festivos=$_FILES['festModifCiudad'];
    move_uploaded_file($festivos['tmp_name'],$miCarpeta.'/festivos.txt');
}
if ($_FILES['horaModifCiudad']['name']!=''){
    $horarios=$_FILES['horaModifCiudad'];
    move_uploaded_file($horarios['tmp_name'],$miCarpeta.'/horarios.txt');
}
if ($_FILES['llegModifCiudad']['name']!=''){
    $llegada=$_FILES['llegModifCiudad'];
    move_uploaded_file($llegada['tmp_name'],$miCarpeta.'/llegada.txt');
}
if ($_FILES['preciosModifCiudad']['name']!=''){
    $precios=$_FILES['preciosModifCiudad'];
    move_uploaded_file($precios['tmp_name'],$miCarpeta.'/precios.txt');
}
if ($_FILES['tiempoModifCiudad']['name']!=''){
    $tiempo=$_FILES['tiempoModifCiudad'];
    move_uploaded_file($tiempo['tmp_name'],$miCarpeta.'/tiempo.txt');
}
if ($_FILES['transpModifCiudad']['name']!=''){
    $transporte=$_FILES['transpModifCiudad'];
    move_uploaded_file($transporte['tmp_name'],$miCarpeta.'/transporte.txt');
}
header("Refresh:0;url='../admin.html'");
?>