<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$codigo=intval($_GET['id']);
$script="SELECT ID_PTO, FORMATO_IMAGEN, ID_CIUDAD FROM PUNTOS_TURISTICOS WHERE ID_PTO=".$codigo;
$resultado=mysqli_query($c,$script);
//Consulto la base de datos buscando el punto de interés en cuestión
if (mysqli_num_rows($resultado)!=0){//El codigo pertenece a un registro
    $fila=mysqli_fetch_row ($resultado);//Datos de la consulta
    //ID del monumento
    $arrayResultado['id']=$fila[0];
    //Imagen
    $rutaImg="../archivos/".$fila[2]."/".$fila[0]."/imagen".$fila[1];
    $arrayResultado['imagen']=$rutaImg;
    //Información general
    $ruta1="../archivos/".$fila[2]."/".$fila[0]."/info1.txt";
    $arrayResultado['infoGeneral']=file_get_contents($ruta1);
    //Información util (horarios, precios, como llegar)
    $ruta2="../archivos/".$fila[2]."/".$fila[0]."/info2.txt";
    if (file_exists($ruta2)) {
        $arrayResultado['infoUtil']=file_get_contents($ruta2);
    }else{
        $arrayResultado['infoUtil']=false;
    }
    //Información curiosa
    $ruta3="../archivos/".$fila[2]."/".$fila[0]."/info3.txt";
    if (file_exists($ruta3)) {
        $arrayResultado['infoCuriosa']=file_get_contents($ruta3);
    }else{
        $arrayResultado['infoCuriosa']=false;
    }
    //Codigo de exito
    $arrayResultado['codigo']=1;
    
    echo json_encode($arrayResultado);
}else{
    echo json_encode(array('codigo' => '2','mensaje' => 'No se ha encontrado la información del monumento elegido'));
}
?>