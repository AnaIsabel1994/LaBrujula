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
    $fDoc="../archivos/".$fila[0]."/documentacion.txt";
    $fFiestas="../archivos/".$fila[0]."/festivos.txt";
    $fHorario="../archivos/".$fila[0]."/horarios.txt";
    $fLlegada="../archivos/".$fila[0]."/llegada.txt";
    $fPrecios="../archivos/".$fila[0]."/precios.txt";
    $fTiempo="../archivos/".$fila[0]."/tiempo.txt";
    $fTransp="../archivos/".$fila[0]."/transporte.txt";

    //Primero, compruebo que existen los archivos de texto
    if (file_exists($fDoc) && file_exists($fFiestas) && file_exists($fHorario) && file_exists($fLlegada) && file_exists($fPrecios) && file_exists($fTiempo) && file_exists($fTransp)) {
        //Creo el array que devolveré como JSON
        //id_ciudad
        $arrayResultado['id']=$codCiudad;
        //Añado el texto de los diferentes archivos
        $arrayResultado['documentacion']=file_get_contents($fDoc);
        $arrayResultado['fiestas']=file_get_contents($fFiestas);
        $arrayResultado['hComercial']=file_get_contents($fHorario);
        $arrayResultado['llegada']=file_get_contents($fLlegada);
        $arrayResultado['precios']=file_get_contents($fPrecios);
        $arrayResultado['tiempo']=file_get_contents($fTiempo);
        $arrayResultado['transporte']=file_get_contents($fTransp);

        //codigo de exito
        $arrayResultado['codigo']='1';
        
        echo json_encode($arrayResultado);
    } else {
        echo json_encode(array('codigo' => '2','mensaje' => 'Se ha producido un error al recuperar los datos'));
    }
}else{
    echo json_encode(array('codigo' => '2','mensaje' => 'El codigo no pertenece a ninguna ciudad'));
}
?>