<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin


//Compruebo que no haya un punto con el mismo nombre en la ciudad en cuestión
$script="SELECT * FROM PUNTOS_TURISTICOS WHERE NOMBRE='".$_POST['nombreNuevoPto']."' AND ID_CIUDAD='".$_POST['ciudadNuevoPto']."'";

$resultado=mysqli_query($c,$script);
if (mysqli_num_rows($resultado)==0){
    $imagen=$_FILES['imagenNuevoPto'];
    $formato=substr($imagen['type'], 6);
    $script="INSERT INTO PUNTOS_TURISTICOS (NOMBRE, TIPO, FORMATO_IMAGEN, ID_CIUDAD) VALUES ('".$_POST['nombreNuevoPto']."','".$_POST['tipoNuevoPto']."','.".$formato."','".$_POST['ciudadNuevoPto']."')";
    mysqli_query($c,$script);
    //Recojo el id del nuevo registro de la bbdd
    $script2="SELECT MAX(ID_PTO) FROM PUNTOS_TURISTICOS";
    $resultado2=mysqli_query($c,$script2);
    $idPto=mysqli_fetch_row ($resultado2)[0];
    //Muevo todos los archivos a la ruta de destino
    $miCarpeta="../archivos/".$_POST['ciudadNuevoPto']."/".$idPto;
    if (!file_exists($miCarpeta)) {
        mkdir($miCarpeta, 0777);
    }
    move_uploaded_file($imagen['tmp_name'],$miCarpeta.'/imagen.'.$formato);
    $info=$_FILES['infoNuevoPto'];
    move_uploaded_file($info['tmp_name'],$miCarpeta.'/info1.txt');
    $info2=$_FILES['info2NuevoPto'];
    move_uploaded_file($info2['tmp_name'],$miCarpeta.'/info2.txt');
    $info3=$_FILES['info3NuevoPto'];
    move_uploaded_file($info3['tmp_name'],$miCarpeta.'/info3.txt');
}
header("Refresh:3;url='../admin.html'");
?>