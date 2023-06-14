<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Cuando se introduce un email en el apartado Recuperar contraseña, primero se comprueba que el email está en la BBD
$usuario=$_POST['usuario'];
$script="SELECT * FROM USUARIOS WHERE EMAIL='".$usuario."'";
$resultado=mysqli_query($c,$script);
if (mysqli_num_rows($resultado)!=0){//El usuario existe
    $clave=$_POST['clave'];
    $password=password_hash($clave, PASSWORD_DEFAULT);
    $script="UPDATE USUARIOS SET CLAVE='".$password."' WHERE EMAIL='".$email."'";
    if (mysqli_query($c,$script)){
        echo json_encode(array('codigo' => '1','mensaje' => 'La clave ha sido cambiada'));;
    }else{
        echo json_encode(array('codigo' => '2','mensaje' => 'Se ha producido algun fallo'));
    }
}else{
    echo json_encode(array('codigo' => '2','mensaje' => 'No hay ninguna cuenta asociada a este email'));
}
?>