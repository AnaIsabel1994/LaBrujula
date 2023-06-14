<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

$usuario=$_SESSION['usuario'];

$script="SELECT * FROM FAVORITOS WHERE ID_USUARIO=(SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$usuario."')"; 
$resultado=mysqli_query($c,$script);
if (mysqli_num_rows($resultado)!=0){//Hay puntos marcados como favoritos
    //Listo todas las ciudades
    $script="SELECT C.ID_CIUDAD, C.NOMBRE, P.NOMBRE, C.FORMATO_FOTO FROM CIUDADES C JOIN PAISES P ON C.ID_PAIS=P.ID_PAIS";
    $resultado=mysqli_query($c,$script);
    //Recorro la lista de ciudades, creando un listado de los puntos de interes marcados como favoritos de cada ciudad
    $lista=array();
    while ($fila = mysqli_fetch_row($resultado)){
        $listaAux=array();
        //Compruebo si hay puntos marcados como favoritos en la ciudad
        $script2="SELECT F.ID_PTO, T.NOMBRE 
        FROM FAVORITOS F JOIN PUNTOS_TURISTICOS T ON  F.ID_PTO=T.ID_PTO
        WHERE T.ID_CIUDAD='".$fila[0]."' AND F.ID_USUARIO=(SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$usuario."')";
        $resultado2=mysqli_query($c,$script2);
        if (mysqli_num_rows($resultado2)!=0){
            while ($fila2 = mysqli_fetch_row($resultado2)){
                $listaAux[]=array("idPto"=>$fila2[0],"nombrePto"=>$fila2[1]);
            }
        }
        $imagenCiudad="./archivos/".$fila[0]."/fotoIndex".$fila[3];
        if (count($listaAux)>0){
            $lista[]=array("idCiudad"=>$fila[0],"nombreCiudad"=>$fila[1],"nombrePais"=>$fila[2],"imagenCiudad"=>$imagenCiudad,"listaPtos"=>$listaAux);
        }
    }
    echo json_encode(array('codigo'=>1,'lista'=>$lista));
}else{
    echo json_encode(array('codigo'=>2, 'script'=>$script));
}


//SELECT * FROM `favoritos` WHERE ID_USUARIO=4 AND ID_PTO IN (SELECT ID_PTO FROM PUNTOS_TURISTICOS WHERE ID_CIUDAD='1');
//Función que comprueba si un usuario tiene puntos de interes marcados como favoritos
/* $script="SELECT COUNT(*) FROM FAVORITOS WHERE ID_USUARIO=(SELECT ID_USUARIO FROM USUARIOS WHERE EMAIL='".$usuario."') ORDER BY ID_CIUDAD"; 
$resultado=mysqli_query($c,$script);
if (mysqli_num_rows($resultado)!=0){//Hay puntos marcados como favoritos
    //Busco los puntos de interes, usando el ID, en la tabla correspondiente
    $lista=array();
    $contador=0;
    while ($fila = mysqli_fetch_row($resultado)){
        $contador++;
        $script2="SELECT T.ID_PTO,T.NOMBRE,T.ID_CIUDAD,C.NOMBRE,C.FOTO_INDEX, P.NOMBRE
        FROM PUNTOS_TURISTICOS T
        JOIN CIUDADES C ON T.ID_CIUDAD=C.ID_CIUDAD
        JOIN PAISES P ON C.ID_PAIS=P.ID_PAIS
        WHERE T.ID_PTO='".$fila[0]."'"; 

        $resultado2=mysqli_query($c,$script2);
        $fila2=mysqli_fetch_row($resultado2);
        $listaAux=array("idPto"=>$fila2[0],"nombrePto"=>$fila2[1],"idCiudad"=>$fila2[2],"nombreCiudad"=>$fila2[3],"imagenCiudad"=>$fila2[4],"nombrePais"=>$fila2[5]);
        array_push($lista,$listaAux);
    }
    echo json_encode(array('codigo'=>1,'contador'=>$contador, 'lista'=>$lista));
}else{
    echo json_encode(array('codigo'=>2, 'script'=>$script));
} */

?>