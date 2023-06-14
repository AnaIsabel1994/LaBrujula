<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin


//Compruebo que no haya una ciudad con el mismo nombre y país
$script="SELECT * FROM CIUDADES WHERE NOMBRE='".$_POST['nombreNuevaCiudad']."' AND ID_PAIS='".$_POST['paisNuevaCiudad']."'";

$resultado=mysqli_query($c,$script);
if (mysqli_num_rows($resultado)==0){
    $imagen=$_FILES['imagenNuevaCiudad'];
    $formato=substr($imagen['type'], 6);
    $script="INSERT INTO CIUDADES(NOMBRE, FORMATO_FOTO, ID_PAIS) VALUES ('".$_POST['nombreNuevaCiudad']."','.".$formato."','".$_POST['paisNuevaCiudad']."')";
    mysqli_query($c,$script);
    //Recojo el id del nuevo registro de la bbdd
    $script="SELECT MAX(ID_CIUDAD) FROM CIUDADES";
    $resultado=mysqli_query($c,$script);
    $idCiudad=mysqli_fetch_row ($resultado)[0];
    //Muevo todos los archivos a la ruta de destino
    $miCarpeta="../archivos/".$idCiudad;
    if (!file_exists($miCarpeta)) {
        mkdir($miCarpeta, 0777);
    }
    move_uploaded_file($imagen['tmp_name'],$miCarpeta.'/fotoIndex.'.$formato);
    $info=$_FILES['descNuevaCiudad'];
    move_uploaded_file($info['tmp_name'],$miCarpeta.'/infoIndex.txt');
    $documentacion=$_FILES['docuNuevaCiudad'];
    move_uploaded_file($documentacion['tmp_name'],$miCarpeta.'/documentacion.txt');
    $festivos=$_FILES['festNuevaCiudad'];
    move_uploaded_file($festivos['tmp_name'],$miCarpeta.'/festivos.txt');
    $horarios=$_FILES['horaNuevaCiudad'];
    move_uploaded_file($horarios['tmp_name'],$miCarpeta.'/horarios.txt');
    $llegada=$_FILES['llegNuevaCiudad'];
    move_uploaded_file($llegada['tmp_name'],$miCarpeta.'/llegada.txt');
    $precios=$_FILES['preciosNuevaCiudad'];
    move_uploaded_file($precios['tmp_name'],$miCarpeta.'/precios.txt');
    $tiempo=$_FILES['tiempoNuevaCiudad'];
    move_uploaded_file($tiempo['tmp_name'],$miCarpeta.'/tiempo.txt');
    $transporte=$_FILES['transpNuevaCiudad'];
    move_uploaded_file($transporte['tmp_name'],$miCarpeta.'/transporte.txt');
    echo '<html><p>Inserción realizada con éxito</p></html>';
}else{
    echo '<html><p>Ya existe una ciudad en ese país con el mismo nombre</p></html>';
}
header("Refresh:0;url='../admin.html'");
?>