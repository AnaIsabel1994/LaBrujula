<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$codCiudad=intval($_GET['id']);

$script="SELECT * FROM CIUDADES WHERE ID_CIUDAD=".$codCiudad;
$resultado=mysqli_query($c,$script);

//Consulto la base de datos buscando la ciudad en cuestión
if (mysqli_num_rows($resultado)!=0){//El codigo pertenece a un registro
    $fila=mysqli_fetch_row ($resultado);//Datos de la consulta

    //Ruta a los archivos
    $rutaImagen="../archivos/".$fila[0]."/fotoIndex".$fila[2];
    $rutaFichero="../archivos/".$fila[0]."/infoIndex.txt";

    //Primero, compruebo que existen los archivos de imagen y texto
    if (file_exists($rutaFichero) && file_exists($rutaImagen)) {
        //Creo el array que devolveré como JSON
        //id_ciudad
        $arrayResultado['id']=$codCiudad;
        //nombre de la ciudad
        $arrayResultado['nombre']=$fila[1];
        //ruta relativa de la imagen
        $rutaImagen="./archivos/".$fila[0]."/fotoIndex".$fila[2];
        $arrayResultado['imagen']=$rutaImagen;
        //contenido del TXT
        $archivo = file_get_contents($rutaFichero);
        $arrayResultado['info']=$archivo;
        //codigo de exito
        $arrayResultado['codigo']='1';
        
        echo json_encode($arrayResultado);
    } else {
        echo json_encode(array('codigo' => '2','mensaje' => 'Se ha producido un error al recuperar los datos','rutaImagen'=>$rutaImagen,'rutaFichero'=>$rutaFichero));
    }
}else{
    echo json_encode(array('codigo' => '2','mensaje' => 'El codigo no pertenece a ninguna ciudad'));
}
?>