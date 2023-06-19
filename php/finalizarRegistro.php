<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Extraigo el id de la URL
$id=$_GET['id'];

///Busco/Extraigo el registro de la tabla USUARIOS_TEMP
$script="SELECT * FROM USUARIOS_TEMP WHERE ID_REG='".$id."'";
$resultado=mysqli_query($c,$script);

if (mysqli_num_rows($resultado)==0){
    echo '<div>
    <h2>Este usuario no tiene pendiente la verificación de su cuenta</h2>
    <h4>Estas siendo redirigido a la página de inicio...</h4>
    </div>';
    header("Refresh:3;url='../index.html'");
}else{
    //Paso el registro a la tabla USUARIOS
    $fila=mysqli_fetch_row ($resultado);//Datos de la consulta
    $script="INSERT INTO USUARIOS (EMAIL,CLAVE) VALUES ('".$fila[1]."','".$fila[3]."')";
    if ($fila[2]!=''){
        $script="INSERT INTO USUARIOS (EMAIL,FECHA_NAC,CLAVE) VALUES ('".$fila[1]."','".$fila[2]."','".$fila[3]."')";
    }
    if (mysqli_query($c,$script)){
        echo 'Inserción en tabla USUARIOS realizada correctamente';
        //Borro el registro de la tabla USUARIOS_TEMP
        $script="DELETE FROM USUARIOS_TEMP WHERE ID_REG='".$id."'";
        if (mysqli_query($c,$script)){
            echo "Borrado de la tabla registros realizada correctamente";
        }else{
            echo('ERROR: '.mysqli_error($c).'<br>');
        }
    }else{
        echo('ERROR: '.mysqli_error($c).'<br>');
    }
    header("Refresh:0;url='../inicioSesion.html'");

}
?>