<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');

include "../../LoginMySql.php";//Datos de conexion SQL
$c=new mysqli($host,$usuario,$password,$bbdd);//Loggin en phpMyAdmin
session_start();

//Guardo los datos del formulario, en variables
$id=$_POST['idUsuario'];
$clave=$_POST['nuevaClave'];

//Compruebo que el id pertenece a un usuario
$script="SELECT * FROM USUARIOS WHERE ID_USUARIO='".$id."'";
$resultado=mysqli_query($c,$script);
if (mysqli_num_rows($resultado)==0){
    echo json_encode(array('codigo'=>2,'mensaje'=>'El usuario no esta registrado.'));
}else{
    //Modifico el usuario
    //password_hash($clave, PASSWORD_DEFAULT)
    $script="UPDATE USUARIOS SET CLAVE='".password_hash($clave, PASSWORD_DEFAULT)."' WHERE ID_USUARIO='".$id."'";
    if (mysqli_query($c,$script)){
        echo json_encode(array('codigo'=>1,'mensaje'=>'La clave se ha modificado'));
    }else{
        echo json_encode(array('codigo'=>2,'mensaje'=>'Se ha producido un error; ponte un contacto con el administrador para solucionarlo.','scrip'=>$script));
    }
}
?>